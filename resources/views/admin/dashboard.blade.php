<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-lg font-medium text-gray-900">
                        Selamat datang, <span class="font-bold">Admin {{ Auth::user()->name }}</span> 🎉
                    </h3>

                    {{-- Statistik Ringkas --}}
                    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-100 p-5 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-blue-800">Total Karyawan</h4>
                            <p class="text-3xl font-bold mt-2 text-blue-900">{{ $totalKaryawan }}</p>
                        </div>
                        <div class="bg-yellow-100 p-5 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-yellow-800">Absensi Perlu Validasi</h4>
                            <p class="text-3xl font-bold mt-2 text-yellow-900">{{ $pendingAbsensi }}</p>
                        </div>
                        <div class="bg-red-100 p-5 rounded-lg shadow hover:shadow-md transition">
                            <h4 class="font-semibold text-red-800">Izin Perlu Validasi</h4>
                            <p class="text-3xl font-bold mt-2 text-red-900">{{ $pendingIzin }}</p>
                        </div>
                    </div>

                    {{-- Absensi Pending --}}
                    <h4 class="text-lg font-medium text-gray-900 mt-10">📌 Absensi Terbaru Perlu Validasi</h4>

                    @if($absensiToValidate->isEmpty())
                        <p class="mt-3 text-gray-600 italic">Tidak ada absensi yang perlu divalidasi.</p>
                    @else
                        <div class="overflow-x-auto mt-5 border rounded-lg shadow-sm">
                            <table class="min-w-full divide-y divide-gray-200 text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Nama Karyawan</th>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Tanggal</th>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Check In</th>
                                        <th class="px-6 py-3 text-left font-semibold text-gray-600">Status</th>
                                        <th class="px-6 py-3 text-center font-semibold text-gray-600">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($absensiToValidate as $absensi)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->tanggal }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $absensi->check_in }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-3 py-1 inline-flex text-xs font-medium rounded-full 
                                                    {{ $absensi->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($absensi->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <form action="{{ route('admin.absensi.validate', $absensi) }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="px-3 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600 shadow">
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.absensi.validate', $absensi) }}" method="POST" class="inline ml-2">
                                                    @csrf
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="px-3 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600 shadow">
                                                        Reject
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
