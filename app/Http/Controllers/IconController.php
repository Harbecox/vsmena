<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IconController extends Controller
{
    function get($name)
    {
        $svg = "";
        $path = resource_path('icons/' . $name . '.svg');
        if (file_exists($path)) {
            $svg = file_get_contents($path);
        }
        return view('components.icon',['svg' => $svg]);
    }
}
