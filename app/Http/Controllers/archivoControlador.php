<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use SplFileObject;

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
        $archivoAlmacenado = $archivo->store('csv'); //Guardamos el archivo

        //Enviamos los datos a la vista de visualizacion del archivo y ejecutamos el método paginacion()
        return redirect()->route('archivo.paginacion',
         ['archivo' => $archivoAlmacenado,
          'pagina' => 1
         ]);
    }

    public function paginacion(Request $request){
        $archivo = $request->get('archivo'); //Recibimos el archivo

        //Si no llega el archivo guardado devuelve al inicio y con mensaje de error
        if (!Storage::exists($archivo)) {
            return redirect()->route('inicio')->withErrors('Archivo no encontrado');
        }

        $rutaAbsoluta = Storage::path($archivo);//convertimos en ruta real para SplFileObject

        $objetoLectura = new SplFileObject($rutaAbsoluta); //creamos el objeto de lectura
        $objetoLectura->setFlags(SplFileObject::READ_CSV); //Le decimos como debe leerlo, como csv. Porque esta clase lee mas tipos de archivos
        $objetoLectura->setCsvControl(';'); //explicamos en separador

        $pagina = max(1, (int) $request->get('pagina', 1));//VErificamos que pagina siempre sea 1 sino le llegan el resto
        $filasPorPagina = 10; //numero de filas que se van a amostrar por pagina

        $columnas = $objetoLectura->fgetcsv(); // lee las cabeceras de las columnas

        //Si encuentra la primera fila/encabezados retorna a la pagina de inicio con mensaje de error
        if (!$columnas) {
            return back()->withErrors('El archivo esta vacío.');
        }

        $columnas = array_map(function ($col) { //Limpiamos los encabezados de la tabla
            $col = trim($col); //limpiamos espacios en blanco por delante y detras
            $col = str_replace(['-', '_'], ' ', $col); // cambio los guiones por espacios
            $col = preg_replace('/[^A-Za-z0-9 ]/', '', $col); // solo permite letras , numero y espacios
            $col = ucwords(strtolower($col)); //todo el texto en minuscula, menos la primera letra en mayusculas

            return $col;
        }, $columnas); 

        //paginacion, solo se leen 10 paginas por linea
        $inicio = ($pagina - 1) * $filasPorPagina;
        $objetoLectura->seek($inicio + 1);

       
        $datos = []; //creamos el array donde vamos a almacenar la informacion del archivo
         //Recorremos el archivo de datos y vamos llenando cada fila en un array
        for ($i = 0; $i < $filasPorPagina && !$objetoLectura->eof(); $i++) { //eof() funcion de la clase que le indica cuando tiene que parar de leer
            $fila = $objetoLectura->fgetcsv();// fgetcsv() funcion que lee cada fila
            if (!$fila || $fila === [null]) continue;//saltamos filas vacias 
            $datos[] = array_combine($columnas, $fila);//funcion guarda los datos como array estructurado con los datos de todas las filas
        }

        //Enviamos la informacion a la vista donde se muestra
        return view('visualizacionArchivo', [
            'columnas' => $columnas,
            'datos' => $datos,
            'pagina' => $pagina,
            'filasPorPagina' => $filasPorPagina,
            'archivo' => $archivo
        ]);
    }
}