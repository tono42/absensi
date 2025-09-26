<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-file-signature text-blue-600 dark:text-blue-400"></i>
            {{ __('Manajemen Pengajuan Izin') }}
        </h2>
    </x-slot>

    <div class="py-10" x-data="izinPage">
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
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4">
                    <div class="bg-yellow-100 dark:bg-yellow-900/40 p-3 rounded-full"><i class="fas fa-hourglass-half text-2xl text-yellow-500"></i></div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu Validasi</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pendingCount ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4">
                    <div class="bg-green-100 dark:bg-green-900/40 p-3 rounded-full"><i class="fas fa-check-double text-2xl text-green-500"></i></div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Disetujui</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $approvedCount ?? 0 }}</p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow-md flex items-center gap-4">
                    <div class="bg-red-100 dark:bg-red-900/40 p-3 rounded-full"><i class="fas fa-times-circle text-2xl text-red-500"></i></div>
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sudah Ditolak</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $rejectedCount ?? 0 }}</p>
                    </div>
                </div>
            </section>

            {{-- Main Content Card --}}
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Laporan & Validasi Pengajuan Izin</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Filter, cari, dan validasi data pengajuan izin dari karyawan.</p>
                    
                    {{-- Filter Form --}}
                    <form method="GET" action="{{ route('admin.izin.index') }}" class="mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama karyawan..." class="md:col-span-2 lg:col-span-1 mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                            <select name="jenis_izin" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Jenis Izin</option>
                                <option value="Sakit" @selected(request('jenis_izin') == 'Sakit')>Sakit</option>
                                <option value="Cuti" @selected(request('jenis_izin') == 'Cuti')>Cuti</option>
                                <option value="Izin Pribadi" @selected(request('jenis_izin') == 'Izin Pribadi')>Izin Pribadi</option>
                                <option value="Perjalanan Dinas" @selected(request('jenis_izin') == 'Perjalanan Dinas')>Perjalanan Dinas</option>
                            </select>
                            <select name="status" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending" @selected(request('status') == 'pending')>Menunggu</option>
                                <option value="approved" @selected(request('status') == 'approved')>Disetujui</option>
                                <option value="rejected" @selected(request('status') == 'rejected')>Ditolak</option>
                            </select>
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition"><i class="fas fa-filter mr-2"></i>Filter</button>
                                <a href="{{ route('admin.izin.index') }}" class="w-full flex items-center justify-center px-4 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-semibold rounded-lg transition" title="Reset Filter">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Karyawan</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Jenis Izin</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Periode</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300 uppercase">Bukti</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($izin as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($item->user->name) }}&background=random&color=fff" alt="Avatar">
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $item->user->name }}</div>
                                                <div class="text-gray-500 dark:text-gray-400">NIP: {{ $item->user->nip }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-200 capitalize">{{ $item->jenis_izin }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->translatedFormat('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->translatedFormat('d M Y') }}</td>
                                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300 truncate max-w-xs" title="{{ $item->keterangan }}">{{ $item->keterangan }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->file_bukti)
                                            <a href="{{ url('storage/' . $item->file_bukti) }}" target="_blank" class="text-blue-500 hover:text-blue-700 transition" title="Lihat Bukti"><i class="fas fa-file-download fa-lg"></i></a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'pending')
                                            <span class="px-2 py-1 font-semibold text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300">Menunggu</span>
                                        @elseif($item->status == 'approved')
                                            <span class="px-2 py-1 font-semibold text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">Disetujui</span>
                                        @else
                                            <span class="px-2 py-1 font-semibold text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->status == 'pending')
                                            <div class="flex justify-center items-center gap-2">
                                                <button @click="openModal('{{ route('admin.izin.validate', $item) }}', 'approved', '{{ $item->user->name }}')" class="px-3 py-1 text-xs bg-green-500 text-white rounded-md hover:bg-green-600 transition" title="Approve">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button @click="openModal('{{ route('admin.izin.validate', $item) }}', 'rejected', '{{ $item->user->name }}')" class="px-3 py-1 text-xs bg-red-500 text-white rounded-md hover:bg-red-600 transition" title="Reject">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-folder-open text-4xl mb-2"></i>
                                        <p>Tidak ada data pengajuan izin yang cocok dengan filter Anda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if ($izin->hasPages())
                <div class="p-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $izin->withQueryString()->links() }}
                </div>
                @endif
            </section>
        </div>

        <div x-show="showModal" @keydown.escape.window="closeModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="closeModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form :action="formAction" method="POST">
                        @csrf
                        <input type="hidden" name="status" :value="formStatus">
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full sm:mx-0 sm:h-10 sm:w-10" :class="formStatus === 'approved' ? 'bg-green-100' : 'bg-red-100'">
                                    <i class="fa-solid" :class="formStatus === 'approved' ? 'fa-check text-green-600' : 'fa-times text-red-600'"></i>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Konfirmasi Validasi Izin</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Anda akan <b :class="formStatus === 'approved' ? 'text-green-600' : 'text-red-600'" x-text="formStatus === 'approved' ? 'menyetujui' : 'menolak'"></b> pengajuan izin untuk <b class="text-gray-800 dark:text-gray-200" x-text="karyawanName"></b>. Lanjutkan?
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white sm:ml-3 sm:w-auto sm:text-sm" :class="formStatus === 'approved' ? 'bg-green-600 hover:bg-green-700' : 'bg-red-600 hover:bg-red-700'">
                                Ya, Lanjutkan
                            </button>
                            <button @click.prevent="closeModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('izinPage', () => ({
                showModal: false,
                formAction: '',
                formStatus: '',
                karyawanName: '',
                openModal(action, status, name) {
                    this.formAction = action;
                    this.formStatus = status;
                    this.karyawanName = name;
                    this.showModal = true;
                },
                closeModal() {
                    this.showModal = false;
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>