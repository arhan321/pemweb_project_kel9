<?php

namespace App\Http\Controllers\Admin;

use App\Charts\adminchart;
use App\Charts\adminchartareachart;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(adminchart $chart, adminchartareachart $chartArea)
    {
        return view('home', [
            'chart' => $chart->build(),
            'chartArea' => $chartArea->build()
        ]);
    }
}
