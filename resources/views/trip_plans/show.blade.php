@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')

    <div class="container border border-dark p-4"  style="width: 100%; max-width: 800px; height:150px; margin: 30px auto 0 auto; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);  background: linear-gradient(135deg, #ff7e30, #ffb84d); display: flex; flex-direction: column; justify-content: center; align-items: center;">
        <div class="text-center" style="color: #000000;">
            <h1 class="display-4" style="font-weight: bold;">
                @if($tripPlan->title)
                    {{ $tripPlan->title }}
                @else
                    {{ $tripPlan->country }}
                @endif
            </h1>

            <p class="text-lg text-gray-600 mt-2 text-center">
                {{ \Carbon\Carbon::parse($tripPlan->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($tripPlan->end_date)->format('Y-m-d') }}
            </p>

            <div class="text-end mt-2">
                <a href="{{ route('trip_plans.edit', $tripPlan->id) }}" class="mx-2">
                    <i class="fas fa-edit"></i>
                </a>

                <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="trip" data-item-id="{{ $tripPlan->id }}">
                    <i class="fas fa-trash"></i>
                </a>
            </div>
        </div>
    </div>


    <!-- Common delete modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="color: #000;">
                    <h5 class="modal-title" id="deleteLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: #000;">
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



    <div class="row" style="display: flex; flex-wrap: wrap;">
        <!-- Left Column: Schedule - Lists -->
        <div class="col-md-7" style="flex: 1;">
            <!-- Schedule - Lists Section -->
            <div class="container border border-dark p-4" style="width: 90%; max-width: 800px; margin: 30px auto; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; position: relative; display: flex; flex-direction: column; height: 100vh; max-height: 780px;">
                <h2 class="display-6 text-center" style="margin-bottom: 5px; color: #000000;">Schedules</h2>
                <div id='calendar' style="flex-shrink: 0; flex-grow: 1; height: 300px; width: 100%; max-width: 800px; margin: 0 auto; border: 1px solid #000; border-radius: 10px; padding: 20px; color: #000;"></div><br>
                <div style="flex-grow: 1; overflow-y: auto; border: 1px solid #000; border-radius: 10px; padding: 20px; color: #000;">
                    <ul class="list-group">
                        @forelse ($tripLists as $tripList)
                            <li class="list-group-item">
                                <strong>{{ $tripList->destination }}</strong><br>
                                <i class="bi bi-calendar3" style="margin-right: 5px;"></i>{{ $tripList->date }}
                                <i class="bi bi-clock" style="margin-right: 5px;"></i>{{ $tripList->start_time ? $tripList->start_time : 'Start Time' }} -
                                {{ $tripList->end_time ? $tripList->end_time : 'End Time' }}<br>
                                Memo: {{ $tripList->notes }}<br>
                                <div class="text-end mt-2">
                                    <a href="{{ route('trip_lists.edit', [$tripPlan->id, $tripList->id]) }}" class="mx-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="schedule" data-item-id="{{ $tripList->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">No schedule has been registered yet.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('trip_lists.create', $tripPlan->id) }}" class="btn" style="background: linear-gradient(135deg, #ff7e30, #ffb84d); color: white; border: none;">
                        <i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Create a New Schedule</a>
                </div>
            </div>
        </div>

        <!-- Right Column: Transportation and Checklists -->
        <div class="col-md-5" style="flex: 1;">
        <!-- Transportation Section -->
            <div class="container border border-dark p-4" style="width: 90%; max-width: 800px; margin: 30px auto; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; position: relative; display: flex; flex-direction: column; height: 100vh; max-height: 450px;">
                <h2 class="display-6 text-center " style=" margin-bottom: 10px; color: #000000;">Transportations</h2>

                <div style="flex-grow: 1; overflow-y: auto; border: 1px solid #000; border-radius: 10px; padding: 20px; color: #000;">
                    <ul class="list-group">
                        @forelse($transportations as $transportation)
                            <li class="list-group-item">
                                <i class="{{ $transportationIcons[$transportation->transportation_mode] ?? 'bi bi-question' }} fs-4"></i>
                                <strong>{{ $transportation->departure_location }}</strong> to <strong>{{ $transportation->arrival_location }}</strong><br>
                                <i class="bi bi-calendar3" style="margin-right: 5px;"></i>{{ $transportation->date }}
                                <i class="bi bi-clock" style="margin-right: 5px;"></i>{{ $transportation->departure_time }} - {{ $transportation->arrival_time }}
                                <br>Memo: {{ $transportation->notes }}
                                <br>
                                <div class="text-end mt-2">
                                    <a href="{{ route('transportations.edit', ['trip_plan' => $tripPlan->id, 'transportation' => $transportation->id]) }}" class="mx-2">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="transportation" data-item-id="{{ $transportation->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </li>
                        @empty
                            <p>No transportation details available for this trip.</p>
                        @endforelse
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('transportations.create', ['trip_plan' => $tripPlan->id]) }}" class="btn" style="background: linear-gradient(135deg, #ff7e30, #ffb84d); color: white; border: none;">
                        <i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add Transportation</a>
                </div>
            </div>

            <!-- Checklists Section -->
            <div class="container border border-dark p-4" style="width: 90%; max-width: 800px; margin: 30px auto; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; position: relative; display: flex; flex-direction: column; height: 100vh; max-height: 300px;">
                <h2 class="display-6 text-center" style="margin-bottom: 10px; color: #000000;">Checklists</h2>

                <div style="flex-grow: 1; overflow-y: auto; border: 1px solid #000; border-radius: 10px; padding: 20px; color: #000;">
                    <ul class="list-group">
                        @forelse($tripPlan->checklists as $checklist)
                            <li class="list-group-item">
                                <i class="bi bi-list-check" style="margin-right: 5px;"></i><strong>{{ $checklist->title }}</strong>
                            </li>
                        @empty
                            <p>No checklists available for this trip.</p>
                        @endforelse
                    </ul>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('checklists.index', $tripPlan->id) }}" class="btn" style="background: linear-gradient(135deg, #ff7e30, #ffb84d); color: white; border: none;">
                        <i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add Checklist</a>
                </div>
            </div>
        </div>
    </div>

     <!-- Bottom column: Accommodations section -->
    <div class="container border border-dark p-4" style="width: 100%; max-width: 1000px; margin-bottom: 50px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #f9f9f9; position: relative;">
        <h2 class="display-6 text-center" style="margin-bottom: 20px; color: #000000;">Accommodations</h2>

        <div style="display: flex; flex-direction: row; height: 100vh; max-height: 420px;">
            <div style="flex: 0.6; margin-right: 10px;">
                <div id="map" style="flex-shrink: 0; flex-grow: 1; height: 420px; width: 100%; max-width: 800px; margin: 0 auto; border: 1px solid #000; border-radius: 10px; padding: 20px;"></div><br>
            </div>
            <div style="flex: 0.4; display: flex; flex-direction: column; height: 95%; margin-bottom: 10px;">
                <div style="flex-grow: 1; overflow-y: auto; padding-right: 10px; border: 1px solid #000; border-radius: 10px; padding: 20px; color: #000;">
                    <ul class="list-group" style="max-height: 100%;">
                        @forelse($accommodations as $accommodation)
                            <li class="list-group-item">
                                <strong>{{ $accommodation->hotel_name }}</strong><br>
                                Check-in: {{ $accommodation->check_in_date }} {{ \Carbon\Carbon::parse($accommodation->check_in_time)->format('H:i') }}<br>
                                check-out: {{ $accommodation->check_out_date }} {{ \Carbon\Carbon::parse($accommodation->check_out_time)->format('H:i') }}<br>
                                Notes: {{ $accommodation->notes }}<br>

                                <div class="text-end mt-2">
                                    <button type="button" class="btn mx-2 show-map"
                                    data-address="{{ $accommodation->address }}" data-hotel-name="{{ $accommodation->hotel_name }}"
                                    data-check-in="{{ $accommodation->check_in_date }} {{ \Carbon\Carbon::parse($accommodation->check_in_time)->format('H:i') }}"
                                    data-check-out="{{ $accommodation->check_out_date }} {{ \Carbon\Carbon::parse($accommodation->check_out_time)->format('H:i') }}"
                                    data-notes="{{ $accommodation->notes }}">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </button>

                                    <a href="{{ route('accommodations.edit', ['trip_plan' => $tripPlan->id, 'accommodation' => $accommodation->id]) }}" class="mx-2">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="#" class="mx-2" data-bs-toggle="modal" data-bs-target="#deleteModal" data-item-type="accommodation" data-item-id="{{ $accommodation->id }}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </li>
                        @empty
                            <p>No accommodations available for this trip.</p>
                        @endforelse
                    </ul>
                </div>
                <div class="text-center mt-4" style="flex-shrink: 0;">
                    <a href="{{ route('accommodations.create', ['trip_plan' => $tripPlan->id]) }}" class="btn" style="background: linear-gradient(135deg, #ff7e30, #ffb84d); color: white; border: none;">
                        <i class="bi bi-plus-circle" style="margin-right: 5px;"></i>Add Accommodation</a>
                </div>
            </div>
        </div>
    </div>


    <div class="text-center mt-4">
        <button type="button" class="btn btn-secondary mx-2 mb-3" onclick="window.history.back()">
            <i class="bi bi-arrow-left-circle" style="margin-right: 5px;"></i>back
        </button>
    </div>



    <script>
        const deleteModal = document.getElementById('deleteModal');
        deleteModal.addEventListener('show.bs.modal', event => {
            const button = event.relatedTarget;
            const itemType = button.getAttribute('data-item-type');
            const itemId = button.getAttribute('data-item-id');

            const itemTypeSpan = deleteModal.querySelector('#item-type');
            itemTypeSpan.textContent = itemType === 'trip' ? 'trip plan' : itemType;

            const form = deleteModal.querySelector('#deleteForm');
            let deleteUrl = '';

            if (itemType === 'trip') {
                deleteUrl = `{{ route('trip_plans.destroy', '') }}/${itemId}`;
            } else if (itemType === 'schedule') {
                deleteUrl = `{{ route('trip_lists.destroy', ['trip_plan' => $tripPlan->id, '']) }}/${itemId}`;
            } else if (itemType === 'transportation') {
                deleteUrl = `{{ route('transportations.destroy', ['trip_plan' => $tripPlan->id, '']) }}/${itemId}`;
            } else {
                deleteUrl = `{{ route('accommodations.destroy', ['trip_plan' => $tripPlan->id, '']) }}/${itemId}`;
            }

            form.action = deleteUrl;
        });

        // Initialization of FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            const tripLists = @json($tripLists);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: tripLists.map(function(tripList) {
                    return {
                        title: tripList.destination,
                        start: tripList.date + 'T' + tripList.start_time,
                        end: tripList.date + 'T' + tripList.end_time,
                        description: tripList.notes
                    };
                }),
                eventContent: function(arg) {
                    return {
                        html: `<div class="event-content">
                                    <strong>${arg.event.title}</strong>
                                </div>`
                    };
                },
                eventDidMount: function(info) {
                    info.el.style.backgroundColor = 'white';
                    info.el.style.border = '1px solid';
                    info.el.style.borderColor = 'red';
                    info.el.style.borderRadius = '5px';
                }
            });

            calendar.render();
        });

        // Initialization of Map
        window.initMap = function() {
            var location = {lat: 35.6895, lng: 139.6917};  // Tokyo
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 1.2,
                center: location,
                mapTypeControl: true,
                mapTypeId: 'roadmap',
                streetViewControl: true // Street View
            });

            const showMapButtons = document.querySelectorAll('.show-map');
            showMapButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const address = this.getAttribute('data-address');
                    const hotelName = this.getAttribute('data-hotel-name');
                    const checkIn = this.getAttribute('data-check-in');
                    const checkOut = this.getAttribute('data-check-out');
                    const notes = this.getAttribute('data-notes');
                    displayMapForAddress(address, hotelName, checkIn, checkOut, notes);
                });
            });
        }

        // display an address on a map
        function displayMapForAddress(address, hotelName, checkIn, checkOut, notes) {
            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ address: address }, function(results, status) {
                if (status === 'OK') {
                    const location = results[0].geometry.location;
                    const mapOptions = {
                        zoom: 15,
                        center: location
                    };
                    const map = new google.maps.Map(document.getElementById('map'), mapOptions);

                    const marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });

                    const infowindow = new google.maps.InfoWindow({
                        content: `
                            <div style="color: #000;">
                                <strong>${hotelName}</strong><br>
                                Check-in: ${checkIn}<br>
                                check-out: ${checkOut}<br>
                                Address: ${address}<br>
                                Notes: ${notes ? notes : "No notes available"}
                            </div>
                        `
                    });

                    marker.addListener('click', function() {
                        infowindow.open(map, marker);
                    });
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                }
            });
        }
    </script>
@endsection
