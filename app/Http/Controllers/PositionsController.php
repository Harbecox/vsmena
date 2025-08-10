<?php

namespace App\Http\Controllers;

use App\Enum\PaymentMethod;
use App\Helpers\Helper;
use App\Models\Positions;
use App\Models\Restaurants;
use App\View\Components\DeleteModal;
use App\View\Components\Form\Filter;
use App\View\Components\Form\Table\Actions;
use App\View\Components\Form\Table\Text;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\PositionsRequest;

class PositionsController extends Controller
{
    function index()
    {
        $filters_params = \Illuminate\Support\Facades\Request::all();
        $query = Positions::query()
            ->select(['positions.name as name','positions.id as id','positions.payment_method as payment_method','positions.payment_amount as payment_amount','positions.description as description','restaurants.name as restaurant_name'])
            ->join('restaurants','positions.restaurants_id','=','restaurants.id');

        if(isset($filters_params['restorant'])){
            $query = $query->where('restaurants.id', '=', $filters_params['restorant']);
        }
        if(isset($filters_params['positions'])){
            $query = $query->where('positions.name', '=', $filters_params['positions']);
        }

        $positions = $query->get();
        $data = [];
        foreach ($positions as $position) {
            $data[] = [
                new Text($position->restaurant_name),
                new Text($position->name),
                new Text(PaymentMethod::from($position->payment_method)->label()),
                new Text($position->payment_amount),
                new Text($position->description,limit:50),
                new Actions([
                    new Actions\IconLink(route('positions.edit',$position->id),'edit'),
                    new DeleteModal(
                        title:'Удалить должность?',
                        text:'Вы действительно хотите удалить должность?',
                        url:route('positions.destroy', $position->id),
                        id:$position->id,
                    )
                ])
            ];
        }
        $pos_filter = Positions::query()->select('name')->groupBy('name')->get()->keyBy('name')->map(function ($value) { return $value->name;})->toArray();
        $data = Helper::paginateArray($data);
        $restorans = Restaurants::query()->pluck("name", "id")->toArray();
        $restorans['-1'] = 'Все рестораны';
        $filters[] = new Filter('positions','Должность','',$pos_filter,'pos_filter');
        $filters[] = new Filter('restorant','Выбрать ресторан','Все рестораны',$restorans,'cookie');
        return view('positions.index',['positions' => $data,'filters' => $filters]);
    }

    function edit($id)
    {
        $position = Positions::query()->where('id',$id)->firstOrFail();
        return view('positions.edit',
        [
            'position' => $position,
            'restaurants' => Restaurants::query()->get()
            ->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->name,
                ];
            }),
            'action' => route('positions.update', $position->id),
            'method' => 'PUT'
        ]);
    }

    function update($id,PositionsRequest $request)
    {
        Positions::query()->where('id',$id)->update($request->validated());
        return response()->redirectToRoute('positions.index');
    }

    function store(PositionsRequest $request)
    {
        Positions::create($request->validated());
        return response()->redirectToRoute('positions.index');
    }

    function create()
    {
        $position = new Positions();
        return view('positions.edit',
            [
                'position' => $position,
                'restaurants' => Restaurants::query()->get()
                    ->map(function ($value) {
                        return [
                            'id' => $value->id,
                            'name' => $value->name,
                        ];
                    }),
                'action' => route('positions.store', $position->id),
                'method' => 'POST'
            ]);
    }

    function destroy($id)
    {
        Positions::query()->where('id',$id)->firstOrFail()?->delete();
        return redirect()->route('positions.index');
    }
}
