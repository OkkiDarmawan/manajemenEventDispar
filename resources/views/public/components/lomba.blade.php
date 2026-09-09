<section id="lomba" class="py-20 bg-gray-50 border-2">

    <div class="max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="text-center max-w-2xl mx-auto">

            <span class="text-blue-600 font-semibold">
                Kompetisi
            </span>

            <h2 class="mt-2 text-4xl font-bold text-gray-800">
                Lomba yang Sedang Dibuka
            </h2>

            <p class="mt-4 text-gray-500">
                Ikuti berbagai lomba menarik dalam
                {{ $event->nama_event }}.
            </p>

        </div>


        <!-- Lomba -->
        @if($event->lombas->count())

            <div class="mt-12 grid grid-cols-2 md:grid-cols-3 gap-4 md:gap-6 lg:grid-cols-3">

                @foreach($event->lombas as $lomba)

                    <div class="w-full bg-white rounded-2xl shadow-sm p-4 hover:shadow-lg">

            <p class="text-xs md:text-sm text-blue-600 font-semibold">
                {{ $lomba->event->nama_event }}
            </p>

            <h2 class="text-sm md:text-lg font-bold text-gray-800 mt-2">
                {{ $lomba->nama_lomba }}
            </h2>

            <p class="text-xs md:text-sm text-gray-500 mt-2">
                {{ Str::limit($lomba->deskripsi, 80) }}
            </p>

            <a
                href="{{ route('public.lomba.show', $lomba->id) }}"
                class="block text-center mt-4
                       bg-blue-600 hover:bg-blue-700
                       text-white py-2 rounded-lg
                       text-xs md:text-sm"
            >
                Lihat Detail
            </a>

        </div>

                @endforeach

            </div>

        @else

            <div class="mt-12 text-center">

                <p class="text-gray-500">
                    Belum ada lomba yang tersedia.
                </p>

            </div>

        @endif

    </div>

</section>