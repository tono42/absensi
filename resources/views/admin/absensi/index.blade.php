<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Validasi dan Laporan Absensi
                    </h3>

                    {{-- Alert sukses --}}
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Filter --}}
                    <form method="GET" action="{{ route('admin.absensi.index') }}" class="mb-6 flex flex-wrap items-end gap-4">
                        <div>
                            <x-input-label for="tanggal" :value="__('Filter Tanggal')" />
                            <x-text-input id="tanggal" type="date" name="tanggal" :value="request('tanggal')" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Filter Status')" />
                            <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-primary-button type="submit">Filter</x-primary-button>
                            <a href="{{ route('admin.absensi.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                Reset
                            </a>
                        </div>
                    </form>

                    {{-- Tabel Absensi --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Karyawan</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Check In</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Check Out</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($absensi as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->tanggal }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->check_in ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->check_out ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($item->status == 'pending')
                                                <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                            @elseif($item->status == 'approved')
                                                <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                            @else
                                                <span class="px-2 py-1 inline-flex text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if($item->status == 'pending')
                                                <form action="{{ route('admin.absensi.validate', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900 mr-2">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.absensi.validate', $item) }}" method="POST" class="inline">
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
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data absensi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $absensi->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
