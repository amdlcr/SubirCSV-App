@extends('layouts.app')

@section('title', config('app.name', 'CSViewer'))

@push('styles')
    <!--  CSS  -->
    <link rel="stylesheet" href="{{ asset('css/pag_index.css') }}">
@endpush

@section('content')
    <div class="contenedor_inicio">
        
        <!-- Tarjeta blanca -->
        <div class="tarjeta_bienvenida @if($errors->any()) tarjeta-con-error @endif">
            
            <!-- Bloque izquierdo: Input y boton de subida archivo -->
            <div class="bloque_izquierdo">
                <form action="{{ route('leer.csv') }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    
                    <div class="grupo_subida">
                        <p class="texto_instruccion">Selecciona tu archivo CSV</p>
                        
                        <input id="entrada_archivo" class="entrada_archivo" type="file" name="anadirArchivo" accept=".csv" required>
                        
                        <label for="entrada_archivo" class="boton_imagen_subir" id="mi_label">
                            <img src="{{ asset('images/CSViewer-carpeta.png') }}" alt="Subir archivo" class="vista_imagen_boton">
                        </label>

                        <div id="nombre_archivo_elegido" class="nombre_archivo_texto"></div>

                        <button class="boton_subir" id="boton_subir" type="submit" style="display: none;">
                            <span>Mostrar</span>
                        </button> 
                    </div>
                </form>
            </div>

            <!-- Bloque derecho: Imagen mascota -->
            <div class="bloque_derecho">
                <div class="mascota">
                    @if ($errors->any())
                        <img src="{{ asset('images/CSViewer-mascota-error.png') }}" alt="CSViewy Error" class="imagen_avatar">
                    @else
                        <img src="{{ asset('images/CSViewer-mascota-hola.png') }}" alt="CSViewy Hola" class="imagen_avatar">
                    @endif
                </div>
            </div>

        </div>

        <!-- Mensajes de error -->
        @if ($errors->any())
            <div class="alerta-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/boton_subida.js') }}"></script>
@endpush