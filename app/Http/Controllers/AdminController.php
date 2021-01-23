<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->post('email'));
        if ($request->post('email') == "admin@gmail.com" && $request->post('password') == "admin") {
            return redirect('/wisata');
        }
        return redirect('/');
    }
}
