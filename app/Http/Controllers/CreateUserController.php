<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    public function create() {
        return view('admin.user.create');
    }

    public function store(Request $request) {
        return dd($request->all());
    }
}
