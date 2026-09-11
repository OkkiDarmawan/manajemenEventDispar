<nav class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-sm">

    <div class="max-w-7xl mx-auto px-6">

        <div class="h-20 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-3">

                <div class="w-14 h-14 rounded-xl flex items-center justify-center text-white font-bold">

                    <img src="{{ asset('images/my_logo.png') }}" alt="">

                </div>

                <div>
                    <h1 class="font-bold text-gray-800 text-lg">
                        EventKite
                    </h1>

                    <p class="text-xs text-gray-500">
                        Manajemen Event
                    </p>
                </div>

            </a>


            {{-- Desktop Menu --}}
            <div class="hidden md:flex items-center gap-8">

                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600 transition">

                    Beranda

                </a>


                <a href="{{ route('home') }}#event" class="text-gray-600 hover:text-blue-600 transition">

                    Event

                </a>


                <a href="{{ route('home') }}#faq" class="text-gray-600 hover:text-blue-600 transition">
                    FAQ
                </a>


                @auth

                    <a href="{{ route('public.pendaftaran-saya.index') }}" class="text-gray-600 hover:text-blue-600 transition">

                        Pendaftaran Saya

                    </a>

                @endauth

            </div>


            {{-- Right Side --}}
            <div class="hidden md:flex items-center gap-4">

                @auth

                    {{-- User --}}
                    <div class="flex items-center gap-3">

                        <div
                            class="w-9 h-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-semibold">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                        <div class="text-sm">

                            <p class="font-semibold text-gray-800">
                                {{ auth()->user()->name }}
                            </p>

                        </div>

                    </div>


                    {{-- Logout --}}
                    <form action="{{ route('logout') }}" method="POST">

                        @csrf

                        <button type="submit" class="px-4 py-2 rounded-lg text-red-600 hover:bg-red-50 transition">

                            Keluar

                        </button>

                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition">

                        Masuk

                    </a>


                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">

                        Daftar

                    </a>

                @endauth

            </div>


            {{-- Mobile Menu Button --}}
            <button id="mobile-menu-button" type="button" class="md:hidden text-gray-700">

                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />

                </svg>

            </button>

        </div>


        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden pb-6">

            <div class="flex flex-col gap-4">

                <a href="{{ route('home') }}" class="text-gray-600 hover:text-blue-600">

                    Beranda

                </a>


                <a href="{{ route('home') }}#event" class="text-gray-600 hover:text-blue-600">

                    Event

                </a>

                <a href="{{ route('home') }}#faq" class="text-gray-600 hover:text-blue-600 transition">
                    FAQ
                </a>


                @auth

                    <a href="{{ route('public.pendaftaran-saya.index') }}" class="text-gray-600 hover:text-blue-600">

                        Pendaftaran Saya

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


{{-- Mobile Menu Script --}}
<script>
    const mobileMenuButton =
        document.getElementById('mobile-menu-button');

    const mobileMenu =
        document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', function() {

        mobileMenu.classList.toggle('hidden');

    });
</script>
