<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\User;
use App\Positions;
use App\Restaurants;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Exports\EventsExport;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
	public function __construct() {
    parent::__construct();
		$this->middleware("can:manipulate,App\Event");
	}
	//--------------------------view------------------------------------
    public function index()
    {
                $events = [];
                $data = Event::select("events.*", "positions.name as posname")->join("positions", "events.positions_id", "positions.id")->where('events.status','=','1')->get();
                if($data->count())
                 {
                    foreach ($data as $key => $value) 
                    {
                        $events[] = Calendar::event(
                            $value->title,
                            true,
                            new \DateTime($value->start_date),
                            new \DateTime($value->end_date.'+1 day'),
                            null,
                            // Add color
                         [
                            'color'=> $value->color,
                             'textColor' => $value->textColor,
                         ]
                        );
                    }
                } 
			$calendar =\Calendar::addEvents($events)->setOptions(['lang' => 'ru'])->setCallbacks([
            'eventClick' => 'function(event) {	
				let evdate = event.start.format("YYYY-MM-DD");

				// ------create XMLHttpRequest-----------------
				const request = new XMLHttpRequest();

				// ---------path-------------------------------
				const url = "/events/editeventurl?eventdate=" + evdate;
				 
				// ---------send POST-------------------------- 
				request.open("GET", url);
				request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				// ---------------result send------------------
				request.addEventListener("readystatechange", () => {
					if(request.readyState === 4 && request.status === 200) {       
						//console.log(request.responseText);
						window.location.href = "/events/editeventurl";
					}
				});

				//------- send ---------------------------------
				request.send();				
			}',
        ]);
		return view('/events/eventpage',compact('events','calendar'),['header'=>"Календарь смен сотрудников"]);
    }
	//---------------------------view------------------------------
	public function show()
    {  
	 if (isset($_GET['eventdate'])) {
		$day = $_GET['eventdate'];
		Storage::disk('local')->put('clickDay.txt', $day);	
	 }
	 if (Storage::disk('local')->exists('clickDay.txt')) $eventdate = Storage::disk('local')->get('clickDay.txt');
	
     $events = Event::select("events.*", "positions.name as posname", "users.fio as usrfio", "restaurants.name as restname",
								"positions.price_hour", DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), 
								DB::raw('(CASE 
											WHEN positions.price_hour != 0.00 AND positions.price_shifts = 0.00 AND positions.price_month = 0.00 
												THEN TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour + events.premium 
											WHEN positions.price_hour = 0.00 AND positions.price_shifts != 0.00 AND positions.price_month = 0.00 
												THEN positions.price_shifts + events.premium 
											WHEN positions.price_hour = 0.00 AND positions.price_shifts = 0.00 AND positions.price_month = 0.00 
												THEN positions.price_month + events.premium
									       END) AS payment')
								)->join("positions", "events.positions_id", "positions.id")
								->join("users", "positions.users_id", "users.id")
							    ->join("restaurants", "positions.restaurants_id", "restaurants.id")->where([[DB::raw('DATE(events.start_date)'), '=', $eventdate],['events.status','=','1']])->get();
     return view('/events/display')->with('events',$events);
    }
	//----------------------edit----------------------------------
	 public function edit($id)
    { 
        $events = Event::find($id);
		return view('/events/editform',compact('events','id'));
    }

    public function update(Request $request, $id)
    {
          $events = Event::where('id', '=', $id)->first();
          $events->update($request->all());
		  //-------------------------insert logs-----------------------------------------
		  $logs_title = "обновление смены сотрудника";
		  DB::table('logs')->insert([ 'positions_id' => $events->positions_id, 'title' => $logs_title, 'admin_id' => auth()->user()->id ]);
		  //-----------------------------------------------------------------------------
         return redirect('/events/editeventurl')->with('status','Смена успешно обновлена.');
    }
	//---------------------delete---------------------------------
	public function destroy($id)
    {
        $events = Event::find($id);
        $events->delete();
        return redirect('/events/editeventurl');
    }
	//----------------------export to excel------------------------
	public function export() 
    {
		$restaurants = Restaurants::select("id", "name")->orderBy("name")->get();
		$users = User::whereIn('role', array("a", "e"))->orderBy("id", "asc")->orderBy("fio")->get(["fio", "id"]);
		return view("/events/exports", ["users" => $users,"rests"=>$restaurants]);
    }
	public function downloads(Request $request) 
    {
		$launch_start_date = date("Y-m-d", strtotime($request->input('start_date')));
		$launch_end_date = date("Y-m-d", strtotime($request->input('end_date')));
		return Excel::download(new EventsExport($request->input('restaurants_id'), $request->input('users_id'), $launch_start_date, $launch_end_date), 'exportAdminEvents.xlsx');
	}
}
