<?php

namespace App\Http\Controllers\Admin;
use App\Charts\adminchart;
class HomeController
{
    public function index(adminchart $chart)
    {
        return view('home', ['chart' => $chart->build()]);
    }
}
