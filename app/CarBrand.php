<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CarModel;

class CarBrand extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['name','code'];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
