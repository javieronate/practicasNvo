<?php
/**
 *
 * Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit, S.C. / Dédalo (http://hasselbit.com)
 *
 * @author Javier Oñate Mendía (Dédalo)
 *
 */

/**
 *
 * archivo de web service para generación de datos de mapas
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */




include_once ('../includes/conf.php');


/**
 *
 * Cambia formato de fecha de año-mes-dia a dia-mes-año
 *
 * @param $fecha
 *
 * @return string
 */
function transformarFechaDMY($fecha)
{
	$ano=substr($fecha,0,4);
	$mes=substr($fecha,5,2);
	$dia=substr($fecha,8,2);
	$nuevaFecha="$dia-$mes-$ano";
	return ($nuevaFecha);
}




$geojson = array(
	'type'      => 'FeatureCollection',
	'features'  => array()
);
$admonId=$_GET['id'];
$nivel=$_GET['nivel'];

$textoWhere='';
if($nivel==2){
	$textoWhere=" where mentorId in (select id from bp_personal where superiorId=$admonId)";
}


//$dbJson = new mysqli('localhost', 'jom','lehendakari', 'buenasPracticas');
$dbJson = new mysqli($mysqlServidor, $mysqlUser,$mysqlClave, $mysqlDb);
$dbJson->query("SET NAMES utf8");

//$sql="select *, X(ubicacion) as latitud, Y(ubicacion) as longitud from bp_empresas";

$sql="select nombreEmpresa,contactoNombre,telefono,correos,sitioWeb,fechaCreacion,ultimoLogin,
X(ubicacion) as latitud, Y(ubicacion) as longitud,foto,
(select count(*)  from bp_empresa_buenaPractica where empresaId=E.id and estatus=4 ) as terminadas,
(select count(*)  from bp_empresa_buenaPractica where empresaId=E.id and estatus=2 ) as proceso
from bp_empresas E $textoWhere";
$resultado=$dbJson->query($sql);
while($linea=$resultado->fetch_assoc()){
	$propiedades = $linea;
	$fechaCreacion = transformarFechaDMY($linea['fechaCreacion']);
	$fechaUltimoLogIn = transformarFechaDMY($linea['ultimoLogin']);

	switch($linea['terminadas']){

		case ($linea['terminadas']<=9):
			$pin="pinRojo.png";
			break;
		case ($linea['terminadas']<=18):
			$pin="pinAmarillo.png";
			break;
		case ($linea['terminadas']<=27):
			$pin="pinAzul.png";
			break;
		case ($linea['terminadas']<=35):
			$pin="pinVerde.png";
			break;
	}
	// quita las columnas extra de latitud y longitud del set de propiedades
	unset($propiedades['latitud']);
	unset($propiedades['longitud']);
	unset($propiedades['fechaCreacion']);
	unset($propiedades['ultimoLogin']);
	$propiedades['fechaCreacion']=$fechaCreacion;
	$propiedades['ultimoLogin']=$fechaUltimoLogIn;
	$propiedades['pin']=$pin;
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
echo "eqfeed_callback(".json_encode($geojson, JSON_NUMERIC_CHECK).");";
$dbJson=null;