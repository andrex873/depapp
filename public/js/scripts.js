/**
 * Funcion que se ejecuta en el ready de la aplicacion.
 */
$(document).on('ready', onReadyCallback );

/**
 * Funcion que es llamada por el ready de la aplicacion. 
 */
function onReadyCallback(){   
    $('#p_mensajes').on('click', desplegarMensajes);         
}
/**
 * Funcion para redireccionar peticiones mediante documento.location.    
 */
function redireccionar(ruta){
    document.location = ruta;
}

/**
 * Función que permite desplegar los mensajes de la aplicación.
 */
function desplegarMensajes(){
    var actual  = $('#p_mensajes').attr('data-opc');
    var numero  = $('#p_mensajes').attr('data-num');
    if(actual == 'show'){
        $('#p_mensajes')       
            .text('Ver Mensajes (' + numero + ')')
            .attr('data-opc', 'hide');
        $('#dv_mensajes').hide('blind');                            
    }else{
        $('#p_mensajes')       
            .text('Ocultar Mensajes (' + numero + ')')
            .attr({'data-opc':'show'});
        $('#dv_mensajes').show('blind');                            
    }
}        

