<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductImage;
use Illuminate\Support\Facades\Cache;


class ProductImageController extends Controller
{
    //

     public function forgetCaches(){
        Cache::forget('productsNotPaused');
        Cache::forget('categories');
    }

    public function reorder(Request $request)
    {
        $list = $request->list;
        if (!$list || count($list) < 2) {
            return;
        }
        foreach ($list as $item) {
            $image = ProductImage::find($item['image_id']);
            if (!$image) {
                continue;
            }
            $image->order = $item['order'];
            $image->save();
        }
    }
    

          public function downloadImage($id)
    {
       
        $img =  ProductImage::find($id);
        $name =$img->id.'-'.$img->product->name;
        
        if($img)
        {
            $path = public_path().$img->url;
            $ext =  pathinfo($path)['extension'];
            $name = $name.'.'.$ext;

            return response()->download($path,$name);
        }
        
    }        
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->product_id){return;}
        $order = ProductImage::where('product_id',$request->product_id)->count();
        $this->forgetCaches();
        $image = $request->file('image');
        $path = $image->storePublicly('/images/products');
        $path = '/storage/'.$path;
        $new = ProductImage::create([
                'product_id' => $request->product_id,
                'url' => $path,
                'order'=>$order]);

        return $new;
    }



   


   public function update(Request $request)
    {
      $this->forgetCaches();
        $field = $request->field;
        $image = ProductImage::find($request->id);
        $image->$field = $request->value;
        $image->save();

        return $request->value;
        
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->forgetCaches();
        $image = ProductImage::find($id);
        if($image){
            $image->delete();
        }
    }

}
