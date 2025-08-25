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

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex">
            @include('layouts.sidebar')
            <div class="flex-1 flex flex-col min-h-screen">
                @include('layouts.navigation')
                
                <!-- Main Content Slot -->
                <main class="flex-1">
                    <div class="px-6 py-6">
                        @isset($header)
                            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6">{!! $header !!}</h1>
                        @endisset
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
