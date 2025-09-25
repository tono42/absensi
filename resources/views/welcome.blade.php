<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PDAM Tirta Intan Garut - Air Bersih untuk Semua</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>
<body class="antialiased bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <header class="bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg sticky top-0 z-50 shadow-sm">
        <nav class="max-w-7xl mx-auto px-6 lg:px-8 flex justify-between items-center py-4">
            <div class="flex items-center gap-3">
                <i class="fas fa-tint text-2xl text-blue-500"></i>
                <span class="font-bold text-xl text-gray-800 dark:text-white">PDAM Garut</span>
            </div>
            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="#layanan" class="hover:text-blue-500 transition duration-300">Layanan</a>
                <a href="#tentang" class="hover:text-blue-500 transition duration-300">Tentang Kami</a>
                <a href="#kontak" class="hover:text-blue-500 transition duration-300">Kontak</a>
            </div>
            <a href="{{ route('login') }}"
               class="px-5 py-2 bg-blue-600 text-white font-semibold rounded-full shadow-lg hover:bg-blue-700 transition duration-300 transform hover:scale-105">
                Login Pelanggan
            </a>
        </nav>
    </header>

    <section class="relative bg-gradient-to-br from-blue-600 to-cyan-400 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-repeat" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24 md:py-32 flex flex-col md:flex-row items-center">
            <div class="flex-1 text-center md:text-left md:pr-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-4 leading-tight tracking-tight">
                    Selamat Datang di <span class="text-yellow-300 drop-shadow-lg">PDAM Tirta Intan Garut</span>
                </h1>
                <p class="text-lg text-blue-100 mb-8 max-w-xl">
                    Layanan air bersih terpercaya untuk masyarakat Garut. Mudah, cepat, dan transparan dalam genggaman Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="#layanan"
                       class="px-8 py-3 bg-yellow-400 text-blue-900 font-bold rounded-full shadow-xl hover:bg-yellow-300 transition duration-300 transform hover:scale-105">
                        Jelajahi Layanan
                    </a>
                    <a href="#kontak"
                       class="px-8 py-3 bg-white/20 text-white font-semibold rounded-full hover:bg-white/30 transition duration-300 transform hover:scale-105">
                        Hubungi Kami
                    </a>
                </div>
            </div>
            <div class="flex-1 mt-12 md:mt-0 flex justify-center">
                
                <img src="data:image/jpeg;base64,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"
                     alt="Ilustrasi Air Bersih"
                     class="w-full max-w-md lg:max-w-lg">
            </div>
        </div>
    </section>

    <section id="layanan" class="py-20 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-100">Layanan Digital Terpadu</h2>
            <p class="max-w-2xl mx-auto text-gray-600 dark:text-gray-400 mb-12">
                Kami menyediakan berbagai kemudahan untuk semua kebutuhan Anda terkait layanan air bersih.
            </p>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="group bg-gray-50 dark:bg-gray-700/50 p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-blue-100 dark:bg-blue-900/50 text-blue-500 dark:text-blue-400 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-user-plus text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Pendaftaran Pelanggan</h3>
                    <p class="text-gray-600 dark:text-gray-400">Daftar sebagai pelanggan baru PDAM dengan mudah melalui sistem online kami.</p>
                </div>
                <div class="group bg-gray-50 dark:bg-gray-700/50 p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <div class="bg-green-100 dark:bg-green-900/50 text-green-500 dark:text-green-400 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-invoice-dollar text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Cek & Bayar Tagihan</h3>
                    <p class="text-gray-600 dark:text-gray-400">Akses informasi tagihan air Anda dan lakukan pembayaran kapan saja.</p>
                </div>
                <div class="group bg-gray-50 dark:bg-gray-700/50 p-8 rounded-xl shadow-md hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                     <div class="bg-red-100 dark:bg-red-900/50 text-red-500 dark:text-red-400 rounded-full h-16 w-16 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bullhorn text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-3 text-gray-900 dark:text-white">Layanan Pengaduan</h3>
                    <p class="text-gray-600 dark:text-gray-400">Sampaikan keluhan dan kendala Anda agar lebih cepat ditangani oleh tim kami.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="tentang" class="py-20 bg-gradient-to-r from-blue-700 to-blue-800 text-white">
        <div class="max-w-5xl mx-auto px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Tentang PDAM Tirta Intan Garut</h2>
            <p class="text-lg text-blue-100 leading-relaxed max-w-3xl mx-auto">
                PDAM Tirta Intan Garut berkomitmen untuk menyediakan layanan air bersih yang merata dan berkualitas untuk seluruh masyarakat. Dengan inovasi digital, kami hadir lebih dekat dan transparan untuk memberikan kenyamanan terbaik bagi setiap pelanggan.
            </p>
        </div>
    </section>

    <footer id="kontak" class="bg-gray-900 text-gray-400">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h3 class="font-bold text-white text-lg mb-4">PDAM Garut</h3>
                    <p class="text-sm">Jl. Raya Karangpawitan No. 23, Garut, Jawa Barat.</p>
                    <p class="text-sm">info@pdamgarut.go.id</p>
                </div>
                <div>
                    <h3 class="font-bold text-white text-lg mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#layanan" class="hover:text-white transition">Layanan</a></li>
                        <li><a href="#tentang" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-bold text-white text-lg mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram fa-lg"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-10 border-t border-gray-800 pt-6 text-center text-sm">
                <p>&copy; {{ date('Y') }} PDAM Tirta Intan Garut. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>