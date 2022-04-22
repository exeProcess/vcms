<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    //
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'status' => 'required|string',
            'department' => 'required|string',
            'role' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }
        DB::connection("admin")->table("staff")->insert($request->all());
        return response()->json([
            "message" => "activity inserted"
        ]);
    }
    public function fetchAllStaffs(){
        $staffs = DB::connection("admin")->table("staff")->get();
        return view('admin.staff', compact('staffs'));
    }
}
