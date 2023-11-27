<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Percentage;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function create()
    {
        $doctors = Doctor::all();
        return view('admin.transaction.create', compact('doctors'));
    }

    public function department(Request $request)
    {
        $doctor_id = $request->doctor_id;

        $percentages = Percentage::where('doctor_id', $doctor_id)->with('department')->with('department.percentage')->get();

        return view('admin.department.dropdown', compact('percentages'));
    }

    public function store(Request $request)
    {
        $bill = new Bill();
        $bill->bill_no = $request->bill_no;
        $bill->bill_date = $request->bill_date;
        $bill->doctor_id = $request->doctor_id;
        if ($bill->save()) {
            $bill_id = $bill->id;

            // ADD TRANSACTION
            $transactions = [];

            foreach ($request->department as $index => $dept) {
                $transactions[] = [
                    'dept_id' => $dept,
                    'bill_id' => $bill_id,
                    'amount' => $request->amount[$index],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Transaction::insert($transactions);
        }

        return redirect()->route('transaction.create')->with('success', 'Transaction saved successfully');
    }
}
