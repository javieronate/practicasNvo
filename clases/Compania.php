<?php

/**
 * Created by PhpStorm.
 * User: jom
 * Date: 3/29/16
 * Time: 12:20 PM
 */
class Compania
{
	var $db;

	var $datosCompania = array();


	/**
	 *
	 *  Constructor del Modelo
	 *
	 *  Inicializa el arreglo de filtros de busqueda
	 *
	 */
	function __construct($db,$id)
	{
		$this->db = $db;
		$this->recabarDatos($id);
	}

	/**
	 *  destructor de la clase
	 *  por ahora no se usa
	 */
	function __destruct()
	{

	}

	function recabarDatos($id)
	{
		$sql = "select * from bp_companias where id=" . $id;
		$resultado = $this->db->query($sql);
		$datos = $resultado->fetch_assoc();
		$this->datosCompania['nombre'] = $datos['nombre'];
		$this->datosCompania['latitud'] = $datos['latitud'];
		$this->datosCompania['longitud'] = $datos['longitud'];
	}
}