<?php

use App\Http\Controllers\BookerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventCustomerController;
use App\Http\Controllers\EventManagerController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\PositionsManagerController;
use App\Http\Controllers\RestaurantsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCustomerController;
use App\Http\Controllers\UserManagerController;
use App\Http\Controllers\ValidateController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


//
//Route::view('dashboard', 'dashboard')
//    ->middleware(['auth', 'verified'])
//    ->name('dashboard');
//
//Route::middleware(['auth'])->group(function () {
//    Route::redirect('settings', 'settings/profile');
//
//    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
//    Volt::route('settings/password', 'settings.password')->name('settings.password');
//    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
//});

//require __DIR__.'/auth.php';
Auth::routes();

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/policy', [MainController::class, 'policy'])->name('policy');

//Route::get('/logout', 'Auth\LoginController@logout');

//---------------------admin users--------------------------------------------------
Route::get('/users', [UserController::class,'index']);
Route::get("/users/{user}/edit", [UserController::class,'input']);
Route::put("/users/save", [UserController::class,'save']);;
Route::get("/users/{user}/delete", [UserController::class,'destroy']);
Route::get('/users/{user}/chgpwd', [UserController::class,'changepwd']);
Route::put("/users", [UserController::class,'update']);;
//-----------------------------------↓----------------------------------------
Route::get("/positions", [PositionsController::class, 'index']);
Route::get("/positions/create", [PositionsController::class,'input'])->name("positions.create");
Route::post("/positions", [PositionsController::class,'save']);
Route::get("/positions/{position}/edit", [PositionsController::class,'input']);
Route::put("/positions", [PositionsController::class,'save']);
Route::get("/positions/{position}/delete", [PositionsController::class,'destroy']);
//-------------------restaurants-----↑-----------------------------------------
Route::get("/restaurants", [RestaurantsController::class, 'index']);
Route::get("/restaurants/create", [RestaurantsController::class, 'input'])->name("restaurants.create");
Route::post("/restaurants", [RestaurantsController::class, 'save']);
Route::get("/restaurants/{restaurant}/edit", [RestaurantsController::class, 'input']);
Route::put("/restaurants", [RestaurantsController::class, 'save']);
Route::get("/restaurants/{restaurant}/delete", [RestaurantsController::class, 'destroy']);
//-----------------------manager------------------------------------------------
Route::get('/usersmanager', [UserManagerController::class, 'index']);
Route::get("/usersmanager/{user}/edit", [UserManagerController::class, 'input']);
Route::put("/usersmanager", [UserManagerController::class, 'save']);
Route::get("/usersmanager/{user}/delete", [UserManagerController::class, 'destroy']);
Route::get('/usersmanager/{user}/chgpwd', [UserManagerController::class, 'changepwd']);
Route::put("/usersmanager", [UserManagerController::class, 'update']);
Route::middleware('can:manipulate,App\Models\EventManager')->group(function (){
    //-----------------------manager(events)-----------------------------------------
    Route::get('/events', [EventManagerController::class, 'index'])->name('EventManagerController.index');
    Route::get('/events/addeventurl',[EventManagerController::class, 'display'])->name('EventManagerController.store');
    Route::post('/events/addeventurl/store',[EventManagerController::class, 'store'])->name('addeventmanager.store');
    Route::get("/events/{id}/edit", [EventManagerController::class, 'input'])->name('EventManagerController.input');
    Route::put("/events", [EventManagerController::class, 'save']);
    Route::get('/events/todaywork', [EventManagerController::class, 'currentwork']);
});
Route::middleware('can:manipulate,App\Models\EventManager')->group(function (){
//-----------------------manager(history)----------------------------------------
    Route::get('/events/mview/{url}',[EventManagerController::class,'views'])->name('mview.views');
    Route::get('/events/mviewurl',[EventManagerController::class,'show'])->name('displaym.edit');
    Route::get('/events/mviewurl/{id}/edit',[EventManagerController::class,'edit']);
    Route::get('/events/mviewurl/{id}/editstatus',[EventManagerController::class,'editstatus']);
    Route::put("/events/mviewurl", [EventManagerController::class,'update']);
});

//-----------------------manager(positions)--------------------------------------
Route::get("/positionsmanager", [PositionsManagerController::class, 'index']);
Route::get("/positionsmanager/create/{id}", [PositionsManagerController::class, 'inputadd'])->name("positionsmanager.create");
Route::post("/positionsmanager", [PositionsManagerController::class, 'save']);
Route::get("/positionsmanager/{position}/edit", [PositionsManagerController::class, 'input']);
Route::put("/positionsmanager", [PositionsManagerController::class, 'save']);
Route::get("/positionsmanager/{position}/{rest_id}/delete", [PositionsManagerController::class, 'destroy']);

//-------------------------admin events(смены)-----------------------------------------
Route::resource('/events/eventpage', EventController::class);
Route::get('/events/editeventurl',[EventController::class,'show']);
Route::post('/events/editeventurl/update/{id}',[EventController::class,'update'])->name('editform_update');
Route::get('/events/deleteeventurl/{id}',[EventController::class,'destroy']);
//-------------------------admin export events-----------------------------------------
Route::get('/events/export', [EventController::class,'export']); // export route
Route::post('/events/export',[EventController::class,'downloads']);
//-------------------------admin logs--------------------------------------------------
Route::get('/logs', [LogsController::class, 'index']);
//-------------------------customer------------------------------------------------
Route::get('/userscustomer', [UserCustomerController::class, 'index'])->name('userscustomer.index');
Route::put("/userscustomer", [UserCustomerController::class, 'save'])->name('userscustomer.save');
Route::put("/userscustomer/change_pwd", [UserCustomerController::class, 'update'])->name('userscustomer.update');

Route::middleware('can:manipulate,App\Models\EventCustomer')->group(function (){
    //-----------------------customer(events)-----------------------------------------
    Route::get('/eventscustomer', [EventCustomerController::class, 'index']);
    Route::get('/eventscustomer/addeventurl',[EventCustomerController::class, 'display'])->name('EventCustomerController.store');
    Route::post('/eventscustomer/addeventurl/store',[EventCustomerController::class, 'store'])->name('addevent.store');
    Route::get("/eventscustomer/{id}/edit", [EventCustomerController::class, 'input']);
    Route::put("/eventscustomer", [EventCustomerController::class, 'save']);
//-----------------------customer(history)----------------------------------------
    Route::get('/eventscustomer/mview',[EventCustomerController::class,'views'])->name('cview.views');
    Route::post('/eventscustomer/mviewurl',[EventCustomerController::class,'show']);
//-------------------------customer export events-----------------------------------------
    Route::get('/eventscustomer/mview/load',[EventCustomerController::class,'dloads']);
    Route::post('/eventscustomer/mviewurl/filterload',[EventCustomerController::class,'filterdloads']);

});

//-------------------------booker export events-------------------------------------------
Route::get('/booker', [BookerController::class,'index']); // export route
Route::post('/booker/export',[BookerController::class,'downloads']);


