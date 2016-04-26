<?php

/**
 *
 * Empresa Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * Clase Empresa de sitio Buenas Prácticas
 *
 * @var mysqli
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */


/**
 *
 * Empresa del sitio Buenas Prácticas
 *
 * Clase Empresa
 *
 * Aquí se concentra la informacion de la empresa logueda
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */


class Empresa
{
	var $id;

	var $datos;

	var $arrPracticasTerminadas=array();

	var $arrPracticasEnProceso=array();



	/**
	 *
	 *  Constructor de la clase que:
	 *
	 */
	function __construct($usuario)
	{
		$this->id=$usuario['id'];
		$this->datos = $usuario;
	}

	/**
	 *  destructor de la clase
	 *  por ahora no se usa
	 */
	function __destruct()
	{

	}

}