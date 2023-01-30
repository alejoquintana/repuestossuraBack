<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Product;
use App\CarModel;

class ProductCarModel extends Pivot
{
    //
    protected $table = 'product_car_model';
    protected $fillable = ['product_id','car_model_id','comments'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function model() {
        return $this->belongsTo(CarModel::class);
    }
}
