<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Percentage;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(){
        $doctors = Doctor::all();
        return view('admin.transaction.create', compact('doctors'));
    }

    public function department(Request $request) {
        $doctor_id = $request->doctor_id;

        $percentages = Percentage::where('doctor_id', $doctor_id)->with('department')->with('department.percentage')->get();

        return view('admin.department.dropdown', compact('percentages'));
    }
}
