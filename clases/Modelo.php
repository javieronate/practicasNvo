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
	var $db;

	/**
	 * Almacena objeto de tipo compania
	 */
	var $compania;

	/**
	 * Almacena arreglo con los datos del usuario que ingreso
	 */
	var $arrUsuarioLogueado = array();

	var $arrCategorias=array();


	/**
	 * Almacena arreglo con las buenas practicas
	 */
	var $arrBuenasPracticas = array();

	var $arrPracticaDescripcion = array();

	///////////////////////////////////////////



	/**
	 * Arreglo de los reportes disponibles. Se usa en el menú Selección de reporte
	 */
    var $arrReportes=array();

    // catalogos
	/**
	 * Almacena arreglo pequeño (id, nombre) de campos habilitados para filtros
	 */
    var $arrListaCatalogos=array();

	/**
	 * Almacena arreglo completo de campos habilitados y las variables necesarias en la construcción del sql y de filtros
	 */
	var $arrCatalogoCampos=array();

	/**
	 * Almacena arreglo completo de los datos incluidos en cada catalogo
	 * Se usa como fuente para llenar el arreglo arrComboFiltro que despliega las opciones de filtrado
	 */
	var $arrDatosCampos=array();

    // arreglos de busquedas
	/**
	 * Arreglo para almacenar las sentencias de join para construcción del query
	 */
    var $arrJoins=array();

	// TODO: si no se usa en otro lado quitarlo de la clase y dejarla como variable interna de la función
	/**
	 * Arreglo de campos de validación
	 */
    var $arrCamposDeValidacion=array(); // se usa para poner etiqueta totales donde se debe

	/**
	 * Arreglo que almacena todas las columnas del reporte y sus características de visibilidad y tipo de columna
	 */
    var $arrColumnas=array();

	/**
	 * Arreglo que almacena todos los datos de la estructura del reporte seleccionado
	 * de acuerdo a la información almacenada en las tablas de definición
	 */
    var $estructuraReporte=array();

	/**
	 * Variable que almacena el string construido para hacer el query
	 */
    var $sql;

	/**
	 * Arreglo que contiene el resultado del query
	 */
    var $resultadoBusqueda=array();

    // filtros
	/**
	 * Arreglo que almacena los campos del filtrado y los valores seleccionadas para cada uno
	 */
    var $arrFiltros=array();

	/**
	 * Arreglo que almacena las opciones a desplegar en el menú de selección multiple de filtrado
	 */
	var $arrComboFiltro=array();

	/**
	 * Variable que almacena el string que reduce las opciones en el menu de filtrado
	 */
	var $strAcotarOpciones;

	/**
	 * Variable que almacena el campo activo en el menu de filtrado
	 */
	var $campoActivoEnFiltro;

	var $arrDatosCamposNvo;

	var $arrTablasTemporales=array();

	var $arrStringWhereDeTablasMultiples=array();



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
//		$this->arrBuenasPracticas = $this->hacerArregloBuenasPracticas();

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
		}else{
			// buscar si es usuario de personal
			$sql = "select count(*)as cuantos from bp_personal where usuario ='".$usuario."' and clave='".$clave."'";
			$resultado = $this->db->query($sql);
			$datos = $resultado->fetch_assoc();
			if($datos['cuantos']==1) {
				$sql2 = "select * from bp_personal where usuario ='" . $usuario . "' and clave='" . $clave . "'";
				$resultado2 = $this->db->query($sql2);
				$datos2 = $resultado2->fetch_assoc();
//				if($datos2['esSuperAdmin']==1) {
//					$rol='administrador';
//				}else{
//					$rol='mentor';
//				}
				$arrTmp['rol'] =  $datos2['esSuperAdmin']==1 ? 'administrador' :'mentor';
				$arrTmp['id'] = $datos2['id'];
				$arrTmp['nombre'] = $datos2['nombre'];
				$arrTmp['email'] = $datos2['email'];
				$arrTmp['esSuperAdmin'] = $datos2['esSuperAdmin'];

			}else{
				$arrTmp['rol'] = "fallo";
			}
		}
		return($arrTmp);
	}



	// funciones por usarse




	/**
	 *
	 * llena el arreglo de buenas practicas
	 *
	 * no se usa aun
	 *
	 * @return array
	 */
	function hacerArregloBuenasPracticas()
	{
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
		        );


	        }else{
		        $arrTmpSub[]=array(
			        'idPractica' => $fila['id'],
			        'nombrePractica' => $fila['titulo'],
		        );
	        }
        }
		$arrTmp[] = array(
			'idCategoria' => $categoriaSel,
			'nombreCategoria' => $nombreCategoriaSel,
			'practicas' => $arrTmpSub
		);
        return ($arrTmp);
	}

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
//		print "<pre>";
//		echo "<br>buena practica  fila<BR>";
//		print_r($this->arrPracticaDescripcion);
//		print "</pre>";
	}





	/////////////////////////////////////////////////////////////////////////////////

	// funciones legacy
    // llenar catalogos
	/**
	 *
	 *  Inicializa y puebla los catálogos requeridos para los filtros y para los reportes
	 *
	 */
	function llenarCatalogos()
    {
//        if(count($this->arrReportes)==0) $this->arrReportes=$this->llenarCatalogoReportes();
//        if(count($this->arrCatalogoCampos)==0) $this->arrCatalogoCampos=$this->llenarCatalogoCampos();
//		//if(count($this->arrDatosCampos)==0) $this->arrDatosCampos=$this->llenarDatosCampos();
//        if(count($this->arrListaCatalogos)==0) $this->arrListaCatalogos=$this->llenarArrListaCatalogos();
    }

	/**
	 *
	 * Inicializa y puebla el catálogo de reportes
	 *
	 * @return array
	 */
	function llenarCatalogoReportes()
    {
//        $arrTmp=array();
//        $resultado = $this->db->query("SELECT * FROM jomReportes ORDER BY id");
//        //$resultado->data_seek(0);
//        while ($fila = $resultado->fetch_assoc()) {
//            $arrTmp[]=array('id'=>$fila['id'],'nombre'=>$fila['nombre'], 'tablaFuente'=>$fila['tablaFuente'],'valorRepresentar'=>$fila['valorRepresentar']);
//        }
//        return ($arrTmp);
    }

	/**
	 *
	 * Inicializa y puebla el catalogo de opciones de filtrado
	 *
	 *@return array
	 *
	 *
*/
	function llenarCatalogoCampos()
	{
		$arrTmp=array();
		$resultado = $this->db->query("SELECT * FROM jomCatalogoCampos ORDER BY id");
		//$resultado->data_seek(0);
		while ($fila = $resultado->fetch_assoc()) {
			$arrTmp[]=$fila;
		}
		return ($arrTmp);
	}

	/**
	 *
	 * Llena el arreglo corto arrListaCatalogos para desplegar en el menu de filtros
	 *
	 */
	function llenarArrListaCatalogos()
	{
		$arrTmp=array();
		for($x=0;$x<count($this->arrCatalogoCampos);$x++){
			$arrTmp[]=array('id'=>$this->arrCatalogoCampos[$x]['nombre'],'nombre'=>$this->arrCatalogoCampos[$x]['etiqueta']);
		}
		return($arrTmp);
	}


	function llenarDatosCamposDeReporte()
	{
		$arrTmpCompleto=array();
		for($x=1;$x<=count($this->estructuraReporte['col']);$x++){
			if(!isset($this->arrDatosCampos[$this->estructuraReporte['col'][$x]['identificador']])){
				for($y=0;$y<count($this->arrCatalogoCampos);$y++){
					if($this->arrCatalogoCampos[$y]['nombre']==$this->estructuraReporte['col'][$x]['identificador']){
						$arrTmp= $this->llenarCatalogoIndividual($this->arrCatalogoCampos[$y]['tablaCatalogo'],
														$this->arrCatalogoCampos[$y]['idTablaCatalogo'],
														$this->arrCatalogoCampos[$y]['descripcionTablaCatalogo'],
														$this->arrCatalogoCampos[$y]['campoEnCatalogoQueLigaConAgrupacion']);
						$arrTmpCompleto[$this->arrCatalogoCampos[$y]['nombre']]=$arrTmp;
					}
				}
			}
		}
		for($x=1;$x<=count($this->estructuraReporte['reng']);$x++){
			if(!isset($this->arrDatosCampos[$this->estructuraReporte['reng'][$x]['identificador']])){
				for($y=0;$y<count($this->arrCatalogoCampos);$y++){
					if($this->arrCatalogoCampos[$y]['nombre']==$this->estructuraReporte['reng'][$x]['identificador']){
						$arrTmp= $this->llenarCatalogoIndividual($this->arrCatalogoCampos[$y]['tablaCatalogo'],
														$this->arrCatalogoCampos[$y]['idTablaCatalogo'],
														$this->arrCatalogoCampos[$y]['descripcionTablaCatalogo'],
														$this->arrCatalogoCampos[$y]['campoEnCatalogoQueLigaConAgrupacion']);
						$arrTmpCompleto[$this->arrCatalogoCampos[$y]['nombre']]=$arrTmp;
					}
				}
			}
		}
		return ($arrTmpCompleto);
	}

	function revisarExistenciaEnArrDatosCampos()
	{
		if(!isset($this->arrDatosCampos[$this->campoActivoEnFiltro])){
			for($x=0;$x<count($this->arrCatalogoCampos);$x++){
				if($this->arrCatalogoCampos[$x]['nombre']==$this->campoActivoEnFiltro){
					$arrTmp = $this->llenarCatalogoIndividual($this->arrCatalogoCampos[$x]['tablaCatalogo'],
															$this->arrCatalogoCampos[$x]['idTablaCatalogo'],
															$this->arrCatalogoCampos[$x]['descripcionTablaCatalogo'],
															$this->arrCatalogoCampos[$x]['campoEnCatalogoQueLigaConAgrupacion']);
					$this->arrDatosCampos[$this->arrCatalogoCampos[$x]['nombre']]=$arrTmp;
				}
			}
		}
	}

	function borrarDatosDeReporte()
	{
		for($x=1;$x<=count($this->estructuraReporte['col']);$x++){
			$borrar=1;
			for($y=0;$y<count($this->arrFiltros);$y++){
				if($this->arrFiltros[$y]['campo']==$this->estructuraReporte['col'][$x]['identificador']) $borrar=0;
			}
			if($borrar==1) unset($this->arrDatosCampos[$this->estructuraReporte['col'][$x]['identificador']]);
		}

		for($x=1;$x<=count($this->estructuraReporte['reng']);$x++){
			$borrar=1;
			for($y=0;$y<count($this->arrFiltros);$y++){
				if($this->arrFiltros[$y]['campo']==$this->estructuraReporte['reng'][$x]['identificador']) $borrar=0;
			}
			if($borrar==1) unset($this->arrDatosCampos[$this->estructuraReporte['reng'][$x]['identificador']]);
		}

	}

	function borrarSiNoEstaEnCamposReporte($campoAnterior)
	{
		$borrar=1;
		for($x=1;$x<=count($this->estructuraReporte['col']);$x++){
			if($this->estructuraReporte['col'][$x]['identificador']==$campoAnterior) $borrar=0;
		}
		for($x=1;$x<=count($this->estructuraReporte['reng']);$x++){
			if($this->estructuraReporte['reng'][$x]['identificador']==$campoAnterior) $borrar=0;
		}
		if($borrar==1) unset($this->arrDatosCampos[$campoAnterior]);
	}

	/**
	 *
	 * Llena el catalogo arrDatosCampos con todos los datos para cada catalogo a usar en los filtros
	 *
	 * Para cada catalogo llama a la función llenarCatalogoIndividual e inserta su resultado en arrDatosCampos
	 *
	 * @return array
	 *
	 * borrar
	 */
	function llenarDatosCampos()
	{
		$arrTmpCompleto=array();
		for($x=0;$x<count($this->arrCatalogoCampos);$x++){
			$arrTmp= $this->llenarCatalogoIndividual($this->arrCatalogoCampos[$x]['tablaCatalogo'],
													$this->arrCatalogoCampos[$x]['idTablaCatalogo'],
													$this->arrCatalogoCampos[$x]['descripcionTablaCatalogo'],
													$this->arrCatalogoCampos[$x]['campoEnCatalogoQueLigaConAgrupacion']);
			$arrTmpCompleto[$this->arrCatalogoCampos[$x]['nombre']]=$arrTmp;
		}
		return ($arrTmpCompleto);
	}

	/**
	 *
	 * llena un arreglo temporal con todos los valores de datos del catalogo solicitado
	 *
	 * @param $tabla
	 * @param $campoId
	 * @param $campoNombre
	 * @param $campoEnCatalogoQueLigaConAgrupacion
	 *
	 *  @var mysqli_result $resultado
	 *
	 *@return array
	 */
	function llenarCatalogoIndividual($tabla,$campoId,$campoNombre,$campoEnCatalogoQueLigaConAgrupacion)
	{
		$arrTmp=array();


		if($campoEnCatalogoQueLigaConAgrupacion == 'noAplica') $campoEnCatalogoQueLigaConAgrupacion="'noAplica'";
		$sql="select $campoId as id, $campoNombre as nombre, $campoEnCatalogoQueLigaConAgrupacion as grupo from $tabla order by id";
		$resultado = $this->db->query($sql);
		//$resultado->data_seek(0);
		while ($fila = $resultado->fetch_assoc()) {
			$arrTmp[]=$fila;
		}
		return ($arrTmp);
	}

    // modelaje reporte
	/**
	 *
	 * Construye descripción del reporte seleccionado en arreglo estructuraReporte
	 *
	 * @param $id
	 */
	function construirReporte($id)
    {
        $resultado = $this->db->query("select * from jomReportes where id=$id");
        $fila = $resultado->fetch_assoc();
        $arrTmp=array('id'=>$fila['id'],'nombre'=>$fila['nombre'],'tablaFuente'=>$fila['tablaFuente'],
            'valorRepresentar'=>$fila['valorRepresentar'],'campoRepresentar'=>$fila['campoRepresentar']);
        $resultado2= $this->db->query("select * from jomReportesDetalle where idJomReportes=$id order by columnaRenglon,orden");
        while ($fila2 = $resultado2->fetch_assoc()) {
            for($x=0;$x<count($this->arrCatalogoCampos);$x++){
                if($this->arrCatalogoCampos[$x]['id']==$fila2['idJomCatalogoCampos']) {
	                $arrTmp[$fila2['columnaRenglon']] [$fila2['orden']] ['tablaMaestra']=$this->arrCatalogoCampos[$x]['tablaConLaQueLiga'];
	                $arrTmp[$fila2['columnaRenglon']] [$fila2['orden']] ['campoEnTabla']=$this->arrCatalogoCampos[$x]['campoEnTablaConLaQueLiga'];
	                $arrTmp[$fila2['columnaRenglon']] [$fila2['orden']] ['nombreTablaCatalogo']=$this->arrCatalogoCampos[$x]['tablaCatalogo'];
	                $arrTmp[$fila2['columnaRenglon']] [$fila2['orden']] ['nombreCampoLlaveCatalogo']=$this->arrCatalogoCampos[$x]['idTablaCatalogo'];
	                $arrTmp[$fila2['columnaRenglon']] [$fila2['orden']] ['nombreCampoDescripcionCatalogo']=$this->arrCatalogoCampos[$x]['descripcionTablaCatalogo'];
	                $arrTmp[$fila2['columnaRenglon']] [$fila2['orden']] ['etiqueta']=$this->arrCatalogoCampos[$x]['etiqueta'];
	                $arrTmp[$fila2['columnaRenglon']] [$fila2['orden']] ['identificador']=$this->arrCatalogoCampos[$x]['nombre'];
                }
            }
        }
        $this->estructuraReporte=$arrTmp;
    }

	/**
	 *
	 * Construye sentencia sql para el reporte seleccionado y las variables de filtrado
	 *
	 * Pasos que sigue:
	 * - Inicializa arreglos arrJoins, arrColumnas, $arrIdDescColumnasTmp
	 * - Llena el arreglo $arrIdDescColumnasTmp con las columnas obtenidas de la tabla del catalogo
	 * - A través de la función asociarColumnasConFiltros revisa si un filtro solo requiere parte de las opciones
	 *   obtenidas antes y en su caso elimina las columnas redundantes
	 * - A través de la función hacerStringWhere llena la variable $stringWhere con las condiciones de filtrado
	 * - Construye query interno:
	 *      - Define las sentencias join que en su caso se requieren dependiendo de los campos a incluir
	 *          y de los filtros seleccionados a través de la función definirTablaFuenteAlternativa
	 *      - Construye el arreglo de las columnas a incluir para las agrupaciones de renglones y
	 *          los strings a incluir en en el query
	 *      - Construye la sentencia de suma, conteo o porcentaje para cada columna
	 *      - A través de la función hacerStringJoins construye el string de joins
	 *      - Integra en $sqlInternoCompleto la sentencia de query interno
	 * - Construye query externo:
	 *      - Hace string de las columnas de agrupación
	 *      - Hace string de sumas para cada columna y de la suma total del renglón
	 * - Construye string completo a ejecutar y lo guarda en la variable sql
	 *
	 */
	function construirSql()
    {
		// seccion de join requeridos
		$tablaFuente=$this->estructuraReporte['tablaFuente'];

		// hace un arreglo de tablas involucradas y sus relaciones con tablas maestras
		$arrTablasInvolucradas=$this->hacerArrayDeTablasInvolucradas();

		$this->arrJoins=array();
        $this->arrColumnas=array();

        // hace un arreglo con todas las sentencias join necesarias
		$stringJoins=$this->hacerSeccionJoins($tablaFuente,$arrTablasInvolucradas);

		// verifica si en el arreglo de strings extras de tablas multiples hay repetidos y los elimina
		$arrTmpDeStringsWhereDeTablasMultiples=array();
		for($x=0;$x<count($this->arrStringWhereDeTablasMultiples);$x++){
			if(!in_array($this->arrStringWhereDeTablasMultiples[$x],$arrTmpDeStringsWhereDeTablasMultiples)){
				$arrTmpDeStringsWhereDeTablasMultiples[]=$this->arrStringWhereDeTablasMultiples[$x];
			}
		}
		$this->arrStringWhereDeTablasMultiples=$arrTmpDeStringsWhereDeTablasMultiples;
		$stringExtraDeTablasMultiples="";
		for($x=0;$x<count($this->arrStringWhereDeTablasMultiples);$x++){
			if(strlen($stringExtraDeTablasMultiples)>0) $stringExtraDeTablasMultiples.=" and ";
			$stringExtraDeTablasMultiples.=$this->arrStringWhereDeTablasMultiples[$x];
		}

        // construcción de arreglo de columnas a sumar y desplegar en las columnas
	    $arrIdDescColumnasTmp=array();
		for($x=1;$x<=count($this->estructuraReporte['col']);$x++){
			$identificador=$this->estructuraReporte['col'][$x]['identificador'];
			for($y=0;$y<count($this->arrDatosCampos[$identificador]);$y++){
				$arrIdDescColumnasTmp[]=array('id'=>$this->arrDatosCampos[$identificador][$y]['id'],'nombre'=>'id_'.$this->arrDatosCampos[$identificador][$y]['id'],'etiqueta'=>$this->arrDatosCampos[$identificador][$y]['nombre']);
			}

		}

		// quitar columnas que se excluyan por filtrado
		$arrIdDescColumnas=$this->asociarColumnasConFiltros($arrIdDescColumnasTmp);

		// hacer string de where
		$stringWhere=$this->hacerStringWhere();

		if(strlen($stringWhere)>0 and strlen($stringExtraDeTablasMultiples)>0){
			$stringWhere.=" and ".$stringExtraDeTablasMultiples;
		}else if(strlen($stringWhere)==0 and strlen($stringExtraDeTablasMultiples)>0){
			$stringWhere=" where ".$stringExtraDeTablasMultiples;
		}

        // subquery

        // porción de primeras columnas con id de grupos en renglones para etiquetas de renglon
        $stringColumnasConIdDeGrupos='';
        $stringColumnasParaSeccionGroup='';

        for($x=1;$x<=count($this->estructuraReporte['reng']);$x++){

            // define si hay que cambiar tabla fuente dependiendo se si incluye estados, munip, sexo o edo civil en el query

            // busca nombre de tabla del que se va a tomar el id
//            $tablaFuente=$this->definirTablaFuenteAlternativa($x);

            if (strlen($stringColumnasConIdDeGrupos)>0) $stringColumnasConIdDeGrupos.=", ";
            if (strlen($stringColumnasParaSeccionGroup)>0) $stringColumnasParaSeccionGroup.=", ";

			$stringColumnasConIdDeGrupos.=$this->estructuraReporte['reng'][$x]['nombreTablaCatalogo'].".".$this->estructuraReporte['reng'][$x]['nombreCampoDescripcionCatalogo']." as ".$this->estructuraReporte['reng'][$x]['identificador'].", ";
            $stringColumnasConIdDeGrupos.=$this->estructuraReporte['reng'][$x]['tablaMaestra'].".".$this->estructuraReporte['reng'][$x]['campoEnTabla']." as ".$this->estructuraReporte['reng'][$x]['identificador']."Id ";
            $this->arrColumnas[]=array('nombre'=>$this->estructuraReporte['reng'][$x]['identificador'],'visible'=>1,'tipo'=>"etiqueta",'despliegue'=>$this->estructuraReporte['reng'][$x]['etiqueta'],'reducir'=>1);
            $stringColumnasParaSeccionGroup.=$this->estructuraReporte['reng'][$x]['identificador']."Id ";
            $this->arrColumnas[]=array('nombre'=>$this->estructuraReporte['reng'][$x]['identificador']."Id",'visible'=>0,'tipo'=>"id",'despliegue'=>'','reducir'=>0);

        }


        // porción de definición de columnas por agrupar para datos numéricos a representar
        // buscar primero campo que se suma
		$stringColumnasPorSumar='';
        for($x=1;$x<=count($this->estructuraReporte['col']); $x++ ){
            $stringColumnasPorSumar='';
            for ($y=0;$y<count($arrIdDescColumnas);$y++){
                if (strlen($stringColumnasPorSumar)>0) $stringColumnasPorSumar.=", ";
				$stringColumnasPorSumar.="SUM(IF(".$this->estructuraReporte['col'][$x]['tablaMaestra'].".".$this->estructuraReporte['col'][$x]['campoEnTabla']."='".$arrIdDescColumnas[$y]['id']. "',1,0)) as '".$arrIdDescColumnas[$y]['nombre']."'";
                $this->arrColumnas[]=array('nombre'=>$arrIdDescColumnas[$y]['nombre'],'visible'=>1,'tipo'=>"resultado",'despliegue'=>$arrIdDescColumnas[$y]['etiqueta'],'reducir'=>0);
            }
        }

//        $stringJoins=$this->hacerStringJoins();

        // sql interno completo
        $sqlInternoCompleto="Select ".$stringColumnasConIdDeGrupos.", ".$stringColumnasPorSumar." from ".$this->estructuraReporte['tablaFuente']." ".$stringJoins." ".$stringWhere." group by ".$stringColumnasParaSeccionGroup." with rollup";

        // query exterior

        // parte de renglones
        $stringRenglones='';
        for ($t=1;$t<=count($this->estructuraReporte['reng']);$t++){
            if (strlen($stringRenglones)>0) $stringRenglones.=", ";
            $stringRenglones.=$this->estructuraReporte['reng'][$t]['identificador'].", ".$this->estructuraReporte['reng'][$t]['identificador']."Id ";
        }

        // parte de columnas
        $stringSumasColumnaIndividual='';
        $stringSumasTodasLasColumnas='';
        $stringCompletoColumnas='';
        for($r=0;$r<count($arrIdDescColumnas);$r++){
            $stringSumasColumnaIndividual.="sumaColumna.".$arrIdDescColumnas[$r]['nombre'].", ";
            if (strlen($stringSumasTodasLasColumnas)>0) $stringSumasTodasLasColumnas.="+";
            $stringSumasTodasLasColumnas.="sumaColumna.".$arrIdDescColumnas[$r]['nombre'];
        }

        $stringCompletoColumnas=$stringSumasColumnaIndividual.' '.$stringSumasTodasLasColumnas." as Totales";
        $this->arrColumnas[]=array('nombre'=>"Totales",'visible'=>1,'tipo'=>"resultado",'despliegue'=>'Totales','reducir'=>0);

        // sql completo a ejecutar
        $this->sql="select ".$stringRenglones.", ".$stringCompletoColumnas." from (".$sqlInternoCompleto.") as sumaColumna";
    }

	/**
	 *
	 * hace un arreglo de las tablas involucradas por los agrupamientos y filtros
	 *
	 * @return array
	 */
	function hacerArrayDeTablasInvolucradas()
	{
		// pone un item en el array por cada tabla de las columnas
		$arrTablas=array();
		for($x=1;$x<=count($this->estructuraReporte['col']);$x++){
			$arrTablas[]=array('tablaMaestra'=>$this->estructuraReporte['col'][$x]['tablaMaestra'],
							'campoTablaMaestra'=>$this->estructuraReporte['col'][$x]['campoEnTabla'],
							'tablaCatalogo'=>$this->estructuraReporte['col'][$x]['nombreTablaCatalogo'],
							'campoTablaCatalogo'=>$this->estructuraReporte['col'][$x]['nombreCampoLlaveCatalogo'],
							);
		}

		// pone un item en el array por cada tabla de los renglones
		for($x=1;$x<=count($this->estructuraReporte['reng']);$x++){
			$arrTablas[]=array('tablaMaestra'=>$this->estructuraReporte['reng'][$x]['tablaMaestra'],
							'campoTablaMaestra'=>$this->estructuraReporte['reng'][$x]['campoEnTabla'],
							'tablaCatalogo'=>$this->estructuraReporte['reng'][$x]['nombreTablaCatalogo'],
							'campoTablaCatalogo'=>$this->estructuraReporte['reng'][$x]['nombreCampoLlaveCatalogo'],
							);
		}

		// pone un item en el array por cada tabla de los filtros
		for($x=0;$x<count($this->arrFiltros);$x++){
			for($y=0;$y<count($this->arrCatalogoCampos);$y++){
				if($this->arrFiltros[$x]['campo']==$this->arrCatalogoCampos[$y]['nombre']){
					$arrTablas[]=array('tablaMaestra'=>$this->arrCatalogoCampos[$y]['tablaConLaQueLiga'],
										'campoTablaMaestra'=>$this->arrCatalogoCampos[$y]['campoEnTablaConLaQueLiga'],
										'tablaCatalogo'=>$this->arrCatalogoCampos[$y]['tablaCatalogo'],
										'campoTablaCatalogo'=>$this->arrCatalogoCampos[$y]['idTablaCatalogo'],
										);
				}
			}

		}
		return($arrTablas);
	}

	/**
     *
     * Hace un arreglo con todas las sentencias de left join que se necesitan tomando en cuenta las agrupaciones y los filtros
     *
	 * @param $tablaFuente
	 * @param $arrTablasInvolucradas
	 *
	 *@return array
	 */
	function hacerSeccionJoins($tablaFuente,$arrTablasInvolucradas)
	{
		// primero hace arreglo de tablas maestras y busca en tabla jomRelacionesMaestras los strings necesarios
		$arrTablasMaestras=array();
		for($x=0;$x<count($arrTablasInvolucradas);$x++){
			if($arrTablasInvolucradas[$x]['tablaMaestra']!=$tablaFuente){
				$ponerTabla=1;
				for($y=0;$y<count($arrTablasMaestras);$y++){
				    if($arrTablasMaestras[$y]==$arrTablasInvolucradas[$x]['tablaMaestra']) $ponerTabla=0;
				}
				if($ponerTabla==1) $arrTablasMaestras[]=$arrTablasInvolucradas[$x]['tablaMaestra'];
			}
		}
		$arrStringsJoin=array();
		$this->arrStringWhereDeTablasMultiples=array();
		for($x=0;$x<count($arrTablasMaestras);$x++){
			$sql="select * from jomRelacionesMaestras where tablaPrincipal='".$tablaFuente."' and tablaDependiente='".$arrTablasMaestras[$x]."'";
			$resultado = $this->db->query($sql);
	        while ($fila = $resultado->fetch_assoc()) {
	            $arrStringsJoin[]=$this->construirJoin($fila['tablaPrincipal'],$fila['tablaDependiente'],$fila['campoIdTablaPrincipal'],$fila['campoIdTablaDependiente']);
	            if($fila['tablaDependienteMultiple']==1){
//					$numero=rand (0 , 10000 );
//					$fecha=date('YmdHis');
//	                $nombreTablaTemporal=$fila['tablaDependiente']."_".$fecha.$numero;
	                $listaIdsPorConsiderarDeTablaMultiple=$this->llenarArrayDeValoresMultiples($fila['tablaDependiente'],$fila['campoIdTablaDependiente'],$fila['campoIdTablaMultiple'],$fila['campoSeleccionadorRenglonesMultiples']);
					$this->arrStringWhereDeTablasMultiples[]=$fila['tablaDependiente'].".".$fila['campoIdTablaMultiple']." in ($listaIdsPorConsiderarDeTablaMultiple)";
					//."tbeca_detalle.tbede_id in (select tbede_id from jomTemp)";
	            }
	        }
		}

		// luego hace joins de cada catalogo asociado a las tablas
		for($x=0;$x<count($arrTablasInvolucradas);$x++){
		    $arrStringsJoin[]=$this->construirJoin($arrTablasInvolucradas[$x]['tablaMaestra'],$arrTablasInvolucradas[$x]['tablaCatalogo'],$arrTablasInvolucradas[$x]['campoTablaMaestra'],$arrTablasInvolucradas[$x]['campoTablaCatalogo']);
		}

		// luego elimina los repetidos
		$arrTmp=array();
		for($x=0;$x<count($arrStringsJoin);$x++){
		    if(!in_array($arrStringsJoin[$x],$arrTmp,true)) $arrTmp[]=$arrStringsJoin[$x];
		}


		// por ultimo hace un solo string con todos los left join del array recién construido
		$stringJoin='';
		for($x=0;$x<count($arrTmp);$x++){
		    $stringJoin.=$arrTmp[$x]." ";
		}

		return($stringJoin);
	}


	function llenarArrayDeValoresMultiples($tablaDependiente,$campoIdTablaDependiente,$campoIdTablaMultiple,$campoSeleccionadorRenglonesMultiples){

		$listaIds='';
		$sql="select $campoIdTablaMultiple,$campoIdTablaDependiente,max($campoSeleccionadorRenglonesMultiples) as maximo from $tablaDependiente group by $campoIdTablaDependiente";
		$resultado = $this->db->query($sql);
		while ($fila = $resultado->fetch_assoc()) {
			if(strlen($listaIds)>0) $listaIds.=", ";
			$listaIds.=$fila[$campoIdTablaMultiple];
		}
		return ($listaIds);
	}

	/**
	 *
	 * Construye string de left join
	 *
	 * @param $tablaMadre
	 * @param $tablaHija
	 * @param $campoTablaMadre
	 * @param $campoTablaHija
     *
	 *@return string
	 */
	function construirJoin($tablaMadre,$tablaHija,$campoTablaMadre,$campoTablaHija)
	{
		$textoJoin="left join $tablaHija on $tablaMadre.$campoTablaMadre=$tablaHija.$campoTablaHija";
		return ($textoJoin);
	}

	/**
	 *
	 * Compara columnas de tabla a desplegar en columnas con columnas seleccionadas en el filtro y en su caso elimina las que no son filtradas
	 *
	 * @param $arrTmp
	 *
	 *@return array
	 */
	function asociarColumnasConFiltros($arrTmp)
	{
		$arrRecortado=array();
		for($x=0;$x<count($this->arrFiltros);$x++){
			if($this->arrFiltros[$x]['campo']==$this->estructuraReporte['col']["1"]['identificador']){
				for($y=0;$y<count($arrTmp);$y++){
					for($z=0;$z<count($this->arrFiltros[$x]['valor']);$z++){
						if($arrTmp[$y]['id']==$this->arrFiltros[$x]['valor'][$z]['id']){
							$arrRecortado[]=$arrTmp[$y];
						}
					}
				}
			}

		}
		if(count($arrRecortado)==0)$arrRecortado=$arrTmp;
		return($arrRecortado);
	}

	/**
	 *
	 * Construye la sentencia where del sql a ejecutar
	 *
	 * @return string
	 */
	function hacerStringWhere()
	{
		$arrTexto=array();
		$stringWhere='';
		if (count($this->arrFiltros)>0){
			for($x=0;$x<count($this->arrFiltros);$x++){
				$tablaConFiltro='';
				$campoAFiltrar='';
				for($y=0;$y<count($this->arrCatalogoCampos);$y++){
					if($this->arrCatalogoCampos[$y]['nombre']==$this->arrFiltros[$x]['campo']) {
						$tablaConFiltro=$this->arrCatalogoCampos[$y]['tablaConLaQueLiga'];
						$campoAFiltrar=$this->arrCatalogoCampos[$y]['campoEnTablaConLaQueLiga'];
					}
				}
				if(strlen($tablaConFiltro)>0 && strlen($campoAFiltrar)>0){
					$texto='';
					for($z=0;$z<count($this->arrFiltros[$x]['valor']);$z++){
						if(strlen($texto)>0) $texto.=" || ";
						$texto.=$tablaConFiltro.".".$campoAFiltrar."='".$this->arrFiltros[$x]['valor'][$z]['id']."'";
					}
					$arrTexto[]=" (".$texto.") ";
				}
			}
		}
		for($q=0;$q<count($arrTexto);$q++){
			if (strlen($stringWhere)>0) $stringWhere.=' and ';
			$stringWhere.=$arrTexto[$q];
		}
		if(strlen($stringWhere)>0) $stringWhere=" where ".$stringWhere;
		return ($stringWhere);
	}

	/**
	 *
	 * Define las tablas de donde se toman los valores y las de relaciones en función de filtros y campos a desplegar
	 * Llena el arreglo de joins de acuerdo a las tablas involucradas
	 *
	 * @param $x
	 *
*@return string
	 */
	function definirTablaFuenteAlternativa($x)
    {
        // TODO: Migrar esto a una tabla que tenga campo de tablaPrincipal, campo de tabla asociada al catalogo, campos de join para juntar estas tablas
        $tablaFuente=$this->estructuraReporte['tablaFuente'];
        switch ($this->estructuraReporte['tablaFuente']){
            case 'tbecario_beca':
                switch ($this->estructuraReporte['reng'][$x]['campoEnTabla']){
                    case 'idEstado':
                        $tablaFuente='mbecario';
//                        $this->arrJoins[]="left join mbecario on mbecario.mbec_id=tbecario_beca.mbec_id";
//                        $this->arrJoins[]="left join mestados on mbecario.idEstado=mestados.idEstado";
                        break;
                    case 'idEdoMpo':
                        $tablaFuente='mbecario';
//                        $this->arrJoins[]="left join mbecario on mbecario.mbec_id=tbecario_beca.mbec_id";
//                        $this->arrJoins[]="left join mdeleg_munic on mbecario.idEdoMpo=mdeleg_munic.idEdoMpo";
                        break;
                    case 'msex_id':
                        $tablaFuente='mbecario';
//                        $this->arrJoins[]="left join mbecario on mbecario.mbec_id=tbecario_beca.mbec_id";
//                        $this->arrJoins[]="left join msexo on mbecario.mbec_sexo=msexo.msex_id";
                        break;
                    case 'mesc_id':
                        $tablaFuente='mbecario';
//                        $this->arrJoins[]="left join mbecario on mbecario.mbec_id=tbecario_beca.mbec_id";
//                        $this->arrJoins[]="left join mestciv on mbecario.mbec_estciv=mestciv.mesc_id";
                        break;
                    case 'inst_id':
//                        $this->arrJoins[]="left join minstitution on minstitution.inst_id=tbecario_beca.inst_id";
                        break;
                }
        }
        return ($tablaFuente);
    }

	/**
	 *
	 * Analiza el arreglo de joints, elimina duplicidades y lo traduce en un string de joins para el sql
	 *
	 * @return string
	 */
	function hacerStringJoins()
    {
        $arrTmp=array();
        for ($x = 0; $x < count($this->arrJoins); $x++) {
            if (!in_array($this->arrJoins[$x], $arrTmp)) $arrTmp[]=$this->arrJoins[$x];
        }
        // hace string de las opciones del arr temporal
        $stringTmp='';
        for ($x=0;$x<count($arrTmp);$x++){
            $stringTmp.=$arrTmp[$x].' ';
        }
        return($stringTmp);
    }

	/**
	 *
	 * Ejecuta el sql y regresa un arreglo con los resultados
	 *
	 * @return array
	 */
	function hacerQuery()
    {
        $arrTmp=array();
//        echo "$this->sql<br>";
        $resultado = $this->db->query($this->sql);
        if (!$resultado) {
		    throw new Exception("Database Error [{$this->database->errno}] {$this->database->error}");
		   }else{

	        while ($fila = $resultado->fetch_assoc()) {
	            $arrTmp[]=$fila;
	        }
        }
        return($arrTmp);
    }

	/**
	 *
	 * Función que inicia la búsqueda
	 * Llama a la función de construcción del sql
	 * Después a la función de hacer la búsqueda
	 * Finalmente llama a la función que reemplaza las etiquetas de totales en el resultado
	 *
	 */
	function buscar()
    {
		if(count($this->estructuraReporte)>0){
	        $this->construirSql();
	        $this->resultadoBusqueda=$this->hacerQuery();
	        $this->ponerEtiquetasTotalesEnResultados();
	        //$this->reducirNombresEnColumnasDeEtiquetas();
        }
    }

	/**
	 *
	 * Función que elimina los nombres de las columnas que por filtrado no deben incluirse
	 *
	 */
    function reducirNombresEnColumnasDeEtiquetas()
	{
		for($x=0;$x<count($this->arrColumnas);$x++){
			if($this->arrColumnas[$x]['reducir']==1){
				$this->borrarEtiquetas($this->arrColumnas[$x]['nombre']);
			}
		}
	}

	/**
     *
     * Función que borra los nombres de los renglones repetidos
     *
	 * @param $nombre
	 */
	function borrarEtiquetas($nombre)
	{
		$etiqueta='';
		for($x=0;$x<count($this->resultadoBusqueda);$x++){

		     if($this->resultadoBusqueda[$x][$nombre]!=$etiqueta && $this->resultadoBusqueda[$x][$nombre] != null){
		         $etiqueta=$this->resultadoBusqueda[$x][$nombre];
		     }else{
		        $this->resultadoBusqueda[$x]['$nombre']='';
		     }

		}
	}

	/**
	 *
	 * Sustituye las etiquetas en los campos nulos con la leyenda "Total"
	 *
	 */
	function ponerEtiquetasTotalesEnResultados()
    {
        $this->arrCamposDeValidacion=array();
        for ($x = 1; $x <= count($this->estructuraReporte['reng']); $x++) {
            $this->arrCamposDeValidacion[]=array('etiqueta'=>$this->estructuraReporte['reng'][$x]['identificador'],'id'=>$this->estructuraReporte['reng'][$x]['identificador']."Id");
        }

        for ($x = 0; $x < count($this->resultadoBusqueda); $x++) {
            for ($y = 0; $y < count($this->arrCamposDeValidacion); $y++) {
                if (($this->resultadoBusqueda[$x][ $this->arrCamposDeValidacion[$y]['etiqueta'] ] != NULL) && ($this->resultadoBusqueda[$x][ $this->arrCamposDeValidacion[$y]['id'] ] == NULL))
                    $this->resultadoBusqueda[$x][ $this->arrCamposDeValidacion[$y]['etiqueta'] ]="Total";
            }

        }
    }

    // filtros


	/**
	 *
	 * Pone los valores seleccionados en campo de selección múltiple
	 * y devuelve un arreglo para poblar la variable arrFiltros[item][valor]
	 *
	 * @param $idEnArrFiltros
	 * @param $itemsSeleccionados
	 *
	 * @return array
	 */
	public function ponerValoresDeItemSeleccionado ($idEnArrFiltros,$itemsSeleccionados)
	{
		$arrTmp=array();
		for($y=0;$y<count($this->arrFiltros[$idEnArrFiltros]['valor']);$y++){
			$arrTmp[]=$this->arrFiltros[$idEnArrFiltros]['valor'][$y];
		}
		for($x=0;$x<count($itemsSeleccionados);$x++){
			for($y=0;$y<count($this->arrDatosCampos[$this->arrFiltros[$idEnArrFiltros]['campo']]);$y++){
				if($this->arrDatosCampos[$this->arrFiltros[$idEnArrFiltros]['campo']]["$y"]['id']==$itemsSeleccionados["$x"]){
					$arrTmp[]=array('id'=>$itemsSeleccionados["$x"],'nombre'=>$this->arrDatosCampos[$this->arrFiltros[$idEnArrFiltros]['campo']]["$y"]['nombre']);
				}
			}
		}
		return($arrTmp);
	}

	/**
	 *
	 * reduce el arreglo arrComboFiltro que despliega las opciones de filtrado considerando
     * solo las que contengan el string que se recibe como $stringABuscar
	 *
	 * @param $stringABuscar
	 */
	function acotarOpciones($stringABuscar)
	{
		if(strlen($stringABuscar)>0){
			$arrTmp=array();
			for($x=0;$x<count($this->arrComboFiltro);$x++){
				if (strpos(strtoupper($this->arrComboFiltro[$x]['nombre']),strtoupper($stringABuscar)) !== false) {
	                $arrTmp[]=$this->arrComboFiltro[$x];
				}
	//			if(upper($stringABuscar) $this->arrComboFiltro[$x]['nombre'])
			}
			$this->arrComboFiltro=$arrTmp;
		}
	}

	function hacerExcelFake()
	{
		$texto='';
		$texto.='<table>';
		$texto.='<tr>';
		for ($x=0;$x<count($this->arrColumnas);$x++){
			if($this->arrColumnas[$x]['visible']==1){
				$texto.='<td bgcolor="#696969"> <p style="color:whitesmoke" style="font-size:14px">';
//				$texto.='<td bgcolor="g"> <p style="color:whitesmoke" style="font-size:14px">';
					$texto.=utf8_encode($this->arrColumnas[$x]['despliegue']);
					$texto.='</p>';
				$texto.='</td>';
			}
		}
		$texto.='</tr>';
		$colorDeFondo=0;
		for ($y=0;$y<count($this->resultadoBusqueda);$y++){

			if($colorDeFondo=='0'){
				$fondo='#ffffff';
				$colorDeFondo='1';
			}else{
//				$fondo='#add8e6';
				$fondo='#fafad2';
				$colorDeFondo='0';
			}

			$texto.='<tr>';

			for ($x=0;$x<count($this->arrColumnas);$x++){
				if ($this->arrColumnas[$x]['visible']==1) {
					$contenido='';
					if ($this->arrColumnas[$x]['tipo']=="etiqueta"){
						if($this->resultadoBusqueda[$y-1][$this->arrColumnas[$x]['nombre']]!=$this->resultadoBusqueda[$y][$this->arrColumnas[$x]['nombre']]){
							$contenido=utf8_encode($this->resultadoBusqueda[$y][$this->arrColumnas[$x]['nombre']]);
						}else{
							$contenido='&nbsp;';
						}
					}else if($this->arrColumnas[$x]['tipo']=="resultado"){
						$contenido=$this->resultadoBusqueda[$y][$this->arrColumnas[$x]['nombre']];
					}

					if($contenido=='Total') {
						$fondo='#add8e6';
						$colorDeFondo=0;
					}
					$texto.='<td bgcolor="'.$fondo.'"> ';
						$texto.="<p style=\"color:black;\" style=\"font-size:14px\">";
						$texto.=$contenido;
						$texto.='</p>';
					$texto.='</td>';
				}
			}
			$texto.='</tr>';
		}

//		$nombre=$this->estructuraReporte['nombre']."_".date('Y_m_d');


//		echo "header(\"Content-type: application/vnd.ms-excel\") ;";
//		echo "header(\"Content-Disposition: attachment;Filename=document_name.xls\");";

		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition: attachment; filename=DocumentoGeneradoPorReporteadorBecalos.xls");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo "<html>";
		echo "<meta http-equiv=\"Content-Type\" charset=utf-8\">";
		echo "<body>";
		echo "$texto";
		echo "</body>";
		echo "</html>";

	}

	function hacerExcel()
	{
		define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

		/** Include PHPExcel */
		require_once ("excelExporter/PHPExcel.php");

		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()->setCreator("Reporteador Becalos")
									 ->setLastModifiedBy("Reporteador Becalos")
									 ->setTitle("Reporte generado por Reporteador Becalos")
									 ->setSubject("Reporte automático")
									 ->setDescription("Reporte generado por Reporteador Bécalos")
									 ->setKeywords("Beecalos")
									 ->setCategory("");


		// todo: poner titulos columnas

		$objPHPExcel->getDefaultStyle()->getFont()->setName('Arial')
                                          ->setSize(10);
		$columna=2;
		$renglon=3;

		$noCols=0;
		for ($x=0;$x<count($this->arrColumnas);$x++){
			if($this->arrColumnas[$x]['visible']==1) $noCols++;
		}

		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columna, $renglon)->getFont()->setName('Arial');
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columna, $renglon)->getFont()->setSize(20);
		$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columna, $renglon)->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $renglon, $this->estructuraReporte['nombre']);
		$renglon++;

		$styleArray = array(
			'font' => array(
				'bold' => true,
				'size' => 12,
				),
				'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT, ),
					'borders' => array(
						'top' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN,),
						'bottom' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN,
					),
				),
						'fill' => array( 'type' => PHPExcel_Style_Fill::FILL_GRADIENT_LINEAR,
						'rotation' => 90,
						'startcolor' => array(
							'argb' => '9dcbf6', ),
						'endcolor' => array(
							'argb' => '9dcbf6',
						),
					),
				);

		for ($x=0;$x<count($this->arrColumnas);$x++){
			if($this->arrColumnas[$x]['visible']==1){
				$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($columna)->setAutoSize(true);
				$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($columna, $renglon)->applyFromArray($styleArray);
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $renglon, $this->arrColumnas[$x]['despliegue']);
				$columna++;
			}
		}
		$renglon++;
		$columna=2;


		// todo: que no brinque columna si la columna no es imprimible
		for ($y=0;$y<count($this->resultadoBusqueda);$y++){
            $clase='';
            for ($x=0;$x<count($this->arrColumnas);$x++){
                //if ($this->arrColumnas[$x]['tipo']=="etiqueta" and $this->resultadoBusqueda[$y][$this->arrColumnas[$x]['nombre']]=='Total') $clase='info';
                if ($this->arrColumnas[$x]['visible']==1) {
					if ($this->arrColumnas[$x]['tipo']=="etiqueta"){
                            if($this->resultadoBusqueda[$y-1][$this->arrColumnas[$x]['nombre']]!=$this->resultadoBusqueda[$y][$this->arrColumnas[$x]['nombre']]){
                                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $renglon, $this->resultadoBusqueda[$y][$this->arrColumnas[$x]['nombre']]);
                                //echo (utf8_encode($this->resultadoBusqueda[$y][ $this->arrColumnas[$x]['nombre'] ]));
                            }
                    }else if($this->arrColumnas[$x]['tipo']=="resultado"){
                            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($columna, $renglon, $this->resultadoBusqueda[$y][$this->arrColumnas[$x]['nombre']]);
                    }
                    $columna++;
                }
            }
		$renglon++;
		$columna=2;
        }

		// Rename worksheet
		$prohibidos = array("/", " ", "\\", "?",",","<",">");
		$nombrePestana = str_replace($prohibidos, "_", $this->estructuraReporte['nombre']);
		if(strlen($nombrePestana)>30) $nombrePestana=substr($nombrePestana,0,29);
		$objPHPExcel->getActiveSheet()->setTitle($nombrePestana);

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

//		$nombre=$this->estructuraReporte['nombre']."_".date('Y_m_d');


		$nombre=rand ( 100000 , 1000000 );
		//$nombre=str_replace('/','_',$nombre);
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$nombre.'.xlsx"');
		header('Cache-Control: max-age=0');

//		// If you're serving to IE 9, then the following may be needed
//		header('Cache-Control: max-age=1');
//
//		// If you're serving to IE over SSL, then the following may be needed
//		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
//		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

	}
}
