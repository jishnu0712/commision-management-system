<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\DoctorPayment;
use App\Models\Percentage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();

        if ($request->has('doctor_name') && !empty($request->doctor_name)) {
            $query->where('name', 'like', '%' . $request->doctor_name . '%');
        }
        if ($request->has('hospital_name') && !empty($request->hospital_name)) {
            $query->where('hospital_name', 'like', '%' . $request->hospital_name . '%');
        }
        if ($request->has('email') && !empty($request->email)) {
            $query->where('email', $request->email);
        }
        if ($request->has('mobile') && !empty($request->mobile)) {
            $query->where('mobile', $request->mobile);
        }

        $doctors = $query->get();

        return view('admin.doctor.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.doctor.create', compact('departments'));
    }

    public function store(Request $request)
    {
        // validate data
        $rules = [
            'name' => 'required|string',
            'address' => 'string',
            'mobile' => 'required|string|unique:doctors|max:10|min:10',
        ];

        // CHECK IF AN IMAGE FILE IS UPLOADED
        if ($request->hasFile('profile_pic')) {
            $rules['profile_pic'] = 'required|image|mimes:png,jpg,jpeg';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // image upload
        if ($request->hasFile('profile_pic')) {
            $imageFile = $request->file('profile_pic');
            $fileExtension = $imageFile->getClientOriginalExtension();
            $customFilename = Str::random(40);
            $imageFile->storeAs('public/doctors/profile_pic', $customFilename . '.' . $fileExtension);
        }

        // save data
        $doctor = Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gender' => $request->gender,
            'address' => $request->address,
            'hospital_name' => $request->hospital_name,
            'specialization' => $request->specialization,
            'profile_pic' => $request->hasFile('profile_pic') ? $customFilename . '.' . $fileExtension : 'profile_pic.png',
        ]);

        $doctor_id = $doctor->id;
        $percentageData = [];
        $dateTime = date('Y-m-d H:i:s');
        foreach ($request->percentage as $department_id => $value) {
            $tempArr = [];
            $tempArr['doctor_id'] = $doctor_id;
            $tempArr['dept_id'] = $department_id;
            $tempArr['percentage'] = $value;
            $tempArr['created_at'] = $dateTime;
            $tempArr['updated_at'] = $dateTime;
            $percentageData[] = $tempArr;
        }

        Percentage::insert($percentageData);

        // redirect after save
        return redirect()->route('doctor.create')->with('success', 'Doctor created successfully');
    }

    public function edit(Request $request, $doctor_id)
    {
        try {
            $doctor_id = decrypt($doctor_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid Doctor ID!');
        }

        try {
            $this->syncDepartment($doctor_id);
            $doctor = Doctor::find($doctor_id);
            $percentages = Percentage::where('doctor_id', $doctor_id)->with('department')->with('department.percentage')->get();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('admin.doctor.edit', compact('doctor', 'percentages'));
    }

    public function update(Request $request)
    {
        // validate data
        $rules = [
            'name' => 'required|string',
            'address' => 'string',
            'mobile' => 'required|string|max:10|min:10',
        ];

        // CHECK IF AN IMAGE FILE IS UPLOADED
        if ($request->hasFile('profile_pic')) {
            $rules['profile_pic'] = 'required|image|mimes:png,jpg,jpeg';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $doctor_id = decrypt($request->doctor_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid Doctor ID!');
        }

        // image upload
        if ($request->hasFile('profile_pic')) {
            $imageFile = $request->file('profile_pic');
            $fileExtension = $imageFile->getClientOriginalExtension();
            $customFilename = Str::random(40);
            $imageFile->storeAs('public/doctors/profile_pic', $customFilename . '.' . $fileExtension);
        }
        // update
        $doctor = Doctor::find($doctor_id);
        $doctor->name = $request->name;
        $doctor->email = $request->email;
        $doctor->mobile = $request->mobile;
        $doctor->gender = $request->gender;
        $doctor->address = $request->address;
        $doctor->hospital_name = $request->hospital_name;
        $doctor->specialization = $request->specialization;
        if ($request->hasFile('profile_pic')) {
            $doctor->profile_pic = $customFilename . '.' . $fileExtension;
        }
        $doctor->save();

        foreach ($request->percentage as $percentage_id => $value) {
            $percentage = Percentage::find($percentage_id);
            $percentage->percentage = $value;
            $percentage->save();
        }
        // redirect after save
        return redirect()->route('doctor.edit', $request->doctor_id)->with('success', 'Doctor updated successfully');
    }

    public function syncDepartment($doctor_id)
    {

        $percentageDept = Percentage::where('doctor_id', $doctor_id)->pluck('dept_id')->toArray();

        $departments = Department::whereNotIn('id', $percentageDept)->get();
        foreach ($departments as $department) {
            $percentage = new Percentage();
            $percentage->doctor_id = $doctor_id;
            $percentage->dept_id = $department->id;
            $percentage->percentage = 0;
            $percentage->save();
        }
    }

    public function payment(Request $request)
    {
        $payment = new DoctorPayment();
        $payment->doctor_id = $request->doctor_id;
        $payment->year = date('Y', strtotime($request->month_year));
        $payment->month = date('m', strtotime($request->month_year));
        $payment->save();
        return response()->json(['status' => 'success', 'msg' => 'Payment completed successfully.']);
    }

    public function delete(Request $request)
    {
        try {
            $doctor = decrypt($request->doctor);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return response()->json(['status' => 'error', 'msg' => 'Invalid Doctor!']);
        }
        $user = Doctor::find($doctor);
        $user->delete();
        return response()->json(['status' => 'success', 'msg' => 'Doctor deleted successfully']);
    }
}
