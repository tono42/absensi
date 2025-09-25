<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Ajukan Izin Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Error Handling --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                    <p class="font-bold">Terjadi Kesalahan</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="list-disc ml-5">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg transition hover:shadow-2xl hover:scale-[1.01]">
                <div class="p-6 md:p-8">
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <i class="fas fa-file-signature text-blue-500"></i>
                            Formulir Pengajuan Izin
                        </h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Pastikan semua data diisi dengan benar. Izin sakit wajib melampirkan surat dokter sebagai bukti.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('karyawan.izin.store') }}" enctype="multipart/form-data" class="space-y-6" id="izinForm">
                        @csrf

                        {{-- Jenis Izin --}}
                        <div>
                            <x-input-label for="jenis_izin" value="Jenis Izin" />
                            <select id="jenis_izin" name="jenis_izin"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                       focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="" disabled selected>Pilih Jenis Izin</option>
                                <option value="Sakit" @selected(old('jenis_izin') == 'Sakit')>Sakit</option>
                                <option value="Cuti" @selected(old('jenis_izin') == 'Cuti')>Cuti</option>
                                <option value="Izin Pribadi" @selected(old('jenis_izin') == 'Izin Pribadi')>Izin Pribadi</option>
                                <option value="Perjalanan Dinas" @selected(old('jenis_izin') == 'Perjalanan Dinas')>Perjalanan Dinas</option>
                            </select>
                        </div>

                        {{-- Tanggal --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="tanggal_mulai" value="Tanggal Mulai" />
                                <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="date"
                                    name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_selesai" value="Tanggal Selesai" />
                                <x-text-input id="tanggal_selesai" class="block mt-1 w-full" type="date"
                                    name="tanggal_selesai" :value="old('tanggal_selesai')" required />
                            </div>
                        </div>

                        {{-- Keterangan --}}
                        <div>
                            <x-input-label for="keterangan" value="Keterangan" />
                            <textarea id="keterangan" name="keterangan" rows="4"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 
                                       focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- File Upload --}}
                        <div x-data="{ fileName: '' }">
                            <x-input-label for="file_bukti" value="File Bukti (Opsional - PDF, JPG, PNG, maks 2MB)" />
                            <label for="file_bukti"
                                class="mt-1 flex justify-center w-full h-32 px-6 pt-5 pb-6 border-2 border-gray-300 
                                       dark:border-gray-600 border-dashed rounded-md cursor-pointer hover:border-blue-400 
                                       dark:hover:border-blue-500 transition">
                                <div class="space-y-1 text-center">
                                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Klik untuk upload atau drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, PDF up to 2MB</p>
                                    <p x-text="fileName" class="text-xs text-green-500 font-semibold"></p>
                                </div>
                                <input id="file_bukti" name="file_bukti" type="file" class="sr-only"
                                    @change="fileName = $event.target.files.length > 0 ? $event.target.files[0].name : ''">
                            </label>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700 space-x-4">
                            <a href="{{ route('karyawan.izin.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 
                                       dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 
                                       uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-600 
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition">
                                Kembali
                            </a>
                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 
                                       active:bg-blue-800 focus:ring-blue-500 text-white text-xs font-semibold uppercase 
                                       tracking-widest rounded-md shadow-sm transition">
                                <span id="btnText">{{ __('Ajukan Izin') }}</span>
                                <svg id="btnSpinner" class="hidden ml-2 w-4 h-4 animate-spin text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v8z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Loading spinner on submit
        document.getElementById('izinForm').addEventListener('submit', function () {
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('btnText').textContent = "Mengirim...";
            document.getElementById('btnSpinner').classList.remove('hidden');
        });
    </script>
    @endpush
</x-app-layout>
