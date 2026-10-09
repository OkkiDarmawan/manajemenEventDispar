@php
    // Mengecek apakah saat ini user berada di halaman 'home'
    $isHome = request()->routeIs('home');
@endphp

<nav id="main-navbar"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 {{ $isHome ? 'bg-transparent' : 'bg-white/95 backdrop-blur-md shadow-sm' }}">

    <div class="max-w-7xl mx-auto px-6">

        <div class="h-20 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold">
                    <img src="{{ asset('images/my_logo.png') }}" alt="">
                </div>

                <div>
                    <h1 id="logo-title"
                        class="font-bold text-lg transition-colors duration-300 {{ $isHome ? 'text-white' : 'text-gray-800' }}">
                        EventKite
                    </h1>

                    <p id="logo-sub"
                        class="text-xs transition-colors duration-300 {{ $isHome ? 'text-gray-200' : 'text-gray-500' }}">
                        Manajemen Event
                    </p>
                </div>

            </a>


            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-8">

                <a href="{{ route('home') }}"
                    class="desktop-link transition-colors duration-300 {{ $isHome ? 'text-white hover:text-blue-300' : 'text-gray-600 hover:text-blue-600' }}">
                    Beranda
                </a>

                <a href="{{ route('home') }}#event"
                    class="desktop-link transition-colors duration-300 {{ $isHome ? 'text-white hover:text-blue-300' : 'text-gray-600 hover:text-blue-600' }}">
                    Event
                </a>

                <a href="{{ route('public.galeri-umkm') }}#event"
                    class="desktop-link transition-colors duration-300 {{ $isHome ? 'text-white hover:text-blue-300' : 'text-gray-600 hover:text-blue-600' }}">
                    Galeri UMKM
                </a>

                <a href="{{ route('home') }}#faq"
                    class="desktop-link transition-colors duration-300 {{ $isHome ? 'text-white hover:text-blue-300' : 'text-gray-600 hover:text-blue-600' }}">
                    FAQ
                </a>



            </div>


            {{-- Right Side --}}
            <div class="hidden md:flex items-center gap-4">

                @auth

                    {{-- User Dropdown --}}
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false"
                        @keydown.escape.window="open = false">

                        {{-- Tombol User --}}
                        <button type="button" @click="open = !open" class="flex items-center gap-3 focus:outline-none">

                            {{-- Inisial --}}
                            <div
                                class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold shadow-sm">

                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                            </div>


                            {{-- Nama --}}
                            <div class="text-sm text-left">

                                <p id="profile-name"
                                    class="font-semibold transition-colors duration-300 {{ $isHome ? 'text-white' : 'text-gray-800' }}">

                                    {{ auth()->user()->name }}

                                </p>

                            </div>


                            {{-- Chevron --}}
                            <svg class="w-4 h-4 transition-transform duration-200 {{ $isHome ? 'text-white' : 'text-gray-600' }}"
                                :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7" />

                            </svg>

                        </button>


                        {{-- Dropdown --}}
                        <div x-show="open" x-transition x-cloak
                            class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50">

                            {{-- Header kecil --}}
                            <div class="px-4 py-3 bg-gray-50 border-b border-gray-100">

                                <p class="text-sm font-semibold text-gray-800">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-gray-500">
                                    Akun Pengguna
                                </p>

                            </div>


                            {{-- Pendaftaran Saya --}}
                            <a href="{{ route('public.pendaftaran-saya.index') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2M9 5a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2M9 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2m-6 7h6m-6 4h6" />

                                </svg>

                                <span>
                                    Pendaftaran Saya
                                </span>

                            </a>


                            {{-- Profil Saya --}}
                            <a href="{{ route('public.profile.show') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">

                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 0 1 15 0" />

                                </svg>

                                <span>
                                    Profil Saya
                                </span>

                            </a>


                            {{-- Garis --}}
                            <div class="border-t border-gray-100"></div>


                            {{-- Logout --}}
                            <form action="{{ route('logout') }}" method="POST">

                                @csrf

                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition text-left">

                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 12h9m0 0-3-3m3 3-3 3" />

                                    </svg>

                                    <span>
                                        Keluar
                                    </span>

                                </button>

                            </form>

                        </div>

                    </div>
                @else
                    <a href="{{ route('login') }}" id="login-link"
                        class="transition-colors duration-300 {{ $isHome ? 'text-white hover:text-blue-300' : 'text-gray-600 hover:text-blue-600' }}">

                        Masuk

                    </a>

                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

                        Daftar

                    </a>

                @endauth

            </div>


            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-button" type="button"
                class="md:hidden transition-colors duration-300 {{ $isHome ? 'text-white' : 'text-gray-700' }}">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>


        {{-- Mobile Menu --}}
        <div id="mobile-menu"
            class="hidden md:hidden pb-6 bg-white px-6 pt-4 rounded-xl shadow-lg mt-2 absolute left-6 right-6">
            <div class="flex flex-col gap-4">

                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">
                    Beranda
                </a>

                <a href="{{ route('home') }}#event" class="text-gray-600 hover:text-blue-600">
                    Event
                </a>

                <a href="{{ route('public.galeri-umkm') }}" class="text-gray-600 hover:text-blue-600">
                    Galeri UMKM
                </a>

                <a href="{{ route('home') }}#faq" class="text-gray-600 hover:text-blue-600 transition">
                    FAQ
                </a>

                @auth
                    <a href="{{ route('public.pendaftaran-saya.index') }}" class="text-gray-600 hover:text-blue-600">
                        Pendaftaran Saya
                    </a>

                    <a href="{{ route('public.profile.show') }}" class="text-gray-700 hover:text-blue-600 transition">
                        Profil Saya
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-red-600">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">
                        Masuk
                    </a>

                    <a href="{{ route('register') }}" class="text-blue-600 font-semibold">
                        Daftar
                    </a>
                @endauth

            </div>
        </div>

    </div>

