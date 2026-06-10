<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CSViewer') }}</title>
        
        <!-- Fonts -->
        <link rel="stylesheet" href="https://bunny.net">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">

        <!-- Fondo imagen-->
        <div class="min-h-screen w-screen overflow-y-auto flex flex-col justify-start items-center pt-8 pb-12 bg-cover bg-center" style="background-image: url('{{ asset('images/fondo-web.jpg') }}');">

       <!-- Logo -->
        <div class="flex flex-col items-center text-center">
            <a href="/">
                <img src="{{ asset('images/Logo-CSViewer.png') }}" alt="CSViewer" class="logo h-40 w-auto mb-2">
            </a>
            <h1 class="text-xl font-normal italic text-slate-50">Visualiza tus archivos CSV de forma sencilla</h1>
        </div>

            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-slate-50 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
