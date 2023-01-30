<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appimage;

class AppimageController extends Controller
{
    //
    public function getAll(){
        return AppImage::all();
    }

    public function getByName($name)
    {
        return Appimage::where('name',$name)->get();
    }

    public function create(request $request){
        
        $target = $request->target_url || '/' ;

        $appImage =  AppImage::create([
            'code'=>$request->code,
            'name'=>$request->name,
            'target_url'=>$target
        ]);
        
        if($request->hasFile('image')){
            $file = $request->file('image');
            $path = $file->storePublicly('/images/appimages');
            $path = '/storage/' . $path;
            $appImage->url = $path ;
            $appImage->save();
        }
        
        return $appImage ; 
    }
    public function createBannerHome(request $request){
        $image = $request->file('image');
        $path = $image->storePublicly('/images/appimages');
        $path = '/storage/'.$path;
        
        return AppImage::create([
            'code'=>$request->code,
            'name'=>$request->name,
            'alt'=>$request->name,
            'target_url'=>$request->target_url,
            'url'=>$path,
        ]);
    }
    
    public function upload(Request $request)
    {
        $image = $request->file('image');
        $appimage = Appimage::find($request->id);
        if(!$image || !$appimage){return;}
        $path = $image->storePublicly('/images/appimages');
        $path = '/storage/'.$path;
        $appimage->url = $path;
        $appimage->save();
    }

    public function update(request $request ){
        $appimage = AppImage::find($request->id);
        if(!$appimage){return;}
        $field = $request->field;
        $appimage->$field = $request->value;
        $appimage->save();
    }

    public function destroy($id ){
        $appimage = AppImage::find($id);
        if($appimage && $appimage->url){
            unlink(public_path().$appimage->url);
        }
        AppImage::destroy($id);
    }
}
