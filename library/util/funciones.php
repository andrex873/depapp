<?php
/**
 *
 * @param type $numero
 * @return type 
 */
function fnFormatoNumero($numero) {
    return number_format($numero, 0, '', '.');    
}
/**
 *
 * @param type $numero
 * @return type 
 */
function fnFormatoMoneda($numero) {
    return "$ ".fnFormatoNumero($numero);
}
/**
 *
 * @param type $mes
 * @return string 
 */
function fnMesNombre($mes) {
    $key = (int)$mes;
    $meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');   
    return $meses[$key];

}
/**
 *
 * @param type $dia
 * @return string 
 */
function fnDiaNombre($dia){
    $key = (int)$dia;
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sábado');
    return $dias[$key];
}
/**
 *
 * @param type $object
 * @return type 
 */
function fnObject2array($object){
    if(!(is_array($object) || is_object($object))){
        $dato = $object; 
    } else { 
        foreach($object as $key => $valor1){ 
            $dato[$key] = fnObject2array($valor1); 
        }
    }
    return $dato;
}
/**
 * 
 * @param type $texto
 * @param type $key
 * @return type 
 */
function fnEncriptar($texto, $key){
    $result = '';
    for($index = 0; $index < strlen($texto); $index++) {
        $charT  = substr($texto, $index, 1);
        $charK  = substr($key, ($index % strlen($key))-1, 1);
        $charT  = chr(ord($charT)+ord($charK));
        $result.= $charT;
    }
    $result = str_replace('/', '_', str_replace('+', '-', base64_encode($result)));
    return $result;
}
/**
 * 
 * @param type $texto
 * @param type $key
 * @return type 
 */
function fnDesencriptar($texto, $key) {
    $result = '';
    $texto = base64_decode(str_replace('-', '+', str_replace('_', '/', $texto)));
    for($index = 0; $index < strlen($texto); $index++) {
        $charT  = substr($texto, $index, 1);
        $cahrK  = substr($key, ($index % strlen($key))-1, 1);
        $charT  = chr(ord($charT)-ord($cahrK));
        $result.= $charT;
    } 
    return $result;
}
function fnTiposIdentificacion() {
    return array(
        'CC' => 'CC',
        'TI' => 'TI',
        'CE' => 'CE'
        );
}
function fnEstados() {
    return array(
        'ACT' => 'Activo',
        'INA' => 'Inactivo',        
        );
}
function fnEstadosPersonas() {
    return array(
        'ACT' => 'Activo',
        'INA' => 'Inactivo',
        'RET' => 'Retirado'
        );
}
/**
 * Función que cambia el formato de una fecha MySql yyyy-mm-dd
 * al formato dd/mm/yyyy para visualización.
 * @param String $fecha Fecha en formato yyyy-mm-dd.
 * @return String Fecha en formato dd/mm/yyyy. 
 */
function fn2ddmmyyyy($fecha){
    $patron = '/[0-9]{4}\-[0-9]{2}\-[0-9]{2}/';
    if(preg_match($patron, $fecha)){
        list($y, $m, $d) = explode('-', $fecha);
        return $d.'/'.$m.'/'.$y;
    }
    return '';     
}
/**
 * Función que cambia una fecha en formato dd/mm/yyyy a yyyy-mm-dd
 * para poder ser almacenada en MySql.
 * @param String $fecha Fecha en formato dd/mm/yyyy.
 * @return String Fecha en formato yyyy-mm-dd. 
 */
function fn2yyyymmdd($fecha){
    $patron = '/[0-9]{2}\/[0-9]{2}\/[0-9]{4}/';
    if(preg_match($patron, $fecha)){
        list($d, $m, $y) = explode('/', $fecha);
        return $y.'-'.$m.'-'.$d;
    }
    return '';
}