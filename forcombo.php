<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$_SESSION["simbolo"]."</strong>");

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarCombos();
exit;
} 
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarCombos();
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
                    <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Combos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Mantenimiento</li>
                                <li class="breadcrumb-item active" aria-current="page">Combos</li>
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
 
<?php  if (isset($_GET['codcombo'])) {
      
      $reg = $tra->CombosPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updatecombo" id="updatecombo" data-id="<?php echo $reg[0]["codcombo"] ?>" enctype="multipart/form-data">
        
    <?php } else { ?>
        
<form class="form form-material" method="post" action="#" name="savecombo" id="savecombo" enctype="multipart/form-data">
      
    <?php } ?>

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Gestión de Combos</h4>
            </div>

            <div id="save">
            <!-- error will be shown here ! -->
            </div>

    <?php  if (isset($_GET['codcombo']) && isset($_GET['codsucursal'])) {
      
      $reg = $tra->CombosPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updatecombo" id="updatecombo" data-id="<?php echo $reg[0]["codcombo"] ?>" enctype="multipart/form-data">
        
    <?php } else { ?>
        
<form class="form form-material" method="post" action="#" name="savecombo" id="savecombo" enctype="multipart/form-data">
      
    <?php } ?>
            
            <div class="form-body">

              <div class="card-body">

    <div class="row">

        <!-- .col -->
        <div class="col-md-3">
        
        <h3 class="card-subtitle m-0 text-dark"><i class="font-20 fa fa-file-image-o"></i> Foto de Combo</h3><hr>

        <div class="row">
                    <div class="col-md-12">
                      <div class="text-center"><div class="fileinput fileinput-new" data-provides="fileinput">
                          <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 160px; height: 160px;">
                            <?php 
                            if (isset($reg[0]['codcombo'])) {
                                if (file_exists("fotos/combos/".$reg[0]['codsucursal']."_".$reg[0]["codcombo"].".jpg")){
                                    echo "<img src='fotos/combos/".$reg[0]['codsucursal']."_".$reg[0]['codcombo'].".jpg?".date('h:i:s')."' class='rounded-circle' width='160' height='160'>";
                                } else if (file_exists("fotos/combos/".$reg[0]['codsucursal']."_".$reg[0]["codcombo"].".jpeg")){
                                    echo "<img src='fotos/combos/".$reg[0]['codsucursal']."_".$reg[0]["codcombo"].".jpeg?".date('h:i:s')."' class='rounded-circle' width='160' height='160'>";
                                } else if (file_exists("fotos/combos/".$reg[0]['codsucursal']."_".$reg[0]["codcombo"].".png")){
                                    echo "<img src='fotos/combos/".$reg[0]['codsucursal']."_".$reg[0]["codcombo"].".png?".date('h:i:s')."' class='rounded-circle' width='160' height='160'>";
                                } else {
                                echo "<img src='fotos/img.png' class='rounded-circle' width='160' height='160'>"; 
                                } } else {
                                echo "<img src='fotos/img.png' class='rounded-circle' width='160' height='160'>"; 
                            }
                            ?>
                      </div>
                      <div>
                          <span class="btn btn-success btn-file">
                              <span class="fileinput-new" data-trigger="fileinput"><i class="fa fa-file-image-o"></i> Cargar Imagen</span>
                              <span class="fileinput-exists" data-trigger="fileinput"><i class="fa fa-paint-brush"></i> Cargar Imagen</span>
                              <input type="file" size="10" data-original-title="Subir Fotografia" data-rel="tooltip" placeholder="Suba su Fotografia" name="imagen" id="imagen"/>
                          </span>
                          <a href="#" class="btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times-circle"></i> Remover</a>                             
                      </div></div>
                      </div>
                  </div>
                </div>

        </div>
        <!-- /.col -->
        
        <!-- .col -->  
        <div class="col-md-9">

        <h3 class="card-subtitle m-0 text-dark"><i class="font-20 fa fa-tasks"></i> Detalle de Combo</h3><hr>
            
        <?php if ($_SESSION['acceso'] == "administradorG") { ?> 
        <div class="row">
            <div class="col-md-12"> 
                <div class="form-group has-feedback"> 
                    <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if (isset($reg[0]['codsucursal'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" onChange="CargaFamiliasxSucursal(this.form.codsucursal.value,0);" class="form-control" required= "" aria-required="true">
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
                    <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" onChange="CargaFamiliasxSucursal(this.form.codsucursal.value,0);" class="form-control" required="" aria-required="true">
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
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Combo: <span class="symbol required"></span></label>
                    <input type="hidden" name="idcombo" id="idcombo" <?php if (isset($reg[0]['idcombo'])) { ?> value="<?php echo encrypt($reg[0]['idcombo']); ?>"<?php } ?>>
                    <input type="hidden" name="proceso" id="proceso" <?php if (isset($reg[0]['idcombo'])) { ?> value="update" <?php } else { ?> value="save" <?php } ?>/>
                    <input type="hidden" name="tipousuario" id="tipousuario" value="<?php echo ($_SESSION["acceso"]=="administradorG" ? 1 : 2) ?>"/>
                    <?php if (isset($reg[0]['codcombo'])) { ?>
                    <input type="hidden" name="codcombo" id="codcombo"  value="<?php echo encrypt($reg[0]['codcombo']); ?>"/> 
                    <?php } ?>
                    <input type="text" class="form-control" name="nomcombo" id="nomcombo" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Combo" autocomplete="off" <?php if (isset($reg[0]['nomcombo'])) { ?> value="<?php echo $reg[0]['nomcombo']; ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>                

            <div class="col-md-4">
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
                    <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"><?php echo $familia[$i]['nomfamilia'] ?></option> <?php } } ?>
                    </select>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="preciocompra" id="preciocompra" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio de Compra" autocomplete="off" <?php if (isset($reg[0]['preciocompra'])) { ?> value="<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>" <?php } else { ?> value="0.00" <?php } ?> required="" aria-required="true"/><i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Venta (P.V.P): <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio de Venta" autocomplete="off" <?php if (isset($reg[0]['precioventa'])) { ?> value="<?php echo number_format($reg[0]['precioventa'], 2, '.', ''); ?>" <?php } ?>  required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Existencia de Combo: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Existencia de Combo" autocomplete="off" <?php if (isset($reg[0]['existencia'])) { ?> value="<?php echo $reg[0]['existencia']; ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Stock Minimo: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="stockminimo" id="stockminimo" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Stock Minimo" autocomplete="off" <?php if (isset($reg[0]['stockminimo'])) { ?> value="<?php echo $reg[0]['stockminimo']; ?>" <?php } else { ?> value="0" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-bolt form-control-feedback"></i> 
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Stock Máximo: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="stockmaximo" id="stockmaximo" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Stock Máximo" autocomplete="off" <?php if (isset($reg[0]['stockmaximo'])) { ?> value="<?php echo $reg[0]['stockmaximo']; ?>" <?php } else { ?> value="0" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label"><?php echo $impuesto; ?> de Combo: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <?php if (isset($reg[0]['ivacombo'])) { ?>
                    <select style="color:#000;font-weight:bold;" name="ivacombo" id="ivacombo" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="SI"<?php if (!(strcmp('SI', $reg[0]['ivacombo']))) {echo "selected=\"selected\"";} ?>>SI</option>
                    <option value="NO"<?php if (!(strcmp('NO', $reg[0]['ivacombo']))) {echo "selected=\"selected\"";} ?>>NO</option>
                    </select>
                    <?php } else { ?>
                    <select style="color:#000;font-weight:bold;" name="ivacombo" id="ivacombo" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                    </select>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Descuento de Combo: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="desccombo" id="desccombo" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Descuento de Combo" autocomplete="off" <?php if (isset($reg[0]['desccombo'])) { ?> value="<?php echo $reg[0]['desccombo']; ?>" <?php } else { ?> value="0.00" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>
        </div>

        </div>
       <!-- /.col -->
                                   
    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Row -->


<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
                <h4 class="card-title text-white"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Productos</h4>
            </div>

        <div class="form-body">

        <div class="card-body">

        <?php if (!isset($_GET['codcombo'])) { ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group has-feedback">
                    <label class="control-label">Búsqueda de Producto: </label>
                    <input type="hidden" name="idproducto" id="idproducto">
                    <input type="hidden" name="codproducto" id="codproducto">
                    <input type="hidden" name="producto" id="producto">
                    <input type="hidden" name="codmarca" id="codmarca">
                    <input type="hidden" name="marcas" id="marcas">
                    <input type="hidden" name="codmodelo" id="codmodelo">
                    <input type="hidden" name="modelos" id="modelos">
                    <input type="hidden" name="codpresentacion" id="codpresentacion">
                    <input type="hidden" name="preciocompradet" id="preciocompradet">
                    <input type="hidden" name="precioventadet" id="precioventadet">
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control agregaproducto" name="search_producto_sucursal" id="search_producto_sucursal" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Realice la Búsqueda de Producto" autocomplete="off"/>
                  <i class="fa fa-search form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-3">  
                <div class="form-group has-feedback"> 
                    <label class="control-label">Cantidad de Producto: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control agregaproducto" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Cantidad de Producto" title="Ingrese Cantidad de Producto" autocomplete="off" value="1"/>  
                    <i class="fa fa-pencil form-control-feedback"></i>                                           
                </div>
            </div>

            <div class="col-md-3">  
                <div class="form-group has-feedback"> 
                    <label class="control-label">Presentación: </label>
                    <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="presentacion" id="presentacion" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Presentación" autocomplete="off" readonly=""/>  
                    <i class="fa fa-pencil form-control-feedback"></i>                                           
                </div>
            </div>  
        </div>
        
        <div class="text-left">
    <button type="button" id="AgregaProducto" class="btn btn-success"><span class="fa fa-cart-plus"></span> Agregar</button>
    <button class="btn btn-dark" type="button" id="vaciar"><i class="fa fa-trash-o"></i> Vaciar</button>
        </div>

        <div class="table-responsive m-t-20">
            <table id="carrito" class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>Cantidad</th>
                        <th>Descripción</th>
                        <th>Presentación</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
                        <td class="text-center" colspan=6><h4>NO HAY DETALLES AGREGADOS</h4></td>
                    </tr>
                </tbody>
            </table> 
        </div>

        <?php } else { ?>

        <div id="cargaproductos"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
            <tr role="row">
            </tr>
            <tr>
                <th>Nº</th>
                <th>Cantidad</th>
                <th>Producto</th>
                <th>Existencia</th>
                <th>Precio Compra</th>
                <th>Precio Venta</th>
            </tr>
            </thead>
            <tbody>
<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesProductos();

if($busq==""){

echo "";      

} else {

$count = 0;
for($i=0;$i<sizeof($busq);$i++){
$count++; 
?>
    <tr class="warning-element text-dark alert-link" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td class="text-dark alert-link"><?php echo $a++; ?></td>
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleProducto('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoProducto(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($busq[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($busq[$i]["cantidad"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleProducto('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
    <td>
    <input type="hidden" name="iddetallecombo[]" id="iddetallecombo_<?php echo $count; ?>" value="<?php echo $busq[$i]["iddetallecombo"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto_<?php echo $count; ?>" value="<?php echo $busq[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto_<?php echo $count; ?>" value="<?php echo $busq[$i]["codproducto"]; ?>">
    <input type="hidden" name="preciocompradet[]" id="preciocompradet_<?php echo $count; ?>" value="<?php echo $busq[$i]["cantidad"]*$busq[$i]["preciocompra"]; ?>">
    <input type="hidden" name="precioventadet[]" id="precioventadet_<?php echo $count; ?>" value="<?php echo $busq[$i]["cantidad"]*$busq[$i]["precioventa"]; ?>">
    <input type="hidden" class="preciocompradet" name="montocompra[]" id="montocompra_<?php echo $count; ?>" value="<?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["preciocompra"], 2, '.', ''); ?>">
    <input type="hidden" class="precioventadet" name="montoventa[]" id="montoventa_<?php echo $count; ?>" value="<?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["precioventa"], 2, '.', ''); ?>">
    <?php echo $busq[$i]["producto"]; ?>
    </td>
    <td><?php echo $busq[$i]["existencia"]; ?></td>
    <td><label id="txtmontocompra_<?php echo $count; ?>"><?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["preciocompra"], 2, '.', ','); ?></label></td>
    <td><label id="txtmontoventa_<?php echo $count; ?>"><?php echo number_format($busq[$i]["cantidad"]*$busq[$i]["precioventa"], 2, '.', ','); ?></label></td>
    </tr><?php } } ?>
    </tbody>
    </table></div><br>

    <?php } ?>

    <div class="text-right">
    <?php  if (isset($_GET['codcombo'])) { ?>
<button type="submit" name="btn-update" id="btn-update" class="btn btn-info"><span class="fa fa-edit"></span> Actualizar</button>
<a href="combos"><button class="btn btn-dark" type="button"><span class="fa fa-trash-o"></span> Cancelar</button></a>
    <?php } else { ?>
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
<button class="btn btn-dark" type="button" onclick="
document.getElementById('proceso').value = 'save',
document.getElementById('codcombo').value = '',
document.getElementById('nomcombo').value = '',
document.getElementById('existencia').value = '',
document.getElementById('stockminimo').value = '',
document.getElementById('stockmaximo').value = '',
document.getElementById('ivacombo').value = '',
document.getElementById('desccombo').value = ''
"><span class="fa fa-trash-o"></span> Limpiar</button>
    <?php } ?>  
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
    <script type="text/javascript" src="assets/script/jsproductos.js"></script>
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