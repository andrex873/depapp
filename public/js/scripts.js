/**
 *
 */
$(document).on('ready', onReadyCallback );
/**
 * 
 */
function onReadyCallback(){   
    $('#p_mensajes').on('click', desplegarMensajes); 
    
    var header_alto = $('header').height();
    var footer_alto = $('footer').height();            
    var menu_alto = 20;//$('#nav_menu').height();            
    var ventana_alto = $('body').height();
    var alto = (ventana_alto-header_alto-footer_alto-menu_alto);
    //alert(alto);
    $('#dv_contenido').css('minHeight', alto+'px');
    
    
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




