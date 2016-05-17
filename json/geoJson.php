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


$dbJson = new mysqli('localhost', 'jom','lehendakari', 'buenasPracticas');
$dbJson->query("SET NAMES utf8");

$sql="select *, X(ubicacion) as latitud, Y(ubicacion) as longitud from bp_empresas";
$resultado=$dbJson->query($sql);
while($linea=$resultado->fetch_assoc()){
	$propiedades = $linea;
	$fechaCreacion = transformarFechaDMY($linea['fechaCreacion']);
	$fechaUltimoLogIn = transformarFechaDMY($linea['ultimoLogin']);
	// quita las columnas extra de latitud y longitud del set de propiedades
	unset($propiedades['latitud']);
	unset($propiedades['longitud']);
	unset($propiedades['ubicacion']);
	unset($propiedades['fechaCreacion']);
	unset($propiedades['ultimoLogin']);
	$propiedades['fechaCreacion']=$fechaCreacion;
	$propiedades['ultimoLogin']=$fechaUltimoLogIn;
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
//$completo="eqfeed_callback(".$geojson.");";
//print "<pre>";
//	echo "<br>geoJson  <BR>";
//	print_r($geojson);
//print "</pre>";
//header('Content-type: application/json');
echo "eqfeed_callback(".json_encode($geojson, JSON_NUMERIC_CHECK).");";
$dbJson=null;