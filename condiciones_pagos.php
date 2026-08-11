<?php
require_once("class/class.php");
?>
<script src="assets/script/jscalendario.js"></script>
<script src="assets/script/autocompleto.js"></script>

<?php
$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = ($imp == "" ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = ($imp == "" ? "0.00" : $imp[0]['valorimpuesto']);
?>


<?php 
######################## MUESTRA CONDICIONES DE PAGO ########################
if (isset($_GET['BuscaCondicionesPagos']) && isset($_GET['tipopago']) && isset($_GET['txtTotal'])) { 
  
$tra = new Login();

 if(limpiar($_GET['tipopago'])==""){ echo ""; 

 } elseif(limpiar($_GET['tipopago'])=="CONTADO"){  ?>

      <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback"> 
            <label class="control-label">Forma de Pago: <span class="symbol required"></span></label>
            <i class="fa fa-bars form-control-feedback"></i>
            <select style="color:#000;font-weight:bold;" name="pagos[0][codmediopago]" id="codmediopago" title="Seleccione Forma Pago" class="form-control" required aria-required="true">
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
                <input style="color:#000;font-weight:bold;" class="form-control" type="text" name="pagos[0][montopagado]" id="montopagado" onKeyUp="CalculoDevolucion();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" placeholder="Monto Recibido" title="Ingrese Monto Recibido" autocomplete="off" value="<?php echo number_format($_GET['txtTotal'], 2, '.', ''); ?>">
                <div class="input-group-append">
                  <div class="btn-group" data-bs-toggle="buttons">
                    <button type="button" class="btn btn-info waves-effect waves-light" data-placement="left" title="Agregar" data-original-title="" onclick="addRowPago()"><span class="fa fa-plus"></span></button>
                  </div>
                </div><!---->
            </div>
        </div>
      </div>
          
 <?php  } else if(limpiar($_GET['tipopago'])=="CREDITO"){  ?>

      <div class="row">
          <div class="col-md-4"> 
               <div class="form-group has-feedback"> 
                  <label class="control-label">Fecha Vence Crédito: <span class="symbol required"></span></label> 
                  <input style="color:#000;font-weight:bold;" type="text" class="form-control expira" name="fechavencecredito" id="fechavencecredito" onKeyUp="this.value=this.value.toUpperCase();" autocomplete="off" placeholder="Ingrese Fecha Vence Crédito" aria-required="true">
                  <i class="fa fa-calendar form-control-feedback"></i>  
             </div> 
          </div> 

          <div class="col-md-4">
              <div class="form-group">
                  <label class="control-label">Forma de Pago: </label>
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
                  <option value="<?php echo encrypt($medio[$i]['codmediopago']); ?>"><?php echo $medio[$i]['mediopago'] ?></option>
                  <?php } } ?>
                  </select>
              </div>
          </div>

          <div class="col-md-4"> 
              <div class="form-group has-feedback"> 
                 <label class="control-label">Abono Crédito: </label>
                 <input style="color:#000;font-weight:bold;" class="form-control number" type="text" name="montoabono" id="montoabono" onKeyUp="this.value=this.value.toUpperCase();" onKeyPress="EvaluateText('%f', this);" onBlur="this.value = NumberFormat(this.value, '2', '.', '')" autocomplete="off" placeholder="Ingrese Monto de Abono" value="0.00" required="" aria-required="true"> 
                 <i class="fa fa-tint form-control-feedback"></i>
              </div> 
          </div>
      </div>
 
<?php  
  }
}
######################## MUESTRA CONDICIONES DE PAGO ########################
?>
