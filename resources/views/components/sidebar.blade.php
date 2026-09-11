<div class="bg-gray-900 text-white h-full p-4">

    <img src="{{ asset('images/my_logo.png') }}" alt="Logo Website" class="w-1/2 block mx-auto pb-4">

    <h4 class="text-center text-lg font-bold mb-4 tracking-wider">
        MENU
    </h4>

    <ul class="flex flex-col space-y-1">

        <li>
            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded text-white hover:bg-gray-800 transition-colors">
                Dashboard
            </a>
        </li>

        <hr class="border-gray-700 my-3">

        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-2 mb-1 block">
            MASTER DATA
        </span>

        <li>
            <a href="{{ route('admin.event.index') }}" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                Event
            </a>
        </li>
        <li>
            <a href="{{ route('admin.master-field.index') }}" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                Master Fields
            </a>
        </li>

        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-3 mb-1 block">
            Kegiatan
        </span>

        <li>
            <a href="{{ route('admin.lomba.index') }}" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                Lomba
            </a>
        </li>

        <li>
            <a href="{{ route('admin.workshop.index') }}" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                Workshop
            </a>
        </li>

        <li>
            <a href="#" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                UMKM
            </a>
        </li>

        <hr class="border-gray-700 my-3">

        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mt-2 mb-1 block">
            INFORMASI
        </span>

        <li>
            <a href="{{ route('admin.pendaftaran-lomba.index') }}" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                Pendaftaran Lomba
            </a>
        </li>
        <li>
            <a href="{{ route('admin.pendaftaran-workshop.index') }}" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                Pendaftaran Workshop
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.faq.index') }}" class="block px-3 py-2 rounded text-gray-300 hover:text-white hover:bg-gray-800 transition-colors">
                FAQ
            </a>
        </li>

    </ul>

</div>