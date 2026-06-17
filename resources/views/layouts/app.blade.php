<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', config('app.name', 'CSViewer'))</title>

        <!--  Vite(CSS y JS) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- css comun -->
        <link rel="stylesheet" href="{{ asset('css/global.css') }}">
        @stack('styles')
       
    </head>
    <body class="min-h-screen w-screen m-0 p-0 overflow-x-hidden">

    
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat -z-10" ></div>

     
        <div class="min-h-screen flex flex-col">

            <!-- NAVBAR -->
            <nav class="w-full bg-slate-50 border-b border-gray-200 py-3 px-6 flex justify-between items-center shadow-sm shrink-0 z-50">
                <!-- Logo  -->
                <div class="flex items-center space-x-2">
                    <a href="{{ isset($archivo) ? route('eliminar.csv', ['archivo' => $archivo]) : route('index') }}" class="flex items-center hover:opacity-90 transition">
                        <img src="{{ asset('images/Logo-CSViewer.png') }}" alt="CSViewer" class="h-16 w-auto">
                    </a>
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

                        <div class="px-4 py-3 bg-gray-50 rounded-t-md flex flex-col justify-start text-center">
                            <span class="text-sm font-semibold text-sky-400 tracking-wider block">Hola,</span>
                            <span class="text-base font-bold text-sky-800 break-words mt-0.5 block">{{ Auth::user()->name }}</span>
                        </div>
                            <!-- Enlace A: Ver Perfil -->
                            <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                                <i class="fa-solid fa-user text-gray-400"></i>
                                <span>{{ __('Perfil') }}</span>
                            </x-dropdown-link>

                            <!-- Configuración -->
                            <x-dropdown-link :href="route('profile.configuracion')" class="flex items-center gap-2">
                                <i class="fa-solid fa-gear text-gray-400"></i>
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
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                    <span>{{ __('Cerrar sesión') }}</span>
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </nav>


            <main class="flex-1">
                @yield('content')
            </main>
        </div>
        @stack('scripts')
    </body>
    <script src="{{ asset('js/global.js') }}"></script>
</html>
