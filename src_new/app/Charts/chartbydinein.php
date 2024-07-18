<?php

namespace App\Charts;

use App\Models\OrderDitempat;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class chartbydinein
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        $monthlyRevenue = OrderDitempat::getMonthlyRevenue();
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        $revenueData = [];
        foreach ($months as $index => $month) {
            $revenueData[] = $monthlyRevenue->get($index + 1, 0);
        }

        return $this->chart->lineChart()
            ->setTitle('Monthly Dine-in Revenue')
            ->setSubtitle('Total revenue per month')
            ->addData('Dine-in Revenue', $revenueData)
            ->setXAxis($months);
    }
}
