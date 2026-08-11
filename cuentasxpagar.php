<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
   $reg = $tra->RegistrarPagoCompra();
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

<body onLoad="muestraReloj(); getTime();" class="fix-header">
    
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

<!--############################## MODAL PARA VER DETALLE DE COMPRA PENDIENTE ######################################-->
<div id="myModalDetalle" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Detalle de Compra</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                <div id="muestracompramodal"></div> 
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA VER DETALLE DE COMPRA PENDIENTE ######################################-->

<?php if ($_SESSION['acceso'] != "administradorG"){ ?>
<!--############################## MODAL PARA ABONOS DE CREDITOS DE COMPRAS ######################################-->
<!-- sample modal content -->
<div id="ModalAbonosCompra" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-text="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Pagos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-text="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" name="savepagocompra" id="savepagocompra" action="#">
                
       <div class="modal-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                    <input type="hidden" name="formulario" id="formulario" value="cuentasxpagar"/>
                    <input type="hidden" name="proceso" id="proceso" value="save"/>
                    <input type="hidden" name="codsucursal" id="codsucursal">
                    <input type="hidden" name="codproveedor" id="codproveedor">
                    <input type="hidden" name="codcompra" id="codcompra">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="cuitproveedor" id="cuitproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" disabled="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Proveedor: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="nomproveedor" id="nomproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Proveedor" autocomplete="off" disabled="" aria-required="true"/>  
                    <i class="fa fa-user form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Factura: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="codfactura" id="codfactura" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Factura" autocomplete="off" disabled="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Total Factura: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="totalfactura" id="totalfactura" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Total Factura" autocomplete="off" disabled="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha de Emisión: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fechaemision" id="fechaemision" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Emisión" autocomplete="off" disabled="" aria-required="true"/>  
                    <i class="fa fa-calendar form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Total Abono: <span class="symbol required"></span></label>
                    <input type="hidden" name="totalabono" id="totalabono"/>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="abono" id="abono" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Total de Abono" autocomplete="off" disabled="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Total Debe: <span class="symbol required"></span></label>
                    <input type="hidden" name="totaldebe" id="totaldebe">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="debe" id="debe" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Total Debe" autocomplete="off" disabled="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Forma de Abono: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="formaabono" id="formaabono" class="form-control" required aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $medio = new Login();
                    $medio = $medio->ListarMediosPagos();
                    if($medio==""){ 
                       echo "";
                    } else {
                    for ($i = 0; $i < sizeof($medio); $i++) { ?>
                    <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"<?php if (!(strcmp('EFECTIVO', $medio[$i]['mediopago']))) {echo "selected=\"selected\"";} ?>><?php echo $medio[$i]['mediopago'] ?></option>
                    <?php } } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Monto de Abono: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Monto de Abono" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Comprobante: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="comprobante" id="comprobante" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Comprobante" autocomplete="off" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Banco: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codbanco" id="codbanco" title="Seleccione Banco" class="form-control" required aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $banco = new Login();
                    $banco = $banco->ListarBancos();
                    if($banco==""){ 
                       echo "";
                    } else {
                    for ($i = 0; $i < sizeof($banco); $i++) { ?>
                    <option value="<?php echo encrypt($banco[$i]['codbanco']); ?>"><?php echo $banco[$i]['nombanco'] ?></option>
                    <?php } } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha de Abono: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese de Abono" autocomplete="off" readonly="" aria-required="true"/> 
                    <i class="fa fa-clock-o form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <!--<div class="row">
            <div class="col-md-8"> 
                <div class="form-group has-feedback">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Foto de Comprobante: </label>
                            <div class="input-group">
                            <div class="form-control" data-trigger="fileinput"><i class="fa fa-file-photo-o fileinput-exists"></i>
                            <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-success btn-file">
                            <span class="fileinput-new" data-trigger="fileinput"><i class="fa fa-cloud-upload"></i> Selecciona Imagen</span>
                            <span class="fileinput-exists" data-trigger="fileinput"><i class="fa fa-file-photo-o"></i> Cambiar</span>
                             <input type="file" class="btn btn-default" data-original-title="Subir Imagen" data-rel="tooltip" placeholder="Suba su Imagen" name="imagen" id="imagen" autocomplete="off" title="Buscar Archivo">
                            </span>
                            <a href="#" class="input-group-addon btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-trash-o"></i> Quitar</a>
                            </div><small><p>Para Subir Foto de Comprobante debe tener en cuenta:<br> * La imagen debe ser extension.jpg<br> * La imagen no debe ser mayor de 50 KB</p></small>
                        </div>
                    </div>
                </div> 
            </div>
        </div>-->

    </div>

            <div class="modal-footer">
                <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button></span>
                <button class="btn btn-dark" type="button" onclick="
                document.getElementById('proceso').value = 'save',
                document.getElementById('codcompra').value = '',
                document.getElementById('codfactura').value = '',
                document.getElementById('codsucursal').value = '',
                document.getElementById('codproveedor').value = '',
                document.getElementById('cuitproveedor').value = '',
                document.getElementById('nomproveedor').value = '',
                document.getElementById('totalfactura').value = '',
                document.getElementById('fechaemision').value = '',
                document.getElementById('totalabono').value = '',
                document.getElementById('abono').value = '',
                document.getElementById('totaldebe').value = '',
                document.getElementById('debe').value = '',
                document.getElementById('formaabono').value = '',
                document.getElementById('montoabono').value = '',
                document.getElementById('comprobante').value = '',
                document.getElementById('codbanco').value = ''
                " class="close" data-dismiss="modal" aria-text="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA ABONOS DE CREDITOS DE COMPRAS ######################################-->
