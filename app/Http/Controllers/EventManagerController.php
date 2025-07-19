<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Positions;
use App\Models\User;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class EventManagerController extends Controller
{
	//----------------------view--------------------------------
	public function index() {

    $events = Event::select("events.*",	"positions.name as posname", "users.fio as usrfio", "restaurants.name as restname",
								"positions.price_hour")
								->join("positions", "events.positions_id", "positions.id")
								->join("users", "positions.users_id", "users.id")
								->join("restaurants", "positions.restaurants_id", "restaurants.id")
								->where('events.start_date', '>=', Carbon::now()->subDays(1))
								->where('users.id', '=', auth()->user()->id)->get();
    return view("events.index", ["events" => $events]);
  }
	//----------------------add---------------------------------
	public function display()
     {
		$events = DB::select("SELECT p.*, r.name as rname FROM positions as p INNER JOIN users as u ON p.users_id= u.id INNER JOIN restaurants as r on p.restaurants_id = r.id WHERE u.id = :id",['id' => auth()->user()->id]);

		return view("/events/addevent", ["events" => $events]);
     }
	public function store(Request $request)
    {
         $events=new Event;
         $events->title=$request->input('title');
         $events->color=$request->input('color');
         $events->start_date=$request->input('start_date');
		 $events->status=$request->input('status');
		 $events->positions_id=$request->input('positions_id');
         $events->save();
         return redirect('/events')->with("status",'Смена успешно открыта.');
    }
	//--------------------------edit----------------------------
	 public function input($id)
    {
		$events = Event::find($id);
		return view('events.input',compact('events','id'));
    }
	public function save(Request $request)
    {
          $events = Event::where('id', '=', $request->id)->first();
          $events->update($request->all());
         return redirect('/events')->with('status','Смена успешно закрыта.');
    }
	//-------------------------view-----------------------------
	public function views($url)
     {
		 $events = [];
				//----------------------------------------------------------------------------------
				if ($url == "history") { $header = "История моих смен"; $flag="hs"; }
				else if ($url == "confirm") { $header = "Подтверждение смен"; $flag="cf"; }
				//------------------------ call function confirmation ------------------------------

                $data = $this->confirmation($url);
				if (isset($_GET['restcal_id'])) $datas = $_GET['restcal_id']; else $datas=NULL;

				if (!empty($data)) {
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
				}
			$calendar =\Calendar::addEvents($events)->setOptions(['lang' => 'ru'])->setCallbacks([
            'eventClick' => 'function(event) {
				let evdate = event.start.format("YYYY-MM-DD");

				// ------create XMLHttpRequest-----------------
				const request = new XMLHttpRequest();

				// ---------path-------------------------------
				const url = "/events/mviewurl?eventdate=" + evdate+"&flag='.$flag.'&restcal='.$datas.'";

				// ---------send POST--------------------------
				request.open("GET", url);
				request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				// ---------------result send------------------
				request.addEventListener("readystatechange", () => {
					if(request.readyState === 4 && request.status === 200) {
						//console.log(request.responseText);
						window.location.href = "/events/mviewurl";
					}
				});

				//------- send ---------------------------------
				request.send();
			}',
        ]);
		//--------------------------restaurants----------------------------
		$rest_id = $this->get_restaurants_id();
		$rests = DB::table('restaurants')->select('*') ->whereIn('id', $rest_id)->get();

		return view('/events/mview',compact('events','calendar'),['datas'=>$datas,'rests'=>$rests,'header'=>$header]);
	 }
	//---------------------------view table manager------------------------------
	public function show()
    {
	 if (isset($_GET['eventdate'])) {
		$day = $_GET['eventdate'];
		$flag = $_GET['flag'];
		$restcal = $_GET['restcal'];
		Storage::disk('local')->put('clickDaym.txt', $day.":".$flag.":".$restcal);
	 }
	 if (Storage::disk('local')->exists('clickDaym.txt')) $eventdate = Storage::disk('local')->get('clickDaym.txt');
	 $eventdate_flag = explode(":", $eventdate);
	 if ($eventdate_flag[1] == "hs") {

	 $header = "Список моих смен";$flag=$eventdate_flag[1];

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
							    ->join("restaurants", "positions.restaurants_id", "restaurants.id")->where(DB::raw('DATE(events.start_date)'), '=', $eventdate_flag[0])->where('users.id', '=', auth()->user()->id)->get();
	 } else if ($eventdate_flag[1] == "cf") {

		 $flag=$eventdate_flag[1];
		 //var_dump($eventdate_flag[0]); die;
		 if((!isset($eventdate_flag[2])) || (isset($eventdate_flag[2]) && $eventdate_flag[2] == 0)) {
			 $rest_id = $this->get_restaurants_id();
			 if (!empty($rest_id)) {
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
										->join("restaurants", "positions.restaurants_id", "restaurants.id")->where(DB::raw('DATE(events.start_date)'), '=', $eventdate_flag[0])
										->whereIn('restaurants.id', $rest_id)
										->where('events.status','=','1')
										->where('users.role', '=',"a")->get();
			 }
		} else {

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
										->join("restaurants", "positions.restaurants_id", "restaurants.id")->where(DB::raw('DATE(events.start_date)'), '=', $eventdate_flag[0])
										->where('restaurants.id', $eventdate_flag[2])
										->where('events.status','=','1')
										->where('users.role', '=',"a")->get();
		}
		$header = "Список смен сотрудников ".$events[0]->restname." ".$eventdate_flag[0];
	 }
     return view('/events/displaym',['events'=>$events,'header'=>$header,'flag'=>$flag]);
    }
	public function confirmation($url) {
		$data="";
		if ($url == "history") {
		$data = Event::select("events.*", "positions.name as posname", "users.fio as usrfio")
										->join("positions", "events.positions_id", "positions.id")
										->join("users", "positions.users_id", "users.id")
										->where('users.id', '=', auth()->user()->id)->where('events.status','=','1')->get();
		} else if ($url == "confirm") {
			if (isset($_GET['restcal_id'])) {
				$restcal_id = $_GET['restcal_id'];
				Storage::disk('local')->put('clickRestCal.txt', $restcal_id);
			 }
			 if (Storage::disk('local')->exists('clickRestCal.txt')) $restcal_id = Storage::disk('local')->get('clickRestCal.txt');
			if((!isset($_GET['restcal_id'])) || (isset($_GET['restcal_id']) && $_GET['restcal_id'] == 0)) {
				$rest_id = $this->get_restaurants_id();

					if (!empty($rest_id)) {
						$data = Event::select("events.*", "positions.name as posname", "users.fio as usrfio")
														->join("positions", "events.positions_id", "positions.id")
														->join("users", "positions.users_id", "users.id")
														->join("restaurants", "positions.restaurants_id", "restaurants.id")
														->whereIn('restaurants.id', $rest_id)
														->where([['users.role', '=',"a"],['events.status','=','1']])->get();
					$data=[];}
			} else {
				$data = Event::select("events.*", "positions.name as posname")
														->join("positions", "events.positions_id", "positions.id")
														->join("users", "positions.users_id", "users.id")
														->join("restaurants", "positions.restaurants_id", "restaurants.id")
														->where('restaurants.id',"=", $restcal_id)
														->where([['users.role', '=',"a"],['events.status','=','1']])->get();
			}
		}
		return $data;
	}
	public function get_restaurants_id() {
		//--------------------------get array objectStd ----------------
		$rest_id = DB::select("SELECT p.restaurants_id FROM positions as p INNER JOIN users as u ON p.users_id= u.id INNER JOIN restaurants as r on p.restaurants_id = r.id WHERE u.id = :id",['id' => auth()->user()->id]);

		//-------------convert to first record--------------------------
		$rest_id= json_decode(json_encode($rest_id), true);
		return $rest_id;
	}
	//----------------------edit----------------------------------
	public function edit($id)
    {
        $events = Event::find($id);
		//var_dump($events);die;
		return $events;//view('/events/meditform',compact('events','id'));
    }
    //----------------------editstatus----------------------------------
	public function editstatus($id)
    {
        DB::table('events')->where('id', $id)->update([ 'title' => 'Подтверждена', 'color' => '#008000' ]);
		return redirect('/events/mviewurl')->with('status','Смена успешно подтверждена.');
    }

    public function update(Request $request)
    {
          $events = Event::where('id', '=', $request->id)->first();
		  //------------------------callback----------------------------------------
		  if ($events->status == 0) {
				//-------------------------callback insert positions----------------
				$posit = Positions::select("name","restaurants_id")->where('id', '=', $events->positions_id)->first();
				$name_ = $this->convertRUcharacters($posit->name);
				$slug = $name_.time()*1000;
				DB::table('positions')->insert([ 'name'=>$posit->name,'price_shifts'=>'0.00','price_hour'=>'0.00','price_month'=>'0.00','description'=>'','slug'=>$slug,'users_id' => '2','restaurants_id' => $posit->restaurants_id ]);
				//-------------------------------------------------------------------
		  }
		  //-------------------------------------------------------------------------
          $events->update($request->all());
         return redirect('/events/mviewurl')->with('status','Смена успешно обновлена.');

    }
	//------------------------------translit php-------------------------------------
	public function convertRUcharacters($str) {
		$from = array('а','б','в','г','д','е','ё','ж','з','и','й','к','л','м','н','о','п','р','с','т','у','ф','х','ц','ч','ш','щ','ъ','ы','ь','э','ю','я','А','Б','В','Г','Д','Е','Ё','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Ъ','Ы','Ь','Э','Ю','Я');
		$to = array('a','b','v','g','d','e','e','zh','z','i','i','k','l','m','n','o','p','r','s','t','u','f','kh','cz','ch','sh','shh','','y','','e','yu','ya','A','B','V','G','D','E','E','ZH','Z','I','I','K','L','M','N','O','P','R','S','T','U','F','KH','CZ','CH','SH','SHH','','Y','','E','YU','YA');
    return str_replace($from, $to, $str);
	}
	//------------------------currentwork--------------------------------
	public function currentwork()
	{
		$rest_id = $this->get_restaurants_id();
		if (!empty($rest_id)) {
		$events = Event::select("restaurants.name as restname","users.fio as usrfio","positions.name as posname","events.*")
								->join("positions", "events.positions_id", "positions.id")
								->join("users", "positions.users_id", "users.id")
								->join("restaurants", "positions.restaurants_id", "restaurants.id")
								->whereIn('restaurants.id', $rest_id)
								->where([['events.status', '=', 0],['users.role', '=',"a"],[DB::raw('CAST(events.start_date AS date)'),'<=',DB::raw('CURDATE()')]])->get();

		return view("events.currentworks", ["events" => $events]);
	} else {
			return redirect()->action("EventManagerController@index")
					->with("status", "Вы не создали ресторан, чтобы встать в нем на должность.");
		}
	}

}
