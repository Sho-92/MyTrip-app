@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1 class="display-4 text-center">My Trip</h1>

    <div class="container border border-dark p-4">
        <h2>Your Next Trip</h2>

        <ul class="list-group mt-4">
            @forelse($tripPlans as $tripPlan)
                <li class="list-group-item">
                    <a href="{{ route('trip_plans.show', $tripPlan->id) }}">
                        <strong>{{ $tripPlan->title }}</strong>
                        <span class="text-muted">
                            ({{ \Carbon\Carbon::parse($tripPlan->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($tripPlan->end_date)->format('Y-m-d') }})
                        </span>
                        <br>
                        <span>Country: {{ $tripPlan->country }}</span>
                        <br>
                        <span>City: {{ $tripPlan->city }}</span>
                    </a>
                </li>
            @empty
                <li class="list-group-item">No trip plans available.</li>
            @endforelse
        </ul>

        <div class="text-center mt-4">
            <a href="{{ route('trip_plans.create') }}" class="btn btn-primary">
                Add New Trip Plan
            </a>
        </div>
        
    </div>
@endsection

