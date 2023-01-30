<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\State;
use App\Order;

class City extends Model
{
    //
     protected $guarded =[];
     protected $table = 'cities';

     public function state()
     {
         return $this->belongsTo(State::class);
     }

     public function orders()
     {
         return $this->hasMany(Order::class);
     }
}
