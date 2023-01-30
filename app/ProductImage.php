<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;


class ProductImage extends Model
{
    //
    protected $guarded =[];
    protected $table ="product_images";

    public function miniatures()
    {
        return $this->hasMany(Miniature::class,'product_id','id');
    }

    public function getMiniature($width)
    {
        return Miniature::findOrCreate($this->id,$width);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
