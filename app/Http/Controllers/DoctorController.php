<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class DoctorController extends Controller
{
    public function index(Request $request)
    {
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

        return view('admin.doctor.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctor.create');
    }

    public function store(Request $request)
    {
        // validate data
        $rules = [
            'name' => 'required|string',
            'address' => 'string',
            'gender' => 'required|string',
            'hospital_name' => 'required|string',
            'specialization' => 'required|string',
            'mobile' => 'required|string|unique:doctors|max:10|min:10',
            'email' => 'required|string|unique:doctors|email',
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
        Doctor::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'gender' => $request->gender,
            'address' => $request->address,
            'hospital_name' => $request->hospital_name,
            'specialization' => $request->specialization,
            'profile_pic' => $request->hasFile('profile_pic') ? $customFilename . '.' . $fileExtension : 'profile_pic.png',
        ]);
        // redirect after save
        return redirect()->route('doctor.create')->with('success', 'Doctor created successfully');
    }

    public function edit(Request $request, $doctor_id)
    {
        try {
            $doctor_id = decrypt($doctor_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid doctor ID!');
        }
        $doctor = Doctor::find($doctor_id);
        return view('admin.doctor.edit', compact('doctor'));
    }

    public function update(Request $request)
    {
        // validate data
        $rules = [
            'name' => 'required|string',
            'address' => 'string',
            'gender' => 'required|string',
            'hospital_name' => 'required|string',
            'specialization' => 'required|string',
            'mobile' => 'required|string|max:10|min:10',
            'email' => 'required|string|email',
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
            return back()->with('error', 'Invalid User ID!');
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
        // redirect after save
        return redirect()->route('doctor.edit', $request->doctor_id)->with('success', 'Doctor updated successfully');
    }
}
