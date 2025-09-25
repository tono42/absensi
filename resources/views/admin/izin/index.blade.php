<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pengajuan Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-6 border-b pb-2">
                        Validasi Pengajuan Izin
                    </h3>

                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Filter -->
                    <form method="GET" action="{{ route('admin.izin.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
                        <div>
                            <x-input-label for="status" :value="__('Filter Status')" />
                            <select id="status" name="status" 
                                class="mt-1 block w-40 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <x-primary-button type="submit">Filter</x-primary-button>
                        <a href="{{ route('admin.izin.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-200 focus:outline-none">
                           Reset
                        </a>
                    </form>

                    <!-- Tabel -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 divide-y divide-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Karyawan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Jenis Izin</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Periode</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Keterangan</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Bukti</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($izin as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $item->user->name }}</td>
                                        <td class="px-6 py-4">{{ $item->jenis_izin }}</td>
                                        <td class="px-6 py-4">{{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                            <span class="line-clamp-2">{{ $item->keterangan }}</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($item->file_bukti)
                                                <a href="{{ url('storage/' . $item->file_bukti) }}" target="_blank" class="text-blue-600 hover:underline">Lihat Bukti</a>
                                            @else
                                                <span class="text-gray-500 italic">Tidak ada</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($item->status == 'pending')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($item->status == 'approved')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium space-x-2">
                                            @if($item->status == 'pending')
                                                <form action="{{ route('admin.izin.validate', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.izin.validate', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada pengajuan izin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $izin->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
