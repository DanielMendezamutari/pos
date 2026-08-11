<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="vendedor") {

$tra = new Login();
$ses = $tra->ExpiraSession();

$bod = new Login();
$bod = $bod->SucursalesSessionPorId(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
$simbolo = ($_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$_SESSION["simbolo"]."</strong>");

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarPreventas();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarPreventas();
exit;
}  
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="agregar") 
{
$reg = $tra->AgregarDetallesPreventas();
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

<!--#################### MODAL PARA BUSQUEDA DE PRODUCTOS #########################-->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-align-justify"></i> Búsqueda de Productos</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
                </div>
                <div class="modal-body">

                <div class="row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-success btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarProductos();"><span class="fa fa-cubes"></span> Productos</button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-info btn-lg btn-block waves-effect waves-light" style="cursor: pointer;" onClick="MostrarCombos();"><span class="fa fa-archive"></span> Combos</button>
                    </div>
                </div><hr>

                <!-- .div load -->
                <div id="loading"></div>
                <!-- /.div load -->

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--#################### MODAL PARA BUSQUEDA DE PRODUCTOS #########################-->

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

            <div id="save">
                <!-- error will be shown here ! -->
            </div>
                
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
                        <input type="hidden" name="formulario" id="formulario" value="forpreventa"/>
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
     <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Preventas</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Preventas</li>
                                <li class="breadcrumb-item active" aria-current="page">Preventa</li>
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
            <h4 class="card-title text-white"><i class="fa fa-save"></i> Gestión de Preventas</h4>
            </div>

<?php if (isset($_GET['codpreventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") {
      
$reg = $tra->PreventasPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updatepreventas" id="updatepreventas" data-id="<?php echo $reg[0]["codpreventa"] ?>">

<?php } else if (isset($_GET['codpreventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") {
      
$reg = $tra->PreventasPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="agregapreventas" id="agregapreventas" data-id="<?php echo $reg[0]["codpreventa"] ?>">
        
<?php } else { ?>
        
 <form class="form form-material" method="post" action="#" name="savepreventas" id="savepreventas">

<?php } ?>
           

    <div id="save">
    <!-- error will be shown here ! -->
    </div>

    <div class="form-body">

    <div class="card-body">
    
    <input type="hidden" name="proceso" id="proceso" <?php if (isset($_GET['codpreventa']) && decrypt($_GET["proceso"])=="U") { ?> value="update" <?php } elseif (isset($_GET['codpreventa']) && decrypt($_GET["proceso"])=="A") { ?> value="agregar" <?php } else { ?> value="save" <?php } ?>>
    <input type="hidden" name="codpreventa" id="codpreventa" <?php if (isset($reg[0]['codpreventa'])) { ?> value="<?php echo encrypt($reg[0]['codpreventa']); ?>"<?php } ?>>
    <input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>"<?php } ?>>
        
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

    <div class="row">
        <div class="col-md-12">
            <label class="control-label">Búsqueda de Cliente: </label>
            <div class="input-group mb-3">
            <div class="input-group-append">
            <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
            </div>
            <input type="hidden" name="codcliente" id="codcliente" <?php if (isset($reg[0]['codcliente'])) { ?> value="<?php echo $reg[0]['codcliente'] == '' ? "0" : $reg[0]['codcliente']; ?>" <?php } else { ?> value="0" <?php } ?>>
            <input type="hidden" name="nrodocumento" id="nrodocumento" <?php if (isset($reg[0]['codcliente'])) { ?> value="<?php echo $reg[0]['codcliente'] == '' ? "0" : $reg[0]['dnicliente']; ?>" <?php } else { ?> value="0" <?php } ?>>
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busqueda" id="busqueda" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Criterio para Búsqueda de Cliente" autocomplete="off" <?php if (isset($reg[0]['codcliente'])) { ?> value="<?php echo $reg[0]['codcliente'] == "" || $reg[0]['codcliente'] == "0" ? "CONSUMIDOR FINAL" : $reg[0]['documento3'].": ".$reg[0]['dnicliente'].": ".$reg[0]['nomcliente']; ?>" <?php } else { ?> value="CONSUMIDOR FINAL" <?php } ?>/>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group has-feedback">
                <label class="control-label">Observaciones: </label>
                <input type="text" class="form-control" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Observación de Preventa" autocomplete="off" <?php if (isset($reg[0]['observaciones'])) { ?> value="<?php echo $reg[0]['observaciones']; ?>" <?php } ?> required="" aria-required="true"/> 
                <i class="fa fa-comments form-control-feedback"></i> 
            </div>
        </div>
    </div>

<?php if (isset($_GET['codpreventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

<div id="detallespreventasupdate">

        <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <?php if ($_SESSION['acceso'] == "administradorS") { ?>
                        <th>Acción</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetallePreventa('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantpreventa[]" id="cantpreventa_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPreventa(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantpreventa"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantpreventabd[]" id="cantpreventabd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantpreventa"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetallePreventa('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
      
    <td class="text-danger alert-link">
    <input type="hidden" name="coddetallepreventa[]" id="coddetallepreventa" value="<?php echo $detalle[$i]["coddetallepreventa"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
    <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    <?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
        <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

    <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
    <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
    <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>

    <td class="text-dark alert-link"><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>

    <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

    <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

    <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventasUpdate('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdiscriminado" id="txtdiscriminado" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="<?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?>"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva"><?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="<?php echo number_format($reg[0]['totaliva'], 2, '.', ''); ?>"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="<?php echo number_format($reg[0]['descontado'], 2, '.', ''); ?>"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento"><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="<?php echo number_format($reg[0]['totaldescuento'], 2, '.', ''); ?>"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal"><?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?></label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
</div>


<?php } else if (isset($_GET['codpreventa']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles Agregados</h2><hr>

<div id="detallespreventasagregar">

        <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
<?php if ($_SESSION['acceso'] == "administradorS") { ?><th>Acción</th><?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
    <tr>
    <td class="text-dark alert-link"><?php echo $a++; ?></td>
      
    <td class="text-danger alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

    <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantpreventa'], 2, '.', ''); ?></td>
      
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>

    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>

    <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>

    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventasAgregar('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>
                                
            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></label></h5>
    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></label></h5>
    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%:</label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaliva'], 2, '.', ','); ?></label></h5>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
        </td>
    
    <td>
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totaldescuento'], 2, '.', ','); ?></label></h5>
    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label><?php echo number_format($reg[0]['totalpago'], 2, '.', ','); ?></label></b></h4>
    </td>
                    </tr>
                  </table>
            </div>
    </div>

        <hr>

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
        <input type="hidden" name="precioconiva" id="precioconiva">
        <input type="hidden" name="ivaproducto" id="ivaproducto">

        <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

        <div class="row">
           <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Tipo de Detalle:</label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="name1" name="tipodetalle" value="1" checked="checked" class="custom-control-input" onclick="VerificaDetalle()">
                        <label class="custom-control-label" for="name1">PRODUCTO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="name2" name="tipodetalle" value="2" class="custom-control-input" onclick="VerificaDetalle()">
                        <label class="custom-control-label" for="name2">COMBO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="name3" name="tipodetalle" value="3" class="custom-control-input" onclick="VerificaDetalle()">
                        <label class="custom-control-label" for="name3">SERVICIO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                  <label class="control-label">Ingrese Criterio para tu Búsqueda: <span class="symbol required"></span></label>
                  <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_busqueda" id="search_busqueda" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                  <i class="fa fa-search form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                   <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
                   <div id="muestra_input">
                   <i class="fa fa-bars form-control-feedback"></i>
                   <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
                   <option value=""> -- SIN RESULTADOS -- </option>
                   </select>
                   </div>
                </div> 
            </div> 

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
                 <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" value="0">
                 <i class="fa fa-bolt form-control-feedback"></i> 
              </div> 
            </div>  

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Descuento: <span class="symbol required"></span></label>
                    <input class="form-control" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento" value="0.00">
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-1"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Cantidad: <span class="symbol required"></span></label>
                 <input type="text" class="form-control" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad">
                 <i class="fa fa-bolt form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="pull-right">
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="MostrarProductos()"><i class="fa fa-search"></i> Búsqueda</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
        </div></br>

        <div class="table-responsive m-t-40">
            <table id="carrito" class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
                        <td class="text-center" colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>
                    </tr>
                </tbody>
              </table><hr>

             <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($valor, 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($valor, 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($valor, 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($bod[0]['descsucursal'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>    </td>
                    </tr>
                  </table>
        </div>


<?php } else { ?>

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
        <input type="hidden" name="precioconiva" id="precioconiva">
        <input type="hidden" name="ivaproducto" id="ivaproducto">

        <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="control-label">Tipo de Detalle:</label> 
                    <br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="name1" name="tipodetalle" value="1" checked="checked" class="custom-control-input" onclick="VerificaDetalle()">
                        <label class="custom-control-label" for="name1">PRODUCTO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="name2" name="tipodetalle" value="2" class="custom-control-input" onclick="VerificaDetalle()">
                        <label class="custom-control-label" for="name2">COMBO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="name3" name="tipodetalle" value="3" class="custom-control-input" onclick="VerificaDetalle()">
                        <label class="custom-control-label" for="name3">SERVICIO</label>
                    </div>
                </div>
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback"> 
                  <label class="control-label">Ingrese Criterio para tu Búsqueda: <span class="symbol required"></span></label>
                  <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_busqueda" id="search_busqueda" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                  <i class="fa fa-search form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                   <label class="control-label">Precio Unitario: <span class="symbol required"></span></label>
                   <div id="muestra_input">
                   <i class="fa fa-bars form-control-feedback"></i>
                   <select style="color:#000;font-weight:bold;" name="precioventa" id="precioventa" class='form-control'>
                   <option value=""> -- SIN RESULTADOS -- </option>
                   </select>
                   </div>
                </div> 
            </div> 

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Stock Actual: <span class="symbol required"></span></label>
                 <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Existencia" disabled="disabled" value="0">
                 <i class="fa fa-bolt form-control-feedback"></i> 
              </div> 
            </div>  

            <div class="col-md-2"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Descuento: <span class="symbol required"></span></label>
                    <input class="form-control" type="text" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descuento" value="0.00">
                    <i class="fa fa-tint form-control-feedback"></i> 
                </div> 
            </div>

            <div class="col-md-1"> 
                <div class="form-group has-feedback"> 
                 <label class="control-label">Cantidad: <span class="symbol required"></span></label>
                 <input type="text" class="form-control" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Cantidad">
                 <i class="fa fa-bolt form-control-feedback"></i> 
                </div> 
            </div>
        </div>

        <div class="pull-right">
    <button type="button" class="btn btn-success" data-placement="left" title="Buscar Productos" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="MostrarProductos()"><i class="fa fa-search"></i> Búsqueda</button>
    <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
        </div></br>

        <div class="table-responsive m-t-40">
            <table id="carrito" class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
                        <td class="text-center" colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td>
                    </tr>
                </tbody>
              </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($valor, 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($valor, 2, '.', ''); ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($valor, 2, '.', ''); ?>"></label></h5>
    </td>

    <td class="text-center" width="250">
    <h5><?php echo $simbolo; ?><label id="lbliva" name="lbliva">0.00</label></h5>
    <input type="hidden" name="txtIva" id="txtIva" value="0.00"/>
    </td>
                </tr>
                <tr>
    <td>
    <h5><label>Descontado %:</label></h5> </td>
    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado">0.00</label></h5>
    <input type="hidden" name="txtdescontado" id="txtdescontado" value="0.00"/>
        </td>
    
    <td>
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($bod[0]['descsucursal'], 2, '.', ''); ?>">%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/>    </td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="0.00"/>    </td>
                    </tr>
                  </table>
        </div>


<?php } ?> 

<div class="clearfix"></div>
<hr>
              <div class="text-right">
<?php  if (isset($_GET['codpreventa']) && decrypt($_GET["proceso"])=="U") { ?>
<span id="submit_update"><button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button></span>
<a href="preventas"><button class="btn btn-dark" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button></a> 
<?php } else if (isset($_GET['codpreventa']) && decrypt($_GET["proceso"])=="A") { ?>  
<span id="submit_agregar"><button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button></span>
<button class="btn btn-dark" type="button" id="vaciar2" onclick="Refrescar();"><span class="fa fa-trash-o"></span> Cancelar</button>
<?php } else { ?>  
<span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button></span>
<button class="btn btn-dark" type="button" id="vaciar" onclick="Refrescar();"><i class="fa fa-trash-o"></i> Limpiar (F4)</button>
<?php } ?>
</div>

          </div>
       </div>
     </form>
   </div>
  </div>
<!--</div>
 End Row -->


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
    <script type="text/javascript" src="assets/script/jspreventas.js"></script>
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