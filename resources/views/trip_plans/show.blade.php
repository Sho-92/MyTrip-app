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

        <div id='calendar'></div><br>

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

        <div id="map" style="height: 400px; width: 100%;"></div>

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

                    <button type="button" class="btn btn-primary mt-2 show-map" data-address="{{ $accommodation->address }}">
                        Show on Map
                    </button>

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
                var marker = new google.maps.Marker({
                    position: location,
                    map: map
                });
            }

            // 住所を地図に表示する関数
            function displayMapForAddress(address) {
                const geocoder = new google.maps.Geocoder();
                geocoder.geocode({ address: address }, function(results, status) {
                    if (status === 'OK') {
                        const location = results[0].geometry.location;
                        const mapOptions = {
                            zoom: 15,
                            center: location
                        };
                        const map = new google.maps.Map(document.getElementById('map'), mapOptions);
                        new google.maps.Marker({
                            position: location,
                            map: map
                        });
                    } else {
                        console.error('Geocode was not successful for the following reason: ' + status);
                    }
                });
            }

            // ボタンのクリックイベントを設定
            const showMapButtons = document.querySelectorAll('.show-map');
            showMapButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const address = this.getAttribute('data-address'); // 住所を取得
                    displayMapForAddress(address); // 住所を使って地図を表示
                });
            });

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
