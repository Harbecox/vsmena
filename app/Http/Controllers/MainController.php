<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            if (auth()->user()->role === "m")
                return redirect('/logs');
            elseif (auth()->user()->role === "e")
                return redirect('/events');
            elseif (auth()->user()->role === "a")
                return redirect('/eventscustomer');
            elseif (auth()->user()->role === "b")
                return redirect('/booker');
        } else {
            return redirect('/login');
        }
        //return view("main");
    }

    public function policy()
    {
        return view("policy");
    }

}
