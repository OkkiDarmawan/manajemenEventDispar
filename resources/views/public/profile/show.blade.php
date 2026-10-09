@extends('public.layouts.app')

@section('content')

<section class="pt-28 pb-12 bg-gray-50 min-h-screen">

    <div class="max-w-4xl mx-auto px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">

            <p class="text-blue-600 font-semibold">
                PROFIL
            </p>

            <h1
                class="mt-2
                       text-3xl
                       md:text-4xl
                       font-bold
                       text-gray-900"
            >
                Profil Saya
            </h1>

            <p class="mt-3 text-gray-500">
                Lihat dan kelola data pribadi kamu.
            </p>

        </div>


        {{-- Profile Card --}}
        <div
            class="bg-white
                   rounded-2xl
                   border border-gray-100
                   shadow-sm
                   overflow-hidden"
        >

            {{-- Header Card --}}
            <div
                class="px-6
                       py-6
                       bg-gradient-to-r
                       from-blue-600
                       to-blue-500
                       text-white"
            >

                <div class="flex items-center gap-4">

                    <div
                        class="w-16 h-16
                               rounded-full
                               bg-white/20
                               backdrop-blur-sm
                               flex
                               items-center
                               justify-center
                               text-3xl"
                    >
                        👤
                    </div>

                    <div>

                        <h2 class="text-2xl font-bold">
                            {{ $user->name }}
                        </h2>

                        <p class="text-blue-100">
                            Masyarakat
                        </p>

                    </div>

                </div>

            </div>


            {{-- Data --}}
            <div class="p-6">

                <div class="divide-y divide-gray-100">


                    {{-- Nama --}}
                    <div
                        class="py-4
                               flex
                               flex-col
                               md:flex-row"
                    >

                        <div
                            class="w-full
                                   md:w-1/3
                                   text-sm
                                   text-gray-500"
                        >
                            Nama Lengkap
                        </div>

                        <div
                            class="w-full
                                   md:w-2/3
                                   mt-1
                                   md:mt-0
                                   font-semibold
                                   text-gray-800"
                        >
                            {{ $user->name }}
                        </div>

                    </div>


                    {{-- NIK --}}
                    <div
                        class="py-4
                               flex
                               flex-col
                               md:flex-row"
                    >

                        <div
                            class="w-full
                                   md:w-1/3
                                   text-sm
                                   text-gray-500"
                        >
                            NIK
                        </div>

                        <div
                            class="w-full
                                   md:w-2/3
                                   mt-1
                                   md:mt-0
                                   font-semibold
                                   text-gray-800"
                        >
                            {{ $user->nik }}
                        </div>

                    </div>


                    {{-- No HP --}}
                    <div
                        class="py-4
                               flex
                               flex-col
                               md:flex-row"
                    >

                        <div
                            class="w-full
                                   md:w-1/3
                                   text-sm
                                   text-gray-500"
                        >
                            No. Handphone
                        </div>

                        <div
                            class="w-full
                                   md:w-2/3
                                   mt-1
                                   md:mt-0
                                   font-semibold
                                   text-gray-800"
                        >
                            {{ $user->no_hp }}
                        </div>

                    </div>


                    {{-- Tanggal Lahir --}}
                    <div
                        class="py-4
                               flex
                               flex-col
                               md:flex-row"
                    >

                        <div
                            class="w-full
                                   md:w-1/3
                                   text-sm
                                   text-gray-500"
                        >
                            Tanggal Lahir
                        </div>

                        <div
                            class="w-full
                                   md:w-2/3
                                   mt-1
                                   md:mt-0
                                   font-semibold
                                   text-gray-800"
                        >
                            {{ \Carbon\Carbon::parse($user->tanggal_lahir)->translatedFormat('d F Y') }}
                        </div>

                    </div>


                    {{-- Alamat --}}
                    <div
                        class="py-4
                               flex
                               flex-col
                               md:flex-row"
                    >

                        <div
                            class="w-full
                                   md:w-1/3
                                   text-sm
                                   text-gray-500"
                        >
                            Alamat
                        </div>

                        <div
                            class="w-full
                                   md:w-2/3
                                   mt-1
                                   md:mt-0
                                   font-semibold
                                   text-gray-800
                                   leading-relaxed"
                        >
                            {{ $user->alamat }}
                        </div>

                    </div>

                </div>


                {{-- Button --}}
                <div
                    class="mt-8
                           flex
                           justify-end"
                >

                    <a
                        href="{{ route('public.profile.edit') }}"
                        class="inline-flex
                               items-center
                               gap-2
                               px-6 py-3
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-semibold
                               transition"
                    >
                        ✏️ Edit Profil
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>

@endsection