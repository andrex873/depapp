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
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");   
    return $meses[$key];

}
/**
 *
 * @param type $dia
 * @return string 
 */
function fnDiaNombre($dia){
    $key = (int)$dia;
    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
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