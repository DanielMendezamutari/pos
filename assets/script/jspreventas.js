function Separador(x) {//SEPARADOR CON DECIMAL
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function DoAction(idproducto, codproducto, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle) {
    
    addItem(idproducto, codproducto, 1, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle, '+=');
}

// ####################### FUNCION PARA ASIGNAR PRECIO VENTA A DETALLES #######################
function DoActionPrecio(idproducto, codproducto, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle) 
{
    addItem(idproducto, codproducto, 0.00, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle, '+=');
}

function AsignaPrecio(id, codigo, tipodetalle, producto, cantidad, precio2,descproducto)
{
  $("#agregaprecio #d_id").val(id);
  $("#agregaprecio #d_codigo").val(codigo);
  $("#agregaprecio #agrega_detalle_precio").load("detalles_productos?BuscaDetallesProductoxPrecio=si&variable=3&d_id="+id+"&d_codigo="+codigo+"&d_tipo="+tipodetalle+"&d_producto="+producto+"&d_cantidad="+cantidad+"&d_precio="+precio2+"&d_descproducto="+descproducto);
}
// ####################### FUNCION PARA ASIGNAR PRECIO VENTA A DETALLES #######################

function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/
    $('#savepreventas').keypress(function(e){
        var keycode = (e.keyCode ? e.keyCode : e.which);   
        if (keycode == 13) {
            return false;
        }
    });
    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/

    /*############ FUNCION AGREGA POR BOTON ############*/
    $('#AgregaProducto').click(function() {
        AgregaProductos();
    });
    /*############ FUNCION AGREGA POR BOTON ############*/

    /*############ FUNCION AGREGA POR CRITERIO ############*/
    $('#cantidad').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
          AgregaProductos();
          e.preventDefault();
          return false;
        }
    });
    /*############ FUNCION AGREGA POR CRITERIO ############*/

    function AgregaProductos () {

        var code = $('input#codproducto').val();
        var prod = $('input#producto').val();
        var cantp = $('input#cantidad').val();
        var exist = $('input#existencia').val();
        var prec = $('input#preciocompra').val();
        var prec2 = ($('input:radio[name=tipodetalle]:checked').val() == 1 ? $('select#precioventa').val() : $('input#precioventa').val());
        var descuen = $('input#descproducto').val();
        var ivgprod = $('input#ivaproducto').val();
        var tipodetalle = $('input:radio[name=tipodetalle]:checked').val();
        var er_num = /^([0-9])*[.]?[0-9]*$/;
        cantp = parseInt(cantp);
        exist = parseInt(exist);
        cantp = cantp;

        if (code == "" && tipodetalle == 1) {
            $("#search_busqueda").focus();
            $("#search_busqueda").css('border-color', '#ff7676');
            swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE!", "error");
            return false;
            
        } else if (tipodetalle == 3 && busqueda == "") {
            $("#search_busqueda").focus();
            $("#search_busqueda").css('border-color', '#ff7676');
            swal("Oops", "POR FAVOR INGRESE DESCRIPCION DE SERVICIO CORRECTAMENTE!", "error");
            return false;
            
        } else if(prec2=="" || prec2=="0" || prec2=="0"){
            $("#precioventa").focus();
            $('#precioventa').css('border-color','#ff7676');
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR SELECCIONE PRECIO DE VENTA!", "error");  
            return false;
            
        } else if(!er_num.test($('#precioventa').val())){
            $("#precioventa").focus();
            $('#precioventa').css('border-color','#ff7676');
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR INGRESE SOLO NUMEROS POSITIVOS EN PRECIO VENTA!", "error");  
            return false;
        
        } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN PREVENTAS!", "error");
            return false;

        } else if (isNaN($('#cantidad').val())) {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE PREVENTAS!", "error");
            return false;
            
       } else if(cantp > exist && tipodetalle != 3){
            $("#cantidad").focus();
            $('#cantidad').css('border-color','#ff7676');
            swal("Oops", "LA CANTIDAD DE PRODUCTOS O COMBOS SOLICITADO NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
            return false;

        } else {

            var Carrito = new Object();
            Carrito.Id = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#idproducto').val());
            Carrito.Codigo = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#codproducto').val());
            Carrito.Producto = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? $('input#search_busqueda').val().replace(/[ '"]+/g, ' ') : $('input#producto').val().replace(/[ '"]+/g, ' '));
            Carrito.Descripcion = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#descripcion').val().replace(/[ '"]+/g, ' '));
            Carrito.Imei = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#imei').val());
            Carrito.Condicion = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#condicion').val());
            Carrito.Codmarca = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#codmarca').val());
            Carrito.Marcas = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#marcas').val());
            Carrito.Codmodelo = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#codmodelo').val());
            Carrito.Modelos = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#modelos').val());
            Carrito.Codpresentacion = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#codpresentacion').val());
            Carrito.Presentacion = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#presentacion').val());
            Carrito.Codcolor = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#codcolor').val());
            Carrito.Color = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0" : $('input#codcolor').val());
            Carrito.Precio = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0.00" : $('input#preciocompra').val());
            Carrito.Precio2 = ($('input:radio[name=tipodetalle]:checked').val() == 1 ? $('select#precioventa').val() : $('input#precioventa').val());
            Carrito.Descproducto      = $('input#descproducto').val();
            Carrito.Existencia = ($('input:radio[name=tipodetalle]:checked').val() == 3 ? "0.00" : $('input#existencia').val());
            if($('input:radio[name=tipodetalle]:checked').val() == 1){
            Carrito.Ivaproducto = ($('input#ivaproducto').val() == "SI" ? $('input#iva').val() : "(E)");    
            Carrito.Precioconiva = ($('input#ivaproducto').val() == "SI" ? $('select#precioventa').val() : "0.00");
            } else if($('input:radio[name=tipodetalle]:checked').val() == 2){
            Carrito.Ivaproducto = ($('input#ivaproducto').val() == "SI" ? $('input#iva').val() : "(E)");    
            Carrito.Precioconiva = ($('input#ivaproducto').val() == "SI" ? $('input#precioventa').val() : "0.00"); 
            } else { 
            Carrito.Ivaproducto = "(E)";    
            Carrito.Precioconiva = "0.00";  
            }
            Carrito.TipoDetalle      = $('input:radio[name=tipodetalle]:checked').val();
            Carrito.Cantidad = $('input#cantidad').val();
            Carrito.opCantidad = '+=';
            var DatosJson = JSON.stringify(Carrito);
            $.post('carritopreventa.php', {
                    MiCarrito: DatosJson
                },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var contador = 0;
                var TotalDescuento = 0;
                var SubtotalFact = 0;
                var BaseImpIva = 0;
                var BaseImpIva2 = 0;
                var Descontado = 0;
                var TotalIvaGeneral = 0;
                var TotalCompra = 0;

                $.each(data, function(i, item) {
                    var cantsincero = item.cantidad;
                    cantsincero = parseInt(cantsincero);
                    if (cantsincero != 0) {
                        contador = contador + 1;

            var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
            TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

            //CALCULO DEL VALOR TOTAL
            var PrecioVenta = parseFloat(item.precio2);
            var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

            //CALCULO DEL TOTAL DEL DESCUENTO %
            var Descuento = ValorTotal * item.descproducto / 100;
            TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

            //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
            var descsiniva = item.precio2 * item.descproducto / 100;
            var descconiva = item.precioconiva * item.descproducto / 100;

            //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
            var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
            var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
            var Subtotal = Operacion.toFixed(2);

            //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
            var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
            var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
            var Subbaseimponiva = Operacion3.toFixed(2);

            //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
            var ivg = $('input#iva').val();
            ivg2  = ivg;

            //CALCULO VALOR DISCRIMINADO
            var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
            var Discriminado = parseFloat(item.precioconiva) / ValorImpuesto;
            var SubtotalDiscriminado = parseFloat(item.precioconiva) - parseFloat(Discriminado.toFixed(2));
            var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(item.cantidad);
            TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));

            //BASE IMPONIBLE IVA CON PORCENTAJE
            BaseImpIva = parseFloat(BaseImpIva) + parseFloat(Subbaseimponiva);
            BaseImpIva1 = parseFloat(BaseImpIva) - parseFloat(TotalIvaGeneral);
            
            //BASE IMPONIBLE IVA SIN PORCENTAJE
            BaseImpIva2 = (item.ivaproducto != "(E)") ? BaseImpIva2 : parseFloat(BaseImpIva2) + parseFloat(Subtotal);
            
            //CALCULAMOS DESCUENTO POR PRODUCTO
            var desc = $('input#descuento').val();
            desc2  = desc/100;
        
            //CALCULO DEL TOTAL DE FACTURA
            SubTotalTxt = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
            Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
            TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
            TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

            if(item.tipodetalle == 1){
                var Detalle = "PRODUCTO";
            } else if(item.tipodetalle == 2){
                var Detalle = "COMBO";
            } else if(item.tipodetalle == 3){
                var Detalle = "SERVICIO";
            }


            var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                    "<td>" +
                    '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'-1'," +
                    "'" + item.producto + "'," +
                    "'" + item.descripcion + "'," +
                    "'" + item.imei + "'," +
                    "'" + item.condicion + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codcolor + "'," +
                    "'" + item.color + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'-'" +
                    ')"' +
                    " type='button'><span class='fa fa-minus'></span></button>" +
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:50px;height:34px;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'+1'," +
                    "'" + item.producto + "'," +
                    "'" + item.descripcion + "'," +
                    "'" + item.imei + "'," +
                    "'" + item.condicion + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codcolor + "'," +
                    "'" + item.color + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'+'" +
                    ')"' +
                    " type='button'><span class='fa fa-plus'></span></button></td>" +
                    "<td class='text-danger alert-link'>" + Detalle + "</td>" +
                    "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.codmarca == '0' ? '******' : item.marcas) + ") - MODELO (" + (item.codmodelo == '0' ? '******' : item.modelos) + ")</small></td>" +
                    "<td><strong>" + Separador(PrecioVenta.toFixed(2)) + "</strong></td>" +
                    "<td><strong>" + Separador(ValorTotal.toFixed(2)) + "</strong></td>" +
                    "<td><strong>" + Separador(Descuento.toFixed(2)) + "<sup>" + Separador(item.descproducto) + "%</sup></strong></td>" +
                    "<td><strong>" + item.ivaproducto + "</strong></td>" +
                    "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                    "<td>" +
                    '<button class="btn btn-rounded btn-info" style="cursor:pointer;color:#fff;" ' +
                    'onclick="AsignaPrecio(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'" + item.tipodetalle + "'," +
                    "'" + item.producto.replace(/\s/g,"_") + "'," +
                    "'" + item.cantidad + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "'" +
                    ')"' +
                    ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPrecio" data-backdrop="static" data-keyboard="false" type="button"><span class="fa fa-pencil"></span></button> ' +
                        
                    '<button class="btn btn-rounded btn-dark" style="cursor:pointer;color:#fff;" ' +
                    'onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'0'," +
                    "'" + item.producto + "'," +
                    "'" + item.descripcion + "'," +
                    "'" + item.imei + "'," +
                    "'" + item.condicion + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codcolor + "'," +
                    "'" + item.color + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'='" +
                    ')"' +
                    ' type="button"><span class="fa fa-trash-o"></span></button>' +
                    "</td>" +
                    "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");
                                
                    $("#lblsubtotal").text(Separador(BaseImpIva1.toFixed(2)));
                    $("#lblsubtotal2").text(Separador(BaseImpIva2.toFixed(2)));
                    $("#lbliva").text(Separador(TotalIvaGeneral.toFixed(2)));
                    $("#lbldescontado").text(Separador(TotalDescuento.toFixed(2)));
                    $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
                    $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));
                    
                    $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                    $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                    $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                    $("#txtTotalCompra").val(TotalCompra.toFixed(2));

                    }
                });

                $("#search_busqueda").focus();
                LimpiarTexto();
            },
            "json"
        );
        return false;
    }
    }

