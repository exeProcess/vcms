<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StorageController extends Controller
{
    //

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'storage_name' => 'required|string',
            'storage_capacity' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }
        DB::connection("production")->table("storages")->insert($request->all());
        return response()->json([
            "message" => "activity inserted"
        ]);
    }
    public function fetchAllStorageProduction(){
        $storages = DB::connection("production")->table("storages")->get();
        return view('production.storage', compact('storages'));
    }
    public function fetchAllStorageAdmin(){
        $storages = DB::connection("production")->table("storages")->get();
        return view('admin.storage', compact('storages'));
    }

    public function fetchstorages($id){
        $storages = DB::connection("production")->table("storages")->where('id',$id)->get();
        return response()->json([
            "activity" => $activity
        ]);
    }
    public function updatestorages(Request $request){
        $validator = Validator::make($request->all(), [
            'author' => 'required|string',
            'body' => 'required|string',
            'title' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }
        $storages = DB::connection("production")->table("storages")->find($request->id);
        $storages->project_name = $request->project_name;
        $storages->description = $request->description;
        $storages->status = $request->status;
        $storages->budget = $request->budget;
        $storages->amount_spent = $request->amount_spent;
        $storages->duration = $request->duration;

        $save = $storages->save();
        if($save){
            return response()->json([
                "message" => "data updated"
            ]);
        }
    }
}
