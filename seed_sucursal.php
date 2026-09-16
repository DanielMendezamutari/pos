<?php
require_once("class/class.php");
require_once("class/class.seed_sucursal.php");

if (!isset($_SESSION['acceso']) || $_SESSION['acceso'] != "administradorG") {
    header("Location: login");
    exit;
}

$tra = new Login();
$ses = $tra->ExpiraSession();
$seedService = new SeedSucursalService();

// Procesar llamadas AJAX
if (isset($_POST["accion"])) {
    header('Content-Type: application/json; charset=utf-8');
    $accion = $_POST["accion"];
    $codsucursal = isset($_POST["codsucursal"]) ? intval($_POST["codsucursal"]) : 6;

    if ($accion == "resumen") {
        $resumen = $seedService->obtenerResumenSucursal($codsucursal);
        echo json_encode(['status' => 'success', 'data' => $resumen]);
        exit;
    } elseif ($accion == "ejecutar_seed") {
        $opciones = [
            'montoinicial'   => isset($_POST['montoinicial']) ? floatval($_POST['montoinicial']) : 100.00,
            'stock_unidades' => isset($_POST['stock_unidades']) ? floatval($_POST['stock_unidades']) : 50.00
        ];
        $res = $seedService->ejecutarSeed($codsucursal, $opciones);
        echo json_encode($res);
        exit;
    } elseif ($accion == "resetear") {
        $res = $seedService->resetearPruebas($codsucursal);
        echo json_encode($res);
        exit;
    }
}

