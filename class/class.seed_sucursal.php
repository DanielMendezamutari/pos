<?php
require_once("classconexion.php");

/**
 * Servicio de Generación de Datos de Prueba (Seeder)
 * Especializado en preparar un entorno completo y seguro para pruebas operativas.
 * Cumple con Principios SOLID (Responsabilidad Única) y transaccionalidad PDO.
 */
class SeedSucursalService extends Db {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtiene la sucursal de prueba o la sucursal seleccionada
     */
    public function obtenerSucursalesDisponibles() {
        $stmt = $this->dbh->query("SELECT codsucursal, cuitsucursal, nomsucursal, estado FROM sucursales ORDER BY codsucursal ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Resumen en tiempo real del estado de la sucursal
     */
    public function obtenerResumenSucursal($codsucursal) {
        $codsucursal = intval($codsucursal);

        // Sucursal
        $stmt = $this->dbh->prepare("SELECT * FROM sucursales WHERE codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $sucursal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sucursal) {
            return null;
        }

        // Usuarios
        $stmt = $this->dbh->prepare("SELECT codigo, usuario, nombres, nivel, status FROM usuarios WHERE codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cajas
        $stmt = $this->dbh->prepare("SELECT c.*, u.usuario, u.nombres FROM cajas c LEFT JOIN usuarios u ON c.codigo = u.codigo WHERE c.codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $cajas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Arqueos de caja abiertos (statusarqueo = 1)
        $stmt = $this->dbh->prepare("SELECT a.*, c.nomcaja, u.usuario FROM arqueocaja a INNER JOIN cajas c ON a.codcaja = c.codcaja LEFT JOIN usuarios u ON c.codigo = u.codigo WHERE c.codsucursal = ? AND a.statusarqueo = 1");
        $stmt->execute([$codsucursal]);
        $arqueosAbiertos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Mesas
        $stmt = $this->dbh->prepare("SELECT * FROM mesasbillar WHERE codsucursal = ? ORDER BY orden ASC");
        $stmt->execute([$codsucursal]);
        $mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Productos
        $stmt = $this->dbh->prepare("SELECT COUNT(*) AS total, SUM(CASE WHEN existencia > 0 THEN 1 ELSE 0 END) AS con_stock FROM productos WHERE codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Clientes
        $stmt = $this->dbh->prepare("SELECT COUNT(*) AS total FROM clientes WHERE codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $cliInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'sucursal'        => $sucursal,
            'usuarios'        => $usuarios,
            'cajas'           => $cajas,
            'arqueosAbiertos' => $arqueosAbiertos,
            'mesas'           => $mesas,
            'productos_total' => intval($prodInfo['total']),
            'productos_stock' => intval($prodInfo['con_stock']),
            'clientes_total'  => intval($cliInfo['total'])
        ];
    }

    /**
     * Ejecuta el seeder para poblar la sucursal de prueba
     */
    public function ejecutarSeed($codsucursal, $opciones = []) {
        $codsucursal = intval($codsucursal);

        // Protección estricta: verificar que la sucursal sea válida
        $stmt = $this->dbh->prepare("SELECT nomsucursal, cuitsucursal FROM sucursales WHERE codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $sucursal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sucursal) {
            return ['status' => 'error', 'mensaje' => 'La sucursal seleccionada no existe.'];
        }

        // Advertencia de seguridad: Si no contiene la palabra PRUEBA en el nombre o CUIT, exigir confirmación forzada
        $esPrueba = (stripos($sucursal['nomsucursal'], 'PRUEBA') !== false || stripos($sucursal['cuitsucursal'], 'PRUEBA') !== false || $codsucursal == 6);
        if (!$esPrueba && empty($opciones['forzar_otra_sucursal'])) {
            return [
                'status' => 'error',
                'mensaje' => 'Por seguridad, este seeder solo puede ejecutarse en sucursales de PRUEBA. La sucursal elegida es "' . $sucursal['nomsucursal'] . '".'
            ];
        }

        $reporte = [
            'usuarios_creados' => 0,
            'cajas_creadas'    => 0,
            'cajas_abiertas'   => 0,
            'mesas_creadas'    => 0,
            'productos_stock'  => 0,
            'clientes_creados' => 0,
            'credenciales'     => []
        ];

        try {
            $this->dbh->beginTransaction();

            // 1. Asegurar Marca Base de la Sucursal
            $stmtM = $this->dbh->prepare("SELECT codmarca FROM marcas WHERE codsucursal = ? LIMIT 1");
            $stmtM->execute([$codsucursal]);
            if (!$stmtM->fetch(PDO::FETCH_ASSOC)) {
                $stmtInsM = $this->dbh->prepare("INSERT INTO marcas (nommarca, codsucursal) VALUES ('ACTUALIZAR', ?)");
                $stmtInsM->execute([$codsucursal]);
            }

            // 2. CREACIÓN DE USUARIOS
            $passwordHash = password_hash('123456', PASSWORD_DEFAULT);
            $usuariosDefinidos = [
                [
                    'dni'       => '60000001',
                    'nombres'   => 'ADMINISTRADOR PRUEBA',
                    'sexo'      => 'MASCULINO',
                    'direccion' => 'SUCURSAL PRUEBA',
                    'telefono'  => '70000001',
                    'email'     => 'adminprueba@pos.com',
                    'usuario'   => 'ADMINPRUEBA',
                    'nivel'     => 'ADMINISTRADOR(A) SUCURSAL',
                    'rol_desc'  => 'Administrador de Sucursal'
                ],
                [
                    'dni'       => '60000002',
                    'nombres'   => 'CAJERO TARDE PRUEBA',
                    'sexo'      => 'MASCULINO',
                    'direccion' => 'SUCURSAL PRUEBA',
                    'telefono'  => '70000002',
                    'email'     => 'cajerotarde@pos.com',
                    'usuario'   => 'PRUEBATARDE',
                    'nivel'     => 'CAJERO(A)',
                    'rol_desc'  => 'Cajero Turno Tarde'
                ],
                [
                    'dni'       => '60000003',
                    'nombres'   => 'CAJERO NOCHE PRUEBA',
                    'sexo'      => 'FEMENINO',
                    'direccion' => 'SUCURSAL PRUEBA',
                    'telefono'  => '70000003',
                    'email'     => 'cajeronoche@pos.com',
                    'usuario'   => 'PRUEBANOCHE',
                    'nivel'     => 'CAJERO(A)',
                    'rol_desc'  => 'Cajero Turno Noche'
                ],
                [
                    'dni'       => '60000004',
                    'nombres'   => 'MESERA PRUEBA',
                    'sexo'      => 'FEMENINO',
                    'direccion' => 'SUCURSAL PRUEBA',
                    'telefono'  => '70000004',
                    'email'     => 'meseraprueba@pos.com',
                    'usuario'   => 'MESERAPRUEBA',
                    'nivel'     => 'VENDEDOR(A)',
                    'rol_desc'  => 'Mesera / Vendedora (Comandas)'
                ]
            ];

            $usuariosIds = [];
            foreach ($usuariosDefinidos as $u) {
                $stmtCheck = $this->dbh->prepare("SELECT codigo FROM usuarios WHERE usuario = ?");
                $stmtCheck->execute([$u['usuario']]);
                $userRow = $stmtCheck->fetch(PDO::FETCH_ASSOC);

                if ($userRow) {
                    // Actualizar para asegurar que pertenezca a la sucursal y tenga la contraseña activa
                    $stmtUpd = $this->dbh->prepare("UPDATE usuarios SET dni = ?, nombres = ?, sexo = ?, direccion = ?, telefono = ?, email = ?, password = ?, nivel = ?, status = 1, codsucursal = ? WHERE codigo = ?");
                    $stmtUpd->execute([$u['dni'], $u['nombres'], $u['sexo'], $u['direccion'], $u['telefono'], $u['email'], $passwordHash, $u['nivel'], $codsucursal, $userRow['codigo']]);
                    $userId = $userRow['codigo'];
                } else {
                    $stmtIns = $this->dbh->prepare("INSERT INTO usuarios (dni, nombres, sexo, direccion, telefono, email, usuario, password, nivel, status, comision, codsucursal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, '0.00', ?)");
                    $stmtIns->execute([$u['dni'], $u['nombres'], $u['sexo'], $u['direccion'], $u['telefono'], $u['email'], $u['usuario'], $passwordHash, $u['nivel'], $codsucursal]);
                    $userId = $this->dbh->lastInsertId();
                    $reporte['usuarios_creados']++;
                }

                $usuariosIds[$u['usuario']] = $userId;
                $reporte['credenciales'][] = [
                    'usuario'  => $u['usuario'],
                    'password' => '123456',
                    'nivel'    => $u['nivel'],
                    'rol_desc' => $u['rol_desc']
                ];
            }

            // 3. CREACIÓN DE CAJAS
            $cajasDefinidas = [
                [
                    'nrocaja' => '1',
                    'nomcaja' => 'CAJERO TARDE PRUEBA',
                    'usuario' => 'PRUEBATARDE'
                ],
                [
                    'nrocaja' => '2',
                    'nomcaja' => 'CAJERO NOCHE PRUEBA',
                    'usuario' => 'PRUEBANOCHE'
                ]
            ];

            $cajasIds = [];
            foreach ($cajasDefinidas as $c) {
                $cajeroId = $usuariosIds[$c['usuario']] ?? 0;
                $stmtCheckCaja = $this->dbh->prepare("SELECT codcaja FROM cajas WHERE codsucursal = ? AND (nomcaja = ? OR codigo = ?)");
                $stmtCheckCaja->execute([$codsucursal, $c['nomcaja'], $cajeroId]);
                $cajaRow = $stmtCheckCaja->fetch(PDO::FETCH_ASSOC);

                if ($cajaRow) {
                    $cajaId = $cajaRow['codcaja'];
                } else {
                    $stmtInsCaja = $this->dbh->prepare("INSERT INTO cajas (nrocaja, nomcaja, codigo, codsucursal) VALUES (?, ?, ?, ?)");
                    $stmtInsCaja->execute([$c['nrocaja'], $c['nomcaja'], $cajeroId, $codsucursal]);
                    $cajaId = $this->dbh->lastInsertId();
                    $reporte['cajas_creadas']++;
                }
                $cajasIds[$c['nomcaja']] = $cajaId;
            }

            // 4. APERTURA DE CAJA (ARQUEOCAJA ACTIVA)
            $cajaTardeId = $cajasIds['CAJERO TARDE PRUEBA'] ?? 0;
            if ($cajaTardeId > 0) {
                // Verificar si ya tiene arqueo abierto
                $stmtCheckArqueo = $this->dbh->prepare("SELECT codarqueo FROM arqueocaja WHERE codcaja = ? AND statusarqueo = 1");
                $stmtCheckArqueo->execute([$cajaTardeId]);
                if (!$stmtCheckArqueo->fetch(PDO::FETCH_ASSOC)) {
                    $montoInicial = isset($opciones['montoinicial']) ? floatval($opciones['montoinicial']) : 100.00;
                    $stmtInsArqueo = $this->dbh->prepare("INSERT INTO arqueocaja (codcaja, montoinicial, ingresos, ingresos2, egresos, creditos, abonos, efectivocaja, dineroefectivo, diferencia, comentarios, fechaapertura, fechacierre, statusarqueo) VALUES (?, ?, '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 'APERTURA DE PRUEBA AUTOMATICA', NOW(), '0000-00-00 00:00:00', 1)");
                    $stmtInsArqueo->execute([$cajaTardeId, $montoInicial]);
                    $reporte['cajas_abiertas']++;
                }
            }

            // 5. CREACIÓN DE MESAS DE BILLAR / SALAS
            $mesasDefinidas = [
                ['nromesa' => 'Mesa 1', 'orden' => 1],
                ['nromesa' => 'Mesa 2', 'orden' => 2],
                ['nromesa' => 'Mesa 3', 'orden' => 3],
                ['nromesa' => 'Mesa 4', 'orden' => 4],
                ['nromesa' => 'Mesa VIP', 'orden' => 5],
                ['nromesa' => 'Barra', 'orden' => 99]
            ];

            foreach ($mesasDefinidas as $m) {
                $stmtCheckMesa = $this->dbh->prepare("SELECT codmesa FROM mesasbillar WHERE codsucursal = ? AND nromesa = ?");
                $stmtCheckMesa->execute([$codsucursal, $m['nromesa']]);
                if (!$stmtCheckMesa->fetch(PDO::FETCH_ASSOC)) {
                    $stmtInsMesa = $this->dbh->prepare("INSERT INTO mesasbillar (nromesa, codsucursal, estado, orden) VALUES (?, ?, 1, ?)");
                    $stmtInsMesa->execute([$m['nromesa'], $codsucursal, $m['orden']]);
                    $reporte['mesas_creadas']++;
                }
            }

            // 6. ASIGNACIÓN DE STOCK A PRODUCTOS DE LA SUCURSAL
            $stockAsignar = isset($opciones['stock_unidades']) ? floatval($opciones['stock_unidades']) : 50.00;
            $stmtUpdStock = $this->dbh->prepare("UPDATE productos SET existencia = ?, stockoptimo = 100.00, stockmedio = 50.00, stockminimo = 10.00 WHERE codsucursal = ? AND existencia <= 0");
            $stmtUpdStock->execute([$stockAsignar, $codsucursal]);
            $reporte['productos_stock'] = $stmtUpdStock->rowCount();

            // 7. CLIENTES DE PRUEBA
            $clientesDefinidos = [
                [
                    'codcliente'   => '1',
                    'tipocliente'  => 'NATURAL',
                    'documcliente' => 1,
                    'dnicliente'   => '0',
                    'nomcliente'   => 'CONSUMIDOR FINAL (PRUEBA)',
                    'tlfcliente'   => '70000000',
                    'direccliente' => 'SUCURSAL PRUEBA'
                ],
                [
                    'codcliente'   => '2',
                    'tipocliente'  => 'NATURAL',
                    'documcliente' => 1,
                    'dnicliente'   => '1234567',
                    'nomcliente'   => 'CLIENTE VIP PRUEBA',
                    'tlfcliente'   => '71234567',
                    'direccliente' => 'SANTA CRUZ'
                ]
            ];

            foreach ($clientesDefinidos as $cli) {
                $stmtCheckCli = $this->dbh->prepare("SELECT idcliente FROM clientes WHERE codsucursal = ? AND (codcliente = ? OR dnicliente = ?)");
                $stmtCheckCli->execute([$codsucursal, $cli['codcliente'], $cli['dnicliente']]);
                if (!$stmtCheckCli->fetch(PDO::FETCH_ASSOC)) {
                    $stmtInsCli = $this->dbh->prepare("INSERT INTO clientes (codcliente, tipocliente, documcliente, dnicliente, nomcliente, razoncliente, girocliente, tlfcliente, id_provincia, id_departamento, direccliente, emailcliente, limitecredito, fechaingreso, codsucursal) VALUES (?, ?, ?, ?, ?, '', '', ?, 0, 0, ?, '', 500.00, CURDATE(), ?)");
                    $stmtInsCli->execute([$cli['codcliente'], $cli['tipocliente'], $cli['documcliente'], $cli['dnicliente'], $cli['nomcliente'], $cli['tlfcliente'], $cli['direccliente'], $codsucursal]);
                    $reporte['clientes_creados']++;
                }
            }

            $this->dbh->commit();

            return [
                'status'  => 'success',
                'mensaje' => '¡Seed completado exitosamente para la sucursal ' . $sucursal['nomsucursal'] . '!',
                'reporte' => $reporte
            ];

        } catch (Exception $e) {
            $this->dbh->rollBack();
            error_log("Error en SeedSucursalService::ejecutarSeed: " . $e->getMessage());
            return [
                'status'  => 'error',
                'mensaje' => 'Error al ejecutar el seeder: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Limpia datos de prueba (solo para la sucursal de prueba)
     */
    public function resetearPruebas($codsucursal) {
        $codsucursal = intval($codsucursal);

        $stmt = $this->dbh->prepare("SELECT nomsucursal, cuitsucursal FROM sucursales WHERE codsucursal = ?");
        $stmt->execute([$codsucursal]);
        $sucursal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$sucursal) {
            return ['status' => 'error', 'mensaje' => 'Sucursal no encontrada.'];
        }

        $esPrueba = (stripos($sucursal['nomsucursal'], 'PRUEBA') !== false || stripos($sucursal['cuitsucursal'], 'PRUEBA') !== false || $codsucursal == 6);
        if (!$esPrueba) {
            return ['status' => 'error', 'mensaje' => 'Por seguridad, solo se pueden resetear sucursales con nombre "PRUEBA".'];
        }

        try {
            $this->dbh->beginTransaction();

            // 1. Cerrar o eliminar arqueos de las cajas de esta sucursal
            $stmtCajas = $this->dbh->prepare("SELECT codcaja FROM cajas WHERE codsucursal = ?");
            $stmtCajas->execute([$codsucursal]);
            $cajasIds = $stmtCajas->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($cajasIds)) {
                $inQuery = implode(',', array_fill(0, count($cajasIds), '?'));
                $stmtDelArq = $this->dbh->prepare("DELETE FROM arqueocaja WHERE codcaja IN ($inQuery)");
                $stmtDelArq->execute($cajasIds);

                $stmtDelCajas = $this->dbh->prepare("DELETE FROM cajas WHERE codsucursal = ?");
                $stmtDelCajas->execute([$codsucursal]);
            }

            // 2. Eliminar usuarios de prueba de esta sucursal
            $stmtDelUser = $this->dbh->prepare("DELETE FROM usuarios WHERE codsucursal = ? AND usuario IN ('ADMINPRUEBA', 'PRUEBATARDE', 'PRUEBANOCHE', 'MESERAPRUEBA')");
            $stmtDelUser->execute([$codsucursal]);

            // 3. Resetear stock de productos de esta sucursal a 0
            $stmtResetStock = $this->dbh->prepare("UPDATE productos SET existencia = 0.00 WHERE codsucursal = ?");
            $stmtResetStock->execute([$codsucursal]);

            // 4. Eliminar mesas de billar de esta sucursal
            $stmtDelMesas = $this->dbh->prepare("DELETE FROM mesasbillar WHERE codsucursal = ?");
            $stmtDelMesas->execute([$codsucursal]);

            // 5. Eliminar clientes de prueba
            $stmtDelCli = $this->dbh->prepare("DELETE FROM clientes WHERE codsucursal = ?");
            $stmtDelCli->execute([$codsucursal]);

            $this->dbh->commit();

            return [
                'status'  => 'success',
                'mensaje' => 'Se limpiaron y resetearon exitosamente los datos de prueba de la sucursal ' . $sucursal['nomsucursal'] . '.'
            ];
        } catch (Exception $e) {
            $this->dbh->rollBack();
            error_log("Error en SeedSucursalService::resetearPruebas: " . $e->getMessage());
            return [
                'status'  => 'error',
                'mensaje' => 'Error al resetear datos: ' . $e->getMessage()
            ];
        }
    }
}
