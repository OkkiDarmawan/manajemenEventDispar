@extends('public.layouts.app')

@section('title', $event ? $event->nama_event : 'Beranda')

@section('content')

    @if ($event)
        @include('public.components.hero')


        @include('public.components.lomba')

        <section id="lomba">

            {{-- Nanti card lomba di sini --}}

        </section>
    @else
        <section class="min-h-screen flex items-center justify-center">

            <div class="text-center">

                <h1 class="text-3xl font-bold">

                    Belum Ada Event Aktif

                </h1>

                <p class="text-gray-500 mt-3">

                    Silakan kembali lagi nanti.

                </p>

            </div>

        </section>
    @endif

@endsection
