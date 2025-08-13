<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        if(auth()->user()){
            if(auth()->user()->role == 'b'){
                return redirect()->route('reports.index');
            }else{
                return redirect()->route('events.index');
            }
        }else{
            return redirect()->route('login');
        }


    }

    public function policy()
    {
        return view("policy");
    }

}
