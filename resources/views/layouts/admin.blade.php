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
                <main class="p-6">

                    {{-- Flash Message --}}
                    @if (session('success'))
                        <div id="success-alert"
                            class="flex items-center gap-3 mb-6 rounded-xl border border-green-300 bg-green-50 px-5 py-4">

                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />

                            </svg>

                            <div>

                                <p class="font-semibold text-green-700">

                                    Berhasil

                                </p>

                                <p class="text-green-600">

                                    {{ session('success') }}

                                </p>

                            </div>

                        </div>

                        <script>
                            setTimeout(function() {

                                const alert = document.getElementById('success-alert');

                                if (alert) {

                                    alert.remove();

                                }

                            }, 3000);
                        </script>
                    @endif

                    @if (session('error'))
                        <div class="mb-5 rounded-lg border border-red-200 bg-red-100 px-4 py-3 text-red-700">

                            {{ session('error') }}

                        </div>
                    @endif

                    @yield('content')

                </main>


            </div>

        </div>

    </div>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>

function confirmDelete(id){

    Swal.fire({

        title: "Apakah Anda yakin?",

        text: "Data yang dihapus tidak dapat dikembalikan!",

        icon: "warning",

        showCancelButton: true,

        confirmButtonColor: "#dc2626",

        cancelButtonColor: "#6b7280",

        confirmButtonText: "Ya, Hapus",

        cancelButtonText: "Batal"

    }).then((result)=>{

        if(result.isConfirmed){

            document.getElementById('delete-form-'+id).submit();

        }

    });

}

</script>
@stack('scripts')
</body>

</html>
