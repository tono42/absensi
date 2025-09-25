<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MyApp') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">

    <div class="min-h-screen flex flex-col">

        <!-- Navbar -->
        @include('layouts.navigation')

        <!-- Gradient Header -->
        <div class="bg-gradient-to-br from-blue-600 via-indigo-500 to-cyan-500 dark:from-blue-900 dark:via-indigo-800 dark:to-cyan-700 pb-28 md:pb-36 relative shadow-xl">
            @if (isset($header))
            <header class="py-10 text-center md:text-left animate-fade-in">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl md:text-5xl font-extrabold tracking-tight text-white drop-shadow-lg">
                        {{ $header }}
                    </h1>
                </div>
            </header>
            @endif

            <!-- Decorative Wave -->
            <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
                <svg class="relative block w-full h-12 md:h-24 text-gray-100 dark:text-gray-900 transition-colors duration-300"
                    xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 120 28">
                    <path d="M0 17 C 30 29 90 5 120 17 V 30 H 0 V 17 Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 -mt-20 md:-mt-28 relative z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-6 md:p-10 transition duration-300 hover:shadow-3xl">
                    {{ $slot }}
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="mt-12 bg-gray-200 dark:bg-gray-800 py-6 text-center text-gray-600 dark:text-gray-400 text-sm border-t border-gray-300/50 dark:border-gray-700/50">
            <p class="mb-1">© {{ date('Y') }} <span class="font-semibold">{{ config('app.name', 'MyApp') }}</span>. jukut.</p>
            <p class="text-xs">Crafted with <i class="fa-solid fa-heart text-red-500"></i> Hilda</p>
        </footer>
    </div>

    @stack('scripts')

    <!-- Animasi custom -->
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-in-out;
        }

        .hover\\:shadow-3xl:hover {
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }
    </style>
</body>

</html>
