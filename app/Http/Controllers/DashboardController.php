<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request) {
        $orders = (object) ['placed_orders' => 100, 'cancelled_orders' => 200, 'completed_orders' => 300, 'total_orders' => 600];
        $query = Doctor::query();

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('email') && !empty($request->email)) {
            $query->where('email', $request->email);
        }
        if ($request->has('mobile') && !empty($request->mobile)) {
            $query->where('mobile', $request->mobile);
        }

        $doctors = $query->paginate(10);
        return view('dashboard', compact('orders', 'doctors'));
    }
}
