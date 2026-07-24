@extends('layouts.admin')

@section('content')

<h2 class="text-2xl font-bold mb-6 text-gray-800">
    Dashboard
</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

    <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
        <h5 class="text-gray-500 text-sm font-medium mb-1">Total Event</h5>
        <h2 class="text-3xl font-bold text-gray-900">0</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
        <h5 class="text-gray-500 text-sm font-medium mb-1">Total Lomba</h5>
        <h2 class="text-3xl font-bold text-gray-900">0</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
        <h5 class="text-gray-500 text-sm font-medium mb-1">Total Workshop</h5>
        <h2 class="text-3xl font-bold text-gray-900">0</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-5 border border-gray-100">
        <h5 class="text-gray-500 text-sm font-medium mb-1">Total UMKM</h5>
        <h2 class="text-3xl font-bold text-gray-900">0</h2>
    </div>

</div>

@endsection