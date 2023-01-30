<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use View;
use App\Metadata;
use App\Category;
use App\Product;

class SinglePageController extends Controller
{
    //

    public function resolveMetadata($uri)
    {
    $metadata = Metadata::where('page',$uri)->get()->first();
    if($uri == '' || $uri == '/'){
        $metadata = Metadata::where('page','home')->get()->first();
    }
    
    if (!$metadata)
    {
        $metadata = new Metadata();
        $pos = strpos($uri,'/'); 

        if ($pos > 0)
        {
            /* Categoria/producto */
            $arr = str_split($uri,$pos);
            $arr[0] = str_replace('/','',$arr[0]);
            $arr[1] = str_replace('/','',$arr[1]);
            
            
            
            $product = Product::where('slug',$arr[1])->get()->first();
            if (!$product){
               $product = Product::where('slug','/'.$arr[1])->get()->first();
            }

            if ($product){
                

                /* metatitle */
                if($product->metatitle){
                    $metadata->metatitle = $product->metatitle;
                }else{
                    $metadata->metatitle = $product->name.' por mayor';
                }

                /* metadescription */
                if ($product->metadescription)
                {
                    $metadata->metadescription = $product->metadescription;
                }
                else if ($product->description)
                {
                    $metadata->metadescription = $product->description;
                }else{
                    $metadata->metadescription = $metadata->metatitle;
                }
            }
        }
        else {
            /* categoria */
            
            $category = Category::where('slug',$uri)->get()->first();
            if(!$category){
                $category = Category::where('slug','/'.$uri)->get()->first();
            }

            if($category){
                /* metatitle */
                if ($category->metatitle)
                {
                    $metadata->metatitle=$category->metatitle;
                } else {
                    $metadata->metatitle = $category->name.' por mayor';
                }
    
                /* metadescription */
                if ($category->metadescription)
                {
                    $metadata->metadescription = $category->metadescription;
                }else if ($category->description)
                {
                    $metadata->metadescription = $category->description;
                }else{
                    $metadata->metadescription = $metadata->metatitle;
                }
            }
        }
    }
       /*  dd($metadata); */
        return $metadata;
    }

    
    
    public function index(request $request) {
        
   /*  $metadata = $this->resolveMetadata( $request->path() );  */
   
    /* return View::make('myapp',compact('metadata')); */
    
        return "this laravel app works as an API for other web apps. Do not try to access it directly from a browser.";
}


}
