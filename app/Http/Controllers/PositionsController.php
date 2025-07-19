<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Positions;
use App\User;
use DB;
use App\Restaurants;
use App\Http\Requests\PositionsRequest;

class PositionsController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware("can:manipulate,App\Positions");
  }
  //-----------------------------view--------------------
  public function index() {
    $subcats = Positions::select("positions.*", "users.fio as usrname", "restaurants.name as restname")
    ->join("users", "positions.users_id", "users.id")
	->join("restaurants", "positions.restaurants_id", "restaurants.id")
	->whereIn('users.role', array("e"))
    ->orderBy("users.id", "asc")->orderBy("users.fio")
	->orderBy("restaurants.id", "asc")->orderBy("restaurants.name")
    ->orderBy("id", "asc")->orderBy("name")->get();
    return view("positions.index", ["subcats" => $subcats]);
  }
  //-------------------------addedit manager only----------------------
  public function input(Positions $position) {
	if (str_contains(url()->current(),'create')) {
		$posits = Positions::select("users.id")
			->join("users", "positions.users_id", "users.id")->whereIn('users.role', array("e"))->orderBy("users.fio")->get();
		if ($posits->isNotEmpty()) {
			foreach ($posits as $posit) {
				$userID[] = $posit->id;
			}
		} else { $userID = array(); }
		//---------------------count positions----------------------------
		$counts = DB::table('positions')->count();
		//-----------------------------------------------------------------
		if(!empty($userID) || $counts == 0) {
		 $cats = User::whereIn('role', array("e"))->whereNotIn("id",$userID)->orderBy("id", "asc")->orderBy("fio")->get(["fio", "id"]);
		}  else {
			return redirect()->action("PositionsController@index")
				->with("status", "Отсутствуют сотрудники-менеджеры.");
		}
	} else {
			$cats = Positions::select("users.fio","users.id")
			->join("users", "positions.users_id", "users.id")->whereIn('users.role', array("e"))->orderBy("users.fio")->get();	
	}
	$rests = Restaurants::orderBy("id", "asc")->orderBy("name")->get(["name", "id"]);
    return view("positions.input", ["subcat" => $position, "cats" => $cats, "rests" => $rests]);
  }
  public function save(PositionsRequest $request) {
    if ($request->has("id")) {
      $subcat = Positions::findOrFail($request->id);
	  $subcat->slug = str_slug($request->slug, strtotime(date("Y-m-d H:m:i")));
      $subcat->fill($request->all())->save();
      $s = " обновлена"; $logs_title="обновление должности";
    } else {
      $subcat = Positions::create($request->all());
      $s = " создана"; $logs_title="создание должности";
    }
	//-------------------------insert logs-----------------------------------------
	DB::table('logs')->insert([ 'positions_id' => $subcat->id, 'title' => $logs_title, 'admin_id' => auth()->user()->id ]);
	//-----------------------------------------------------------------------------
    return redirect()->action("PositionsController@index")
    ->with("status", "Должность " . $subcat->name . $s);
  }
  //-------------------------delete------------------------
  public function destroy(Positions $position) {
    $name = $position->name;
    $position->delete();
    return redirect()->action("PositionsController@index")
    ->with("status", "Должность " . $name . " удалена");
  }
}
