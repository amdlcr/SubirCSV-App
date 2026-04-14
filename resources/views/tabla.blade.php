<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla</title>
    <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('css/tabla.css') }}">
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

@if($pagina > 1)
    <a class="botonesPaginacion" href="{{ route('archivo.paginacion', ['pagina' => $pagina - 1]) }}">Anterior</a>
@endif

@if($pagina * 10 < $total)
    <a class="botonesPaginacion" href="{{ route('archivo.paginacion', ['pagina' => $pagina + 1]) }}">Siguiente</a>
@endif
    
</body>
</html>