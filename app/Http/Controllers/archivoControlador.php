<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class ArchivoControlador extends Controller{

    public function leer(Request $request){
        $request->validate(['buscar'=> 'required|mimes:csv,txt']);
        $archivo =$request->file('buscar');

        $datos = [];
        $columnas =[];

        if(($archivoAbierto=fopen($archivo->getPathname(),'r')) === false){
            return back()->withErrors('No se ha podido abrir el archivo');
        }
            
        $columnas = fgetcsv($archivoAbierto, 1000,';');// fgetcsv() permite leer las filas de un archivo csv. El primer parametro es en alcribo en modo lectura, luego el numero maximo sde caracteres y el simbolo que separa las columnas.
        if(empty($columnas)){
            return back()->withErrors('El archivo CVS esta vacio');
        };

       
        while(($filas =fgetcsv($archivoAbierto, 1000,';')) !== false){ 
            $datos[] = array_combine($columnas,$filas);
        }

        fclose($archivoAbierto);

        session([
            'leerDatos' => $datos,
            'leerColumnas'=> $columnas
        ]);

        return redirect()->route('archivo.paginacion');
    }


    public function paginacion(Request $request){
        $datos = session('leerDatos',[]);
        $columnas= session('leerColumnas',[]);

        if(!$datos){
                return redirect()->route('archivo.index')
                ->withErrors('No se ha podido abrir el archivo');
        };

        $pagina = request()->get('pagina', 1);
        $porPagina = 10;
        $datosPagina = array_slice($datos, ($pagina - 1) * $porPagina, $porPagina);

        return view('tabla', [
            'columnas' => $columnas,
            'datos' => $datosPagina,
            'total' => count($datos),
            'pagina' => $pagina,
            'porPagina' => $porPagina,
        ]);
    }

}