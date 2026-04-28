<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use SplFileObject;
use Illuminate\Http\Request;

class CsvService {


    public function buscar($archivo, $textoBuscar=null, $filtroBuscar=null,$separador=null){

        $rutaAbsoluta = Storage::path($archivo);//convertimos en ruta abosoluta para SplFileObject
        if(!$separador){
            $separador = $this->detectarSeparador($rutaAbsoluta); //Detectamos el separador del archivo y si ya lo tenemos trabajamos con ese
        }
        $objetoLectura = new SplFileObject($rutaAbsoluta); 
        $objetoLectura->setFlags(SplFileObject::READ_CSV); 
        $objetoLectura->setCsvControl($separador); //explicamos que separador usa el archivo

        $columnas = $objetoLectura->fgetcsv();
            if (!$columnas){return null;} 

        $columnasNormalizadas = array_map([$this, 'normalizarTexto'], $columnas);//Limpiamos los encabezados de la tabla
        $datos = [];

        $busqueda = !empty($textoBuscar);
        $busquedaNormalizada = $busqueda ? strtolower($this->normalizarTexto($textoBuscar)) : '';

        $objetoLectura->seek(1);
        foreach ($objetoLectura as $indice => $fila) {
       
            if ($indice === 0) continue;//evitamos que salga la cabecera en las filas
            if (!$fila || $fila === [null] || count($fila) !== count($columnasNormalizadas)) continue;

        
            if ($busqueda) {
            
                $valor = isset($fila[$filtroBuscar]) ? strtolower($this->normalizarTexto($fila[$filtroBuscar])) : '';
                
                if (!str_contains($valor, $busquedaNormalizada)) {
                    continue; 
                }
            }
            
            $datos[] = array_combine($columnasNormalizadas, $fila);
        }
            
        return [
            'columnas' => $columnasNormalizadas,
            'filas' => $datos,
            'separador' => $separador
        ];
    }

    public function detectarSeparador($rutaAbsoluta){  //Verificamos que simbolo se repite mas veces en el encabezado de la tabla para saber cual es el separador del archivo
        $objetoLectura = new SplFileObject($rutaAbsoluta);
        $encabezado = $objetoLectura->fgets();

        $comas = substr_count($encabezado, ',');
        $puntoComas = substr_count($encabezado, ';');
        $separador=($puntoComas > $comas) ? ';' : ',';
        return $separador;
    }

    public function normalizarTexto($texto){
        $texto = trim($texto); //limpiamos espacios en blanco por delante y detras
        $texto = str_replace(['-', '_'], ' ', $texto); // cambio los guiones por espacios
        $texto = preg_replace('/[^A-Za-z0-9 ]/', '', $texto); // solo permite letras , numero y espacios
        $texto = ucwords(strtolower($texto)); //todo el texto en minuscula, menos la primera letra en mayusculas
        return $texto;
    }

}