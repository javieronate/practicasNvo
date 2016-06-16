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
				'ejemplosCumplimiento'=>$renglon['ejemplosCumplimiento'],
				'valorDeCertificacion'=>$renglon['valorDeCertificacion'],
				'ANPAplicacion'=>$renglon['ANPAplicacion'],
			);
		}
		$arrTmp['criterios']=$this->buscarCriteriosDePractica($practicaId);
		$arrTmp['impresos']=$this->buscarImpresosDePractica($practicaId);
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
	 * Construye un arreglo de los impresos asociados a la practica
	 *
	 * @param $idPractica
	 *
	 * @return array
	 */
	function buscarImpresosDePractica($idPractica)
	{
		$arrTmp=array();
		$sql="select id, nombre,archivo from bp_impresos where practicaId=$idPractica order by archivo";
		$resultado=$this->db->query($sql);
		while($renglon = $resultado->fetch_assoc()) {
			$arrTmp[]=array('id'=>$renglon['id'],'nombre'=>$renglon['nombre'],'archivo'=>$renglon['archivo']);
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

		$arrTmp=array();

		// buscar si es usuario de empresa

		// Salt starting with $2a$. The two digit cost parameter: 09. 22 characters
		if (CRYPT_BLOWFISH == 1)
		{
			$pw_hash = crypt($clave,SALT);
		}
		else
		{
			echo "Blowfish DES not supported.\n<br>";
		}

		$sql = "select count(*)as cuantos from bp_empresas where usuario ='".$usuario."' and (clave='".$clave."' OR clave='".$pw_hash."' )";
		$resultado = $this->db->query($sql);
		$datos = $resultado->fetch_assoc();
		if($datos['cuantos']==1) {
			$sql2 = "select *, X(ubicacion) as latitud, Y(ubicacion) as longitud from bp_empresas where usuario ='" . $usuario . "' and (clave='".$clave."' OR clave='".$pw_hash."' )";
			$resultado2 = $this->db->query($sql2);
			$datos2 = $resultado2->fetch_assoc();
			$arrTmp['rol'] = 'empresa';
			$arrTmp['id'] = $datos2['id'];
			$arrTmp['nombreEmpresa'] = $datos2['nombreEmpresa'];
			$arrTmp['latitud'] = $datos2['latitud'];
			$arrTmp['longitud'] = $datos2['longitud'];
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
			$arrTmp['foto'] = $datos2['foto'];
			$this->agregarRegistroLog($arrTmp['id'],null,MENSAJE_LOGIN_EMPRESA,4);
			$this->anotarUltimoLoginEmpresa($arrTmp['id']);
		}else{
			// buscar si es usuario de personal
			$sql = "select count(*) as cuantos from bp_personal where usuario ='".$usuario."' and (clave='".$clave."' OR clave='".$pw_hash."' )";
			$resultado = $this->db->query($sql);
			$datos = $resultado->fetch_assoc();
			if($datos['cuantos']==1) {
				$sql2 = "select bp_personal.*,bp_catNiveles.nombre as nombreNivel from bp_personal
						left join bp_catNiveles on bp_catNiveles.id=bp_personal.nivelId
						where usuario ='" . $usuario . "'  and (clave='".$clave."' OR clave='".$pw_hash."' )";
				$resultado2 = $this->db->query($sql2);
				$datos2 = $resultado2->fetch_assoc();

				switch($datos2['nivelId']){
					case '1':
						$rol='superAdmin';
						break;
					case '2':
						$rol='adminRegional';
						break;
					case '3':
						$rol='mentor';
						break;
				}
				$arrTmp['nombreNivel'] = $datos2['nombreNivel'];
				$arrTmp['rol'] = $rol;
				$arrTmp['id'] = $datos2['id'];
				$arrTmp['nombre'] = $datos2['nombre'];
				$arrTmp['email'] = $datos2['email'];
				$arrTmp['region'] = $datos2['region'];
				$arrTmp['nivelId'] = $datos2['nivelId'];
				$arrTmp['superiorId'] = $datos2['superiorId'];
				$arrTmp['ultimoLogin'] = $datos2['ultimoLogin'];
				$this->agregarRegistroLog(null,$arrTmp['id'],MENSAJE_LOGIN_PERSONAL,4);
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

		if($idEmpresa==null){
			$sql="insert into bp_logActividades SET idPersonal='".$idPersonal."',mensaje='".$mensaje."',prioridad='".$prioridad."'";
		}else if ($idPersonal==null){
			$sql="insert into bp_logActividades SET idEmpresa='".$idEmpresa."',mensaje='".$mensaje."',prioridad='".$prioridad."'";
		}else{
			$sql="insert into bp_logActividades SET idEmpresa='".$idEmpresa."',idPersonal='".$idPersonal."',mensaje='".$mensaje."',prioridad='".$prioridad."'";
		}
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
	 * Evalua el tipo de modificación que se genero y envia un correo a la persona involucrada
	 *
	 * @param      $modalidad
	 * @param      $correos
	 * @param      $nombreContacto
	 * @param      $nombreEmpresa
	 * @param      $usuario
	 * @param      $clave
	 * @param      $nombreDelMentor
	 * @param      $correoDelMentor
	 * @param null $region
	 *
	 * @return bool
	 */
	function enviarCorreoAlta($modalidad, $correos, $nombreContacto, $nombreEmpresa, $usuario, $clave, $nombreDelMentor, $correoDelMentor, $region=null)
	{
		switch($modalidad){
			case 'altaEmpresa':
				$asunto="Aviso de alta de empresa en Biomar - Prácticas de sustentabilidad";

				// mensaje
				$mensaje = '<html><head><title>Aviso de alta de empresa en Biomar - Prácticas de sustentabilidad</title></head>';
				$mensaje.='<body>';
				$mensaje.="<h2>$nombreEmpresa</h2>";
				$mensaje.="<h3>Estimado Sr. / Sra. $nombreContacto</h3>";
				$mensaje.="<p>Por este conducto nos complace darle la bienvenida al Sistema Prácticas de sustentabilidad de Biomar.</p>";
				$mensaje.="<p>La dirección del sitio es http://biomar.org/turismo/index.php</p>";
				$mensaje.="<p>Usuario: $usuario</p>";
				$mensaje.="<p>Clave: $clave</p>";
				$mensaje.="<p>Para cualquier aclaración puede enviar un correo a $nombreDelMentor en la dirección $correoDelMentor</p>";
				$mensaje.="<p>Atentamente</p>";
				$mensaje.="<<p>Biomar</p>";
				$mensaje.="</body></html>";
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				// Cabeceras adicionales
				$cabeceras .= "To: <$correos>" . "\r\n";
				$cabeceras .= "From:  Biomar <$correoDelMentor>". "\r\n";
				break;
			case 'editarEmpresa':
				$asunto="Aviso de modificación de datos de empresa en Biomar - Prácticas de sustentabilidad";

				// mensaje
				$mensaje = '<html><head><title>Aviso de modificación de datos de empresa en Biomar - Prácticas de sustentabilidad</title></head>';
				$mensaje.='<body>';
				$mensaje.="<h2>$nombreEmpresa</h2>";
				$mensaje.="<h3>Estimado Sr. / Sra. $nombreContacto</h3>";
				$mensaje.="<p>Por este conducto nos complace darle la bienvenida al Sistema Prácticas de sustentabilidad de Biomar.</p>";
				$mensaje.="<p>La dirección del sitio es http://biomar.org/turismo/index.php</p>";
				$mensaje.="<p>Usuario: $usuario</p>";
				$mensaje.="<p>Clave: $clave</p>";
				$mensaje.="<p>Para cualquier aclaración puede enviar un correo a $nombreDelMentor en la dirección $correoDelMentor</p>";
				$mensaje.="<p>Atentamente</p>";
				$mensaje.="<<p>Biomar</p>";
				$mensaje.="</body></html>";
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				// Cabeceras adicionales
				$cabeceras .= "To: <$correos>" . "\r\n";
				$cabeceras .= "From:  Biomar <$correoDelMentor>". "\r\n";
				break;
			case 'agregarMentor':
				$asunto="Aviso de alta de Mentor en Biomar - Prácticas de sustentabilidad";
				$mensaje = '<html><head><title>Aviso de alta de Mentor en Biomar - Prácticas de sustentabilidad</title></head>';
				$mensaje.='<body>';
				//$mensaje.="<h2>$nombreEmpresa</h2>";
				$mensaje.="<h3>Estimado Sr. / Sra. $nombreContacto</h3>";
				$mensaje.="<p>Por este conducto nos complace darle la bienvenida al Sistema Prácticas de sustentabilidad de Biomar como Mentor de la región \"$region\".</p>";
				$mensaje.="<p>La dirección del sitio es http://biomar.org/turismo/index.php</p>";
				$mensaje.="<p>Usuario: $usuario</p>";
				$mensaje.="<p>Clave: $clave</p>";
				$mensaje.="<p>Para cualquier aclaración puede enviar un correo a $nombreDelMentor en la dirección $correoDelMentor</p>";
				$mensaje.="<p>Atentamente</p>";
				$mensaje.="<p>Biomar</p>";
				$mensaje.="</body></html>";
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				// Cabeceras adicionales
				$cabeceras .= "To: <$correos>" . "\r\n";
				$cabeceras .= "From:  Biomar <$correoDelMentor>". "\r\n";
				break;
			case 'actualizarMentor':
				$asunto="Aviso de actualización de datos";
				$mensaje = '<html><head><title>Aviso de actualización de datos</title></head>';
				$mensaje.="<body>";
				$mensaje.="<h3>Estimado Sr. / Sra. $nombreContacto</h3>";
				$mensaje.="<p>Por este conducto le informamos que sus datos para ingresar en Biomar - Prácticas de sustentabilidad han cambiado</p>";
				$mensaje.="<p>Usuario: $usuario</p>";
				$mensaje.="<p>Clave: $clave</p>";
				$mensaje.="<p>Para cualquier aclaración puede enviar un correo a $nombreDelMentor en la dirección $correoDelMentor</p>";
				$mensaje.="<p>Atentamente</p>";
				$mensaje.="<p>Biomar</p>";
				$mensaje.="</body></html>";
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				// Cabeceras adicionales
				$cabeceras .= "To: <$correos>" . "\r\n";
				$cabeceras .= "From:  Biomar <$correoDelMentor>". "\r\n";
				break;
			case 'agregarAdmonRegional':
				$asunto="Aviso de alta de Director de ANP en Biomar - Prácticas de sustentabilidad";
				$mensaje = '<html><head><title>Aviso de alta de Director de ANP en Biomar - Prácticas de sustentabilidad</title></head>';
				$mensaje.='<body>';
				//$mensaje.="<h2>$nombreEmpresa</h2>";
				$mensaje.="<h3>Estimado Sr. / Sra. $nombreContacto</h3>";
				$mensaje.="<p>Por este conducto nos complace darle la bienvenida al Sistema Prácticas de sustentabilidad de Biomar como Director de ANP de la región \"$region\".</p>";
				$mensaje.="<p>La dirección del sitio es http://biomar.org/turismo/index.php</p>";
				$mensaje.="<p>Usuario: $usuario</p>";
				$mensaje.="<p>Clave: $clave</p>";
				$mensaje.="<p>Para cualquier aclaración puede enviar un correo a $nombreDelMentor en la dirección $correoDelMentor</p>";
				$mensaje.="<p>Atentamente</p>";
				$mensaje.="<p>Biomar</p>";
				$mensaje.="</body></html>";
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				// Cabeceras adicionales
				$cabeceras .= "To: <$correos>" . "\r\n";
				$cabeceras .= "From:  Biomar <$correoDelMentor>". "\r\n";
				break;
			case 'actualizarAdmonRegional':
				$asunto="Aviso de actualización de datos";
				$mensaje = '<html><head><title>actualización de datos</title></head>';
				$mensaje.="<body>";
				$mensaje.="<h3>Estimado Sr. / Sra. $nombreContacto</h3>";
				$mensaje.="<p>Por este conducto le informamos que sus datos para ingresar en Biomar - Prácticas de sustentabilidad han cambiado</p>";
				$mensaje.="<p>Usuario: $usuario</p>";
				$mensaje.="<p>Clave: $clave</p>";
				$mensaje.="<p>Para cualquier aclaración puede enviar un correo a $nombreDelMentor en la dirección $correoDelMentor</p>";
				$mensaje.="<p>Atentamente</p>";
				$mensaje.="<p>Biomar</p>";
				$mensaje.="</body></html>";
				// Para enviar un correo HTML, debe establecerse la cabecera Content-type
				$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
				$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				// Cabeceras adicionales
				$cabeceras .= "To: <$correos>" . "\r\n";
				$cabeceras .= "From:  Biomar <$correoDelMentor>". "\r\n";
				break;
		}
		// Enviarlo
		$enviado=mail($correos, $asunto, $mensaje, $cabeceras);
		return ($enviado);
	}

	/**
	 *
	 * Revisa si el hash grabado en la tabla es igual al contenido del campo clave
	 * para definir si se graba o no la clave en actualizaciones
	 *
	 * @param $tabla
	 * @param $clave
	 * @param $id
	 *
	 * @return int
	 */
	function verificarModificacionDeClave($tabla, $clave, $id)
	{
		$sql="select clave from $tabla where id=$id";
		$resultado=$this->db->query($sql);
		$linea=$resultado->fetch_assoc();
		if($linea['clave']==$clave) {
			$cambiada=0;
		}else if ($linea['clave']!=$clave){
			$cambiada=1;
		}
		return ($cambiada);
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

	 * @param $arrPreguntas
	 * @param $empresaId
	 * @param $nombreEmpresa
	 * @param $mentorId
	 *
	 * @return int
	 *
	 */
	function validarAutoevaluacion($arrPreguntas, $empresaId, $nombreEmpresa,$mentorId)
	{
		$correcto=1;
		for($x=0;$x<count($arrPreguntas);$x++){
			if($arrPreguntas[$x]['correcta']==0) $correcto=0;
		}
		if($correcto==1){
			//$hoy=date('Ymd');
			// grabar en bp_empresaResultadoAutoevaluacion
			$valoresTxt='';
			for($x=0;$x<count($arrPreguntas);$x++){
				if(strlen($valoresTxt)>0) $valoresTxt.=",";
				$valoresTxt.="('".$empresaId."','".$arrPreguntas[$x]['idPregunta']."','".$arrPreguntas[$x]['valor']."')";
			}
			$sql="insert into bp_empresaResultadoAutoevaluacion (idEmpresa,idPregunta,respuesta) values $valoresTxt";
			$this->db->query($sql);

			// update empresas para poner que ya hizo la evaluación
			$sql1="update bp_empresas set autoevaluacionHecha=1, fechaAutoevaluacion='".HOY."' where id=$empresaId";
			$this->db->query($sql1);

			// agregar buenas practicas que se marcaron como si
			//$mensaje="Agregada automaticamente como resultado de la autoevaluación";
			for($x=0;$x<count($arrPreguntas);$x++){
				if($arrPreguntas[$x]['valor']=='1')
					$this->agregarPracticaAEmpresa($empresaId, $arrPreguntas[$x]['idBuenaPractica'], '2',$nombreEmpresa,$mentorId);
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
	 * @param $nombreEmpresa
	 * @param $mentorId
	 *
	 */
	function agregarPracticaAEmpresa($empresaId, $practicaId, $statusId, $nombreEmpresa,$mentorId=null)
	{
		// buscar si la practica esta dada de alta y vigente
		$sql0 = "select count(*) as cuantos from bp_empresa_buenaPractica where empresaId=$empresaId && buenasPracticasId=$practicaId && estatus!=6";
		$resultado0 = $this->db->query($sql0);
		$fila0 = $resultado0->fetch_assoc();
		$cuantos = $fila0['cuantos'];
		if ($cuantos == 0) {
			$textoValores = "($empresaId,$practicaId,$statusId,'".HOY."')";
			$sql = "insert into bp_empresa_buenaPractica (empresaId,buenasPracticasId,estatus,fechaIncio) values $textoValores";
			$this->db->query($sql);
			$idEmpresaBuenaPractica = $this->db->insert_id;
			$sql1 = "select * from bp_criterios where buenaPracticaId=$practicaId order by orden";
			$resultado1 = $this->db->query($sql1);
			while ($fila = $resultado1->fetch_assoc()) {
				$sql2 = "INSERT INTO bp_empresa_buenaPractica_criterios SET
					empresa_buenaPracticaId='".$idEmpresaBuenaPractica."',
					buenaPracticaId='".$practicaId."',
					criterioId='".$fila['id']."',
					estatusCriterio='2',
					prioridad='3',
					fechaEvaluacion=NULL";
				$this->db->query($sql2);
			}
			$sql2="select tituloCorto from bp_buenasPracticas where id=$practicaId";
			$resultado2=$this->db->query($sql2);
			$linea2=$resultado2->fetch_assoc();

			$mensaje= "La empresa ".$nombreEmpresa." ha agregado la práctica \"".$linea2['tituloCorto']."\"";
			$this->agregarRegistroLog($empresaId, $mentorId, $mensaje, 3);
		}
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
		if(strlen($arrDatosEmpresa['latitud'])==0) $correcto=0;
		if(strlen($arrDatosEmpresa['longitud'])==0) $correcto=0;

		if($correcto==1) {

			$claveModificada=$this->verificarModificacionDeClave('bp_empresas',$arrDatosEmpresa['clave'],$arrDatosEmpresa['id']);
			$lineaClave=($claveModificada==1)? "clave='".crypt($arrDatosEmpresa['clave'],SALT)."'," : "";
			$coordenadas="GeomFromText('POINT(".$arrDatosEmpresa['latitud']." ".$arrDatosEmpresa['longitud'].")')";
			$sql="update bp_empresas set
			nombreEmpresa='".$arrDatosEmpresa['nombreEmpresa']."',
			calle='".$arrDatosEmpresa['calle']."',
			noExt='".$arrDatosEmpresa['noExt']."',
			noInt='".$arrDatosEmpresa['noInt']."',
			colonia='".$arrDatosEmpresa['colonia']."',
			cp='".$arrDatosEmpresa['cp']."',
			ciudad='".$arrDatosEmpresa['ciudad']."',
			ciudad='".$arrDatosEmpresa['ciudad']."',
			ubicacion=".$coordenadas.",
			estado='".$arrDatosEmpresa['estado']."',
			municipio='".$arrDatosEmpresa['municipio']."',
			contactoNombre='".$arrDatosEmpresa['contactoNombre']."',
			telefono='".$arrDatosEmpresa['telefono']."',
			correos='".$arrDatosEmpresa['correos']."',
			sitioWeb='".$arrDatosEmpresa['sitioWeb']."',
			usuario='".$arrDatosEmpresa['usuario']."',
			$lineaClave
			fechaActualizacion='".HOY."',
			infoCapturada=1 where  id=".$arrDatosEmpresa['id'];
			$this->db->query($sql);
			//echo "$sql<br>";
		}
		return ($correcto);
	}

	/**
	 *
	 * Graba el nombre aleatorio de la foto de la empresa en la tabla bp_empresas
	 *
	 * @param $id
	 * @param $nombreFoto
	 */
	function grabarNombreFotoEmpresa($id, $nombreFoto)
	{
		$sql="update bp_empresas set foto='".$nombreFoto."' where id=".$id;
		$this->db->query($sql);
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
		$sql="select bp_empresa_buenaPractica_criterios.*, bp_criterios.nombre, bp_criterios.descripcion, bp_criterios.puntos,bp_criterios.orientacionMentor
			from bp_empresa_buenaPractica_criterios left join bp_criterios on bp_criterios.id=bp_empresa_buenaPractica_criterios.criterioId
			where bp_empresa_buenaPractica_criterios.empresa_buenaPracticaId= $empresa_buenaPracticaId order by bp_criterios.orden";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()){
			$arrTmp[]=$fila;
		}

		for($x=0;$x<count($arrTmp);$x++){
			$arrTmp2=array();
			$sql1="select bp_evidencias.*,
					bp_catStatus.nombre as nombreEstatus,
					bp_catTipoEvento.nombre as nombreTipoEvento
					from bp_evidencias
					left join bp_catStatus on bp_catStatus.id=bp_evidencias.evidenciaStatus
					left join bp_catTipoEvento on bp_catTipoEvento.id=bp_evidencias.idTipoDeEvento
					where empresaPracticaCriteriosId= ".$arrTmp[$x]['id']."
					order by id";
			$resultado1=$this->db->query($sql1);
			while ($fila1 = $resultado1->fetch_assoc()){
				$arrTmp2[]=$fila1;
			}
			$arrTmp[$x]['evidencias']=$arrTmp2;
		}
		return($arrTmp);
	}

	/**
	 *
	 * Función que inserta un registro en bp_empresa_buenaPractica_criterios.
	 *
	 * @param $idTipoEvento
	 * @param $empresa_buenaPracticaId
	 * @param $empresaPracticaCriteriosId
	 * @param $buenaPracticaId
	 * @param $criterioId
	 * @param $nombreEvidencia
	 * @param $nombreOriginal
	 * @param $tipoEvidencia
	 * @param $mensaje
	 * @param $prioridad
	 */
	function agregarEvidencia($idTipoEvento, $empresa_buenaPracticaId, $empresaPracticaCriteriosId, $buenaPracticaId, $criterioId, $nombreEvidencia, $nombreOriginal,
	                          $tipoEvidencia, $mensaje, $prioridad)
	{
		$sql="insert into bp_evidencias set
			idTipoDeEvento='".$idTipoEvento."',
			buenaPracticaId='".$buenaPracticaId."',
			empresa_buenaPracticaId='".$empresa_buenaPracticaId."',
			empresaPracticaCriteriosId='".$empresaPracticaCriteriosId."',
			criterioId='".$criterioId."',
			fechaAltaEvidencia='".HOY."',
			nombreEvidencia='".$nombreEvidencia."',
			nombreOriginal='".$nombreOriginal."',
			tipoEvidencia='".$tipoEvidencia."',
			comentariosEmpresa='".$mensaje."',
			comentariosMentor='',
			evidenciaStatus='2',
			prioridad='".$prioridad."'";
		$this->db->query($sql);
	}

	/**
	 *
	 * Construye el arreglo con los datos para la gráfica de la página de inicio de empresas
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	function buscarDatosGraficasEmpresa($id)
	{
		$arrEmpresa=array();
		$arrTotalesPosibles=array();
		$sumaUnoTerminadas=0;
		$sumaDosTerminadas=0;
		$sumaTresTerminadas=0;
		$sumaUnoEnProceso=0;
		$sumaDosEnProceso=0;
		$sumaTresEnProceso=0;
		$sumaEmpresas=0;

		$sql="select E.empresaId,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=1
			group by E2.empresaId) as puntosUnoTerminadas,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=2 and E2.empresaId=E.empresaId and B.tipoRequisitoId=1
			group by E2.empresaId) as puntosUnoEnProceso,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=2
			group by E2.empresaId) as puntosDosTerminadas,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=2 and E2.empresaId=E.empresaId and B.tipoRequisitoId=2
			group by E2.empresaId) as puntosDosEnProceso,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=3
			group by E2.empresaId) as puntosTresTerminadas,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=2 and E2.empresaId=E.empresaId and B.tipoRequisitoId=3
			group by E2.empresaId) as puntosTresEnProceso
			from bp_empresa_buenaPractica E
			group by E.empresaId";

		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			if($linea['empresaId']==$id){
				$arrEmpresa=$linea;
			}else{
				$sumaEmpresas++;
				$sumaUnoTerminadas+=$linea['puntosUnoTerminadas'];
				$sumaUnoEnProceso+=$linea['puntosUnoEnProceso'];
				$sumaDosTerminadas+=$linea['puntosDosTerminadas'];
				$sumaDosEnProceso+=$linea['puntosDosEnProceso'];
				$sumaTresTerminadas+=$linea['puntosTresTerminadas'];
				$sumaTresEnProceso+=$linea['puntosTresEnProceso'];
			}
		}
		$promedioUnoTerminadas=$sumaUnoTerminadas/$sumaEmpresas;
		$promedioUnoEnProceso=$sumaUnoEnProceso/$sumaEmpresas;
		$promedioDosTerminadas=$sumaDosTerminadas/$sumaEmpresas;
		$promedioDosEnProceso=$sumaDosEnProceso/$sumaEmpresas;
		$promedioTresTerminadas=$sumaTresTerminadas/$sumaEmpresas;
		$promedioTresEnProceso=$sumaTresEnProceso/$sumaEmpresas;

		$arrTodasEmpresas=array('puntosUnoTerminadas'=>$promedioUnoTerminadas,
		                'puntosUnoEnProceso'=>$promedioUnoEnProceso,
		                'puntosDosTerminadas'=>$promedioDosTerminadas,
		                'puntosDosEnProceso'=>$promedioDosEnProceso,
		                'puntosTresTerminadas'=>$promedioTresTerminadas,
		                'puntosTresEnProceso'=>$promedioTresEnProceso,);

		$sql="select tipoRequisitoId,sum(puntosMaximos) as puntos
			  from bp_buenasPracticas group by tipoRequisitoId order by tipoRequisitoId";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			if($linea['tipoRequisitoId']==1){
				$arrTotalesPosibles['uno']=$linea['puntos'];
			}else if ($linea['tipoRequisitoId']==2){
				$arrTotalesPosibles['dos']=$linea['puntos'];
			}else{
				$arrTotalesPosibles['tres']=$linea['puntos'];
			}
		}
		$arrTmp['arrEmpresa']=$arrEmpresa;
		$arrTmp['arrTodasEmpresas']=$arrTodasEmpresas;
		$arrTmp['arrTotalesPosibles']=$arrTotalesPosibles;
		return($arrTmp);
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
		$arrTmp=array();


		// llenar array con datos empresas
		$sql="select id,nombreEmpresa,telefono,correos,mentorId,contactoNombre,usuario,clave from bp_empresas where mentorId=$mentorId";
		$resultado=$this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {
			$arrTmp[]=$fila;
		}

		// llenar array con datos de buenas practicas de cadaempresa
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
				bp_buenasPracticas.puntosMaximos as puntos,
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
				$sqlCriterios="select bp_empresa_buenaPractica_criterios.*, bp_criterios.nombre as criterioNombre,
							bp_criterios.descripcion as criterioDescripcion,bp_criterios.puntos as criterioPuntos,bp_criterios.orientacionMentor,
							bp_catStatus.nombre as nombreStatus
							from bp_empresa_buenaPractica_criterios
							left join bp_criterios on bp_criterios.id=bp_empresa_buenaPractica_criterios.criterioId
							left join bp_catStatus on bp_catStatus.id=bp_empresa_buenaPractica_criterios.estatusCriterio
							where bp_empresa_buenaPractica_criterios.empresa_buenaPracticaId=".$arrTmp[$x]['practicas'][$y]['empresaBuenaPracticaId']."
							order by bp_criterios.orden";
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
					$sqlEvidencias="select bp_evidencias .*, bp_catTipoEvento.nombre as nombreTipoEvento, bp_catStatus.nombre as nombreEstatus
						from bp_evidencias left join bp_catStatus on bp_catStatus.id=bp_evidencias.evidenciaStatus
						left join bp_catTipoEvento on bp_catTipoEvento.id=bp_evidencias.idTipoDeEvento
						where empresaPracticaCriteriosId=".$arrTmp[$x]['practicas'][$y]['criterios'][$z]['id'];
					$resultadoEvidencias=$this->db->query($sqlEvidencias);
					while($filaEvidencias=$resultadoEvidencias->fetch_assoc()){
						$arrTmpEvidencias[]=$filaEvidencias;
					}
					$arrTmp[$x]['practicas'][$y]['criterios'][$z]['evidencias']=$arrTmpEvidencias;
				}
			}
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Graba el cambio de estatus de una evidencia a vista (3) y pone la fecha de visualización
	 *
	 * @param $arrEmpresa
	 * @param $subItem
	 */
	function anotarAperturaEvidencia($arrEmpresa, $subItem)
	{
		$cachos=explode(';',$subItem);
		if($arrEmpresa['practicas'][$cachos['0']]['criterios'][$cachos['1']]['evidencias'][$cachos['2']]['evidenciaStatus']==2) {
			$idEvidencia = $arrEmpresa['practicas'][$cachos['0']]['criterios'][$cachos['1']]['evidencias'][$cachos['2']]['id'];
			$sql = "update bp_evidencias set fechaVisualizacion='".HOY."', evidenciaStatus=3 where id=$idEvidencia";
			$this->db->query($sql);
		}
	}

	/**
	 *
	 * Actualiza el estatus a 4 (aprobado) en las tablas bp_empresa_buenaPractica_criterios y bp_evidencias
	 * Agrega un registro al log de acciones
	 *
	 * @param $post
	 * @param $arrEmpresaSeleccionada
	 */
	function aprobarCriterio($post, $arrEmpresaSeleccionada)
	{
		$cachos=explode(';',$post['item']);
		$practicaItem=$cachos['0'];
		$criteriosItem=$cachos['1'];
		$criterioId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['id'];
		$nombreComentario="comentariosMentor".$post['item'];
		$sql="update bp_empresa_buenaPractica_criterios set  estatusCriterio=4, comentariosMentor='".$post[$nombreComentario]."', fechaEvaluacion='".HOY."' where  id=$criterioId";
		$this->db->query($sql);
		$sql="update bp_evidencias set evidenciaStatus=4,fechaEvaluacion='".HOY."' where empresaPracticaCriteriosId=$criterioId and evidenciaStatus<4";
		$this->db->query($sql);
		$mensaje="Se ha aprobado el criterio \"".
			$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['criterioNombre'].
			"\" de la práctica \"".$arrEmpresaSeleccionada['practicas'][$practicaItem]['nombrePractica']."\"";

		$this->agregarRegistroLog($arrEmpresaSeleccionada['id'], $arrEmpresaSeleccionada['mentorId'], $mensaje, 3);



	}

	/**
	 *
	 * Inserta registro en bp_empresa_buenaPractica_eventos con los datos de rechazo de la evidencia
	 *
	 * @param $item
	 * @param $arrEmpresaSeleccionada
	 */
	function rechazarCriterio($post, $arrEmpresaSeleccionada)
	{
		$cachos=explode(';',$post['item']);
		$practicaItem=$cachos['0'];
		$criteriosItem=$cachos['1'];
		$nombreComentario="comentariosMentor".$post['item'];

		//$evidenciasIitem=$cachos['2'];
		//$empresaBuenapracticaEventosId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['evidencias'][$evidenciasIitem]['empresaBuenapracticaEventosId'];
		$empresaBuenapracticaId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['empresaBuenaPracticaId'];
		$criterioId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['id'];

		// insertar registro de aprobacion en bp_empresa_buenaPractica_eventos

		$sql="update bp_empresa_buenaPractica_criterios set  estatusCriterio=5, comentariosMentor='".$post[$nombreComentario]."', fechaEvaluacion='".HOY."' where  id=$criterioId";
		$this->db->query($sql);
		$sql="update bp_evidencias set evidenciaStatus=5,fechaEvaluacion='".HOY."' where empresaPracticaCriteriosId=$criterioId";
		$this->db->query($sql);

		$mensaje="Se ha rechazado el criterio \"".
			$arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'][$criteriosItem]['criterioNombre'].
			"\" de la práctica \"".$arrEmpresaSeleccionada['practicas'][$practicaItem]['nombrePractica']."\"";

		$this->agregarRegistroLog($arrEmpresaSeleccionada['id'], $arrEmpresaSeleccionada['mentorId'], $mensaje, 3);
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
		$criterioItem=$cachos['1'];
		$empresaPracticaId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['empresaBuenaPracticaId'];
		$practicaId=$arrEmpresaSeleccionada['practicas'][$practicaItem]['buenapracticaId'];

		$sql="select count(*) as cuantosTerminados from bp_empresa_buenaPractica_criterios
			where empresa_buenaPracticaId=$empresaPracticaId && buenaPracticaId=$practicaId && estatusCriterio=4";
		$resultado=$this->db->query($sql);
		$fila = $resultado->fetch_assoc();
		if($fila['cuantosTerminados'] == count($arrEmpresaSeleccionada['practicas'][$practicaItem]['criterios'])){
			$sql2="update bp_empresa_buenaPractica set estatus=4,fechaAprobacion='".HOY."' where id=".$empresaPracticaId;
			$this->db->query($sql2);
		}
	}

	/**
	 *
	 * Graba los nuevos valores de usuario y clave en tabla bp_empresas
	 *
	 * @param $post
	 * @param $arrEmpresa
	 * @param $nombreDelMentor
	 * @param $correoDelMentor
	 */
	function grabarNuevaClave($post, $arrEmpresa,$nombreDelMentor,$correoDelMentor)
	{
		$correcto=1;
		if(strlen($post['usuario'])==0) $correcto=0;
		if(strlen($post['clave'])==0) $correcto=0;
		if($correcto==1){

			$claveModificada=$this->verificarModificacionDeClave('bp_empresas',$post['clave'],$arrEmpresa['id']);
			$lineaClave=($claveModificada==1)? "clave='".crypt($post['clave'],SALT)."'," : "";


			$sql="update bp_empresas set
				$lineaClave
				usuario='".$post['usuario']."'
				where id=".$arrEmpresa['id'];
			$this->db->query($sql);
			$enviado=$this->enviarCorreoAlta('editarEmpresa',$arrEmpresa['correos'],$arrEmpresa['contactoNombre'],
				$arrEmpresa['nombreEmpresa'],$post['usuario'],$post['clave'],$nombreDelMentor,$correoDelMentor);
		}
	}

	/**
	 *
	 * Agrega una nueva empresa a la tabla bp_empresas
	 *
	 * @param $post
	 * @param $mentorId
	 * @param $nombreDelMentor
	 * @param $correoDelMentor
	 */
	function agregarEmpresa($post, $mentorId, $nombreDelMentor, $correoDelMentor)
	{
		$correcto=1;
		if(strlen($post['nombreEmpresa'])==0) $correcto=0;
		if(strlen($post['contactoNombre'])==0) $correcto=0;
		if(strlen($post['correos'])==0) $correcto=0;
		if(strlen($post['usuario'])==0) $correcto=0;
		if(strlen($post['clave'])==0) $correcto=0;

		if($correcto==1){
			$sql="insert into bp_empresas SET
				nombreEmpresa='".$post['nombreEmpresa']."',
				contactoNombre='".$post['contactoNombre']."',
				correos='".$post['correos']."',
				usuario='".$post['usuario']."',
				clave='".crypt($post['clave'],SALT)."',
				mentorId='".$mentorId."'";
			$this->db->query($sql);
			$enviado=$this->enviarCorreoAlta('altaEmpresa',$post['correos'],$post['contactoNombre'],$post['nombreEmpresa'],$post['usuario'],
				$post['clave'],$nombreDelMentor,$correoDelMentor);
		}
	}

	/**
	 *
	 * Construye un arreglo de los eventos de un mentor acaecidos desde su ultimo login
	 *
	 * @param $id
	 * @param $ultimoLogin
	 *
	 * @return array
	 */
	function hacerArregloEventosNuevosDeMentor($id, $ultimoLogin)
	{
		$arrTmp=array();
		$sql="select bp_logActividades.* from bp_logActividades where fecha>'".$ultimoLogin."'
			and prioridad=3 and idEmpresa in(select id from bp_empresas where mentorId=$id)";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			$arrTmp[]=$linea;
		}
		return($arrTmp);
	}

	/**
	 *
	 * Construye el arreglo con los datos para la gráfica de la página de inicio de mentor
	 *
	 * @param $id
	 *
	 * @return array
	 */
	function hacerArregloGraficaMentor($id)
	{
		$arrTmp=array();
		$arrTotalesPosibles=array();
		$arrDatosEmpresaMentor=array();
		$sumaEmpresasMentor=0;
		$sumaEmpresasOtras=0;

		$sumaUnoTerminadas=0;
		$sumaDosTerminadas=0;
		$sumaTresTerminadas=0;

		$sumaUnoTodas=0;
		$sumaDosTodas=0;
		$sumaTresTodas=0;

		$sql0="select id from bp_empresas where mentorId=$id";
		$resultado0=$this->db->query($sql0);
		while($linea0=$resultado0->fetch_assoc()){
			$arrDatosEmpresaMentor[]=$linea0['id'];
		}
		$sql="select E.empresaId,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=1
			group by E2.empresaId) as puntosUnoTerminadas,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=2
			group by E2.empresaId) as puntosDosTerminadas,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=3
			group by E2.empresaId) as puntosTresTerminadas
			from bp_empresa_buenaPractica E
			group by E.empresaId";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			if(in_array($linea['empresaId'], $arrDatosEmpresaMentor)){
				$sumaEmpresasMentor++;
				$sumaUnoTerminadas+=$linea['puntosUnoTerminadas'];
				$sumaDosTerminadas+=$linea['puntosDosTerminadas'];
				$sumaTresTerminadas+=$linea['puntosTresTerminadas'];
			}else{
				$sumaEmpresasOtras++;
				$sumaUnoTodas+=$linea['puntosUnoTerminadas'];
				$sumaDosTodas+=$linea['puntosDosTerminadas'];
				$sumaTresTodas+=$linea['puntosTresTerminadas'];
			}
		}
		if($sumaEmpresasMentor>0) {
			$promedioUnoTerminadas = $sumaUnoTerminadas / $sumaEmpresasMentor;
			$promedioDosTerminadas = $sumaDosTerminadas / $sumaEmpresasMentor;
			$promedioTresTerminadas = $sumaTresTerminadas / $sumaEmpresasMentor;
		}else{
			$promedioUnoTerminadas = 0;
			$promedioDosTerminadas = 0;
			$promedioTresTerminadas = 0;
		}
		if($sumaEmpresasOtras>0) {
			$promedioUnoTodas = $sumaUnoTodas / $sumaEmpresasOtras;
			$promedioDosTodas = $sumaDosTodas / $sumaEmpresasOtras;
			$promedioTresTodas = $sumaTresTodas / $sumaEmpresasOtras;
		}else{
			$promedioUnoTodas =0;
			$promedioDosTodas =0;
			$promedioTresTodas=0;
		}

		$sql="select tipoRequisitoId,sum(puntosMaximos) as puntos
			  from bp_buenasPracticas group by tipoRequisitoId order by tipoRequisitoId";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			if($linea['tipoRequisitoId']==1){
				$arrTotalesPosibles['uno']=$linea['puntos'];
			}else if ($linea['tipoRequisitoId']==2){
				$arrTotalesPosibles['dos']=$linea['puntos'];
			}else{
				$arrTotalesPosibles['tres']=$linea['puntos'];
			}
		}

		$arrTmp['arrMentor']=array('promedioUno'=>$promedioUnoTerminadas,'promedioDos'=>$promedioDosTerminadas,'promedioTres'=>$promedioTresTerminadas);
		$arrTmp['arrTodas']=array('promedioUno'=>$promedioUnoTodas,'promedioDos'=>$promedioDosTodas,'promedioTres'=>$promedioTresTodas);
		$arrTmp['arrTotalesPosibles']=$arrTotalesPosibles;

		return($arrTmp);

	}

	// funciones de admon

	/**
	 *
	 * Busca en tabla bp_personal y hace un arreglo de todos los registros de personal
	 * Se usa en admon.
	 *
	 * @param $admon
	 *
	 * @return array
	 */
	function hacerArregloPersonal($admon)
	{
		$arrTmp=array();
		$sql="select * from bp_personal where superiorId=".$admon->id;

		$resultado=$this->db->query($sql);
		while($fila=$resultado->fetch_assoc()){
			$arrTmp[]=$fila;
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Construye el arreglo con los datos para la gráfica de la página de inicio administrador
	 *
	 * @param $nivel
	 * @param $idPersonal
	 *
	 * @return array
	 */
	function hacerArregloEstadisticasEmpresas($nivel, $idPersonal)
	{

		$arrTmp=array();
		$arrTotalesPosibles=array();
		$arrDatosEmpresaAdmin=array();
		$sumaEmpresasAdmin=0;
		$sumaEmpresasOtras=0;

		$sumaUnoTerminadas=0;
		$sumaDosTerminadas=0;
		$sumaTresTerminadas=0;

		$sumaUnoTodas=0;
		$sumaDosTodas=0;
		$sumaTresTodas=0;

		if($nivel==2){
			$txtMentoresId='';
			$sql00="select id from bp_personal  where superiorId=$idPersonal";
			$resultado00=$this->db->query($sql00);
			while($linea00=$resultado00->fetch_assoc()){
				if(strlen($txtMentoresId)>0) $txtMentoresId.=",";
				$txtMentoresId.=$linea00['id'];
			}
			if(strlen($txtMentoresId)>0) {
				$sql0 = "select id from bp_empresas where mentorId in ($txtMentoresId)";
				$resultado0 = $this->db->query($sql0);
				while ($linea0 = $resultado0->fetch_assoc()) {
					$arrDatosEmpresaAdmin[] = $linea0['id'];
				}
			}else{
				$arrDatosEmpresaAdmin=array();
			}
		}

		$sql="select E.empresaId,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=1
			group by E2.empresaId) as puntosUnoTerminadas,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=2
			group by E2.empresaId) as puntosDosTerminadas,
			(select sum(B.puntosMaximos)
			from bp_buenasPracticas B, bp_empresa_buenaPractica E2
			where B.id=E2.buenasPracticasId and E2.estatus=4 and E2.empresaId=E.empresaId and B.tipoRequisitoId=3
			group by E2.empresaId) as puntosTresTerminadas
			from bp_empresa_buenaPractica E
			group by E.empresaId";
		$resultado=$this->db->query($sql);

		while($linea=$resultado->fetch_assoc()){
			if(in_array($linea['empresaId'], $arrDatosEmpresaAdmin)){
				$sumaEmpresasAdmin++;
				$sumaUnoTerminadas+=$linea['puntosUnoTerminadas'];
				$sumaDosTerminadas+=$linea['puntosDosTerminadas'];
				$sumaTresTerminadas+=$linea['puntosTresTerminadas'];
			}else{
				$sumaEmpresasOtras++;
				$sumaUnoTodas+=$linea['puntosUnoTerminadas'];
				$sumaDosTodas+=$linea['puntosDosTerminadas'];
				$sumaTresTodas+=$linea['puntosTresTerminadas'];
			}
		}
		if($sumaEmpresasAdmin>0) {
			$promedioUnoTerminadas = $sumaUnoTerminadas / $sumaEmpresasAdmin;
			$promedioDosTerminadas = $sumaDosTerminadas / $sumaEmpresasAdmin;
			$promedioTresTerminadas = $sumaTresTerminadas / $sumaEmpresasAdmin;
		}else{
			$promedioUnoTerminadas = 0;
			$promedioDosTerminadas = 0;
			$promedioTresTerminadas = 0;
		}
		if($sumaEmpresasOtras>0) {
			$promedioUnoTodas = $sumaUnoTodas / $sumaEmpresasOtras;
			$promedioDosTodas = $sumaDosTodas / $sumaEmpresasOtras;
			$promedioTresTodas = $sumaTresTodas / $sumaEmpresasOtras;
		}else{
			$promedioUnoTodas =0;
			$promedioDosTodas =0;
			$promedioTresTodas=0;
		}

		$sql="select tipoRequisitoId,sum(puntosMaximos) as puntos
			  from bp_buenasPracticas group by tipoRequisitoId order by tipoRequisitoId";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			if($linea['tipoRequisitoId']==1){
				$arrTotalesPosibles['uno']=$linea['puntos'];
			}else if ($linea['tipoRequisitoId']==2){
				$arrTotalesPosibles['dos']=$linea['puntos'];
			}else{
				$arrTotalesPosibles['tres']=$linea['puntos'];
			}
		}

		$arrTmp['arrAdmin']=array('promedioUno'=>$promedioUnoTerminadas,'promedioDos'=>$promedioDosTerminadas,'promedioTres'=>$promedioTresTerminadas);
		$arrTmp['arrTodas']=array('promedioUno'=>$promedioUnoTodas,'promedioDos'=>$promedioDosTodas,'promedioTres'=>$promedioTresTodas);
		$arrTmp['arrTotalesPosibles']=$arrTotalesPosibles;

		return($arrTmp);
	}

	/**
	 *
	 * Hace un arreglo para representar los avances en la seccion derecha de administrador
	 *
	 * @param $nivel
	 * @param $idPersonal
	 *
	 * @return array
	 */
	function hacerArregloEstadisticasPracticas($nivel, $idPersonal)
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
					'completadasTotal'=>'',
					'completadasRegional'=>'',
					'enProcesoTotal'=>'',
					'enProcesoRegional'=>'',
				);


			}else{
				$arrTmpSub[]=array(
					'idPractica' => $fila['id'],
					'nombrePractica' => $fila['titulo'],
					'completadasTotal'=>'',
					'completadasRegional'=>'',
					'enProcesoTotal'=>'',
					'enProcesoRegional'=>'',
				);
			}
		}
		$arrTmp[] = array(
			'idCategoria' => $categoriaSel,
			'nombreCategoria' => $nombreCategoriaSel,
			'practicas' => $arrTmpSub
		);
		$tamanoMaximo=0;

		$sql="select buenasPracticasId, count(*) as cuantos from bp_empresa_buenaPractica where estatus=4 group by buenasPracticasId";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			if($linea['cuantos']>$tamanoMaximo) $tamanoMaximo=$linea['cuantos'];
			for($x=0;$x<count($arrTmp);$x++){
				for($y=0;$y<count($arrTmp[$x]['practicas']);$y++){
					if($arrTmp[$x]['practicas'][$y]['idPractica']==$linea['buenasPracticasId']) $arrTmp[$x]['practicas'][$y]['completadasTotal']=$linea['cuantos'];
				}
			}
		}

		$sql="select buenasPracticasId, count(*) as cuantos from bp_empresa_buenaPractica where estatus=2 group by buenasPracticasId";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			if($linea['cuantos']>$tamanoMaximo) $tamanoMaximo=$linea['cuantos'];
			for($x=0;$x<count($arrTmp);$x++){
				for($y=0;$y<count($arrTmp[$x]['practicas']);$y++){
					if($arrTmp[$x]['practicas'][$y]['idPractica']==$linea['buenasPracticasId']) $arrTmp[$x]['practicas'][$y]['enProcesoTotal']=$linea['cuantos'];
				}
			}
		}

		if($nivel==2) {

			$sql = "select buenasPracticasId, count(*) as cuantos from bp_empresa_buenaPractica where estatus=4
				and empresaId in (select id from bp_empresas where mentorId in (select Id from bp_personal where superiorId=$idPersonal))
				group by buenasPracticasId";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				if($linea['cuantos']>$tamanoMaximo) $tamanoMaximo=$linea['cuantos'];
				for($x=0;$x<count($arrTmp);$x++){
					for($y=0;$y<count($arrTmp[$x]['practicas']);$y++){
						if($arrTmp[$x]['practicas'][$y]['idPractica']==$linea['buenasPracticasId']) $arrTmp[$x]['practicas'][$y]['completadasRegional']=$linea['cuantos'];
					}
				}
			}

			$sql = "select buenasPracticasId, count(*) as cuantos from bp_empresa_buenaPractica where estatus=2
				and empresaId in (select id from bp_empresas where mentorId in (select Id from bp_personal where superiorId=$idPersonal))
				group by buenasPracticasId";
			$resultado=$this->db->query($sql);
			while($linea=$resultado->fetch_assoc()){
				if($linea['cuantos']>$tamanoMaximo) $tamanoMaximo=$linea['cuantos'];
				for($x=0;$x<count($arrTmp);$x++){
					for($y=0;$y<count($arrTmp[$x]['practicas']);$y++){
						if($arrTmp[$x]['practicas'][$y]['idPractica']==$linea['buenasPracticasId']) $arrTmp[$x]['practicas'][$y]['enProcesoRegional']=$linea['cuantos'];
					}
				}
			}

		}
		$arrTmp['tamanoMaximo']=$tamanoMaximo;
		return ($arrTmp);
	}

	/**
	 *
	 * Valida la corrección de los datos de una persona.
	 * Si son correctos y el registro es de una nueva persona agrega un registro a la tabla bp_personal.
	 * Si son correctos y el registro es de una persona existente hace el update del registro en la tabla bp_personal
	 *
	 * @param $arrDatosPersona
	 * @param $nivel
	 * @param $nombreAdmin
	 * @param $correoAdmin
	 * @param $region
	 *
	 * @return int
	 */
	function validarDatosPersona($arrDatosPersona, $nivel, $nombreAdmin, $correoAdmin, $region)
	{
		// TODO: Definir correctamente las validaciones por hacer
		$correcto=1;
		if(strlen($arrDatosPersona['nombre'])==0) $correcto=0;
		if(strlen($arrDatosPersona['usuario'])==0) $correcto=0;
		if(strlen($arrDatosPersona['clave'])==0) $correcto=0;
		if(strlen($arrDatosPersona['email'])==0) $correcto=0;
		if($nivel==1) {
			if(strlen($arrDatosPersona['region'])==0) $correcto=0;
		}else{
			$arrDatosPersona['region']='';
		}

		if($arrDatosPersona['correoNotificacionCadaXHoras']<1) $correcto=0;

		if($correcto){
			if($arrDatosPersona['id']=='nuevo') {
				$sql = "INSERT INTO bp_personal SET
					nombre='".$arrDatosPersona['nombre']."',
					usuario='".$arrDatosPersona['usuario']."',
					clave='".crypt($arrDatosPersona['clave'],SALT)."',
					email='".$arrDatosPersona['email']."',
					region='".$arrDatosPersona['region']."',
					nivelId='".$arrDatosPersona['nivelId']."',
					superiorId='".$arrDatosPersona['superiorId']."',
					fechaCreado='".HOY."',
					fechaClaveUpdate='".HOY."',
					nota='".$arrDatosPersona['nota']."',
					correoNotificacionCadaXHoras='".$arrDatosPersona['correoNotificacionCadaXHoras']."'";
				if($arrDatosPersona['nivelId']==3) $modalidad='agregarMentor';
				if($arrDatosPersona['nivelId']==2) $modalidad='agregarAdmonRegional';
			} else {

				$sql="select usuario,clave from bp_personal where id=".$arrDatosPersona['id'];
				$resultado=$this->db->query($sql);
				$linea=$resultado->fetch_assoc();

				$textoClave=($linea['clave']!=$arrDatosPersona['clave'])? "clave='".crypt($arrDatosPersona['clave'],SALT)."'," : "";

				$variableFechaClaveUpdate=($linea['usuario']!=$arrDatosPersona['usuario'] || $linea['clave']!=$arrDatosPersona['clave']) ?
					"fechaClaveUpdate='".HOY."'," : "";


				$sql = "update bp_personal SET
					nombre='".$arrDatosPersona['nombre']."',
					usuario='".$arrDatosPersona['usuario']."',
					$textoClave
					email='".$arrDatosPersona['email']."',
					region='".$arrDatosPersona['region']."',
					$variableFechaClaveUpdate
					nota='".$arrDatosPersona['nota']."',
					correoNotificacionCadaXHoras='".$arrDatosPersona['correoNotificacionCadaXHoras']."' where id=".$arrDatosPersona['id'];

				if($arrDatosPersona['nivelId']==3) $modalidad='actualizarMentor';
				if($arrDatosPersona['nivelId']==2) $modalidad='actualizarAdmonRegional';
				//$modalidad='actualizarMentor';
			}
			$this->db->query($sql);

			$this->enviarCorreoAlta($modalidad,$arrDatosPersona['email'],$arrDatosPersona['nombre'],'',
				$arrDatosPersona['usuario'],$arrDatosPersona['clave'],$nombreAdmin,$correoAdmin,$region);

		}
		return ($correcto);
	}

	/**
	 *
	 * genera un string de formato GeoJson para desplegar empresas en el mapa
	 *
	 * @param $nivel
	 * @param $personalId
	 *
	 * @return string
	 */
	function hacerGeoJSONparaMapa($nivel, $personalId)
	{

		$geojson = array(
			'type'      => 'FeatureCollection',
			'features'  => array()
		);

		if($nivel==2){
			$sql="select *, X(ubicacion) as latitud,Y(ubicacion) as longitud
				from bp_empresas where mentorId in (select id from bp_personal where superiorId=$personalId)";
		}else {
			$sql="select *, X(ubicacion) as latitud, Y(ubicacion) as longitud from bp_empresas";
		}

		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			$propiedades = $linea;
			// quita las columnas extra de latitud y longitud del set de propiedades
			unset($propiedades['latitud']);
			unset($propiedades['longitud']);
			unset($propiedades['ubicacion']);
			$feature = array(
				'type' => 'Feature',
				'geometry' => array(
					'type' => 'Point',
					'coordinates' => array(
						$linea['latitud'],
						$linea['longitud']
					)
				),
				'properties' => $propiedades
			);
			// agrega el array $feature al arreglo $geojson
			array_push($geojson['features'], $feature);
		}
		//print "<pre>";
		//	echo "<br>geoJson  <BR>";
		//	print_r($geojson);
		//print "</pre>";
		return json_encode($geojson, JSON_NUMERIC_CHECK);
	}

	/**
	 *
	 * Cambia empresas de un mentor a otro
	 *
	 * @param $donador
	 * @param $receptor
	 */
	function transferirEmpresas($post,$receptor)
	{
		$txtId='';
		foreach($post as $clave=>$valor){
			if(substr($clave,0,6)=="chBox_"){
				$id=substr($clave,6);
				if(strlen($txtId)>0) $txtId.=",";
				$txtId.=$id;
			}
		}
		$txtId="(".$txtId.")";
		$sql="update bp_empresas set mentorId=$receptor where id in $txtId";
		$this->db->query($sql);
	}

	/**
	 *
	 * Hace un arreglo id, nombre de empresa para la pantalla de transferencia de empresas a otro mentor
	 *
	 * @param $donadorId
	 *
	 * @return array
	 */
	function hacerArrEmpresasDeMentorDonador($donadorId)
	{
		$arrTmp=array();
		$sql="select id, nombreEmpresa from bp_empresas where mentorId=$donadorId";
		$resultado=$this->db->query($sql);
		while($linea=$resultado->fetch_assoc()){
			$arrTmp[]=$linea;
		}
		return($arrTmp);
	}

}
