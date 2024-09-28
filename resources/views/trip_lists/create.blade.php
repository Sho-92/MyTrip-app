@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1>{{ $tripPlan->title }} create a Schdele</h1>

    <form action="{{ route('trip_lists.store', $tripPlan->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" id="date" name="date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="form-control" value="{{ old('start_time') }}">
        </div>

        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" class="form-control" value="{{ old('end_time') }}">
        </div>

        <div class="form-group">
            <label for="destination">Destination</label>
            <input type="text" id="destination" name="destination" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="notes">Memo</label>
            <textarea id="notes" name="notes" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    <a href="{{ route('trip_plans.show', $tripPlan->id) }}" class="btn btn-secondary">Back to Trip Plans</a>

@endsection
