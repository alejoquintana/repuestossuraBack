<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;


class SitemapController extends Controller
{
    //
    public function getUrlArray()
    {
        $array = [
            '/',
            '/cotizador',
            '/carrito',
            '/ubicacion',
        ] ; 

        $categories = Category::notPaused();
        
        foreach ($categories as $category) {
            if($category->slug){
                $array[] = $category->slug;
                foreach ($category->products as $p) {
                    if ($p->slug)
                    {
                        $slug = $category->slug . '/' . $p->slug;
                        $slug = str_replace('//','/',$slug);
                        $array[]=$slug;
                    }
                }
            }

        }

       

        foreach ($array as $key => $url) {
            $new = 'suspensionlujan.com/'. $url;
            $new = str_replace('//','/',$new);
            $new = 'https://'.$new;
            $array[$key] = $new;
        }

      return $array;
    }

    public function sitemap()
    {
        $urls = $this->getUrlArray();

          return response()
                ->view('sitemap', compact('urls'))->header('Content-Type', 'text/xml');
    }
}
