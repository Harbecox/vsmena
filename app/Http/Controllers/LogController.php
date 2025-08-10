<?php

namespace App\Http\Controllers;

use App\Enum\Role;
use App\Helpers\Helper;
use App\Models\Log;
use App\View\Components\DeleteModal;
use App\View\Components\Form\Table\Actions;
use App\View\Components\Form\Table\Text;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logs = Log::all();
        $data = [];
        foreach ($logs as $log) {
            $data[] = [
                new Text(Carbon::make($log->created_at)->format("Y-m-d H:i:s")),
                new Text($log->object),
                new Text($log->title),
                new Text($log->admin->fio),
            ];
        }
        $data = Helper::paginateArray($data);
        return view('logs.index',['logs' => $data]);
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
    public function store(Request $request)
    {
        //
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
}