<?php } ?>                                  
                
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
                <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Cuentas por Pagar</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Cuentas por Pagar</li>
                                <li class="breadcrumb-item active" aria-current="page">Cuentas por Pagar</li>
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
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Cuentas x Pagar</h4>
            </div>

            <div class="form-body">

            <div class="card-body">

        <form class="form form-material" method="post" action="#" name="cuentasxpagarxsucursal" id="cuentasxpagarxsucursal">

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
                <button type="button" id="BotonBusqueda" onClick="BuscaCuentasxPagarxSucursal()" class="btn btn-danger"><span class="fa fa-search"></span> Realizar Búsqueda</button>
            </div>

            </form>

            </div>
        </div>
     </div>
  </div>
</div>
<!-- End Row -->

<div id="muestra_detalles"></div>

<?php } else { ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cuentas por Pagar</h4>
            </div>

            <div class="form-body">

            <div id="save">
                   <!-- error will be shown here ! -->
            </div>

                <div class="card-body">

                    <div class="row">

                    <div class="col-md-6">
                        <div class="btn-group m-b-20">
                        <a class="btn waves-effect waves-light btn-light" href="reportepdf?tipo=<?php echo encrypt("CUENTASXPAGAR"); ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                        <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CUENTASXPAGAR"); ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                        <a class="btn waves-effect waves-light btn-light" href="reporteexcel?documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CUENTASXPAGAR"); ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                        </div>
                    </div>
                </div>

                <form class="form form-horizontal" method="post" action="#" name="busquedacuentasxpagar" id="busquedacuentasxpagar">

                <div class="row">
                    <div class="col-md-12">
                        <label class="control-label">Búsqueda de Compras: <span style="cursor: pointer;" class="mdi mdi-alert-circle text-danger" data-container="body" title="Notificación: Ingrese Criterio de Búsqueda por Nº de Factura, Nº Documento de Proveedor, Nombres de Proveedor, Nº de Sucursal, Nombre de Sucursal."></span></label>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                            <button type="button" id="BotonBusqueda" onClick="BuscarCuentasxPagar();" class="btn btn-success waves-effect waves-light" data-placement="left" title="Buscar Compra"><i class="fa fa-search-plus"></i></button>
                            </div>
                            <input type="text" class="form-control" name="bcompras" id="bcompras" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para tu Búsqueda" autocomplete="off" autocomplete="off" required="" aria-required="true"> 
                        </div>
                    </div>
                </div>

                </form>

                <div id="muestracuentasxpagar"></div>

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

    <!-- Custom file upload -->
    <script src="assets/plugins/fileupload/bootstrap-fileupload.min.js"></script>
    <!-- Custom file upload -->

    <!-- script jquery -->
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
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
    <script type="text/javascript">
    $('#bcompras').keypress(function(e) {
    var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') {
            BuscarCuentasxPagar();
            return false;
        }
    });   
    </script>
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