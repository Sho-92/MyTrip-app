<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripList;
use App\Models\TripPlan;class TripListController extends Controller
{
    public function index($tripPlanId)
    {
        $tripLists = TripList::where('trip_plan_id', $tripPlanId)->get();

        return view('trip_lists.index', compact('tripLists', 'tripPlanId'));
    }

    public function create($tripPlanId)
    {
        $tripPlan = TripPlan::findOrFail($tripPlanId);

        return view('trip_lists.create', compact('tripPlan'));
    }

    public function store(Request $request, $tripPlanId)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'destination' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        $tripPlan = TripPlan::findOrFail($tripPlanId);

        $tripList = new TripList($request->all());
        $tripList->trip_plan_id = $tripPlanId;
        $tripList->save();

        return redirect()->route('trip_plans.show', $tripPlanId)
                         ->with('success', 'created a new schedule.');
    }

    public function show($tripPlanId, $id)
    {
        $tripPlan = TripPlan::findOrFail($tripPlanId);
        $tripList = $tripPlan->tripLists()->where('id', $id)->firstOrFail();

        return view('trip_lists.show', compact('tripPlan', 'tripList'));
    }

    public function edit($tripPlanId, $id)
    {
        $tripPlan = TripPlan::findOrFail($tripPlanId);
        $tripList = TripList::where('trip_plan_id', $tripPlanId)->findOrFail($id);

        return view('trip_lists.edit', compact('tripPlan', 'tripList'));
    }

    public function update(Request $request, $tripPlanId, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'destination' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
        ]);

        $tripPlan = TripPlan::findOrFail($tripPlanId);
        $tripList = $tripPlan->tripLists()->findOrFail($id);

        $tripList->update([
            'date' => $request->input('date'),
            'destination' => $request->input('destination'),
            'notes' => $request->input('notes'),
            'start_time' => $request->input('start_time'),
            'end_time' => $request->input('end_time'),

        ]);

        return redirect()->route('trip_plans.show', $tripPlan->id)
                     ->with('success', 'Schedule updated successfully.');
    }

    public function destroy($tripPlanId, $tripListId)
    {
        $tripPlan = TripPlan::findOrFail($tripPlanId);
        $tripList = $tripPlan->tripLists()->findOrFail($tripListId);

        $tripList->delete();

        return redirect()->route('trip_plans.show', $tripPlanId)
                        ->with('success', 'Schedule deleted successfully.');
    }

    public function indexByTripPlan($tripPlanId)
    {
        $tripPlan = TripPlan::with('tripLists')->findOrFail($tripPlanId);
        $tripLists = $tripPlan->tripLists;
        return view('trip_lists.index', compact('tripPlan', 'tripLists'));
    }
}