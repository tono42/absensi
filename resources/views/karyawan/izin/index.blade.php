<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-clipboard-list text-blue-600 dark:text-blue-400"></i>
            {{ __('Riwayat Pengajuan Izin Saya') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Success Alert --}}
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/40 border-l-4 border-green-600 p-4 rounded-lg shadow-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-check text-green-600 mt-1"></i>
                    <div>
                        <p class="font-bold text-green-700 dark:text-green-300">Sukses</p>
                        <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Summary Cards --}}
            <section>
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Ringkasan Izin Anda</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    {{-- Pending --}}
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-yellow-500 border-2 border-transparent transition-all duration-300">
                        <div class="bg-yellow-100 dark:bg-yellow-900/40 p-3 rounded-full">
                            <i class="fas fa-hourglass-half text-2xl text-yellow-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingCount ?? 0 }}</p>
                        </div>
                    </div>
                    {{-- Approved --}}
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-green-500 border-2 border-transparent transition-all duration-300">
                        <div class="bg-green-100 dark:bg-green-900/40 p-3 rounded-full">
                            <i class="fas fa-check-double text-2xl text-green-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $approvedCount ?? 0 }}</p>
                        </div>
                    </div>
                    {{-- Rejected --}}
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-red-500 border-2 border-transparent transition-all duration-300">
                        <div class="bg-red-100 dark:bg-red-900/40 p-3 rounded-full">
                            <i class="fas fa-times-circle text-2xl text-red-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Ditolak</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $rejectedCount ?? 0 }}</p>
                        </div>
                    </div>
                    {{-- Annual Leave --}}
                    <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4 hover:shadow-lg hover:border-blue-500 border-2 border-transparent transition-all duration-300">
                        <div class="bg-blue-100 dark:bg-blue-900/40 p-3 rounded-full">
                            <i class="fas fa-calendar-check text-2xl text-blue-500"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Sisa Cuti Tahunan</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $sisaCuti ?? 12 }}</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Table Section --}}
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                         <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Detail Riwayat Pengajuan Izin</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Menampilkan semua pengajuan izin yang pernah Anda buat.</p>
                         </div>
                         <a href="{{ route('karyawan.izin.create') }}" class="w-full md:w-auto flex-shrink-0 px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-all duration-300 flex items-center justify-center gap-2 transform hover:scale-105">
                            <i class="fas fa-plus"></i> <span>Ajukan Izin Baru</span>
                        </a>
                    </div>
                    
                    {{-- Filter Form --}}
                    <form action="{{ route('karyawan.izin.index') }}" method="GET" class="mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                            <div>
                                <label for="jenis_izin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Izin</label>
                                <select name="jenis_izin" id="jenis_izin" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Semua</option>
                                    <option value="Sakit" @selected(request('jenis_izin') == 'Sakit')>Sakit</option>
                                    <option value="Cuti" @selected(request('jenis_izin') == 'Cuti')>Cuti</option>
                                    <option value="Izin Pribadi" @selected(request('jenis_izin') == 'Izin Pribadi')>Izin Pribadi</option>
                                    <option value="Perjalanan Dinas" @selected(request('jenis_izin') == 'Perjalanan Dinas')>Perjalanan Dinas</option>
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Semua</option>
                                    <option value="pending" @selected(request('status') == 'pending')>Menunggu</option>
                                    <option value="approved" @selected(request('status') == 'approved')>Disetujui</option>
                                    <option value="rejected" @selected(request('status') == 'rejected')>Ditolak</option>
                                </select>
                            </div>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300">
                                    <i class="fas fa-filter mr-2"></i> Filter
                                </button>
                                <a href="{{ route('karyawan.izin.index') }}" class="w-full flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-semibold rounded-lg transition-all duration-300" title="Hapus Filter">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Jenis Izin</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Periode</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300 uppercase">Bukti</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Diajukan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($izin as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors duration-200">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100 capitalize">{{ $item->jenis_izin }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M Y') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs" title="{{ $item->keterangan }}">
                                        {{ $item->keterangan }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->file_bukti)
                                            <a href="{{ url('storage/' . $item->file_bukti) }}" target="_blank" class="text-blue-500 hover:text-blue-700 transition-colors" title="Lihat Bukti">
                                                <i class="fas fa-file-download fa-lg"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($item->status == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Menunggu</span>
                                        @elseif($item->status == 'approved')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Disetujui</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $item->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-folder-open text-4xl mb-2"></i>
                                        <p>Tidak ada data riwayat izin yang cocok dengan filter Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if ($izin->hasPages())
                <div class="p-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $izin->links() }}
                </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>