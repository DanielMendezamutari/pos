<?php
require_once("class/class.php");

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);

$con = new Login();
$con = $con->ConfiguracionPorId();
$simbolo = ($_SESSION["acceso"] == "administradorG" ? "" : "<strong>".$_SESSION["simbolo"]."</strong>");
$stringReplace = array("'", "&", '"','(',')');
?>


<!--######################### LISTAR PRODUCTOS POR FAMILIAS ########################-->
<?php if (isset($_GET['CargarProductos'])): ?>

<h3 class="card-subtitle m-0 text-dark"><i class='font-20 fa fa-cubes'></i> Monitor de Productos</h3><hr>

<?php
$familia = new Login();
$familia = $familia->ListarFamilias();
?>
    <div class="row-horizon">
        <span class="categories selectedGat" id=""><i class="fa fa-home"></i></span>
        <?php 
        if($familia==""){ echo ""; } else {
        $a=1;
        for ($i = 0; $i < sizeof($familia); $i++) { ?>
        <span class="categories" id="<?php echo $familia[$i]['nomfamilia'];?>"><i class="fa fa-tasks"></i> <?php echo $familia[$i]['nomfamilia'];?></span>
        <?php } } ?>
    </div>

    <div class="col-md-12">
        <div id="searchContaner"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label"></label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busquedaproducto" id="busquedaproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                  <i class="fa fa-search form-control-feedback2"></i> 
            </div> 
        </div>
    </div>

    <div id="productList2">
        
      <div class="tab-content w-100" style="padding: 5px; overflow: visible;">
        <div class="slimScrollDiv" style="position: relative; overflow: visible hidden; width: auto; height: 100%;">

        <!-- column -->
        <div>
          <?php
          $producto = new Login();
          $producto = $producto->ListarProductosModal();

          if($producto==""){

            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN PRODUCTOS REGISTRADOS ACTUALMENTE</center>";
            echo "</div>";  

          } else { ?>

          <div class="row-vertical">
            <?php 
            $x=1;
            for ($ii = 0; $ii < sizeof($producto); $ii++) {
            $sinstock = ($producto[$ii]['existencia'] <= 0);
            ?>

            <article class="product p-w-t animated fadeIn" <?php if (!$sinstock): ?>OnClick="DoAction(
            '<?php echo $producto[$ii]['idproducto']; ?>',
            '<?php echo $producto[$ii]['codproducto']; ?>',
            '<?php echo str_replace($stringReplace, '', $producto[$ii]['producto']); ?>',
            '<?php echo str_replace($stringReplace, '', $producto[$ii]['descripcion'] == '' ? "0" : $producto[$ii]['descripcion']); ?>',
            '<?php echo $producto[$ii]['imei'] == '' ? "0" : $producto[$ii]['imei']; ?>',
            '<?php echo $producto[$ii]['condicion'] == '' ? "******" : $producto[$ii]['condicion']; ?>',
            '<?php echo $producto[$ii]['codmarca']; ?>',
            '<?php echo $producto[$ii]['codmarca'] == 0 ? "******" : $producto[$ii]['nommarca']; ?>',
            '<?php echo $producto[$ii]['codmodelo']; ?>',
            '<?php echo $producto[$ii]['codmodelo'] == 0 ? "******" : $producto[$ii]['nommodelo']; ?>',
            '<?php echo $producto[$ii]['codpresentacion']; ?>',
            '<?php echo $producto[$ii]['codpresentacion'] == 0 ? "******" : $producto[$ii]['nompresentacion']; ?>',
            '<?php echo $producto[$ii]['codcolor']; ?>',
            '<?php echo $producto[$ii]['codcolor'] == 0 ? "******" : $producto[$ii]['nomcolor']; ?>',
            '<?php echo number_format($producto[$ii]['preciocompra'], 2, '.', ''); ?>',
            '<?php echo number_format($producto[$ii]['precioxpublico'], 2, '.', ''); ?>',
            '<?php echo number_format($producto[$ii]['descproducto'], 2, '.', ''); ?>',
            '<?php echo $ivaproducto = ( $producto[$ii]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', '') : "(E)"); ?>',
            '<?php echo $producto[$ii]['existencia']; ?>',
            '<?php echo $precioconiva = ( $producto[$ii]['ivaproducto'] == 'SI' ? number_format($producto[$ii]['precioxpublico'], 2, '.', '') : "0.00"); ?>',
            '1');"
            <?php else: ?>style="opacity:0.45; cursor:not-allowed;" onclick="swal('SIN STOCK','El producto &quot;<?php echo addslashes($producto[$ii]['producto']); ?>&quot; no tiene stock disponible!','warning'); return false;"<?php endif; ?>
            title="<?php echo $producto[$ii]['producto'].' | ('.$producto[$ii]['nomfamilia'].')'.($sinstock ? ' | SIN STOCK' : '');?>">
            <div>
            <div id="<?php echo $producto[$ii]['codproducto']; ?>">
            <div class="product-img">
              <?php
                if (file_exists("fotos/productos/".$producto[$ii]["codsucursal"]."_".$producto[$ii]["codproducto"].".jpg")){
                echo "<img src='fotos/productos/".$producto[$ii]["codsucursal"]."_".$producto[$ii]['codproducto'].".jpg?'>";
                } else if (file_exists("fotos/productos/".$producto[$ii]["codsucursal"]."_".$producto[$ii]["codproducto"].".jpeg")){
                echo "<img src='fotos/productos/".$producto[$ii]["codsucursal"]."_".$producto[$ii]['codproducto'].".jpeg?'>";
                } else if (file_exists("fotos/productos/".$producto[$ii]["codsucursal"]."_".$producto[$ii]["codproducto"].".png")){
                echo "<img src='fotos/productos/".$producto[$ii]["codsucursal"]."_".$producto[$ii]['codproducto'].".png?'>";
                } else {
                echo "<img src='fotos/default.png'>";  
              } ?>
              <span class="price-tag"><?php echo $simbolo.number_format($producto[$ii]['precioxpublico'], 2, '.', ','); ?></span><span class="pres-tag"><?php echo getSubString($producto[$ii]['producto'],18);?> </span><?php if ($sinstock): ?><span style="position:absolute;bottom:18px;left:3px;background:#dc3545;color:#fff;font-size:9px;font-weight:700;padding:2px 5px;border-radius:2px;line-height:13px;z-index:10;">SIN STOCK</span><?php else: ?><span style="position:absolute;bottom:18px;left:3px;background:#28a745;color:#fff;font-size:9px;font-weight:700;padding:2px 5px;border-radius:2px;line-height:13px;z-index:10;">Stock: <?php echo (int)$producto[$ii]['existencia']; ?></span><?php endif; ?>
            </div>
              <input type="hidden" id="proname" name="proname" value="<?php echo $producto[$ii]['codproducto'].", ".$producto[$ii]['producto'].", ".$producto[$ii]['codigobarra']; ?>">
              <input type="hidden" id="category" name="category" value="<?php echo $producto[$ii]['nomfamilia']; ?>">
              <div class="product-nam text-dark alert-link"><?php echo getSubString($producto[$ii]['nomfamilia'],22);?></div>
            </div>
            </div>
            </article>
                
            <?php } // fin for ?>
          </div>

        <?php } // fin if ?>
               
        </div>
        <!-- column -->

        </div> 

        </div> 
    </div>
 
