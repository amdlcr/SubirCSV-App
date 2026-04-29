<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvRequest; //Gestionamos la validacion aqui
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Services\CsvService;
use SplFileObject;
use Illuminate\Pagination\LengthAwarePaginator;

class CsvController extends Controller{

    protected $csvService;

    public function __construct(CsvService $csvService) {
        $this->csvService = $csvService;
    }

    /**
     * Recoge el archivo CSV y lo almacena en el servidor.
     *
     * @param  \App\Http\Requests\CsvRequest  $request con el archivo.
     * @return \Illuminate\Http\RedirectResponse Redirige a la ruta de visualizacion, y devuelve un array con 'archivo' y 'nombreArchivo'.
     */
    public function leer(CsvRequest $request){
        
        $archivo= $request->file('anadirArchivo'); //Accedemos al archivo 
        $nombreArchivo = $archivo->getClientOriginalName(); //Seleccionamos el nombre del archivo 
        $archivoAlmacenado = $archivo->store('csv'); //Guardamos la ruta del archivo

        return redirect()->route('archivo.mostrar',
         ['archivo' => $archivoAlmacenado,
          'nombreArchivo'=>$nombreArchivo
         ]);
    }

    /**
     * Procesa y muestra el contenido del CSV con soporte para busqueda y paginacion.
     *
     * @param  \Illuminate\Http\Request  $request con parámetros de filtro, archivo y página.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Vista con datos paginados o redirección por error, con los parametros necesarios para la vista.
     */
    public function mostrar(Request $request){
        $archivo = $request->get('archivo'); 
        if (!Storage::exists($archivo)) {
            return redirect()->route('index')->withErrors('Archivo no encontrado');
        }

        $nombreArchivo = $request->get('nombreArchivo', ''); //Recogemos el nombre del archivo que envio el metodo leer
        
        $resultado = $this->csvService->buscar(
            $archivo, 
            $request->get('inputBuscar'), 
            $request->get('opcionesBuscar'),
            $request->get('separador')
        );
        
        if (is_null($resultado)) {
            return redirect()->route('index')->withErrors('El archivo está vacío.');
        }
        
        $todasLasFilas = $resultado['filas'];
        $totalFilas= count($todasLasFilas);
        $paginaActual = LengthAwarePaginator::resolveCurrentPage();//   
        $filasPorPagina = (int) $request->get('opcionesVista', 10); //numero de filas que se van a amostrar por pagina

         //paginacion, solo se leen 10 paginas por linea
        $inicio = ($paginaActual - 1) * $filasPorPagina;
        $datosPaginados = array_slice($todasLasFilas, $inicio, $filasPorPagina);
        
        $paginador = new LengthAwarePaginator(  //Clase de laravel para paginar
            $datosPaginados, 
            $totalFilas, 
            $filasPorPagina, 
            $paginaActual, 
            [
                'path' => $request->url(),
                'query' => $request->query(), // Esto mantiene 'archivo' y 'nombreArchivo' automaticamente,permite que el paginador "recuerde" los parametros
            ]
        );

        $paginador->onEachSide(2); 
       
        //Enviamos la informacion a la vista donde se muestra
        return view('visualizacionCsv', [
            'columnas' => $resultado['columnas'],
            'datos'=> $paginador,
            'archivo' => $archivo,
            'nombreArchivo'=> $nombreArchivo,
            'totalFilas'=>$totalFilas,
            'filasPorPagina'=>$filasPorPagina,
            'separador' => $resultado['separador']
        ]);
    }

    /**
     * Elimina un archivo CSV del almacenamiento si existe.
     *
     * @param  \Illuminate\Http\Request  $request Objeto que debe contener la ruta del archivo.
     * @return \Illuminate\Http\RedirectResponse Redireccion a la ruta 'index'.
     */
    public function eliminarCsv(Request $request){
        $archivo = $request->input('archivo');

        if (Storage::exists($archivo)) {
            Storage::delete($archivo);
        }
        return redirect()->route('index');
    }

}