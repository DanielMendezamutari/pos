<?php
require_once("class/class.php");
?>

<?php
$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$_SESSION["simbolo"]."</strong>");
$stringReplace = array("'", "&", '"','(',')');

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);

$new = new Login();
?>


<?php
######################## BUSQUEDA DETALLE DE PRODUCTO PARA PRECIO #######################
if (isset($_GET['BuscaDetallesProductoxPrecio']) && isset($_GET['variable']) && isset($_GET['d_id']) && isset($_GET['d_codigo']) && isset($_GET['d_tipo']) && isset($_GET['d_producto']) && isset($_GET['d_cantidad']) && isset($_GET['d_precio']) && isset($_GET['d_descproducto'])) {

$variable = limpiar($_GET['variable']); 

if(limpiar($_GET['d_tipo'] == 1)){ 

$reg = $new->DetallesProductoPorId();
?>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Producto"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-10">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Producto: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Producto"><label id="d_producto" name="d_producto"><?php echo $reg[0]['producto']." ".$reg[0]["condicion"].$descripcion = ($reg[0]["descripcion"] != "" ? "<br>".$reg[0]["descripcion"] : "").$imei = ($reg[0]["imei"] != "" ? "<br>IMEI: ".$reg[0]["imei"] : ""); ?></label></abbr>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label class="control-label">Precio Mayorista: <span class="symbol required"></span></label>
            <br /><abbr title="Precio Mayorista"><label id="d_precioventa"><?php echo number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label class="control-label">Precio Minorista: <span class="symbol required"></span></label>
            <br /><abbr title="Precio Minorista"><label id="d_precioventa"><?php echo number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label class="control-label">Precio Público: <span class="symbol required"></span></label>
            <br /><abbr title="Precio Público"><label id="d_precioventa"><?php echo number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>
      </div>

      <div class="row m-t-5">
        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Nuevo Precio de Venta: <span class="symbol required"></span></label> 
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>" placeholder="Ingrese Precio Venta" required="" aria-required="true">
            <i class="fa fa-pencil form-control-feedback"></i> 
          </div> 
        </div>

        <div class="col-md-6"> 
          <div class="form-group has-feedback"> 
            <label class="control-label">Nuevo Descuento de Producto: <span class="symbol required"></span></label> 
            <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>" placeholder="Ingrese Descuento" required="" aria-required="true">
            <i class="fa fa-pencil form-control-feedback"></i> 
          </div> 
        </div>
      </div> 

      <div class="modal-footer">
        <button type="button" onClick="DoActionPrecio(
        '<?php echo $reg[0]['idproducto']; ?>',
        '<?php echo $reg[0]['codproducto']; ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['producto']); ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['descripcion'] == '' ? "0" : $reg[0]['descripcion']); ?>',
        '<?php echo $reg[0]['imei'] == '' ? "0" : $reg[0]['imei']; ?>',
        '<?php echo $reg[0]['condicion'] == '' ? "******" : $reg[0]['condicion']; ?>',
        '<?php echo $reg[0]['codmarca']; ?>',
        '<?php echo $reg[0]['codmarca'] == 0 ? "******" : $reg[0]['nommarca']; ?>',
        '<?php echo $reg[0]['codmodelo']; ?>',
        '<?php echo $reg[0]['codmodelo'] == 0 ? "******" : $reg[0]['nommodelo']; ?>',
        '<?php echo $reg[0]['codpresentacion']; ?>',
        '<?php echo $reg[0]['codpresentacion'] == 0 ? "******" : $reg[0]['nompresentacion']; ?>',
        '<?php echo $reg[0]['codcolor']; ?>',
        '<?php echo $reg[0]['codcolor'] == 0 ? "******" : $reg[0]['nomcolor']; ?>',
        '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo $ivaproducto = ( $reg[0]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', '') : "(E)"); ?>',
        '<?php echo $reg[0]['existencia']; ?>',
        '<?php if($reg[0]['ivaproducto'] == 'SI'){ ?>'+document.getElementById('precioventa').value+'<?php } else { echo "0.00"; } ?>',
        '<?php echo "1"; ?>');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
        <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
      </div>

