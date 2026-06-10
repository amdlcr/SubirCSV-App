<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name', 'CSViewer'))</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://bunny.net">

        <!--  Vite(CSS y JS) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- css comun -->
        <link rel="stylesheet" href="{{ asset('css/general.css') }}">
        @stack('styles')
       
    </head>
    <body class="h-screen w-screen m-0 p-0 bg-cover bg-center bg-no-repeat bg-fixed overflow-x-hidden" style="background-image: url('{{ asset('images/fondo-web.jpg') }}');">

        <!-- NAVBAR -->
        <nav class="w-full bg-slate-50 border-b border-gray-200 py-3 px-6 flex justify-between items-center shadow-sm shrink-0 z-50">
            <!-- Logo  -->
            <div class="flex items-center space-x-2">
                @if(isset($archivo))
                    <!-- Elimina el archivo abierto de la ruta temporal -->
                    <a href="{{ route('eliminar.csv', ['archivo' => $archivo]) }}" class="flex items-center hover:opacity-90 transition">
                        <img src="{{ asset('images/Logo-CSViewer.png') }}" alt="CSViewer" class="h-16 w-auto">
                    </a>
                @else
                    <!-- Uso normal de vuelta al inicio -->
                    <a href="{{ route('index') }}" class="flex items-center hover:opacity-90 transition">
                        <img src="{{ asset('images/Logo-CSViewer.png') }}" alt="CSViewer" class="h-16 w-auto">
                    </a>
                @endif
            </div>

            <!-- Perfil -->
            <div class="flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center justify-center p-0 rounded-full bg-transparent focus:outline-none transition ease-in-out duration-150 hover:ring-[2px] hover:ring-blue-300 hover:ring-offset-1">
                            <div class="flex items-center justify-center w-14 h-14 rounded-full bg-blue-200 text-[#1F8BA0] font-bold text-2xl uppercase border border-blue-200 shadow-sm shrink-0">
                                {{ mb_substr(Auth::user()->name, 0, 1, 'UTF-8') }}
                            </div>
                        </button>
                    </x-slot>
                
                    <x-slot name="content">

                    <div class="px-4 py-3 bg-gray-50rounded-t-md flex flex-col justify-start text-center">
                        <span class="text-sm font-semibold text-sky-400 tracking-wider block">Hola,</span>
                        <span class="text-base font-bold text-sky-800 break-words mt-0.5 block">{{ Auth::user()->name }}</span>
                    </div>
                        <!-- Enlace A: Ver Perfil -->
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-4 h-4 fill-current text-gray-400 group-hover:text-gray-600 transition-colors"><!--!Font Awesome Free v7.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2026 Fonticons, Inc.--><path d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z"/></svg>
                            <span>{{ __('Perfil') }}</span>
                        </x-dropdown-link>

                        <!-- Configuración -->
                        <x-dropdown-link :href="route('profile.configuracion')" class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-4 h-4 fill-current text-gray-400 group-hover:text-gray-600 transition-colors"><path d="M259.1 73.5C262.1 58.7 275.2 48 290.4 48L350.2 48C365.4 48 378.5 58.7 381.5 73.5L396 143.5C410.1 149.5 423.3 157.2 435.3 166.3L503.1 143.8C517.5 139 533.3 145 540.9 158.2L570.8 210C578.4 223.2 575.7 239.8 564.3 249.9L511 297.3C511.9 304.7 512.3 312.3 512.3 320C512.3 327.7 511.8 335.3 511 342.7L564.4 390.2C575.8 400.3 578.4 417 570.9 430.1L541 481.9C533.4 495 517.6 501.1 503.2 496.3L435.4 473.8C423.3 482.9 410.1 490.5 396.1 496.6L381.7 566.5C378.6 581.4 365.5 592 350.4 592L290.6 592C275.4 592 262.3 581.3 259.3 566.5L244.9 496.6C230.8 490.6 217.7 482.9 205.6 473.8L137.5 496.3C123.1 501.1 107.3 495.1 99.7 481.9L69.8 430.1C62.2 416.9 64.9 400.3 76.3 390.2L129.7 342.7C128.8 335.3 128.4 327.7 128.4 320C128.4 312.3 128.9 304.7 129.7 297.3L76.3 249.8C64.9 239.7 62.3 223 69.8 209.9L99.7 158.1C107.3 144.9 123.1 138.9 137.5 143.7L205.3 166.2C217.4 157.1 230.6 149.5 244.6 143.4L259.1 73.5zM320.3 400C364.5 399.8 400.2 363.9 400 319.7C399.8 275.5 363.9 239.8 319.7 240C275.5 240.2 239.8 276.1 240 320.3C240.2 364.5 276.1 400.2 320.3 400z"/></svg>
                            <span>{{ __('Configuración') }}</span>
                        </x-dropdown-link>

                        <hr class="border-gray-200 my-1">

                        <!-- Cerrar Sesión -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                    this.closest('form').submit();"
                                class="flex items-center gap-2 text-red-500 hover:text-red-700 hover:bg-red-50">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-4 h-4 fill-current shrink-0">
                                    <path d="M569 337C578.4 327.6 578.4 312.4 569 303.1L425 159C418.1 152.1 407.8 150.1 398.8 153.8C389.8 157.5 384 166.3 384 176L384 256L272 256C245.5 256 224 277.5 224 304L224 336C224 362.5 245.5 384 272 384L384 384L384 464C384 473.7 389.8 482.5 398.8 486.2C407.8 489.9 418.1 487.9 425 481L569 337zM224 160C241.7 160 256 145.7 256 128C256 110.3 241.7 96 224 96L160 96C107 96 64 139 64 192L64 448C64 501 107 544 160 544L224 544C241.7 544 256 529.7 256 512C256 494.3 241.7 480 224 480L160 480C142.3 480 128 465.7 128 448L128 192C128 174.3 142.3 160 160 160L224 160z"/>
                                </svg>

                                <span>{{ __('Cerrar sesión') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </nav>


        <main class="contenido flex-grow">
            @yield('content')
        </main>

        @stack('scripts')
    </body>
</html>
