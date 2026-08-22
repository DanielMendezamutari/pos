<?php
require_once("class/class.php");
if (isset($_SESSION['acceso'])) {
    if ($_SESSION["acceso"] == "administradorG" || $_SESSION["acceso"] == "administradorS") {

        $tra = new Login();
        $ses = $tra->ExpiraSession();
        $sucursal_user = isset($_SESSION['codsucursal']) ? $_SESSION['codsucursal'] : 0;
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Nuevo Retiro / Baja de Inventario</title>
    <!-- DataTables CSS -->
    <link href="assets/plugins/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/select2.min.css">
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
</head>

<body onLoad="muestraReloj(); getTime();" class="fix-header">
    
    <!-- Preloader -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>

    <!-- Modal Catálogo Completo de Productos -->
    <div class="modal fade" id="modalCatalogoProductosBaja" tabindex="-1" role="dialog" aria-labelledby="modalCatalogoLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title font-weight-bold" id="modalCatalogoLabel"><i class="fa fa-cubes"></i> Catálogo de Productos Disponibles en Sucursal</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_body_catalogo_baja">
                    <!-- Carga AJAX -->
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Listo / Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-boxed-layout="full" data-boxed-layout="boxed" data-header-position="fixed" data-sidebar-position="fixed" class="mini-sidebar"> 
      
        <!-- INICIO DE MENU -->
        <?php include('menu.php'); ?>
        <!-- FIN DE MENU -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb and right sidebar toggle -->
            <div class="page-breadcrumb border-bottom">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-minus-circle text-danger"></i> Nuevo Retiro / Baja de Mercadería</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Inicio</a></li>
                                <li class="breadcrumb-item"><a href="bajas">Bajas</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Nuevo Retiro</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Container fluid  -->
            <div class="page-content container-fluid">
                
                <form class="form" method="post" action="#" name="formguardarbaja" id="formguardarbaja">
                    <div class="row">
                        <!-- Columna izquierda: Datos generales -->
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                                    <h4 class="card-title text-white mb-0"><i class="fa fa-clipboard"></i> Datos del Retiro / Salida de Mercadería</h4>
                                    <a href="bajas" class="btn btn-dark btn-sm"><i class="fa fa-list"></i> Historial de Bajas</a>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label font-weight-bold">Sucursal de Origen: <span class="text-danger">*</span></label>
                                                <?php if ($_SESSION['acceso'] == "administradorG") { ?>
                                                    <select class="form-control font-weight-bold" name="codsucursal" id="codsucursal" onchange="CambiarSucursalBaja()" required>
                                                        <option value="">-- Seleccione Sucursal --</option>
                                                        <?php
                                                        $sucursales = $tra->ListarSucursales();
                                                        foreach ($sucursales as $s) {
                                                        ?>
                                                            <option value="<?php echo encrypt($s['codsucursal']); ?>" data-id="<?php echo $s['codsucursal']; ?>"><?php echo htmlspecialchars($s['nomsucursal']); ?> (<?php echo $s['cuitsucursal']; ?>)</option>
                                                        <?php } ?>
                                                    </select>
                                                <?php } else { ?>
                                                    <input type="hidden" name="codsucursal" id="codsucursal" value="<?php echo encrypt($_SESSION['codsucursal']); ?>">
                                                    <input type="text" class="form-control font-weight-bold bg-light" value="<?php echo htmlspecialchars($_SESSION['nomsucursal'] ?? 'Mi Sucursal'); ?>" readonly>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label font-weight-bold">Motivo / Tipo de Salida: <span class="text-danger">*</span></label>
                                                <select class="form-control font-weight-bold text-danger border-danger" name="tipomotivo" id="tipomotivo" required>
                                                    <option value="RETIRO_DUENA">👑 Retiro de Dueña / Propietaria</option>
                                                    <option value="CONSUMO_INTERNO">🍽️ Consumo Interno / Personal</option>
                                                    <option value="MERMA_ROTURA">💔 Merma / Botella Rota / Daño</option>
                                                    <option value="PRODUCTO_VENCIDO">⏳ Producto Vencido</option>
                                                    <option value="DEGUSTACION_MUESTRA">🎁 Promoción / Degustación / Muestra</option>
                                                    <option value="OTRO">📝 Otro Motivo</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label font-weight-bold">Persona que Autoriza / Retira: <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control font-weight-bold" name="persona_autoriza" id="persona_autoriza" value="<?php echo htmlspecialchars($_SESSION['nombres'] ?? 'Dueña'); ?>" placeholder="Ej: Doña María (Dueña)" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="control-label font-weight-bold">Observaciones / Justificación:</label>
                                                <input type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Ej: Retiro para evento personal...">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Columna de Productos a dar de baja -->
                        <div class="col-lg-12">
                            <div class="card shadow-sm border-0">
                                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                    <h4 class="card-title text-white mb-0"><i class="fa fa-shopping-cart"></i> Selección de Productos a Retirar</h4>
                                    <button type="button" class="btn btn-warning font-weight-bold btn-sm shadow" onclick="AbrirCatalogoModalBaja()">
                                        <i class="fa fa-cubes"></i> 📂 Abrir Catálogo Completo
                                    </button>
                                </div>
                                <div class="card-body">
                                    
                                    <!-- Buscador directo y rápido de productos -->
                                    <div class="row mb-3">
                                        <div class="col-md-9">
                                            <label class="font-weight-bold text-dark"><i class="fa fa-search text-danger"></i> Buscar Producto (Nombre, Código o Código de Barra):</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-lg font-weight-bold" id="txt_buscar_producto_baja" placeholder="🔍 Escriba aquí el nombre o código del producto..." onkeyup="BuscarProductosEnVivoBaja(this.value)" autocomplete="off">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-danger font-weight-bold" onclick="BuscarProductosEnVivoBaja($('#txt_buscar_producto_baja').val())">
                                                        <i class="fa fa-search"></i> Buscar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 d-flex align-items-end">
                                            <button type="button" class="btn btn-outline-dark btn-lg btn-block font-weight-bold" onclick="AbrirCatalogoModalBaja()">
                                                <i class="fa fa-list"></i> Ver Todos (Catálogo)
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Contenedor desplegable de resultados en vivo -->
                                    <div id="contenedor_resultados_busqueda" style="display: none;" class="mb-4">
                                        <div class="card border border-danger shadow-sm">
                                            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center py-2">
                                                <span class="font-weight-bold"><i class="fa fa-bolt"></i> Resultados Encontrados (Haga clic en "+ Agregar" para añadir a la lista)</span>
                                                <button type="button" class="close text-white" onclick="$('#contenedor_resultados_busqueda').slideUp()">&times;</button>
                                            </div>
                                            <div class="card-body p-0" id="body_resultados_busqueda" style="max-height: 280px; overflow-y: auto;">
                                                <!-- Resultados dinámicos -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="tabla_detalle_baja" class="table table-hover table-bordered table-striped" style="font-size: 13px;">
                                            <thead class="bg-secondary text-white text-center">
                                                <tr>
                                                    <th style="width: 120px;">Código</th>
                                                    <th class="text-left">Descripción del Producto</th>
                                                    <th style="width: 110px;">Stock Actual</th>
                                                    <th style="width: 130px;" class="text-danger">Cantidad a Retirar (-)</th>
                                                    <th style="width: 130px;">Costo Unit.</th>
                                                    <th style="width: 140px;">Subtotal Costo</th>
                                                    <th style="width: 50px;">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="fila_vacia">
                                                    <td colspan="7" class="text-center text-muted p-4">
                                                        <i class="fa fa-shopping-cart fa-2x d-block mb-2 text-muted"></i>
                                                        Escriba en el buscador o abra el catálogo para agregar productos a la baja
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot class="bg-light font-weight-bold">
                                                <tr>
                                                    <td colspan="3" class="text-right align-middle">TOTALES:</td>
                                                    <td class="text-center align-middle font-16 text-danger" id="txt_total_items">0 u.</td>
                                                    <td class="text-right align-middle font-14">Costo Total:</td>
                                                    <td class="text-right align-middle font-16 text-dark" id="txt_total_costo">Bs. 0.00</td>
                                                    <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-6">
                                            <div class="alert alert-info">
                                                <i class="fa fa-info-circle fa-lg mr-1"></i>
                                                <strong>Nota para Auditoría:</strong> Al procesar este retiro, las unidades se descontarán del stock físico y la auditoría reconocerá automáticamente esta salida en la columna <strong>(-) Bajas Dueña</strong> para no generar faltantes a la cajera.
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center justify-content-end">
                                            <button type="button" class="btn btn-danger btn-lg font-weight-bold shadow px-4 py-3" id="btn_guardar_baja" onclick="GuardarBaja()">
                                                <i class="fa fa-save"></i> PROCESAR Y GUARDAR RETIRO
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            
            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <?php echo date('Y'); ?> Sistema POS. Todos los Derechos Reservados.
            </footer>
        </div>
    </div>

    <!-- All Jquery -->
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
    <!--Sweet-Alert -->
    <script src="assets/js/sweetalert-dev.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>
    <!-- DataTables -->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <!-- Select2 -->
    <script src="assets/js/select2.full.min.js"></script>
    <script src="assets/js/select2.min.js"></script>

    <script>
        window.TIPO_BAJA_ENCRYPT = "<?php echo encrypt('BAJAINVENTARIO'); ?>";
    </script>
    <script src="assets/script/jsbajas.js"></script>

</body>
</html>
<?php
    } else {
        header("Location: panel.php");
    }
} else {
    header("Location: logout.php");
}
?>
