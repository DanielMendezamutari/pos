<?php
require_once("class/class.php");
?>

<?php
$imp = new Login();
$imp = $imp->ImpuestosPorId();
$impuesto = (empty($imp) ? "Impuesto" : $imp[0]['nomimpuesto']);
$valor = (empty($imp) ? "0.00" : $imp[0]['valorimpuesto']);

$conf = new Login();
$conf = $conf->ConfiguracionPorId();

$new = new Login();
?>


<?php 
######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
if (isset($_GET['MuestraDatosProductos']) && isset($_GET['sucursal']) && isset($_GET['barcode'])) { 

$reg = $new->VerificadorProductosPorId();

if(empty(!$reg)){
?>
    <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png")){   
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png?' style='margin:0px;' width='300' height='200'>";
        } else {
          echo "<img src='fotos/default.png' style='margin:0px;' width='300' height='200'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1 class="text-danger alert-link"># <?php echo $reg[0]['codproducto']; ?></h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link"><?php echo $reg[0]['producto']; ?></h2>
        <h4 class="text-danger alert-link"><?php echo $marca = ($reg[0]['codmarca'] == 0 ? "": $reg[0]['nommarca']); ?> <?php echo $modelo = ($reg[0]['codmodelo'] == 0 ? "": " - ".$reg[0]['nommodelo']); ?></h4>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3 class="text-dark alert-link">P.V.MIN: <?php echo number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3 class="text-dark alert-link">P.V.MAY: <?php echo number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h3 class="text-dark alert-link">P.V.P: <?php echo number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></h3>
      </div>
    </div>

    </center>

<?php 
  }
}
######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
?>



<?php 
######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
if (isset($_GET['MuestraDatosProductos2']) && isset($_GET['sucursal']) && isset($_GET['barcode'])) { 

$reg = $new->VerificadorProductosPorId();

if(empty(!$reg)){
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalle de Producto</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

    <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg?' style='margin:0px;' width='300' height='200'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png")){   
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png?' style='margin:0px;' width='300' height='200'>";
        } else {
          echo "<img src='fotos/default.png' style='margin:0px;' width='300' height='200'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1 class="text-danger alert-link"># <?php echo $reg[0]['codproducto']; ?></h1>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h1 class="text-dark alert-link"><?php echo $reg[0]['producto']; ?></h1>
        <h3 class="text-danger alert-link"><?php echo $marca = ($reg[0]['codmarca'] == 0 ? "": $reg[0]['nommarca']); ?> <?php echo $modelo = ($reg[0]['codmodelo'] == 0 ? "": " - ".$reg[0]['nommodelo']); ?></h3>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link">P.V.MIN: <?php echo number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></h2>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link">P.V.MAY: <?php echo number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></h2>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <h2 class="text-dark alert-link">P.V.P: <?php echo number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></h2>
      </div>
    </div>

    </center>

        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Row -->

<?php 
  }
}
######################## BUSCA DATOS PRODUCTOS POR VERIFICADOR ########################
?>


<?php 
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
if (isset($_GET['BuscaDepartamentos']) && isset($_GET['id_provincia'])) {
  
  $departamento = $new->ListarDepartamentoXProvincias();

  $id_provincia = limpiar($_GET['id_provincia']);

  if($id_provincia=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>

  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($departamento);$i++){
  ?>
  <option style="color:#000;font-weight:bold;" value="<?php echo $departamento[$i]['id_departamento']; ?>" ><?php echo $departamento[$i]['departamento']; ?></option>
    <?php 
    }
  }
}
######################## BUSCA DEPARTAMENTOS POR PROVINCIAS ########################
?>

<?php 
######################## SELECCIONE DEPARTAMENTOS POR PROVINCIAS ########################
if (isset($_GET['SeleccionaDepartamento']) && isset($_GET['id_provincia']) && isset($_GET['id_departamento'])) {
  
  $departamento = $new->SeleccionaDepartamento();
  ?>
  </div>
  </div>
  <option value="">SELECCIONE</option>
  <?php for($i=0;$i<sizeof($departamento);$i++){ ?>
  <option value="<?php echo $departamento[$i]['id_departamento']; ?>"<?php if (!(strcmp($_GET['id_departamento'], htmlentities($departamento[$i]['id_departamento'])))) {echo "selected=\"selected\"";} ?>><?php echo $departamento[$i]['departamento']; ?></option>
<?php
  } 
}
######################## SELECCIONE DEPARTAMENTOS POR PROVINCIAS ########################
?>





<?php 
######################## BUSCA SUBFAMILIAS POR FAMILIAS ########################
if (isset($_GET['BuscaSubfamilias']) && isset($_GET['codfamilia'])) {
  
$subfamilia = $new->ListarSubfamilias2();

$codfamilia = limpiar($_GET['codfamilia']);

 if($codfamilia=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($subfamilia);$i++){
  ?>
  <option value="<?php echo encrypt($subfamilia[$i]['codsubfamilia']); ?>" ><?php echo $subfamilia[$i]['nomsubfamilia']; ?></option>
<?php 
    } 
  }
}
######################## BUSCA SUBFAMILIAS POR FAMILIAS ########################
?>




