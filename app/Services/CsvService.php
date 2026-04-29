<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use SplFileObject;
use Illuminate\Http\Request;

/**
 * Servicio CsvService
 * 
 * Proporciona funcionalidades para la manipulación de archivos CSV
 * @author Ana Maria De la Cruz
 * @package App\Services
 */
class CsvService {

    /**
     * Busca y procesa el contenido de un archivo CSV aplicando filtros opcionales.
     *
     * @param string      $archivo       Ruta relativa del archivo.
     * @param string|null $textoBuscar   Texto a buscar en los datos.
     * @param string|null $filtroBuscar  Encabezado de la columna donde buscar.
     * @param string|null $separador     Caracter separador (si es null, se detecta automaticamente). 
     * @return array|null Devuelve un array con 'columnas', 'filas' y 'separador', o null si el archivo esta vacio.
     */
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
        $busquedaNormalizada = $busqueda ? $this->normalizarTexto($textoBuscar) : '';

        $objetoLectura->seek(1);
        foreach ($objetoLectura as $indice => $fila) {
       
            if ($indice === 0) continue;//evitamos que salga la cabecera en las filas
            if (!$fila || $fila === [null] || count($fila) !== count($columnasNormalizadas)) continue;

        
            if ($busqueda) {
                $valor = isset($fila[$filtroBuscar]) ? $this->normalizarTexto($fila[$filtroBuscar]) : '';
                
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

    /**
     * Determina el separador de las columna (',' o ';') analizando la cabecera de la tabla.
     *
     * @param string $rutaAbsoluta Ruta completa hacia el archivo.
     * @return string Devuelve el caracter separador detectado.
     */
    public function detectarSeparador($rutaAbsoluta){  //Verificamos que simbolo se repite mas veces en el encabezado de la tabla para saber cual es el separador del archivo
        $objetoLectura = new SplFileObject($rutaAbsoluta);
        $encabezado = $objetoLectura->fgets();

        $comas = substr_count($encabezado, ',');
        $puntoComas = substr_count($encabezado, ';');
        $separador=($puntoComas > $comas) ? ';' : ',';
        return $separador;
    }

    /**
     * Limpia y formatea un texto para estandarizar su apariencia.
     *
     * @param string $texto El texto original a procesar.
     * @return string Devuelve el texto normalizado y formateado.
     */
    public function normalizarTexto($texto){
        $texto = mb_convert_encoding($texto, 'UTF-8', mb_detect_encoding($texto, 'UTF-8, ISO-8859-1, Windows-1252', true));//Aseguramos que el texto sea UTF-8
        $texto = trim($texto); //limpiamos espacios en blanco por delante y detras
        $texto = str_replace(['-', '_'], ' ', $texto); // cambio los guiones por espacios
        $texto = preg_replace('/[^A-Za-z0-9 áéíóúÁÉÍÓÚüÜñÑ]/u', '', $texto); // solo permite letras , numero y espacios
        $texto = ucwords(mb_strtolower($texto, 'UTF-8')); //todo el texto en minuscula, menos la primera letra en mayusculas
        return $texto;
    }

}
//la paginacion aqui