<?php endif; ?>
<!--######################### LISTAR PRODUCTOS POR FAMILIAS ########################-->


<!--######################### LISTAR COMBOS ########################-->
<?php if (isset($_GET['CargarCombos'])): ?>

<h3 class="card-subtitle m-0 text-dark"><i class='font-20 fa fa-archive'></i> Monitor de Combos</h3><hr>

<?php
$familia = new Login();
$familia = $familia->ListarFamilias();
?>
    <div class="row-horizon">
        <span class="categories selectedGat" id=""><i class="fa fa-home"></i></span>
        <?php 
        if($familia==""){ echo ""; } else {
        $a=1;
        for ($i = 0; $i < sizeof($familia); $i++) { ?>
        <span class="categories" id="<?php echo $familia[$i]['nomfamilia'];?>"><i class="fa fa-tasks"></i> <?php echo $familia[$i]['nomfamilia'];?></span>
        <?php } } ?>
    </div>

    <div class="col-md-12">
        <div id="searchContaner"> 
            <div class="form-group has-feedback2"> 
                <label class="control-label"></label>
                <input style="color:#000;font-weight:bold;" type="text" class="form-control" name="busquedaproducto" id="busquedaproducto" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Criterio para tu Búsqueda">
                  <i class="fa fa-search form-control-feedback2"></i> 
            </div> 
        </div>
    </div>

    <div id="productList2">
        
      <div class="tab-content w-100" style="padding: 5px; overflow: visible;">
        <div class="slimScrollDiv" style="position: relative; overflow: visible hidden; width: auto; height: 100%;">

        <!-- column -->
        <div>
              
          <?php
          $combo = new Login();
          $combo = $combo->ListarCombosModal();

          if($combo==""){

            echo "<div class='alert alert-danger'>";
            echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
            echo "<center><span class='fa fa-info-circle'></span> NO EXISTEN COMBOS REGISTRADOS ACTUALMENTE</center>";
            echo "</div>";  

          } else { ?>

          <div class="row-vertical">
            <?php 
            $x=1;
            for ($ii = 0; $ii < sizeof($combo); $ii++) { ?>

            <article class="product p-w-t animated fadeIn" OnClick="DoAction(
            '<?php echo $combo[$ii]['idcombo']; ?>',
            '<?php echo $combo[$ii]['codcombo']; ?>',
            '<?php echo str_replace($stringReplace, '', $combo[$ii]['nomcombo']); ?>',
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
            '<?php echo number_format($combo[$ii]['preciocompra'], 2, '.', ''); ?>',
            '<?php echo number_format($combo[$ii]['precioventa'], 2, '.', ''); ?>',
            '<?php echo number_format($combo[$ii]['desccombo'], 2, '.', ''); ?>',
            '<?php echo $ivacombo = ( $combo[$ii]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', '') : "(E)"); ?>',
            '<?php echo $combo[$ii]['existencia']; ?>',
            '<?php echo $precioconiva = ( $combo[$ii]['ivacombo'] == 'SI' ? number_format($combo[$ii]['precioventa'], 2, '.', '') : "0.00"); ?>','2');" title="<?php echo $combo[$ii]['nomcombo'].')';?>">
            <div>
              <div id="<?php echo $combo[$ii]['codcombo']; ?>">
              <div class="product-img">
                <?php
                if (file_exists("fotos/combos/".$combo[$ii]["codsucursal"]."_".$combo[$ii]["codcombo"].".jpg")){
                echo "<img src='fotos/combos/".$combo[$ii]["codsucursal"]."_".$combo[$ii]['codcombo'].".jpg?'>";
                } else if (file_exists("fotos/combos/".$combo[$ii]["codsucursal"]."_".$combo[$ii]["codcombo"].".jpeg")){
                echo "<img src='fotos/combos/".$combo[$ii]["codsucursal"]."_".$combo[$ii]['codcombo'].".jpeg?'>";
                } else if (file_exists("fotos/combos/".$combo[$ii]["codsucursal"]."_".$combo[$ii]["codcombo"].".png")){
                echo "<img src='fotos/combos/".$combo[$ii]["codsucursal"]."_".$combo[$ii]['codcombo'].".png?'>";
                } else {
                echo "<img src='fotos/default.png'>";  
                } ?>
                <span class="price-tag"><?php echo $simbolo.number_format($combo[$ii]['precioventa'], 2, '.', ','); ?></span>
                <span class="pres-tag"><?php echo getSubString($combo[$ii]['nomcombo'],18);?> </span>
              </div>
                <input type="hidden" id="proname" name="proname" value="<?php echo $combo[$ii]["codcombo"].", ".$combo[$ii]['nomcombo']; ?>">
                <input type="hidden" id="category" name="category" value="<?php echo $combo[$ii]['nomfamilia']; ?>">
                <div class="product-nam text-dark alert-link"><?php echo getSubString($combo[$ii]['nomfamilia'],22);?></div>
              </div>
              </div>
              </article>
                
              <?php } // fin for ?>
            </div>

            <?php } // fin if ?>
               
        </div>
        <!-- column -->

        </div> 

        </div> 
    </div>
 
