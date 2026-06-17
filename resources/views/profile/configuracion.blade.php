@extends('layouts.app')

@section('title', __('Configuración de Seguridad'))

@section('content')
    <div class="py-12">
    <div class="max-w-3xl mx-auto space-y-6 px-4">

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl mx-auto">
                @include('profile.partials.two-factor-authentication-form', ['user' => auth()->user()])
            </div>
        </div>

    </div>
</div>
@endsection
