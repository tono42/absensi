<nav x-data="{ open: false }" 
    class="bg-white/80 backdrop-blur-xl dark:bg-gray-900/80 border-b border-gray-200 dark:border-gray-700 shadow-lg sticky top-0 z-50 transition duration-300">
    
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            <!-- Left -->
            <div class="flex items-center space-x-8">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
                    <x-application-logo class="block h-9 w-auto text-blue-600 dark:text-blue-400 transition-transform duration-300 group-hover:rotate-6" />
                    <span class="font-extrabold text-lg text-gray-900 dark:text-gray-100 tracking-wide">AbsensiKu</span>
                </a>

                <!-- Navigation Links -->
                <div class="hidden sm:flex space-x-6">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <i class="fa-solid fa-gauge-high mr-1 text-blue-500"></i> Dashboard
                            </x-nav-link>
                            <x-nav-link :href="route('admin.karyawan.index')" :active="request()->routeIs('admin.karyawan.*')">
                                <i class="fa-solid fa-users mr-1 text-green-500"></i> Karyawan
                            </x-nav-link>
                            <x-nav-link :href="route('admin.absensi.index')" :active="request()->routeIs('admin.absensi.*')">
                                <i class="fa-regular fa-calendar-check mr-1 text-purple-500"></i> Absensi
                            </x-nav-link>
                            <x-nav-link :href="route('admin.izin.index')" :active="request()->routeIs('admin.izin.*')">
                                <i class="fa-solid fa-file-circle-plus mr-1 text-pink-500"></i> Izin
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('karyawan.dashboard')" :active="request()->routeIs('karyawan.dashboard')">
                                <i class="fa-solid fa-house mr-1 text-blue-500"></i> Dashboard
                            </x-nav-link>
                            <x-nav-link :href="route('karyawan.izin.index')" :active="request()->routeIs('karyawan.izin.*')">
                                <i class="fa-solid fa-clipboard-list mr-1 text-pink-500"></i> Izin
                            </x-nav-link>
                            <x-nav-link :href="route('karyawan.izin.index')" :active="request()->routeIs('karyawan.izin.*')">
                                
                            </x-nav-link>
                            <x-nav-link :href="route('karyawan.izin.index')" :active="request()->routeIs('karyawan.izin.*')">
                                
                            </x-nav-link>
                            <x-nav-link :href="route('karyawan.izin.index')" :active="request()->routeIs('karyawan.izin.*')">
                                
                            </x-nav-link>
                            <x-nav-link :href="route('karyawan.absensi.index')" :active="request()->routeIs('karyawan.absensi.*')">
                               
                            </x-nav-link>
                            
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right (User Dropdown) -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition duration-200">
                            <i class="fa-regular fa-circle-user text-lg text-blue-500"></i>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-solid fa-user-pen mr-1"></i> {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" 
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fa-solid fa-right-from-bracket mr-1"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open"
                    class="p-2 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-800 transition duration-200">
                    <i :class="open ? 'fa-solid fa-xmark' : 'fa-solid fa-bars'"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Nav (Mobile) -->
    <div :class="{'block': open, 'hidden': !open}" 
        class="sm:hidden hidden border-t border-gray-200 dark:border-gray-700 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md">
        <div class="pt-2 pb-3 space-y-2">
            @auth
                @if(Auth::user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <i class="fa-solid fa-gauge-high mr-1 text-blue-500"></i> Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.karyawan.index')" :active="request()->routeIs('admin.karyawan.*')">
                        <i class="fa-solid fa-users mr-1 text-green-500"></i> Karyawan
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.absensi.index')" :active="request()->routeIs('admin.absensi.*')">
                        <i class="fa-regular fa-calendar-check mr-1 text-purple-500"></i> Absensi
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.izin.index')" :active="request()->routeIs('admin.izin.*')">
                        <i class="fa-solid fa-file-circle-plus mr-1 text-pink-500"></i> Izin
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('karyawan.dashboard')" :active="request()->routeIs('karyawan.dashboard')">
                        <i class="fa-solid fa-house mr-1 text-blue-500"></i> Dashboard
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('karyawan.absensi.index')" :active="request()->routeIs('karyawan.absensi.*')">
                        <i class="fa-regular fa-calendar-days mr-1 text-purple-500"></i>  
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('karyawan.izin.index')" :active="request()->routeIs('karyawan.izin.*')">
                        <i class="fa-solid fa-clipboard-list mr-1 text-pink-500"></i> Izin
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>
    </div>
</nav>
