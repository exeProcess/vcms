<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    //
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'location' => 'required|string',
            'size' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }
        DB::connection("admin")->table("sites")->insert($request->all());
        return response()->json([
            "message" => "activity inserted"
        ]);
    }

    public function fetchAllSites(){
        $sites = DB::connection("admin")->table("sites")->get();
        return view('admin.site', compact('sites'));
    }
}
