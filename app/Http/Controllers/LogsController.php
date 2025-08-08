<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Http\Request;


class LogsController extends Controller
{

	//--------------------------view------------------------------------
    public function index()
    {
		 $data = Logs::select("logs.*", "users.fio as usrfio", "restaurants.name as restname", "positions.name as posname")
								->join("positions", "logs.positions_id", "positions.id")
								->join("users", "positions.user_id", "users.id")
							    ->join("restaurants", "positions.restaurants_id", "restaurants.id")->where("logs.admin_id","=",auth()->user()->id)->get();
		return view('/logs/index')->with('data',$data);
	}
}
