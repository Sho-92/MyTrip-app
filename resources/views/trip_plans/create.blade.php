@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1 class="display-4 text-center">Create a New Trip</h1>
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

            <form action="{{ route('trip_plans.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="form-group">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                </div>

                <div class="form-group">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                </div>

                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" class="form-control" value="{{ old('country') }}" required>
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}" required>
                </div><br>

                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary  mx-2" onclick="window.history.back()">
                        <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
                    </button>

                    <button type="submit" class="btn btn-primary mx-2"><i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Create</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Google Places API -->
    <script>
        function initialize() {
            var countryInput = document.getElementById('country');
            var cityInput = document.getElementById('city');

            var countryAutocomplete = new google.maps.places.Autocomplete(countryInput, {
                types: ['(regions)']
            });

            var cityAutocomplete = new google.maps.places.Autocomplete(cityInput, {
                types: ['(cities)']
            });

            countryAutocomplete.addListener('place_changed', function() {
                var place = countryAutocomplete.getPlace();
                console.log('Selected country:', place.name);
            });

            cityAutocomplete.addListener('place_changed', function() {
                var place = cityAutocomplete.getPlace();
                console.log('Selected city:', place.name);
            });
        }

        window.onload = initialize;
    </script>


@endsection
