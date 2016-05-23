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
 * Aquí se concentra la información de la empresa logueada
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */

class Empresa
{
	/**
	 *
	 *  Variable que almacena el id de la empresa logueada
	 *
	 */
	var $id;

	/**
	 *
	 *  Variable que almacena arreglo con los datos de la empresa logueada
	 *
	 */
	var $datos;

	/**
	 *
	 *  Variable que almacena arreglo con las prácticas aprobadas por la empresa
	 *
	 */
	var $arrPracticasTerminadas=array();

	/**
	 *
	 *  Variable que almacena arreglo con las prácticas en proceso de la empresa
	 *
	 */
	var $arrPracticasEnProceso=array();

	/**
	 *
	 *  Variable que almacena el id del criterio seleccionado para agregar evidencia
	 *
	 */
	VAR $criterioIdSeleccionado='';

	/**
	 * constructor de clase Empresa.
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