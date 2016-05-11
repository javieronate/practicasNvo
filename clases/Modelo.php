<?php

/**
 *
 * Modelo Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * Clase Modelo de sitio Buenas Prácticas
 *
 * @var mysqli
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */

/**
 *
 * Modelo del sitio Buenas Prácticas
 *
 * Clase Model del modelo MVC (Model - Vew - Controller)
 *
 * Aquí se concentra toda la funcionalidad del modelo de negocio
 * También desde aquí se hacen las peticiones a la base de datos
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */

class Modelo
{
	/** @var Database */

	/**
	 * Almacena objeto de tipo mysqli para conexión a base de datos
	 */
	var $db;

	/**
	 * Almacena arreglo de categorias.
	 * Se usa en página de innovación
	 */
	var $arrCategorias=array();


    /**
     *
     *  Constructor del Modelo
     *
     */
    function __construct()
    {
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
	 * Recibe el objeto de tipo mysqli y lo almacena en la variable $db
	 *
	 * @param $db
	 */
	function ponerConexion($db)
	{
		$this->db=$db;
	}

	/**
	 *
	 * llena los arreglos generales de inicio
	 *
	 */
	function hacerArreglosBase()
	{
		$this->arrCategorias=$this->hacerArregloCategorias();

	}

	/**
	 *
	 * Busca en base de datos y llena arreglo $this->arrCategorias
	 *
	 * @return array
	 */
	function hacerArregloCategorias()
	{
		$arrTmp=array();
		$sql="select id,nombre,imagenLiga from bp_categorias order by orden";
		$resultado = $this->db->query($sql);
		while ($renglon = $resultado->fetch_assoc()) {
			$arrTmp[]=array('id'=>$renglon['id'],'nombre'=>$renglon['nombre'],'imagenLiga'=>$renglon['imagenLiga']);
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Busca en base de datos la información de la categoría $categoriaId.
	 * Llena el array 'arrDatosPaginaCategoria' del controlador
	 * Se usa en página general -> categoria
	 *
	 * @param $categoriaId
	 *
	 * @return array
	 */
	function buscarDatosPaginaCategoria($categoriaId)
	{
		$arrTmp=array();
		$resultado = $this->db->query("SELECT * FROM bp_categorias where id=$categoriaId ORDER BY id");
		while ($renglon = $resultado->fetch_assoc()) {
			$arrTmp=array('id'=>$renglon['id'],'nombre'=>$renglon['nombre'], 'descripcion'=>$renglon['descripcion'],'imagen1'=>$renglon['imagen1'],'imagen2'=>$renglon['imagen2'],'imagen3'=>$renglon['imagen3']);
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Busca en base de datos la información de las practicas de la categoría $categoriaId.
	 * Llena el array 'arrPracticasDeCategoria' del controlador
	 * Se usa en página general -> categoria
	 *
	 * @param $categoriaId
	 *
	 * @return array
	 */
	function buscarPracticasDeCategoria($categoriaId)
	{
		$arrTmp=array();
		$resultado = $this->db->query("SELECT id,tituloCorto FROM bp_buenasPracticas where categoriaId=$categoriaId ORDER BY orden");
		while ($renglon = $resultado->fetch_assoc()) {
			$arrTmp[]=array('id'=>$renglon['id'],'nombre'=>$renglon['tituloCorto']);
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Busca en base de datos la información de la práctica $practicaId
	 * Llena el array 'arrDatosPaginaPractica' del controlador
	 * Se usa en página general -> categoria -> practica
	 *
	 * @param $practicaId
	 *
	 * @return array
	 */
	function buscarDatosPaginaPractica($practicaId)
	{
		$arrTmp=array();
		$resultado = $this->db->query("SELECT * FROM bp_buenasPracticas where id=$practicaId ORDER BY orden");
		while ($renglon = $resultado->fetch_assoc()) {
			$arrTmp=array(
				'id'=>$renglon['id'],
				'categoriaId'=>$renglon['categoriaId'],
				'titulo'=>$renglon['titulo'],
				'tituloCorto'=>$renglon['tituloCorto'],
				'descripcion'=>$renglon['descripcion'],
				'experiencia'=>$renglon['experiencia'],
				'sustentabilidad'=>$renglon['sustentabilidad'],
				'competitividad'=>$renglon['competitividad'],
				'variaciones'=>$renglon['variaciones'],
				'recursos'=>$renglon['recursos'],
				'aprenderMas'=>$renglon['aprenderMas'],
				'criterios'=>$renglon['criterios'],
				'imagen1'=>$renglon['imagen1'],
				'imagen2'=>$renglon['imagen2'],
				'imagen3'=>$renglon['imagen3'],
				'puntosMaximos'=>$renglon['puntosMaximos'],
				'periodoDeVigencia'=>$renglon['periodoDeVigencia'],
				'variacionesDePractica'=>$renglon['variacionesDePractica'],
				'ejemplosCumplimiento'=>$renglon['ejemplosCumplimiento'],
				'valorDeCertificacion'=>$renglon['valorDeCertificacion'],
				'ANPAplicacion'=>$renglon['ANPAplicacion'],
			);
		}
		$arrTmp['criterios']=$this->buscarCriteriosDePractica($practicaId);
		return ($arrTmp);
	}

	/**
	 *
	 * Busca en base de datos la información de los criterios de la practica $idPractica
	 *
	 * @param $idPractica
	 *
	 * @return array
	 */
	function buscarCriteriosDePractica($idPractica)
	{
		$arrTmp=array();
		$sql="select id,nombre,puntos from bp_criterios where buenaPracticaId=$idPractica order by orden";
		$resultado=$this->db->query($sql);
		while($renglon = $resultado->fetch_assoc()) {
			$arrTmp[]=array('id'=>$renglon['id'],'nombre'=>$renglon['nombre'],'puntos'=>$renglon['puntos']);
		}
		return($arrTmp);
	}

	/**
	 *
	 * Busca en base de datos si el usuario esta autorizado para ingresar al sistema.
	 *
	 * Define si el usuario es de una emprese, administrador o mentor.
	 *
	 * De acuerdo al rol llena un arreglo temporal que se devuelve al controlador quien puebla datos
	 * de empresa, o presonal
	 *
	 * Actualiza datos de log y de ultimo acceso
	 *
	 * @param $usuario
	 * @param $clave
	 *
	 * @return array
	 */
	function validarLogin($usuario, $clave){

		// TODO: Agregar sistema de cifrado de Michael
		$arrTmp=array();

		// buscar si es usuario de empresa
		$sql = "select count(*)as cuantos from bp_empresas where usuario ='".$usuario."' and clave='".$clave."'";
		$resultado = $this->db->query($sql);
		$datos = $resultado->fetch_assoc();
		if($datos['cuantos']==1) {
			$sql2 = "select * from bp_empresas where usuario ='" . $usuario . "' and clave='" . $clave . "'";
			$resultado2 = $this->db->query($sql2);
			$datos2 = $resultado2->fetch_assoc();
			$arrTmp['rol'] = 'empresa';
			$arrTmp['id'] = $datos2['id'];
			$arrTmp['nombreEmpresa'] = $datos2['nombreEmpresa'];
			$arrTmp['ubicacion'] = $datos2['ubicacion'];
			$arrTmp['contactoNombre'] = $datos2['contactoNombre'];
			$arrTmp['fechaAutoevaluacion'] = $datos2['fechaAutoevaluacion'];
			$arrTmp['correos'] = $datos2['correos'];
			$arrTmp['mentorId'] = $datos2['mentorId'];
			$arrTmp['infoCapturada'] = $datos2['infoCapturada'];
			$arrTmp['autoevaluacionHecha'] = $datos2['autoevaluacionHecha'];
			$arrTmp['calle'] = $datos2['calle'];
			$arrTmp['noExt'] = $datos2['noExt'];
			$arrTmp['noInt'] = $datos2['noInt'];
			$arrTmp['colonia'] = $datos2['colonia'];
			$arrTmp['cp'] = $datos2['cp'];
			$arrTmp['ciudad'] = $datos2['ciudad'];
			$arrTmp['municipio'] = $datos2['municipio'];
			$arrTmp['estado'] = $datos2['estado'];
			$arrTmp['telefono'] = $datos2['telefono'];
			$arrTmp['sitioWeb'] = $datos2['sitioWeb'];
			$arrTmp['fechaCreacion'] = $datos2['fechaCreacion'];
			$arrTmp['fechaActualizacion'] = $datos2['fechaActualizacion'];
			$arrTmp['propietarioId'] = $datos2['propietarioId'];
			$arrTmp['publica'] = $datos2['publica'];
			$arrTmp['contactoTelefono'] = $datos2['contactoTelefono'];
			$arrTmp['correoNotificacionCadaXHoras'] = $datos2['correoNotificacionCadaXHoras'];
			$arrTmp['ultimoCorreoEnviado'] = $datos2['ultimoCorreoEnviado'];
			$arrTmp['ultimoLogin'] = $datos2['ultimoLogin'];
			$arrTmp['usuario'] = $datos2['usuario'];
			$arrTmp['clave'] = $datos2['clave'];
			$this->agregarRegistroLog($arrTmp['id'],NULL,MENSAJE_LOGIN_EMPRESA,3);
			$this->anotarUltimoLoginEmpresa($arrTmp['id']);
		}else{
			// buscar si es usuario de personal
			$sql = "select count(*) as cuantos from bp_personal where usuario ='".$usuario."' and clave='".$clave."'";
			$resultado = $this->db->query($sql);
			$datos = $resultado->fetch_assoc();
			if($datos['cuantos']==1) {
				$sql2 = "select * from bp_personal where usuario ='" . $usuario . "' and clave='" . $clave . "'";
				$resultado2 = $this->db->query($sql2);
				$datos2 = $resultado2->fetch_assoc();
				$arrTmp['rol'] =  $datos2['esSuperAdmin']==1 ? 'administrador' :'mentor';
				$arrTmp['id'] = $datos2['id'];
				$arrTmp['nombre'] = $datos2['nombre'];
				$arrTmp['email'] = $datos2['email'];
				$arrTmp['esSuperAdmin'] = $datos2['esSuperAdmin'];
				$arrTmp['ultimoLogin'] = $datos2['ultimoLogin'];
				$this->agregarRegistroLog(NULL,$arrTmp['id'],MENSAJE_LOGIN_PERSONAL,3);
				$this->anotarUltimoLoginPersona($arrTmp['id']);
			}else{
				$arrTmp['rol'] = "fallo";
			}
		}
		return($arrTmp);
	}

	/**
	 *
	 * Agrega un registro a la tabla bp_logActividades
	 *
	 * @param $idEmpresa
	 * @param $idPersonal
	 * @param $mensaje
	 * @param $prioridad
	 */
	function agregarRegistroLog($idEmpresa, $idPersonal, $mensaje, $prioridad)
	{
		$sql=($idPersonal==NULL)? "insert into bp_logActividades(idEmpresa,mensaje,prioridad) values ($idEmpresa,'".$mensaje."',$prioridad)" : "insert into bp_logActividades(idPersonal,mensaje,prioridad) values ($idPersonal,'".$mensaje."',$prioridad)";
		$this->db->query($sql);
	}

	/**
	 *
	 * Actualiza el campo ultimoLogin de la tabla bp_empresas
	 *
	 * @param $idEmpresa
	 */
	function anotarUltimoLoginEmpresa($idEmpresa)
	{
		$hoy=date('Ymd');
		$sql="update bp_empresas set ultimoLogin='".$hoy."' where id=$idEmpresa";
		$this->db->query($sql);
	}

	/**
	 *
	 * Actualiza el campo ultimoLogin de la tabla bp_personal
	 *
	 * @param $idPersona
	 */
	function anotarUltimoLoginPersona($idPersona)
	{
		//$hoy=date('Y-m-d');
		$sql="update bp_personal set ultimoLogin='".HOY."' where id=$idPersona";
		$this->db->query($sql);
	}

	/**
	 *
	 * llena el arreglo de buenas practicas
	 * para poblar la sección derecha de la pagina de empresa
	 *
	 * @param $empresaId
	 *
	 * @return array
	 */
	function hacerArregloBuenasPracticas($empresaId)
	{
		// buscar todas las practicas organizadas según las categorias y hacer un arreglo
		$sql = "select bp_categorias.nombre as categoria,
				bp_buenasPracticas.categoriaId,bp_buenasPracticas.id,  bp_buenasPracticas.tituloCorto as titulo
				from bp_categorias
				left join bp_buenasPracticas on bp_categorias.id = bp_buenasPracticas.categoriaId
				where publico=1 order by bp_categorias.orden,bp_buenasPracticas.orden";

		$arrTmp=array();
		$arrTmpSub=array();
        $resultado = $this->db->query($sql);
		$categoriaSel=0;
		$nombreCategoriaSel="";
        while ($fila = $resultado->fetch_assoc()) {
	        if($fila['categoriaId']!=$categoriaSel){

 		        // grabar arreglo hecho hasta ahora
		        if($categoriaSel!=0) {
			        $arrTmp[] = array(
				        'idCategoria' => $categoriaSel,
				        'nombreCategoria' => $nombreCategoriaSel,
				        'practicas' => $arrTmpSub
			        );
		        }
		        $categoriaSel=$fila['categoriaId'];
		        $nombreCategoriaSel=$fila['categoria'];
		        $arrTmpSub=array();
		        $arrTmpSub[]=array(
			        'idPractica' => $fila['id'],
			        'nombrePractica' => $fila['titulo'],
					'idEmpresaBuenaPractica'=>'',
			        'idEstatus'=>'',
			        'statusNombre'=>'',
			        'fechaIncio'=>'',
			        'fechaAprobacion'=>'',
		        );


	        }else{
		        $arrTmpSub[]=array(
			        'idPractica' => $fila['id'],
			        'nombrePractica' => $fila['titulo'],
			        'idEmpresaBuenaPractica'=>'',
			        'idEstatus'=>'',
			        'statusNombre'=>'',
			        'fechaIncio'=>'',
			        'fechaAprobacion'=>'',
		        );
	        }
        }
		$arrTmp[] = array(
			'idCategoria' => $categoriaSel,
			'nombreCategoria' => $nombreCategoriaSel,
			'practicas' => $arrTmpSub
		);

		// buscar practicas asociadas a la empresa y actualizar el arreglo anterior

		$sql1="select bp_empresa_buenaPractica.id,bp_empresa_buenaPractica.buenasPracticasId,bp_empresa_buenaPractica.estatus,
				bp_empresa_buenaPractica.fechaIncio,bp_empresa_buenaPractica.fechaAprobacion,bp_catStatus.nombre as statusNombre,
				bp_buenasPracticas.categoriaId
				from bp_empresa_buenaPractica
				left join bp_catStatus on bp_catStatus.id=bp_empresa_buenaPractica.estatus
				left join bp_buenasPracticas on bp_buenasPracticas.id= bp_empresa_buenaPractica.buenasPracticasId
				where empresaId=$empresaId order by bp_buenasPracticas.categoriaId,bp_empresa_buenaPractica.buenasPracticasId";
		$resultado1=$this->db->query($sql1);
		while ($fila1 = $resultado1->fetch_assoc()) {
			for($x=0;$x<count($arrTmp);$x++){
				if($arrTmp[$x]['idCategoria']==$fila1['categoriaId']){
					for ($y=0;$y<count($arrTmp[$x]['practicas']);$y++){
						if($arrTmp[$x]['practicas'][$y]['idPractica']==$fila1['buenasPracticasId']){
							$arrTmp[$x]['practicas'][$y]['idEmpresaBuenaPractica']=$fila1['id'];
							$arrTmp[$x]['practicas'][$y]['idEstatus']=$fila1['estatus'];
							$arrTmp[$x]['practicas'][$y]['statusNombre']=$fila1['statusNombre'];
							$arrTmp[$x]['practicas'][$y]['fechaIncio']=$fila1['fechaIncio'];
							$arrTmp[$x]['practicas'][$y]['fechaAprobacion']=$fila1['fechaAprobacion'];
						}
					}
				}
			}
		}
        return ($arrTmp);
	}

	/**
	 *
	 * Construye un arreglo con las preguntas de la autoevaluación.
	 * Se usa en la pagina de autoevaluacion de la empresa
	 *
	 * @return array
	 */
	function hacerArregloAutoevaluacion()
	{
		$arrTmp=array();
		$sql="select id, pregunta,puntos,idBuenaPractica from bp_preguntasAutoevaluacion where activo=1 order by orden";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {

			$arrTmp[]=array('idPregunta'=>$fila['id'], 'pregunta'=>$fila['pregunta'], 'puntos'=>$fila['puntos'], 'idBuenaPractica'=>$fila['idBuenaPractica'],
				'valor'=>'0','correcta'=>1);
		}
		return($arrTmp);
	}

	/**
	 *
	 * Función que valida las respuestas de la autoevaluación.
	 * Si son correctas graba en la tabla bp_empresaResultadoAutoevaluacion los resultados
	 * Actualiza los campos autoevaluacionHecha y fechaAutoevaluacion la tabla bp_empresas
	 * Llama a la función agregarPracticaAEmpresa para incluir las practicas marcadas
	 * como si en el cuestionario como practicas en proceso
	 *
	 * @param $arrPreguntas
	 * @param $empresaId
	 *
	 * @return int
	 */
	function validarAutoevaluacion($arrPreguntas, $empresaId)
	{
		$correcto=1;
		for($x=0;$x<count($arrPreguntas);$x++){
			if($arrPreguntas[$x]['correcta']==0) $correcto=0;
		}
		if($correcto==1){
			$hoy=date('Ymd');
			// grabar en bp_empresaResultadoAutoevaluacion
			$valoresTxt='';
			for($x=0;$x<count($arrPreguntas);$x++){
				if(strlen($valoresTxt)>0) $valoresTxt.=",";
				$valoresTxt.="('".$empresaId."','".$arrPreguntas[$x]['idPregunta']."','".$arrPreguntas[$x]['valor']."')";
			}
			$sql="insert into bp_empresaResultadoAutoevaluacion (idEmpresa,idPregunta,respuesta) values $valoresTxt";
			$this->db->query($sql);

			// update empresas para poner que ya hizo la evaluación
			$sql1="update bp_empresas set autoevaluacionHecha=1, fechaAutoevaluacion='".$hoy."' where id=$empresaId";
			$this->db->query($sql1);

			// agregar buenas practicas que se marcaron como si
			$mensaje="Agregada automaticamente como resultado de la autoevaluación";
			for($x=0;$x<count($arrPreguntas);$x++){
				if($arrPreguntas[$x]['valor']=='1')
					$this->agregarPracticaAEmpresa($empresaId, $arrPreguntas[$x]['idBuenaPractica'], '2', $hoy,'1',$mensaje,'3');
			}
		}
		return($correcto);
	}

	/**
	 *
	 * Agrega una practica a una empresa
	 * Inserta registros en tablas 'bp_empresa_buenaPractica' y en 'bp_empresa_buenaPractica_eventos'
	 *
	 * @param $empresaId
	 * @param $practicaId
	 * @param $statusId
	 * @param $fechaInicio
	 * @param $tipoEventoId
	 * @param $mensaje
	 * @param $prioridadId
	 */
	function agregarPracticaAEmpresa($empresaId, $practicaId, $statusId, $fechaInicio, $tipoEventoId, $mensaje, $prioridadId)
	{
		// TODO: Agregar la fecha de aprobacion ya sea en blanco o con dato para que en una solo función quede todo
		$textoValores="($empresaId,$practicaId,$statusId,'".$fechaInicio."')";
		$sql="insert into bp_empresa_buenaPractica (empresaId,buenasPracticasId,estatus,fechaIncio) values $textoValores";
		$this->db->query($sql);
		$idNuevo=$this->db->insert_id;

		$textoValores1="($tipoEventoId,$idNuevo,'".$fechaInicio."',$statusId,'".$mensaje."',$prioridadId)";
		$sql1="insert into bp_empresa_buenaPractica_eventos (idTipoDeEvento,empresa_buenaPracticaId,fecha,estatusBuenaPractica,mensaje,prioridad) values $textoValores1";
		$this->db->query($sql1);
	}

	/**
	 *
	 * Construye arreglo de estados.
	 * Se usa en página de perfil de empresa
	 *
	 * @return array
	 */
	function hacerArregloEstados()
	{
		$arrTmp=array();
		$sql= "select idEdo,nombre from bp_catEstados order by idEdo";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {
			$arrTmp[]=array('id'=>$fila['idEdo'],'nombre'=>$fila['nombre']);
		}
		return($arrTmp);
	}

	/**
	 *
	 * Construye arreglo de municipios.
	 * Se usa en página de perfil de empresa
	 *
	 * @return array
	 */
	function hacerArregloMunicipios()
	{
		$arrTmp=array();
		$sql= "select idEdo,idMpo,nombre from bp_catMunicipios order by idEdo";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {
			$arrTmp[]=array('categoria'=>$fila['idEdo'],'id'=>$fila['idMpo'],'nombre'=>$fila['nombre']);
		}
		return($arrTmp);
	}

	/**
	 *
	 * Función que valida si los datos del perfil son correctos.
	 * Si lo son actualiza los datos en la tabla bp_empresas y actualiza los datos en objeto Empresa
	 *
	 * @param $arrDatosEmpresa
	 *
	 * @return int
	 */
	function validarPerfil($arrDatosEmpresa)
{
	$correcto=1;
	if(strlen($arrDatosEmpresa['nombreEmpresa'])==0) $correcto=0;
	if(strlen($arrDatosEmpresa['estado'])==0) $correcto=0;
	if(strlen($arrDatosEmpresa['municipio'])==0) $correcto=0;
	if(strlen($arrDatosEmpresa['contactoNombre'])==0) $correcto=0;
	if(strlen($arrDatosEmpresa['telefono'])==0) $correcto=0;
	if(strlen($arrDatosEmpresa['correos'])==0) $correcto=0;
	if(strlen($arrDatosEmpresa['usuario'])==0) $correcto=0;
	if(strlen($arrDatosEmpresa['clave'])==0) $correcto=0;

	if($correcto==1) {
		$sql="update bp_empresas set
		nombreEmpresa='".$arrDatosEmpresa['nombreEmpresa']."',
		calle='".$arrDatosEmpresa['calle']."',
		noExt='".$arrDatosEmpresa['noExt']."',
		noInt='".$arrDatosEmpresa['noInt']."',
		colonia='".$arrDatosEmpresa['colonia']."',
		cp='".$arrDatosEmpresa['cp']."',
		ciudad='".$arrDatosEmpresa['ciudad']."',
		estado='".$arrDatosEmpresa['estado']."',
		municipio='".$arrDatosEmpresa['municipio']."',
		contactoNombre='".$arrDatosEmpresa['contactoNombre']."',
		telefono='".$arrDatosEmpresa['telefono']."',
		correos='".$arrDatosEmpresa['correos']."',
		sitioWeb='".$arrDatosEmpresa['sitioWeb']."',
		usuario='".$arrDatosEmpresa['usuario']."',
		clave='".$arrDatosEmpresa['clave']."',
		fechaActualizacion='".HOY."',
		infoCapturada=1 where  id=".$arrDatosEmpresa['id'];
		$this->db->query($sql);
		// TODO: Grabar ubicación. Revisar como es el campo ubicación
		// TODO: Actualizar arreglo empresa->datos con los nuevos datos grabados

		//ubicacion='".$this->arrDatosEmpresaTmp['ubicacion']."',
	}
	return ($correcto);
}

	/**
	 *
	 * Funcion que construye un arreglo de prácticas de una empresa y con un cierto estatus
	 * El arreglo puede ser completado con la función hacerArregloCriteriosYEvidencias para referir
	 * información sobre histórico de upload y validación de evidencias por criterio
	 *
	 * @param null $idEmpresa
	 * @param null $idStatus
	 *
	 * @return array
	 */
	function hacerArregloPracticas($idEmpresa=null, $idStatus=null)
	{
		$textoWhere='';
		if($idEmpresa!=NULL) $textoWhere=" empresaId=$idEmpresa ";
		if($idStatus!=NULL) {
			if(strlen($textoWhere)>0) $textoWhere.=" && ";
			$textoWhere.=" estatus=$idStatus ";
		}
		if(strlen($textoWhere)>0) $textoWhere=" where ".$textoWhere;

		$arrTmp=array();
		$sql= "select
				bp_empresa_buenaPractica.*,
				bp_buenasPracticas.tituloCorto as nombrePractica,
				bp_categorias.nombre as nombreCategoria,
				bp_categorias.id as categoriaId,
				bp_catStatus.nombre as statusNombre
				from bp_empresa_buenaPractica
				left join bp_buenasPracticas on bp_buenasPracticas.id= bp_empresa_buenaPractica.buenasPracticasId
				left join bp_categorias on bp_categorias.id= bp_buenasPracticas.categoriaId
				left join bp_catStatus on bp_catStatus.id= bp_empresa_buenaPractica.estatus
				$textoWhere
				order by fechaIncio,fechaAprobacion";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {
			$arrTmp[]=$fila;
		}
		return($arrTmp);
	}

	/**
	 *
	 * Función que completa el arreglo generado por la función hacerArregloPracticas
	 * para incluir datos sobre histórico de evidencias
	 *
	 * @param $empresaId
	 * @param $practicaId
	 * @param $empresa_buenaPracticaId
	 *
	 * @return array
	 */
	function hacerArregloCriteriosYEvidencias($empresaId, $practicaId, $empresa_buenaPracticaId)
	{
		$arrTmp=array();
		$sql="select id,buenaPracticaId,nombre,puntos,orden from bp_criterios where buenaPracticaId=$practicaId order by orden";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()){
			$arrTmp[]=array('criterioId'=>$fila['id'],'practicaId'=>$fila['buenaPracticaId'],'nombre'=>$fila['nombre'],'puntos'=>$fila['puntos'],'orden'=>$fila['orden'],'datos'=>array());
		}

		$arrTmpEventos=array();
		$sql1="select bp_empresa_buenaPractica_eventos.*,bp_catTipoEvidencia.nombre as nombreTipoEvidencia,bp_catTipoEvento.nombre as nombreTipoEvento,bp_catStatus.nombre as nombreEstatus
					from bp_empresa_buenaPractica_eventos
					left join bp_catTipoEvidencia on bp_catTipoEvidencia.id=bp_empresa_buenaPractica_eventos.tipoEvidencia
					left join bp_catTipoEvento on bp_catTipoEvento.id=bp_empresa_buenaPractica_eventos.idTipoDeEvento
					left join bp_catStatus on bp_catStatus.id=bp_empresa_buenaPractica_eventos.estatusCriterio
					where empresa_buenaPracticaId=$empresa_buenaPracticaId order by criterioId, fecha";
		$resultado1=$this->db->query($sql1);
		while ($fila1 = $resultado1->fetch_assoc()){

			for($x=0;$x<count($arrTmp);$x++){
				if($fila1['criterioId']==$arrTmp[$x]['criterioId']){
					$arrTmp[$x]['datos'][]=$fila1;
				}
			}
		}
		return($arrTmp);
	}

	/**
	 *
	 * Función que inserta un registro en bp_empresa_buenaPractica_eventos
	 *
	 * @param $idTipoEvento
	 * @param $empresa_buenaPracticaId
	 * @param $criterioId
	 * @param $nombreEvidencia
	 * @param $tipoEvidencia
	 * @param $estatusCriterio
	 * @param $mensaje
	 * @param $prioridad
	 */
	function agregarEvidencia($idTipoEvento, $empresa_buenaPracticaId, $criterioId, $nombreEvidencia, $tipoEvidencia, $estatusCriterio, $mensaje, $prioridad)
	{
		$sql="insert into bp_empresa_buenaPractica_eventos (idTipoDeEvento,empresa_buenaPracticaId,criterioId,fecha,nombreEvidencia,tipoEvidencia,estatusCriterio,mensaje,prioridad)
			values($idTipoEvento,$empresa_buenaPracticaId,$criterioId,'".HOY."','".$nombreEvidencia."',$tipoEvidencia,$estatusCriterio,'".$mensaje."',$prioridad)";
		$resultado=$this->db->query($sql);

	}

	// funciones del mentor


	/**
	 *
	 * Busca en tabla bp_empresas y hace arreglo de empresas asesoradas por el $mentorId proporcionado.
	 * Se usa en sección mentor
	 *
	 * @param $mentorId
	 *
	 * @return array
	 */
	function hacerArregloEmpresasDeMentor($mentorId)
	{
		// TODO: eficientizar sql en uno solo.
		$arrTmp=array();
		$sql="select id,nombreEmpresa,telefono,correos,mentorId,contactoNombre from bp_empresas where mentorId=$mentorId";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {
			$arrTmp[]=$fila;
		}
		for($x=0;$x<count($arrTmp);$x++){
			$arrTmpPracticas=array();
			$sqlPracticas="select
				bp_empresa_buenaPractica.id as empresaBuenaPracticaId,
				bp_empresa_buenaPractica.empresaId,
				bp_empresa_buenaPractica.buenasPracticasId as buenapracticaId,
				bp_empresa_buenaPractica.estatus as estatusId,
				bp_empresa_buenaPractica.fechaIncio,
				bp_empresa_buenaPractica.fechaAprobacion,
				bp_buenasPracticas.tituloCorto as nombrePractica,
				bp_catStatus.nombre as nombreEstatus
				from
				bp_empresa_buenaPractica
				left join bp_buenasPracticas on bp_buenasPracticas.id=bp_empresa_buenaPractica.buenasPracticasId
				left join bp_catStatus on bp_catStatus.id=bp_empresa_buenaPractica.estatus
				where empresaId=".$arrTmp[$x]['id'];
			$resultadoPracticas=$this->db->query($sqlPracticas);
			while ($filaPracticas = $resultadoPracticas->fetch_assoc()) {
				$arrTmpPracticas[]=$filaPracticas;
			}
			$arrTmp[$x]['practicas']=$arrTmpPracticas;
		}

		for($x=0;$x<count($arrTmp);$x++){
			for($y=0;$y<count($arrTmp[$x]['practicas']);$y++){
				$arrTmpCriterios=array();
				$sqlCriterios="select id,nombre,puntos,orientacionMentor from bp_criterios where buenaPracticaId=".$arrTmp[$x]['practicas'][$y]['buenapracticaId'];
				$resultadoCriterios=$this->db->query($sqlCriterios);
				while ($filaCriterios = $resultadoCriterios->fetch_assoc()) {
					$arrTmpCriterios[]=$filaCriterios;
				}
				$arrTmp[$x]['practicas'][$y]['criterios']=$arrTmpCriterios;
			}
		}

		for($x=0;$x<count($arrTmp);$x++) {
			for ($y = 0; $y < count($arrTmp[$x]['practicas']); $y++) {
				for($z=0;$z<count($arrTmp[$x]['practicas'][$y]['criterios']);$z++){
					$arrTmpEvidencias=array();
					$sqlEvidencias="select bp_empresa_buenaPractica_eventos.id as empresaBuenapracticaEventosId,
						bp_empresa_buenaPractica_eventos.idTipoDeEvento,
						bp_empresa_buenaPractica_eventos.fecha,
						bp_empresa_buenaPractica_eventos.nombreEvidencia,
						bp_empresa_buenaPractica_eventos.idEventoAprobado,
						bp_empresa_buenaPractica_eventos.tipoEvidencia,
						bp_empresa_buenaPractica_eventos.estatusCriterio,
						bp_empresa_buenaPractica_eventos.mensaje,
						bp_catTipoEvento.nombre as nombreTipoEvento,
						bp_catTipoEvidencia.nombre as nombreTipoEvidencia,
						bp_catStatus.nombre as nombreEstatusCriterio,
						0 as aprovada,
						0 as rechazada,
						'' as fechaAprovacionRechazo
						from bp_empresa_buenaPractica_eventos
						left join bp_catTipoEvento on bp_catTipoEvento.id=bp_empresa_buenaPractica_eventos.idTipoDeEvento
						left join bp_catTipoEvidencia on bp_catTipoEvidencia.id=bp_empresa_buenaPractica_eventos.tipoEvidencia
						left join bp_catStatus on bp_catStatus.id=bp_empresa_buenaPractica_eventos.estatusCriterio
						where empresa_buenaPracticaId=".$arrTmp[$x]['practicas'][$y]['empresaBuenaPracticaId']." &&
						bp_empresa_buenaPractica_eventos.criterioId=".$arrTmp[$x]['practicas'][$y]['criterios'][$z]['id']." &&
						bp_empresa_buenaPractica_eventos.idTipoDeEvento=2
						order by bp_empresa_buenaPractica_eventos.idTipoDeEvento, bp_empresa_buenaPractica_eventos.estatusCriterio,bp_empresa_buenaPractica_eventos.fecha
					";
					$resultadoEvidencias=$this->db->query($sqlEvidencias);
					while ($filaEvidencias = $resultadoEvidencias->fetch_assoc()) {
						$arrTmpEvidencias[]=$filaEvidencias;
					}
					$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias']=$arrTmpEvidencias;
				}

			}
		}

		for($x=0;$x<count($arrTmp);$x++) {
			for ($y = 0; $y < count($arrTmp[$x]['practicas']); $y++) {
				$sqlCambioStatus="select bp_empresa_buenaPractica_eventos.id as empresaBuenapracticaEventosId,
				bp_empresa_buenaPractica_eventos.idTipoDeEvento,
				bp_empresa_buenaPractica_eventos.fecha,
				bp_empresa_buenaPractica_eventos.idEventoAprobado
				from bp_empresa_buenaPractica_eventos
				where empresa_buenaPracticaId=".$arrTmp[$x]['practicas'][$y]['empresaBuenaPracticaId']." &&
				bp_empresa_buenaPractica_eventos.idTipoDeEvento>2 and bp_empresa_buenaPractica_eventos.idTipoDeEvento<5";
				$resultadoCambioStatus=$this->db->query($sqlCambioStatus);
				while ($filaCambioStatus = $resultadoCambioStatus->fetch_assoc()) {
					for($z=0;$z<count($arrTmp[$x]['practicas'][$y]['criterios']);$z++){
						for($q=0;$q<count($arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias']);$q++){
							if($arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias'][$q]['empresaBuenapracticaEventosId']==$filaCambioStatus['idEventoAprobado']){
								if($filaCambioStatus['idTipoDeEvento']==3){
									$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias'][$q]['rechazada']=1;
									$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias'][$q]['fechaAprovacionRechazo']=$filaCambioStatus['fecha'];
									$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias'][$q]['nombreEstatusCriterio']="Rechazada";
								}else if($filaCambioStatus['idTipoDeEvento']==4){
									$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias'][$q]['aprovada']=1;
									$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias'][$q]['fechaAprovacionRechazo']=$filaCambioStatus['fecha'];
									$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias'][$q]['nombreEstatusCriterio']="Aprobada";
								}
							}
						}
					}
				}
			}
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Inserta registro en bp_empresa_buenaPractica_eventos con los datos de aprovación de la evidencia
	 *
	 * @param $item
	 * @param $arrEmpresaSeleccionada
	 */
	function aprobarEvidencia($item, $arrEmpresaSeleccionada)
	{
		$cachos=explode(';',$item);
		$practicaItem=$cachos['0'];
		$criteriosItem=$cachos['1'];
		$evidenciasIitem=$cachos['2'];
		$empresaBuenapracticaEventosId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['evidencias'][$evidenciasIitem]['empresaBuenapracticaEventosId'];
		$empresaBuenapracticaId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['empresaBuenaPracticaId'];
		$criterioId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['id'];

		// insertar registro de aprobacion en bp_empresa_buenaPractica_eventos
		$sql="insert into bp_empresa_buenaPractica_eventos (idTipoDeEvento,empresa_buenaPracticaId,criterioId,fecha,estatusCriterio,mensaje,prioridad,idEventoAprobado)
			values('4',$empresaBuenapracticaId,$criterioId,'".HOY."','3','Aprobación de evidencia','3',$empresaBuenapracticaEventosId)";
		$this->db->query($sql);
	}

	/**
	 *
	 * Inserta registro en bp_empresa_buenaPractica_eventos con los datos de rechazo de la evidencia
	 *
	 * @param $item
	 * @param $arrEmpresaSeleccionada
	 */
	function rechazarEvidencia($item, $arrEmpresaSeleccionada)
	{
		$cachos=explode(';',$item);
		$practicaItem=$cachos['0'];
		$criteriosItem=$cachos['1'];
		$evidenciasIitem=$cachos['2'];
		$empresaBuenapracticaEventosId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['evidencias'][$evidenciasIitem]['empresaBuenapracticaEventosId'];
		$empresaBuenapracticaId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['empresaBuenaPracticaId'];
		$criterioId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['id'];

		// insertar registro de aprobacion en bp_empresa_buenaPractica_eventos
		$sql="insert into bp_empresa_buenaPractica_eventos (idTipoDeEvento,empresa_buenaPracticaId,criterioId,fecha,estatusCriterio,mensaje,prioridad,idEventoAprobado)
			values('3',$empresaBuenapracticaId,$criterioId,'".HOY."','3','Rechazo de evidencia','3',$empresaBuenapracticaEventosId)";
		$this->db->query($sql);
	}

	/**
	 *
	 * Revisa que para cada criterio de la practica exista un registro de autorizacion de evidencia
	 * Si se cumple inserta un registro en bp_empresa_buenaPractica_eventos con los datos de autorización de la práctica
	 * y graba en bp_empresa_buenaPractica la fecha de aprovación y el cambio de estatus a Aprobada
	 *
	 * @param $item
	 * @param $arrEmpresaSeleccionada
	 */
	function validarCompletudDeCriteriosDePractica($item, $arrEmpresaSeleccionada)
	{
		$cachos=explode(';',$item);
		$practicaItem=$cachos['0'];
		$empresaBuenapracticaId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['empresaBuenaPracticaId'];
		$idPractica=$arrEmpresaSeleccionada['practicas'][$practicaItem]['buenapracticaId'];

		// revisar cuantos criterios hay para la practica
		$sql="select count(*) as cuantosTerminados from bp_criterios,bp_empresa_buenaPractica_eventos
			where bp_empresa_buenaPractica_eventos.criterioId=bp_criterios.id and
			bp_criterios.buenaPracticaId=$idPractica and bp_empresa_buenaPractica_eventos.idTipoDeEvento=4";
		$resultado=$this->db->query($sql);
		$fila = $resultado->fetch_assoc();
		if($fila['cuantosTerminados'] == count($arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'])){
			// insertar registro de aprobacion en bp_empresa_buenaPractica_eventos
			$sql="insert into bp_empresa_buenaPractica_eventos (idTipoDeEvento,empresa_buenaPracticaId,fecha,estatusBuenaPractica,mensaje,prioridad)
			values('5',$empresaBuenapracticaId,'".HOY."','3','Aprobación de práctica','3')";
			$this->db->query($sql);
			$sql2="update bp_empresa_buenaPractica set estatus=3,fechaAprobacion='".HOY."' where id=".$empresaBuenapracticaId;
			$this->db->query($sql2);
		}
	}




	// funciones de admon

	/**
	 *
	 * Busca en tabla bp_personal y hace un arreglo de todos los registros de personal
	 * Se usa en admon.
	 *
	 * @return array
	 */
	function hacerArregloPersonal()
	{
		$arrTmp=array();
		$sql="Select * from bp_personal order by esSuperAdmin DESC ";
		$resultado=$this->db->query($sql);
		while($fila=$resultado->fetch_assoc()){
			$arrTmp[]=$fila;
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Valida la corrección de los datos de una persona.
	 * Si son correctos y el registro es de una nueva persona agrega un registro a la tabla bp_personal.
	 * Si son correctos y el registro es de una persona existente hace el update del registro en la tabla bp_personal
	 *
	 * @param $arrDatosPersona
	 *
	 * @return int
	 */
	function validarDatosPersona($arrDatosPersona)
	{
		// TODO: Definir correctamente las validaciones por hacer
		// TODO: Implementar grabado y validado de clave según modelo de Michael
		$correcto=1;
		if(strlen($arrDatosPersona['nombre'])==0) $correcto=0;
		if(strlen($arrDatosPersona['usuario'])==0) $correcto=0;
		if(strlen($arrDatosPersona['clave'])==0) $correcto=0;
		if(strlen($arrDatosPersona['email'])==0) $correcto=0;
		//if(strlen($arrDatosPersona['nota'])==0) $correcto=0;
		if($arrDatosPersona['esSuperAdmin']>1 && $arrDatosPersona['esSuperAdmin']<0) $correcto=0;
		if($arrDatosPersona['correoNotificacionCadaXHoras']<1) $correcto=0;

		if($correcto){
			if($arrDatosPersona['id']=='nuevo') {
				$sql = "INSERT INTO bp_personal SET
					nombre='".$arrDatosPersona['nombre']."',
					usuario='".$arrDatosPersona['usuario']."',
					clave='".$arrDatosPersona['clave']."',
					email='".$arrDatosPersona['email']."',
					fechaCreado='".HOY."',
					fechaClaveUpdate='".HOY."',
					nota='".$arrDatosPersona['nota']."',
					esSuperAdmin='".$arrDatosPersona['esSuperAdmin']."',
					correoNotificacionCadaXHoras='".$arrDatosPersona['correoNotificacionCadaXHoras']."'";
			} else {

				$sql="select usuario,clave from bp_personal where id=".$arrDatosPersona['id'];
				$resultado=$this->db->query($sql);
				$linea=$resultado->fetch_assoc();

				$variableFechaClaveUpdate=($linea['usuario']!=$arrDatosPersona['usuario'] || $linea['clave']!=$arrDatosPersona['clave']) ?
					"fechaClaveUpdate='".HOY."'," : "";

				//if($linea['usuario']!=$arrDatosPersona['usuario'] || $linea['clave']!=$arrDatosPersona['clave'])

				$sql = "update bp_personal SET
					nombre='".$arrDatosPersona['nombre']."',
					usuario='".$arrDatosPersona['usuario']."',
					clave='".$arrDatosPersona['clave']."',
					email='".$arrDatosPersona['email']."',
					$variableFechaClaveUpdate
					nota='".$arrDatosPersona['nota']."',
					esSuperAdmin='".$arrDatosPersona['esSuperAdmin']."',
					correoNotificacionCadaXHoras='".$arrDatosPersona['correoNotificacionCadaXHoras']."' where id=".$arrDatosPersona['id'];
			}
			$this->db->query($sql);
		}
		return ($correcto);
	}



}
