//SELECCIONAR/DESELECCIONAR TODOS LOS CHECKBOX
function Separador1(val) {//SEPARADOR SIN DECIMAL
    return String(val).split("").reverse().join("")
    .replace(/(.{3}\B)/g, "$1.")
    .split("").reverse().join("");
}

function Separador(x) {//SEPARADOR CON DECIMAL
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

$("#checkTodos").change(function () {
      $("input:checkbox").prop('checked', $(this).prop("checked"));
      //$("input[type='checkbox']:checked:enabled").prop('checked', $(this).prop("checked"));
  });

// FUNCION PARA LIMPIAR CHECKBOX ACTIVOS
function LimpiarCheckbox(){
$("input[type='checkbox']:checked:enabled").attr('checked',false); 
}

//BUSQUEDA EN CONSULTAS
$(document).ready(function () {
   (function($) {
       $('#FiltrarContenido').keyup(function () {
            var ValorBusqueda = new RegExp($(this).val(), 'i');
            $('.BusquedaRapida tr').hide();
             $('.BusquedaRapida tr').filter(function () {
                return ValorBusqueda.test($(this).text());
              }).show();
                })
      }(jQuery));
});

//FUNCION REFRESCA PRECIO VENTA
function Refrescar() {
    $("#search_producto_barra").attr('disabled', false);
    $("#muestra_input").html('<i class="fa fa-bars form-control-feedback"></i><select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class="form-control"><option value=""> -- SIN RESULTADOS -- </option></select>');
}













/////////////////////////////////// FUNCIONES DE USUARIOS //////////////////////////////////////

// FUNCION PARA MOSTRAR USUARIOS EN VENTANA MODAL
function VerUsuario(codigo){

$('#muestrausuariomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaUsuarioModal=si&codigo='+codigo;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrausuariomodal').empty();
                $('#muestrausuariomodal').append(''+response+'').fadeIn("slow");
                
            }
      });
}

// FUNCION PARA ACTUALIZAR USUARIOS
function UpdateUsuario(codigo,dni,nombres,sexo,direccion,telefono,email,usuario,nivel,status,comision,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveuser #codigo").val(codigo);
  $("#saveuser #dni").val(dni);
  $("#saveuser #nombres").val(nombres);
  $("#saveuser #sexo").val(sexo);
  $("#saveuser #direccion").val(direccion);
  $("#saveuser #telefono").val(telefono);
  $("#saveuser #email").val(email);
  $("#saveuser #usuario").val(usuario);
  $("#saveuser #nivel").val(nivel);
  $("#saveuser #status").val(status);
  $("#saveuser #comision").val(comision);
  $("#saveuser #codsucursal").val(codsucursal);
  $("#saveuser #proceso").val(proceso);
}

/////FUNCION PARA ACTUALIZAR STATUS DE USUARIOS 
function StatusUsuario(codigo,status,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Cambiar el Status de este Usuario?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codigo="+codigo+"&status="+status+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Procesado!", "Datos Procesados con éxito!", "success");
            $("#usuarios").load("consultas.php?CargaUsuarios=si");

          } else { 

             swal("Oops", "Usted no tiene Acceso para Cambiar Status de Usuarios, no tienes los privilegios dentro del Sistema!", "error"); 

                }

            }
        })
    });
}

/////FUNCION PARA ELIMINAR USUARIOS 
function EliminarUsuario(codigo,dni,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Usuario?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codigo="+codigo+"&dni="+dni+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $("#usuarios").load("consultas.php?CargaUsuarios=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Usuario no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Usuarios, no eres el Administrador del Sistema!", "error"); 

                }

            }
        })
    });
}

// FUNCION PARA MOSTRAR USUARIOS POR SUCURSAL
function CargaUsuarios(codsucursal){

$('#codigo').html('<center><i class="fa fa-spin fa-spinner"></i></center>');
                
var dataString = 'BuscaUsuariosxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codigo').empty();
                $('#codigo').append(''+response+'').fadeIn("slow");
                
           }
      });
}

////FUNCION PARA MOSTRAR USUARIO POR CODIGO
function SelectUsuario(codigo,codsucursal){

  $("#codigo").load("funciones.php?MuestraUsuario=si&codigo="+codigo+"&codsucursal="+codsucursal);

}

//FUNCIONES PARA ACTIVAR-DESACTIVAR NIVEL DE USUARIO
function NivelUsuario(nivel){

  $("#nivel").on("change", function() {

      var valor = $("#nivel").val();

      if (valor == "ADMINISTRADOR(A) SUCURSAL" || valor == "SECRETARIA" || valor == "CAJERO(A)" || valor === true) {
       
        $("#codsucursal").attr('disabled', false);

      } else {

        // deshabilitamos
        $("#codsucursal").attr('disabled', true);
      }
  });
}


// FUNCION PARA BUSCAR LOGS DE ACCESO
$(document).ready(function(){
//function BuscarPacientes() {  
    var consulta;
    //hacemos focus al campo de búsqueda
    $("#blogs").focus();
    //comprobamos si se pulsa una tecla
    $("#blogs").keyup(function(e){
      //obtenemos el texto introducido en el campo de búsqueda
      consulta = $("#blogs").val();

      if (consulta.trim() === '') {  

      $("#logs").html("<center><div class='alert alert-danger'><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BUSQUEDA CORRECTAMENTE</div></center>");
      return false;

      } else {
                                                                           
        //hace la búsqueda
        $.ajax({
          type: "POST",
          url: "consultas.php?CargaLogs=si",
          data: "b="+consulta,
          dataType: "html",
          beforeSend: function(){
              //imagen de carga
              $("#logs").html('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>');
          },
          error: function(){
              swal("Oops", "Ha ocurrido un error en la petición Ajax, verifique por favor!", "error"); 
          },
          success: function(data){                                                    
            $("#logs").empty();
            $("#logs").append(data);
          }
      });
     }
   });                                                               
});











