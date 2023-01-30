<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

use App\ProductImage;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductUpdateLog extends Model
{
    //
    protected $guarded =[];
    protected $table = 'products_update_log';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

        
}
