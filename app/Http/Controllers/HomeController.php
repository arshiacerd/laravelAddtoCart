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
    public function index()
    {
        $role = auth()->user()->is_admin;
        if($role==1){

            return view('admin.dashboard');
        }
        else{
            return view('user');
            
        }
    }
    public function addprod(){
        return view('admin.add');
    
    }
    // public function showprod(){
     
    
    // }
}
