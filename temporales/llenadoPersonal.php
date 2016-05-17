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



for($x=0;$x<30;$x++) {
	$idNombre = rand(1, 40);
	$idApellido1 = rand(1, 99);
	$idApellido2 = rand(1, 99);

	$diaInicio=rand(1,28);
	$mesInicio=rand(1,12);
	$anoInicio=rand(2015,2016);
	$fechaInicio=$anoInicio."-".$mesInicio."-".$diaInicio;


	$diaClaveUpdate=rand(1,28);
	$mesClaveUpdate=rand(1,12);
	$anoClaveUpdate=rand(2015,2016);
	$fechaClaveUpdate=$anoClaveUpdate."-".$mesClaveUpdate."-".$diaClaveUpdate;

	$diaLogin=rand(1,28);
	$mesLogin=rand(1,12);
	$anoLogin=rand(2015,2016);
	$fechaLogin=$anoLogin."-".$mesLogin."-".$diaLogin;

	$resultadoNombre = $db->query("select nombre from nombres2 where id=$idNombre");
	$lineaNombre=$resultadoNombre->fetch_assoc();

	$resultadoPaterno = $db->query("select nombre from nombres where id=$idApellido1");
	$lineaPaterno=$resultadoPaterno->fetch_assoc();

	$resultadoMaterno = $db->query("select nombre from nombres where id=$idApellido2");
	$lineaMaterno=$resultadoMaterno->fetch_assoc();

	//echo $lineaNombre['nombre']." - ".$lineaPaterno['nombre']." - ".$lineaMaterno['nombre']." $idApellido1 $idApellido2<br>";

	$nombreCompleto=$lineaNombre['nombre']." ".$lineaPaterno['nombre']." ".$lineaMaterno['nombre'];
	$usuario=strtolower($lineaNombre['nombre']);
	$clave=strtolower($lineaPaterno['nombre']);
	$correo=strtolower($lineaNombre['nombre']).".".strtolower($lineaPaterno['nombre'])."@".strtolower($lineaMaterno['nombre']).".com.mx";


	$sql="insert into bp_personal (nombre, usuario, clave, email, fechaCreado, fechaClaveUpdate, esSuperAdmin,
			correoNotificacionCadaXHoras, correoUltimoEnviado, ultimoLogin)
			VALUES ('".$nombreCompleto."','".$usuario."','".$clave."','".$correo."','".$fechaInicio."','".$fechaClaveUpdate."','0','4','2016-05-01','".$fechaLogin."')";
	$db->query($sql);
	echo "$sql<br>";


}