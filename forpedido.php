<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
     if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
$simbolo = ($_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$_SESSION["simbolo"]."</strong>");

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save")
{
$reg = $tra->RegistrarPedidos();
exit;
}
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update")
{
$reg = $tra->ActualizarPedidos();
exit;
}  
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="agregar") 
{
$reg = $tra->AgregarDetallesPedidos();
exit;
}  
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="newproducto")
{
$reg = $tra->RegistrarNuevoProducto();
exit;
} 
elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="newproveedor")
{
$reg = $tra->RegistrarProveedores();
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

<!--############################## MODAL PARA REGISTRO DE NUEVO PROVEEDOR ######################################-->
<!-- sample modal content -->
<div id="myModalProveedor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Proveedores</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="saveproveedor" id="saveproveedor"> 

        <div id="save">
        <!-- error will be shown here ! -->
        </div>
                
        <div class="modal-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Tipo de Documento: </label>
                    <i class="fa fa-bars form-control-feedback"></i> 
                    <select style="color:#000;font-weight:bold;" name="documproveedor" id="documproveedor" class='form-control' required="" aria-required="true">
                        <option value="0"> -- SELECCIONE -- </option>
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
                        <input type="hidden" name="proceso" id="proceso" value="newproveedor"/>
                        <input type="hidden" name="formulario" id="formulario" value="forpedido"/>
                        <input type="text" class="form-control" name="cuitproveedor" id="cuitproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Documento" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-bolt form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombre de Proveedor: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="nomproveedor" id="nomproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Proveedor" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                        <input type="text" class="form-control phone-inputmask" name="tlfproveedor" id="tlfproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-phone form-control-feedback"></i> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Provincia: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" name="id_provincia" id="id_provincia" onChange="CargaDepartamentos(this.form.id_provincia.value);" class='form-control' required="" aria-required="true">
                        <option value="0"> -- SELECCIONE -- </option>
                        <?php
                        $provincia = new Login();
                        $provincia = $provincia->ListarProvincias();
                        if($provincia==""){ 
                            echo "";
                        } else {
                        for($i=0;$i<sizeof($provincia);$i++){ ?>
                        <option value="<?php echo $provincia[$i]['id_provincia']; ?>"><?php echo $provincia[$i]['provincia'] ?></option>        
                        <?php } } ?>
                        </select> 
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Departamento: </label>
                        <i class="fa fa-bars form-control-feedback"></i>
                        <select style="color:#000;font-weight:bold;" class="form-control" id="id_departamento" name="id_departamento" required="" aria-required="true">
                            <option value=""> -- SIN RESULTADOS -- </option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Dirección de Proveedor: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="direcproveedor" id="direcproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Dirección de Proveedor" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-map-marker form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Correo de Proveedor: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="emailproveedor" id="emailproveedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Correo Electronico" autocomplete="off" required="" aria-required="true"/> 
                        <i class="fa fa-envelope-o form-control-feedback"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nombre de Vendedor: <span class="symbol required"></span></label>
                        <input type="text" class="form-control" name="vendedor" id="vendedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Vendedor" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-pencil form-control-feedback"></i> 
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group has-feedback">
                        <label class="control-label">Nº de Teléfono: <span class="symbol required"></span></label>
                        <input type="text" class="form-control phone-inputmask" name="tlfvendedor" id="tlfvendedor" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Teléfono" autocomplete="off" required="" aria-required="true"/>  
                        <i class="fa fa-phone form-control-feedback"></i> 
                    </div>
                </div>
            </div>
        </div>

            <div class="modal-footer">
                <button type="submit" name="btn-proveedor" id="btn-proveedor" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                <button class="btn btn-dark" type="button" onclick="
                document.getElementById('proceso').value = 'save',
                document.getElementById('codproveedor').value = '',
                document.getElementById('documproveedor').value = '',
                document.getElementById('cuitproveedor').value = '',
                document.getElementById('nomproveedor').value = '',
                document.getElementById('tlfproveedor').value = '',
                document.getElementById('id_provincia').value = '',
                document.getElementById('id_departamento').value = '',
                document.getElementById('direcproveedor').value = '',
                document.getElementById('emailproveedor').value = '',
                document.getElementById('vendedor').value = '',
                document.getElementById('tlfvendedor').value = ''
                " data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE NUEVO PROVEEDOR ######################################-->

<!--############################## MODAL PARA REGISTRO DE NUEVO PRODUCTO ######################################-->
<!-- sample modal content -->
<div id="myModalNuevo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title text-white" id="myModalLabel"><i class="fa fa-save"></i> Gestión de Producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="assets/images/close.png"/></button>
            </div>
            
        <form class="form form-material" method="post" action="#" name="nuevoproducto" id="nuevoproducto" enctype="multipart/form-data"> 

        <div id="save">
        <!-- error will be shown here ! -->
        </div>
                
        <div class="modal-body">

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Código de Producto: <span class="symbol required"></span></label>
                    <input type="hidden" name="formulario" id="formulario" value="forpedido">
                    <input type="hidden" name="modulo" id="modulo" value="3">
                    <input type="hidden" name="proceso" id="proceso" value="newproducto"/>
                    <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
                    <input type="text" class="form-control" name="codproducto2" id="codproducto2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Código de Producto" autocomplete="off" required="" aria-required="true"/> 
                    <i class="fa fa-bolt form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nombre de Producto: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="producto2" id="producto2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nombre de Producto" autocomplete="off" required="" aria-required="true"/>
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4"> 
                <div class="form-group has-feedback2"> 
                    <label class="control-label">Descripción de Producto: </label> 
                    <textarea class="form-control" type="text" name="descripcion2" id="descripcion2" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Descripción de Producto" rows="1"></textarea>
                    <i class="fa fa-comment-o form-control-feedback2"></i> 
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Nº de Imei: </label>
                    <input type="text" class="form-control" name="imei2" id="imei2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Nº de Imei" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Condición de Producto: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="condicion2" id="condicion2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Condición" autocomplete="off" <?php if (isset($reg[0]['condicion'])) { ?> value="<?php echo $reg[0]['condicion']; ?>" <?php } ?> required="" aria-required="true"/>  
                    <i class="fa fa-pencil form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Familia: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codfamilia2" id="codfamilia2" class='form-control' required="" aria-required="true">
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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Marca: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codmarca2" id="codmarca2" onChange="CargaModelos2(this.form.codmarca2.value);" class='form-control' required="" aria-required="true">
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
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Modelo: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codmodelo2" id="codmodelo2" class='form-control' required="" aria-required="true">
                    <option value=""> -- SIN RESULTADOS -- </option>
                    </select> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Presentación: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codpresentacion2" id="codpresentacion2" class='form-control' required="" aria-required="true">
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
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Color: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codcolor2" id="codcolor2" class='form-control' required="" aria-required="true">
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
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
                    <input type="text" class="form-control calculoprecio" name="preciocompra2" id="preciocompra2" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio de Compra" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Precio Venta x Público: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="precioxpublico2" id="precioxpublico2" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Precio Venta x Público" autocomplete="off"  required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Existencia: <span class="symbol required"></span></label>
                     <input type="text" class="form-control" name="existencia2" id="existencia2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Existencia" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-bolt form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Código de Barra: </label>
                    <input type="text" class="form-control" name="codigobarra2" id="codigobarra2" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ingrese Código de Barra" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-barcode form-control-feedback"></i> 
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione <?php echo $impuesto; ?>: <span class="symbol required"></span></label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="ivaproducto2" id="ivaproducto2" class="form-control" required="" aria-required="true">
                    <option value=""> -- SELECCIONE -- </option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Descuento de Producto: <span class="symbol required"></span></label>
                    <input type="text" class="form-control" name="descproducto2" id="descproducto2" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Ingrese Descuento" value="0.00" autocomplete="off" required="" aria-required="true"/>  
                    <i class="fa fa-tint form-control-feedback"></i>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group has-feedback">
                    <label class="control-label">Seleccione Proveedor: </label>
                    <i class="fa fa-bars form-control-feedback"></i>
                    <select style="color:#000;font-weight:bold;" name="codproveedor2" id="codproveedor2" class='form-control' required="" aria-required="true">
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
                </div>
            </div>
        </div>

        </div>

            <div class="modal-footer">
                <button type="submit" name="btn-save" id="btn-save" class="btn btn-danger"><span class="fa fa-save"></span> Guardar</button>
                <button class="btn btn-dark" type="reset" data-dismiss="modal" aria-hidden="true"><span class="fa fa-trash-o"></span> Cerrar</button>
            </div>
        </form>

    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
<!-- /.modal --> 
<!--############################## MODAL PARA REGISTRO DE NUEVO PRODUCTO ######################################-->                          
                    
    
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
             <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Pedidos</h5>
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
               
<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-danger">
            <h4 class="card-title text-white"><i class="fa fa-save"></i> Gestión de Pedidos</h4>
            </div>

<?php  if (isset($_GET['codpedido']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") {
      
$reg = $tra->PedidosPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="updatepedidos" id="updatepedidos" data-id="<?php echo $reg[0]["codpedido"] ?>">

<?php } else if (isset($_GET['codpedido']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") {
      
$reg = $tra->PedidosPorId(); ?>
      
<form class="form form-material" method="post" action="#" name="agregapedidos" id="agregapedidos" data-id="<?php echo $reg[0]["codpedido"] ?>">
        
<?php } else { ?>
        
 <form class="form form-material" method="post" action="#" name="savepedidos" id="savepedidos">

<?php } ?>
           
    <div id="save">
    <!-- error will be shown here ! -->
    </div>

    <div class="form-body">

    <div class="card-body">

    <input type="hidden" name="proceso" id="proceso" <?php if (isset($_GET['codpedido']) && decrypt($_GET["proceso"])=="U") { ?> value="update" <?php } elseif (isset($_GET['codpedido']) && decrypt($_GET["proceso"])=="A") { ?> value="agregar" <?php } else { ?> value="save" <?php } ?>>
    <input type="hidden" name="codpedido" id="codpedido" <?php if (isset($reg[0]['codpedido'])) { ?> value="<?php echo encrypt($reg[0]['codpedido']); ?>"<?php } ?>>
    <input type="hidden" name="codsucursal" id="codsucursal" <?php if (isset($reg[0]['codsucursal'])) { ?> value="<?php echo encrypt($reg[0]['codsucursal']); ?>" <?php } else { ?> value="<?php echo encrypt($_SESSION["codsucursal"]); ?>"<?php } ?>>
    
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-file-send"></i> Datos de Factura</h2><hr>

    <div class="row">
        <div class="col-md-4">
            <label class="control-label">Seleccione Proveedor: <span class="symbol required"></span></label>
            <div class="input-group mb-3">
            <div class="input-group-append">
            <button type="button" class="btn btn-success waves-effect waves-light" data-placement="left" title="Nuevo Proveedor" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false"><i class="fa fa-user-plus"></i> (F7)</button>
            </div>
            <?php if (isset($reg[0]['codproveedor'])) { ?>
            <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class='form-control' required="" aria-required="true">
            <option value=""> -- SELECCIONE -- </option>
            <?php
            $proveedor = new Login();
            $proveedor = $proveedor->ListarProveedores();
            if($proveedor==""){ 
              echo "";
            } else {
            for($i=0;$i<sizeof($proveedor);$i++){ ?>
            <option value="<?php echo $proveedor[$i]['codproveedor'] ?>"<?php if (!(strcmp($reg[0]['codproveedor'], htmlentities($proveedor[$i]['codproveedor'])))) {echo "selected=\"selected\""; } ?>><?php echo $proveedor[$i]['nomproveedor'] ?></option>        
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
            <option value="<?php echo $proveedor[$i]['codproveedor'] ?>"><?php echo $proveedor[$i]['nomproveedor'] ?></option>
            <?php } } ?>
            </select>
            <?php } ?> 
            </div>
        </div>

        <div class="col-md-4"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Fecha de Pedido: <span class="symbol required"></span></label>
            <?php if (isset($reg[0]['fechapedido'])) { ?>
              <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="fechapedido" id="fechapedido" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Pedido"  value="<?php echo $reg[0]['fechapedido'] == '0000-00-00' ? "" : date("d-m-Y H:i:s",strtotime($reg[0]['fechapedido'])); ?>" readonly="readonly"><?php } else { ?><input style="color:#000;font-weight:bold;" class="form-control" type="text" name="fecharegistro" id="fecharegistro" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Pedido" required="" aria-required="true" readonly="readonly"> <?php } ?>
            <i class="fa fa-calendar form-control-feedback"></i>
          </div> 
        </div>

        <div class="col-md-4"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label">Observaciones: </label> 
                <textarea class="form-control" type="text" name="observaciones" id="observaciones" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Observaciones" rows="2"><?php if (isset($reg[0]['observaciones'])) { echo $reg[0]['observaciones']; } ?></textarea>
                <i class="fa fa-comment-o form-control-feedback2"></i> 
            </div> 
        </div>
    </div>

<?php if (isset($_GET['codpedido']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

<div id="detallespedidosupdate">

        <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Código</th>
                        <th>Descripción de Producto</th>
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
$detalle = $tra->VerDetallesPedidos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
?>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetallePedido('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedido(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetallePedido('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
      
    <td class="text-dark alert-link">
    <input type="hidden" name="coddetallepedido[]" id="coddetallepedido" value="<?php echo $detalle[$i]["coddetallepedido"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <?php echo $detalle[$i]['codproducto']; ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['preciocompra'], 2, '.', ''); ?></td>

    <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>
      
    <td class="text-dark alert-link">
    <input type="hidden" name="descfactura[]" id="descfactura_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ','); ?>">
    <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ','); ?>">
    <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?></label><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>

    <td class="text-dark alert-link"><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>

    <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" ><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPedidosUpdate('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/></td>
            </tr>
            </table>
        </div>
    </div>

<?php } else if (isset($_GET['codpedido']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") { ?>

<h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles Agregados</h2><hr>

<div id="detallespedidosagregar">

        <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Código</th>
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
$detalle = $tra->VerDetallesPedidos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td class="text-dark alert-link"><?php echo $a++; ?></td> 
    <td class="text-danger alert-link"><?php echo $detalle[$i]['codproducto']; ?></td>

    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
    <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
    <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPedidosAgregar('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td></td><?php } ?>
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
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%:</label></h5>    </td>

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
          
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

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
    <input type="hidden" name="descproducto" id="descproducto" value="0.00">
    <input type="hidden" name="ivaproducto" id="ivaproducto">
    <input type="hidden" name="preciocompra" id="preciocompra">
    <input type="hidden" name="precioconiva" id="precioconiva" value="0.00">
    <input type="hidden" name="precioxmenor" id="precioxmenor" value="0.00"/>
    <input type="hidden" name="precioxmayor" id="precioxmayor" value="0.00"/>
    <input type="hidden" name="precioxpublico" id="precioxpublico" value="0.00"/>  
    <input type="hidden" name="descfactura" id="descfactura" value="0.00">

    <div class="row">
        <div class="col-md-10"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Realice la Búsqueda de Producto: <span class="symbol required"></span></label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_compra" id="search_compra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda por Código, Descripción o Nº de Barra">
                <i class="fa fa-pencil form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-2"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Cantidad: <span class="symbol required"></span></label>
                <input type="text" class="form-control agregar" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad">
                <i class="fa fa-bolt form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    <div class="pull-right">
        <button type="button" class="btn btn-success" data-placement="left" title="Nuevo Producto" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalNuevo" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i> Nuevo Producto</button>
        <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
    </div></br>

    <div class="table-responsive m-t-40">
        <table id="carrito" class="table table-hover">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Código</th>
                    <th>Descripción de Producto</th>
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
        </table>
        <hr>

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
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($_SESSION['descsucursal'], 2, '.', ''); ?>">%:</label></h5>    </td>

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

    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 mdi mdi-cart-plus"></i> Detalles de Factura</h2><hr>

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
    <input type="hidden" name="descproducto" id="descproducto" value="0.00">
    <input type="hidden" name="ivaproducto" id="ivaproducto">
    <input type="hidden" name="preciocompra" id="preciocompra">
    <input type="hidden" name="precioconiva" id="precioconiva" value="0.00">
    <input type="hidden" name="precioxmenor" id="precioxmenor" value="0.00"/>
    <input type="hidden" name="precioxmayor" id="precioxmayor" value="0.00"/>
    <input type="hidden" name="precioxpublico" id="precioxpublico" value="0.00"/>  
    <input type="hidden" name="descfactura" id="descfactura" value="0.00">

    <div class="row">
        <div class="col-md-10"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Realice la Búsqueda de Producto: <span class="symbol required"></span></label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="search_compra" id="search_compra" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Realice la Búsqueda por Código, Descripción o Nº de Barra">
                <i class="fa fa-pencil form-control-feedback"></i> 
            </div> 
        </div>

        <div class="col-md-2"> 
            <div class="form-group has-feedback"> 
                <label class="control-label">Cantidad: <span class="symbol required"></span></label>
                <input type="text" class="form-control agregar" name="cantidad" id="cantidad" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Cantidad">
                <i class="fa fa-bolt form-control-feedback"></i> 
            </div> 
        </div>
    </div>

    <div class="pull-right">
        <button type="button" class="btn btn-success" data-placement="left" title="Nuevo Producto" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalNuevo" data-backdrop="static" data-keyboard="false"><i class="fa fa-plus"></i> Nuevo Producto</button>
        <button type="button" id="AgregaProducto" class="btn btn-info"><span class="fa fa-cart-plus"></span> Agregar (Enter)</button>
    </div></br>

    <div class="table-responsive m-t-40">
        <table id="carrito" class="table table-hover">
            <thead>
                <tr>
                    <th>Cantidad</th>
                    <th>Código</th>
                    <th>Descripción de Producto</th>
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
        </table>
        <hr>

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
    <h5><label>Desc. Global <input class="number" type="text" name="descuento" id="descuento" onKeyPress="EvaluateText('%f', this);" style="border-radius:4px;height:30px;width:60px;" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" value="<?php echo number_format($_SESSION['descsucursal'], 2, '.', ''); ?>">%:</label></h5>    </td>

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
<?php  if (isset($_GET['codpedido']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="U") { ?>
<span id="submit_update"><button type="submit" name="btn-update" id="btn-update" class="btn btn-danger"><span class="fa fa-edit"></span> Actualizar</button></span>
<a href="pedidos"><button class="btn btn-dark" type="reset"><span class="fa fa-trash-o"></span> Cancelar</button></a> 
<?php } else if (isset($_GET['codpedido']) && isset($_GET['codsucursal']) && decrypt($_GET["proceso"])=="A") { ?>  
<span id="submit_agregar"><button type="submit" name="btn-agregar" id="btn-agregar" class="btn btn-danger"><span class="fa fa-plus-circle"></span> Agregar</button></span>
<button class="btn btn-dark" type="button" id="vaciar"><span class="fa fa-trash-o"></span> Cancelar</button>
<?php } else { ?>  
<span id="submit_guardar"><button type="submit" name="btn-submit" id="btn-submit" class="btn btn-danger"><span class="fa fa-save"></span> Guardar (F2)</button></span>
<button class="btn btn-dark" type="button" id="vaciar"><i class="fa fa-trash-o"></i> Limpiar (F4)</button>
<?php } ?>
</div>

          </div>
       </div>
     </form>
   </div>
  </div>
</div>

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
    <script type="text/javascript" src="assets/script/jspedidos.js"></script>
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