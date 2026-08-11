<?php
//CARRITO DE ENTRADAS DE PRODUCTOS
isset($_SESSION) or session_start();
if (!isset($_POST['MiCarrito'])) return;
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo=="vaciar") {
    unset($_SESSION["CarritoVenta"]);
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
