<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 flex items-center gap-2">
            <i class="fa-solid fa-gauge-high text-blue-600 dark:text-blue-400"></i>
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-xl shadow-lg p-6 flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-semibold">Selamat datang, {{ Auth::user()->name }} 👋</h3>
                    <p class="mt-1 text-sm opacity-90">
                        Anda login sebagai <span class="font-medium">{{ Auth::user()->role }}</span>.
                    </p>
                </div>
                <i class="fa-regular fa-circle-user text-5xl opacity-80"></i>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="p-3 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 rounded-lg">
                        <i class="fa-solid fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Karyawan</p>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">120</h3>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="p-3 bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 rounded-lg">
                        <i class="fa-regular fa-calendar-check text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Absensi Hari Ini</p>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">85</h3>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex items-center gap-4 hover:shadow-lg transition">
                    <div class="p-3 bg-yellow-100 dark:bg-yellow-900 text-yellow-600 dark:text-yellow-300 rounded-lg">
                        <i class="fa-solid fa-file-circle-question text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Izin Pending</p>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200">5</h3>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-2">
                    <i class="fa-solid fa-bullhorn text-blue-500"></i> Pengumuman
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Sistem absensi sedang dalam tahap pengembangan. Silakan laporkan jika menemukan bug atau error.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>
