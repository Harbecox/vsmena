<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return redirect()->route('events.index');
    }

    public function policy()
    {
        return view("policy");
    }

}
