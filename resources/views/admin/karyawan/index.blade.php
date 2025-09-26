<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-200 leading-tight flex items-center gap-2">
            <i class="fa-solid fa-users-cog text-blue-600 dark:text-blue-400"></i>
            {{ __('Manajemen Karyawan') }}
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

            {{-- Main Content Card --}}
            <section class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">📋 Daftar Karyawan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data, edit, dan hapus akun karyawan.</p>
                        </div>
                        <a href="{{ route('admin.karyawan.create') }}" class="w-full md:w-auto flex-shrink-0 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all duration-300 flex items-center justify-center gap-2 transform hover:scale-105">
                            <i class="fas fa-plus"></i> <span>Tambah Karyawan Baru</span>
                        </a>
                    </div>

                    {{-- Search Form --}}
                    <form action="{{ route('admin.karyawan.index') }}" method="GET" class="mt-6">
                        <div class="flex items-center">
                            <label for="search" class="sr-only">Cari Karyawan</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" id="search" value="{{ request('search') }}"
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white dark:bg-gray-700 dark:border-gray-600 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                       placeholder="Cari berdasarkan nama, NIP, atau email...">
                            </div>
                            <button type="submit" class="ml-3 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">Cari</button>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Nama Karyawan</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">NIP</th>
                                <th class="px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-300 uppercase">Email</th>
                                <th class="px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($karyawan as $user)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" alt="Avatar">
                                            </div>
                                            <div class="ml-4">
                                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">{{ $user->nip }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center items-center gap-2">
                                            <a href="{{ route('admin.karyawan.edit', $user) }}" class="px-3 py-1 text-xs bg-yellow-500 text-white rounded-md shadow-sm hover:bg-yellow-600 transition-all transform hover:scale-105" title="Edit Karyawan">
                                                <i class="fas fa-pencil-alt"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.karyawan.destroy', $user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus karyawan ini? Tindakan ini tidak dapat dibatalkan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-3 py-1 text-xs bg-red-500 text-white rounded-md shadow-sm hover:bg-red-600 transition-all transform hover:scale-105" title="Hapus Karyawan">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-user-slash text-4xl mb-2"></i>
                                        <p>Tidak ada data karyawan yang ditemukan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($karyawan->hasPages())
                <div class="p-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
                    {{ $karyawan->links() }}
                </div>
                @endif
            </section>
        </div>
    </div>
</x-app-layout>