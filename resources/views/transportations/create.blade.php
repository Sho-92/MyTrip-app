@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <div class="container">
        <h1 class="display-4 text-center">Create a New Transportation</h1>

        <div class="container border border-dark p-4" style="width: 80%; max-width: 800px; margin-bottom: 50px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">
            <div class="border border-dark p-4" style="color: #000000;">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('transportations.store', ['trip_plan' => $tripPlanId]) }}" method="POST">
                    @csrf

                    <input type="hidden" name="trip_plan_id" value="{{ $tripPlanId }}">

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="departure_time">Departure Time</label>
                        <input type="time" id="departure_time" name="departure_time" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="arrival_time">Arrival Time (optional)</label>
                        <input type="time" id="arrival_time" name="arrival_time" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="departure_location">Departure Location</label>
                        <input type="text" id="departure_location" name="departure_location" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="arrival_location">Arrival Location</label>
                        <input type="text" id="arrival_location" name="arrival_location" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="transportation_mode">Mode of Transportation</label>
                        <select id="transportation_mode" name="transportation_mode" class="form-control" required>
                            <option value="plane">Plane</option>
                            <option value="train">Train</option>
                            <option value="bus">Bus</option>
                            <option value="car">Car</option>
                            <option value="bicycle">Bicycle</option>
                            <option value="walking">Walking</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes (optional)</label>
                        <textarea id="notes" name="notes" class="form-control" rows="4"></textarea>
                    </div><br>

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary mx-2" onclick="window.location.href='{{ route('trip_plans.show', $tripPlan->id) }}'">
                            <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
                        </button>

                        <button type="submit" class="btn btn-primary mx-2"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
