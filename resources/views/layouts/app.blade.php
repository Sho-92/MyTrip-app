<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


        <!-- Bootstrap 5 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

        <!-- FullCalendar CSS -->
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />


        <!-- Google Maps APIの読み込み -->
        <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.api_key') }}&libraries=places&language=en&callback=initMap" async defer></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans antialiased">
        <div id="app">
            <div class="min-h-screen bg-gray-100">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    @yield('content')
                </main>

                <footer class="bg-light text-center py-3">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </footer>
            </div>

            <!-- ページごとのスクリプト -->
            @yield('scripts')

            <!-- Bootstrap JavaScript (必要なら追加) -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <!-- FullCalendar JavaScript -->
            <script defer src='https://cdn.jsdelivr.net/npm/fullcalendar/index.global.min.js'></script>
        </div>
    </body>
</html>
