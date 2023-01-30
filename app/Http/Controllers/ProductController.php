<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\CarModel;
use App\CarBrand;
use App\Metadata;
use App\ProductUpdateLog;
use App\ProductImage;
use App\TemporalImport;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\SearchHistory;

class ProductController extends Controller {

    public function saveImage($product, $file) {
        if ( !$file) {
            return;
        }

        if( !$product || !$product->id) {
            return;
        }

        $ext=$file->getClientOriginalExtension();
        $rand=rand(1000, 9999);
        $path=$file->storeAs('/images/products', $rand . $product->id . '.'. $ext);

        ProductImage::create([ 'product_id'=> $product->id,
            'url'=> $path]);
    }

    public function forgetCaches() {
        Cache::forget('productsNotPaused');
        Cache::forget('categories');
    }

    public function getPaginated(request $request) {

        $query=Product::with('category')->with('images')->with('car_models');

        if($request->category_id) {
            $query=$query->where('category_id', $request->category_id);
        }

        $searchTerm=$request->searchTerm;
        $len=strlen($searchTerm);

        if($len > 1) {
            $searchTerm='%'.strtoupper($searchTerm).'%';
            $query=$query->whereRaw("( UPPER(name) LIKE '{$searchTerm}' OR UPPER(code) LIKE '{$searchTerm}' )");
        }

        $query=$query->orderBy('category_id')->orderBy('name')->paginate(20);

        return $query;

    }

    public function getAll() {
        return Product::with('category')->with('images')->with('car_models')->get();
    }

    public function getOffers() {
        return Product::where('offer', 1) ->with('category') ->with('images')->get();
    }

    public function getNews() {
        return Product::where('new', 1) ->with('category') ->with('images')->get();
    }

    public function getByCode() {
        return Product::where('new', 1) ->with('category') ->with('images')->get();
    }

    public function getCategoryProducts($category_id) {
        return Product::where('category_id', $category_id) ->with('category') ->with('images')->get();
    }
    
    public function getFoundProducts(Request $request) {
        $products = Product::with('car_models')->with('images');
        $res = [];

        $brand_code = str_replace("-", " ", $request->marca);
        $model_code = str_replace("-", " ", $request->modelo);
        $category_code = str_replace("-", " ", $request->rubro);
        
        if ($category_code) {
            $category = Category::where('code', $category_code)->get()->first();
            $products = $products->where('category_id',$category->id)->get();
        }
        else{
            $products = $products->get();
        }

        if ($model_code) {
            $model = CarModel::where('code', $model_code)->get()->first();
            foreach ($products as $product) {
                $push = false;
                foreach ($product->car_models as $car_model) {
                    if ($car_model->id == $model->id) {
                        $push = true;
                    }
                }
                if ($push) {
                    array_push($res,$product);
                }
            }
        }
        else if ($brand_code && !$model_code) {
            $brand = CarBrand::where('code', $brand_code)->get()->first();
            foreach ($products as $product) {
                $push = false;
                foreach ($product->car_models as $car_model) {
                    if ($car_model->car_brand_id == $brand->id) {
                        $push = true;
                    }
                }
                if ($push) {
                    array_push($res,$product);
                }
            }
        }
        else {
            $res = $products;
        }
        return $res;
    }

    public function getMostSold() {
        $products=Product::all();
        $maxdate=Carbon::now()->subDays(16);

        $most_sold=DB::table('order_items') ->select('product_id', DB::raw('COUNT(product_id) as count')) ->where('created_at', '>=', $maxdate) ->groupBy('product_id') ->orderBy('count', 'DESC') ->limit(20) ->get();

        $res=[];

        foreach ($most_sold as $p) {
            $full_prod=Product::where('id', $p->product_id)->where('paused', false) ->with('category') ->with('images')->get()->first();

            if ($full_prod) {
                $res[]=$full_prod;
            }
        }

        return $res;

    }