</nav>


{{-- Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        // Toggle Mobile Menu
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Cek apakah ini di halaman Home dari variabel PHP Laravel yang dilempar ke JS
        const isHomePage = {{ $isHome ? 'true' : 'false' }};

        // HANYA jalankan efek scroll transparent jika user berada di halaman Home
        if (isHomePage) {
            const navbar = document.getElementById('main-navbar');
            const eventSection = document.getElementById('event');

            const logoTitle = document.getElementById('logo-title');
            const logoSub = document.getElementById('logo-sub');
            const desktopLinks = document.querySelectorAll('.desktop-link');
            const profileName = document.getElementById('profile-name');
            const loginLink = document.getElementById('login-link');

            function handleScroll() {
                let triggerPoint = 50;

                if (eventSection) {
                    triggerPoint = eventSection.offsetTop - 80;
                }

                if (window.scrollY >= triggerPoint) {
                    // MUNCULKAN BACKGROUND PUTIH
                    navbar.classList.add('bg-white/95', 'backdrop-blur-md', 'shadow-sm');
                    navbar.classList.remove('bg-transparent');

                    // UBAH TEKS JADI GELAP
                    logoTitle.classList.replace('text-white', 'text-gray-800');
                    logoSub.classList.replace('text-gray-200', 'text-gray-500');
                    mobileMenuButton.classList.replace('text-white', 'text-gray-700');

                    desktopLinks.forEach(link => {
                        link.classList.replace('text-white', 'text-gray-600');
                        link.classList.replace('hover:text-blue-300', 'hover:text-blue-600');
                    });

                    if (profileName) profileName.classList.replace('text-white', 'text-gray-800');
                    if (loginLink) {
                        loginLink.classList.replace('text-white', 'text-gray-600');
                        loginLink.classList.replace('hover:text-blue-300', 'hover:text-blue-600');
                    }

                } else {
                    // BACKGROUND TRANSPARAN
                    navbar.classList.add('bg-transparent');
                    navbar.classList.remove('bg-white/95', 'backdrop-blur-md', 'shadow-sm');

                    // KEMBALIKAN TEKS JADI PUTIH
                    logoTitle.classList.replace('text-gray-800', 'text-white');
                    logoSub.classList.replace('text-gray-500', 'text-gray-200');
                    mobileMenuButton.classList.replace('text-gray-700', 'text-white');

                    desktopLinks.forEach(link => {
                        link.classList.replace('text-gray-600', 'text-white');
                        link.classList.replace('hover:text-blue-600', 'hover:text-blue-300');
                    });

                    if (profileName) profileName.classList.replace('text-gray-800', 'text-white');
                    if (loginLink) {
                        loginLink.classList.replace('text-gray-600', 'text-white');
                        loginLink.classList.replace('hover:text-blue-600', 'hover:text-blue-300');
                    }
                }
            }

            window.addEventListener('scroll', handleScroll);
            handleScroll();
        }
    });
</script>
