<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\StoredProductController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\SiteController;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::domain('{tenant}.localhost')->middleware('tenant')->group(function (){
    Route::get("/", function($tenant){
       
           $tenant_users = DB::connection($tenant)->table('users')->get();
            if($tenant_users->count() == 0){
                return view($tenant.".register");
            }else{
                return view($tenant.".login");
            } 
    });
    Route::get("/admin/activity", function($tenant){
        return view($tenant.".activity");
    });
});
Route::get("/activity/{id}", [ActivitiesController::class, 'fetchActivity']);
Route::post('/activity/post', [ActivitiesController::class, 'create']);
Route::patch('/update', [ActivitiesController::class, 'updateActivity']);
Route::get('/admin/activities', [ActivitiesController::class, 'fetchAllActivitiesAdmin']);
Route::get("/production/storage", [StorageController::class, 'fetchAllStorageProduction']);
Route::get("/admin/storage", [StorageController::class, 'fetchAllStorageAdmin']);
Route::post('/storage/post', [StorageController::class, 'create']);
Route::post('/tostorage', [StoredProductController::class, 'create']);
Route::post('/tostaff', [StaffController::class, 'create']);
Route::post('/tosite', [SiteController::class, 'create']);



Route::get("/admin/staffs", [StaffController::class, 'fetchAllStaffs']);


Route::get("/admin/sites", [SiteController::class, 'fetchAllSites']);
Route::get("/shop/e-commerce", function(){
    return view("shop.commerce");
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $tenant = explode('.', Request::getHost());
        return view($tenant[0].'.dashboard');
    })->name('dashboard');

});
