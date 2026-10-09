<footer class="bg-gray-900 text-gray-300 ">

    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div class="md:col-span-2">

                <div class="flex items-center gap-3">

                    <div
                        class="w-24 h-24 rounded-xl
                               flex items-center justify-center
                               text-white font-bold">

                        <img src="{{ asset('images/my_logo.png') }}" alt="">

                    </div>

                    <div>

                        <h2 class="text-white text-xl font-bold">
                            EventKite
                        </h2>

                        <p class="text-sm text-gray-400">
                            Manajemen Event
                        </p>

                    </div>

                </div>


                <p class="mt-5 text-gray-400 leading-relaxed max-w-md">

                    Platform informasi dan pendaftaran event,
                    lomba, serta workshop yang diselenggarakan
                    oleh Dinas Pariwisata.

                </p>

            </div>


            {{-- Navigasi --}}
            <div>

                <h3 class="text-white font-semibold mb-4">
                    Navigasi
                </h3>

                <ul class="space-y-3">

                    <li>
                        <a
                            href="{{ route('home') }}"
                            class="hover:text-white transition">

                            Beranda

                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('home') }}#lomba"
                            class="hover:text-white transition">

                            Lomba

                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('home') }}#workshop"
                            class="hover:text-white transition">

                            Workshop

                        </a>
                    </li>
                    <li>
                        <a
                            href="{{ route('home') }}#faq"
                            class="hover:text-white transition">

                            FAQ

                        </a>
                    </li>                   

                </ul>

            </div>


            {{-- Kontak --}}
            <div>

                <h3 class="text-white font-semibold mb-4">
                    Kontak
                </h3>

                <ul class="space-y-3 text-gray-400">

                    <li>
                        📍 Pangkalpinang, Bangka Belitung
                    </li>

                    <li>
                        📞 0821-7986-2826
                    </li>

                    <li>
                        ✉️ <a href="mailto:tic.pangkalpinang@gmail.com">tic.pangkalpinang@gmail.com</a>
                    </li>

                </ul>

            </div>

        </div>


        {{-- Garis --}}
        <div class="border-t border-gray-800 mt-10 pt-6">

            <div
                class="flex flex-col md:flex-row
                       justify-between items-center
                       gap-4">

                <p class="text-sm text-gray-500">

                    © {{ date('Y') }} EventKite.
                    All rights reserved.

                </p>


                <div class="flex gap-5 text-sm">

                    <a
                        href="#"
                        class="text-gray-500 hover:text-white transition">

                        Instagram

                    </a>

                    <a
                        href="#"
                        class="text-gray-500 hover:text-white transition">

                        Facebook

                    </a>

                    <a
                        href="#"
                        class="text-gray-500 hover:text-white transition">

                        YouTube

                    </a>

                </div>

            </div>

        </div>

    </div>

</footer>