/////////////////////////////////// FUNCIONES DE PROVINCIAS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR PROVINCIAS
function UpdateProvincia(id_provincia,provincia,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#saveprovincias #id_provincia").val(id_provincia);
  $("#saveprovincias #provincia").val(provincia);
  $("#saveprovincias #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PROVINCIAS 
function EliminarProvincia(id_provincia,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Provincia?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "id_provincia="+id_provincia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#provincias').load("consultas?CargaProvincias=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Provincia no puede ser Eliminada, tiene Departamentos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Provincias, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE DEPARTAMENTOS //////////////////////////////////////

// FUNCION PARA ACTUALIZAR DEPARTAMENTOS
function UpdateDepartamento(id_departamento,departamento,id_provincia,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savedepartamentos #id_departamento").val(id_departamento);
  $("#savedepartamentos #departamento").val(departamento);
  $("#savedepartamentos #id_provincia").val(id_provincia);
  $("#savedepartamentos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR DEPARTAMENTOS 
function EliminarDepartamento(id_departamento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Departamento de Provincia?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "id_departamento="+id_departamento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#departamentos').load("consultas?CargaDepartamentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Departamento no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Departamento, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

////FUNCION PARA MOSTRAR DEPARTAMENTOS POR PROVINCIA
function CargaDepartamentos(id_provincia){

$('#id_departamento').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaDepartamentos=si&id_provincia='+id_provincia;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#id_departamento').empty();
                $('#id_departamento').append(''+response+'').fadeIn("slow");
           }
      });
}

////FUNCION PARA SELECCIONAR DEPARTAMENTO POR PROVINCIA
function SelectDepartamento(id_provincia,id_departamento){

  $("#id_departamento").load("funciones.php?SeleccionaDepartamento=si&id_provincia="+id_provincia+"&id_departamento="+id_departamento);

}











/////////////////////////////////// FUNCIONES DE TIPOS DE DOCUMENTOS  //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE DOCUMENTOS
function UpdateDocumento(coddocumento,documento,descripcion,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savedocumentos #coddocumento").val(coddocumento);
  $("#savedocumentos #documento").val(documento);
  $("#savedocumentos #descripcion").val(descripcion);
  $("#savedocumentos #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE DOCUMENTOS 
function EliminarDocumento(coddocumento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Documento?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddocumento="+coddocumento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#documentos').load("consultas?CargaDocumentos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Documento no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Documentos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TIPOS DE MONEDA //////////////////////////////////////

// FUNCION PARA ACTUALIZAR TIPOS DE MONEDA
function UpdateTipoMoneda(codmoneda,moneda,siglas,simbolo,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemonedas #codmoneda").val(codmoneda);
  $("#savemonedas #moneda").val(moneda);
  $("#savemonedas #siglas").val(siglas);
  $("#savemonedas #simbolo").val(simbolo);
  $("#savemonedas #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE MONEDA 
function EliminarTipoMoneda(codmoneda,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Moneda?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmoneda="+codmoneda+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#monedas').load("consultas?CargaMonedas=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Tipo de Moneda no puede ser Eliminado, tiene Tipos de Cambio relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Moneda, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE TIPOS DE CAMBIO  //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A TIPOS DE MONEDA
function AgregaSucursalxTipoCambio(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savecambio #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE TIPOS DE MONEDA POR SUCURSAL
function BuscaTiposCambiosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#tiposcambiosxsucursal").serialize();
var url = 'consultas.php?BuscaTiposCambiosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR TIPOS DE CAMBIO
function UpdateTipoCambio(codcambio,descripcioncambio,montocambio,codmoneda,fechacambio,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecambio #codcambio").val(codcambio);
  $("#savecambio #descripcioncambio").val(descripcioncambio);
  $("#savecambio #montocambio").val(montocambio);
  $("#savecambio #codmoneda").val(codmoneda);
  $("#savecambio #fechacambio").val(fechacambio);
  $("#savecambio #codsucursal").val(codsucursal);
  $("#savecambio #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR TIPOS DE CAMBIO 
function EliminarTipoCambio(codcambio,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Tipo de Cambio?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcambio="+codcambio+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#cambios').load("consultas.php?CargaCambios=si");   
            }
            $("#savecambio")[0].reset();
                  
           } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Tipos de Cambio, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE MEDIOS DE PAGOS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A TIPOS DE MONEDA
function AgregaSucursalxMedioPago(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savemedio #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE MEDIOS DE PAGOS POR SUCURSAL
function BuscaMediosPagosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#mediospagosxsucursal").serialize();
var url = 'consultas.php?BuscaMediosPagosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR MEDIOS DE PAGOS
function UpdateMedioPago(codmediopago,mediopago,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemedio #codmediopago").val(codmediopago);
  $("#savemedio #mediopago").val(mediopago);
  $("#savemedio #codsucursal").val(codsucursal);
  $("#savemedio #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MEDIOS DE PAGOS 
function EliminarMedioPago(codmediopago,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Medio de Pago?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmediopago="+codmediopago+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#mediospagos').load("consultas?CargaMediosPagos=si");   
            }
            $("#savecambio")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Este Medio de Pago no puede ser Eliminado, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Medios de Pagos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}












/////////////////////////////////// FUNCIONES DE IMPUESTOS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A IMPUESTO
function AgregaSucursalxImpuesto(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#saveimpuesto #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE IMPUESTOS POR SUCURSAL
function BuscaImpuestosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#impuestosxsucursal").serialize();
var url = 'consultas.php?BuscaImpuestosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR IMPUESTOS
function UpdateImpuesto(codimpuesto,nomimpuesto,valorimpuesto,statusimpuesto,fechaimpuesto,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveimpuesto #codimpuesto").val(codimpuesto);
  $("#saveimpuesto #nomimpuesto").val(nomimpuesto);
  $("#saveimpuesto #valorimpuesto").val(valorimpuesto);
  $("#saveimpuesto #statusimpuesto").val(statusimpuesto);
  $("#saveimpuesto #fechaimpuesto").val(fechaimpuesto);
  $("#saveimpuesto #codsucursal").val(codsucursal);
  $("#saveimpuesto #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR IMPUESTOS
function EliminarImpuesto(codimpuesto,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Impuesto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codimpuesto="+codimpuesto+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#impuestos').load("consultas.php?CargaImpuestos=si");   
            }
            $("#saveimpuesto")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Este Impuesto no puede ser Eliminado, se encuentra activo para Ventas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Impuestos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE BANCOS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A IMPUESTO
function AgregaSucursalxBanco(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savebanco #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE IMPUESTOS POR SUCURSAL
function BuscaBancosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#bancosxsucursal").serialize();
var url = 'consultas.php?BuscaBancosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR BANCOS
function UpdateBanco(codbanco,nombanco,codsucursal,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savebanco #codbanco").val(codbanco);
  $("#savebanco #nombanco").val(nombanco);
  $("#savebanco #codsucursal").val(codsucursal);
  $("#savebanco #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR BANCOS 
function EliminarBanco(codbanco,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Banco?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codbanco="+codbanco+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#bancos').load("consultas?CargaBancos=si");   
            }
            $("#savebanco")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Este Banco no puede ser Eliminado, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Bancos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}










/////////////////////////////////// FUNCIONES DE SUCURSALES //////////////////////////////////////

// FUNCION PARA MOSTRAR SUCURSALES EN VENTANA MODAL
function VerSucursal(codsucursal){

$('#muestrasucursalmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaSucursalModal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
                  url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#muestrasucursalmodal').empty();
                $('#muestrasucursalmodal').append(''+response+'').fadeIn("slow");
            }
      });
}

// FUNCION PARA ACTUALIZAR SUCURSALES
function UpdateSucursal(codsucursal,documsucursal,cuitsucursal,nomsucursal,
id_provincia,direcsucursal,correosucursal,tlfsucursal,inicioticket,iniciofactura,inicioguia,inicionotaventa,inicionotacredito,nroactividadsucursal,fechaautorsucursal,
llevacontabilidad,documencargado,dniencargado,nomencargado,tlfencargado,descsucursal,porcentaje,codmoneda,codmoneda2,membrete,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savesucursal #codsucursal").val(codsucursal);
  $("#savesucursal #documsucursal").val(documsucursal);
  $("#savesucursal #cuitsucursal").val(cuitsucursal);
  $("#savesucursal #nomsucursal").val(nomsucursal);
  $("#savesucursal #id_provincia").val(id_provincia);
  $("#savesucursal #direcsucursal").val(direcsucursal);
  $("#savesucursal #correosucursal").val(correosucursal);
  $("#savesucursal #tlfsucursal").val(tlfsucursal);
  $("#savesucursal #inicioticket").val(inicioticket);
  $("#savesucursal #iniciofactura").val(iniciofactura);
  $("#savesucursal #inicioguia").val(inicioguia);
  $("#savesucursal #inicionotaventa").val(inicionotaventa);
  $("#savesucursal #inicionotacredito").val(inicionotacredito);
  $("#savesucursal #nroactividadsucursal").val(nroactividadsucursal);
  $("#savesucursal #fechaautorsucursal").val(fechaautorsucursal);
  $("#savesucursal #llevacontabilidad").val(llevacontabilidad);
  $("#savesucursal #documencargado").val(documencargado);
  $("#savesucursal #dniencargado").val(dniencargado);
  $("#savesucursal #nomencargado").val(nomencargado);
  $("#savesucursal #tlfencargado").val(tlfencargado);
  $("#savesucursal #descsucursal").val(descsucursal);
  $("#savesucursal #porcentaje").val(porcentaje);
  $("#savesucursal #codmoneda").val(codmoneda);
  $("#savesucursal #codmoneda2").val(codmoneda2);
  $("#savesucursal #membrete").val(membrete);
  $("#savesucursal #proceso").val(proceso);
}

/////FUNCION PARA ACTUALIZAR STATUS DE SUCURSAL 
function StatusSucursal(codsucursal,estado,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Cambiar el Estado de esta Sucursal?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codsucursal="+codsucursal+"&estado="+estado+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Procesado!", "Datos Procesados con éxito!", "success");
            $("#sucursales").load("consultas.php?CargaSucursales=si");

          } else { 

             swal("Oops", "Usted no tiene Acceso para Cambiar Status de Usuarios, no tienes los privilegios dentro del Sistema!", "error"); 

                }

            }
        })
    });
}

/////FUNCION PARA ELIMINAR SUCURSALES 
function EliminarSucursal(codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Sucursal?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

         if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#sucursales').load("consultas?CargaSucursales=si");
                  
          } else if(data==2){ 

             swal("Oops", "Esta Sucursal no puede ser Eliminada, tiene registros relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Sucursales, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}











/////////////////////////////////// FUNCIONES DE FAMILIAS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A FAMILIA
function AgregaSucursalxFamilia(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savefamilia #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE FAMILIAS POR SUCURSAL
function BuscaFamiliasxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#familiasxsucursal").serialize();
var url = 'consultas.php?BuscaFamiliasxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR FAMILIAS
function UpdateFamilia(codfamilia,nomfamilia,codsucursal,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savefamilia #codfamilia").val(codfamilia);
  $("#savefamilia #nomfamilia").val(nomfamilia);
  $("#savefamilia #codsucursal").val(codsucursal);
  $("#savefamilia #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR FAMILIAS 
function EliminarFamilia(codfamilia,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Familia de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codfamilia="+codfamilia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#familias').load("consultas?CargaFamilias=si");   
            }
            $("#savefamilia")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Esta Familia no puede ser Eliminada, tiene Subfamilias relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Familias, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR FAMILIAS POR SUCURSAL
function CargaFamiliasxSucursal(codsucursal,codfamilia){

$('#codfamilia').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaFamiliasxSucursal=si&codsucursal='+codsucursal+"&codfamilia="+codfamilia;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codfamilia').empty();
            $('#codfamilia').append(''+response+'').fadeIn("slow");
        }
    });
}










/////////////////////////////////// FUNCIONES DE SUBFAMILIAS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A TIPOS DE MONEDA
function AgregaSucursalxSubfamilia(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savesubfamilia #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE SUBFAMILIAS POR SUCURSAL
function BuscaSubfamiliasxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#subfamiliasxsucursal").serialize();
var url = 'consultas.php?BuscaSubfamiliasxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR SUBFAMILIAS
function UpdateSubfamilia(codsubfamilia,nomsubfamilia,codfamilia,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savesubfamilia #codsubfamilia").val(codsubfamilia);
  $("#savesubfamilia #nomsubfamilia").val(nomsubfamilia);
  $("#savesubfamilia #codfamilia").val(codfamilia);
  $("#savesubfamilia #codsucursal").val(codsucursal);
  $("#savesubfamilia #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR SUBFAMILIAS 
function EliminarSubfamilia(codsubfamilia,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Subfamilia de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codsubfamilia="+codsubfamilia+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#subfamilias').load("consultas?CargaSubfamilias=si");   
            }
            $("#savesubfamilia")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Esta Subfamilia no puede ser Eliminada, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Subfamilias, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR SUBFAMILIAS POR FAMILIAS
function CargaSubfamilias(codfamilia){

$('#codsubfamilia').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaSubfamilias=si&codfamilia='+codfamilia;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codsubfamilia').empty();
            $('#codsubfamilia').append(''+response+'').fadeIn("slow");
        }
    });
}












/////////////////////////////////// FUNCIONES DE MARCAS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A MARCA
function AgregaSucursalxMarca(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savemarca #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE MARCAS POR SUCURSAL
function BuscaMarcasxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#marcasxsucursal").serialize();
var url = 'consultas.php?BuscaMarcasxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR MARCAS
function UpdateMarca(codmarca,nommarca,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemarca #codmarca").val(codmarca);
  $("#savemarca #nommarca").val(nommarca);
  $("#savemarca #codsucursal").val(codsucursal);
  $("#savemarca #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MARCAS 
function EliminarMarca(codmarca,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Marca de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmarca="+codmarca+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#marcas').load("consultas?CargaMarcas=si");   
            }
            $("#savemarca")[0].reset();
            
          } else if(data==2){ 

             swal("Oops", "Esta Marca no puede ser Eliminada, tiene Modelos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Marcas, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR MODELOS POR SUCURSAL
function CargaMarcasxSucursal(codsucursal,codmarca){

$('#codmarca').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaMarcasxSucursal=si&codsucursal='+codsucursal+"&codmarca="+codmarca;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codmarca').empty();
            $('#codmarca').append(''+response+'').fadeIn("slow");
        }
    });
}









/////////////////////////////////// FUNCIONES DE MODELOS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A MODELO
function AgregaSucursalxModelo(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savemodelo #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE MODELOS POR SUCURSAL
function BuscaModelosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#modelosxsucursal").serialize();
var url = 'consultas.php?BuscaModelosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR MODELOS
function UpdateModelo(codmodelo,nommodelo,codmarca,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemodelo #codmodelo").val(codmodelo);
  $("#savemodelo #nommodelo").val(nommodelo);
  $("#savemodelo #codmarca").val(codmarca);
  $("#savemodelo #codsucursal").val(codsucursal);
  $("#savemodelo #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MODELOS 
function EliminarModelo(codmodelo,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Modelo de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmodelo="+codmodelo+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#modelos').load("consultas?CargaModelos=si");   
            }
            $("#savemodelo")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Este Modelo no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Modelos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR MODELOS POR MARCAS---  $(document).off('focusin.bs.modal');
function CargaModelos(codmarca){

$('#codmodelo').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaModelos=si&codmarca='+codmarca;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codmodelo').empty();
            $('#codmodelo').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA MOSTRAR MODELOS POR MARCAS---  $(document).off('focusin.bs.modal');
function CargaModelos2(codmarca2){

$('#codmodelo2').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaModelos2=si&codmarca2='+codmarca2;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codmodelo2').empty();
            $('#codmodelo2').append(''+response+'').fadeIn("slow");
        }
    });
}










/////////////////////////////////// FUNCIONES DE PRESENTACIONES //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A PRESENTACION
function AgregaSucursalxPresentacion(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savepresentacion #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE PRESENTACIONES POR SUCURSAL
function BuscaPresentacionesxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#presentacionesxsucursal").serialize();
var url = 'consultas.php?BuscaPresentacionesxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR PRESENTACIONES
function UpdatePresentacion(codpresentacion,nompresentacion,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savepresentacion #codpresentacion").val(codpresentacion);
  $("#savepresentacion #nompresentacion").val(nompresentacion);
  $("#savepresentacion #codsucursal").val(codsucursal);
  $("#savepresentacion #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PRESENTACIONES 
function EliminarPresentacion(codpresentacion,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Presentaci&oacute;n de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpresentacion="+codpresentacion+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#presentaciones').load("consultas?CargaPresentaciones=si");   
            }
            $("#savepresentacion")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Esta Presentaci&oacute;n no puede ser Eliminada, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Presentaciones, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR PRESENTACIONES POR SUCURSAL
function CargaPresentacionesxSucursal(codsucursal){

$('#codpresentacion').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaPresentacionesxSucursal=si&codsucursal='+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codpresentacion').empty();
            $('#codpresentacion').append(''+response+'').fadeIn("slow");
        }
    });
}









/////////////////////////////////// FUNCIONES DE COLORES //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A COLOR
function AgregaSucursalxColor(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savecolor #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE COLORES POR SUCURSAL
function BuscaColoresxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#coloresxsucursal").serialize();
var url = 'consultas.php?BuscaColoresxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR COLORES
function UpdateColor(codcolor,nomcolor,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecolor #codcolor").val(codcolor);
  $("#savecolor #nomcolor").val(nomcolor);
  $("#savecolor #codsucursal").val(codsucursal);
  $("#savecolor #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR COLORES 
function EliminarColor(codcolor,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Color de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcolor="+codcolor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#colores').load("consultas?CargaColores=si");   
            }
            $("#savecolor")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Este Color no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Colores, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR COLORES POR SUCURSAL
function CargaColoresxSucursal(codsucursal){

$('#codcolor').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaColoresxSucursal=si&codsucursal='+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codcolor').empty();
            $('#codcolor').append(''+response+'').fadeIn("slow");
        }
    });
}









/////////////////////////////////// FUNCIONES DE ORIGENES //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A ORIGEN
function AgregaSucursalxOrigen(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#saveorigen #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE ORIGENES POR SUCURSAL
function BuscaOrigenesxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#origenesxsucursal").serialize();
var url = 'consultas.php?BuscaOrigenesxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA ACTUALIZAR ORIGENES
function UpdateOrigen(codorigen,nomorigen,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#saveorigen #codorigen").val(codorigen);
  $("#saveorigen #nomorigen").val(nomorigen);
  $("#saveorigen #codsucursal").val(codsucursal);
  $("#saveorigen #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR ORIGENES 
function EliminarOrigen(codorigen,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Origen de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codorigen="+codorigen+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#origenes').load("consultas?CargaOrigenes=si");  
            }
            $("#saveorigen")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Este Origen no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Origenes, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR ORIGENES POR SUCURSAL
function CargaOrigenesxSucursal(codsucursal){

$('#codorigen').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaOrigenesxSucursal=si&codsucursal='+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codorigen').empty();
            $('#codorigen').append(''+response+'').fadeIn("slow");
        }
    });
}









/////////////////////////////////// FUNCIONES DE CLIENTES //////////////////////////////////////

//FUNCION PARA LIMPIAR FORMULARIO DE CLIENTES
function ResetCliente() 
{
    $("#savecliente")[0].reset();
    $("#savecliente #proceso").val("save");
    $("#savecliente #codcliente").val("");
    $("#savecliente #tipocliente").val("");
    $("#savecliente #documcliente").val("");
    $("#savecliente #dnicliente").val("");
    $("#savecliente #nomcliente").val("").attr('disabled', true);
    $("#savecliente #razoncliente").val("").attr('disabled', true);
    $("#savecliente #girocliente").val("").attr('disabled', true);
    $("#savecliente #tlfcliente").val("");
    $("#savecliente #emailcliente").val("");
    $("#savecliente #id_provincia").val("0");
    $('#savecliente #id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");
    $("#savecliente #direccliente").val("");
    $("#savecliente #limitecredito").val("0.00");
}

//FUNCION PARA LIMPIAR OTROS FORMULARIO DE CLIENTES
function ResetCliente2() 
{
    $("#savecliente")[0].reset();
    $("#savecliente #proceso").val("nuevocliente");
    $("#savecliente #tipocliente").val("");
    $("#savecliente #documcliente").val("");
    $("#savecliente #dnicliente").val("");
    $("#savecliente #nomcliente").val("").attr('disabled', true);
    $("#savecliente #razoncliente").val("").attr('disabled', true);
    $("#savecliente #girocliente").val("").attr('disabled', true);
    $("#savecliente #tlfcliente").val("");
    $("#savecliente #emailcliente").val("");
    $("#savecliente #id_provincia").val("0");
    $('#savecliente #id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");
    $("#savecliente #direccliente").val("");
    $("#savecliente #limitecredito").val("0.00");
}

// FUNCION PARA ASIGNA SUCURSAL A CARGA MASIVA DE CLIENTES
function AgregaSucursalxMasivaCliente(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#cargaclientes #codsucursal").val(codsucursal);
}

// FUNCION PARA ASIGNA SUCURSAL A CLIENTE
function AgregaSucursalxCliente(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savecliente #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE CLIENTES POR SUCURSAL
function BuscaClientesxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#clientesxsucursal").serialize();
var url = 'consultas.php?BuscaClientesxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSCAR CLIENTES
function BuscarClientes(){
                        
$('#muestraclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bclientes").val();
var dataString = $("#busquedaclientes").serialize();
var url = 'consultas.php?CargaClientes=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestraclientes').empty();
        $('#muestraclientes').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE CLIENTES
function CargaDivClientes(){

$('#divcliente').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivCliente=si';

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#divcliente').empty();
            $('#divcliente').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE CLIENTES
function ModalCliente(){
  $("#divcliente").html("");
}

// FUNCION PARA MOSTRAR CLIENTES EN VENTANA MODAL
function VerCliente(codcliente){

$('#muestraclientemodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaClienteModal=si&codcliente='+codcliente;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestraclientemodal').empty();
            $('#muestraclientemodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA MOSTRAR DATOS DE CHEQUE O TARJETA DE CREDITO PAGO #1
function CargaTipoCliente(tipocliente){

    if (tipocliente === "NATURAL" || tipocliente === true) {
    
    $('#nomcliente').attr('disabled', false);
    $("#razoncliente").attr('disabled', true);
    $('#girocliente').attr('disabled', true);

    } else {

    // deshabilitamos
    $('#nomcliente').attr('disabled', true);
    $("#razoncliente").attr('disabled', false);
    $('#girocliente').attr('disabled', false);
    }
}

// FUNCION PARA ACTUALIZAR CLIENTES
function UpdateCliente(codcliente,tipocliente,documcliente,dnicliente,nomcliente,razoncliente,girocliente,tlfcliente,id_provincia,
  direccliente,emailcliente,limitecredito,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savecliente #codcliente").val(codcliente);
  $("#savecliente #tipocliente").val(tipocliente);
  $("#savecliente #documcliente").val(documcliente);
  $("#savecliente #dnicliente").val(dnicliente);
  $("#savecliente #nomcliente").val(nomcliente);
  $("#savecliente #razoncliente").val(razoncliente);
  $("#savecliente #girocliente").val(girocliente);
  $("#savecliente #tlfcliente").val(tlfcliente);
  $("#savecliente #id_provincia").val(id_provincia);
  $("#savecliente #direccliente").val(direccliente);
  $("#savecliente #emailcliente").val(emailcliente);
  $("#savecliente #limitecredito").val(limitecredito);
  $("#savecliente #codsucursal").val(codsucursal);
  $("#savecliente #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CLIENTES 
function EliminarCliente(codcliente,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Cliente?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcliente="+codcliente+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $("#BotonBusqueda").trigger("click");

          } else if(data==2){ 

            swal("Oops", "Este Cliente no puede ser Eliminado, tiene Ventas relacionados!", "error"); 

          } else { 

            swal("Oops", "Usted no tiene Acceso para Eliminar Clientes, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}













/////////////////////////////////// FUNCIONES DE PROVEEDORES //////////////////////////////////////

//FUNCION PARA LIMPIAR FORMULARIO DE PROVEEDORES
function ResetProveedor() 
{
    $("#saveproveedor")[0].reset();
    $("#saveproveedor #proceso").val("save");
    $("#saveproveedor #codproveedor").val("");
    $("#saveproveedor #documproveedor").val("");
    $("#saveproveedor #cuitproveedor").val("");
    $("#saveproveedor #nomproveedor").val("");
    $("#saveproveedor #tlfproveedor").val("");
    $("#saveproveedor #id_provincia").val("");
    $('#saveproveedor #id_departamento').html("<option value=''>-- SIN RESULTADOS --</option>");
    $("#saveproveedor #direcproveedor").val("");
    $("#saveproveedor #emailproveedor").val("");
    $("#saveproveedor #vendedor").val("");
    $("#saveproveedor #tlfvendedor").val("");
}

// FUNCION PARA ASIGNA SUCURSAL A CARGA MASIVA DE PROVEEDOR
function AgregaSucursalxMasivaProveedor(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#cargaproveedores #codsucursal").val(codsucursal);
}

// FUNCION PARA ASIGNA SUCURSAL A PROVEEDOR
function AgregaSucursalxProveedor(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#saveproveedor #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE PROVEEDORES POR SUCURSAL
function BuscaProveedoresxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#proveedoresxsucursal").serialize();
var url = 'consultas.php?BuscaProveedoresxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PROVEEDORES
function CargaDivProveedores(){

$('#divproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProveedor=si';

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#divproveedor').empty();
            $('#divproveedor').append(''+response+'').fadeIn("slow");
        }
    });
}


// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PROVEEDORES
function ModalProveedor(){
  $("#divproveedor").html("");
}

// FUNCION PARA MOSTRAR PROVEEDORES EN VENTANA MODAL
function VerProveedor(codproveedor){

$('#muestraproveedormodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProveedorModal=si&codproveedor='+codproveedor;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestraproveedormodal').empty();
            $('#muestraproveedormodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ACTUALIZAR PROVEEDORES
function UpdateProveedor(codproveedor,documproveedor,cuitproveedor,nomproveedor,tlfproveedor,id_provincia,
  direcproveedor,emailproveedor,vendedor,tlfvendedor,codsucursal,proceso) 
{
// aqui asigno cada valor a los campos correspondientes
  $("#saveproveedor #codproveedor").val(codproveedor);
  $("#saveproveedor #documproveedor").val(documproveedor);
  $("#saveproveedor #cuitproveedor").val(cuitproveedor);
  $("#saveproveedor #nomproveedor").val(nomproveedor);
  $("#saveproveedor #tlfproveedor").val(tlfproveedor);
  $("#saveproveedor #id_provincia").val(id_provincia);
  $("#saveproveedor #direcproveedor").val(direcproveedor);
  $("#saveproveedor #emailproveedor").val(emailproveedor);
  $("#saveproveedor #vendedor").val(vendedor);
  $("#saveproveedor #tlfvendedor").val(tlfvendedor);
  $("#saveproveedor #codsucursal").val(codsucursal);
  $("#saveproveedor #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR PROVEEDORES 
function EliminarProveedor(codproveedor,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Proveedor?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codproveedor="+codproveedor+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#proveedores').load("consultas.php?CargaProveedores=si");  
            }
            $("#saveproveedor")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Este Proveedor no puede ser Eliminado, tiene Productos relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Proveedores, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA MOSTRAR PROVEEDORES POR SUCURSAL
function CargaProveedoresxSucursal(codsucursal){

$('#codproveedor').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaProveedoresxSucursal=si&codsucursal='+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#codproveedor').empty();
            $('#codproveedor').append(''+response+'').fadeIn("slow");
        }
    });
}










/////////////////////////////////// FUNCIONES DE PEDIDOS //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE PEDIDOS POR SUCURSAL
function BuscaPedidosxSucursal(){

$('#muestra_pedidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#pedidosxsucursal").serialize();
var url = 'consultas.php?BuscaPedidosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_pedidos').empty();
            $('#muestra_pedidos').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR PEDIDOS EN VENTANA MODAL
function VerPedido(codpedido,codsucursal){

$('#muestrapedidomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaPedidoModal=si&codpedido='+codpedido+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestrapedidomodal').empty();
            $('#muestrapedidomodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ACTUALIZAR PEDIDOS
function UpdatePedido(codpedido,codsucursal,proceso) {

    swal({
        title: "¿Estás seguro?", 
        text: "¿Estás seguro de Actualizar este Pedido al Proveedor?", 
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: '#d33',
        closeOnConfirm: false,
        confirmButtonText: "Actualizar",
        confirmButtonColor: "#3085d6"
    }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpedido?codpedido="+codpedido+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
    })
}

// FUNCION PARA CALCULAR DETALLES PEDIDOS EN ACTUALIZAR
function PresionarDetallePedido(item,indice){
    var cantidad = $('#cantidad_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantidad_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoPedido(indice);
} 

// FUNCION PARA CALCULAR DETALLES PEDIDOS EN ACTUALIZAR
function ProcesarCalculoPedido(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var cantidadBD = $('#cantidadbd_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioconiva = $('#precioconiva_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descfactura_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantidad_"+indice).val(cantidadBD);
        $("#cantidad_"+indice).focus();
        $("#cantidad_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);
    
    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentoc_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");

    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0");

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(cantidad);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));
    //$('#lblsubtotal').text(Separador(SubTotal+BaseImpIva2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentoc').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));
}

// FUNCION PARA AGREGAR DETALLES A PEDIDOS
function AgregaDetallePedido(codpedido,codsucursal,proceso) {

    swal({
        title: "¿Estás seguro?", 
        text: "¿Estás seguro de Agregar Detalles de Productos a este Pedido al Proveedor?", 
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: '#d33',
        closeOnConfirm: false,
        confirmButtonText: "Continuar",
        confirmButtonColor: "#3085d6"
    }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpedido?codpedido="+codpedido+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
    })
}

/////FUNCION PARA ELIMINAR DETALLES DE PEDIDOS EN VENTANA MODAL
function EliminarDetallesPedidosModal(coddetallepedido,codpedido,codsucursal,tipo) {
        swal({
        title: "¿Estás seguro?", 
        text: "¿Estás seguro de Eliminar este Detalle del Pedido?", 
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: '#d33',
        closeOnConfirm: false,
        confirmButtonText: "Eliminar",
        confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepedido="+coddetallepedido+"&codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestrapedidomodal').load("funciones.php?BuscaPedidoModal=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
            $('#pedidos').load("consultas.php?CargaPedidos=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Pedidos en este Módulo, realice la Eliminación completa del Pedido!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Pedidos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE PEDIDOS EN ACTUALIZAR
function EliminarDetallesPedidosUpdate(coddetallepedido,codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle del Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepedido="+coddetallepedido+"&codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallespedidosupdate').load("funciones.php?MuestraDetallesPedidosUpdate=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Pedidos en este Módulo, realice la Eliminación completa del Pedido!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Pedidos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE PEDIDOS EN AGREGAR
function EliminarDetallesPedidosAgregar(coddetallepedido,codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle del Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepedido="+coddetallepedido+"&codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallespedidosagregar').load("funciones.php?MuestraDetallesPedidosAgregar=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Pedidos en este Módulo, realice la Eliminación completa del Pedido!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Pedidos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR PRESUPUESTOS 
function EliminarPedido(codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#pedidos').load("consultas.php?CargaPedidos=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Pedidos a Proveedores, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA PROCESAR PEDIDO
function ProcesaPedido(codpedido,codproveedor,nomproveedor,codsucursal) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#procesarpedido #codpedido").val(codpedido);
  $("#procesarpedido #codproveedor").val(codproveedor);
  $("#procesarpedido #codsucursal").val(codsucursal);
  $("#procesarpedido #nomproveedor").val(nomproveedor);
  //$("#procesarpedido").html("");
  $("#muestra_detalles").load("funciones.php?MuestraDetallesPedidos=si&codpedido="+codpedido+"&codsucursal="+codsucursal);
}

//FUNCION PARA LIMPIAR FORMULARIO DE PROCESAR PEDIDO
function LimpiarProcesaPedido() 
{
    $("#procesarpedido #proceso").val("procesar");
    $("#procesarpedido #codpedido").val("");
    $("#procesarpedido #codproveedor").val("");
    $("#procesarpedido #codsucursal").val("");
    $("#procesarpedido #codfactura").val("");
    $("#procesarpedido #fechaemision").val("");
    $("#procesarpedido #fecharecepcion").val("");
    $("#procesarpedido #nomproveedor").val("");
    $("#procesarpedido #tipocompra").val("");
    $("#procesarpedido #formacompra").val("");
    $("#procesarpedido #fechavencecredito").val("");
    $("#procesarpedido #gastoenvio").val("0.00");
    $("#procesarpedido #observaciones").val("");
    $("#procesarpedido #muestra_detalles").html("");
}


// FUNCION PARA CALCULAR DETALLES PEDIDOS EN PROCESAR
function PresionarDetallePedidoProcesado(item,indice){
    var cantidad = $('#cantidad_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantidad_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoPedidoProcesado(indice);
} 


// FUNCION PARA CALCULAR DETALLES PEDIDOS EN PROCESAR
function ProcesarCalculoPedidoProcesado(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var cantidadBD = $('#cantidadbd_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioconiva = $('#preciocompra_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descfactura_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantidad_"+indice).val(cantidadBD);
        $("#cantidad_"+indice).focus();
        $("#cantidad_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);
    
    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentoc_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");

    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0");

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(cantidad);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));
    //$('#lblsubtotal').text(Separador(SubTotal+BaseImpIva2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentoc').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));
}

/////FUNCION PARA ELIMINAR DETALLES DE PEDIDOS EN AGREGAR
function EliminarDetallesProcesarPedidos(coddetallepedido,codpedido,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle del Pedido?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepedido="+coddetallepedido+"&codpedido="+codpedido+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestra_detalles').load("funciones.php?MuestraDetallesPedidos=si&codpedido="+codpedido+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Pedidos en este Módulo, realice la Eliminación completa del Pedido!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Pedidos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE PEDIDOS POR PROVEEDOR
function BuscarPedidosxProveedor(){
                        
$('#muestrapedidosxproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codproveedor = $("#codproveedor").val();
var dataString = $("#pedidosxproveedor").serialize();
var url = 'funciones.php?BuscaPedidosxProvedores=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestrapedidosxproveedor').empty();
      $('#muestrapedidosxproveedor').append(''+response+'').fadeIn("slow");
    }
  });
}

// FUNCION PARA BUSQUEDA DE PEDIDOS POR FECHAS
function BuscarPedidosxFechas(){
                        
$('#muestrapedidosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#pedidosxfechas").serialize();
var url = 'funciones.php?BuscaPedidosxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestrapedidosxfechas').empty();
      $('#muestrapedidosxfechas').append(''+response+'').fadeIn("slow");
    }
  });
}











/////////////////////////////////// FUNCIONES DE PRODUCTOS //////////////////////////////////////

////FUNCION MUESTRA BOTON PRODUCTOS
function MostrarProductos(){
  
  $('#loading').load("familias_productos?CargarProductos=si");
}

//FUNCION PARA CALCULAR PRECIO VENTA
$(document).ready(function (){
    $('.calculoprecio').keyup(function (){
       
      var precio = $('input#preciocompra').val();
      var porcentaje = $('input#porcentaje').val()/100;

      //REALIZO EL CALCULO
      var calculo = parseFloat(precio)*parseFloat(porcentaje);
      precioventa = parseFloat(calculo)+parseFloat(precio);
      $("#precioventa").val((porcentaje == "0.00") ? "" : precioventa.toFixed(2));

  });
});

// FUNCION PARA MOSTRAR DIV DE CARGA MASIVA DE PRODUCTOS
function CargaDivProductos(){

$('#divproducto').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');
                
var dataString = 'BuscaDivProducto=si';

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#divproducto').empty();
            $('#divproducto').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA LIMPIAR DIV DE CARGA MASIVA DE PRODUCTOS
function ModalProducto(){
  $("#divproducto").html("");
}

// FUNCION PARA MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL
function VerFoto(codproducto,codsucursal){

$('#muestrafotomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaFotoProductoModal=si&codproducto='+codproducto+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
             $('#muestrafotomodal').empty();
            $('#muestrafotomodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA MOSTRAR PRODUCTOS EN VENTANA MODAL
function VerProducto(codproducto,codsucursal){

$('#muestraproductomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaProductoModal=si&codproducto='+codproducto+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestraproductomodal').empty();
             $('#muestraproductomodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ACTUALIZAR PRODUCTOS
function UpdateProducto(codproducto,codsucursal) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forproducto?codproducto="+codproducto+"&codsucursal="+codsucursal;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR PRODUCTOS 
function EliminarProducto(codproducto,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codproducto="+codproducto+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#productos').load("consultas.php?CargaProductos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Producto no puede ser Eliminado, tiene Ventas relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Productos, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS POR SUCURSAL
function BuscaProductosxSucursal(){

$('#muestra_productos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#productosxsucursal").serialize();
var url = 'consultas.php?BuscaProductosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_productos').empty();
            $('#muestra_productos').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS POR MONEDA
function BuscaProductosxMoneda(){
    
$('#muestraproductosxmoneda').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codmoneda = $("select#codmoneda").val();
var dataString = $("#productosxmoneda").serialize();
var url = 'funciones.php?BuscaProductoxMoneda=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestraproductosxmoneda').empty();
            $('#muestraproductosxmoneda').append(''+response+'').fadeIn("slow");
        }
    }); 
}


// FUNCION PARA CARGAR PRODUCTOS POR FAMILIAS EN VENTANA MODAL
function CargaProductos(){

$('#loadproductos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var dataString = "CargarProductos=si&url=modal";

$.ajax({
    type: "GET",
    url: "familias_productos.php",
    data: dataString,
        success: function(response) {            
            $('#loadproductos').empty();
            $('#loadproductos').append(''+response+'').fadeIn("slow");
        }
    });
}


// FUNCION PARA BUSQUEDA DE KARDEX POR PRODUCTOS
function BuscaKardexProducto(){

$('#muestrakardex').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codproducto = $("input#codproducto").val();
var dataString = $("#buscakardex").serialize();
var url = 'funciones.php?BuscaKardexProducto=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestrakardex').empty();
            $('#muestrakardex').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX PRODUCTOS VALORIZADO
function BuscaProductosValorizadoxSucursal(){
    
$('#muestrakardexvalorizado').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#kardexvalorizado").serialize();
var url = 'consultas.php?BuscaKardexProductosValorizadoxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestrakardexvalorizado').empty();
            $('#muestrakardexvalorizado').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS VALORIZADO POR FECHAS Y VENDEDOR
function BuscaProductosValorizadoxFechas(){
    
$('#muestravalorizadoxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#valorizadoxfechas").serialize();
var url = 'funciones.php?BuscaProductosValorizadoxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestravalorizadoxfechas').empty();
            $('#muestravalorizadoxfechas').append(''+response+'').fadeIn("slow");
        }
    }); 
}


// FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS
function BuscaProductosVendidos(){
    
$('#muestraproductosvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productosvendidos").serialize();
var url = 'funciones.php?BuscaProductosVendidos=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestraproductosvendidos').empty();
            $('#muestraproductosvendidos').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE PRODUCTOS VENDIDOS POR VENDEDOR
function BuscaProductosxVendedor(){
    
$('#muestraproductosxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#productosxvendedor").serialize();
var url = 'funciones.php?BuscaProductoxVendedor=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestraproductosxvendedor').empty();
            $('#muestraproductosxvendedor').append(''+response+'').fadeIn("slow");
        }
    }); 
}















/////////////////////////////////// FUNCIONES DE COMBOS //////////////////////////////////////

// FUNCION PARA CARGAR COMBOS POR PRODUCTOS EN VENTANA MODAL
function MostrarCombos(){
  
  $('#loading').load("familias_productos?CargarCombos=si");
}

// FUNCION PARA MOSTRAR FOTO DE COMBO EN VENTANA MODAL
function VerFotoCombo(codcombo,codsucursal){

$('#muestrafotomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaFotoComboModal=si&codcombo='+codcombo+"&codsucursal="+codsucursal;

$.ajax({
        type: "GET",
        url: "funciones.php",
        data: dataString,
        success: function(response) {            
            $('#muestrafotomodal').empty();
            $('#muestrafotomodal').append(''+response+'').fadeIn("slow");
        }
  });
}

// FUNCION PARA MOSTRAR COMBOS EN VENTANA MODAL
function VerCombo(codcombo,codsucursal){

$('#muestracombomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaComboModal=si&codcombo='+codcombo+"&codsucursal="+codsucursal;

$.ajax({
        type: "GET",
        url: "funciones.php",
        data: dataString,
        success: function(response) {            
            $('#muestracombomodal').empty();
            $('#muestracombomodal').append(''+response+'').fadeIn("slow");
            
        }
  });
}

// FUNCION PARA ACTUALIZAR COMBOS
function UpdateCombo(codcombo,codsucursal) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Combo?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcombo?codcombo="+codcombo+"&codsucursal="+codsucursal;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA AGREGAR PRODUCTOS A COMBOS
function AgregaProducto(codcombo,codsucursal) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Productos a este Combo?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "foragregaproductos?codcombo="+codcombo+"&codsucursal="+codsucursal;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLE DE PRODUCTOS 
function EliminaDetalleCombo(codcombo,idproducto,codproducto,cantidad,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Producto del Combo?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcombo="+codcombo+"&idproducto="+idproducto+"&codproducto="+codproducto+"&cantidad="+cantidad+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $("#productosxcombos").load("funciones.php?BuscaDetallesCombo=si&codcombo="+codcombo+"&codsucursal="+codsucursal);

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Productos Asociados a Combos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COMBOS 
function EliminarCombo(codcombo,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Combo?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcombo="+codcombo+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#combos').load("consultas.php?CargaCombos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Combo no puede ser Eliminado, tiene Ventas relacionadas!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Combos, no tienes los privilegios dentro del Sistema!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA CALCULAR DETALLES COMBOS EN ACTUALIZAR
function PresionarDetalleProducto(item,indice){
    var cantidad = $('#cantidad_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantidad_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoProducto(indice);
} 

// FUNCION PARA CALCULAR DETALLES PRODUCTOS EN ACTUALIZAR
function ProcesarCalculoProducto(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var cantidadBD = $('#cantidadbd_'+indice).val();
    var precioventa = $('#precioventadet_'+indice).val();
    var preciocompra = $('#preciocompradet_'+indice).val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantidad_"+indice).val(cantidadBD);
        $("#cantidad_"+indice).focus();
        $("#cantidad").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorCompra = parseFloat(cantidad) * parseFloat(preciocompra);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorVenta = parseFloat(cantidad) * parseFloat(precioventa);

    //CALCULO SUBTOTAL IVA SI
    $("#montocompra_"+indice).val(ValorCompra.toFixed(2));
    $("#txtmontocompra_"+indice).text(Separador(ValorCompra.toFixed(2)));
    //CALCULO SUBTOTAL IVA NO
    $("#montoventa_"+indice).val(ValorVenta.toFixed(2));
    $("#txtmontoventa_"+indice).text(Separador(ValorVenta.toFixed(2)));

    //CALCULO DE PRECIO COMPRA
    var MontoCompra=0;
    $('.preciocompradet').each(function() {  
    ($(this).val() != "0" ? MontoCompra += parseFloat($(this).val()) : MontoCompra);
    MontoCompra += ($(this).val() == "0" ? "0" : parseFloat($(this).val()));
    }); 
    $('#preciocompra').val(MontoCompra.toFixed(2));

    //CALCULO DE PRECIO VENTA
    var MontoVenta=0;
    $('.precioventadet').each(function() { 
    ($(this).val() != "0" ? MontoVenta += parseFloat($(this).val()) : MontoVenta);
    }); 
    $('#precioventa').val(MontoVenta.toFixed(2));
}

// FUNCION PARA BUSQUEDA DE COMBOS POR SUCURSAL
function BuscaCombosxSucursal(){

$('#muestracombos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#combosxsucursal").serialize();
var url = 'consultas.php?BuscaCombosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestracombos').empty();
            $('#muestracombos').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE COMBOS POR MONEDA
function BuscaCombosxMoneda(){
    
$('#muestracombosxmoneda').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codmoneda = $("select#codmoneda").val();
var dataString = $("#combosxmoneda").serialize();
var url = 'funciones.php?BuscaCombosxMoneda=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestracombosxmoneda').empty();
            $('#muestracombosxmoneda').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE KARDEX POR COMBOS
function BuscaKardexCombo(){

$('#muestrakardex').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcombo = $("#codcombo").val();
var dataString = $("#buscakardexcombos").serialize();
var url = 'funciones.php?BuscaKardexCombo=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestrakardex').empty();
            $('#muestrakardex').append(''+response+'').fadeIn("slow"); 
        }
    }); 
}


// FUNCION PARA BUSQUEDA DE KARDEX COMBOS VALORIZADO
function BuscaCombosValorizadoxSucursal(){
    
$('#muestrakardexvalorizado').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#kardexvalorizado").serialize();
var url = 'consultas.php?BuscaKardexCombosValorizadoxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestrakardexvalorizado').empty();
            $('#muestrakardexvalorizado').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE COMBOS VALORIZADO POR FECHAS Y VENDEDOR
function BuscaCombosValorizadoxFechas(){
    
$('#muestravalorizadoxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#valorizadoxfechas").serialize();
var url = 'funciones.php?BuscaCombosValorizadoxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestravalorizadoxfechas').empty();
            $('#muestravalorizadoxfechas').append(''+response+'').fadeIn("slow");
        }
    }); 
}


// FUNCION PARA BUSQUEDA DE COMBOS VENDIDOS
function BuscaCombosVendidos(){
    
$('#muestracombosvendidos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#combosvendidos").serialize();
var url = 'funciones.php?BuscaCombosVendidos=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestracombosvendidos').empty();
            $('#muestracombosvendidos').append(''+response+'').fadeIn("slow");       
        }
    }); 
}






















/////////////////////////////////// FUNCIONES DE TRASPASOS //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE TRASPASOS POR SUCURSAL
function BuscaTrapasosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#traspasosxsucursal").serialize();
var url = 'consultas.php?BuscaTrapasosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR SUCURSALES QUE RECIBEN TRASPASS
function CargaSucursal(envia){

$('#recibe').html('<center><img src="assets/images/loading.gif" width="30" height="30"/></center>');
                
var dataString = 'BuscaSucursalesRecibeTraspaso=si&envia='+envia;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#recibe').empty();
            $('#recibe').append(''+response+'').fadeIn("slow"); 
        }
    });
}

// FUNCION PARA MOSTRAR TRASPASOS EN VENTANA MODAL
function VerTraspaso(codtraspaso,codsucursal){

$('#muestratraspasomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaTraspasoModal=si&codtraspaso='+codtraspaso+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestratraspasomodal').empty();
            $('#muestratraspasomodal').append(''+response+'').fadeIn("slow");  
        }
    });
}

// FUNCION PARA ACTUALIZAR TRASPASOS
function UpdateTraspaso(codtraspaso,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Traspaso de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "fortraspaso?codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES TRASPASOS EN ACTUALIZAR
function PresionarDetalleTraspaso(item,indice){
    var cantidad = $('#cantidad_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantidad_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoTraspaso(indice);
} 

// FUNCION PARA CALCULAR DETALLES TRASPASOS EN ACTUALIZAR
function ProcesarCalculoTraspaso(indice){
    var cantidad = $('#cantidad_'+indice).val();
    var cantidadBD = $('#cantidadbd_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var precioconiva = $('#precioconiva_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantidad_"+indice).val(cantidadBD);
        $("#cantidad_"+indice).focus();
        $("#cantidad_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(cantidad);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    ($(this).val() != "0" ? NetoCompra += parseFloat($(this).val()) : NetoCompra);
    });

   //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(TotalFactura.toFixed(2));
}


// FUNCION PARA AGREGAR DETALLES A TRASPASOS
function AgregaDetalleTraspaso(codtraspaso,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a este Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "fortraspaso?codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN VENTANA MODAL
function EliminarDetalleTraspasoModal(coddetalletraspaso,codtraspaso,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestratraspasomodal').load("funciones.php?BuscaTraspasoModal=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
            $('#traspasos').load("consultas.php?CargaTraspasos=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN ACTUALIZAR
function EliminarDetalleTraspasoUpdate(coddetalletraspaso,codtraspaso,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallestraspasoupdate').load("funciones.php?MuestraDetallesTraspasoUpdate=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE TRASPASOS EN AGREGAR
function EliminarDetalleTraspasoAgregar(coddetalletraspaso,codtraspaso,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalletraspaso="+coddetalletraspaso+"&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallestraspasosagregar').load("funciones.php?MuestraDetallesTrapasoAgregar=si&codtraspaso="+codtraspaso+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Traspasos en este Módulo, realice la Eliminación completa del Traspaso!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Traspasos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR TRASPASOS 
function EliminarTraspaso(codtraspaso,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Traspaso?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codtraspaso="+codtraspaso+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#traspasos').load("consultas.php?CargaTraspasos=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Traspasos de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA PROCESAR TRASPASOS
function ProcesarTraspaso(codtraspaso,codsucursal,codfactura,nombre_sucursal,nombre_encargado,fechatraspaso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#procesartraspaso #codtraspaso").val(codtraspaso);
  $("#procesartraspaso #codsucursal").val(codsucursal);
  $("#procesartraspaso #codfactura").val(codfactura);
  $("#procesartraspaso #nombre_sucursal").val(nombre_sucursal);
  $("#procesartraspaso #nombre_encargado").val(nombre_encargado);
  $("#procesartraspaso #fechatraspaso").val(fechatraspaso);
}

// FUNCION PARA BUSQUEDA DE TRASPASOS POR FECHAS
function BuscarTraspasosxFechas(){
                        
$('#muestratraspasosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#traspasosxfechas").serialize();
var url = 'funciones.php?BuscaTraspasosxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestratraspasosxfechas').empty();
            $('#muestratraspasosxfechas').append(''+response+'').fadeIn("slow");
        }
    });
}


// FUNCION PARA BUSQUEDA DE DETALLES TRASPASOS POR FECHAS
function BuscaDetallesTraspasosxFechas(){
    
$('#muestradetallestraspasosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallestraspasosxfechas").serialize();
var url = 'funciones.php?BuscaDetallesTraspasosxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestradetallestraspasosxfechas').empty();
            $('#muestradetallestraspasosxfechas').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE TRACKING
function BuscaTracking(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var tracking = $("#tracking").val();
var dataString = $("#search_tracking").serialize();
var url = 'detalles_tracking.php?MuestraDetallesTracking=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}














/////////////////////////////////// FUNCIONES DE COMPRAS //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE COMPRAS POR SUCURSAL
function BuscaComprasxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#comprasxsucursal").serialize();
var url = 'consultas.php?BuscaComprasxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSCAR COMPRAS PAGADAS
function BuscarCompras(){
                        
$('#muestracompras').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcompras").val();
var dataString = $("#busquedacompras").serialize();
var url = 'consultas.php?CargaCompras=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracompras').empty();
        $('#muestracompras').append(''+response+'').fadeIn("slow");
      }
  });
}


// FUNCION PARA BUSQUEDA DE CUENTAS X PAGAR POR SUCURSAL
function BuscaCuentasxPagarxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#cuentasxpagarxsucursal").serialize();
var url = 'consultas.php?BuscaCuentasxPagarxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSCAR CUENTAS X PAGAR
function BuscarCuentasxPagar(){
                        
$('#muestracuentasxpagar').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcompras").val();
var dataString = $("#busquedacuentasxpagar").serialize();
var url = 'consultas.php?CargaCuentasxPagar=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracuentasxpagar').empty();
        $('#muestracuentasxpagar').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR COMPRA PAGADA EN VENTANA MODAL
function VerCompraPagada(codcompra,codsucursal){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPagadaModal=si&codcompra='+codcompra+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestracompramodal').empty();
            $('#muestracompramodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL
function VerCompraPendiente(codcompra,codsucursal){

$('#muestracompramodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCompraPendienteModal=si&codcompra='+codcompra+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestracompramodal').empty();
            $('#muestracompramodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ACTUALIZAR COMPRAS
function UpdateCompra(codcompra,codsucursal,proceso,status) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Compra de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcompra?codcompra="+codcompra+"&codsucursal="+codsucursal+"&proceso="+proceso+"&status="+status;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES COMPRAS EN ACTUALIZAR
function PresionarDetalleCompra(item,indice){
    var cantidad = $('#cantcompra_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantcompra_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoCompra(indice);
} 

// FUNCION PARA CALCULAR DETALLES COMPRAS EN ACTUALIZAR
function ProcesarCalculoCompra(indice){
    var cantidad = $('#cantcompra_'+indice).val();
    var cantidadBD = $('#cantidadcomprabd_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioconiva = $('#precioconiva_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descfactura_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantcompra_"+indice).val(cantidadBD);
        $("#cantcompra_"+indice).focus();
        $("#cantcompra_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }
    
    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);
    
    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentoc_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");

    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0");

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(cantidad);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));
    //$('#lblsubtotal').text(Separador(SubTotal+BaseImpIva2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentoc').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));
}


// FUNCION PARA AGREGAR DETALLES A COMPRAS
function AgregaDetalleCompra(codcompra,codsucursal,proceso,status) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
        location.href = "forcompra?codcompra="+codcompra+"&codsucursal="+codsucursal+"&proceso="+proceso+"&status="+status;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA ABONAR PAGO DE CREDITOS DE COMPRAS
function AbonoCreditoCompra(codcompra,codfactura,codsucursal,codproveedor,cuitproveedor,nomproveedor,totalfactura,fechaemision,totaldebe,totalabono) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savepagocompra #codcompra").val(codcompra);
  $("#savepagocompra #codfactura").val(codfactura);
  $("#savepagocompra #codsucursal").val(codsucursal);
  $("#savepagocompra #codproveedor").val(codproveedor);
  $("#savepagocompra #cuitproveedor").val(cuitproveedor);
  $("#savepagocompra #nomproveedor").val(nomproveedor);
  $("#savepagocompra #totalfactura").val(totalfactura);
  $("#savepagocompra #fechaemision").val(fechaemision);
  $("#savepagocompra #totaldebe").val(totaldebe);
  $("#savepagocompra #debe").val(totaldebe);
  $("#savepagocompra #totalabono").val(totalabono);
  $("#savepagocompra #abono").val(totalabono);
}


/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PAGADAS EN VENTANA MODAL
function EliminarDetallesComprasPagadasModal(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPagadaModal=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
            $("#BotonBusqueda").trigger("click");

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS PENDIENTES EN VENTANA MODAL
function EliminarDetallesComprasPendientesModal(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestracompramodal').load("funciones.php?BuscaCompraPendienteModal=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
            $("#BotonBusqueda").trigger("click");

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS EN ACTUALIZAR
function EliminarDetallesComprasUpdate(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallescomprasupdate').load("funciones.php?MuestraDetallesComprasUpdate=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COMPRAS EN AGREGAR
function EliminarDetallesComprasAgregar(coddetallecompra,codcompra,codproveedor,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecompra="+coddetallecompra+"&codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallescomprasagregar').load("funciones.php?MuestraDetallesComprasAgregar=si&codcompra="+codcompra+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Compras en este Módulo, realice la Eliminación completa de la Compra!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Compras, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COMPRAS 
function EliminarCompra(codcompra,codproveedor,codsucursal,status,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Compra?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcompra="+codcompra+"&codproveedor="+codproveedor+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $("#BotonBusqueda").trigger("click");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Compras de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

// FUNCION PARA BUSQUEDA DE COMPRAS POR PROVEEDORES
function BuscarComprasxProveedores(){
                        
$('#muestracomprasxproveedores').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codproveedor = $("select#codproveedor").val();
var dataString = $("#comprasxproveedores").serialize();
var url = 'funciones.php?BuscaComprasxProvedores=si';


$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestracomprasxproveedores').empty();
        $('#muestracomprasxproveedores').append(''+response+'').fadeIn("slow");
     }
  });
}


// FUNCION PARA BUSQUEDA DE COMPRAS POR FECHAS
function BuscarComprasxFechas(){
                        
$('#muestracomprasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#comprasxfechas").serialize();
var url = 'funciones.php?BuscaComprasxFechas=si';


$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestracomprasxfechas').empty();
        $('#muestracomprasxfechas').append(''+response+'').fadeIn("slow");
     }
  });
}

//FUNCION PARA BUSQUEDA DE COMPRAS POR CONDICION DE PAGO Y FECHAS
function BuscarAbonosCreditosComprasxFechas(){
                  
$('#muestradetallesabonos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
//var codbanco = $("select#codbanco").val();
var formapago = $("select#formapago").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#abonoscreditoscomprasxfechas").serialize();
var url = 'funciones.php?BuscaAbonosCreditosComprasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestradetallesabonos').empty();
      $('#muestradetallesabonos').append(''+response+'').fadeIn("slow");
    }
  }); 
}


//FUNCION PARA BUSQUEDA DE CREDITOS DE COMPRAS POR PROVEEDOR Y FECHAS
function BuscarCreditosComprasxProveedor(){
                  
$('#muestracreditosxproveedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var status = $('input:radio[name=status]:checked').val();
var codproveedor = $("#codproveedor").val();
var dataString = $("#creditoscomprasxproveedor").serialize();
var url = 'funciones.php?BuscaCreditosComprasxProveedor=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestracreditosxproveedor').empty();
        $('#muestracreditosxproveedor').append(''+response+'').fadeIn("slow");
       }
  }); 
}

// FUNCION PARA BUSQUEDA DE CREDITOS DE COMPRAS POR FECHAS
function BuscarCreditosComprasxFechas(){
                        
$('#muestracreditoscomprasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var status = $('input:radio[name=status]:checked').val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditoscomprasxfechas").serialize();
var url = 'funciones.php?BuscaCreditosComprasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestracreditoscomprasxfechas').empty();
        $('#muestracreditoscomprasxfechas').append(''+response+'').fadeIn("slow");
     }
  });
}

// FUNCION PARA BUSQUEDA DE CREDITOS POR DETALLES
function BuscarDetallesCreditosComprasxProveedor(){
                        
$('#muestradetallescreditos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var status = $('input:radio[name=status]:checked').val();
var codproveedor = $("#codproveedor").val();
var dataString = $("#detallescreditoscomprasxproveedor").serialize();
var url = 'funciones.php?BuscaDetallesCreditosComprasxProveedor=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestradetallescreditos').empty();
        $('#muestradetallescreditos').append(''+response+'').fadeIn("slow");
     }
  });
}


//FUNCION PARA BUSQUEDA DE DETALLES DE CREDITOS POR FECHAS
function BuscarDetallesCreditosComprasxFechas(){
                  
$('#muestradetallescreditos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var status = $('input:radio[name=status]:checked').val();              
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallescreditoscomprasxfechas").serialize();
var url = 'funciones.php?BuscaDetallesCreditosComprasxFechas=si';

$.ajax({
  type: "GET",
  url: url,
  data: dataString,
    success: function(response) {            
    $('#muestradetallescreditos').empty();
    $('#muestradetallescreditos').append(''+response+'').fadeIn("slow");        
    }
  }); 
}





















/////////////////////////////////// FUNCIONES DE COTIZACIONES //////////////////////////////////////


// FUNCION PARA BUSQUEDA DE COTIZACIONES POR SUCURSAL
function BuscaCotizacionesxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#cotizacionesxsucursal").serialize();
var url = 'consultas.php?BuscaCotizacionesxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSCAR COTIZACIONES
function BuscarCotizaciones(){
                        
$('#muestracotizaciones').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bcotizaciones").val();
var dataString = $("#busquedacotizaciones").serialize();
var url = 'consultas.php?CargaCotizaciones=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
      success: function(response) {            
        $('#muestracotizaciones').empty();
        $('#muestracotizaciones').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA MOSTRAR COTIZACIONES EN VENTANA MODAL
function VerCotizacion(codcotizacion,codsucursal){

$('#muestracotizacionmodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCotizacionModal=si&codcotizacion='+codcotizacion+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestracotizacionmodal').empty();
            $('#muestracotizacionmodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA CARGAR DATOS DE COTIZACION
function ProcesaCotizacion(codcotizacion,codsucursal,codcliente,nrodocumento,busqueda,nombres,limitecredito,totalpago) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#procesarcotizacion #codcotizacion").val(codcotizacion);
  $("#procesarcotizacion #codsucursal").val(codsucursal);
  $("#procesarcotizacion #codcliente").val(codcliente);
  $("#procesarcotizacion #nrodocumento").val(nrodocumento);
  $("#procesarcotizacion #busqueda").val(busqueda);
  $("#procesarcotizacion #TextCliente").text(nombres);
  $("#procesarcotizacion #TextCredito").text(limitecredito);
  $("#procesarcotizacion #txtTotal").val(totalpago);
  $("#procesarcotizacion #txtPagado").val(totalpago);
  $("#procesarcotizacion #TextImporte").text(totalpago);
  $("#procesarcotizacion #montopagado").val(totalpago);
}


// FUNCION PARA ACTUALIZAR COTIZACIONES
function UpdateCotizacion(codcotizacion,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Cotización de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcotizacion?codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function PresionarDetalleCotizacion(item,indice){
    var cantidad = $('#cantcotizacion_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantcotizacion_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoCotizacion(indice);
} 

// FUNCION PARA CALCULAR DETALLES COTIZACIONES EN ACTUALIZAR
function ProcesarCalculoCotizacion(indice){
    var cantidad = $('#cantcotizacion_'+indice).val();
    var cantidadBD = $('#cantcotizacionbd_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var precioconiva = $('#precioconiva_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantcotizacion_"+indice).val(cantidadBD);
        $("#cantcotizacion_"+indice).focus();
        $("#cantcotizacion_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(cantidad);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    ($(this).val() != "0" ? NetoCompra += parseFloat($(this).val()) : NetoCompra);
    });

   //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() { 
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));
    //$('#lblsubtotal').text(Separador(SubTotal+BaseImpIva2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));
}


// FUNCION PARA AGREGAR DETALLES A COTIZACIONES
function AgregaDetalleCotizacion(codcotizacion,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcotizacion?codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN VENTANA MODAL
function EliminarDetallesCotizacionModal(coddetallecotizacion,codcotizacion,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestracotizacionmodal').load("funciones.php?BuscaCotizacionModal=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
            $("#BotonBusqueda").trigger("click");

          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN ACTUALIZAR
function EliminarDetallesCotizacionesUpdate(coddetallecotizacion,codcotizacion,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallescotizacionesupdate').load("funciones.php?MuestraDetallesCotizacionesUpdate=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE COTIZACIONES EN AGREGAR
function EliminarDetallesCotizacionesAgregar(coddetallecotizacion,codcotizacion,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallecotizacion="+coddetallecotizacion+"&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallescotizacionesagregar').load("funciones.php?MuestraDetallesCotizacionesAgregar=si&codcotizacion="+codcotizacion+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Cotizaciones en este Módulo, realice la Eliminación completa de la Cotización!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Cotizaciones, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR COTIZACIONES 
function EliminarCotizacion(codcotizacion,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Cotización?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcotizacion="+codcotizacion+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $("#BotonBusqueda").trigger("click");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cotizaciones de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE COTIZACIONES POR FECHAS
function BuscarCotizacionesxFechas(){
                        
$('#muestracotizacionesxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#cotizacionesxfechas").serialize();
var url = 'funciones.php?BuscaCotizacionesxFechas=si';


$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestracotizacionesxfechas').empty();
            $('#muestracotizacionesxfechas').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA BUSQUEDA DE DETALLES COTIZACIONES X FECHAS
function BuscaDetallesCotizacionesxFechas(){
    
$('#muestradetallescotizacionesxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallescotizacionesxfechas").serialize();
var url = 'funciones.php?BuscaDetallesCotizacionesxFechas=si';

    $.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestradetallescotizacionesxfechas').empty();
            $('#muestradetallescotizacionesxfechas').append(''+response+'').fadeIn("slow");
        }
    }); 
}


// FUNCION PARA BUSQUEDA DE DETALLES COTIZACIONES X VENDEDOR
function BuscaDetallesCotizacionesxVendedor(){
    
$('#muestradetallescotizacionesxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallescotizacionesxvendedor").serialize();
var url = 'funciones.php?BuscaDetallesCotizacionesxVendedor=si';

    $.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestradetallescotizacionesxvendedor').empty();
            $('#muestradetallescotizacionesxvendedor').append(''+response+'').fadeIn("slow");
        }
    }); 
}






















/////////////////////////////////// FUNCIONES DE PREVENTAS //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE PREVENTAS POR SUCURSAL
function BuscaPreventasxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#preventasxsucursal").serialize();
var url = 'consultas.php?BuscaPreventasxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR PREVENTAS EN VENTANA MODAL
function VerPreventa(codpreventa,codsucursal){

$('#muestrapreventamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaPreventaModal=si&codpreventa='+codpreventa+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestrapreventamodal').empty();
            $('#muestrapreventamodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA CARGAR DATOS DE PREVENTAS
function ProcesaPreventa(codpreventa,codsucursal,codcliente,nrodocumento,busqueda,nombres,limitecredito,totalpago) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#procesarpreventa #codpreventa").val(codpreventa);
  $("#procesarpreventa #codsucursal").val(codsucursal);
  $("#procesarpreventa #codcliente").val(codcliente);
  $("#procesarpreventa #nrodocumento").val(nrodocumento);
  $("#procesarpreventa #busqueda").val(busqueda);
  $("#procesarpreventa #TextCliente").text(nombres);
  $("#procesarpreventa #TextCredito").text(limitecredito);
  $("#procesarpreventa #txtTotal").val(totalpago);
  $("#procesarpreventa #txtPagado").val(totalpago);
  $("#procesarpreventa #TextImporte").text(totalpago);
  $("#procesarpreventa #montopagado").val(totalpago);
}


// FUNCION PARA ACTUALIZAR PREVENTAS
function UpdatePreventa(codpreventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Preventa de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpreventa?codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES PREVENTAS EN ACTUALIZAR
function PresionarDetallePreventa(item,indice){
    var cantidad = $('#cantpreventa_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantpreventa_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoPreventa(indice);
} 

// FUNCION PARA CALCULAR DETALLES PREVENTAS EN ACTUALIZAR
function ProcesarCalculoPreventa(indice){
    var cantidad = $('#cantpreventa_'+indice).val();
    var cantidadBD = $('#cantpreventabd_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var precioconiva = $('#precioconiva_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantpreventa_"+indice).val(cantidadBD);
        $("#cantpreventa_"+indice).focus();
        $("#cantpreventa_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(cantidad);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    ($(this).val() != "0" ? NetoCompra += parseFloat($(this).val()) : NetoCompra);
    });

   //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));
    //$('#lblsubtotal').text(Separador(SubTotal+BaseImpIva2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));
}

// FUNCION PARA AGREGAR DETALLES A PREVENTAS
function AgregaDetallePreventa(codpreventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forpreventa?codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE PREVENTAS EN VENTANA MODAL
function EliminarDetallesPreventaModal(coddetallepreventa,codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepreventa="+coddetallepreventa+"&codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestrapreventamodal').load("funciones.php?BuscaPreventaModal=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal); 
            $('#preventas').load("consultas.php?CargaPreventas=si");    
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Preventas en este Módulo, realice la Eliminación completa de la Preventa!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Preventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE PREVENTAS EN ACTUALIZAR
function EliminarDetallesPreventasUpdate(coddetallepreventa,codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepreventa="+coddetallepreventa+"&codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallespreventasupdate').load("funciones.php?MuestraDetallesPreventasUpdate=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Preventas en este Módulo, realice la Eliminación completa de la Preventa!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Preventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE PREVENTAS EN AGREGAR
function EliminarDetallesPreventasAgregar(coddetallepreventa,codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetallepreventa="+coddetallepreventa+"&codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallespreventasagregar').load("funciones.php?MuestraDetallesPreventasAgregar=si&codpreventa="+codpreventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Preventas en este Módulo, realice la Eliminación completa de la Preventa!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Preventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR PREVENTAS 
function EliminarPreventa(codpreventa,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Preventa?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codpreventa="+codpreventa+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#preventas').load("consultas.php?CargaPreventas=si");
                  
          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Preventas de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA BUSQUEDA DE PREVENTAS POR FECHAS
function BuscarPreventasxFechas(){
                        
$('#muestrapreventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#preventasxfechas").serialize();
var url = 'funciones.php?BuscaPreventasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestrapreventasxfechas').empty();
        $('#muestrapreventasxfechas').append(''+response+'').fadeIn("slow");
      }
  });
}

// FUNCION PARA BUSQUEDA DE DETALLES PREVENTAS X FECHAS
function BuscaDetallesPreventasxFechas(){
    
$('#muestradetallespreventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallespreventasxfechas").serialize();
var url = 'funciones.php?BuscaDetallesPreventasxFechas=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallespreventasxfechas').empty();
                $('#muestradetallespreventasxfechas').append(''+response+'').fadeIn("slow");
            }
      }); 
}


// FUNCION PARA BUSQUEDA DE DETALLES PREVENTAS X VENDEDOR
function BuscaDetallesPreventasxVendedor(){
    
$('#muestradetallespreventasxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallespreventasxvendedor").serialize();
var url = 'funciones.php?BuscaDetallesPreventasxVendedor=si';

        $.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {
                $('#muestradetallespreventasxvendedor').empty();
                $('#muestradetallespreventasxvendedor').append(''+response+'').fadeIn("slow");
            }
      }); 
}












/////////////////////////////////// FUNCIONES DE CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA ASIGNA SUCURSAL A CAJA
function AgregaSucursalxCaja(codsucursal) 
{
   // aqui asigno cada valor a los campos correspondientes
   $("#savecaja #codsucursal").val(codsucursal);
}

// FUNCION PARA BUSQUEDA DE CAJAS POR SUCURSAL
function BuscaCajasxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#cajasxsucursal").serialize();
var url = 'consultas.php?BuscaCajasxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR CAJAS DE VENTAS EN VENTANA MODAL
function VerCaja(codcaja){

$('#muestracajamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCajaModal=si&codcaja='+codcaja;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestracajamodal').empty();
            $('#muestracajamodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ACTUALIZAR CAJAS DE VENTAS
function UpdateCaja(codsucursal,codcaja,nrocaja,nomcaja,codigo,proceso) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savecaja #codsucursal").val(codsucursal);
  $("#savecaja #codcaja").val(codcaja);
  $("#savecaja #nrocaja").val(nrocaja);
  $("#savecaja #nomcaja").val(nomcaja);
  $("#savecaja #codigo").val(codigo);
  $("#savecaja #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR CAJAS DE VENTAS 
function EliminarCaja(codcaja,tipousuario,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Caja para Ventas?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codcaja="+codcaja+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            if(tipousuario == 1){
                $("#BotonBusqueda").trigger("click"); 
            } else {
                $('#cajas').load("consultas.php?CargaCajas=si");   
            }
            $("#savecaja")[0].reset();
                  
          } else if(data==2){ 

             swal("Oops", "Esta Caja para Venta no puede ser Eliminada, tiene Ventas relacionados!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Cajas para Ventas, no eres el Administrador del Sistema!", "error"); 

                }
            }
        })
    });
}


// FUNCION PARA MOSTRAR CAJAS POR SUCURSAL
function CargaCajas(codsucursal){

$('#codcaja').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var dataString = 'BuscaCajasxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codcaja').empty();
                $('#codcaja').append(''+response+'').fadeIn("slow");
           }
      });
}


// FUNCION PARA MOSTRAR CAJAS POR SUCURSAL
function CargaCajasAbiertas(codsucursal){

$('#codcaja').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var dataString = 'BuscaCajasAbiertasxSucursal=si&codsucursal='+codsucursal;

$.ajax({
            type: "GET",
            url: "funciones.php",
            data: dataString,
            success: function(response) {            
                $('#codcaja').empty();
                $('#codcaja').append(''+response+'').fadeIn("slow");
           }
      });
}

















/////////////////////////////////// FUNCIONES DE ARQUEOS DE CAJAS PARA VENTAS //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR SUCURSAL
function BuscaArqueosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#arqueosxsucursal").serialize();
var url = 'consultas.php?BuscaArqueosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR ARQUEOS DE CAJAS PARA VENTAS EN VENTANA MODAL
function VerArqueo(codarqueo){

$('#muestraarqueomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaArqueoModal=si&codarqueo='+codarqueo;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestraarqueomodal').empty();
            $('#muestraarqueomodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA CERRAR ARQUEO DE CAJA
function CerrarArqueo(codarqueo,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Realizar el Cierre de Caja?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcierre?codarqueo="+codarqueo+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CERRAR ARQUEO DE CAJA
function ActualizarArqueo(codarqueo,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar este Arqueo de Caja?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forcierre?codarqueo="+codarqueo+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

//FUNCION PARA CALCULAR LA DIFERENCIA EN CIERRE DE CAJA
$(document).ready(function (){
  $('.cierrecaja').keyup(function (){
      
    var efectivo = $('input#dineroefectivo').val();
    var efectivocaja = $('input#efectivocaja').val();
            
    //REALIZO EL CALCULO Y MUESTRO LA DEVOLUCION
    total = parseFloat(efectivo - efectivocaja);
    var original = parseFloat(total.toFixed(2));
    $("#diferencia").val(original.toFixed(2));
      
  });
});


//FUNCION PARA BUSQUEDA DE ARQUEOS DE CAJAS POR FECHAS PARA REPORTES
function BuscarArqueosxFechas(){
                  
$('#muestraarqueosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#arqueosxfechas").serialize();
var url = 'funciones.php?BuscaArqueosxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestraarqueosxfechas').empty();
            $('#muestraarqueosxfechas').append(''+response+'').fadeIn("slow");
        }
    }); 
}


// FUNCION PARA BUSQUEDA DE GANANCIAS POR FECHAS
function BuscarGananciasxFechas(){
                        
$('#muestragananciasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#gananciasxfechas").serialize();
var url = 'funciones.php?BuscaGananciasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestragananciasxfechas').empty();
      $('#muestragananciasxfechas').append(''+response+'').fadeIn("slow");
    }
  });
}













/////////////////////////////////// FUNCIONES DE MOVIMIENTOS EN CAJAS DE VENTAS //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE MOVIMIENTO DE CAJAS POR SUCURSAL
function BuscaMovimientosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#movimientosxsucursal").serialize();
var url = 'consultas.php?BuscaMovimientosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR MOVIMIENTO EN CAJAS DE VENTAS EN VENTANA MODAL
function VerMovimiento(numero,codsucursal){

$('#muestramovimientomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaMovimientoModal=si&numero='+numero+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestramovimientomodal').empty();
            $('#muestramovimientomodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ACTUALIZAR MOVIMIENTOS EN CAJAS DE VENTAS
function UpdateMovimiento(codmovimiento,numero,codarqueo,tipomovimiento,descripcionmovimiento,montomovimiento,codmediopago,fechamovimiento,codsucursal,proceso) 
{
    // aqui asigno cada valor a los campos correspondientes
  $("#savemovimiento #codmovimiento").val(codmovimiento);
  $("#savemovimiento #numero").val(numero);
  $("#savemovimiento #codarqueo").val(codarqueo);
  $("#savemovimiento #tipomovimiento").val(tipomovimiento);
  $("#savemovimiento #tipomovimientobd").val(tipomovimiento);
  $("#savemovimiento #descripcionmovimiento").val(descripcionmovimiento);
  $("#savemovimiento #montomovimiento").val(montomovimiento);
  $("#savemovimiento #montomovimientobd").val(montomovimiento);
  $("#savemovimiento #codmediopago").val(codmediopago);
  $("#savemovimiento #codmediopagobd").val(codmediopago);
  $("#savemovimiento #fecharegistro").val(fechamovimiento);
  $("#savemovimiento #codsucursal").val(codsucursal);
  $("#savemovimiento #proceso").val(proceso);
}

/////FUNCION PARA ELIMINAR MOVIMIENTOS EN CAJAS DE VENTAS 
function EliminarMovimiento(codmovimiento,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Movimiento en Caja para Ventas?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codmovimiento="+codmovimiento+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#movimientos').load("consultas?CargaMovimientos=si");
                  
          } else if(data==2){ 

             swal("Oops", "Este Movimiento en Caja para Venta no puede ser Eliminado, se encuentra Desactivado!", "error"); 

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Movimiento en Cajas para Ventas, no eres el Administrador de Sucursal o Cajero del Sistema!", "error"); 

                }
            }
        })
    });
}

//FUNCION PARA BUSQUEDA DE MOVIMIENTOS DE CAJAS POR FECHAS PARA REPORTES
function BuscarMovimientosxFechas(){
                  
$('#muestramovimientosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#movimientosxfechas").serialize();
var url = 'funciones.php?BuscaMovimientosxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestramovimientosxfechas').empty();
            $('#muestramovimientosxfechas').append(''+response+'').fadeIn("slow");
        }
    }); 
}

























/////////////////////////////////// FUNCIONES DE VENTAS //////////////////////////////////////

// FUNCION PARA CERRA CAJA EN VENTA
function CerrarCaja(){

$('#cierrecaja').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = "MuestraCajaVenta=si";

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#cierrecaja').empty();
            $('#cierrecaja').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA BUSQUEDA DE VENTAS POR SUCURSAL
function BuscaVentasxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#ventasxsucursal").serialize();
var url = 'consultas.php?BuscaVentasxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSCAR VENTAS
function BuscarVentas(){
                        
$('#muestraventas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var search = $("#bventas").val();
var dataString = $("#busquedaventas").serialize();
var url = 'consultas.php?CargaVentas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestraventas').empty();
            $('#muestraventas').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA MOSTRAR VENTAS EN VENTANA MODAL
function VerVenta(codventa,codsucursal){

$('#muestraventamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaVentaModal=si&codventa='+codventa+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestraventamodal').empty();
            $('#muestraventamodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ACTUALIZAR VENTAS
function UpdateVenta(codventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Actualizar esta Venta de Producto?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Actualizar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forventa?codventa="+codventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}

// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function PresionarDetalleVenta(item,indice){
    var cantidad = $('#cantventa_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#cantventa_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoVenta(indice);
} 

// FUNCION PARA CALCULAR DETALLES VENTAS EN ACTUALIZAR
function ProcesarCalculoVenta(indice){
    var cantidad = $('#cantventa_'+indice).val();
    var cantidadBD = $('#cantidadventabd_'+indice).val();
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var precioconiva = $('#precioconiva_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;

    if (cantidad == "" || cantidad == 0 || cantidad == 0.00 || cantidad < 0) {

        $("#cantventa_"+indice).val(cantidadBD);
        $("#cantventa_"+indice).focus();
        $("#cantventa_"+indice).css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VÁLIDA!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(cantidad) * parseFloat(precioventa);

    //REALIZAMOS LA MULTIPLICACION DE PRECIO COMPRA * CANTIDAD
    var ValorTotal2 = parseFloat(cantidad) * parseFloat(preciocompra);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO VALOR NETO 2
    $("#valorneto2_"+indice).val(ValorTotal2.toFixed(2));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(cantidad);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE VALOR NETO PARA COMPRAS
    var NetoCompra=0;
    $('.valorneto2').each(function() {  
    ($(this).val() != "0" ? NetoCompra += parseFloat($(this).val()) : NetoCompra);
    });

   //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));
    //$('#lblsubtotal').text(Separador(SubTotal+BaseImpIva2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#txtTotalCompra').val(NetoCompra.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));
}

// FUNCION PARA AGREGAR DETALLES A VENTAS
function AgregaDetalleVenta(codventa,codsucursal,proceso) {

  swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Agregar Detalles de Productos a esta Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Continuar",
          confirmButtonColor: "#3085d6"
        }, function(isConfirm) {
    if (isConfirm) {
      location.href = "forventa?codventa="+codventa+"&codsucursal="+codsucursal+"&proceso="+proceso;
      // handle confirm
    } else {
      // handle all other cases
    }
  })
}


/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN VENTANA MODAL
function EliminarDetallesVentaModal(coddetalleventa,codventa,codcliente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#muestraventamodal').load("funciones.php?BuscaVentaModal=si&codventa="+codventa+"&codsucursal="+codsucursal); 
            $("#BotonBusqueda").trigger("click");
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN ACTUALIZAR
function EliminarDetallesVentaUpdate(coddetalleventa,codventa,codcliente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallesventasupdate').load("funciones.php?MuestraDetallesVentasUpdate=si&codventa="+codventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR DETALLES DE VENTAS EN AGREGAR
function EliminarDetallesVentaAgregar(coddetalleventa,codventa,codcliente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar este Detalle de Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "coddetalleventa="+coddetalleventa+"&codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $('#detallesventasagregar').load("funciones.php?MuestraDetallesVentasAgregar=si&codventa="+codventa+"&codsucursal="+codsucursal); 
          
          } else if(data==2){ 

             swal("Oops", "No puede Eliminar todos los Detalles de Ventas en este Módulo, realice la Eliminación completa de la Venta!", "error"); 

          } else { 

             swal("Oops", "No tiene Acceso para Eliminar Detalles de Ventas, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}

/////FUNCION PARA ELIMINAR VENTAS 
function EliminarVenta(codventa,codcliente,codsucursal,tipo) {
        swal({
          title: "¿Estás seguro?", 
          text: "¿Estás seguro de Eliminar esta Venta?", 
          type: "warning",
          showCancelButton: true,
          cancelButtonText: "Cancelar",
          cancelButtonColor: '#d33',
          closeOnConfirm: false,
          confirmButtonText: "Eliminar",
          confirmButtonColor: "#3085d6"
        }, function() {
             $.ajax({
                  type: "GET",
                  url: "eliminar.php",
                  data: "codventa="+codventa+"&codcliente="+codcliente+"&codsucursal="+codsucursal+"&tipo="+tipo,
                  success: function(data){

          if(data==1){

            swal("Eliminado!", "Los Datos han sido eliminados con éxito!", "success");
            $("#BotonBusqueda").trigger("click");

          } else { 

             swal("Oops", "Usted no tiene Acceso para Eliminar Ventas de Productos, no eres el Administrador de Sucursal!", "error"); 

                }
            }
        })
    });
}


//FUNCION PARA BUSQUEDA DE VENTAS POR CAJAS Y FECHAS
function BuscarVentasxCajas(){
                  
$('#muestraventasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var tipopago = $('input:radio[name=tipopago]:checked').val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxcajas").serialize();
var url = 'funciones.php?BuscaVentasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestraventasxcajas').empty();
            $('#muestraventasxcajas').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE VENTAS POR FECHAS
function BuscarVentasxFechas(){
                        
$('#muestraventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var tipopago = $('input:radio[name=tipopago]:checked').val();                
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxfechas").serialize();
var url = 'funciones.php?BuscaVentasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestraventasxfechas').empty();
            $('#muestraventasxfechas').append(''+response+'').fadeIn("slow");
        }
    });
}

//FUNCION PARA BUSQUEDA DE VENTAS POR CLIENTES Y FECHAS
function BuscarVentasxClientes(){
                  
$('#muestraventasxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var tipopago = $('input:radio[name=tipopago]:checked').val();
var codcliente = $("input#codcliente").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxclientes").serialize();
var url = 'funciones.php?BuscaVentasxClientes=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
             $('#muestraventasxclientes').empty();
            $('#muestraventasxclientes').append(''+response+'').fadeIn("slow");   
        }
    }); 
}


//FUNCION PARA BUSQUEDA DE VENTAS POR CONDICION DE PAGO Y FECHAS
function BuscarVentasxCondiciones(){
                  
$('#muestraventasxcondiciones').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
//var tipopago = $('input:radio[name=tipopago]:checked').val();
var formapago = $("select#codmediopago").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#ventasxcondiciones").serialize();
var url = 'funciones.php?BuscaVentasxCondiciones=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestraventasxcondiciones').empty();
            $('#muestraventasxcondiciones').append(''+response+'').fadeIn("slow");       
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE COMISION POR VENDEDOR
function BuscaComisionxVentas(){
    
$('#muestracomisionxventas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var tipopago = $('input:radio[name=tipopago]:checked').val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#comisionxventas").serialize();
var url = 'funciones.php?BuscaComisionxVentas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestracomisionxventas').empty();
            $('#muestracomisionxventas').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA BUSQUEDA DE DETALLES VENTAS X FECHAS
function BuscaDetallesVentasxFechas(){
    
$('#muestradetallesventasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var tipopago = $('input:radio[name=tipopago]:checked').val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallesventasxfechas").serialize();
var url = 'funciones.php?BuscaDetallesVentasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestradetallesventasxfechas').empty();
            $('#muestradetallesventasxfechas').append(''+response+'').fadeIn("slow");
        }
    }); 
}


// FUNCION PARA BUSQUEDA DE DETALLES VENTAS X VENDEDOR
function BuscaDetallesVentasxVendedor(){
    
$('#muestradetallesventasxvendedor').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var tipopago = $('input:radio[name=tipopago]:checked').val();
var codigo = $("#codigo").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallesventasxvendedor").serialize();
var url = 'funciones.php?BuscaDetallesVentasxVendedor=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestradetallesventasxvendedor').empty();
            $('#muestradetallesventasxvendedor').append(''+response+'').fadeIn("slow");
        }
    }); 
}

















/////////////////////////////////// FUNCIONES DE CREDITOS //////////////////////////////////////

// FUNCION PARA BUSQUEDA DE CREDITOS POR SUCURSAL
function BuscaCreditosxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#creditosxsucursal").serialize();
var url = 'consultas.php?BuscaCreditosxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR VENTA DE CREDITO EN VENTANA MODAL
function VerCredito(codventa,codsucursal){

$('#muestracreditomodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaCreditoModal=si&codventa='+codventa+"&codsucursal="+codsucursal;

$.ajax({
    type: "GET",
    url: "funciones.php",
    data: dataString,
        success: function(response) {            
            $('#muestracreditomodal').empty();
            $('#muestracreditomodal').append(''+response+'').fadeIn("slow");
        }
    });
}

// FUNCION PARA ABONAR PAGO A CREDITOS DE VENTAS
function AbonoCreditoVenta(codsucursal,codcliente,codventa,nomcliente,codfactura,totalfactura,fechaventa,totaldebe,totalabono) 
{
  // aqui asigno cada valor a los campos correspondientes
  $("#savepagoventa #codsucursal").val(codsucursal);
  $("#savepagoventa #codcliente").val(codcliente);
  $("#savepagoventa #codventa").val(codventa);
  $("#savepagoventa #nomcliente").val(nomcliente);
  $("#savepagoventa #codfactura").val(codfactura);
  $("#savepagoventa #totalfactura").val(totalfactura);
  $("#savepagoventa #fechaventa").val(fechaventa);
  $("#savepagoventa #totaldebe").val(totaldebe);
  $("#savepagoventa #debe").val(totaldebe);
  $("#savepagoventa #totalabono").val(totalabono);
  $("#savepagoventa #abono").val(totalabono);
}

//FUNCION PARA BUSQUEDA DE VENTAS POR CONDICION DE PAGO Y FECHAS
function BuscarAbonosCreditosVentasxCajas(){
                  
$('#muestradetallesabonos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var formapago = $("select#formapago").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#abonoscreditosventasxcajas").serialize();
var url = 'funciones.php?BuscaAbonosCreditosVentasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestradetallesabonos').empty();
      $('#muestradetallesabonos').append(''+response+'').fadeIn("slow");
    }
  }); 
}

// FUNCION PARA BUSQUEDA DE CREDITOS POR FECHAS
function BuscarCreditosVentasxFechas(){
                        
$('#muestracreditosxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val(); 
var status = $('input:radio[name=status]:checked').val();               
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#creditosventasxfechas").serialize();
var url = 'funciones.php?BuscaCreditosVentasxFechas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {            
            $('#muestracreditosxfechas').empty();
            $('#muestracreditosxfechas').append(''+response+'').fadeIn("slow");
        }
    });
}

