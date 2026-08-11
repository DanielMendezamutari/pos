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
  $("#agregaprecio #agrega_detalle_precio").load("detalles_productos?BuscaDetallesProductoxPrecio=si&variable=1&d_id="+id+"&d_codigo="+codigo+"&d_tipo="+tipodetalle+"&d_producto="+producto+"&d_producto="+producto+"&d_cantidad="+cantidad+"&d_precio="+precio2+"&d_descproducto="+descproducto);
}
// ####################### FUNCION PARA ASIGNAR PRECIO VENTA A DETALLES #######################


function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/
    $('#savepos').keypress(function(e){
        var keycode = (e.keyCode ? e.keyCode : e.which);   
        if (keycode == 13) {
            return false;
        }
    });
    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/

    /*############ FUNCION AGREGA POR CRITERIO ############*/
    $('#search_producto').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
          AgregaVentas();
          e.preventDefault();
          return false;
        }
    });
    /*############ FUNCION AGREGA POR CRITERIO ############*/

    /*############ FUNCION AGREGA POR LECTOR ############*/
    $('#search_producto_barra').keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == 13) {
            AgregaVentas();
            e.preventDefault();
            return false;
        }
    });

    $('#search_producto_barra').change(function(e) {        
        AgregaVentas();
        e.preventDefault();     
    });
    /*############ FUNCION AGREGA POR LECTOR ############*/

    function AgregaVentas () {
        var code = $('input#codproducto').val();
        var prod = $('input#producto').val();
        var cantp = $('input#cantidad').val();
        var exist = $('input#existencia').val();
        var prec = $('input#preciocompra').val();
        var prec2 = $('input#precioventa').val();
        var descuen = $('input#descproducto').val();
        var ivgprod = $('input#ivaproducto').val();
        var tipodetalle = $('input#tipodetalle').val();
        var er_num = /^([0-9])*[.]?[0-9]*$/;
        cantp = parseInt(cantp);
        exist = parseInt(exist);
        cantp = cantp;

        if (code == "") {
            $("#search_producto").focus();
            //$("#search_producto").css('border-color', '#ff7676');
            //swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO/SERVICIO CORRECTAMENTE!", "error");
            return false;
            
        } else if(prec2=="" || prec2=="0" || prec2=="0"){
            $("#precioventa").focus();
            $('#precioventa').css('border-color','#ff7676');
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR INGRESE PRECIO DE VENTA VALIDO PARA PRODUCTO!", "error");  
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
            $("#precioventa").val("");
            swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN VENTAS!", "error");
            return false;

        } else if (isNaN($('#cantidad').val())) {
            $("#cantidad").focus();
            $("#cantidad").css('border-color', '#ff7676');
            $("#cantidad").val("");
            swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE VENTAS!", "error");
            return false;
            
       } else if(cantp > exist){
            $("#cantidad").focus();
            $('#cantidad').css('border-color','#ff7676');
            $("#existencia").focus();
            $('#existencia').css('border-color','#ff7676');
            swal("Oops", "LA CANTIDAD DE PRODUCTOS SOLICITADA NO EXISTE EN ALMACEN, VERIFIQUE NUEVAMENTE POR FAVOR!", "error");
            return false;

        } else {

            var Carrito = new Object();
            Carrito.Id = $('input#idproducto').val();
            Carrito.Codigo = $('input#codproducto').val();
            Carrito.Producto = $('input#producto').val().replace(/[ '"]+/g, ' ');
            Carrito.Descripcion = $('input#descripcion').val().replace(/[ '"]+/g, ' ');
            Carrito.Imei = $('input#imei').val();
            Carrito.Condicion = $('input#condicion').val();
            Carrito.Codmarca = $('input#codmarca').val();
            Carrito.Marcas = $('input#marcas').val();
            Carrito.Codmodelo = $('input#codmodelo').val();
            Carrito.Modelos = $('input#modelos').val();
            Carrito.Codpresentacion = $('input#codpresentacion').val();
            Carrito.Presentacion = $('input#presentacion').val();
            Carrito.Codcolor = $('input#codcolor').val();
            Carrito.Color = $('input#codcolor').val();
            Carrito.Precio      = $('input#preciocompra').val();
            Carrito.Precio2      = $('input#precioventa').val();
            Carrito.Descproducto      = $('input#descproducto').val();
            Carrito.Ivaproducto = ($('input#ivaproducto').val() == "SI" ? $('input#iva').val() : "(E)");
            Carrito.Existencia = $('input#existencia').val();
            Carrito.Precioconiva = $('input#precioconiva').val();
            Carrito.TipoDetalle = $('input#tipodetalle').val();
            Carrito.Cantidad = $('input#cantidad').val();
            Carrito.opCantidad = '+=';
            var DatosJson = JSON.stringify(Carrito);
            $.post('carritoventa.php', {
                    MiCarrito: DatosJson
                },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var contador = 0;
                var TotalDescuento = 0;
                var SubtotalFact = 0;
                var BaseImpIva = 0;
                var BaseImpIva2 = 0;
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

        //MONTO MONEDA DE CAMBIO
        var montocambio = $('input#montocambio').val();
        
        //CALCULO DEL TOTAL DE FACTURA
        SubTotalTxt = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
        Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
        TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
        TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));
        TotalFacturaCambio   = parseFloat(TotalFactura.toFixed(2)) / parseFloat(montocambio);
        
        var nuevaFila =
            "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                "<td>" +
                '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
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
                "<input type='text' id='" + item.cantidad + "' class='bold' style='width:50px;height:28px;' value='" + item.cantidad + "'>" +
                '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
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
                "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6>" +
                (item.descripcion && item.descripcion !== '' && item.descripcion !== '0' ? "<small class='text-muted'>" + item.descripcion + "</small>" : "") +
                "</td>" +
                "<td><strong>" + Separador(item.precio2) + "</strong></td>" +
                "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                "<td>" +
                
                (typeof posCanEditPrice !== 'undefined' && posCanEditPrice ?
                '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
                'onclick="AsignaPrecio(' +
                "'" + item.id + "'," +
                "'" + item.txtCodigo + "'," +
                "'" + item.tipodetalle + "'," +
                "'" + item.producto.replace(/\s/g,"_") + "'," +
                "'" + item.cantidad + "', " +
                "'" + item.precio2 + "', " +
                "'" + item.descproducto + "'" +
                ')"' +
                ' data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPrecio" data-backdrop="static" data-keyboard="false" type="button"><span class="fa fa-pencil"></span></button> '
                : '') +
                    
                '<button class="btn btn-dark btn-sm" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
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
                $("#lbltotal2").text(Separador(TotalFacturaCambio.toFixed(2)));
                
                $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                $("#txtdescontado").val(TotalDescuento.toFixed(2));
                $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                $("#txtTotal").val(TotalFactura.toFixed(2));
                //$("#txtTotal2").val(TotalFacturaCambio.toFixed(2));
                $("#txtPagado").val(TotalFactura.toFixed(2));
                $("#txtTotalCompra").val(TotalCompra.toFixed(2));

                /*####### ACTIVAR BOTON DE PAGO #######*/
                $("#buttonpago").attr('disabled', false);
                $("#TextImporte").text(Separador(TotalFactura.toFixed(2)));
                $("#TextPagado").text(Separador(TotalFactura.toFixed(2)));
                $("#montopagado").val(TotalFactura.toFixed(2));

                    }
                });

                $("#search_busqueda").focus();
                //$("#search_producto").focus();
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
        $.post('carritoventa.php', {
                MiCarrito: DatosJson
            },
            function(data, textStatus) {
                $("#carrito tbody").html("");
                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
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
        "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
        $(nuevaFila).appendTo("#carrito tbody");
        $("#savepos")[0].reset();
        $("#codcliente").val("0");
        $("#lblsubtotal").text("0.00");
        $("#lblsubtotal2").text("0.00");
        $("#lbliva").text("0.00");
        $("#lbldescontado").text("0.00");
        $("#lbldescuento").text("0.00");
        $("#lbltotal").text("0.00");
        $("#lbltotal2").text("0.00");

        $("#txtsubtotal").val("0.00");
        $("#txtsubtotal2").val("0.00");
        $("#txtIva").val("0.00");
        $("#txtdescontado").val("0.00");
        $("#txtDescuento").val("0.00");
        $("#txtTotal").val("0.00");
        //$("#txtTotal2").val("0.00");
        $("#txtPagado").val("0.00");

        /*####### ACTIVAR BOTON DE PAGO #######*/
        $("#buttonpago").attr('disabled', true);
        $("#TextImporte").text("0.00");
        $("#TextPagado").text("0.00");
        $("#TextCambio").text("0.00");
        $('#TextCliente').text("Consumidor Final");
        $('#TextCredito').text("0.00");
        $("#montopagado").val("0.00");
        $("#muestra_condiciones").load("condiciones_pagos.php?BuscaCondicionesPagos=si&tipopago=CONTADO&txtTotal=0.00");
    });
});