/* CANCELAR LOS ITEM AGREGADOS EN REGISTRO */
$("#vaciar").click(function() {
        var Carrito = new Object();
        Carrito.Id = "vaciar";
        Carrito.Codigo = "vaciar";
        Carrito.Producto = "vaciar";
        Carrito.Descripcion = "vaciar";
        Carrito.Imei = "vaciar";
        Carrito.Condicion = "vaciar";
        Carrito.Codmarca = "vaciar";
        Carrito.Marcas = "vaciar";
        Carrito.Codmodelo = "vaciar";
        Carrito.Modelos = "vaciar";
        Carrito.Codpresentacion = "vaciar";
        Carrito.Presentacion = "vaciar";
        Carrito.Codcolor = "vaciar";
        Carrito.Color = "vaciar";
        Carrito.Precio      = "0";
        Carrito.Precio2      = "0";
        Carrito.Descproducto      = "0";
        Carrito.Ivaproducto = "vaciar";
        Carrito.Existencia = "vaciar";
        Carrito.Precioconiva      = "0";
        Carrito.TipoDetalle      = "vaciar";
        Carrito.Cantidad = "0";
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritopreventa.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");
                LimpiarTexto();
            },
            "json"
        );
        return false;
    });


$(document).ready(function() {
    $('#vaciar').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#savepreventas")[0].reset();
        $("#codcliente").val("0");
        $("#lblsubtotal").text("0.00");
        $("#lblsubtotal2").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lbltotal").text("0.00");

        $("#txtsubtotal").val("0.00");
        $("#txtsubtotal2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
        $("#muestra_condiciones").load("condiciones_pagos.php?BuscaCondicionesPagos=si&tipopago=CONTADO&txtTotal=0.00");
    });
});



