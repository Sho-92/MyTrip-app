@extends('layouts.app')

@section('navbar-brand')
    My Trip
@endsection

@section('content')
<div class="container">
    <h1>宿泊施設の編集</h1>

    <form action="{{ route('accommodations.update', ['trip_plan' => $trip_plan, 'accommodation' => $accommodation]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="check_in_date" class="form-label">チェックイン日</label>
            <input type="date" class="form-control" id="check_in_date" name="check_in_date" value="{{ old('check_in_date', $accommodation->check_in_date) }}" required>
            @error('check_in_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="check_in_time" class="form-label">チェックイン時間</label>
            <input type="time" class="form-control" id="check_in_time" name="check_in_time" value="{{ old('check_in_time', $accommodation->check_in_time) }}" required>
            @error('check_in_time')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="check_out_date" class="form-label">チェックアウト日</label>
            <input type="date" class="form-control" id="check_out_date" name="check_out_date" value="{{ old('check_out_date', $accommodation->check_out_date) }}" required>
            @error('check_out_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="check_out_time" class="form-label">チェックアウト時間</label>
            <input type="time" class="form-control" id="check_out_time" name="check_out_time" value="{{ old('check_out_time', $accommodation->check_out_time) }}" required>
            @error('check_out_time')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="hotel_name" class="form-label">ホテル名</label>
            <input type="text" class="form-control" id="hotel_name" name="hotel_name" value="{{ old('hotel_name', $accommodation->hotel_name) }}" required>
            @error('hotel_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">住所</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $accommodation->address) }}" placeholder="住所を入力してください" required>
            @error('address')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">備考</label>
            <textarea class="form-control" id="notes" name="notes">{{ old('notes', $accommodation->notes) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('trip_plans.show', $trip_plan) }}" class="btn btn-secondary">戻る</a>
    </form>
</div>

<!-- Google Places APIの読み込み -->
<script>
    function initAutocomplete() {
        const input = document.getElementById('address');
        const autocomplete = new google.maps.places.Autocomplete(input);

        // オートコンプリートが選択された時の処理
        autocomplete.addListener('place_changed', function() {
                const place = autocomplete.getPlace();
                console.log(place); // 選択された場所の情報をコンソールに表示
            });
    }

    window.onload = initAutocomplete;
</script>
@endsection
