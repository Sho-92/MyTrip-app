@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1 class="display-4 text-center">Your Next Trip</h1>

    <div class="container border border-dark p-4">
        <h2 class="mt-4">
            @if($tripPlan->title)
                {{ $tripPlan->title }} - Trip Lists
            @else
                {{ $tripPlan->country }} - Trip Lists
            @endif
        </h2>

        <p>Start Date: {{ \Carbon\Carbon::parse($tripPlan->start_date)->format('Y-m-d') }}</p>
        <p>End Date: {{ \Carbon\Carbon::parse($tripPlan->end_date)->format('Y-m-d') }}</p>
        <p>Country: {{ $tripPlan->country }}</p>
        <p>City: {{ $tripPlan->city }}</p>

        <a href="{{ route('trip_plans.edit', $tripPlan->id) }}" class="btn btn-warning">Edit</a>

        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="trip" data-item-id="{{ $tripPlan->id }}">
            Delete
        </button>
    </div>

    <!-- 共通の削除モーダル -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this <span id="item-type"></span>? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h2 class="display-4 text-center">Schedule - Lists</h2>
    <div class="container border border-dark p-4">
        <ul class="list-group">
            @forelse ($tripLists as $tripList)
                <li class="list-group-item">
                    <strong>{{ $tripList->date }}</strong> - {{ $tripList->destination }} <br>
                    {{ $tripList->start_time ? $tripList->start_time : 'Start Time' }} -
                    {{ $tripList->end_time ? $tripList->end_time : 'End Time' }}<br>
                    Memo: {{ $tripList->notes }}
                    <a href="{{ route('trip_lists.edit', [$tripPlan->id, $tripList->id]) }}" class="btn btn-warning mt-2">Edit</a>

                    <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="schedule" data-item-id="{{ $tripList->id }}">
                        Delete
                    </button>
                </li>
            @empty
                <p>No schedule has been registered yet.</p>
            @endforelse
            <br><a href="{{ route('trip_lists.create', $tripPlan->id) }}" class="btn btn-primary">Create a new schedule</a>
        </ul>
    </div>

    <h2 class="display-4 text-center">Transportation Details</h2>
    <div class="container border border-dark p-4">
        <ul class="list-group">
            @forelse($transportations as $transportation)
                <li class="list-group-item">
                    <strong>{{ $transportation->departure_location }}</strong> to <strong>{{ $transportation->arrival_location }}</strong>
                    at {{ $transportation->departure_time }} - {{ $transportation->arrival_time }}
                    on {{ $transportation->date }}
                    @php
                        $transportationIcons = [
                            'plane' => '🛩️',
                            'train' => '🚄',
                            'bus' => '🚌',
                            'car' => '🚗',
                            'bicycle' => '🚲',
                            'walking' => '🚶',
                            'other' => '🌍',
                        ];
                    @endphp
                    {{ isset($transportationIcons[$transportation->transportation_mode]) ? $transportationIcons[$transportation->transportation_mode] : 'Not Specified' }}
                    <br>Memo: {{ $transportation->notes }}
                    <br>
                    <a href="{{ route('transportations.edit', ['trip_plan' => $tripPlan->id, 'transportation' => $transportation->id]) }}" class="btn btn-warning mt-2">Edit</a>

                    <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="transportation" data-item-id="{{ $transportation->id }}">
                        Delete
                    </button>
                </li>
            @empty
                <p>No transportation details available for this trip.</p>
            @endforelse
            <br><a href="{{ route('transportations.create', ['trip_plan' => $tripPlan->id]) }}" class="btn btn-primary">Add Transportation</a>
        </ul>
    </div>

    <h2 class="display-4 text-center">Accommodations</h2>
    <div class="container border border-dark p-4">
        <ul class="list-group">
            @forelse($accommodations as $accommodation)
                <li class="list-group-item">
                    <strong>{{ $accommodation->hotel_name }}</strong><br>
                    チェックイン: {{ $accommodation->check_in_date }} {{ \Carbon\Carbon::parse($accommodation->check_in_time)->format('H:i') }}<br>
                    チェックアウト: {{ $accommodation->check_out_date }} {{ \Carbon\Carbon::parse($accommodation->check_out_time)->format('H:i') }}<br>
                    住所: {{ $accommodation->address }}<br>
                    メモ: {{ $accommodation->notes }}
                    <br>
                    <a href="{{ route('accommodations.edit', ['trip_plan' => $tripPlan->id, 'accommodation' => $accommodation->id]) }}" class="btn btn-warning mt-2">Edit</a>

                    <button type="button" class="btn btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="accommodation" data-item-id="{{ $accommodation->id }}">
                        Delete
                    </button>
                </li>
            @empty
                <p>No accommodations available for this trip.</p>
            @endforelse
            <br>
            <a href="{{ route('accommodations.create', ['trip_plan' => $tripPlan->id]) }}" class="btn btn-primary">Add Accommodation</a>
        </ul>
    </div>

    <h2 class="display-4 text-center">Checklists</h2>
    <div class="container border border-dark p-4">
        <ul class="list-group">
            @forelse($tripPlan->checklists as $checklist)
                <li class="list-group-item">
                    <strong>{{ $checklist->title }}</strong>
                </li>
            @empty
                <p>No checklists available for this trip.</p>
            @endforelse
            <br>
            <a href="{{ route('checklists.index', $tripPlan->id) }}" class="btn btn-primary">Add Checklist</a>
        </ul>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('home') }}" class="btn btn-secondary">
            Return to Trip Plan
        </a>
    </div>


    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget; // ボタンがクリックされたときの情報を取得
            const itemType = button.getAttribute('data-item-type');
            const itemId = button.getAttribute('data-item-id');

            const itemTypeSpan = deleteModal.querySelector('#item-type');
            itemTypeSpan.textContent = itemType === 'trip' ? 'trip plan' : itemType;

            const form = deleteModal.querySelector('#deleteForm');
            form.action = itemType === 'trip'
                ? `{{ route('trip_plans.destroy', '') }}/${itemId}`
                : itemType === 'schedule'
                    ? `{{ route('trip_lists.destroy', ['trip_plan' => $tripPlan->id, '']) }}/${itemId}`
                    : itemType === 'transportation'
                        ? `{{ route('transportations.destroy', ['trip_plan' => $tripPlan->id, '']) }}/${itemId}`
                        : `{{ route('accommodations.destroy', ['trip_plan' => $tripPlan->id, '']) }}/${itemId}`;
        });
    </script>
@endsection
