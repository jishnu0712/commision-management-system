<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        $query = Department::query();
        if ($request->has('dept_name') && !empty($request->dept_name)) {
            $query->where('dept_name', 'like', '%' . $request->dept_name . '%');
        }
        $departments = $query->get();
        return view('admin.department.index', compact('departments'));
    }
    public function create()
    {
        return view('admin.department.create');
    }

    public function store(Request $request)
    {
        // validate data
        $rules = [
            'dept_name' => 'required|string',
            'description' => 'required|string',
            'percentage' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // save data
        Department::create([
            'dept_name' => $request->dept_name,
            'description' => $request->description,
            'percentage' => $request->percentage,
        ]);
        // redirect after save
        return redirect()->route('department.create')->with('success', 'Department created successfully');
    }

    public function edit(Request $request, $department_id)
    {
        try {
            $department_id = decrypt($department_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid User ID!');
        }
        $department = Department::find($department_id);
        return view('admin.department.edit', compact('department'));
    }

    public function update(Request $request)
    {
        // validate data
        $rules = [
            'dept_name' => 'required|string',
            'percentage' => 'required',
            'description' => 'required|string',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $department_id = decrypt($request->department_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid Department ID!');
        }

        $dept = Department::find($department_id);
        $dept->dept_name = $request->dept_name;
        $dept->percentage = $request->percentage;
        $dept->description = $request->description;
        $dept->save();

        return redirect()->route('department.edit', $request->department_id)->with('success', 'Department updated successfully');
    }

    public function delete(Request $request)
    {
        try {
            $dept_id = decrypt($request->dept_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['status' => 'error', 'msg' => 'Invalid Department!']);
        }
        $user = Department::find($dept_id);
        $user->delete();
        return response()->json(['status' => 'success', 'msg' => 'Department deleted successfully']);
    }
}
