@extends('layouts.app')

@section('title',  $nombreArchivo)

@push('styles')
    <!--  CSS  -->
    <link rel="stylesheet" href="{{ asset('css/pag_visualizacion_csv.css') }}">
@endpush

@section('content')
<div class="contenedor_general_csv">

 <!-- CABECERA  -->
    <div class="bloque_cabecera">
        <a href="{{ route('eliminar.csv', ['archivo' => $archivo]) }}" class="botonVolver">
           <i class="fa-solid fa-reply text-sky-900"></i>
        </a>
        <h6>Datos del Archivo:</h6>
        <h4>{{ $nombreArchivo }}</h4>
    </div>

<!--ERRORES GLOBALES -->      
    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

<!--BARRA SUPERIOR: TIPO DE VISTA Y BUSQUEDA -->

    <div class="barraSuperior">
        <form method="GET" action="{{ route('mostrar.csv', ['archivo' => $archivo]) }}" class="buscador">
            <div class="controlVista">
                <label for="opcionesVista">Mostrar:</label>
                    <select name="opcionesVista" id="opcionesVista" class="opcionesVista" onchange="this.form.submit()">
                        @foreach([5, 10, 20, 50] as $vistas)
                            <option value="{{ $vistas }}" {{ $datos->perPage() == $vistas ? 'selected' : '' }}>
                                {{ $vistas }}
                            </option>
                        @endforeach
                    </select>
            </div>

            <div class="busquedaInputs">
             
                <input type="text" class="inputBuscar" name="inputBuscar" value="{{ request('inputBuscar') }}" placeholder="¿Qué quieres buscar?">    
          
                <select class="opcionesBuscar" name="opcionesBuscar" style="margin: 0;">
                    <option value="" {{ request('opcionesBuscar') == '' ? 'selected' : '' }}>
                        Seleccione una opción
                    </option>
                    @foreach($datos->cabecera as $nombreColumna)
                        <option value="{{ $nombreColumna }}" {{ request('opcionesBuscar') == $nombreColumna ? 'selected' : '' }}>
                            {{ $nombreColumna }}
                        </option>
                    @endforeach
                </select>
                   
                <button type="submit" name="botonBuscar">Buscar</button>
                
                <a href="{{ route('mostrar.csv', ['archivo' => $archivo]) }}" class="btn-refrescar">
                   <i class="fa-solid fa-arrows-rotate text-sky-900"></i>
                </a>
            </div>
        </form>
    </div>

<!--TABLA -->
    <table class="tabla">
        <thead>
            <tr>
                @if($errors->has('error_general'))
                    <th></th>
                @else
                    @foreach ($datos->cabecera as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                @endif
            </tr>
        </thead>

        <tbody>
            @if($errors->has('error_general'))
                <tr>
                    <td>No es posible mostrar la información debido a un error.</td>
                </tr>
            @else
                @forelse ($datos as $row)
                    <tr>
                        @foreach ($row as $valor)
                            <td>{{ $valor }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                    <td colspan="{{ count($datos->cabecera) }}" style="text-align: center; padding: 20px;">
                        No se encontraron registros.
                    </td>
                    </tr>
                @endforelse
            @endif
        </tbody>
    </table>

<!--BARRA INFERIOR:CONTADOR Y PAGINACION -->
    <div class="barraInferior"> 
        <p class="contadorFilas">
            {{ $errors->has('error_general') ? 0 : $datos->total() }} registros
        </p>

        <div class="paginacion">
            @if(!$errors->has('error_general'))
                {{ $datos->links('partials.paginacion') }}
            @endif
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <!-- JS -->
    <script src="{{ asset('js/selector_vista.js') }}"></script>
@endpush