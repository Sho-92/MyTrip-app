@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
    <h1 class="display-4 text-center">Your Next Trip</h1>

    <div class="container p-4" style="max-width: 600px; margin-left: auto; margin-right: auto;">
        <div class="border border-dark p-4">
            <h2 class="display-6 text-center">
                @if($tripPlan->title)
                    {{ $tripPlan->title }}
                @else
                    {{ $tripPlan->country }}
                @endif
            </h2>

            <p class="text-lg text-gray-600 mt-2 text-center">
                {{ \Carbon\Carbon::parse($tripPlan->start_date)->format('Y-m-d') }} - {{ \Carbon\Carbon::parse($tripPlan->end_date)->format('Y-m-d') }}
            </p>
            <p class="text-lg text-gray-600 mt-2 text-center">
                Country: {{ $tripPlan->country }} | City: {{ $tripPlan->city }}
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

    <div class="row">
        <!-- Left Column: Schedule - Lists and Transportation Details -->
        <div class="col-md-6">
            <!-- Schedule - Lists Section -->
            <h2 class="display-4 text-center">Schedules</h2>
            <div class="container border border-dark p-4" >
                <div id='calendar'></div><br>
                <ul class="list-group">
                    @forelse ($tripLists as $tripList)
                        <li class="list-group-item">
                            <strong>{{ $tripList->date }}</strong> /
                            {{ $tripList->start_time ? $tripList->start_time : 'Start Time' }} -
                            {{ $tripList->end_time ? $tripList->end_time : 'End Time' }} /
                            {{ $tripList->destination }}<br>
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
                        <p>No schedule has been registered yet.</p>
                    @endforelse
                    <br><a href="{{ route('trip_lists.create', $tripPlan->id) }}" class="btn btn-primary">Create a New Schedule</a>
                </ul>
            </div>

            <!-- Transportation Details Section -->
            <h2 class="display-4 text-center mt-4">Transportations</h2>
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
                    <br><a href="{{ route('transportations.create', ['trip_plan' => $tripPlan->id]) }}" class="btn btn-primary">Add Transportation</a>
                </ul>
            </div>
        </div>

        <!-- Right Column: Accommodations and Checklists -->
        <div class="col-md-6">
            <!-- Accommodations Section -->
            <h2 class="display-4 text-center">Accommodations</h2>
            <div class="container border border-dark p-4">
                <div id="map" style="height: 400px; width: 100%;"></div><br>
                <ul class="list-group">
                    @forelse($accommodations as $accommodation)
                        <li class="list-group-item">
                            <strong>{{ $accommodation->hotel_name }}</strong><br>
                            Check-in: {{ $accommodation->check_in_date }} {{ \Carbon\Carbon::parse($accommodation->check_in_time)->format('H:i') }}<br>
                            check-out: {{ $accommodation->check_out_date }} {{ \Carbon\Carbon::parse($accommodation->check_out_time)->format('H:i') }}<br>
                            Notes: {{ $accommodation->notes }}
                            <br>

                            <div class="text-end mt-2">
                                <button type="button" class="btn mx-2 show-map"
                                data-address="{{ $accommodation->address }}"data-hotel-name="{{ $accommodation->hotel_name }}"
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
                    <br><a href="{{ route('accommodations.create', ['trip_plan' => $tripPlan->id]) }}" class="btn btn-primary">Add Accommodation</a>
                </ul>
            </div>

            <!-- Checklists Section -->
            <h2 class="display-4 text-center mt-4">Checklists</h2>
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
        </div>
    </div>

    <div class="text-center mt-4">
        <button type="button" class="btn btn-secondary  mx-2" onclick="window.history.back()">
            ← back
        </button>
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

        // FullCalendarの初期化
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar'); // カレンダーを表示する要素を取得
            // Laravelからのスケジュールデータを取得
            const tripLists = @json($tripLists); // LaravelのデータをJavaScriptに渡す

            // FullCalendarの初期化
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: tripLists.map(function(tripList) {
                    return {
                        title: tripList.destination, // タイトル
                        start: tripList.date + 'T' + tripList.start_time, // 開始日時
                        end: tripList.date + 'T' + tripList.end_time, // 終了日時
                        description: tripList.notes // メモなど、必要な情報を追加
                    };
                }),
                eventContent: function(arg) {
                    // HTMLを使ってイベント内容をカスタマイズ
                    return {
                        html: `<div class="event-content">
                                    <strong>${arg.event.title}</strong>
                                    / ${arg.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                                </div>`
                    };
                },
                eventDidMount: function(info) {
                    // カスタムスタイルを設定
                    info.el.style.backgroundColor = 'lightblue'; // 背景色を変更
                    info.el.style.border = '1px solid'; // ボーダーを追加
                    info.el.style.borderRadius = '5px'; // 角を丸くする
                }
            });

            calendar.render(); // カレンダーを描画
        });

        document.addEventListener('DOMContentLoaded', function() {
        console.log('Google Maps APIが初期化されました');
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initMap`;
            script.async = true;
            script.onload = function() {
                console.log("Google Maps APIのスクリプトが読み込まれました。");
            };
            script.onerror = function() {
                console.error("Google Maps APIの読み込み中にエラーが発生しました。");
            };
            document.head.appendChild(script);
        } else {
            initMap(); // すでに読み込まれている場合はinitMapを呼び出す
        }

        // 地図の初期化関数
        window.initMap = function() {
            var location = {lat: 35.6895, lng: 139.6917};  // 東京の座標
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 1,
                center: location,
                mapTypeControl: true, // 地図タイプコントロールを表示
                mapTypeId: 'roadmap', // デフォルトの地図タイプ
                streetViewControl: true // Street Viewコントロールを表示
            });

            // ボタンのクリックイベントを設定
            const showMapButtons = document.querySelectorAll('.show-map');
            showMapButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const address = this.getAttribute('data-address'); // 住所を取得
                    const hotelName = this.getAttribute('data-hotel-name'); // ホテル名を取得
                    const checkIn = this.getAttribute('data-check-in'); // チェックイン情報を取得
                    const checkOut = this.getAttribute('data-check-out'); // チェックアウト情報を取得
                    const notes = this.getAttribute('data-notes'); // メモを取得
                    displayMapForAddress(address, hotelName, checkIn, checkOut, notes); // 住所を使って地図を表示
                });
            });
        }

        // 住所を地図に表示する関数
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

                    // マーカーを作成
                    const marker = new google.maps.Marker({
                        position: location,
                        map: map
                    });

                    // インフォウィンドウを作成
                    const infowindow = new google.maps.InfoWindow({
                        content: `
                            <div>
                                <strong>${hotelName}</strong><br>
                                Check-in: ${checkIn}<br>
                                check-out: ${checkOut}<br>
                                Address: ${address}<br>
                                Notes: ${notes ? notes : "No notes available"}
                            </div>
                        `
                    });

                    // マーカーをクリックした時にインフォウィンドウを表示
                    marker.addListener('click', function() {
                        infowindow.open(map, marker);
                    });
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        // Google Maps APIのスクリプトを非同期で読み込む
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            const script = document.createElement('script');
            script.src = `https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&callback=initMap`;
            script.async = true;
            script.onload = function() {
                console.log("Google Maps APIのスクリプトが読み込まれました。");
            };
            script.onerror = function() {
                console.error("Google Maps APIの読み込み中にエラーが発生しました。");
            };
            document.head.appendChild(script);
        }
    });



    </script>
@endsection