$(document).ready(function(){
    $("#search_producto_barra").change(function(){
        let codeBar=$(this).val();
        $.ajax({    
            url: "class/busqueda_autocompleto.php?Busqueda_Producto_Barcode=si",
            data:{barcode:codeBar},      
            type : 'POST',   
            dataType : 'json',    
            success : function(json) {
                console.log(json);
                if (!json || json.length === 0) {
                    swal("No encontrado", "No se encontró ningún producto con ese código de barra!", "warning");
                    $('#search_producto_barra').val('');
                    return;
                }
                if (parseInt(json[0].existencia) <= 0) {
                    swal("SIN STOCK", "El producto '" + json[0].producto + "' no tiene stock disponible. No puede ser vendido!", "warning");
                    $('#search_producto_barra').val('');
                    return;
                }
                $('#idproducto').val(json[0].idproducto);
                $('#codproducto').val(json[0].codproducto);
                $('#producto').val(json[0].producto);
                $('#descripcion').val(json[0].descripcion);
                $('#imei').val(json[0].imei);
                $('#condicion').val(json[0].condicion);
                $('#codmarca').val(json[0].codmarca);
                $('#marcas').val(json[0].nommarca);
                $('#codmodelo').val(json[0].codmodelo);
                $('#modelos').val((json[0].codmodelo == "0") ? "*****" : json[0].nommodelo);
                $('#codpresentacion').val(json[0].codpresentacion);
                $('#presentacion').val((json[0].codpresentacion == "0") ? "******" : json[0].nompresentacion);
                $('#codcolor').val(json[0].codcolor);
                $('#color').val((json[0].codcolor == "0") ? "******" : json[0].nomcolor);
                $('#preciocompra').val(json[0].preciocompra);
                $('#precioventa').val(json[0].precioxpublico);
                $('#descproducto').val(json[0].descproducto);
                $('#ivaproducto').val(json[0].ivaproducto);
                $('#existencia').val(json[0].existencia);
                $('#precioconiva').val((json[0].ivaproducto == "SI") ? json[0].precioxpublico : "0");
                $("#cantidad").val("1");
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
                //swal("Oops", "HA Ocurrido un Error en el procesamiento de informacion!", "error");
                alert('Disculpe, Ha Ocurrido un Error en el procesamiento de informacion');
            }
        });
    });
});


