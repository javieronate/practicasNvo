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
include_once ("Mentor.php");
include_once ("Admon.php");
include_once ("FxFormularios.php");
//include_once ("Pantallas.php");

/**
 *
 * Controlador de Buenas Prácticas
 *
 * Clase controller del modelo MVC (Model - Vew - Controller)
 *
 * @package BuenasPracticas
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

	//var $pantallas;

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
	 * Variable que guarda un objeto Mentor cuando el log in es de rol mentor
	 */
	var $mentor;

	/**
	 * Variable que guarda un objeto Administrador cuando el log in es de rol administrador
	 */
	var $admon;

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

	// tal vez no es necesaria
	/**
	 * Variable que guarda el id de la persona seleccionada. Se usa en la sección de admon.
	 */
	//var $personaSeleccionadaId;

	/**
	 * Variable que guarda un arreglo temporal de los datos de la person durante el llenado de datos en seccion admon.
	 */
	var $arrDatosPersonaTmp=array();

	/**
	 * Variable que guarda un arreglo con la situación de las practicas, criterios y evidencias de la empresa seleccionada.
	 */
	var $arrEmpresaSeleccionada;

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
	    //$this->pantallas=new Pantallas();
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
					$this->empresa=null;
					$this->mentor=null;
					$this->admon=null;
					$this->mensaje="No se encontró el usuario. Vuelva a intentar";
					$this->pantalla='pantallas/general/login.php';
				} else if ($usuario['rol']=='empresa'){
					$this->mentor=null;
					$this->admon=null;
					$this->empresa=new Empresa($usuario);
					$this->hacerArreglosDeSeccionEmpresa();
					$this->pantalla='pantallas/empresa/inicio.php';
				}else if($usuario['rol']=='administrador'){
					$this->empresa=null;
					$this->mentor=null;
					$this->admon= new Admon($usuario);
					$this->hacerArreglosDeSeccionAdmon($post);
					$this->pantalla='pantallas/admin/inicio.php';
				}else if($usuario['rol']=='mentor'){
					$this->admon=null;
					$this->empresa=null;
					$this->mentor=new Mentor($usuario);
					$this->hacerArreglosDeSeccionMentor();
					$this->pantalla='pantallas/mentor/inicio.php';
				}
				break;
	        case 'logout':
		        $this->empresa=null;
		        $this->mentor=null;
		        $this->admon=null;
				$this->limpiarArreglos();
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
							$this->actualizarDatosPerfilTmp($post);
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
				$this->actualizarDatosPerfilTmp($post);
				$correcto=$this->modelo->validarPerfil($this->arrDatosEmpresaTmp);
				if($correcto==1) {
					$this->empresa->datos['infoCapturada']=1;
					$this->pantalla='pantallas/empresa/inicio.php';
				}else{
					$this->pantalla='pantallas/empresa/perfil.php';
				}
				break;
			case 'cambiarEstado':
				$this->actualizarDatosPerfilTmp($post);
				$this->arrDatosEmpresaTmp['municipio']='Municipio';
				break;
			case 'agregarEvidencia':
				$this->grabarEvidencia($post);
				break;
			case 'agregarPractica':
				$hoy=date('Y-m-d');
				if($post['menuPracticaPendiente']!="noSeleccionable" && $post['menuPracticaPendiente']!="Elija practica") {
					$this->modelo->agregarPracticaAEmpresa($this->empresa->id, $post['menuPracticaPendiente'], '2');
					$this->hacerArreglosDeSeccionEmpresa();
				}
				break;
			case 'seleccionarCriterio':
				$this->empresa->criterioIdSeleccionado=$post['item'];
				break;
			case 'quitarCriterio':
				$this->empresa->criterioIdSeleccionado='';
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
				echo $post['item']."<br>";
				$this->arrEmpresaSeleccionada=$this->buscarEmpresaSeleccionada($post['item']);
				$this->pantalla='pantallas/mentor/detalleEmpresa.php';
				break;
			case 'agregarEmpresa':
				$this->pantalla='pantallas/mentor/nuevaEmpresa.php';
				break;
			case 'grabarNuevaEmpresa':
				$this->modelo->agregarEmpresa($post,$this->mentor->id);
				// actualizar arreglo de empresas
				$this->mentor->arrEmpresasSupervisadas=$this->modelo->hacerArregloEmpresasDeMentor($this->mentor->id);
				break;
			case 'aprobarEvidencia':
				$this->modelo->aprobarCriterio($post,$this->arrEmpresaSeleccionada);
				$empresaSeleccionadaId=$this->arrEmpresaSeleccionada['id'];
				// verificar si se completo la practica
				$this->modelo->validarCompletudDeCriteriosDePractica($post['item'],$this->arrEmpresaSeleccionada);
				// actualizar arreglo de empresas
				$this->mentor->arrEmpresasSupervisadas=$this->modelo->hacerArregloEmpresasDeMentor($this->mentor->id);
				// actualizar arreglo de empresa seleccionada
				$this->arrEmpresaSeleccionada=$this->buscarEmpresaSeleccionada($empresaSeleccionadaId);
				break;
			case 'rechazarEvidencia':
				$this->modelo->rechazarCriterio($post,$this->arrEmpresaSeleccionada);
				$empresaSeleccionadaId=$this->arrEmpresaSeleccionada['id'];

				// actualizar arreglo de empresas
				$this->mentor->arrEmpresasSupervisadas=$this->modelo->hacerArregloEmpresasDeMentor($this->mentor->id);

				// actualizar arreglo de empresa seleccionada
				$this->arrEmpresaSeleccionada=$this->buscarEmpresaSeleccionada($empresaSeleccionadaId);
				break;
			case 'abrirEvidencia':
				$empresaSeleccionadaId=$this->arrEmpresaSeleccionada['id'];
				$this->modelo->anotarAperturaEvidencia($this->arrEmpresaSeleccionada,$post['subItem']);
				// actualizar arreglo de empresas
				$this->mentor->arrEmpresasSupervisadas=$this->modelo->hacerArregloEmpresasDeMentor($this->mentor->id);

				// actualizar arreglo de empresa seleccionada
				$this->arrEmpresaSeleccionada=$this->buscarEmpresaSeleccionada($empresaSeleccionadaId);
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
				break;
			case 'seleccionarPersona':
				$this->arrDatosPersonaTmp = $this->buscarDatosPersona($post['item']);
				break;
			case 'agregarPersona':
				$this->arrDatosPersonaTmp = $this->llenarArrDatosPersonaTmpVacio();
				break;
			case 'grabarNuevo':
			case 'editarPersona':
				$this->actualizarDatosPersonaTmp($post);
				$correcto=$this->modelo->validarDatosPersona($this->arrDatosPersonaTmp);
				if($correcto==1) $this->admon->arrPersonal=$this->modelo->hacerArregloPersonal();
				break;
			case 'llenarDatos':
				$this->modelo->llenarDatosFicticios();
				break;
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
	 * Función que limpia los arreglos en logout
	 *
	 */
	function limpiarArreglos()
	{
		$this->arrDatosEmpresaTmp=array();
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
		$arrPracticasTerminadas=$this->modelo->hacerArregloPracticas($this->empresa->id,4);
		$this->empresa->arrPracticasTerminadas=$arrPracticasTerminadas;

		// hacer arreglo de las practicas en proceso de la empresa
		$this->hacerArregloPracticasEnProceso();

	}

	/**
	 *
	 *  Función que construye los arreglos necesarios para paginas de mentor
	 *
	 */
	function hacerArreglosDeSeccionMentor()
	{
		// hacer arreglo de las empresas supervisadas por el mentor
		$this->mentor->arrEmpresasSupervisadas=$this->modelo->hacerArregloEmpresasDeMentor($this->mentor->id);
	}

	/**
	 *
	 *  Función que construye los arreglos necesarios para paginas de admon
	 *
	 * @param $post
	 */
	function hacerArreglosDeSeccionAdmon($post)
	{
		$this->admon->arrPersonal=$this->modelo->hacerArregloPersonal();
		$this->admon->geoJSON=$this->modelo->hacerGeoJSONparaMapa();
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
			$this->empresa->arrPracticasEnProceso[$x]['criterios']=$this->modelo->hacerArregloCriteriosYEvidencias(
				$this->empresa->id,
				$this->empresa->arrPracticasEnProceso[$x]['buenasPracticasId'],
				$this->empresa->arrPracticasEnProceso[$x]['id']);
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
	function actualizarDatosPerfilTmp($post)
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
		if(isset($post['latitud']))  $this->arrDatosEmpresaTmp['latitud'] = $post['latitud'];
		if(isset($post['longitud']))  $this->arrDatosEmpresaTmp['longitud'] = $post['longitud'];
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
	 * Llama a función del modelo 'agregarEvidencia' que actualiza tabla bp_empresa_buenaPractica_criterios
	 * Llama afunción 'hacerArregloPracticasEnProceso' que actualiza arreglos de la sección de empresa
	 *
	 * @param $post
	 */
	function grabarEvidencia($post)
	{
		// Verificar si se indico adecuadamente el criterio
		// Verificar si existe el directorio de empresa/practica/criterio

		$cachos=explode(":",$this->empresa->criterioIdSeleccionado);
		$folderEmpresa=$this->fx->convertirAASCII($this->empresa->datos['nombreEmpresa']);
		$folderPractica="Practica_".$this->empresa->arrPracticasEnProceso[$cachos['0']]['buenasPracticasId'];
		$folderCriterio="Criterio_".$this->empresa->arrPracticasEnProceso[$cachos['0']]['criterios'][$cachos['1']]['criterioId'];
		$empresa_buenaPracticaId=$this->empresa->arrPracticasEnProceso[$cachos['0']]['id'];
		$criterioId=$this->empresa->arrPracticasEnProceso[$cachos['0']]['criterios'][$cachos['1']]['criterioId'];
		$empresaPracticaCriterioId=$this->empresa->arrPracticasEnProceso[$cachos['0']]['criterios'][$cachos['1']]['id'];
		$buenaPracticaId=$this->empresa->arrPracticasEnProceso[$cachos['0']]['buenasPracticasId'];

		// TODO: completar la lista de archivos permitidos considerar zip
		if(strlen($folderEmpresa)>0 && strlen($folderPractica)>0 && strlen($folderCriterio)>0) {

			$directorioDestino = ROOT_FOLDER_EVIDENCIAS."$folderEmpresa/$folderPractica/$folderCriterio/";
			$nombreOriginal=pathinfo($_FILES["nombresArchivos"]["name"]);
			$nombreParaDespliegue=$nombreOriginal['basename'];
			$nombreExtension=$nombreOriginal['extension'];
			$nombreArchivo=$this->fx->hacerAlfanumericoAleatorio(12);
			$rutaCompletaArchivoDestino = $directorioDestino.$nombreArchivo.".".$nombreExtension;

			switch(strtolower($nombreExtension)){
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
				// Revisar si existe directorio. Si no existe crearlo
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
						if (!file_exists($rutaCompletaArchivoDestino)) {
							move_uploaded_file($_FILES["nombresArchivos"]["tmp_name"], $rutaCompletaArchivoDestino);
							$this->modelo->agregarEvidencia('2', $empresa_buenaPracticaId,$empresaPracticaCriterioId, $buenaPracticaId, $criterioId, $rutaCompletaArchivoDestino,
														$nombreParaDespliegue, $tipoEvidencia, '2',$post['comentarios'], '3');
							$this->hacerArregloPracticasEnProceso();
							$existe = 0;
						} else {
							$nuevoNombre = $nombreArchivo."_".$indice.".".$nombreExtension;
							$rutaCompletaArchivoDestino = $directorioDestino.$nuevoNombre;
							$indice++;
						}
					}
				}else{
					echo "error al crear el directorio<br>";
				}
			}else {
			echo "error de tipo de archivo o tamaño<br>";

			}
		}else{
			echo "error al indicar el criterio exacto<br>";
		}
	}

	/**
	 *
	 * Busca en el arreglo de todas las personas almacenado en la instancia admon y
	 * devuelve un arreglo con los datos de la persona encontrada
	 *
	 * @param $personaId
	 *
	 * @return array
	 */
	function buscarDatosPersona($personaId)
	{
		$arrTmp=array();
		for($x=0;$x<count($this->admon->arrPersonal);$x++){
			if($this->admon->arrPersonal[$x]['id']==$personaId) {
				$arrTmp=$this->admon->arrPersonal[$x];
			}
		}

		return($arrTmp);
	}

	/**
	 *
	 * Llena el arreglo temporal arrDatosPersonaTmp con datos vacios. Se usa en admon
	 *
	 * @return array
	 */
	function llenarArrDatosPersonaTmpVacio()
	{
		$arrTmp=array(
			'id' => 'nuevo',
			'nombre' => '',
			'usuario' => '',
			'clave' => '',
			'email' => '',
			'fechaCreado' => '',
			'fechaClaveUpdate' => '',
			'nota' => '',
			'esSuperAdmin' => 0,
			'correoNotificacionCadaXHoras' => 4,
			'correoUltimoEnviado' => '',
			'ultimoLogin' => '');
		return($arrTmp);
	}

	/**
	 *
	 * Actualiza el arreglo de arrDatosPersonaTmp de acuerdo a laos valores recibidos del post.
	 * Se usa en sección de admon
	 *
	 * @param $post
	 */
	function actualizarDatosPersonaTmp($post)
	{
		if(isset($post['nombrePersona']))  $this->arrDatosPersonaTmp['nombre'] = $post['nombrePersona'];
		if(isset($post['usuarioPersona']))  $this->arrDatosPersonaTmp['usuario'] = $post['usuarioPersona'];
		if(isset($post['clavePersona']))  $this->arrDatosPersonaTmp['clave'] = $post['clavePersona'];
		if(isset($post['correoPersona']))  $this->arrDatosPersonaTmp['email'] = $post['correoPersona'];
		if(isset($post['Nota']))  $this->arrDatosPersonaTmp['nota'] = $post['Nota'];
		if(isset($post['esSuperAdmin']))  $this->arrDatosPersonaTmp['esSuperAdmin'] = $post['esSuperAdmin'];
		if(isset($post['notificarPorCorreoCadaHorasPersona']))  $this->arrDatosPersonaTmp['correoNotificacionCadaXHoras'] = $post['notificarPorCorreoCadaHorasPersona'];
	}

	/**
	 *
	 * Recorre el arreglo mentor->arrEmpresasSupervisadas y
	 * copia la que tiene el id recibido al arreglo $this->arrEmpresaSeleccionada
	 * que se usa en la seccion de detalles de la situación de practicas de la empresa
	 * en la zona del mentor.
	 *
	 * @param $empresaId
	 *
	 * @return array
	 */
	function buscarEmpresaSeleccionada($empresaId)
	{
		$arrTmp=array();
		for($x=0;$x<count($this->mentor->arrEmpresasSupervisadas);$x++){
			if($this->mentor->arrEmpresasSupervisadas[$x]['id']==$empresaId) $arrTmp=$this->mentor->arrEmpresasSupervisadas[$x];
		}
		return($arrTmp);
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

