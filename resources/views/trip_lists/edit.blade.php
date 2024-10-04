@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
<div class="container">
    <h1 class="display-4 text-center">Edit Schedule</h1>

    <div class="container p-4" style="max-width: 600px; margin-left: auto; margin-right: auto;">
        <div class="border border-dark p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('trip_lists.update', [$tripPlan->id, $tripList->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $tripList->date) }}" required>
                </div>

                <div class="form-group">
                    <label for="start_time">Start Time</label>
                    <input type="time" id="start_time" name="start_time" class="form-control" value="{{ old('start_time', $tripList->start_time) }}">
                </div>

                <div class="form-group">
                    <label for="end_time">End Time</label>
                    <input type="time" id="end_time" name="end_time" class="form-control" value="{{ old('end_time', $tripList->end_time) }}">
                </div>

                <div class="form-group">
                    <label for="destination">Destination</label>
                    <input type="text" id="destination" name="destination" class="form-control" value="{{ old('destination', $tripList->destination) }}" required>
                </div>

                <div class="form-group">
                    <label for="notes">Memo</label>
                    <textarea id="notes" name="notes" class="form-control">{{ old('notes', $tripList->notes) }}</textarea>
                </div><br>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary  mx-2" onclick="window.history.back()">
                        ← back
                    </button>

                    <button type="submit" class="btn btn-primary mx-2">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
