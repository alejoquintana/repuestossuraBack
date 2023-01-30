<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductCarModel;
use App\CarModel;
use App\Product;
use App\TemporalImport;

class ProductCarModelController extends Controller
{
    //
    public function getAll() {
        return ProductCarModel::all();
    }

    public function get($id) {
        return ProductCarModel::find($id);
    }

    public function getById($type,$id) {
        if ($type == "product") {
            $product = Product::where('id',$id)->with('car_models')->get()->first();
            return $product->car_models;
        }
        if ($type == "car-models") {
            $carModel =  CarModel::where('id',$id)->with('products')->get()->first();
            return $carModel->products;
        }
    }
    
    public function create(Request $request) {
        $relation = ProductCarModel::create($request->all());
        $product = Product::where('id',$request->product_id)->with('car_models')->get()->first();
        $res = null;
        foreach ($product->car_models as $model) {
            /* return [
                "model"=>$model,
                "relation"=>$relation
            ]; */
            if( $model->id == $request->car_model_id &&
                $model->pivot->car_model_id == $relation->car_model_id &&
                $model->pivot->product_id == $relation->product_id 
            ){
                $res = $model;
            }
        }
        /* { "id": 2, "code": "1MOL2", "name": "1MOL2", "car_brand_id": 1, "created_at": "2022-11-25 11:29:51", "updated_at": "2022-11-25 11:29:51", "deleted_at": null, "pivot": { "product_id": 2, "car_model_id": 2, "id": 2, "comments": null, "created_at": "2022-11-25 12:35:37", "updated_at": "2022-11-25 12:35:37" } } */
        return $res;//CarModel::where('id',$request->car_model_id)->get()->first();
    }
    
    public function update(Request $request) {
        $relation = ProductCarModel::find($request->id);
        $field = $request->field;
        $relation->$field = $request->value;
        $relation->save();
        return $relation;
    }

    public function destroy($id) {
        return ProductCarModel::destroy($id);
    }
    //! public function destroy($product_id,$car_model_id) {
    //!     $relation = ProductCarModel::where('product_id', $product_id)->where('car_model_id',$car_model_id)->get()->first();
    //!     return $relation->delete();
    //! }
    
    public function import(Request $request) {
        $not_saved = [];

        foreach ($request->fields as $key => $value) {
            $$value = $key;
        };
        //! $code_prod - $code_model - $comments
        
        $temporal_imports = TemporalImport::all();
        $temporal_imports->shift();

        foreach ($temporal_imports as $import) {

            $repeated = false;

            $product_code = trim($import->$code_prod);
            $product = Product::where('code',$product_code)->with('car_models')->get()->first();
            
            $model_code = trim($import->$code_model);
            $model = CarModel::where('code',$model_code)->get()->first();
            
            if($product && $model){
                foreach ($product->car_models as $m) {
                    if ($m->code == $model->code) {
                        $repeated = true;
                    }
                }
                $data = [
                    'product_id' => $product->id,
                    'car_model_id' => $model->id
                ];
                if (isset($comments)) {
                    $data['comments'] = $import->$comments;
                }
                
                if (!$repeated) {
                    ProductCarModel::create($data);
                }
                else {
                    $data['text'] = "Repetido / ya existe";
                    array_push($not_saved, $data);
                }
            }
            else {
                if(!$product){
                    $data['text'] = "NO SE ENCONTRO EL PRODUCTO";
                }else if (!$model){
                    $data['text'] = "NO SE ENCONTRO EL MODELO DE AUTO";
                }
                array_push($not_saved, $data);
            }
        }
        return $not_saved;
    }

}
