<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripPlan;

class HomeController extends Controller
{
    public function index()
    {
        $trips = TripPlan::where('user_id', auth()->id())->get(); // ユーザーの旅行プランを取得
        return view('home', compact('trips')); // trips 変数をビューに渡す
    }

}