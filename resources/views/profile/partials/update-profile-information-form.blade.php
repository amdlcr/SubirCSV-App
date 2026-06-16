<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Actualiza la información del perfil de tu cuenta y tu dirección de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Name -->
        <div class="mb-4">
            <x-input-label for="name" :value="__('Name')" />
                <div class="relative mt-1"> 

                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fa-solid fa-user text-gray-400"></i>
                    </div>

                    <x-text-input id="name" class="block w-full pl-10" 
                        type="text" 
                        name="name" 
                        :value="old('name', $user->name)" 
                        placeholder="Introduce tu nombre" 
                        required autofocus autocomplete="name" />
                </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
    <x-input-label for="email" :value="__('Email')" />
    
    <!-- Email -->
    <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <i class="fa-solid fa-envelope text-gray-400"></i>
            </div>

            <x-text-input id="email" name="email" type="email" class="block w-full pl-10" :value="old('email', $user->email)" placeholder="Introduce tu correo electrónico" required autocomplete="username" />
        </div>

        <x-input-error class="mt-2" :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Tu dirección de correo electrónico no está verificada.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Haz clic aquí para reenviar el correo de verificación.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>{{ __('Guardar') }}</span>
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</section>
