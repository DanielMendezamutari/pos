<?php
/**
 * Servicio de Dominio: Gestión de Capacitación, Sesiones de Prueba y Cruce de Marcas
 * Arquitectura desacoplada bajo Principios SOLID para evitar sobrecargar class.php
 */

class EntrenamientoCajasService {
    private $dbh;

    public function __construct($dbh) {
        $this->dbh = $dbh;
    }

    /**
     * Evalúa si un arqueo califica como sesión de prueba, capacitación o apertura accidental.
     * 
     * @param array $arq Fila de arqueocaja
     * @param float $totalRecaudado Monto total recaudado del turno
     * @param int $totalTransacciones Cantidad de ventas realizadas
     * @return array ['es_prueba' => bool, 'motivo' => string, 'duracion_minutos' => int]
     */
    public function evaluarSiEsPrueba(array $arq, float $totalRecaudado = 0, int $totalTransacciones = 0): array {
        // 1. Verificación por bandera de base de datos
        if (!empty($arq['es_entrenamiento']) && intval($arq['es_entrenamiento']) === 1) {
            return [
                'es_prueba' => true,
                'motivo' => 'Marcado explícitamente en el POS como Modo Entrenamiento',
                'duracion_minutos' => 0
            ];
        }

        // 2. Verificación por comentarios/observaciones del cajero
        $comentario = strtoupper(trim($arq['comentarios'] ?? ''));
        $palabrasClave = ['PRUEBA', 'CAPACITACION', 'CAPACITACIÓN', 'ENTRENAMIENTO', 'TEST', 'ENSEÑAR', 'ENSEÑANZA', 'PRACTICA', 'PRÁCTICA'];
        foreach ($palabrasClave as $p) {
            if (strpos($comentario, $p) !== false) {
                return [
                    'es_prueba' => true,
                    'motivo' => "El cajero registró nota de capacitación: '{$comentario}'",
                    'duracion_minutos' => 0
                ];
            }
        }

        // 3. Verificación heurística por duración y volumen financiero
        if (!empty($arq['fechaapertura']) && !empty($arq['fechacierre']) && $arq['fechacierre'] !== '0000-00-00 00:00:00') {
            $tsApertura = strtotime($arq['fechaapertura']);
            $tsCierre = strtotime($arq['fechacierre']);
            $duracionSeg = $tsCierre - $tsApertura;
            $duracionMin = intval(round($duracionSeg / 60));

            // Si duró menos de 25 minutos y no tuvo ventas reales (o menos de Bs. 50 en pruebas)
            if ($duracionMin >= 0 && $duracionMin <= 25 && $totalRecaudado <= 50.00 && $totalTransacciones <= 3) {
                return [
                    'es_prueba' => true,
                    'motivo' => "Micro-turno de {$duracionMin} minutos con recaudación de Bs. " . number_format($totalRecaudado, 2) . " (Apertura técnica/capacitación)",
                    'duracion_minutos' => $duracionMin
                ];
            }
        }

        return [
            'es_prueba' => false,
            'motivo' => 'Turno operativo legítimo',
            'duracion_minutos' => 0
        ];
    }

