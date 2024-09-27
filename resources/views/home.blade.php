@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-center mb-4">Welcome to {{ config('app.name') }}</h1>
        <p class="text-center mb-6">This is the home page where you can find amazing features and information.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Feature 1</h2>
                <p class="mt-2">Description of feature 1.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Feature 2</h2>
                <p class="mt-2">Description of feature 2.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Feature 3</h2>
                <p class="mt-2">Description of feature 3.</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // ここにページ特有のスクリプトを追加できます
    </script>
@endsection
