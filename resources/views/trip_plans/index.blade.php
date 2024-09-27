@extends('layouts.app')

@section('content')
<div class="container">
    <h1>旅行リスト</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('trip_plans.create') }}" class="btn btn-primary">新しい旅行を作成</a>

    <ul class="list-group mt-3">
        @foreach ($trips as $trip)
            <li class="list-group-item">
                <a href="{{ route('trip_plans.show', $trip->id) }}">{{ $trip->title }}</a>
                <span class="badge badge-secondary">{{ $trip->start_date }} 〜 {{ $trip->end_date }}</span>
            </li>
        @endforeach
    </ul>
</div>
@endsection
