<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\OrderItem;
use App\User;
use App\City;
use App\RetiroOption;
use Carbon\Carbon;

class Order extends Model
{
    protected $guarded =[];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class)->orderBy('code');
    }
    public function editedOrderItems()
    {
        return $this->hasMany(EditedOrderItem::class)->orderBy('code');
    }

    public function retiro(){
        return $this->belongsTo(RetiroOption::class);
    }

      public function getTotalAttribute($val)
    {
        return $val/100;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function setTotalAttribute($val)
    {
        $this->attributes['total']= $val*100;
    }
  
     public function setViewedAttribute($val)
    {
        $date = Carbon::now();
        $this->attributes['viewed_at'] =$date;
        $this->attributes['viewed'] = $val;
    }
   

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