/* CANCELAR LOS ITEM AGREGADOS EN AGREGAR DETALLES */
$("#vaciar2").click(function() {
    var Carrito = new Object();
    Carrito.Id = "vaciar";
    Carrito.Codigo = "vaciar";
    Carrito.Producto = "vaciar";
    Carrito.Descripcion = "vaciar";
    Carrito.Imei = "vaciar";
    Carrito.Condicion = "vaciar";
    Carrito.Codmarca = "vaciar";
    Carrito.Marcas = "vaciar";
    Carrito.Codmodelo = "vaciar";
    Carrito.Modelos = "vaciar";
    Carrito.Codpresentacion = "vaciar";
    Carrito.Presentacion = "vaciar";
    Carrito.Codcolor = "vaciar";
    Carrito.Color = "vaciar";
    Carrito.Precio      = "0";
    Carrito.Precio2      = "0";
    Carrito.Descproducto      = "0";
    Carrito.Ivaproducto = "vaciar";
    Carrito.Existencia = "vaciar";
    Carrito.Precioconiva      = "0";
    Carrito.TipoDetalle     = "vaciar";
    Carrito.Cantidad = "0";
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritopreventa.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var nuevaFila =
            "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
            $(nuevaFila).appendTo("#carrito tbody");
            LimpiarTexto();
        },
        "json"
    );
    return false;
});

