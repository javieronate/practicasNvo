<?php

/**
 *
 * Controlador Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * Clase Controlador de sitio Buenas Prácticas
 *
 * @var mysqli
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */


/**
 *
 * Controlador del sitio Buenas Prácticas
 *
 * Clase Controller del modelo MVC (Model - Vew - Controller)
 *
 * Aquí se concentra la comunicación entre las vistas y el Modelo
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */

include_once ("Modelo.php");
include_once ("Compania.php");
include_once ("FxFormularios.php");

/**
 *
 * Controlador del módulo de Reportes
 *
 * Clase controller del modelo MVC (Model - Vew - Controller)
 *
 * @package Reporteador
 * @author  Javier Oñate Mendía (Dédalo)
 *
 */
class Controlador
{
	/**
	 * Almacena objeto de tipo ModeloReporteador
	 */
    var $modelo;

 	/**
	 * Almacena objeto de tipo fx, que es un helper para elementos de formularios
	 */
    var $fx;

	/**
	 * Almacena variable que indica en que zona del sitio se encuentra el usuario
	 */
	var $zona = 'general';

	/**
	 * Almacena variable que indica la pantalla a mostrar
	 */
	var $pantalla = 'pantallas/general/inicio.php';

	/**
	 * Variable que guarda un arreglo de los datos de una pagina de categoria
	 */
	var $arrDatosPaginaCategoria=array();

	/**
	 * Variable que guarda un arreglo de las practicas pertenecientes a la categoria activa
	 */
	var $arrPracticasDeCategoria=array();

	/**
	 * Variable que guarda un arreglo de los datos de una pagina de practica
	 */
	var $arrDatosPaginaPractica=array();

	var $empresa=array();

	var $usuario=array();

	var $mensaje='';


	///////// variables legacy que habra que desechar

	/**
	 * Almacena el id del reporte seleccionado por el usuario
	 */
    var $reporteSeleccionado;

	/**
	 * Almacena el índice del arreglo modelo->arrFiltros activo por la seleccion del usuario
	 */
	var $itemFiltroSeleccionado;

	/**
	 * Almacena el arreglo con los valores disponibles de acuerdo al item del arreglo de filtros
     * este arreglo puebla el menu desplegable de datos en la seccion de filtros
	 */
	//var $arrOpcionesFiltroSeleccionado=array();

	/**
	 * Bandera que indica si se despliega el campo de opción multiple con datos de filtrado o no
	 */
	var $ensenarComboFiltro=0;


	/**
	 *
	 *  Constructor del Controlador que:
	 *  Inicializa un modelo en la variable "modelo" dentro del controlador
	 *  Pone una conexión a la base de datos en el modelo
	 *  Inicializa la variable fx que es un helper de elementos de formulario
	 *
	 */
	function __construct()
    {
        $this->modelo = new Modelo();
        $this->fx=new FxFormularios();
    }

	/**
	 *  destructor de la clase
	 *  por ahora no se usa
	 */
	function __destruct()
    {

    }

	/**
	 *
	 * Recibe el objeto $db del tipo mysqli
	 * generado en el index cada vez que se recibe un submit y lo envía al modelo
	 *
	 * @param $db
	 */
	function ponerConexionMysql($db)
	{
		$this->modelo->ponerConexion($db);
	}

	/**
	 *
	 * Instruye al modelo que construya los arreglos de catalogos
	 *
	 */
	function llenarCatalogosModelo()
	{
		$this->modelo->hacerArreglosBase();
	}