//FUNCION PARA BUSQUEDA DE CREDITOS POR CLIENTES
function BuscarCreditosVentasxClientes(){
                  
$('#muestracreditosxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var status = $('input:radio[name=status]:checked').val();
var cliente = $("#cliente").val();
var dataString = $("#creditosventasxclientes").serialize();
var url = 'funciones.php?BuscaCreditosVentasxClientes=si';

$.ajax({
  type: "GET",
  url: url,
  data: dataString,
  success: function(response) {            
    $('#muestracreditosxclientes').empty();
    $('#muestracreditosxclientes').append(''+response+'').fadeIn("slow");
    }
  }); 
}

//FUNCION PARA BUSQUEDA DE DETALLES DE CREDITOS POR FECHAS
function BuscarDetallesCreditosVentasxFechas(){
                  
$('#muestradetallescreditos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var status = $('input:radio[name=status]:checked').val();              
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#detallescreditosventasxfechas").serialize();
var url = 'funciones.php?BuscaDetallesCreditosVentasxFechas=si';

$.ajax({
  type: "GET",
  url: url,
  data: dataString,
    success: function(response) {            
    $('#muestradetallescreditos').empty();
    $('#muestradetallescreditos').append(''+response+'').fadeIn("slow");        
    }
  }); 
}

// FUNCION PARA BUSQUEDA DE CREDITOS POR DETALLES
function BuscarDetallesCreditosVentasxClientes(){
                        
$('#muestradetallescreditos').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var status = $('input:radio[name=status]:checked').val();
var cliente = $("#cliente").val();
var dataString = $("#detallescreditosventasxclientes").serialize();
var url = 'funciones.php?BuscaDetallesCreditosVentasxClientes=si';

$.ajax({
  type: "GET",
  url: url,
  data: dataString,
  success: function(response) {            
      $('#muestradetallescreditos').empty();
      $('#muestradetallescreditos').append(''+response+'').fadeIn("slow");
    }
  });
}
























/////////////////////////////////// FUNCIONES DE NOTAS DE CREDITO //////////////////////////////////////

// FUNCION PARA CALCULAR DETALLES DETALLES VENTAS PARA NOTA DE CREDITO
function PresionarDetalleDevolucion(item,indice){
    var cantidad = $('#devuelto_'+indice).val();

    var Calculo = (item === "a" ? parseFloat(cantidad) - 1 : parseFloat(cantidad) + 1);
    $('#devuelto_'+indice).val(Calculo.toFixed(2));
    ProcesarCalculoDevolucion(indice);
} 

// FUNCION PARA CALCULAR DETALLES VENTAS PARA NOTA DE CREDITO
function ProcesarCalculoDevolucion(indice){

    var devuelto = parseInt($('#devuelto_'+indice).val());
    var cantidad = parseInt($('#cantidad_'+indice).val());
    var preciocompra = $('#preciocompra_'+indice).val();
    var precioventa = $('#precioventa_'+indice).val();
    var precioconiva = $('#precioconiva_'+indice).val();
    var valortotal = $('#valortotal_'+indice).val();
    var neto = $('#valorneto_'+indice).val();
    var descproducto = $('#descproducto_'+indice).val();
    var ivaproducto = $('#ivaproducto_'+indice).val();
    var ivg = $('#iva').val();
    var desc = $('#descuento').val();
    var ValorNeto = 0;
    //entrega = parseInt(devuelto);
    //salida = parseInt(cantidad);

    if (devuelto < 0) {

        $("#devuelto_"+indice).val("0.00");
        $('#valortotal_'+indice).val("0.00");
        $('#txtvalortotal_'+indice).text("0.00");
        $('#subtotalivasi_'+indice).val("0.00");
        $('#subtotalivano_'+indice).val("0.00");
        $('#subtotalimpuestos_'+indice).val("0.00");
        $('#subtotaldiscriminado_'+indice).val("0.00");
        $('#valorneto_'+indice).val("0.00");
        $("#txtvalorneto_"+indice).text("0.00");
        $("#devuelto_"+indice).focus();
        $("#devuelto").css('border-color', '#f0ad4e');
        swal("Oops", "POR FAVOR INGRESE UNA CANTIDAD VALIDA!", "error");
        return false;

    } else if (devuelto > cantidad) {

        $("#devuelto_"+indice).val("0.00");
        $('#valortotal_'+indice).val("0.00");
        $('#txtvalortotal_'+indice).text("0.00");
        $('#subtotalivasi_'+indice).val("0.00");
        $('#subtotalivano_'+indice).val("0.00");
        $('#subtotalimpuestos_'+indice).val("0.00");
        $('#subtotaldiscriminado_'+indice).val("0.00");
        $('#valorneto_'+indice).val("0.00");
        $("#txtvalorneto_"+indice).text("0.00");
        $("#devuelto_"+indice).focus();
        $("#devuelto").css('border-color', '#f0ad4e');
        swal("Oops", "LA DEVOLUCIÓN NO PUEDE SER MAYOR QUE LA CANTIDAD!", "error");
        return false;
    }

    //REALIZAMOS LA MULTIPLICACION DE PRECIO VENTA * CANTIDAD
    var ValorTotal = parseFloat(devuelto) * parseFloat(precioventa);

    //CALCULO DEL TOTAL DEL DESCUENTO %
    var Descuento = ValorTotal * descproducto / 100;
    var ValorNeto = parseFloat(ValorTotal) - parseFloat(Descuento);

    //CALCULO VALOR TOTAL
    $("#valortotal_"+indice).val(ValorTotal.toFixed(2));
    $("#txtvalortotal_"+indice).text(Separador(ValorTotal.toFixed(2)));

    //CALCULO TOTAL DESCUENTO
    $("#totaldescuentov_"+indice).val(Descuento.toFixed(2));
    $("#txtdescproducto_"+indice).text(Separador(Descuento.toFixed(2)));

    //CALCULO VALOR NETO
    $("#valorneto_"+indice).val(ValorNeto.toFixed(2));
    $("#txtvalorneto_"+indice).text(Separador(ValorNeto.toFixed(2)));

    //CALCULO SUBTOTAL IVA SI
    $("#subtotalivasi_"+indice).val(ivaproducto != '0.00' ? ValorNeto.toFixed(2) : "0");
    //CALCULO SUBTOTAL IVA NO
    $("#subtotalivano_"+indice).val(ivaproducto == "0.00" ? ValorNeto.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/
    
    //CALCULO SUBTOTAL DISCRIMINADO
    ivg2  = ivg;
    var ValorImpuesto = (ivg2 <= 9) ? "1.0"+parseInt(ivg2) : "1."+parseInt(ivg2);
    var Discriminado = parseFloat(precioconiva) / parseFloat(ValorImpuesto);
    var SubtotalDiscriminado = parseFloat(precioconiva) - parseFloat(Discriminado.toFixed(2));
    var BaseDiscriminado = parseFloat(SubtotalDiscriminado.toFixed(2)) * parseFloat(devuelto);
    //TotalIvaGeneral = parseFloat(TotalIvaGeneral.toFixed(2)) + parseFloat(BaseDiscriminado.toFixed(2));
    var RestoDiscriminado = parseFloat(ValorNeto) - parseFloat(BaseDiscriminado.toFixed(2));
    
    //CALCULO SUBTOTAL IMPUESTOS
    $("#subtotalimpuestos_"+indice).val(BaseDiscriminado.toFixed(2));

    //CALCULO SUBTOTAL DISCRIMINADO
    $("#subtotaldiscriminado_"+indice).val(ivaproducto != "0.00" ? RestoDiscriminado.toFixed(2) : "0"); 

    /*################################ CALCULO DISCRIMINADO ################################*/

    //CALCULO DE SUBTOTAL CON IVA
    var BaseImpIva1=0;
    $('.subtotalivasi').each(function() {
    ($(this).val() != "0" ? BaseImpIva1 += parseFloat($(this).val()) : BaseImpIva1);
    }); 
    //$('#txtsubtotal').val(BaseImpIva1.toFixed(2));
    //$('#lblsubtotal').text(Separador(BaseImpIva1.toFixed(2)));

    //CALCULO DE SUBTOTAL SIN IVA
    var BaseImpIva2=0;
    $('.subtotalivano').each(function() {
    ($(this).val() != "0" ? BaseImpIva2 += parseFloat($(this).val()) : BaseImpIva2);
    }); 
    $('#txtsubtotal2').val(BaseImpIva2.toFixed(2));
    $('#lblsubtotal2').text(Separador(BaseImpIva2.toFixed(2)));

    //CALCULO DE SUBTOTAL GENERAL
    var SubTotal=0;
    $('.subtotaldiscriminado').each(function() {
    SubTotal += parseFloat($(this).val());
    });
    var SubtotalBaseGeneral = parseFloat(SubTotal.toFixed(2)) + parseFloat(BaseImpIva2.toFixed(2));
    $('#lblsubtotal').text(Separador(SubTotal.toFixed(2)));
    $('#txtsubtotal').val(SubTotal.toFixed(2));
    $('#txtdiscriminado').val(SubtotalBaseGeneral.toFixed(2));
    //$('#lblsubtotal').text(Separador(SubTotal+BaseImpIva2));

    //CALCULO DE TOTAL IMPUEST0S 
    var TotalIvaGeneral=0;
    $('.subtotalimpuestos').each(function() {  
    ($(this).val() != "0" ? TotalIvaGeneral += parseFloat($(this).val()) : TotalIvaGeneral);
    }); 
    $('#txtIva').val(TotalIvaGeneral.toFixed(2));
    $('#lbliva').text(Separador(TotalIvaGeneral.toFixed(2)));

    //CALCULO DE TOTAL DESCONTADO
    var TotalDescontado=0;
    $('.totaldescuentov').each(function() { 
    ($(this).val() != "0" ? TotalDescontado += parseFloat($(this).val()) : TotalDescontado); 
    });
    $('#txtdescontado').val(TotalDescontado.toFixed(2));
    $('#lbldescontado').text(Separador(TotalDescontado.toFixed(2))); 

    //CALCULAMOS DESCUENTO POR PRODUCTO
    desc2  = desc/100;

    //CALCULO DEL TOTAL DE FACTURA
    var Total = parseFloat(SubtotalBaseGeneral) + parseFloat(TotalIvaGeneral);
    TotalDescuentoGeneral   = parseFloat(Total.toFixed(2)) * parseFloat(desc2.toFixed(2));
    TotalFactura   = parseFloat(Total.toFixed(2)) - parseFloat(TotalDescuentoGeneral.toFixed(2));

    $('#txtTotal').val(TotalFactura.toFixed(2));
    $('#lbltotal').text(Separador(TotalFactura.toFixed(2)));
} 


// FUNCION PARA BUSQUEDA DE FACTURA PARA NOTA DE CREDITO
function BuscarFactura(){
                        
$('#muestrafactura').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("input#codsucursal").val();
var codventa = $("input#codventa").val();
var status = $('input:radio[name=descontar]:checked').val();
var codarqueo = $("input#codarqueo").val();
var dataString = $("#savenota").serialize();
var url = 'funciones.php?ProcesaNotaCredito=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
        $('#muestrafactura').empty();
        $('#muestrafactura').append(''+response+'').fadeIn("slow");
            
    }
  });
}


