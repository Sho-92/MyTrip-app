<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Accommodation;
use App\Models\TripPlan;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function index(TripPlan $trip_plan)
    {
        $accommodations = $trip_plan->accommodations()->get();
        return view('accommodations.index', compact('trip_plan', 'accommodations'));
    }

    public function create(TripPlan $trip_plan)
    {
        return view('accommodations.create', compact('trip_plan'));
    }

    public function store(Request $request, $tripPlanId)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|before_or_equal:check_out_date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'hotel_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Only if check-in date and check-out date are the same, check if check-in time is before check-out time
        if ($request->check_in_date == $request->check_out_date) {
            $checkIn = Carbon::createFromFormat('Y-m-d H:i', $request->check_in_date . ' ' . $request->check_in_time);
            $checkOut = Carbon::createFromFormat('Y-m-d H:i', $request->check_out_date . ' ' . $request->check_out_time);

            if ($checkIn >= $checkOut) {
                return back()->withErrors(['check_in_time' => 'Check-in time must be before check-out time for same day.']);
            }
        }

        // Save your property if it passes validation
        Accommodation::create([
            'trip_plan_id' => $tripPlanId,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'hotel_name' => $request->hotel_name,
            'address' => $request->address,
            'notes' => $request->notes,
        ]);


        return redirect()->route('trip_plans.show', $tripPlanId )->with('success', 'Added accommodations.');
    }

    public function show(TripPlan $trip_plan, Accommodation $accommodation)
    {
        return view('accommodations.show', compact('trip_plan', 'accommodation'));
    }

    public function edit(TripPlan $trip_plan, Accommodation $accommodation)
    {
        return view('accommodations.edit', compact('trip_plan', 'accommodation'));
    }


    public function update(Request $request, TripPlan $trip_plan, Accommodation $accommodation)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|before_or_equal:check_out_date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'hotel_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        if ($request->check_in_date == $request->check_out_date) {
            $checkIn = Carbon::createFromFormat('Y-m-d H:i', $request->check_in_date . ' ' . $request->check_in_time);
            $checkOut = Carbon::createFromFormat('Y-m-d H:i', $request->check_out_date . ' ' . $request->check_out_time);

            if ($checkIn >= $checkOut) {
                return back()->withErrors(['check_in_time' => 'Check-in time must be before check-out time for same day.']);
            }
        }

        $accommodation->update([
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'hotel_name' => $request->hotel_name,
            'address' => $request->address,
            'notes' => $request->notes,
        ]);

        return redirect()->route('trip_plans.show', $trip_plan)->with('success', 'Updated Accommodations.');
    }

    public function destroy(TripPlan $trip_plan, Accommodation $accommodation)
    {
        $accommodation->delete();
        return redirect()->route('trip_plans.show', $trip_plan)->with('success', 'Deleted Accommodations.');
    }

}