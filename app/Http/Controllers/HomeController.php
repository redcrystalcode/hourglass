<?php

namespace Hourglass\Http\Controllers;

use Hourglass\Http\Requests;
use Hourglass\Models\Employee;
use Hourglass\Models\Location;
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = \Auth::user();
        $employees = Employee::whereAccountId($user->account_id)->get();
        $locations = Location::whereAccountId($user->account_id)->get();
        return view('home', compact('employees', 'locations'));
    }
}
