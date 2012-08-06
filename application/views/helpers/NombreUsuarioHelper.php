<?php

class Zend_View_Helper_NombreUsuarioHelper extends Zend_View_Helper_Abstract
{            
    /**
     * Helper que permite obtener el nombre del usuario logueado según el formato especificado.
     * 
     * @param String $formato Contiene el valor del formato que se desea obtener. los formatos disponibles son:
     * <pre>
     * NOMBRE_HEADER
     * NOMBRE_TOTAL
     * </pre>
     * @return String|SIN_FORMATO Retorna el nombre del usuario con el formato deseado. o el texto SIN_FORMATO cuando no existe el formato solicitado.
     */
    function nombreUsuarioHelper($formato) {
        
        $sesion = new Zend_Session_Namespace(NS_SESSION); 
        $usuario = $sesion->usuario;
        $persona = $sesion->persona; 
        $nombreTotal = trim($persona->primerNombre." ".$persona->segundoNombre." ".$persona->primerApellido." ".$persona->segundoApellido);
        switch ($formato) {
            case 'NOMBRE_HEADER':                
                $str = "".$nombreTotal." (".$usuario->nombreUsuario.")"; 
            break;
            case 'NOMBRE_TOTAL':
                $str = $nombreTotal;
                break;
            default:
                //$str = "<!-- SIN_FORMATO -->"; 
                $str = "SIN_FORMATO"; 
                break;
        }                
        return $str;                
    }
}

?>
