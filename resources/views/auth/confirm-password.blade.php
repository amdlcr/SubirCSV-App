<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mt-4">
            <div class="password-wrapper relative">
                <!-- Icono llave -->
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                   <i class="fa-solid fa-key text-gray-400"></i>
                </div>

                <x-text-input  required class="password-input block w-full pl-10 pr-10"
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

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
    
</x-guest-layout>
