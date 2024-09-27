<?php

namespace App\Http\Controllers;

use App\Models\TripPlan;
use Illuminate\Http\Request;

class TripPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = TripPlan::where('user_id', auth()->id())->get();
        return view('trip_plans.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trip_plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'country' => 'required',
            'city' => 'required',
        ]);

        TripPlan::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect()->route('trip_plans.index')->with('success', '旅行プランが作成されました！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trip = TripPlan::findOrFail($id);
        return view('trip_plans.show', compact('trip'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $trip = TripPlan::findOrFail($id);
        return view('trip_plans.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'country' => 'required',
            'city' => 'required',
        ]);

        $trip = TripPlan::findOrFail($id);
        $trip->update($validated);

        return redirect()->route('trip_plans.index')->with('success', '旅行プランが更新されました！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trip = TripPlan::findOrFail($id);
        $trip->delete();

        return redirect()->route('trip_plans.index')->with('success', '旅行プランが削除されました！');
    }
}