//FUNCION PARA ACTUALIZAR CALCULO EN FACTURA DE COMPRAS CON DESCUENTO
$(document).ready(function(){
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

        $("#TextImporte").text(Separador(TotalFactura.toFixed(2)));
        $("#TextPagado").text(Separador(TotalFactura.toFixed(2)));
        $("#montopagado").val(TotalFactura.toFixed(2));
    });
});


//MUESTRO MODAL DE PAGO CON F2
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '113' && button == false) {
        $("#myModalPago").modal("toggle");
        $('#myModalPago').on('shown.bs.modal', function() {
        $('#montopagado').focus();
        })
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

//REGISTRO DE COBRO CON F8
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '119' && button == false) {
        $("#btn-submit").trigger("click");
        return false;
        }
    });                    
});

//CIERRO MODAL DE COBRO CON F10
$(document).ready(function(){
    $(document).keydown(function(e) {        
        var keycode = (e.keyCode ? e.keyCode : e.which);
        var button = $('#buttonpago').is(':disabled'); 
        if (keycode == '121' && button == false) {
            $('.close').trigger("click");
            return false;
        }
    });                    
});

function LimpiarTexto() {
    $("#search_producto").val("");
    $("#search_producto_barra").val("");
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
    $("#precioventa").val("");
    $("#descproducto").val("");
    $("#ivaproducto").val("");
    $("#existencia").val("");
    $("#precioconiva").val("");
    $("#cantidad").val("1");
    $("#tipodetalle").val("1");
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
    $.post('carritoventa.php', {
            MiCarrito: DatosJson
        },
        function(data, textStatus) {
            $("#carrito tbody").html("");
            var contador = 0;
            var TotalDescuento = 0;
            var SubtotalFact = 0;
            var BaseImpIva = 0;
            var BaseImpIva2 = 0;
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
                var PrecioImpuesto = (item.ivaproducto != "(E)") ? item.precio2 : "0.00";
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
                //TotalIvaGeneral = parseFloat(BaseImpIva1) * parseFloat(ivg2.toFixed(2));
                
                //CALCULO VALOR DISCRIMINADO
                var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
                var Discriminado = parseFloat(item.precioconiva) / ValorImpuesto;
                var SubtotalDiscriminado = parseFloat(item.precioconiva) - parseFloat(Discriminado.toFixed(2));
                var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(item.cantidad);
                TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));

                //BASE IMPONIBLE IVA CON PORCENTAJE
                BaseImpIva = parseFloat(BaseImpIva) + parseFloat(Subbaseimponiva);
                BaseImpIva1 = parseFloat(BaseImpIva) - parseFloat(TotalIvaGeneral);
                
                //SUBTOTAL GENERAL DE FACTURA
                //SubtotalFact = parseFloat(SubtotalFact) + parseFloat(Subtotal);

                //BASE IMPONIBLE IVA SIN PORCENTAJE
                BaseImpIva2 = (item.ivaproducto != "(E)") ? BaseImpIva2 : parseFloat(BaseImpIva2) + parseFloat(Subtotal);
                //BaseImpIva2 = parseFloat(BaseImpIva2) + parseFloat(Subtotal);
                
                //CALCULAMOS DESCUENTO POR PRODUCTO
                var desc = $('input#descuento').val();
                desc2  = desc/100;

                //MONTO MONEDA DE CAMBIO
                //var montocambio = $('input#montocambio').val();
                
                //CALCULO DEL TOTAL DE FACTURA
                SubTotalTxt = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2);
                Total = parseFloat(BaseImpIva1) + parseFloat(BaseImpIva2) + parseFloat(TotalIvaGeneral);
                TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
                TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));
                //TotalFacturaCambio   = parseFloat(TotalFactura.toFixed(2)) / parseFloat(montocambio);

                    var nuevaFila =
                    "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;' align='center'>" +
                    "<td>" +
                    '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 0px 0px 5px;" onclick="addItem(' +
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
                    "<input type='text' id='" + item.cantidad + "' class='bold' style='width:50px;height:28px;' value='" + item.cantidad + "'>" +
                    '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onclick="addItem(' +
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
                    "<td class='text-left'><h6><strong>" + item.producto + "</strong></h6><small>MARCA (" + (item.marcas == '' || item.marcas == '0' ? '******' : item.marcas) + ") : MODELO (" + (item.modelos == '' || item.modelos == '0' ? '****' : item.modelos) + ")</small></td>" +
                    "<td><strong>" + Separador(item.precio2) + "</strong></td>" +
                    "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                    "<td>" +
                    
                    '<button class="btn btn-info btn-sm" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
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

                    '<button class="btn btn-dark btn-sm" style="cursor:pointer;border-radius:5px 5px 5px 5px;color:#fff;" ' +
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
                    //$("#lbltotal2").text(Separador(TotalFacturaCambio.toFixed(2)));

                    $("#txtsubtotal").val(BaseImpIva1.toFixed(2));
                    $("#txtsubtotal2").val(BaseImpIva2.toFixed(2));
                    $("#txtIva").val(TotalIvaGeneral.toFixed(2));
                    $("#txtdescontado").val(TotalDescuento.toFixed(2));
                    $("#txtDescuento").val(TotalDescuentoGeneral.toFixed(2));
                    $("#txtTotal").val(TotalFactura.toFixed(2));
                    //$("#txtTotal2").val(TotalFacturaCambio.toFixed(2));
                    $("#txtPagado").val(TotalFactura.toFixed(2));
                    $("#txtTotalCompra").val(TotalCompra.toFixed(2));

                    /*####### ACTIVAR BOTON DE PAGO #######*/
                    $("#buttonpago").attr('disabled', false);
                    $("#TextImporte").text(Separador(TotalFactura.toFixed(2)));
                    $("#TextPagado").text(Separador(TotalFactura.toFixed(2)));
                    $("#montopagado").val(TotalFactura.toFixed(2));
                }
            });
            if (contador == 0) {

                $("#carrito tbody").html("");

                var nuevaFila =
                "<tr class='warning-element' style='border-left: 2px solid #ff5050 !important; background: #fce3e3;'>"+"<td class='text-center' colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>"+"</tr>";
                $(nuevaFila).appendTo("#carrito tbody");

                //alert("ELIMINAMOS TODOS LOS SUBTOTAL Y TOTALES");
                $("#savepos")[0].reset();
                $("#lblsubtotal").text("0.00");
                $("#lblsubtotal2").text("0.00");
                $("#lbliva").text("0.00");
                $("#lbldescontado").text("0.00");
                $("#lbldescuento").text("0.00");
                $("#lbltotal").text("0.00");
                $("#lbltotal2").text("0.00");
                
                $("#txtsubtotal").val("0.00");
                $("#txtsubtotal2").val("0.00");
                $("#txtIva").val("0.00");
                $("#txtdescontado").val("0.00");
                $("#txtDescuento").val("0.00");
                $("#txtTotal").val("0.00");
                //$("#txtTotal2").val("0.00");
                $("#txtPagado").val("0.00");
                $("#txtTotalCompra").val("0.00");

                /*####### ACTIVAR BOTON DE PAGO #######*/
                $("#buttonpago").attr('disabled', true);
                $("#TextImporte").text("0.00");
                $("#TextPagado").text("0.00");
                $('#TextCliente').text("Consumidor Final");
                $('#TextCredito').text("0.00");
                $("#montopagado").val("0.00");
                $("#montopagado").text("0.00");
            }
            //LimpiarTexto();
        },
        "json"
    );
    return false;
}