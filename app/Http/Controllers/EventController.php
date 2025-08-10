<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\View\Components\Form\DateFilter;
use App\View\Components\Form\Filter;
use App\View\Components\Form\Table\Date;
use App\View\Components\Form\Table\Text;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Positions;
use App\Models\Restaurants;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Exports\EventsCustomerExport;
use App\Exports\EventsFCustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;

class EventController extends Controller
{
    //----------------------view--------------------------------
    public function index()
    {
        $filters_params = \Illuminate\Support\Facades\Request::all();
        $query = Event::select("events.*", "positions.name as posname", "restaurants.name as restname",
            "positions.payment_amount")
            ->leftJoin("positions", "events.positions_id", "positions.id")
            ->leftJoin("users", "events.user_id", "users.id")
            ->leftJoin("restaurants", "positions.restaurants_id", "restaurants.id")
            ->where('events.user_id', '=', auth()->user()->id);
        if(isset($filters_params['restorant'])){
            $query = $query->where('restaurants.id', '=', $filters_params['restorant']);
        }
        if(isset($filters_params['status'])){
            $query = $query->where('events.status', '=', $filters_params['status']);
        }
        if(isset($filters_params['date'])){
            $dates = explode(',', $filters_params['date']);
            $query = $query->whereBetween('events.start_date', [$dates[0], $dates[1]]);
        }
        else{
            $from = Carbon::now()->subDays(1)->format('Y-m-d');
            $to = Carbon::now()->format('Y-m-d');
            $url = \Illuminate\Support\Facades\Request::url() . (count($filters_params) > 0 ? http_build_query($filters_params). '&' : "?") . "date=".$from.','.$to;

            $status = session('status');
            $error = session('error');

            return redirect($url)
                ->with('status', $status)
                ->with('error', $error);
        }
        $export_url = '/events/export?' . http_build_query($filters_params);
        $events = $query->get();
        $data = [];
        foreach ($events as $event) {
            $data[] = [
                new Text($event->restname),
                new Text($event->posname),
                new Date($event->start_date),
                new Date($event->end_date),
                new Text(Helper::formatDurationRoundedHours($event->start_date, $event->end_date)),
                new Text($event->status ? 'Подтверждена' : 'Не подтверждена')
            ];
        }
        $restorans = Restaurants::query()->pluck("name", "id")->toArray();
        $restorans['-1'] = 'Все рестораны';
        $statuses = [
            '0' => 'Не подтверждена',
            '1' => 'Подтверждена',
            '-1' => 'Все смены'
        ];
        $data = Helper::paginateArray($data);
        $filters[] = new Filter('status','Статус смены','Все смены',$statuses);
        $filters[] = new Filter('restorant','Выбрать ресторан','Все рестораны',$restorans,'cookie');
        $filters[] = new DateFilter('date','Выбрать даты','--',[],'calendar');
        return view("eventscustomer.index", ["events" => $data,'filters' => $filters,'export_url' => $export_url]);
    }

    //----------------------add---------------------------------
    public function display()
    {
        //--------------------save and read file------------------
        if (isset($_GET['rest_id'])) {
            $getdata = $_GET['rest_id'];
            Storage::disk('local')->put('selRest.txt', $getdata);
        }
        if (Storage::disk('local')->exists('selRest.txt')) $getdata_ = Storage::disk('local')->get('selRest.txt');
        //----------------------------restaurants------------------
        $restaurants = DB::select("SELECT * FROM `restaurants`");
        if (isset($getdata_)) {
            $events = DB::select("SELECT * FROM `positions` WHERE user_id = 2 AND restaurants_id =" . $getdata_);
            $restaurant = DB::table('restaurants')->where('id', $getdata_)->first();
        } else {
            $events = array();
        }
        return view("/eventscustomer/addevent", ["rests" => $restaurants, "events" => $events, "restaurant" => $restaurant]);
    }

    public function open(Request $request)
    {
        $events = new Event;
        $events->start_date = Helper::parseRuDate($request->input('start_date'));
        $events->positions_id = $request->input('position_id');

        $events->save();
        //----------------------------------------------------------
        DB::table('positions')->where('id', $events->positions_id)->update(['user_id' => auth()->user()->id]);
        //----------------------------------------------------------
        return redirect()->route('events.index')->with("status", 'Смена успешно открыта.');
    }

