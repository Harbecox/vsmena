<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logs;

class LogsController extends Controller
{
    public function __construct() {
    parent::__construct();
		$this->middleware("can:manipulate,App\Logs");
	}
	//--------------------------view------------------------------------
    public function index()
    {
		 $data = Logs::select("logs.*", "users.fio as usrfio", "restaurants.name as restname", "positions.name as posname")
								->join("positions", "logs.positions_id", "positions.id")
								->join("users", "positions.users_id", "users.id")
							    ->join("restaurants", "positions.restaurants_id", "restaurants.id")->where("logs.admin_id","=",auth()->user()->id)->get();
		return view('/logs/index')->with('data',$data);
	}
}
