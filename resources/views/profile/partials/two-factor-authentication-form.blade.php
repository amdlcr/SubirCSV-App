<section>
  
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Autenticación de Doble Factor (2FA)') }}
        </h2>
    </header>

    @php
        $user = auth()->user()->fresh();
    @endphp

    {{--  El 2FA no se ha activado --}}
    @if(!$user->two_factor_secret)
        <div class="p-4 bg-gray-50 border rounded">
            <p class="mb-4 text-sm text-gray-600">
                {{ __('Activa la autenticación en dos pasos para proteger tu cuenta.') }}
            </p>
    
            <form method="POST" action="{{ url('/user/two-factor-authentication') }}">
                @csrf
                    <x-primary-button type="submit">
                        {{ __('Activar Doble Factor') }}
                    </x-primary-button>
            </form>
        </div>  
    @else
        {{-- Se crear el secreto pero no esta confirmado --}}
        @if(is_null($user->two_factor_confirmed_at))
            <div class="mb-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 text-sm rounded">
                <p class="font-bold">{{ __('Escanea el código QR con tu aplicación móvil para sincronizar los códigos.') }}</p>
            </div>

            {{-- Codigo QR  --}}
            <div class="mb-4 p-4 bg-white inline-block border border-gray-200 rounded shadow-sm text-center">
                <div class="inline-block p-2 bg-white rounded">
                    {!! $user->twoFactorQrCodeSvg() !!}
                </div>
            </div>
            
            <p class="text-sm text-gray-600 mb-6">
                {{ __('Clave manual si no puedes escanear el código QR:') }} 
                <span class="font-mono bg-gray-100 px-2 py-1 rounded text-gray-800 break-all select-all block mt-1 w-full border text-center text-xs">
                    {{ decrypt($user->two_factor_secret) }}
                </span>
            </p>

            {{--  Formulario de validacion del código TOTP para confirmar la activación del 2FA--}}
            <form method="POST" action="{{ url('/user/confirmed-two-factor-authentication') }}" class="space-y-4">
                @csrf
                <div>
                    <x-input-label for="code" :value="__('Introduce el código de 6 dígitos de tu app')" />
                    <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus placeholder="000000" maxlength="6" autocomplete="one-time-code" />
                </div>
                <x-primary-button type="submit">
                    {{ __('Confirmar y Activar 2FA') }}
                </x-primary-button>
            </form>

        @else
            {{-- EL 2FA esta confirmado y activo --}}
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded">
                <p class="font-bold flex items-center gap-2">
                    <i class="fa-solid fa-check"></i>
                    <span>{{ __('El sistema 2FA está protegiendo tu cuenta.') }}</span>
                </p>
            </div>

            {{-- Permitir desactivar el 2FA solo al rol de administrador --}}
            <div class="border-t border-gray-200 pt-6 mb-6">
                <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Desactivar Protección') }}</h3>
                @if($user->role === 'admin')
                    <form method="POST" action="{{ route('two-factor.disable') }}">
                        @csrf
                        @method('DELETE')
                        <x-danger-button type="submit">
                            {{ __('Desactivar 2FA') }}
                        </x-danger-button>
                    </form>
                @else
                    <p class="text-sm text-amber-600 bg-amber-50 p-3 rounded border border-amber-200 flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        <span>{{ __('Solo un usuario con rol de Administrador puede desactivar el 2FA de esta cuenta.') }}</span>
                    </p>
                @endif
            </div>

            {{-- Codigos de recuperacion --}}
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-900 mb-2">{{ __('Códigos de Recuperación') }}</h3>
                
                @php
                    $codigos = $user->two_factor_recovery_codes 
                        ? json_decode(decrypt($user->two_factor_recovery_codes), true) 
                        : [];
                @endphp

                {{-- Ver cuantos codigos quedan --}}
                <p class="text-sm text-gray-600 mb-4">
                    {{ __('Te quedan') }} <span class="font-bold text-gray-900">{{ count($codigos) }}</span> {{ __('códigos de emergencia restantes:') }}
                </p>

                <div class="grid grid-cols-2 gap-2 max-w-sm mb-4 font-mono text-sm bg-gray-50 p-3 rounded border text-gray-700">
                    @foreach($codigos as $code)
                        <div class="bg-white p-1 rounded border shadow-sm text-center select-all">{{ $code }}</div>
                    @endforeach
                </div>

                {{-- Regenerar codigos de recuperacion --}}
                <form method="POST" action="{{ url('/user/two-factor-recovery-codes') }}">
                        @csrf
                        <x-primary-button type="submit" class="boton-submit inline-flex items-center justify-center gap-2">
                            {{ __('Regenerar Códigos de Recuperación') }}
                        </x-primary-button>
                    </form>

            </div>
        @endif
    @endif
</section>