<?php
session_start();
require_once("classconexion.php");

class conectorDB extends Db
{
	public function __construct()
    {
        parent::__construct();
    } 	
	
	public function EjecutarSentencia($consulta, $valores = array()){  //funcion principal, ejecuta todas las consultas
		$resultado = false;
		
		if($statement = $this->dbh->prepare($consulta)){  //prepara la consulta
			if(preg_match_all("/(:\w+)/", $consulta, $campo, PREG_PATTERN_ORDER)){ //tomo los nombres de los campos iniciados con :xxxxx
				$campo = array_pop($campo); //inserto en un arreglo
				foreach($campo as $parametro){
					$statement->bindValue($parametro, $valores[substr($parametro,1)]);
				}
			}
			try {
				if (!$statement->execute()) { //si no se ejecuta la consulta...
					print_r($statement->errorInfo()); //imprimir errores
					return false;
				}
				$resultado = $statement->fetchAll(PDO::FETCH_ASSOC); //si es una consulta que devuelve valores los guarda en un arreglo.
				$statement->closeCursor();
			}
			catch(PDOException $e){
				echo "Error de ejecución: \n";
				print_r($e->getMessage());
			}	
		}
		return $resultado;
		$this->dbh = null; //cerramos la conexión
	} /// Termina funcion consultarBD
}/// Termina clase conectorDB

class Json
{
	private $json;

