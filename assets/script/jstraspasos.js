function Separador(x) {//SEPARADOR CON DECIMAL
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function DoAction(idproducto, codproducto, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle) {
    addItem(idproducto, codproducto, 1, producto, descripcion, imei, condicion, codmarca, marcas, codmodelo, modelos, codpresentacion, presentacion, codcolor, color, preciocompra, precioventa, descproducto, ivaproducto, existencia, precioconiva, tipodetalle, '+=');
}

function pulsar(e, valor) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 13) comprueba(valor)
}

$(document).ready(function() {

    /*############ FUNCION DESACTIVA ENTER EN FORMULARIO ############*/
    $('#savetraspaso').keypress(function(e){
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
    var prec2 = $('select#precioventa').val();
    var descuen = $('input#descproducto').val();
    var ivgprod = $('input#ivaproducto').val();
    var er_num = /^([0-9])*[.]?[0-9]*$/;
    cantp = parseInt(cantp);
    exist = parseInt(exist);
    cantp = cantp;

    if (code == "") {
        $("#search_traspaso").focus();
        $("#search_traspaso").css('border-color', '#ff7676');
        swal("Oops", "POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE!", "error");
        return false;

    } else if(prec2=="" || prec2=="0" || prec2=="0"){
        $("#precioventa").focus();
        $('#precioventa').css('border-color','#ff7676');
        $("#precioventa").val("");
        swal("Oops", "POR FAVOR INGRESE PRECIO DE VENTA VALIDO PARA PRODUCTO!", "error");  
        return false;

    } else if ($('#cantidad').val() == "" || $('#cantidad').val() == "0") {
        $("#cantidad").focus();
        $("#cantidad").css('border-color', '#ff7676');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA EN TRASPASOS!", "error");
        return false;

    } else if (isNaN($('#cantidad').val())) {
        $("#cantidad").focus();
        $("#cantidad").css('border-color', '#ff7676');
        swal("Oops", "POR FAVOR INGRESE SOLO DIGITOS EN CANTIDAD DE TRASPASOS!", "error");
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
        Carrito.Precio2      = $('select#precioventa').val();
        Carrito.Descproducto      = $('input#descproducto').val();
        Carrito.Ivaproducto = ($('input#ivaproducto').val() == "SI" ? $('input#iva').val() : "(E)");
        Carrito.Existencia = $('input#existencia').val();
        Carrito.Precioconiva = ($('input#ivaproducto').val() == "SI" ? $('select#precioventa').val() : "0");
        Carrito.TipoDetalle = $('input#tipodetalle').val();
        Carrito.Cantidad = $('input#cantidad').val();
        Carrito.opCantidad = '+=';
        var DatosJson = JSON.stringify(Carrito);
        $.post('carritotraspaso.php', {
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
                "<td><strong>" + item.txtCodigo + "</strong></td>" +
                "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.marcas == '' || item.marcas == '0' ? '******' : item.marcas) + ") - MODELO (" + (item.modelos == '' ? '****' : item.modelos) + ")</small></td>" +
                "<td><strong>" + Separador(item.precio2) + "</strong></td>" +
                "<td><strong>" + Separador(ValorTotal.toFixed(2)) + "</td>" +
                "<td><strong>" + Separador(Descuento.toFixed(2)) + "<sup>" + Separador(item.descproducto) + "%</sup></strong></td>" +
                "<td><strong>" + item.ivaproducto + "</td>" +
                "<td><strong>" + Separador(Operacion.toFixed(2)) + "</td>" +
                "<td>" +
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

                $("#search_traspaso").focus();
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
    $.post('carritotraspaso.php', {
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
        $("#savetraspaso")[0].reset();
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
    Carrito.TipoDetalle      = "vaciar";
    Carrito.Cantidad = "0";
    var DatosJson = JSON.stringify(Carrito);
    $.post('carritotraspaso.php', {
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
        $("#agregatraspaso")[0].reset();
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
        if (keycode == '115') {
            $('#vaciar').trigger("click");
            return false;
        }
    });                    
});


function LimpiarTexto() {
    $("#search_traspaso").val("");
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
    $('#precioventa').html("<option value=''>-- SIN RESULTADOS --</option>");
    $("#descproducto").val("");
    $("#ivaproducto").val("");
    $("#existencia").val("");
    $("#precioconiva").val("");
    $("#tipodetalle").val("1");
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
    $.post('carritotraspaso.php', {
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
                        "<td><strong>" + item.txtCodigo + "</strong></td>" +
                        "<td class='text-left'><h5><strong>" + item.producto + "</strong></h5><small>MARCA (" + (item.marcas == '' || item.marcas == '0' ? '******' : item.marcas) + ") - MODELO (" + (item.modelos == '' ? '****' : item.modelos) + ")</small></td>" +
                        "<td><strong>" + Separador(item.precio2) + "</strong></td>" +
                        "<td><strong>" + Separador(ValorTotal.toFixed(2)) + "</strong></td>" +
                        "<td><strong>" + Separador(Descuento.toFixed(2)) + "<sup>" + Separador(item.descproducto) + "%</sup></strong></td>" +
                        "<td><strong>" + item.ivaproducto + "</strong></td>" +
                        "<td><strong>" + Separador(Operacion.toFixed(2)) + "</strong></td>" +
                        "<td>" +
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
                $("#savetraspaso")[0].reset();
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
            //LimpiarTexto();
        },
        "json"
    );
    return false;
}