<?php endif; ?>
<!--######################### LISTAR COMBOS ########################-->

<script type="text/javascript">
$(document).ready(function() {
  
  //  search product
  $("#busquedaproducto").keyup(function(){
      // Retrieve the input field text
      var filter = $(this).val();
      // Loop through the list
      $("#productList2 #proname").each(function(){
        // If the list item does not contain the text phrase fade it out
        if ($(this).val().search(new RegExp(filter, "i")) < 0) {
          $(this).parent().parent().parent().hide();
        // Show the list item if the phrase matches
        } else {
          $(this).parent().parent().parent().show();
        }
    });
  });


  $(".categorias").on("click", function () {
   // Retrieve the input field text
   var filter = $(this).attr('id');
   $(this).parent().children().removeClass('selectedGat');
   $(this).addClass('selectedGat');
  });

  $(".categories").on("click", function () {
   // Retrieve the input field text
   var filter = $(this).attr('id');
   $(this).parent().children().removeClass('selectedGat');

   $(this).addClass('selectedGat');
   // Loop through the list
   $("#productList2 #category").each(function(){
      // If the list item does not contain the text phrase fade it out
      if ($(this).val().search(new RegExp(filter, "i")) < 0) {
         $(this).parent().parent().parent().hide();
         // Show the list item if the phrase matches
      } else {
         $(this).parent().parent().parent().show();
      }
    });
  });

});
</script>