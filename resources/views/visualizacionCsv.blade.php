<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Archivo: {{ $nombreArchivo }}</title>

        <link rel="stylesheet" href="{{ asset('css/pag_visualizacion_csv.css') }}">
    </head>
    <body>
        
<!--BOTON VOLVER AL INICIO -->
    <form action="{{ route('eliminar.csv') }}" method="POST">
    @csrf
        <input type="hidden" name="archivo" value="{{ $archivo }}">
            <button type="submit" class="botonVolver">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M268.2 82.4C280.2 87.4 288 99 288 112L288 192L400 192C497.2 192 576 270.8 576 368C576 481.3 494.5 531.9 475.8 542.1C473.3 543.5 470.5 544 467.7 544C456.8 544 448 535.1 448 524.3C448 516.8 452.3 509.9 457.8 504.8C467.2 496 480 478.4 480 448.1C480 395.1 437 352.1 384 352.1L288 352.1L288 432.1C288 445 280.2 456.7 268.2 461.7C256.2 466.7 242.5 463.9 233.3 454.8L73.3 294.8C60.8 282.3 60.8 262 73.3 249.5L233.3 89.5C242.5 80.3 256.2 77.6 268.2 82.6z"/></svg>
            </button>
    </form>

<!--TITULOS -->
        <h4>Datos del Archivo:</h4>
        <h2>{{ $nombreArchivo }}</h2>

<!--BARRA SUPERIOR: TIPO DE VISTA Y BUSQUEDA -->
    <div class="barraSuperior">
        <form method="GET">
            <input type="hidden" name="archivo" value="{{ $archivo }}"> <!-- Asi le indicamos a la vista al navegar en que archivo estamos  -->
            <input type="hidden" name="inputBuscar" value="{{ request('inputBuscar') }}">
            <input type="hidden" name="opcionesBuscar" value="{{ request('opcionesBuscar') }}">
            
            <label for="opcionesVista">Mostrar:</label>
                <select name="opcionesVista" id="opcionesVista" class="opcionesVista">
                    @foreach([5, 10, 20, 50] as $vistas)
                        <option value="{{ $vistas }}" {{ $filasPorPagina == $vistas ? 'selected' : '' }}>
                            {{ $vistas }}
                        </option>
                    @endforeach
                </select>
        </form>

        <form method="GET" class="buscador">
            <input type="hidden" name="archivo" value="{{ $archivo }}"><!-- Asi le indicamos a la vista al navegar en que archivo estamos  -->
            <input type="text" class="inputBuscar" name="inputBuscar"  value="{{ request('inputBuscar') }}" placeholder="¿Qué quieres buscar?">    
                <select class="opcionesBuscar" name="opcionesBuscar">
                    @foreach($columnas as $indice => $nombreColumna)
                    <option value="{{ $indice }}" {{ request('opcionesBuscar') == $indice ? 'selected' : '' }}>
                        {{ $nombreColumna }}
                    </option>
                    @endforeach
                </select>
            <button type="submit">Buscar</button>
        </form>
    </div>

<!--TABLA -->
    <table class="tabla">
        <thead>
            <tr>
                @foreach ($columnas as $col)
                    <th>{{ $col }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @if($datos->count() > 0)
                @foreach ($datos as $row)
                    <tr>
                        @foreach ($columnas as $col)
                            <td>{{ $row[$col] ?? '' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="{{ count($columnas) }}" style="text-align: center; padding: 20px;">
                        No se encontraron registros.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

<!--BARRA INFERIOR:CONTADOR Y PAGINACION -->
    <div class="barraInferior"> 
        <p class="contadorFilas">
            {{ $totalFilas }} registros
        </p>

        <div class="paginacion">
          {{ $datos->links('vendor.pagination.tailwind') }}
        </div>
    </div>
    
    <script src="{{ asset('js/selector_vista.js') }}"></script>
    </body>
</html>