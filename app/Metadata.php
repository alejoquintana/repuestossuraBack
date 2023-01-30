<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
class Metadata extends Model
{
 protected $guarded=[];
 protected $table ='metadata';

 public static function findOrCreate($page)
 {
    $cacheCode = 'meta-'.$page;
    $meta = /* Cache::rememberForever($cacheCode, function() use ($page){ */
        Self::where('page',$page)->get()->first();
   /*  }); */

    if(!$meta)
    {
        $meta = Self::create(['page'=>$page]);
    }

    return $meta;
 }

 public static function getPage($page)
 {
     
     $cacheCode = 'meta-'.$page;
     return /* Cache::rememberForever($cacheCode, function() use ($page){ */
        Self::where('page',$page)->get()->first();
    /* }); */

 }
}
