<?php
//CARRITO DE ENTRADAS DE PRODUCTOS
session_start();
$ObjetoCarrito   = json_decode($_POST['MiCarrito']);
if ($ObjetoCarrito->Codigo=="vaciar") {
    unset($_SESSION["CarritoPedido"]);
} else {
    if (isset($_SESSION['CarritoPedido'])) {
        $carrito=$_SESSION['CarritoPedido'];
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
            $precio3 = $ObjetoCarrito->Precio3;
            $precio4 = $ObjetoCarrito->Precio4;
            $descproductofact = $ObjetoCarrito->DescproductoFact;
            $descproducto = $ObjetoCarrito->Descproducto;
            $ivaproducto = $ObjetoCarrito->Ivaproducto;
            $precioconiva = $ObjetoCarrito->Precioconiva;
            $cantidad = $ObjetoCarrito->Cantidad;
            $opCantidad = $ObjetoCarrito->opCantidad;

            $donde = -1;
            for($i=0;$i<=count($carrito)-1;$i ++){
                
                if($id == $carrito[$i]['id'] && $txtCodigo == $carrito[$i]['txtCodigo'] && $producto == $carrito[$i]['producto']){

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
                    "precio3"=>$precio3,
                    "precio4"=>$precio4,
                    "descproductofact"=>$descproductofact,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "precioconiva"=>$precioconiva,
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
                    "precio3"=>$precio3,
                    "precio4"=>$precio4,
                    "descproductofact"=>$descproductofact,
                    "descproducto"=>$descproducto,
                    "ivaproducto"=>$ivaproducto,
                    "precioconiva"=>$precioconiva,
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
        $precio3 = $ObjetoCarrito->Precio3;
        $precio4 = $ObjetoCarrito->Precio4;
        $descproductofact = $ObjetoCarrito->DescproductoFact;
        $descproducto = $ObjetoCarrito->Descproducto;
        $ivaproducto = $ObjetoCarrito->Ivaproducto;
        $precioconiva = $ObjetoCarrito->Precioconiva;
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
            "precio3"=>$precio3,
            "precio4"=>$precio4,
            "descproductofact"=>$descproductofact,
            "descproducto"=>$descproducto,
            "ivaproducto"=>$ivaproducto,
            "precioconiva"=>$precioconiva,
            "cantidad"=>$cantidad
        );
    }
    $carrito = array_values(
        array_filter($carrito, function($v) {
            return $v['cantidad'] > 0;
        })
    );
    $_SESSION['CarritoPedido'] = $carrito;
    echo json_encode($_SESSION['CarritoPedido']);
}
