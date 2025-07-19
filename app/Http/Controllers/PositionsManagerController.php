<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Positions;
use App\User;
use App\Restaurants;
use DB;
use App\Http\Requests\PositionsRequest;
use Illuminate\Support\Collection;

class PositionsManagerController extends Controller
{
  public function __construct() {
    parent::__construct();
    $this->middleware("can:manipulate,App\PositionsManager");
  }
  //-----------------------------view--------------------
  public function index() {
	if (isset($_GET['rest_id'])) {
			$rest_id = $_GET['rest_id'];

		$restaurantsID = $this->isrestaurants();
		if(!empty($restaurantsID)) {
		$subcats = Positions::select("positions.*", "users.fio as usrname", "restaurants.name as restname")
		->join("users", "positions.users_id", "users.id")
		->join("restaurants", "positions.restaurants_id", "restaurants.id")
		->whereIn('users.role', array("a"))
		->whereIn('positions.restaurants_id',$restaurantsID)
		->where([['positions.restaurants_id', '=', $rest_id],['positions.users_id', '=', 2]])
		->orderBy("users.id", "asc")->orderBy("users.fio")
		->orderBy("restaurants.id", "asc")->orderBy("restaurants.name")
		->orderBy("users.id", "asc")->get();
		//var_dump($subcats);die;
		/*if (!$subcats->isEmpty()) { return view("positionsmanager.index", ["subcats" => $subcats]); }
		 else { return redirect()->action("RestaurantsController@index")
				->with("status", "Отсутствуют вакантные должности."); }*/
		} else {
			return redirect()->action(MainController::class."@index")
					->with("status", "Вы не поставлены на должность в ресторане - обратитесь к администратору.");
		}
		$restaurants = Restaurants::where('id', '=', $rest_id)->first();
		//var_dump($restaurants->id); die;
		return view("positionsmanager.index", ["subcats" => $subcats,"restaurants"=>$restaurants]);
	}
  }
  //-------------------------addedit customers only----------------------
  public function inputadd(Positions $position,$id) {
	//var_dump($id); die;
	$restaurantsID = $this->isrestaurants();
	if (str_contains(url()->current(),'create')) {
		$posits = Positions::select("users.id")
			->join("users", "positions.users_id", "users.id")->whereIn('users.role', array("a"))->orderBy("users.fio")->get();
		if ($posits->isNotEmpty()) {
			foreach ($posits as $posit) {
				$userID[] = $posit->id;
			}
		} else { $userID = array(); }
		//---------------------count positions----------------------------
		$counts = DB::table('positions')->join("users", "positions.users_id", "users.id")
			->select(DB::raw('count(users.id)'))->whereIn('users.role', array("a"))
			->groupBy('positions.id')->count();
		//-----------------------------------------------------------------
		if(!empty($userID) || $counts == 0) {
		  $cats = User::whereIn('role', array("a"))->whereNotIn("id",$userID)->orderBy("id", "asc")->orderBy("fio")->get(["fio", "id"]);
		} else {
			return redirect()->action("RestaurantsController@index")
				->with("status", "Отсутствуют сотрудники.");
		}
	} else {
		if(!empty($restaurantsID)) {
			$cats = Positions::select("users.fio","users.id")
			->join("users", "positions.users_id", "users.id")->whereIn('users.role', array("a"))->whereIn('positions.restaurants_id',$restaurantsID)->orderBy("users.fio")->get();
		} else {
			return redirect()->action("RestaurantsController@index")
					->with("status", "Вы не поставлены на должность в ресторане - обратитесь к администратору.");
		}
	}
		if(!empty($restaurantsID)) {
			$rests = Restaurants::orderBy("id", "asc")->whereIn('id',$restaurantsID)->orderBy("name")->get(["name", "id"]);
		} else {
			return redirect()->action("RestaurantsController@index")
					->with("status", "Вы не поставлены на должность в ресторане - обратитесь к администратору.");
		}
	if ($cats->isNotEmpty()) {
		return view("positionsmanager.input", ["subcat" => $position, "cats" => $cats, "rests" => $rests, "rest_id" => $id]);
	} else {
		return redirect()->action("RestaurantsController@index")
				->with("status", "Отсутствуют сотрудники.");
	}
  }
  //------------------------------edit----------------------------
  public function input(Positions $position) {
	$positions = Positions::where('slug', '=', $position->slug)->first();
	return $positions;
  }

  public function save(PositionsRequest $request) {
    if ($request->has("id")) {
      $subcat = Positions::findOrFail($request->id);
	  $subcat->slug = str_slug($request->slug, strtotime(date("Y-m-d H:m:i")));
      $subcat->fill($request->all())->save();
      $s = " обновлена"; $logs_title="обновление должности";
	  return redirect("/positionsmanager?rest_id=".$request->restaurants_id)
		->with("status", "Должность " . $subcat->name . $s);
    } else {
	  if ($request->has("rest_id")) {
      $subcat = Positions::create($request->all());
      $s = " создана"; $logs_title="создание должности";
	  return redirect("/positionsmanager?rest_id=".$request->rest_id)->with("status", "Должность " . $subcat->name . $s);
	  }
    }

  }
  //-------------------------delete------------------------
  public function destroy(Positions $position, $rest_id) {
    $name = $position->name;
    $position->delete();
    return redirect("/positionsmanager?rest_id=".$rest_id) //redirect()->action("RestaurantsController@index")
    ->with("status", "Должность " . $name . " удалена");
  }
  //-------------------is restaurants for auth manager-----------------
  public function isrestaurants() {

	  $posits = Positions::select("restaurants.id")
			->join("users", "positions.users_id", "users.id")
			->join("restaurants", "positions.restaurants_id", "restaurants.id")
			->whereIn('users.role', array("e"))->where('users.id', '=', auth()->user()->id)->orderBy("users.fio")->get();
	   if ($posits->isNotEmpty()) {
		foreach ($posits as $posit) {
			$restaurantsID[] = $posit->id;
		}
	   } else { $restaurantsID = array(); }
	return $restaurantsID;
  }
}
