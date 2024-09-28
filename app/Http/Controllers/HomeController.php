<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripPlan;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tripPlans = TripPlan::all();
        return view('home', compact('tripPlans'));
    }

}