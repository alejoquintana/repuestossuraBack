<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserSocial extends Model
{
    //
    protected $guarded = [];
    protected $table = 'user_social';

    public function user(){
        return $this->belongsTo(User::class);
    }
}
