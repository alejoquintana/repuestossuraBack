<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarBrand;
use App\TemporalImport;

class CarBrandController extends Controller
{
    //
    public function get()
    {
        return CarBrand::all();
    }

    public function create(Request $request)
    {
        $car_brand = CarBrand::create($request->all());
        return $car_brand;
    }

    public function update(Request $request)
    {
        $brand = CarBrand::find($request->id);
        if(!$brand){return;}

        $field = $request->field;
        $brand->$field = $request->value;
        $brand->save();
        return;
    }

    public function destroy($id)
    {
        return CarBrand::destroy($id); 
    }

    public function import(Request $request) {
        foreach ($request->fields as $key => $value) {
            $$value = $key;
        };
        
        $create_temporal_imports = TemporalImport::find($request->create);
        foreach ($create_temporal_imports as $import) {
            CarBrand::create([
                'code' => $import->$code,
                'name' => $import->$name
            ]);
        }

        $update_temporal_imports = TemporalImport::find($request->update);
        foreach ($update_temporal_imports as $import) {
            $brand = CarBrand::where('code',$import->$code)->get()->first();
            $brand->name = $import->$name;
            $brand->save();
        }
    }
}
