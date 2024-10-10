@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
<div class="container">
    <h1 class="display-4 text-center">Create a New Accommodation</h1>

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

            <form action="{{ route('accommodations.store', $trip_plan) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="check_in_date" class="form-label">Check-in Date</label>
                    <input type="date" class="form-control" id="check_in_date" name="check_in_date" required>
                    @error('check_in_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="check_in_time" class="form-label">Check-in Time</label>
                    <input type="time" class="form-control" id="check_in_time" name="check_in_time" required>
                    @error('check_in_time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="check_out_date" class="form-label">Check-out Date</label>
                    <input type="date" class="form-control" id="check_out_date" name="check_out_date" required>
                    @error('check_out_date')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="check_out_time" class="form-label">Check-out Time</label>
                    <input type="time" class="form-control" id="check_out_time" name="check_out_time" required>
                    @error('check_out_time')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="hotel_name" class="form-label">Hotel Name</label>
                    <input type="text" class="form-control" id="hotel_name" name="hotel_name" required>
                    @error('hotel_name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="form-control" placeholder="Please enter address" required>
                    @error('address')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" id="notes" name="notes"></textarea>
                </div>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary mx-2" onclick="window.location.href='{{ route('trip_plans.show', $trip_plan->id) }}'">
                        <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
                    </button>

                    <button type="submit" class="btn btn-primary mx-2"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Google Places API -->
<script>
    function initAutocomplete() {
        const input = document.getElementById('address');
        const autocomplete = new google.maps.places.Autocomplete(input);

        autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                console.log(place);
            });
    }

    window.onload = initAutocomplete;
</script>
@endsection
