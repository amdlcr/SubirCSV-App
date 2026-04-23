<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use SplFileObject;
use Illuminate\Pagination\LengthAwarePaginator;

class ArchivoControlador extends Controller{

    public function leer(Request $request)
    {
        //validacion del archivo que se va acargar
        $request->validate([
            'anadirArchivo' => 'required|file|mimes:csv,txt'
        ], [
            'anadirArchivo.required' => 'Debes subir un archivo.',
            'anadirArchivo.file' => 'Debes subir un archivo válido.',
            'anadirArchivo.mimes' => 'El archivo debe ser tipo csv o txt.'
        ]);

        
        $archivo= $request->file('anadirArchivo'); //Accedemos al archivo una vez es valido
        $nombreArchivo = $archivo->getClientOriginalName(); //Seleccionamos el nombre del archivo que introdujo el usuario, para luego el titutlo de la tabla
        $archivoAlmacenado = $archivo->store('csv'); //Guardamos la ruta del archivo

        //Enviamos los datos a la vista de visualizacion del archivo y ejecutamos el método paginacion()
        return redirect()->route('archivo.paginacion',
         ['archivo' => $archivoAlmacenado,
          'nombreArchivo'=>$nombreArchivo
         ]);
    }

    public function paginacion(Request $request){
        $archivo = $request->get('archivo'); //Recibimos el archivo

        //Si no llega el archivo guardado devuelve al inicio y con mensaje de error
        if (!Storage::exists($archivo)) {
            return redirect()->route('inicio')->withErrors('Archivo no encontrado');
        }

        $nombreArchivo = $request->get('nombreArchivo', 'Archivo sin nombre'); //Recogemos el nombre del archivo que envio el metodo leer
        $rutaAbsoluta = Storage::path($archivo);//convertimos en ruta abosoluta para SplFileObject
        $totalFilas= count(file($rutaAbsoluta))-1;//Contamos las lineas del archivo y quitamos la fila de la cabecera

        $objetoLectura = new SplFileObject($rutaAbsoluta); //creamos el objeto de lectura
        $objetoLectura->setFlags(SplFileObject::READ_CSV); //Le decimos como debe leerlo, como csv. Porque esta clase lee mas tipos de archivos
        $objetoLectura->setCsvControl(';'); //explicamos en separador

        $paginaActual = LengthAwarePaginator::resolveCurrentPage();//
        $filasPorPagina = 5; //numero de filas que se van a amostrar por pagina

        $columnas = $objetoLectura->fgetcsv(); // lee las cabeceras de las columnas
        //Si encuentra la primera fila/encabezados retorna a la pagina de inicio con mensaje de error
        if (!$columnas) {
            return back()->withErrors('El archivo esta vacío.');
        }

        //Limpiamos los encabezados de la tabla
        $columnas = array_map([$this, 'normalizarTexto'], $columnas);

        //paginacion, solo se leen 10 paginas por linea
        $inicio = ($paginaActual - 1) * $filasPorPagina;
        $objetoLectura->seek($inicio + 1);

       
        $datos = []; //creamos el array donde vamos a almacenar la informacion del archivo
         //Recorremos el archivo de datos y vamos llenando cada fila en un array
        for ($i = 0; $i < $filasPorPagina && !$objetoLectura->eof(); $i++) { //eof() funcion de la clase que le indica cuando tiene que parar de leer
            $fila = $objetoLectura->fgetcsv();// fgetcsv() funcion que lee cada fila
            if (!$fila || $fila === [null]) continue;//saltamos filas vacias 
            $datos[] = array_combine($columnas, $fila);//funcion guarda los datos como array estructurado con los datos de todas las filas
        }

        $paginador = new LengthAwarePaginator(  //Clase de laravel para paginar
            $datos, 
            $totalFilas, 
            $filasPorPagina, 
            $paginaActual, 
            [
                'path' => $request->url(),
                'query' => $request->query(), // Esto mantiene 'archivo' y 'nombreArchivo' automaticamente,permite que el paginador "recuerde" los parametros
            ]
        );

        //Gestionamos el numero de paginas que se van a ver en la barra de navegacion
        $totalMostrar=5;
        $paginasBarra = $this->calculoNavegacionPaginas($paginador, $totalMostrar);

        //Enviamos la informacion a la vista donde se muestra
        return view('visualizacionArchivo', [
            'columnas' => $columnas,
            'datos'=> $paginador,
            'archivo' => $archivo,
            'nombreArchivo'=> $nombreArchivo,
            'paginasBarra'=>$paginasBarra
        ]);
    }

    public function calculoNavegacionPaginas($paginador, $totalMostrar){
        
        $paginaActual = $paginador->currentPage();
        $totalPaginas = $paginador->lastPage();

        $inicio = max(1, $paginaActual - 2); 
        $fin = min($totalPaginas, $inicio + $totalMostrar - 1);

        if ($fin - $inicio + 1 < $totalMostrar) {
            $inicio = max(1, $fin - $totalMostrar + 1);
        }

        return $paginador->getUrlRange($inicio, $fin);
    }


    public function normalizarTexto($texto){
        $texto = trim($texto); //limpiamos espacios en blanco por delante y detras
        $texto = str_replace(['-', '_'], ' ', $texto); // cambio los guiones por espacios
        $texto = preg_replace('/[^A-Za-z0-9 ]/', '', $texto); // solo permite letras , numero y espacios
        $texto = ucwords(strtolower($texto)); //todo el texto en minuscula, menos la primera letra en mayusculas
        return $texto;
    }



    
}