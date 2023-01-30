<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CarModel;
use App\Product;
use App\CarBrand;
use App\TemporalImport;

class CarModelController extends Controller
{
    //
    public function get()
    {
        return CarModel::all();
    }

    public function create(Request $request)
    {
        $car_model = CarModel::create($request->all());
        return $car_model;
    }

    public function update(Request $request)
    {
        $model = CarModel::find($request->id);
        if(!$model){return;}

        $field = $request->field;
        $model->$field = $request->value;
        $model->save();
        return;
    }

    public function destroy($id)
    {
        return CarModel::destroy($id); 
    }

    public function import(Request $request) {
        foreach ($request->fields as $key => $value) {
            $$value = $key;
        };
        
        $create_temporal_imports = TemporalImport::find($request->create);
        foreach ($create_temporal_imports as $import) {
            $brand = CarBrand::where('code',$import->$car_brand_code)->get()->first();
            CarModel::create([
                'code' => $import->$code,
                'name' => $import->$name,
                'car_brand_id' => $brand->id
            ]);
        }

        $update_temporal_imports = TemporalImport::find($request->update);
        foreach ($update_temporal_imports as $import) {
            $model = CarModel::where('code',$import->$code)->get()->first();
            $model->name = $import->$name;
            $model->save();
        }
    }
}
