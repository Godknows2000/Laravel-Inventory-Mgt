<?php

namespace App\Http\Controllers;

use App\Models\Product;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class DashboardController extends Controller
{
    public function index()
    {
      $products = Product::all();
        return view('home',compact('products'));
    }
}
