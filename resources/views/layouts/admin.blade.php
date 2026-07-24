<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Manajemen Event</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen flex flex-col bg-gray-50">

    @include('components.navbar')

    <div class="w-full flex-1">

        <div class="flex flex-col md:flex-row">

            <div class="w-full md:w-2/12 p-0">

                @include('components.sidebar')

            </div>

            <div class="w-full md:w-10/12 p-6">

                @yield('content')

            </div>

        </div>

    </div>

    @include('components.footer')

</body>

</html>