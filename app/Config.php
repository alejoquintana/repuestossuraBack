<?php

namespace App;
use App\User;
use finfo;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $guarded =[];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function base64($path)
    {
        $path = public_path($path);
       $finfo = new finfo(FILEINFO_MIME_TYPE);
    $type = $finfo->file($path);
    return 'data:'.$type.';base64,'.base64_encode(file_get_contents($path));
    }
}