$(document).ready(function() {
    $('#vaciar2').click(function() {
        $("#carrito tbody").html("");
        var nuevaFila =
        "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#agregapreventas")[0].reset();
        $("#codcliente").val("0");
        $("#lblsubtotal").text("0.00");
        $("#lblsubtotal2").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lbltotal").text("0.00");

        $("#txtsubtotal").val("0.00");
        $("#txtsubtotal2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
    });
});



//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function (){
    $('#descuento').keyup(function(){
    
        var txtsubtotal = $('input#txtsubtotal').val();
        var txtsubtotal2 = $('input#txtsubtotal2').val();
        var txtIva = $('input#txtIva').val();
        var desc = $('input#descuento').val();
        descuento  = desc/100;
                    
        //REALIZO EL CALCULO CON EL DESCUENTO INDICADO
        Subtotal = parseFloat(txtsubtotal) + parseFloat(txtsubtotal2) + parseFloat(txtIva); 
        TotalDescuentoGeneral   = parseFloat(Subtotal.toFixed(2)) * parseFloat(descuento.toFixed(2));
        TotalFactura   = parseFloat(Subtotal.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));        
    
        $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
        $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));
        $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
        $("#txtTotal").val(TotalFactura.toFixed(2));
        $("#txtPagado").val(TotalFactura.toFixed(2));
    });
});


