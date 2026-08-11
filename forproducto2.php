<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarProductos();
exit;
} 
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarProductos();
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
        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Productos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Mantenimiento</li>
                                <li class="breadcrumb-item active" aria-current="page">Productos</li>
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
                <h4 class="card-title text-white"><i class="fa fa-save"></i> Gestión de Productos</h4>
            </div>

    <?php if (isset($_GET['codproducto']) && isset($_GET['codsucursal'])) {
      
    $reg = $tra->ProductosPorId(); ?>
      
    <form class="form form-material" method="post" action="#" name="updateproductos" id="updateproductos" data-id="<?php echo $reg[0]["codproducto"] ?>" enctype="multipart/form-data">
        
    <?php } else { ?>
        
    <form class="form form-material" method="post" action="#" name="saveproductos" id="saveproductos" enctype="multipart/form-data">
      
    <?php } ?>

    <div id="save">
    <!-- error will be shown here ! -->
    </div>

    <div class="form-body">

        <div class="card-body">

        <?php if ($_SESSION['acceso'] == "administradorG") { ?> 
        <div class="row">
            <div class="col-md-12"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if (isset($reg[0]['codsucursal'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" onChange="CargaFamiliasxSucursal(this.form.codsucursal.value,0); CargaMarcasxSucursal(this.form.codsucursal.value,0); CargaPresentacionesxSucursal(this.form.codsucursal.value); CargaColoresxSucursal(this.form.codsucursal.value); CargaProveedoresxSucursal(this.form.codsucursal.value);" class="form-control" required= "" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $sucursal = new Login();
                    $sucursal = $sucursal->ListarSucursales();
                    if($sucursal==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($sucursal);$i++){ ?>
                    <option value="<?php echo encrypt($sucursal[$i]['codsucursal']) ?>"<?php if (!(strcmp($reg[0]['codsucursal'], htmlentities($sucursal[$i]['codsucursal'])))) { echo "selected=\"selected\""; } ?>><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal'] ?></option>        
                    <?php } } ?>
                    </select>
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" onChange="CargaFamiliasxSucursal(this.form.codsucursal.value,0); CargaMarcasxSucursal(this.form.codsucursal.value,0); CargaPresentacionesxSucursal(this.form.codsucursal.value); CargaColoresxSucursal(this.form.codsucursal.value); CargaProveedoresxSucursal(this.form.codsucursal.value);" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $sucursal = new Login();
                    $sucursal = $sucursal->ListarSucursales();
                    if($sucursal==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($sucursal);$i++){ ?>
                    <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal'] ?></option>
                    <?php } } ?>
                    </select>
                    <?php } ?> 
                </div> 
            </div> 
        </div>
        <?php } else {  ?> 
        <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
        <?php } ?>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Código de Producto: <span class="symbol required"></span></label>
                    <input type="hidden" name="idproducto" id="idproducto" <?php if (isset($reg[0]['idproducto'])) { ?> value="<?php echo encrypt($reg[0]['idproducto']); ?>"<?php } ?>>
                    <input type="hidden" name="formulario" id="formulario" value="forproducto2">
                    <input type="hidden" name="tipousuario" id="tipousuario" value="<?php echo ($_SESSION["acceso"]=="administradorG" ? 1 : 2) ?>"/>
                    <input type="hidden" name="modulo" id="modulo" value="2">
                    <input type="hidden" name="proceso" id="proceso" <?php if (isset($reg[0]['idproducto'])) { ?> value="update" <?php } else { ?> value="save" <?php } ?>/>
                    <input type="text" class="form-control" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Código de Producto" autocomplete="off" <?php if (isset($reg[0]['codproducto'])) { ?> value="<?php echo $reg[0]['codproducto']; ?>" readonly="readonly" <?php } else { ?><?php } ?> required="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Producto: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Producto" autocomplete="off" <?php if (isset($reg[0]['producto'])) { ?> value="<?php echo $reg[0]['producto']; ?>" <?php } ?> required="" aria-required="true"/>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Descripción de Producto: </label> 
                    <textarea class="form-control" type="text" name="descripcion" id="descripcion" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripción de Producto" rows="1"><?php if (isset($reg[0]['descripcion'])) { echo $reg[0]['descripcion']; } ?></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Imei: </label>
                    <input type="text" class="form-control" name="imei" id="imei" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Imei" autocomplete="off" <?php if (isset($reg[0]['imei'])) { ?> value="<?php echo $reg[0]['imei']; ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Condición de Producto: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="condicion" id="condicion" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Condición" autocomplete="off" <?php if (isset($reg[0]['condicion'])) { ?> value="<?php echo $reg[0]['condicion']; ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Familia: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if ($_SESSION['acceso'] == "administradorG" && !isset($reg[0]['codfamilia'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codfamilia" id="codfamilia" class='form-control' required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select>
                    <?php } elseif (isset($reg[0]['codfamilia'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codfamilia" id="codfamilia" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $familia = new Login();
                    $familia = $familia->ListarFamilias();
                    if($familia==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($familia);$i++){ ?>
                    <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"<?php if (!(strcmp($reg[0]['codfamilia'], htmlentities($familia[$i]['codfamilia'])))) { echo "selected=\"selected\"";} ?>><?php echo $familia[$i]['nomfamilia'] ?></option>        
                    <?php } } ?>
                    </select>  
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="codfamilia" id="codfamilia" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $familia = new Login();
                    $familia = $familia->ListarFamilias();
                    if($familia==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($familia);$i++){ ?>
                    <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"><?php echo $familia[$i]['nomfamilia'] ?></option>        
                    <?php } } ?>
                    </select>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Marca: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if ($_SESSION['acceso'] == "administradorG" && !isset($reg[0]['codmarca'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codmarca" id="codmarca" onChange="CargaModelos(this.form.codmarca.value);" class='form-control' required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select>
                    <?php } elseif (isset($reg[0]['codmarca'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codmarca" id="codmarca" onChange="CargaModelos(this.form.codmarca.value);" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $marca = new Login();
                    $marca = $marca->ListarMarcas();
                    if($marca==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($marca);$i++){ ?>
                    <option value="<?php echo encrypt($marca[$i]['codmarca']); ?>"<?php if (!(strcmp($reg[0]['codmarca'], htmlentities($marca[$i]['codmarca'])))) { echo "selected=\"selected\""; } ?>><?php echo $marca[$i]['nommarca'] ?></option> 
                    <?php } } ?>
                    </select>
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="codmarca" id="codmarca" onChange="CargaModelos(this.form.codmarca.value);" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $marca = new Login();
                    $marca = $marca->ListarMarcas();
                    if($marca==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($marca);$i++){ ?>
                    <option value="<?php echo encrypt($marca[$i]['codmarca']); ?>"><?php echo $marca[$i]['nommarca'] ?></option>
                    <?php } } ?>
                    </select>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Modelo: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if (isset($reg[0]['codmodelo'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codmodelo" id="codmodelo" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $modelo = new Login();
                    $modelo = $modelo->ListarModelosAsignados($reg[0]['codmarca']);
                    if($modelo==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($modelo);$i++){ ?>
                    <option value="<?php echo encrypt($modelo[$i]['codmodelo']); ?>"<?php if (!(strcmp($reg[0]['codmodelo'], htmlentities($modelo[$i]['codmodelo'])))) { echo "selected=\"selected\""; } ?>><?php echo $modelo[$i]['nommodelo']; ?></option> 
                    <?php } } ?>
                    </select>
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="codmodelo" id="codmodelo" class='form-control' required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select> 
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Presentación: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if ($_SESSION['acceso'] == "administradorG" && !isset($reg[0]['codpresentacion'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codpresentacion" id="codpresentacion" class='form-control' required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select>
                    <?php } elseif (isset($reg[0]['codpresentacion'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codpresentacion" id="codpresentacion" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $presentacion = new Login();
                    $presentacion = $presentacion->ListarPresentaciones();
                    if($presentacion==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($presentacion);$i++){ ?>
                    <option value="<?php echo encrypt($presentacion[$i]['codpresentacion']); ?>"<?php if (!(strcmp($reg[0]['codpresentacion'], htmlentities($presentacion[$i]['codpresentacion'])))) {echo "selected=\"selected\"";} ?>><?php echo $presentacion[$i]['nompresentacion'] ?></option>        
                    <?php } } ?>
                    </select> 
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="codpresentacion" id="codpresentacion" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $presentacion = new Login();
                    $presentacion = $presentacion->ListarPresentaciones();
                    if($presentacion==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($presentacion);$i++){ ?>
                    <option value="<?php echo encrypt($presentacion[$i]['codpresentacion']); ?>"><?php echo $presentacion[$i]['nompresentacion'] ?></option>        
                    <?php } } ?>
                    </select> 
                    <?php } ?> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Color: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if ($_SESSION['acceso'] == "administradorG" && !isset($reg[0]['codcolor'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codcolor" id="codcolor" class='form-control' required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select>
                    <?php } elseif (isset($reg[0]['codcolor'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codcolor" id="codcolor" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $color = new Login();
                    $color = $color->ListarColores();
                    if($color==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($color);$i++){ ?>
                    <option value="<?php echo encrypt($color[$i]['codcolor']); ?>"<?php if (!(strcmp($reg[0]['codcolor'], htmlentities($color[$i]['codcolor'])))) { echo "selected=\"selected\""; } ?>><?php echo $color[$i]['nomcolor'] ?></option>        
                    <?php } } ?>
                    </select>  
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="codcolor" id="codcolor" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $color = new Login();
                    $color = $color->ListarColores();
                    if($color==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($color);$i++){ ?>
                    <option value="<?php echo encrypt($color[$i]['codcolor']); ?>"><?php echo $color[$i]['nomcolor'] ?></option><?php } } ?>
                    </select> 
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                    <input type="hidden" name="porcentaje" id="porcentaje" <?php if ($_SESSION['acceso'] == "administradorG") { ?> value="0.00" <?php } else { ?> value="<?php echo number_format($_SESSION['porcentaje'], 2, '.', ''); ?>" <?php } ?>>
                    <input type="text" class="form-control calculoprecio" name="preciocompra" id="preciocompra" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio de Compra" autocomplete="off" <?php if (isset($reg[0]['preciocompra'])) { ?> value="<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio Venta x Público: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="precioxpublico" id="precioxpublico" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio Venta x Público" autocomplete="off" <?php if (isset($reg[0]['precioxpublico'])) { ?> value="<?php echo number_format($reg[0]['precioxpublico'], 2, '.', ''); ?>" <?php } ?>  required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Existencia: <span class="symbol required"></span></label>
                    <input type="hidden" class="form-control" name="existencia2" id="existencia2" <?php if (isset($reg[0]['existencia'])) { ?> value="<?php echo $reg[0]['existencia']; ?>" <?php } ?> />
                     <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Existencia" autocomplete="off" <?php if (isset($reg[0]['existencia'])) { ?> value="<?php echo $reg[0]['existencia']; ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Código de Barra: </label>
                    <input type="text" class="form-control" name="codigobarra" id="codigobarra" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Código de Barra" autocomplete="off" <?php if (isset($reg[0]['codigobarra'])) { ?> value="<?php echo $reg[0]['codigobarra']; ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-barcode form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione <?php echo $impuesto; ?>: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if (isset($reg[0]['ivaproducto'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="ivaproducto" id="ivaproducto" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="SI"<?php if (!(strcmp('SI', $reg[0]['ivaproducto']))) {echo "selected=\"selected\"";} ?>>SI</option>
                    <option value="NO"<?php if (!(strcmp('NO', $reg[0]['ivaproducto']))) {echo "selected=\"selected\"";} ?>>NO</option>
                    </select>
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="ivaproducto" id="ivaproducto" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                    </select>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Descuento de Producto: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Descuento" autocomplete="off" <?php if (isset($reg[0]['descproducto'])) { ?> value="<?php echo number_format($reg[0]['descproducto'], 2, '.', ''); ?>" <?php } else { ?> value="0.00" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Proveedor: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if ($_SESSION['acceso'] == "administradorG" && !isset($reg[0]['codproveedor'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select>
                    <?php } elseif (isset($reg[0]['codproveedor'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $proveedor = new Login();
                    $proveedor = $proveedor->ListarProveedores();
                    if($proveedor==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($proveedor);$i++){ ?>
                    <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>"<?php if (!(strcmp($reg[0]['codproveedor'], htmlentities($proveedor[$i]['codproveedor'])))) {echo "selected=\"selected\""; } ?>><?php echo $proveedor[$i]['nomproveedor'] ?></option>        
                    <?php } } ?>
                    </select>
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <?php
                    $proveedor = new Login();
                    $proveedor = $proveedor->ListarProveedores();
                    if($proveedor==""){ 
                        echo "";
                    } else {
                    for($i=0;$i<sizeof($proveedor);$i++){ ?>
                    <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>"><?php echo $proveedor[$i]['nomproveedor'] ?></option>        
                    <?php } } ?>
                    </select>
                    <?php } ?> 
                </div>
            </div>

            <input type="hidden" name="fabricante" id="fabricante" <?php if (isset($reg[0]['fabricante'])) { ?> value="<?php echo $reg[0]['fabricante']; ?>" <?php } ?>/>
            <input type="hidden" name="codsubfamilia" id="codsubfamilia" <?php if (isset($reg[0]['fabricante'])) { ?> value="<?php echo encrypt($reg[0]['codsubfamilia']); ?>" <?php } ?>/>
            <input type="hidden" name="codorigen" id="codorigen" <?php if (isset($reg[0]['fabricante'])) { ?> value="<?php echo encrypt($reg[0]['codorigen']); ?>" <?php } ?>/>
            <input type="hidden" name="year" id="year" <?php if (isset($reg[0]['year'])) { ?> value="<?php echo $reg[0]['year']; ?>" <?php } ?>/>  
            <input type="hidden" name="nroparte" id="nroparte" <?php if (isset($reg[0]['nroparte'])) { ?> value="<?php echo $reg[0]['nroparte']; ?>" <?php } ?>/>
            <input type="hidden" name="lote" id="lote" <?php if (isset($reg[0]['lote'])) { ?> value="<?php echo $reg[0]['lote']; ?>" <?php } ?>/>
            <input type="hidden" name="peso" id="peso" <?php if (isset($reg[0]['peso'])) { ?> value="<?php echo $reg[0]['peso']; ?>" <?php } ?>/>  
            <input type="hidden" name="precioxmayor" id="precioxmayor" <?php if (isset($reg[0]['precioxmayor'])) { ?> value="<?php echo number_format($reg[0]['precioxmayor'], 2, '.', ''); ?>" <?php } ?> />  
            <input type="hidden" name="precioxmenor" id="precioxmenor" <?php if (isset($reg[0]['precioxmenor'])) { ?> value="<?php echo number_format($reg[0]['precioxmenor'], 2, '.', ''); ?>" <?php } ?>/> 
            <input type="hidden" name="stockoptimo" id="stockoptimo" <?php if (isset($reg[0]['stockoptimo'])) { ?> value="<?php echo $reg[0]['stockoptimo']; ?>" <?php } ?>/>
            <input type="hidden" name="stockmedio" id="stockmedio" <?php if (isset($reg[0]['stockmedio'])) { ?> value="<?php echo $reg[0]['stockmedio']; ?>" <?php } ?> />
            <input type="hidden" name="stockminimo" id="stockminimo" <?php if (isset($reg[0]['stockminimo'])) { ?> value="<?php echo $reg[0]['stockminimo']; ?>" <?php } ?>/> 
            <input type="hidden" name="fechaelaboracion" id="fechaelaboracion" <?php if (isset($reg[0]['fechaelaboracion'])) { ?> value="<?php echo $reg[0]['fechaelaboracion'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaelaboracion'])); ?>"<?php } ?>/>
            <input type="hidden" name="fechaoptimo" id="fechaoptimo" <?php if (isset($reg[0]['fechaoptimo'])) { ?> value="<?php echo $reg[0]['fechaoptimo'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaoptimo'])); ?>"<?php } ?>/>  
            <input type="hidden" name="fechamedio" id="fechamedio" <?php if (isset($reg[0]['fechamedio'])) { ?> value="<?php echo $reg[0]['fechamedio'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechamedio'])); ?>"<?php } ?>/>
            <input type="hidden" name="fechaminimo" id="fechaminimo" <?php if (isset($reg[0]['fechaminimo'])) { ?> value="<?php echo $reg[0]['fechaminimo'] == '0000-00-00' ? "" : date("d-m-Y",strtotime($reg[0]['fechaminimo'])); ?>"<?php } ?>/>  

            <div class="col-md-3">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 130px; height: 130px;">
                    <?php 
                    if (isset($reg[0]['codproducto'])) {
                        if (file_exists("fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]["codproducto"].".jpg")){
                            echo "<img src='fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]['codproducto'].".jpg?".date('h:i:s')."' class='rounded-circle' width='130' height='130'>";
                        } else if (file_exists("fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]["codproducto"].".jpeg")){
                            echo "<img src='fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]["codproducto"].".jpeg?".date('h:i:s')."' class='rounded-circle' width='130' height='130'>";
                        } else if (file_exists("fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]["codproducto"].".png")){
                            echo "<img src='fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]["codproducto"].".png?".date('h:i:s')."' class='rounded-circle' width='130' height='130'>";
                        } else {
                            echo "<img src='fotos/img.png' class='rounded-circle' width='130' height='130'>"; 
                            } } else {
                            echo "<img src='fotos/img.png' class='rounded-circle' width='130' height='130'>"; 
                        }
                    ?>
                    </div>
                    <div>
                    <span class="btn btn-success btn-file">
                    <span class="fileinput-new" data-trigger="fileinput"><i class="fa fa-file-image-o"></i> Cargar Imagen</span>
                    <span class="fileinput-exists" data-trigger="fileinput"><i class="fa fa-paint-brush"></i> Cargar Imagen</span>
                    <input type="file" size="10" data-original-title="Subir Fotografia" data-rel="tooltip" placeholder="Suba su Fotografia" name="imagen" id="imagen"/>
                    </span>
                    <a href="#" class="btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times-circle"></i> Remover</a><small><p>Para Subir la Imagen debe tener en cuenta:<br> * La Imagen debe ser extension (jpg, png)</p></small>
                    </div>
                </div>
            </div>
        </div>

            <div class="text-right">
    <?php if (isset($_GET['codproducto'])) { ?>
<button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button>
<button class="btn btn-dark" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button> 
    <?php } else { ?>
<button type="submit" name="btn-save" id="btn-save" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
<button class="btn btn-dark" type="reset"><span class="fa fa-trash-o"></span> Limpiar</button>
    <?php } ?>  
             </div>
          </div>
      </div>
    </form>
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
        document.location.href='productos'   
        </script> 
<?php } } else { ?>
        <script type='text/javascript' language='javascript'>
        alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION')  
        document.location.href='logout'  
        </script> 
<?php } ?>