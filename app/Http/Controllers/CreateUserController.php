<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('type', 'user');

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('email') && !empty($request->email)) {
            $query->where('email', $request->email);
        }
        if ($request->has('mobile') && !empty($request->mobile)) {
            $query->where('mobile', $request->mobile);
        }

        $users = $query->paginate(10);
        return view('admin.user.index', compact('users'));
    }

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
        // image upload
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileExtension = $imageFile->getClientOriginalExtension();
            $customFilename = Str::random(40);
            $imageFile->storeAs('public/profile_pic', $customFilename . '.' . $fileExtension);
        }

        // save data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'mobile' => $request->mobile,
            'type' => 'user',
            'password' => bcrypt($request->password),
            'image' => $request->hasFile('image') ? $customFilename . '.' . $fileExtension : 'profile_pic.png',
        ]);
        // redirect after save
        return redirect()->route('user.create')->with('success', 'User created successfully');
    }

    public function edit(Request $request, $user_id)
    {
        try {
            $user_id = decrypt($user_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid User ID!');
        }
        $user = User::find($user_id);

        $userPermissions = json_decode($user->permissions, true);

        return view('admin.user.edit', compact('user', 'userPermissions'));
    }

    public function update(Request $request)
    {
        // validate data
        $rules = [
            'name' => 'required|string',
            'mobile' => 'required|string|min:10',
            'email' => 'required|string|email',
        ];

        if (!empty($request->password)) {
            $rules['password'] = 'required|string|min:8';
        }

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

        try {
            $user_id = decrypt($request->user_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid User ID!');
        }

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileExtension = $imageFile->getClientOriginalExtension();
            $customFilename = Str::random(40);
            $imageFile->storeAs('public/profile_pic', $customFilename . '.' . $fileExtension);
        }

        $user = User::find($user_id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        if ($request->hasFile('image')) {
            $user->profile_pic = $customFilename . '.' . $fileExtension;
        }

        $user->save();

        return redirect()->route('user.edit', $request->user_id)->with('success', 'User updated successfully');
    }


    public function permission(Request $request)
    {
        try {
            $user_id = decrypt($request->user_id);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            return back()->with('error', 'Invalid User ID!');
        }

        $permission = $request->except(['_token', 'user_id']);
        $permission = array_keys($permission);
        $permission = json_encode($permission);

        $user = User::find($user_id);
        $user->permissions = $permission;
        $user->save();
     
        return redirect()->route('user.edit', $request->user_id)->with('success', 'User permissions updated successfully');

    }
}
