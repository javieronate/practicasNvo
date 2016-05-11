<?php

/**
 *
 * Admon Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * Clase Admon de sitio Buenas Prácticas
 *
 * @var mysqli
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */


/**
 *
 * Admon del sitio Buenas Prácticas
 *
 * Clase Admon
 *
 * Aquí se concentra la información del administrador logueado
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */

class Admon
{
	/**
	 *
	 *  Variable que almacena el id del admon logueado
	 *
	 */
	var $id;

	/**
	 *
	 *  Variable que almacena arreglo con los datos del admon logueado
	 *
	 */
	var $datos;

	/**
	 *
	 *  Variable que almacena arreglo con lmentores supervisados por el admon logueado
	 *
	 */
	var $arrPersonal=array();


	/**
	 * constructor de clase Admon.
	 *
	 * @param $usuario
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