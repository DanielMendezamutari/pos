<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$bod = new Login();
$bod = $bod->SucursalesSessionPorId(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);

$cambiomoneda = new Login();
$cambiomoneda = $cambiomoneda->MonedaProductoId(); 
$montocambio = ($cambiomoneda == "" ? "0.00" : $cambiomoneda[0]['montocambio']);
$simbolo = ($cambiomoneda == "" ? "" : "<strong>".$cambiomoneda[0]['simbolo']."</strong>");
$simbolo2 = ($cambiomoneda == "" ? "" : "<strong>".$cambiomoneda[0]['simbolo2']."</strong>");

$arqueo = new Login();
$arqueo = $arqueo->ArqueoCajaPorUsuario();

if(isset($_POST["proceso"]) and $_POST["proceso"]=="apertura")
{
$reg = $tra->RegistrarArqueoCaja();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarVentas();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="nuevocliente")
{
$reg = $tra->RegistrarClientes();
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
    <!--Bootstrap Horizontal CSS -->
    <link href="assets/css/bootstrap-horizon.css" rel="stylesheet">
    <!--Detalles Productos CSS -->
    <link href="assets/css/style_all.css" rel="stylesheet">
    <!-- color alert -->
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">

    <style>
    @keyframes pulse-conteo-anim {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
        70% { transform: scale(1.03); box-shadow: 0 0 0 8px rgba(255, 193, 7, 0); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
    }
    .pulse-conteo {
        animation: pulse-conteo-anim 2s infinite;
    }
    </style>

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
<!--############################## MODAL INVENTARIO INICIAL CAJEROS ##############################-->
<div id="myModalConteoInicial" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabelConteo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h4 class="modal-title font-weight-bold" id="myModalLabelConteo"><i class="fa fa-clipboard"></i> Inventario Inicial Diario (Turno Tarde - 2:00 PM)</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            <div class="modal-body" id="contenido_modal_conteo">
                <!-- Carga por AJAX -->
            </div>
        </div>
    </div>
</div>
<!--############################## FIN MODAL INVENTARIO INICIAL CAJEROS ##############################-->

<!--############################## MODAL PARA AGREGAR PRECIO VENTA EN DETALLE ##############################-->
<!-- sample modal content -->
<div id="myModalPrecio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Actualizar Detalle</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>

        <form class="form form-material" method="post" action="#" name="agregaprecio" id="agregaprecio">
                
            <div class="modal-body">

            <div id="agrega_detalle_precio"></div><!-- detalle observacion -->

            </div>

        </form>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA AGREGAR PRECIO VENTA EN DETALLE ##############################-->

<!--############################## MODAL PARA REGISTRO DE ARQUEO ######################################-->
<!-- sample modal content -->
<div id="myModalArqueo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Arqueos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="savearqueo" id="savearqueo">
        
        <div class="modal-body">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Caja: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codcaja" id="codcaja" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $caja = new Login();
                        $caja = $caja->ListarCajas();
                        if($caja==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($caja);$i++){
                        ?>
                    <option value="<?php echo encrypt($caja[$i]['codcaja']); ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>         
                    <?php } } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Hora de Apertura: <span class="symbol required"></span></label>
                    <input type="hidden" name="proceso" id="proceso" value="apertura"/>
                    <input type="hidden" name="formulario" id="formulario" value="pos"/>
                    <input type="hidden" name="codarqueo" id="codarqueo">
                    <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Hora de Apertura" autocomplete="off" readonly="" aria-required="true"/> 
                    <i class="fa fa-clock-o form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Monto Inicial: <span class="symbol required"></span></label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="montoinicial" id="montoinicial" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Monto Inicial" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div>
            </div>
        </div>
    </div>

            <div class="modal-footer">
                <button type="submit" name="btn-arqueo" id="btn-arqueo" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                <button class="btn btn-dark" type="button" onclick="
                document.getElementById('proceso').value = 'apertura',
                document.getElementById('codsucursal').value = '',
                document.getElementById('codcaja').value = '',
                document.getElementById('codarqueo').value = '',
                document.getElementById('fecharegistro').value = '',
                document.getElementById('montoinicial').value = ''
                " data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE ARQUEO ######################################-->   

<!--############################## MODAL PARA COBRO DE BILLAR ######################################-->
<div id="myModalBillar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabelBillar" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabelBillar"><i class="fa fa-clock-o"></i> Cobro de Billar - <span id="billarNombreProducto"></span></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="billarIdProducto" value="">
                <input type="hidden" id="billarPrecioHora" value="0.00">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group has-feedback">
                            <label class="control-label">Horas: <span class="symbol required"></span></label>
                            <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="billarHoras" id="billarHoras" onKeyUp="CalcularTotalBillar();" onKeyPress="EvaluateText('%d', this);" onBlur="CalcularTotalBillar();" value="1" placeholder="Horas" autocomplete="off">
                            <i class="fa fa-clock-o form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-feedback">
                            <label class="control-label">Minutos: <span class="symbol required"></span></label>
                            <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="billarMinutos" id="billarMinutos" onKeyUp="CalcularTotalBillar();" onKeyPress="EvaluateText('%d', this);" onBlur="CalcularTotalBillar();" value="0" placeholder="Minutos" autocomplete="off">
                            <i class="fa fa-clock-o form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-feedback">
                            <label class="control-label">Tiempo Cobrado: </label>
                            <input style="color:#000;font-weight:bold;" class="form-control" type="text" id="billarTiempoCobrado" readonly="readonly" value="1 Hora 00 Min">
                            <i class="fa fa-hourglass-half form-control-feedback"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group has-feedback">
                            <label class="control-label">Total Horas: </label>
                            <input style="color:#000;font-weight:bold;" class="form-control" type="text" id="billarTotalHora" readonly="readonly" value="0.00">
                            <i class="fa fa-money form-control-feedback"></i>
                        </div>
                    </div>
                </div>
                <h5 class="card-subtitle m-0 text-dark"><i class="fa fa-plus-circle"></i> Accesorios de Billar</h5><hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Accesorio: </label>
                            <div class="input-group">
                                <select style="color:#000;font-weight:bold;" name="billarAccesorio" id="billarAccesorio" class="form-control">
                                    <option value=""> -- SELECCIONE ACCESORIO -- </option>
                                </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="AgregarAccesorioBillar()"><span class="fa fa-plus"></span> Agregar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="TablaAccesoriosBillar" class="table table-striped table-bordered border display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Accesorio</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Importe</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <h3 class="text-right">Total Accesorios: <?php echo $simbolo; ?> <label id="billarTotalAccesorios">0.00</label></h3>
                <h3 class="text-right text-danger">Total General: <?php echo $simbolo; ?> <label id="billarTotalGeneral">0.00</label></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="ConfirmarBillar()"><span class="fa fa-check"></span> Confirmar Cobro</button>
                <button class="btn btn-dark" type="button" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--############################## MODAL PARA COBRO DE BILLAR ######################################-->

<!--############################## MODAL PARA REGISTRO DE NUEVO CLIENTE ######################################-->
<!-- sample modal content -->
<div id="myModalCliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Cientes</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="savecliente" id="savecliente"> 

                
        <div class="modal-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Cliente: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="tipocliente" id="tipocliente" class="form-control" onChange="CargaTipoCliente(this.form.tipocliente.value);" required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <option value="NATURAL">NATURAL</option>
                        <option value="JURIDICO">JURIDICO</option>
                    </select> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Documento: </label>
                    <i class="fa fa-bars form-control-feedback"></i> 
                    <select style="color:#000;font-weight:bold;" name="documcliente" id="documcliente" class='form-control' required="" aria-required="true">
                        <option value=""> -- SELECCIONE -- </option>
                        <?php
                        $doc = new Login();
                        $doc = $doc->ListarDocumentos();
                        if($doc==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($doc);$i++){ ?>
                        <option value="<?php echo $doc[$i]['coddocumento'] ?>"><?php echo $doc[$i]['documento'] ?></option>
                        <?php } } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Documento: <span class="symbol required"></span></label>
                        <input type="hidden" name="proceso" id="proceso" value="nuevocliente"/>
                        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                        <input type="hidden" name="formulario" id="formulario" value="pos"/>
                        <input type="text" class="form-control" name="dnicliente" id="dnicliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-bolt form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombre de Cliente: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="nomcliente" id="nomcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Cliente" disabled="" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Razón Social: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="razoncliente" id="razoncliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Razón Social" disabled="" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Giro de Cliente: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="girocliente" id="girocliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Giro de Cliente" disabled="" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Teléfono: </label>
                        <input type="text" class="form-control phone-inputmask" name="tlfcliente" id="tlfcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-phone form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Correo de Cliente: </label>
                        <input type="text" class="form-control" name="emailcliente" id="emailcliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Correo Electronico" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-envelope-o form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Provincia: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="id_provincia" id="id_provincia" onChange="CargaDepartamentos(this.form.id_provincia.value);" class='form-control' required="" aria-required="true">
                        <option value="0"> -- SELECCIONE -- </option>
                        <?php
                        $pro = new Login();
                        $pro = $pro->ListarProvincias();
                        if($pro==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($pro);$i++){ ?>
                        <option value="<?php echo $pro[$i]['id_provincia'] ?>"><?php echo $pro[$i]['provincia'] ?></option>        
                        <?php } } ?>
                        </select> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Departamento: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" class="form-control" id="id_departamento" name="id_departamento" required="" aria-required="true">
                            <option value=""> -- SIN RESULTADOS -- </option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Dirección Domiciliaria: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="direccliente" id="direccliente" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección Domiciliaria" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-map-marker form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Limite de Crédito: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="limitecredito" id="limitecredito" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Limite de Crédito" value="0.00" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-usd form-control-feedback"></i>
                    </div>
                </div>
            </div>
        </div>

            <div class="modal-footer">
                <button type="submit" name="btn-cliente" id="btn-cliente" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                <button class="btn btn-dark" type="button" onclick="ResetCliente2()" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE NUEVO CLIENTE ######################################-->

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
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Ventas</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">POS Terminal</li>
                                <li class="breadcrumb-item active" aria-current="page">POS</li>
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
            <?php
            $verif_conteo = $tra->VerificarConteoInicialHoy($_SESSION["codsucursal"]);
            ?>
            <div class="card-header bg-danger d-flex justify-content-between align-items-center flex-wrap">
                <h4 class="card-title text-white mb-0"><i class="fa fa-tasks"></i> POS Terminal</h4>
                <div id="contenedor_boton_conteo" class="mt-1 mt-md-0">
                <?php if(!$verif_conteo){ ?>
                    <button type="button" class="btn btn-warning text-dark font-weight-bold shadow-sm pulse-conteo" onclick="AbrirModalConteoInicial()"><i class="fa fa-clipboard"></i> 📦 REGISTRAR INVENTARIO INICIAL (2:00 PM)</button>
                <?php } else { ?>
                    <button type="button" class="btn btn-success font-weight-bold shadow-sm mr-1" onclick="AbrirModalConteoInicial(<?php echo $verif_conteo['idconteo']; ?>)"><i class="fa fa-check-circle"></i> ✅ INVENTARIO INICIAL REGISTRADO (<?php echo date("h:i A", strtotime($verif_conteo['fechaconteo'])); ?>)</button>
                    <a href="reportepdf?idconteo=<?php echo encrypt($verif_conteo['idconteo']); ?>&tipo=<?php echo encrypt("CONTEOINICIAL"); ?>" target="_blank" class="btn btn-light font-weight-bold" title="Descargar Comprobante PDF para WhatsApp"><i class="fa fa-file-pdf-o text-danger"></i> PDF WhatsApp</a>
                <?php } ?>
                </div>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>
            
            <div class="form-body">

              <div class="card-body">

    <div class="row">

        <!-- .col -->
        <div class="col-md-6">
        
        <h3 class="card-subtitle m-0 text-dark"><i class="font-20 mdi mdi-cart-plus"></i> Detalle de Ventas</h3><hr>

        <form class="form form-horizontal" method="post" action="#" name="savepos" id="savepos"> 

    <!-- sample modal content -->
