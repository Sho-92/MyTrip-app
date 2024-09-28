@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1>Schdele - Lists</h1>

    <ul>
        @forelse ($tripLists as $tripList)
            <li>
                <strong>{{ $tripList->date }}</strong> - {{ $tripList->destination }}
                <br>Memo: {{ $tripList->notes }}
                <br><a href="{{ route('trip_lists.show', [$tripList->trip_plan_id, $tripList->id]) }}">詳細を見る</a>
            </li>
        @empty
            <p>No schedule has been registered yet.</p>
        @endforelse
    </ul>
@endsection
