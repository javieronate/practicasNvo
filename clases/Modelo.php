<?php

/**
 *
 * Modelo Buenas Prácticas
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
	/**
	 * Almacena objeto de tipo mysqli para conexión a base de datos
	 */
	/** @var Database */
	var $db;

	var $arrCategorias=array();


	////////////////////////////////////



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
		//$this->arrBuenasPracticas = $this->hacerArregloBuenasPracticas();

	}



	// funciones activas


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

	function buscarDatosPaginaCategoria($categoriaId)
	{
		$arrTmp=array();
		$resultado = $this->db->query("SELECT * FROM bp_categorias where id=$categoriaId ORDER BY id");
		while ($renglon = $resultado->fetch_assoc()) {
			$arrTmp=array('id'=>$renglon['id'],'nombre'=>$renglon['nombre'], 'descripcion'=>$renglon['descripcion'],'imagen1'=>$renglon['imagen1'],'imagen2'=>$renglon['imagen2'],'imagen3'=>$renglon['imagen3']);
		}
		return ($arrTmp);
	}

	function buscarPracticasDeCategoria($categoriaId)
	{
		$arrTmp=array();
		$resultado = $this->db->query("SELECT id,tituloCorto FROM bp_buenasPracticas where categoriaId=$categoriaId ORDER BY orden");
		while ($renglon = $resultado->fetch_assoc()) {
			$arrTmp[]=array('id'=>$renglon['id'],'nombre'=>$renglon['tituloCorto']);
		}
		return ($arrTmp);
	}

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

	function validarLogin($usuario,$clave){
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
			$this->agregarRegistroLog($arrTmp['id'],NULL,MENSAJE_LOGIN_EMPRESA,3);
			$this->anotarUltimoLoginEmpresa($arrTmp['id']);
		}else{
			// buscar si es usuario de personal
			$sql = "select count(*)as cuantos from bp_personal where usuario ='".$usuario."' and clave='".$clave."'";
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
				$this->agregarRegistroLog(NULL,$arrTmp['id'],MENSAJE_LOGIN_PERSONAL,3);
				$this->anotarUltimoLoginPersona($arrTmp['id']);
			}else{
				$arrTmp['rol'] = "fallo";
			}
		}
		return($arrTmp);
	}

	function agregarRegistroLog($idEmpresa,$idPersonal,$mensaje,$prioridad)
	{
		$sql=($idPersonal==NULL)? "insert into bp_logActividades(idEmpresa,mensaje,prioridad) values ($idEmpresa,'".$mensaje."',$prioridad)" : "insert into bp_logActividades(idPersonal,mensaje,prioridad) values ($idPersonal,'".$mensaje."',$prioridad)";
		$this->db->query($sql);
	}

	function anotarUltimoLoginEmpresa($idEmpresa)
	{
		$hoy=date('Ymd');
		$sql="update bp_empresas set ultimoLogin='".$hoy."' where id=$idEmpresa";
		$this->db->query($sql);
	}

	function anotarUltimoLoginPersona($idPersona)
	{
		$hoy=date('Ymd');
		$sql="update bp_personal set ultimoLogin='".$hoy."' where id=$idPersona";
		$this->db->query($sql);
	}

	/**
	 *
	 * llena el arreglo de buenas practicas
	 * para poblar la sección derecha de la pagina de empresa
	 *
	 * @return array
	 */
	function hacerArregloBuenasPracticas($empresaId)
	{
		// buscar todas las practicas organizadas segun las catagorias y hacer un arreglo
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

	function hacerArregloPracticas($idEmpresa,$idStatus)
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

	function hacerArregloAutoevaluacion()
	{
		$arrTmp=array();
		$sql="select id, pregunta,puntos,idBuenaPractica from bp_preguntasAutoevaluacion where activo=1 order by orden";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {

			$arrTmp[]=array('idPregunta'=>$fila['id'], 'pregunta'=>$fila['pregunta'], 'puntos'=>$fila['puntos'], 'idBuenaPractica'=>$fila['idBuenaPractica'],
				'valor'=>'','correcta'=>1);
		}
		return($arrTmp);
	}

	function validarAutoevaluacion($post,$arrPreguntas,$empresaId)
	{
		$correcto=1;
		echo "dentro de validar autoevaluacion<br>";
		for($x=0;$x<count($arrPreguntas);$x++){
			$nombre="respuesta".$x;
			if(!isset($post[$nombre])){
				echo "falto respuesta de pregunta $x<br>";
				$correcto=0;
			}
		}
		if($correcto==1){
			$arrValores=array();
			for($x=0;$x<count($arrPreguntas);$x++){
				$nombre="respuesta".$x;
				$y=$x+1;
				$arrValores[]=array($empresaId,$y,$post[$nombre]);

				//$sql="insert into bp_empresaResultadoAutoevaluacion ($empresaId,$x,$post[$nombre])";
				//echo "$sql<br>";
				//$this->db->query($sql);
			}
			$valoresTxt='';
			for($x=0;$x<count($arrValores);$x++){
				if(strlen($valoresTxt)>0) $valoresTxt.=",";
				$valoresTxt.="('".$arrValores[$x][0]."','".$arrValores[$x][1]."','".$arrValores[$x][2]."')";
			}
			$sql="insert into bp_empresaResultadoAutoevaluacion (idEmpresa,idPregunta,respuesta) values $valoresTxt";
			echo "$sql<br>";
			$this->db->query($sql);
			$sql1="update bp_empresas set autoevaluacionHecha=1";
			$this->db->query($sql1);
		}

	}







	// funciones por usarse
	/**
	 *
	 * Busca la descripción completa de la buena practica con id = variable id
	 *
	 * @param $id
	 * @return array
	 */
	function buscarDescripcionPractica($id)
	{
		$tmpArr=array();
		$sql = "select * from bp_buenasPracticas where id=$id";
		$resultado = $this->db->query($sql);

		$fila = $resultado->fetch_assoc();


		$tmpArr = array(
			'id' => $fila['id'],
			'categoriaId' => $fila['categoriaId'],
			'titulo' => $fila['titulo'],
			'tituloCorto' => $fila['tituloCorto'],
			'descripcion' => $fila['descripcion'],
			'experiencia' => $fila['experiencia'],
			'sustentabilidad' => $fila['sustentabilidad'],
			'competitividad' => $fila['competitividad'],
			'variaciones' => $fila['variaciones'],
			'recursos' => $fila['recursos'],
			'aprenderMas' => $fila['aprenderMas'],
			'criterios' => $fila['criterios'],
			'propietarioId' => $fila['propietarioId'],
			'imagen1' => $fila['imagen1'],
			'imagen2' => $fila['imagen2'],
			'imagen3' => $fila['imagen3']
		);
		return ($tmpArr);
	}






}
