<?php
/**
 * Servicio de Dominio: ComandaService
 * Especializado en el flujo de comandas móviles para meseras, gestión de mesas y sincronización con el POS.
 * Aplica principios SOLID, transacciones PDO y desacoplamiento.
 * 
 * Autor: Ing. Daniel Méndez Amutari
 * Sistema: POS Ribersoft
 */

require_once __DIR__ . '/classconexion.php';

class ComandaService {
    private $dbh;

    public function __construct($dbh = null) {
        if ($dbh instanceof PDO) {
            $this->dbh = $dbh;
        } else {
            $db = new Db();
            $reflector = new ReflectionClass('Db');
            $prop = $reflector->getProperty('dbh');
            $prop->setAccessible(true);
            $this->dbh = $prop->getValue($db);
        }
    }

    /**
     * Obtiene el arqueo abierto actualmente en una sucursal
     */
    public function obtenerArqueoActivo($codsucursal) {
        $sql = "SELECT a.codarqueo, a.codcaja, c.nomcaja, a.fechaapertura, a.montoinicial
                FROM arqueocaja a
                INNER JOIN cajas c ON a.codcaja = c.codcaja
                WHERE c.codsucursal = :codsucursal AND a.statusarqueo = '1'
                ORDER BY a.codarqueo DESC LIMIT 1";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codsucursal' => (int)$codsucursal]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Valida el PIN de 4 dígitos ingresado por la mesera
     */
    public function validarPinMesera($pin, $codsucursal) {
        $codsucursal = (int)$codsucursal;
        $pin = trim($pin);

        // 1. Verificar si hay caja abierta en la sucursal
        $arqueo = $this->obtenerArqueoActivo($codsucursal);
        if (!$arqueo) {
            return [
                'success' => false,
                'codigo_error' => 'CAJA_CERRADA',
                'mensaje' => 'La cajera aún no ha abierto caja en esta sucursal. Pídele que abra turno para comenzar.'
            ];
        }

        // 2. Buscar mesera por PIN y sucursal
        $sql = "SELECT m.idmesera, m.nombre, m.codsucursal, m.estado, s.nomsucursal 
                FROM meseras_turno m
                LEFT JOIN sucursales s ON m.codsucursal = s.codsucursal
                WHERE m.pin = :pin AND m.codsucursal = :codsucursal AND m.estado = 1
                LIMIT 1";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':pin' => $pin, ':codsucursal' => $codsucursal]);
        $mesera = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$mesera) {
            return [
                'success' => false,
                'codigo_error' => 'PIN_INVALIDO',
                'mensaje' => 'PIN incorrecto o no asignado a esta sucursal.'
            ];
        }

        return [
            'success' => true,
            'mesera' => [
                'id' => (int)$mesera['idmesera'],
                'nombre' => $mesera['nombre'],
                'codsucursal' => (int)$mesera['codsucursal'],
                'sucursal' => $mesera['nomsucursal'] ?? 'Sucursal'
            ],
            'arqueo' => [
                'codarqueo' => (int)$arqueo['codarqueo'],
                'codcaja' => (int)$arqueo['codcaja'],
                'nomcaja' => $arqueo['nomcaja'],
                'fechaapertura' => $arqueo['fechaapertura']
            ]
        ];
    }

