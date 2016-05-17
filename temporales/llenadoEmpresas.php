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

function nombreAleatorio($db)
{
	$idNombre = rand(1, 40);
	$idApellido1 = rand(1, 99);
	$idApellido2 = rand(1, 99);

	$resultadoNombre = $db->query("select nombre from nombres2 where id=$idNombre");
	$lineaNombre=$resultadoNombre->fetch_assoc();

	$resultadoPaterno = $db->query("select nombre from nombres where id=$idApellido1");
	$lineaPaterno=$resultadoPaterno->fetch_assoc();

	$resultadoMaterno = $db->query("select nombre from nombres where id=$idApellido2");
	$lineaMaterno=$resultadoMaterno->fetch_assoc();

	$nombreCompleto=$lineaNombre['nombre']." ".$lineaPaterno['nombre']." ".$lineaMaterno['nombre'];

	return "$nombreCompleto";
}

function fechaAleatoria()
{
	$dia = rand(1, 28);
	$mes = rand(1, 12);
	$ano = rand(2015, 2016);
	$fecha = $ano."-".$mes."-".$dia;
	return "$fecha";
}

$coordenadas=array(
	'24.632043 -111.817752',
	'22.8084963 -110.8601402',
	'24.6439963 -110.9994895',
	'27.237384 -110.390625',
	'23.495838 -109.511719',
	'27.080984 -110.050049',
	'27.301297 -110.558167',
	'28.053727 -111.187134',
	'28.369935 -111.460419',
	'28.759514 -111.890259',
	'29.176426 -112.19101',
	'29.470968 -112.375031',
	'29.905507 -112.695007',
	'30.283066 -112.843323',
	'30.717323 -113.090515',
	'27.73444 -113.433838',
	'27.452075 -112.91748',
	'27.929185 -112.766418',
	'27.926758 -114.217987',
	'27.853932 -114.32785',
	'27.844218 -115.048828',
	'28.161895 -115.160065',
	'27.237384 -114.44458',
	'27.484194 -113.994141',
	'27.021131 -113.131714',
	'26.69712 -111.769409',
	'27.241486 -112.08252',
	'27.434232 -111.879272',
	'28.320022 -113.153687',
	'28.825707 -113.248444',
	'29.082858 -113.170166',
	'29.52834 -113.529968',
	'29.406385 -113.37616',
	'29.457816 -113.865051',
	'30.959045 -113.087769',
	'30.911062 -112.895508',
	'31.275305 -113.395386',
	'31.630273 -113.974915',
	'31.541364 -114.267426',
	'31.688719 -114.701385',
	'31.877831 -114.863434',
	'31.931459 -114.230347',
	'31.929401 -113.694763',
	'31.768146 -113.216858',
	'32.244439 -114.286652',
	'32.103789 -114.921112',
	'25.983026 -111.353302',
	'24.416517 -107.446289',
	'24.476193 -107.611084',
	'24.780793 -108.047791',
	'25.305836 -108.348541',
	'25.455966 -108.763275',
	'26.10088 -111.42334',
	'25.834795 -111.213226',
	'25.693803 -111.040192',
	'25.690091 -110.77652',
	'29.773318 -115.444336',
	'29.920702 -115.712128',
	'29.738427 -114.34845',
	'29.110457 -112.476654',
	'29.352535 -112.401123',
	'28.800439 -111.875153',
	'28.336096 -111.445312',
	'28.221204 -111.353302',
	'28.045603 -111.211853',
	'28.210313 -111.165161',
	'25.130055 -110.895996',
	'25.039863 -110.665283',
	'25.292179 -110.714722',
	'26.833262 -109.731445',
	'27.080201 -110.033569',
	'27.285432 -110.44693',
	'27.3135 -110.587006',
	'27.821144 -110.577393',
	'24.178372 -109.856415',
	'24.503687 -110.343933',
	'24.572397 -110.391998',
	'26.238921 -109.182129',
	'26.725048 -109.460907',
	'26.559338 -109.293365',
	'25.217211 -112.038574',
	'25.343076 -112.114105',
	'23.28645 -109.533691',
	'22.888155 -109.986877',
	'30.365618 -112.818604',
	'30.596825 -113.028717',
	'29.91237 -112.726593',
	'31.246783 -114.916992',
	'31.097906 -114.87854',
	'31.035561 -114.833221',
	'31.276479 -115.506134',
	'31.008493 -115.473175',
	'30.871859 -115.419617',
	'30.658274 -115.252075',
	'30.449784 -114.65332',
	'30.097892 -114.605255',
	'27.649168 -112.675781',
	'27.704124 -113.285522',
	'28.735076 -114.301758');




$db = new mysqli('localhost', 'jom','lehendakari', 'buenasPracticas');
$db->query("SET NAMES utf8");

$sql0="delete from bp_empresas where id>12";
$db->query($sql0);

$sql0="ALTER TABLE bp_empresas AUTO_INCREMENT = 13";
$db->query($sql0);

$resultado=$db->query("select * from nombresEmpresas");
while($linea=$resultado->fetch_assoc()){

	$nombreEmpresa=$linea['nombre'];
	//$coordenadas="GeomFromText('POINT(28.084550 -111.193561)')";
	$fecha1=fechaAleatoria();
	$fecha2=fechaAleatoria();
	if($fecha1>=$fecha2){
		$fechaCreacion=$fecha2;
		$fechaUltimoLogin=$fecha1;
	}else{
		$fechaCreacion=$fecha1;
		$fechaUltimoLogin=$fecha2;
	}
	$nombreContacto=nombreAleatorio($db);
	$cachosNombre=explode(' ',$nombreContacto);
	$usuario=$cachosNombre['0'];
	$clave=$cachosNombre['1'];
	$telefono=rand(55111111,55999999);

	//ubicacion,
	//".$coordenadas.",

	$sql2="insert into bp_empresas (nombreEmpresa,   fechaCreacion, mentorId, publica,
 			contactoNombre, telefono, correoNotificacionCadaXHoras, ultimoLogin,
 			usuario, clave, fechaAutoevaluacion, infoCapturada, autoevaluacionHecha)
 			values(
 			'".$nombreEmpresa."',
			'".$fechaCreacion."',
			'2',
			'1',
			'".$nombreContacto."',
			'".$telefono."',
			'4',
			'".$fechaUltimoLogin."',
			'".$usuario."',
			'".$clave."',
			'".$fechaCreacion."',
			'1',
			'1')";
	//echo "$sql2<br><br>";
	$db->query($sql2);
}

////////////////



$x=0;
$resultado5=$db->query("select id from bp_empresas  order by telefono");
while($linea=$resultado5->fetch_assoc()){
	$coordenadasTexto="GeomFromText('POINT(".$coordenadas[$x].")')";
	$sql="update bp_empresas set ubicacion=".$coordenadasTexto." where id=".$linea['id'];
	$db->query($sql);
	echo "x = $x<br>";
	echo $coordenadas[$x]."<br>";
	echo "$coordenadasTexto<br>";
	echo "$sql<br>";
	$x++;
}
