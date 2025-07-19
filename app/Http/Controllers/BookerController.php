<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Restaurants;
use DB;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;

class BookerController extends Controller
{
	//-------------------access booker----------------------------
    public function __construct() {
    parent::__construct();
		$this->middleware("can:manipulate,App\Booker");
	}
	//----------------------export to excel------------------------
	 public function index()
    {
		$restaurants = Restaurants::select("id", "name")->orderBy("name")->get();
		$users = User::whereIn('role', array("a", "e"))->orderBy("id", "asc")->orderBy("fio")->get(["fio", "id"]);
		return view("booker.index", ["users" => $users,"rests"=>$restaurants]);
	}
	
	public function downloads(Request $request) 
    {
		$launch_start_date = date("Y-m-d", strtotime($request->input('start_date')));
		$launch_end_date = date("Y-m-d", strtotime($request->input('end_date')));
		return Excel::download(new EventsExport($request->input('restaurants_id'), $request->input('users_id'), $launch_start_date, $launch_end_date), 'exportBookerEvents.xlsx');
	}
}
