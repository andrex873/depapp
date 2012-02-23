<?php

/**
 * Función que convierte un Array en un Object de tipo stdClass().
 * @param array $array
 * @return stdClass 
 */
function arrayToObject(array $array) {
	$object = new stdClass();
	foreach($array as $key => $value) {
		if(is_array($value)) {
			$object->$key = array2object($value);
		} else {
			$object->$key = $value;
		}
	}
	return $object;
}

/**
 * 
 * @param type $object
 * @return array 
 */
function objectToArray($object) {
    $array = array();
    if(is_array($object)){
        return $object;
    }
    if(!is_object($object)){
        return $array; 
    } 
    foreach($object as $key => $valor){ 
        $array[$key] = object2array($valor); 
    }
    
    return $array;
}
?>
