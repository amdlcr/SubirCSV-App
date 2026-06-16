<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('¿Has olvidado tu contraseña? No hay problema. Simplemente dinos tu dirección de correo electrónico y te enviaremos un enlace para restablecerla que te permitirá elegir una nueva.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" id="form-forgot-password">
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
                    required autofocus autocomplete="email" />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
         
        <div class="flex items-center justify-end mt-4">
            <!-- Boton iniciar sesion -->
            <x-primary-button class="boton-submit inline-flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-right-to-bracket boton-icon"></i>

                <i class="fa-solid fa-spinner fa-spin boton-spinner"></i>

                <span class="boton-text">Iniciar Sesión</span>
            </x-primary-button>
        </div>
    </form>
    @vite(['resources/js/spinner.js'])
</x-guest-layout>
