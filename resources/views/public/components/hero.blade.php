<section
    class="relative h-screen bg-cover bg-center"
    style="background-image: url('{{ asset('storage/' . $event->poster) }}');">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <!-- Content -->
    <div
        class="relative z-10 h-full max-w-7xl mx-auto px-6 flex items-center">

        <div class="max-w-2xl text-white">

            <span
                class="inline-block bg-blue-600 px-4 py-1 rounded-full text-sm">

                Event Aktif

            </span>

            <h1
                class="mt-6 text-5xl md:text-7xl font-bold leading-tight">

                {{ $event->nama_event }}

            </h1>

            <p class="mt-6 text-lg text-gray-200">

                {{ $event->deskripsi }}

            </p>

            <div class="mt-8 flex items-center gap-4">

                <div
                    class="bg-white/20 backdrop-blur-md px-5 py-3 rounded-xl">

                    📅

                    {{ \Carbon\Carbon::parse($event->tanggal_mulai)->translatedFormat('d F Y') }}

                </div>

                <div
                    class="bg-white/20 backdrop-blur-md px-5 py-3 rounded-xl">

                    Sampai

                    {{ \Carbon\Carbon::parse($event->tanggal_selesai)->translatedFormat('d F Y') }}

                </div>

            </div>

            <a
                href="#lomba"
                class="inline-flex mt-10 px-8 py-4 rounded-xl bg-blue-600 hover:bg-blue-700 transition text-lg font-semibold">

                Daftar Sekarang →

            </a>

        </div>

    </div>

</section>