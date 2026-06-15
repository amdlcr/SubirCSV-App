<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esta cuenta está protegida por una capa de seguridad adicional. Introduce el código TOTP generado por tu aplicación o usa un código de recuperación de emergencia.') }}
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <!-- Codigo TOTP  -->
        <div class="mt-4">
            <x-input-label for="code" :value="__('Código de Autenticación')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" autofocus autocomplete="one-time-code" placeholder="000000" maxlength="6" />
        </div>

        <div class="text-center my-4 text-xs text-gray-400 font-semibold uppercase tracking-wider">
            {{ __('O también puedes') }}
        </div>

        <!-- Codigo de recuperación -->
        <div>
            <x-input-label for="recovery_code" :value="__('Código de Recuperación de Emergencia')" />
            <x-text-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" autocomplete="one-time-code" placeholder="abcde-12345" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="ms-3">
                {{ __('Confirmar y Acceder') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
