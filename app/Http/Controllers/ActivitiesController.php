<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class ActivitiesController extends Controller
{
    //
    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'author' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], 400);
        }
        DB::connection("production")->table("activities")->insert($request->all());
        return response()->json([
            "message" => "activity inserted"
        ]);
    }

    public function fetchAllActivitiesAdmin(){
        $activities = DB::connection("production")->table("activities")->get();
        return view('admin.activity', compact('activities'));
    }

    public function fetchAllActivitiesProduction(){
        $activities = DB::connection("production")->table("activities")->get();
        return view('production.activities', compact('activities'));
    }

    public function fetchActivity($id){
        $query = "SELECT * FROM activities WHERE :id";
        $activity = DB::connection("production")->table("activities")->where('id',$id)->get();
        return response()->json([
            "activity" => $activity
        ]);
    }

    public function updateActivity(Request $request){
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
        $oldActivity = DB::connection("production")->table("activities")->find($request->id);
        $oldActivity->project_name = $request->project_name;
        $oldActivity->description = $request->description;
        $oldActivity->status = $request->status;
        $oldActivity->budget = $request->budget;
        $oldActivity->amount_spent = $request->amount_spent;
        $oldActivity->duration = $request->duration;

        $save = $oldActivity->save();
        if($save){
            return response()->json([
                "message" => "data updated"
            ]);
        }
    }

}
