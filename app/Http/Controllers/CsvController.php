<?php

namespace App\Http\Controllers;

use App\Http\Requests\CsvRequest; //Gestionamos la validacion aqui
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Services\CsvService;
use SplFileObject;


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

        $archivoAlmacenado = $archivo->store('csv');
        $this->csvService->preprocessCsv($archivoAlmacenado);//Guardamos la ruta del archivo

        return redirect()->route('archivo.mostrar',
         ['archivo' => $archivoAlmacenado,
          'nombreArchivo'=>$nombreArchivo
         ]);
    }

    /**
     * Coordina la lectura, filtrado y paginación de un archivo CSV para su visualizacion.
     *
     * @param \Illuminate\Http\Request $request Peticion con la ruta del archivo, terminos de busqueda y opciones de vista.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Vista de visualizacion o redireccion en caso de error.
     */
   public function mostrar(Request $request){
        $archivo = $request->get('archivo');//Recoge la ruta del archivo a tratar

        //Si el archivo no existe devuelve error al usuario en el inicio
        if (!$archivo || !Storage::exists($archivo)) {
            return redirect()->route('index')->withErrors('Archivo no encontrado');
        }

        $nombreArchivo = $request->get('nombreArchivo', '');//Recogemos el nombre del archivo que envio el metodo leer
        $resultado = $this->csvService->processCsv($archivo);//Lee el archivo y lo estructura en columnas y filas

        //Si el archivo esta vacio o no tiene cabeceras devuelve error al usuario en el inicio
        if (is_null($resultado) || empty($resultado['columnas'])) {
            return redirect()->route('index')->withErrors('El archivo está vacío o es inválido.');
        }

        //Pasamos los datos por el filtro de busqueda, si no hay busqueda muestra todos los datos del archivo
        $filasFiltradas = $this->csvService->filtrarFilas(
            $resultado['filas'],
            $request->get('inputBuscar'),
            $request->get('opcionesBuscar')
        );

        $filasPorPagina = (int) $request->get('opcionesVista', 10);// Determinamos la cantidad de registros a mostrar por pagina
        $paginador = $this->csvService->paginar($filasFiltradas, $filasPorPagina, $request); //Creamos el paginador

        //Enviamos la informacion a la vista donde se muestra
        return view('visualizacionCsv', [
            'columnas'       => $resultado['columnas'],
            'datos'          => $paginador,
            'archivo'        => $archivo,
            'nombreArchivo'  => $nombreArchivo,
            'totalFilas'     => count($filasFiltradas),
            'filasPorPagina' => $filasPorPagina
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