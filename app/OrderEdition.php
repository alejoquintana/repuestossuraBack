<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Order;
use app\EditedOrderItem;

class OrderEdition extends Model
{
    //
    protected $guarded = [];

    public function items(){
        return $this->hasMany(EditedOrderItem::class , 'edition_id' , 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
