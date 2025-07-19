<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurants;
use App\Http\Requests\RestaurantsRequest;
use App\Positions;
use DB;

class RestaurantsController extends Controller
{
  public function __construct() {
		parent::__construct();
		$this->middleware("can:manipulate,App\Restaurants");
	}
  public function index() {
    $cats = Restaurants::where('session_id', '=', auth()->user()->id)->orderBy("id", "asc")->orderBy("name")->get();
    return view("restaurants.index", ["cats" => $cats]);
  }

  public function input(Restaurants $restaurant) {
    return view("restaurants.input", ["cat" => $restaurant]);
  }

  public function save(RestaurantsRequest $request) {
    if ($request->has("id")) {
      $cat = Restaurants::findOrFail($request->id);
      $cat->fill($request->all())->save();
      $s = " обновлен";
    } else {
      $cat = Restaurants::create($request->all());
      $s = " создан"; 
	   //-------------------------insert positions-----------------------------------------
		  $slug = 'menedzher'.time()*1000;
		  DB::table('positions')->insert([ 'name'=>'менеджер','price_shifts'=>'0','price_hour'=>'0','price_month'=>'0','description'=>'','slug'=>$slug,'users_id' => auth()->user()->id,'restaurants_id' => $cat->id ]);
	  //-----------------------------------------------------------------------------
    }
    return redirect()->action("RestaurantsController@index")
    ->with("status", "Ресторан " . $cat->name . $s);
  }

  public function destroy(Restaurants $restaurant) {
    $name = $restaurant->name;
    $restaurant->delete();
    return redirect()->action("RestaurantsController@index")
    ->with("status", "Ресторан " . $name . " удален");
  }
}
