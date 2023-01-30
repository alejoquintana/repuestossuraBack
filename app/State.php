<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\City;
use Illuminate\Support\Facades\Cache;

class State extends Model
{
    protected $guarded =[];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
