@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
<div class="container">
    <h2  class="display-4 text-center">Edit Transportation</h2>

    <!-- 編集フォーム -->
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

            <form action="{{ route('transportations.update', ['trip_plan' => $tripPlan->id, 'transportation' => $transportation->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- 日付 -->
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" value="{{ old('date', $transportation->date) }}" class="form-control" required>
                </div>

                <!-- 出発時間 -->
                <div class="form-group">
                    <label for="departure_time">Departure Time</label>
                    <input type="time" id="departure_time" name="departure_time" value="{{ old('departure_time', $transportation->departure_time) }}" class="form-control" required>
                </div>

                <!-- 到着時間 -->
                <div class="form-group">
                    <label for="arrival_time">Arrival Time</label>
                    <input type="time" id="arrival_time" name="arrival_time" value="{{ old('arrival_time', $transportation->arrival_time) }}" class="form-control">
                </div>

                <!-- 出発地 -->
                <div class="form-group">
                    <label for="departure_location">Departure Location</label>
                    <input type="text" id="departure_location" name="departure_location" value="{{ old('departure_location', $transportation->departure_location) }}" class="form-control" required>
                </div>

                <!-- 到着地 -->
                <div class="form-group">
                    <label for="arrival_location">Arrival Location</label>
                    <input type="text" id="arrival_location" name="arrival_location" value="{{ old('arrival_location', $transportation->arrival_location) }}" class="form-control" required>
                </div>

                <!-- 移動手段 -->
                <div class="form-group">
                    <label for="transportation_mode">Transportation Mode</label>
                    <select id="transportation_mode" name="transportation_mode" class="form-control" required>
                        <option value="plane" {{ old('transportation_mode', $transportation->transportation_mode) === 'plane' ? 'selected' : '' }}>Plane</option>
                        <option value="train" {{ old('transportation_mode', $transportation->transportation_mode) === 'train' ? 'selected' : '' }}>Train</option>
                        <option value="bus" {{ old('transportation_mode', $transportation->transportation_mode) === 'bus' ? 'selected' : '' }}>Bus</option>
                        <option value="car" {{ old('transportation_mode', $transportation->transportation_mode) === 'car' ? 'selected' : '' }}>Car</option>
                        <option value="bicycle" {{ old('transportation_mode', $transportation->transportation_mode) === 'bicycle' ? 'selected' : '' }}>Bicycle</option>
                        <option value="walking" {{ old('transportation_mode', $transportation->transportation_mode) === 'walking' ? 'selected' : '' }}>Walking</option>
                        <option value="other" {{ old('transportation_mode', $transportation->transportation_mode) === 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                <!-- 備考 -->
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" class="form-control">{{ old('notes', $transportation->notes) }}</textarea>
                </div><br>

                <!-- 送信ボタン -->
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary mx-2" onclick="window.history.back()">
                        ← back
                    </button>

                    <button type="submit" class="btn btn-primary mx-2">Update Transportation</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
