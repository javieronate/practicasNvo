<?php

/**
 *
 * Mentor Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * Clase Mentor de sitio Buenas Prácticas
 *
 * @var mysqli
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */


/**
 *
 * Mentor del sitio Buenas Prácticas
 *
 * Clase Mentor
 *
 * Aquí se concentra la información del mentor logueada
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */

class Mentor
{
	/**
	 *
	 *  Variable que almacena el id del mentor logueada
	 *
	 */
	var $id;

	/**
	 *
	 *  Variable que almacena arreglo con los datos del mentor logueada
	 *
	 */
	var $datos;

	/**
	 *
	 *  Variable que almacena arreglo con las empresas supervisadas por el mentor
	 *
	 */
	var $arrEmpresasSupervisadas=array();

	/**
	 *
	 *  arreglo que almacena lista de eventos posteriores al último login del mentor
	 *
	 */
	var $arrEventosNuevos=array();

	/**
	 *
	 *  arreglo que almacena datos para la grafica de inicio de mentor
	 *
	 */
	var $arrGraficaMentor=array();

	/**
	 *
	 *  arreglo que almacena datos de la empresa que se muestar en el detalle de empresa
	 *
	 */
	var $arrEmpesaSeleccionada=array();

	/**
	 * constructor de clase Mentor.
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