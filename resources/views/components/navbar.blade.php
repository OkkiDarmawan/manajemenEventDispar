<nav class="bg-blue-600 text-white shadow-sm px-4 py-3">
    <div class="w-full flex items-center justify-between">

        <a class="text-xl font-bold tracking-wide hover:text-blue-100 transition-colors" href="#">
            Manajemen Event
        </a>

        <div class="flex items-center space-x-4">

            <span class="text-white text-sm">
                Halo,
                <strong class="font-semibold">{{ Auth::user()->name }}</strong>
            </span>

            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf

                <button class="bg-white text-blue-600 hover:bg-blue-50 text-sm font-medium px-3 py-1.5 rounded transition-colors shadow-sm">
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>