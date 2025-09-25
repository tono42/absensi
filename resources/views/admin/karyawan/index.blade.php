<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">📋 Daftar Karyawan</h3>
                        <a href="{{ route('admin.karyawan.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1 transition">
                            + Tambah Karyawan
                        </a>
                    </div>

                    {{-- Flash Message --}}
                    @if(session('success'))
                        <div class="mb-4 rounded-md bg-green-100 border border-green-400 px-4 py-3 text-green-700 shadow">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel --}}
                    <div class="overflow-x-auto border rounded-lg shadow-sm">
                        <table class="min-w-full text-sm divide-y divide-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">NIP</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-center font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($karyawan as $user)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->nip }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <div class="flex justify-center gap-2">
                                                <a href="{{ route('admin.karyawan.edit', $user) }}"
                                                   class="px-3 py-1 text-xs bg-yellow-400 text-white rounded shadow hover:bg-yellow-500">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.karyawan.destroy', $user) }}" method="POST"
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-3 py-1 text-xs bg-red-500 text-white rounded shadow hover:bg-red-600">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-6 text-center text-gray-500 italic">
                                            Tidak ada data karyawan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-6">
                        {{ $karyawan->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