    public function searchResults(Request $request) {

        // user can provide double space by accident, or on purpose:
        $search=$request->input('search');

        /* Guardo en historial de busquedas */
        $user=Auth::user();

        if ( !$user || $user->role_id > 2) {
            SearchHistory::create([ 'term'=>$search]);
        }

        // so with explode you get this:
        $array=explode(' ', $search);

        $products=Product::where('paused', 0)->where(function ($q) use ($array) {
                foreach ($array as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            }

        )->pluck('id')->toArray();
        ;


        return view('search-results', compact('products', 'search'));


    }

    public static function detail($categorySlug, $productSlug) {
        $slug='/'.$productSlug;
        $product=Product::where('slug', $slug)->get()->first();

        if($product) {
            $meta=new Metadata();
            $meta->metatitle=$product->name;
            $meta->metadescription=$product->description;
            return view('product', compact('product', 'meta'));
        }

        return redirect('/');
    }

    public function getProductsUpdatesLog() {
        return ProductUpdateLog::all();
    }

    public function getProductsWithNoPhotos() {
        $res=[];
        $products=Product::all();

        foreach ($products as $product) {
            $image=ProductImage::where('product_id', $product->id) ->get()->first();

            if ( !$image) {
                $res[]=$product;
            }
        }

        return $res;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $this->forgetCaches();

        $prod=Product::create($request->only([
            'code',
            'name',
            'price',
            'category_id',
            'description'
        ]));

        $slugcopys=Product::where('slug', $prod->slug)->where('category_id', $prod->category_id)->count();

        if($slugcopys > 1) {
            $prod->slug=$prod->slug.'_'.$prod->id;
            $prod->save();
        }

        return $prod;
    }

    public function update(Request $request) {

        $this->forgetCaches();

        $field=$request->field;
        $product=Product::find($request->id);

        $oldvalue=$product->$field;

        $product->$field=$request->value;
        $product->save();

        $user=auth()->user();

        ProductUpdateLog::create([ 'product_id'=>$request->id,
                'user'=>$user->name,
                'field'=>$request->field,
                'old_value'=>$oldvalue,
                'new_value'=> $request->value]);
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->forgetCaches();
        $product=Product::find($id);
        if( !$product) {
            return;
        }
        $product->code='deleted-'.$product->code.'-('.$product->id.')';
        $product->save();
        $product->delete();
        return;
    }

    public function import(Request $request) {
        $not_saved = []; //se guardan los datos para retornar y mostrar que no se guardo
        $updated= 0;
        $created=0;
        $fields = $request->fields;
        $requireds = [
            'category' => true,
            'code' => true,
            'name' => true,
            'price' => true,
            'description' => false,
            'stock' => true
        ];

        $create = true;//var para saber si estan todos los campos para crear
        foreach ($requireds as $key => $required) {
            if($required && !isset($fields[$key])){
                $create = false;
            }
        }

        $temporal_imports = TemporalImport::all();
        $temporal_imports->shift();
        foreach ($temporal_imports as $import) {
            $product = Product::where('code',trim($import[$fields['code']]))->get()->first();
            
            if (!$create && !$product) {
                array_push($not_saved,['code'=>$import[$fields['code']],'text'=>'No se pudo crear ni actualizar']);
                continue;
            }
            
            if ( isset($fields['category']) && $import[$fields['category']] ) {
                $category = Category::where('code',trim($import[$fields['category']]))->get()->first();
                if (!$category) {
                    array_push($not_saved,['code' => $import[$fields['code']],'text'=>'Rubro no encontrado']);
                    continue;
                }
                $createFields=['category_id' => $category->id];
            }
            
            if ( isset($fields['stock']) && $import[$fields['stock']]) {
                $value = strtoupper(trim($import[$fields['stock']]));
                if ($value != 'S' && $value != 'N' && $value != 'C') {
                    array_push($not_saved,['code' => $import[$fields['code']],'text'=>'Dato erroneo en disponibilidad']);
                    continue;
                }
                $import[$fields['stock']] = $value;
            }
            //return $createFields;
            
            if ($product) {
                foreach ($fields as $key => $value) {
                    if($key == 'code') continue;
                    else if($key == 'category') {
                        $product->category_id = $category->id;
                        continue;
                    }
                    else {
                        $product->$key = trim($import[$value]);
                    }
                }
                $product->save();
                $updated = $updated + 1;
            }

            if ($create && !$product) {
                foreach ($fields as $key => $value) {
                    if($key == 'category') continue;
                    if (!$import[$value]) {
                        array_push($not_saved,['code' => $import[$fields['code']],'text'=>'create pero nada en '.$key]);
                        continue;
                    }
                    $createFields[$key] = trim($import[$value]);
                };
                $product = Product::create($createFields);
                $created = $created +1 ;
            }
            //'code' => trim($import->$code),
            //'name' => trim($import->$name),
            //'price' => trim($import->$price),
            //'description' => trim($import->$description),
            //'stock' => trim($import->$stock),
            //'category_id' => $fullCategory->id,
        }
        return ['notSaved'=>$not_saved,'updated'=>$updated,'created'=>$created];
    }
}