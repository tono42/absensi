<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale-1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <div class="relative hidden lg:flex flex-col items-center justify-center p-12 bg-gradient-to-br from-blue-700 to-cyan-500 text-white text-center">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative z-10">
                <a href="/" class="flex items-center justify-center gap-3 mb-8">
                    <i class="fas fa-tint text-4xl text-white"></i>
                    <span class="font-bold text-3xl">PDAM Garut</span>
                </a>
                <h1 class="text-4xl font-bold mb-4 leading-tight">
                    Sistem Absensi Karyawan
                </h1>
                <p class="text-blue-100 max-w-sm">
                    Selamat datang kembali! Silakan masuk untuk mencatat kehadiran dan melihat riwayat absensi Anda.
                </p>
                
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/user-login-7341818-6028591.png" alt="Ilustrasi Login" class="w-full max-w-sm mx-auto mt-10">
            </div>
        </div>

        <div class="flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50 dark:bg-gray-900">
            <div class="w-full max-w-md">
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Login ke Akun Anda</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Daftar di sini</a></p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div>
                        <x-input-label for="email" value="Email atau NIP" class="dark:text-gray-300" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" value="Password" class="dark:text-gray-300" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full flex justify-center py-3 bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:ring-blue-500">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>

                    <div class="text-center mt-6">
                        <a href="/" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 hover:underline">
                            &larr; Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>