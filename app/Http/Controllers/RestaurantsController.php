<?php

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Helpers\Helper;
use App\Models\Restaurants;
use App\View\Components\DeleteModal;
use App\View\Components\Form\Table\Actions;
use App\View\Components\Form\Table\Date;
use App\View\Components\Form\Table\Text;
use Illuminate\Http\Request;
use App\Http\Requests\RestaurantsRequest;
use DB;
use Illuminate\Support\Str;

class RestaurantsController extends Controller
{
    function index()
    {
        if(auth()->user()->role == Role::E->value){
            $restaurants = Restaurants::query()
                ->select('restaurants.id as id', 'restaurants.name as name', 'restaurants.description as description', 'users.fio as fio')
                ->join('users', 'restaurants.user_id', 'users.id')
                ->where('restaurants.user_id',auth()->user()->id)
                ->get();
        }else{
            $restaurants = Restaurants::query()
                ->select('restaurants.id as id', 'restaurants.name as name', 'restaurants.description as description', 'users.fio as fio')
                ->join('users', 'restaurants.user_id', 'users.id')
                ->get();
        }
        $data = [];
        foreach ($restaurants as $restaurant) {
            $data[] = [
                new Text($restaurant->name),
                new Text($restaurant->description,limit:30),
                new Text($restaurant->fio),
                new Actions([
                    new Actions\IconLink(route('restaurants.edit', $restaurant->id), 'edit'),
                    //new Actions\IconLink(route('restaurants.destroy',$restaurant->id),'trash'),
                    new DeleteModal(
                        title:'Удалить ресторан?',
                        text:'Вы действительно хотите удалить ресторан?',
                        url:route('restaurants.destroy', $restaurant->id),
                        id:$restaurant->id,
                    )
                ])
            ];
        }
        return view('restaurants.index', ['restaurants' => Helper::paginateArray($data)]);
    }

    function edit($id)
    {
        $restaurant = Restaurants::query()->where('id',$id)->firstOrFail();
        $managers = DB::table('users')->where('role','e')->get()
            ->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->fio,
                ];
            });
        return view('restaurants.edit',[
            'restaurant' => $restaurant,
            'managers' => $managers,
            'action' => route('restaurants.update', $restaurant->id),
            'method' => 'PUT',
        ]);
    }

    function update($id, RestaurantsRequest $request)
    {
        Restaurants::query()->where('id', $id)->update($request->validated());
        return redirect()->route('restaurants.index');
    }

    function destroy($id)
    {
        Restaurants::query()->where('id', $id)->delete();
        return redirect()->route('restaurants.index');
    }

    function create()
    {
        $restaurant = new Restaurants();
        $managers = DB::table('users')->where('role','e')->get()
            ->map(function ($value) {
                return [
                    'id' => $value->id,
                    'name' => $value->fio,
                ];
            });
        return view('restaurants.edit',[
            'restaurant' => $restaurant,
            'managers' => $managers,
            'action' => route('restaurants.store'),
            'method' => 'POST',
        ]);
    }

    function store(RestaurantsRequest $request)
    {
        Restaurants::create($request->validated());
        return redirect()->route('restaurants.index');
    }
}
