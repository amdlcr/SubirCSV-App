<x-guest-layout>
    <div class="flex flex-col items-center justify-center mb-6 pt-2">
        <div class="flex items-center justify-center w-20 h-20 bg-white rounded-full border border-blue-500">
            <i class="fa-solid fa-user text-blue-500 text-5xl"></i>
        </div>
        <span class="text-sm font-semibold text-blue-500 mt-2">Accede a tu cuenta</span>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('login') }}" id="form-login">
        @csrf

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
        <div class="mt-4">
            <div class="password-wrapper relative">
                <!-- Icono llave -->
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                   <i class="fa-solid fa-key text-gray-400"></i>
                </div>

                <x-text-input required class="password-input block w-full pl-10 pr-10"
                    type="password"
                    name="password"
                    placeholder="Introduce tu contraseña"
                    autocomplete="current-password" />

                <!-- Boton ojo -->
                <button type="button" class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i id="ojo" class="fa-solid fa-eye text-gray-400"></i>
                </button>
                
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recordar contraseña') }}</span>
            </label>
        </div>

        <div class="flex flex-col items-center justify-center mt-8 w-full">
            <!-- Boton iniciar sesion -->
            <x-primary-button class="boton-submit inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket boton-icon"></i>

                <i class="fa-solid fa-spinner fa-spin boton-spinner"></i>

                <span class="boton-text">Iniciar Sesión</span>
            </x-primary-button>
            
            <!-- Recuperar contraseña -->
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    {{ __('¿Has olvidado tu contraseña?') }}
                </a>
            @endif

        </div>
    </form>

    <!-- Registro -->
    <div class="text-center w-full mt-2">          
        <span class="text-sm text-gray-600">
            ¿No tienes cuenta? 
            <a class="underline text-base text-blue-600 hover:text-blue-900 font-semibold rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400" href="{{ route('register') }}">
                {{ __('Regístrate') }}
            </a>
        </span>
    </div> 

</x-guest-layout>
