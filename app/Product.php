<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\CarModel;
use Illuminate\Support\Facades\Auth;
use App\ProductImage;
use App\ProductCarModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    //
    use SoftDeletes;
    protected $guarded =[];

    public function setSlugAttribute($text){
        // $text = preg_replace('~[^\pL\d]+~u', '-', $text); //# replace non letter or digits by -
        str_replace("/", "-", $text);
        str_replace("%", "-", $text);
        // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text); //# transliterate
        $text = preg_replace('~[^-\w]+~', '', $text); //# remove unwanted characters
        $text = trim($text, '-'); //# trim
        $text = preg_replace('~-+~', '-', $text); //# remove duplicate -
        $text = strtolower($text); //# lowercase
        if (empty($text)) {
            return 'n-a';
        }
        $this->attributes['slug'] ='/'.$text;
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public static function boot() {
         parent::boot();

          self::creating(function($product){
            $product->attributes['slug'] = '/'.str_slug($product->name); 
          });
    }

    public function getPriceAttribute($val)
    {
        return $val/100;
    }

    public function setPriceAttribute($val)
    {
        $this->attributes['price']= $val*100;
    }
    public function getPckPriceAttribute($val)
    {
        return $val/100;
    }



    public function getSlugAttribute($val)
    {
        if (!$val)
        {
            $val =  '/'.str_slug($this->name);
            $this->attributes['slug'] = $val;
            $this->save();
        }
        return $val;
    }

    public function getNameAttribute($name)
    {
        return ucfirst($name);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function car_models(){
        /* return $this->belongsToMany(CarModel::class,
            'product_car_model',
            'product_id',
            'car_model_id'
        ); */
        return $this->belongsToMany(CarModel::class,
            'product_car_model',
            'product_id',
            'car_model_id'
        )->withPivot('id','comments')
            ->withTimestamps();
    }
        
}
