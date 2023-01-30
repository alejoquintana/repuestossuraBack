<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    //
    use SoftDeletes;

    protected $guarded =[];

    
     public function setSlugAttribute($text){
    
        // replace non letter or digits by -
        //$text = preg_replace('~[^\pL\d]+~u', '-', $text);

         str_replace("/", "-", $text);
          str_replace("%", "-", $text);
        // transliterate
       // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        $this->attributes['slug'] ='/'.$text;
        
    }

  
    public static function notPaused()
    {
       return Cache::rememberForever('productsNotPaused', function () {
            return Category::with('products.images')
                    ->with(['products' => function($q){
                        $q->where('paused',0);
                    }])
                    ->whereHas('products' , function($q){
                $q->where('paused',0)->orderBy('name');
            })->orderby('order')->orderby('name')->get();
        });
        
    }



    public function products(){
        return $this->hasMany(Product::class)
            ->orderBy('offer','desc')
            ->orderBy('first','desc')
            ->orderBy('name');
    }

    

    public function setNameAttribute($val)
    {
        $slug = '';
        if (array_key_exists('slug', $this->attributes)) {
            $slug = $this->attributes['slug'];
        }

        if(!$slug){
            $this->attributes['slug'] = '/'.str_slug($val);
        }
        $this->attributes['name'] = ucfirst($val);
    }

    public function getSlugAttribute($val)
    {
        if (!$val)
        {
           $val = '/'.str_slug($this->name);
           $this->attributes['slug'] = $val;
           $this->save();
        }
        return $val;
    }
    
      public function getNameAttribute($name)
    {
        return ucfirst($name);
    }

}