<?php 
######################## BUSCA MARCAS X SUCURSAL ########################
if (isset($_GET['BuscaMarcasxSucursal']) && isset($_GET['codsucursal']) && isset($_GET['codmarca'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codmarca = limpiar($_GET['codmarca']);
  $marca = $new->ListarMarcas();

  if($codsucursal == "" || $codmarca == "") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($marca);$i++){
  ?>
  <option value="<?php echo encrypt($marca[$i]['codmarca']); ?>"<?php if (!(strcmp(decrypt($_GET['codmarca']), htmlentities($marca[$i]['codmarca'])))) { echo "selected=\"selected\"";} ?>><?php echo $marca[$i]['nommarca']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MARCAS X SUCURSAL #############################
?>

<?php 
######################## BUSCA MODELOS POR MARCAS ########################
if (isset($_GET['BuscaModelos']) && isset($_GET['codmarca'])) {
  
  $codmarca = limpiar($_GET['codmarca']);
  $modelo = $new->ListarModelosxMarcas();

  if($codmarca=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($modelo);$i++){
  ?>
  <option value="<?php echo encrypt($modelo[$i]['codmodelo']); ?>" ><?php echo $modelo[$i]['nommodelo']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MODELOS POR MARCAS #############################
?>

<?php 
######################## BUSCA MODELOS #2 POR MARCAS ########################
if (isset($_GET['BuscaModelos2']) && isset($_GET['codmarca2'])) {
  
  $codmarca = limpiar($_GET['codmarca2']);
  $modelo = $new->ListarModelos2xMarcas();

  if($codmarca=="") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($modelo);$i++){
  ?>
  <option value="<?php echo encrypt($modelo[$i]['codmodelo']); ?>" ><?php echo $modelo[$i]['nommodelo']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA MODELOS #2 POR MARCAS #############################
?>


<?php 
######################## BUSCA FAMILIAS X SUCURSAL ########################
if (isset($_GET['BuscaFamiliasxSucursal']) && isset($_GET['codsucursal']) && isset($_GET['codfamilia'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codfamilia = limpiar($_GET['codfamilia']);
  $familia = $new->ListarFamilias();

  if($codsucursal == "" || $codfamilia == "") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($familia);$i++){
  ?>
  <option value="<?php echo encrypt($familia[$i]['codfamilia']); ?>"<?php if (!(strcmp(decrypt($_GET['codfamilia']), htmlentities($familia[$i]['codfamilia'])))) { echo "selected=\"selected\"";} ?>><?php echo $familia[$i]['nomfamilia']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA FAMILIAS X SUCURSAL #############################
?>

<?php 
######################## BUSCA PRESENTACIONES X SUCURSAL ########################
if (isset($_GET['BuscaPresentacionesxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $presentacion = $new->ListarPresentaciones();

  if($codsucursal == "") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($presentacion);$i++){
  ?>
  <option value="<?php echo encrypt($presentacion[$i]['codpresentacion']); ?>"><?php echo $presentacion[$i]['nompresentacion']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA PRESENTACIONES X SUCURSAL #############################
?>

<?php 
######################## BUSCA COLORES X SUCURSAL ########################
if (isset($_GET['BuscaColoresxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $color = $new->ListarColores();

  if($codsucursal == "") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($color);$i++){
  ?>
  <option value="<?php echo encrypt($color[$i]['codcolor']); ?>"><?php echo $color[$i]['nomcolor']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA COLORES X SUCURSAL #############################
?>

<?php 
######################## BUSCA ORIGENES X SUCURSAL ########################
if (isset($_GET['BuscaOrigenesxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $origen = $new->ListarOrigenes();

  if($codsucursal == "") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($origen);$i++){
  ?>
  <option value="<?php echo encrypt($origen[$i]['codorigen']); ?>"><?php echo $origen[$i]['nomorigen']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA ORIGENES X SUCURSAL #############################
?>

<?php 
######################## BUSCA PROVEEDORES X SUCURSAL ########################
if (isset($_GET['BuscaProveedoresxSucursal']) && isset($_GET['codsucursal'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $proveedor = $new->ListarProveedores();

  if($codsucursal == "") { ?>

  <option value=""> -- SIN RESULTADOS -- </option>
  <?php } else { ?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($proveedor);$i++){
  ?>
  <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>"><?php echo $proveedor[$i]['nomproveedor']; ?></option>
    <?php 
    } 
  }
}
######################## BUSCA PROVEEDORES X SUCURSAL #############################
?>

<?php 
######################## BUSCA PROVEEDORES ########################
if (isset($_GET['BuscaProveedores'])) {
  
$proveedor = $new->ListarProveedores();
?>
  <option value=""> -- SELECCIONE -- </option>
  <?php
  for($i=0;$i<sizeof($proveedor);$i++){
  ?>
  <option value="<?php echo encrypt($proveedor[$i]['codproveedor']); ?>" ><?php echo $proveedor[$i]['nomproveedor']; ?></option>
<?php 
  } 
}
######################## BUSCA PROVEEDORES ########################
?>


<?php 
######################## BUSCA PRECIOS DE PRODUCTO ########################
if (isset($_GET['BuscaPreciosProductos']) && isset($_GET['idproducto'])) {
  
$idproducto = limpiar($_GET['idproducto']);
$producto = $new->BuscarPrecioProductoxCodigo();

if($idproducto=="") { ?>

<option style="color:#000;font-weight:bold;" value=""> -- SIN RESULTADOS -- </option>
  
<?php } else { ?>

<option style="color:#000;font-weight:bold;" value=""> -- SELECCIONE -- </option>

<?php
$explode = explode("|",$producto[0]['precioventa']);
$listaSimple = array_values(array_unique($explode));
# Recorremos el array para despues separar en 2 partes.
for($cont=0; $cont<COUNT($listaSimple); $cont++):
list($nombre,$precio) = explode("_",$listaSimple[$cont]);
?>
<option style="color:#000;font-weight:bold;" value="<?php echo number_format($precio, 2, '.', ''); ?>"<?php if (!(strcmp("PRECIO PUBLICO", htmlentities($nombre)))) { echo "selected=\"selected\""; } ?>><?php echo $nombre.": ".number_format($precio, 2, '.', ''); ?></option>
    <?php 
    endfor;
    //}
  }
}
######################## BUSCA PRECIOS DE PRODUCTO ########################
?>


<?php
########################## MOSTRAR USUARIO EN VENTANA MODAL ###########################
if (isset($_GET['BuscaUsuarioModal']) && isset($_GET['codigo'])) { 
$reg = $new->UsuariosPorId();
?>

  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Nº de Documento: <?php echo $reg[0]['dni']; ?></td>
  </tr>
  <tr>
    <td>Nombres y Apellidos: <?php echo $reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td>Sexo: <?php echo $reg[0]['sexo']; ?></td>
  </tr>
  <tr>
    <td>Dirección Domiciliaria:  <?php echo $reg[0]['direccion']; ?></td>
  </tr>
  <tr>
    <td>Nº de Teléfono:  <?php echo $reg[0]['telefono']; ?></td>
  </tr>
  <tr>
    <td>Correo Electrónico:  <?php echo $reg[0]['email']; ?></td>
  </tr>
  <tr>
    <td>Usuario de Acceso:  <?php echo $reg[0]['usuario']; ?></td>
  </tr>
  <tr>
    <td>Nivel de Acceso:  <?php echo $reg[0]['nivel']; ?></td>
  </tr>
  <?php if($_SESSION['acceso']=="administradorG"){ ?>
  <tr>
    <td>Sucursal Asignada:  <?php echo $reg[0]['codsucursal'] == '' ? "*********" : $reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
  <tr>
  <td>Status de Acceso:  <?php echo $status = ( $reg[0]['status'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
</table>  

  <?php
   } 
######################### MOSTRAR USUARIO EN VENTANA MODAL ############################
?>

<?php 
########################## BUSCA USUARIOS POR SUCURSALES #############################
if (isset($_GET['BuscaUsuariosxSucursal']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"><?php echo $usuario[$i]['dni'].": ".$usuario[$i]['nombres'].": ".$usuario[$i]['nivel']; ?></option>
    <?php 
   } 
}
############################# BUSCA USUARIOS POR SUCURSALES ##########################
?>


<?php 
######################## SELECCIONE USUARIOS POR SUCURSALES ########################
if (isset($_GET['MuestraUsuario']) && isset($_GET['codigo']) && isset($_GET['codsucursal'])) {
  
$usuario = $new->BuscarUsuariosxSucursal();
?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($usuario);$i++){
    ?>
<option value="<?php echo $usuario[$i]['codigo'] ?>"<?php if (!(strcmp($_GET['codigo'], htmlentities($usuario[$i]['codigo'])))) { echo "selected=\"selected\"";} ?>><?php echo $usuario[$i]['nombres'].": ".$usuario[$i]['nivel']; ?></option>
<?php
   } 
}
######################## SELECCIONE USUARIOS POR SUCURSALES #######################
?>





<?php
######################### MOSTRAR SUCURSAL EN VENTANA MODAL ##########################
if (isset($_GET['BuscaSucursalModal']) && isset($_GET['codsucursal'])) { 

$reg = $new->SucursalesPorId();
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Nº de <?php echo $reg[0]['documsucursal'] == '0' ? "Documento" : $reg[0]['documento'] ?>:  <?php echo $reg[0]['cuitsucursal']; ?></td>
  </tr>
  <tr>
    <td>Nombre de Sucursal:  <?php echo $reg[0]['nomsucursal']; ?></td>
  </tr>
  <tr>
    <td>Provincia:  <?php echo $reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td>Departamento:  <?php echo $reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td>Dirección de Sucursal:  <?php echo $reg[0]['direcsucursal']; ?></td>
  </tr>
  <tr>
    <td>Correo Electrónico:  <?php echo $reg[0]['correosucursal']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Teléfono:  <?php echo $reg[0]['tlfsucursal']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Inicio de Ticket:  <?php echo $reg[0]['inicioticket']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Inicio de Factura:  <?php echo $reg[0]['iniciofactura']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Inicio de Guia:  <?php echo $reg[0]['inicioguia']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Inicio Nota Venta:  <?php echo $reg[0]['inicionotaventa']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Inicio Nota Credito:  <?php echo $reg[0]['inicionotacredito']; ?></td>
  </tr>
  <tr>
    <td>Nº de Actividad:  <?php echo $reg[0]['nroactividadsucursal']; ?></td>
  </tr>  
  <tr>
    <td>Fecha de Autorización:  <?php echo $reg[0]['fechaautorsucursal'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaautorsucursal'])); ?></td>
  </tr> 
  <tr>
    <td>Lleva Contabilidad:  <?php echo $reg[0]['llevacontabilidad']; ?></td>
  </tr> 
  <tr>
    <td>Nº <?php echo $reg[0]['documencargado'] == '0' ? "Documento" : $reg[0]['documento2'] ?> de Encargado: <?php echo $reg[0]['dniencargado']; ?></td>
  </tr>
  <tr>
    <td>Nombre de Encargado: <?php echo $reg[0]['nomencargado']; ?></td>
  </tr>
  <tr>
    <td>Nº de Telèfono: <?php echo $reg[0]['tlfencargado'] == '' ? "*********" : $reg[0]['tlfencargado']; ?></td>
  </tr>
  <tr>
    <td>Descuento Global en Ventas:  <?php echo number_format($reg[0]['descsucursal'], 2, '.', ','); ?>%</td>
  </tr> 
  <tr>
    <td>Porcentaje para Calcular Precio Venta:  <?php echo number_format($reg[0]['porcentaje'], 2, '.', ','); ?>%</td>
  </tr>   
  <tr>
    <td>Moneda Nacional:  <?php echo $reg[0]['codmoneda'] == '0' ? "*********" : $reg[0]['moneda']; ?></td>
  </tr> 
  <tr>
    <td>Moneda Tipo de Cambio: <?php echo $reg[0]['codmoneda2'] == '0' ? "*********" : $reg[0]['moneda2']; ?></td>
  </tr>
  <td>Estado: <?php echo $status = ($reg[0]['estado'] == 1 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVA</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> INACTIVA</span>"); ?></td>
  </tr> 
</table>
<?php 
} 
######################### MOSTRAR SUCURSAL EN VENTANA MODAL #########################
?>






<?php 
############################# MUESTRA DIV CLIENTE #############################
if (isset($_GET['BuscaDivCliente'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"> Para poder realizar la Carga Masiva de Clientes, el archivo Excel, debe estar estructurado de 12 columnas, la cuales tendrán las siguientes especificaciones:</font><br>

  1. Tipo de Cliente (Opciones: NATURAL/JURIDICO).<br>
  2. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  3. Nº de Documento.<br>
  4. Nombre de Cliente (Ingresar Nombre completo con Apellidos).<br>
  5. Razón Social (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  6. Giro de Cliente (Ingresar en caso de ser Cliente Juridico de lo contrario dejarlo vacio).<br>
  7. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  8. Provincia. (Debera de Ingresar el Codigo de Provincia a la que corresponde)<br>
  9. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  10. Dirección Domiciliaria.<br>
  11. Correo Electronico.<br>
  12. Monto de Crédito en Ventas.<br><br>

  <font color="red"> NOTA:</font><br>
  a) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  b) Descargar Plantilla de Formato para Carga Masiva de Clientes <a class="text-info" href="fotos/clientes.csv">AQUI</a><br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Clientes, deben de ser cargados como se explica, para evitar problemas de datos del cliente dentro del Sistema.<br><br>
   </div>
</div>                               
<?php 
  }
############################ MUESTRA DIV CLIENTE ############################
?>

<?php
########################### MOSTRAR CLIENTE EN VENTANA MODAL ############################
if (isset($_GET['BuscaClienteModal']) && isset($_GET['codcliente'])) { 

$reg = $new->ClientesPorId();
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Código: <?php echo $reg[0]['codcliente']; ?></td>
  </tr>
  <tr>
    <td>Tipo de Cliente:  <?php echo $reg[0]['tipocliente']; ?></td>
  </tr> 
  <tr>
    <td>Nº de <?php echo $reg[0]['documcliente'] == '0' ? "Documento" : $reg[0]['documento'] ?>: <?php echo $reg[0]['dnicliente']; ?></td>
  </tr>
  <tr>
    <td>Nombres/Razón Social: <?php echo $reg[0]['nomcliente']; ?></td>
  </tr>
  <tr>
    <td>Giro de Cliente: <?php echo $reg[0]['tipocliente'] == 'NATURAL' ? "*********" : $reg[0]['girocliente']; ?></td>
  </tr>
  <tr>
    <td>Nº de Teléfono:  <?php echo $reg[0]['tlfcliente'] == '' ? "*********" : $reg[0]['tlfcliente'] ?></td>
  </tr>
  <tr>
    <td>Provincia:  <?php echo $reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td>Departamento:  <?php echo $reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td>Dirección Domiciliaria:  <?php echo $reg[0]['direccliente']; ?></td>
  </tr>
  <tr>
    <td>Correo Electrónico:  <?php echo $reg[0]['emailcliente'] == '' ? "*********" : $reg[0]['emailcliente'] ?></td>
  </tr>
  <tr>
    <td>Limite de Crédito:  <?php echo number_format($reg[0]['limitecredito'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Cantidad de Compras: <?php echo number_format($reg[0]['cantidad'], 2, '.', ','); ?></td>
  </tr>  
  <tr>
    <td>Total en Compras: <?php echo number_format($reg[0]['totalcompras'], 2, '.', ','); ?></td>
  </tr>  
  <tr>
    <td>Fecha de Ingreso: <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR CLIENTE EN VENTANA MODAL ###########################
?>













<?php 
############################# MUESTRA DIV PROVEEDOR #############################
if (isset($_GET['BuscaDivProveedor'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"> Para poder realizar la Carga Masiva de Proveedores, el archivo Excel, debe estar estructurado de 10 columnas, la cuales tendrán las siguientes especificaciones:</font><br>

  1. Tipo de Documento. (Debera de Ingresar el Codigo de Documento a la que corresponde)<br>
  2. Nº de Documento.<br>
  3. Nombre de Proveedor (Ingresar Nombre de Proveedor).<br>
  4. Nº de Teléfono. (Formato: (9999) 9999999).<br>
  5. Provincia. (Debera de Ingresar el Codigo de Provincia a la que corresponde)<br>
  6. Departamento. (Debera de Ingresar el Codigo de Departamento a la que corresponde)<br>
  7. Dirección de Proveedor.<br>
  8. Correo Electronico.<br>
  9. Nombre de Vendedor.<br>
  10. Nº de Teléfono de Vendedor. (Formato: (9999) 9999999).<br><br>

  <font color="red"> NOTA:</font><br>
  a) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  b) Descargar Plantilla de Formato para Carga Masiva de Proveedores <a class="text-info" href="fotos/proveedores.csv">AQUI</a>.<br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Proveedores, deben de ser cargados como se explica, para evitar problemas de datos del proveedor dentro del Sistema.<br><br>
   </div>
</div>
<?php 
}
############################ MUESTRA DIV PROVEEDOR #############################
?>

<?php
########################### MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProveedorModal']) && isset($_GET['codproveedor'])) { 

$reg = $new->ProveedoresPorId();
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Código: <?php echo $reg[0]['codproveedor']; ?></td>
  </tr>
  <tr>
    <td>Nº de <?php echo $reg[0]['documproveedor'] == '0' ? "Documento" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitproveedor']; ?>:</td>
  </tr>
  <tr>
    <td>Nombres de Proveedor: <?php echo $reg[0]['nomproveedor']; ?></td>
  </tr>
  <tr>
    <td>Nº de Teléfono:  <?php echo $reg[0]['tlfproveedor']; ?></td>
  </tr>
  <tr>
    <td>Provincia:  <?php echo $reg[0]['id_provincia'] == '0' ? "*********" : $reg[0]['provincia'] ?></td>
  </tr>
  <tr>
    <td>Departamento:  <?php echo $reg[0]['id_departamento'] == '0' ? "*********" : $reg[0]['departamento'] ?></td>
  </tr>
  <tr>
    <td>Dirección de Proveedor:  <?php echo $reg[0]['direcproveedor']; ?></td>
  </tr>
  <tr>
    <td>Correo Electrónico:  <?php echo $reg[0]['emailproveedor']; ?></td>
  </tr> 
  <tr>
    <td>Vendedor:  <?php echo $reg[0]['vendedor']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Teléfono:  <?php echo $reg[0]['tlfvendedor']; ?></td>
  </tr>
  <tr>
    <td>Fecha de Ingreso:  <?php echo date("d-m-Y",strtotime($reg[0]['fechaingreso'])); ?></td>
  </tr>
</table>
<?php 
} 
########################## MOSTRAR PROVEEDOR EN VENTANA MODAL ##########################
?>


























<?php
########################### MOSTRAR PEDIDOS EN VENTANA MODAL ############################
if (isset($_GET['BuscaPedidoModal']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PEDIDOS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "REGISTRO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº DE FACTURA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechapedido'])); ?>
  <br/> OBSERVACIONES: <?php echo $reg[0]['observaciones']; ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <br/>DIREC: <?php echo $reg[0]['direcproveedor'] == '' ? "*********" : $reg[0]['direcproveedor']; ?> <?php echo $reg[0]['provincia'] == '' ? "*********" : $reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "*********" : $reg[0]['departamento']; ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor'] == '' ? "*******" : $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "*******" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                              <div class="col-md-12">
                                  <div class="table-responsive m-t-10" style="clear: both;">
                                      <table class="table table-hover">
                                          <thead>
                                              <tr>
                        <th>#</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?>
                        <th>Acción</th>
                        <?php } ?>
                      </tr>
                      </thead>
                      <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPedidos();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo $detalle[$i]['cantidad']; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?><td>
 <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPedidosModal('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codpedido=<?php echo encrypt($reg[0]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

<?php
  }
} 
########################## MOSTRAR PEDIDOS EN VENTANA MODAL ############################
?>


<?php
########################## MOSTRAR DETALLES DE PEDIDOS UPDATE ############################
if (isset($_GET['MuestraDetallesPedidosUpdate']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
<?php
} 
########################## MOSTRAR DETALLES DE PEDIDOS UPDATE #########################
?>

<?php
########################## MOSTRAR DETALLES DE PEDIDOS AGREGAR #########################
if (isset($_GET['MuestraDetallesPedidosAgregar']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
<?php
} 
########################## MOSTRAR DETALLES DE PEDIDOS AGREGRA #########################
?>

<?php
########################## MOSTRAR DETALLES PARA PROCESAR PEDIDO ############################
if (isset($_GET['MuestraDetallesPedidos']) && isset($_GET['codpedido']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PedidosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
                    <th>Total Desc %</th>
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
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetallePedidoProcesado('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedidoProcesado(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetallePedidoProcesado('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>
      
  <td class="text-dark alert-link">
  <input type="hidden" name="coddetallepedido[]" id="coddetallepedido" value="<?php echo $detalle[$i]["coddetallepedido"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <input type="hidden" name="producto[]" id="producto" value="<?php echo $detalle[$i]["producto"]; ?>">
  <input type="hidden" name="descripcion[]" id="descripcion" value="<?php echo $detalle[$i]["descripcion"]; ?>">
  <input type="hidden" name="imei[]" id="imei" value="<?php echo $detalle[$i]["imei"]; ?>">
  <input type="hidden" name="condicion[]" id="condicion" value="<?php echo $detalle[$i]["condicion"]; ?>">
  <input type="hidden" name="codmarca[]" id="codmarca" value="<?php echo $detalle[$i]["codmarca"]; ?>">
  <input type="hidden" name="codmodelo[]" id="codmodelo" value="<?php echo $detalle[$i]["codmodelo"]; ?>">
  <input type="hidden" name="codpresentacion[]" id="codpresentacion" value="<?php echo $detalle[$i]["codpresentacion"]; ?>">
  <input type="hidden" name="codcolor[]" id="codcolor" value="<?php echo $detalle[$i]["codcolor"]; ?>">
  <input type="hidden" name="precioxmayor[]" id="precioxmayor" value="<?php echo number_format($detalle[$i]["precioxmayor"], 2, '.', ''); ?>">
  <input type="hidden" name="precioxmenor[]" id="precioxmenor" value="<?php echo number_format($detalle[$i]["precioxmenor"], 2, '.', ''); ?>">
  <input type="hidden" name="precioxpublico[]" id="precioxpublico" value="<?php echo number_format($detalle[$i]["precioxpublico"], 2, '.', ''); ?>">
  <input type="hidden" name="descproducto[]" id="descproducto" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
  <?php echo $detalle[$i]['codproducto']; ?></td>
      
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
  <td class="text-dark alert-link">
  <input type="text" class="cantidad bold" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedidoProcesado(<?php echo $count; ?>);" autocomplete="off" placeholder="Precio Compra" style="width:100px;height:40px;background:#e7f8fc;border-radius:5px 5px 5px 5px;padding:7px 12px;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc');" title="Ingrese Precio Compra" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>" required="" aria-required="true">
  </td>

  <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>
      
  <td class="text-dark alert-link">
  <input type="text" class="cantidad bold" name="descfactura[]" id="descfactura_<?php echo $count; ?>" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPedidoProcesado(<?php echo $count; ?>);" autocomplete="off" placeholder="Descuento" style="width:60px;height:40px;background:#e7f8fc;border-radius:5px 5px 5px 5px;padding:7px 12px;" onfocus="this.style.background=('#e7f8fc')" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc');" title="Ingrese Descuento" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ''); ?>" required="" aria-required="true">
  </td>

  <td class="text-dark alert-link">
  <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ','); ?>">
  <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?> 
  </td>

  <td class="text-dark alert-link"><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>

  <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" ><label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>

  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesProcesarPedidos('<?php echo encrypt($detalle[$i]["coddetallepedido"]); ?>','<?php echo encrypt($detalle[$i]["codpedido"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPEDIDOS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
<?php
} 
########################## MOSTRAR DETALLES PARA PROCESAR PEDIDO #########################
?>

<?php
########################## BUSQUEDA PEDIDOS POR PROVEEDORES ##########################
if (isset($_GET['BuscaPedidosxProvedores']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPedidosxProveedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Pedidos del Proveedor <?php echo $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOSXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div1"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                              <th>Nº</th>
                              <th>N° de Factura</th>
                              <th>Descripción de Proveedor</th>
                              <th>Fecha Emisión</th>
                              <th>Nº Artic</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Dcto %</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td>
  <a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                      </tr>
                    <?php } ?>
         <tr class="text-dark alert-link">
          <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA PEDIDOS POR PROVEEDORES ##########################
?>


<?php
########################## BUSQUEDA PEDIDOS POR FECHAS ##########################
if (isset($_GET['BuscaPedidosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']); 
  $hasta = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

  } else {

$pre = new Login();
$reg = $pre->BuscarPedidosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Pedidos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PEDIDOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PEDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PEDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div1"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                              <th>Nº</th>
                              <th>N° de Factura</th>
                              <th>Descripción de Proveedor</th>
                              <th>Fecha Emisión</th>
                              <th>Nº Artic</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Dcto %</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapedido'])); ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td>
  <a href="reportepdf?codpedido=<?php echo encrypt($reg[$i]['codpedido']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURAPEDIDO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                      </tr>
                    <?php } ?>
         <tr class="text-dark alert-link">
          <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA PEDIDOS POR FECHAS ##########################
?>


























<?php 
############################# MUESTRA DIV PRODUCTO ############################
if (isset($_GET['BuscaDivProducto'])) {
  
  ?>
<div class="row">
      <div class="col-md-12">
<font color="red"> Para poder realizar la Carga Masiva de Productos, el archivo Excel, debe estar estructurado de 33 columnas, la cuales tendrán las siguientes especificaciones:</font><br><br>

  1. Código de Producto (Ejem. 0001).<br>
  2. Nombre de Producto.<br>
  3. Descripción de Producto.<br>
  4. Nº de Imei.<br>
  5. Condición de Producto.<br>
  6. Nombre de Fabricante (En caso de no tener colocar Cero).<br>
  7. Familia de Producto. (Deberá ingresar el Nº de Familia a la que corresponde o colocar Cero).<br>
  8. Subfamilia de Producto. (Deberá ingresar el Nº de Subfamilia a la que corresponde o colocar Cero)<br>
  9. Marca de Producto (Deberá ingresar el Nº de Marca a la que corresponde o colocar Cero)<br>
  10. Modelo de Producto (Deberá ingresar el Nº de Modelo a la que corresponde o colocar Cero)<br>
  11. Presentación (Deberá ingresar el Nº de Presentación a la que corresponde o colocar Cero)<br>
  12. Color de Producto (Deberá ingresar el Nº de Color a la que corresponde o colocar Cero).<br>
  13. Origen de Producto (Deberá ingresar el Nº de Origen a la que corresponde o colocar Cero).<br>
  14. Año de Producto (En caso de ser algun Producto de Año de Fabricación).<br>
  15. Nº de Parte de Producto (En caso de no tener colocar Cero).<br>
  16. Lote de Producto (En caso de no tener colocar Cero).<br>
  17. Peso de Producto (En caso de no tener colocar Cero).<br>
  18. Precio Compra. (Numeros con 2 decimales).<br>
  19. Precio Venta Menor. (Numeros con 2 decimales).<br>
  20. Precio Venta Mayor. (Numeros con 2 decimales).<br>
  21. Precio Venta Público. (Numeros con 2 decimales).<br>
  22. Existencia. (Debe de ser solo enteros).<br>
  23. Stock Óptimo. (Debe de ser solo enteros).<br>
  24. Stock Medio. (Debe de ser solo enteros).<br>
  25. Stock Minimo. (Debe de ser solo enteros).<br>
  26. <?php echo $impuesto; ?> de Producto. (Ejem. SI o NO).<br>
  27. Descuento de Producto. (Numeros con 2 decimales).<br>
  28. Código de Barra. (En caso de no tener colocar Cero).<br>
  29. Fecha de Elaboración. (Formato: 0000-00-00).<br>
  30. Fecha de Expiración Óptimo. (Formato: 0000-00-00).<br>
  31. Fecha de Expiración Medio. (Formato: 0000-00-00).<br>
  32. Fecha de Expiración Minimo. (Formato: 0000-00-00).<br>
  33. Proveedor. (Debe de verificar a que codigo pertenece el Proveedor existente).<br><br>

  <font color="red"> NOTA:</font><br>
  a) Se debe de guardar como archivo .CSV  (delimitado por comas)(*.csv).<br>
  b) Descargar Plantilla <a class="text-info" href="fotos/productos.csv">AQUI</a>.<br>
  c) Todos los datos deberán escribirse en mayúscula para mejor orden y visibilidad en los reportes.<br>
  d) Deben de tener en cuenta que la carga masiva de Productos, deben de ser cargados como se explica, para evitar problemas de datos del productos dentro del Sistema.<br><br>
    </div>
</div>                                 
<?php 
}
############################# MUESTRA DIV PRODUCTO #############################
?>

<?php 
########################## MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL ##########################
if (isset($_GET['BuscaFotoProductoModal']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) { 

$reg = $new->ProductosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
  <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg")){
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".jpeg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png")){   
          echo "<img src='fotos/productos/".$reg[0]["codsucursal"]."_".$reg[0]["codproducto"].".png?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else {
          echo "<img src='fotos/img.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Nombre de Producto" class="alert-link"><?php echo $reg[0]['producto']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Código de Producto" class="alert-link"><?php echo $reg[0]['codproducto']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Precio Venta Minorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Mayorista" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?></abbr> - 

        <abbr title="Precio Venta Público" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?></abbr>
      </div>
    </div><hr> 
  <?php
  include('fpdf/barcode.php');
  $codigo = $reg[0]["codigobarra"];
  barcode('fpdf/codigos/'.$codigo.'.png', $codigo, 50, 'horizontal', 'code128', true);
  ?>
  <img src="fpdf/codigos/<?php echo $codigo.'.png'; ?>"> 
  </center> 
<?php 
}
############################# MOSTRAR FOTO DE PRODUCTO EN VENTANA MODAL #############################
?>

<?php
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
if (isset($_GET['BuscaProductoModal']) && isset($_GET['codproducto']) && isset($_GET['codsucursal'])) { 

$reg = $new->ProductosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Código: <?php echo $reg[0]['codproducto']; ?></td>
  </tr>
  <tr>
    <td>Producto: <?php echo $reg[0]['producto']; ?></td>
  </tr> 
  <tr>
    <td>Descripción: <?php echo $reg[0]['descripcion'] == '' ? "*********" : $reg[0]['descripcion']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Imei: <?php echo $reg[0]['imei'] == '' ? "*********" : $reg[0]['imei']; ?></td>
  </tr> 
  <tr>
    <td>Condición: <?php echo $reg[0]['condicion'] == '' ? "*********" : $reg[0]['condicion']; ?></td>
  </tr>
  <tr>
    <td>Fabricante: <?php echo $reg[0]['fabricante'] == '' ? "*********" : $reg[0]['fabricante']; ?></td>
  </tr>
  <tr>
    <td>Familia: <?php echo $reg[0]['nomfamilia']; ?></td>
  </tr>
  <tr>
    <td>Subfamilia: <?php echo $reg[0]['codsubfamilia'] == '0' ? "*********" : $reg[0]['nomsubfamilia']; ?></td>
  </tr>
  <tr>
    <td>Marca: <?php echo $reg[0]['nommarca']; ?></td>
  </tr>
  <tr>
    <td>Modelo: <?php echo $reg[0]['nommodelo'] == '' ? "*********" : $reg[0]['nommodelo']; ?></td>
  </tr>
  <tr>
    <td>Presentación: <?php echo $reg[0]['nompresentacion']; ?></td>
  </tr> 
  <tr>
    <td>Color: <?php echo $reg[0]['codcolor'] == '0' ? "*********" : $reg[0]['nomcolor']; ?></td>
  </tr> 
  <tr>
    <td>Origen: <?php echo $reg[0]['codorigen'] == '0' ? "*********" : $reg[0]['nomorigen']; ?></td>
  </tr>
  <tr>
    <td>Año de Fábrica: <?php echo $reg[0]['year'] == '' ? "*********" : $reg[0]['year']; ?></td>
  </tr> 
  <tr>
    <td>Part Number: <?php echo $reg[0]['nroparte'] == '' ? "*********" : $reg[0]['nroparte']; ?></td>
  </tr> 
  <tr>
    <td>Nº de Lote: <?php echo $reg[0]['lote'] == '' ? "*********" : $reg[0]['lote']; ?></td>
  </tr> 
  <tr>
    <td>Peso: <?php echo $reg[0]['peso'] == '' ? "*********" : $reg[0]['peso']; ?></td>
  </tr>  
  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
  <tr>
    <td>Precio de Compra: <?php echo $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ','); ?></td>
  </tr>
  <?php } ?> 
  <tr>
    <td>Precio de Venta Menor: <?php echo $simbolo.number_format($reg[0]['precioxmenor'], 2, '.', ','); ?> <?php echo $var1 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxmenor']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr> 
  <tr>
    <td>Precio de Venta Mayor: <?php echo $simbolo.number_format($reg[0]['precioxmayor'], 2, '.', ','); ?> <?php echo $var2 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxmayor']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr> 
  <tr>
    <td>Precio de Venta Publico: <?php echo $simbolo.number_format($reg[0]['precioxpublico'], 2, '.', ','); ?> <?php echo $var3 = ($reg[0]['montocambio'] == '' ? "" : "(".$reg[0]['simbolo2']."".number_format($reg[0]['precioxpublico']/$reg[0]['montocambio'], 2, '.', ',').")"); ?></td>
  </tr> 
  <tr>
    <td>Existencia: <?php echo $reg[0]['existencia']; ?></td>
  </tr> 
  <tr>
    <td>Stock Óptimo: <?php echo $reg[0]['stockoptimo'] == '0' ? "*********" : $reg[0]['stockoptimo']; ?></td>
  </tr> 
  <tr>
    <td>Stock Medio: <?php echo $reg[0]['stockmedio'] == '0' ? "*********" : $reg[0]['stockmedio']; ?></td>
  </tr> 
  <tr>
    <td>Stock Minimo: <?php echo $reg[0]['stockminimo'] == '0' ? "*********" : $reg[0]['stockminimo']; ?></td>
  </tr> 
  <tr>
    <td><?php echo $impuesto; ?>: <?php echo $reg[0]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td>Descuento: <?php echo number_format($reg[0]['descproducto'], 2, '.', ',')."%"; ?></td>
  </tr> 
  <tr>
    <td>Código de Barra: <?php echo $reg[0]['codigobarra'] == '' ? "*********" : $reg[0]['codigobarra']; ?></td>
  </tr> 
  <tr>
    <td>Fecha de Elaboración: <?php echo $reg[0]['fechaelaboracion'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaelaboracion'])); ?></td>
  </tr> 
  <tr>
    <td>Fecha de Exp. Óptimo: <?php echo $reg[0]['fechaoptimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaoptimo'])); ?></td>
  </tr>
  <tr>
    <td>Fecha de Exp. Medio: <?php echo $reg[0]['fechamedio'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechamedio'])); ?></td>
  </tr>
  <tr>
    <td>Fecha de Exp. Minimo: <?php echo $reg[0]['fechaminimo'] == '0000-00-00' ? "*********" : date("d-m-Y",strtotime($reg[0]['fechaminimo'])); ?></td>
  </tr>
  <tr>
    <td>Status: <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr> 
  <tr>
    <td>Proveedor: <?php echo $reg[0]['cuitproveedor'].": ".$reg[0]['nomproveedor']; ?></td>
  </tr> 
  <?php if ($_SESSION['acceso'] == "administradorG") { ?>
  <tr>
    <td>Sucursal: <?php echo $reg[0]['nomsucursal']; ?></td>  
  </tr>
  <?php } ?>
</table>
<?php 
} 
########################## MOSTRAR PRODUCTOS EN VENTANA MODAL ##########################
?>

<?php 
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
if (isset($_GET['BuscaProductoxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
} else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "<strong>".$cambio[0]['simbolo']."</strong>");
  
$reg = $new->ListarProductos();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos al Cambio de <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div4"><table id="datatable-responsive" class="table table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                   <thead>
                   <tr role="row">
                      <th>N°</th>
                      <th>Código</th>
                      <th>Nombre de Producto</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th><?php echo $impuesto; ?></th>
                      <th>Dcto %</th>
                      <th>Existencia</th>
                      <th>P. Compra <?php echo $cambio[0]['siglas']; ?></th>
                      <th>P. Mayor <?php echo $cambio[0]['siglas']; ?></th>
                      <th>P. Menor <?php echo $cambio[0]['siglas']; ?></th>
                      <th>P. Público <?php echo $cambio[0]['siglas']; ?></th>
                   </tr>
                   </thead>
                   <tbody class="BusquedaRapida">

<?php
if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

} else {

$a=1;
$TotalCompra=0;
$TotalMayor=0;
$TotalMenor=0;
$TotalPublico=0;
$TotalMonedaCompra=0;
$TotalMonedaMayor=0;
$TotalMonedaMenor=0;
$TotalMonedaPublico=0;
$TotalArticulos=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$simbolo2 = ($reg[$i]['simbolo2'] == "" ? "" : "<strong>".$reg[$i]['simbolo2']."</strong>");

$TotalCompra+=number_format($reg[$i]['preciocompra'], 2, '.', ',');
$TotalMayor+=number_format($reg[$i]['precioxmayor'], 2, '.', '');
$TotalMenor+=number_format($reg[$i]['precioxmenor'], 2, '.', '');
$TotalPublico+=number_format($reg[$i]['precioxpublico'], 2, '.', '');

$TotalMonedaCompra+=number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',');
$TotalMonedaMayor+=number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaMenor+=number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', '');
$TotalMonedaPublico+=number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', '');
$TotalArticulos+=$reg[$i]['existencia'];
?>
          <tr role="row" class="odd">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['nommodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo $reg[$i]['ivaproducto'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
          <td><?php echo $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
          <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmayor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
          <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxmenor']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
          <td><?php echo $tipo_simbolo.number_format($reg[$i]['precioxpublico']/$cambio[0]['montocambio'], 2, '.', ','); ?></td>
                </tr>
          <?php } ?>
          <tr class="text-dark alert-link">
          <td colspan="7"></td>
          <td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
          <td><?php echo $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ','); ?></td>
          <td><?php echo $tipo_simbolo.number_format($TotalMonedaMayor, 2, '.', ','); ?></td>
          <td><?php echo $tipo_simbolo.number_format($TotalMonedaMenor, 2, '.', ','); ?></td>
          <td><?php echo $tipo_simbolo.number_format($TotalMonedaPublico, 2, '.', ','); ?></td>
          </tr>
          <?php } ?>
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
########################### BUSQUEDA DE PRODUCTOS POR MONEDA ##########################
?>


<?php 
######################## BUSQUEDA DE KARDEX POR PRODUCTO ########################
if (isset($_GET['BuscaKardexProducto']) && isset($_GET['codsucursal']) && isset($_GET['codproducto'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codproducto = limpiar($_GET['codproducto']); 

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codproducto=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PRODUCTO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
   } else {

$detalle = new Login();
$detalle = $detalle->DetalleProductosKardex();
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexProducto();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos del Producto <?php echo $detalle[0]['codproducto'].": ".$detalle[0]['producto']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&tipo=<?php echo encrypt("KARDEXPRODUCTO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codproducto=<?php echo $codproducto; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXPRODUCTO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Realizado por</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
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
                              <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
      <td><?php echo $kardex[$i]['movimiento']; ?></td>
      <td><?php echo $kardex[$i]['entradas']; ?></td>
      <td><?php echo $kardex[$i]['salidas']; ?></td>
      <td><?php echo $kardex[$i]['devolucion']; ?></td>
      <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
      <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
      <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
      <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
      <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
      <?php } else { ?>
      <td><?php echo number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
      <?php } ?>
      <td><?php echo $kardex[$i]['stockactual']; ?></td>
      <td><?php echo $kardex[$i]['documento']; ?></td>
      <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
      </tr>
      <?php  }  ?>
                              </tbody>
                          </table>
                        
          Detalles de Producto<br>
          Código: <?php echo $kardex[0]['codproducto']; ?><br>
          Descripción: <?php echo $detalle[0]['producto']; ?><br>
          Presentación: <?php echo $detalle[0]['nompresentacion']; ?><br>
          Marca: <?php echo $detalle[0]['nommarca']; ?><br>
          Modelo: <?php echo $detalle[0]['nommodelo'] == '' ? "*****" : $detalle[0]['nommodelo']; ?><br>
          Total Entradas: <?php echo $TotalEntradas; ?><br>
          Total Salidas: <?php echo $TotalSalidas; ?><br>
          Total Devolución: <?php echo $TotalDevolucion; ?><br>
          Existencia: <?php echo $detalle[0]['existencia']; ?><br>
          Precio Compra: <?php echo $simbolo." ".number_format($detalle[0]['preciocompra'], 2, '.', ','); ?><br>
          P. Venta Menor: <?php echo $simbolo." ".number_format($detalle[0]['precioxmenor'], 2, '.', ','); ?><br>
          P. Venta Mayor: <?php echo $simbolo." ".number_format($detalle[0]['precioxmayor'], 2, '.', ','); ?><br>
          P. Venta Público: <?php echo $simbolo." ".number_format($detalle[0]['precioxpublico'], 2, '.', ','); ?>

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
######################## BUSQUEDA DE KARDEX POR PRODUCTO ########################
?>

<?php 
########################### BUSQUEDA PRODUCTOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
if (isset($_GET['BuscaProductosValorizadoxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarProductosValorizadoxFechas();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Valorizado por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Nº</th>
                  <th>Código</th>
                  <th>Descripción de Producto</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Desc</th>
                  <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
                  <th>Precio Compra</th>
                  <?php } ?>
                  <th>Precio de Venta</th>
                  <th>Vendido</th>
                  <th>Total Venta</th>
                  <th>Total Compra</th>
                  <th>Ganancias</th>
                </tr>
              </thead>
              <tbody>
<?php
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
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

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
          <tr>
          <td><?php echo $a++; ?></div></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
          <td><?php echo $reg[$i]['nommarca']; ?></td>
          <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
          <?php } ?>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
          </tr>
          <?php } ?>
          <tr class="text-dark alert-link">
            <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
            <td colspan="8"></td>
            <?php } else { ?>
            <td colspan="7"></td>
            <?php } ?>
            <td><?php echo number_format($VendidosTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
          </tr>
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
########################### BUSQUEDA PRODUCTOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
?>

<?php 
######################## BUSQUEDA DE PRODUCTOS VENDIDOS ########################
if (isset($_GET['BuscaProductosVendidos']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarProductosVendidosxFechas();  
?>
 
<!-- Row -->
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Productos Vendidos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PRODUCTOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

    <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Nº</th>
                <th>Código</th>
                <th>Descripción de Producto</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Precio de Venta</th>
                <th>Existencia</th>
                <th>Vendido</th>
                <th><?php echo $impuesto; ?></th>
                <th>Desc %</th>
                <th>Monto Total</th>
              </tr>
            </thead>
            <tbody>
<?php
$a=1;
$PrecioVentaTotal = 0;
$ExisteTotal      = 0;
$VendidosTotal    = 0;
$TotalDescuento   = 0;
$TotalImpuesto    = 0;
$TotalGeneral     = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioVentaTotal += $reg[$i]['precioventa'];
$ExisteTotal      += $reg[$i]['existencia'];
$VendidosTotal    += $reg[$i]['cantidad'];

$Descuento        = $reg[$i]['descproducto']/100;
$PrecioDescuento  = $reg[$i]['precioventa']*$Descuento;
//$CalculoDescuento = $PrecioDescuento*$reg[$i]['cantidad'];
$CalculoDescuento = number_format($reg[$i]['totaldescuentov'], 2, '.', '');
$PrecioFinal      = $reg[$i]['precioventa']-$PrecioDescuento;

$ivg              = $reg[$i]['ivaproducto']/100;
$CalculoImpuesto  = number_format($reg[$i]['subtotalimpuestos'], 2, '.', '');

// valortotal_sum es el total real de línea (con IVA y descuento ya aplicados) que coincide con total en ventas
$LineaTotal = floatval($reg[$i]['valortotal_sum']);

$TotalDescuento += $CalculoDescuento; 
$TotalImpuesto  += $CalculoImpuesto; 
$TotalGeneral   += $LineaTotal; 
?>
          <tr>
            <td><?php echo $a++; ?></div></td>
            <td><?php echo $reg[$i]['codproducto']; ?></td>
            <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
            <td><?php echo $reg[$i]['nommarca']; ?></td>
            <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
            <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
            <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($CalculoImpuesto, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($CalculoDescuento, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($LineaTotal, 2, '.', ','); ?></td>
          </tr>
          <?php } ?>
          <tr class="text-dark alert-link">
            <td colspan="5"></td>
            <td><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($ExisteTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($VendidosTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></td>
          </tr>
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
######################## BUSQUEDA DE PRODUCTOS VENDIDOS ########################
?>

<?php
######################## BUSQUEDA DE VENTAS POR FAMILIA ########################
if (isset($_GET['BuscaVentasxFamilia']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']);
$hasta = limpiar($_GET['hasta']);

if($codsucursal=="") { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL</center></div>"; exit; }
if($desde=="") { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE</center></div>"; exit; }
if($hasta=="") { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA</center></div>"; exit; }
if(strtotime($desde) > strtotime($hasta)) { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA FIN</center></div>"; exit; }

$tra = new Login();
$reg = $tra->BuscarVentasxFamilia();
if(!is_array($reg)) { exit; }
?>
<div class="row"><div class="col-lg-12"><div class="card">
  <div class="card-header bg-danger"><h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Familia</h4></div>
  <div class="form-body"><div class="card-body">
  <div class="row"><div class="col-md-12">
    <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?> &nbsp;&nbsp;
    <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
  </div></div>
  <div class="table-responsive">
  <table id="datatable" class="table table-striped table-bordered border display">
    <thead><tr><th>#</th><th>Familia</th><th>Unidades Vendidas</th><th>Total</th></tr></thead>
    <tbody>
<?php $a=1; $TotalUnidades=0; $TotalMonto=0;
foreach($reg as $r):
  $simbolo = ($r['simbolo'] != '' ? '<strong>'.$r['simbolo'].'</strong>' : '');
  $TotalUnidades += $r['cantidad'];
  $TotalMonto    += $r['total'];
?>
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo ($r['nomfamilia'] != '' ? $r['nomfamilia'] : '(Sin familia)'); ?></td>
        <td><?php echo number_format($r['cantidad'],2,'.',','); ?></td>
        <td><?php echo $simbolo.number_format($r['total'],2,'.',','); ?></td>
      </tr>
<?php endforeach; ?>
      <tr class="text-dark alert-link font-weight-bold">
        <td colspan="2"><strong>TOTAL</strong></td>
        <td><?php echo number_format($TotalUnidades,2,'.',','); ?></td>
        <td><?php echo $simbolo.number_format($TotalMonto,2,'.',','); ?></td>
      </tr>
    </tbody>
  </table></div>
  </div></div>
</div></div></div>
<?php }
######################## BUSQUEDA DE VENTAS POR FAMILIA ########################
?>

<?php
######################## BUSQUEDA DE VENTAS POR CATEGORIA ########################
if (isset($_GET['BuscaVentasxCategoria']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']);
$hasta = limpiar($_GET['hasta']);

if($codsucursal=="") { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL</center></div>"; exit; }
if($desde=="") { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE</center></div>"; exit; }
if($hasta=="") { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA</center></div>"; exit; }
if(strtotime($desde) > strtotime($hasta)) { echo "<div class='alert alert-danger'><center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA FIN</center></div>"; exit; }

$tra = new Login();
$reg = $tra->BuscarVentasxCategoria();
if(!is_array($reg)) { exit; }
?>
<div class="row"><div class="col-lg-12"><div class="card">
  <div class="card-header bg-danger"><h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Categoría</h4></div>
  <div class="form-body"><div class="card-body">
  <div class="row"><div class="col-md-12">
    <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?> &nbsp;&nbsp;
    <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
  </div></div>
  <div class="table-responsive">
  <table id="datatable" class="table table-striped table-bordered border display">
    <thead><tr><th>#</th><th>Familia</th><th>Categoría</th><th>Unidades Vendidas</th><th>Total</th></tr></thead>
    <tbody>
<?php $a=1; $TotalUnidades=0; $TotalMonto=0;
foreach($reg as $r):
  $simbolo = ($r['simbolo'] != '' ? '<strong>'.$r['simbolo'].'</strong>' : '');
  $TotalUnidades += $r['cantidad'];
  $TotalMonto    += $r['total'];
?>
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo ($r['nomfamilia'] != '' ? $r['nomfamilia'] : '(Sin familia)'); ?></td>
        <td><?php echo ($r['nomsubfamilia'] != '' ? $r['nomsubfamilia'] : '(Sin categoría)'); ?></td>
        <td><?php echo number_format($r['cantidad'],2,'.',','); ?></td>
        <td><?php echo $simbolo.number_format($r['total'],2,'.',','); ?></td>
      </tr>
<?php endforeach; ?>
      <tr class="text-dark alert-link font-weight-bold">
        <td colspan="3"><strong>TOTAL</strong></td>
        <td><?php echo number_format($TotalUnidades,2,'.',','); ?></td>
        <td><?php echo $simbolo.number_format($TotalMonto,2,'.',','); ?></td>
      </tr>
    </tbody>
  </table></div>
  </div></div>
</div></div></div>
<?php }
######################## BUSQUEDA DE VENTAS POR CATEGORIA ########################
?>

<?php
######################## BUSQUEDA DE ARQUEOS POR CAJA ########################
if (isset($_GET['BuscaArqueosxCaja']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

$codsucursal = limpiar($_GET['codsucursal']);
$codcaja     = limpiar($_GET['codcaja']);
$desde       = limpiar($_GET['desde']);
$hasta       = limpiar($_GET['hasta']);

if($codsucursal == "") {
  echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL</center></div>";
  exit;
} elseif($codcaja == "") {
  echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA</center></div>";
  exit;
} elseif($desde == "") {
  echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE</center></div>";
  exit;
} elseif($hasta == "") {
  echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA</center></div>";
  exit;
} elseif(strtotime($desde) > strtotime($hasta)) {
  echo "<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA FIN</center></div>";
  exit;
} else {

$tra  = new Login();
$regs = $tra->BuscarArqueosxCaja();
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Sesiones de Caja</h4>
      </div>
      <div class="form-body">
        <div class="card-body">
<?php if($regs == "") { ?>
  <div class="alert alert-warning"><center><span class="fa fa-info-circle"></span> NO SE ENCONTRARON SESIONES EN EL RANGO SELECCIONADO</center></div>
<?php } else { ?>
  <div class="table-responsive">
  <table id="datatable" class="table table-striped table-bordered border display">
    <thead>
      <tr>
        <th>#</th>
        <th>Caja</th>
        <th>Cajero</th>
        <th>Apertura</th>
        <th>Cierre</th>
        <th>Estado</th>
        <th>Unidades Vendidas</th>
        <th>Productos Distintos</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
<?php $a=1; foreach($regs as $r): ?>
      <tr>
        <td><?php echo $a++; ?></td>
        <td><?php echo $r['nrocaja'].': '.$r['nomcaja']; ?></td>
        <td><?php echo $r['nombres']; ?></td>
        <td><?php echo date('d-m-Y H:i:s', strtotime($r['fechaapertura'])); ?></td>
        <td><?php echo ($r['fechacierre'] ? date('d-m-Y H:i:s', strtotime($r['fechacierre'])) : '---'); ?></td>
        <td><?php echo ($r['statusarqueo'] == '1' ? "<span class='badge badge-success'>ABIERTA</span>" : "<span class='badge badge-danger'>CERRADA</span>"); ?></td>
        <td><strong><?php echo number_format($r['total_items'], 2, '.', ','); ?></strong></td>
        <td><?php echo number_format($r['total_productos'], 0, '.', ','); ?></td>
        <td>
          <button class="btn btn-sm btn-danger" onclick="VerProductosArqueo('<?php echo encrypt($r['codarqueo']); ?>')">
            <span class="fa fa-list"></span> Ver Productos
          </button>
          <a class="btn btn-sm btn-light" href="reportepdf?codarqueo=<?php echo encrypt($r['codarqueo']); ?>&tipo=<?php echo encrypt('TICKETCIERRE'); ?>" target="_blank" rel="noopener noreferrer">
            <span class="fa fa-file-pdf-o text-dark"></span> Ticket
          </a>
        </td>
      </tr>
<?php endforeach; ?>
    </tbody>
  </table>
  </div>
<?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal para productos del arqueo -->
<div id="modalProductosArqueo" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h4 class="modal-title text-white"><i class="fa fa-list"></i> Productos Vendidos en la Sesión</h4>
        <button type="button" class="close" data-dismiss="modal"><img src="assets/images/close.png"/></button>
      </div>
      <div class="modal-body" id="contenidoProductosArqueo"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
      </div>
    </div>
  </div>
</div>
<script>
function VerProductosArqueo(codarqueo) {
  $('#contenidoProductosArqueo').html('<center><i class="fa fa-spinner fa-spin fa-2x"></i></center>');
  $('#modalProductosArqueo').modal('show');
  $.get('funciones?BuscaProductosArqueoModal=si&codarqueo=' + codarqueo, function(data) {
    $('#contenidoProductosArqueo').html(data);
  });
}
</script>
<?php } }
######################## BUSQUEDA DE ARQUEOS POR CAJA ########################
?>

<?php
######################## DETALLE PRODUCTOS ARQUEO (MODAL) ########################
if (isset($_GET['BuscaProductosArqueoModal']) && isset($_GET['codarqueo'])) {
  $prd = new Login();
  $prd = $prd->ProductosVendidosxArqueo();
  if(empty($prd)) {
    echo "<div class='alert alert-warning'><center>No se registraron productos en esta sesión.</center></div>";
  } else {
?>
<div class="table-responsive">
<table class="table table-sm table-striped table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Código</th>
      <th>Producto</th>
      <th>Descripción</th>
      <th class="text-right">Precio Unit.</th>
      <th class="text-right">Unidades</th>
      <th class="text-right">Subtotal</th>
    </tr>
  </thead>
  <tbody>
<?php $a=1; $totalUnd=0; $totalSub=0; foreach($prd as $p):
  $simb = ($p['simbolo'] != '' ? '<strong>'.$p['simbolo'].'</strong>' : '');
  $totalUnd += $p['cantidad'];
  $totalSub += $p['subtotal'];
?>
    <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo $p['codproducto']; ?></td>
      <td><?php echo $p['producto']; ?></td>
      <td><?php echo $p['descripcion']; ?></td>
      <td class="text-right"><?php echo $simb.number_format($p['precioventa'],2,'.',','); ?></td>
      <td class="text-right"><strong><?php echo number_format($p['cantidad'],2,'.',','); ?></strong></td>
      <td class="text-right"><?php echo $simb.number_format($p['subtotal'],2,'.',','); ?></td>
    </tr>
<?php endforeach; ?>
    <tr class="font-weight-bold">
      <td colspan="4"></td>
      <td class="text-right">TOTAL:</td>
      <td class="text-right"><?php echo number_format($totalUnd,2,'.',','); ?></td>
      <td class="text-right"><?php echo $simb.number_format($totalSub,2,'.',','); ?></td>
    </tr>
  </tbody>
</table>
</div>
<?php } }
######################## DETALLE PRODUCTOS ARQUEO (MODAL) ########################
?>



















<?php 
########################## MOSTRAR FOTO DE COMBO EN VENTANA MODAL ##########################
if (isset($_GET['BuscaFotoComboModal']) && isset($_GET['codcombo']) && isset($_GET['codsucursal'])) { 

$new = new Login();
$reg = $new->CombosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>"); 
?>
    <center>
    <div class="row">
      <div class="col-md-12">
        <?php
        if (file_exists("fotos/combos/".$reg[0]["codsucursal"]."_".$reg[0]["codcombo"].".jpg")){
          echo "<img src='fotos/combos/".$reg[0]["codsucursal"]."_".$reg[0]["codcombo"].".jpg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/combos/".$reg[0]["codsucursal"]."_".$reg[0]["codcombo"].".jpeg")){
          echo "<img src='fotos/combos/".$reg[0]["codsucursal"]."_".$reg[0]["codcombo"].".jpeg?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else if (file_exists("fotos/combos/".$reg[0]["codsucursal"]."_".$reg[0]["codcombo"].".png")){   
          echo "<img src='fotos/combos/".$reg[0]["codsucursal"]."_".$reg[0]["codcombo"].".png?' class='rounded-circle' style='margin:0px;' width='240' height='240'>";
        } else {
          echo "<img src='fotos/img.png' class='rounded-circle' style='margin:0px;' width='50' height='40'>";  
        } 
        ?>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Nombre de Combo" class="alert-link"><?php echo $reg[0]['nomcombo']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Código de Combo" class="alert-link"><?php echo $reg[0]['codcombo']; ?></abbr>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <abbr title="Precio de Venta" class="alert-link"><?php echo $simbolo.number_format($reg[0]['precioventa'], 2, '.', ','); ?></abbr>

      </div>
    </div>
    </center>
                            
<?php 
  }
############################# MOSTRAR FOTO DE COMBO EN VENTANA MODAL #############################
?>

<?php
######################## MOSTRAR COMBOS EN VENTANA MODAL ########################
if (isset($_GET['BuscaComboModal']) && isset($_GET['codcombo']) && isset($_GET['codsucursal'])) { 

$reg = $new->CombosPorId(); 
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Código: <?php echo $reg[0]['codcombo']; ?></td>
  </tr>
  <tr>
    <td>Nombre de Combo: <?php echo $reg[0]['nomcombo']; ?></td>
  </tr>
  <tr>
    <td>Familia:  <?php echo $reg[0]['nomfamilia']; ?></td>
  </tr> 
  <tr>
    <td>Precio de Compra:  <?php echo $preciocompra = ($_SESSION['acceso'] == "cajero" || $_SESSION["acceso"]=="cocinero" ? "**********" : $simbolo.number_format($reg[0]['preciocompra'], 2, '.', ',')); ?></td>
  </tr> 
  <tr>
    <td>Precio de Venta:  <?php echo $simbolo.number_format($reg[0]['precioventa'], 2, '.', ','); ?></td>
  </tr>
<?php if($reg[0]['montocambio']!=""){ ?>
  <tr>
    <td><?php echo "Precio ".$reg[0]['siglas']; ?>:  
      <?php echo "<label>".$reg[0]['simbolo2']."</label> ".number_format($reg[0]['precioventa']/$reg[0]['montocambio'], 2, '.', ','); ?></td>
  </tr> 
<?php } ?>
  <tr>
    <td>Existencia:  <?php echo number_format($reg[0]['existencia'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Stock Minimo:  <?php echo $reg[0]['stockminimo'] == '0.00' ? "******" : number_format($reg[0]['stockminimo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td>Stock Máximo:  <?php echo $reg[0]['stockmaximo'] == '0.00' ? "******" : number_format($reg[0]['stockmaximo'], 2, '.', ','); ?></td>
  </tr> 
  <tr>
    <td><?php echo $impuesto; ?>:  <?php echo $reg[0]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
  </tr> 
  <tr>
    <td>Descuento:  <?php echo number_format($reg[0]['desccombo'], 2, '.', ',')."%"; ?></td>
  </tr> 
  <tr>
    <td>Status:  <?php echo $status = ( $reg[0]['existencia'] != 0 ? "<span class='badge badge-success'><i class='fa fa-check'></i> ACTIVO</span>" : "<span class='badge badge-warning'><i class='fa fa-times'></i> INACTIVO</span>"); ?></td>
  </tr>
    
  <?php if($_SESSION['acceso'] == "administradorG") { ?>
  <tr>
    <td>Sucursal Asignada:  <?php echo $reg[0]['codsucursal'] == "0" ? "**********" : $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
  <?php } ?>
</table>

<?php 
$tru = new Login();
$a=1;
$busq = $tru->VerDetallesProductos(); 

if($busq==""){

  echo "";      
    
} else {
?>
<div id="div1">
  <table id="default_order" class="table2 table-striped table-bordered border display m-t-10">
        <thead>
        <tr>
        <th colspan="6" data-priority="1"><center>Productos Agregados</center></th>
        </tr>
        <tr>
          <th>Nº</th>
          <th>Producto</th>
          <th>Presentación</th>
          <th>Existencia</th>
          <th>Cantidad</th>
          <th>P.V.P</th>
        </tr>
        </thead>
        <tbody>
<?php 
$TotalCosto=0;
for($i=0;$i<sizeof($busq);$i++){
$TotalCosto+=($busq[$i]['precioventa']-$busq[$i]['descproducto']/100)*$busq[$i]["cantidad"];
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td class="text-left"><h5 class="text-dark alert-link"><?php echo $busq[$i]['producto']; ?></h5>
    <small>MARCA (<?php echo $busq[$i]['codmarca'] == '0' ? "*****" : $busq[$i]['nommarca'] ?>) - MODELO (<?php echo $busq[$i]['codmodelo'] == '0' ? "*****" : $busq[$i]['nommodelo'] ?>)</small></td>
    <td><?php echo $busq[$i]["codpresentacion"] == 0 ? "*****" : $busq[$i]["nompresentacion"]; ?></td>
    <td><?php echo number_format($busq[$i]["existencia"], 2, '.', ','); ?></td>
    <td><?php echo number_format($busq[$i]["cantidad"], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($busq[$i]["precioventa"], 2, '.', ','); ?></td>
  </tr> 
  <?php } ?> 
  <tr class="text-dark alert-link">
    <td colspan="4"></td>
    <td><label>Total Gasto</label></td>
    <td><label><?php echo $simbolo.number_format($TotalCosto, 2, '.', ','); ?></label></td>
  </tr>
  </tbody>
  </table>
  </div>
<?php  
  }
} 
######################## MOSTRAR COMBOS EN VENTANA MODAL ########################
?>

<?php 
######################## MUESTRA PRODUCTOS AGREGADOS A COMBOS ########################
if (isset($_GET['BuscaDetallesCombo']) && isset($_GET['codcombo']) && isset($_GET['codsucursal'])) { 
$new = new Login();
$reg = $new->CombosPorId();   
?>
<table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
      <thead>
      <tr role="row">
      </tr>
      <tr>
        <th>Nº</th>
        <th>Producto</th>
        <th>Presentación</th>
        <th>Existencia</th>
        <th>Cantidad</th>
        <th>Precio Compra</th>
        <th>Precio Venta</th>
        <th><span class="mdi mdi-drag-horizontal"></span></th>
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

for($i=0;$i<sizeof($busq);$i++){
?>
  <tr class="warning-element text-dark alert-link" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td><?php echo $a++; ?></td>
    <td class="text-left"><h5 class="text-dark alert-link"><?php echo $busq[$i]['producto']; ?></h5>
    <small>MARCA (<?php echo $busq[$i]['codmarca'] == '0' ? "*****" : $busq[$i]['nommarca'] ?>) - MODELO (<?php echo $busq[$i]['codmodelo'] == '0' ? "*****" : $busq[$i]['nommodelo'] ?>)</small></td>
    <td><?php echo $busq[$i]["codpresentacion"] == 0 ? "*****" : $busq[$i]["nompresentacion"]; ?></td>
    <td><?php echo $busq[$i]["existencia"]; ?></td>
    <td><?php echo $busq[$i]["cantidad"]; ?></td>
    <td><?php echo number_format($busq[$i]["preciocompra"], 2, '.', ','); ?></td>
    <td><?php echo number_format($busq[$i]["precioventa"], 2, '.', ','); ?></td>
    <td><button type="button" class="btn btn-dark btn-rounded" onClick="EliminaDetalleCombo('<?php echo encrypt($busq[$i]['codcombo']); ?>','<?php echo encrypt($busq[$i]['idproducto']); ?>','<?php echo encrypt($busq[$i]['codproducto']); ?>','<?php echo encrypt($busq[$i]['cantidad']); ?>','<?php echo encrypt($busq[$i]['codsucursal']); ?>','<?php echo encrypt("ELIMINADETALLECOMBO"); ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td>
  </tr><?php } } ?>
  </tbody>
  </table>
<?php 
}
######################## MUESTRA PRODUCTOS AGREGADOS A COMBOS ########################
?>

<?php 
######################## BUSQUEDA DE COMBOS POR MONEDA ########################
if (isset($_GET['BuscaCombosxMoneda']) && isset($_GET['codsucursal']) && isset($_GET['codmoneda'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codmoneda = limpiar($_GET['codmoneda']);

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codmoneda=="") { 

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE MONEDA PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
   } else {

$cambio = new Login();
$cambio = $cambio->BuscarTiposCambios();
$tipo_simbolo = ($cambio[0]['codmoneda'] == '' ? " " : "".$cambio[0]['simbolo']."");
  
$reg = $new->ListarCombos();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos al Cambio de <?php echo $cambio[0]['moneda']." (".$cambio[0]['siglas'].")"; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmoneda=<?php echo $codmoneda; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSXMONEDA") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-responsive" class="table table-hover table-nomargin table-bordered dataTable table-striped" cellspacing="0" width="100%">
                                          <thead>
                                          <tr role="row">
                                            <th>N°</th>
                                            <th>Código</th>
                                            <th>Nombre de Combo</th>
                                            <th><?php echo $impuesto; ?></th>
                                            <th>Desc %</th>
                                            <th>Detalles de Productos</th>
                                            <th>Existencia</th>
                                            <th>Precio Compra <?php echo $cambio[0]['siglas']; ?></th>
                                            <th>Precio Venta <?php echo $cambio[0]['siglas']; ?></th>
                                            </tr>
                                            </thead>
                                            <tbody class="BusquedaRapida">

<?php
if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMBOS ACTUALMENTE EN LA SUCURSAL SELECCIONADA </center>";
    echo "</div>";    

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
          <tr role="row" class="odd">
          <td><?php echo $a++; ?></td>
          <td><?php echo $reg[$i]['codcombo']; ?></td>
          <td><?php echo $reg[$i]['nomcombo']; ?></td>
          <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
          <td><?php echo $reg[$i]['ivacombo'] == 'SI' ? number_format($valor, 2, '.', ',')."%" : "(E)"; ?></td>
          <td><?php echo number_format($reg[$i]['desccombo'],2, '.', ','); ?></td>
          <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
        <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
          <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $tipo_simbolo.number_format($reg[$i]['preciocompra']/$cambio[0]['montocambio'], 2, '.', ',') : "**********"); ?></td>
          <td><?php echo $tipo_simbolo.number_format($PrecioFinal/$cambio[0]['montocambio'], 2, '.', ''); ?></td>
          </tr>
          <?php } ?>
          <tr class="text-dark alert-link">
            <td colspan="7"></td>
            <td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
            <td><?php echo $pcompra = ($_SESSION['acceso'] == "administradorG" || $_SESSION["acceso"]=="administradorS" ? $tipo_simbolo.number_format($TotalMonedaCompra, 2, '.', ',') : "**********"); ?></td>
            <td><?php echo $tipo_simbolo.number_format($TotalMonedaVenta, 2, '.', ','); ?></td>
          </tr>
        <?php } ?>
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
######################## BUSQUEDA DE COMBOS POR MONEDA ##########################
?>


<?php 
######################## BUSQUEDA DE KARDEX POR COMBO ########################
if (isset($_GET['BuscaKardexCombo']) && isset($_GET['codsucursal']) && isset($_GET['codcombo'])) { 

  $codsucursal = limpiar($_GET['codsucursal']);
  $codcombo = limpiar($_GET['codcombo']); 

  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codcombo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL COMBO CORRECTAMENTE</center>";
  echo "</div>";
  exit;
   
  } else {
  
$kardex = new Login();
$kardex = $kardex->BuscarKardexCombo(); 

$detalle = new Login();
$detalle = $detalle->DetalleKardexCombo(); 
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos del Combo <?php echo $detalle[0]['codcombo'].": ".$detalle[0]['nomcombo']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcombo=<?php echo $codcombo; ?>&tipo=<?php echo encrypt("KARDEXCOMBO") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcombo=<?php echo $codcombo; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("KARDEXCOMBO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcombo=<?php echo $codcombo; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("KARDEXCOMBO") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>

              </div>
            </div>
          </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                                  <th>Nº</th>
                                  <th>Realizado por</th>
                                  <th>Movimiento</th>
                                  <th>Entradas</th>
                                  <th>Salidas</th>
                                  <th>Devolución</th>
                                  <th>Precio Costo</th>
                                  <th>Costo Movimiento</th>
                                  <th>Stock Actual</th>
                                  <th>Documento</th>
                                  <th>Fecha de Kardex</th>
                              </tr>
                              </thead>
                              <tbody>
<?php
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
                              <tr>
      <td><?php echo $a++; ?></td>
      <td><?php echo $usuario = ($kardex[$i]['codigo'] == "0" ? "**********" : $kardex[$i]['dni'].": ".$kardex[$i]['nombres']); ?></td>
      <td><?php echo $kardex[$i]['movimiento']; ?></td>
      <td><?php echo number_format($kardex[$i]['entradas'], 2, '.', ','); ?></td>
      <td><?php echo number_format($kardex[$i]['salidas'], 2, '.', ','); ?></td>
      <td><?php echo number_format($kardex[$i]['devolucion'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($kardex[$i]['precio'], 2, '.', ','); ?></td>
      <?php if($kardex[$i]["movimiento"]=="ENTRADAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['entradas'], 2, '.', ','); ?></td>
      <?php } elseif($kardex[$i]["movimiento"]=="SALIDAS"){ ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['salidas'], 2, '.', ','); ?></td>
      <?php } else { ?>
        <td><?php echo $simbolo.number_format($kardex[$i]['precio']*$kardex[$i]['devolucion'], 2, '.', ','); ?></td>
      <?php } ?>
      <td><?php echo number_format($kardex[$i]['stockactual'], 2, '.', ','); ?></td>
      <td><?php echo $kardex[$i]['documento']." ".$num = ($kardex[$i]['documento'] == 'VENTA' || $kardex[$i]['documento'] == 'DEVOLUCION' ? $kardex[$i]['codproceso'] : ""); ?></td>
      <td><?php echo date("d-m-Y",strtotime($kardex[$i]['fechakardex'])); ?></td>
                              </tr>
                        <?php  }  ?>
                              </tbody>
                          </table>
                        
          <label>Detalles de Combo</label><br>
          <label>Código:</label> <?php echo $detalle[0]['codcombo']; ?><br>
          <label>Descripción:</label> <?php echo $detalle[0]['nomcombo']; ?><br>
          <label>Total Entradas:</label> <?php echo number_format($TotalEntradas, 2, ',', '.'); ?><br>
          <label>Total Salidas:</label> <?php echo number_format($TotalSalidas, 2, ',', '.'); ?><br>
          <label>Total Devolución:</label> <?php echo number_format($TotalDevolucion, 2, ',', '.'); ?><br>
          <label>Existencia:</label> <?php echo number_format($detalle[0]['existencia'], 2, ',', '.'); ?><br>
          <label>Precio Compra:</label> <?php echo $simbolo.number_format($detalle[0]['preciocompra'], 2, '.', ','); ?><br>
          <label>Precio Venta:</label> <?php echo $simbolo.number_format($detalle[0]['precioventa'], 2, '.', ','); ?>
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
######################## BUSQUEDA DE KARDEX POR COMBO ########################
?>


<?php 
########################### BUSQUEDA COMBOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
if (isset($_GET['BuscaCombosValorizadoxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
  if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarCombosValorizadoxFechas();  
?>
 
<!-- Row -->
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos Valorizado por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMBOSVALORIZADOXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSVALORIZADOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

    <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
        <thead>
          <tr role="row">
            <th>Nº</th>
            <th>Código</th>
            <th>Descripción de Combo</th>
            <th>Desc %</th>
            <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
            <th>Precio Compra</th>
            <?php } ?>
            <th>Precio de Venta</th>
            <th>Vendido</th>
            <th>Total Venta</th>
            <th>Total Compra</th>
            <th>Ganancias</th>
          </tr>
        </thead>
        <tbody>
<?php
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
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

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
          <tr role="row" class="odd">
          <td><?php echo $a++; ?></div></td>
          <td><?php echo $reg[$i]['codproducto']; ?></td>
          <td><?php echo $reg[$i]['producto']; ?></td>
          <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
          <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
          <td><?php echo $simbolo.number_format($reg[$i]['preciocompra'], 2, '.', ','); ?></td>
          <?php } ?>
          <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
          <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
          </tr>
          <?php } ?>
          <tr class="text-dark alert-link">
            <?php if($_SESSION['acceso']=="administradorG" || $_SESSION['acceso']=="administradorS"){ ?>
            <td colspan="6"></td>
            <?php } else { ?>
            <td colspan="5"></td>
            <?php } ?>
            <td><?php echo number_format($VendidosTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
          </tr>
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
########################### BUSQUEDA COMBOS VALORIZADO POR FECHAS Y VENDEDOR ##########################
?>


<?php 
######################## BUSQUEDA DE COMBOS VENDIDOS ########################
if (isset($_GET['BuscaCombosVendidos']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarCombosVendidosxFechas();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Combos Vendidos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMBOSVENDIDOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMBOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMBOSVENDIDOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>Nº</th>
                  <th>Código</th>
                  <th>Descripción de Combo</th>
                  <th>Precio de Venta</th>
                  <th>Existencia</th>
                  <th>Vendido</th>
                  <th><?php echo $impuesto; ?></th>
                  <th>Desc %</th>
                  <th>Monto Total</th>
                </tr>
              </thead>
              <tbody>
<?php
$a=1;
$PrecioVentaTotal = 0;
$ExisteTotal      = 0;
$VendidosTotal    = 0;
$TotalDescuento   = 0;
$TotalImpuesto    = 0;
$TotalGeneral     = 0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");

$PrecioVentaTotal += $reg[$i]['precioventa'];
$ExisteTotal      += $reg[$i]['existencia'];
$VendidosTotal    += $reg[$i]['cantidad'];

$Descuento        = $reg[$i]['descproducto']/100;
$PrecioDescuento  = $reg[$i]['precioventa']*$Descuento;
//$CalculoDescuento = $PrecioDescuento*$reg[$i]['cantidad'];
$CalculoDescuento = $reg[$i]['totaldescuentov'];
$PrecioFinal      = $reg[$i]['precioventa']-$PrecioDescuento;

$ivg              = $reg[$i]['ivaproducto']/100;
$CalculoImpuesto  = number_format($reg[$i]['subtotalimpuestos'], 2, '.', '');

$TotalDescuento += number_format($reg[$i]['totaldescuentov'], 2, '.', ''); 
$TotalImpuesto  += $CalculoImpuesto; 
$TotalGeneral   += $PrecioFinal*$reg[$i]['cantidad']; 
?>
          <tr>
            <td><?php echo $a++; ?></div></td>
            <td><?php echo $reg[$i]['codproducto']; ?></td>
            <td><?php echo $reg[$i]['producto']; ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
            <td><?php echo number_format($reg[$i]['existencia'], 2, '.', ','); ?></td>
            <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($CalculoImpuesto, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['ivaproducto'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($CalculoDescuento, 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
            <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
          </tr>
          <?php  }  ?>
          <tr class="text-dark alert-link">
            <td colspan="3"></td>
            <td><?php echo $simbolo.number_format($PrecioVentaTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($ExisteTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($VendidosTotal, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($TotalGeneral, 2, '.', ','); ?></td>
          </tr>
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
######################## BUSQUEDA DE COMBOS VENDIDOS ########################
?>































<?php
######################## MOSTRAR TRASPASOS EN VENTANA MODAL ########################
if (isset($_GET['BuscaTraspasoModal']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON TRASPASOS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <address>
  <h4><b class="text-dark">SUCURSAL REMITENTE</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?>
  <br/><?php echo $reg[0]['direcsucursal'] == '' ? "" : $reg[0]['direcsucursal']; ?> <?php echo $reg[0]['provincia'] == '' ? "" : $reg[0]['provincia']; ?> <?php echo $reg[0]['departamento'] == '' ? "" : strtoupper($reg[0]['departamento']); ?>
  <br/> EMAIL: <?php echo $reg[0]['correosucursal'] == '' ? "**********" : $reg[0]['correosucursal']; ?></p>

  <h4><b class="text-dark">Nº TRASPASO <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº DE TRACKING: <?php echo $reg[0]['numero_tracking']; ?>
  <br>FECHA DE TRASPASO: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso'])); ?>
  
  <br>ESTADO DE TRASPASO: 
  <?php if($reg[0]['estado_traspaso'] == 1){
  echo "<span class='badge badge-info'><i class='fa fa-info'></i> REGISTRADO</span>";
  } elseif($reg[0]['estado_traspaso'] == 2){
  echo "<span class='badge badge-info'><i class='fa fa-truck'></i> EN PROCESO</span>";
  } elseif($reg[0]['estado_traspaso'] == 3){
  echo "<span class='badge badge-info'><i class='fa fa-truck'></i> PENDIENTE</span>";
  } elseif($reg[0]['estado_traspaso'] == 4){
  echo "<span class='badge badge-success'><i class='fa fa-check'></i> RECIBIDO</span>";
  } elseif($reg[0]['estado_traspaso'] == 5){
  echo "<span class='badge badge-danger'><i class='fa fa-times-circle'></i> RECHAZADA</span>"; 
  } ?>
  <br/> OBSERVACIONES DE ENVIO: <?php echo $reg[0]['observaciones'] == '' ? "**********" : $reg[0]['observaciones']; ?>
  <br/> RESPONSABLE DE TRASLADO POR: <?php echo $reg[0]['nombres_responsable'] == "" ? "**********" : $reg[0]['nombres_responsable']; ?>
  <br/> RECIBIDO POR: <?php echo $reg[0]['persona_recibe'] == 0 ? "**********" : $reg[0]['persona_recibe']; ?>
  <br/> FECHA DE RECIBO: <?php echo $reg[0]['fecha_recibe'] == '' ? "**********" : date("d-m-Y H:i:s",strtotime($reg[0]['fechatraspaso'])); ?>
  <br/> OBSERVACIONES DE RECIBIDO: <?php echo $reg[0]['observaciones_recibido'] == '' ? "**********" : $reg[0]['observaciones_recibido']; ?>

  <?php if($reg[0]['sucursal_recibe'] == $_SESSION["codsucursal"]){ ?>
  <br/> SUMADO A STOCK AL RECIBIR: <?php echo $reg[0]['agregar_stock'] == '1' ? "<span class='badge badge-info alert-link font-16'> SI</span>" : "<span class='badge badge-warning alert-link font-16'> NO</span>"; ?>
  <?php } ?>

</p>
                                   </address>
                                </div>
                                <div class="pull-right text-right">
                                    <address>
  <h4><b class="text-dark">SUCURSAL DESTINATARIO</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomsucursal2']; ?>
  <br/> Nº <?php echo $reg[0]['documsucursal2'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitsucursal2']; ?> - TLF: <?php echo $reg[0]['tlfsucursal2']; ?>
  <br><?php echo $reg[0]['direcsucursal2'] == '' ? "" : $reg[0]['direcsucursal2']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : $reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['correosucursal2'] == '' ? "**********" : $reg[0]['correosucursal2'] ?></p>
                                    </address>
                                </div>
                            </div>

            <div class="col-md-12">
              <div class="table-responsive m-t-10" style="clear: both;">
              <table class="table table-hover">
              <thead>
              <tr>
                <th>#</th>
                <th>Descripción de Producto</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Valor Total</th>
                <th>Desc %</th>
                <th><?php echo $impuesto; ?></th>
                <th>Valor Neto</th>
                <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]['sucursal_envia'] == $_SESSION['codsucursal']) { ?>
                <th>Acción</th>
                <?php } ?>
              </tr>
              </thead>
              <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesTraspasos();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo number_format($detalle[$i]['cantidad'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]['sucursal_envia'] == $_SESSION['codsucursal']) { ?><td>
  <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoModal('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </div>
                    </div>

                        <div class="col-md-12">
                            <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                              <div class="clearfix"></div>
                              <hr>

                    <div class="col-md-12">
                        <div class="text-right">
 <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[0]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[0]['sucursal_envia']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                        </div>
                      </div>
                  </div>
                <!-- .row -->
<?php
  }
} 
######################## MOSTRAR TRASPASOS EN VENTANA MODAL ########################
?>


<?php
######################## MOSTRAR DETALLES DE TRASPASOS UPDATE ########################
if (isset($_GET['MuestraDetallesTraspasoUpdate']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
$detalle = $tra->VerDetallesTraspasos();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;   
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleTraspaso('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantidad[]" id="cantidad_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoTraspaso(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadbd[]" id="cantidadbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleTraspaso('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>  
  <td class="text-dark alert-link">
  <input type="hidden" name="coddetalletraspaso[]" id="coddetalletraspaso" value="<?php echo $detalle[$i]["coddetalletraspaso"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
  <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
  <?php echo $detalle[$i]['codproducto']; ?></td>  
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>  
  <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
  <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>
  <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></td>
  <td class="text-dark alert-link"><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
  <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
  <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>
  <td><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>
  <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">
  <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0"; ?>">
  <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0"; ?>">
  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >
  <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >
  <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoUpdate('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/> </td>
     </tr>
    </table>
  </div>
<?php
} 
######################## MOSTRAR DETALLES DE TRASPASOS UPDATE ########################
?>

<?php
######################## MOSTRAR DETALLES DE TRASPASOS AGREGAR ########################
if (isset($_GET['MuestraDetallesTraspasoAgregar']) && isset($_GET['codtraspaso']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->TraspasosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
            <table class="table table-hover">
            <thead>
            <tr>
              <th>Nº</th>
              <th>Código</th>
              <th>Descripción de Producto</th>
              <th>Cantidad</th>
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
$detalle = $tra->VerDetallesTraspasos();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td class="text-dark alert-link"><?php echo $a++; ?></td>   
  <td class="text-dark alert-link"><?php echo $detalle[$i]['codproducto']; ?></td>
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]["cantidad"], 2, '.', ''); ?></td>  
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>  
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetalleTraspasoAgregar('<?php echo encrypt($detalle[$i]["coddetalletraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codtraspaso"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLETRASPASO") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
  <h5><label>Exento 0%:</label></h5></td>
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
<?php
} 
######################## MOSTRAR DETALLES DE TRASPASOS AGREGRA ########################
?>

<?php
######################## BUSQUEDA TRASPASOS POR FECHAS ########################
if (isset($_GET['BuscaTraspasosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarTraspasosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Traspasos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("TRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Nº</th>
                          <th>N° de Traspaso</th>
                          <th>N° de Tracking</th>
                          <th>Sucursal Remitente</th>
                          <th>Sucursal Destinatario</th>
                          <th>Fecha Emisión</th>
                          <th>Estado</th>
                          <th>Nº de Articulos</th>
                          <th>Subtotal</th>
                          <th><?php echo $impuesto; ?></th>
                          <th>Desc%</th>
                          <th>Imp. Total</th>
                          <th><span class="mdi mdi-drag-horizontal"></span></th>
                        </tr>
                      </thead>
                      <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['numero_tracking']; ?></td>
  <td><?php echo $reg[$i]['cuitsucursal'].": <strong><br>".$reg[$i]['nomsucursal']."</strong>"; ?></td>
    <td><?php echo $reg[$i]['cuitsucursal2'].": <strong><br>".$reg[$i]['nomsucursal2']."</strong>"; ?></td>
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
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codtraspaso=<?php echo encrypt($reg[$i]['codtraspaso']); ?>&codsucursal=<?php echo encrypt($reg[$i]['sucursal_envia']); ?>&tipo=<?php echo encrypt("FACTURATRASPASO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
        </tr>
        <?php } ?>
        <tr class="text-dark alert-link">
          <td colspan="7"></td>
          <td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
          <td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
          </tr>
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
######################## BUSQUEDA TRASPASOS POR FECHAS ########################
?>


<?php
########################## BUSQUEDA DETALLES PRODUCTOS TRASPASOS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesTraspasosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA HASTA</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesTraspasosxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Traspasos por Fechas </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESTRASPASOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Nº</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Desc</th>
                            <th><?php echo $impuesto; ?></th>
                            <th>Precio de Venta</th>
                            <th>Existencia</th>
                            <th>Traspasado</th>
                            <th>Monto Total</th>
                          </tr>
                        </thead>
                        <tbody>
<?php
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
            <tr>
              <td><?php echo $a++; ?></td>
              <td><?php echo $reg[$i]['codproducto']; ?></td>
              <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
              <td><?php echo $reg[$i]['codmarca'] == '0' ? "**********" : $reg[$i]['nommarca']; ?></td>
              <td><?php echo $reg[$i]['codmodelo'] == '' ? "*****" : $reg[$i]['nommodelo']; ?></td>
              <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
              <td><?php echo $reg[$i]['ivaproducto'] != '0.00' ? number_format($reg[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
              <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
              <td><?php echo number_format($reg[$i]['existencia'], 2, ',', '.'); ?></td>
              <td><?php echo number_format($reg[$i]['cantidad'], 2, ',', '.'); ?></td>
              <td><?php echo $simbolo.number_format($PrecioFinal*$reg[$i]['cantidad'], 2, '.', ','); ?></td>
            </tr>
            <?php } ?>
            <tr class="text-dark alert-link">
              <td colspan="7"></td>
              <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
              <td><?php echo number_format($ExisteTotal, 2, ',', '.'); ?></td>
              <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></td>
              <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
            </tr>
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
########################## BUSQUEDA DETALLES PRODUCTOS TRASPASOS POR FECHAS ##########################
?>































<?php
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCompraPagadaModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº DE FACTURA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
  elseif($reg[0]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <?php if($reg[0]['fechavencecredito'] != "0000-00-00") { ?>
  <br>DIAS VENCIDOS:
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <?php echo $reg[0]['direcproveedor'] == '' ? "" : "<br/>".$reg[0]['direcproveedor']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "*******" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                        <th>#</th>
                        <th>Descripción de Producto</th>
                        <th>Cantidad</th>
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
$detalle = $tra->VerDetallesCompras();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto']; 
?>
                                                <tr>
    <td><?php echo $a++; ?></td>
    <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
    <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td><?php echo $detalle[$i]['cantcompra']; ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesComprasPagadasModal('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?></p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
<p><b>Gasto de Envio:</b> <?php echo $simbolo.number_format($reg[0]['gastoenvio'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total :</b> <?php echo $simbolo.number_format($reg[0]['totalpago']+$reg[0]['gastoenvio'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>
                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->

<?php
  }
} 
######################## MOSTRAR COMPRA PAGADA EN VENTANA MODAL ########################
?>

<?php
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL #######################
if (isset($_GET['BuscaCompraPendienteModal']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

if($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COMPRAS Y DETALLES ACTUALMENTE </center>";
  echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/>Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº DE FACTURA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">STATUS: 
  <?php if($reg[0]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statuscompra"]."</span>"; } 
  elseif($reg[0]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statuscompra"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statuscompra"]."</span>"; } ?>

  <br>TOTAL FACTURA: <?php echo $simbolo.number_format($reg[0]['totalpago']+$reg[0]['gastoenvio'], 2, '.', ','); ?>
  <br>TOTAL ABONO: <?php echo $simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','); ?>
  <br>TOTAL DEBE: <?php echo $simbolo.number_format($reg[0]['totalpago']+$reg[0]['gastoenvio']-$reg[0]['creditopagado'], 2, '.', ','); ?>
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fechaemision'])); ?>
  <br/> FECHA DE RECEPCIÓN: <?php echo date("d-m-Y",strtotime($reg[0]['fecharecepcion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">PROVEEDOR</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomproveedor'] == '' ? "*******" : $reg[0]['nomproveedor']; ?>,
  <?php echo $reg[0]['direcproveedor'] == '' ? "" : "<br/>".$reg[0]['direcproveedor']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailproveedor'] == '' ? "*******" : $reg[0]['emailproveedor']; ?>
  <br/> Nº <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['cuitproveedor'] == '' ? "*******" : $reg[0]['cuitproveedor']; ?> - TLF: <?php echo $reg[0]['tlfproveedor'] == '' ? "*******" : $reg[0]['tlfproveedor']; ?>
  <br/> VENDEDOR: <?php echo $reg[0]['vendedor']; ?> - TLF: <?php echo $reg[0]['tlfvendedor'] == '' ? "*******" : $reg[0]['tlfvendedor']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>

                                
                      <div class="col-md-12">
                          <div class="table-responsive m-t-10" style="clear: both;">
                      <table class="table table-hover">
                      <thead>
                        <tr><th colspan="4">Detalles de Abonos</th></tr>
                        <tr>
                        <th>#</th>
                        <th>Forma de Abono</th>
                        <th>Nombre de Banco</th>
                        <th>Nº de Comprobante</th>
                        <th>Monto de Abono</th>
                        <th>Fecha de Abono</th>
                      </tr>
                      </thead>
                      <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesAbonosCompras();

if($detalle==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ABONOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  

?>
  <tr class="text-dark">
    <td><?php echo $a++; ?></td>
    <td><?php echo $detalle[$i]['mediopago']; ?></td>
    <td><?php echo $banco = ($detalle[$i]['codbanco'] == 0 ? "******" : $detalle[$i]['nombanco']); ?></td>
    <td><?php echo $comprobante = ($detalle[$i]['comprobante'] == "" ? "******" : $detalle[$i]['comprobante']); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','); ?></td>
    <td><?php echo date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono'])); ?></td>
  </tr>
  <?php } } ?>
  </tbody>
  </table>
  </div>
  <hr>

            <div class="col-md-12">
              <div class="text-right">
 <a href="reportepdf?codcompra=<?php echo encrypt($reg[0]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-folder-open-o"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
              </div>
            </div>
          </div>                     
<?php
  }
} 
####################### MOSTRAR COMPRA PENDIENTE EN VENTANA MODAL ######################
?>


<?php
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
if (isset($_GET['MuestraDetallesComprasUpdate']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>

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
$detalle = $tra->VerDetallesCompras();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++; 
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleCompra('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="cantcompra[]" id="cantcompra_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCompra(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantcompra"], 2, '.', ''); ?>" title="Ingrese Cantidad">
  <input type="hidden" name="cantidadcomprabd[]" id="cantidadcomprabd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantcompra"], 2, '.', ''); ?>">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleCompra('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>
      
  <td class="text-dark alert-link">
  <input type="hidden" name="coddetallecompra[]" id="coddetallecompra" value="<?php echo $detalle[$i]["coddetallecompra"]; ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <?php echo $detalle[$i]['codproducto']; ?></td>
      
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['nommarca'] == '' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['nommodelo'] == '' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

  <td class="text-dark alert-link"><input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
  <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['preciocompra'], 2, '.', ''); ?></td>

  <td><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></label></td>
      
  <td class="text-dark alert-link">
  <input type="hidden" name="descfactura[]" id="descfactura_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descfactura"], 2, '.', ','); ?>">
  <input type="hidden" class="totaldescuentoc" name="totaldescuentoc[]" id="totaldescuentoc_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentoc"], 2, '.', ','); ?>">
  <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?></label><sup><?php echo number_format($detalle[$i]['descfactura'], 2, '.', ','); ?>%</sup></td>

  <td class="text-dark alert-link"><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>

  <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" > <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></label></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesComprasUpdate('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
<?php
} 
######################### MOSTRAR DETALLES DE COMPRAS UPDATE ##########################
?>




<?php
####################### MOSTRAR DETALLES DE COMPRAS AGREGAR #######################
if (isset($_GET['MuestraDetallesComprasAgregar']) && isset($_GET['codcompra']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->ComprasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
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
                        <?php if ($_SESSION['acceso'] == "administradorS") { ?>
                        <th>Acción</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCompras();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr>
    <td class="text-dark alert-link"><?php echo $a++; ?></td>
    <td class="text-danger alert-link"><?php echo $detalle[$i]['codproducto']; ?></td>
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantcompra'], 2, '.', ''); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['preciocompra'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentoc'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproductoc'], 2, '.', ','); ?>%</sup></td>
    <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesComprasAgregar('<?php echo encrypt($detalle[$i]["coddetallecompra"]); ?>','<?php echo encrypt($detalle[$i]["codcompra"]); ?>','<?php echo encrypt($reg[0]["codproveedor"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOMPRAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td></td><?php } ?>
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
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
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
<?php
} 
######################## MOSTRAR DETALLES DE COMPRAS AGREGRA #######################
?>

<?php
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
if (isset($_GET['BuscaComprasxProvedores']) && isset($_GET['codsucursal']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxProveedor();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras de Productos por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codproveedor=<?php echo $codproveedor; ?>&codsucursal=<?php echo $codsucursal; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Factura</th>
                              <th>Descripción de Proveedor</th>
                              <th>Estado</th>
                              <th>Dias Venc.</th>
                              <th>Fecha de Emisión</th>
                              <th>Fecha de Recepción</th>
                              <th>Nº de Articulos</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc%</th>
                              <th>Gasto Envio</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
 <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
  
  <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
  elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
          
  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva']+$reg[$i]['gastoenvio'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  <td><a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
          <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA COMPRAS POR PROVEEDORES ##########################
?>


<?php
######################### BUSQUEDA COMPRAS POR FECHAS ########################
if (isset($_GET['BuscaComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Compras de Productos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                              <tr>
                              <th>Nº</th>
                              <th>N° de Factura</th>
                              <th>Descripción de Proveedor</th>
                              <th>Estado</th>
                              <th>Dias Venc.</th>
                              <th>Fecha de Emisión</th>
                              <th>Fecha de Recepción</th>
                              <th>Nº de Articulos</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc%</th>
                              <th>Gasto Envio</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]['codfactura']; ?></td>
 <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
  
  <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
  elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
          
  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fecharecepcion'])); ?></td>

  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
                    <td>
<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
          <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalGasto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA COMPRAS POR FECHAS ##########################
?>

<?php
######################## BUSQUEDA ABONOS CREDITOS DE COMPRAS POR FECHAS ########################
if (isset($_GET['BuscaAbonosCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codmediopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  //$codbanco = limpiar($_GET['codbanco']);
  $codmediopago = limpiar($_GET['codmediopago']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codmediopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FORMA DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

 } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


 } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

 } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarAbonosCreditosComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Abonos Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ABONOSCREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Forma de Pago: </label> <?php echo $reg[0]['mediopago']; ?><br>
            
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>N° de Documento</th>
                                  <th>Descripción de Proveedor</th>
                                  <th>Fecha de Abono</th>
                                  <th>Nº de Comprobante</th>
                                  <th>Nombre de Banco</th>
                                  <th>Monto de Abono</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

//$TotalArticulos+=$reg[$i]['articulos'];
$TotalImporte+=$reg[$i]['montoabono'];
?>
                  <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $reg[$i]["codcompra"]; ?></td>
                    <td><?php echo $reg[$i]['documento3'].": ".$reg[$i]['cuitproveedor']; ?></td>
                    <td><?php echo $reg[$i]['nomproveedor']; ?></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaabono'])); ?></td>
                    <td><?php echo $reg[$i]['comprobante'] == '' ? "********" : $reg[$i]['comprobante']; ?></td>
                    <td><?php echo $reg[$i]['codbanco'] == '0' ? "********" : $reg[$i]['nombanco']; ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','); ?></td>
                  </tr>
              <?php } ?>
         <tr class="text-dark alert-link">
           <td colspan="7"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
######################## BUSQUEDA ABONOS CREDITOS DE COMPRAS POR FECHAS ########################
?>

<?php
########################## BUSQUEDA CREDITOS DE COMPRAS POR PROVEEDOR ##########################
if (isset($_GET['BuscaCreditosComprasxProveedor']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['codproveedor'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $codproveedor = limpiar($_GET['codproveedor']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($codproveedor=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE PROVEEDOR PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else {

$pre = new Login();
$reg = $pre->BuscarCreditosComprasxProveedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos Compras por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label"><?php echo "Nº ".$documento = ($reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']); ?> de Proveedor: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Descripción de Proveedor</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
  
  <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
  elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>
  
  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>

  <td> <button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonosCompra" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoCompra(
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

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-warning text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
</td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
           <td colspan="6"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<td></td>
         </tr>
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
########################## BUSQUEDA CREDITOS DE COMPRAS POR PROVEEDOR ##########################
?>

<?php
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

 } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


 } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

 } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

 } else {

$pre = new Login();
$reg = $pre->BuscarCreditosComprasxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Descripción de Proveedor</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo "Nº ".$documento = ($reg[$i]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
      
  <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
  elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>

  <td><button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#ModalAbonosCompra" data-backdrop="static" data-keyboard="false" onClick="AbonoCreditoCompra(
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

  <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-warning text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button></a>

  <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
  </td>
      </tr>
      <?php } ?>
      <tr class="text-dark alert-link">
      <td colspan="6"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
<td></td>
         </tr>
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
########################## BUSQUEDA CREDITOS DE COMPRAS POR FECHAS ##########################
?>

<?php
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR PROVEEDOR ##########################
if (isset($_GET['BuscaDetallesCreditosComprasxProveedor']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['codproveedor'])){
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $codproveedor = limpiar($_GET['codproveedor']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($codproveedor=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL PROVEEDOR CORRECTAMENTE</center>";
  echo "</div>";   
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosComprasxProveedor();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Compras a Créditos por Proveedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXPROVEEDOR") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&codproveedor=<?php echo $codproveedor; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXPROVEEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label">Nº de <?php echo $reg[0]['documproveedor'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: </label> <?php echo $reg[0]['cuitproveedor']; ?><br>

            <label class="control-label">Nombre de Proveedor: </label> <?php echo $reg[0]['nomproveedor']; ?><br>
            
            <label class="control-label">Nº de Telefono: </label> <?php echo $reg[0]['tlfproveedor'] == "" ? "********" : $reg[0]['tlfproveedor']; ?><br>

            <label class="control-label">Dirección Domiciliaria: </label> <?php echo $reg[0]['direcproveedor'] == "" ? "********" : $reg[0]['direcproveedor']; ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Observaciones</th>
                                  <th>Detalles Productos</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'];
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
  
  <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
  elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]["gastoenvio"]-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>
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

 <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
           <td colspan="7"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR PROVEEDOR ##########################
?>

<?php
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesCreditosComprasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosComprasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Compras a Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSCOMPRASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
            
            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>
            
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Factura</th>
                                  <th>Descripción de Proveedor</th>
                                  <th>Observaciones</th>
                                  <th>Detalles Productos</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalImporte=0;
$TotalAbono=0;
$TotalDebe=0;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
$TotalImporte+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio'];
$TotalAbono+=$reg[$i]['creditopagado'];
$TotalDebe+=$reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'];
?>
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['documento3'].": ".$reg[$i]['cuitproveedor']; ?>"><?php echo $reg[$i]['nomproveedor']; ?></abbr></td>
  <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
    
  <td><?php if($reg[$i]["statuscompra"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statuscompra"]."</span>"; } 
  elseif($reg[$i]["statuscompra"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statuscompra"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statuscompra'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statuscompra"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaemision'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']+$reg[$i]['gastoenvio']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>
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

 <a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button>

<a href="reportepdf?codcompra=<?php echo encrypt($reg[$i]['codcompra']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("FACTURACOMPRA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA DETALLES CREDITOS COMPRAS POR FECHAS ##########################
?>
























<?php
######################## MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
if (isset($_GET['BuscaCotizacionModal']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON COTIZACIONES Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº COTIZACIÓN <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechacotizacion'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?>
                        <th>Acción</th>
                        <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesCotizaciones();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
      <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo number_format($detalle[$i]['cantcotizacion'], 2, '.', ''); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionModal('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[0]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"> <span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
  }
} 
######################### MOSTRAR COTIZACIONES EN VENTANA MODAL #########################
?>


<?php
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
if (isset($_GET['MuestraDetallesCotizacionesUpdate']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) {

$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
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
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleCotizacion('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantcotizacion[]" id="cantcotizacion_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoCotizacion(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantcotizacion"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantcotizacionbd[]" id="cantcotizacionbd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantcotizacion"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleCotizacion('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
      
    <td class="text-danger alert-link">
    <input type="hidden" name="coddetallecotizacion[]" id="coddetallecotizacion" value="<?php echo $detalle[$i]["coddetallecotizacion"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
    <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    <?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
    <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

    <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></td>

    <td class="text-dark alert-link"><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
    <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
    <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>

    <td class="text-dark alert-link"><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>

    <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

    <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

    <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></td>
    <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
    <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionesUpdate('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</label></h5></td>
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
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
<?php
} 
####################### MOSTRAR DETALLES DE COTIZACIONES UPDATE #########################
?>

<?php
####################### MOSTRAR DETALLES DE COTIZACIONES AGREGAR #######################
if (isset($_GET['MuestraDetallesCotizacionesAgregar']) && isset($_GET['codcotizacion']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CotizacionesPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>

<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
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
$detalle = $tra->VerDetallesCotizaciones();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td class="text-dark alert-link"><?php echo $a++; ?></td>
      
  <td class="text-danger alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
      
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantcotizacion'], 2, '.', ''); ?></td>
      
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>

  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>

  <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>

  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

  <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
  <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesCotizacionesAgregar('<?php echo encrypt($detalle[$i]["coddetallecotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codcotizacion"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESCOTIZACIONES") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
    <h5><?php echo $simbolo; ?><label id="lbldescontado" name="lbldescontado"><?php echo number_format($reg[0]['descontado'], 2, '.', ','); ?></label></h5>
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
<?php
} 
######################## MOSTRAR DETALLES DE COTIZACIONES AGREGRA #######################
?>


<?php
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
if (isset($_GET['BuscaCotizacionesxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCotizacionesxFechas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Cotizaciones por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nº</th>
                              <th>N° de Cotización</th>
                              <th>Descripción de Cliente</th>
                              <th>Fecha Emisión</th>
                              <th>Nº de Articulos</th>
                              <th>Subtotal</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Desc%</th>
                              <th>Imp. Total</th>
                              <th><span class="mdi mdi-drag-horizontal"></span></th>
                            </tr>
                          </thead>
                          <tbody>
<?php
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
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo $reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>  
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechacotizacion'])); ?></td>
          <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codcotizacion=<?php echo encrypt($reg[$i]['codcotizacion']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
        </tr>
        <?php } ?>
         <tr class="text-dark alert-link">
          <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA COTIZACIONES POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES COTIZACIONES POR FECHAS ##########################
if (isset($_GET['BuscaDetallesCotizacionesxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$cotizado = new Login();
$reg = $cotizado->BuscarDetallesCotizacionesxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Cotizaciones por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nº</th>
                              <th>Tipo</th>
                              <th>Descripción</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Desc</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Precio de Venta</th>
                              <th>Cotizado</th>
                              <th>Monto Total</th>
                            </tr>
                          </thead>
                          <tbody>
<?php
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
          <tr>
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
            <?php  }  ?>
          <tr class="text-dark alert-link">
            <td colspan="7"></td>
            <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></td>
            <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
          </tr>
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
########################### BUSQUEDA DE DETALLES COTIZACIONES POR FECHAS ##########################
?>


<?php 
########################### BUSQUEDA DE DETALLES COTIZACIONES POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesCotizacionesxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesCotizacionesxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Cotizaciones por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCOTIZACIONESXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nº</th>
                              <th>Tipo</th>
                              <th>Descripción</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Desc</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Precio de Venta</th>
                              <th>Cotizado</th>
                              <th>Monto Total</th>
                            </tr>
                          </thead>
                          <tbody>
<?php
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
          <tr>
          <td><?php echo $a++; ?></div></td>
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
            <?php  }  ?>
          <tr class="text-dark alert-link">
            <td colspan="7"></td>
            <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></td>
            <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
          </tr>
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
########################### BUSQUEDA DE DETALLES COTIZACIONES POR VENDEDOR ##########################
?>
























<?php
######################## MOSTRAR PREVENTAS EN VENTANA MODAL #########################
if (isset($_GET['BuscaPreventaModal']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PREVENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº PREVENTA <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechapreventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?>
                        <th>Acción</th>
                        <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesPreventas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
  <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td><?php echo number_format($detalle[$i]['cantpreventa'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
  <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
  <?php if ($_SESSION['acceso'] == "administradorS" && $reg[0]["procesada"] == 1) { ?><td>
  <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventaModal('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','); ?></p>
<p><b>Total Grabado <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Total Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codpreventa=<?php echo encrypt($reg[0]['codpreventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETPREVENTA") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"> <span><i class="fa fa-print"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
  <?php
  }
} 
######################### MOSTRAR PREVENTAS EN VENTANA MODAL #########################
?>


<?php
####################### MOSTRAR DETALLES DE PREVENTAS UPDATE #########################
if (isset($_GET['MuestraDetallesPreventasUpdate']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
      <table class="table table-hover">
          <thead>
              <tr>
                  <th>Cantidad</th>
                  <th>Tipo</th>
                  <th>Descripción</th>
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
$detalle = $tra->VerDetallesPreventas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;  
?>
    <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetallePreventa('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantpreventa[]" id="cantpreventa_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoPreventa(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantpreventa"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantpreventabd[]" id="cantpreventabd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantpreventa"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetallePreventa('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
      
    <td class="text-danger alert-link">
    <input type="hidden" name="coddetallepreventa[]" id="coddetallepreventa" value="<?php echo $detalle[$i]["coddetallepreventa"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
    <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    <?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
    <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>

    <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
        <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
        <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>

    <td class="text-dark alert-link"><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>

    <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

    <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

    <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></td>

 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventasUpdate('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
                                 </tr>
                     <?php } ?>
                </tbody>
            </table><hr>

            <table id="carritototal" class="table-responsive">
                <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', ''); ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal"><?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2"><?php echo number_format($reg[0]['subtotalivano'], 2, '.', ''); ?></label></h5>
    <input type="hidden" name="txtdiscriminado" id="txtdiscriminado" value="<?php echo number_format($reg[0]['subtotalivasi'], 2, '.', ''); ?>"/>
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
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/></td>
    </tr>
    </table>
  </div>
<?php
} 
####################### MOSTRAR DETALLES DE PREVENTAS UPDATE #########################
?>

<?php
####################### MOSTRAR DETALLES DE PREVENTAS AGREGAR #######################
if (isset($_GET['MuestraDetallesPreventasAgregar']) && isset($_GET['codpreventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->PreventasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
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
$detalle = $tra->VerDetallesPreventas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr>
  <td class="text-dark alert-link"><?php echo $a++; ?></td>
  <td class="text-danger alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
  <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
  <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantpreventa'], 2, '.', ''); ?></td> 
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
  <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
  <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
 <?php if ($_SESSION['acceso'] == "administradorS") { ?><td>
<button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesPreventasAgregar('<?php echo encrypt($detalle[$i]["coddetallepreventa"]); ?>','<?php echo encrypt($detalle[$i]["codpreventa"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESPREVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button></td><?php } ?>
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
    <h5><label>Exento 0%:</label></h5></td>
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
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', ''); ?>%:</label></h5>    </td>
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
<?php
} 
######################## MOSTRAR DETALLES DE PREVENTAS AGREGRA #######################
?>


<?php
########################## BUSQUEDA PREVENTAS POR FECHAS ##########################
if (isset($_GET['BuscaPreventasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarPreventasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Preventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("PREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Nº</th>
                          <th>N° de Preventa</th>
                          <th>Descripción de Cliente</th>
                          <th>Fecha Emisión</th>
                          <th>Nº de Articulos</th>
                           <th>Subtotal</th>
                          <th><?php echo $impuesto; ?></th>
                          <th>Desc</th>
                          <th>Imp. Total</th>
                          <th><i class="mdi mdi-drag-horizontal"></i></th>
                        </tr>
                      </thead>
                      <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
                                  <td><?php echo $reg[$i]['codfactura']; ?></td>
<td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>  
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechapreventa'])); ?></td>
          <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
          <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codpreventa=<?php echo encrypt($reg[$i]['codpreventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETPREVENTA") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
          <td colspan="4"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA PREVENTAS POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES PREVENTAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesPreventasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$cotizado = new Login();
$reg = $cotizado->BuscarDetallesPreventasxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Preventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nº</th>
                              <th>Tipo</th>
                              <th>Descripción</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Desc</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Precio de Venta</th>
                              <th>Preventa</th>
                              <th>Monto Total</th>
                            </tr>
                          </thead>
                          <tbody>
<?php
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
        <tr>
          <td><?php echo $a++; ?></div></td>
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
        <?php } ?>
        <tr class="text-dark alert-link">
          <td colspan="7"></td>
          <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
          <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></td>
          <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
        </tr>
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
########################### BUSQUEDA DE DETALLES PREVENTAS POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES PREVENTAS POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesPreventasxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesPreventasxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Preventas por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESPREVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>Nº</th>
                              <th>Tipo</th>
                              <th>Descripción de Producto</th>
                              <th>Marca</th>
                              <th>Modelo</th>
                              <th>Desc</th>
                              <th><?php echo $impuesto; ?></th>
                              <th>Precio de Venta</th>
                              <th>Preventa</th>
                              <th>Monto Total</th>
                            </tr>
                          </thead>
                          <tbody>
<?php
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
        <tr>
          <td><?php echo $a++; ?></div></td>
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
        <?php } ?>
        <tr class="text-dark alert-link">
          <td colspan="7"></td>
          <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
          <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></td>
          <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
        </tr>
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
########################### BUSQUEDA DE PRODUCTOS PREVENTAS POR VENDEDOR ##########################
?>









































<?php
####################### MOSTRAR CAJA DE VENTA EN VENTANA MODAL ########################
if (isset($_GET['BuscaCajaModal']) && isset($_GET['codcaja'])) { 

$reg = $new->CajasPorId();
?>
  
  <table class="table-responsive" border="0" align="center"> 
  <tr>
    <td>Nº de Caja: <?php echo $reg[0]['nrocaja']; ?></td>
  </tr>
  <tr>
    <td>Nombre de Caja: <?php echo $reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td>Responsable de Caja:  <?php echo $reg[0]['nombres']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td>Sucursal: <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>
<?php 
} 
######################## MOSTRAR CAJA DE VENTA EN VENTANA MODAL #########################
?>


<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->BuscarCajasxSucursal();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($caja);$i++){
    ?>
<option value="<?php echo encrypt($caja[$i]['codcaja']) ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
    <?php 
   } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>


<?php 
############################# BUSCAR CAJAS POR SUCURSALES #############################
if (isset($_GET['BuscaCajasAbiertasxSucursal']) && isset($_GET['codsucursal'])) {
  
$caja = $new->ListarCajasAbiertas();
  ?>
<option value=""> -- SELECCIONE -- </option>
  <?php
   for($i=0;$i<sizeof($caja);$i++){
    ?>
<option value="<?php echo $caja[$i]['codcaja']; ?>"><?php echo $caja[$i]['nrocaja'].": ".$caja[$i]['nomcaja']." - ".$caja[$i]['nombres']; ?></option>
    <?php 
   } 
}
############################# BUSCAR CAJAS POR SUCURSALES ##########################
?>


<?php
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL #######################
if (isset($_GET['BuscaArqueoModal']) && isset($_GET['codarqueo'])) { 

$reg = $new->ArqueoCajaPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

$detalleabonos = (new Login)->DetallesAbonosArqueoCajaPorId();
?>
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-desktop"></i> Cajero</h4><hr></td>
  </tr>

  <tr>
    <td>Nombre de Caja: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td>Responsable: <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
  <tr>
    <td>Hora Apertura: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaapertura'])); ?></td>
  </tr>
  <tr>
    <td>Hora Cierre: <?php echo $cierre = ( $reg[0]['statusarqueo'] == '1' ? $reg[0]['fechacierre'] : date("d-m-Y H:i:s",strtotime($reg[0]['fechacierre']))); ?></td>
  </tr>
  <tr>
    <td>Monto Inicial: <?php echo $simbolo.number_format($reg[0]['montoinicial'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-cart-plus"></i> Desglose en Ventas</h4><hr></td>
  </tr>
  <tr>
    <td>CRÉDITOS: <?php echo $simbolo.number_format($reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>

  <?php
  $a=1;
  $Ventas_Efectivo = 0;
  for($i=0;$i<sizeof($reg);$i++){
  $Ventas_Efectivo += ($reg[$i]['mediopago'] == "EFECTIVO" ? $reg[$i]['montopagado'] : 0);   
  if($reg[$i]['mediopago'] != ""){
  ?>
  <tr>
    <td><?php echo $reg[$i]['mediopago']; ?>:  <?php echo $simbolo.number_format($reg[$i]['montopagado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-cart-plus"></i> Desglose en Abonos a Créditos</h4><hr></td>
  </tr>

  <?php
  $a=1;
  $Abonos_Efectivo = 0;
  for($i=0;$i<sizeof($detalleabonos);$i++){
  $Abonos_Efectivo += ($detalleabonos[$i]['mediopago'] == "EFECTIVO" ? $detalleabonos[$i]['monto_abonado'] : 0);
  if($detalleabonos[$i]['mediopago'] != ""){
  ?>
  <tr>
    <td><?php echo $detalleabonos[$i]['mediopago']; ?>:  <?php echo $simbolo.number_format($detalleabonos[$i]['monto_abonado'], 2, '.', ','); ?></td>
  </tr>
  <?php } } ?>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="fa fa-usd"></i> Movimientos de Caja</h4><hr></td>
  </tr>

  <tr>
    <td>Ingresos: <?php echo $simbolo.number_format($reg[0]['ingresos2'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>Egresos: <?php echo $simbolo.number_format($reg[0]['egresos'], 2, '.', ','); ?></td>
  </tr>

  <tr>
    <td><hr><h4 class="card-subtitle m-0 text-dark"><i class="mdi mdi-scale-balance"></i> Balance en Caja</h4><hr></td>
  </tr>

  <tr>
    <td>Total Ventas: <?php echo $simbolo.number_format($reg[0]['ingresos']+$reg[0]['creditos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>Total de Abonos: <?php echo $simbolo.number_format($reg[0]['abonos'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>Efectivo en Caja: <?php echo $simbolo.number_format(($reg[0]["montoinicial"]+$Ventas_Efectivo+$Abonos_Efectivo+$reg[0]["ingresos2"])-$reg[0]["egresos"], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>Efectivo Disponible: <?php echo $simbolo.number_format($reg[0]['dineroefectivo'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>Diferencia en Efectivo: <?php echo $simbolo.number_format($reg[0]['diferencia'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>Observaciones: <?php echo $reg[0]['comentarios'] == "" ? "******" : $reg[0]['comentarios']; ?></td>
  </tr>
  <?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td>Sucursal: <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
  <?php } ?>
</table>
  
  <?php
   } 
######################## MOSTRAR ARQUEO EN CAJA EN VENTANA MODAL ########################
?>


<?php
########################## BUSQUEDA ARQUEOS DE CAJA POR FECHAS ##########################
if (isset($_GET['BuscaArqueosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarArqueosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Arqueos de Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ARQUEOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Caja</th>
                                  <th>Hora de Apertura</th>
                                  <th>Hora de Cierre</th>
                                  <th>Monto Inicial</th>
                                  <th>Total en Ventas</th>
                                  <th>Efectivo en Caja</th>
                                  <th>Efectivo Disponible</th>
                                  <th>Diferencia Efectivo</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
                                <tr>
<td><?php echo $a++; ?></td>
<td><abbr title="<?php echo "Responsable: ".$reg[$i]['nombres'] ?>"><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></abbr></td>
<td><?php echo date("d-m-Y",strtotime($reg[$i]['fechaapertura'])); ?></td>
<td><?php echo $reg[$i]['fechacierre'] == '0000-00-00 00:00:00' ? "*********" : date("d-m-Y",strtotime($reg[$i]['fechacierre'])); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montoinicial'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['ingresos']+$reg[$i]['creditos'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['efectivocaja'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['dineroefectivo'], 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['diferencia'], 2, '.', ','); ?></td>
            </tr>
            <?php  }  ?>
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
########################## BUSQUEDA ARQUEOS DE CAJAS POR FECHAS ##########################
?>

<?php 
########################### BUSQUEDA GANANCIAS POR FECHAS ##########################
if (isset($_GET['BuscaGananciasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$ingresos = new Login();
$detalle_ingreso = $ingresos->BuscarIngresosxFechas(); 
  
$gastos = new Login();
$detalle_gasto = $gastos->BuscarGastosxFechas(); 

$ganancias = new Login();
$reg = $ganancias->BuscarGananciasxFechas();  
?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ganancias por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("GANANCIASXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("GANANCIASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("GANANCIASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>Nº</th>
                      <th>Código</th>
                      <th>Descripción de Producto</th>
                      <th>Marca</th>
                      <th>Modelo</th>
                      <th>Desc</th>
                      <th>Precio Compra</th>
                      <th>Precio Venta</th>
                      <th>Vendido</th>
                      <th>Total Venta</th>
                      <th>Total Compra</th>
                      <th>Ganancias</th>
                    </tr>
                  </thead>
                  <tbody>
<?php
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
            <tr>
            <td><?php echo $a++; ?></div></td>
            <td><?php echo $reg[$i]['codproducto']; ?></td>
            <td><?php echo $reg[$i]['producto']." ".$reg[$i]["condicion"].$descripcion = ($reg[$i]["descripcion"] != "" ? "<br>".$reg[$i]["descripcion"] : "").$imei = ($reg[$i]["imei"] != "" ? "<br>IMEI: ".$reg[$i]["imei"] : ""); ?></td>
            <td><?php echo $reg[$i]['codmarca'] == '0' ? "*****" : $reg[$i]['nommarca']; ?></td>
            <td><?php echo $reg[$i]['codmodelo'] == '0' ? "*****" : $reg[$i]['nommodelo']; ?></td>
            <td><?php echo number_format($reg[$i]['descproducto'], 2, '.', ','); ?>%</td>
            <td><?php echo $simbolo.number_format($reg[$i]["preciocompra"], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($reg[$i]["precioventa"], 2, '.', ','); ?></td>
            <td><?php echo number_format($reg[$i]['cantidad'], 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($SumVenta, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($SumCompra, 2, '.', ','); ?></td>
            <td><?php echo $simbolo.number_format($SumVenta-$SumCompra, 2, '.', ','); ?></td>
            </tr>
            <?php  }  ?>
            <tr class="text-dark alert-link">
              <td colspan="8"></td>
              <td><?php echo number_format($VendidosTotal, 2, '.', ','); ?></td>
              <td><?php echo $simbolo.number_format($VentaTotal, 2, '.', ','); ?></td>
              <td><?php echo $simbolo.number_format($CompraTotal, 2, '.', ','); ?></td>
              <td><?php echo $simbolo.number_format($TotalGanancia, 2, '.', ','); ?></td>
            </tr>
            <tr class="text-dark alert-link">
              <td colspan="9"></td>
              <td colspan="2">INGRESOS ADICIONALES</td>
              <td><?php echo $simbolo.number_format($detalle_ingreso[0]['ingresos'], 2, '.', ','); ?></td>
            </tr>
            <tr class="text-dark alert-link">
              <td colspan="9"></td>
              <td colspan="2">GASTOS</td>
              <td><?php echo $simbolo.number_format($detalle_gasto[0]['gastos'], 2, '.', ','); ?></td>
            </tr>
            <tr class="text-dark alert-link">
              <td colspan="9"></td>
              <td colspan="2">TOTAL</td>
              <td><?php echo $simbolo.number_format($TotalGanancia+$detalle_ingreso[0]['ingresos']-$detalle_gasto[0]['gastos'], 2, '.', ','); ?></td>
            </tr>
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
########################### BUSQUEDA GANANCIAS POR FECHAS ##########################
?>
















<?php
###################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL #####################
if (isset($_GET['BuscaMovimientoModal']) && isset($_GET['numero']) && isset($_GET['codsucursal'])) { 

$reg = $new->MovimientosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>
  
  <table class="table-responsive" border="0" align="center">
  <tr>
    <td>Nombre de Caja: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?></td>
  </tr>
  <tr>
    <td>Tipo de Movimiento: <?php echo $reg[0]['tipomovimiento']; ?></td>
  </tr>
  <tr>
    <td>Tipo de Pago: <?php echo $reg[0]['mediopago']; ?></td>
  </tr>
  <tr>
    <td>Monto de Movimiento: <?php echo $simbolo.number_format($reg[0]['montomovimiento'], 2, '.', ','); ?></td>
  </tr>
  <tr>
    <td>Descripción de Movimiento: <?php echo $reg[0]['descripcionmovimiento']; ?></td>
  </tr>
  <tr>
    <td>Fecha Movimiento: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechamovimiento'])); ?></td>
  </tr>
  <tr>
    <td>Responsable: <?php echo $reg[0]['dni'].": ".$reg[0]['nombres']; ?></td>
  </tr>
<?php if ($_SESSION["acceso"]=="administradorG") { ?>
  <tr>
    <td>Sucursal: <?php echo $reg[0]['cuitsucursal'].": ".$reg[0]['nomsucursal']; ?></td>
  </tr>
<?php } ?>
</table>
  
  <?php
   } 
##################### MOSTRAR MOVIMIENTO EN CAJA EN VENTANA MODAL ######################
?>


<?php
######################### BUSQUEDA MOVIMIENTOS DE CAJA POR FECHAS ########################
if (isset($_GET['BuscaMovimientosxFechas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarMovimientosxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Movimientos en Cajas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("MOVIMIENTOSXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Nº de Caja</th>
                                  <th>Responsable</th>
                                  <th>Tipo Movimiento</th>
                                  <th>Descripción</th>
                                  <th>Monto</th>
                                  <th>Forma de Movimiento</th>
                                  <th>Fecha Movimiento</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>");
?>
                                <tr>
                    <td><?php echo $a++; ?></td>
              <td><?php echo $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']; ?></td>
              <td><?php echo $reg[$i]['nombres']; ?></td>
<td><?php echo $status = ( $reg[$i]['tipomovimiento'] == 'INGRESO' ? "<span class='badge badge-info'><i class='fa fa-check'></i> ".$reg[$i]['tipomovimiento']."</span>" : "<span class='badge badge-danger'><i class='fa fa-times'></i> ".$reg[$i]['tipomovimiento']."</span>"); ?></td>
<td><?php echo $reg[$i]['descripcionmovimiento']; ?></td>
<td><?php echo $simbolo.number_format($reg[$i]['montomovimiento'], 2, '.', ','); ?></td>
              <td><?php echo $reg[$i]['mediopago']; ?></td>
              <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechamovimiento'])); ?></td>
                                </tr>
                        <?php  }  ?>
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
####################### BUSQUEDA MOVIMIENTOS DE CAJAS POR FECHAS ########################
?>































<?php
############################# MOSTRAR VENTAS EN VENTANA MODAL ############################
if (isset($_GET['BuscaVentaModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {
?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº <?php echo $tipo_documento = ($reg[0]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[0]['tipodocumento'])." ".$reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº SERIE: <?php echo $reg[0]['codserie']; ?>
  <br>Nº DE CAJA: <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?>
  
  <?php if($reg[0]['fechavencecredito']!= "0000-00-00") { ?>
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  <?php } ?>

  <br>STATUS VENTA: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
  elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                                        </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>...</th>
                                                </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
                                                <tr>
      <td><?php echo $a++; ?></td>
      <td class="text-left"><h5><?php echo $detalle[$i]['producto']; ?></h5>
      <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      <td><?php echo number_format($detalle[$i]['cantventa'], 2, '.', ''); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
      <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

    <td>
    <?php if($reg[0]['notacredito'] != 1){ ?>
    <?php if($_SESSION['acceso'] == "administradorS" || $reg[0]["codigo"] == $_SESSION['codigo']){ ?>
    <?php if($reg[0]['statusarqueo'] == 1){ ?>
    <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesVentaModal('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </td>
                                                </tr>
                                      <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="col-md-12">

                                    <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', ',') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?> </p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                                    <div class="clearfix"></div>
                                    <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[0]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"> <span><i class="fa fa-print"></i> Imprimir</span> </button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                            </div>
                <!-- .row -->
<?php
  }
} 
############################# MOSTRAR VENTAS EN VENTANA MODAL ############################
?>


<?php
######################### MOSTRAR DETALLES DE VENTAS UPDATE ############################
if (isset($_GET['MuestraDetallesVentasUpdate']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){ 
$count++;    
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
    <td>
    <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
    <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleVenta('a',<?php echo $count; ?>)">-</button></span>
    <input type="text" class="bold" name="cantventa[]" id="cantventa_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoVenta(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="<?php echo number_format($detalle[$i]["cantventa"], 2, '.', ''); ?>" title="Ingrese Cantidad">
    <input type="hidden" name="cantidadventabd[]" id="cantidadventabd_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantventa"], 2, '.', ''); ?>">
    <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleVenta('b',<?php echo $count; ?>)">+</button></span>
    </div>
    </td>
      
    <td class="text-danger alert-link">
    <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo $detalle[$i]["coddetalleventa"]; ?>">
    <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
    <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
    <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
    <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
    <?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5><small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
      
    <td class="text-dark alert-link"><input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
        <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo number_format($detalle[$i]['precioventa'], 2, '.', '');; ?></td>

    <td class="text-dark alert-link"><input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["valortotal"], 2, '.', ''); ?>"><label id="txtvalortotal_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valortotal'], 2, '.', ''); ?></label></td>

    <td class="text-dark alert-link"><input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
    <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["totaldescuentov"], 2, '.', ''); ?>">
    <label id="txtdescproducto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['totaldescuentov'], 2, '.', ''); ?></label><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>

    <td class="text-dark alert-link"><input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', '')."%" : "(E)"; ?></td>

    <td class="text-dark alert-link"><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? number_format($detalle[$i]['valorneto'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['valorneto']-$detalle[$i]['subtotalimpuestos'], 2, '.', '') : "0.00"; ?>">

    <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?>" >

    <input type="hidden" class="valorneto2" name="valorneto2[]" id="valorneto2_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]['valorneto2'], 2, '.', ''); ?>" >

    <label id="txtvalorneto_<?php echo $count; ?>"><?php echo number_format($detalle[$i]['valorneto'], 2, '.', ''); ?></label></td>

    <td>
    <?php if($reg[0]['notacredito'] != 1){ ?>
    <?php if($_SESSION['acceso'] == "administradorS" || $reg[0]["codigo"] == $_SESSION['codigo']){ ?>
    <?php if($reg[0]['statusarqueo'] == 1){ ?>
    <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesVentaUpdate('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </td>
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
    <input type="hidden" name="txtTotal" id="txtTotal" value="<?php echo number_format($reg[0]['totalpago'], 2, '.', ''); ?>"/>
    <input type="hidden" name="txtTotalCompra" id="txtTotalCompra" value="<?php echo number_format($reg[0]['totalpago2'], 2, '.', ''); ?>"/>    </td>
                    </tr>
                  </table>
        </div>
<?php
} 
########################### MOSTRAR DETALLES DE VENTAS UPDATE ##########################
?>

<?php
########################### MOSTRAR DETALLES DE VENTAS AGREGAR ##########################
if (isset($_GET['MuestraDetallesVentasAgregar']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->VentasPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");
?>
<div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                        <th>...</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesVentas();
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
?>
  <tr>
    <td class="text-dark alert-link"><?php echo $a++; ?></td>
      
    <td class="text-danger alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>
      
    <td class='text-left'><h5><strong><?php echo $detalle[$i]['producto']; ?></strong></h5>
    <small>MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>

    <td class="text-dark alert-link"><?php echo number_format($detalle[$i]['cantventa'], 2, '.', ''); ?></td>
      
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>

    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
      
    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ''); ?>%</sup></td>

    <td class="text-dark alert-link"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>

    <td class="text-dark alert-link"><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>

    <td>
    <?php if($reg[0]['notacredito'] != 1){ ?>
    <?php if($_SESSION['acceso'] == "administradorS" || $reg[0]["codigo"] == $_SESSION['codigo']){ ?>
    <?php if($reg[0]['statusarqueo'] == 1){ ?>
    <button type="button" class="btn btn-rounded btn-dark" onClick="EliminarDetallesVentaAgregar('<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>','<?php echo encrypt($detalle[$i]["codventa"]); ?>','<?php echo encrypt($reg[0]["codcliente"]); ?>','<?php echo encrypt($detalle[$i]["codsucursal"]); ?>','<?php echo encrypt("DETALLESVENTAS") ?>')" title="Eliminar" ><i class="fa fa-trash-o"></i></button>
    <?php } ?>
    <?php } ?>
    <?php } ?>
    </td>
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
<?php
  } 
########################## MOSTRAR DETALLES DE VENTAS AGREGRAR #########################
?>


<?php
########################## BUSQUEDA VENTAS POR CAJAS ##########################
if (isset($_GET['BuscaVentasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago = limpiar($_GET['tipopago']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

 } elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Caja</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Nota Credito</th>
                                  <th>Estado</th>
                                  <th>Fecha Emisión</th>
                                  <th>Detalles Productos</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Dcto %</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['notacredito'] == 1 ? "<span class='badge badge-danger'><i class='fa fa-exclamation-circle'></i> SI</span>" : "<span class='badge badge-success'><i class='fa fa-check'></i> NO</span>"; ?></td>

  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
          <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA VENTAS POR CAJAS ##########################
?>


<?php
########################## BUSQUEDA VENTAS POR FECHAS ##########################
if (isset($_GET['BuscaVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago = limpiar($_GET['tipopago']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Vendedor</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Nota Credito</th>
                                  <th>Estado</th>
                                  <th>Fecha Emisión</th>
                                  <th>Detalles Productos</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['nombres']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['notacredito'] == 1 ? "<span class='badge badge-danger'><i class='fa fa-exclamation-circle'></i> SI</span>" : "<span class='badge badge-success'><i class='fa fa-check'></i> NO</span>"; ?></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
          <td colspan="8"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA VENTAS POR FECHAS ##########################
?>


<?php
########################## BUSQUEDA VENTAS POR CLIENTES ##########################
if (isset($_GET['BuscaVentasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codcliente']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $tipopago = limpiar($_GET['tipopago']);
  $codcliente = limpiar($_GET['codcliente']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

  } else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codcliente=<?php echo $codcliente; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Estado</th>
                                  <th>Fecha Emisión</th>
                                  <th>Detalles Productos</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php } ?>
         <tr class="text-dark alert-link">
          <td colspan="6"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA VENTAS POR CLIENTES ##########################
?>

<?php
########################## BUSQUEDA VENTAS POR CONDICIONES DE PAGO ##########################
if (isset($_GET['BuscaVentasxCondiciones']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['formapago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $formapago = limpiar($_GET['formapago']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($formapago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FORMA DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DE INICIO PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA FINAL PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DE INICIO NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarVentasxCondiciones();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas por Formas de Pago</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&formapago=<?php echo $formapago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("VENTASXCONDICIONES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Descripción de Caja: </label> <?php echo $reg[0]['nrocaja'].": ".$reg[0]['nomcaja']; ?><br>

            <label class="control-label">Responsable de Caja: </label> <?php echo $reg[0]['nombres']; ?><br>

            <label class="control-label">Forma de Pago: </label> <?php echo $reg[0]['mediopago']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Nota Credito</th>
                                  <th>Estado</th>
                                  <th>Fecha Emisión</th>
                                  <th>Detalles Productos</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Dcto %</th>
                                  <th>Imp. Total</th>
                                  <th>Total Pagado </th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['notacredito'] == 1 ? "<span class='badge badge-danger'><i class='fa fa-exclamation-circle'></i> SI</span>" : "<span class='badge badge-success'><i class='fa fa-check'></i> NO</span>"; ?></td>

  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($ImportePagado, 2, '.', ','); ?></td>

  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
        <tr class="text-dark alert-link">
        <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalPagado, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA VENTAS POR CONDICIONES DE PAGO ##########################
?>


<?php 
########################### BUSQUEDA COMISION POR VENDEDOR ##########################
if (isset($_GET['BuscaComisionxVentas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$tipopago = limpiar($_GET['tipopago']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarComisionxVentas();  ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Comisión en Ventas por Vendedor </h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("COMISIONXVENTAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Vendedor</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Estado</th>
                                  <th>Fecha Emisión</th>
                                  <th>Detalles Productos</th>
                                  <th>Nº de Articulos</th>
                                  <th>Subtotal</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Desc %</th>
                                  <th>Imp. Total</th>
                                  <th>Total Comisión</th>
                                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
$TotalComision+=$reg[$i]['totalpago']*$reg[$i]['comision']/100;
?>
  <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><?php echo $reg[$i]['nombres']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>

  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>
  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
  <td><?php echo number_format($reg[$i]['articulos'], 2, '.', ''); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']*$reg[$i]['comision']/100, 2, '.', ','); ?></td>
  <td> <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-rounded btn-secondary" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
         <td colspan="7"></td>
<td><?php echo number_format($TotalArticulos, 2, '.', ''); ?></td>
<td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalComision, 2, '.', ','); ?></td>
         </tr>
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
########################### BUSQUEDA DE COMISION POR VENDEDOR ##########################
?>

<?php 
########################### BUSQUEDA DE DETALLES VENTAS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$tipopago = limpiar($_GET['tipopago']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesVentasxFechas();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Ventas por Fecha</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>Tipo</th>
                                  <th>Descripción</th>
                                  <th>Marca</th>
                                  <th>Modelo</th>
                                  <th>Desc</th>
                                  <th><?php echo $impuesto; ?></th>
                                  <th>Precio de Venta</th>
                                  <th>Vendido</th>
                                  <th>Monto Total</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
          <tr>
            <td><?php echo $a++; ?></div></td>
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
          <?php  }  ?>
          <tr class="text-dark alert-link">
            <td colspan="7"></td>
            <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></td>
            <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
          </tr>
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
########################### BUSQUEDA DE DETALLES VENTAS POR FECHAS ##########################
?>


<?php 
########################### BUSQUEDA DE DETALLES VENTAS POR VENDEDOR ##########################
if (isset($_GET['BuscaDetallesVentasxVendedor']) && isset($_GET['codsucursal']) && isset($_GET['tipopago']) && isset($_GET['codigo']) && isset($_GET['desde']) && isset($_GET['hasta'])) { 

$codsucursal = limpiar($_GET['codsucursal']);
$tipopago = limpiar($_GET['tipopago']);
$codigo = limpiar($_GET['codigo']);
$desde = limpiar($_GET['desde']); 
$hasta = limpiar($_GET['hasta']);
   
 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($tipopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE TIPO DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($codigo=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE VENDEDOR PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {
  
$vendidos = new Login();
$reg = $vendidos->BuscarDetallesVentasxVendedor();  
 ?>
 
 <!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Ventas por Vendedor</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&tipopago=<?php echo $tipopago; ?>&codigo=<?php echo $codigo; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESVENTASXVENDEDOR") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Tipo de Pago: </label> <?php if(decrypt($_GET['tipopago']) == 1){ echo "GENERAL"; }elseif(decrypt($_GET['tipopago']) == 2){ echo "CONTADO"; } elseif(decrypt($_GET['tipopago']) == 3){ echo "CREDITO"; }  ?><br>

            <label class="control-label">Nombre de Vendedor: </label> <?php echo $reg[0]['nombres']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

      <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th>Nº</th>
                          <th>Tipo</th>
                          <th>Descripción</th>
                          <th>Marca</th>
                          <th>Modelo</th>
                          <th>Desc</th>
                          <th><?php echo $impuesto; ?></th>
                          <th>Precio de Venta</th>
                          <th>Vendido</th>
                          <th>Monto Total</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
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
          <tr>
            <td><?php echo $a++; ?></div></td>
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
          <?php } ?>
          <tr class="text-dark alert-link">
            <td colspan="7"></td>
            <td><?php echo $simbolo.number_format($PrecioTotal, 2, '.', ','); ?></td>
            <td><?php echo number_format($VendidosTotal, 2, ',', '.'); ?></td>
            <td><?php echo $simbolo.number_format($PagoTotal, 2, '.', ','); ?></td>
          </tr>
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
########################### BUSQUEDA DE DETALLES VENTAS POR VENDEDOR ##########################
?>





































<?php
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
if (isset($_GET['BuscaCreditoModal']) && isset($_GET['codventa']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->CreditosPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">SUCURSAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº <?php echo $tipo_documento = ($reg[0]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[0]['tipodocumento'])." ".$reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">TOTAL FACTURA: <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?>
  <br>TOTAL ABONO: <?php echo $simbolo.number_format($reg[0]['creditopagado'], 2, '.', ','); ?>
  <br>TOTAL DEBE: <?php echo $simbolo.number_format($reg[0]['totalpago']-$reg[0]['creditopagado'], 2, '.', ','); ?>
  
  <br>DIAS VENCIDOS: 
  <?php if($reg[0]['fechavencecredito'] == '0000-00-00' || $reg[0]['fechavencecredito'] != '0000-00-00' && $reg[0]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] >= date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[0]['fechavencecredito']); }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[0]['fechapagado'],$reg[0]['fechavencecredito']); } ?>
  
  <br>STATUS: 
  <?php if($reg[0]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[0]["statusventa"]."</span>"; } 
  elseif($reg[0]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[0]["statusventa"]."</span>"; }
  elseif($reg[0]['fechavencecredito'] < date("Y-m-d") && $reg[0]['fechapagado'] == "0000-00-00" && $reg[0]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[0]["statusventa"]."</span>"; } ?>
  <?php if($reg[0]['fechapagado']!= "0000-00-00") { ?>
  <br>FECHA PAGADA: <?php echo date("d-m-Y",strtotime($reg[0]['fechapagado'])); ?>
  <?php } ?>

  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechaventa'])); ?></p>

  <h4><b class="text-dark">CLIENTE </b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>


                                        </address>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-10" style="clear: both;">
                                        <table class="table table-hover">
                               <thead>
                        <tr><th colspan="4">Detalles de Abonos</th></tr>
                        <tr>
                        <th>#</th>
                        <th>Nº de Caja</th>
                        <th>Forma de Abono</th>
                        <th>Monto de Abono</th>
                        <th>Fecha de Abono</th>
                        </tr>
                                            </thead>
                                            <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesAbonos();

if($detalle==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON ABONOS ACTUALMENTE </center>";
    echo "</div>";    

} else {

$a=1;
for($i=0;$i<sizeof($detalle);$i++){  

?>
      <tr class="text-dark font-12">
      <td><?php echo $a++; ?></td>
      <td><?php echo $detalle[$i]['nrocaja'].": ".$detalle[$i]['nomcaja']; ?></td>
      <td><?php echo $detalle[$i]['mediopago']; ?></td>
      <td><?php echo $simbolo.number_format($detalle[$i]['montoabono'], 2, '.', ','); ?></td>
      <td><?php echo date("d-m-Y H:i:s",strtotime($detalle[$i]['fechaabono'])); ?></td>
                                                </tr>
                                      <?php } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <hr>

                                <div class="col-md-12">
                                    <div class="text-right">
 <a href="reportepdf?codventa=<?php echo encrypt($reg[0]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-folder-open-o"></i> Imprimir</span></button></a>
 <button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                                    </div>
                                </div>
                              </div>
                <!-- .row -->
  <?php
   } 
####################### MOSTRAR VENTA DE CREDITO EN VENTANA MODAL #######################
?>


<?php
######################## BUSQUEDA ABONOS CREDITOS POR CAJAS ########################
if (isset($_GET['BuscaAbonosCreditosVentasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['codmediopago']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $codmediopago = limpiar($_GET['codmediopago']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($codmediopago=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE FORMA DE PAGO PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarAbonosCreditosVentasxCajas();
?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Abonos Créditos por Cajas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("ABONOSCREDITOSVENTASXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSVENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&codmediopago=<?php echo $codmediopago; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("ABONOSCREDITOSVENTASXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nº de Caja: </label> <?php echo $reg[0]['nrocaja']; ?><br>

            <label class="control-label">Nombre de Caja: </label> <?php echo $reg[0]['nomcaja']; ?><br>

            <label class="control-label">Forma de Pago: </label> <?php echo $reg[0]['mediopago']; ?><br>
            
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div3"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>N° de Documento</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Fecha de Abono</th>
                                  <th>Monto de Abono</th>
                                </tr>
                              </thead>
                              <tbody>
<?php
$a=1;
$TotalArticulos=0;
$TotalImporte=0;

for($i=0;$i<sizeof($reg);$i++){
$simbolo = ($reg[$i]['simbolo'] == "" ? "" : "<strong>".$reg[$i]['simbolo']."</strong>"); 

//$TotalArticulos+=$reg[$i]['articulos'];
$TotalImporte+=$reg[$i]['montoabono'];
?>
                  <tr>
                    <td><?php echo $a++; ?></td>
                    <td><?php echo $tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento']).": ".$reg[$i]["codfactura"]; ?></td>
                    <td><?php echo $reg[$i]['documento3'].": ".$reg[$i]['dnicliente']; ?></td>
                    <td><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></td>
                    <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaabono'])); ?></td>
                    <td><?php echo $simbolo.number_format($reg[$i]['montoabono'], 2, '.', ','); ?></td>
                  </tr>
              <?php } ?>
         <tr class="text-dark alert-link">
           <td colspan="5"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
         </tr>
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
######################## BUSQUEDA ABONOS CREDITOS POR CAJAS ########################
?>

<?php
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaCreditosVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarCreditosVentasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas a Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("CREDITOSVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
            
            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Observaciones</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>

  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>

<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false"
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

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
           <td colspan="7"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA CREDITOS POR FECHAS ##########################
?>


<?php
########################## BUSQUEDA CREDITOS POR CLIENTES ##########################
if (isset($_GET['BuscaCreditosVentasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['cliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $cliente = limpiar($_GET['cliente']);

 if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($cliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

  } else {

$pre = new Login();
$reg = $pre->BuscarCreditosVentasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Ventas a Créditos por Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&cliente=<?php echo $cliente; ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCLIENTES") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&cliente=<?php echo $cliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&cliente=<?php echo $cliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("CREDITOSVENTASXCLIENTES") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
            
            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label">Nº de <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Observaciones</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
  
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td> 
<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false"
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

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
           <td colspan="7"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA CREDITOS POR CLIENTES ##########################
?>


<?php
########################## BUSQUEDA DETALLES CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaDetallesCreditosVentasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

  } else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosVentasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Ventas a Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
            
            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>
            
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Observaciones</th>
                                  <th>Detalles Productos</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>
  
  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>
<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false"
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

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA DETALLES CREDITOS POR FECHAS ##########################
?>


<?php
########################## BUSQUEDA DETALLES CREDITOS POR CLIENTES ##########################
if (isset($_GET['BuscaDetallesCreditosVentasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['status']) && isset($_GET['cliente'])){
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $status = limpiar($_GET['status']);
  $cliente = limpiar($_GET['cliente']);

  if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($status=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE STATUS DE CRÉDITO PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;

  } else if($cliente=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
  echo "</div>";   
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarDetallesCreditosVentasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalles de Ventas a Créditos por Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&cliente=<?php echo $cliente; ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXCLIENTE") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&cliente=<?php echo $cliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&status=<?php echo $status; ?>&cliente=<?php echo $cliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("DETALLESCREDITOSVENTASXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Status de Crédito: </label> <?php if(decrypt($status) == 1){ echo "GENERAL"; }elseif(decrypt($status) == 2){ echo "PAGADA"; } elseif(decrypt($status) == 3){ echo "PENDIENTE"; }  ?><br>

            <label class="control-label">Nº de <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento3']; ?>: </label> <?php echo $reg[0]['dnicliente']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?><br>
            
            <label class="control-label">Nº de Telefono: </label> <?php echo $reg[0]['tlfcliente'] == "" ? "********" : $reg[0]['tlfcliente']; ?><br>

            <label class="control-label">Dirección Domiciliaria: </label> <?php echo $reg[0]['direccliente'] == "" ? "********" : $reg[0]['direccliente']; ?>
        </div>
      </div>

          <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Nº</th>
                                  <th>N° de Venta</th>
                                  <th>Descripción de Cliente</th>
                                  <th>Observaciones</th>
                                  <th>Detalles Productos</th>
                                  <th>Estado</th>
                                  <th>Dias Venc</th>
                                  <th>Fecha Emisión</th>
                                  <th>Imp. Total</th>
                                  <th>Total Abono</th>
                                  <th>Total Debe</th>
                                  <th><span class="mdi mdi-drag-horizontal"></span></th>
                                </tr>
                              </thead>
                              <tbody>
<?php
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
                                <tr>
                                  <td><?php echo $a++; ?></td>
  <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong><br> Nº: ".$reg[$i]['codfactura']; ?></td>
  <td><abbr title="<?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : "Nº ".$documento = ($reg[$i]['documcliente'] == '0' ? "DOCUMENTO" : $reg[$i]['documento3']).": ".$reg[$i]['dnicliente']; ?>"><?php echo $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['nomcliente']; ?></abbr></td>
  <td><?php echo $reg[$i]['observaciones'] == '' ? "***********" : $reg[$i]['observaciones']; ?></td>
  <td class="font-10 bold"><?php echo $reg[$i]['detalles_productos']; ?></td>

  <td><?php if($reg[$i]["statusventa"] == 'PAGADA') { echo "<span class='badge badge-success'><i class='fa fa-check'></i> ".$reg[$i]["statusventa"]."</span>"; } 
  elseif($reg[$i]["statusventa"] == 'ANULADA') { echo "<span class='badge badge-warning text-white'><i class='fa fa-exclamation-circle'></i> ".$reg[$i]["statusventa"]."</span>"; }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00" && $reg[$i]['statusventa'] == "PENDIENTE") { echo "<span class='badge badge-danger'><i class='fa fa-times'></i> VENCIDA </span>"; }
  else { echo "<span class='badge badge-info'><i class='fa fa-exclamation-triangle'></i> ".$reg[$i]["statusventa"]."</span>"; } ?></td>

  <td><?php if($reg[$i]['fechavencecredito'] == '0000-00-00' || $reg[$i]['fechavencecredito'] != '0000-00-00' && $reg[$i]['fechapagado'] != "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] >= date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo "0"; } 
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] == "0000-00-00") { echo Dias_Transcurridos(date("Y-m-d"),$reg[$i]['fechavencecredito']); }
  elseif($reg[$i]['fechavencecredito'] < date("Y-m-d") && $reg[$i]['fechapagado'] != "0000-00-00") { echo Dias_Transcurridos($reg[$i]['fechapagado'],$reg[$i]['fechavencecredito']); } ?></td>

  <td><?php echo date("d-m-Y H:i:s",strtotime($reg[$i]['fechaventa'])); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td><?php echo $simbolo.number_format($reg[$i]['totalpago']-$reg[$i]['creditopagado'], 2, '.', ','); ?></td>
  <td>
<?php if($_SESSION['acceso']=="administradorS" || $_SESSION["acceso"]=="secretaria" || $_SESSION["acceso"]=="cajero"){ ?>

<button type="button" class="btn btn-danger btn-rounded waves-effect waves-light" data-placement="left" title="Abonar" data-original-title="" data-href="#" data-toggle="modal" data-target="#myModalPago" data-backdrop="static" data-keyboard="false"
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

 <a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("TICKETCREDITO") ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-warning btn-rounded text-white" title="Imprimir Pdf"><i class="fa fa-folder-open-o"></i></button>

<a href="reportepdf?codventa=<?php echo encrypt($reg[$i]['codventa']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt($reg[$i]['tipodocumento']) ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></td>
                                  </tr>
                        <?php  }  ?>
         <tr class="text-dark alert-link">
           <td colspan="8"></td>
<td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalAbono, 2, '.', ','); ?></td>
<td><?php echo $simbolo.number_format($TotalDebe, 2, '.', ','); ?></td>
         </tr>
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
########################## BUSQUEDA DETALLES CREDITOS POR CLIENTES ##########################
?>

































<?php
######################## MOSTRAR FACTURA PARA NOTA DE CREDITO ########################
if (isset($_GET['ProcesaNotaCredito']) && isset($_GET['codventa']) && isset($_GET['codsucursal']) && isset($_GET['descontar'])) { 
 
  $codventa = limpiar($_GET['codventa']);
  $codsucursal = limpiar($_GET['codsucursal']);
  $descontar = limpiar($_GET['descontar']);
  $codarqueo = limpiar(isset($_GET['codarqueo']) ? $_GET["codarqueo"] : "");

  $reg = $new->BuscarVentasPorId();
  $simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

 if($codventa=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL Nº DE DOCUMENTO CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

 } else if($codsucursal=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
  echo "</div>";
  exit;
   
  } else if(isset($_GET['codarqueo']) && $codarqueo=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

 } elseif($reg==""){
    
  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> EL Nº DE DOCUMENTO INGRESADO NO SE ENCUENTRA REGISTRADO </center>";
  echo "</div>";    

} else {

?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Detalle de <?php echo $reg[0]['tipodocumento']." Nº: ".$reg[0]['codventa']; ?></h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="table-responsive m-t-20">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Devolución</th>
                        <th>Vendido</th>
                        <th>Tipo</th>
                        <th>Descripción de Producto</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$tra = new Login();
$detalle = $tra->BuscarDetallesVentas();

$SubTotal = 0;
$a=1;
$b=0;
$count = 0;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
$c = $b++; 
$count++; 
?>
  <tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;">
  <td>
  <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected input-group-sm">
  <span class="input-group-btn input-group-prepend"><button class="btn btn-classic btn-info bootstrap-touchspin-down input-button" style="cursor:pointer;border-radius:5px 0px 0px 5px;" type="button" onClick="PresionarDetalleDevolucion('a',<?php echo $count; ?>)">-</button></span>
  <input type="text" class="bold" name="devuelto[]" id="devuelto_<?php echo $count; ?>" style="width:60px;height:40px;font-size:14px;background:#e7f8fc;font-weight:bold;" onfocus="this.style.background=('#e7f8fc')" onKeyPress="EvaluateText('%f', this);" onBlur="this.style.background=('#e7f8fc'); this.value = NumberFormat(this.value, '2', '.', '');" onKeyUp="this.value=this.value.toUpperCase(); ProcesarCalculoDevolucion(<?php echo $count; ?>);" autocomplete="off" placeholder="Cantidad" value="0.00" title="Ingrese Cantidad">
  <span class="input-group-btn input-group-append"><button class="btn btn-classic btn-info bootstrap-touchspin-up" type="button" style="cursor:pointer;border-radius:0px 5px 5px 0px;" onClick="PresionarDetalleDevolucion('b',<?php echo $count; ?>)">+</button></span>
  </div>
  </td>

  <td class="text-dark alert-link"><?php echo number_format($detalle[$i]["cantventa"], 2, '.', ''); ?></td>

  <td class="text-danger alert-link"><?php if($detalle[$i]['tipodetalle'] == 1){ echo "PRODUCTO"; } elseif($detalle[$i]['tipodetalle'] == 2){ echo "COMBO"; } else { "SERVICIO"; } ?></td>

  <td class="text-left">
  <input type="hidden" name="coddetalleventa[]" id="coddetalleventa" value="<?php echo encrypt($detalle[$i]["coddetalleventa"]); ?>">
  <input type="hidden" name="idproducto[]" id="idproducto" value="<?php echo $detalle[$i]["idproducto"]; ?>">
  <input type="hidden" name="codproducto[]" id="codproducto" value="<?php echo $detalle[$i]["codproducto"]; ?>">
  <input type="hidden" name="tipodetalle[]" id="tipodetalle" value="<?php echo $detalle[$i]["tipodetalle"]; ?>">
  <input type="hidden" name="producto[]" id="producto" value="<?php echo $detalle[$i]["producto"]; ?>">
  <input type="hidden" name="descripcion[]" id="descripcion" value="<?php echo $detalle[$i]["descripcion"]; ?>">
  <input type="hidden" name="imei[]" id="imei" value="<?php echo $detalle[$i]["imei"]; ?>">
  <input type="hidden" name="condicion[]" id="condicion" value="<?php echo $detalle[$i]["condicion"]; ?>">
  <input type="hidden" name="codmarca[]" id="codmarca" value="<?php echo $detalle[$i]["codmarca"]; ?>">
  <input type="hidden" name="codmodelo[]" id="codmodelo" value="<?php echo $detalle[$i]["codmodelo"]; ?>">
  <input type="hidden" name="codpresentacion[]" id="codpresentacion" value="<?php echo $detalle[$i]["codpresentacion"]; ?>">
  <input type="hidden" name="codcolor[]" id="codcolor" value="<?php echo $detalle[$i]["codcolor"]; ?>">
  <input type="hidden" name="cantidad[]" id="cantidad_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["cantventa"], 2, '.', ''); ?>">
  <h5 class="text-dark alert-link"><?php echo $detalle[$i]['producto']; ?></h5>
  <small >MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
  <td>
  <input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["preciocompra"], 2, '.', ''); ?>">
  <input type="hidden" name="precioventa[]" id="precioventa_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>">
    <input type="hidden" name="precioconiva[]" id="precioconiva_<?php echo $count; ?>" value="<?php echo $detalle[$i]['ivaproducto'] == '0.00' ? "0.00" : number_format($detalle[$i]["precioventa"], 2, '.', ''); ?>"><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ''); ?></td>
  <td>
  <input type="hidden" name="valortotal[]" id="valortotal_<?php echo $count; ?>" value="0.00">
  <label id="txtvalortotal_<?php echo $count; ?>">0.00</label></td>
  
  <td>
  <input type="hidden" name="descproducto[]" id="descproducto_<?php echo $count; ?>" value="<?php echo number_format($detalle[$i]["descproducto"], 2, '.', ''); ?>">
  <input type="hidden" class="totaldescuentov" name="totaldescuentov[]" id="totaldescuentov_<?php echo $count; ?>" value="0.00">
  <?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup>0.00%</sup></td>

  <td>
  <input type="hidden" name="ivaproducto[]" id="ivaproducto_<?php echo $count; ?>" value="<?php echo $detalle[$i]["ivaproducto"]; ?>"><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? $reg[0]['iva']."%" : "(E)"; ?></td>

  <td><input type="hidden" class="subtotalivasi" name="subtotalivasi[]" id="subtotalivasi_<?php echo $count; ?>" value="0.00">

  <input type="hidden" class="subtotalivano" name="subtotalivano[]" id="subtotalivano_<?php echo $count; ?>" value="0.00">

  <input type="hidden" class="subtotalimpuestos" name="subtotalimpuestos[]" id="subtotalimpuestos_<?php echo $count; ?>" value="0.00">

  <input type="hidden" class="subtotaldiscriminado" name="subtotaldiscriminado[]" id="subtotaldiscriminado_<?php echo $count; ?>" value="0.00">

  <input type="hidden" class="valorneto" name="valorneto[]" id="valorneto_<?php echo $count; ?>" value="0.00" >

  <label id="txtvalorneto_<?php echo $count; ?>">0.00</label></td>
    </tr>
    <?php } ?>
    </tbody>
    </table><hr>
    <input type="hidden" name="abonototal" id="abonototal" value="<?php echo number_format($reg[0]["creditopagado"], 2, '.', ''); ?>"/>
    <input type="hidden" name="tipodocumento" id="tipodocumento" value="<?php echo $reg[0]['tipodocumento']; ?>"/>
    <input type="hidden" name="tipopago" id="tipopago" value="<?php echo $reg[0]['tipopago']; ?>"/>
    <input type="hidden" name="codcliente" id="codcliente" value="<?php echo $codigo = ($reg[0]['codcliente'] == "" ? "0" : $reg[0]['codcliente']); ?>"/>

    <table id="carritototal" class="table-responsive">
    <tr>
    <td width="250"><h5><label>Gravado <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:</label></h5></td>
    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal" name="lblsubtotal">0.00</label></h5>
    <input type="hidden" name="txtdiscriminado" id="txtdiscriminado" value="0.00"/>
    <input type="hidden" name="txtsubtotal" id="txtsubtotal" value="0.00"/>    </td>
                  
    <td width="250">
    <h5><label>Exento 0%:</label></h5>    </td>

    <td width="250">
    <h5><?php echo $simbolo; ?><label id="lblsubtotal2" name="lblsubtotal2">0.00</label></h5>
    <input type="hidden" name="txtsubtotal2" id="txtsubtotal2" value="0.00"/>    </td>
    
    <td width="250"><h5><label><?php echo $impuesto; ?> <?php echo number_format($reg[0]['iva'], 2, '.', '') ?>%:<input type="hidden" name="iva" id="iva" autocomplete="off" value="<?php echo number_format($reg[0]['iva'], 2, '.', '') ?>"></label></h5>
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
    <h5><label>Desc. Global <?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>%:</label></h5>    </td>

    <td>
    <h5><?php echo $simbolo; ?><label id="lbldescuento" name="lbldescuento">0.00</label></h5>
    <input type="hidden" name="descuento" id="descuento" value="<?php echo number_format($reg[0]['descuento'], 2, '.', '') ?>">
    <input type="hidden" name="txtDescuento" id="txtDescuento" value="0.00"/></td>

    <td><h4><b>Importe Total</b></h4>
    </td>

    <td class="text-center">
    <h4><b><?php echo $simbolo; ?><label id="lbltotal" name="lbltotal">0.00</label></b></h4>
    <input type="hidden" name="txtTotal" id="txtTotal" value="0.00"/></td>
                    </tr>
                  </table>
        </div>

      <div class="text-right">
<button type="submit" name="btn-submit" id="btn-submit" class="btn btn-primary"><span class="fa fa-save"></span> Guardar Nota</button>
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
######################## MOSTRAR FACTURA PARA NOTA DE CREDITO ########################
?>


<?php
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
if (isset($_GET['BuscaNotaModal']) && isset($_GET['codnota']) && isset($_GET['codsucursal'])) { 
 
$reg = $new->NotaCreditoPorId();
$simbolo = ($reg[0]['simbolo'] == "" ? "" : "<strong>".$reg[0]['simbolo']."</strong>");

  if($reg==""){
    
    echo "<div class='alert alert-danger'>";
    echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
    echo "<center><span class='fa fa-info-circle'></span> NO SE ENCONTRARON VENTAS Y DETALLES ACTUALMENTE </center>";
    echo "</div>";    

} else {

?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
  <h4><b class="text-dark">RAZÓN SOCIAL</b></h4>
  <p class="text-muted m-l-5"><?php echo $reg[0]['nomsucursal']; ?>,
  <br/> Nº <?php echo $reg[0]['documsucursal'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['cuitsucursal']; ?> - TLF: <?php echo $reg[0]['tlfsucursal']; ?></p>

  <h4><b class="text-dark">Nº NOTA CRÉDITO <?php echo $reg[0]['codfactura']; ?></b></h4>
  <p class="text-muted m-l-5">Nº <?php echo $tipo_documento = ($reg[0]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[0]['tipodocumento'])." ".$reg[0]['facturaventa']; ?>

  <br>MOTIVO DE NOTA: <?php echo $reg[0]["observaciones"]; ?>
  
  <br>FECHA DE EMISIÓN: <?php echo date("d-m-Y H:i:s",strtotime($reg[0]['fechanota'])); ?></p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
  <h4><b class="text-dark">CLIENTE</b></h4>
  <p class="text-muted m-l-30"><?php echo $reg[0]['nomcliente'] == '' ? "CONSUMIDOR FINAL" : $reg[0]['nomcliente']; ?>,
  <?php echo $reg[0]['direccliente'] == '' ? "" : "<br/>".$reg[0]['direccliente']; ?>
  <?php echo $reg[0]['provincia2'] == '' ? "" : "<br/>".$reg[0]['provincia2']; ?> <?php echo $reg[0]['departamento2'] == '' ? "" : strtoupper($reg[0]['departamento2']); ?>
  <br/> EMAIL: <?php echo $reg[0]['emailcliente'] == '' ? "*******" : $reg[0]['emailcliente']; ?>
  <br/> Nº <?php echo $reg[0]['documcliente'] == '0' ? "DOCUMENTO" : $reg[0]['documento'] ?>: <?php echo $reg[0]['dnicliente'] == '' ? "*******" : $reg[0]['dnicliente']; ?> - TLF: <?php echo $reg[0]['tlfcliente'] == '' ? "*******" : $reg[0]['tlfcliente']; ?></p>
                                            
                              </address>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <div class="table-responsive m-t-10" style="clear: both;">
                              <table class="table table-hover">
                     <thead>
                        <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Valor Total</th>
                        <th>Desc %</th>
                        <th><?php echo $impuesto; ?></th>
                        <th>Valor Neto</th>
                      </tr>
                      </thead>
                      <tbody>
<?php 
$tra = new Login();
$detalle = $tra->VerDetallesNotasCredito();

$SubTotal = 0;
$a=1;
for($i=0;$i<sizeof($detalle);$i++){  
$SubTotal += $detalle[$i]['valorneto'];
?>
  <tr>
    <td><?php echo $a++; ?></td>
    <td><h5><?php echo $detalle[$i]['producto']; ?></h5>
    <small class="text-dark alert-link">MARCA (<?php echo $detalle[$i]['codmarca'] == '0' ? "*****" : $detalle[$i]['nommarca'] ?>) - MODELO (<?php echo $detalle[$i]['codmodelo'] == '0' ? "*****" : $detalle[$i]['nommodelo'] ?>)</small></td>
    <td><?php echo $detalle[$i]['cantventa']; ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['precioventa'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valortotal'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['totaldescuentov'], 2, '.', ','); ?><sup><?php echo number_format($detalle[$i]['descproducto'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $detalle[$i]['ivaproducto'] != '0.00' ? number_format($detalle[$i]['ivaproducto'], 2, '.', ',')."%" : "(E)"; ?></td>
    <td><?php echo $simbolo.number_format($detalle[$i]['valorneto'], 2, '.', ','); ?></td>
                                      </tr>
                            <?php } ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>


                      <div class="col-md-12">

                          <div class="pull-right text-right">
<p><b>Subtotal:</b> <?php echo $simbolo.number_format($reg[0]["subtotalivasi"]+$reg[0]["subtotalivano"], 2, '.', ','); ?></p>
<p><b>Gravado  <?php echo number_format($reg[0]['iva'], 2, '.', '.') ?>%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivasi'], 2, '.', ','); ?><p>
<p><b>Exento 0%:</b> <?php echo $simbolo.number_format($reg[0]['subtotalivano'], 2, '.', ','); ?></p>
<p><b>Total <?php echo $impuesto; ?> (<?php echo number_format($reg[0]['iva'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaliva'], 2, '.', ','); ?> </p>
<p><b>Descontado %:</b> <?php echo $simbolo.number_format($reg[0]['descontado'], 2, '.', ','); ?></p>
<p><b>Desc. Global (<?php echo number_format($reg[0]['descuento'], 2, '.', ','); ?>%):</b> <?php echo $simbolo.number_format($reg[0]['totaldescuento'], 2, '.', ','); ?> </p>
                                        <hr>
<h4><b>Importe Total:</b> <?php echo $simbolo.number_format($reg[0]['totalpago'], 2, '.', ','); ?></h4></div>
                          <div class="clearfix"></div>
                          <hr>

                      <div class="col-md-12">
                          <div class="text-right">
<a href="reportepdf?codnota=<?php echo encrypt($reg[0]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[0]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO") ?>" target="_blank" rel="noopener noreferrer"><button id="print" class="btn waves-light btn-light" type="button"><span><i class="fa fa-print"></i> Imprimir</span></button></a>
<button type="button" class="btn btn-dark" data-dismiss="modal"><span class="fa fa-times-circle"></span> Cerrar</button>
                          </div>
                      </div>
                  </div>
                <!-- .row -->
<?php
  }
} 
######################## MOSTRAR NOTA DE CREDITO EN VENTANA MODAL ########################
?>

<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ##########################
if (isset($_GET['BuscaNotasxCajas']) && isset($_GET['codsucursal']) && isset($_GET['codcaja']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcaja = limpiar($_GET['codcaja']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;
   
  } else if($codcaja=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE CAJA PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxCajas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos por Caja</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcaja=<?php echo $codcaja; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCAJAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nº de Caja: </label> <?php echo $reg[0]['nrocaja']; ?><br>

            <label class="control-label">Nombre de Caja: </label> <?php echo $reg[0]['nomcaja']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
    <thead>
      <tr>
        <th>N°</th>
        <th>N° de Caja</th>
        <th>N° de Nota</th>
        <th>Nº de Documento</th>
        <th>Descripción de Cliente</th>
        <th>Motivo de Nota</th>
        <th>Fecha Emisión</th>
        <th>SubTotal</th>
        <th><?php echo $impuesto; ?></th>
        <th>Dcto</th>
        <th>Imp. Total</th>
        <th><i class="mdi mdi-drag-horizontal"></i></th>
      </tr>
    </thead>
    <tbody>
<?php
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
  <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $caja = ($reg[$i]['codcaja'] == '0' ? "**********" : $reg[$i]['nrocaja'].": ".$reg[$i]['nomcaja']); ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td>
    <a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
  </tr>
  <?php } ?>
  <tr class="text-dark alert-link">
    <td colspan="7"></td>
    <td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?> </td>
  </tr>
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
########################## BUSQUEDA NOTAS DE CREDITOS POR CAJAS ########################
?>

<?php
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ##########################
if (isset($_GET['BuscaNotasxFechas']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $desde = limpiar($_GET['desde']);
  $hasta = limpiar($_GET['hasta']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($desde=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA DESDE PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;


} else if($hasta=="") {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> POR FAVOR INGRESE FECHA HASTA PARA TU BÚSQUEDA</center>";
  echo "</div>"; 
  exit;

} elseif (strtotime($desde) > strtotime($hasta)) {

  echo "<div class='alert alert-danger'>";
  echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
  echo "<center><span class='fa fa-info-circle'></span> LA FECHA DESDE NO PUEDE SER MAYOR QUE LA FECHA DE FIN</center>";
  echo "</div>"; 
  exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxFechas();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos por Fechas</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&desde=<?php echo $desde; ?>&hasta=<?php echo $hasta; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXFECHAS") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>
      
            <label class="control-label">Fecha Desde: </label> <?php echo date("d-m-Y", strtotime($desde)); ?><br>

            <label class="control-label">Fecha Hasta: </label> <?php echo date("d-m-Y", strtotime($hasta)); ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>N°</th>
                  <th>N° de Nota</th>
                  <th>Nº de Documento</th>
                  <th>Descripción de Cliente</th>
                  <th>Motivo de Nota</th>
                  <th>Fecha Emisión</th>
                  <th>SubTotal</th>
                  <th><?php echo $impuesto; ?></th>
                  <th>Dcto %</th>
                  <th>Imp. Total</th>
                  <th><i class="mdi mdi-drag-horizontal"></i></th>
                  </tr>
                </thead>
                <tbody>
<?php
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
  <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo $reg[$i]['codcliente'] == '' || $reg[$i]['codcliente'] == '0' ? "CONSUMIDOR FINAL" : $reg[$i]['dnicliente'].": ".$reg[$i]['nomcliente']; ?></td>
    <td><?php echo $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td>
    <a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
  </tr>
  <?php } ?>
  <tr class="text-dark alert-link">
    <td colspan="6"></td>
    <td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?> </td>
  </tr>
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
########################## BUSQUEDA NOTAS DE CREDITOS POR FECHAS ########################
?>


<?php
######################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ########################
if (isset($_GET['BuscaNotasxClientes']) && isset($_GET['codsucursal']) && isset($_GET['codcliente'])) {
  
  $codsucursal = limpiar($_GET['codsucursal']);
  $codcliente = limpiar($_GET['codcliente']);

if($codsucursal=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE SUCURSAL PARA TU BÚSQUEDA</center>";
   echo "</div>";   
   exit;

} else if($codcliente=="") {

   echo "<div class='alert alert-danger'>";
   echo "<button type='button' class='close' data-dismiss='alert' aria-text='true'>&times;</button>";
   echo "<center><span class='fa fa-info-circle'></span> POR FAVOR REALICE LA BÚSQUEDA DEL CLIENTE CORRECTAMENTE</center>";
   echo "</div>";   
   exit;

} else {

$pre = new Login();
$reg = $pre->BuscarNotasxClientes();
  ?>

<!-- Row -->
 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header bg-danger">
        <h4 class="card-title text-white"><i class="fa fa-tasks"></i> Notas de Créditos del Cliente</h4>
      </div>

      <div class="form-body">
        <div class="card-body">

          <div class="row">
            <div class="col-md-7">
              <div class="btn-group m-b-20">
              <a class="btn waves-effect waves-light btn-light" href="reportepdf?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTE") ?>" target="_blank" rel="noopener noreferrer"  data-toggle="tooltip" data-placement="bottom" title="Exportar Pdf"><span class="fa fa-file-pdf-o text-dark"></span> Pdf</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("EXCEL") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Excel"><span class="fa fa-file-excel-o text-dark"></span> Excel</a>

              <a class="btn waves-effect waves-light btn-light" href="reporteexcel?codsucursal=<?php echo $codsucursal; ?>&codcliente=<?php echo $codcliente; ?>&documento=<?php echo encrypt("WORD") ?>&tipo=<?php echo encrypt("NOTASCREDITOXCLIENTE") ?>" data-toggle="tooltip" data-placement="bottom" title="Exportar Word"><span class="fa fa-file-word-o text-dark"></span> Word</a>
              </div>
            </div>
          </div>

      <div class="row">
        <div class="col-md-12">
            <label class="control-label">Nombre de Sucursal: </label> <?php echo $reg[0]['nomsucursal']; ?><br>

            <label class="control-label">Nombre de Cliente: </label> <?php echo $reg[0]['nomcliente']; ?>
        </div>
      </div>

  <div id="div2"><table id="datatable-scroller" class="table2 table-hover table-striped table-bordered nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
              <th>N°</th>
              <th>N° de Nota</th>
              <th>Nº de Documento</th>
              <th>Motivo de Nota</th>
              <th>Fecha Emisión</th>
              <th>SubTotal</th>
              <th><?php echo $impuesto; ?></th>
              <th>Dcto %</th>
              <th>Imp. Total</th>
              <th><i class="mdi mdi-drag-horizontal"></i></th>
              </tr>
            </thead>
            <tbody>
<?php
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
  <tr>
    <td><?php echo $a++; ?></td>
    <td><?php echo $reg[$i]['codfactura']; ?></td>
    <td><?php echo "<strong>".$tipo_documento = ($reg[$i]['tipodocumento'] == "FACTURA_A4" ? "FACTURA" : $reg[$i]['tipodocumento'])."</strong> Nº: ".$reg[$i]['facturaventa']; ?></td>
    <td><?php echo $reg[$i]['observaciones']; ?></td>
    <td><?php echo date("d-m-Y",strtotime($reg[$i]['fechanota'])); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['subtotalivasi']+$reg[$i]['subtotalivano'], 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaliva'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['iva'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totaldescuento'], 2, '.', ','); ?><sup><?php echo number_format($reg[$i]['descuento'], 2, '.', ','); ?>%</sup></td>
    <td><?php echo $simbolo.number_format($reg[$i]['totalpago'], 2, '.', ','); ?></td>
    <td>
    <a href="reportepdf?codnota=<?php echo encrypt($reg[$i]['codnota']); ?>&codsucursal=<?php echo encrypt($reg[$i]['codsucursal']); ?>&tipo=<?php echo encrypt("NOTACREDITO"); ?>" target="_blank" rel="noopener noreferrer"><button type="button" class="btn btn-secondary btn-rounded" title="Imprimir Pdf"><i class="fa fa-print"></i></button></a>
    </td>
  </tr>
  <?php  }  ?>
  <tr class="text-dark alert-link">
    <td colspan="5"></td>
    <td><?php echo $simbolo.number_format($TotalSubtotal, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalImpuesto, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalDescuento, 2, '.', ','); ?></td>
    <td><?php echo $simbolo.number_format($TotalImporte, 2, '.', ','); ?></td>
    </tr>
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
########################## BUSQUEDA NOTAS DE CREDITOS POR CLIENTES ##########################

########################## BUSQUEDA PRODUCTOS PARA AUDITORIA ##########################
if (isset($_GET['BuscaProductosAuditoria']) && isset($_GET['codsucursal']) && isset($_GET['fechadesde']) && isset($_GET['fechahasta'])) {

	$codsucursal = decrypt($_GET['codsucursal']);
	$fechadesde = limpiar($_GET['fechadesde']);
	$fechahasta = limpiar($_GET['fechahasta']);
	$codfamilia = isset($_GET['codfamilia']) ? (int)decrypt($_GET['codfamilia']) : 0;

	if (empty($codsucursal)) {
		echo "<div class='alert alert-danger text-center'><span class='fa fa-info-circle'></span> POR FAVOR SELECCIONE UNA SUCURSAL</div>";
		exit;
	}
	if (empty($fechadesde) || empty($fechahasta)) {
		echo "<div class='alert alert-danger text-center'><span class='fa fa-info-circle'></span> POR FAVOR INGRESE EL RANGO DE FECHA Y HORA</div>";
		exit;
	}
	if (strtotime($fechadesde) > strtotime($fechahasta)) {
		echo "<div class='alert alert-danger text-center'><span class='fa fa-info-circle'></span> LA FECHA/HORA INICIAL NO PUEDE SER MAYOR A LA FINAL</div>";
		exit;
	}

	$auditoria = new Login();
	$productos = $auditoria->ConsultarProductosParaAuditoria($codsucursal, $fechadesde, $fechahasta, $codfamilia);

	if (empty($productos)) {
		echo "<div class='alert alert-warning text-center'><span class='fa fa-info-circle'></span> NO SE ENCONTRARON PRODUCTOS PARA LA SUCURSAL SELECCIONADA</div>";
		exit;
	}

	$ventas_anuladas = $auditoria->ConsultarVentasAnuladasAuditoria($codsucursal, $fechadesde, $fechahasta);
	$fechaFiltroConteo = date('Y-m-d', strtotime($fechadesde));
	$conteoInicial = $auditoria->VerificarConteoInicialHoy($codsucursal, $fechaFiltroConteo);
?>
<form class="form" method="post" action="#" name="formguardarauditoria" id="formguardarauditoria">
	<input type="hidden" name="proceso" value="save_auditoria">
	<input type="hidden" name="codsucursal" value="<?php echo encrypt($codsucursal); ?>">
	<input type="hidden" name="fechadesde" value="<?php echo $fechadesde; ?>">
	<input type="hidden" name="fechahasta" value="<?php echo $fechahasta; ?>">

	<!-- Modal Desglose de Ventas por Caja -->
	<div id="modalDesgloseCajas" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-danger text-white">
					<h5 class="modal-title font-weight-bold" id="tituloModalDesglose"><i class="fa fa-desktop"></i> Desglose de Ventas por Caja</h5>
					<button type="button" class="close text-white" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body" id="contenidoDesgloseCajas">
					<!-- Se carga por AJAX -->
				</div>
			</div>
		</div>
	</div>

	<!-- Panel de Estado del Conteo Inicial de la Sucursal -->
	<div class="card border-info mb-3 shadow-sm">
		<div class="card-header bg-light py-2 d-flex justify-content-between align-items-center flex-wrap">
			<div>
				<i class="fa fa-clipboard-check fa-lg text-info mr-1"></i>
				<?php if (!empty($conteoInicial)) { ?>
					<strong>Inventario Inicial de Sucursal (<?php echo date("d/m/Y", strtotime($fechaFiltroConteo)); ?>):</strong> Registrado a las <span class="badge badge-success font-12"><?php echo date("h:i A", strtotime($conteoInicial['fechaconteo'])); ?></span> por <strong><?php echo htmlspecialchars($conteoInicial['nomusuario'] ?? 'Cajero'); ?></strong>.
				<?php } else { ?>
					<strong>Inventario Inicial de Sucursal (<?php echo date("d/m/Y", strtotime($fechaFiltroConteo)); ?>):</strong> <span class="badge badge-warning text-dark font-12">Pendiente / No realizado aún</span>
				<?php } ?>
			</div>
			<div class="mt-1 mt-md-0">
				<?php if (!empty($conteoInicial)) { ?>
					<button type="button" class="btn btn-xs btn-info font-weight-bold mr-1" onclick="AbrirModalConteoInicial('<?php echo encrypt($conteoInicial['idconteo']); ?>')">
						<i class="fa fa-eye"></i> Ver / Corregir Conteo
					</button>
					<button type="button" class="btn btn-xs btn-danger font-weight-bold" onclick="DesbloquearConteoInicial('<?php echo encrypt($conteoInicial['idconteo']); ?>', '<?php echo htmlspecialchars($conteoInicial['nomsucursal'] ?? 'esta sucursal'); ?>')">
						<i class="fa fa-unlock"></i> 🔓 Desbloquear y Permitir Re-conteo
					</button>
				<?php } ?>
			</div>
		</div>
	</div>

	<?php if (!empty($ventas_anuladas)) { ?>
	<!-- Panel de Alerta: Ventas y Productos Anulados en el Periodo -->
	<div class="card border-warning mb-3">
		<div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center py-2">
			<h6 class="font-weight-bold mb-0">
				<i class="fa fa-exclamation-triangle fa-lg text-danger mr-1"></i> 
				🔴 PANEL DE CONTROL: <?php echo count($ventas_anuladas); ?> PRODUCTOS ANULADOS / TICKETS CANCELADOS EN ESTE TURNO
			</h6>
			<button type="button" class="btn btn-xs btn-dark" data-toggle="collapse" data-target="#panelAnuladas">
				<i class="fa fa-eye"></i> Ver / Ocultar Detalles
			</button>
		</div>
		<div class="collapse show" id="panelAnuladas">
			<div class="card-body p-2 bg-light">
				<div class="table-responsive" style="max-height: 220px; overflow-y: auto;">
					<table class="table table-sm table-bordered table-striped mb-0 font-11">
						<thead class="bg-dark text-white text-center">
							<tr>
								<th>#</th>
								<th>Hora Anulación</th>
								<th>Ticket / Factura</th>
								<th>Caja</th>
								<th>Cajero / Usuario</th>
								<th>Producto Anulado</th>
								<th>Cant.</th>
								<th>Monto Anulado</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$va_i = 1;
							$total_anulados_dinero = 0;
							foreach ($ventas_anuladas as $va) {
								$total_anulados_dinero += (float)$va['valortotal'];
							?>
							<tr>
								<td class="text-center font-weight-bold"><?php echo $va_i++; ?></td>
								<td class="text-center"><?php echo date("d/m/Y h:i A", strtotime($va['fechaventa'])); ?></td>
								<td class="text-center font-weight-bold text-danger"><?php echo htmlspecialchars($va['txtdocumento'] ?: $va['codventa']); ?></td>
								<td><?php echo htmlspecialchars($va['nomcaja'] ?? 'Caja Principal'); ?></td>
								<td><?php echo htmlspecialchars($va['nomusuario'] ?? 'N/A'); ?></td>
								<td><strong><?php echo htmlspecialchars($va['producto']); ?></strong> (Cód: <?php echo htmlspecialchars($va['codproducto']); ?>)</td>
								<td class="text-center font-weight-bold text-danger"><?php echo number_format($va['cantventa'], 0); ?></td>
								<td class="text-right font-weight-bold text-danger">$ <?php echo number_format($va['valortotal'], 2, '.', ','); ?></td>
							</tr>
							<?php } ?>
							<tr class="bg-warning text-dark font-weight-bold">
								<td colspan="6" class="text-right">TOTAL DINERO ANULADO EN EL TURNO:</td>
								<td class="text-center"><?php echo count($ventas_anuladas); ?> ítem(s)</td>
								<td class="text-right font-14">$ <?php echo number_format($total_anulados_dinero, 2, '.', ','); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
				<small class="text-muted d-block mt-1"><i class="fa fa-info-circle"></i> <strong>Nota del Auditor:</strong> Si un producto fue anulado después de ser entregado, no debe faltar físicamente en refrigeradores/barra a menos que haya sido devuelto.</small>
			</div>
		</div>
	</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header bg-danger d-flex justify-content-between align-items-center flex-wrap">
					<h4 class="card-title text-white mb-0"><i class="fa fa-clipboard-check"></i> Hoja de Trabajo de Auditoría (<?php echo count($productos); ?> Productos)</h4>
					<div>
						<button type="button" class="btn btn-sm btn-light font-weight-bold mr-1" onclick="CopiarTeoricoAFisico()"><i class="fa fa-magic text-primary"></i> Copiar Teórico a Físico</button>
						<button type="button" class="btn btn-sm btn-light font-weight-bold" onclick="LimpiarCuaderno()"><i class="fa fa-eraser text-danger"></i> Limpiar Cuaderno</button>
					</div>
				</div>

				<div class="card-body">
					<!-- Banner de Resumen Dinámico -->
					<div class="row mb-3">
						<div class="col-md-3 col-sm-6 mb-2">
							<div class="p-3 bg-light border rounded text-center">
								<small class="text-muted text-uppercase font-weight-bold d-block">Total Productos</small>
								<span class="h4 font-weight-bold text-dark" id="lbl_total_items"><?php echo count($productos); ?></span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 mb-2">
							<div class="p-3 bg-light border rounded text-center">
								<small class="text-muted text-uppercase font-weight-bold d-block">Total Faltantes (U)</small>
								<span class="h4 font-weight-bold text-danger" id="lbl_total_faltantes">0.00</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 mb-2">
							<div class="p-3 bg-light border rounded text-center">
								<small class="text-muted text-uppercase font-weight-bold d-block">Total Sobrantes (U)</small>
								<span class="h4 font-weight-bold text-info" id="lbl_total_sobrantes">0.00</span>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 mb-2">
							<div class="p-3 bg-light border rounded text-center">
								<small class="text-muted text-uppercase font-weight-bold d-block">Valor Faltante (Bs.)</small>
								<span class="h4 font-weight-bold text-danger" id="lbl_monto_faltante">Bs. 0.00</span>
							</div>
						</div>
					</div>

					<?php
					$descuadres_inicio = 0;
					$monto_descuadre_inicio = 0;
					foreach ($productos as $p_chk) {
						$ini_chk = (!empty($p_chk['conteo_cajero']) && (float)$p_chk['conteo_cajero'] > 0) ? (float)$p_chk['conteo_cajero'] : 0;
						$stock_chk = (float)$p_chk['existencia'];
						if ($ini_chk > 0 && abs($ini_chk - $stock_chk) > 0.001) {
							$descuadres_inicio++;
							$dif_u = $ini_chk - $stock_chk;
							if ($dif_u < 0) {
								$monto_descuadre_inicio += abs($dif_u) * (float)$p_chk['precioxpublico'];
							}
						}
					}
					$verif_conteo_apertura = $auditoria->VerificarConteoInicialHoy($codsucursal, substr($fechadesde, 0, 10));
					if ($descuadres_inicio > 0) {
					?>
					<div class="alert alert-danger border-danger d-flex align-items-center justify-content-between flex-wrap p-3 mb-3 shadow-sm">
						<div>
							<h5 class="alert-heading font-weight-bold text-danger mb-1">
								<i class="fa fa-exclamation-triangle"></i> ¡ALERTA DE DESCUADRE EN APERTURA DE TURNO (2:00 PM)!
							</h5>
							<p class="mb-0 text-dark">
								Se detectaron <strong><?php echo $descuadres_inicio; ?> producto(s)</strong> donde el conteo físico declarado por la cajera <strong>NO COINCIDE</strong> con el stock del sistema.
								<?php if ($monto_descuadre_inicio > 0) { ?>
								<strong class="text-danger">(Faltante al Abrir: Bs. <?php echo number_format($monto_descuadre_inicio, 2, '.', ','); ?>)</strong>
								<?php } ?>
							</p>
						</div>
						<div class="mt-2 mt-md-0">
							<?php if ($verif_conteo_apertura && !empty($verif_conteo_apertura['idconteo'])) { ?>
							<a href="reportepdf?idconteo=<?php echo encrypt($verif_conteo_apertura['idconteo']); ?>&tipo=<?php echo encrypt("DISCREPANCIAS_CONTEO"); ?>" target="_blank" class="btn btn-danger font-weight-bold shadow">
								<i class="fa fa-file-pdf-o"></i> 📄 Exportar Acta para el Dueño (PDF)
							</a>
							<?php } ?>
						</div>
					</div>
					<?php } ?>

					<div class="table-responsive">
						<table id="tabla_auditoria" class="table table-hover table-bordered table-striped" style="font-size: 13px;">
							<thead class="bg-dark text-white text-center">
								<tr>
									<th style="width: 35px;">#</th>
									<th style="min-width: 170px;" class="text-left">Producto</th>
									<th style="min-width: 110px;">Inicial Cuad. ✍️</th>
									<th style="min-width: 65px;">Compras (+)</th>
									<th style="min-width: 65px;">Trasp. (+)</th>
									<th style="min-width: 95px;" class="text-danger">Ventas (-)</th>
									<th style="min-width: 65px;" class="text-warning">Trasp. (-)</th>
									<th style="min-width: 65px;" class="text-info" title="Retiros de Dueña, Consumo Interno, Mermas autorizadas">Bajas (-)</th>
									<th style="min-width: 85px;" class="bg-primary text-white">Stock Teór.</th>
									<th style="min-width: 95px;">Físico Final ✍️</th>
									<th style="min-width: 85px;">Diferencia</th>
									<th style="min-width: 85px;">Precio Venta</th>
									<th style="min-width: 90px;">Valor Dif. (Bs.)</th>
									<th style="min-width: 160px; background-color: #343a40; color: #ffc107;">Gestión de Faltante ⚖️</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$n = 1;
								foreach ($productos as $i => $p) {
									$entradas_compras = (float)$p['compras_entradas'];
									$entradas_traspasos = (float)$p['traspasos_entradas'];
									$salidas_ventas = (float)$p['ventas_pos'];
									$salidas_traspasos = (float)$p['traspasos_salidas'];
									$salidas_bajas = (float)($p['bajas_salidas'] ?? 0);
									$precioventa = (float)$p['precioxpublico'];
									$preciocompra = (float)$p['preciocompra'];
									$conteo_cajero_ini = (!empty($p['conteo_cajero']) && (float)$p['conteo_cajero'] > 0) ? (float)$p['conteo_cajero'] : 0;
								?>
								<tr class="fila-auditoria" id="fila_<?php echo $i; ?>" data-index="<?php echo $i; ?>">
									<td class="text-center font-weight-bold align-middle"><?php echo $n++; ?></td>
									<td class="align-middle">
										<input type="hidden" name="idproducto[]" value="<?php echo $p['idproducto']; ?>">
										<input type="hidden" name="codproducto[]" value="<?php echo htmlspecialchars($p['codproducto']); ?>">
										<input type="hidden" name="producto[]" value="<?php echo htmlspecialchars($p['producto']); ?>">
										<input type="hidden" name="preciocompra[]" id="preciocompra_<?php echo $i; ?>" value="<?php echo $preciocompra; ?>">
										<input type="hidden" name="precioventa[]" id="precioventa_<?php echo $i; ?>" value="<?php echo $precioventa; ?>">
										<input type="hidden" name="entradas_compras[]" id="entradas_compras_<?php echo $i; ?>" value="<?php echo $entradas_compras; ?>">
										<input type="hidden" name="entradas_traspasos[]" id="entradas_traspasos_<?php echo $i; ?>" value="<?php echo $entradas_traspasos; ?>">
										<input type="hidden" name="salidas_ventas[]" id="salidas_ventas_<?php echo $i; ?>" value="<?php echo $salidas_ventas; ?>">
										<input type="hidden" name="salidas_traspasos[]" id="salidas_traspasos_<?php echo $i; ?>" value="<?php echo $salidas_traspasos; ?>">
										<input type="hidden" name="salidas_bajas[]" id="salidas_bajas_<?php echo $i; ?>" value="<?php echo $salidas_bajas; ?>">
										
										<strong><?php echo htmlspecialchars($p['producto']); ?></strong>
										<br><small class="text-muted">Cód: <?php echo htmlspecialchars($p['codproducto']); ?> | Stock Sistema: <strong><?php echo number_format($p['existencia'], 0); ?></strong></small>
									</td>
									<td class="text-center align-middle">
										<input type="number" step="any" min="0" class="form-control form-control-sm text-center font-weight-bold input-cuaderno" name="inicial_cuaderno[]" id="inicial_cuaderno_<?php echo $i; ?>" value="<?php echo $conteo_cajero_ini; ?>" oninput="CalcularFila(<?php echo $i; ?>)" style="background-color: #fff9e6; border: 2px solid #ffc107;">
										<?php 
										if ($conteo_cajero_ini > 0) {
											$dif_inicio = $conteo_cajero_ini - (float)$p['existencia'];
											if (abs($dif_inicio) < 0.001) { ?>
												<span class="badge badge-success d-block mt-1 font-10" title="El conteo de la cajera coincide con el stock del sistema (<?php echo number_format($p['existencia'], 0); ?>)">
													<i class="fa fa-check"></i> Cuadra Stock (<?php echo number_format($p['existencia'], 0); ?>)
												</span>
											<?php } elseif ($dif_inicio < 0) { ?>
												<span class="badge badge-danger d-block mt-1 font-10" title="Cajera contó <?php echo number_format($conteo_cajero_ini, 0); ?> pero en sistema hay <?php echo number_format($p['existencia'], 0); ?>">
													<i class="fa fa-exclamation-triangle"></i> Falta inicio: <?php echo number_format($dif_inicio, 0); ?>u
												</span>
											<?php } else { ?>
												<span class="badge badge-info d-block mt-1 font-10" title="Cajera contó <?php echo number_format($conteo_cajero_ini, 0); ?> pero en sistema hay <?php echo number_format($p['existencia'], 0); ?>">
													<i class="fa fa-info-circle"></i> Sobra inicio: +<?php echo number_format($dif_inicio, 0); ?>u
												</span>
											<?php }
										} ?>
									</td>
									<td class="text-center align-middle text-success font-weight-bold"><?php echo $entradas_compras > 0 ? "+".number_format($entradas_compras, 0) : "0"; ?></td>
									<td class="text-center align-middle text-success font-weight-bold"><?php echo $entradas_traspasos > 0 ? "+".number_format($entradas_traspasos, 0) : "0"; ?></td>
									<td class="text-center align-middle">
										<span class="text-danger font-weight-bold d-block"><?php echo $salidas_ventas > 0 ? "-".number_format($salidas_ventas, 0) : "0"; ?></span>
										<?php if (!empty($p['ventas_combos']) && (float)$p['ventas_combos'] > 0) { ?>
											<small class="text-muted d-block font-10" title="Desglose: <?php echo number_format($p['ventas_directas'], 0); ?> sueltas + <?php echo number_format($p['ventas_combos'], 0); ?> en combos">
												<i class="fa fa-cubes text-warning"></i> <?php echo number_format($p['ventas_directas'], 0); ?>u + <?php echo number_format($p['ventas_combos'], 0); ?>cb
											</small>
										<?php } ?>
										<?php if ($salidas_ventas > 0) { ?>
											<button type="button" class="btn btn-outline-danger btn-xs font-10 px-1 py-0 mt-1 shadow-sm" onclick="VerDesgloseCajas(<?php echo $p['idproducto']; ?>, '<?php echo htmlspecialchars(addslashes($p['producto'])); ?>')">
												<i class="fa fa-desktop"></i> Cajas
											</button>
										<?php } ?>
									</td>
									<td class="text-center align-middle text-warning font-weight-bold"><?php echo $salidas_traspasos > 0 ? "-".number_format($salidas_traspasos, 0) : "0"; ?></td>
									<td class="text-center align-middle text-info font-weight-bold" title="Retiros autorizados de Dueña / Consumo / Mermas"><?php echo $salidas_bajas > 0 ? "-".number_format($salidas_bajas, 0) : "0"; ?></td>
									<td class="text-center align-middle">
										<input type="hidden" name="stock_teorico[]" id="stock_teorico_<?php echo $i; ?>" value="0">
										<span class="badge badge-primary p-2 font-13" id="badge_teorico_<?php echo $i; ?>">0.00</span>
									</td>
									<td class="text-center align-middle">
										<input type="number" step="any" min="0" class="form-control form-control-sm text-center font-weight-bold input-fisico" name="fisico_final[]" id="fisico_final_<?php echo $i; ?>" value="0" oninput="CalcularFila(<?php echo $i; ?>)" style="background-color: #f0f7ff; border: 2px solid #007bff;">
									</td>
									<td class="text-center align-middle">
										<input type="hidden" name="diferencia[]" id="diferencia_<?php echo $i; ?>" value="0">
										<span class="badge badge-success p-2 font-13 badge-dif" id="badge_diferencia_<?php echo $i; ?>">0.00</span>
									</td>
									<td class="text-center align-middle font-weight-bold">Bs. <?php echo number_format($precioventa, 2, '.', ','); ?></td>
									<td class="text-center align-middle">
										<input type="hidden" name="valordiferencia[]" id="valordiferencia_<?php echo $i; ?>" value="0">
										<span class="font-weight-bold span-valor-dif" id="span_valor_<?php echo $i; ?>">Bs. 0.00</span>
									</td>
									<td class="align-middle p-1" id="col_gestion_<?php echo $i; ?>" style="background-color: #fafbfc;">
										<div class="gestion-faltante-box" id="box_gestion_<?php echo $i; ?>" style="display: none;">
											<select class="form-control form-control-sm mb-1 font-11 font-weight-bold text-danger border-danger" name="accion_diferencia[]" id="accion_diferencia_<?php echo $i; ?>">
												<option value="NINGUNA">-- Acción Faltante --</option>
												<option value="COBRO_CAJERO">⚖️ Cobro a Cajero</option>
												<option value="MERMA_ROTURA">🍷 Merma / Botella Rota</option>
												<option value="ERROR_CONTEO">📝 Error de Conteo</option>
												<option value="PERDIDA_EMPRESA">🏢 Pérdida Empresa</option>
											</select>
											<input type="text" class="form-control form-control-sm font-11 mb-1" name="responsable_diferencia[]" id="responsable_diferencia_<?php echo $i; ?>" placeholder="Cajero / Turno">
											<input type="text" class="form-control form-control-sm font-10" name="motivo_diferencia[]" id="motivo_diferencia_<?php echo $i; ?>" placeholder="Justificación...">
										</div>
										<span class="text-muted font-11 d-block text-center sin-faltante-lbl" id="lbl_ok_<?php echo $i; ?>"><i class="fa fa-check text-success"></i> Sin Faltante</span>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>

					<div class="row mt-4">
						<div class="col-md-8">
							<div class="form-group">
								<label class="control-label font-weight-bold">Observaciones / Notas de la Auditoría:</label>
								<textarea class="form-control" name="observaciones" id="observaciones" rows="3" placeholder="Escriba aquí cualquier novedad o aclaración sobre la auditoría del turno..."></textarea>
							</div>
						</div>
						<div class="col-md-4 d-flex align-items-end justify-content-end mb-3">
							<button type="button" class="btn btn-success btn-lg btn-block font-weight-bold shadow" onclick="GuardarAuditoria()"><i class="fa fa-save"></i> GUARDAR AUDITORÍA</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>
<?php
}
########################## FIN BUSQUEDA PRODUCTOS PARA AUDITORIA ##########################

########################## AJAX DESGLOSE VENTAS POR CAJA ##########################
if (isset($_GET['DesgloseVentasCajas']) && isset($_GET['idproducto'])) {
	$idproducto = (int)$_GET['idproducto'];
	$codsucursal = !empty($_GET['codsucursal']) ? (int)decrypt($_GET['codsucursal']) : 0;
	$fechadesde = limpiar($_GET['fechadesde']);
	$fechahasta = limpiar($_GET['fechahasta']);

	$login = new Login();
	$desglose = $login->ConsultarDesgloseVentasProducto($idproducto, $codsucursal, $fechadesde, $fechahasta);

	if (empty($desglose)) {
		echo "<div class='alert alert-info text-center py-3 mb-0'><i class='fa fa-info-circle'></i> No se encontraron ventas registradas para este producto en el rango horario seleccionado.</div>";
		exit;
	}
?>
	<table class="table table-bordered table-sm table-striped mb-0 font-12">
		<thead class="bg-danger text-white text-center">
			<tr>
				<th>Caja / Terminal</th>
				<th>Cajero Responsable</th>
				<th>Venta Suelta</th>
				<th>Venta en Combos</th>
				<th>Total Unidades</th>
				<th>Total Recaudado</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$tot_cant = 0;
			$tot_directa = 0;
			$tot_combos = 0;
			$tot_dinero = 0;
			foreach ($desglose as $d) {
				$tot_cant += (float)$d['total_vendido'];
				$tot_directa += (float)$d['cant_directa'];
				$tot_combos += (float)$d['cant_combos'];
				$tot_dinero += (float)$d['importe_total'];
			?>
			<tr>
				<td class="font-weight-bold align-middle"><?php echo htmlspecialchars($d['nomcaja'] ?? 'Caja #'.$d['nrocaja']); ?></td>
				<td class="align-middle"><?php echo htmlspecialchars($d['nomusuario'] ?? 'Sin cajero asignado'); ?></td>
				<td class="text-center font-weight-bold text-dark align-middle"><?php echo number_format($d['cant_directa'], 0); ?> u.</td>
				<td class="text-center font-weight-bold text-warning align-middle"><?php echo number_format($d['cant_combos'], 0); ?> u.</td>
				<td class="text-center font-weight-bold text-danger align-middle font-14"><?php echo number_format($d['total_vendido'], 0); ?> u.</td>
				<td class="text-right font-weight-bold align-middle">$ <?php echo number_format($d['importe_total'], 2, '.', ','); ?></td>
			</tr>
			<?php } ?>
			<tr class="bg-light font-weight-bold">
				<td colspan="2" class="text-right">TOTAL GENERAL:</td>
				<td class="text-center text-dark font-14"><?php echo number_format($tot_directa, 0); ?> u.</td>
				<td class="text-center text-warning font-14"><?php echo number_format($tot_combos, 0); ?> u.</td>
				<td class="text-center text-danger font-14"><?php echo number_format($tot_cant, 0); ?> u.</td>
				<td class="text-right font-14 text-dark">$ <?php echo number_format($tot_dinero, 2, '.', ','); ?></td>
			</tr>
		</tbody>
	</table>
<?php
	exit;
}
########################## FIN DESGLOSE VENTAS POR CAJA ##########################

########################## BUSQUEDA HISTORIAL AUDITORIAS ##########################
if (isset($_GET['BuscaHistorialAuditorias']) && isset($_GET['codsucursal']) && isset($_GET['desde']) && isset($_GET['hasta'])) {

	$codsucursal = !empty($_GET['codsucursal']) ? (int)decrypt($_GET['codsucursal']) : 0;
	$desde = limpiar($_GET['desde']);
	$hasta = limpiar($_GET['hasta']);

	$auditoria = new Login();
	$registros = $auditoria->BuscarAuditoriasxFechas($codsucursal, $desde, $hasta);

	if (empty($registros)) {
		echo "<div class='alert alert-warning text-center'><span class='fa fa-info-circle'></span> NO SE ENCONTRARON AUDITORIAS EN EL RANGO SELECCIONADO</div>";
		exit;
	}
?>
<div class="table-responsive">
	<table id="tabla_historial_auditorias" class="table table-striped table-bordered display">
		<thead class="bg-danger text-white text-center">
			<tr>
				<th>Nº</th>
				<th>Sucursal</th>
				<th>Rango Auditado (Desde - Hasta)</th>
				<th>Fecha Registro</th>
				<th>Realizado Por</th>
				<th>Prod. Auditados</th>
				<th>Faltantes (U)</th>
				<th>Sobrantes (U)</th>
				<th>Monto Faltante</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$a = 1;
			foreach ($registros as $r) {
			?>
			<tr>
				<td class="text-center font-weight-bold"><?php echo $a++; ?></td>
				<td><?php echo htmlspecialchars($r['cuitsucursal'] . " - " . $r['nomsucursal']); ?></td>
				<td class="text-center">
					<small class="d-block font-weight-bold text-dark"><?php echo date("d/m/Y h:i A", strtotime($r['fechadesde'])); ?></small>
					<small class="text-muted">hasta</small>
					<small class="d-block font-weight-bold text-dark"><?php echo date("d/m/Y h:i A", strtotime($r['fechahasta'])); ?></small>
				</td>
				<td class="text-center"><?php echo date("d/m/Y h:i A", strtotime($r['fecharegistro'])); ?></td>
				<td><?php echo htmlspecialchars($r['nomusuario'] ?? 'Administrador'); ?></td>
				<td class="text-center font-weight-bold"><?php echo $r['total_productos']; ?></td>
				<td class="text-center font-weight-bold text-danger"><?php echo number_format($r['total_faltantes'], 0); ?></td>
				<td class="text-center font-weight-bold text-info"><?php echo number_format($r['total_sobrantes'], 0); ?></td>
				<td class="text-center font-weight-bold text-danger">$ <?php echo number_format($r['monto_faltante'], 2, '.', ','); ?></td>
				<td class="text-center">
					<a href="reportepdf?idauditoria=<?php echo encrypt($r['idauditoria']); ?>&tipo=<?php echo encrypt("AUDITORIAPRODUCTOS"); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-danger btn-sm" title="Descargar PDF"><i class="fa fa-file-pdf-o"></i> PDF</a>
					<a href="reporteexcel?idauditoria=<?php echo encrypt($r['idauditoria']); ?>&documento=<?php echo encrypt("EXCEL"); ?>&tipo=<?php echo encrypt("AUDITORIAPRODUCTOS"); ?>" class="btn btn-success btn-sm" title="Descargar Excel"><i class="fa fa-file-excel-o"></i> Excel</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<?php
}
########################## FIN BUSQUEDA HISTORIAL AUDITORIAS ##########################

########################## MODAL Y PROCESO CONTEO INICIAL CAJERO (CONTEO A CIEGAS) ##########################
if (isset($_GET['CargaModalConteoInicial'])) {
	$login = new Login();
	$codsucursal = isset($_SESSION['codsucursal']) ? (int)$_SESSION['codsucursal'] : 0;
	if (!empty($_GET['codsucursal'])) {
		$decSuc = decrypt($_GET['codsucursal']);
		if (is_numeric($decSuc) && $decSuc > 0) {
			$codsucursal = (int)$decSuc;
		} else if (is_numeric($_GET['codsucursal'])) {
			$codsucursal = (int)$_GET['codsucursal'];
		}
	}

	$idconteo = 0;
	if (!empty($_GET['idconteo'])) {
		$dec = decrypt($_GET['idconteo']);
		if (is_numeric($dec) && $dec > 0) {
			$idconteo = (int)$dec;
		} else if (is_numeric($_GET['idconteo']) && (int)$_GET['idconteo'] > 0) {
			$idconteo = (int)$_GET['idconteo'];
		}
	}

	// Si no vino idconteo pero tenemos codsucursal, verificamos si ya contó hoy
	if ($idconteo == 0 && $codsucursal > 0) {
		$conteoHoy = $login->VerificarConteoInicialHoy($codsucursal);
		if ($conteoHoy && !empty($conteoHoy['idconteo'])) {
			$idconteo = (int)$conteoHoy['idconteo'];
		}
	}

	// Si ya está registrado, mostramos el resumen y botón para ver/imprimir PDF / editar
	if ($idconteo > 0) {
		$data = $login->BuscarConteoInicialPorId($idconteo);
		if ($data && !empty($data['cabecera'])) {
			$cab = $data['cabecera'];
			$det = $data['detalles'];
		?>
		<div class="alert alert-success text-center mb-3">
			<h4 class="alert-heading font-weight-bold mb-1"><i class="fa fa-check-circle"></i> ¡Inventario Inicial Ya Registrado!</h4>
			<p class="mb-0">Registrado por <strong><?php echo htmlspecialchars($cab['nomusuario'] ?? $_SESSION['nombres']); ?></strong> el <strong><?php echo date("d/m/Y h:i A", strtotime($cab['fechaconteo'])); ?></strong>.</p>
		</div>

		<?php
		$isAdmin = (isset($_SESSION['acceso']) && ($_SESSION['acceso'] == "administradorG" || $_SESSION['acceso'] == "administradorS"));
		?>
		<?php if ($isAdmin) { ?>
		<!-- Panel Exclusivo de Administrador -->
		<form id="form_edicion_conteo_admin" onsubmit="return false;">
		<input type="hidden" name="idconteo" value="<?php echo encrypt($cab['idconteo']); ?>">
		<div class="alert alert-info py-2 px-3 mb-2 d-flex justify-content-between align-items-center flex-wrap">
			<div>
				<i class="fa fa-shield fa-lg text-primary mr-1"></i>
				<strong>Opciones de Administrador:</strong> Si la sucursal se equivocó, puedes permitirle contar de nuevo o corregir valores.
			</div>
			<div class="mt-1 mt-md-0">
				<button type="button" class="btn btn-sm btn-outline-primary font-weight-bold" id="btn_habilitar_edicion_conteo" onclick="HabilitarEdicionConteoAdmin()">
					<i class="fa fa-pencil"></i> ✏️ Corregir Cantidades
				</button>
				<button type="button" class="btn btn-sm btn-danger font-weight-bold ml-1" onclick="DesbloquearConteoInicial('<?php echo encrypt($cab['idconteo']); ?>', '<?php echo htmlspecialchars($cab['nomsucursal'] ?? 'esta sucursal'); ?>')">
					<i class="fa fa-unlock"></i> 🔓 Permitir Re-conteo (Desbloquear)
				</button>
			</div>
		</div>
		<?php } ?>

		<div class="d-flex justify-content-between align-items-center flex-wrap mb-2">
			<span class="font-weight-bold text-dark"><i class="fa fa-cubes"></i> Total Ítems Contados: <?php echo count($det); ?></span>
			<div class="mt-1 mt-md-0">
				<?php if ($isAdmin) { ?>
				<a href="reportepdf?idconteo=<?php echo encrypt($cab['idconteo']); ?>&tipo=<?php echo encrypt("DISCREPANCIAS_CONTEO"); ?>" target="_blank" class="btn btn-warning font-weight-bold text-dark shadow-sm mr-1">
					<i class="fa fa-file-pdf-o text-danger"></i> 📄 Exportar Acta para el Dueño (PDF)
				</a>
				<?php } ?>
				<a href="reportepdf?idconteo=<?php echo encrypt($cab['idconteo']); ?>&tipo=<?php echo encrypt("CONTEOINICIAL"); ?>" target="_blank" class="btn btn-danger font-weight-bold shadow-sm">
					<i class="fa fa-print"></i> Comprobante Físico (WhatsApp)
				</a>
			</div>
		</div>

		<div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
			<table class="table table-striped table-bordered table-sm mb-0">
				<thead class="bg-warning text-dark font-weight-bold text-center">
					<tr>
						<th style="width: 45px;">#</th>
						<th style="width: 110px;">Código</th>
						<th>Producto</th>
						<?php if ($isAdmin) { ?>
						<th style="width: 110px;" class="bg-dark text-white">Stock Sistema</th>
						<th style="width: 120px;" class="bg-warning text-dark">Físico Cajera</th>
						<th style="width: 110px;">Diferencia</th>
						<th style="width: 120px;">Diagnóstico</th>
						<?php } else { ?>
						<th style="width: 140px;">Cantidad Física</th>
						<?php } ?>
					</tr>
				</thead>
				<tbody>
					<?php 
					$c = 1;
					foreach ($det as $item) {
						$stock_sis = (float)($item['stock_sistema'] ?? 0);
						$fisico_caj = (float)$item['cantidad_fisica'];
						$dif_ap = $fisico_caj - $stock_sis;
					?>
					<tr>
						<td class="text-center font-weight-bold align-middle"><?php echo $c++; ?></td>
						<td class="text-center align-middle"><?php echo htmlspecialchars($item['codproducto']); ?></td>
						<td class="align-middle"><strong><?php echo htmlspecialchars($item['producto']); ?></strong></td>
						<?php if ($isAdmin) { ?>
						<td class="text-center font-weight-bold align-middle bg-light text-dark font-14"><?php echo number_format($stock_sis, 0); ?></td>
						<td class="text-center font-weight-bold align-middle font-15 text-primary" style="background-color: #fff9e6;">
							<span class="vista-lectura-conteo"><?php echo number_format($fisico_caj, 0); ?></span>
							<div class="vista-edicion-conteo" style="display: none;">
								<input type="hidden" name="iddetalleconteo[]" value="<?php echo $item['iddetalleconteo']; ?>">
								<input type="number" step="any" min="0" class="form-control form-control-sm text-center font-weight-bold border-danger" name="cantidad_fisica[]" value="<?php echo $fisico_caj; ?>">
							</div>
						</td>
						<td class="text-center font-weight-bold align-middle font-14">
							<?php if (abs($dif_ap) < 0.001) { ?>
								<span class="text-success">0</span>
							<?php } elseif ($dif_ap < 0) { ?>
								<span class="text-danger"><?php echo number_format($dif_ap, 0); ?></span>
							<?php } else { ?>
								<span class="text-info">+<?php echo number_format($dif_ap, 0); ?></span>
							<?php } ?>
						</td>
						<td class="text-center align-middle font-11 font-weight-bold">
							<?php if (abs($dif_ap) < 0.001) { ?>
								<span class="badge badge-success p-1"><i class="fa fa-check"></i> Cuadra</span>
							<?php } elseif ($dif_ap < 0) { ?>
								<span class="badge badge-danger p-1"><i class="fa fa-exclamation-triangle"></i> Faltante (<?php echo number_format($dif_ap, 0); ?>)</span>
							<?php } else { ?>
								<span class="badge badge-info p-1"><i class="fa fa-info-circle"></i> Sobrante (+<?php echo number_format($dif_ap, 0); ?>)</span>
							<?php } ?>
						</td>
						<?php } else { ?>
						<td class="text-center font-weight-bold bg-light text-primary font-16 align-middle"><?php echo number_format($fisico_caj, 0); ?></td>
						<?php } ?>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>

		<?php if ($isAdmin) { ?>
		<div id="seccion_edicion_admin_conteo" style="display: none;" class="mt-3 p-3 bg-light border border-danger rounded">
			<label class="font-weight-bold text-danger"><i class="fa fa-comment"></i> Justificación de la Modificación por Administrador: <span class="text-danger">*</span></label>
			<textarea class="form-control" name="justificacion" id="justificacion_edicion_conteo" rows="2" placeholder="Ej: Cajera digitó 5 en vez de 50 cajas de cerveza Corona. Corregido por Administración..."></textarea>
		</div>
		</form>
		<?php } ?>

		<?php if (!empty($cab['observaciones'])) { ?>
		<div class="alert alert-secondary mt-3 mb-0">
			<strong>Notas / Observaciones:</strong> <?php echo htmlspecialchars($cab['observaciones']); ?>
		</div>
		<?php } ?>

		<div class="modal-footer px-0 pb-0 mt-3 d-flex justify-content-between flex-wrap">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
			<div>
				<?php if ($isAdmin) { ?>
				<button type="button" class="btn btn-success font-weight-bold mr-1" id="btn_guardar_edicion_conteo" style="display: none;" onclick="GuardarEdicionConteoAdmin()">
					<i class="fa fa-save"></i> Guardar Correcciones
				</button>
				<button type="button" class="btn btn-outline-secondary font-weight-bold mr-1" id="btn_cancelar_edicion_conteo" style="display: none;" onclick="CancelarEdicionConteoAdmin()">
					<i class="fa fa-ban"></i> Cancelar Edición
				</button>
				<a href="reportepdf?idconteo=<?php echo encrypt($cab['idconteo']); ?>&tipo=<?php echo encrypt("DISCREPANCIAS_CONTEO"); ?>" target="_blank" class="btn btn-warning font-weight-bold text-dark mr-1">
					<i class="fa fa-file-pdf-o text-danger"></i> 📊 Acta de Discrepancias para el Dueño (PDF)
				</a>
				<?php } ?>
				<a href="reportepdf?idconteo=<?php echo encrypt($cab['idconteo']); ?>&tipo=<?php echo encrypt("CONTEOINICIAL"); ?>" target="_blank" class="btn btn-danger font-weight-bold">
					<i class="fa fa-print"></i> Imprimir Comprobante
				</a>
			</div>
		</div>
		<?php
			exit;
		}
	}

	// Si no está registrado, mostramos el formulario de captura rápida (MODO CONTEO A CIEGAS)
	$productos = $login->ConsultarProductosParaAuditoria($codsucursal, date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59'));
?>
	<form id="form_conteo_inicial_cajero" onsubmit="return false;">
		<input type="hidden" name="codsucursal" value="<?php echo encrypt($codsucursal); ?>">

		<div class="alert alert-warning text-dark py-2 px-3 mb-3 d-flex align-items-center justify-content-between flex-wrap">
			<div>
				<i class="fa fa-clipboard-check fa-lg text-dark mr-1"></i>
				<strong>Conteo Físico Inicial (2:00 PM):</strong> Cuente y anote la cantidad real en refrigeradores y barra.
			</div>
			<span class="badge badge-dark text-warning font-weight-bold p-2"><i class="fa fa-eye-slash"></i> Conteo Físico a Ciegas</span>
		</div>

		<div class="form-group mb-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
				</div>
				<input type="text" id="buscador_producto_conteo" class="form-control" placeholder="Buscar producto por nombre o código..." onkeyup="FiltrarProductosConteo()">
			</div>
		</div>

		<div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
			<table class="table table-bordered table-striped table-hover table-sm mb-0" id="tabla_captura_conteo">
				<thead class="bg-warning text-dark font-weight-bold text-center sticky-top" style="position: sticky; top: 0; z-index: 1;">
					<tr>
						<th style="width: 45px;">#</th>
						<th style="width: 110px;">Código</th>
						<th>Descripción del Producto</th>
						<th style="width: 170px; background-color: #ffe8a1;">Cantidad Física Contada ✍️</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					if (empty($productos)) {
						echo '<tr><td colspan="4" class="text-center py-3 text-muted">No se encontraron productos asignados a esta sucursal.</td></tr>';
					} else {
						foreach ($productos as $idx => $p) {
					?>
					<tr class="fila-producto-conteo">
						<td class="text-center font-weight-bold align-middle"><?php echo $k++; ?></td>
						<td class="text-center text-muted align-middle font-12"><?php echo htmlspecialchars($p['codproducto']); ?></td>
						<td class="align-middle">
							<input type="hidden" name="idproducto[]" value="<?php echo $p['idproducto']; ?>">
							<input type="hidden" name="codproducto[]" value="<?php echo htmlspecialchars($p['codproducto']); ?>">
							<input type="hidden" name="producto[]" value="<?php echo htmlspecialchars($p['producto']); ?>">
							<strong class="nombre-prod"><?php echo htmlspecialchars($p['producto']); ?></strong>
							<?php if (!empty($p['nommarca'])) { ?>
								<span class="badge badge-light border text-muted ml-1"><?php echo htmlspecialchars($p['nommarca']); ?></span>
							<?php } ?>
						</td>
						<td class="p-1 align-middle" style="background-color: #fffdf5;">
							<input type="number" step="any" min="0" class="form-control form-control-sm text-center font-weight-bold input-conteo-cajero" name="cantidad_fisica[]" value="0" style="font-size: 16px; border: 2px solid #ffc107; font-weight: 700;" onclick="this.select();" onfocus="this.select();">
						</td>
					</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>

		<div class="form-group mt-3 mb-0">
			<label class="font-weight-bold text-dark font-12 mb-1">Notas / Observaciones del Conteo:</label>
			<textarea class="form-control form-control-sm" name="observaciones" rows="2" placeholder="Opcional: Indique cualquier producto roto, cambio o detalle importante de su entrega..."></textarea>
		</div>

		<div class="modal-footer px-0 pb-0 mt-3 d-flex justify-content-between">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
			<button type="button" class="btn btn-warning text-dark font-weight-bold shadow px-4" id="btn_guardar_conteo_cajero" onclick="GuardarConteoInicialCajero()">
				<i class="fa fa-save"></i> GUARDAR INVENTARIO INICIAL
			</button>
		</div>
	</form>
<?php
	exit;
}

if (isset($_GET['GuardarConteoInicialCajero'])) {
	$login = new Login();
	$login->RegistrarConteoInicialCajero();
	exit;
}

if (isset($_GET['ActualizarConteoInicialAdmin'])) {
	$login = new Login();
	$login->ActualizarConteoInicialAdmin();
	exit;
}

if (isset($_GET['DesbloquearConteoInicialAdmin'])) {
	$login = new Login();
	$login->DesbloquearConteoInicialAdmin();
	exit;
}

if (isset($_GET['BuscaHistorialConteosIniciales'])) {
	$login = new Login();
	$codsucursal = !empty($_GET["codsucursal"]) ? (int)decrypt($_GET["codsucursal"]) : 0;
	$desde = !empty($_GET["desde"]) ? limpiar($_GET["desde"]) : "";
	$hasta = !empty($_GET["hasta"]) ? limpiar($_GET["hasta"]) : "";

	$conteos = $login->ListarConteosInicialesDiarios($codsucursal, $desde, $hasta);
?>
	<div class="table-responsive">
		<table id="tabla_historial_conteos" class="table table-striped table-bordered text-center font-12 display" style="width:100%">
			<thead class="bg-warning text-dark font-weight-bold">
				<tr>
					<th># Folio</th>
					<th>Sucursal</th>
					<th>Cajero / Usuario</th>
					<th>Fecha y Hora</th>
					<th>Ítems Contados</th>
					<th>Observaciones</th>
					<th style="width: 250px;">Acciones de Administrador</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (!empty($conteos)) {
					foreach ($conteos as $row) {
				?>
				<tr>
					<td class="font-weight-bold align-middle">#<?php echo str_pad($row['idconteo'], 5, "0", STR_PAD_LEFT); ?></td>
					<td class="align-middle text-left font-weight-bold text-dark">
						<i class="fa fa-home text-muted mr-1"></i> <?php echo htmlspecialchars($row['nomsucursal']); ?>
					</td>
					<td class="align-middle text-left">
						<i class="fa fa-user text-muted mr-1"></i> <?php echo htmlspecialchars($row['nomusuario'] ?? 'Cajero'); ?>
					</td>
					<td class="align-middle">
						<span class="badge badge-light border text-dark font-12 font-weight-bold">
							<i class="fa fa-calendar text-danger mr-1"></i> <?php echo date("d/m/Y h:i A", strtotime($row['fechaconteo'])); ?>
						</span>
					</td>
					<td class="align-middle">
						<span class="badge badge-info font-12 font-weight-bold"><?php echo $row['total_items']; ?> productos</span>
					</td>
					<td class="align-middle text-left font-11 text-muted" style="max-width: 200px;">
						<?php echo !empty($row['observaciones']) ? nl2br(htmlspecialchars($row['observaciones'])) : '<span class="text-muted italic">Sin notas</span>'; ?>
					</td>
					<td class="align-middle">
						<div class="btn-group btn-group-sm" role="group">
							<button type="button" class="btn btn-outline-info font-weight-bold" title="Ver Detalle y Corregir Cantidades" onclick="AbrirModalConteoInicial('<?php echo encrypt($row['idconteo']); ?>')">
								<i class="fa fa-eye"></i> Ver / Editar
							</button>
							<button type="button" class="btn btn-danger font-weight-bold" title="Desbloquear para que la sucursal vuelva a contar a ciegas" onclick="DesbloquearConteoInicial('<?php echo encrypt($row['idconteo']); ?>', '<?php echo htmlspecialchars($row['nomsucursal']); ?>')">
								<i class="fa fa-unlock"></i> 🔓 Desbloquear
							</button>
							<a href="reportepdf?idconteo=<?php echo encrypt($row['idconteo']); ?>&tipo=<?php echo encrypt('DISCREPANCIAS_CONTEO'); ?>" target="_blank" class="btn btn-warning text-dark font-weight-bold" title="Descargar Acta de Discrepancias en PDF">
								<i class="fa fa-file-pdf-o text-danger"></i> Acta
							</a>
							<a href="reportepdf?idconteo=<?php echo encrypt($row['idconteo']); ?>&tipo=<?php echo encrypt('CONTEOINICIAL'); ?>" target="_blank" class="btn btn-secondary" title="Descargar Comprobante Físico (WhatsApp)">
								<i class="fa fa-print"></i>
							</a>
						</div>
					</td>
				</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
<?php
	exit;
}
########################## FIN MODAL Y PROCESO CONTEO INICIAL CAJERO ##########################

########################## MODULO DE RETIROS Y BAJAS DE INVENTARIO ##########################

// Búsqueda de productos disponibles de la sucursal para la Baja (JSON para Select2 / Autocomplete)
if (isset($_GET['BuscaProductosParaBaja'])) {
	$codsucursal = 0;
	if (isset($_GET['codsucursal']) && !empty($_GET['codsucursal'])) {
		$raw = $_GET['codsucursal'];
		if (is_numeric($raw)) {
			$codsucursal = (int)$raw;
		} else {
			$dec = decrypt($raw);
			if (is_numeric($dec)) {
				$codsucursal = (int)$dec;
			}
		}
	}
	if ($codsucursal <= 0 && isset($_SESSION['codsucursal']) && !empty($_SESSION['codsucursal'])) {
		$codsucursal = (int)$_SESSION['codsucursal'];
	}

	$q = isset($_GET['q']) ? trim($_GET['q']) : (isset($_GET['term']) ? trim($_GET['term']) : "");

	$login = new Login();
	$prods = $login->BuscarProductosParaBaja($codsucursal, $q);

	$results = array();
	foreach ($prods as $p) {
		$results[] = array(
			"id" => $p['idproducto'],
			"idproducto" => $p['idproducto'],
			"codproducto" => $p['codproducto'],
			"producto" => $p['producto'],
			"existencia" => (float)$p['existencia'],
			"preciocompra" => (float)$p['preciocompra'],
			"precioxpublico" => (float)$p['precioxpublico'],
			"text" => $p['codproducto'] . " - " . $p['producto'] . " (Stock: " . number_format($p['existencia'], 0) . " | Costo: Bs. " . number_format($p['preciocompra'], 2) . ")"
		);
	}
	if (ob_get_length()) { @ob_clean(); }
	header('Content-Type: application/json');
	echo json_encode(array("results" => $results));
	exit;
}

// Cargar catálogo de productos en Modal para Baja de Inventario
if (isset($_GET['CargarModalProductosBaja'])) {
	$codsucursal = 0;
	if (isset($_GET['codsucursal']) && !empty($_GET['codsucursal'])) {
		$raw = $_GET['codsucursal'];
		if (is_numeric($raw)) {
			$codsucursal = (int)$raw;
		} else {
			$dec = decrypt($raw);
			if (is_numeric($dec)) {
				$codsucursal = (int)$dec;
			}
		}
	}
	if ($codsucursal <= 0 && isset($_SESSION['codsucursal']) && !empty($_SESSION['codsucursal'])) {
		$codsucursal = (int)$_SESSION['codsucursal'];
	}

	$login = new Login();
	$prods = $login->BuscarProductosParaBaja($codsucursal, "");
?>
	<div class="table-responsive">
		<table id="tabla_modal_catalogo_baja" class="table table-hover table-bordered table-striped" style="font-size: 13px;">
			<thead class="bg-dark text-white text-center">
				<tr>
					<th>#</th>
					<th>Cód.</th>
					<th class="text-left">Producto</th>
					<th>Stock</th>
					<th>Precio Costo</th>
					<th>Precio Venta</th>
					<th>Acción</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$n = 1;
				foreach ($prods as $p) {
					$jsonProd = htmlspecialchars(json_encode(array(
						"idproducto" => $p['idproducto'],
						"codproducto" => $p['codproducto'],
						"producto" => $p['producto'],
						"existencia" => (float)$p['existencia'],
						"preciocompra" => (float)$p['preciocompra'],
						"precioxpublico" => (float)$p['precioxpublico']
					)), ENT_QUOTES, 'UTF-8');
				?>
				<tr>
					<td class="text-center font-weight-bold"><?php echo $n++; ?></td>
					<td class="text-center"><span class="badge badge-light border text-dark font-12"><?php echo htmlspecialchars($p['codproducto']); ?></span></td>
					<td class="font-weight-bold"><?php echo htmlspecialchars($p['producto']); ?></td>
					<td class="text-center">
						<span class="badge <?php echo ((float)$p['existencia'] > 0) ? 'badge-success' : 'badge-danger'; ?> font-12">
							<?php echo number_format($p['existencia'], 0); ?> u.
						</span>
					</td>
					<td class="text-right font-weight-bold">Bs. <?php echo number_format($p['preciocompra'], 2, '.', ','); ?></td>
					<td class="text-right">Bs. <?php echo number_format($p['precioxpublico'], 2, '.', ','); ?></td>
					<td class="text-center">
						<button type="button" class="btn btn-danger btn-sm font-weight-bold" onclick='AgregarProductoBajaDesdeModal(<?php echo $jsonProd; ?>)'>
							<i class="fa fa-plus-circle"></i> Agregar
						</button>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php
	exit;
}

// Historial de Bajas / Retiros para DataTable
if (isset($_GET['BuscaBajasInventario'])) {
	$codsucursal = isset($_GET['codsucursal']) ? (int)decrypt($_GET['codsucursal']) : 0;
	if ($codsucursal <= 0 && isset($_GET['codsucursal']) && is_numeric($_GET['codsucursal'])) {
		$codsucursal = (int)$_GET['codsucursal'];
	}
	$desde = isset($_GET['desde']) ? limpiar($_GET['desde']) : "";
	$hasta = isset($_GET['hasta']) ? limpiar($_GET['hasta']) : "";

	$login = new Login();
	$bajas = $login->ListarBajasInventario($codsucursal, $desde, $hasta);
?>
	<div class="table-responsive">
		<table id="tabla_bajas_historial" class="table table-striped table-bordered display" style="font-size: 13px;">
			<thead class="bg-dark text-white text-center">
				<tr>
					<th># Código</th>
					<th>Sucursal</th>
					<th>Fecha y Hora</th>
					<th>Motivo / Tipo</th>
					<th>Autorizado Por</th>
					<th>Total Ítems</th>
					<th>Costo Total</th>
					<th>Estado</th>
					<th style="width: 180px;">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (!empty($bajas)) {
					foreach ($bajas as $b) {
						$badgeMotivo = "badge-secondary";
						$txtMotivo = htmlspecialchars($b['tipomotivo']);
						if (strpos($b['tipomotivo'], 'DUENA') !== false || strpos($b['tipomotivo'], 'DUEÑA') !== false) {
							$badgeMotivo = "badge-danger";
							$txtMotivo = "👑 RETIRO DE DUEÑA";
						} elseif (strpos($b['tipomotivo'], 'CONSUMO') !== false) {
							$badgeMotivo = "badge-warning text-dark";
							$txtMotivo = "🍽️ CONSUMO INTERNO";
						} elseif (strpos($b['tipomotivo'], 'MERMA') !== false) {
							$badgeMotivo = "badge-dark";
							$txtMotivo = "💔 MERMA / ROTURA";
						} elseif (strpos($b['tipomotivo'], 'VENCIDO') !== false) {
							$badgeMotivo = "badge-danger";
							$txtMotivo = "⏳ VENCIMIENTO";
						} elseif (strpos($b['tipomotivo'], 'DEGUSTACION') !== false || strpos($b['tipomotivo'], 'PROMOCION') !== false) {
							$badgeMotivo = "badge-info";
							$txtMotivo = "🎁 DEGUSTACIÓN / MUESTRA";
						}

						$isAnulada = ($b['statusbaja'] == 'ANULADA');
				?>
				<tr class="<?php echo $isAnulada ? 'table-danger text-muted' : ''; ?>">
					<td class="font-weight-bold text-center align-middle">
						<span class="badge badge-light border text-dark font-12 font-weight-bold">
							<?php echo htmlspecialchars($b['codbaja']); ?>
						</span>
					</td>
					<td class="align-middle font-weight-bold">
						<i class="fa fa-home text-muted mr-1"></i> <?php echo htmlspecialchars($b['nomsucursal']); ?>
					</td>
					<td class="align-middle text-center">
						<span class="font-12">
							<i class="fa fa-calendar text-danger mr-1"></i> <?php echo date("d/m/Y h:i A", strtotime($b['fechabaja'])); ?>
						</span>
					</td>
					<td class="align-middle text-center">
						<span class="badge <?php echo $badgeMotivo; ?> font-12 px-2 py-1">
							<?php echo $txtMotivo; ?>
						</span>
					</td>
					<td class="align-middle">
						<i class="fa fa-user-circle text-muted mr-1"></i> <?php echo htmlspecialchars($b['persona_autoriza']); ?>
					</td>
					<td class="align-middle text-center font-weight-bold">
						<?php echo $b['total_items']; ?> prod.
					</td>
					<td class="align-middle text-right font-weight-bold text-dark">
						Bs. <?php echo number_format($b['total_costo'], 2, '.', ','); ?>
					</td>
					<td class="align-middle text-center">
						<?php if ($isAnulada) { ?>
							<span class="badge badge-danger font-11"><i class="fa fa-ban"></i> ANULADA</span>
						<?php } else { ?>
							<span class="badge badge-success font-11"><i class="fa fa-check"></i> PROCESADA</span>
						<?php } ?>
					</td>
					<td class="align-middle text-center">
						<div class="btn-group btn-group-sm" role="group">
							<button type="button" class="btn btn-info font-weight-bold" title="Ver Detalle de Productos" onclick="VerDetalleBaja('<?php echo encrypt($b['idbaja']); ?>')">
								<i class="fa fa-eye"></i> Detalle
							</button>
							<a href="reportepdf?idbaja=<?php echo encrypt($b['idbaja']); ?>&tipo=<?php echo encrypt('BAJAINVENTARIO'); ?>" target="_blank" class="btn btn-danger font-weight-bold" title="Descargar Comprobante PDF">
								<i class="fa fa-file-pdf-o"></i> PDF
							</a>
							<?php if (!$isAnulada && ($_SESSION['acceso'] == 'administradorG' || $_SESSION['acceso'] == 'administradorS')) { ?>
								<button type="button" class="btn btn-outline-danger font-weight-bold" title="Anular Baja y Reincorporar Stock" onclick="AnularBaja('<?php echo encrypt($b['idbaja']); ?>', '<?php echo htmlspecialchars($b['codbaja']); ?>')">
									<i class="fa fa-ban"></i>
								</button>
							<?php } ?>
						</div>
					</td>
				</tr>
				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
<?php
	exit;
}

// Modal Ver Detalle de Baja
if (isset($_GET['VerDetalleBajaInventario']) && isset($_GET['idbaja'])) {
	$idbaja = (int)decrypt($_GET['idbaja']);
	$login = new Login();
	$data = $login->BuscarBajaInventarioPorId($idbaja);

	if (!$data || empty($data['cabecera'])) {
		echo '<div class="alert alert-danger">No se encontró el registro solicitado.</div>';
		exit;
	}

	$cab = $data['cabecera'];
	$det = $data['detalles'];
?>
	<div class="row mb-3">
		<div class="col-md-6">
			<p class="mb-1"><strong>Código de Baja:</strong> <span class="badge badge-dark font-13"><?php echo htmlspecialchars($cab['codbaja']); ?></span></p>
			<p class="mb-1"><strong>Sucursal:</strong> <?php echo htmlspecialchars($cab['nomsucursal']); ?></p>
			<p class="mb-1"><strong>Fecha y Hora:</strong> <?php echo date("d/m/Y h:i A", strtotime($cab['fechabaja'])); ?></p>
			<p class="mb-1"><strong>Registrado Por:</strong> <?php echo htmlspecialchars($cab['nomusuario'] ?? 'Admin'); ?></p>
		</div>
		<div class="col-md-6">
			<p class="mb-1"><strong>Motivo / Tipo:</strong> <span class="badge badge-danger font-13"><?php echo htmlspecialchars($cab['tipomotivo']); ?></span></p>
			<p class="mb-1"><strong>Autorizado Por:</strong> <span class="text-primary font-weight-bold"><?php echo htmlspecialchars($cab['persona_autoriza']); ?></span></p>
			<p class="mb-1"><strong>Estado:</strong> 
				<?php if ($cab['statusbaja'] == 'ANULADA') { ?>
					<span class="badge badge-danger">ANULADA</span>
				<?php } else { ?>
					<span class="badge badge-success">PROCESADA</span>
				<?php } ?>
			</p>
			<p class="mb-1"><strong>Observaciones:</strong> <em><?php echo !empty($cab['observaciones']) ? nl2br(htmlspecialchars($cab['observaciones'])) : 'Ninguna'; ?></em></p>
		</div>
	</div>

	<div class="table-responsive">
		<table class="table table-bordered table-striped table-sm" style="font-size: 13px;">
			<thead class="bg-dark text-white text-center">
				<tr>
					<th>#</th>
					<th>Cód. Producto</th>
					<th class="text-left">Descripción del Producto</th>
					<th>Cantidad Retirada</th>
					<th>Costo Unit.</th>
					<th>Precio Público</th>
					<th>Subtotal Costo</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$n = 1;
				$totalCant = 0;
				$totalSub = 0;
				foreach ($det as $d) {
					$totalCant += (float)$d['cantidad'];
					$totalSub += (float)$d['subtotal_costo'];
				?>
				<tr>
					<td class="text-center font-weight-bold"><?php echo $n++; ?></td>
					<td class="text-center"><?php echo htmlspecialchars($d['codproducto']); ?></td>
					<td><?php echo htmlspecialchars($d['producto']); ?></td>
					<td class="text-center font-weight-bold text-danger">-<?php echo number_format($d['cantidad'], 2); ?></td>
					<td class="text-right">Bs. <?php echo number_format($d['preciocompra'], 2, '.', ','); ?></td>
					<td class="text-right">Bs. <?php echo number_format($d['precioxpublico'], 2, '.', ','); ?></td>
					<td class="text-right font-weight-bold">Bs. <?php echo number_format($d['subtotal_costo'], 2, '.', ','); ?></td>
				</tr>
				<?php } ?>
			</tbody>
			<tfoot class="bg-light font-weight-bold">
				<tr>
					<td colspan="3" class="text-right">TOTALES:</td>
					<td class="text-center text-danger font-14">-<?php echo number_format($totalCant, 2); ?> u.</td>
					<td colspan="2"></td>
					<td class="text-right text-dark font-14">Bs. <?php echo number_format($totalSub, 2, '.', ','); ?></td>
				</tr>
			</tfoot>
		</table>
	</div>
<?php
	exit;
}

// Endpoint para guardar baja vía AJAX
if (isset($_GET['GuardarBajaInventario']) && $_GET['GuardarBajaInventario'] == 'si') {
	$login = new Login();
	$login->RegistrarBajaInventario();
	exit;
}

// Endpoint para anular baja vía AJAX
if (isset($_GET['AnularBajaInventario']) && $_GET['AnularBajaInventario'] == 'si') {
	$login = new Login();
	$login->AnularBajaInventario();
	exit;
}

########################## FIN MODULO DE RETIROS Y BAJAS DE INVENTARIO ##########################
?>