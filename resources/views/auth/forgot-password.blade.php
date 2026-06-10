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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-5 h-5 fill-current text-gray-400"><path d="M112 128C85.5 128 64 149.5 64 176C64 191.1 71.1 205.3 83.2 214.4L291.2 370.4C308.3 383.2 331.7 383.2 348.8 370.4L556.8 214.4C568.9 205.3 576 191.1 576 176C576 149.5 554.5 128 528 128L112 128zM64 260L64 448C64 483.3 92.7 512 128 512L512 512C547.3 512 576 483.3 576 448L576 260L377.6 408.8C343.5 434.4 296.5 434.4 262.4 408.8L64 260z"/></svg>
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
            <x-primary-button id="btn-forgot-password" class="inline-flex items-center justify-center gap-2 transition-all duration-200">
                <!-- Spinner  -->
                <svg id="spinner-forgot-password" class="hidden animate-spin h-4 w-4 text-white" xmlns="http://w3.org" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>

                <span id="text-forgot-password">{{ __('Enviar enlace de restablecimiento') }}</span>
            </x-primary-button>
        </div>
    </form>
    @vite(['resources/js/spinner.js'])
</x-guest-layout>
