<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Tabla CSV</title>

        <link rel="stylesheet" href="{{ asset('css/pag_visualizacion_archivo.css') }}">
    </head>
    <body>

        <h2>Datos del Archivo</h2>

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

            @if($pagina > 1)
                <a class="botonesPaginacion"
                    href="{{ route('archivo.paginacion', 
                    ['pagina' => $pagina - 1,
                        'archivo' => $archivo]
                    ) }}">
                        Anterior
                </a>
            @endif

            @if(count($datos) == $filasPorPagina)
                <a class="botonesPaginacion"
                    href="{{ route('archivo.paginacion', 
                    ['pagina' => $pagina + 1,
                        'archivo' => $archivo]
                    ) }}">
                        Siguiente
                </a>
            @endif

        </div>

        <br>

        <a class="botonesPaginacion" href="{{ route('inicio') }}">Volver al inicio</a>

    </body>
</html>