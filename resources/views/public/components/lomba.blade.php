<section id="lomba" class="py-20 bg-gray-50">

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

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach($event->lombas as $lomba)

                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition overflow-hidden">

                        <!-- Content -->
                        <div class="p-6">

                            <h3 class="text-xl font-bold text-gray-800">
                                {{ $lomba->nama_lomba }}
                            </h3>

                            <p class="mt-3 text-gray-500 line-clamp-3">
                                {{ $lomba->deskripsi }}
                            </p>

                            <!-- Info -->
                            <div class="mt-6 space-y-3 text-sm">

                                <div class="flex justify-between">

                                    <span class="text-gray-500">
                                        Kuota
                                    </span>

                                    <span class="font-semibold">
                                        {{ $lomba->kuota }} Peserta
                                    </span>

                                </div>

                                <div class="flex justify-between">

                                    <span class="text-gray-500">
                                        Biaya
                                    </span>

                                    <span class="font-semibold">

                                        @if($lomba->biaya > 0)

                                            Rp {{ number_format($lomba->biaya, 0, ',', '.') }}

                                        @else

                                            Gratis

                                        @endif

                                    </span>

                                </div>

                            </div>

                            <!-- Button -->
                            <a
                                href="{{ route('public.lomba.show', $lomba->id) }}"
                                class="mt-6 block text-center bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl transition">

                                Lihat Detail

                            </a>

                        </div>

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