//FUNCIONES PARA VERIFICAR NOTA CREDITO
function VerificaDescuentoCaja(){

  var status = $('input:radio[name=descontar]:checked').val();

  if (status == 1 || status == true) {
         
      //deshabilitamos
      $("#codarqueo").attr('disabled', false);

  } else {

      // habilitamos
      $("#codarqueo").attr('disabled', true);
  }
}

// FUNCION PARA BUSQUEDA NOTA DE CREDITO POR SUCURSAL
function BuscaNotasCreditoxSucursal(){

$('#muestra_detalles').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var dataString = $("#notascreditoxsucursal").serialize();
var url = 'consultas.php?BuscaNotasCreditoxSucursal=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
        success: function(response) {
            $('#muestra_detalles').empty();
            $('#muestra_detalles').append(''+response+'').fadeIn("slow");
        }
    }); 
}

// FUNCION PARA MOSTRAR NOTA DE CREDITO EN VENTANA MODAL
function VerNota(codnota,codsucursal){

$('#muestranotamodal').html('<center><i class="fa fa-spin fa-spinner"></i> Cargando información, por favor espere....</center>');

var dataString = 'BuscaNotaModal=si&codnota='+codnota+"&codsucursal="+codsucursal;

$.ajax({
      type: "GET",
      url: "funciones.php",
      data: dataString,
      success: function(response) {            
          $('#muestranotamodal').empty();
          $('#muestranotamodal').append(''+response+'').fadeIn("slow");
          
      }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR CAJAS
function BuscarNotasxCajas(){
                        
$('#muestranotasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxcajas").serialize();
var url = 'funciones.php?BuscaNotasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestranotasxcajas').empty();
      $('#muestranotasxcajas').append(''+response+'').fadeIn("slow");  
    }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR CAJAS
function BuscarNotasxCajas(){
                        
$('#muestranotasxcajas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var codcaja = $("#codcaja").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxcajas").serialize();
var url = 'funciones.php?BuscaNotasxCajas=si';

$.ajax({
    type: "GET",
    url: url,
    data: dataString,
    success: function(response) {            
      $('#muestranotasxcajas').empty();
      $('#muestranotasxcajas').append(''+response+'').fadeIn("slow");  
    }
  });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR FECHAS
function BuscarNotasxFechas(){
                        
$('#muestranotasxfechas').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');

var codsucursal = $("#codsucursal").val();
var desde = $("input#desde").val();
var hasta = $("input#hasta").val();
var dataString = $("#notasxfechas").serialize();
var url = 'funciones.php?BuscaNotasxFechas=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestranotasxfechas').empty();
                $('#muestranotasxfechas').append(''+response+'').fadeIn("slow");
                
             }
      });
}

// FUNCION PARA BUSQUEDA DE NOTAS POR CLIENTE
function BuscarNotasxClientes(){
                        
$('#muestranotasxclientes').html('<center><i class="fa fa-spin fa-spinner"></i> Procesando información, por favor espere....</center>');
                
var codsucursal = $("#codsucursal").val();
var codcliente = $("input#codcliente").val();
var dataString = $("#notasxclientes").serialize();
var url = 'funciones.php?BuscaNotasxClientes=si';

$.ajax({
            type: "GET",
            url: url,
            data: dataString,
            success: function(response) {            
                $('#muestranotasxclientes').empty();
                $('#muestranotasxclientes').append(''+response+'').fadeIn("slow");
                
             }
      });
}