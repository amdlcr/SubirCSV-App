<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Archivo: {{ $nombreArchivo }}</title>

        <link rel="stylesheet" href="{{ asset('css/pag_visualizacion_archivo.css') }}">
    </head>
    <body>
         <a class="botonVolver" href="{{ route('inicio') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M268.2 82.4C280.2 87.4 288 99 288 112L288 192L400 192C497.2 192 576 270.8 576 368C576 481.3 494.5 531.9 475.8 542.1C473.3 543.5 470.5 544 467.7 544C456.8 544 448 535.1 448 524.3C448 516.8 452.3 509.9 457.8 504.8C467.2 496 480 478.4 480 448.1C480 395.1 437 352.1 384 352.1L288 352.1L288 432.1C288 445 280.2 456.7 268.2 461.7C256.2 466.7 242.5 463.9 233.3 454.8L73.3 294.8C60.8 282.3 60.8 262 73.3 249.5L233.3 89.5C242.5 80.3 256.2 77.6 268.2 82.6z"/></svg>
         </a>

        <h4>Datos del Archivo:</h4>
        <h2>{{ $nombreArchivo }}</h2>

        <div class="opcionesVisualizacion">
            <label for="opciones">Vista</label>
                <select name="opciones" id="opciones" class="mi-selector">
                    <option value="1">5</option>
                    <option value="2">10</option>
                    <option value="3">20</option>
                    <option value="4">50</option>
                </select>
        </div>

        <table class="tabla">
            <thead>
                <tr>
                    @foreach ($columnas as $col)
                        <th>{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach ($datos as $row)
                    <tr>
                        @foreach ($columnas as $col)
                            <td>{{ $row[$col] ?? '' }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        <br>

        <div class="paginacion">
            <div class="botonesPaginacion">
                @if (!$datos->onFirstPage())
                    <a class="botonIzquierda" href="{{ $datos->previousPageUrl() }}">
                        {{-- SVG Flecha Izquierda --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM199 303L279 223C288.4 213.6 303.6 213.6 312.9 223C322.2 232.4 322.3 247.6 312.9 256.9L273.9 295.9L424 295.9C437.3 295.9 448 306.6 448 319.9C448 333.2 437.3 343.9 424 343.9L273.9 343.9L312.9 382.9C322.3 392.3 322.3 407.5 312.9 416.8C303.5 426.1 288.3 426.2 279 416.8L199 336.8C189.6 327.4 189.6 312.2 199 302.9z"/></svg>
                    </a>
                @endif

                <div class="numerosPaginacion">
                        @foreach ($paginasBarra as $pagina => $url)
                            <a href="{{ $url }}" class="numero {{ $pagina == $datos->currentPage() ? 'pagina-activa' : '' }}">
                                {{ $pagina }}
                            </a>
                        @endforeach
                    </div>

                @if ($datos->hasMorePages())
                    <a class="botonDerecha" href="{{ $datos->nextPageUrl() }}">
                        {{-- SVG Flecha Derecha --}}
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M320 576C461.4 576 576 461.4 576 320C576 178.6 461.4 64 320 64C178.6 64 64 178.6 64 320C64 461.4 178.6 576 320 576zM361 417C351.6 426.4 336.4 426.4 327.1 417C317.8 407.6 317.7 392.4 327.1 383.1L366.1 344.1L216 344.1C202.7 344.1 192 333.4 192 320.1C192 306.8 202.7 296.1 216 296.1L366.1 296.1L327.1 257.1C317.7 247.7 317.7 232.5 327.1 223.2C336.5 213.9 351.7 213.8 361 223.2L441 303.2C450.4 312.6 450.4 327.8 441 337.1L361 417.1z"/></svg>  
                    </a>
                @endif
            </div>

            <p class="contadorPaginas">
                Página {{ $datos->currentPage() }} de {{ $datos->lastPage() }}
            </p>
            
        </div>
       

    </body>
</html>