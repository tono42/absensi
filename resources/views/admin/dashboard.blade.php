<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-blue-600 dark:text-blue-400"></i>
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome Message --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Selamat datang, <span class="text-blue-600 dark:text-blue-400">{{ Auth::user()->name }}</span>!
                </h3>
                <p class="mt-1 text-gray-500 dark:text-gray-400">Berikut adalah ringkasan sistem absensi hari ini.</p>
            </div>

            {{-- Quick Stats Cards --}}
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Total Karyawan --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-blue-500 border-2 border-transparent transition-all duration-300">
                    <div class="bg-blue-100 dark:bg-blue-900/40 p-3 rounded-full">
                        <i class="fas fa-users text-2xl text-blue-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Karyawan</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalKaryawan ?? 0 }}</p>
                    </div>
                </div>
                {{-- Absensi Perlu Validasi --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-yellow-500 border-2 border-transparent transition-all duration-300">
                    <div class="bg-yellow-100 dark:bg-yellow-900/40 p-3 rounded-full">
                        <i class="fas fa-clock-rotate-left text-2xl text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Absensi Pending</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingAbsensi ?? 0 }}</p>
                    </div>
                </div>
                {{-- Izin Perlu Validasi --}}
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-red-500 border-2 border-transparent transition-all duration-300">
                    <div class="bg-red-100 dark:bg-red-900/40 p-3 rounded-full">
                        <i class="fas fa-file-circle-question text-2xl text-red-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Izin Pending</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingIzin ?? 0 }}</p>
                    </div>
                </div>
                {{-- Kehadiran Hari Ini --}}
                 <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-green-500 border-2 border-transparent transition-all duration-300">
                    <div class="bg-green-100 dark:bg-green-900/40 p-3 rounded-full">
                        <i class="fas fa-user-check text-2xl text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Hadir Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $hadirHariIni ?? 0 }}</p>
                    </div>
                </div>
            </section>

            {{-- Charts & Quick Links --}}
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Bar Chart --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Statistik Kehadiran Mingguan</h3>
                    <div class="h-64">
                         <canvas id="attendanceChart"></canvas>
                    </div>
                </div>
                {{-- Quick Links --}}
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-6">
                     <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Akses Cepat</h3>
                     <div class="space-y-3">
                         <a href="{{ route('admin.karyawan.index') }}" class="w-full flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                             <i class="fas fa-users-cog text-blue-500"></i>
                             <span class="font-semibold text-gray-700 dark:text-gray-300">Manajemen Karyawan</span>
                         </a>
                         <a href="{{ route('admin.absensi.index') }}" class="w-full flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                             <i class="fas fa-calendar-alt text-green-500"></i>
                             <span class="font-semibold text-gray-700 dark:text-gray-300">Kelola Absensi</span>
                         </a>
                         <a href="{{ route('admin.izin.index') }}" class="w-full flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                             <i class="fas fa-file-export text-yellow-500"></i>
                             <span class="font-semibold text-gray-700 dark:text-gray-300">Kelola Izin</span>
                         </a>
                         <a href="#" class="w-full flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                             <i class="fas fa-file-invoice text-red-500"></i>
                             <span class="font-semibold text-gray-700 dark:text-gray-300">Laporan & Rekap</span>
                         </a>
                     </div>
                </div>
            </section>

            {{-- Pending Validation Table --}}
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">📌 Absensi Terbaru Perlu Validasi</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Segera setujui atau tolak pengajuan absensi berikut.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Nama Karyawan</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Check In</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($absensiToValidate as $absensi)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-gray-100">{{ $absensi->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($absensi->tanggal)->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($absensi->check_in)->format('H:i:s') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Menunggu</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                        <form action="{{ route('admin.absensi.validate', $absensi) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menyetujui absensi ini?');">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="px-3 py-1 text-xs bg-green-500 text-white rounded-md hover:bg-green-600 shadow-sm transition transform hover:scale-105" title="Approve">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.absensi.validate', $absensi) }}" method="POST" class="inline" onsubmit="return confirm('Anda yakin ingin menolak absensi ini?');">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="px-3 py-1 text-xs bg-red-500 text-white rounded-md hover:bg-red-600 shadow-sm transition transform hover:scale-105" title="Reject">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-check-circle text-4xl mb-2 text-green-500"></i>
                                        <p>Tidak ada absensi yang perlu divalidasi saat ini. Kerja bagus!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
        const labelColor = isDark ? '#cbd5e1' : '#475569';
        
        // Dummy data for weekly attendance chart
        const weeklyData = {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            present: [95, 98, 92, 88, 99, 50, 45], // in percent
        };

        // Attendance Bar Chart
        const attendanceCanvas = document.getElementById('attendanceChart');
        if (attendanceCanvas) {
            new Chart(attendanceCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: weeklyData.labels,
                    datasets: [{
                        label: 'Persentase Kehadiran (%)',
                        data: weeklyData.present,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 5,
                        hoverBackgroundColor: 'rgba(59, 130, 246, 0.8)'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { color: gridColor },
                            ticks: { color: labelColor }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: labelColor }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
    });
    </script>
    @endpush
</x-app-layout>