//AGREGA DETALLE DE PRODUCTO CON ENTER
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            $('#AgregaProducto').trigger("click");
            return false;
        }
    });                    
});

//MUESTRO MODAL DE PAGO CON F2
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '113') {
        $("#btn-submit").trigger("click");
        return false;
        }
    });                    
});


//LIMPIO VALORES DE FORMULARIO CON F4
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '115' && button == false) {
            $('#vaciar').trigger("click");
            return false;
        }
    });                    
});

//MUESTRO MODAL CLIENTE CON F7
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '118') {
        $("#myModalCliente").modal("toggle");
        $('#myModalCliente').on('shown.bs.modal', function() {
        })
        return false;
        }
    });                    
});


function LimpiarTexto() {
    $("#search_busqueda").val("");
    $("#idproducto").val("");
    $("#codproducto").val("");
    $("#producto").val("");
    $("#descripcion").val("");
    $("#imei").val("");
    $("#condicion").val("");
    $("#codmarca").val("");
    $("#marcas").val("");
    $("#codmodelo").val("");
    $("#modelos").val("");
    $("#codpresentacion").val("");
    $("#presentacion").val("");
    $("#codcolor").val("");
    $("#color").val("");
    $("#preciocompra").val("");
    ($('input:radio[name=tipodetalle]:checked').val() == 1 ? $("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>') : $('input#precioventa').val(""));
    $("#descproducto").val("0.00");
    $("#ivaproducto").val("");
    $("#existencia").val("0.00");
    $("#precioconiva").val("");
    $("#cantidad").val("");
}

$("#carrito tbody").on('blur', 'input', function(e) {
    var element = $(this);
    var pvalue = element.val();
    /*var code = e.charCode || e.keyCode;
    var avalue = String.fromCharCode(code);*/
    var regx = /^[A-Za-z0-9 _.-]+$/;
    var action = element.siblings('button').first().attr('onclick');
    var params;
    //if (code !== 16 && /[^\d]/ig.test(avalue)) {
    if (!regx.test(e.charCode) || !regx.test(e.keyCode)){
        e.preventDefault();
        return;
    }
    if (element.attr('data-proc') == '1') {
        return true;
    }
    element.attr('data-proc', '1');
    params = action.match(/\'([^\']+)\'/g).map(function(v) {
        return v.replace(/\'/g, '');
    });
    setTimeout(function() {
        if (element.attr('data-proc') == '1') {
            var value = element.val() || 0;
            addItem(
                params[0],
                params[1],
                value,
                params[3],
                params[4],
                params[5],
                params[6],
                params[7],
                params[8],
                params[9],
                params[10],
                params[11],
                params[12],
                params[13],
                params[14],
                params[15],
                params[16],
                params[17],
                params[18],
                params[19],
                params[20],
                params[21],
                '='
            );
            element.attr('data-proc', '0');
            }
        }, 100);
    });
});

