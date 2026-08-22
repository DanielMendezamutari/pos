// FUNCION AUTOCOMPLETE 
$(function() {
       $("#marcas").autocomplete({
       source: "class/busqueda_autocompleto.php?Busqueda_Marcas=si",
       minLength: 1,
       select: function(event, ui) { 
       $('#codmarca').val(ui.item.codmarca);
       }  
    });
 });

$(function() {
       $("#modelos").autocomplete({
       source: "class/busqueda_autocompleto.php?Busqueda_Modelos=si",
       minLength: 1,
       select: function(event, ui) { 
       $('#codmodelo').val(ui.item.codmodelo);
       $("#cantidad").focus();
       }  
    });
 });


$(function() {
        $("#busqueda").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Clientes=si",
        minLength: 1,
        select: function(event, ui) { 
        $('#codcliente').val(ui.item.codcliente);
        $('#nrodocumento').val(ui.item.dnicliente);
        $('#cliente').val(ui.item.codcliente);
        $('#creditoinicial').val(ui.item.limitecredito);
        $('#montocredito').val(ui.item.creditodisponible);
        $('#creditodisponible').val(ui.item.creditodisponible);
        $('#TextCliente').text((ui.item.tipocliente == "JURIDICO") ? ui.item.razoncliente : ui.item.nomcliente);
        $('#TextCredito').text(ui.item.creditodisponible);
         }  
    });
});

/* FUNCION AUTOCOMPLETE DE BUSQUEDA DE CLIENTE POR SUCURSAL*/
$(function() {
    $("#search_cliente_sucursal").autocomplete({
        minLength: 1,
        source: "class/busqueda_autocompleto.php?Busqueda_Clientes_Sucursal=si",
        //source: '@Url.Action("FillSelectedSeriesName")',
        data: { series_id: $("#codsucursal option:selected").text() },
        //data: { series_id: $("#SeriesName option:selected").text(), series_name: document.getElementById("SeriesName").value },
        source: function (request, response) {
            var term = request.term;
            var term2 = document.getElementById("codsucursal").value;
            //var series_name = $("#SeriesName option:selected").text();
            if(term2 == ""){
               swal("Oops", "POR FAVOR DEBE SELECCIONAR UNA SUCURSAL!", "warning");
                return false;
            }
            $.getJSON("class/busqueda_autocompleto.php?Busqueda_Clientes_Sucursal=si?term=" + term + '&term2=' + term2, request, function (data, status, xhr) {
                response(data);
            });
        },
        select: function (event, ui) {
            $('#codcliente').val(ui.item.codcliente);
            $('#nrodocumento').val(ui.item.dnicliente);
        },
        change: function (event, ui) {
        }
    });
});


/* FUNCION AUTOCOMPLETE DE BUSQUEDA DE PRODUCTO POR SUCURSAL*/
$(function() {
    $("#search_producto_sucursal").autocomplete({
        minLength: 1,
        source: "class/busqueda_autocompleto.php?Busqueda_Productos_Sucursal=si",
        data: { series_id: $("#codsucursal option:selected").text() },
        source: function (request, response) {
            var term = request.term;
            var term2 = document.getElementById("codsucursal").value;
            if(term2 == ""){
               swal("Oops", "POR FAVOR DEBE SELECCIONAR UNA SUCURSAL!", "warning");
                return false;
            }
            $.getJSON("class/busqueda_autocompleto.php?Busqueda_Productos_Sucursal=si?term=" + term + '&term2=' + term2, request, function (data, status, xhr) {
                response(data);
            });
        },
        select: function (event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
            $('#imei').val((ui.item.imei == "") ? "0" : ui.item.imei);
            $('#condicion').val(ui.item.condicion);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
            $('#codcolor').val(ui.item.codcolor);
            $('#color').val((ui.item.codcolor == "0") ? "*****" : ui.item.nomcolor);
            $('#preciocompradet').val(ui.item.preciocompra);
            $('#precioventadet').val(ui.item.precioxpublico);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioxpublico : "0.00");
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#tipo').val("2");
            $("#cantidad").focus();
        },
        change: function (event, ui) {
        }
    });
});


