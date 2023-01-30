<?php

namespace App\Http\Controllers;
use App\Category;
use App\Product;
use App\Metadata;
use App\TemporalImport;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function destroy($id) {
        $this->forgetCaches();
        $category = Category::find($id);
        if (!$category) {
            return;
        }
        
        $products = Product::where('category_id',$id)->get();
        foreach ($products as $product) {
            $product->category_id = null;
            $product->save();
        }
        $category->code = 'deleted-' . $category->code . '-(' . $category->id . ')';
        $category->name = 'deleted-' . $category->name . '-(' . $category->id . ')';
        $category->slug = $category->code . '-deleted-' . $category->id ;
        $category->save();
        $category->delete();
        return;
    }

    public function forgetCaches() {
        Cache::forget('productsNotPaused');
        Cache::forget('categories');
    }

    public function saveImage($category,$file) {
        if(!$file){return;}
        $ext = $file->getClientOriginalExtension();
        $rand = rand(1000, 9999);
        $path = $file->storeAs('/images/categories', $rand . $category->slug . '.' . $ext);
        $category->image = '/storage/' . $path;
        $category->save();
    }

    public function uploadImage(Request $request) {
        $this->forgetCaches();
        $category = Category::find($request->id);
        $file = $request->file('image');
        if(!$file || !$category){return;}
        $this->saveImage($category,$file);
        return $category;
    }

    public static function detail($slug) {   
       $category = Category::where('slug','/'.$slug)->get()->first();
        if ($category){
           $meta = new Metadata([
               'metatitle'=>$category->metatitle,
               'metadescription'=>$category->metadescription
               ]);
          
           return view('category',compact('category','meta'));
        }
        return redirect('/');
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $this->forgetCaches();
        $newCategory =  Category::create([
            'code'=>$request->code,
            'name'=>$request->name,
            'description'=>$request->description
        ]);

        if ($request->file('image')  && $request->file('image')->isValid()) {   
            $file = $request->file('image');
            $this->saveImage($newCategory,$file);
        }
       
        return $newCategory;

    }

    public function getAll() {
        return Cache::rememberForever('categories', function () {
            return Category::orderby('order')->orderBy('name')->get();
        });
    }

    public function productsNotPaused() {
        return Category::notPaused();
    }

    public function update(Request $request) {
        $this->forgetCaches();
        $field = $request->field;
        $category = Category::find($request->id);
        $category->$field = $request->value;
        $category->save();
        return $category;
    }

    public function import(Request $request) {
        foreach ($request->fields as $key => $value) {
            $$value = $key;
        };
        
        $create_temporal_imports = TemporalImport::find($request->create);
        foreach ($create_temporal_imports as $import) {
            $obj = [
                'code' => $import->$code,
                'name' => $import->$name
            ];
            if (isset($description)) {
                $obj['description'] = $import->$description;
            }
            Category::create($obj);
        }

        $update_temporal_imports = TemporalImport::find($request->update);
        foreach ($update_temporal_imports as $import) {
            $brand = Category::where('code',$import->$code)->get()->first();
            if (isset($name)) {
                $brand->name = $import->$name;
            }
            if (isset($description)) {
                $brand->description = $import->$description;
            }
            $brand->save();
        }

        $this->forgetCaches();
    }
}
