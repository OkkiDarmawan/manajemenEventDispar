<!DOCTYPE html>
<html>

<head>

    <title>@yield('title')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-gray-50">

    @include('public.components.navbar')

    <main>

        @yield('content')

    </main>

    @include('public.components.footer')

    @stack('scripts')

</body>

</html>