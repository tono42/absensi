<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="themeSwitcher" :class="{ 'dark': isDark }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Absensi Pegawai - PDAM Tirta Intan Garut</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.8s ease-out, transform 0.8s ease-out;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-gray-800 dark:text-gray-200 font-sans transition-colors duration-300">

    <header x-data="{ open: false }" class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg sticky top-0 z-50 shadow-sm border-b border-white/20">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-between items-center py-4">
            <a href="#" class="flex items-center gap-3">
                <svg class="h-8 w-8 text-teal-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="font-bold text-xl text-gray-800 dark:text-white">Absensi PDAM</span>
            </a>
            
            <div class="hidden md:flex items-center gap-8 font-semibold text-gray-600 dark:text-gray-300">
                <a href="#fitur" class="hover:text-teal-500 transition-colors duration-300">Fitur Unggulan</a>
                <a href="#tentang" class="hover:text-teal-500 transition-colors duration-300">Tentang Sistem</a>
            </div>

            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-2.5 bg-teal-600 text-white font-semibold rounded-full shadow-lg shadow-teal-500/20 hover:bg-teal-700 transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                    Login Pegawai
                </a>
                
                <button @click="toggleTheme" title="Ganti Tema" class="hidden md:flex w-11 h-11 items-center justify-center rounded-full text-gray-600 dark:text-gray-300 bg-gray-200/50 dark:bg-slate-800/50 hover:bg-gray-200 dark:hover:bg-slate-800 transition-all duration-300">
                    <i class="fas" :class="isDark ? 'fa-sun' : 'fa-moon'"></i>
                </button>

                <div class="md:hidden">
                    <button @click="open = !open" class="w-11 h-11 flex items-center justify-center text-gray-800 dark:text-white focus:outline-none">
                        <i class="fas" :class="open ? 'fa-times fa-xl' : 'fa-bars fa-lg'"></i>
                    </button>
                </div>
            </div>
        </nav>
        
        <div x-show="open" x-transition class="md:hidden bg-white dark:bg-slate-900 pb-4 px-6 space-y-3">
            <a href="#fitur" @click="open = false" class="block py-2 text-gray-600 dark:text-gray-300 font-semibold hover:text-teal-500">Fitur Unggulan</a>
            <a href="#tentang" @click="open = false" class="block py-2 text-gray-600 dark:text-gray-300 font-semibold hover:text-teal-500">Tentang Sistem</a>
             <button @click="toggleTheme" class="flex items-center gap-3 py-2 text-gray-600 dark:text-gray-300 font-semibold">
                <i class="fas w-5" :class="isDark ? 'fa-sun' : 'fa-moon'"></i>
                <span x-text="isDark ? 'Mode Terang' : 'Mode Gelap'"></span>
            </button>
        </div>
    </header>

    <section class="relative bg-gradient-to-br from-green-50 to-teal-100 dark:from-slate-900 dark:to-teal-900/50 text-slate-800 dark:text-white overflow-hidden">
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24 md:py-32 flex flex-col md:flex-row items-center">
            <div class="flex-1 text-center md:text-left md:pr-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 leading-tight tracking-tight">
                    Tingkatkan Disiplin & Efisiensi Kerja
                </h1>
                <p class="text-lg text-slate-600 dark:text-slate-300 mb-8 max-w-xl">
                    Sistem absensi digital untuk manajemen kehadiran pegawai PDAM Tirta Intan Garut yang lebih modern, akurat, dan transparan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="{{ route('login') }}" class="px-8 py-3 bg-teal-600 text-white font-bold rounded-full shadow-xl shadow-teal-500/20 hover:bg-teal-700 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl">
                        Masuk ke Dashboard
                    </a>
                </div>
            </div>
            <div class="flex-1 mt-12 md:mt-0 flex justify-center">
                <img src="data:image/jpeg;base64,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"
                     alt="Ilustrasi Pegawai Bekerja"
                     class="w-full max-w-md lg:max-w-lg">
            </div>
        </div>
    </section>

    <section id="fitur" class="py-20 bg-white dark:bg-slate-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-100 reveal">Fitur Unggulan Sistem</h2>
            <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-400 mb-12 reveal">
                Dirancang untuk memudahkan proses absensi dan administrasi kepegawaian sehari-hari.
            </p>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group bg-gray-50 dark:bg-slate-700/50 p-8 rounded-xl shadow-md hover:shadow-teal-500/20 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 reveal">
                    <div class="bg-teal-100 dark:bg-teal-900/50 text-teal-500 dark:text-teal-400 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Absensi Online (Check-in/Out)</h3>
                    <p class="text-gray-600 dark:text-gray-400">Lakukan absensi masuk dan pulang kerja dengan cepat langsung dari perangkat Anda.</p>
                </div>
                <div class="group bg-gray-50 dark:bg-slate-700/50 p-8 rounded-xl shadow-md hover:shadow-sky-500/20 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 reveal">
                    <div class="bg-sky-100 dark:bg-sky-900/50 text-sky-500 dark:text-sky-400 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Pengajuan Izin & Cuti</h3>
                    <p class="text-gray-600 dark:text-gray-400">Ajukan izin sakit, cuti tahunan, atau dinas luar kota secara digital lengkap dengan upload dokumen.</p>
                </div>
                <div class="group bg-gray-50 dark:bg-slate-700/50 p-8 rounded-xl shadow-md hover:shadow-indigo-500/20 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 reveal">
                     <div class="bg-indigo-100 dark:bg-indigo-900/50 text-indigo-500 dark:text-indigo-400 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m14-2v-2a4 4 0 00-4-4h-1a4 4 0 00-4 4v2m14 0H5M12 12v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m12 0V9a4 4 0 00-4-4h-1a4 4 0 00-4 4v2" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Riwayat & Rekap Kehadiran</h3>
                    <p class="text-gray-600 dark:text-gray-400">Lihat riwayat absensi personal dan rekapitulasi kehadiran bulanan Anda kapan saja.</p>
                </div>
            </div>
        </div>
    </section>
    
    <section id="stats" class="py-20 bg-slate-100 dark:bg-slate-900">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="reveal">
                    <h3 class="text-4xl font-extrabold text-teal-500" data-target="350">0</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400 font-medium">Total Pegawai Terdaftar</p>
                </div>
                <div class="reveal">
                    <h3 class="text-4xl font-extrabold text-sky-500" data-target="98">0</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400 font-medium">Kehadiran Hari Ini (%)</p>
                </div>
                <div class="reveal">
                    <h3 class="text-4xl font-extrabold text-indigo-500" data-target="1500">0</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400 font-medium">Izin & Cuti Diproses</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-20 bg-white dark:bg-slate-800">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6 text-teal-600 dark:text-teal-400 reveal">Tentang Sistem Absensi Digital</h2>
            <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed max-w-3xl mx-auto reveal">
                Sistem ini merupakan bagian dari program digitalisasi administrasi PDAM Tirta Intan Garut untuk meningkatkan akurasi data kehadiran, menyederhanakan proses birokrasi, dan mendukung terciptanya lingkungan kerja yang lebih efisien dan produktif.
            </p>
        </div>
    </section>

    <footer id="kontak" class="bg-slate-900 dark:bg-black text-gray-400">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 text-center">
            <p>&copy; {{ date('Y') }} Divisi IT - PDAM Tirta Intan Garut. All rights reserved.</p>
        </div>
    </footer>

    <button id="to-top-button" title="Kembali ke atas"
            class="hidden fixed bottom-8 right-8 z-50 p-3 bg-teal-600 text-white rounded-full shadow-lg hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-110">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('themeSwitcher', () => ({
                isDark: localStorage.getItem('isDark') === 'true',
                toggleTheme() {
                    this.isDark = !this.isDark;
                    localStorage.setItem('isDark', this.isDark);
                }
            }));
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Animasi Scroll (Fade-in)
            const revealObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

            // Animasi Angka Berjalan
            const statsObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = +counter.getAttribute('data-target');
                        let current = 0;
                        const increment = target / 100;

                        const updateCounter = () => {
                            if (current < target) {
                                current += increment;
                                counter.innerText = Math.ceil(current).toLocaleString('id-ID');
                                requestAnimationFrame(updateCounter);
                            } else {
                                counter.innerText = target.toLocaleString('id-ID');
                            }
                        };
                        updateCounter();
                        observer.unobserve(counter);
                    }
                });
            }, { threshold: 0.5 });
            document.querySelectorAll('#stats h3').forEach(counter => statsObserver.observe(counter));

            // Tombol Kembali ke Atas
            const toTopButton = document.getElementById('to-top-button');
            window.onscroll = () => {
                toTopButton.classList.toggle('hidden', document.body.scrollTop < 100 && document.documentElement.scrollTop < 100);
            };
            toTopButton.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>