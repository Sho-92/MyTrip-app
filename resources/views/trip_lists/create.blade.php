@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1 class="display-4 text-center">Create a New Schdele</h1>

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
                </div><br>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary  mx-2" onclick="window.location.href='{{ route('trip_plans.show', $tripPlan->id) }}'">
                        <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
                    </button>

                    <button type="submit" class="btn btn-primary mx-2">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
