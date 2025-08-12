<?php

namespace App\Http\Controllers;

use App\Exports\EventsCustomerExport;
use App\Exports\RewardExport;
use App\Helpers\Helper;
use App\Http\Requests\RewardRequest;
use App\Models\Reward;
use App\View\Components\Form\DateFilter;
use App\View\Components\Form\Table\Text;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters_params = \Illuminate\Support\Facades\Request::all();
        if(!isset($filters_params['date'])){
            $from = Carbon::now()->subMonth()->format('Y-m-d');
            $to = Carbon::now()->format('Y-m-d');
            return redirect()->route('rewards.index', ['date' => $from.','.$to]);
        }
        $rewards = Reward::query()->whereBetween('date', explode(',', $filters_params['date']))->get();
        $data = [];
        foreach ($rewards as $reward) {
            $data[] = [
                new Text($reward->user->fio),
                new Text(Carbon::make($reward->created_at)->format('Y-m-d')),
                new Text(Carbon::make($reward->date)->format('Y-m-d')),
                new Text(\App\Enum\Reward::from($reward->type)->label() . " " . $reward->amount),
                new Text($reward->comment),
                new Text($reward->admin->fio),
            ];
        }
        $data = Helper::paginateArray($data);
        $filters[] = new DateFilter('date','Выбрать даты','--',[],'calendar');
        return view('reward.index',['reward' => $data,'filters' => $filters,'export_url' => route('rewards.download',\Illuminate\Support\Facades\Request::all())]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RewardRequest $request)
    {
        $data = $request->validated();
        $data['admin_id'] = auth()->user()->id;
        Reward::create($data);
        return redirect()->route('rewards.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function dloads()
    {
        $filters_params = \Illuminate\Support\Facades\Request::all();
        $dates = explode(',', $filters_params['date']);
        return Excel::download(new RewardExport($dates[0],$dates[1]), 'exportReward.xlsx');
    }
}
