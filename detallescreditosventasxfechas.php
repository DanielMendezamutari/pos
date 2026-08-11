<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") {

$tra = new Login();
$ses = $tra->ExpiraSession();   

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
   $reg = $tra->RegistrarPagoVenta();
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
          

<!--############################## MODAL PARA REGISTRO DE PAGO CREDITO ######################################-->
<!-- sample modal content -->
<div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Pagos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="savepagoventa" id="savepagoventa">
                
        <div class="modal-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Cliente: <span class="symbol required"></span></label>
                    <input type="hidden" name="formulario" id="formulario" value="detallescreditosventasxfechas"/>
                    <input type="hidden" name="proceso" id="proceso" value="save"/>
                    <input type="hidden" name="codsucursal" id="codsucursal">
                    <input type="hidden" name="codcliente" id="codcliente">
                    <input type="hidden" name="codventa" id="codventa">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="nomcliente" id="nomcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Cliente" autocomplete="off" disabled="" aria-required="true"/>
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Factura: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="codfactura" id="codfactura" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Factura" autocomplete="off" disabled="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha de Emisión: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fechaventa" id="fechaventa" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha de Venta" autocomplete="off" disabled="" aria-required="true"/>  
                    <i class="fa fa-calendar form-control-feedback"></i> 
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
                    <label class="control-label">Total Abono: <span class="symbol required"></span></label>
                    <input type="hidden" name="totalabono" id="totalabono"/>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="abono" id="abono" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Total de Abono" autocomplete="off" disabled="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Total Debe: <span class="symbol required"></span></label>
                    <input type="hidden" name="totaldebe" id="totaldebe">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="debe" id="debe" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Total Debe" autocomplete="off" disabled="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label">Forma de Abono: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="formaabono" id="formaabono" title="Seleccione Forma Pago" class="form-control" required aria-required="true">
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

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Fecha de Abono: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese de Abono" autocomplete="off" readonly="" aria-required="true"/> 
                    <i class="fa fa-clock-o form-control-feedback"></i> 
                </div>
            </div>
        </div>

        </div>

            <div class="modal-footer">
                <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button></span>
                <button class="btn btn-dark" type="button" onclick="
                document.getElementById('proceso').value = 'save',
                document.getElementById('codsucursal').value = '',
                document.getElementById('codcliente').value = '',
                document.getElementById('codventa').value = '',
                document.getElementById('nomcliente').value = '',
                document.getElementById('codfactura').value = '',
                document.getElementById('fechaventa').value = '',
                document.getElementById('totalfactura').value = '',
                document.getElementById('totalabono').value = '',
                document.getElementById('abono').value = '',
                document.getElementById('totaldebe').value = '',
                document.getElementById('debe').value = '',
                document.getElementById('montoabono').value = '',
                document.getElementById('formaabono').value = ''
                " data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE PAGO CREDITO ######################################-->

                   
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
    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Créditos por Detalles</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Créditos</li>
                                <li class="breadcrumb-item active" aria-current="page">Detalles x Fechas</li>
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
               
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles x Fechas</h4>
            </div>
            
        <form class="form form-material" method="post" action="#" name="detallescreditosventasxfechas" id="detallescreditosventasxfechas">

             <div class="form-body">

            <div id="save">
            <!-- error will be shown here ! -->
            </div>

                <div class="card-body">

    <?php if($_SESSION['acceso'] == "administradorG") { ?>
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
                if($sucursal==""){ 
                    echo "";
                } else {
                for($i=0;$i<sizeof($sucursal);$i++){
                ?>
                <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal']; ?></option>       
                <?php } } ?>
                </select>
            </div> 
        </div>
    </div>
    <?php } else { ?>
    <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
    <?php } ?>

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Status de Crédito: <span class="symbol required"></span></label><br>
                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="1" name="status" value="<?php echo encrypt("1"); ?>" checked="checked">
                        <label class="custom-control-label" for="1">GENERAL</label>
                    </div>
                </div>

                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="2" name="status" value="<?php echo encrypt("2"); ?>">
                        <label class="custom-control-label" for="2">PAGADA</label>
                    </div>
                </div><br>

                <div class="form-check form-check-inline">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="3" name="status" value="<?php echo encrypt("3"); ?>">
                        <label class="custom-control-label" for="3">PENDIENTE</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group has-feedback">
                <label class="control-label">Ingrese Fecha Desde: <span class="symbol required"></span></label>
                <input type="text" class="form-control" name="desde" id="desde" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha Desde" autocomplete="off" required="" aria-required="true"/>
                <i class="fa fa-calendar form-control-feedback"></i>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group has-feedback">
                <label class="control-label">Ingrese Fecha Hasta: <span class="symbol required"></span></label>
                <input type="text" class="form-control" name="hasta" id="hasta" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Fecha Hasta" autocomplete="off" required="" aria-required="true"/>  
                <i class="fa fa-calendar form-control-feedback"></i>
            </div>
        </div>
    </div>

                    <div class="text-right">
                        <button type="button" id="BotonBusqueda" onClick="BuscarDetallesCreditosVentasxFechas()" class="btn btn-danger"><span class="fa fa-search"></span> Realizar Búsqueda</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>
<!-- End Row -->

<div id="muestradetallescreditos"></div>


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
    $(document).ready(function(){
        $(document).keypress(function(e) {        
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
            $("#BotonBusqueda").trigger("click");
            return false;
            }
        });                    
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