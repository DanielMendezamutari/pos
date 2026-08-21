<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
if ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero" || $_SESSION["acceso"]=="vendedor") {

$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);

$conf = new Login();
$conf = $conf->ConfiguracionPorId();

$tipo = decrypt($_GET['tipo']);
$documento = decrypt($_GET['documento']);
$extension = $documento == 'EXCEL' ? '.xls' : '.doc';

switch($tipo){

############################### MODULO DE CONFIGURACIONES ###############################
case 'PROVINCIAS': 

$archivo = str_replace(" ", "_","LISTADO DE PROVINCIAS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE PROVINCIA</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarProvincias();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $reg[$i]['id_provincia']; ?></td>
           <td><?php echo $reg[$i]['provincia']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'DEPARTAMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DEPARTAMENTOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE PROVINCIA</th>
           <th>NOMBRE DE DEPARTAMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDepartamentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['provincia']; ?></td>
           <td><?php echo $reg[$i]['departamento']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'DOCUMENTOS': 

$archivo = str_replace(" ", "_","LISTADO DE DOCUMENTOS TRIBUTARIOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE DOCUMENTO</th>
           <th>DESCRIPCIÓN DE DOCUMENTO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarDocumentos();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['documento']; ?></td>
           <td><?php echo $reg[$i]['descripcion']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOMONEDA': 

$archivo = str_replace(" ", "_","LISTADO DE TIPOS DE MONEDA");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
         <tr>
           <th>Nº</th>
           <th>NOMBRE DE MONEDA</th>
           <th>SIGLAS</th>
           <th>SIMBOLO</th>
         </tr>
      <?php 
$tra = new Login();
$reg = $tra->ListarTipoMoneda();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
         <tr class="even_row">
           <td><?php echo $a++; ?></td>
           <td><?php echo $reg[$i]['moneda']; ?></td>
           <td><?php echo $reg[$i]['siglas']; ?></td>
           <td><?php echo $reg[$i]['simbolo']; ?></td>
         </tr>
        <?php } } ?>
</table>
<?php
break;

case 'TIPOCAMBIO': 

$tra = new Login();
$reg = $tra->ListarTipoCambio();

$archivo = str_replace(" ", "_","LISTADO DE TIPO DE CAMBIO EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <th>Nº</th>
        <th>DESCRIPCIÓN DE CAMBIO</th>
        <th>MONTO DE CAMBIO</th>
        <th>TIPO DE MONEDA</th>
        <th>FECHA DE INGRESO</th>
      </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['descripcioncambio']; ?></td>
    <td><?php echo number_format($reg[$i]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['moneda'].":".$reg[$i]['siglas']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechacambio'])); ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'MEDIOSPAGOS':

$tra = new Login();
$reg = $tra->ListarMediosPagos();

$archivo = str_replace(" ", "_","LISTADO DE FORMAS DE PAGOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");  

$archivo = str_replace(" ", "_","LISTADO DE FORMAS DE PAGOS");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE MEDIO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'IMPUESTOS': 

$tra = new Login();
$reg = $tra->ListarImpuestos(); 

$archivo = str_replace(" ", "_","LISTADO DE IMPUESTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE IMPUESTO</th>
      <th>VALOR(%)</th>
      <th>ESTADO</th>
      <th>REGISTRO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nomimpuesto']; ?></td>
      <td><?php echo number_format($reg[$i]['valorimpuesto'], 2, '.', ',') ?></td>
      <td><?php echo $reg[$i]['statusimpuesto']; ?></td>
      <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaimpuesto'])); ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'BANCOS':

$tra = new Login();
$reg = $tra->ListarBancos(); 

$archivo = str_replace(" ", "_","LISTADO DE BANCOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE BANCO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nombanco']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'FAMILIAS': 

$tra = new Login();
$reg = $tra->ListarFamilias();

$archivo = str_replace(" ", "_","LISTADO DE FAMILIAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE FAMILIA</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nomfamilia']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'SUBFAMILIAS': 

$tra = new Login();
$reg = $tra->ListarSubfamilias();

$archivo = str_replace(" ", "_","LISTADO DE SUBFAMILIAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <th>Nº</th>
        <th>NOMBRE DE FAMILIA</th>
        <th>NOMBRE DE SUB-FAMILIA</th>
      </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nomfamilia']; ?></td>
      <td><?php echo $reg[$i]['nomsubfamilia']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'MARCAS': 

$tra = new Login();
$reg = $tra->ListarMarcas();

$archivo = str_replace(" ", "_","LISTADO DE MARCAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE MARCA</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nommarca']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'MODELOS': 
 
$tra = new Login();
$reg = $tra->ListarModelos();

$archivo = str_replace(" ", "_","LISTADO DE MODELOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE MARCA</th>
      <th>NOMBRE DE MODELO</th>
    </tr>
<?php
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]['nommodelo']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'PRESENTACIONES':

$tra = new Login();
$reg = $tra->ListarPresentaciones();

$archivo = str_replace(" ", "_","LISTADO DE PRESENTACIONES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE PRESENTACIONES</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nompresentacion']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'COLORES': 

$tra = new Login();
$reg = $tra->ListarColores();

$archivo = str_replace(" ", "_","LISTADO DE COLORES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE COLOR</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nomcolor']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'ORIGENES': 

$tra = new Login();
$reg = $tra->ListarOrigenes();

$archivo = str_replace(" ", "_","LISTADO DE ORIGENES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE ORIGEN</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['nomorigen']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CONFIGURACIONES ###############################








############################### MODULO DE SUCURSALES ###############################
case 'SUCURSALES': 

$archivo = str_replace(" ", "_","LISTADO DE SUCURSALES");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE DOCUMENTO</th>
    <th>RAZÓN SOCIAL</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>PROVINCIA</th>
    <th>DEPARTAMENTO</th>
    <th>DIRECCIÓN</th>
    <?php } ?>
    <th>CORREO ELECTRONICO</th>
    <th>Nº DE TELÉFONO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>Nº DE ACTIVIDAD</th>
    <th>Nº DE INICIO DE VENTA</th>
    <th>FECHA DE AUTORIZACIÓN</th>
    <th>LLEVA CONTABILIDAD</th>
    <th>DESCUENTO GLOBAL</th>
    <th>Nº DOC. ENCARGADO</th>
    <?php } ?>
    <th>NOMBRE DE ENCARGADO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>Nº DE TELÉFONO ENCARGADO</th>
    <?php } ?>
    <th>ESTADO</th>
  </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarSucursales();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal']; ?></td>
    <td><?php echo $reg[$i]['nomsucursal']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
    <td><?php echo $reg[$i]['direcsucursal']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['correosucursal']; ?></td>
    <td><?php echo $reg[$i]['tlfsucursal']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['nroactividadsucursal']; ?></td>
    <td><?php echo $reg[$i]['iniciofactura']; ?></td>
    <td><?php echo $reg[$i]['fechaautorsucursal'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaautorsucursal'])); ?></td>
    <td><?php echo $reg[$i]['llevacontabilidad']; ?></td>
    <td><?php echo number_format($reg[$i]['descsucursal'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['dniencargado']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['nomencargado']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['tlfencargado'] == '' ? "*********" : $reg[$i]['tlfencargado']; ?></td>
    <?php } ?>
    <td><?php echo $status = ( $reg[$i]['estado'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;
############################### MODULO DE SUCURSALES ###############################








############################### MODULO DE USUARIOS ###############################
case 'USUARIOS': 

$tra = new Login();
$reg = $tra->ListarUsuarios();

if ($_SESSION['acceso'] == "administradorG") {
$archivo = str_replace(" ", "_","LISTADO DE USUARIOS");
} else {
$archivo = str_replace(" ", "_","LISTADO DE USUARIOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE DOCUMENTO</th>
      <th>NOMBRES Y APELLIDOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SEXO</th>
      <th>CORREO ELECTRONICO</th>
      <?php } ?>
      <th>USUARIO</th>
      <th>NIVEL</th>
      <th>ESTADO</th>
      <?php if ($_SESSION['acceso'] == "administradorG") { ?><th>SUCURSAL</th><?php } ?>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['dni']; ?></td>
      <td><?php echo $reg[$i]['nombres']; ?></td>
      <?php if ($documento == "EXCEL") { ?>
      <td><?php echo $reg[$i]['sexo']; ?></td>
      <td><?php echo $reg[$i]['email']; ?></td>
      <?php } ?>
      <td><?php echo $reg[$i]['usuario']; ?></td>
      <td><?php echo $reg[$i]['nivel']; ?></td>
      <td><?php echo $status = ( $reg[$i]['status'] == 1 ? "ACTIVO" : "INACTIVO"); ?></td>
      <?php if ($_SESSION['acceso'] == "administradorG") { ?><td><strong><?php echo $reg[$i]['nomsucursal'] == '' ? "*********" : $reg[$i]['nomsucursal']; ?></strong></td><?php } ?>
    </tr>
    <?php } } ?>
</table>
<?php
break;

case 'LOGS': 

$archivo = str_replace(" ", "_","LISTADO LOGS DE ACCESO");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>IP EQUIPO</th>
      <th>TIEMPO DE ENTRADA</th>
      <th>NAVEGADOR DE ACCESO</th>
      <th>PÁGINAS DE ACCESO</th>
      <th>USUARIOS</th>
    </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarLogs();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['ip']; ?></td>
      <td><?php echo $reg[$i]['tiempo']; ?></td>
      <td><?php echo $reg[$i]['detalles']; ?></td>
      <td><?php echo $reg[$i]['paginas']; ?></td>
      <td><?php echo $reg[$i]['usuario']; ?></td>
    </tr>
    <?php } } ?>
</table>
<?php
break;
############################### MODULO DE USUARIOS ###############################














############################### MODULO DE CLIENTES ###############################
case 'CLIENTES': 

$tra = new Login();
$reg = $tra->ListarClientes();

$archivo = str_replace(" ", "_","LISTADO DE CLIENTES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO CLIENTE</th>
      <th>TIPO DE DOCUMENTO</th>
      <th>Nº DE DOCUMENTO</th>
      <th>NOMBRES Y APELLIDOS</th>
      <th>Nº DE TELÉFONO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>PROVINCIA</th>
      <th>DEPARTAMENTO</th>
      <th>DIRECCIÓN DOMICILIARIA</th>
      <th>CORREO ELECTRONICO</th>
      <?php } ?>
      <th>LIMITE DE CRÉDITO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['tipocliente']; ?></td>
    <td><?php echo $reg[$i]['documcliente'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
    <td><?php echo $reg[$i]['dnicliente']; ?></td>
    <td><?php echo $cliente = ($reg[$i]['tipocliente'] == 'NATURAL' ? $reg[$i]['nomcliente'] : $reg[$i]['razoncliente']); ?></td>
    <td><?php echo $reg[$i]['tlfcliente'] == '' ? "*********" : $reg[$i]['tlfcliente']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
    <td><?php echo $reg[$i]['direccliente']; ?></td>
    <td><?php echo $reg[$i]['emailcliente'] == '' ? "*********" : $reg[$i]['emailcliente']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['limitecredito'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;
############################### MODULO DE CLIENTES ###################################










################################ MODULO DE PROVEEDORES #################################
case 'PROVEEDORES': 

$tra = new Login();
$reg = $tra->ListarProveedores();

$archivo = str_replace(" ", "_","LISTADO DE PROVEEDORES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO DE DOCUMENTO</th>
      <th>Nº DE DOCUMENTO</th>
      <th>NOMBRE DE PROVEEDOR</th>
      <th>Nº DE TELÉFONO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>PROVINCIA</th>
      <th>DEPARTAMENTO</th>
      <th>DIRECCIÓN DOMICILIARIA</th>
      <th>CORREO ELECTRONICO</th>
      <?php } ?>
      <th>VENDEDOR</th>
      <th>Nº DE TELÉFONO</th>
    </tr>
<?php 
$tra = new Login();
$reg = $tra->ListarProveedores();

if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['documproveedor'] == '0' ? "*********" : $reg[$i]['documento']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['tlfproveedor'] == '' ? "*********" : $reg[$i]['tlfproveedor']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['id_provincia'] == '0' ? "*********" : $reg[$i]['provincia']; ?></td>
    <td><?php echo $reg[$i]['id_departamento'] == '0' ? "*********" : $reg[$i]['departamento']; ?></td>
    <td><?php echo $reg[$i]['direcproveedor']; ?></td>
    <td><?php echo $reg[$i]['emailproveedor'] == '' ? "*********" : $reg[$i]['emailproveedor']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['vendedor']; ?></td>
    <td><?php echo $reg[$i]['tlfvendedor']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'PEDIDOS':

$tra = new Login();
$reg = $tra->ListarPedidos(); 

$archivo = str_replace(" ", "_","LISTADO DE PEDIDOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>   
      <th>OBSERVACIONES</th>       
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
  <td><?php echo $a++; ?></td>
  <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
  <td><?php echo $observaciones = ($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <?php } ?>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
  <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
  <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
  <?php } ?>
  <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PEDIDOSXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarPedidosxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE PEDIDOS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>
      <th>OBSERVACIONES</th>          
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
  <td><?php echo $a++; ?></td>
  <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
  <td><?php echo $observaciones = ($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <?php } ?>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
  <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PEDIDOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarPedidosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>         
      <th>OBSERVACIONES</th> 
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
  <td><?php echo $a++; ?></td>
  <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
  <td><?php echo $observaciones = ($reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <?php if ($documento == "EXCEL") { ?>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <?php } ?>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;
############################### MODULO DE PROVEEDORES ###############################














############################### MODULO DE PRODUCTOS ###############################
case 'PRODUCTOS':

$tra = new Login();
$reg = $tra->ListarProductos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>NOMBRE DE PRODUCTO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>DESCRIPCIÓN DE PRODUCTO</th>
      <th>Nº DE IMEI</th>
      <th>CONDICIÓN DE PRODUCTO</th>
      <th>FABRICANTE</th>
      <th>FAMILIA</th>
      <th>SUBFAMILIA</th>
      <?php } ?>
      <th>MARCA</th>
      <th>MODELO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>PRESENTACIÓN</th>
      <th>COLOR</th>
      <th>ORIGEN</th>
      <th>AÑO</th>
      <th>Nº DE PARTE</th>
      <th>LOTE</th>
      <th>PESO</th>
      <th>STOCK ÓPTIMO</th>
      <th>STOCK MEDIO</th>
      <th>STOCK MINIMO</th>
      <?php } ?>
      <th><?php echo $impuesto; ?></th>
      <th>DESC</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>CÓDIGO DE BARRA</th>
      <th>FECHA DE ELABORACIÓN</th>
      <th>FECHA DE EXP. ÓPTIMO</th>
      <th>FECHA DE EXP. MEDIO</th>
      <th>FECHA DE EXP. MINIMO</th>
      <th>PROVEEDOR</th>
      <?php } ?>
      <th>EXISTENCIA</th>
      <th>PRECIO COMPRA</th>
      <th>PRECIO MAYOR</th>
      <th>PRECIO MENOR</th>
      <th>PRECIO PÚBLICO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalMenor=0;
$TotalMayor=0;
$TotalPublico=0;
$TotalMonedaMenor=0;
$TotalMonedaMayor=0;
$TotalMonedaPublico=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");
$TotalCompra+=$reg[$i]['preciocompra'];
$TotalMenor+=$reg[$i]['precioxmenor'];
$TotalMayor+=$reg[$i]['precioxmayor'];
$TotalPublico+=$reg[$i]['precioxpublico'];

$TotalMonedaMayor+= (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmayor']/$reg[$i]['montocambio']);
$TotalMonedaMenor+= (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxmenor']/$reg[$i]['montocambio']);
$TotalMonedaPublico+= (empty($reg[$i]['montocambio']) ? "0.00" : $reg[$i]['precioxpublico']/$reg[$i]['montocambio']);

$TotalArticulos+=$reg[$i]['existencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['descripcion'] == '' ? "*********" : $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei'] == '' ? "*********" : $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion'] == '' ? "*********" : $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante'] == '' ? "*********" : $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "*********" : $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "*********" : $reg[$i]['nomsubfamilia']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*********" : $reg[$i]['nommodelo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "*********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "*********" : $reg[$i]['nomcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "*********" : $reg[$i]['nomorigen']; ?></td>
    <td><?php echo $reg[$i]['year'] == '' ? "*********" : $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte'] == '' ? "*********" : $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "*********" : $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso'] == '' ? "*********" : $reg[$i]['peso']; ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "*********" : $reg[$i]['stockoptimo']; ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "*********" : $reg[$i]['stockmedio']; ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "*********" : $reg[$i]['stockminimo']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codigobarra'] == '' ? "*********" : $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmayor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxmenor'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioxpublico'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="29"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMayor, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaMayor, 2, '.', ','); ?>)</strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalMenor, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaMenor, 2, '.', ','); ?>)</strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalPublico, 2, '.', ','); ?> (<?php echo $simbolo2.number_format($TotalMonedaPublico, 2, '.', ','); ?>)</strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSCSV':

$tra = new Login();
$reg = $tra->ListarProductos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <?php 

if($reg==""){
echo "";      
} else {
  
$a=1;
for($i=0;$i<sizeof($reg);$i++){ 
?>
  <tr class="even_row">
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "0" : $reg[$i]['codfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "0" : $reg[$i]['codsubfamilia']; ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "0" : $reg[$i]['codmarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "0" : $reg[$i]['codmodelo']; ?></td>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "0" : $reg[$i]['codpresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "0" : $reg[$i]['codcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "0" : $reg[$i]['codorigen']; ?></td>
    <td><?php echo $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso']; ?></td>
    <td><?php echo number_format($reg[$i]['preciocompra'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['precioxmenor'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['precioxmayor'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['precioxpublico'], 2, '.', ''); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "0" : $reg[$i]['stockoptimo']; ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "0" : $reg[$i]['stockmedio']; ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "0" : $reg[$i]['stockminimo']; ?></td>
    <td><?php echo $reg[$i]['ivaproducto']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "0000-00-00" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
    <td><?php echo $reg[$i]['codproveedor']; ?></td>
    <td><?php echo $reg[$i]['stockteorico']; ?></td>
    <td><?php echo $reg[$i]['motivoajuste']; ?></td>
    <td><?php echo $reg[$i]['codsucursal']; ?></td>
  </tr>
  <?php }  } ?>
</table>
<?php
break;

case 'PRODUCTOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : $cambio[0]['simbolo']);

$tra = new Login();
$reg = $tra->ListarProductos(); 

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y MONEDA ".$cambio[0]['moneda'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>NOMBRE DE PRODUCTO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>Nº DE IMEI</th>
    <th>CONDICIÓN DE PRODUCTO</th>
    <th>FABRICANTE</th>
    <th>FAMILIA</th>
    <th>SUBFAMILIA</th>
    <?php } ?>
    <th>MARCA</th>
    <th>MODELO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>PRESENTACIÓN</th>
    <th>COLOR</th>
    <th>ORIGEN</th>
    <th>AÑO</th>
    <th>Nº DE PARTE</th>
    <th>LOTE</th>
    <th>PESO</th>
    <th>STOCK ÓPTIMO</th>
    <th>STOCK MEDIO</th>
    <th>STOCK MINIMO</th>
    <?php } ?>
    <th><?php echo $impuesto; ?></th>
    <th>DESC</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>CÓDIGO DE BARRA</th>
    <th>FECHA DE ELABORACIÓN</th>
    <th>FECHA DE EXP. ÓPTIMO</th>
    <th>FECHA DE EXP. MEDIO</th>
    <th>FECHA DE EXP. MINIMO</th>
    <th>PROVEEDOR</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO MAYOR</th>
    <th>PRECIO MENOR</th>
    <th>PRECIO PÚBLICO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalMenor=0;
$TotalMayor=0;
$TotalPublico=0;
$TotalMonedaCompra=0;
$TotalMonedaMenor=0;
$TotalMonedaMayor=0;
$TotalMonedaPublico=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$TotalCompra+=number_format($reg[$i]['preciocompra'], 2, '.', '');
$TotalMayor+=number_format($reg[$i]['precioxmayor'], 2, '.', '');
$TotalMenor+=number_format($reg[$i]['precioxmenor'], 2, '.', '');
$TotalPublico+=number_format($reg[$i]['precioxpublico'], 2, '.', '');

$TotalMonedaCompra+=number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaMayor+=number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaMenor+=number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaPublico+=number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', '');

$TotalArticulos+=$reg[$i]['existencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['descripcion'] == '' ? "*********" : $reg[$i]['descripcion']; ?></td>
    <td><?php echo $reg[$i]['imei'] == '' ? "*********" : $reg[$i]['imei']; ?></td>
    <td><?php echo $reg[$i]['condicion'] == '' ? "*********" : $reg[$i]['condicion']; ?></td>
    <td><?php echo $reg[$i]['fabricante'] == '' ? "*********" : $reg[$i]['fabricante']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "*********" : $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['codsubfamilia'] == '0' ? "*********" : $reg[$i]['nomsubfamilia']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*********" : $reg[$i]['nommodelo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codpresentacion'] == '0' ? "*********" : $reg[$i]['nompresentacion']; ?></td>
    <td><?php echo $reg[$i]['codcolor'] == '0' ? "*********" : $reg[$i]['nomcolor']; ?></td>
    <td><?php echo $reg[$i]['codorigen'] == '0' ? "*********" : $reg[$i]['nomorigen']; ?></td>
    <td><?php echo $reg[$i]['year'] == '' ? "*********" : $reg[$i]['year']; ?></td>
    <td><?php echo $reg[$i]['nroparte'] == '' ? "*********" : $reg[$i]['nroparte']; ?></td>
    <td><?php echo $reg[$i]['lote'] == '' || $reg[$i]['lote'] == '0' ? "*********" : $reg[$i]['lote']; ?></td>
    <td><?php echo $reg[$i]['peso'] == '' ? "*********" : $reg[$i]['peso']; ?></td>
    <td><?php echo $reg[$i]['stockoptimo'] == '0' ? "*********" : $reg[$i]['stockoptimo']; ?></td>
    <td><?php echo $reg[$i]['stockmedio'] == '0' ? "*********" : $reg[$i]['stockmedio']; ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0' ? "*********" : $reg[$i]['stockminimo']; ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codigobarra'] == '' ? "*********" : $reg[$i]['codigobarra']; ?></td>
    <td><?php echo $reg[$i]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaelaboracion'])); ?></td>
    <td><?php echo $reg[$i]['fechaoptimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaoptimo'])); ?></td>
    <td><?php echo $reg[$i]['fechamedio'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechamedio'])); ?></td>
    <td><?php echo $reg[$i]['fechaminimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechaminimo'])); ?></td>
           <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="29"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaMayor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaMenor, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaPublico, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'KARDEXPRODUCTO':

$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();

$detalle = new Login();
$detalle = $detalle->DetalleProductosKardex();
 

$archivo = str_replace(" ", "_","KARDEX DEL PRODUCTO (".portales($detalle[0]['producto'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");
header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>REALIZADO POR</th>
    <th>MOVIMIENTO</th>
    <th>ENTRADAS</th>
    <th>SALIDAS</th>
    <th>DEVOLUCIÓN</th>
    <th>EXISTENCIA</th>
    <?php if ($documento == "EXCEL") { ?>
    <th><?php echo $impuesto; ?></th>
    <th>DESCUENTO</th>
    <th>PRECIO</th>
    <?php } ?>
    <th>DOCUMENTO</th>
    <th>FECHA KARDEX</th>
  </tr>
<?php 
if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){ 
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>");
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
    <td><?php echo $kardex[$i]['movimiento']; ?></td>
    <td><?php echo $kardex[$i]['entradas']; ?></td>
    <td><?php echo $kardex[$i]['salidas']; ?></td>
    <td><?php echo $kardex[$i]['devolucion']; ?></td>
    <td><?php echo $kardex[$i]['stockactual']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $kardex[$i]['ivaproducto'] != '0.00' ? number_format($kardex[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $kardex[$i]['documento']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
  </tr>
  <?php } } ?>
</table>
<strong>DETALLE DE PRODUCTO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $kardex[0]['codproducto']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['producto']; ?><br>
<strong>PRESENTACIÓN:</strong> <?php echo $detalle[0]['nompresentacion']; ?><br>
<strong>MARCA:</strong> <?php echo $detalle[0]['nommarca']; ?><br>
<strong>MODELO:</strong> <?php echo $detalle[0]['nommodelo'] == '' ? "*****" : $detalle[0]['nommodelo']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo $TotalEntradas; ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo $TotalSalidas; ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo $TotalDevolucion; ?><br>
<strong>EXISTENCIA:</strong> <?php echo $detalle[0]['existencia']; ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $simbolo." ".number_format($detalle[0]['preciocompra'], 2, '.', ','); ?><br>
<strong>P. VENTA MENOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmenor'], 2, '.', ','); ?><br>
<strong>P. VENTA MAYOR:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxmayor'], 2, '.', ','); ?><br>
<strong>P. VENTA PUBLICO:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioxpublico'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXPRODUCTOSVALORIZADO':

$tra = new Login();
$reg = $tra->ListarKardexProductosValorizado(); 

$archivo = str_replace(" ", "_","KARDEX PRODUCTOS VALORIZADO DE SUCURSAL: (".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <th>PRECIO COMPRA</th>
    <?php } ?>
    <th>PRECIO PÚBLICO</th>
    <th>DESC.</th>
    <th><?php echo $impuesto; ?></th>
    <th>EXISTENCIA</th>
    <th>TOTAL VENTA</th>
    <th><?php echo $impuesto; ?> VENTA</th>
    <th>TOTAL COMPRA</th>
    <th><?php echo $impuesto; ?> COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
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

$a=1;
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
   <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]["preciocompra"], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]["precioxpublico"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosV, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosC, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td></td><?php } ?>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($ImpuestosVentaTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($ImpuestosCompraTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'PRODUCTOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarProductosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","PRODUCTOS VALORIZADO DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>DESCRIPCIÓN DE PRODUCTO</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
      <th>PRECIO COMPRA</th>
      <?php } ?>
      <th>PRECIO VENTA</th>
      <th>EXISTENCIA</th>
      <th>VENDIDO</th>
      <th>TOTAL VENTA</th>
      <th><?php echo $impuesto; ?> VENTA</th>
      <th>TOTAL COMPRA</th>
      <th><?php echo $impuesto; ?> COMPRA</th>
      <th>GANANCIAS</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$ImpuestosCompraTotal=0;
$ImpuestosVentaTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorImpuesto = 1 + ($valor/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorImpuesto;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['cantidad'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorImpuesto;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['cantidad'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['cantidad'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['cantidad'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra;
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]["preciocompra"], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosV, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosC, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td></td><?php } ?>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($ImpuestosVentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($ImpuestosCompraTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'PRODUCTOSVENDIDOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarProductosVendidosxFechas(); 

$archivo = str_replace(" ", "_","PRODUCTOS VENDIDOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");


header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>DESCRIPCIÓN DE PRODUCTO</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>PRECIO VENTA</th>
      <th>EXISTENCIA</th>
      <th>VENDIDO</th>
      <th><?php echo $impuesto; ?></th>
      <th>DESC %</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$TotalDescuento=0;
$TotalImpuesto=0;
$TotalGeneral=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad'];

$Descuento        = $reg[$i]['descproducto']/100;
$PrecioDescuento  = $reg[$i]['precioventa']*$Descuento;
//$CalculoDescuento = $PrecioDescuento*$reg[$i]['cantidad'];
$CalculoDescuento = $reg[$i]['totaldescuentov'];
$PrecioFinal      = $reg[$i]['precioventa']-$PrecioDescuento;

$ivg              = $reg[$i]['ivaproducto']/100;
$CalculoImpuesto  = number_format($reg[$i]['subtotalimpuestos'], 2, '.', '');

$TotalDescuento += $reg[$i]['totaldescuentov']; 
$TotalImpuesto  += $CalculoImpuesto; 
$TotalGeneral   += $PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($CalculoImpuesto, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($CalculoDescuento, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr align="center">
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
############################### MODULO DE PRODUCTOS ###############################























################################ MODULO DE COMBOS ################################
case 'COMBOS':

$tra = new Login();
$reg = $tra->ListarCombos();

$archivo = str_replace(" ", "_","LISTADO DE PRODUCTOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE COMBO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>FAMILIA</th>
    <th>STOCK MINIMO</th>
    <th>STOCK MÁXIMO</th>
    <?php } ?>
    <th><?php echo $impuesto; ?></th>
    <th>DESC %</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>DETALLES DE PRODUCTOS</th>
    <?php } ?>
    <th>EXISTENCIA</th>
    <th>PRECIO COMPRA</th>
    <th>PRECIO VENTA</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalCompra=0;
$TotalVenta=0;
$TotalMoneda=0;
$TotalArticulos=0;
for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");

$moneda = (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa']/$reg[$i]['montocambio'], 2, '.', ',')); 

$TotalCompra+=$reg[$i]['preciocompra'];
$TotalVenta+=$reg[$i]['precioventa'];
$TotalMoneda += (empty($reg[$i]['montocambio']) ? "0.00" : number_format($reg[$i]['precioventa']/$reg[$i]['montocambio'], 2, '.', ','));
$TotalArticulos+=$reg[$i]['existencia'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "*********" : $reg[$i]['nomfamilia']; ?></td>
    <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>     
    <?php } ?>
    <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['precioventa'], 2, '.', ','); ?></td> 
  </tr>
  <?php } ?>
  <tr align="center">
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCompra, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalVenta, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COMBOSXMONEDA':

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : $cambio[0]['simbolo']);

$tra = new Login();
$reg = $tra->ListarCombos(); 

$archivo = str_replace(" ", "_","LISTADO DE COMBOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y MONEDA ".$cambio[0]['moneda'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>DESCRIPCIÓN DE COMBO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>FAMILIA</th>
      <th>STOCK MINIMO</th>
      <th>STOCK MÁXIMO</th>
      <?php } ?>
      <th><?php echo $impuesto; ?></th>
      <th>DESC %</th>
      <th>DETALLES DE PRODUCTOS</th>
      <th>EXISTENCIA</th>
      <th>PRECIO COMPRA</th>
      <th>PRECIO VENTA</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalMonedaCompra=0;
$TotalMonedaVenta=0;
$TotalArticulos=0;

for($i=0;$i<sizeof($reg);$i++){

$TotalArticulos+=$reg[$i]['existencia'];
$TotalMonedaCompra+=number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');

$Descuento = $reg[$i]['desccombo']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$TotalMonedaVenta+=number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ''); 
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <td><?php echo $reg[$i]['codfamilia'] == '0' ? "*********" : $reg[$i]['nomfamilia']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['stockminimo'] == '0.00' ? "*********" : number_format($reg[$i]['stockminimo'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['stockmaximo'] == '0.00' ? "*********" : number_format($reg[$i]['stockmaximo'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?></td>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>

    <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
    <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioventa']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $tipo_simbolo.number_format($TotalMonedaVenta, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'KARDEXCOMBO':

$kardex = new Login();
$kardex = $kardex->BuscarKardexCombo(); 

$detalle = new Login();
$detalle = $detalle->DetalleKardexCombo(); 

$archivo = str_replace(" ", "_","KARDEX DEL COMBO (".portales($detalle[0]['nomcombo'])." Y SUCURSAL: ".$detalle[0]['cuitsucursal'].": ".$detalle[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>REALIZADO POR</th>
      <th>MOVIMIENTO</th>
      <th>ENTRADAS</th>
      <th>SALIDAS</th>
      <th>DEVOLUCIÓN</th>
      <th>EXISTENCIA</th>
      <?php if ($documento == "EXCEL") { ?>
      <th><?php echo $impuesto; ?></th>
      <th>DESC %</th>
      <th>PRECIO</th>
      <?php } ?>
      <th>DOCUMENTO</th>
      <th>FECHA KARDEX</th>
    </tr>
<?php 
if($kardex==""){
echo "";      
} else {

$TotalEntradas=0;
$TotalSalidas=0;
$TotalDevolucion=0;
$a=1;
for($i=0;$i<sizeof($kardex);$i++){
$simbolo = ($detalle[0]['simbolo'] == "" ? "" : "<strong>".$detalle[0]['simbolo']."</strong>"); 
$TotalEntradas+=$kardex[$i]['entradas'];
$TotalSalidas+=$kardex[$i]['salidas'];
$TotalDevolucion+=$kardex[$i]['devolucion'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
    <td><?php echo $kardex[$i]['movimiento']; ?></td>
    <td><?php echo number_format($kardex[$i]['entradas'], 2, ',', '.'); ?></td>
    <td><?php echo number_format($kardex[$i]['salidas'], 2, ',', '.'); ?></td>
    <td><?php echo number_format($kardex[$i]['devolucion'], 2, ',', '.'); ?></td>
    <td><?php echo number_format($kardex[$i]['stockactual'], 2, ',', '.'); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $kardex[$i]['ivaproducto']; ?></td>
    <td><?php echo number_format($kardex[$i]['descproducto'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($kardex[$i]["precio"], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
    <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
  </tr>
  <?php } } ?>
</table>
<strong>DETALLE DE COMBO</strong><br>
<strong>CÓDIGO:</strong> <?php echo $detalle[0]['codcombo']; ?><br>
<strong>DESCRIPCIÓN:</strong> <?php echo $detalle[0]['nomcombo']; ?><br>
<strong>TOTAL ENTRADAS:</strong> <?php echo number_format($TotalEntradas, 2, ',', '.'); ?><br>
<strong>TOTAL SALIDAS:</strong> <?php echo number_format($TotalSalidas, 2, ',', '.'); ?><br>
<strong>TOTAL DEVOLUCIÓN:</strong> <?php echo number_format($TotalDevolucion, 2, ',', '.'); ?><br>
<strong>EXISTENCIA:</strong> <?php echo number_format($detalle[0]['existencia'], 2, ',', '.'); ?><br>
<strong>PRECIO COMPRA:</strong> <?php echo $simbolo." ".number_format($detalle[0]['preciocompra'], 2, '.', ','); ?><br>
<strong>PPRECIO VENTA:</strong> <?php echo $simbolo." ".number_format($detalle[0]['precioventa'], 2, '.', ','); ?>
<?php
break;

case 'KARDEXCOMBOSVALORIZADO':

$tra = new Login();
$reg = $tra->ListarKardexCombosValorizado(); 

$archivo = str_replace(" ", "_","KARDEX DE COMBOS VALORIZADO DE SUCURSAL: (".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE COMBO</th>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <th>PRECIO COMPRA</th>
    <?php } ?>
    <th>PRECIO VENTA</th>
    <th><?php echo $impuesto; ?></th>
    <th>DESC %</th>
    <th>EXISTENCIA</th>
    <th>TOTAL VENTA</th>
    <th><?php echo $impuesto; ?> VENTA</th>
    <th>TOTAL COMPRA</th>
    <th><?php echo $impuesto; ?> COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
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

$a=1;
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
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codcombo']; ?></td>
    <td><?php echo $reg[$i]['nomcombo']; ?></td>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]["preciocompra"], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo number_format($reg[$i]['desccombo'], 2, '.', ','); ?>%</td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosV, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosC, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td></td><?php } ?>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($ImpuestosVentaTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($ImpuestosCompraTotal, 2, '.', ','); ?></strong></td>
  <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COMBOSVALORIZADOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCombosValorizadoxFechas(); 

$archivo = str_replace(" ", "_","COMBOS VALORIZADO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>DESCRIPCIÓN DE COMBO</th>
      <th>DESC %</th>
      <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
      <th>PRECIO COMPRA</th>
      <?php } ?>
      <th>PRECIO VENTA</th>
      <th>EXISTENCIA</th>
      <th>VENDIDO</th>
      <th>TOTAL VENTA</th>
      <th><?php echo $impuesto; ?> VENTA</th>
      <th>TOTAL COMPRA</th>
      <th><?php echo $impuesto; ?> COMPRA</th>
      <th>GANANCIAS</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$ImpuestosCompraTotal=0;
$ImpuestosVentaTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : $reg[$i]['simbolo']);

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad'];

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

//VALOR DE IMPUESTO
$ValorImpuesto = 1 + ($valor/100);

//CALCULO SUBTOTAL IMPUESTOS PRECIO COMPRA
$DiscriminadoC         = $reg[$i]['preciocompra']/$ValorImpuesto;
$SubtotalDiscriminadoC = $reg[$i]['preciocompra'] - $DiscriminadoC;
$BaseDiscriminadoC     = $SubtotalDiscriminadoC * $reg[$i]['cantidad'];
$SubtotalimpuestosC    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoC, 2, '.', '') : "0.00");

//CALCULO SUBTOTAL IMPUESTOS PRECIO VENTA
$DiscriminadoV         = $PrecioFinal/$ValorImpuesto;
$SubtotalDiscriminadoV = $PrecioFinal - $DiscriminadoV;
$BaseDiscriminadoV     = $SubtotalDiscriminadoV * $reg[$i]['cantidad'];
$SubtotalimpuestosV    = ($reg[$i]['ivaproducto'] != '0.00' ? number_format($BaseDiscriminadoV, 2, '.', '') : "0.00");

$SumCompra = ($reg[$i]['preciocompra']*$reg[$i]['cantidad'])-$SubtotalimpuestosC;
$SumVenta  = ($PrecioFinal*$reg[$i]['cantidad'])-$SubtotalimpuestosV; 

$CompraTotal          += $SumCompra;
$ImpuestosCompraTotal += $SubtotalimpuestosC;
$VentaTotal           += $SumVenta;
$ImpuestosVentaTotal  += $SubtotalimpuestosV;
$TotalGanancia        += $SumVenta-$SumCompra;
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]["preciocompra"], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosV, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SubtotalimpuestosC, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
    </tr>
    <?php } } ?>
    <tr>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td></td><?php } ?>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($ImpuestosVentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($ImpuestosCompraTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'COMBOSVENDIDOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCombosVendidosxFechas(); 

$archivo = str_replace(" ", "_","COMBOS VENDIDOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");


header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>DESCRIPCIÓN DE COMBO</th>
      <th>PRECIO VENTA</th>
      <th>EXISTENCIA</th>
      <th>VENDIDO</th>
      <th><?php echo $impuesto; ?></th>
      <th>DESC %</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$a=1;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$TotalDescuento=0;
$TotalImpuesto=0;
$TotalGeneral=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad'];

$Descuento        = $reg[$i]['descproducto']/100;
$PrecioDescuento  = $reg[$i]['precioventa']*$Descuento;
//$CalculoDescuento = $PrecioDescuento*$reg[$i]['cantidad'];
$CalculoDescuento = $reg[$i]['totaldescuentov'];
$PrecioFinal      = $reg[$i]['precioventa']-$PrecioDescuento;

$ivg              = $reg[$i]['ivaproducto']/100;
$CalculoImpuesto  = number_format($reg[$i]['subtotalimpuestos'], 2, '.', '');

$TotalDescuento += $reg[$i]['totaldescuentov']; 
$TotalImpuesto  += $CalculoImpuesto; 
$TotalGeneral   += $PrecioFinal*$reg[$i]['cantidad'];
?>
    <tr align="center" class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo $reg[$i]['codproducto']; ?></td>
      <td><?php echo $reg[$i]['producto']; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
      <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
      <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($CalculoImpuesto, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($CalculoDescuento, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
    </tr>
    <?php } } ?>
    <tr align="center">
      <td></td>
      <td></td>
      <td></td>
      <td><strong><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo number_format($ExisteTotal, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></strong></td>
    </tr>
</table>
<?php
break;
################################# MODULO DE COMBOS ##################################

























################################# MODULO DE TRASPASOS #################################
case 'TRASPASOS':

$tra = new Login();
$reg = $tra->ListarTraspasos(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>Nº DE TRACKING</th>
      <th>SUCURSAL REMITENTE</th>
      <th>SUCURSAL DESTINATARIO</th>
      <th>RESPONSABLE DE TRASLADO</th>
      <th>FECHA DE EMISIÓN</th>
      <th>ESTADO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>OBERVACIONES DE ENVIO</th>
      <th>PERSONA QUE RECIBE</th>
      <th>FECHA RECIBE</th>
      <th>OBERVACIONES DE RECIBIDO</th>
      <th>DETALLES DE ARTICULOS</th>
      <?php } ?>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th>TOTAL <?php echo $impuesto; ?></th>
      <th>TOTAL DESC</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": ".$reg[$i]['nomsucursal2']; ?></td>
    <td><?php echo $reg[$i]['nombres_responsable'] == "" ? "*********" : $reg[$i]['nombres_responsable']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <td><?php if($reg[$i]['estado_traspaso']==1) { 
    echo '<a style="color:#1b78a0;font-weight:bold;">REGISTRADO</a>'; 
    } elseif($reg[$i]['estado_traspaso']==2) {  
    echo '<a style="color:#1b78a0;font-weight:bold;">EN PROCESO</a>'; 
    } elseif($reg[$i]['estado_traspaso']==3) {  
    echo '<a style="color:#1b78a0;font-weight:bold;">PENDIENTE</a>'; 
    } elseif($reg[$i]['estado_traspaso']==4) {  
    echo '<a style="color:#8dbf42;font-weight:bold;">RECIBIDO</a>';
    } elseif($reg[$i]['estado_traspaso']==5) { 
    echo '<a style="color:#dc1a0b;font-weight:bold;">RECHAZADA</a>'; } ?>
    </td>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo $reg[$i]['persona_recibe'] == 0 ? "**********" : $reg[$i]['persona_recibe']; ?></td>
    <td><?php echo $reg[$i]['fecha_recibe'] == '' ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <td><?php echo $reg[$i]['observaciones_recibido'] == '' ? "**********" : $reg[$i]['observaciones_recibido']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <?php } ?>

    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    </tr>
    <?php } ?>
    <tr align="center">
    <?php echo $documento == "EXCEL" ? '<td colspan="13"></td>' : '<td colspan="8"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'TRASPASOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarTraspasosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE TRASPASOS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL N°: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>Nº DE TRACKING</th>
      <th>SUCURSAL REMITENTE</th>
      <th>SUCURSAL DESTINATARIO</th>
      <th>RESPONSABLE DE TRASLADO</th>
      <th>FECHA DE EMISIÓN</th>
      <th>ESTADO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>OBERVACIONES DE ENVIO</th>
      <th>PERSONA QUE RECIBE</th>
      <th>FECHA RECIBE</th>
      <th>OBERVACIONES DE RECIBIDO</th>
      <th>DETALLES DE ARTICULOS</th>
      <?php } ?>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th>TOTAL <?php echo $impuesto; ?></th>
      <th>TOTAL DESC</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr align="center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['numero_tracking']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal'].": ".$reg[$i]['nomsucursal']; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": ".$reg[$i]['nomsucursal2']; ?></td>
    <td><?php echo $reg[$i]['nombres_responsable'] == "" ? "*********" : $reg[$i]['nombres_responsable']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <td><?php if($reg[$i]['estado_traspaso']==1) { 
    echo '<a style="color:#1b78a0;font-weight:bold;">REGISTRADO</a>'; 
    } elseif($reg[$i]['estado_traspaso']==2) {  
    echo '<a style="color:#1b78a0;font-weight:bold;">EN PROCESO</a>'; 
    } elseif($reg[$i]['estado_traspaso']==3) {  
    echo '<a style="color:#1b78a0;font-weight:bold;">PENDIENTE</a>'; 
    } elseif($reg[$i]['estado_traspaso']==4) {  
    echo '<a style="color:#8dbf42;font-weight:bold;">RECIBIDO</a>';
    } elseif($reg[$i]['estado_traspaso']==5) { 
    echo '<a style="color:#dc1a0b;font-weight:bold;">RECHAZADA</a>'; } ?>
    </td>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "**********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo $reg[$i]['persona_recibe'] == 0 ? "**********" : $reg[$i]['persona_recibe']; ?></td>
    <td><?php echo $reg[$i]['fecha_recibe'] == '' ? "**********" : date("d-m-Y H:i:s",strtotime($reg[$i]['fechatraspaso'])); ?></td>
    <td><?php echo $reg[$i]['observaciones_recibido'] == '' ? "**********" : $reg[$i]['observaciones_recibido']; ?></td>
    <td style="text-align:left;font-weight:bold;font-size:10px;color:#1d2591;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <?php } ?>

    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    </tr>
    <?php } ?>
    <tr align="center">
    <?php echo $documento == "EXCEL" ? '<td colspan="13"></td>' : '<td colspan="8"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESTRASPASOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesTraspasosxFechas(); 

$archivo = str_replace(" ", "_","DETALLES DE TRASPASOS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>CÓDIGO</th>
      <th>DESCRIPCIÓN DE PRODUCTO</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <th><?php echo $impuesto; ?></th>
      <th>PRECIO VENTA</th>
      <th>EXISTENCIA</th>
      <th>TRASPASADO</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <td colspan="7"></td>
    <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
    <td><?php echo number_format($ExisteTotal, 2, ',', '.'); ?></td>
    <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></strong></td>
    <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
  </tr>
</table>
<?php
break;
################################## MODULO DE TRASPASOS ###################################





















############################### MODULO DE COMPRAS ###############################
case 'COMPRAS':

$tra = new Login();
$reg = $tra->ListarCompras(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <th>GASTO DE ENVIO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalGasto=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalGasto+=$reg[$i]['gastoenvio'];
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>   
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
        <?php } ?>

    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CUENTASXPAGAR':

$tra = new Login();
$reg = $tra->ListarCuentasxPagar(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS POR PAGAR EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalGasto=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalGasto+=$reg[$i]['gastoenvio'];
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
         
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?> 
</table>
<?php
break;

case 'COMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarComprasxProveedor(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal'])." Y PROVEEDOR ".$reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <th>GASTO DE ENVIO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalGasto=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalGasto+=$reg[$i]['gastoenvio'];
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
           
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>

    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4"></td>
    <?php if ($documento == "EXCEL") { ?>
    <td colspan="4"></td>
    <?php } ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarComprasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <th>GASTO DE ENVIO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalGasto=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalGasto+=$reg[$i]['gastoenvio'];
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>   
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'ABONOSCREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarAbonosCreditosComprasxFechas();

$archivo = str_replace(" ", "_","LISTADO ABONOS DE COMPRAS A CREDITOS EN (CONDICIÓN DE PAGO: ".$reg[0]["mediopago"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>Nº DE DOCUMENTO</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FORMA DE ABONO</th>
      <th>FECHA DE ABONO</th>
      <th>Nº DE COMPROBANTE</th>
      <th>NOMBRE DE BANCO</th>
      <th>MONTO ABONO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
   
$TotalImporte += $reg[$i]['montoabono'];
?>
  <tr class="text-center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]["codfactura"]; ?></td>
    <td><?php echo $reg[$i]['documento2'].": ".$reg[$i]['cuitproveedor']; ?></td>
    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaabono'])); ?></td>
    <td><?php echo $reg[$i]['comprobante'] == "" ? "********" : $reg[$i]['comprobante']; ?></td>
    <td><?php echo $reg[$i]['codbanco'] == 0 ? "********" : $reg[$i]['nombanco']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr class="text-center">
    <td colspan="8"></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CREDITOSCOMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarCreditosComprasxProveedor(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS EN GENERAL DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PAGADAS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PENDIENTES DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalGasto=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalGasto+=$reg[$i]['gastoenvio'];
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="3"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'CREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosComprasxFechas(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","LISTADO DE COMPRAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalGasto=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

$TotalGasto+=$reg[$i]['gastoenvio'];
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCREDITOSCOMPRASXPROVEEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosComprasxProveedor(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS EN GENERAL DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PAGADAS DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PENDIENTES DEL (PROVEEDOR: ".$reg[0]["cuitproveedor"].": ".$reg[0]["nomproveedor"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>OBSERVACIONES</th>
      <th>DETALLES DE PRODUCTOS</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>     
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCREDITOSCOMPRASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosComprasxFechas(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","DETALLES DE COMPRAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE FACTURA</th>
      <th>DESCRIPCIÓN DE PROVEEDOR</th>
      <th>OBSERVACIONES</th>
      <th>DETALLES DE PRODUCTOS</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['cuitproveedor'].": ".$reg[$i]['nomproveedor']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo $reg[$i]["statuscompra"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statuscompra"]; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statuscompra'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statuscompra']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
    </tr>
</table>
<?php
break;
############################### MODULO DE COMPRAS ###############################
























############################### MODULO DE COTIZACIONES ###############################
case 'COTIZACIONES':

$tra = new Login();
$reg = $tra->ListarCotizaciones(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE COTIZACIÓN</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>OBSERVACIONES</th>
      <th>FECHA DE EMISIÓN</th>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'COTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE COTIZACIONES (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE COTIZACIÓN</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>OBSERVACIONES</th>
      <th>FECHA DE EMISIÓN</th>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'DETALLESCOTIZACIONESXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesCotizacionesxFechas(); 

$archivo = str_replace(" ", "_","DETALLES COTIZACIONES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO</th>
      <th>DESCRIPCIÓN</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <th><?php echo $impuesto; ?></th>
      <th>PRECIO VENTA</th>
      <th>COTIZADO</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == 3 ? "0" : $reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php if($reg[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($reg[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { echo "SERVICIO"; } ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <td colspan="7"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCOTIZACIONESXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesCotizacionesxVendedor(); 

$archivo = str_replace(" ", "_","DETALLES COTIZACIONES POR VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO</th>
      <th>DESCRIPCIÓN</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <th><?php echo $impuesto; ?></th>
      <th>PRECIO VENTA</th>
      <th>COTIZADO</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == 3 ? "0" : $reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php if($reg[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($reg[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { echo "SERVICIO"; } ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <td colspan="7"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
############################### MODULO DE COTIZACIONES ###############################




















############################### MODULO DE PREVENTAS ###############################
case 'PREVENTAS':

$tra = new Login();
$reg = $tra->ListarPreventas(); 

$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE PREVENTA</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>OBSERVACIONES</th>
      <th>FECHA DE EMISIÓN</th>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
      <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
      <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
      <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
      <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
      <?php if ($documento == "EXCEL") { ?>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
      <?php } ?>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    </tr>
    <?php } ?>
    <tr>
      <?php echo $documento == "EXCEL" ? '<td colspan="5"></td>' : '<td colspan="5"></td>'; ?>
      <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
      <?php if ($documento == "EXCEL") { ?>
      <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
      <?php } ?>
      <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    </tr>
    <?php } ?>
</table>
<?php
break;

case 'PREVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarPreventasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE PREVENTAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE PREVENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>SUBTOTAL</th>
    <th><?php echo $impuesto; ?></th>
    <th>DCTO %</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
      <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
      <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
      <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
      <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
      <?php if ($documento == "EXCEL") { ?>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
      <?php } ?>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    </tr>
    <?php } } ?>
    <tr>
      <td colspan="5"></td>
      <td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
      <?php if ($documento == "EXCEL") { ?>
      <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
      <?php } ?>
      <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    </tr>
</table>
<?php
break;

case 'DETALLESPREVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesPreventasxFechas(); 

$archivo = str_replace(" ", "_","DETALLES DE PREVENTAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO</th>
      <th>DESCRIPCIÓN</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <th><?php echo $impuesto; ?></th>
      <th>PRECIO VENTA</th>
      <th>PREVENTA</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php if($reg[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($reg[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { echo "SERVICIO"; } ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <td colspan="7"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESPREVENTASXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesPreventasxVendedor(); 

$archivo = str_replace(" ", "_","DETALLES DE PREVENTAS DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO</th>
      <th>DESCRIPCIÓN DE PRODUCTO</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <th><?php echo $impuesto; ?></th>
      <th>PRECIO VENTA</th>
      <th>PREVENTA</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == 3 ? "0" : $reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php if($reg[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($reg[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { echo "SERVICIO"; } ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]["codmodelo"] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
    <tr>
    <td colspan="7"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
############################### MODULO DE PREVENTAS ###############################

















############################### MODULO DE CAJAS ###############################
case 'CAJAS':

$tra = new Login();
$reg = $tra->ListarCajas();  

$archivo = str_replace(" ", "_","LISTADO DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE CAJA</th>
      <th>NOMBRE DE CAJA</th>
      <th>RESPONSABLE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja']; ?></td>
    <td><?php echo $reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'ARQUEOS':

$tra = new Login();
$reg = $tra->ListarArqueoCaja(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE CAJA</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>RESPONSABLE</th>
      <th>APERTURA</th>
      <th>CIERRE</th>
      <th>OBSERVACIONES</th>
      <?php } ?>
      <th>MONTO INICIAL</th>
      <th>TOTAL EN VENTAS</th>
      <th>TOTAL EN ABONOS</th>
      <th>EFECTIVO EN CAJA</th>
      <th>EFECTIVO DISPONIBLE</th>
      <th>DIFERENCIA EFECTIVO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalVentas=0;
$TotalAbonos=0; 
$TotalCaja=0;
$TotalEfectivo=0;
$TotalDiferencia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalVentas+=$reg[$i]['ingresos']+$reg[$i]['creditos'];
$TotalAbonos+=$reg[$i]['abonos'];
$TotalCaja+=$reg[$i]['efectivocaja'];
$TotalEfectivo+=$reg[$i]['dineroefectivo'];
$TotalDiferencia+=$reg[$i]['diferencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaapertura'])); ?></td>
    <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechacierre'])); ?></td>
    <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['abonos'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['efectivocaja'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="3"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbonos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></strong></td>
  <?php } ?>
  </tr>
</table>
<?php
break;

case 'ARQUEOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarArqueosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE ARQUEOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL Nº: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>NOMBRE DE CAJA</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>RESPONSABLE</th>
    <th>APERTURA</th>
    <th>CIERRE</th>
    <th>OBSERVACIONES</th>
    <?php } ?>
    <th>MONTO INICIAL</th>
    <th>TOTAL EN VENTAS</th>
    <th>TOTAL EN ABONOS</th>
    <th>EFECTIVO EN CAJA</th>
    <th>EFECTIVO DISPONIBLE</th>
    <th>DIFERENCIA EFECTIVO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalVentas=0;
$TotalAbonos=0; 
$TotalCaja=0;
$TotalEfectivo=0;
$TotalDiferencia=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalVentas+=$reg[$i]['ingresos']+$reg[$i]['creditos'];
$TotalAbonos+=$reg[$i]['abonos'];
$TotalCaja+=$reg[$i]['efectivocaja'];
$TotalEfectivo+=$reg[$i]['dineroefectivo'];
$TotalDiferencia+=$reg[$i]['diferencia'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaapertura'])); ?></td>
    <td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechacierre'])); ?></td>
    <td><?php echo $reg[$i]['comentarios'] == '' ? "*********" : $reg[$i]['comentarios']; ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['abonos'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['efectivocaja'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, ',', '.'); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="3"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalVentas, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbonos, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalCaja, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalEfectivo, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDiferencia, 2, '.', ','); ?></strong></td>
  <?php } ?>
  </tr>
</table>
<?php
break;

case 'MOVIMIENTOS':

$tra = new Login();
$reg = $tra->ListarMovimientos(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS DE CAJAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>NOMBRE DE CAJA</th>
      <th>RESPONSABLE</th>
      <th>DESCRIPCIÓN</th>
      <th>TIPO</th>
      <th>MONTO</th>
      <th>MEDIO</th>
      <th>FECHA MOVIMIENTO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'MOVIMIENTOSXFECHAS':

$tra = new Login();
$reg = $tra->BuscarMovimientosxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE MOVIMIENTOS EN (CAJA ".$reg[0]['nrocaja'].": ".$reg[0]['nomcaja']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL Nº: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>RESPONSABLE</th>
      <th>DESCRIPCIÓN</th>
      <th>TIPO</th>
      <th>MONTO</th>
      <th>MEDIO</th>
      <th>FECHA MOVIMIENTO</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1; 
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['dni'].": ".$reg[$i]['nombres']; ?></td>
    <td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
    <td><?php echo $reg[$i]['tipomovimiento']; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo $reg[$i]['fechamovimiento']; ?></td>
  </tr>
  <?php } } ?>
</table>
<?php
break;

case 'GANANCIASXFECHAS':

$ingresos = new Login();
$detalle_ingreso = $ingresos->BuscarIngresosxFechas(); 

$gastos = new Login();
$detalle_gasto = $gastos->BuscarGastosxFechas(); 

$ganancias = new Login();
$reg = $ganancias->BuscarGananciasxFechas();  

$archivo = str_replace(" ", "_","GANANCIAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>DESCRIPCIÓN DE PRODUCTO</th>
    <th>MARCA</th>
    <th>MODELO</th>
    <th>DESC.</th>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <th>PRECIO COMPRA</th>
    <?php } ?>
    <th>PRECIO VENTA</th>
    <th>VENDIDO</th>
    <th>TOTAL VENTA</th>
    <th>TOTAL COMPRA</th>
    <th>GANANCIAS</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioCompraTotal=0;
$PrecioVentaTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$CompraTotal=0;
$VentaTotal=0;
$TotalGanancia=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioCompraTotal+=$reg[$i]['preciocompra'];
$PrecioVentaTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;

//CALCULO SUBTOTAL IMPUESTOS
$ValorImpuesto = 1 + ($reg[$i]['ivaproducto']/100);
$Discriminado = $reg[$i]['precioventa']/$ValorImpuesto;
$SubtotalDiscriminado = $reg[$i]['precioventa'] - $Discriminado;
$BaseDiscriminado = $SubtotalDiscriminado * $reg[$i]['cantidad'];
$Subtotalimpuestos = number_format($BaseDiscriminado, 2, '.', '');

$SumVenta = $PrecioFinal*$reg[$i]['cantidad']; 
$SumCompra = $reg[$i]['preciocompra']*$reg[$i]['cantidad'];

$CompraTotal+=$reg[$i]['preciocompra']*$reg[$i]['cantidad'];
$VentaTotal+=$PrecioFinal*$reg[$i]['cantidad'];
$TotalGanancia+=$SumVenta-$SumCompra;
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codproducto']; ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
    <td><?php echo $simbolo.number_format($reg[$i]["preciocompra"], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td colspan="8"></td><?php } else { ?><td colspan="7"></td><?php } ?>
    <td><strong><?php echo number_format($VendidosTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></strong></td>
  </tr>
  <tr class="text-dark alert-link">
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td colspan="10"></td><?php } else { ?><td colspan="9"></td><?php } ?>
    <td><strong>INGRESOS ADICIONALES</strong></td>
    <td><strong><?php echo $simbolo.number_format($detalle_ingreso[0]['ingresos'], 2, '.', ','); ?></strong></td>
  </tr>
  <tr class="text-dark alert-link">
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td colspan="10"></td><?php } else { ?><td colspan="9"></td><?php } ?>
    <td><strong>GASTOS</strong></td>
    <td><strong><?php echo $simbolo.number_format($detalle_gasto[0]['gastos'], 2, '.', ','); ?></strong></td>
  </tr>
  <tr class="text-dark alert-link">
    <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?><td colspan="10"></td><?php } else { ?><td colspan="9"></td><?php } ?>
    <td><strong>TOTAL</strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalGanancia+$detalle_ingreso[0]['ingresos']-$detalle_gasto[0]['gastos'], 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
############################### MODULO DE CAJAS ###############################


















############################### MODULO DE VENTAS ###############################
case 'VENTAS':

$tra = new Login();
$reg = $tra->ListarVentas(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE VENTA</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>TIPO DE PAGO</th>
      <th>NOTA CRÉDITO</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>FECHA DE EMISIÓN</th>
      <th>DETALLES DE PRODUCTOS</th>
      <th>Nº DE ARTICULOS</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['tipopago']; ?></td>
    <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
           
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <?php } ?>
  </tr>
</table>
<?php
break;

case 'VENTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarVentasxCajas(); 

if(decrypt($_GET['tipopago']) == 1){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS GENERALES EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 2){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 3){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITO EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>NOTA CRÉDITO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>SUBTOTAL</th>
    <th><?php echo $impuesto; ?></th>
    <th>DCTO %</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['tipopago']; ?></td>
    <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
           
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'VENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarVentasxFechas(); 

if(decrypt($_GET['tipopago']) == 1){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS GENERALES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 2){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 3){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>NOTA CRÉDITO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>SUBTOTAL</th>
    <th><?php echo $impuesto; ?></th>
    <th>DCTO %</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['tipopago']; ?></td>
    <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
           
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'VENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarVentasxClientes(); 

if(decrypt($_GET['tipopago']) == 1){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS GENERALES DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 2){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 3){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CRÉDITO DEL CLIENTE (".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <th>NOTA CRÉDITO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>SUBTOTAL</th>
    <th><?php echo $impuesto; ?></th>
    <th>DCTO %</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['tipopago']; ?></td>
    <td><?php echo $reg[$i]['notacredito'] == 1 ? "SI" : "NO"; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
           
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="11"></td>' : '<td colspan="7"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'VENTASXCONDICIONES':

$tra = new Login();
$reg = $tra->BuscarVentasxCondiciones();

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CONTADO EN (FORMA DE PAGO: ".$reg[0]["mediopago"]." DE CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." Y FECHA DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>FECHA EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>SUBTOTAL</th>
    <th><?php echo $impuesto; ?></th>
    <th>DESC %</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL PAGADO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;
$TotalPagado=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$ImportePagado = $reg[$i]['montopagado']-$reg[$i]['montodevuelto'];
$TotalPagado += $reg[$i]['montopagado']-$reg[$i]['montodevuelto'];
?>
  <tr class="text-center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]["codfactura"]; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['tipopago']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?></td>
      
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
           
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($ImportePagado, 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr class="text-center">
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalPagado, 2, '.', ','); ?></strong></td>
  </tr>
    <?php } ?>
</table>
<?php
break;

case 'COMISIONXVENTAS':

$tra = new Login();
$reg = $tra->BuscarComisionxVentas(); 

if(decrypt($_GET['tipopago']) == 1){ 

$archivo = str_replace(" ", "_","LISTADO COMISIÓN DE VENTAS GENERALES DEL VENDEDOR (Nº: ".$reg[0]["dni"].": ".$reg[0]["nombres"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 2){ 

$archivo = str_replace(" ", "_","LISTADO COMISIÓN DE VENTAS A CONTADO DEL VENDEDOR (Nº: ".$reg[0]["dni"].": ".$reg[0]["nombres"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 3){ 

$archivo = str_replace(" ", "_","LISTADO COMISIÓN DE VENTAS A CRÉDITO DEL VENDEDOR (Nº: ".$reg[0]["dni"].": ".$reg[0]["nombres"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>TIPO DE PAGO</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>FECHA DE EMISIÓN</th>
    <th>DETALLES DE PRODUCTOS</th>
    <th>Nº DE ARTICULOS</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>SUBTOTAL</th>
    <th><?php echo $impuesto; ?></th>
    <th>DCTO %</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL COMISIÓN</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;
$TotalComision=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
   
$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
$comision = number_format($reg[0]['comision']/100, 3, '.', ',');
$TotalComision+=number_format($reg[$i]['totalpago']*$comision, 3, '.', ',');
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['tipopago']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
           
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']*$reg[0]['comision']/100, 2, '.', ','); ?></td>
  </tr>
    <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo number_format($TotalArticulos, 2, '.', ''); ?></strong></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesVentasxFechas(); 

if(decrypt($_GET['tipopago']) == 1){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS GENERALES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 2){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 3){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO</th>
      <th>DESCRIPCIÓN</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <th><?php echo $impuesto; ?></th>
      <th>PRECIO VENTA</th>
      <th>VENDIDO</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == 3 ? "0" : $reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php if($reg[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($reg[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { echo "SERVICIO"; } ?></td>
    <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
    <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
    <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
    <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
    <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
    <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
   </tr>
  <?php } } ?>
  <tr>
    <td colspan="7"></td>
    <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESVENTASXVENDEDOR':

$tra = new Login();
$reg = $tra->BuscarDetallesVentasxVendedor(); 

if(decrypt($_GET['tipopago']) == 1){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS GENERALES DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 2){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CONTADO DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

} elseif(decrypt($_GET['tipopago']) == 3){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CRÉDITO DEL VENDEDOR (".$reg[0]['dni'].": ".$reg[0]['nombres']." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>TIPO</th>
      <th>DESCRIPCIÓN DE PRODUCTO</th>
      <th>MARCA</th>
      <th>MODELO</th>
      <th>DESC.</th>
      <th><?php echo $impuesto; ?></th>
      <th>PRECIO VENTA</th>
      <th>VENDIDO</th>
      <th>MONTO TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {

$PrecioTotal=0;
$ExisteTotal=0;
$VendidosTotal=0;
$PagoTotal=0;
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$PrecioTotal+=$reg[$i]['precioventa'];
$ExisteTotal+=$reg[$i]['tipodetalle'] == 3 ? "0" : $reg[$i]['existencia'];
$VendidosTotal+=$reg[$i]['cantidad']; 

$Descuento = $reg[$i]['descproducto']/100;
$PrecioDescuento = $reg[$i]['precioventa']*$Descuento;
$PrecioFinal = $reg[$i]['precioventa']-$PrecioDescuento;
$PagoTotal+=$PrecioFinal*$reg[$i]['cantidad']; 
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php if($reg[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($reg[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { echo "SERVICIO"; } ?></td>
      <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
      <td><?php echo $reg[$i]["codmarca"] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
      <td><?php echo $reg[$i]["codmodelo"] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
      <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
      <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
      <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
      <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
    </tr>
    <?php } } ?>
    <tr>
      <td colspan="7"></td>
      <td><strong><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></strong></td>
    </tr>
</table>
<?php
break;
############################### MODULO DE VENTAS ###############################



























############################### MODULO DE CREDITOS ###############################
case 'CREDITOS':

$tra = new Login();
$reg = $tra->ListarCreditos(); 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE VENTA</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>OBSERVACIONES</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
      
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>

    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'ABONOSCREDITOSVENTASXCAJAS':

$tra = new Login();
$reg = $tra->BuscarAbonosCreditosVentasxCajas();

$archivo = str_replace(" ", "_","LISTADO ABONOS DE VENTAS A CREDITOS EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." CONDICIÓN DE PAGO: ".$reg[0]["mediopago"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")"); 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" class="text-center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>Nº DE DOCUMENTO</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>FORMA DE ABONO</th>
    <th>FECHA DE ABONO</th>
    <th>MONTO ABONO</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");  
   
$TotalImporte += $reg[$i]['montoabono'];
?>
  <tr class="text-center" class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]["codfactura"]; ?></td>
    <td><?php echo $reg[$i]['documento3'].": ".$reg[$i]['dnicliente']; ?></td>
    <td><?php echo $reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['mediopago']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaabono'])); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr class="text-center">
    <td colspan="6"></td>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'CREDITOSVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarCreditosVentasxFechas(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL ABONO</th>
    <th>TOTAL DEBE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>

    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>    
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'CREDITOSVENTASXCLIENTES':

$tra = new Login();
$reg = $tra->BuscarCreditosVentasxClientes(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS EN GENERAL DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PAGADAS DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","LISTADO DE VENTAS A CREDITOS PENDIENTES DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
} 

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE VENTA</th>
    <th>OBSERVACIONES</th>
    <th>FECHA DE EMISIÓN</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>ESTADO</th>
    <th>DIAS VENC.</th>
    <th>FECHA VENCE</th>
    <th>FECHA PAGADO</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
    <th>TOTAL ABONO</th>
    <th>TOTAL DEBE</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>     
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="8"></td>' : '<td colspan="4"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCREDITOSVENTASXFECHAS':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosVentasxFechas(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS EN GENERAL POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PAGADAS POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PENDIENTES POR FECHAS (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");  

}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE VENTA</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>OBSERVACIONES</th>
      <th>DETALLES DE PRODUCTOS</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>

    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>  
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="10"></td>' : '<td colspan="6"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;

case 'DETALLESCREDITOSVENTASXCLIENTE':

$tra = new Login();
$reg = $tra->BuscarDetallesCreditosVentasxClientes(); 

$status = limpiar($_GET["status"]); 

if(decrypt($status) == 1){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS EN GENERAL DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 2){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PAGADAS DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

} elseif(decrypt($status) == 3){ 

$archivo = str_replace(" ", "_","DETALLES DE VENTAS A CREDITOS PENDIENTES DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");
}

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE VENTA</th>
      <th>OBSERVACIONES</th>
      <th>DETALLES DE PRODUCTOS</th>
      <th>FECHA DE EMISIÓN</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>ESTADO</th>
      <th>DIAS VENC.</th>
      <th>FECHA VENCE</th>
      <th>FECHA PAGADO</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
      <th>TOTAL ABONO</th>
      <th>TOTAL DEBE</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalImporte+=$reg[$i]['totalpago'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']-$reg[$i]['creditopagado'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['codfactura']; ?></td>
    <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
    <td style="text-align:left;color:#0b1379;font-weight:bold;font-size:10px;"><?php echo $reg[$i]['detalles_productos']; ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]["statusventa"] == 'ANULADA') { echo $reg[$i]["statusventa"]; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "VENCIDA"; } else { echo $reg[$i]["statusventa"]; } ?></td>
    <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); } elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
    <td><?php echo $reg[$i]['fechavencecredito'] == '0000-00-00' ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechavencecredito'])); ?>
    <td><?php echo $reg[$i]['statusventa'] == 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" || $reg[$i]['statusventa']!= 'PAGADA' && $reg[$i]['fechapagado']== "0000-00-00" ? "*****" :  date("d-m-Y",strtotime($reg[$i]['fechapagado'])); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>    
  </tr>
  <?php } } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="9"></td>' : '<td colspan="5"></td>'; ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></strong></td>
  </tr>
</table>
<?php
break;
############################### MODULO DE CREDITOS ###############################





















############################### MODULO DE CREDITOS ###############################
case 'NOTASCREDITO':

$tra = new Login();
$reg = $tra->ListarNotasCreditos(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CREDITO EN (SUCURSAL ".$sucursal = ($reg == "" ? "" : $reg[0]['cuitsucursal']." ".$reg[0]['nomsucursal']).")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE NOTA</th>
      <th>Nº DE DOCUMENTO</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>Nº DE ARTICULOS</th>
      <th>FECHA DE EMISIÓN</th>
      <th>MOTIVO DE NOTA</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $reg[$i]['observaciones']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="7"></td>'; ?>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXCAJAS':

$tra = new Login();
$reg = $tra->BuscarNotasxCajas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO EN (CAJA Nº: ".$reg[0]["nrocaja"].": ".$reg[0]["nomcaja"]." DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <th>Nº</th>
    <th>Nº DE NOTA</th>
    <th>Nº DE DOCUMENTO</th>
    <th>DESCRIPCIÓN DE CLIENTE</th>
    <th>Nº DE ARTICULOS</th>
    <th>FECHA DE EMISIÓN</th>
    <th>MOTIVO DE NOTA</th>
    <?php if ($documento == "EXCEL") { ?>
    <th>SUBTOTAL</th>
    <th><?php echo $impuesto; ?></th>
    <th>DCTO</th>
    <?php } ?>
    <th>IMPORTE TOTAL</th>
  </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $reg[$i]['observaciones']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="4"></td>'; ?>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXFECHAS':

$tra = new Login();
$reg = $tra->BuscarNotasxFechas(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO (DESDE ".date("d-m-Y", strtotime($_GET["desde"]))." HASTA ".date("d-m-Y", strtotime($_GET["hasta"]))." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE NOTA</th>
      <th>Nº DE DOCUMENTO</th>
      <th>DESCRIPCIÓN DE CLIENTE</th>
      <th>Nº DE ARTICULOS</th>
      <th>FECHA DE EMISIÓN</th>
      <th>MOTIVO DE NOTA</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
    <tr class="even_row">
      <td><?php echo $a++; ?></td>
      <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
      <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['facturaventa']; ?></td>
      <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
      <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
      <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
      <td><?php echo $reg[$i]['observaciones']; ?></td>
      <?php if ($documento == "EXCEL") { ?>
      <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
      <?php } ?>
      <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    </tr>
    <?php } ?>
    <tr>
      <?php echo $documento == "EXCEL" ? '<td colspan="7"></td>' : '<td colspan="4"></td>'; ?>
      <?php if ($documento == "EXCEL") { ?>
      <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
      <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
      <?php } ?>
      <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
    </tr>
    <?php } ?>
</table>
<?php
break;

case 'NOTASCREDITOXCLIENTE':

$tra = new Login();
$reg = $tra->BuscarNotasxClientes(); 

$archivo = str_replace(" ", "_","LISTADO DE NOTAS DE CRÉDITO DEL (CLIENTE: ".$reg[0]["dnicliente"].": ".$reg[0]["nomcliente"]." Y SUCURSAL: ".$reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal'].")");

header("Content-Type: application/vnd.ms-$documento"); 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <th>Nº</th>
      <th>Nº DE NOTA</th>
      <th>Nº DE DOCUMENTO</th>
      <th>Nº DE ARTICULOS</th>
      <th>FECHA DE EMISIÓN</th>
      <th>MOTIVO DE NOTA</th>
      <?php if ($documento == "EXCEL") { ?>
      <th>SUBTOTAL</th>
      <th><?php echo $impuesto; ?></th>
      <th>DCTO %</th>
      <?php } ?>
      <th>IMPORTE TOTAL</th>
    </tr>
<?php 
if($reg==""){
echo "";      
} else {
  
$a=1;
$TotalArticulos=0;
$TotalSubtotal=0;
$TotalImpuesto=0;
$TotalDescuento=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){ 
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$TotalArticulos+=$reg[$i]['articulos'];
$TotalSubtotal+=$reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'];
$TotalImpuesto+=$reg[$i]['totaliva'];
$TotalDescuento+=$reg[$i]['totaldescuento'];
$TotalImporte+=$reg[$i]['totalpago'];
?>
  <tr class="even_row">
    <td><?php echo $a++; ?></td>
    <td><?php echo '&nbsp;'.$reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $reg[$i]['observaciones']; ?></td>
    <?php if ($documento == "EXCEL") { ?>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <?php } ?>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <?php echo $documento == "EXCEL" ? '<td colspan="6"></td>' : '<td colspan="6"></td>'; ?>
    <?php if ($documento == "EXCEL") { ?>
    <td><strong><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></strong></td>
    <td><strong><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></strong></td>
    <?php } ?>
    <td><strong><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></strong></td>
  </tr>
  <?php } ?>
</table>
############################### MODULO DE AUDITORIA DE PRODUCTOS ###############################
case 'AUDITORIAPRODUCTOS':

$idauditoria = isset($_GET['idauditoria']) ? (int)decrypt($_GET['idauditoria']) : 0;
$tra = new Login();
$data = $tra->BuscarAuditoriaPorId($idauditoria);

$cab = $data ? $data['cabecera'] : [];
$detalles = $data ? $data['detalles'] : [];

$archivo = str_replace(" ", "_", "AUDITORIA_PRODUCTOS_" . ($cab['nomsucursal'] ?? 'SUCURSAL') . "_" . date("Ymd_His"));
header("Content-Type: application/vnd.ms-$documento");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=".$archivo.$extension);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table border="1" cellpadding="2" cellspacing="0">
  <tr style="background-color: #d9534f; color: #ffffff; font-weight: bold; text-align: center;">
    <th colspan="11">INFORME DE AUDITORÍA DE PRODUCTOS - <?php echo strtoupper($cab['nomsucursal'] ?? ''); ?></th>
  </tr>
  <tr>
    <td colspan="4"><strong>Sucursal:</strong> <?php echo ($cab['cuitsucursal'] ?? '').": ".($cab['nomsucursal'] ?? ''); ?></td>
    <td colspan="4"><strong>Periodo:</strong> <?php echo date("d/m/Y H:i", strtotime($cab['fechadesde'])); ?> al <?php echo date("d/m/Y H:i", strtotime($cab['fechahasta'])); ?></td>
    <td colspan="3"><strong>Auditoría Nº:</strong> <?php echo str_pad($cab['idauditoria'] ?? 0, 6, "0", STR_PAD_LEFT); ?></td>
  </tr>
  <tr style="background-color: #333333; color: #ffffff; font-weight: bold; text-align: center;">
    <th>Nº</th>
    <th>CÓDIGO</th>
    <th>PRODUCTO</th>
    <th>INICIAL CUADERNO</th>
    <th>COMPRAS (+)</th>
    <th>TRASP. RECIBIDOS (+)</th>
    <th>VENTAS POS (-)</th>
    <th>TRASP. ENVIADOS (-)</th>
    <th>STOCK TEÓRICO</th>
    <th>FÍSICO FINAL</th>
    <th>DIFERENCIA (U)</th>
    <th>PRECIO VENTA</th>
    <th>VALOR DIFERENCIA ($)</th>
    <th>ACCIÓN ASIGNADA</th>
    <th>RESPONSABLE / CAJERO</th>
    <th>JUSTIFICACIÓN / MOTIVO</th>
  </tr>
  <?php
  $a = 1;
  foreach ($detalles as $d) {
    $dif = (float)$d['diferencia'];
    $valDif = (float)$d['valordiferencia'];
    $colorDif = $dif < 0 ? 'style="color: red; font-weight: bold;"' : ($dif > 0 ? 'style="color: blue; font-weight: bold;"' : '');
    $accionTxt = $d['accion_diferencia'] ?? 'NINGUNA';
    if ($accionTxt == 'COBRO_CAJERO') $accionTxt = 'COBRO A CAJERO';
    elseif ($accionTxt == 'MERMA_ROTURA') $accionTxt = 'MERMA / ROTURA';
    elseif ($accionTxt == 'ERROR_CONTEO') $accionTxt = 'ERROR DE CONTEO';
    elseif ($accionTxt == 'PERDIDA_EMPRESA') $accionTxt = 'PERDIDA EMPRESA';
    elseif ($accionTxt == 'NINGUNA') $accionTxt = '-';
  ?>
  <tr>
    <td align="center"><?php echo $a++; ?></td>
    <td><?php echo $d['codproducto']; ?></td>
    <td><?php echo $d['producto']; ?></td>
    <td align="center"><?php echo number_format($d['inicial_cuaderno'], 2); ?></td>
    <td align="center"><?php echo number_format($d['entradas_compras'], 2); ?></td>
    <td align="center"><?php echo number_format($d['entradas_traspasos'], 2); ?></td>
    <td align="center"><?php echo number_format($d['salidas_ventas'], 2); ?></td>
    <td align="center"><?php echo number_format($d['salidas_traspasos'], 2); ?></td>
    <td align="center" style="font-weight: bold;"><?php echo number_format($d['stock_teorico'], 2); ?></td>
    <td align="center"><?php echo number_format($d['fisico_final'], 2); ?></td>
    <td align="center" <?php echo $colorDif; ?>><?php echo ($dif > 0 ? "+" : "") . number_format($dif, 2); ?></td>
    <td align="right"><?php echo number_format($d['precioventa'], 2); ?></td>
    <td align="right" <?php echo $colorDif; ?>><?php echo ($valDif > 0 ? "+" : "") . number_format($valDif, 2); ?></td>
    <td align="center"><?php echo $accionTxt; ?></td>
    <td><?php echo $d['responsable_diferencia'] ?? ''; ?></td>
    <td><?php echo $d['motivo_diferencia'] ?? ''; ?></td>
  </tr>
  <?php } ?>
  <tr style="background-color: #f2f2f2; font-weight: bold;">
    <td colspan="8">TOTALES</td>
    <td align="center"><?php echo count($detalles); ?> Prod.</td>
    <td></td>
    <td align="center" style="color: red;"><?php echo number_format($cab['total_faltantes'] ?? 0, 2); ?></td>
    <td></td>
    <td align="right" style="color: red;">$ <?php echo number_format($cab['monto_faltante'] ?? 0, 2); ?></td>
    <td colspan="3"></td>
  </tr>
</table>
<?php
break;
############################### MODULO DE AUDITORIA DE PRODUCTOS ###############################

}
 
?>

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