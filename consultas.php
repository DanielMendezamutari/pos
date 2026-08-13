<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
  if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="vendedor") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "IMPUESTO" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);
    
$tra = new Login();
?>

<?php
############################# CARGAR USUARIOS ############################
if (isset($_GET['CargaUsuarios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
             <thead>
             <tr role="row">
                <th>N°</th>
                <th>N° de Documento</th>
                <th>Nombres y Apellidos</th>
                <th>Nº de Teléfono</th>
                <th>Usuario</th>
                <th>Nivel</th>
                <th>Estado</th>
                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                <th>Sucursal</th>
                <?php } ?>
                <th>Acciones</th>
             </tr>
             </thead>
             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarUsuarios();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON USUARIOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['dni']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['telefono']; ?></td>
    <td><?php echo $reg[$i]['usuario']; ?></td>
    <td><?php echo $reg[$i]['nivel']; ?></td>
    <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
    <?php if ($_SESSION['acceso'] == "administradorG") { ?><td class="text-dark alert-link"><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>')"><i class="fa fa-eye"></i></button>

    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalUser" data-backdrop="static" data-keyboard="false" onClick="UpdateUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo $reg[$i]["dni"]; ?>','<?php echo $reg[$i]["nombres"]; ?>','<?php echo $reg[$i]["sexo"]; ?>','<?php echo $reg[$i]["direccion"]; ?>','<?php echo $reg[$i]["telefono"]; ?>','<?php echo $reg[$i]["email"]; ?>','<?php echo $reg[$i]["usuario"]; ?>','<?php echo $reg[$i]["nivel"]; ?>','<?php echo $reg[$i]["status"]; ?>','<?php echo number_format($reg[$i]["comision"], 2, '.', ''); ?>','<?php echo $reg[$i]["codsucursal"] == '' ? encrypt("0") : encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <?php if($reg[$i]["status"] == 1){ ?>
    <span class="btn btn-danger btn-rounded" style="cursor: pointer;" title="Inactivar Usuario" onClick="StatusUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["status"]); ?>','<?php echo encrypt("STATUSUSUARIOS") ?>')"><i class="fa fa-user-times"></i></span>
    <?php } else { ?>
    <span class="btn btn-warning btn-rounded text-white" style="cursor: pointer;" title="Activar Usuario" onClick="StatusUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["status"]); ?>','<?php echo encrypt("STATUSUSUARIOS") ?>')"><i class="fa fa-user-plus"></i></span>
    <?php } ?>
                                 
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarUsuario('<?php echo encrypt($reg[$i]["codigo"]); ?>','<?php echo encrypt($reg[$i]["dni"]); ?>','<?php echo encrypt("USUARIOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR USUARIOS ############################
?>


<?php
############################# CARGAR LOGS DE USUARIOS ############################
if (isset($_GET['CargaLogs'])) { 
?>

<div id="div2"><div class="table-responsive" data-pattern="priority-columns">
      <table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Ip de Máquina</th>
                    <th>Fecha</th>
                    <th>Navegador</th>
                    <th>Usuario</th>
                    <?php if($_SESSION['acceso']=="administradorG"){ ?>
                    <th>Sucursal</th><?php } ?>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BusquedaLogs();

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON REGISTROS DE ACCESO ACTUALMENTE</center>";
  echo "</div>";
  exit;    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['ip']; ?></td>
    <td><?php echo $reg[$i]['tiempo']; ?></td>
    <td><?php echo $reg[$i]['detalles']; ?></td>
    <td><?php echo $reg[$i]['usuario']; ?></td>
    <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><?php echo $reg[$i]['codsucursal'] == 0 ? "**********" : $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>"; ?></td><?php } ?>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div></div>
<?php
} 
############################# CARGAR LOGS DE USUARIOS ############################
?>


<?php
############################# CARGAR PROVINCIAS ############################
if (isset($_GET['CargaProvincias'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">
                    <thead>
                    <tr role="row">
                        <th>N°</th>
                        <th>Provincias</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProvincias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVINCIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['provincia']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateProvincia('<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["provincia"]; ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProvincia('<?php echo encrypt($reg[$i]["id_provincia"]); ?>','<?php echo encrypt("PROVINCIAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PROVINCIAS ############################
?>


<?php
############################# CARGAR DEPARTAMENTOS ############################
if (isset($_GET['CargaDepartamentos'])) { 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                            <thead>
                            <tr role="row">
                                <th>N°</th>
                                <th>Provincia</th>
                                <th>Departamento</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDepartamentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON DEPARTAMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['departamento']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDepartamento('<?php echo $reg[$i]["id_departamento"]; ?>','<?php echo $reg[$i]["departamento"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDepartamento('<?php echo encrypt($reg[$i]["id_departamento"]); ?>','<?php echo encrypt("DEPARTAMENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR DEPARTAMENTOS ############################
?>


<?php
############################# CARGAR TIPOS DE DOCUMENTOS ############################
if (isset($_GET['CargaDocumentos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                        <thead>
                        <tr role="row">
                            <th>N°</th>
                            <th>Nombre</th>
                            <th>Descripción de Documento</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarDocumentos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE DOCUMENTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['documento']; ?></td>
    <td><?php echo $reg[$i]['descripcion']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateDocumento('<?php echo $reg[$i]["coddocumento"]; ?>','<?php echo $reg[$i]["documento"]; ?>','<?php echo $reg[$i]["descripcion"]; ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarDocumento('<?php echo encrypt($reg[$i]["coddocumento"]); ?>','<?php echo encrypt("DOCUMENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TIPOS DE DOCUMENTOS ############################
?>


<?php
############################# CARGAR TIPOS DE MONEDA ############################
if (isset($_GET['CargaMonedas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Moneda</th>
                    <th>Siglas</th>
                    <th>Simbolo</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoMoneda();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE MONEDAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['moneda']; ?></td>
    <td><?php echo $reg[$i]['siglas']; ?></td>
    <td><?php echo $reg[$i]['simbolo']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoMoneda('<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["moneda"]; ?>','<?php echo $reg[$i]["siglas"]; ?>','<?php echo $reg[$i]["simbolo"]; ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTipoMoneda('<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo encrypt("TIPOMONEDA") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TIPOS DE MONEDA ############################
?>









<?php
############################# CARGAR TIPOS DE CAMBIO X SUCURSAL ############################
if (isset($_GET['BuscaTiposCambiosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Tipos de Cambio</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Cambio" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalTipoCambio" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxTipoCambio('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("TIPOCAMBIO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TIPOCAMBIO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TIPOCAMBIO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Descripción de Cambio</th>
                    <th>Monto de Cambio</th>
                    <th>Tipo Moneda</th>
                    <th>Fecha Ingreso</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarTipoCambio();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIOS DE MONEDA ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
    <td><?php echo $reg[$i]['montocambio']; ?></td>
    <td><abbr title="<?php echo "Siglas: ".$reg[$i]['siglas']; ?>"><?php echo $reg[$i]['moneda']; ?></abbr></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalTipoCambio" data-backdrop="static" data-keyboard="false" onClick="UpdateTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo $reg[$i]["descripcioncambio"]; ?>','<?php echo $reg[$i]["montocambio"]; ?>','<?php echo encrypt($reg[$i]["codmoneda"]); ?>','<?php echo date("Y-m-d",strtotime($reg[$i]['fechacambio'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("TIPOCAMBIO"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR TIPOS DE CAMBIO X SUCURSAL ############################
?>

<?php
############################# CARGAR TIPOS DE CAMBIO ############################
if (isset($_GET['CargaCambios'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row">
                <th>N°</th>
                <th>Descripción de Cambio</th>
                <th>Monto de Cambio</th>
                <th>Tipo Moneda</th>
                <th>Fecha Ingreso</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTipoCambio();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TIPOS DE CAMBIO DE MONEDA ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
    <td><?php echo number_format($reg[$i]['montocambio'], 2, '.', ','); ?></td>
    <td><abbr title="<?php echo "Siglas: ".$reg[$i]['siglas']; ?>"><?php echo $reg[$i]['moneda']; ?></abbr></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
    <td>
    <?php if(date("d-m-Y",strtotime($reg[$i]['fechacambio'])) == date("d-m-Y")) { ?>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" onClick="UpdateTipoCambio('<?php echo $reg[$i]["codcambio"]; ?>','<?php echo $reg[$i]["descripcioncambio"]; ?>','<?php echo number_format($reg[$i]["montocambio"], 2, '.', ''); ?>','<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo date("Y-m-d",strtotime($reg[$i]['fechacambio'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
    <?php } ?>
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTipoCambio('<?php echo encrypt($reg[$i]["codcambio"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("TIPOCAMBIO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TIPOS DE CAMBIO ############################
?>

















<?php
############################# CARGAR MEDIOS DE PAGOS X SUCURSAL ############################
if (isset($_GET['BuscaMediosPagosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Formas de Pagos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Medio de Pago" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMedioPago" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMedioPago('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MEDIOSPAGOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MEDIOSPAGOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MEDIOSPAGOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Medio de Pago</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarMediosPagos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MEDIOS DE PAGOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMedioPago" data-backdrop="static" data-keyboard="false" onClick="UpdateMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo $reg[$i]["mediopago"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("MEDIOSPAGOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MEDIOS DE PAGOS X SUCURSAL ############################
?>

<?php
############################# CARGAR MEDIOS DE PAGOS ############################
if (isset($_GET['CargaMediosPagos'])) { 
?>
<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Medio de Pago</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMediosPagos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MEDIOS DE PAGOS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMedioPago" data-backdrop="static" data-keyboard="false" onClick="UpdateMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo $reg[$i]["mediopago"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMedioPago('<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("MEDIOSPAGOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR MEDIOS DE PAGOS ############################
?>

















<?php
############################# CARGAR IMPUESTOS X SUCURSAL ############################
if (isset($_GET['BuscaImpuestosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Impuestos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Impuesto" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImpuesto" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxImpuesto('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("IMPUESTOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("IMPUESTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("IMPUESTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Impuesto</th>
                    <th>Valor (%)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarImpuestos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMPUESTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
    <td><?php echo $reg[$i]['valorimpuesto']; ?></td>
    <td><?php echo $status = ($reg[$i]['statusimpuesto'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImpuesto" data-backdrop="static" data-keyboard="false" onClick="UpdateImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo $reg[$i]["nomimpuesto"]; ?>','<?php echo $reg[$i]["valorimpuesto"]; ?>','<?php echo $reg[$i]["statusimpuesto"]; ?>','<?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("IMPUESTOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR IMPUESTOS X SUCURSAL ############################
?>

<?php
############################# CARGAR IMPUESTOS ############################
if (isset($_GET['CargaImpuestos'])) { 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

        <thead>
        <tr role="row">
            <th>N°</th>
            <th>Nombre de Impuesto</th>
            <th>Valor (%)</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarImpuestos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON IMPUESTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
    <td><?php echo number_format($reg[$i]['valorimpuesto'], 2, '.', ','); ?></td>
    <td><?php echo $status = ($reg[$i]['statusimpuesto'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-dark'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImpuesto" data-backdrop="static" data-keyboard="false" onClick="UpdateImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo $reg[$i]["nomimpuesto"]; ?>','<?php echo $reg[$i]["valorimpuesto"]; ?>','<?php echo $reg[$i]["statusimpuesto"]; ?>','<?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarImpuesto('<?php echo encrypt($reg[$i]["codimpuesto"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("IMPUESTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>   
<?php 
} 
############################# CARGAR IMPUESTOS ############################
?>


















<?php
############################# CARGAR BANCOS X SUCURSAL ############################
if (isset($_GET['BuscaBancosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Bancos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Banco" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalBanco" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxBanco('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("BANCOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("BANCOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("BANCOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Banco</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarBancos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON BANCOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nombanco']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalBanco" data-backdrop="static" data-keyboard="false" onClick="UpdateBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo $reg[$i]["nombanco"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("BANCOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MEDIOS DE PAGOS X SUCURSAL ############################
?>

<?php
############################# CARGAR BANCOS ############################
if (isset($_GET['CargaBancos'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                    <thead>
                    <tr role="row">
                        <th>N°</th>
                        <th>Nombre de Banco</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarBancos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON BANCOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nombanco']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalBanco" data-backdrop="static" data-keyboard="false" onClick="UpdateBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo $reg[$i]["nombanco"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarBanco('<?php echo encrypt($reg[$i]["codbanco"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("BANCOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR BANCOS ############################
?>






<?php
############################# CARGAR SUCURSALES ############################
if (isset($_GET['CargaSucursales'])) { 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
        <thead>
        <tr role="row">
            <th>N°</th>
            <th>Logo</th>
            <th>N° de Documento</th>
            <th>Razón Social</th>
            <th>Nº de Teléfono</th>
            <th>Email</th>
            <th>Encargado</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarSucursales();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUCURSALES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php if (file_exists("fotos/sucursales/".$reg[$i]["cuitsucursal"].".png")){
    echo "<img src='fotos/sucursales/".$reg[$i]["cuitsucursal"].".png?' class='img-rounded' style='margin:0px;' width='50' height='40'>";
    } else {
    echo "<img src='fotos/img.png' class='img-rounded' style='margin:0px;' width='50' height='40'>";  
    } ?>
    </a></td>
    <td><?php echo $reg[$i]['cuitsucursal']; ?></td>
    <td class="text-dark alert-link"><?php echo $reg[$i]['nomsucursal']; ?></td>
    <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
    <td><?php echo $reg[$i]['correosucursal']; ?></td>
    <td><?php echo $reg[$i]['nomencargado']; ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalSucursal" data-backdrop="static" data-keyboard="false" onClick="UpdateSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $documento1 = ($reg[$i]["documsucursal"] == 0 ? "" : $reg[$i]["documsucursal"]); ?>','<?php echo $reg[$i]["cuitsucursal"]; ?>','<?php echo $reg[$i]["nomsucursal"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["direcsucursal"]; ?>','<?php echo $reg[$i]["correosucursal"]; ?>','<?php echo $reg[$i]["tlfsucursal"]; ?>','<?php echo $reg[$i]["inicioticket"]; ?>','<?php echo $reg[$i]["iniciofactura"]; ?>','<?php echo $reg[$i]["inicioguia"]; ?>','<?php echo $reg[$i]["inicionotaventa"]; ?>','<?php echo $reg[$i]["inicionotacredito"]; ?>','<?php echo $reg[$i]["nroactividadsucursal"]; ?>','<?php echo date('d-m-Y', strtotime($reg[$i]["fechaautorsucursal"])); ?>','<?php echo $reg[$i]["llevacontabilidad"]; ?>','<?php echo $documento2 = ($reg[$i]["documencargado"] == 0 ? "" : $reg[$i]["documencargado"]); ?>','<?php echo $reg[$i]["dniencargado"]; ?>','<?php echo $reg[$i]["nomencargado"]; ?>','<?php echo $reg[$i]["tlfencargado"]; ?>','<?php echo number_format($reg[$i]["descsucursal"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["porcentaje"], 2, '.', ''); ?>','<?php echo $reg[$i]["codmoneda"]; ?>','<?php echo $reg[$i]["codmoneda2"]; ?>','<?php echo preg_replace("/\r\n|\r|\n/",'\n',$reg[$i]['membrete']); ?>','update'); SelectDepartamento('<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["id_departamento"]; ?>')"><i class="fa fa-edit"></i></button>

    <?php if($_SESSION['acceso'] == "administradorG" && $reg[$i]["estado"] == 1){ ?>
    <span class="btn btn-danger btn-rounded" style="cursor: pointer;" title="Inactivar Sucursal" onClick="StatusSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["estado"]); ?>','<?php echo encrypt("STATUSSUCURSALES") ?>')"><i class="fa fa-times"></i></span>
    <?php } else if($_SESSION['acceso'] == "administradorG" && $reg[$i]["estado"] == 0){ ?>
    <span class="btn btn-warning btn-rounded" style="cursor: pointer;" title="Activar Sucursal" onClick="StatusSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["estado"]); ?>','<?php echo encrypt("STATUSSUCURSALES") ?>')"><i class="fa fa-check"></i></span>
    <?php } ?>
    
    <?php if ($_SESSION['acceso'] == "administradorG") { ?><button type="button" class="btn btn-dark btn-rounded" onClick="EliminarSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("SUCURSALES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button><?php } ?></td>
            </tr>
            <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR SUCURSALES ############################
?>










<?php
############################# CARGAR FAMILIAS X SUCURSAL ############################
if (isset($_GET['BuscaFamiliasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Familias</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Familia" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalFamilia" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxFamilia('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FAMILIAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("FAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("FAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Familias</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarFamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON FAMILIAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalFamilia" data-backdrop="static" data-keyboard="false" onClick="UpdateFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo $reg[$i]["nomfamilia"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("FAMILIAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR FAMILIAS X SUCURSAL ############################
?>

<?php
############################# CARGAR FAMILIAS ############################
if (isset($_GET['CargaFamilias'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">
                    <thead>
                    <tr role="row">
                        <th>N°</th>
                        <th>Nombre de Familias</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarFamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON FAMILIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalFamilia" data-backdrop="static" data-keyboard="false" onClick="UpdateFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo $reg[$i]["nomfamilia"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarFamilia('<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("FAMILIAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR FAMILIAS ############################
?>











<?php
############################# CARGAR SUBFAMILIAS X SUCURSAL ############################
if (isset($_GET['BuscaSubfamiliasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Subfamilias</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Subfamilia" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalSubfamilia" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxSubfamilia('<?php echo $codsucursal; ?>');CargaFamiliasxSucursal('<?php echo $codsucursal; ?>','0');"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("SUBFAMILIAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("SUBFAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("SUBFAMILIAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Familias</th>
                    <th>Nombre de Subfamilias</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarSubfamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUBFAMILIAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalSubfamilia" data-backdrop="static" data-keyboard="false" onClick="UpdateSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo $reg[$i]["nomsubfamilia"]; ?>','<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); CargaFamiliasxSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codfamilia"]); ?>');"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("SUBFAMILIAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR SUBFAMILIAS X SUCURSAL ############################
?>

<?php
############################# CARGAR SUBFAMILIAS ############################
if (isset($_GET['CargaSubfamilias'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Familias</th>
                    <th>Nombre de Subfamilias</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarSubfamilias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON SUBFAMILIAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalSubfamilia" data-backdrop="static" data-keyboard="false" onClick="UpdateSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo $reg[$i]["nomsubfamilia"]; ?>','<?php echo encrypt($reg[$i]["codfamilia"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarSubfamilia('<?php echo encrypt($reg[$i]["codsubfamilia"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("SUBFAMILIAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR SUBFAMILIAS ############################
?>












<?php
############################# CARGAR MARCAS X SUCURSAL ############################
if (isset($_GET['BuscaMarcasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Marcas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Marca" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMarca" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMarca('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MARCAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MARCAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MARCAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Marcas</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarMarcas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MARCAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMarca" data-backdrop="static" data-keyboard="false" onClick="UpdateMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo $reg[$i]["nommarca"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("MARCAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MARCAS X SUCURSAL ############################
?>

<?php
############################# CARGAR MARCAS ############################
if (isset($_GET['CargaMarcas'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                    <thead>
                    <tr role="row">
                        <th>N°</th>
                        <th>Nombre de Marcas</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMarcas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MARCAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMarca" data-backdrop="static" data-keyboard="false" onClick="UpdateMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo $reg[$i]["nommarca"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMarca('<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("MARCAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR MARCAS ############################
?>












<?php
############################# CARGAR MODELOS X SUCURSAL ############################
if (isset($_GET['BuscaModelosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Modelos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Modelo" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalModelo" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxModelo('<?php echo $codsucursal; ?>');CargaMarcasxSucursal('<?php echo $codsucursal; ?>','0');"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MODELOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MODELOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MODELOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Marcas</th>
                    <th>Nombre de Modelos</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarModelos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MODELOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalModelo" data-backdrop="static" data-keyboard="false" onClick="UpdateModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo $reg[$i]["nommodelo"]; ?>','<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); CargaMarcasxSucursal('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codmarca"]); ?>');"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("MODELOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MODELOS X SUCURSAL ############################
?>

<?php
############################# CARGAR MODELOS ############################
if (isset($_GET['CargaModelos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Marcas</th>
                    <th>Nombre de Modelos</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarModelos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MODELOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalModelo" data-backdrop="static" data-keyboard="false" onClick="UpdateModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo $reg[$i]["nommodelo"]; ?>','<?php echo encrypt($reg[$i]["codmarca"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarModelo('<?php echo encrypt($reg[$i]["codmodelo"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("MODELOS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR MODELOS ############################
?>















<?php
############################# CARGAR PRESENTACIONES X SUCURSAL ############################
if (isset($_GET['BuscaPresentacionesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Presentaciones</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Presentación" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPresentacion" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxPresentacion('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRESENTACIONES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRESENTACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRESENTACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Presentación</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarPresentaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRESENTACIONES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPresentacion" data-backdrop="static" data-keyboard="false" onClick="UpdatePresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo $reg[$i]["nompresentacion"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarPresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("PRESENTACIONES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PRESENTACIONES X SUCURSAL ############################
?>

<?php
############################# CARGAR PRESENTACIONES ############################
if (isset($_GET['CargaPresentaciones'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Presentaciones</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPresentaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRESENTACIONES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nompresentacion']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPresentacion" data-backdrop="static" data-keyboard="false" onClick="UpdatePresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo $reg[$i]["nompresentacion"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarPresentacion('<?php echo encrypt($reg[$i]["codpresentacion"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("PRESENTACIONES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PRESENTACIONES ############################
?>












<?php
############################# CARGAR COLORES X SUCURSAL ############################
if (isset($_GET['BuscaColoresxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Colores</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Color" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalColor" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxColor('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COLORES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COLORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COLORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Color</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarColores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COLORES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomcolor']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalColor" data-backdrop="static" data-keyboard="false" onClick="UpdateColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo $reg[$i]["nomcolor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("COLORES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COLORES X SUCURSAL ############################
?>

<?php
############################# CARGAR COLORES ############################
if (isset($_GET['CargaColores'])) { 
?>

<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">

        <thead>
        <tr role="row">
            <th>N°</th>
            <th>Colores</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarColores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COLORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomcolor']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalColor" data-backdrop="static" data-keyboard="false" onClick="UpdateColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo $reg[$i]["nomcolor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarColor('<?php echo encrypt($reg[$i]["codcolor"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("COLORES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR COLORES ############################
?>
















<?php
############################# CARGAR ORIGENES X SUCURSAL ############################
if (isset($_GET['BuscaOrigenesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Colores</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Origen" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalOrigen" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxOrigen('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("ORIGENES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ORIGENES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ORIGENES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Origen</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarOrigenes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ORIGENES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomorigen']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalOrigen" data-backdrop="static" data-keyboard="false" onClick="UpdateOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo $reg[$i]["nomorigen"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("ORIGENES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR ORIGENES X SUCURSAL ############################
?>

<?php
############################# CARGAR ORIGENES ############################
if (isset($_GET['CargaOrigenes'])) { 
?>
<div class="table-responsive"><table id="datatable" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Origenes</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarOrigenes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ORIGENES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nomorigen']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalOrigen" data-backdrop="static" data-keyboard="false" onClick="UpdateOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo $reg[$i]["nomorigen"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarOrigen('<?php echo encrypt($reg[$i]["codorigen"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("ORIGENES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR ORIGENES ############################
?>
















<?php
############################# CARGAR CLIENTES X SUCURSAL ############################
if (isset($_GET['BuscaClientesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Clientes</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn waves-effect waves-light btn-light" data-placement="left" title="Carga Masiva" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCargaMasiva" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMasivaCliente('<?php echo $codsucursal; ?>')"><span class="fa fa-cloud-upload text-dark"></span> Cargar</button>
                    
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Cliente" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxCliente('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CLIENTES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                 <thead>
                 <tr role="row">
                    <th>N°</th>
                    <th>Tipo de Cliente</th>
                    <th>Nº de Documento</th>
                    <th>Nombres</th>
                    <th>Nº de Teléfono</th>
                    <th>Correo Electrónico</th>
                    <th>Acciones</th>
                 </tr>
                 </thead>
                 <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarClientes();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CLIENTES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td class="text-dark alert-link"><?php echo $reg[$i]['tipocliente']; ?></td>
    <td><?php echo $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'NATURAL' ? $reg[$i]['nomcliente'] : $reg[$i]['razoncliente']); ?></td>
    <td><?php echo $reg[$i]['tlfcliente'] == '' ? "***********" : $reg[$i]['tlfcliente']; ?></td>
    <td><?php echo $reg[$i]['emailcliente'] == '' ? "***********" : $reg[$i]['emailcliente']; ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>')"><i class="fa fa-eye"></i></button>
    
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false" onClick="UpdateCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo $reg[$i]["tipocliente"]; ?>','<?php echo $documento = ($reg[$i]["documcliente"] == 0 ? "" : $reg[$i]["documcliente"]); ?>','<?php echo $reg[$i]["dnicliente"]; ?>','<?php echo $reg[$i]["nomcliente"]; ?>','<?php echo $reg[$i]["razoncliente"]; ?>','<?php echo $reg[$i]["girocliente"]; ?>','<?php echo $reg[$i]["tlfcliente"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["direccliente"]; ?>','<?php echo $reg[$i]["emailcliente"]; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); SelectDepartamento('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["id_departamento"]; ?>'); CargaTipoCliente('<?php echo $reg[$i]["tipocliente"]; ?>');"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo encrypt("CLIENTES") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR CLIENTES X SUCURSAL ############################
?>

<?php
############################# CARGAR CLIENTES ############################
if (isset($_GET['CargaClientes']) && isset($_GET['bclientes'])) {

$criterio = limpiar($_GET['bclientes']);   
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                     <thead>
                     <tr role="row">
                        <th>N°</th>
                        <th>Tipo de Cliente</th>
                        <th>Nº de Documento</th>
                        <th>Nombres</th>
                        <th>Nº de Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>
                     </tr>
                     </thead>
                     <tbody class="BusquedaRapida">
<?php 
if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaClientes();
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td class="text-dark alert-link"><?php echo $reg[$i]['tipocliente']; ?></td>
    <td><?php echo $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'NATURAL' ? $reg[$i]['nomcliente'] : $reg[$i]['razoncliente']); ?></td>
    <td><?php echo $reg[$i]['tlfcliente'] == '' ? "***********" : $reg[$i]['tlfcliente']; ?></td>
    <td><?php echo $reg[$i]['emailcliente'] == '' ? "***********" : $reg[$i]['emailcliente']; ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>')"><i class="fa fa-eye"></i></button>

    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCliente" data-backdrop="static" data-keyboard="false" onClick="UpdateCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo $reg[$i]["tipocliente"]; ?>','<?php echo $documento = ($reg[$i]["documcliente"] == 0 ? "" : $reg[$i]["documcliente"]); ?>','<?php echo $reg[$i]["dnicliente"]; ?>','<?php echo $reg[$i]["nomcliente"]; ?>','<?php echo $reg[$i]["razoncliente"]; ?>','<?php echo $reg[$i]["girocliente"]; ?>','<?php echo $reg[$i]["tlfcliente"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["direccliente"]; ?>','<?php echo $reg[$i]["emailcliente"]; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); SelectDepartamento('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["id_departamento"]; ?>'); CargaTipoCliente('<?php echo $reg[$i]["tipocliente"]; ?>');"><i class="fa fa-edit"></i></button>
    
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCliente('<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo encrypt("CLIENTES") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR CLIENTES ############################
?>















<?php
############################# CARGAR PROVEEDORES X SUCURSAL ############################
if (isset($_GET['BuscaProveedoresxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Control de Proveedores</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
                <div class="btn-group m-b-20">
                <button type="button" class="btn waves-effect waves-light btn-light" data-placement="left" title="Carga Masiva" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCargaMasiva" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxMasivaProveedor('<?php echo $codsucursal; ?>')"><span class="fa fa-cloud-upload text-dark"></span> Cargar</button>
                    
                <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nuevo Proveedor" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxProveedor('<?php echo $codsucursal; ?>')"><i class="fa fa-plus"></i> Nuevo</button>

                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PROVEEDORES") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PROVEEDORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PROVEEDORES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
                </div>
            </div>
        </div>

        <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nº de Documento</th>
                    <th>Nombres de Proveedor</th>
                    <th>Correo Electrónico</th>
                    <th>Nº de Teléfono</th>
                    <th>Vendedor</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarProveedores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVEEDORES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
    <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
    <td><?php echo $reg[$i]['vendedor'] == '' ? "*********" : $reg[$i]['vendedor']; ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>')"><i class="fa fa-eye"></i></button>

    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false" onClick="UpdateProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo $documento = ($reg[$i]["documproveedor"] == 0 ? "" : $reg[$i]["documproveedor"]); ?>','<?php echo $reg[$i]["cuitproveedor"]; ?>','<?php echo $reg[$i]["nomproveedor"]; ?>','<?php echo $reg[$i]["tlfproveedor"]; ?>','<?php echo ($reg[$i]['id_provincia'] == '0' ? "" : $reg[$i]['id_provincia']); ?>','<?php echo $reg[$i]["direcproveedor"]; ?>','<?php echo $reg[$i]["emailproveedor"]; ?>','<?php echo $reg[$i]["vendedor"]; ?>','<?php echo $reg[$i]["tlfvendedor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update'); SelectDepartamento('<?php echo $reg[$i]['id_provincia']; ?>','<?php echo $reg[$i]["id_departamento"]; ?>')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("PROVEEDORES"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PROVEEDORES X SUCURSAL ############################
?>

<?php
############################# CARGAR PROVEEDORES ############################
if (isset($_GET['CargaProveedores'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                     <thead>
                     <tr role="row">
                        <th>N°</th>
                        <th>Nº Documento</th>
                        <th>Nombres de Proveedor</th>
                        <th>Correo Electrónico</th>
                        <th>Nº de Teléfono</th>
                        <th>Vendedor</th>
                        <th>Acciones</th>
                     </tr>
                     </thead>
                     <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProveedores();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento'])." ".$reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
    <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
    <td><?php echo $reg[$i]['vendedor'] == '' ? "*********" : $reg[$i]['vendedor']; ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>')"><i class="fa fa-eye"></i></button>

    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProveedor" data-backdrop="static" data-keyboard="false" onClick="UpdateProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo $documento = ($reg[$i]["documproveedor"] == 0 ? "" : $reg[$i]["documproveedor"]); ?>','<?php echo $reg[$i]["cuitproveedor"]; ?>','<?php echo $reg[$i]["nomproveedor"]; ?>','<?php echo $reg[$i]["tlfproveedor"]; ?>','<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["direcproveedor"]; ?>','<?php echo $reg[$i]["emailproveedor"]; ?>','<?php echo $reg[$i]["vendedor"]; ?>','<?php echo $reg[$i]["tlfvendedor"]; ?>','update'); SelectDepartamento('<?php echo $reg[$i]["id_provincia"]; ?>','<?php echo $reg[$i]["id_departamento"]; ?>')"><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProveedor('<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("PROVEEDORES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PROVEEDORES ############################
?>







<?php
############################# CARGAR PEDIDOS ############################
if (isset($_GET['CargaPedidos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                 <thead>
                                 <tr role="row">
                                    <th>N°</th>
                                    <th>N° de Factura</th>
                                    <th>Descripción de Proveedor</th>
                                    <th>Nº Artic</th>
                                    <th>Subtotal</th>
                                    <th><?php echo $impuesto; ?></th>
                                    <th>Dcto %</th>
                                    <th>Imp. Total</th>
                                    <th>Fecha Emisión</th>
                                    <th>Acciones</th>
                                 </tr>
                                 </thead>
                                 <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarPedidos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS DE PRODUCTOS A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
    <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION['acceso']=="secretaria" && $reg[$i]["procesada"] == 1){ ?>

    <button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Procesar a Compra" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProcesar" data-backdrop="static" data-keyboard="false" onClick="ProcesaPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo $reg[$i]["cuitproveedor"].": ".$reg[$i]["nomproveedor"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-folder-open-o"></i></button>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdatePedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetallePedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

    <?php if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS") { ?>
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 
    <?php } ?>

    <?php } ?>

    <a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
            </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PEDIDOS ############################
?>

<?php
############################# CARGAR PEDIDOS X SUCURSAL ############################
if (isset($_GET['BuscaPedidosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Pedidos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                    <thead>
                                    <tr role="row">
                                    <th>N°</th>
                                    <th>N° de Factura</th>
                                    <th>Descripción de Proveedor</th>
                                    <th>Nº Artic</th>
                                    <th>Subtotal</th>
                                    <th><?php echo $impuesto; ?></th>
                                    <th>Dcto %</th>
                                    <th>Imp. Total</th>
                                    <th>Fecha Emisión</th>
                                    <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPedidos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS A PROVEEDORES ACTUALMENTE </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
    <?php if($_SESSION['acceso']=="administradorG"){ ?><td class="text-dark alert-link"><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td><?php } ?>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target=".bs-example-modal-lg" data-backdrop="static" data-keyboard="false" onClick="VerPedido('<?php echo encrypt($reg[$i]["codpedido"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PEDIDOS X SUCURSAL ############################
?>















<?php
############################# CARGAR PRODUCTOS X SUCURSAL ############################
if (isset($_GET['BuscaProductosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);  

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else {
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Productos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            
            <div class="col-md-12">
              <div class="btn-group m-b-20">
              <div class="btn-group">
              <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
              <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKOPTIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Óptimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKMEDIO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Medio</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("STOCKMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Minimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FECHASOPTIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Óptimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FECHASMEDIO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Medio</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("FECHASMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Fechas Minimo</a>

                <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CODIGOBARRAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-barcode text-dark"></span> Código Barras</a>

              </div>
            </div>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSCSV") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> CSV</a>

              </div>
            </div>
        </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                 <thead>
                 <tr role="row">
                    <th>N°</th>
                    <th>Foto</th>
                    <th>Nombre de Producto</th>
                    <th>Stock</th>
                    <th>Fecha Venc.</th>
                    <th>Fecha Elab.</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>P. Mayor</th>
                    <th>P. Menor</th>
                    <th>P. Público</th>
                    <th><?php echo $impuesto; ?> </th>
                    <th>Dcto</th>
                    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>
                    <th>Acciones</th>
                    <?php } else { ?>
                    <th><i class="mdi mdi-drag-horizontal"></i></th>
                    <?php } ?>
                 </tr>
                 </thead>
                 <tbody class="BusquedaRapida">

<?php
$monedap = new Login();
$cambio = $monedap->MonedaProductoId();

$reg = $tra->ListarProductos(); 

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

$fecha_actual = date("Y-m-d");
$fecha_optima = $reg[$i]['fechaoptimo'];
$fecha_media = $reg[$i]['fechamedio'];
$fecha_minima = $reg[$i]['fechaminimo'];

if($fecha_optima != '0000-00-00' && $fecha_actual <= $fecha_optima){
$nombre_fecha = "OPTIMA";
$color_fecha  = "<span class='badge badge-success'>".$fecha_optima."</span>";
} else if($fecha_media != '0000-00-00' && $fecha_actual <= $fecha_media){
$nombre_fecha = "MEDIA";
$color_fecha  = "<span class='badge badge-warning'>".$fecha_media."</span>";
} else if($fecha_minima != '0000-00-00' && $fecha_actual >= $fecha_minima){
$nombre_fecha = "MINIMA";
$color_fecha  = "<span class='badge badge-danger'>".$fecha_minima."</span>";
} else if($fecha_optima == '0000-00-00' || $fecha_media == '0000-00-00' || $fecha_minima == '0000-00-00'){
$nombre_fecha = "";
$color_fecha  = "******";
} 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto']; ?></abbr></td>

    <td><abbr title="<?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "STOCK OPTIMO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "STOCK MEDIO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "STOCK MINIMO"; } else { echo ""; } ?>">
    <?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "<span class='badge badge-success'>".number_format($reg[$i]['existencia'], 0, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "<span class='badge badge-warning'>".number_format($reg[$i]['existencia'], 0, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "<span class='badge badge-danger'>".number_format($reg[$i]['existencia'], 0, '.', ',')."</span>"; } else { echo number_format($reg[$i]['existencia'], 0, '.', ','); } ?>
    </abbr></td>

    <td><abbr title="<?php echo $nombre_fecha; ?>"><?php echo $color_fecha; ?></abbr></td>
    
    <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*****" : "<span class='badge badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>

    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>
                    
    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>
                    
    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td>

    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PRODUCTOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>

    <?php } ?>

    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PRODUCTOS X SUCURSAL ############################
?>

<?php
############################# COPIAR PRODUCTOS X SUCURSAL ############################
if (isset($_GET['CopiarProductosxSucursal']) && isset($_GET['codsucursalorigen']) && isset($_GET['codsucursaldestino'])) {

if ($_SESSION['acceso'] != "administradorG") {
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN</center>";
  echo "</div>";
  exit;
}

$codsucursalorigen = limpiar(decrypt($_GET['codsucursalorigen']));
$codsucursaldestino = limpiar(decrypt($_GET['codsucursaldestino']));

if($codsucursalorigen==="" || $codsucursaldestino==="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE AMBAS SUCURSALES</center>";
  echo "</div>";
  exit;

} elseif($codsucursalorigen == $codsucursaldestino) {

  echo "<div class='alert alert-warning'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA SUCURSAL ORIGEN Y DESTINO NO PUEDEN SER LA MISMA</center>";
  echo "</div>";
  exit;

} else {

$pro = new Login();
$reg = $pro->ListarProductosSucursal($codsucursalorigen);

if($reg===""){

    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS EN LA SUCURSAL ORIGEN SELECCIONADA</center>";
    echo "</div>";

} else {

?>

<div class="table-responsive"><table id="default_order_copiar" class="table table-striped table-bordered border display">
             <thead>
             <tr role="row">
                <th>N°</th>
                <th>Código</th>
                <th>Nombre de Producto</th>
                <th>Stock Origen</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Acción</th>
             </tr>
             </thead>
             <tbody class="BusquedaRapida">

<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$yaexiste = $pro->ProductoExisteSucursal($reg[$i]['codproducto'], $codsucursaldestino);
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 0, '.', ','); ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td>
    <?php if($yaexiste) { ?>
    <span class="badge badge-success"><i class="fa fa-check"></i> YA EXISTE</span>
    <?php } else { ?>
    <button type="button" class="btn btn-info btn-rounded btn-copiar-producto" data-idproducto="<?php echo encrypt($reg[$i]['idproducto']); ?>" title="Copiar a Sucursal Destino"><i class="fa fa-copy"></i></button>
    <?php } ?>
    </td>
    </tr>
<?php } ?>
    </tbody>
    </table>
</div>

<?php
   }
  }
}
############################# COPIAR PRODUCTOS X SUCURSAL ############################
?>

<?php
############################# OBTENER PRODUCTOS PARA COPIAR ############################
if (isset($_GET['ObtenerProductosCopiar']) && isset($_GET['codsucursalorigen']) && isset($_GET['codsucursaldestino'])) {

if ($_SESSION['acceso'] != "administradorG") {
  echo json_encode(["status" => "error", "message" => "NO TIENE PERMISOS"]);
  exit;
}

header('Content-Type: application/json');

$codsucursalorigen = limpiar(decrypt($_GET['codsucursalorigen']));
$codsucursaldestino = limpiar(decrypt($_GET['codsucursaldestino']));

if($codsucursalorigen==="" || $codsucursaldestino==="" || $codsucursalorigen == $codsucursaldestino) {
  echo json_encode(["status" => "error", "message" => "SUCURSALES INVALIDAS"]);
  exit;
}

$pro = new Login();
$reg = $pro->ListarProductosSucursal($codsucursalorigen);

$ids = [];
if($reg!==""){
  for($i=0;$i<sizeof($reg);$i++){
    if(!$pro->ProductoExisteSucursal($reg[$i]['codproducto'], $codsucursaldestino)){
      $ids[] = encrypt($reg[$i]['idproducto']);
    }
  }
}

echo json_encode(["status" => "ok", "total" => sizeof($ids), "ids" => $ids]);
exit;
}
############################# OBTENER PRODUCTOS PARA COPIAR ############################
?>

<?php
############################# CARGAR PRODUCTOS ############################
if (isset($_GET['CargaProductos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                 <thead>
                 <tr role="row">
                    <th>N°</th>
                    <th>Foto</th>
                    <th>Nombre de Producto</th>
                    <th>Stock</th>
                    <th>Fecha Venc.</th>
                    <th>Fecha Elab.</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>P. Mayor</th>
                    <th>P. Menor</th>
                    <th>P. Público</th>
                    <th><?php echo $impuesto; ?> </th>
                    <th>Dcto</th>
                    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>
                    <th>Acciones</th>
                    <?php } else { ?>
                    <th><i class="mdi mdi-drag-horizontal"></i></th>
                    <?php } ?>
                 </tr>
                 </thead>
                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarProductos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$monedaxmenor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmenor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxmayor = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxmayor'] / $reg[$i]['montocambio'], 2, '.', ','));
$monedaxpublico = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioxpublico'] / $reg[$i]['montocambio'], 2, '.', ',')); 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : $reg[$i]['simbolo2']);

$fecha_actual = date("Y-m-d");
$fecha_optima = $reg[$i]['fechaoptimo'];
$fecha_media = $reg[$i]['fechamedio'];
$fecha_minima = $reg[$i]['fechaminimo'];

if($fecha_optima != '0000-00-00' && $fecha_actual <= $fecha_optima){
$nombre_fecha = "OPTIMA";
$color_fecha  = "<span class='badge badge-success'>".$fecha_optima."</span>";
} else if($fecha_media != '0000-00-00' && $fecha_actual <= $fecha_media){
$nombre_fecha = "MEDIA";
$color_fecha  = "<span class='badge badge-warning'>".$fecha_media."</span>";
} else if($fecha_minima != '0000-00-00' && $fecha_actual >= $fecha_minima){
$nombre_fecha = "MINIMA";
$color_fecha  = "<span class='badge badge-danger'>".$fecha_minima."</span>";
} else if($fecha_optima == '0000-00-00' || $fecha_media == '0000-00-00' || $fecha_minima == '0000-00-00'){
$nombre_fecha = "";
$color_fecha  = "******";
} 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codproducto']; ?>"><?php echo $reg[$i]['producto']; ?></abbr></td>

    <td><abbr title="<?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "STOCK OPTIMO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "STOCK MEDIO"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "STOCK MINIMO"; } else { echo ""; } ?>">
    <?php if($reg[$i]['existencia'] <= $reg[$i]['stockoptimo'] && $reg[$i]['existencia'] > $reg[$i]['stockmedio']){ echo "<span class='badge badge-success'>".number_format($reg[$i]['existencia'], 0, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockmedio'] && $reg[$i]['existencia'] > $reg[$i]['stockminimo']){ echo "<span class='badge badge-warning'>".number_format($reg[$i]['existencia'], 0, '.', ',')."</span>"; } elseif($reg[$i]['existencia'] <= $reg[$i]['stockminimo']){ echo "<span class='badge badge-danger'>".number_format($reg[$i]['existencia'], 0, '.', ',')."</span>"; } else { echo number_format($reg[$i]['existencia'], 0, '.', ','); } ?>
    </abbr></td>

    <td><abbr title="<?php echo $nombre_fecha; ?>"><?php echo $color_fecha; ?></abbr></td>
    
    <td><?php echo $reg[$i]['fechaelaboracion'] == '' || $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*****" : "<span class='badge badge-success'>".date("d-m-Y",strtotime($reg[$i]['fechaelaboracion']))."</span>"; ?></td>

    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxmayor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></abbr></td>
                    
    <td><abbr title="<?php echo $simbolo2.$monedaxmenor; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></abbr></td>

    <td><abbr title="<?php echo $simbolo2.$monedaxpublico; ?>"><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></abbr></td>
                    
    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td>

    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarProducto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PRODUCTOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>

    <?php } ?>

    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
<?php
} 
############################# CARGAR PRODUCTOS ############################
?>








<?php
############################# CARGAR KARDEX VALORIZADO PRODUCTOS X SUCURSAL ############################
if (isset($_GET['BuscaKardexProductosValorizadoxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);
$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Kardex Valorizado</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">

            <div class="col-md-12">
              <div class="btn-group m-b-20">
                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                             <thead>
                             <tr role="row">
                                <th>N°</th>
                                <th>Foto</th>
                                <th>Código</th>
                                <th>Nombre de Producto</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Precio Compra</th>
                                <th>Precio Público</th>
                                <th>Stock</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Desc %</th>
                                <th>Total Venta</th>
                                <th>Total Compra</th>
                                <th>Ganancias</th>
                             </tr>
                             </thead>
                             <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarKardexProductosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$ImpuestosCompraTotal=0;
$ImpuestosVentaTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioxpublico'];
$ExisteTotal+=$reg[$i]['existencia'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioxpublico']*$Descuento;
$PrecioFinal = $reg[$i]['precioxpublico']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorImpuesto = 1 + ($valor/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorImpuesto;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] == 'SI' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorImpuesto;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] == 'SI' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra; 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
        </tr>
        <?php } } ?>
        </tbody>
        </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR KARDEX VALORIZADO PRODUCTOS X SUCURSAL ############################
?>

<?php
############################# CARGAR KARDEX PRODUCTOS VALORIZADO ############################
if (isset($_GET['CargaKardexProductosValorizado'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
    <thead>
    <tr role="row">
        <th>N°</th>
        <th>Foto</th>
        <th>Código</th>
        <th>Nombre de Producto</th>
        <th>Marca</th>
        <th>Modelo</th>
        <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
        <th>Precio Compra</th>
        <?php } ?>
        <th>Precio Público</th>
        <th>Existencia</th>
        <th><?php echo $impuesto; ?></th>
        <th>Desc %</th>
        <th>Total Venta</th>
        <th>Total Compra</th>
        <th>Ganancias</th>
    </tr>
    </thead>
    <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarKardexProductosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$ImpuestosCompraTotal=0;
$ImpuestosVentaTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioxpublico'];
$ExisteTotal+=$reg[$i]['existencia'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioxpublico']*$Descuento;
$PrecioFinal = $reg[$i]['precioxpublico']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorImpuesto = 1 + ($valor/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorImpuesto;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] == 'SI' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorImpuesto;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] == 'SI' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra;
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".jpeg")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/productos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"].".png")){ ?>
    <img src="fotos/productos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codproducto"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFoto('<?php echo encrypt($reg[$i]["codproducto"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 0, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR KARDEX PRODUCTOS VALORIZADO ############################
?>












<?php
############################# CARGAR COMBOS X SUCURSAL ############################
if (isset($_GET['BuscaCombosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Productos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">

            <div class="col-md-12">
              <div class="btn-group m-b-20">
              <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                  <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                                
                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMBOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMBOSMINIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Minimo</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMBOSMAXIMO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Stock Máximo</a>

                  </div>
              </div> 

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                 <thead>
                 <tr role="row">
                    <th>N°</th>
                    <th>Foto</th>
                    <th>Nombre de Combo</th>
                    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
                    <th>Precio Compra</th>
                    <?php } ?>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th><?php echo $impuesto; ?></th>
                    <th>Dcto</th>
                    <th>Detalles de Productos</th>
                    <?php echo $perfil = ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" ? "<th>Acciones</th>" : "<th><i class='mdi mdi-drag-horizontal'></i></th>"); ?> 
                 </tr>
                 </thead>
                 <tbody class="BusquedaRapida">

<?php 
$monedap = new Login();
$cambio = $monedap->MonedaProductoId();

$reg = $tra->ListarCombos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ',')); 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codcombo']; ?>"><?php echo $reg[$i]['nomcombo']; ?></abbr></td>

    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>
    <?php if ($_SESSION['acceso']=="administradorG" || $_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria") {?>
    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-primary btn-rounded" onClick="AgregaProducto('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Agregar" ><i class="fa fa-cart-arrow-down"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("COMBOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>
    <?php } ?>
    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COMBOS X SUCURSAL ############################
?>

<?php
############################# CARGAR COMBOS ############################
if (isset($_GET['CargaCombos'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                 <thead>
                 <tr role="row">
                    <th>N°</th>
                    <th>Foto</th>
                    <th>Nombre de Combo</th>
                    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
                    <th>Precio Compra</th>
                    <?php } ?>
                    <th>Precio Venta</th>
                    <th>Stock</th>
                    <th><?php echo $impuesto; ?></th>
                    <th>Dcto</th>
                    <th>Detalles de Productos</th>
                    <?php echo $perfil = ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria" ? "<th>Acciones</th>" : "<th><i class='mdi mdi-drag-horizontal'></i></th>"); ?> 
                 </tr>
                 </thead>
                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCombos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa'] / $reg[$i]['montocambio'], 2, '.', ',')); 
?>
    <?php echo $tr = ($reg[$i]['existencia'] <= $reg[$i]['stockminimo'] ? '<tr role="row" class="odd" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">' : '<tr role="row" class="odd">'); ?>
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><abbr title="CÓDIGO: <?php echo $reg[$i]['codcombo']; ?>"><?php echo $reg[$i]['nomcombo']; ?></abbr></td>

    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>
    <?php if ($_SESSION['acceso'] == "administradorS" || $_SESSION["acceso"]=="secretaria") {?>
    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-primary btn-rounded" onClick="AgregaProducto('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')" title="Agregar" ><i class="fa fa-cart-arrow-down"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("COMBOS") ?>')" title="Eliminar"><i class="fa fa-trash-o"></i></button>
    <?php } ?>
    </td>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
<?php
} 
############################# CARGAR COMBOS ############################
?>














<?php
############################# CARGAR KARDEX VALORIZADO COMBOS X SUCURSAL ############################
if (isset($_GET['BuscaKardexCombosValorizadoxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);
$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Kardex Valorizado</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

        <div class="row">
            <div class="col-md-12">
              <div class="btn-group m-b-20">
                <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

                <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXCOMBOSVALORIZADO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
        </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                     <thead>
                     <tr role="row">
                        <th>N°</th>
                        <th>Foto</th>
                        <th>Código</th>
                        <th>Nombre de Combo</th>
                        <th>Precio Compra</th>
                        <th>Precio Venta</th>
                        <th>Stock</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Desc %</th>
                        <th>Total Venta</th>
                        <th>Total Compra</th>
                        <th>Ganancias</th>
                     </tr>
                     </thead>
                     <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarKardexCombosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$ImpuestosCompraTotal=0;
$ImpuestosVentaTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];

$Descuento = $reg[$i]['desccombo']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorImpuesto = 1 + ($valor/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorImpuesto;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
$SubtotalimpuestosC    = ($reg[$i]['ivacombo'] == 'SI' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorImpuesto;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
$SubtotalimpuestosV    = ($reg[$i]['ivacombo'] == 'SI' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra;  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></abbr></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] != '0' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table>
    </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR KARDEX VALORIZADO COMBOS X SUCURSAL ############################
?>

<?php
############################# CARGAR KARDEX DE COMBOS VALORIZADO ############################
if (isset($_GET['CargaKardexCombosValorizado'])) { 

$monedap = new Login();
$cambio = $monedap->MonedaProductoId(); 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
     <thead>
     <tr role="row">
        <th>N°</th>
        <th>Foto</th>
        <th>Código</th>
        <th>Nombre de Combo</th>
        <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
        <th>Precio Compra</th>
        <?php } ?>
        <th>Precio Venta</th>
        <th>Stock</th>
        <th><?php echo $impuesto; ?></th>
        <th>Desc %</th>
        <th>Total Venta</th>
        <th>Total Compra</th>
        <th>Ganancias</th>
     </tr>
     </thead>
     <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarKardexCombosValorizado();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$ImpuestosCompraTotal=0;
$ImpuestosVentaTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];

$Descuento = $reg[$i]['desccombo']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorImpuesto = 1 + ($valor/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorImpuesto;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['existencia'];
$SubtotalimpuestosC    = ($reg[$i]['ivacombo'] == 'SI' ? number_format($BaseDiscriminadoC, 0, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorImpuesto;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['existencia'];
$SubtotalimpuestosV    = ($reg[$i]['ivacombo'] == 'SI' ? number_format($BaseDiscriminadoV, 0, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['existencia'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['existencia'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra;
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td>
    <?php
    if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".jpeg")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.jpeg?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">
    <?php } else if (file_exists("fotos/combos/".$reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"].".png")){ ?>
    <img src="fotos/combos/<?php echo $reg[$i]["codsucursal"]."_".$reg[$i]["codcombo"]; ?>.png?" class="rounded-circle" style="margin:0px;" width="80" height="70" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalImg" data-backdrop="static" data-keyboard="false" onClick="VerFotoCombo('<?php echo encrypt($reg[$i]["codcombo"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')">   
    <?php } else {
    echo "<img src='fotos/producto.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
    } 
    ?>  
    </td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
    </tr>
    <?php } } ?>
    </tbody>
    </table></div>
<?php
} 
############################# CARGAR KARDEX DE COMBOS VALORIZADO ############################
?>















<?php
############################# CARGAR TRASPASOS X SUCURSAL ############################
if (isset($_GET['BuscaTrapasosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Traspasos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("TRASPASOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                    <thead>
                    <th>N°</th>
                        <th>N° de Factura</th>
                        <th>N° de Tracking</th>
                        <th>Sucursal Remitente</th>
                        <th>Sucursal Destinatario</th>
                        <th>Nº Artículos</th>
                        <th>Observaciones</th>
                        <th>Fecha Emisión</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTraspasos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS DE PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>: ".$reg[$i]['nomencargado']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>: ".$reg[$i]['nomencargado2']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    
    <td><?php if($reg[$i]['estado_traspaso'] == 1){
    echo "<span class='badge badge-info'><i class='fa fa-info'></i> REGISTRADO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 2){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> EN PROCESO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 3){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> PENDIENTE</span>";
    } elseif($reg[$i]['estado_traspaso'] == 4){
    echo "<span class='badge badge-success'><i class='fa fa-check'></i> RECIBIDO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 5){
    echo "<span class='badge badge-danger'><i class='fa fa-times-circle'></i> RECHAZADA</span>"; 
    } ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['sucursal_envia']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR TRASPASOS X SUCURSAL ############################
?>

<?php
############################# CARGAR TRASPASOS ############################
if (isset($_GET['CargaTraspasos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                    <thead>
                    <tr role="row">
                        <th>N°</th>
                        <th>N° de Factura</th>
                        <th>N° de Tracking</th>
                        <th>Sucursal Remitente</th>
                        <th>Sucursal Destinatario</th>
                        <th>Nº Artículos</th>
                        <th>Observaciones</th>
                        <th>Fecha Emisión</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarTraspasos();

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS DE PRODUCTOS ACTUALMENTE </center>";
  echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": <strong>".$reg[$i]['nomsucursal']."</strong>: ".$reg[$i]['nomencargado']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong>".$reg[$i]['nomsucursal2']."</strong>: ".$reg[$i]['nomencargado2']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['observaciones'] == "" ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    
    <td><?php if($reg[$i]['estado_traspaso'] == 1){
    echo "<span class='badge badge-info'><i class='fa fa-info'></i> REGISTRADO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 2){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> EN PROCESO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 3){
    echo "<span class='badge badge-info'><i class='fa fa-truck'></i> PENDIENTE</span>";
    } elseif($reg[$i]['estado_traspaso'] == 4){
    echo "<span class='badge badge-success'><i class='fa fa-check'></i> RECIBIDO</span>";
    } elseif($reg[$i]['estado_traspaso'] == 5){
    echo "<span class='badge badge-danger'><i class='fa fa-times-circle'></i> RECHAZADA</span>"; 
    } ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]['sucursal_envia'] == $_SESSION['codsucursal'] || $_SESSION['acceso']=="secretaria" && $reg[$i]['sucursal_envia'] == $_SESSION['codsucursal']){ ?>

    <?php if($reg[$i]['estado_traspaso'] != 4){ ?>
    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo encrypt("TRASPASOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>

    <?php } ?> 

    <?php } ?>

    <?php if($reg[$i]['sucursal_recibe'] == $_SESSION['codsucursal'] && $reg[$i]['estado_traspaso'] == 3){ ?>

    <button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Procesar Traspaso" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalProcesar" data-backdrop="static" data-keyboard="false" onClick="ProcesarTraspaso('<?php echo encrypt($reg[$i]["codtraspaso"]); ?>','<?php echo encrypt($reg[$i]["sucursal_envia"]); ?>','<?php echo $reg[$i]["codfactura"]; ?>','<?php echo $reg[$i]['nomsucursal']; ?>','<?php echo $reg[$i]['nomencargado']; ?>','<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?>')"><i class="fa fa-folder"></i></button>

    <?php } ?>


    <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['sucursal_envia']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR TRASPASOS ############################
?>










<?php
############################# CARGAR COMPRAS X SUCURSAL ############################
if (isset($_GET['BuscaComprasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Compras</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMPRAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                             <thead>
                               <tr role="row">
                                <th>N°</th>
                                <th>N° de Factura</th>
                                <th>Descripción de Proveedor</th>
                                <th>Nº Artic</th>
                                <th>Subtotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th>Fecha Emisión</th>
                                <th>Acciones</th>
                              </tr>
                             </thead>
                             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCompras();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCompraPagada('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COMPRAS X SUCURSAL ############################
?>

<?php
############################# CARGAR COMPRAS ############################
if (isset($_GET['CargaCompras']) && isset($_GET['bcompras'])) {

$criterio = limpiar($_GET['bcompras']); 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                     <thead>
                     <tr role="row">
                        <th>N°</th>
                        <th>N° de Factura</th>
                        <th>Descripción de Proveedor</th>
                        <th>Nº Artic</th>
                        <th>Subtotal</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Dcto %</th>
                        <th>Imp. Total</th>
                        <th>Fecha Emisión</th>
                        <th>Acciones</th>
                     </tr>
                     </thead>
                     <tbody class="BusquedaRapida">

<?php 
if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>"; 
  exit;   

} else {

$reg = $tra->BusquedaCompras();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCompraPagada('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria"){ ?>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo encrypt("P"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>','<?php echo encrypt("P"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo "P"; ?>','<?php echo encrypt("COMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

    <?php } ?>

    <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR COMPRAS ############################
?>







<?php
############################# CARGAR CUENTAS X PAGAR X SUCURSAL ############################
if (isset($_GET['BuscaCuentasxPagarxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Cuentas x Pagar</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CUENTASXPAGAR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CUENTASXPAGAR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CUENTASXPAGAR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                             <thead>
                               <tr role="row">
                                <th>N°</th>
                                <th>N° de Factura</th>
                                <th>Descripción de Proveedor</th>
                                <th>Imp. Total</th>
                                <th>Abono</th>
                                <th>Debe</th>
                                <th>Estado</th>
                                <th>Fecha Emisión</th>
                                <th>Fecha Venc.</th>
                                <th>Acciones</th>
                              </tr>
                             </thead>
                             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCuentasxPagar();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CUENTAS X PAGAR ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
    elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCompraPendiente('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-warning text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

    <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR CUENTAS X PAGAR X SUCURSAL ############################
?>

<?php
############################# CARGAR CUENTAS POR PAGAR ############################
if (isset($_GET['CargaCuentasxPagar']) && isset($_GET['bcompras'])) {

$criterio = limpiar($_GET['bcompras']);  
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                        <thead>
                        <tr role="row">
                            <th>N°</th>
                            <th>N° de Factura</th>
                            <th>Descripción de Proveedor</th>
                            <th>Imp. Total</th>
                            <th>Abono</th>
                            <th>Debe</th>
                            <th>Estado</th>
                            <th>Fecha Emisión</th>
                            <th>Fecha Venc.</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="BusquedaRapida">

<?php 

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaCuentasxPagar();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['cuitproveedor']."</strong><br> ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado']== "0000-00-00") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; }
    elseif($reg[$i]['fechavencecredito'] <= date("Y-m-d") && $reg[$i]['fechapagado']!= "0000-00-00") { echo "<span class='badge badge-pill badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCompraPendiente('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if ($_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria") { ?>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>','<?php echo "D"; ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>','<?php echo "D"; ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

    <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonosCompra" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoCompra(
    '<?php echo encrypt($reg[$i]["codcompra"]); ?>',
    '<?php echo $reg[$i]["codfactura"]; ?>',
    '<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
    '<?php echo encrypt($reg[$i]["codproveedor"]); ?>',
    '<?php echo $reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3'].": ".$reg[$i]["cuitproveedor"]; ?>',
    '<?php echo $reg[$i]["nomproveedor"]; ?>',
    '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"], 2, '.', ''); ?>',
    '<?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?>',
    '<?php echo number_format($reg[$i]["totalpago"]+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><i class="fa fa-credit-card"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCompra('<?php echo encrypt($reg[$i]["codcompra"]); ?>','<?php echo encrypt($reg[$i]["codproveedor"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("D") ?>','<?php echo encrypt("COMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> <?php } ?>

    <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-warning text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

    <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn  btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR CUENTAS POR PAGAR ############################
?>







<?php
############################# CARGAR COTIZACIONES X SUCURSAL ############################
if (isset($_GET['BuscaCotizacionesxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Cotizaciones</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COTIZACIONES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                             <thead>
                               <tr role="row">
                                <th>N°</th>
                                <th>N° de Cotización</th>
                                <th>Descripción de Cliente</th>
                                <th>Nº Artic</th>
                                <th>Subtotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th>Fecha Emisión</th>
                                <th>Acciones</th>
                              </tr>
                             </thead>
                             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCotizaciones();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR COTIZACIONES X SUCURSAL ############################
?>

<?php
############################# CARGAR COTIZACIONES ############################
if (isset($_GET['CargaCotizaciones']) && isset($_GET['bcotizaciones'])) {

$criterio = limpiar($_GET['bcotizaciones']); 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                     <thead>
                     <tr role="row">
                        <th>N°</th>
                        <th>N° de Cotización</th>
                        <th>Descripción de Cliente</th>
                        <th>Nº Artic</th>
                        <th>Subtotal</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Dcto %</th>
                        <th>Imp. Total</th>
                        <th>Fecha Emisión</th>
                        <th>Acciones</th>
                     </tr>
                     </thead>
                     <tbody class="BusquedaRapida">

<?php 

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaCotizaciones();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
    <td><?php echo $reg[$i]['articulos']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>
    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION['acceso']=="secretaria" && $reg[$i]["procesada"] == 1 || $_SESSION["acceso"]=="cajero" && $reg[$i]["procesada"] == 1){ ?>

    <button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Procesar a Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="ProcesaCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "0" : $reg[$i]['dnicliente']; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>')"><i class="fa fa-folder-open-o"></i></button>

    <?php } ?>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION['acceso']=="secretaria" && $reg[$i]["procesada"] == 1 || $_SESSION["acceso"]=="cajero" && $reg[$i]["procesada"] == 1){ ?>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

    <?php if($_SESSION['acceso'] == "administradorS" && $reg[$i]["procesada"] == 1 || $reg[0]["codigo"] == $_SESSION['codigo'] && $reg[$i]["procesada"] == 1){ ?><button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCotizacion('<?php echo encrypt($reg[$i]["codcotizacion"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("COTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button><?php } ?>

    <?php } ?>

    <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR COTIZACIONES ############################
?>







<?php
############################# CARGAR PREVENTAS X SUCURSAL ############################
if (isset($_GET['BuscaPreventasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Preventas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <div class="btn-group">
                <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-file-pdf-o"></i> Pdf</button>
                <div class="dropdown-menu dropdown-menu-left" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(164px, 35px, 0px);">
                    
                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Listado General</a>

                    <a class="dropdown-item" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CLIENTESXPREVENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Clientes x Preventas</a>
                </div>
            </div>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                             <thead>
                               <tr role="row">
                                <th>N°</th>
                                <th>N° de Factura</th>
                                <th>Descripción de Cliente</th>
                                <th>Nº Artic</th>
                                <th>Subtotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th>Fecha Emisión</th>
                                <th>Acciones</th>
                              </tr>
                             </thead>
                             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPreventas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codpreventa=<?php echo encrypt($reg[$i]['codpreventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETPREVENTA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR PREVENTAS X SUCURSAL ############################
?>


<?php
############################# CARGAR PREVENTAS ############################
if (isset($_GET['CargaPreventas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                 <thead>
                                 <tr role="row">
                                    <th>N°</th>
                                    <th>N° de Factura</th>
                                    <th>Descripción de Cliente</th>
                                    <th>Nº Artic</th>
                                    <th>Subtotal</th>
                                    <th><?php echo $impuesto; ?></th>
                                    <th>Dcto %</th>
                                    <th>Imp. Total</th>
                                    <th>Fecha Emisión</th>
                                    <th>Acciones</th>
                                 </tr>
                                 </thead>
                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarPreventas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS A CLIENTES ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1 || $_SESSION["acceso"]=="cajero" && $reg[$i]["procesada"] == 1){ ?>

    <button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Procesar a Venta" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="ProcesaPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo $reg[$i]["codcliente"]; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "0" : $reg[$i]['dnicliente']; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento']).": ".$reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?>','<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?>','<?php echo number_format($reg[$i]["limitecredito"], 2, '.', ''); ?>','<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>')"><i class="fa fa-folder-open-o"></i></button>

    <?php } ?>


    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]["procesada"] == 1){ ?>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdatePreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetallePreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarPreventa('<?php echo encrypt($reg[$i]["codpreventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("PREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> 

    <?php } ?>

    <a href="reportepdf?codpreventa=<?php echo encrypt($reg[$i]['codpreventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETPREVENTA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR PREVENTAS ############################
?>












<?php
############################# CARGAR DE CAJAS X SUCURSAL ############################
if (isset($_GET['BuscaCajasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Búsqueda de Cajas</h4>
      </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <button type="button" class="btn btn-success btn-light" data-placement="left" title="Nueva Caja" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="AgregaSucursalxCaja('<?php echo $codsucursal; ?>'); CargaUsuarios('<?php echo $codsucursal; ?>');"><i class="fa fa-plus"></i> Nuevo</button>

            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                <thead>
                <tr role="row">
                    <th>N°</th>
                    <th>Nombre de Caja</th>
                    <th>Nº Documento</th>
                    <th>Responsable</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarCajas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CAJAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="UpdateCaja('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo $reg[$i]["codigo"]; ?>','update'); CargaUsuarios('<?php echo encrypt($reg[$i]["codsucursal"]); ?>'); SelectUsuario('<?php echo $reg[$i]["codigo"]; ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>');"><i class="fa fa-edit"></i></button>
                                 
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCaja('<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo "1"; ?>','<?php echo encrypt("CAJAS"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR DE CAJAS X SUCURSAL ############################
?>

<?php
############################# CARGAR CAJAS PARA VENTAS ############################
if (isset($_GET['CargaCajas'])) { 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
             <thead>
             <tr role="row">
                <th>N°</th>
                <th>N° de Caja</th>
                <th>Nombre de Caja</th>
                <th>Nº Documento</th>
                <th>Responsable</th>
                <th>Nivel</th>
                <th>Acciones</th>
             </tr>
             </thead>
             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCajas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja']; ?></td>
    <td><?php echo $reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['nivel']; ?></td>
    <td>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalCaja" data-backdrop="static" data-keyboard="false" onClick="UpdateCaja('<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo $reg[$i]["nrocaja"]; ?>','<?php echo $reg[$i]["nomcaja"]; ?>','<?php echo $reg[$i]["codigo"]; ?>','update')"><i class="fa fa-edit"></i></button>
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarCaja('<?php echo encrypt($reg[$i]["codcaja"]); ?>','<?php echo "2"; ?>','<?php echo encrypt("CAJAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button> </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>    
<?php 
} 
############################# CARGAR CAJAS PARA VENTAS ############################
?>








<?php
############################# CARGAR ARQUEOS DE CAJAS X SUCURSAL ############################
if (isset($_GET['BuscaArqueosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Arqueos de Cajas</h4>
      </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                <thead>
                                <tr role="row">
                                <th>N°</th>
                                <th>Caja</th>
                                <th>Responsable</th>
                                <th>Hora de Apertura</th>
                                <th>Hora de Cierre</th>
                                <th>Monto Inicial</th>
                                <th>Ventas</th>
                                <th>Ingresos</th>
                                <th>Efectivo</th>
                                <th>Diferencia</th>
                                <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarArqueoCaja();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS PARA VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
    <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')"><i class="fa fa-eye"></i></button>
    
    <a href="reportepdf?codarqueo=<?php echo encrypt($reg[$i]['codarqueo']); ?>&tipo=<?php echo encrypt("TICKETCIERRE") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR ARQUEOS DE CAJAS X SUCURSAL ############################
?>

<?php
########################## CARGAR ARQUEOS DE CAJAS PARA VENTAS ##########################
if (isset($_GET['CargaArqueos'])) { 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                <thead>
                                <tr role="row">
                                <th>N°</th>
                                <th>Caja</th>
                                <th>Responsable</th>
                                <th>Hora de Apertura</th>
                                <th>Hora de Cierre</th>
                                <th>Monto Inicial</th>
                                <th>Ventas</th>
                                <th>Ingresos</th>
                                <th>Efectivo</th>
                                <th>Diferencia</th>
                                <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody class="BusquedaRapida">
<?php 
$reg = $tra->ListarArqueoCaja();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ARQUEOS DE CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaapertura'])); ?></td>
    <td><?php echo $reg[$i]['statusarqueo'] == 1 ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechacierre'])); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial']+$reg[$i]['ingresos']+$reg[$i]['abonos']-$reg[$i]['egresos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false" onClick="VerArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>')"><i class="fa fa-eye"></i></button>
    <?php if($reg[$i]["statusarqueo"]=='1'){ ?>
    <button type="button" class="btn btn-dark btn-rounded" onClick="CerrarArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>','<?php echo encrypt("save"); ?>')" title="Cerrar Arqueo" ><i class="fa fa-archive"></i></button>
    <?php } else { ?>
    <?php if ($_SESSION['acceso'] == "administradorS") { ?>
    <button type="button" class="btn btn-info btn-rounded" onClick="ActualizarArqueo('<?php echo encrypt($reg[$i]["codarqueo"]); ?>','<?php echo encrypt("update"); ?>')" title="Actualizar Arqueo" ><i class="fa fa-edit"></i></button>
    <?php } ?>
    <a href="reportepdf?codarqueo=<?php echo encrypt($reg[$i]['codarqueo']); ?>&tipo=<?php echo encrypt("TICKETCIERRE") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    <?php } ?></td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
######################### CARGAR ARQUEOS DE CAJAS PARA VENTAS #########################
?>









<?php
############################# CARGAR MOVIMIENTOS DE CAJAS X SUCURSAL ############################
if (isset($_GET['BuscaMovimientosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Movimientos de Cajas</h4>
      </div>

    <div class="form-body">
        <div class="card-body">

    <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("MOVIMIENTOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MOVIMIENTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MOVIMIENTOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
    </div>

    <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                             <thead>
                             <tr role="row">
                              <th>N°</th>
                              <th>Caja</th>
                              <th>Responsable</th>
                              <th>Tipo</th>
                              <th>Descripción</th>
                              <th>Monto</th>
                              <th>Fecha</th>
                              <th>Acciones</th>
                             </tr>
                             </thead>
                             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMovimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS EN CAJAS PARA VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td><?php echo $tipo = ( $reg[$i]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerMovimiento('<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?numero=<?php echo encrypt($reg[$i]['numero']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETMOVIMIENTO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR MOVIMIENTOS DE CAJAS X SUCURSAL ############################
?>

<?php
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS #######################
if (isset($_GET['CargaMovimientos'])) { 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">

                     <thead>
                     <tr role="row">
                      <th>N°</th>
                      <th>Caja</th>
                      <th>Responsable</th>
                      <th>Tipo</th>
                      <th>Descripción</th>
                      <th>Monto</th>
                      <th>Fecha</th>
                      <th>Acciones</th>
                     </tr>
                     </thead>
                     <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarMovimientos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON MOVIMIENTOS EN CAJAS PARA VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['nombres']; ?></td>
    <td><?php echo $tipo = ( $reg[$i]['tipomovimiento'] == "INGRESO" ? "<span class='badge badge-success'><i class='fa fa-check'></i> INGRESO</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> EGRESO</span>"); ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerMovimiento('<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if ($_SESSION["acceso"]=="administradorS" && $reg[$i]['statusarqueo']=="1") { ?>
    <button type="button" class="btn btn-info btn-rounded" data-placement="left" title="Editar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalMovimiento" data-backdrop="static" data-keyboard="false" onClick="UpdateMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt($reg[$i]["numero"]); ?>','<?php echo encrypt($reg[$i]["codarqueo"]); ?>','<?php echo $reg[$i]["tipomovimiento"]; ?>','<?php echo $reg[$i]["descripcionmovimiento"]; ?>','<?php echo number_format($reg[$i]["montomovimiento"], 2, '.', ''); ?>','<?php echo encrypt($reg[$i]["codmediopago"]); ?>','<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechamovimiento'])); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','update')"><i class="fa fa-edit"></i></button>
                                 
    <button type="button" class="btn btn-dark btn-rounded" onClick="EliminarMovimiento('<?php echo encrypt($reg[$i]["codmovimiento"]); ?>','<?php echo encrypt("MOVIMIENTOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
    <?php } ?> 

    <a href="reportepdf?numero=<?php echo encrypt($reg[$i]['numero']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETMOVIMIENTO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>

    </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
######################## CARGAR MOVIMIENTOS EN CAJAS PARA VENTAS #######################
?>









<?php
############################# CARGAR VENTAS X SUCURSAL ############################
if (isset($_GET['BuscaVentasxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Ventas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("VENTAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                                 <thead>
                                   <tr role="row">
                                    <th>N°</th>
                                    <th>N° de Venta</th>
                                    <th>Vendedor</th>
                                    <th>Descripción de Cliente</th>
                                    <th>Subtotal</th>
                                    <th><?php echo $impuesto; ?></th>
                                    <th>Dcto %</th>
                                    <th>Imp. Total</th>
                                    <th>Estado</th>
                                    <th>Fecha Emisión</th>
                                    <th>Acciones</th>
                                  </tr>
                                 </thead>
                                 <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarVentas();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><abbr title="CAJA: <?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?>"><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></abbr></td>
    <td><abbr title="<?php echo "Nº DE DNI: ".$reg[$i]['dni']; ?>"><?php echo $reg[$i]['nombres']; ?></abbr></td> 
    <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><abbr title="Nº DE ARTICULOS: <?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?>"><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></abbr></td>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
      elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
      elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
      else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR VENTAS X SUCURSAL ############################
?>

<?php
############################# CARGAR VENTAS DIARIAS ############################
if (isset($_GET['CargaVentasDiarias'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                             <thead>
                               <tr class="text-center">
                                <th>Nº</th>
                                <th>N° de Factura</th>
                                <th>Caja</th>
                                <th>Descripción de Cliente</th>
                                <th>Nº Artic</th>
                                <th>Subtotal</th>
                                <th><?php echo $impuesto; ?></th>
                                <th>Dcto %</th>
                                <th>Imp. Total</th>
                                <th>Estado</th>
                                <th><span class="mdi mdi-drag-horizontal"></span></th>
                              </tr>
                             </thead>
                             <tbody class="BusquedaRapida">

<?php 
$reg = $tra->BuscarVentasDiarias();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr class="text-center">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php if($reg[$i]['fechavencecredito']== '0000-00-00') { echo "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d")) { echo "<span class='badge badge-success'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d")) { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA</span>"; } ?></td>
    <td><button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR VENTAS DIARIAS ############################
?>

<?php
############################# CARGAR VENTAS ############################
if (isset($_GET['CargaVentas']) && isset($_GET['bventas'])) {

$criterio = limpiar($_GET['bventas']); 
?>
<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                 <thead>
                 <tr role="row">
                    <th>N°</th>
                    <th>N° de Venta</th>
                    <th>Vendedor</th>
                    <th>Descripción de Cliente</th>
                    <th>Subtotal</th>
                    <th><?php echo $impuesto; ?></th>
                    <th>Dcto %</th>
                    <th>Imp. Total</th>
                    <th>Estado</th>
                    <th>Fecha Emisión</th>
                    <th>Acciones</th>
                 </tr>
                 </thead>
                 <tbody class="BusquedaRapida">

<?php

if($criterio==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE VALOR PARA TU CRITERIO DE BÚSQUEDA </center>";
  echo "</div>";
  exit;    

} else {

$reg = $tra->BusquedaVentas();
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><abbr title="CAJA: <?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?>"><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></abbr></td>
    <td><abbr title="<?php echo "Nº DE DNI: ".$reg[$i]['dni']; ?>"><?php echo $reg[$i]['nombres']; ?></abbr></td> 
    <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td> 
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><abbr title="Nº DE ARTICULOS: <?php echo $reg[$i]['articulos']; ?>"><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></abbr></td>
 
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-pill badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-pill badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-pill badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
    else { echo "<span class='badge badge-pill badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($reg[$i]['notacredito'] != 1){ ?>

    <?php if($_SESSION['acceso'] == "administradorS" || $reg[$i]["codigo"] == $_SESSION['codigo']){ ?>

    <button type="button" class="btn btn-info btn-rounded" onClick="UpdateVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("U"); ?>')" title="Editar" ><i class="fa fa-edit"></i></button>

    <button type="button" class="btn btn-warning btn-rounded" onClick="AgregaDetalleVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("A"); ?>')" title="Agregar Detalle" ><i class="text-white fa fa-tasks"></i></button>

    <?php if($reg[$i]['statusarqueo'] == 1){ ?><button type="button" class="btn btn-dark btn-rounded" onClick="EliminarVenta('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codcliente"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>','<?php echo encrypt("VENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button><?php } ?> 

    <?php } ?>

    <?php } ?>

    <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR VENTAS ############################
?>




<?php
############################# CARGAR CREDITOS X SUCURSAL ############################
if (isset($_GET['BuscaCreditosxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Créditos</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("CREDITOS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                            <thead>
                            <tr role="row">
                                <th>N°</th>
                                <th>N° de Factura</th>
                                <th>Nº de Documento</th>
                                <th>Nombre de Cliente</th>
                                <th>Imp. Total</th>
                                <th>Abono</th>
                                <th>Debe</th>
                                <th>Estado</th>
                                <th>Dias Venc</th>
                                <th>Fecha Emisión</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CRÉDITOS DE VENTAS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>

    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
    else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCredito('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

    <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR CREDITOS X SUCURSAL ############################
?>

<?php
############################# CARGAR CREDITOS ############################
if (isset($_GET['CargaCreditos'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
            <thead>
            <tr role="row">
                <th>N°</th>
                <th>N° de Factura</th>
                <th>Nº de Documento</th>
                <th>Nombre de Cliente</th>
                <th>Imp. Total</th>
                <th>Abono</th>
                <th>Debe</th>
                <th>Estado</th>
                <th>Dias Venc</th>
                <th>Fecha Emisión</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON CREDITOS DE VENTAS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>

    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
      
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
    elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
    else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
    elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td>
    <button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerCredito('<?php echo encrypt($reg[$i]["codventa"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>

    <?php if($_SESSION['acceso']=="administradorS" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado'] || $_SESSION["acceso"]=="secretaria" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado'] || $_SESSION["acceso"]=="cajero" && $reg[$i]['totalpago'] != $reg[$i]['creditopagado']){ ?>

    <button type="button" class="btn btn-danger btn-rounded" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false" 
    onClick="AbonoCreditoVenta('<?php echo encrypt($reg[$i]["codsucursal"]); ?>',
    '<?php echo $reg[$i]["codcliente"]; ?>',
    '<?php echo encrypt($reg[$i]["codventa"]); ?>',
    '<?php echo $reg[$i]["dnicliente"].": ".$reg[$i]["nomcliente"]; ?>',
    '<?php echo $reg[$i]["codfactura"]; ?>',
    '<?php echo number_format($reg[$i]["totalpago"], 2, '.', ''); ?>',
    '<?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?>',
    '<?php echo number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ''); ?>',
    '<?php echo number_format($reg[$i]['creditopagado'], 2, '.', ''); ?>')"><i class="fa fa-credit-card"></i></button>

    <?php } ?>

    <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

    <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
        </td>
        </tr>
        <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR CREDITOS ############################
?>











<?php
############################# CARGAR NOTAS DE CREDITO X SUCURSAL ############################
if (isset($_GET['BuscaNotasCreditoxSucursal'])&& isset($_GET['codsucursal'])) {

$codsucursal = limpiar($_GET['codsucursal']);

if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else { 
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Listado de Notas de Crédito</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

      <div class="row">
        <div class="col-md-7">
            <div class="btn-group m-b-20">
            <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("NOTASCREDITO") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

            <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
          </div>
        </div>
      </div>

      <div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                        <thead>
                        <tr role="row">
                            <th>N°</th>
                            <th>N° de Factura</th>
                            <th>Nº de Documento</th>
                            <th>Descripción de Cliente</th>
                            <th>Nº Artic</th>
                            <th>SubTotal</th>
                            <th><?php echo $impuesto; ?></th>
                            <th>Dcto %</th>
                            <th>Imp. Total</th>
                            <th>Fecha Emisión</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarNotasCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON NOTAS DE CRÉDITO ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";
    exit();    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></div>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerNota('<?php echo encrypt($reg[$i]["codnota"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>
    <a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
                </tr>
                <?php } } ?>
                </tbody>
            </table></div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->
<?php
   }
} 
############################# CARGAR NOTAS DE CREDITO X SUCURSAL ############################
?>


<?php
############################# CARGAR NOTAS DE CREDITO ############################
if (isset($_GET['CargaNotas'])) { 
?>

<div class="table-responsive"><table id="default_order" class="table table-striped table-bordered border display">
                    <thead>
                    <tr role="row">
                        <th>N°</th>
                        <th>N° de Factura</th>
                        <th>Nº de Documento</th>
                        <th>Descripción de Cliente</th>
                        <th>Nº Artic</th>
                        <th>SubTotal</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Dcto %</th>
                        <th>Imp. Total</th>
                        <th>Fecha Emisión</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="BusquedaRapida">

<?php 
$reg = $tra->ListarNotasCreditos();

if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON NOTAS DE CREDITOS ACTUALMENTE </center>";
    echo "</div>";    

} else {
 
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
    <tr role="row" class="odd">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><button type="button" class="btn btn-success btn-rounded" data-placement="left" title="Ver" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalDetalle" data-backdrop="static" data-keyboard="false" onClick="VerNota('<?php echo encrypt($reg[$i]["codnota"]); ?>','<?php echo encrypt($reg[$i]["codsucursal"]); ?>')"><i class="fa fa-eye"></i></button>
    <a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
            </td>
            </tr>
            <?php } } ?>
        </tbody>
    </table></div>
<?php
} 
############################# CARGAR NOTAS DE CREDITO ############################
?>



<!-- Datatables-->
  <script src="assets/plugins/datatables/dataTables.min.js"></script>
  <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
  <script src="assets/plugins/datatables/datatable-basic.init.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#datatable').dataTable();
      $('#datatable-responsive').DataTable();
      $('#default_order').dataTable();
    } );
  </script>
        
  <!--Gallery-->
  <script type="text/javascript" src="assets/plugins/gallery/sagallery.js"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/jquery.quicksand.js" type="text/javascript"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/jquery.easing.js" type="text/javascript"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/script.js" type="text/javascript"></script>
  <script src="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/js/jquery.prettyPhoto.js" type="text/javascript"></script>
  <link href="assets/plugins/gallery/jquery-photo-gallery/jquery-photo-gallery/css/prettyPhoto.css" rel="stylesheet" type="text/css" />
  <!--Gallery-->


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