    //--------------------------edit----------------------------
    public function input($id)
    {
        $events = Event::find($id);
        return view('eventscustomer.input', compact('events', 'id'));
    }

    public function close(Request $request)
    {
        $event = Event::where('id', '=', $request->id)->first();
        Positions::query()->where('id',$event->positions_id)->update(['user_id' => null]);
        return redirect()->route('events.index')->with('status', 'Смена успешно закрыта.');
    }

    //------------------------------translit php-------------------------------------
    public function convertRUcharacters($str)
    {
        $from = array('а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я');
        $to = array('a', 'b', 'v', 'g', 'd', 'e', 'e', 'zh', 'z', 'i', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'kh', 'cz', 'ch', 'sh', 'shh', '', 'y', '', 'e', 'yu', 'ya', 'A', 'B', 'V', 'G', 'D', 'E', 'E', 'ZH', 'Z', 'I', 'I', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'KH', 'CZ', 'CH', 'SH', 'SHH', '', 'Y', '', 'E', 'YU', 'YA');
        return str_replace($from, $to, $str);
    }

    //-------------------------view-----------------------------
    public function views()
    {
        $events = Event::select("events.*", "positions.name as posname", "restaurants.name as restname",
            "positions.payment_amount", DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.payment_amount + events.premium as payment"))
            ->join("positions", "events.positions_id", "positions.id")
            ->join("users", "positions.user_id", "users.id")
            ->join("restaurants", "positions.restaurants_id", "restaurants.id")->where('events.status', '=', '1')
            ->where('users.id', '=', auth()->user()->id)->orderBy("events.start_date", "asc")->get();
        $rests = Restaurants::orderBy("id", "asc")->orderBy("name")->get(["name", "id"]);

        return view('/eventscustomer/mview', ['events' => $events, "rests" => $rests, 'header' => "История моих смен"]);
    }

    public function show(Request $request)
    {
        //var_dump($request->input('title')); die;
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $restaurants_id = $request->input('restaurants_id');
        $title = $request->input('title');

        if ($start_date != "" && $end_date != "" && $restaurants_id != "" && $title != "") {
            $events = Event::select("events.*", "positions.name as posname", "restaurants.name as restname",
                "positions.payment_amount", DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"), DB::raw("TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.payment_amount + events.premium as payment"))
                ->join("positions", "events.positions_id", "positions.id")
                ->join("users", "positions.user_id", "users.id")
                ->join("restaurants", "positions.restaurants_id", "restaurants.id")
                ->where(DB::raw('DATE(events.start_date)'), '>=', $start_date)
                ->where(DB::raw('DATE(events.end_date)'), '<=', $end_date)
                ->where('positions.restaurants_id', '=', $restaurants_id)
                ->where('events.title', '=', $title)
                ->where('users.id', '=', auth()->user()->id)->get();
            $rests = Restaurants::where("id", "=", $restaurants_id)->orderBy("name")->get(["name", "id"]);
            return view('/eventscustomer/displaym', ['events' => $events, "start_date" => $start_date, "end_date" => $end_date, "rests" => $rests, "title" => $title, 'header' => "Найденные мои смены"]);
        }
    }

    //------------------------------------------export to Excel---------------------------
    public function download()
    {
        $filters_params = \Illuminate\Support\Facades\Request::all();
        $restaurants_id = $filters_params['restorant'] ?? -1;
        $status = $filters_params['status'] ?? -1;
        $dates = explode(',', $filters_params['date']);
        return Excel::download(new EventsCustomerExport($dates[0],$dates[1],$restaurants_id,$status), 'exportCustomerEvents.xlsx');
    }


//	public function __construct() {
//    parent::__construct();
//		$this->middleware("can:manipulate,App\Event");
//	}
//	//--------------------------view------------------------------------
//    public function index()
//    {
//                $events = [];
//                $data = Event::select("events.*", "positions.name as posname")->join("positions", "events.positions_id", "positions.id")->where('events.status','=','1')->get();
//                if($data->count())
//                 {
//                    foreach ($data as $key => $value)
//                    {
//                        $events[] = Calendar::event(
//                            $value->title,
//                            true,
//                            new \DateTime($value->start_date),
//                            new \DateTime($value->end_date.'+1 day'),
//                            null,
//                            // Add color
//                         [
//                            'color'=> $value->color,
//                             'textColor' => $value->textColor,
//                         ]
//                        );
//                    }
//                }
//			$calendar =\Calendar::addEvents($events)->setOptions(['lang' => 'ru'])->setCallbacks([
//            'eventClick' => 'function(event) {
//				let evdate = event.start.format("YYYY-MM-DD");
//
//				// ------create XMLHttpRequest-----------------
//				const request = new XMLHttpRequest();
//
//				// ---------path-------------------------------
//				const url = "/events/editeventurl?eventdate=" + evdate;
//
//				// ---------send POST--------------------------
//				request.open("GET", url);
//				request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
//				// ---------------result send------------------
//				request.addEventListener("readystatechange", () => {
//					if(request.readyState === 4 && request.status === 200) {
//						//console.log(request.responseText);
//						window.location.href = "/events/editeventurl";
//					}
//				});
//
//				//------- send ---------------------------------
//				request.send();
//			}',
//        ]);
//		return view('/events/eventpage',compact('events','calendar'),['header'=>"Календарь смен сотрудников"]);
//    }
//	//---------------------------view------------------------------
//	public function show()
//    {
//	 if (isset($_GET['eventdate'])) {
//		$day = $_GET['eventdate'];
//		Storage::disk('local')->put('clickDay.txt', $day);
//	 }
//	 if (Storage::disk('local')->exists('clickDay.txt')) $eventdate = Storage::disk('local')->get('clickDay.txt');
//
//     $events = Event::select("events.*", "positions.name as posname", "users.fio as usrfio", "restaurants.name as restname",
//								"positions.price_hour", DB::raw("SEC_TO_TIME(TIMESTAMPDIFF(minute, events.start_date, events.end_date)*60) as period"),
//								DB::raw('(CASE
//											WHEN positions.price_hour != 0.00 AND positions.price_shifts = 0.00 AND positions.price_month = 0.00
//												THEN TIMESTAMPDIFF(hour, events.start_date, events.end_date) * positions.price_hour + events.premium
//											WHEN positions.price_hour = 0.00 AND positions.price_shifts != 0.00 AND positions.price_month = 0.00
//												THEN positions.price_shifts + events.premium
//											WHEN positions.price_hour = 0.00 AND positions.price_shifts = 0.00 AND positions.price_month = 0.00
//												THEN positions.price_month + events.premium
//									       END) AS payment')
//								)->join("positions", "events.positions_id", "positions.id")
//								->join("users", "positions.users_id", "users.id")
//							    ->join("restaurants", "positions.restaurants_id", "restaurants.id")->where([[DB::raw('DATE(events.start_date)'), '=', $eventdate],['events.status','=','1']])->get();
//     return view('/events/display')->with('events',$events);
//    }
//	//----------------------edit----------------------------------
//	 public function edit($id)
//    {
//        $events = Event::find($id);
//		return view('/events/editform',compact('events','id'));
//    }
//
//    public function update(Request $request, $id)
//    {
//          $events = Event::where('id', '=', $id)->first();
//          $events->update($request->all());
//		  //-------------------------insert logs-----------------------------------------
//		  $logs_title = "обновление смены сотрудника";
//		  DB::table('logs')->insert([ 'positions_id' => $events->positions_id, 'title' => $logs_title, 'admin_id' => auth()->user()->id ]);
//		  //-----------------------------------------------------------------------------
//         return redirect('/events/editeventurl')->with('status','Смена успешно обновлена.');
//    }
//	//---------------------delete---------------------------------
//	public function destroy($id)
//    {
//        $events = Event::find($id);
//        $events->delete();
//        return redirect('/events/editeventurl');
//    }
//	//----------------------export to excel------------------------
//	public function export()
//    {
//		$restaurants = Restaurants::select("id", "name")->orderBy("name")->get();
//		$users = User::whereIn('role', array("a", "e"))->orderBy("id", "asc")->orderBy("fio")->get(["fio", "id"]);
//		return view("/events/exports", ["users" => $users,"rests"=>$restaurants]);
//    }
//	public function downloads(Request $request)
//    {
//		$launch_start_date = date("Y-m-d", strtotime($request->input('start_date')));
//		$launch_end_date = date("Y-m-d", strtotime($request->input('end_date')));
//		return Excel::download(new EventsExport($request->input('restaurants_id'), $request->input('users_id'), $launch_start_date, $launch_end_date), 'exportAdminEvents.xlsx');
//	}
}
