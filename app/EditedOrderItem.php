<?php

namespace App;
use App\Order;

use Illuminate\Database\Eloquent\Model;

class EditedOrderItem extends Model
{

    protected $guarded =[];
    protected $table = 'edited_order_items';

    public function getPriceAttribute($val)
    {
        return $val/100;
    }

    public function setPriceAttribute($val)
    {
        $this->attributes['price']= $val*100;
    }

        public function order(){
            return $this->belongsTo(Order::class);
        }

       

         public function product()
        {
            return $this->belongsTo(Product::class);
        }
}