$sucursales = $seedService->obtenerSucursalesDisponibles();
?>
<!DOCTYPE html>
<html dir="ltr" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>Generador de Datos de Prueba (Seed) - POS</title>

    <link href="assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="assets/plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/default.css" id="theme" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/alert.css">

    <style>
        .card-counter {
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            padding: 18px;
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 5px solid #e74c3c;
            transition: all .25s ease;
        }
        .card-counter:hover {
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
            transform: translateY(-2px);
        }
        .card-counter .count-title {
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
            color: #7f8c8d;
        }
        .card-counter .count-numbers {
            font-size: 26px;
            font-weight: 700;
            color: #2c3e50;
            margin: 5px 0;
        }
        .card-counter .count-desc {
            font-size: 12px;
            color: #95a5a6;
        }
        .cred-box {
            background: #f8f9fa;
            border-radius: 6px;
            padding: 12px;
            border: 1px dashed #ced4da;
            margin-bottom: 10px;
        }
        .cred-user {
            font-family: monospace;
            font-size: 14px;
            font-weight: bold;
            color: #c0392b;
        }
        .cred-pass {
            font-family: monospace;
            font-size: 14px;
            font-weight: bold;
            color: #27ae60;
        }
    </style>
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
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <h5 class="font-medium text-uppercase mb-0"><i class="fa fa-database text-danger"></i> Entorno de Pruebas: Generador Seed</h5>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-12 align-self-center">
                        <nav aria-label="breadcrumb" class="mt-2 float-md-right float-left">
                            <ol class="breadcrumb mb-0 justify-content-end p-0">
                                <li class="breadcrumb-item"><a href="panel">Inicio</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Seeder de Pruebas</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="container-fluid">

                <!-- Alert descriptivo -->
                <div class="alert alert-info border-0 shadow-sm">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="fa fa-info-circle"></i> Entorno Aislado para Pruebas Operativas</h4>
                    Este módulo puebla de forma automática y segura todos los registros requeridos para operar el sistema en la sucursal seleccionada (<strong>usuarios, cajeros, cajas, apertura de caja en vivo, mesas de billar, stock y clientes</strong>) sin afectar a las demás sucursales en producción.
                </div>

                <!-- Selector de Sucursal y Acciones Principales -->
                <div class="card shadow-sm">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <h4 class="card-title text-white mb-0"><i class="fa fa-cogs"></i> Configuración de la Sucursal para Pruebas</h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <label class="font-weight-bold">Seleccione la Sucursal de Pruebas:</label>
                                <select class="form-control" id="selectSucursal" style="font-weight:bold; font-size:15px;">
                                    <?php foreach ($sucursales as $s): ?>
                                    <option value="<?php echo $s['codsucursal']; ?>" <?php echo ($s['codsucursal'] == 6 || stripos($s['nomsucursal'], 'PRUEBA') !== false) ? 'selected' : ''; ?>>
                                        [ID: <?php echo $s['codsucursal']; ?>] <?php echo htmlspecialchars($s['nomsucursal']); ?> (CUIT: <?php echo htmlspecialchars($s['cuitsucursal']); ?>)
                                        <?php if ($s['codsucursal'] == 6 || stripos($s['nomsucursal'], 'PRUEBA') !== false) echo '⭐ SUCURSAL DE PRUEBA'; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-7 text-right mt-3 mt-md-0">
                                <button type="button" id="btnRecargarEstado" class="btn btn-outline-secondary mr-2">
                                    <i class="fa fa-refresh"></i> Actualizar Estado
                                </button>
                                <button type="button" id="btnResetearSeed" class="btn btn-outline-danger mr-2">
                                    <i class="fa fa-trash"></i> Resetear Pruebas
                                </button>
                                <button type="button" id="btnEjecutarSeed" class="btn btn-danger btn-lg font-weight-bold shadow">
                                    <i class="fa fa-rocket"></i> Ejecutar Seed Completo
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tarjetas de Estado en Tiempo Real -->
                <h5 class="text-uppercase font-weight-bold text-muted mb-3"><i class="fa fa-bar-chart"></i> Estado Actual de la Sucursal Seleccionada</h5>
                <div class="row" id="contenedorTarjetasEstado">
                    <div class="col-md-2 col-sm-6">
                        <div class="card-counter" style="border-left-color: #3498db;">
                            <span class="count-title"><i class="fa fa-users"></i> Usuarios</span>
                            <div class="count-numbers" id="numUsuarios">--</div>
                            <span class="count-desc" id="descUsuarios">Cargando...</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="card-counter" style="border-left-color: #e67e22;">
                            <span class="count-title"><i class="fa fa-inbox"></i> Cajas</span>
                            <div class="count-numbers" id="numCajas">--</div>
                            <span class="count-desc" id="descCajas">Cargando...</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="card-counter" style="border-left-color: #2ecc71;">
                            <span class="count-title"><i class="fa fa-unlock-alt"></i> Caja Abierta</span>
                            <div class="count-numbers" id="numArqueos">--</div>
                            <span class="count-desc" id="descArqueos">Cargando...</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="card-counter" style="border-left-color: #9b59b6;">
                            <span class="count-title"><i class="fa fa-circle-o"></i> Mesas Billar</span>
                            <div class="count-numbers" id="numMesas">--</div>
                            <span class="count-desc" id="descMesas">Cargando...</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="card-counter" style="border-left-color: #1abc9c;">
                            <span class="count-title"><i class="fa fa-cubes"></i> Prod. Stock</span>
                            <div class="count-numbers" id="numProductos">--</div>
                            <span class="count-desc" id="descProductos">Cargando...</span>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="card-counter" style="border-left-color: #f39c12;">
                            <span class="count-title"><i class="fa fa-address-book"></i> Clientes</span>
                            <div class="count-numbers" id="numClientes">--</div>
                            <span class="count-desc" id="descClientes">Cargando...</span>
                        </div>
                    </div>
                </div>

                <!-- Detalle de lo que se Genera & Credenciales de Acceso -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-dark text-white">
                                <h4 class="card-title text-white mb-0"><i class="fa fa-list-check"></i> ¿Qué generará el Seed en esta Sucursal?</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fa fa-check-circle text-success fa-2x mr-3"></i>
                                        <div>
                                            <strong>4 Usuarios del Sistema:</strong>
                                            <div class="text-muted small">Administrador Sucursal, Cajero Turno Tarde, Cajero Turno Noche, y Mesera de Turno.</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fa fa-check-circle text-success fa-2x mr-3"></i>
                                        <div>
                                            <strong>2 Cajas Operativas Vinculadas:</strong>
                                            <div class="text-muted small">Caja Tarde asignada a PRUEBATARDE y Caja Noche asignada a PRUEBANOCHE.</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fa fa-check-circle text-success fa-2x mr-3"></i>
                                        <div>
                                            <strong>Apertura de Caja en Vivo:</strong>
                                            <div class="text-muted small">Apertura inmediata de la Caja Tarde con 100.00 Bs iniciales para probar ventas de inmediato.</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fa fa-check-circle text-success fa-2x mr-3"></i>
                                        <div>
                                            <strong>6 Mesas / Salas de Billar:</strong>
                                            <div class="text-muted small">Mesa 1, Mesa 2, Mesa 3, Mesa 4, Mesa VIP y Barra listas para comandas y alquiler.</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fa fa-check-circle text-success fa-2x mr-3"></i>
                                        <div>
                                            <strong>Stock para Todos los Productos:</strong>
                                            <div class="text-muted small">Asigna 50 unidades de inventario a los 81 productos de la sucursal para facturar sin restricciones.</div>
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fa fa-check-circle text-success fa-2x mr-3"></i>
                                        <div>
                                            <strong>Clientes de Prueba:</strong>
                                            <div class="text-muted small">Consumidor Final y Cliente VIP para ventas al contado y a crédito.</div>
                                        </div>
                                    </li>
                                </ul>

                                <!-- Opciones Rápidas -->
                                <div class="p-3 bg-light rounded border">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="font-weight-bold small">Monto Inicial Caja (Bs):</label>
                                            <input type="number" step="10" class="form-control" id="montoInicialSeed" value="100.00">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="font-weight-bold small">Stock por Producto (Uds):</label>
                                            <input type="number" step="10" class="form-control" id="stockUnidadesSeed" value="50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                                <h4 class="card-title text-white mb-0"><i class="fa fa-key"></i> Credenciales de Prueba para Iniciar Sesión</h4>
                                <span class="badge badge-warning">Clave general: 123456</span>
                            </div>
                            <div class="card-body">
                                <p class="text-muted small">Utiliza cualquiera de estos usuarios para probar los distintos flujos operativos del sistema POS:</p>

                                <div class="cred-box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge badge-primary">ADMINISTRADOR SUCURSAL</span>
                                            <div class="cred-user mt-1"><i class="fa fa-user"></i> Usuario: ADMINPRUEBA</div>
                                            <div class="cred-pass"><i class="fa fa-lock"></i> Contraseña: 123456</div>
                                            <small class="text-muted">Control total de la sucursal de prueba.</small>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary btn-copiar" data-user="ADMINPRUEBA" data-pass="123456" title="Copiar"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>

                                <div class="cred-box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge badge-success">CAJERO(A) TARDE (Caja Abierta)</span>
                                            <div class="cred-user mt-1"><i class="fa fa-user"></i> Usuario: PRUEBATARDE</div>
                                            <div class="cred-pass"><i class="fa fa-lock"></i> Contraseña: 123456</div>
                                            <small class="text-muted">Asignado a Caja Tarde, con caja abierta y 100 Bs iniciales.</small>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary btn-copiar" data-user="PRUEBATARDE" data-pass="123456" title="Copiar"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>

                                <div class="cred-box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge badge-info">CAJERO(A) NOCHE</span>
                                            <div class="cred-user mt-1"><i class="fa fa-user"></i> Usuario: PRUEBANOCHE</div>
                                            <div class="cred-pass"><i class="fa fa-lock"></i> Contraseña: 123456</div>
                                            <small class="text-muted">Asignado a Caja Noche para probar cierres y relevos.</small>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary btn-copiar" data-user="PRUEBANOCHE" data-pass="123456" title="Copiar"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>

                                <div class="cred-box">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge badge-warning text-dark">MESERA / VENDEDOR(A)</span>
                                            <div class="cred-user mt-1"><i class="fa fa-user"></i> Usuario: MESERAPRUEBA</div>
                                            <div class="cred-pass"><i class="fa fa-lock"></i> Contraseña: 123456</div>
                                            <small class="text-muted">Para probar comandas en app móvil y ventas de salón.</small>
                                        </div>
                                        <button class="btn btn-sm btn-outline-secondary btn-copiar" data-user="MESERAPRUEBA" data-pass="123456" title="Copiar"><i class="fa fa-copy"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <footer class="footer text-center">
                <i class="fa fa-copyright"></i> <span class="current-year"></span> Sistema POS - Joker.
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="assets/script/jquery.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.min.js"></script>
    <script src="assets/js/app.init.horizontal-fullwidth.js"></script>
    <script src="assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>
    <script src="assets/script/jsseed_sucursal.js"></script>
</body>
</html>
