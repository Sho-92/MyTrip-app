@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1>Add New Trip Plan</h1>
    <div class="container">

        <!-- エラーメッセージの表示 -->
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

            <!-- タイトルの入力 -->
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            </div>

            <!-- 日程の入力 -->
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
            </div>

            <!-- 場所の入力 -->
            <div class="form-group">
                <label for="country">Country:</label>
                <input type="text" id="country" name="country" class="form-control" value="{{ old('country') }}" required>
            </div>

            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" class="form-control" value="{{ old('city') }}" required>
            </div>

            <!-- 送信ボタン -->
            <button type="submit" class="btn btn-primary">Create Trip Plan</button>

            <br><a href="{{ route('home') }}" class="btn btn-secondary">旅行プラン一覧に戻る</a>
        </form>
    </div>

    <!-- Google Places APIの読み込み -->
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

        // Google Places APIのロード後に初期化
        window.onload = initialize;
    </script>
    

@endsection
