<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CreateUserController extends Controller
{
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        // validate data
        $rules = [
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'mobile' => 'required|string|unique:users|max:10|min:10',
            'email' => 'required|string|unique:users|email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ];

        // CHECK IF AN IMAGE FILE IS UPLOADED
        if ($request->hasFile('image')) {
            $rules['image'] = 'required|image|mimes:png,jpg,jpeg';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // save data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'type' => 'user',
            'password' => bcrypt($request->password),
        ]);
        // redirect after save
        return redirect()->route('user.create')->with('success', 'User created successfully');

    }
}
