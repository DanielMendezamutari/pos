/*############ FUNCION AGREGA POR LECTOR ############*/
$('#search_producto_barra').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
    if (keycode == 13) {
        AgregaVentas();
        e.preventDefault();
        return false;
    }
});
/*############ FUNCION AGREGA POR LECTOR ############*/

$(document).ready(function(){
    
$("#search_producto_barra").change(function(){
    let codSucursal = $("#codsucursal").val();
    let codeBar = $(this).val();
    var url = 'funciones.php?MuestraDatosProductos=si';
    $.ajax({    
        url: url,
        data:{sucursal:codSucursal,barcode:codeBar},      
        type : 'GET',   
        success : function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
            console.log(response);
            //$('#idproducto').val(json[0].idproducto);
            //$('#codproducto').val(json[0].codproducto);
            $("#search_producto_barra").focus();
            //asigno tiempo de agregar detalle
            setTimeout(function() {
            var e = jQuery.Event("keypress");
            e.which = 13;
            e.keyCode = 13;
            AgregaVentas();
            }, 100);
        },
        error : function(error) {
            console.log(error);
            swal("Oops", "HA Ocurrido un Error en el procesamiento de informacion!", "error");
            //alert('Disculpe, Ha Ocurrido un Error en el procesamiento de informacion');
        }
    });
});


function AgregaVentas () 
{
    let codSucursal = $("#codsucursal").val();
    let codeBar = $(this).val();
    var url = 'funciones.php?MuestraDatosProductos=si';
    $.ajax({    
        url: url,
        data:{sucursal:codSucursal,barcode:codeBar},      
        type : 'GET',   
        success : function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
            console.log(response);
            //$('#idproducto').val(json[0].idproducto);
            //$('#codproducto').val(json[0].codproducto);
            $("#search_producto_barra").focus();
            //asigno tiempo de agregar detalle
            setTimeout(function() {
            var e = jQuery.Event("keypress");
            e.which = 13;
            e.keyCode = 13;
            $('#muestra_detalles').load("funciones.php?MuestraDatosProductos=si&sucursal="+codSucursal+"&barcode="+codeBar);
            }, 100);
        },
        error : function(error) {
            console.log(error);
            swal("Oops", "HA Ocurrido un Error en el procesamiento de informacion!", "error");
            //alert('Disculpe, Ha Ocurrido un Error en el procesamiento de informacion');
        }
    });
} 


});