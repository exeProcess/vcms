<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StoredProductController extends Controller
{
    //
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'quantity' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }
        DB::connection("production")->table("stored_products")->insert($request->all());
        return response()->json([
            "status" => true,
            "message" => "product stored"
        ]);
    }

    public function fetchAllStoredProduct(){
        $storedProduct = DB::connection("production")->table("stored_product")->get();
        return view('production.storage', compact('storedProduct'));
    }
}
