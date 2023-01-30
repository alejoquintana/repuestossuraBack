<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\user;

class Role extends Model
{
    //
    public function users(){
        return $this->hasMany(User::class);
    }
}
