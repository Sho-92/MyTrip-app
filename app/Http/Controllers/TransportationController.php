<?php

namespace App\Http\Controllers;

use App\Models\Transportation;
use App\Models\TripPlan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TransportationController extends Controller
{
    public function index(): View
    {
        $transportations = Transportation::all();
        return view('transportations.index', compact('transportations'));
    }

    public function create($tripPlanId):View
    {
        $tripPlan = TripPlan::findOrFail($tripPlanId);

        return view('transportations.create', [
            'tripPlan' => $tripPlan,
            'tripPlanId' => $tripPlanId
        ]);
    }

     public function store(Request $request): RedirectResponse
     {
         $validated = $request->validate([
             'trip_plan_id' => 'required|exists:trip_plans,id',
             'date' => 'required|date',
             'departure_time' => 'required',
             'arrival_time' => 'nullable',
             'departure_location' => 'required|string|max:255',
             'arrival_location' => 'required|string|max:255',
             'transportation_mode' => 'required|string',
             'notes' => 'nullable|string',
         ]);

         Transportation::create($validated);

         return redirect()->route('trip_plans.show', $request->trip_plan_id)
             ->with('success', 'Transportation added successfully!');
     }


    public function show(TripPlan $trip_plan, Transportation $transportation): View
    {
        return view('transportations.show', compact('transportation'));
    }

    public function edit($tripPlanId, $id): View
    {
        $transportation = Transportation::findOrFail($id);

        $tripPlan = TripPlan::findOrFail($tripPlanId);

        return view('transportations.edit', [
            'tripPlan' => $tripPlan,
            'transportation' => $transportation
        ]);
    }

    public function update(Request $request, $tripPlanId, Transportation $transportation): RedirectResponse
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'departure_time' => 'required|date_format:H:i',
            'arrival_time' => 'nullable|date_format:H:i',
            'departure_location' => 'required|string|max:255',
            'arrival_location' => 'required|string|max:255',
            'transportation_mode' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $transportation->update($validatedData);

        return redirect()->route('trip_plans.show', ['trip_plan' => $tripPlanId])
                         ->with('success', 'Transportation updated successfully.');
    }

        public function destroy($tripPlanId, Transportation $transportation): RedirectResponse
    {
        $transportation->delete();

        return redirect()->route('trip_plans.show', $tripPlanId)
                        ->with('success', 'Transportation deleted successfully.');

    }
}