<?php } elseif(limpiar($_GET['d_tipo'] == 2)){ 

$reg = $new->DetallesComboPorId();
?>
      <div class="row">
        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Cantidad: <span class="symbol required"></span></label>
            <br /><abbr title="Cantidad de Combo"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-8">
          <div class="form-group has-feedback">
            <label class="control-label">Descripción de Combo: <span class="symbol required"></span></label>
            <br /><abbr title="Descripción de Combo"><label id="d_producto"><?php echo $reg[0]['nomcombo']; ?></label></abbr>
          </div>
        </div>

        <div class="col-md-2">
          <div class="form-group has-feedback">
            <label class="control-label">Precio: <span class="symbol required"></span></label>
            <br /><abbr title="Precio de Combo"><label id="d_precioventa"><?php echo number_format($reg[0]['precioventa'], 2, '.', ','); ?></label></abbr>
          </div>
        </div>
      </div>
<?php 
$tru = new Login();
$a=1;
$busq = $tru->DetallesProductosxCombo(); 

if($busq==""){
  echo "";      
} else {
?>
<!----><div id="div">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10" width="100%">
    <thead>
    <tr>
    <th colspan="6" data-priority="1"><center>Productos del Combo</center></th>
    </tr>
    <tr>
      <th>Nº</th>
      <th>Producto</th>
      <th>Cantidad</th>
    </tr>
    </thead>
    <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
?>
    <tr>
    <th><?php echo $a++; ?></th>
      <td><?php echo $busq[$i]["producto"]; ?></td>
      <td><?php echo $busq[$i]["cantidad"]; ?></td>
    </tr> 
    <?php } ?>
    </tbody>
  </table>
</div>
<?php } ?>

    <div class="row m-t-5">
      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Precio de Venta: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>" placeholder="Ingrese Precio Venta" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>

      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Descuento de Producto: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>" placeholder="Ingrese Descuento" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>
    </div> 

    <div class="modal-footer">
      <button type="button" onClick="DoActionPrecio(
        '<?php echo $reg[0]['idcombo']; ?>',
        '<?php echo $reg[0]['codcombo']; ?>',
        '<?php echo str_replace($stringReplace, '', $reg[0]['nomcombo']); ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo number_format($reg[0]['preciocompra'], 2, '.', ''); ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo $ivacombo = ( $reg[0]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', '') : "(E)"); ?>',
        '<?php echo $reg[0]['existencia']; ?>',
        '<?php if($reg[0]['ivacombo'] == 'SI'){ ?>'+document.getElementById('precioventa').value+'<?php } else { echo "0.00"; } ?>',
        '2');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
      <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
    </div>

<?php } elseif(limpiar($_GET['d_tipo'] == 3)){ ?>

    <div class="row">
      <div class="col-md-2">
        <div class="form-group has-feedback">
          <label class="control-label">Cantidad: <span class="symbol required"></span></label>
          <br /><abbr title="Cantidad de Combo"><label id="d_cantidad"><?php echo $_GET['d_cantidad']; ?></label></abbr>
        </div>
      </div>

      <div class="col-md-10">
        <div class="form-group has-feedback">
          <label class="control-label">Descripción de Servicio: <span class="symbol required"></span></label>
          <br /><abbr title="Descripción de Combo"><label id="d_producto"><?php echo $_GET['d_producto']; ?></label></abbr>
        </div>
      </div>
    </div>

    <div class="row m-t-5">
      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Precio de Venta: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="precioventa" id="precioventa" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_precio'], 2, '.', ''); ?>" placeholder="Ingrese Precio Venta" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>

      <div class="col-md-6"> 
        <div class="form-group has-feedback"> 
          <label class="control-label">Nuevo Descuento de Servicio: <span class="symbol required"></span></label> 
          <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="descproducto" id="descproducto" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" onfocus="this.style.background=('#FDF0DF')" autocomplete="off" value="<?php echo number_format($_GET['d_descproducto'], 2, '.', ''); ?>" placeholder="Ingrese Descuento" required="" aria-required="true">
          <i class="fa fa-pencil form-control-feedback"></i> 
        </div> 
      </div>
    </div> 

    <div class="modal-footer">
      <button type="button" onClick="DoActionPrecio(
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo str_replace($stringReplace, '', $_GET['d_producto']); ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0"; ?>',
        '<?php echo "0.00"; ?>',
        document.getElementById('precioventa').value,
        document.getElementById('descproducto').value,
        '<?php echo "(E)"; ?>',
        '<?php echo "0.00"; ?>',
        '<?php echo "0.00"; ?>',
        '3');" name="agregar" id="agregar" data-dismiss="modal" class="btn btn-info"><span class="fa fa-plus-circle"></span> Agregar</button>
      <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
    </div>
<?php

}
?>

<?php if($variable == 1){ ?>
<script type="text/javascript" src="assets/script/jspos.js"></script>
<?php } else if($variable == 2){ ?>
<script type="text/javascript" src="assets/script/jscotizaciones.js"></script>
<?php } else if($variable == 3){ ?>
<script type="text/javascript" src="assets/script/jspreventas.js"></script>
<?php } else if($variable == 4){ ?>
<script type="text/javascript" src="assets/script/jsventas.js"></script>
<?php } ?>

<?php
} 
######################## BUSQUEDA DETALLE DE PRODUCTO PARA PRECIO ########################
?>