	################################ BUSQUEDA DE MARCAS ################################
	public function BuscaMarcas($filtro){
    $consulta = "SELECT CONCAT(nommarca) as label, codmarca FROM marcas WHERE CONCAT(nommarca) LIKE '%".$filtro."%' ORDER BY codmarca ASC LIMIT 0,10";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE MARCAS ################################
	
	################################ BUSQUEDA DE MODELOS ################################
	public function BuscaModelos($filtro){
    $consulta = "SELECT CONCAT(nommodelo) as label, codmodelo FROM modelos WHERE CONCAT(nommodelo) LIKE '%".$filtro."%' GROUP BY nommodelo ORDER BY codmodelo ASC LIMIT 0,10";
			$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE MODELOS ################################


	################################ BUSQUEDA DE PRODUCTOS X SUCURSAL ################################
	public function BuscaProductosxSucursal($filtro,$filtro2){

		$consulta = "SELECT
		CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ') | IMEI(',if(productos.imei='','***',productos.imei), ')', if(productos.existencia <= 0, ' | *** SIN STOCK ***', '') ) as label, 
	    productos.idproducto, 
	    productos.codproducto, 
	    productos.producto, 
	    productos.descripcion, 
	    productos.imei, 
	    productos.condicion, 
	    productos.fabricante, 
	    productos.codfamilia, 
	    productos.codsubfamilia, 
	    productos.codmarca, 
	    productos.codmodelo, 
	    productos.codpresentacion,
	    productos.codcolor, 
	    ROUND(productos.preciocompra, 2) preciocompra, 
	    ROUND(productos.precioxmenor, 2) precioxmenor, 
	    ROUND(productos.precioxmayor, 2) precioxmayor, 
	    ROUND(productos.precioxpublico, 2) precioxpublico, 
	    productos.existencia, 
	    productos.ivaproducto, 
	    ROUND(productos.descproducto, 2) descproducto, 
	    productos.fechaelaboracion, 
	    productos.fechaoptimo, 
	    productos.fechamedio, 
	    productos.fechaminimo, 
	    marcas.nommarca, 
	    modelos.nommodelo, 
	    presentaciones.nompresentacion, 
	    colores.nomcolor 
	    FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca 
	    LEFT JOIN modelos ON modelos.codmodelo = productos.codmodelo 
	    LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion
        LEFT JOIN colores ON productos.codcolor = colores.codcolor
        WHERE CONCAT(productos.codproducto, '',productos.producto, '',productos.codigobarra, '',marcas.nommarca, if(productos.imei='','0',productos.imei)) LIKE '%".$filtro."%'
        AND productos.codsucursal = '".strip_tags($filtro2)."'
        ORDER BY productos.codproducto 
        ASC LIMIT 0,15";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE PRODUCTOS X SUCURSAL ################################

	################################ BUSQUEDA DE PRODUCTOS ################################
	public function BuscaProductos($filtro){

        $consulta = "SELECT 
        CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ') | IMEI(',if(productos.imei='','***',productos.imei), ')', if(productos.existencia <= 0, ' | *** SIN STOCK ***', '') ) as label, 
	    productos.idproducto, 
	    productos.codproducto, 
	    productos.producto, 
	    productos.descripcion, 
	    productos.imei, 
	    productos.condicion, 
	    productos.fabricante, 
	    productos.codfamilia, 
	    productos.codsubfamilia, 
	    productos.codmarca, 
	    productos.codmodelo, 
	    productos.codpresentacion,
	    productos.codcolor, 
	    productos.codorigen, 
	    ROUND(productos.preciocompra, 2) preciocompra, 
	    ROUND(productos.precioxmenor, 2) precioxmenor, 
	    ROUND(productos.precioxmayor, 2) precioxmayor, 
	    ROUND(productos.precioxpublico, 2) precioxpublico, 
	    productos.existencia, 
	    productos.ivaproducto, 
	    ROUND(productos.descproducto, 2) descproducto, 
	    productos.fechaelaboracion, 
	    productos.fechaoptimo, 
	    productos.fechamedio, 
	    productos.fechaminimo, 
	    marcas.nommarca, 
	    modelos.nommodelo, 
	    presentaciones.nompresentacion, 
	    colores.nomcolor 
	    FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca 
	    LEFT JOIN modelos ON modelos.codmodelo = productos.codmodelo 
	    LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion
        LEFT JOIN colores ON productos.codcolor = colores.codcolor
        WHERE CONCAT(productos.codproducto, '',productos.producto, '',productos.codigobarra, '',marcas.nommarca, if(productos.imei='','0',productos.imei)) LIKE '%".$filtro."%' 
        AND productos.codsucursal= '".strip_tags($_SESSION["codsucursal"])."'
        ORDER BY productos.existencia DESC, productos.codproducto 
        ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE PRODUCTOS ################################

	################################ BUSQUEDA DE PRODUCTOS ################################
	public function BuscaProductosCompra($filtro){

        $consulta = "SELECT 
        CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ') | IMEI(',if(productos.imei='','***',productos.imei), ')' ) as label, 
	    productos.idproducto, 
	    productos.codproducto, 
	    productos.producto, 
	    productos.descripcion, 
	    productos.imei, 
	    productos.condicion, 
	    productos.fabricante, 
	    productos.codfamilia, 
	    productos.codsubfamilia, 
	    productos.codmarca, 
	    productos.codmodelo, 
	    productos.codpresentacion,
	    productos.codcolor, 
	    productos.codorigen, 
	    ROUND(productos.preciocompra, 2) preciocompra, 
	    ROUND(productos.precioxmenor, 2) precioxmenor, 
	    ROUND(productos.precioxmayor, 2) precioxmayor, 
	    ROUND(productos.precioxpublico, 2) precioxpublico, 
	    productos.existencia, 
	    productos.ivaproducto, 
	    ROUND(productos.descproducto, 2) descproducto, 
	    productos.fechaelaboracion, 
	    productos.fechaoptimo, 
	    productos.fechamedio, 
	    productos.fechaminimo, 
	    marcas.nommarca, 
	    modelos.nommodelo, 
	    presentaciones.nompresentacion, 
	    colores.nomcolor 
	    FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca 
	    LEFT JOIN modelos ON modelos.codmodelo = productos.codmodelo 
	    LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion
        LEFT JOIN colores ON productos.codcolor = colores.codcolor
        WHERE CONCAT(productos.codproducto, '',productos.producto, '',productos.codigobarra, '',marcas.nommarca, if(productos.imei='','0',productos.imei)) LIKE '%".$filtro."%' 
        AND productos.codsucursal= '".strip_tags($_SESSION["codsucursal"])."' 
        ORDER BY productos.codproducto 
        ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE PRODUCTOS ################################

	################################ BUSQUEDA DE PRODUCTOS POR CODIGO DE BARRA ################################
	public function BuscaProductoBarCode($filtro)
	{
	    $consulta = "SELECT 
	    CONCAT(productos.codproducto, ' | ',productos.producto, ' | MARCA(',marcas.nommarca, ') | MODELO(',if(productos.codmodelo='0','***',modelos.nommodelo), ')') as label, 
	    productos.idproducto, 
	    productos.codproducto, 
	    productos.producto, 
	    productos.descripcion, 
	    productos.imei, 
	    productos.condicion, 
	    productos.fabricante, 
	    productos.codfamilia, 
	    productos.codsubfamilia, 
	    productos.codmarca, 
	    productos.codmodelo, 
	    productos.codpresentacion,
	    productos.codcolor, 
	    ROUND(productos.preciocompra, 2) preciocompra, 
	    ROUND(productos.precioxmenor, 2) precioxmenor, 
	    ROUND(productos.precioxmayor, 2) precioxmayor, 
	    ROUND(productos.precioxpublico, 2) precioxpublico, 
	    productos.existencia, 
	    productos.ivaproducto, 
	    ROUND(productos.descproducto, 2) descproducto, 
	    productos.fechaelaboracion, 
	    productos.fechaoptimo, 
	    productos.fechamedio, 
	    productos.fechaminimo, 
	    marcas.nommarca, 
	    modelos.nommodelo, 
	    presentaciones.nompresentacion, 
	    colores.nomcolor 
	    FROM productos INNER JOIN marcas ON productos.codmarca = marcas.codmarca 
	    LEFT JOIN modelos ON modelos.codmodelo = productos.codmodelo 
	    LEFT JOIN presentaciones ON productos.codpresentacion = presentaciones.codpresentacion
        LEFT JOIN colores ON productos.codcolor = colores.codcolor  
	    WHERE productos.codigobarra = '$filtro' 
	    AND productos.codsucursal = '".strip_tags($_SESSION["codsucursal"])."' 
	    GROUP BY productos.codproducto, productos.codsucursal 
	    ORDER BY productos.codproducto ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE PRODUCTOS POR CODIGO DE BARRA ################################

	



	################################ BUSQUEDA DE COMBOS X SUCURSAL ################################
	public function BuscaCombosxSucursal($filtro,$filtro2){

		$consulta = "SELECT
		CONCAT(combos.nomcombo) as label, 
        combos.idcombo, 
        combos.codcombo, 
        combos.nomcombo, 
        ROUND(combos.preciocompra, 2) preciocompra, 
        ROUND(combos.precioventa, 2) precioventa, 
        ROUND(combos.existencia, 2) existencia, 
        combos.ivacombo, 
        ROUND(combos.desccombo, 2) desccombo 
        FROM combos 
        WHERE CONCAT(combos.codcombo, '',combos.nomcombo) LIKE '%".$filtro."%'
        AND combos.codsucursal = '".strip_tags($filtro2)."'
        ORDER BY combos.codcombo 
        ASC LIMIT 0,15";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE COMBOS X SUCURSAL ################################

	################################ BUSQUEDA DE COMBOS ################################
	public function BuscaCombos($filtro){

        $consulta = "SELECT 
        CONCAT(combos.nomcombo) as label, 
        combos.idcombo, 
        combos.codcombo, 
        combos.nomcombo, 
        ROUND(combos.preciocompra, 2) preciocompra, 
        ROUND(combos.precioventa, 2) precioventa,
        ROUND(combos.existencia, 2) existencia, 
        combos.ivacombo, 
        ROUND(combos.desccombo, 2) desccombo 
        FROM combos 
        WHERE CONCAT(combos.codcombo, '',combos.nomcombo) LIKE '%".$filtro."%' 
        AND codsucursal= '".strip_tags($_SESSION["codsucursal"])."' 
        ORDER BY combos.codcombo 
        ASC LIMIT 0,15";
        $conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE COMBOS ################################



	################################ BUSQUEDA DE CLIENTES X SUCURSAL ################################
	public function BuscaClientesxSucursal($filtro,$filtro2){

		$consulta = "SELECT
		CONCAT(if(clientes.documcliente='0','DOC.',documentos.documento), ': ',clientes.dnicliente, ': ',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente), ' | ',if(clientes.direccliente='','***',clientes.direccliente)) as label,  
		clientes.codcliente, 
		clientes.dnicliente,
		clientes.tipocliente,
		clientes.nomcliente,
		clientes.razoncliente,
		clientes.direccliente, 
		clientes.limitecredito
	    FROM
        clientes 
        LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
        WHERE CONCAT(clientes.dnicliente, '',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente), '',clientes.girocliente) LIKE '%".$filtro."%'
        AND clientes.codsucursal = '".strip_tags($filtro2)."'
        ORDER BY clientes.codcliente 
        ASC LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE CLIENTES X SUCURSAL ################################

	################################ BUSQUEDA DE CLIENTES ################################
	public function BuscaClientes($filtro){
	$consulta = "SELECT
	CONCAT(if(clientes.documcliente='0','DOC.',documentos.documento), ': ',clientes.dnicliente, ': ',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente)) as label,   
	clientes.codcliente, 
	clientes.dnicliente,
	clientes.tipocliente,
	clientes.nomcliente,
	clientes.razoncliente,
	clientes.limitecredito,
	ROUND(SUM(if(pag.montocredito!='0.00',clientes.limitecredito-pag.montocredito,clientes.limitecredito)), 2) creditodisponible
    FROM
        clientes 
        LEFT JOIN documentos ON clientes.documcliente = documentos.coddocumento
        LEFT JOIN
        (SELECT
           codcliente, montocredito       
           FROM creditosxclientes WHERE codsucursal = '".strip_tags($_SESSION['codsucursal'])."') pag ON pag.codcliente = clientes.codcliente
           WHERE CONCAT(clientes.dnicliente, '',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente)) LIKE '%".$filtro."%' 
        AND clientes.codsucursal = '".strip_tags($_SESSION['codsucursal'])."'
        GROUP BY clientes.codcliente 
        ORDER BY clientes.codcliente ASC LIMIT 0,10";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE CLIENTES ################################

	



	################################ BUSQUEDA DE FACTURAS X SUCURSAL ################################
	public function BuscaFacturas($filtro,$filtro2){

		$consulta = "SELECT
		CONCAT(ventas.tipodocumento, ' Nº ',ventas.codfactura, ': ',if(ventas.codcliente='0','CONSUMIDOR FINAL',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente))) as label, 
		ventas.idventa, 
		ventas.codventa, 
		ventas.codfactura 
		FROM ventas LEFT JOIN clientes ON ventas.codcliente = clientes.codcliente 
		WHERE CONCAT(ventas.tipodocumento, ventas.codventa, ventas.codfactura, if(ventas.codcliente='0','CONSUMIDOR FINAL',if(clientes.nomcliente='',clientes.razoncliente,clientes.nomcliente))) LIKE '%".$filtro."%'
        AND ventas.codsucursal = '".strip_tags($filtro2)."' 
		AND ventas.statusventa != 'ANULADA'
		AND ventas.notacredito = 0
        ORDER BY ventas.codventa 
        ASC LIMIT 0,15";
		$conexion = new conectorDB;
		$this->json = $conexion->EjecutarSentencia($consulta);
		return $this->json;
	}
	################################ BUSQUEDA DE FACTURAS X SUCURSAL ################################

}/// TERMINA CLASE  ///
?>