<div id="myModalPago" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
             
            <div id="loadcampos">
            <?php if($arqueo != ""){ ?>
              <h4 class="modal-title text-white" id="myModalLabel"><i class="mdi mdi-desktop-mac"></i> Caja Nº: <?php echo $arqueo[0]["nrocaja"].":".$arqueo[0]["nomcaja"]; ?></h4>
            <?php } ?>
            </div>

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>

            <div class="modal-body">
            <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
            <input type="hidden" name="pagado" id="pagado" value="0.00">
            <input type="hidden" name="creditoinicial" id="creditoinicial" value="0.00">
            <input type="hidden" name="creditodisponible" id="creditodisponible" value="0.00">
            <input type="hidden" name="abonototal" id="abonototal" value="0.00">
            <input type="hidden" name="proceso" id="proceso" value="save">

                <div class="row">
                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total a Pagar</h4>
                       <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextImporte" name="TextImporte">0.00</label></h3>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total Recibido</h4>
                       <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextPagado" name="TextPagado">0.00</label></h3>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Total Cambio</h4>
                       <h3 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCambio" name="TextCambio">0.00</label></h3>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col-md-8">
                       <h4 class="mb-0 font-light">Nombre del Cliente</h4>
                       <h4 class="mb-0 font-medium"> <label id="TextCliente" name="TextCliente">Consumidor Final</label></h4>
                    </div>

                    <div class="col-md-4">
                       <h4 class="mb-0 font-light">Limite de Crédito</h4>
                       <h4 class="mb-0 font-medium"><?php echo $simbolo; ?><label id="TextCredito" name="TextCredito">0.00</label></h4>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Tipo de Documento: <span class="symbol required"></span></label><br>
                                
                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="notaventa" name="tipodocumento" value="NOTA DE VENTA" checked="checked">
                                <label class="custom-control-label" for="notaventa">NOTA VENTA</label>
                                </div>
                            </div>

                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="boleta" name="tipodocumento" value="BOLETA">
                                <label class="custom-control-label" for="boleta">BOLETA</label>
                                </div>
                            </div>

                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="factura" name="tipodocumento" value="FACTURA">
                                <label class="custom-control-label" for="factura">FACTURA</label>
                                </div>
                            </div>

                            <div class="form-check form-check-inline">
                                <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="guia" name="tipodocumento" value="GUIA">
                                <label class="custom-control-label" for="guia">GUIA REMISIÓN</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Condición de Pago: <span class="symbol required"></span></label>
                            <div class="custom-control custom-radio">
                          <input type="radio" class="custom-control-input" id="contado" name="tipopago" value="CONTADO" onClick="CargaCondicionesPagos()" checked="checked">
                            <label class="custom-control-label" for="contado">CONTADO</label>
                            </div>

                            <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="credito" name="tipopago" value="CREDITO" onClick="CargaCondicionesPagos()">
                            <label class="custom-control-label" for="credito">CRÉDITO</label>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="montodevuelto" id="montodevuelto" value="0.00"/>

            <div id="muestra_condiciones"><!-- IF CONDICION PAGO -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback"> 
                            <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
                            <i class="fa fa-bars form-control-feedback"></i>
                            <select style="color:#000;font-weight:bold;" name="pagos[0][codmediopago]" id="codmediopago" class="form-control" title="Seleccione Forma Pago" required aria-required="true">
                            <option value=""> -- SELECCIONE -- </option>
                            <?php
                            $medio = new Login();
                            $medio = $medio->ListarMediosPagos();
                            if($medio==""){ 
                                echo "";
                            } else {
                            for ($i = 0; $i < sizeof($medio); $i++) { ?>
                            <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"<?php if ( ! (strcmp('1',
                                    $medio[$i]['codmediopago']))) echo "selected"; ?>><?php echo $medio[$i]['mediopago'] ?></option>
                            <?php } } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="control-label">Monto Recibido: <span class="symbol required"></span></label>
                        <div class="input-group">
                            <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos[0][montopagado]" id="montopagado" onKeyUp="CalculoDevolucion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off" value="0.00">
                            <div class="input-group-append">
                                <div class="btn-group" data-bs-toggle="buttons">
                                    <button type="button" class="btn btn-info waves-effect waves-light" data-placement="left" title="Agregar" data-original-title="" onclick="addRowPago()"><span class="fa fa-plus"></span></button>
                                </div>
                            </div><!---->
                        </div>
                    </div>
                </div>

            </div><!-- END CONDICION PAGO -->

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group has-feedback">
                            <label class="control-label">Observaciones: </label>
                            <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="1" required="" aria-required="true"></textarea>
                            <i class="fa fa-comments form-control-feedback"></i> 
                        </div>
                    </div>
                </div>
                 
            </div>

            <div class="modal-footer">
                <span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-print"></span> Facturar e Imprimir (F8)</button></span>
                <button class="btn btn-dark" type="reset" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cancelar (F10)</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal --> 

        <?php if($arqueo==""){ ?>

        <div id="muestra_mensaje" class='alert alert-danger text-center'>
        <span class='fa fa-info-circle'></span> POR FAVOR REALICE LA APERTURA DE CAJA PARA PROCESAR VENTAS
        </div>

        <?php } ?>

        <input type="hidden" name="idproducto" id="idproducto">
        <input type="hidden" name="codproducto" id="codproducto">
        <input type="hidden" name="producto" id="producto">
        <input type="hidden" name="descripcion" id="descripcion">
        <input type="hidden" name="imei" id="imei">
        <input type="hidden" name="condicion" id="condicion">
        <input type="hidden" name="codmarca" id="codmarca">
        <input type="hidden" name="marcas" id="marcas">
        <input type="hidden" name="codmodelo" id="codmodelo">
        <input type="hidden" name="modelos" id="modelos">
        <input type="hidden" name="codpresentacion" id="codpresentacion">
        <input type="hidden" name="presentacion" id="presentacion">
        <input type="hidden" name="codcolor" id="codcolor">
        <input type="hidden" name="color" id="color">
        <input type="hidden" name="preciocompra" id="preciocompra"> 
        <input type="hidden" name="precioventa" id="precioventa">
        <input type="hidden" name="precioconiva" id="precioconiva">
        <input type="hidden" name="ivaproducto" id="ivaproducto">
        <input type="hidden" name="descproducto" id="descproducto">
        <input type="hidden" name="cantidad" id="cantidad" value="1">
        <input type="hidden" name="existencia" id="existencia">
        <input type="hidden" name="tipodetalle" id="tipodetalle" value="1">
        <input type="hidden" name="tipoproducto" id="tipoproducto" value="PRODUCTO">
        <input type="hidden" name="preciohora" id="preciohora" value="0.00">

        <div class="row">
            <div class="col-md-12">
                <label class="control-label">Búsqueda de Cliente: </label>
                <div class="input-group mb-3">
                    <div class="input-group-append">
                    <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
                    </div>
                    <input type="hidden" name="codcliente" id="codcliente" value="0">
                    <input type="hidden" name="nrodocumento" id="nrodocumento" value="0">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para la Búsqueda del Cliente" autocomplete="off" value="CONSUMIDOR FINAL"/>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Búsqueda por Lector de Barra: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto_barra" id="search_producto_barra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Código de Barra">
                    <i class="fa fa-barcode form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-6"> 
                <div class="form-group has-feedback"> 
                  <label class="control-label">Búsqueda por Criterio: <span class="symbol required"></span></label>
                  <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_producto" id="search_producto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                  <i class="fa fa-search form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="table-responsive m-t-10 scroll">
            <table id="carrito" class="table table-hover">
                <thead>
                </thead>
                <tbody>
                    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
                        <td class="text-center" colspan=5><h4>NO HAY DETALLES AGREGADOS</h4></td>
                    </tr>
                </tbody>
            </table> 
        </div>

        <div class="table-responsive m-t-10">

    <table id="carritototal" class="table-responsive">
    
    <tr>
    <td></td>
    <td width="250">
    <h5 class="text-left"><label>Gravado <?php echo number_format($valor, 2, '.', ''); ?>%:</label></h5>    
    </td>
    <td width="250">
    <h5 class="text-left"><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>
    </td>
    <td width="250">
    <h5 class="text-left"><label>Exento 0%:</label></h5>    
    </td>
    <td width="250">
    <h5 class="text-right"><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>
    </td>
    <td></td>
    </tr>

    <tr>
    <td></td>
    <td>
    <h5 class="text-left"><label><?php echo $impuesto; ?> <?php echo number_format($valor, 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo $valor; ?>"></label></h5>
    </td>
    <td>
    <h5 class="text-left"><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/></td>
    <td width="180">
    <h5 class="text-left"><label>Descontado %:</label></h5>
    </td>
    <td><h5 class="text-right"><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
    </td>
    <td width="10"></td>      
    </tr>

    <tr>
    <td></td>
    <td colspan="2">
    <h5><label class="text-right">DESC: <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:25px;width:50px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($bod[0]['descsucursal'], 2, '.', ''); ?>">%:</label></h5>
    </td>
    <td colspan="2">
    <h5 class="text-right"> <?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>
    </td>
    <td width="10"></td>
    </tr>

    <tr>
    <td></td>
    <td colspan="2">
    <h4><span class="text-right text-dark alert-link">TOTAL A PAGAR EN :</span> <?php echo $simbolo; ?></h4>
    </td>
    <td colspan="2">
    <h4 class="text-right"> <label id="lbltotal" name="lbltotal">0.00</label></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
    <input type="hidden" name="txtPagado" id="txtPagado" value="0.00"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>
    </td>
    <td width="10"></td>
    </tr>

    <!--<tr>
    <td></td>
    <td colspan="2">
    <h4><span class="text-right text-dark alert-link">TOTAL A PAGAR EN :</span> <?php echo $simbolo2; ?></h4>
    </td>
    <td colspan="2">
    <h4 class="text-right"> <label id="lbltotal2" name="lbltotal2">0.00</label></h4>
    <input type="hidden" name="montocambio" id="montocambio" value="<?php echo number_format($montocambio, 2, '.', ''); ?>"/>
    </td>
    <td width="10"></td>
    </tr>-->

    </table>
     
    </div>

    <!--<span class="pull-right">

    <button type="button" class="btn btn-info waves-effect waves-light" style="cursor: pointer;" title="Productos" onClick="MostrarProductos();"><span class="fa fa-cubes"></span> </button>
        
    </span>-->

    <div class="pull-left">
<button type="button" id="buttonapertura" class="btn btn-info waves-effect waves-light" data-placement="left" title="Aperturar Caja" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalArqueo"><span class="fa fa-desktop"></span> Aperturar Caja</button>
    </div>

    <div class="pull-right">
<button type="button" id="buttonpago" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Cobrar Venta" data-original-title="" data-href="#" disabled="" data-toggle="modal" data-target="#myModalPago"><span class="fa fa-calculator"></span> Cobrar (F2)</button>
<button class="btn btn-dark" type="button" id="vaciar"><span class="fa fa-trash-o"></span> Limpiar (F4)</button>
    </div>

        </form>

        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-6">

        <span class="pull-right">

        <button type="button" class="btn btn-info waves-effect waves-light" style="cursor: pointer;" title="Productos" onClick="MostrarProductos();"><span class="fa fa-cubes"></span> </button>
                        
        <button type="button" class="btn btn-success waves-effect waves-light" style="cursor: pointer;" title="Combos" onClick="MostrarCombos();"><span class="fa fa-archive"></span> </button>

        <button type="button" class="btn btn-warning waves-effect waves-light" style="cursor: pointer;" title="Billar" onClick="MostrarBillar();"><span class="fa fa-clock-o"></span> </button>
        
        </span>

            <div id="loading"></div>

        </div>
       <!-- /.col -->
                                   
    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Row -->


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
    <script type="text/javascript" src="assets/script/jquery.mask.js"></script>
    <script type="text/javascript" src="assets/script/mask.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script>
    // Role-based POS flags accessible to jspos.js
    var posCanEditPrice = <?php echo ($_SESSION['acceso'] === 'cajero' ? 'false' : 'true'); ?>;
    var TIPO_CONTEO_INICIAL = "<?php echo encrypt('CONTEOINICIAL'); ?>";
    </script>
    <script type="text/javascript" src="assets/script/jspos.js?v=3"></script>
    <script type="text/javascript" src="assets/script/jsconteo_inicial.js"></script>
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
    <script type="text/jscript">
    $('#loading').append('<center><i class="fa fa-spin fa-spinner"></i> Por favor espere, cargando registros ......</center>').fadeIn("slow");
    setTimeout(function() {
    $('#loading').load("familias_productos?CargarProductos=si");
     }, 200);
    </script>
    <!-- jQuery -->

    <script id='rowPago' type="text/html">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group has-feedback4"> 
                <i class="fa fa-bars form-control-feedback4"></i> 
                <select style="color:#000;font-weight:bold;" name="pagos[$INDEX][codmediopago]" id="codmediopago" title="Seleccione Forma Pago" class="form-control" required>
                <option value=""> -- SELECCIONE -- </option>
                <?php
                $medio = new Login();
                $medio = $medio->ListarMediosPagos();
                if($medio==""){ 
                    echo "";
                } else {
                for ($i = 0; $i < sizeof($medio); $i++) { ?>
                <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>">
                <?php echo $medio[$i]['mediopago'] ?>
                </option>
                <?php } } ?>
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group">
                <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos[$INDEX][montopagado]" id="montopagado" onKeyUp="CalculoDevolucion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off">
                <div class="input-group-append">
                    <div class="btn-group" data-bs-toggle="buttons">
                        <button type="button" class="btn btn-danger waves-effect waves-light" data-placement="left" title="Quitar" data-original-title="" onclick='rmRowPago(this)'><span class="fa fa-minus"></span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </script>

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