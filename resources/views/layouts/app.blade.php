<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.7/flowbite.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- cssJS --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.7/flowbite.min.css" rel="stylesheet">


    {{-- JS --}}
    <script src="{{ asset('js/shopping-list.js') }}"></script>


    <!-- Add custom styles for layout -->
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            background-color: transparent;
            /* Transparent background for html and body */
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: transparent;
            /* Transparent background for body */
        }

        main {
            flex-grow: 1;
            background-color: transparent;
            /* Transparent background for main content */
        }

        header,
        footer {
            background-color: rgba(255, 255, 255, 0.9);
            /* Slight opacity for header/footer */
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="flex flex-col min-h-screen bg-transparent">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Include the footer -->
        @include('layouts.footer')
    </div>
</body>

</html>
