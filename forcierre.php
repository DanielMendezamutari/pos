<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->CerrarArqueoCaja();
exit;
} 
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarArqueoCaja();
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
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 
                   
    
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
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Cierre</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Mantenimiento</li>
                                <li class="breadcrumb-item active" aria-current="page">Cierre de Caja</li>
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
 
     
    <?php  if (isset($_GET['codarqueo'])) {
      
    $reg = $tra->ArqueoCajaPorId();
    $simbolo = ($reg == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

    $detalleabonos = (new Login)->DetallesAbonosArqueoCajaPorId();
    ?>
      
    <form class="form form-material" method="post" action="#" name="savecerrararqueo" id="savecerrararqueo" data-id="<?php echo $reg[0]["codarqueo"] ?>">
      
    <?php } ?>


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-danger">
                    <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalle de Caja</h4>
                </div>

                <div id="save">
                <!-- error will be shown here ! -->
                </div>


    <div class="form-body">

    <div class="card-body">

    <h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-monitor"></i> Detalle de Caja</h3><hr>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Nº de Caja: </label>
                <input type="hidden" name="proceso" id="proceso" value="<?php echo decrypt($_GET['proceso']); ?>"/>
                <input type="hidden" name="formulario" id="formulario" value="forcierre"/>
                <input type="hidden" name="codarqueo" id="codarqueo" value="<?php echo encrypt($reg[0]["codarqueo"]); ?>"/>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="caja" id="caja" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]; ?>" disabled="" aria-required="true"/>  
                <i class="fa fa-desktop form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Nombre de Cajero: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="nombres" id="nombres" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo $reg[0]["nombres"]; ?>" disabled="" aria-required="true"/>  
                <i class="fa fa-user form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Monto Apertura: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="inicial" id="inicial" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]["montoinicial"], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                <i class="fa fa-dollar form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Fecha Apertura: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="apertura" id="apertura" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo date("d-m-Y H:i:s",strtotime($reg[0]["fechaapertura"])); ?>" disabled="" aria-required="true"/>  
                <i class="fa fa-calendar form-control-feedback"></i> 
            </div>
        </div>
    </div>


    <div class="row">

        <!-- .col -->
        <div class="col-md-6">

        <hr><h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-presentation"></i> Desglose de Ventas por Forma de Pago</h3><hr>

        <div class="row">
        
        <div class="col-md-4">
            <div class="form-group has-feedback">
                <label class="control-label">Venta a Crédito: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="creditos" id="creditos" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]["creditos"], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                <i class="fa fa-dollar form-control-feedback"></i> 
            </div>
        </div>

        <?php
        $a=1;
        $Ventas_Efectivo = 0;
        for($i=0;$i<sizeof($reg);$i++){
        $Ventas_Efectivo += ($reg[$i]['mediopago'] == "EFECTIVO" ? $reg[$i]['montopagado'] : 0);
        if($reg[$i]['mediopago'] != ""){
        ?>
        <div class="col-md-4">
            <div class="form-group has-feedback">
                <label class="control-label"><?php echo $reg[$i]['mediopago']; ?>: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="montopagado" id="montopagado" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[$i]['montopagado'], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                <i class="fa fa-dollar form-control-feedback"></i> 
            </div>
        </div>
        <?php } } ?>

        </div>
            

        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-6">
        
        <hr><h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-presentation"></i> Desglose por Forma de Abonos a Créditos</h3><hr>
            
        <div class="row">
        <?php
        $a=1;
        $Abonos_Efectivo = 0;
        for($i=0;$i<sizeof($detalleabonos);$i++){
        $Abonos_Efectivo += ($detalleabonos[$i]['mediopago'] == "EFECTIVO" ? $detalleabonos[$i]['monto_abonado'] : 0);
        if($detalleabonos[$i]['mediopago'] != ""){
        ?>
        <div class="col-md-4">
            <div class="form-group has-feedback">
                <label class="control-label"><?php echo $detalleabonos[$i]['mediopago']; ?>: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="monto_abonado" id="monto_abonado" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($detalleabonos[$i]['monto_abonado'], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                <i class="fa fa-dollar form-control-feedback"></i> 
            </div>
        </div>
        <?php } } ?>

        </div>    

        </div>
        <!-- /.col -->
       
    </div>


    <div class="row">

        <!-- .col -->
        <div class="col-md-6">

        <hr><h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-presentation"></i> Movimientos en Caja</h3><hr>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Ingresos: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="ingresoe" id="ingresoe" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['ingresos2'], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                    <i class="fa fa-dollar form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Egresos: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="egresos" id="egresos" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['egresos'], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                    <i class="fa fa-dollar form-control-feedback"></i> 
                </div>
            </div>
        </div>
            

        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-6">
        
        <hr><h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-file"></i> Detalles de Totales</h3><hr>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Total en Ventas: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="total_ventas" id="total_ventas" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]["ingresos"]+$reg[0]["creditos"], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                    <i class="fa fa-dollar form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Total de Abonos: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="total_abonos" id="total_abonos" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]["abonos"], 2, '.', ','); ?>" disabled="" aria-required="true"/>  
                    <i class="fa fa-dollar form-control-feedback"></i> 
                </div>
            </div>
        </div>
            
        </div>
        <!-- /.col -->
       
    </div>


    <h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-scale-balance"></i> Balance en Caja</h3><hr>

    <div class="row">
        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Efectivo en Caja: </label>
                
                <input type="hidden" name="efectivocaja" id="efectivocaja" value="<?php echo number_format(($reg[0]["montoinicial"]+$Ventas_Efectivo+$Abonos_Efectivo+$reg[0]["ingresos2"])-$reg[0]["egresos"], 2, '.', ''); ?>"/>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="estimado" id="estimado" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format(($reg[0]["montoinicial"]+$Ventas_Efectivo+$Abonos_Efectivo+$reg[0]["ingresos2"])-$reg[0]["egresos"], 2, '.', ','); ?>" disabled="" aria-required="true"/> 
                <i class="fa fa-dollar form-control-feedback"></i>  
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Efectivo Disponible: <span class="symbol required"></span></label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control cierrecaja" name="dineroefectivo" id="dineroefectivo" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" value="<?php echo number_format($reg[0]['dineroefectivo'], 2, '.', ''); ?>" required="" aria-required="true"/>  
                <i class="fa fa-dollar form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Diferencia: </label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="diferencia" id="diferencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['diferencia'], 2, '.', ''); ?>" readonly="" aria-required="true"/>
                <i class="fa fa-dollar form-control-feedback"></i> 
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group has-feedback">
                <label class="control-label">Hora de Cierre: <span class="symbol required"></span></label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Hora de Cierre" autocomplete="off" readonly="" aria-required="true"/> 
                <i class="fa fa-clock-o form-control-feedback"></i> 
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">Observaciones: </label>
                <input type="text" class="form-control" name="comentarios" id="comentarios" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Observaciones de Cierre" autocomplete="off" required="" aria-required="true"/> 
                <i class="fa fa-comment-o form-control-feedback"></i> 
            </div>
        </div>
    </div>

            <div class="text-right">
<?php if(decrypt($_GET['proceso']) == 'save'){ ?>
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
<?php } elseif(decrypt($_GET['proceso']) == 'update' && $_SESSION["acceso"] == "administradorS"){ ?>
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
<?php } ?>
<button class="btn btn-dark" type="reset" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
            </div>                


                </div>

            </div>

        </div>
    </div>

</div>
<!-- End Row -->


    </form>
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