<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $orders = (object) ['placed_orders' => 100, 'cancelled_orders' => 200, 'completed_orders' => 300, 'total_orders' => 600];
        return view('dashboard', compact('orders'));
    }
}
