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
<body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900">
    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <div class="mb-8 text-center">
            <a href="/">
                <x-application-logo class="w-24 h-24 mx-auto text-gray-500 dark:text-gray-200" />
            </a>
            <h1 class="mt-4 text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ config('app.name', 'Laravel') }}</h1>
        </div>

        <!-- Form / Slot -->
        <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-xl p-8">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <p class="mt-6 text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
        </p>
    </div>
</body>
</html>
