<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">
        <!-- Kolom Kiri: Branding & Ilustrasi -->
        <div class="relative hidden lg:flex flex-col items-center justify-center p-12 bg-gradient-to-br from-blue-700 to-cyan-500 text-white text-center">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative z-10">
                <a href="/" class="flex items-center justify-center gap-3 mb-8">
                    <i class="fas fa-tint text-4xl text-white"></i>
                    <span class="font-bold text-3xl">PDAM Garut</span>
                </a>
                <h1 class="text-4xl font-bold mb-4 leading-tight">
                    Buat Akun Baru Anda
                </h1>
                <p class="text-blue-100 max-w-sm">
                    Daftarkan diri Anda untuk mulai menggunakan sistem absensi digital PDAM Garut. Prosesnya cepat dan mudah.
                </p>
                
                <img src="https://cdni.iconscout.com/illustration/premium/thumb/sign-up-8276338-6623869.png" alt="Ilustrasi Registrasi" class="w-full max-w-sm mx-auto mt-10">
            </div>
        </div>

        <!-- Kolom Kanan: Form Registrasi -->
        <div class="flex flex-col justify-center items-center p-6 sm:p-12 bg-gray-50 dark:bg-gray-900">
            <div class="w-full max-w-md">
                <div class="text-center lg:text-left mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Daftar Akun Baru</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login di sini</a></p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" class="dark:text-gray-300" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" value="Alamat Email" class="dark:text-gray-300" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" value="Password" class="dark:text-gray-300" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" value="Konfirmasi Password" class="dark:text-gray-300" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="mt-6">
                        <x-primary-button class="w-full flex justify-center py-3 bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:ring-blue-500">
                            {{ __('Register') }}
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