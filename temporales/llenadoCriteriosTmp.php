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

$db = new mysqli('localhost', 'jom','lehendakari', 'buenasPracticas');
$db->query("SET NAMES utf8");

for($x=1;$x<36;$x++){
	$sql="select id from bp_criterios where buenaPracticaId=$x order by id";
	$resultado=$db->query($sql);
	$arrIdCriterios=array();
	while($linea=$resultado->fetch_assoc()){
		$arrIdCriterios[]=$linea['id'];
	}
	$cuantos=count($arrIdCriterios);
	for($y=0;$y<$cuantos;$y++){
		$noCriterio=$y+1;
		$sql2="update bp_criterios set nombre='Criterio ".$noCriterio." de la práctica ".$x."' where id=".$arrIdCriterios[$y];
		echo "$sql2<br>";
		$resultado2=$db->query($sql2);
	}

}