    /**
     * Lista mesas activas de una sucursal
     */
    public function listarMesas($codsucursal, $soloActivas = true) {
        $sql = "SELECT codmesa, nromesa, codsucursal, estado, orden 
                FROM mesasbillar 
                WHERE codsucursal = :codsucursal";
        if ($soloActivas) {
            $sql .= " AND estado = 1";
        }
        $sql .= " ORDER BY orden ASC, codmesa ASC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':codsucursal' => (int)$codsucursal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Guarda o actualiza una mesa
     */
    public function guardarMesa($codmesa, $nromesa, $codsucursal, $estado = 1, $orden = 0) {
        $nromesa = trim($nromesa);
        if (empty($nromesa)) {
            return ['success' => false, 'mensaje' => 'El nombre de la mesa es obligatorio.'];
        }

        if (!empty($codmesa)) {
            $stmt = $this->dbh->prepare("UPDATE mesasbillar SET nromesa = ?, estado = ?, orden = ? WHERE codmesa = ?");
            $stmt->execute([$nromesa, (int)$estado, (int)$orden, (int)$codmesa]);
            return ['success' => true, 'mensaje' => 'Mesa actualizada con éxito.'];
        } else {
            $stmt = $this->dbh->prepare("INSERT INTO mesasbillar (nromesa, codsucursal, estado, orden) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nromesa, (int)$codsucursal, (int)$estado, (int)$orden]);
            return ['success' => true, 'mensaje' => 'Mesa creada con éxito.', 'codmesa' => $this->dbh->lastInsertId()];
        }
    }

    /**
     * Cambia el estado (activa/inactiva) de una mesa
     */
    public function cambiarEstadoMesa($codmesa, $estado) {
        $stmt = $this->dbh->prepare("UPDATE mesasbillar SET estado = ? WHERE codmesa = ?");
        $stmt->execute([(int)$estado, (int)$codmesa]);
        return ['success' => true];
    }

    /**
     * Lista meseras registradas para la sucursal
     */
    public function listarMeseras($codsucursal) {
        $stmt = $this->dbh->prepare("SELECT idmesera, nombre, pin, codsucursal, estado, fecharegistro 
                                     FROM meseras_turno 
                                     WHERE codsucursal = ? 
                                     ORDER BY estado DESC, nombre ASC");
        $stmt->execute([(int)$codsucursal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Guarda o actualiza mesera del turno
     */
    public function guardarMesera($idmesera, $nombre, $pin, $codsucursal, $estado = 1) {
        $nombre = trim($nombre);
        $pin = trim($pin);
        if (empty($nombre) || strlen($pin) !== 4) {
            return ['success' => false, 'mensaje' => 'Nombre obligatorio y el PIN debe tener exactamente 4 dígitos.'];
        }

        if (!empty($idmesera)) {
            $stmt = $this->dbh->prepare("UPDATE meseras_turno SET nombre = ?, pin = ?, estado = ? WHERE idmesera = ?");
            $stmt->execute([$nombre, $pin, (int)$estado, (int)$idmesera]);
            return ['success' => true, 'mensaje' => 'Mesera actualizada con éxito.'];
        } else {
            $stmt = $this->dbh->prepare("INSERT INTO meseras_turno (nombre, pin, codsucursal, estado) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nombre, $pin, (int)$codsucursal, (int)$estado]);
            return ['success' => true, 'mensaje' => 'Mesera agregada con éxito.', 'idmesera' => $this->dbh->lastInsertId()];
        }
    }

    /**
     * Lista catálogo de productos y combos con stock para la app móvil
     */
    public function listarProductosComanda($codsucursal) {
        // 1. Productos individuales
        $sqlP = "SELECT p.idproducto, p.codproducto, p.producto, p.precioxpublico as precio, 
                        p.existencia, p.tipoproducto, f.nomfamilia as categoria
                 FROM productos p
                 LEFT JOIN familias f ON p.codfamilia = f.codfamilia
                 WHERE p.codsucursal = :suc AND p.existencia > 0
                 ORDER BY f.nomfamilia ASC, p.producto ASC";
        $stmtP = $this->dbh->prepare($sqlP);
        $stmtP->execute([':suc' => (int)$codsucursal]);
        $productos = $stmtP->fetchAll(PDO::FETCH_ASSOC);

        // 2. Combos activos con stock disponible (propio y de todos sus insumos)
        $sqlC = "SELECT c.idcombo as idproducto, c.codcombo as codproducto, c.nomcombo as producto, 
                        c.precioventa as precio, c.existencia, 'COMBO' as tipoproducto, 'COMBOS' as categoria
                 FROM combos c
                 WHERE c.codsucursal = ? AND c.existencia > 0
                 ORDER BY c.nomcombo ASC";
        $stmtC = $this->dbh->prepare($sqlC);
        $stmtC->execute([(int)$codsucursal]);
        $combosRaw = $stmtC->fetchAll(PDO::FETCH_ASSOC);

        $stmtInsumos = $this->dbh->prepare("
            SELECT cxp.cantidad, p.existencia
            FROM combosxproductos cxp
            INNER JOIN productos p ON (
                (cxp.idproducto = p.idproducto OR cxp.codproducto = p.codproducto)
                AND p.codsucursal = ?
            )
            WHERE cxp.codcombo = ? AND cxp.codsucursal = ?
        ");

        $combos = [];
        foreach ($combosRaw as $c) {
            $stmtInsumos->execute([(int)$codsucursal, $c['codproducto'], (int)$codsucursal]);
            $insumos = $stmtInsumos->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($insumos)) {
                $stockCombo = floatval($c['existencia']);
                foreach ($insumos as $ins) {
                    $cantRequerida = floatval($ins['cantidad']);
                    $stockProd = floatval($ins['existencia']);
                    if ($cantRequerida > 0) {
                        $combosPosibles = floor($stockProd / $cantRequerida);
                        if ($combosPosibles < $stockCombo) {
                            $stockCombo = $combosPosibles;
                        }
                    }
                }
                // Si alguno de sus insumos no tiene stock suficiente, no se muestra a la mesera
                if ($stockCombo <= 0) {
                    continue;
                }
                $c['existencia'] = $stockCombo;
            } elseif (floatval($c['existencia']) <= 0) {
                continue;
            }

            $combos[] = $c;
        }

        return array_merge($combos, $productos);
    }

    /**
     * Registra una nueva comanda emitida por la mesera
     */
    public function crearComanda($idmesera, $codmesa, $nombre_mesa, $codsucursal, $items, $metodo_pago = 'EFECTIVO') {
        if (empty($items) || !is_array($items)) {
            return ['success' => false, 'status' => 400, 'mensaje' => 'La comanda debe contener al menos un producto.'];
        }

        $arqueo = $this->obtenerArqueoActivo($codsucursal);
        if (!$arqueo) {
            return ['success' => false, 'status' => 400, 'mensaje' => 'No hay caja abierta activa en esta sucursal.'];
        }

        // Obtener nombre de la mesera
        $stmtM = $this->dbh->prepare("SELECT nombre FROM meseras_turno WHERE idmesera = ?");
        $stmtM->execute([(int)$idmesera]);
        $nombre_mesera = $stmtM->fetchColumn() ?: 'Mesera';

        // Calcular total y normalizar items para que nunca sean null
        $total = 0;
        $itemsNormalizados = [];
        foreach ($items as $item) {
            $cant = floatval($item['cantidad'] ?? 1);
            $precio = floatval($item['precio'] ?? 0);
            $subtotal = $cant * $precio;
            $total += $subtotal;

            $nombreProd = trim($item['producto'] ?? $item['nombre'] ?? 'Producto');
            $idProd = (int)($item['idproducto'] ?? $item['id'] ?? 0);
            $codProd = trim($item['codproducto'] ?? $item['codigo'] ?? '');
            $tipoProd = strtoupper(trim($item['tipoproducto'] ?? $item['tipo'] ?? 'PRODUCTO'));

            // Auto-resolver código si no fue enviado por el cliente
            if (empty($codProd) && $idProd > 0) {
                if ($tipoProd === 'COMBO') {
                    $stRes = $this->dbh->prepare("SELECT codcombo FROM combos WHERE idcombo = ? AND codsucursal = ?");
                    $stRes->execute([$idProd, (int)$codsucursal]);
                    $codProd = $stRes->fetchColumn() ?: '';
                } else {
                    $stRes = $this->dbh->prepare("SELECT codproducto FROM productos WHERE idproducto = ? AND codsucursal = ?");
                    $stRes->execute([$idProd, (int)$codsucursal]);
                    $codProd = $stRes->fetchColumn() ?: '';
                }
            }

            $itemsNormalizados[] = [
                'id' => $idProd,
                'idproducto' => $idProd,
                'codigo' => $codProd,
                'codproducto' => $codProd,
                'producto' => $nombreProd,
                'nombre' => $nombreProd,
                'cantidad' => $cant,
                'precio' => $precio,
                'subtotal' => $subtotal,
                'tipo' => $tipoProd,
                'tipoproducto' => $tipoProd,
                'notas' => trim($item['notas'] ?? '')
            ];
        }

        // Idempotencia: evitar pedidos duplicados por doble clic accidental en menos de 15 segundos
        $sqlCheck = "SELECT idcomanda, total FROM comandas_meseras 
                     WHERE idmesera = ? AND codsucursal = ? AND codmesa = ? 
                       AND estado = 'PENDIENTE' 
                       AND fechahora >= (NOW() - INTERVAL 15 SECOND)
                     ORDER BY idcomanda DESC LIMIT 1";
        $stmtCheck = $this->dbh->prepare($sqlCheck);
        $stmtCheck->execute([(int)$idmesera, (int)$codsucursal, (int)$codmesa]);
        $existente = $stmtCheck->fetch(PDO::FETCH_ASSOC);
        if ($existente && abs(floatval($existente['total']) - $total) < 0.01) {
            return [
                'success' => true,
                'status' => 200,
                'mensaje' => 'Comanda enviada a caja exitosamente.',
                'idcomanda' => (int)$existente['idcomanda'],
                'total' => floatval($existente['total']),
                'reintento' => true
            ];
        }

        try {
            $this->dbh->beginTransaction();

            // Incluir metadatos de cobro sugerido
            $comandaPayload = [
                'metodo_pago' => strtoupper(trim($metodo_pago)),
                'items' => $itemsNormalizados
            ];

            $sql = "INSERT INTO comandas_meseras 
                    (idmesera, nombre_mesera, codmesa, nombre_mesa, codsucursal, codarqueo, items_json, total, metodo_pago, estado, fechahora)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'PENDIENTE', NOW())";
            $stmt = $this->dbh->prepare($sql);
            $stmt->execute([
                (int)$idmesera,
                $nombre_mesera,
                (int)$codmesa,
                $nombre_mesa,
                (int)$codsucursal,
                (int)$arqueo['codarqueo'],
                json_encode($itemsNormalizados, JSON_UNESCAPED_UNICODE),
                $total,
                strtoupper(trim($metodo_pago ?: 'EFECTIVO'))
            ]);

            $idcomanda = $this->dbh->lastInsertId();
            $this->dbh->commit();

            return [
                'success' => true,
                'status' => 200,
                'mensaje' => 'Comanda enviada a caja exitosamente.',
                'idcomanda' => (int)$idcomanda,
                'total' => $total
            ];
        } catch (Exception $e) {
            $this->dbh->rollBack();
            error_log("Error en crearComanda: " . $e->getMessage());
            return ['success' => false, 'status' => 500, 'mensaje' => 'Error al guardar la comanda: ' . $e->getMessage()];
        }
    }

    /**
     * Lista comandas pendientes de una sucursal para la pantalla de la cajera
     */
    public function listarComandasPendientes($codsucursal) {
        $arqueo = $this->obtenerArqueoActivo($codsucursal);
        if (!$arqueo) return [];

        $sql = "SELECT c.*, 
                       TIMESTAMPDIFF(MINUTE, c.fechahora, NOW()) as minutos_transcurridos
                FROM comandas_meseras c
                WHERE c.codsucursal = :suc 
                  AND c.codarqueo = :arq 
                  AND c.estado = 'PENDIENTE'
                ORDER BY c.fechahora ASC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':suc' => (int)$codsucursal, ':arq' => (int)$arqueo['codarqueo']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$r) {
            $itemsDecoded = json_decode($r['items_json'], true) ?: [];
            foreach ($itemsDecoded as &$it) {
                if (empty($it['producto']) && !empty($it['nombre'])) {
                    $it['producto'] = $it['nombre'];
                }
            }
            $r['items'] = $itemsDecoded;
        }
        return $rows;
    }

    /**
     * Marca una o varias comandas como cobradas cuando la cajera completa la venta
     */
    public function cobrarComanda($idcomanda, $codventa) {
        $ids = is_array($idcomanda) ? $idcomanda : [(int)$idcomanda];
        $ids = array_filter($ids, function($v) { return (int)$v > 0; });
        if (empty($ids)) return ['success' => true];

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $this->dbh->prepare("UPDATE comandas_meseras 
                                     SET estado = 'COBRADA', codventa = ?, fechacobro = NOW() 
                                     WHERE idcomanda IN ($placeholders)");
        $params = array_merge([$codventa], array_map('intval', array_values($ids)));
        $stmt->execute($params);
        return ['success' => true, 'afectadas' => $stmt->rowCount()];
    }

    /**
     * Anula o cancela una comanda pendiente (por error o duplicado)
     */
    public function anularComanda($idcomanda, $motivo = 'Cancelado en caja') {
        $stmt = $this->dbh->prepare("UPDATE comandas_meseras 
                                     SET estado = 'CANCELADA', codventa = ? 
                                     WHERE idcomanda = ?");
        $stmt->execute([$motivo, (int)$idcomanda]);
        return ['success' => true, 'mensaje' => 'Comanda anulada exitosamente'];
    }

    /**
     * Restaura una comanda a estado PENDIENTE (deshacer cobro o anulación)
     */
    public function reabrirComanda($idcomanda) {
        $stmt = $this->dbh->prepare("UPDATE comandas_meseras 
                                     SET estado = 'PENDIENTE', codventa = NULL, fechacobro = NULL 
                                     WHERE idcomanda = ?");
        $stmt->execute([(int)$idcomanda]);
        return ['success' => true, 'afectadas' => $stmt->rowCount(), 'mensaje' => 'Comanda restaurada a pendientes exitosamente.'];
    }

    /**
     * Lista comandas ya cobradas en el turno actual para consulta de la cajera
     */
    public function listarComandasCobradas($codsucursal) {
        $arqueo = $this->obtenerArqueoActivo($codsucursal);
        if (!$arqueo) return [];

        $sql = "SELECT c.*, 
                       TIMESTAMPDIFF(MINUTE, c.fechahora, NOW()) as minutos_transcurridos
                FROM comandas_meseras c
                WHERE c.codsucursal = :suc 
                  AND c.codarqueo = :arq 
                  AND c.estado = 'COBRADA'
                ORDER BY c.fechacobro DESC LIMIT 25";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':suc' => (int)$codsucursal, ':arq' => (int)$arqueo['codarqueo']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as &$r) {
            $itemsDecoded = json_decode($r['items_json'], true) ?: [];
            foreach ($itemsDecoded as &$it) {
                if (empty($it['producto']) && !empty($it['nombre'])) {
                    $it['producto'] = $it['nombre'];
                }
            }
            $r['items'] = $itemsDecoded;
        }
        return $rows;
    }

    /**
     * Obtiene el historial del turno actual para la pestaña 'Mi Turno' de la mesera
     */
    public function historialMesera($idmesera, $codsucursal) {
        $arqueo = $this->obtenerArqueoActivo($codsucursal);
        if (!$arqueo) {
            return [
                'caja_abierta' => false,
                'total_cobrado' => 0,
                'total_pendiente' => 0,
                'comandas' => []
            ];
        }

        $sql = "SELECT c.*, 
                       TIMESTAMPDIFF(MINUTE, c.fechahora, NOW()) as minutos_transcurridos
                FROM comandas_meseras c
                WHERE c.idmesera = :idm 
                  AND c.codarqueo = :arq
                ORDER BY c.fechahora DESC";
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute([':idm' => (int)$idmesera, ':arq' => (int)$arqueo['codarqueo']]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $total_cobrado = 0;
        $total_pendiente = 0;

        foreach ($rows as &$r) {
            $r['items'] = json_decode($r['items_json'], true) ?: [];
            if ($r['estado'] === 'COBRADA') {
                $total_cobrado += floatval($r['total']);
            } elseif ($r['estado'] === 'PENDIENTE') {
                $total_pendiente += floatval($r['total']);
            }
        }

        return [
            'caja_abierta' => true,
            'nomcaja' => $arqueo['nomcaja'],
            'codarqueo' => (int)$arqueo['codarqueo'],
            'total_cobrado' => $total_cobrado,
            'total_pendiente' => $total_pendiente,
            'comandas' => $rows
        ];
    }
}
