<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                <i class="fas fa-user-tie mr-2 text-blue-600"></i> {{ __('Karyawan Dashboard') }}
            </h2>

            <button id="theme-toggle-btn"
                class="flex items-center gap-2 rounded-lg bg-gray-200 px-3 py-1 text-sm transition hover:scale-105 dark:bg-gray-700">
                <i id="theme-icon" class="fa-solid fa-moon"></i>
                <span id="theme-label" class="sr-only">Toggle Theme</span>
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Selamat Datang Kembali,
                    {{ Auth::user()->name }}!</h1>
                <p class="text-gray-500 dark:text-gray-400">Berikut adalah ringkasan aktivitas absensi Anda.</p>
            </div>

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-6 rounded-md border-l-4 border-green-500 bg-green-100 p-4 text-green-700 shadow-sm"
                    role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-md border-l-4 border-red-500 bg-red-100 p-4 text-red-700 shadow-sm"
                    role="alert">
                    <p class="font-bold">Gagal</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if (session('warning'))
                <div class="mb-6 rounded-md border-l-4 border-yellow-500 bg-yellow-100 p-4 text-yellow-700 shadow-sm"
                    role="alert">
                    <p class="font-bold">Perhatian</p>
                    <p>{{ session('warning') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                <div class="space-y-6 lg:col-span-2">

                    {{-- Absensi Hari Ini --}}
                    <div
                        class="overflow-hidden rounded-lg bg-white p-6 shadow-lg transition hover:-translate-y-1 hover:shadow-2xl dark:bg-gray-800 transform">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="flex items-center gap-3 text-xl font-bold text-gray-900 dark:text-white">
                                <i class="fas fa-clock text-blue-500"></i>
                                Absensi Hari Ini
                            </h3>
                            <div class="text-right">
                                <p id="live-clock" class="text-lg font-semibold text-gray-700 dark:text-gray-300"
                                    aria-live="polite"></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
                            </div>
                        </div>

                        <div class="rounded-lg bg-gray-50 p-6 dark:bg-gray-700/50">
                            @if (isset($absensiToday) && $absensiToday)
                                <div class="grid grid-cols-1 gap-4 text-center sm:grid-cols-3">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Check-in</p>
                                        <p class="text-lg font-bold text-green-600 dark:text-green-400">
                                            {{ $absensiToday->check_in ? \Carbon\Carbon::parse($absensiToday->check_in)->format('H:i:s') : '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Check-out</p>
                                        <p class="text-lg font-bold text-red-500 dark:text-red-400">
                                            {{ $absensiToday->check_out ? \Carbon\Carbon::parse($absensiToday->check_out)->format('H:i:s') : 'Belum' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                                        @php $status = strtolower($absensiToday->status ?? ''); @endphp
                                        @if (in_array($status, ['pending', 'menunggu', 'waiting']))
                                            <span
                                                class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Menunggu
                                                Validasi</span>
                                        @elseif(in_array($status, ['approved', 'divalidasi', 'hadir']))
                                            <span
                                                class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/50 dark:text-green-300">Divalidasi</span>
                                        @else
                                            <span
                                                class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800 dark:bg-red-900/50 dark:text-red-300">Ditolak</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Display Photo and Location if available --}}
                                @if ($absensiToday->photo || ($absensiToday->latitude && $absensiToday->longitude))
                                    <div class="mt-6 border-t border-gray-200 pt-4 text-center dark:border-gray-600">
                                        @if ($absensiToday->photo)
                                            <p class="mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                                Foto Absensi:</p>
                                            <img src="{{ asset('storage/absensi/' . $absensiToday->photo) }}"
                                                alt="Foto Absensi" class="mx-auto mb-4 h-32 w-32 rounded-lg object-cover shadow-sm">
                                        @endif

                                        @if ($absensiToday->latitude && $absensiToday->longitude)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                Lokasi: {{ $absensiToday->latitude }}, {{ $absensiToday->longitude }}
                                            </p>
                                            <a href="https://www.google.com/maps?q={{ $absensiToday->latitude }},{{ $absensiToday->longitude }}"
                                                target="_blank"
                                                class="text-blue-600 underline hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                                Lihat di Google Maps
                                            </a>
                                        @endif
                                    </div>
                                @endif

                                @if (!$absensiToday->check_out)
                                    <form action="{{ route('karyawan.absensi.checkOut') }}" method="POST"
                                        class="mt-6">
                                        @csrf
                                        <button type="submit"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-3 font-bold text-white shadow-md transition duration-300 hover:bg-red-700">
                                            <i class="fas fa-sign-out-alt"></i> <span>Check-out Sekarang</span>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <div class="text-center">
                                    <p class="mb-4 text-gray-600 dark:text-gray-300">Anda belum melakukan absensi hari
                                        ini. Silakan Check-in.</p>
                                    <form action="{{ route('karyawan.absensi.checkIn') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-4 text-center">
                                            <video id="camera" autoplay playsinline
                                                class="mx-auto h-48 w-64 rounded-lg border object-cover"></video>
                                            <canvas id="snapshot" class="hidden"></canvas>
                                            <input type="hidden" name="photo" id="photoInput">
                                        </div>
                                        <button type="button" id="takePhoto"
                                            class="mb-3 rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 transition">
                                            Ambil Foto
                                        </button>
                                        <input type="hidden" name="latitude" id="latitude">
                                        <input type="hidden" name="longitude" id="longitude">
                                        <button type="submit"
                                            class="flex w-full items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-3 font-bold text-white shadow-md transition duration-300 hover:bg-green-700">
                                            <i class="fas fa-sign-in-alt"></i> <span>Check-in Sekarang</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Statistik & Riwayat --}}
                    <div
                        class="overflow-hidden rounded-lg bg-white p-6 shadow-lg transition hover:-translate-y-1 hover:shadow-2xl dark:bg-gray-800 transform">
                        <h3 class="mb-4 flex items-center gap-3 text-xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-chart-pie text-blue-500"></i>
                            Statistik Bulan Ini
                        </h3>
                        <div class="grid grid-cols-1 items-center gap-6 md:grid-cols-3">
                            <div class="h-48 md:col-span-2">
                                <canvas id="chartAbsensi"></canvas>
                            </div>
                            <div class="space-y-2 text-center md:text-left">
                                @php
                                    // Memastikan variabel ada sebelum digunakan
                                    $riwayat = $riwayatAbsensi ?? collect();
                                    $totalHadir = $riwayat->whereIn('status', ['approved', 'divalidasi', 'hadir'])->count();
                                    $totalIzin = $riwayat->whereIn('status', ['izin'])->count();
                                    $totalData = $riwayat->count();
                                    $totalAlpa = $totalData - $totalHadir - $totalIzin;
                                @endphp
                                <div class="rounded-lg bg-green-50 p-3 dark:bg-green-900/40">
                                    <p class="text-sm text-green-800 dark:text-green-300">Total Hadir</p>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalHadir }}
                                    </p>
                                </div>
                                <div class="rounded-lg bg-yellow-50 p-3 dark:bg-yellow-900/40">
                                    <p class="text-sm text-yellow-800 dark:text-yellow-300">Total Izin</p>
                                    <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $totalIzin }}
                                    </p>
                                </div>
                                <div class="rounded-lg bg-red-50 p-3 dark:bg-red-900/40">
                                    <p class="text-sm text-red-800 dark:text-red-300">Total Alpa</p>
                                    <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $totalAlpa }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Riwayat Absensi Terakhir --}}
                    <div class="overflow-hidden rounded-lg bg-white shadow-lg dark:bg-gray-800">
                        <div class="p-6">
                            <h3 class="flex items-center gap-3 text-xl font-bold text-gray-900 dark:text-white">
                                <i class="fas fa-history text-blue-500"></i>
                                Riwayat Absensi Terakhir
                            </h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Check In</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Check Out</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-300">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                                    @forelse($riwayatAbsensi->take(5) as $absensi)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <td
                                                class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d M Y') }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                                {{ $absensi->check_in ? \Carbon\Carbon::parse($absensi->check_in)->format('H:i:s') : '-' }}
                                            </td>
                                            <td
                                                class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 dark:text-gray-300">
                                                {{ $absensi->check_out ? \Carbon\Carbon::parse($absensi->check_out)->format('H:i:s') : '-' }}
                                            </td>
                                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                                @php $status = strtolower($absensi->status ?? ''); @endphp
                                                @if (in_array($status, ['pending', 'menunggu', 'waiting']))
                                                    <span
                                                        class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Menunggu
                                                        Validasi</span>
                                                @elseif(in_array($status, ['approved', 'divalidasi', 'hadir']))
                                                    <span
                                                        class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800 dark:bg-green-900/50 dark:text-green-300">Divalidasi</span>
                                                @elseif(in_array($status, ['izin']))
                                                    <span
                                                        class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800 dark:bg-blue-900/50 dark:text-blue-300">Izin</span>
                                                @else
                                                    <span
                                                        class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800 dark:bg-red-900/50 dark:text-red-300">Ditolak</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                                <p>Belum ada riwayat absensi.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-50 p-6 text-right dark:bg-gray-700/50">
                            <a href="{{ route('karyawan.absensi.index') }}"
                                class="text-sm font-medium text-blue-600 transition hover:underline dark:text-blue-400">Lihat
                                semua riwayat &rarr;</a>
                        </div>
                    </div>
                </div>

                {{-- Sidebar Kanan --}}
                <div class="space-y-6 lg:col-span-1">
                    <div
                        class="rounded-lg bg-white p-6 text-center shadow-lg transition hover:-translate-y-1 hover:shadow-2xl dark:bg-gray-800 transform">
                        <img class="mx-auto mb-4 h-24 w-24 rounded-full ring-4 ring-blue-500/50"
                            src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff"
                            alt="User Avatar">
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->name }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">NIP: {{ $user->nip ?? 'Belum diatur' }}</p>
                        <hr class="my-4 dark:border-gray-600">
                        <a href="{{ route('profile.edit') }}"
                            class="inline-block w-full rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                            Edit Profil
                        </a>
                    </div>

                    <div
                        class="rounded-lg bg-white p-6 shadow-lg transition hover:-translate-y-1 hover:shadow-2xl dark:bg-gray-800 transform">
                        <h3 class="mb-4 flex items-center gap-3 text-xl font-bold text-gray-900 dark:text-white">
                            <i class="fas fa-file-alt text-blue-500"></i>
                            Pengajuan Izin
                        </h3>
                        <div class="mb-4 rounded-lg bg-blue-50 p-4 text-center dark:bg-blue-900/50">
                            <p class="text-sm text-blue-800 dark:text-blue-200">Menunggu Persetujuan</p>
                            <p class="text-4xl font-bold text-blue-600 dark:text-blue-300">{{ $pendingIzin ?? 0 }}</p>
                        </div>
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('karyawan.izin.create') }}"
                                class="rounded-lg bg-blue-600 px-4 py-2 text-center font-semibold text-white transition hover:bg-blue-700">
                                Ajukan Izin Baru
                            </a>
                            <a href="{{ route('karyawan.izin.index') }}"
                                class="rounded-lg bg-gray-200 px-4 py-2 text-center font-semibold text-gray-800 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
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
                let currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : (prefersDark ? 'dark' :
                    'light');

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

            // Camera and Photo Capture
            const video = document.getElementById('camera');
            const canvas = document.getElementById('snapshot');
            const photoInput = document.getElementById('photoInput');
            const takePhotoBtn = document.getElementById('takePhoto');

            if (video && canvas && photoInput && takePhotoBtn) {
                navigator.mediaDevices.getUserMedia({
                        video: true
                    })
                    .then(stream => {
                        video.srcObject = stream;
                    })
                    .catch(err => {
                        console.error("Kamera tidak bisa diakses: ", err);
                        alert("Kamera tidak bisa diakses: " + err.message);
                    });

                takePhotoBtn.addEventListener('click', () => {
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);
                    let dataUrl = canvas.toDataURL('image/png');
                    photoInput.value = dataUrl; // base64 string
                });
            }


            // Live Clock
            (function() {
                const clockElement = document.getElementById('live-clock');
                if (clockElement) {
                    const updateClock = () => {
                        const now = new Date();
                        clockElement.textContent = now.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });
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

            // Geolocation
            (function() {
                const latitudeInput = document.getElementById('latitude');
                const longitudeInput = document.getElementById('longitude');

                // Only attempt to get geolocation if the inputs exist (i.e., on the check-in form)
                if (latitudeInput && longitudeInput && document.querySelector('form[action="{{ route('karyawan.absensi.checkIn') }}"]')) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            latitudeInput.value = position.coords.latitude;
                            longitudeInput.value = position.coords.longitude;
                        }, function(error) {
                            console.error("Gagal ambil lokasi: ", error);
                            alert("Gagal mengambil lokasi Anda. Pastikan izin lokasi diberikan. " + error.message);
                        });
                    } else {
                        alert("Geolocation tidak didukung oleh browser Anda.");
                    }
                }
            })();
        </script>

        {{-- Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function() {
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
                                '#ef4444' // red-500
                            ],
                            borderColor: isDark ? '#1e293b' : '#ffffff', // slate-800 or white
                            borderWidth: 2
                        }]
                    },
                    options: {
                        animation: {
                            animateScale: true,
                            animateRotate: true,
                            duration: 900
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: labelColor
                                }
                            }
                        },
                        maintainAspectRatio: false
                    }
                });
            })();
        </script>
    @endpush
</x-app-layout>