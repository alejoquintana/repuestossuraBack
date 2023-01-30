<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CarBrand;
use App\Product;

class CarModel extends Model
{
    //

    use SoftDeletes;

    protected $fillable = ['name','code','car_brand_id'];

    public function car_brand() {
        return $this->belongsTo(CarBrand::class);
    }

    public function products(){
        return $this->belongsToMany(
            Product::class,
            'product_car_model',
            'car_model_id',
            'product_id'
        );//->using(ProductCarModel::class);
        /* return $this->hasMany(Product::class)
            ->orderBy('offer','desc')
            ->orderBy('first','desc')
            ->orderBy('name'); */
    }
}
