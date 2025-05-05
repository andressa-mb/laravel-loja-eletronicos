<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function indexAdm(){
        return view('indexAdm');
    }

    public function indexBuyer(){
        return view('indexBuyer');
    }
    public function indexProfile(Request $request)
    {
        return view('profile.index', ['user' => $request->user()]);
    }
}
