@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1 class="display-2 text-center" style="font-weight: bold; margin: 50px auto 30px;">My Trip</h1>

    <div class="container border border-dark p-4" style="width: 50%; max-width: 800px; margin-bottom: 50px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9;">
        <h2 class="display-6 text-center" style="color: #000000;">Your Next Trip</h2>

        <ul class="list-group mt-4 text-center">
            @forelse($tripPlans as $tripPlan)
                <li class="list-group-item">
                    <a href="{{ route('trip_plans.show', $tripPlan->id) }}">
                        <strong>{{ $tripPlan->title }}</strong><br>
                        <span class="text-muted">
                            ({{ \Carbon\Carbon::parse($tripPlan->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($tripPlan->end_date)->format('Y-m-d') }})
                        </span>
                        <br>
                        <City:>Country: {{ $tripPlan->country }} / City: {{ $tripPlan->city }}</span>
                    </a>
                </li>
            @empty
                <li class="list-group-item">No trip plans available.</li>
            @endforelse
        </ul>
        <div class="text-center mt-4">
            <a href="{{ route('trip_plans.create') }}" class="btn" style="background: linear-gradient(135deg, #ff7e30, #ffb84d); color: white; border: none;">
                Add New Trip Plan
            </a>
        </div>

    </div>
@endsection

