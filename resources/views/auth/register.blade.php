<x-guest-layout>

    <div class="flex flex-col items-center justify-center mb-6 pt-2">
        <div class="flex items-center justify-center w-20 h-20 bg-white-100 rounded-full border border-blue-500">
            <i class="fa-solid fa-user-pen text-4xl text-blue-500"></i>
        </div>
        <span class="text-sm font-semibold text-blue-500 mt-2">Crea tu cuenta</span>
    </div>

    <form class="form-con-spinner" method="POST" action="{{ route('register') }}" id="form-register">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <div class="relative"> 
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-user text-gray-400" ></i>
                </div>

                <x-text-input id="name" class="block w-full pl-10" 
                    type="text" 
                    name="name" 
                    :value="old('name')" 
                    placeholder="Introduce tu nombre" 
                    required autofocus autocomplete="name" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <div class="relative">
    
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fa-solid fa-envelope text-gray-400"></i>
                </div>

                <x-text-input id="email" class="block w-full pl-10" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="Introduce tu correo electrónico" 
                    required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <div class="password-wrapper relative">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                   <i class="fa-solid fa-key text-gray-400"></i>
                </div>

                <x-text-input class="password-input block w-full pl-10 pr-10"
                    type="password"
                    name="password"
                    placeholder="Introduce tu contraseña"
                    required autocomplete="current-password" />

                <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class="fa-solid fa-eye password-icon text-gray-400"></i>
                </button>

            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <div class="password-wrapper relative">

                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                   <i class="fa-solid fa-key text-gray-400"></i>
                </div>

                <x-text-input class="password-input block w-full pl-10 pr-10"
                    type="password"
                    name="password_confirmation"
                    placeholder="Confirma tu contraseña"
                    required autocomplete="new-password" />

                <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i id="ojo" class="fa-solid fa-eye text-gray-400"></i>
                </button>

            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6 w-full gap-4">
            <div class="flex items-center">
                <!-- Iniciar sesion -->
                @if (Route::has('login'))
                    <span class="text-sm text-gray-600">
                        ¿Ya estás registrado? 
                        <a class="underline text-base text-blue-600 hover:text-blue-900 font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400" href="{{ route('login') }}">
                            {{ __('Iniciar Sesión') }}
                        </a>
                    </span>
                @endif
            </div>

            <!-- Boton registrar -->
            <x-primary-button class="boton-submit inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-pen-to-square boton-icon"></i>

                <i class="fa-solid fa-spinner fa-spin boton-spinner"></i>

                <span class="boton-text">Registrar</span>
            </x-primary-button>
        </div>
    </form>
    
</x-guest-layout>
