<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="procesar")
{
$reg = $tra->ProcesarPedidos();
exit;
}       
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Ing. Ruben Chirinos">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>

    <!-- Menu CSS -->
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- toast CSS -->
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Datatables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Sweet-Alert -->
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- needed css -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <!-- color alert -->
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>

<body onLoad="muestraReloj()" class="fix-header">
    
   <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 

<!--############################## MODAL PARA VER DETALLE DE PEDIDO ######################################-->
<!-- sample modal content -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-danger">
            <h4 class="modal-title" id="myLargeModalLabel"><font color="white"><i class="fa fa-tasks"></i> Detalle de Pedido</font></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
        </div>
        <div class="modal-body">
            <p><div id="muestrapedidomodal"></div></p>
        </div>
        
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA VER DETALLE DE PEDIDO ######################################-->                 
                    

<!--############################## MODAL PARA PROCESAR PEDIDO ######################################-->
<!-- sample modal content -->
<div id="myModalProcesar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Procesar Pedido</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="procesarpedido" id="procesarpedido" enctype="multipart/form-data">
                
        <div class="modal-body">

        <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

        <div class="row"> 
            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">N° de Factura: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" value="procesar"/>
                    <input type="hidden" name="codpedido" id="codpedido">
                    <input type="hidden" name="codproveedor" id="codproveedor">
                    <input type="hidden" name="codsucursal" id="codsucursal">
                    <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="codfactura" id="codfactura" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="N° de Factura" required="" aria-required="true">
                    <i class="fa fa-flash form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Fecha de Emisión: <span class="symbol required"></span></label> 
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control calendario2" name="fechaemision" id="fechaemision" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Emisión" required="" aria-required="true">
                    <i class="fa fa-calendar form-control-feedback"></i>  
                </div> 
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Fecha de Recepción: <span class="symbol required"></span></label> 
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control calendario2" name="fecharecepcion" id="fecharecepcion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Recepción" required="" aria-required="true">
                    <i class="fa fa-calendar form-control-feedback"></i>  
                </div> 
            </div> 

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Nombre de Proveedor: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="nomproveedor" id="nomproveedor" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Nombre de Proveedor" disabled ="" aria-required="true">
                    <i class="fa fa-flash form-control-feedback"></i>
                </div> 
            </div>
        </div>


        <div class="row">
            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Tipo de Compra: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="tipocompra" id="tipocompra" class="form-control" onChange="CargaFormaPagosCompras()" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="CONTADO">CONTADO</option>
                    <option value="CREDITO">CRÉDITO</option>
                    </select>
                </div> 
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="formacompra" id="formacompra" class="form-control" disabled="" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $pago = new Login();
                    $pago = $pago->ListarMediosPagos();
                    if($pago==""){ 
                       echo "";
                    } else {
                    for($i=0;$i<sizeof($pago);$i++){  ?>
                    <option value="<?php echo $pago[$i]['codmediopago'] ?>"><?php echo $pago[$i]['mediopago'] ?></option>       
                    <?php } } ?> 
                    </select>
                </div> 
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                   <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label> 
                   <input style="color:#000;font-weight:bold;" type="text" class="form-control expira" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vence Crédito" disabled="" required="" aria-required="true">
                   <i class="fa fa-calendar form-control-feedback"></i>  
                </div> 
            </div>  

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Gasto de Envio: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="gastoenvio" id="gastoenvio" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" value="0.00" placeholder="Gasto de Envio" required="" aria-required="true">
                    <i class="fa fa-flash form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-12"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Observaciones: </label> 
                    <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1"></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>
        </div>

        <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

        <div id="muestra_detalles"></div>

        </div>

            <div class="modal-footer">
                <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button></span>
                <button class="btn btn-dark" type="button" onclick="LimpiarProcesaPedido();" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA PROCESAR PEDIDO ######################################--> 

    
        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->
   

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Pedidos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Mantenimiento</li>
                                <li class="breadcrumb-item active" aria-current="page">Proveedores</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="page-content container-fluid">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
               
<?php if ($_SESSION['acceso'] == "administradorG"){ ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Pedidos</h4>
            </div>

            <div class="form-body">

            <div class="card-body">

        <form class="form form-material" method="post" action="#" name="pedidosxsucursal" id="pedidosxsucursal">

            <div class="row">

                <div class="col-md-12"> 
                    <div class="form-group has-feedback"> 
                        <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" class="form-control" required="" aria-required="true">
                          <option value=""> -- SELECCIONE -- </option>
                          <?php
                          $sucursal = new Login();
                          $sucursal = $sucursal->ListarSucursales();
                          for($i=0;$i<sizeof($sucursal);$i++){
                              ?>
                              <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal']; ?></option>       
                          <?php } ?>
                        </select>
                    </div> 
                </div>
            </div>

            <div class="text-right">
                <button type="button" onClick="BuscaPedidosxSucursal()" class="btn btn-danger"><span class="fa fa-search"></span> Realizar Búsqueda</button>
            </div>

            </form>

            </div>
        </div>
     </div>
  </div>
</div>
<!-- End Row -->

<div id="muestra_pedidos"></div>

<?php } else { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Pedidos</h4>
            </div>

            <div class="form-body">

                <div class="card-body">

                    <div id="save">
                    <!-- error will be shown here ! -->
                    </div>

                    <div class="row">

                    <div class="col-md-6">
                        <div class="btn-group m-b-20">
                        <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipo=<?php echo encrypt("PEDIDOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                        </div>
                    </div>
                </div>

                <div id="pedidos"></div>

            </div>
        </div>
     </div>
  </div>
</div>
<!-- End Row -->

<?php } ?>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
   

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/script/jquery.min.js"></script>  
    <script src="assets/js/popper.min.js"></script>  
    <script src="assets/js/bootstrap.js"></script>
    <!-- apps -->
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!-- Sweet-Alert -->
    <script src="assets/js/sweetalert-dev.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/jscompras.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <!-- script jquery -->

    <!-- Calendario -->
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
    <!-- Calendario -->

    <!-- jQuery -->
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <?php if ($_SESSION['acceso'] != "administradorG") { ?>
    <script type="text/jscript">
    $('#pedidos').append('<center><p><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</p></center>').fadeIn("slow");
    setTimeout(function() {
    $('#pedidos').load("consultas?CargaPedidos=si");
     }, 200);
    </script>
    <?php } ?>
    <!-- jQuery -->
    

</body>
</html>

<?php } else { ?>   
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO')  
        document.location.href='panel'   
        </script> 
<?php } } else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?>