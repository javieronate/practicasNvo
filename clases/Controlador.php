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
	 * Variable que guarda un arreglo de los datos de la categoria a representar en las páginas de categorías
	 * Se usa en la sección genral -> innovacion
	 */
	var $arrDatosPaginaCategoria=array();

	/**
	 * Variable que guarda un arreglo de las practicas pertenecientes a la categoria activa.
	 * Se usa en la seccion general -> innovación -> categoria
	 */
	var $arrPracticasDeCategoria=array();

	/**
	 * Variable que guarda un arreglo de los datos de una pagina de practica
	 * Se usa en la sección general -> innovación -> categoria -> practica
	 */
	var $arrDatosPaginaPractica=array();

	/**
	 * Variable que guarda un objeto Empresa cuando el log in es de una empresa
	 */
	var $empresa;

	/**
	 * Variable que guarda un objeto Personal cuando el log in es de una persona
	 */
	var $personal=array();

	/**
	 * Variable que guarda el texto de mensaje a reproducir al usuario
	 */
	var $mensaje='';

	/**
	 * Variable que guarda un arreglo de todas las practicas organizadas por categoria de práctica
	 * con datos de fecha de inicio de la practica por la empresa y status de avance
	 */
	var $arrListaPracticas=array();

	/**
	 * Variable que guarda un arreglo de las preguntas de la autoevaluación y las respuestas recibidas
	 */
	var $arrPreguntasAutoevaluacion=array();

	/**
	 * Variable que guarda un arreglo de los estados. Se usa en la página de perfil
	 */
	var $arrEstados=array();

	/**
	 * Variable que guarda un arreglo de los municipios por estado. Se usa en la página de perfil
	 */
	var $arrMunicipios=array();

	/**
	 * Variable que guarda un arreglo temporal de los datos de la empresa durante el llenado de datos en el perfil.
	 */
	var $arrDatosEmpresaTmp=array();

	/**
	 *
	 *  Constructor del Controlador que:
	 *  Inicializa un modelo en la variable "modelo" dentro del controlador
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
	 * Instruye al modelo que construya los arreglos de catalogos necesarios en el inicio
	 *
	 */
	function llenarCatalogosModelo()
	{
		$this->modelo->hacerArreglosBase();
	}

	/**
	 *
	 *  función que recibe valores del post y evalúa las acciones a llevar a cabo
	 *  Evalua el parámetro accion y dependiendo de este llama a la función correspondiente a su valor
	 *
	 * @param $post
	 *
	 */
	function evaluarPost($post)
    {

	    // TODO: Hacer función de limpieza de arreglos
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
		        //$this->usuario=array();
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

	/**
	 *
	 *  función que recibe valores del post cuando la accion es 'empresa' y evalúa las acciones a llevar a cabo
	 *  Evalúa el parámetro subaccion y ejecuta las funciones correspondientes a la subaccion
	 *
	 * @param $post
	 *
	 */
	function evaluarPostEmpresa($post)
	{
		switch ($post['subaccion']) {
			case 'irA':
				switch ($post['item']) {
					case 'inicio':
						$this->pantalla='pantallas/empresa/inicio.php';
						break;
					case 'perfil':
						if(count($this->arrEstados)==0) {
							$this->arrEstados = $this->modelo->hacerArregloEstados();
						}
						if(count($this->arrMunicipios)==0) {
							$this->arrMunicipios = $this->modelo->hacerArregloMunicipios();
						}
						if(count($this->arrDatosEmpresaTmp)==0) {
							$this->arrDatosEmpresaTmp = $this->empresa->datos;
						}else{
							$this->actualizarDatosTmp($post);
						}
						$this->pantalla='pantallas/empresa/perfil.php';
						break;
					case 'autoevaluacion':
						$this->arrPreguntasAutoevaluacion=$this->modelo->hacerArregloAutoevaluacion();
						$this->pantalla='pantallas/empresa/autoevaluacion.php';
						break;
					case 'admonPracticasEvidencias':
						$this->pantalla='pantallas/empresa/admonPracticasEvidencias.php';
						break;
				}
				break;
			case 'autoevaluacionGrabar':
				$this->actualizarRespuestasAutoevaluacion($post);
				$correcto=$this->modelo->validarAutoevaluacion($this->arrPreguntasAutoevaluacion,$this->empresa->id);
				if($correcto==1){
					$hoy=date('Y-m-d');
					$this->hacerArreglosDeSeccionEmpresa();
					$this->empresa->datos['autoevaluacionHecha']=1;
					$this->empresa->datos['fechaAutoevaluacion']=$hoy;
					$this->pantalla='pantallas/empresa/inicio.php';
				}
				break;
			case 'perfilGrabar':
				$this->actualizarDatosTmp($post);
				$correcto=$this->modelo->validarPerfil($this->arrDatosEmpresaTmp);
				if($correcto==1) {
					$this->empresa->datos['infoCapturada']=1;
					$this->pantalla='pantallas/empresa/inicio.php';
				}else{
					$this->pantalla='pantallas/empresa/perfil.php';
				}
				break;
			case 'cambiarEstado':
				$this->actualizarDatosTmp($post);
				$this->arrDatosEmpresaTmp['municipio']='Municipio';
				break;
			case 'agregarEvidencia':
				$this->grabarEvidencia($post);
				break;
			case 'agregarPractica':
				$hoy=date('Y-m-d');
				$this->modelo->agregarPracticaAEmpresa($this->empresa->id,$post['menuPracticaPendiente'],'2',HOY,'1','Agregada por el usuario','3');
				$this->hacerArregloPracticasEnProceso();
				break;
		}
	}

	/**
	 *
	 *  función que recibe valores del post cuando la accion es 'mentor' y evalúa las acciones a llevar a cabo
	 *  Evalúa el parámetro subaccion y ejecuta las funciones correspondientes a la subaccion
	 *
	 * @param $post
	 *
	 */
	function evaluarPostMentor($post)
	{
		switch ($post['subaccion']) {
			case 'irA':
				switch ($post['item']) {
					case 'inicio':
						$this->pantalla='pantallas/mentor/inicio.php';
						break;
				}
				break;
			case 'irAEmpresa':
				$this->pantalla='pantallas/mentor/detalleEmpresa.php';
				break;
		}
	}

	/**
	 *
	 *  función que recibe valores del post cuando la accion es 'admin' y evalúa las acciones a llevar a cabo
	 *  Evalúa el parámetro subaccion y ejecuta las funciones correspondientes a la subaccion
	 *
	 * @param $post
	 *
	 */
	function evaluarPostAdmin($post)
	{
		switch ($post['subaccion']) {
			case 'irA':
				switch ($post['item']) {
					case 'inicio':
						$this->pantalla='pantallas/admin/inicio.php';
						break;
					case 'manejoMentor':
						$this->pantalla='pantallas/admin/manejoMentor.php';
						break;
				}
		}
	}

	/**
	 *
	 *  función que recibe valores del post cuando la accion es 'general' y evalúa las acciones a llevar a cabo
	 *  Evalúa el parámetro subaccion y ejecuta las funciones correspondientes a la subaccion
	 *
	 * @param $post
	 *
	 */
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

	/**
	 *
	 *  Función que construye los arreglos de practicas y practicas terminadas usados en la zona de empresa
	 *  Llama a la función que construye el arreglo de practicas en proceso 'hacerArregloPracticasEnProceso'
	 *
	 */
	function hacerArreglosDeSeccionEmpresa()
	{
		// hacer arreglo de todas las practicas anotando los estatus y fechas de las ingresadas por la empresa
		$this->arrListaPracticas= $this->modelo->hacerArregloBuenasPracticas($this->empresa->id);

		// hacer arreglo de las practicas terminadas por la empresa
		$arrPracticasTerminadas=$this->modelo->hacerArregloPracticas($this->empresa->id,3);
		$this->empresa->arrPracticasTerminadas=$arrPracticasTerminadas;

		// hacer arreglo de las practicas en proceso de la empresa
		$this->hacerArregloPracticasEnProceso();
	}

	/**
	 *
	 * Función que construye el arreglo de practicas en proceso usados en la zona de empresa
	 *  Se llama al log in de una empresa o cuando se agregan practicas o evidencias
	 *
	 */
	function hacerArregloPracticasEnProceso()
	{
		// hacer arreglo de las practicas en proceso de la empresa
		$arrPracticasEnProceso=$this->modelo->hacerArregloPracticas($this->empresa->id,2);
		$this->empresa->arrPracticasEnProceso=$arrPracticasEnProceso;

		// hacer arreglo de criterios por práctica en proceso y de eventos de cumplimiento por cada criterio
		for($x=0;$x<count($this->empresa->arrPracticasEnProceso);$x++){
			$this->empresa->arrPracticasEnProceso[$x]['criterios']=$this->modelo->hacerArregloCriteriosYEvidencias($this->empresa->id,
				$this->empresa->arrPracticasEnProceso[$x]['buenasPracticasId'],$this->empresa->arrPracticasEnProceso[$x]['id']);
		}

	}

	/**
	 *
	 * Actualiza el arreglo de arrPreguntasAutoevaluacion de acuerdo a laos valores recibidos del post
	 *
	 * @param $post
	 */
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

	/**
	 *
	 * Actualiza el arreglo de arrDatosEmpresaTmp de acuerdo a laos valores recibidos del post.
	 * Se usa en sección de perfil
	 *
	 * @param $post
	 */
	function actualizarDatosTmp($post)
	{
		if(isset($post['nombreEmpresa']))  $this->arrDatosEmpresaTmp['nombreEmpresa'] = $post['nombreEmpresa'];
		if(isset($post['calle']))  $this->arrDatosEmpresaTmp['calle'] = $post['calle'];
		if(isset($post['noExt']))  $this->arrDatosEmpresaTmp['noExt'] = $post['noExt'];
		if(isset($post['noInt']))  $this->arrDatosEmpresaTmp['noInt'] = $post['noInt'];
		if(isset($post['colonia']))  $this->arrDatosEmpresaTmp['colonia'] = $post['colonia'];
		if(isset($post['cp']))  $this->arrDatosEmpresaTmp['cp'] = $post['cp'];
		if(isset($post['ciudad']))  $this->arrDatosEmpresaTmp['ciudad'] = $post['ciudad'];
		if(isset($post['estado']))  $this->arrDatosEmpresaTmp['estado'] = $post['estado'];
		if(isset($post['municipio']))  $this->arrDatosEmpresaTmp['municipio'] = $post['municipio'];
		if(isset($post['ubicacion']))  $this->arrDatosEmpresaTmp['ubicacion'] = $post['ubicacion'];
		if(isset($post['contactoNombre']))  $this->arrDatosEmpresaTmp['contactoNombre'] = $post['contactoNombre'];
		if(isset($post['telefono']))  $this->arrDatosEmpresaTmp['telefono'] = $post['telefono'];
		if(isset($post['correos']))  $this->arrDatosEmpresaTmp['correos'] = $post['correos'];
		if(isset($post['sitioWeb']))  $this->arrDatosEmpresaTmp['sitioWeb'] = $post['sitioWeb'];
		if(isset($post['usuario']))  $this->arrDatosEmpresaTmp['usuario'] = $post['usuario'];
		if(isset($post['clave']))  $this->arrDatosEmpresaTmp['clave'] = $post['clave'];
	}

	/**
	 *
	 * Evalúa datos recibidos del post.
	 * Genera folders de empresa, practica y criterio para guardar evidencia
	 * Graba evidencia en folder
	 * Llama a función del modelo 'agregarEvidencia' que actualiza tabla bp_empresa_buenaPractica_eventos
	 * Llama afunción 'hacerArregloPracticasEnProceso' que actualiza arreglos de la sección de empresa
	 *
	 * @param $post
	 */
	function grabarEvidencia($post)
	{
		// Verificar si se indico adecuadamente el criterio
		// Verificar si existe el directorio de empresa/practica/criterio
		$folderEmpresa=str_replace(' ','_',$this->empresa->datos['nombreEmpresa']);
		$folderPractica='';
		$folderCriterio='';
		$empresa_buenaPracticaId='';
		$criterioId='';

		for($x=0;$x<count($this->empresa->arrPracticasEnProceso);$x++){
			for($y=0;$y<count($this->empresa->arrPracticasEnProceso[$x]['criterios']);$y++){
				if($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['criterioId']==$post['menuPracticaCriterio']){
					$folderPractica="Practica_".$this->empresa->arrPracticasEnProceso[$x]['buenasPracticasId'];
					$folderCriterio="Criterio_".$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['criterioId'];
					$empresa_buenaPracticaId=$this->empresa->arrPracticasEnProceso[$x]['id'];
					$criterioId=$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['criterioId'];
				}
			}
		}
		if(strlen($folderEmpresa)>0 && strlen($folderPractica)>0 && strlen($folderCriterio)>0) {
			$directorioDestino = ROOT_FOLDER_EVIDENCIAS."$folderEmpresa/$folderPractica/$folderCriterio/";
			$archivoDestino = $directorioDestino.basename($_FILES["nombresArchivos"]["name"]);
			$partes_ruta = pathinfo($archivoDestino);
			switch($partes_ruta['extension']){
				case 'txt':
				case 'doc':
				case 'docx':
				case 'pdf':
					$tipoEvidencia=1;
					break;
				case 'jpg':
				case 'png':
				case 'tif':
				case 'tiff':
					$tipoEvidencia=2;
					break;
				case 'mov':
				case 'mp4':
					$tipoEvidencia=3;
					break;
				default:
					$tipoEvidencia=0;
					break;
			}

			$tamano=filesize($_FILES["nombresArchivos"]["tmp_name"]);
			if($tipoEvidencia>0 && $tamano<TAMANO_MAX_EVIDENCIA) {
				// si no existe crearlo
				$directorioCreado = 0;
				if (!file_exists($directorioDestino)) {
					if (mkdir($directorioDestino, 0777, true)) {
						$directorioCreado = 1;
					}
				} else {
					$directorioCreado = 1;
				}
				if ($directorioCreado == 1) {
					$existe = 1;
					$indice = 1;
					while ($existe == 1) {
						if (!file_exists($archivoDestino)) {
							move_uploaded_file($_FILES["nombresArchivos"]["tmp_name"], $archivoDestino);
							$this->modelo->agregarEvidencia('2',$empresa_buenaPracticaId,$criterioId,$archivoDestino,$tipoEvidencia,'2',$post['comentarios'],'3');
							$this->hacerArregloPracticasEnProceso();
							$existe = 0;
						} else {
							$nuevoNombre = $partes_ruta['filename']."_".$indice.".".$partes_ruta['extension'];
							$archivoDestino = $directorioDestino.$nuevoNombre;
							$indice++;
						}
					}
				}else{
					echo "error al crear el directorio<br>";
				}
			}else{
				echo "error de tipo de archivo o tamaño<br>";
			}
		}else{
			echo "error al indicar el criterio exacto<br>";
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
	    include ('pantallas/general/pie.php');
	    if(DEBUG==1){
		    include ('pantallas/general/debug.php');
	    }
    }

}

