<?php

namespace App\Http\Controllers;

use App\CustomHelper\CustomHelper;
use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorPayment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

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

        $departments = DB::table('departments')
            ->leftJoin('percentages', function ($join) use ($doctor_id) {
                $join->on('departments.id', '=', 'percentages.dept_id')
                    ->where('percentages.doctor_id', '=', $doctor_id);
            })
            ->select(
                'departments.id as department_id',
                'departments.dept_name',
                DB::raw('CASE WHEN percentages.percentage IS NOT NULL THEN percentages.percentage ELSE departments.percentage END as percentage')
            )
            ->get();
        return view('admin.department.dropdown', compact('departments'));
    }

    public function store(Request $request)
    {
        $doctor_id = $request->doctor_id;
        $bill = new Bill();
        $bill->bill_no = $request->bill_no;
        $bill->patient_name = $request->patient_name;
        $bill->bill_date = $request->bill_date;
        $bill->doctor_id = $request->doctor_id;
        if ($bill->save()) {
            $bill_id = $bill->id;

            // ADD TRANSACTION
            $transactions = [];

            foreach ($request->department as $index => $dept_id) {
                $percentage = DB::table('departments')
                    ->leftJoin('percentages', function ($join) use ($doctor_id, $dept_id) {
                        $join->on('departments.id', '=', 'percentages.dept_id')
                            ->where('percentages.doctor_id', '=', $doctor_id);
                    })
                    ->select(
                        'departments.id as department_id',
                        'departments.dept_name',
                        DB::raw('CASE WHEN percentages.percentage IS NOT NULL THEN percentages.percentage ELSE departments.percentage END as percentage')
                    )->where('departments.id', $dept_id)
                    ->first();

                $transactions[] = [
                    'dept_id' => $dept_id,
                    'bill_id' => $bill_id,
                    'amount' => $request->amount[$index],
                    'percentage' => $percentage->percentage,
                    'commission' => ($request->amount[$index] * $percentage->percentage) / 100,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Transaction::insert($transactions);
        }

        return redirect()->route('transaction.create')->with('success', 'Transaction saved successfully');
    }

    public function view(Request $request, $doctor_id)
    {
        // Get all transaction details using doctor_id

        try {
            $doctor_id = decrypt($doctor_id);
            $doctor = Doctor::find($doctor_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid Doctor ID!');
        }

        // get 12 months revenue, grouped by month
        if ($request->has('month') && !empty($request->month)) {
            $currentMonth = CustomHelper::dateFormat('m', $request->month);
            $currentYear = CustomHelper::dateFormat('Y', $request->month);
        } else {
            $currentYear = date('Y');
            $currentMonth = date('m');
        }


        $transactions = Transaction::select(
            DB::raw('SUM(transactions.amount) as total_amount'),
            DB::raw('SUM(transactions.commission) as commission'),
            DB::raw('MONTHNAME(bills.bill_date) as month'),
            DB::raw('DATE_FORMAT(bills.bill_date, "%Y-%m")  as month_year'),
        )
            ->leftJoin('bills', 'bills.id', '=', 'transactions.bill_id')
            ->where('bills.doctor_id', $doctor_id)
            ->whereYear('bills.bill_date', $currentYear)
            ->groupBy(DB::raw('MONTHNAME(bills.bill_date)'))
            ->groupBy('bills.bill_date')
            ->orderBy(DB::raw('MONTH(bills.bill_date)'))
            ->get();

        $commissions = $transactions->pluck('commission')->all();
        $commissions = json_encode($commissions);

        $totalAmount = $transactions->pluck('total_amount')->all();
        $totalAmount = json_encode($totalAmount);

        $months = $transactions->pluck('month')->all();
        $months = json_encode($months);


        // CHECK IS PAYMENT
        $payments = DoctorPayment::where('doctor_id', $doctor_id)->where('year', $currentYear);
        $payments = $payments->pluck('month')->all();

        // DEPARTMRNT WISE CHART DATA
        $transactionsDept = Transaction::select(
            DB::raw('SUM(transactions.amount) as total_amount'),
            DB::raw('SUM(transactions.commission) as commission'),
            DB::raw('departments.dept_name'),
        )
            ->leftJoin('bills', 'bills.id', '=', 'transactions.bill_id')
            ->leftJoin('departments', 'departments.id', '=', 'transactions.dept_id')
            ->where('bills.doctor_id', $doctor_id)
            ->whereYear('bills.bill_date', $currentYear)
            ->whereMonth('bills.bill_date', $currentMonth)
            // ->groupBy(DB::raw('MONTHNAME(bills.bill_date)'))
            ->groupBy('departments.dept_name')
            ->orderBy(DB::raw('MONTH(bills.bill_date)'))
            ->get();
        $commissionsDept = $transactionsDept->pluck('commission')->all();
        $commissionsDept = json_encode($commissionsDept);

        $totalAmountDept = $transactionsDept->pluck('total_amount')->all();
        $totalAmountDept = json_encode($totalAmountDept);

        $deptName = $transactionsDept->pluck('dept_name')->all();
        $deptName = json_encode($deptName);

        
        return view('admin.transaction.view', compact('payments', 'transactions', 'doctor', 'commissions', 'months', 'totalAmount', 'commissionsDept', 'totalAmountDept', 'deptName', 'currentYear', 'currentMonth'));
    }

    public function invoice(Request $request)
    {
        if ($request->has('month') && !empty($request->month)) {
            $month = CustomHelper::dateFormat('m', $request->month);
            $year = CustomHelper::dateFormat('Y', $request->month);
        } else {
            $month = date('m');
            $year = date('Y');
        }

        $invoices = Doctor::has('bill')
            ->with(['bill' => function ($query) use ($month, $year) {
                $query->has('transaction.department')
                    ->whereMonth('bill_date', $month)
                    ->whereYear('bill_date', $year);
            }])
            ->get();


        $newMonth = CustomHelper::dateFormat('F', $year . '-' . $month);

        return view('admin.transaction.invoices', compact('invoices', 'newMonth', 'year', 'month'));
    }

    public function download(Request $request)
    {
        // Get all transaction details using doctor_id
        if ($request->has('month') && !empty($request->month)) {
            $month = CustomHelper::dateFormat('m', $request->month);
            $year = CustomHelper::dateFormat('Y', $request->month);
        } else {
            $month = date('m');
            $year = date('Y');
        }

        $invoices = Doctor::has('bill')
            ->with(['bill' => function ($query) use ($month, $year) {
                $query->with('transaction.department')
                    ->whereMonth('bill_date', $month)
                    ->whereYear('bill_date', $year);
            }])
            ->get();
        $newMonth = CustomHelper::dateFormat('F', $year . '-' . $month);

        // return a download file
        $data = [
            'invoices' => $invoices,
            'newMonth' => $newMonth,
            'year' => $year,
            'month' => $month
        ];
        return view('pdf.template', $data);
        // $pdf = PDF::loadView('pdf.template', $data);

        // return $pdf->download('All_inovoices.pdf');
    }

    public function edit(Request $request)
    {
        if ($request->has('month') && !empty($request->month)) {
            $month = CustomHelper::dateFormat('m', $request->month);
            $year = CustomHelper::dateFormat('Y', $request->month);
        } else {
            $month = date('m');
            $year = date('Y');
        }

        $invoices = Doctor::has('bill')
            ->with(['bill' => function ($query) use ($month, $year) {
                $query->has('transaction.department')
                    ->whereMonth('bill_date', $month)
                    ->whereYear('bill_date', $year);
            }])
            ->get();


        $newMonth = CustomHelper::dateFormat('F', $year . '-' . $month);

        return view('admin.transaction.edit', compact('invoices', 'newMonth', 'year', 'month'));
    }

    public function update(Request $request)
    {
        $transaction = Transaction::find($request->id);
        if (!$transaction) {
            return response()->json(["status" => 'error', "msg" => 'Transaction not found!']);
        }
        $transaction->amount = $request->value;
        $transaction->commission = ($request->value * $transaction->percentage) / 100;
        $transaction->save();

        return response()->json(["status" => 'success', "msg" => 'Transaction updated successfully.']);
    }

    public function delete(Request $request)
    {
        $transaction = Transaction::find($request->deleteid);
        if (!$transaction) {
            return response()->json(["status" => 'error', "msg" => 'Transaction not found!']);
        }
        $transaction->delete();
        return response()->json(["status" => 'success', "msg" => 'Transaction deleted successfully.']);
    }
}
