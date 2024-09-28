<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripPlan;
use Carbon\Carbon;

class TripPlanController extends Controller
{

    public function index()
    {

    }


    public function create()
    {
        return view('trip_plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        TripPlan::create($request->all());

        return redirect()->route('home')->with('success', 'Your request was successful');
    }

    public function show($id)
    {
         // 該当の旅行プランを取得し、そのプランに紐づくリストを一緒に取得
        $tripPlan = TripPlan::with(['tripLists', 'transportations'])->findOrFail($id);

        //, 'transportations',  'accommodations'

        return view('trip_plans.show',[
            'tripPlan' => $tripPlan,
            'tripLists' => $tripPlan->tripLists,
            'transportations' => $tripPlan->transportations,
            'accommodations' => $tripPlan->accommodations,
        ]);

    }

    public function edit($id)
    {
        $tripPlan = TripPlan::findOrFail((int)$id);
        return view('trip_plans.edit', compact('tripPlan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $tripPlan = TripPlan::findOrFail((int)$id);
        $tripPlan->update([
            'title' => $request->input('title'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'country' => $request->input('country'),
            'city' => $request->input('city'),
        ]);

        return redirect()->route('trip_plans.show', $tripPlan->id)->with('success', 'Your travel plan has been updated.');
    }

    public function destroy($id)
    {

        $tripPlan = TripPlan::findOrFail((int)$id);
        $tripPlan->delete();

        return redirect()->route('home')->with('success', 'Your travel plan has been deleted.');
    }


    //public function events(){}

}