/* FUNCION AUTOCOMPLETE DE BUSQUEDA DE COMBOS POR SUCURSAL*/
$(function() {
    $("#search_combo_sucursal").autocomplete({
        minLength: 1,
        source: "class/busqueda_autocompleto.php?Busqueda_Combos_Sucursal=si",
        data: { series_id: $("#codsucursal option:selected").text() },
        source: function (request, response) {
            var term = request.term;
            var term2 = document.getElementById("codsucursal").value;
            if(term2 == ""){
               swal("Oops", "POR FAVOR DEBE SELECCIONAR UNA SUCURSAL!", "warning");
                return false;
            }
            $.getJSON("class/busqueda_autocompleto.php?Busqueda_Combos_Sucursal=si?term=" + term + '&term2=' + term2, request, function (data, status, xhr) {
                response(data);
            });
        },
        select: function (event, ui) {
            $('#idcombo').val(ui.item.idcombo);
            $('#codcombo').val(ui.item.codcombo);
        },
        change: function (event, ui) {
        }
    });
});




$(function() {
    $("#search_compra").autocomplete({
        minLength: 1,
        source: function (request, response) {
            var term = request.term;
            var term2 = $("#codsucursal").length ? $("#codsucursal").val() : "";
            $.getJSON("class/busqueda_autocompleto.php?Busqueda_Producto_Compra=si&term=" + encodeURIComponent(term) + "&term2=" + encodeURIComponent(term2), function (data) {
                response(data);
            });
        },
        select: function(event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
            $('#imei').val((ui.item.imei == "") ? "0" : ui.item.imei);
            $('#condicion').val(ui.item.condicion);
            $('#fabricante').val(ui.item.fabricante);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
            $('#codcolor').val(ui.item.codcolor);
            $('#color').val((ui.item.codcolor == "0") ? "*****" : ui.item.nomcolor);
            $('#codorigen').val(ui.item.codorigen);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioxmenor').val(ui.item.precioxmenor);
            $('#precioxmayor').val(ui.item.precioxmayor);
            $('#precioxpublico').val(ui.item.precioxpublico);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.preciocompra : "0.00");
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $("#cantidad").focus();
        }
    });
});



$(function() {
  $("#search_traspaso").autocomplete({
    source: "class/busqueda_autocompleto.php?Busqueda_Producto_Compra=si",
    minLength: 1,
    select: function(event, ui) {
        $('#idproducto').val(ui.item.idproducto);
        $('#codproducto').val(ui.item.codproducto);
        $('#producto').val(ui.item.producto);
        $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
        $('#imei').val((ui.item.imei == "") ? "0" : ui.item.imei);
        $('#condicion').val(ui.item.condicion);
        $('#fabricante').val(ui.item.fabricante);
        $('#codfamilia').val(ui.item.codfamilia);
        $('#codsubfamilia').val(ui.item.codsubfamilia);
        $('#codmarca').val(ui.item.codmarca);
        $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
        $('#codmodelo').val(ui.item.codmodelo);
        $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
        $('#codpresentacion').val(ui.item.codpresentacion);
        $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
        $('#codcolor').val(ui.item.codcolor);
        $('#color').val((ui.item.codcolor == "0") ? "*****" : ui.item.nomcolor);
        $('#codorigen').val(ui.item.codorigen);
        $('#preciocompra').val(ui.item.preciocompra);
        $('#precioxmenor').val(ui.item.precioxmenor);
        $('#precioxmayor').val(ui.item.precioxmayor);
        $('#precioxpublico').val(ui.item.precioxpublico);
        //$('#precioventa').val(ui.item.precioxpublico);
        $('#existencia').val(ui.item.existencia);
        $('#ivaproducto').val(ui.item.ivaproducto);
        $('#descproducto').val(ui.item.descproducto);
        $('#fechaexpiracion').val(ui.item.fechaexpiracion);
        $("#cantidad").focus();
        $('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+ui.item.idproducto);
        }
    });
});


/*BUSQUEDA DE PRODUCTO EN POS*/
$(function() {
    $("#search_producto").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Productos=si",
        minLength: 1,
        select: function(event, ui) {
            var tipoproducto = (typeof ui.item.tipoproducto !== "undefined") ? ui.item.tipoproducto : "PRODUCTO";
            if (tipoproducto != "SERVICIO" && parseInt(ui.item.existencia) <= 0) {
                swal("SIN STOCK", "El producto '" + ui.item.producto + "' no tiene stock disponible. No puede ser vendido!", "warning");
                $("#search_producto").val('');
                return false;
            }
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
            $('#imei').val((ui.item.imei == "") ? "0" : ui.item.imei);
            $('#condicion').val(ui.item.condicion);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
            $('#codcolor').val(ui.item.codcolor);
            $('#color').val((ui.item.codcolor == "0") ? "*****" : ui.item.nomcolor);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioventa').val(ui.item.precioxpublico);
            $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioxpublico : "0.00");
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#existencia').val(ui.item.existencia);
            $('#tipoproducto').val((typeof ui.item.tipoproducto !== "undefined") ? ui.item.tipoproducto : "PRODUCTO");
            $('#preciohora').val((typeof ui.item.preciohora !== "undefined") ? ui.item.preciohora : "0.00");
            $("#search_busqueda_pos").focus();
            setTimeout(function() {
                var e = jQuery.Event("keypress");
                e.which = 13;
                e.keyCode = 13;
                $("#search_producto").trigger(e);
            }, 100);
        }
    });
});