// FUNCION PARA VERIFICAR DETALLE DE COTIZACION
function VerificaDetalle(){
    
    var tipo = $('input:radio[name=tipodetalle]:checked').val();

    if (tipo === "" || tipo === true) {

    $("#search_busqueda").val("");
    $("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
    $("#existencia").val("");
    $("#descproducto").val("");
    $("#ivaproducto").val("");

    } else if (tipo === "1" || tipo === true) {

    $("#search_busqueda").val("");
    $("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
    $("#existencia").val("");
    $("#descproducto").val("");
    $("#ivaproducto").val("");

    } else if (tipo === "2" || tipo === true) {

    $("#search_busqueda").val("");
    $("#muestra_input").html('<input type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Precio Venta" disabled="disabled" autocomplete="off"/><i class="fa fa-tint form-control-feedback"></i>');
    $("#existencia").val("");
    $("#descproducto").val("");
    $("#ivaproducto").val("");

    } else if (tipo === "3" || tipo === true) {

    $("#search_busqueda").val("");
    $("#muestra_input").html('<input type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Precio Servicio" autocomplete="off"/><i class="fa fa-tint form-control-feedback"></i>');
    $("#existencia").val("0.00");
    $("#descproducto").val("0.00");
    $("#ivaproducto").val("NO");

    }
}

//FUNCION AGREGAR MEDIO DE PAGO
function addRowPago() {
    let maxIdx = -1;
    $("#muestra_condiciones select[name^='pagos[']").each(function() {
        const match = $(this).attr('name').match(/pagos\[(\d+)\]/);
        if (match) {
            maxIdx = Math.max(maxIdx, parseInt(match[1], 10));
        }
    });
    const newIdx = maxIdx + 1;
    const html = $("#rowPago").html().replace(/\$INDEX/g, newIdx);
    $("#muestra_condiciones").append(html);
    $("#muestra_condiciones > .row:last input").val("0.00");
    CalculoDevolucion();
}

//FUNCION QUITAR MEDIO DE PAGO
function rmRowPago(el) {
    $(el).closest(".row").remove();
    CalculoDevolucion();
}

//FUNCION PARA CALCULAR DEVOLUCION EN VENTA
function CalculoDevolucion() {

    const totalVal = $('input#txtTotal').val();
    if (totalVal === "" || parseFloat(totalVal) === 0) {

    $("#montopagado").val("");
    swal("Oops", "POR FAVOR AGREGUE DETALLES PARA CONTINUAR CON LA VENTA DE PRODUCTOS!", "error");

    return false;

    } else {

        let sumaPagos = 0;
        $("#muestra_condiciones input").each(function() {
            const val = parseFloat($(this).val()) || 0;
            sumaPagos += val;
        });

        const montopagado = sumaPagos;
        const montototal = parseFloat($("input#txtTotal").val()) || 0;

        //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
        const montoVuelto = montopagado - montototal;

        $("#txtPagado").val(montopagado.toFixed(2));
        $("#TextPagado").text(Separador(montopagado.toFixed(2)));
        $("#TextCambio").text((montopagado == "" || montopagado == "0.00") ? "0.00" : Separador(montoVuelto.toFixed(2)));
        $("#montodevuelto").val((montopagado == "" || montopagado == "0.00") ? "0.00" : montoVuelto.toFixed(2));
    }
}


// FUNCION PARA MOSTRAR CONDICIONES DE PAGO
function CargaCondicionesPagos(){
    
var tipopago = $('input:radio[name=tipopago]:checked').val();
var montototal = $('input#txtTotal').val();

var sumtotal = parseFloat(montototal);
var Sumatoria = parseFloat(sumtotal.toFixed(2));

$("#TextImporte").text(Separador(Sumatoria.toFixed(2)));
$("#TextPagado").text(tipopago == "CREDITO" ? "0.00" : Separador(montototal));
$("#txtPagado").val(tipopago == "CREDITO" ? "0.00" : Separador(montototal));
$("#TextCambio").text("0.00");

var dataString = 'BuscaCondicionesPagos=si&tipopago='+tipopago+"&txtTotal="+montototal;

    $.ajax({
        type: "GET",
            url: "condiciones_pagos.php",
            data: dataString,
            success: function(response) {            
            $('#muestra_condiciones').empty();
            $('#muestra_condiciones').append(''+response+'').fadeIn("slow"); 
        }
    });
}

function addItem(id, codigo, cantidad, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, precio, precio2, descproducto, ivaproducto, existencia, precioconiva, tipodetalle, opCantidad) {
    var Carrito = new Object();
    Carrito.Id = id;
    Carrito.Codigo = codigo;
    Carrito.Producto = producto;
    Carrito.Descripcion = descripcion;
    Carrito.Imei = imei;
    Carrito.Condicion = condicion;
    Carrito.Codmarca = codmarca;
    Carrito.Marcas = marcas;
    Carrito.Codmodelo = codmodelo;
    Carrito.Modelos = modelos;
    Carrito.Codpresentacion = codpresentacion;
    Carrito.Presentacion = presentacion;
    Carrito.Codcolor = codcolor;
    Carrito.Color = color;
    Carrito.Precio = precio;
    Carrito.Precio2 = precio2;
    Carrito.Descproducto = descproducto;
    Carrito.Ivaproducto = ivaproducto;
    Carrito.Existencia = existencia;
    Carrito.Precioconiva      = precioconiva;
    Carrito.TipoDetalle      = tipodetalle;
    Carrito.Cantidad = cantidad;
    Carrito.opCantidad = opCantidad;
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritopreventa.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var contador = 0;
            var TotalDescuento = 0;
            var SubtotalFact = 0;
            var BaseImpIva = 0;
            var BaseImpIva2 = 0;
            var Descontado = 0;
            var TotalIvaGeneral = 0;
            var TotalCompra = 0;

            $.each(data, function(i, item) {
                var cantsincero = item.cantidad;
                cantsincero = parseInt(cantsincero);
                if (cantsincero != 0) {
                    contador = contador + 1;

                var OperacionCompra= parseFloat(item.precio) * parseFloat(item.cantidad);
                TotalCompra = parseFloat(TotalCompra) + parseFloat(OperacionCompra);

                //CALCULO DEL VALOR TOTAL
                var PrecioVenta = parseFloat(item.precio2);
                var ValorTotal= parseFloat(item.precio2) * parseFloat(item.cantidad);

                //CALCULO DEL TOTAL DEL DESCUENTO %
                var Descuento = ValorTotal * item.descproducto / 100;
                TotalDescuento = parseFloat(TotalDescuento) + parseFloat(Descuento);

                //OBTENEMOS DESCUENTO INDIVIDUAL POR PRODUCTOS
                var descsiniva = item.precio2 * item.descproducto / 100;
                var descconiva = item.precioconiva * item.descproducto / 100;

                //CALCULO DE BASE IMPONIBLE IVA SIN PORCENTAJE
                var Operac= parseFloat(item.precio2) - parseFloat(descsiniva);
                var Operacion= parseFloat(Operac) * parseFloat(item.cantidad);
                var Subtotal = Operacion.toFixed(2);

                //CALCULO DE BASE IMPONIBLE IVA CON PORCENTAJE
                var Operac3 = parseFloat(item.precioconiva) - parseFloat(descconiva);
                var Operacion3 = parseFloat(Operac3) * parseFloat(item.cantidad);
                var Subbaseimponiva = Operacion3.toFixed(2);

                //CALCULO GENERAL DE IVA CON BASE IVA * IVA %
                var ivg = $('input#iva').val();
                ivg2  = ivg;

                //CALCULO VALOR DISCRIMINADO
                var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
                var Discriminado = parseFloat(item.precioconiva) / ValorImpuesto;
                var SubtotalDiscriminado = parseFloat(item.precioconiva) - parseFloat(Discriminado.toFixed(2));
                var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(item.cantidad);
                TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva = parseFloat(BaseImpIva) + parseFloat(Subbaseimponiva);
                BaseImpIva1 = parseFloat(BaseImpIva) - parseFloat(TotalIvaGeneral);
                
                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = (item.ivaproducto != "(E)") ? BaseImpIva2 : parseFloat(BaseImpIva2) + parseFloat(Subtotal);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;
            
                //CALCULO DEL TOTAL DE FACTURA
                SubTotalTxt = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

                if(item.tipodetalle == 1){
                    var Detalle = "PRODUCTO";
                } else if(item.tipodetalle == 2){
                    var Detalle = "COMBO";
                } else if(item.tipodetalle == 3){
                    var Detalle = "SERVICIO";
                }

                    var nuevaFila =
                    "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                    "<td>" +
                    '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'-1'," +
                    "'" + item.producto + "'," +
                    "'" + item.descripcion + "'," +
                    "'" + item.imei + "'," +
                    "'" + item.condicion + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codcolor + "'," +
                    "'" + item.color + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'-'" +
                    ')"' +
                    " type='button'><span class='fa fa-minus'></span></button>" +
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:50px;height:34px;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-info btn-xs" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'+1'," +
                    "'" + item.producto + "'," +
                    "'" + item.descripcion + "'," +
                    "'" + item.imei + "'," +
                    "'" + item.condicion + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codcolor + "'," +
                    "'" + item.color + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'+'" +
                    ')"' +
                    " type='button'><span class='fa fa-plus'></span></button></td>" +
                    "<td class='text-danger alert-link'>" + Detalle + "</td>" +
                    "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.codmarca == '0' ? '******' : item.marcas) + ") - MODELO (" + (item.codmodelo == '0' ? '******' : item.modelos) + ")</small></td>" +
                    "<td><strong>" + Separador(PrecioVenta.toFixed(2)) + "</strong></td>" +
                    "<td><strong>" + Separador(ValorTotal.toFixed(2)) + "</strong></td>" +
                    "<td><strong>" + Separador(Descuento.toFixed(2)) + "<sup>" + Separador(item.descproducto) + "%</sup></strong></td>" +
                    "<td><strong>" + item.ivaproducto + "</strong></td>" +
                    "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                    "<td>" +
                    '<button class="btn btn-rounded btn-info" style="cursor:pointer;color:#fff;" ' +
                    'onclick="AsignaPrecio(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'" + item.tipodetalle + "'," +
                    "'" + item.producto.replace(/\s/g,"_") + "'," +
                    "'" + item.cantidad + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "'" +
                    ')"' +
                    ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPrecio" data-backdrop="static" data-keyboard="false" type="button"><span class="fa fa-pencil"></span></button> ' +
                    
                    '<button class="btn btn-rounded btn-dark" style="cursor:pointer;color:#fff;" ' +
                    'onclick="addItem(' +
                    "'" + item.id + "'," +
                    "'" + item.txtCodigo + "'," +
                    "'0'," +
                    "'" + item.producto + "'," +
                    "'" + item.descripcion + "'," +
                    "'" + item.imei + "'," +
                    "'" + item.condicion + "'," +
                    "'" + item.codmarca + "'," +
                    "'" + item.marcas + "'," +
                    "'" + item.codmodelo + "'," +
                    "'" + item.modelos + "'," +
                    "'" + item.codpresentacion + "'," +
                    "'" + item.presentacion + "'," +
                    "'" + item.codcolor + "'," +
                    "'" + item.color + "'," +
                    "'" + item.precio + "', " +
                    "'" + item.precio2 + "', " +
                    "'" + item.descproducto + "', " +
                    "'" + item.ivaproducto + "', " +
                    "'" + item.existencia + "', " +
                    "'" + item.precioconiva + "', " +
                    "'" + item.tipodetalle + "', " +
                    "'='" +
                    ')"' +
                    ' type="button"><span class="fa fa-trash-o"></span></button>' +
                    "</td>" +
                    "</tr>";
                    $(nuevaFila).appendTo("#carrito tbody");
                                    
                    $("#lblsubtotal").text(Separador(BaseImpIva1.toFixed(2)));
                    $("#lblsubtotal2").text(Separador(BaseImpIva2.toFixed(2)));
                    $("#lbliva").text(Separador(TotalIvaGeneral.toFixed(2)));
                    $("#lbldescontado").text(Separador(TotalDescuento.toFixed(2)));
                    $("#lbldescuento").text(Separador(TotalDescuentoGeneral.toFixed(2)));
                    $("#lbltotal").text(Separador(TotalFactura.toFixed(2)));

                    $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                    $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                    $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                    $("#txtTotalCompra").val(TotalCompra.toFixed(2));
                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#savepreventas")[0].reset();
                $("#lblsubtotal").text("0.00");
                $("#lblsubtotal2").text("0.00");
                $("#lbliva").text("0.00");
                $("#lbldescontado").text("0.00");
                $("#lbldescuento").text("0.00");
                $("#lbltotal").text("0.00");
                
                $("#txtsubtotal").val("0.00");
                $("#txtsubtotal2").val("0.00");
                $("#txtIva").val("0.00");
                $("#txtdescontado").val("0.00");
                $("#txtDescuento").val("0.00");
                $("#txtTotal").val("0.00");
                $("#txtTotalCompra").val("0.00");
            }
            LimpiarTexto();
        },
        "json"
    );
    return false;
}