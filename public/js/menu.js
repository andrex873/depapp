/**
 * Menu de navegacion principal.
 */
$(document).on('ready', function(){
    
    var gMenu = null;    
    $.ajax({
        async:false,
        url:'/menu/index',
        type:'post',
        dataType:'json',
        data:{},
        error:function(){
            alert('Error cargando el menú');
        },
        success:function(response){
            gMenu = response;
            var allMenu = setMenu(gMenu, 0);
            
            Ext.create('Ext.toolbar.Toolbar', {
                renderTo: document.getElementById('nav_menu'),                
                items: allMenu                
            });             
        }
    });
    
    
    
    function setMenu(grupoMenu, idpadre){
        var indexMenu = 0;
        var menu = new Array();
        var gPadre = grupoMenu[idpadre];
        for(var key in gPadre){
            var valor = gPadre[key];
            var obj = new Object();
            obj.text = valor['nombre'];             
            obj.ruta = valor['ruta']; 
            obj.icon = valor['icon'];
            if(obj.ruta != '#'){ 
                obj.handler = function(){                    
                    redireccionar(this.ruta);
                };
            }
            if(typeof(gMenu[valor['idMenu']]) != 'undefined'){
                if(gMenu[valor['idMenu']].length > 0 ){
                    obj.menu = setMenu(gMenu, valor['idMenu']);
                }
            }
            menu[indexMenu] = obj;
            indexMenu++;
        }
        return menu;
    }     
    
});