	/**
	 *
	 *  función que recibe valores del post y evalúa las acciones a llevar a cabo
	 *
	 * @param $post
	 *
	 */
	function evaluarPost($post)
    {
        switch ($post['accion']){
	        case 'general':
		        $this->evaluarPostGeneral($post);
		        break;
	        case 'login':
		        $usuario=$this->modelo->validarLogin($post['usuario'],$post['clave']);
				if($usuario['rol']=='fallo') {
					$this->empresa=array();
					$this->usuario=array();
					$this->mensaje="No se encontro el usuario. Vuelva a intentar";
					$this->pantalla='pantallas/general/login.php';
				} else if ($usuario['rol']=='empresa'){
					$this->usuario=array();
					$this->empresa=$usuario;
					$this->pantalla='pantallas/empresa/inicio.php';
				}else if($usuario['rol']=='administrador'){
					$this->usuario=$usuario;
					$this->pantalla='pantallas/admin/inicio.php';
				}else if($usuario['rol']=='mentor'){
					$this->usuario=$usuario;
					$this->pantalla='pantallas/mentor/inicio.php';
				}
				break;
	        case 'logout':
		        $this->empresa=array();
		        $this->usuario=array();
		        $this->pantalla='pantallas/general/login.php';
		        break;
	        case 'empresa':
		        $this->evaluarPostEmpresa($post);
		        break;
	        case 'mentor':
		        $this->evaluarPostMentor($post);
		        break;
	        case 'admin':
		        $this->evaluarPostAdmin($post);
		        break;
        }
    }

	function evaluarPostEmpresa($post)
	{
		switch ($post['subaccion']) {
			case 'irA':
				switch ($post['item']) {
					case 'inicio':
						$this->pantalla='pantallas/empresa/inicio.php';
						break;
				}
		}
	}

	function evaluarPostMentor($post)
	{
		switch ($post['subaccion']) {
			case 'irA':
				switch ($post['item']) {
					case 'inicio':
						$this->pantalla='pantallas/mentor/inicio.php';
						break;
				}
		}
	}

	function evaluarPostAdmin($post)
	{
		switch ($post['subaccion']) {
			case 'irA':
				switch ($post['item']) {
					case 'inicio':
						$this->pantalla='pantallas/admin/inicio.php';
						break;
				}
		}
	}








	function evaluarPostGeneral($post)
	{
		switch($post['subaccion']){
			case 'irA':
				switch ($post['item']){
					case 'innovacion':
						$this->pantalla='pantallas/general/innovacion.php';
						break;
					case 'redesTurismo':
						$this->pantalla='pantallas/general/redesTurismo.php';
						break;
					case 'capacitacion':
						$this->pantalla='pantallas/general/capacitacion.php';
						break;
					case 'login':
						$this->pantalla='pantallas/general/login.php';
						break;
					case 'inicio':
						$this->pantalla='pantallas/general/inicio.php';
						break;
				}
				break;
			case 'irACategoria':
				$this->arrDatosPaginaCategoria=$this->modelo->buscarDatosPaginaCategoria($post['item']);
				$this->arrPracticasDeCategoria=$this->modelo->buscarPracticasDeCategoria($post['item']);
				$this->pantalla='pantallas/general/categorias.php';
				break;
			case 'irAPractica':
				$this->arrDatosPaginaPractica=$this->modelo->buscarDatosPaginaPractica($post['item']);
				$this->pantalla='pantallas/general/practica.php';
				break;
		}
	}






	function postEmpresa($post)
	{
		switch ($post['subaccion']){
			case 'idrADescripcionPractica':
//				echo ($post['item']);
				$this->modelo->arrPracticaDescripcion = $this->modelo->buscarDescripcionPractica($post['item']);
				$this->pantalla = "pantallas/".$this->zona."/descripcionPractica.php";
				break;
		}
	}








	/**
	 *
	 *  Llama al archivo encargado de construir la pantalla para el usuario (sección View en le MVC)
	 *
	 */
	function mostrarPantalla()
    {
	    include ('pantallas/general/cabecera.php');
	    include ('pantallas/general/menuPrincipal.php');
	    include ($this->pantalla);
//	    switch ($this->zona){
//		    case 'general':
//			    include ($this->pantalla);
//			    break;
////		    case 'login';
////			    include 'pantallas/inicio.php';
////			    break;
////		    case 'admin':
////			    include 'pantallas/admin/inicio.php';
////			    break;
////		    case 'enlace':
////			    include 'pantallas/enlace/inicio.php';
////			    break;
////		    case 'compania':
////			    //include 'pantallas/compania/inicio.php';
//////			    include $this->pantalla;
////
////			    break;
//	    }
	    include ('pantallas/general/pie.php');
//	    $this->fx->ensenarArreglo($this->arrDatosPaginaCategoria,'arrDatosPaginaCategoria');
    }


}

