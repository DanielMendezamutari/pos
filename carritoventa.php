<?php
//CARRITO DE ENTRADAS DE PRODUCTOS
isset($_SESSION) or session_start();
if (!isset($_POST['MiCarrito'])) return;
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo == "vaciar") {
    unset($_SESSION["CarritoVenta"]);
    echo json_encode([]);
    exit;
} elseif ($ObjetoCarrito->Codigo == "cargar_lote") {
    $nuevos = [];
    if (isset($ObjetoCarrito->Items) && is_array($ObjetoCarrito->Items)) {
        require_once __DIR__ . '/class/classconexion.php';
        $dbConn = new Db();
        $refConn = new ReflectionClass('Db');
        $pConn = $refConn->getProperty('dbh');
        $pConn->setAccessible(true);
        $dbhLote = $pConn->getValue($dbConn);
        $sucursalActiva = isset($_SESSION['codsucursal']) ? (int)$_SESSION['codsucursal'] : 0;

        foreach ($ObjetoCarrito->Items as $item) {
            $itemId = $item->Id ?? 0;
            $itemCod = trim($item->Codigo ?? '');
            $tipoDet = $item->TipoDetalle ?? 1;

            // Si el código viene vacío, resolverlo desde la base de datos
            if (empty($itemCod) && $itemId > 0 && $dbhLote && $sucursalActiva > 0) {
                if ($tipoDet == 2) {
                    $stC = $dbhLote->prepare("SELECT codcombo FROM combos WHERE idcombo = ? AND codsucursal = ?");
                    $stC->execute([$itemId, $sucursalActiva]);
                    $itemCod = $stC->fetchColumn() ?: '';
                } else {
                    $stP = $dbhLote->prepare("SELECT codproducto FROM productos WHERE idproducto = ? AND codsucursal = ?");
                    $stP->execute([$itemId, $sucursalActiva]);
                    $itemCod = $stP->fetchColumn() ?: '';
                }
            }

            $nuevos[] = array(
                "id" => $itemId,
                "txtCodigo" => $itemCod,
                "producto" => $item->Producto ?? 'Producto',
                "descripcion" => $item->Descripcion ?? '',
                "imei" => $item->Imei ?? '',
                "condicion" => $item->Condicion ?? '',
                "codmarca" => $item->Codmarca ?? 0,
                "marcas" => $item->Marcas ?? '',
                "codmodelo" => $item->Codmodelo ?? 0,
                "modelos" => $item->Modelos ?? '',
                "codpresentacion" => $item->Codpresentacion ?? 0,
                "presentacion" => $item->Presentacion ?? '',
                "codcolor" => $item->Codcolor ?? 0,
                "color" => $item->Color ?? '',
                "precio" => $item->Precio ?? 0,
                "precio2" => $item->Precio2 ?? 0,
                "descproducto" => $item->Descproducto ?? 0,
                "ivaproducto" => $item->Ivaproducto ?? '(E)',
                "existencia" => $item->Existencia ?? 99,
                "precioconiva" => $item->Precioconiva ?? $item->Precio2 ?? 0,
                "tipodetalle" => $tipoDet,
                "tipoproducto" => $item->TipoProducto ?? ($tipoDet == 2 ? 'COMBO' : 'PRODUCTO'),
                "cantidad" => $item->Cantidad ?? 1
            );
        }
    }
    $_SESSION["CarritoVenta"] = $nuevos;
    echo json_encode($_SESSION["CarritoVenta"]);
    exit;
} else {
    if (isset($_SESSION['CarritoVenta'])) {
        $carrito=$_SESSION['CarritoVenta'];
        if (isset($ObjetoCarrito->Codigo)) {
            $id = $ObjetoCarrito->Id;
            $txtCodigo = $ObjetoCarrito->Codigo;
            $producto= $ObjetoCarrito->Producto;
            $descripcion= $ObjetoCarrito->Descripcion;
            $imei= $ObjetoCarrito->Imei;
            $condicion= $ObjetoCarrito->Condicion;
            $codmarca = $ObjetoCarrito->Codmarca;
            $marcas = $ObjetoCarrito->Marcas;
            $codmodelo = $ObjetoCarrito->Codmodelo;
            $modelos = $ObjetoCarrito->Modelos;
            $codpresentacion = $ObjetoCarrito->Codpresentacion;
            $presentacion = $ObjetoCarrito->Presentacion;
            $codcolor = $ObjetoCarrito->Codcolor;
            $color = $ObjetoCarrito->Color;
            $precio = $ObjetoCarrito->Precio;
            $precio2 = $ObjetoCarrito->Precio2;
            $descproducto = $ObjetoCarrito->Descproducto;
            $ivaproducto = $ObjetoCarrito->Ivaproducto;
            $existencia = $ObjetoCarrito->Existencia;
            $precioconiva = $ObjetoCarrito->Precioconiva;
            $tipodetalle = $ObjetoCarrito->TipoDetalle;
            $tipoproducto = isset($ObjetoCarrito->TipoProducto) ? $ObjetoCarrito->TipoProducto : 'PRODUCTO';
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;

            //array_search("whatisearchfor2", array_column(array_column($response, "types"), 0));
            //$donde  = array_search($txtCodigo, array_column($carrito, 'txtCodigo'));
            //$apellidos = array_column($registros, 'apellido', 'id');
            //$keys = array_keys(array_column($userdb, 'uid'), 40489); //resultado multiple
            //$keys = array_keys(array_column($userdb, 'uid'), 40489);

            $donde = -1;
            for($i=0;$i<=count($carrito)-1;$i ++){
                
                if($tipodetalle == $carrito[$i]['tipodetalle'] && $id == $carrito[$i]['id'] && $txtCodigo == $carrito[$i]['txtCodigo'] && $producto == $carrito[$i]['producto']){

                    $donde=$i;
                }
            }

            if($donde != -1){

                if ($opCantidad === '=') {
                    $cuanto = $cantidad;
                } else {
                    $cuanto = $carrito[$donde]['cantidad'] + $cantidad;
                }
                $carrito[$donde] = array(
                    "id"=>$id,
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "descripcion"=>$descripcion,
                    "imei"=>$imei,
                    "condicion"=>$condicion,
                    "codmarca"=>$codmarca,
                    "marcas"=>$marcas,
                    "codmodelo"=>$codmodelo,
                    "modelos"=>$modelos,
                    "codpresentacion"=>$codpresentacion,
                    "presentacion"=>$presentacion,
                    "codcolor"=>$codcolor,
                    "color"=>$color,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "existencia"=>$existencia,
                    "precioconiva"=>$precioconiva,
                    "tipodetalle"=>$tipodetalle,
                    "tipoproducto"=>$tipoproducto,
                    "cantidad"=>$cuanto
                );
            } else {
                $carrito[]=array(
                    "id"=>$id,
                    "txtCodigo"=>$txtCodigo,
                    "producto"=>$producto,
                    "descripcion"=>$descripcion,
                    "imei"=>$imei,
                    "condicion"=>$condicion,
                    "codmarca"=>$codmarca,
                    "marcas"=>$marcas,
                    "codmodelo"=>$codmodelo,
                    "modelos"=>$modelos,
                    "codpresentacion"=>$codpresentacion,
                    "presentacion"=>$presentacion,
                    "codcolor"=>$codcolor,
                    "color"=>$color,
                    "precio"=>$precio,
                    "precio2"=>$precio2,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "existencia"=>$existencia,
                    "precioconiva"=>$precioconiva,
                    "tipodetalle"=>$tipodetalle,
                    "tipoproducto"=>$tipoproducto,
                    "cantidad"=>$cantidad
                );
            }
        }
    } else {
        $id = $ObjetoCarrito->Id;
        $txtCodigo = $ObjetoCarrito->Codigo;
        $producto = $ObjetoCarrito->Producto;
        $descripcion= $ObjetoCarrito->Descripcion;
        $imei= $ObjetoCarrito->Imei;
        $condicion= $ObjetoCarrito->Condicion;
        $codmarca = $ObjetoCarrito->Codmarca;
        $marcas = $ObjetoCarrito->Marcas;
        $codmodelo = $ObjetoCarrito->Codmodelo;
        $modelos = $ObjetoCarrito->Modelos;
        $codpresentacion = $ObjetoCarrito->Codpresentacion;
        $presentacion = $ObjetoCarrito->Presentacion;
        $codcolor = $ObjetoCarrito->Codcolor;
        $color = $ObjetoCarrito->Color;
        $precio = $ObjetoCarrito->Precio;
        $precio2 = $ObjetoCarrito->Precio2;
        $descproducto = $ObjetoCarrito->Descproducto;
        $ivaproducto = $ObjetoCarrito->Ivaproducto;
        $existencia = $ObjetoCarrito->Existencia;
        $precioconiva = $ObjetoCarrito->Precioconiva;
        $tipodetalle = $ObjetoCarrito->TipoDetalle;
        $tipoproducto = isset($ObjetoCarrito->TipoProducto) ? $ObjetoCarrito->TipoProducto : 'PRODUCTO';
        $cantidad = $ObjetoCarrito->Cantidad;
        $carrito[] = array(
            "id"=>$id,
            "txtCodigo"=>$txtCodigo,
            "producto"=>$producto,
            "descripcion"=>$descripcion,
            "imei"=>$imei,
            "condicion"=>$condicion,
            "codmarca"=>$codmarca,
            "marcas"=>$marcas,
            "codmodelo"=>$codmodelo,
            "modelos"=>$modelos,
            "codpresentacion"=>$codpresentacion,
            "presentacion"=>$presentacion,
            "codcolor"=>$codcolor,
            "color"=>$color,
            "precio"=>$precio,
            "precio2"=>$precio2,
            "descproducto"=>$descproducto,
            "ivaproducto"=>$ivaproducto,
            "existencia"=>$existencia,
            "precioconiva"=>$precioconiva,
            "tipodetalle"=>$tipodetalle,
            "tipoproducto"=>$tipoproducto,
            "cantidad"=>$cantidad
        );
    }
    $carrito = array_values(
        array_filter($carrito, function($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoVenta'] = $carrito;
    echo json_encode($_SESSION['CarritoVenta']);
}
