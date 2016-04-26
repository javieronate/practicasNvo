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
include_once ("Empresa.php");
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

	var $empresa;

	var $personal=array();

	var $mensaje='';

	var $arrListaPracticas=array();

	var $arrPreguntasAutoevaluacion=array();


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
					$this->personal=array();
					$this->mensaje="No se encontro el usuario. Vuelva a intentar";
					$this->pantalla='pantallas/general/login.php';
				} else if ($usuario['rol']=='empresa'){
					$this->personal=array();
					$this->empresa=new Empresa($usuario);
					$this->hacerArreglosDeSeccionEmpresa();
					$this->pantalla='pantallas/empresa/inicio.php';
				}else if($usuario['rol']=='administrador'){
					$this->personal=$usuario;
					$this->pantalla='pantallas/admin/inicio.php';
				}else if($usuario['rol']=='mentor'){
					$this->personal=$usuario;
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
					case 'perfil':
						$this->pantalla='pantallas/empresa/perfil.php';
						break;
					case 'autoevaluacion':
						$this->arrPreguntasAutoevaluacion=$this->modelo->hacerArregloAutoevaluacion();
						$this->pantalla='pantallas/empresa/autoevaluacion.php';
						break;
					case 'agregarPractica':
						$this->pantalla='pantallas/empresa/agregarPractica.php';
						break;
					case 'evidencias':
						$this->pantalla='pantallas/empresa/agregarEvidencias.php';
						break;
				}
				break;
			case 'autoevaluacionGrabar':
				$this->actualizarRespuestasAutoevaluacion($post);

				//$this->modelo->validarAutoevaluacion($post,$this->arrPreguntasAutoevaluacion,$this->empresa->id);
				//$this->pantalla='pantallas/empresa/agregarPractica.php';
				break;

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

	function hacerArreglosDeSeccionEmpresa()
	{
		// hacer arreglo de todas las practicas anotando los estatus y fechas de las ingresadas por la empresa
		$this->arrListaPracticas= $this->modelo->hacerArregloBuenasPracticas($this->empresa->id);

		// hacer arreglo de las practicas terminadas por la empresa
		$arrPracticasTerminadas=$this->modelo->hacerArregloPracticas($this->empresa->id,3);
		$this->empresa->arrPracticasTerminadas=$arrPracticasTerminadas;

		// hacer arreglo de las practicas en proces de la empresa
		$arrPracticasEnProceso=$this->modelo->hacerArregloPracticas($this->empresa->id,2);
		$this->empresa->arrPracticasEnProceso=$arrPracticasEnProceso;

	}

	function actualizarRespuestasAutoevaluacion($post)
	{
		for($x=0;$x<count($this->arrPreguntasAutoevaluacion);$x++){
			$nombre="respuesta".$x;
			if(!isset($post[$nombre])){
				$this->arrPreguntasAutoevaluacion[$x]['correcta']=0;
				$this->arrPreguntasAutoevaluacion[$x]['valor']='';
			}else{
				$this->arrPreguntasAutoevaluacion[$x]['correcta']=1;
				$this->arrPreguntasAutoevaluacion[$x]['valor']=$post[$nombre];
			}
		}
	}


//	function postEmpresa($post)
//	{
//		switch ($post['subaccion']){
//			case 'idrADescripcionPractica':
////				echo ($post['item']);
//				$this->modelo->arrPracticaDescripcion = $this->modelo->buscarDescripcionPractica($post['item']);
//				$this->pantalla = "pantallas/".$this->zona."/descripcionPractica.php";
//				break;
//		}
//	}








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
	    include ('pantallas/general/pie.php');
	    if(DEBUG==1){
		    include ('pantallas/general/debug.php');
	    }

//	    $this->fx->ensenarArreglo($this->arrDatosPaginaCategoria,'arrDatosPaginaCategoria');
    }


}

