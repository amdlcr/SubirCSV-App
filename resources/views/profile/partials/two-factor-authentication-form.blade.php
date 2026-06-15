<section>
    <header class="mb-6">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Autenticación de Doble Factor (2FA)') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Añade una capa extra de seguridad a tu cuenta utilizando códigos temporales con Google Authenticator.') }}
        </p>
    </header>

    {{--  El 2FA no se ha activado --}}
    @if(!$user->two_factor_secret)
        <div x-data="formularioDosFactor">
            <div x-show="cargando" class="mb-4 p-4 bg-blue-50 text-blue-700 text-sm rounded border border-blue-200 animate-pulse">
                {{ __('Generando claves de seguridad y código QR. Por favor, espere...') }}
            </div>

            <form x-show="!cargando" x-ref="form2fa" method="POST" action="{{ route('two-factor.enable') }}" @submit="guardarIntento()">
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
            <form method="POST" action="{{ route('two-factor.confirm') }}" class="space-y-4">
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
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-4 h-4 fill-current inline-block"><path d="M530.8 134.1C545.1 144.5 548.3 164.5 537.9 178.8L281.9 530.8C276.4 538.4 267.9 543.1 258.5 543.9C249.1 544.7 240 541.2 233.4 534.6L105.4 406.6C92.9 394.1 92.9 373.8 105.4 361.3C117.9 348.8 138.2 348.8 150.7 361.3L252.2 462.8L486.2 141.1C496.6 126.8 516.6 123.6 530.9 134z"/></svg>
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
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-4 h-4 fill-current inline-block"><path d="M320 64C334.7 64 348.2 72.1 355.2 85L571.2 485C577.9 497.4 577.6 512.4 570.4 524.5C563.2 536.6 550.1 544 536 544L104 544C89.9 544 76.8 536.6 69.6 524.5C62.4 512.4 62.1 497.4 68.8 485L284.8 85C291.8 72.1 305.3 64 320 64zM320 416C302.3 416 288 430.3 288 448C288 465.7 302.3 480 320 480C337.7 480 352 465.7 352 448C352 430.3 337.7 416 320 416zM320 224C301.8 224 287.3 239.5 288.6 257.7L296 361.7C296.9 374.2 307.4 384 319.9 384C332.5 384 342.9 374.3 343.8 361.7L351.2 257.7C352.5 239.5 338.1 224 319.8 224z"/></svg>
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
                <div x-data="formularioCodigos">
                    <div x-show="cargando" class="mb-4 p-4 bg-blue-50 text-blue-700 text-sm rounded border border-blue-200 animate-pulse">
                        {{ __('Regenerando nuevos códigos de emergencia. Por favor, espera...') }}
                    </div>
                    <form x-show="!cargando" x-ref="formCodigos" method="POST" action="{{ route('two-factor.recovery-codes') }}" @submit="guardarIntento()">
                        @csrf
                        <x-secondary-button type="submit">
                            {{ __('Regenerar Códigos de Recuperación') }}
                        </x-secondary-button>
                    </form>
                </div>
            </div>
        @endif
    @endif
</section>