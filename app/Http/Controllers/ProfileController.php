<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        $userPermissions = json_decode($user->permissions, true);
        return view('admin.profile.index', compact('user', 'userPermissions'));
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

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $fileExtension = $imageFile->getClientOriginalExtension();
            $customFilename = Str::random(40);
            $imageFile->storeAs('public/profile_pic', $customFilename . '.' . $fileExtension);
        }

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        if ($request->hasFile('image')) {
            $user->profile_pic = $customFilename . '.' . $fileExtension;
        }
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }
}