$(function() {
    $("#search_venta").autocomplete({
        source: "class/busqueda_autocompleto.php?Busqueda_Productos=si",
        minLength: 1,
        select: function(event, ui) {
            $('#idproducto').val(ui.item.idproducto);
            $('#codproducto').val(ui.item.codproducto);
            $('#producto').val(ui.item.producto);
            $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
            $('#imei').val((ui.item.imei == "") ? "0" : ui.item.imei);
            $('#condicion').val(ui.item.condicion);
            $('#fabricante').val(ui.item.fabricante);
            $('#codfamilia').val(ui.item.codfamilia);
            $('#codsubfamilia').val(ui.item.codsubfamilia);
            $('#codmarca').val(ui.item.codmarca);
            $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
            $('#codmodelo').val(ui.item.codmodelo);
            $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
            $('#codpresentacion').val(ui.item.codpresentacion);
            $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
            $('#codcolor').val(ui.item.codcolor);
            $('#color').val((ui.item.codcolor == "0") ? "*****" : ui.item.nomcolor);
            $('#codorigen').val(ui.item.codorigen);
            $('#preciocompra').val(ui.item.preciocompra);
            $('#precioxmenor').val(ui.item.precioxmenor);
            $('#precioxmayor').val(ui.item.precioxmayor);
            $('#precioxpublico').val(ui.item.precioxpublico);
            //$('#precioventa').val(ui.item.precioxpublico);
            $('#existencia').val(ui.item.existencia);
            $('#ivaproducto').val(ui.item.ivaproducto);
            $('#descproducto').val(ui.item.descproducto);
            $('#fechaexpiracion').val(ui.item.fechaexpiracion);
            $("#cantidad").focus();
            $('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+ui.item.idproducto);
        }
    });
});


/*BUSQUEDA DE PRODUCTO/COMBOS/SERVICIOS CON TIPO DETALLE*/
$(function() {

    $("#search_busqueda").keyup(function() {

        var tipo = $('input:radio[name=tipodetalle]:checked').val(); 

        if (tipo == 1) {

            $("#search_busqueda").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Productos=si",
            minLength: 1,
            select: function(event, ui) {
                $('#idproducto').val(ui.item.idproducto);
                $('#codproducto').val(ui.item.codproducto);
                $('#producto').val(ui.item.producto);
                $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
                $('#imei').val((ui.item.imei == "") ? "0" : ui.item.imei);
                $('#condicion').val(ui.item.condicion);
                $('#codmarca').val(ui.item.codmarca);
                $('#marcas').val((ui.item.codmarca == "0") ? "*****" : ui.item.nommarca);
                $('#codmodelo').val(ui.item.codmodelo);
                $('#modelos').val((ui.item.codmodelo == "0") ? "*****" : ui.item.nommodelo);
                $('#codpresentacion').val(ui.item.codpresentacion);
                $('#presentacion').val((ui.item.codpresentacion == "0") ? "*****" : ui.item.nompresentacion);
                $('#codcolor').val(ui.item.codcolor);
                $('#color').val((ui.item.codcolor == "0") ? "*****" : ui.item.nomcolor);
                $('#preciocompra').val(ui.item.preciocompra);
                //$('#precioventa').val(ui.item.precioxpublico);
                $('#precioconiva').val((ui.item.ivaproducto == "SI") ? ui.item.precioxpublico : "0.00");
                $('#ivaproducto').val(ui.item.ivaproducto);
                $('#descproducto').val(ui.item.descproducto);
                $('#existencia').val(ui.item.existencia);
                $("#cantidad").focus();
                $('#precioventa').load("funciones.php?BuscaPreciosProductos=si&idproducto="+ui.item.idproducto);
                }
            });

            return false;

        } else if (tipo == 2) {

            $("#search_busqueda").autocomplete({
            source: "class/busqueda_autocompleto.php?Busqueda_Combos=si",
            minLength: 1,
            select: function(event, ui) {
              $('#idproducto').val(ui.item.idcombo);
              $('#codproducto').val(ui.item.codcombo);
              $('#producto').val(ui.item.nomcombo);
              $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
              $('#imei').val((ui.item.imei == "") ? "0" : ui.item.imei);
              $('#descripcion').val((ui.item.descripcion == "") ? "0" : ui.item.descripcion);
              $('#condicion').val("0");
              $('#codmarca').val("0");
              $('#marcas').val("0");
              $('#codmodelo').val("0");
              $('#modelos').val("0");
              $('#codpresentacion').val("0");
              $('#presentacion').val("0");
              $('#codcolor').val("0");
              $('#color').val("0");
              $('#preciocompra').val(ui.item.preciocompra);
              $('#precioventa').val(ui.item.precioventa);
              $('#precioconiva').val((ui.item.ivacombo == "SI") ? ui.item.precioventa : "0.00");
              $('#ivaproducto').val(ui.item.ivacombo);
              $('#descproducto').val(ui.item.desccombo);
              $('#existencia').val(ui.item.existencia);
              $("#cantidad").focus();
            }
          });

          return false;

        } else if (tipo == 3) {

            $("#search_busqueda").autocomplete({
            source: "",
            minLength: 1,
            select: function(event, ui) {
               
                }
            });

          return false;

        } else {

            $("#search_busqueda").val("");
            swal("Oops", "POR FAVOR SELECCIONE EL TIPO DE BUSQUEDA!", "error");
            return false;
        }
    });
}); 




/* FUNCION AUTOCOMPLETE DE BUSQUEDA DE COMBOS POR SUCURSAL*/
$(function() {
    $("#numfactura").autocomplete({
        minLength: 1,
        source: "class/busqueda_autocompleto.php?Busqueda_Facturas=si",
        data: { series_id: $("#codsucursal option:selected").text() },
        source: function (request, response) {
            var term = request.term;
            var term2 = document.getElementById("codsucursal").value;
            if(term2 == ""){
               swal("Oops", "POR FAVOR DEBE SELECCIONAR UNA SUCURSAL!", "warning");
                return false;
            }
            $.getJSON("class/busqueda_autocompleto.php?Busqueda_Facturas=si?term=" + term + '&term2=' + term2, request, function (data, status, xhr) {
                response(data);
            });
        },
        select: function (event, ui) {
            $('#idventa').val(ui.item.idventa);
            $('#codventa').val(ui.item.codventa);
            $('#codfactura').val(ui.item.codfactura);
        },
        change: function (event, ui) {
        }
    });
});