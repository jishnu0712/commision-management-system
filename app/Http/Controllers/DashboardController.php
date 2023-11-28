<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
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

        $monthsArr = [];
        $commissionsArr = [];
        $currentYear = date('Y');

        foreach ($doctors as $doctor) {
            $transactions = $this->getRevenueCommission($currentYear, $doctor->id);

            $commissions = $transactions->pluck('commission')->all();
            $commissions = json_encode($commissions);
            $months = $transactions->pluck('month')->all();
            $months = json_encode($months);

            $monthsArr[$doctor->id] = $months;
            $commissionsArr[$doctor->id] = $commissions;
        }

        //BAR CHART DATA
        $revenueCommission = $this->getRevenueCommission($currentYear);

        $BarChartCommissions = $revenueCommission->pluck('commission')->all();
        $BarChartCommissions = json_encode($BarChartCommissions);

        $BarChartTotal = $revenueCommission->pluck('total_amount')->all();
        $BarChartTotal = json_encode($BarChartTotal);

        $BarChartMonths = $revenueCommission->pluck('month')->all();
        $BarChartMonths = json_encode($BarChartMonths);

        // GET CURRENT YEAR REVENUE AND COMMISSION
        return view('dashboard', compact('orders', 'doctors', 'monthsArr', 'commissionsArr', 'BarChartCommissions', 'BarChartTotal', 'BarChartMonths'));
    }

    public function getRevenueCommission($currentYear, $doctor_id = false)
    {
        $transactions = Transaction::select(
            DB::raw('SUM(transactions.amount) as total_amount'),
            DB::raw('SUM(transactions.commission) as commission'),
            DB::raw('MONTHNAME(bills.bill_date) as month')
        )
            ->leftJoin('bills', 'bills.id', '=', 'transactions.bill_id');

        if ($doctor_id) {
            $transactions->where('bills.doctor_id', $doctor_id);
        }

        $transactions = $transactions->whereYear('bills.bill_date', $currentYear)
            ->groupBy(DB::raw('MONTHNAME(bills.bill_date)'))
            ->orderBy(DB::raw('MONTH(bills.bill_date)'))
            ->get();

        return $transactions;
    }
}
