<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fas fa-user-tie mr-2 text-blue-600"></i> {{ __('Karyawan Dashboard') }}
            </h2>

            <button id="theme-toggle-btn" 
                    class="px-3 py-1 rounded-lg text-sm bg-gray-200 dark:bg-gray-700 hover:scale-105 transition flex items-center gap-2">
                <i id="theme-icon" class="fa-solid fa-moon"></i>
                <span id="theme-label" class="sr-only">Toggle Theme</span>
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Selamat Datang Kembali, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-500 dark:text-gray-400">Berikut adalah ringkasan aktivitas absensi Anda.</p>
            </div>

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Gagal</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if(session('warning'))
                <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Perhatian</p>
                    <p>{{ session('warning') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    {{-- Absensi Hari Ini --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-lg p-6 shadow-lg transition transform hover:-translate-y-1 hover:shadow-2xl">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                <i class="fas fa-clock text-blue-500"></i>
                                Absensi Hari Ini
                            </h3>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-700 dark:text-gray-300" id="live-clock" aria-live="polite"></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                            @if(isset($absensiToday) && $absensiToday)
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Check-in</p>
                                        <p class="font-bold text-lg text-green-600 dark:text-green-400">
                                            {{ $absensiToday->check_in ? \Carbon\Carbon::parse($absensiToday->check_in)->format('H:i:s') : '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Check-out</p>
                                        <p class="font-bold text-lg text-red-500 dark:text-red-400">
                                            {{ $absensiToday->check_out ? \Carbon\Carbon::parse($absensiToday->check_out)->format('H:i:s') : 'Belum' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                        @php $status = strtolower($absensiToday->status ?? ''); @endphp
                                        @if(in_array($status, ['pending','menunggu','waiting']))
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Menunggu Validasi</span>
                                        @elseif(in_array($status, ['approved','divalidasi','hadir']))
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Divalidasi</span>
                                        @else
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Ditolak</span>
                                        @endif
                                    </div>
                                </div>

                                @if(!($absensiToday->check_out))
                                    <form action="{{ route('karyawan.absensi.checkOut') }}" method="POST" class="mt-6">
                                        @csrf
                                        <button type="submit" class="w-full py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow-md transition duration-300 flex items-center justify-center gap-2">
                                            <i class="fas fa-sign-out-alt"></i> <span>Check-out Sekarang</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <div class="text-center">
                                    <p class="text-gray-600 dark:text-gray-300 mb-4">Anda belum melakukan absensi hari ini. Silakan Check-in.</p>
                                    <form action="{{ route('karyawan.absensi.checkIn') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition duration-300 flex items-center justify-center gap-2">
                                            <i class="fas fa-sign-in-alt"></i> <span>Check-in Sekarang</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Statistik & Riwayat --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-lg p-6 shadow-lg transition transform hover:-translate-y-1 hover:shadow-2xl">
                         <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-4">
                            <i class="fas fa-chart-pie text-blue-500"></i>
                            Statistik Bulan Ini
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                            <div class="md:col-span-2 h-48">
                                <canvas id="chartAbsensi"></canvas>
                            </div>
                            <div class="text-center md:text-left space-y-2">
                                @php
                                    // Memastikan variabel ada sebelum digunakan
                                    $riwayat = $riwayatAbsensi ?? collect();
                                    $totalHadir = $riwayat->whereIn('status', ['approved', 'divalidasi', 'hadir'])->count();
                                    $totalIzin = $riwayat->whereIn('status', ['izin'])->count();
                                    $totalData = $riwayat->count();
                                    $totalAlpa = $totalData - $totalHadir - $totalIzin;
                                @endphp
                                <div class="p-3 bg-green-50 dark:bg-green-900/40 rounded-lg">
                                    <p class="text-sm text-green-800 dark:text-green-300">Total Hadir</p>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}</p>
                                </div>
                                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/40 rounded-lg">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300">Total Izin</p>
                                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $totalIzin }}</p>
                                </div>
                                <div class="p-3 bg-red-50 dark:bg-red-900/40 rounded-lg">
                                    <p class="text-sm text-red-800 dark:text-red-300">Total Alpa</p>
                                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $totalAlpa }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Riwayat Absensi Terakhir --}}
                    <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-lg shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                               <i class="fas fa-history text-blue-500"></i>
                               Riwayat Absensi Terakhir
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check In</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check Out</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($riwayatAbsensi->take(5) as $absensi)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $absensi->check_in ? \Carbon\Carbon::parse($absensi->check_in)->format('H:i:s') : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $absensi->check_out ? \Carbon\Carbon::parse($absensi->check_out)->format('H:i:s') : '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                {{-- Status Logic Here --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                                <p>Belum ada riwayat absensi.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-6 bg-gray-50 dark:bg-gray-700/50 text-right">
                            <a href="{{ route('karyawan.absensi.index') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">Lihat semua riwayat &rarr;</a>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Kanan --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center transition transform hover:-translate-y-1 hover:shadow-2xl">
                        <img class="h-24 w-24 rounded-full mx-auto mb-4 ring-4 ring-blue-500/50" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="User Avatar">
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">NIP: {{ $user->nip ?? 'Belum diatur' }}</p>
                        <hr class="my-4 dark:border-gray-600">
                        <a href="{{ route('profile.edit') }}" class="w-full inline-block py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                            Edit Profil
                        </a>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg transition transform hover:-translate-y-1 hover:shadow-2xl">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-4">
                            <i class="fas fa-file-alt text-blue-500"></i>
                            Pengajuan Izin
                        </h3>
                        <div class="bg-blue-50 dark:bg-blue-900/50 p-4 rounded-lg text-center mb-4">
                           <p class="text-sm text-blue-800 dark:text-blue-200">Menunggu Persetujuan</p>
                           <p class="font-bold text-4xl text-blue-600 dark:text-blue-300">{{ $pendingIzin ?? 0 }}</p>
                        </div>
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('karyawan.izin.create') }}" class="py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-center transition">
                                Ajukan Izin Baru
                            </a>
                            <a href="{{ route('karyawan.izin.index') }}" class="py-2 px-4 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-semibold rounded-lg text-center transition">
                                Lihat Riwayat Izin
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Theme Toggle
        (function() {
            const themeToggleButton = document.getElementById('theme-toggle-btn');
            const themeIcon = document.getElementById('theme-icon');
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            let currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : (prefersDark ? 'dark' : 'light');

            function applyTheme(theme) {
                if (theme === 'dark') {
                    document.documentElement.classList.add('dark');
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    document.documentElement.classList.remove('dark');
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }

            applyTheme(currentTheme);

            themeToggleButton.addEventListener('click', () => {
                currentTheme = document.documentElement.classList.contains('dark') ? 'light' : 'dark';
                localStorage.setItem('theme', currentTheme);
                applyTheme(currentTheme);
            });
        })();

        // Live Clock
        (function() {
            const clockElement = document.getElementById('live-clock');
            if (clockElement) {
                const updateClock = () => {
                    const now = new Date();
                    clockElement.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                };
                setInterval(updateClock, 1000);
                updateClock();
            }
        })();
        
        // Disable submit buttons on form submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-70', 'cursor-wait');
                    const icon = submitButton.querySelector('i');
                    if (icon) icon.classList.add('animate-spin');
                }
            });
        });
    </script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function(){
            const canvas = document.getElementById('chartAbsensi');
            if (!canvas) return;

            const isDark = document.documentElement.classList.contains('dark');
            const labelColor = isDark ? '#cbd5e1' : '#475569';
            
            new Chart(canvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Hadir', 'Izin', 'Alpa'],
                    datasets: [{
                        data: [{{ $totalHadir }}, {{ $totalIzin }}, {{ $totalAlpa }}],
                        backgroundColor: [
                            '#22c55e', // green-500
                            '#f59e0b', // amber-500
                            '#ef4444'  // red-500
                        ],
                        borderColor: isDark ? '#1e293b' : '#ffffff', // slate-800 or white
                        borderWidth: 2
                    }]
                },
                options: {
                    animation: { animateScale: true, animateRotate: true, duration: 900 },
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: { color: labelColor }
                        }
                    },
                    maintainAspectRatio: false
                }
            });
        })();
    </script>
    @endpush
</x-app-layout>