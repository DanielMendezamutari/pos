<?php
require_once("class/class.php");
$new = new Login();

######################## MUESTRA RESILTADOS DE ENCOMIENDAS ########################
if (isset($_GET['MuestraDetallesTracking']) && isset($_GET['tracking'])) {
  
$tracking = limpiar($_GET['tracking']);

if($tracking=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE Nº DE TRACKING PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$detalle = $new->BusquedaTracking();

if($detalle[0]['estado_traspaso'] == 1){
$estado = "<span class='badge badge-info alert-link'><i class='fa fa-info'></i> REGISTRADO</span>";
} elseif($detalle[0]['estado_traspaso'] == 2){
$estado = "<span class='badge badge-info alert-link'><i class='fa fa-truck'></i> EN PROCESO (ENVIADO)</span>";
} elseif($detalle[0]['estado_traspaso'] == 3){
$estado = "<span class='badge badge-info alert-link'><i class='fa fa-truck'></i> PENDIENTE (LLEGO A SU DESTINO)</span>";
} elseif($detalle[0]['estado_traspaso'] == 4){
$estado = "<span class='badge badge-success alert-link'><i class='fa fa-check'></i> RECIBIDO</span>";
} elseif($detalle[0]['estado_traspaso'] == 5){
$estado = "<span class='badge badge-danger alert-link'><i class='fa fa-times-circle'></i> RECHAZADA</span>"; 
}
?>
    <h2 class="card-subtitle m-0 text-dark"><i class="font-22 fa fa-folder-open"></i> Detalles de Encomienda</h2><hr>

    <div class="row" style="border-left: 4px solid #ff5050 !important; background: #f6f7f8;">
      <div class="col-md-3">
          <div class="form-group has-feedback">
          <label class="control-label alert-link">Nº de Tracking: <span class="symbol required"></span></label>
              <br /><abbr title="Nº de Tracking"><?php echo $detalle[0]['numero_tracking']; ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
              <label class="control-label alert-link">Fecha de Envio: <span class="symbol required"></span></label>
              <br /><abbr title="Fecha de Envio"><?php echo $fecha = ($detalle[0]['fecha_enviado'] == "" ? "******" : date("d/m/Y",strtotime($detalle[0]['fecha_enviado']))); ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
              <label class="control-label alert-link">Hora de Envio: <span class="symbol required"></span></label>
              <br /><abbr title="Hora de Envio"><?php echo $hora = ($detalle[0]['fecha_enviado'] == "" ? "******" : date("H:i:s",strtotime($detalle[0]['fecha_enviado']))); ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
              <label class="control-label alert-link">Responsable de Entrega: <span class="symbol required"></span></label>
              <br /><abbr title="Responsable de Entrega"><?php echo $responsable = ($detalle[0]['fecha_enviado'] == "" ? "******" : $detalle[0]['nombres_responsable']); ?></abbr>
          </div>
      </div>
    </div>

    <div class="row" style="border-left: 4px solid #ff5050 !important; background: #f6f7f8;">
      <div class="col-md-3">
          <div class="form-group has-feedback">
          <label class="control-label alert-link">Estado: <span class="symbol required"></span></label>
              <br /><abbr title="Estado"><?php echo "<span class='font-18'>".$estado."</span>"; ?></abbr>
          </div>
      </div>
    </div>

    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 fa fa-home"></i> Información del Remitente</h2><hr>

    <div class="row" style="border-left: 4px solid #ff5050 !important; background: #f6f7f8;">
      <div class="col-md-3">
          <div class="form-group has-feedback">
              <label class="control-label alert-link"> Nº DE <?php echo $documento = ($detalle[0]['documsucursal'] == '0' ? "SUCURSAL:" : $detalle[0]['documento'].":"); ?> <span class="symbol required"></span></label>
              <br /><abbr title="Nº de Documento"><?php echo $detalle[0]['cuitsucursal']; ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
              <label class="control-label alert-link">Razón Social: <span class="symbol required"></span></label>
              <br /><abbr title="Razón Social"><?php echo $detalle[0]['nomsucursal']; ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
          <label class="control-label alert-link">Nº de Telefono: <span class="symbol required"></span></label>
              <br /><abbr title="Nº de Telefono"><?php echo $detalle[0]['tlfsucursal']; ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
          <label class="control-label alert-link">Nombre de Encargado: <span class="symbol required"></span></label>
              <br /><abbr title="Nombre de Encargado"><?php echo $detalle[0]['nomencargado']; ?></abbr>
          </div>
      </div>
    </div>

    <div class="row" style="border-left: 4px solid #ff5050 !important; background: #f6f7f8;">
      <div class="col-md-6">
          <div class="form-group has-feedback">
              <label class="control-label alert-link"> Dirección: <span class="symbol required"></span></label>
              <br /><abbr title="Dirección"><?php echo $provincia = ($detalle[0]['id_provincia'] == '' ? "" : $detalle[0]['provincia'])." ".$departamento = ($detalle[0]['id_departamento'] == '' ? "" : $detalle[0]['departamento'])." ".$detalle[0]['direcsucursal']; ?></abbr>
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group has-feedback">
              <label class="control-label alert-link">Correo Electronico: <span class="symbol required"></span></label>
              <br /><abbr title="Correo Electronico"><?php echo $detalle[0]['correosucursal']; ?></abbr>
          </div>
      </div>
    </div>


    <hr><h2 class="card-subtitle m-0 text-dark"><i class="font-22 fa fa-home"></i> Información del Destinatario</h2><hr>

    <div class="row" style="border-left: 4px solid #ff5050 !important; background: #f6f7f8;">
      <div class="col-md-3">
          <div class="form-group has-feedback">
              <label class="control-label alert-link"> Nº DE <?php echo $documento = ($detalle[0]['documsucursal2'] == '0' ? "SUCURSAL:" : $detalle[0]['documento2'].":"); ?> <span class="symbol required"></span></label>
              <br /><abbr title="Nº de Documento"><?php echo $detalle[0]['cuitsucursal2']; ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
              <label class="control-label alert-link">Razón Social: <span class="symbol required"></span></label>
              <br /><abbr title="Razón Social"><?php echo $detalle[0]['nomsucursal2']; ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
          <label class="control-label alert-link">Nº de Telefono: <span class="symbol required"></span></label>
              <br /><abbr title="Nº de Telefono"><?php echo $detalle[0]['tlfsucursal2']; ?></abbr>
          </div>
      </div>

      <div class="col-md-3">
          <div class="form-group has-feedback">
          <label class="control-label alert-link">Nombre de Encargado: <span class="symbol required"></span></label>
              <br /><abbr title="Nombre de Encargado"><?php echo $detalle[0]['nomencargado2']; ?></abbr>
          </div>
      </div>
    </div>

    <div class="row" style="border-left: 4px solid #ff5050 !important; background: #f6f7f8;">
      <div class="col-md-6">
          <div class="form-group has-feedback">
              <label class="control-label alert-link"> Dirección: <span class="symbol required"></span></label>
              <br /><abbr title="Dirección"><?php echo $provincia = ($detalle[0]['id_provincia2'] == '' ? "" : $detalle[0]['provincia2'])." ".$departamento = ($detalle[0]['id_departamento2'] == '' ? "" : $detalle[0]['departamento2'])." ".$detalle[0]['direcsucursal2']; ?></abbr>
          </div>
      </div>

      <div class="col-md-6">
          <div class="form-group has-feedback">
              <label class="control-label alert-link">Correo Electronico: <span class="symbol required"></span></label>
              <br /><abbr title="Correo Electronico"><?php echo $detalle[0]['correosucursal2']; ?></abbr>
          </div>
      </div>
    </div>

<?php
  }
}
######################## MUESTRA RESILTADOS DE ENCOMIENDAS ########################
?>