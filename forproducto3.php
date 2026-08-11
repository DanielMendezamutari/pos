<?php
require_once("class/class.php"); 
if(isset($_SESSION['acceso'])) { 
    if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") {

$tra = new Login();
$ses = $tra->ExpiraSession(); 

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor    = (empty($imp) ? "0.00"     : $imp[0]['valorimpuesto']);

if(isset($_POST["proceso"]) and $_POST["proceso"]=="save") {
    $reg = $tra->RegistrarProductos();
    exit;
} elseif(isset($_POST["proceso"]) and $_POST["proceso"]=="update") {
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title></title>
    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">
</head>

<body onLoad="muestraReloj()" class="fix-header">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar">

        <?php include('menu.php'); ?>

        <div class="page-wrapper">
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-tasks"></i> Gestión de Productos</h5>
                    </div>
                    <div class="col-lg-9 col-md-8 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item">Mantenimiento</li>
                                <li class="breadcrumb-item active">Productos Licorería</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="page-content container-fluid">

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-save"></i> Producto de Licorería</h4>
      </div>

    <?php if (isset($_GET['codproducto']) && isset($_GET['codsucursal'])) {
        $reg = $tra->ProductosPorId(); ?>
    <form class="form form-material" method="post" action="#" name="updateproductos" id="updateproductos" data-id="<?php echo $reg[0]["codproducto"] ?>" enctype="multipart/form-data">
    <?php } else { ?>
    <form class="form form-material" method="post" action="#" name="saveproductos" id="saveproductos" enctype="multipart/form-data">
    <?php } ?>

    <div id="save"></div>

    <div class="form-body">
    <div class="card-body">

    <!-- ======== SUCURSAL (solo admin global) ======== -->
    <?php if ($_SESSION['acceso'] == "administradorG") { ?>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group has-feedback">
          <label class="control-label">Seleccione Sucursal: <span class="symbol required"></span></label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if (isset($reg[0]['codsucursal'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" onChange="CargaFamiliasxSucursal(this.form.codsucursal.value,0); CargaProveedoresxSucursal(this.form.codsucursal.value);" class="form-control" required="" aria-required="true">
          <option value=""> -- SELECCIONE -- </option>
          <?php $sucursal=new Login(); $sucursal=$sucursal->ListarSucursales();
          if($sucursal!="") for($i=0;$i<sizeof($sucursal);$i++): ?>
          <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"<?php if(!(strcmp($reg[0]['codsucursal'],$sucursal[$i]['codsucursal']))) echo "selected"; ?>><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } else { ?>
          <select style="color:#000;font-weight:bold;" name="codsucursal" id="codsucursal" onChange="CargaFamiliasxSucursal(this.form.codsucursal.value,0); CargaProveedoresxSucursal(this.form.codsucursal.value);" class="form-control" required="" aria-required="true">
          <option value=""> -- SELECCIONE -- </option>
          <?php $sucursal=new Login(); $sucursal=$sucursal->ListarSucursales();
          if($sucursal!="") for($i=0;$i<sizeof($sucursal);$i++): ?>
          <option value="<?php echo encrypt($sucursal[$i]['codsucursal']); ?>"><?php echo $sucursal[$i]['cuitsucursal'].": ".$sucursal[$i]['nomsucursal']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php } else { ?>
    <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION["codsucursal"]); ?>">
    <?php } ?>

    <!-- ======== HIDDEN FIELDS (requeridos por RegistrarProductos pero no aplican a licorería) ======== -->
    <input type="hidden" name="idproducto"   id="idproducto"   <?php if(isset($reg[0]['idproducto'])) echo 'value="'.encrypt($reg[0]['idproducto']).'"'; ?>>
    <input type="hidden" name="formulario"   id="formulario"   value="forproducto3">
    <input type="hidden" name="tipousuario"  id="tipousuario"  value="<?php echo ($_SESSION["acceso"]=="administradorG" ? 1 : 2); ?>">
    <input type="hidden" name="modulo"       id="modulo"       value="1">
    <input type="hidden" name="proceso"      id="proceso"      <?php if(isset($reg[0]['idproducto'])) echo 'value="update"'; else echo 'value="save"'; ?>>
    <input type="hidden" name="imei"         id="imei"         value="">
    <input type="hidden" name="condicion"    id="condicion"    value="">
    <input type="hidden" name="codmarca"     id="codmarca"     value="<?php echo encrypt(0); ?>">
    <input type="hidden" name="codmodelo"    id="codmodelo"    value="<?php echo encrypt(0); ?>">
    <input type="hidden" name="codcolor"     id="codcolor"     value="<?php echo encrypt(0); ?>">
    <input type="hidden" name="nroparte"     id="nroparte"     value="">
    <input type="hidden" name="peso"         id="peso"         value="0">
    <input type="hidden" name="porcentaje"   id="porcentaje"   value="<?php echo ($_SESSION['acceso']=="administradorG" ? "0.00" : number_format($_SESSION['porcentaje'],2,'.','')); ?>">
    <input type="hidden" name="fechaelaboracion" id="fechaelaboracion" value="">
    <input type="hidden" name="fechaoptimo"      id="fechaoptimo"      value="">
    <input type="hidden" name="fechamedio"       id="fechamedio"       value="">
    <input type="hidden" name="fechaminimo"      id="fechaminimo"      value="">
    <input type="hidden" name="existencia2"      id="existencia2"      <?php if(isset($reg[0]['existencia'])) echo 'value="'.$reg[0]['existencia'].'"'; else echo 'value="0"'; ?>>

    <!-- ======== FILA 1: Código / Nombre / Descripción / Destilería ======== -->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Código de Producto: <span class="symbol required"></span></label>
          <input type="text" class="form-control" name="codproducto" id="codproducto" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ej: LIC-001" autocomplete="off"
            <?php if(isset($reg[0]['codproducto'])) echo 'value="'.$reg[0]['codproducto'].'" readonly="readonly"'; ?>
            required="" aria-required="true"/>
          <i class="fa fa-bolt form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Nombre del Producto: <span class="symbol required"></span></label>
          <input type="text" class="form-control" name="producto" id="producto" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ej: WHISKY RED LABEL 750ML" autocomplete="off"
            <?php if(isset($reg[0]['producto'])) echo 'value="'.$reg[0]['producto'].'"'; ?>
            required="" aria-required="true"/>
          <i class="fa fa-pencil form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback2">
          <label class="control-label">Descripción / Notas: </label>
          <textarea class="form-control" name="descripcion" id="descripcion" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ej: ESCOCÉS • 40% ALC. VOL." rows="1"><?php if(isset($reg[0]['descripcion'])) echo $reg[0]['descripcion']; ?></textarea>
          <i class="fa fa-comment-o form-control-feedback2"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Destilería / Bodega: </label>
          <input type="text" class="form-control" name="fabricante" id="fabricante" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ej: DIAGEO, BACARDÍ, CONCHA Y TORO" autocomplete="off"
            <?php if(isset($reg[0]['fabricante'])) echo 'value="'.$reg[0]['fabricante'].'"'; ?>/>
          <i class="fa fa-industry form-control-feedback"></i>
        </div>
      </div>
    </div>

    <!-- ======== FILA 2: Familia / Categoría / Presentación / País de Origen ======== -->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Familia (Tipo de Bebida): <span class="symbol required"></span></label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if ($_SESSION['acceso'] == "administradorG" && !isset($reg[0]['codfamilia'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codfamilia" id="codfamilia" onChange="CargaSubfamilias(this.form.codfamilia.value);" class="form-control" required="" aria-required="true">
          <option value=""> -- SIN RESULTADOS -- </option>
          </select>
          <?php } elseif(isset($reg[0]['codfamilia'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codfamilia" id="codfamilia" onChange="CargaSubfamilias(this.form.codfamilia.value);" class="form-control" required="" aria-required="true">
          <option value=""> -- SELECCIONE -- </option>
          <?php $familia=new Login(); $familia=$familia->ListarFamilias();
          if($familia!="") for($i=0;$i<sizeof($familia);$i++): ?>
          <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"<?php if(!(strcmp($reg[0]['codfamilia'],$familia[$i]['codfamilia']))) echo "selected"; ?>><?php echo $familia[$i]['nomfamilia']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } else { ?>
          <select style="color:#000;font-weight:bold;" name="codfamilia" id="codfamilia" onChange="CargaSubfamilias(this.form.codfamilia.value);" class="form-control" required="" aria-required="true">
          <option value=""> -- SELECCIONE -- </option>
          <?php $familia=new Login(); $familia=$familia->ListarFamilias();
          if($familia!="") for($i=0;$i<sizeof($familia);$i++): ?>
          <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"><?php echo $familia[$i]['nomfamilia']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } ?>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Categoría: </label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if(isset($reg[0]['codsubfamilia'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codsubfamilia" id="codsubfamilia" class="form-control">
          <option value=""> -- SELECCIONE -- </option>
          <?php $sub=new Login(); $sub=$sub->ListarSubfamiliasAsignados($reg[0]['codfamilia']);
          if($sub!="") for($i=0;$i<sizeof($sub);$i++): ?>
          <option value="<?php echo encrypt($sub[$i]['codsubfamilia']); ?>"<?php if(!(strcmp($reg[0]['codsubfamilia'],$sub[$i]['codsubfamilia']))) echo "selected"; ?>><?php echo $sub[$i]['nomsubfamilia']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } else { ?>
          <select style="color:#000;font-weight:bold;" name="codsubfamilia" id="codsubfamilia" class="form-control">
          <option value=""> -- SIN RESULTADOS -- </option>
          </select>
          <?php } ?>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Presentación (Tamaño): </label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if(isset($reg[0]['codpresentacion'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codpresentacion" id="codpresentacion" class="form-control">
          <option value=""> -- SELECCIONE -- </option>
          <?php $pres=new Login(); $pres=$pres->ListarPresentaciones();
          if($pres!="") for($i=0;$i<sizeof($pres);$i++): ?>
          <option value="<?php echo encrypt($pres[$i]['codpresentacion']); ?>"<?php if(!(strcmp($reg[0]['codpresentacion'],$pres[$i]['codpresentacion']))) echo "selected"; ?>><?php echo $pres[$i]['nompresentacion']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } else { ?>
          <select style="color:#000;font-weight:bold;" name="codpresentacion" id="codpresentacion" class="form-control">
          <option value=""> -- SELECCIONE -- </option>
          <?php $pres=new Login(); $pres=$pres->ListarPresentaciones();
          if($pres!="") for($i=0;$i<sizeof($pres);$i++): ?>
          <option value="<?php echo encrypt($pres[$i]['codpresentacion']); ?>"><?php echo $pres[$i]['nompresentacion']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } ?>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">País de Origen: </label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if(isset($reg[0]['codorigen'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codorigen" id="codorigen" class="form-control">
          <option value=""> -- SELECCIONE -- </option>
          <?php $orig=new Login(); $orig=$orig->ListarOrigenes();
          if($orig!="") for($i=0;$i<sizeof($orig);$i++): ?>
          <option value="<?php echo encrypt($orig[$i]['codorigen']); ?>"<?php if(!(strcmp($reg[0]['codorigen'],$orig[$i]['codorigen']))) echo "selected"; ?>><?php echo $orig[$i]['nomorigen']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } else { ?>
          <select style="color:#000;font-weight:bold;" name="codorigen" id="codorigen" class="form-control">
          <option value=""> -- SELECCIONE -- </option>
          <?php $orig=new Login(); $orig=$orig->ListarOrigenes();
          if($orig!="") for($i=0;$i<sizeof($orig);$i++): ?>
          <option value="<?php echo encrypt($orig[$i]['codorigen']); ?>"><?php echo $orig[$i]['nomorigen']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } ?>
        </div>
      </div>
    </div>

    <!-- ======== FILA 3: Año / Lote / Precio Compra / Precio x Mayor ======== -->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Año de Cosecha / Producción: </label>
          <input type="text" class="form-control" name="year" id="year" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%d', this);" placeholder="Ej: 2020" autocomplete="off"
            <?php if(isset($reg[0]['year'])) echo 'value="'.$reg[0]['year'].'"'; ?>/>
          <i class="fa fa-calendar form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Lote / Batch: </label>
          <input type="text" class="form-control" name="lote" id="lote" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Ej: L2024-001" autocomplete="off"
            <?php if(isset($reg[0]['lote'])) echo 'value="'.$reg[0]['lote'].'"'; ?>/>
          <i class="fa fa-tag form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Precio de Compra: <span class="symbol required"></span></label>
          <input type="text" class="form-control calculoprecio" name="preciocompra" id="preciocompra" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['preciocompra'])) echo 'value="'.number_format($reg[0]['preciocompra'],2,'.',''). '"'; ?>
            required="" aria-required="true"/>
          <i class="fa fa-tint form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Precio x Mayor: </label>
          <input type="text" class="form-control" name="precioxmayor" id="precioxmayor" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['precioxmayor'])) echo 'value="'.number_format($reg[0]['precioxmayor'],2,'.',''). '"'; else echo 'value="0.00"'; ?>/>
          <i class="fa fa-tint form-control-feedback"></i>
        </div>
      </div>
    </div>

    <!-- ======== FILA 4: Precio x Menor / Precio x Público / Existencia / Código de Barra ======== -->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Precio x Menor: </label>
          <input type="text" class="form-control" name="precioxmenor" id="precioxmenor" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['precioxmenor'])) echo 'value="'.number_format($reg[0]['precioxmenor'],2,'.',''). '"'; else echo 'value="0.00"'; ?>/>
          <i class="fa fa-tint form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Precio x Público: <span class="symbol required"></span></label>
          <input type="text" class="form-control" name="precioxpublico" id="precioxpublico" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['precioxpublico'])) echo 'value="'.number_format($reg[0]['precioxpublico'],2,'.',''). '"'; ?>
            required="" aria-required="true"/>
          <i class="fa fa-tint form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Existencia: <span class="symbol required"></span></label>
          <input type="text" class="form-control" name="existencia" id="existencia" onKeyUp="this.value=this.value.toUpperCase();" placeholder="0" autocomplete="off"
            <?php if(isset($reg[0]['existencia'])) echo 'value="'.$reg[0]['existencia'].'"'; ?>
            required="" aria-required="true"/>
          <i class="fa fa-bolt form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Código de Barra: </label>
          <input type="text" class="form-control" name="codigobarra" id="codigobarra" onKeyUp="this.value=this.value.toUpperCase();" placeholder="Escanee o ingrese" autocomplete="off"
            <?php if(isset($reg[0]['codigobarra'])) echo 'value="'.$reg[0]['codigobarra'].'"'; ?>/>
          <i class="fa fa-barcode form-control-feedback"></i>
        </div>
      </div>
    </div>

    <!-- ======== FILA 5: Stock Óptimo / Medio / Mínimo / Impuesto ======== -->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Stock Óptimo: </label>
          <input type="text" class="form-control" name="stockoptimo" id="stockoptimo" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['stockoptimo'])) echo 'value="'.$reg[0]['stockoptimo'].'"'; else echo 'value="0.00"'; ?>/>
          <i class="fa fa-signal form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Stock Medio: </label>
          <input type="text" class="form-control" name="stockmedio" id="stockmedio" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['stockmedio'])) echo 'value="'.$reg[0]['stockmedio'].'"'; else echo 'value="0.00"'; ?>/>
          <i class="fa fa-signal form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Stock Mínimo: </label>
          <input type="text" class="form-control" name="stockminimo" id="stockminimo" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['stockminimo'])) echo 'value="'.$reg[0]['stockminimo'].'"'; else echo 'value="0.00"'; ?>/>
          <i class="fa fa-signal form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Aplica <?php echo $impuesto; ?>: <span class="symbol required"></span></label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if(isset($reg[0]['ivaproducto'])) { ?>
          <select style="color:#000;font-weight:bold;" name="ivaproducto" id="ivaproducto" class="form-control" required="" aria-required="true">
          <option value="">-- SELECCIONE --</option>
          <option value="SI"<?php if(!(strcmp('SI',$reg[0]['ivaproducto']))) echo "selected"; ?>>SI</option>
          <option value="NO"<?php if(!(strcmp('NO',$reg[0]['ivaproducto']))) echo "selected"; ?>>NO</option>
          </select>
          <?php } else { ?>
          <select style="color:#000;font-weight:bold;" name="ivaproducto" id="ivaproducto" class="form-control" required="" aria-required="true">
          <option value="">-- SELECCIONE --</option>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
          </select>
          <?php } ?>
        </div>
      </div>
    </div>

    <!-- ======== FILA 6: Descuento / Proveedor / Foto ======== -->
    <div class="row">
      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Descuento %: <span class="symbol required"></span></label>
          <input type="text" class="form-control" name="descproducto" id="descproducto" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="0.00" autocomplete="off"
            <?php if(isset($reg[0]['descproducto'])) echo 'value="'.number_format($reg[0]['descproducto'],2,'.',''). '"'; else echo 'value="0.00"'; ?>
            required="" aria-required="true"/>
          <i class="fa fa-tint form-control-feedback"></i>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-group has-feedback">
          <label class="control-label">Seleccione Proveedor: <span class="symbol required"></span></label>
          <i class="fa fa-bars form-control-feedback"></i>
          <?php if($_SESSION['acceso']=="administradorG" && !isset($reg[0]['codproveedor'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class="form-control" required="" aria-required="true">
          <option value=""> -- SIN RESULTADOS -- </option>
          </select>
          <?php } elseif(isset($reg[0]['codproveedor'])) { ?>
          <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class="form-control" required="" aria-required="true">
          <option value=""> -- SELECCIONE -- </option>
          <?php $prov=new Login(); $prov=$prov->ListarProveedores();
          if($prov!="") for($i=0;$i<sizeof($prov);$i++): ?>
          <option value="<?php echo encrypt($prov[$i]['codproveedor']); ?>"<?php if(!(strcmp($reg[0]['codproveedor'],$prov[$i]['codproveedor']))) echo "selected"; ?>><?php echo $prov[$i]['nomproveedor']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } else { ?>
          <select style="color:#000;font-weight:bold;" name="codproveedor" id="codproveedor" class="form-control" required="" aria-required="true">
          <option value=""> -- SELECCIONE -- </option>
          <?php $prov=new Login(); $prov=$prov->ListarProveedores();
          if($prov!="") for($i=0;$i<sizeof($prov);$i++): ?>
          <option value="<?php echo encrypt($prov[$i]['codproveedor']); ?>"><?php echo $prov[$i]['nomproveedor']; ?></option>
          <?php endfor; ?>
          </select>
          <?php } ?>
        </div>
      </div>

      <div class="col-md-3">
        <div class="fileinput fileinput-new" data-provides="fileinput">
          <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width:130px;height:130px;">
          <?php if(isset($reg[0]['codproducto'])) {
            $ext = file_exists("fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]['codproducto'].".jpg") ? "jpg"
                 : (file_exists("fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]['codproducto'].".jpeg") ? "jpeg"
                 : (file_exists("fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]['codproducto'].".png") ? "png" : ""));
            if($ext) echo "<img src='fotos/productos/".$reg[0]['codsucursal']."_".$reg[0]['codproducto'].".".$ext."?".date('h:i:s')."' class='rounded-circle' width='130' height='130'>";
            else echo "<img src='fotos/img.png' class='rounded-circle' width='130' height='130'>";
          } else echo "<img src='fotos/img.png' class='rounded-circle' width='130' height='130'>"; ?>
          </div>
          <div>
            <span class="btn btn-success btn-file">
              <span class="fileinput-new" data-trigger="fileinput"><i class="fa fa-file-image-o"></i> Cargar Imagen</span>
              <span class="fileinput-exists" data-trigger="fileinput"><i class="fa fa-paint-brush"></i> Cambiar Imagen</span>
              <input type="file" name="imagen" id="imagen"/>
            </span>
            <a href="#" class="btn btn-dark fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times-circle"></i> Remover</a>
          </div>
        </div>
      </div>
    </div>

    <div class="text-right">
      <?php if(isset($_GET['codproducto'])) { ?>
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

            </div>
            <footer class="footer text-center"><i class="fa fa-copyright"></i> <span class="current-year"></span>.</footer>
        </div>
    </div>

    <script src="assets/script/jquery.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <script src="assets/js/perfect-scrollbar.js"></script>
    <script src="assets/js/sparkline.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/sweetalert-dev.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/plugins/fileupload/bootstrap-fileupload.min.js"></script>
    <script type="text/javascript" src="assets/script/titulos.js"></script>
    <script type="text/javascript" src="assets/script/script2.js"></script>
    <script type="text/javascript" src="assets/script/validation.min.js"></script>
    <script type="text/javascript" src="assets/script/script.js"></script>
    <script src="assets/plugins/noty/packaged/jquery.noty.packaged.min.js"></script>
    <link rel="stylesheet" href="assets/calendario/jquery-ui.css" />
    <script src="assets/calendario/jquery-ui.js"></script>
    <script src="assets/script/jscalendario.js"></script>
    <script src="assets/script/autocompleto.js"></script>
</body>
</html>

<?php } else { ?>
    <script>alert('NO TIENES PERMISO PARA ACCEDER A ESTA PAGINA.\nCONSULTA CON EL ADMINISTRADOR PARA QUE TE DE ACCESO'); document.location.href='productos'</script>
<?php } } else { ?>
    <script>alert('NO TIENES PERMISO PARA ACCEDER AL SISTEMA.\nDEBERA DE INICIAR SESION'); document.location.href='logout'</script>
<?php } ?>
