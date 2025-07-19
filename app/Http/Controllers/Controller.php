<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public $isMobile = false;
    public $parentView;
    public function __construct()
    {
        $userAgent = strtolower(request()->header("User-Agent"));
        if (preg_match("/phone|iphone|itouch|ipod|symbian|android|htc_|" .
            "htc-|palmos|blackberry|opera mini|iemobile|windows ce|nokia|" .
            "fennec|hiptop|kindle|mot |mot-|webos\/|samsung|sonyericsson|" .
            "^sie-|nintendo/", $userAgent)) {
            $this->isMobile = true;
        } else {
            if (preg_match("/mobile|pda;|avantgo|eudoraweb|minimo|netfront|" .
                "brew|teleca|lg;|lge |wap;| wap /", $userAgent)) {
                $this->isMobile = true;
            }
        }
        if ($this->isMobile) {
            $this->parentView = "layouts.pc";
        } else {
            $this->parentView = "layouts.pc";
        }

    }
}
