/**
 * Funcion que se ejecuta en el ready de la aplicacion.
 */
$(document).on('ready', onReadyCallback );

/**
 * Funcion que es llamada por el ready de la aplicacion. 
 */
function onReadyCallback(){   
    // Desplegar los mensajes de la aplicación
    $('#p_mensajes').on('click', desplegarMensajes);
    
    // Agrega un datepicker a los inpus en la aplicación
    $('input[data-type="dateCalendar"]').datepicker({
        monthNames:['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'], 
        dayNamesMin:['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'], 
        dayNames:['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'], 
        weekHeader:'W',
        showWeek:true,
        dateFormat: 'dd/mm/yy'
    });
    
    // Agregar mensaje de confirmación a la eliminacion de registros
    $('a[data-confirm]').on('click', function(){
        var texto = $(this).attr('data-confirm');
        return confirm(texto);
    });
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
            .attr('data-opc', 'hide')
            .children("span#p_mensajes_text").text('Ver Mensajes').end()
            .children("span#p_mensajes_num").text(numero);
        $('#dv_mensajes').hide('blind');                            
    }else{
        $('#p_mensajes')       
            .attr({'data-opc':'show'})
            .children("span#p_mensajes_text").text('Ocultar Mensajes').end()
            .children("span#p_mensajes_num").text(numero);            
        $('#dv_mensajes').show('blind');                            
    }
}        