    /**
     * Busca los últimos arqueos de una sucursal y retorna el último arqueo OPERATIVO REAL,
     * descartando micro-aperturas de prueba o capacitación.
     * 
     * @param int $codsucursal
     * @return array ['arqueo' => array, 'descartes_prueba' => array]
     */
    public function obtenerUltimoArqueoOperativoReal(int $codsucursal, ?string $fecha = null): array {
        $sql = "SELECT a.*, c.nrocaja, c.nomcaja 
                FROM arqueocaja a
                JOIN cajas c ON a.codcaja = c.codcaja
                WHERE c.codsucursal = :codsucursal
                  AND a.statusarqueo = 0";
        $params = [':codsucursal' => $codsucursal];

        if (!empty($fecha)) {
            $fechaSig = date('Y-m-d', strtotime($fecha . ' +1 day'));
            $sqlFecha = $sql . " AND (DATE(a.fechacierre) = :fecha OR DATE(a.fechaapertura) = :fecha OR DATE(a.fechacierre) = :fechaSig) 
                                 ORDER BY a.codarqueo DESC LIMIT 8";
            $paramsFecha = $params;
            $paramsFecha[':fecha'] = $fecha;
            $paramsFecha[':fechaSig'] = $fechaSig;
            $stmt = $this->dbh->prepare($sqlFecha);
            $stmt->execute($paramsFecha);
            $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $candidatos = [];
        }

        if (empty($candidatos)) {
            $sqlDefault = $sql . " ORDER BY a.codarqueo DESC LIMIT 8";
            $stmt = $this->dbh->prepare($sqlDefault);
            $stmt->execute($params);
            $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if (empty($candidatos)) {
            return ['arqueo' => null, 'descartes_prueba' => []];
        }

        $descartes = [];
        foreach ($candidatos as $cand) {
            // Calcular recaudación rápida para este arqueo
            $stmtVentas = $this->dbh->prepare("SELECT COUNT(*) as transacciones, COALESCE(SUM(totalpago), 0) as total 
                                               FROM ventas WHERE codarqueo = ?");
            $stmtVentas->execute([$cand['codarqueo']]);
            $infVentas = $stmtVentas->fetch(PDO::FETCH_ASSOC);
            $totalRecaudado = floatval($infVentas['total'] ?? 0);
            $cantTransacciones = intval($infVentas['transacciones'] ?? 0);

            $eval = $this->evaluarSiEsPrueba($cand, $totalRecaudado, $cantTransacciones);
            if ($eval['es_prueba']) {
                $descartes[] = [
                    'codarqueo' => $cand['codarqueo'],
                    'caja' => $cand['nomcaja'],
                    'motivo' => $eval['motivo'],
                    'fechaapertura' => $cand['fechaapertura'],
                    'fechacierre' => $cand['fechacierre']
                ];
                continue; // Saltar arqueo de prueba y seguir al operativo anterior
            }

            // Encontró el primer arqueo operativo legítimo
            return [
                'arqueo' => $cand,
                'descartes_prueba' => $descartes
            ];
        }

        // Si todos fueron calificados como prueba, devolver el primero por fallback
        return [
            'arqueo' => $candidatos[0],
            'descartes_prueba' => $descartes
        ];
    }

    /**
     * Analiza correlación y compensación de marcas en la misma categoría (ej. cervezas en combos).
     * Permite a la IA no alarmar con robo cuando una cajera nueva confunde una marca por otra.
     * 
     * @param array $faltantes Lista de faltantes con ['producto', 'diferencia', 'costo_unit', 'costo_total']
     * @param array $sobrantes Lista de sobrantes con ['producto', 'diferencia', 'costo_unit', 'costo_total']
     * @return array Cruces detectados y pérdida compensada
     */
    public function analizarCruceDeMarcas(array $faltantes, array $sobrantes): array {
        $cruces = [];
        $marcasCerveza = ['PROST', 'AMSTEL', 'DUCAL', 'PACEÑA', 'PACENA', 'HUARI', 'CONTI', 'BURGUESA', 'CORONA', 'HEINEKEN', 'BOHEM'];

        $faltantesCerveza = [];
        foreach ($faltantes as $f) {
            $nom = strtoupper($f['producto']);
            foreach ($marcasCerveza as $m) {
                if (strpos($nom, $m) !== false) {
                    $faltantesCerveza[] = $f;
                    break;
                }
            }
        }

        $sobrantesCerveza = [];
        foreach ($sobrantes as $s) {
            $nom = strtoupper($s['producto']);
            foreach ($marcasCerveza as $m) {
                if (strpos($nom, $m) !== false) {
                    $sobrantesCerveza[] = $s;
                    break;
                }
            }
        }

        if (!empty($faltantesCerveza) && !empty($sobrantesCerveza)) {
            $totalFaltCerv = 0;
            $totalSobrCerv = 0;
            $costoFalt = 0;
            $nombresFalt = [];
            $nombresSobr = [];

            foreach ($faltantesCerveza as $fc) {
                $cant = abs($fc['diferencia']);
                $totalFaltCerv += $cant;
                $costoFalt += $fc['costo_total'];
                $nombresFalt[] = trim($fc['producto']) . " (-{$cant})";
            }
            foreach ($sobrantesCerveza as $sc) {
                $cant = abs($sc['diferencia']);
                $totalSobrCerv += $cant;
                $nombresSobr[] = trim($sc['producto']) . " (+{$cant})";
            }

            $cruces[] = [
                'categoria' => 'CERVEZAS',
                'unidades_faltantes' => $totalFaltCerv,
                'unidades_sobrantes' => $totalSobrCerv,
                'detalle_faltantes' => implode(', ', $nombresFalt),
                'detalle_sobrantes' => implode(', ', $nombresSobr),
                'costo_aparente' => $costoFalt,
                'explicacion' => "Se detectó correlación directa entre marcas de cerveza. Es altamente probable que la cajera haya registrado una marca en el POS y entregado otra físicamente al despachar combos (Cruce de marcas sin pérdida real)."
            ];
        }

        return $cruces;
    }
}
