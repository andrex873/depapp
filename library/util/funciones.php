<?php
/**
 *
 * @param type $numero
 * @return type 
 */
function appFormatoNumero($numero) {
    return number_format($numero, 0, '', '.');    
}
/**
 *
 * @param type $numero
 * @return type 
 */
function appFormatoMoneda($numero) {
    return "$ ".appFormatoNumero($numero);
}
/**
 *
 * @param type $mes
 * @return string 
 */
function appMesNombre($mes) {
    $key = (int)$mes;
    $meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");   
    return $meses[$key];

}
/**
 *
 * @param type $dia
 * @return string 
 */
function appDiaNombre($dia){
    $key = (int)$dia;
    $dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sábado");
    return $dias[$key];
}

?>
