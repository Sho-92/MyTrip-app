@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <div class="container">
        <h1>Add New Transportation</h1>

        <form action="{{ route('transportations.store', ['trip_plan' => $tripPlanId]) }}" method="POST">
            @csrf

            <!-- Trip Plan ID を隠しフィールドとして送信 -->
            <input type="hidden" name="trip_plan_id" value="{{ $tripPlanId }}">

            <!-- 日付 -->
            <div class="form-group">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>

            <!-- 出発時間 -->
            <div class="form-group">
                <label for="departure_time">Departure Time</label>
                <input type="time" id="departure_time" name="departure_time" class="form-control" required>
            </div>

            <!-- 到着時間（オプション） -->
            <div class="form-group">
                <label for="arrival_time">Arrival Time (optional)</label>
                <input type="time" id="arrival_time" name="arrival_time" class="form-control">
            </div>

            <!-- 出発地 -->
            <div class="form-group">
                <label for="departure_location">Departure Location</label>
                <input type="text" id="departure_location" name="departure_location" class="form-control" required>
            </div>

            <!-- 到着地 -->
            <div class="form-group">
                <label for="arrival_location">Arrival Location</label>
                <input type="text" id="arrival_location" name="arrival_location" class="form-control" required>
            </div>

            <!-- 移動手段 -->
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

            <!-- 備考欄 -->
            <div class="form-group">
                <label for="notes">Notes (optional)</label>
                <textarea id="notes" name="notes" class="form-control" rows="4"></textarea>
            </div>

            <!-- 送信ボタン -->
            <button type="submit" class="btn btn-primary">Add Transportation</button>
            <a href="{{ route('trip_plans.show', $tripPlan->id) }}" class="btn btn-secondary">Back to Trip Plans</a>
        </form>
    </div>
@endsection
