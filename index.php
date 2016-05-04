<?php

/**
 *
 * Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * Inicio de sitio Buenas Prácticas
 *
 * @var mysqli
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 */

date_default_timezone_set('America/Mexico_City');
$directorioRaiz=__DIR__;
include_once "clases/Controlador.php";
include_once "includes/conf.php";

session_start();

$db = new mysqli($mysqlServidor, $mysqlUser,$mysqlClave, $mysqlDb);
$db->query("SET NAMES utf8");


if (isset($_POST)) {
	if (isset($_POST['accion']) && $_POST['accion']=='salir' ) unset($_SESSION['controlador']);
}
if (!isset($_SESSION['controlador'])) {
	$_SESSION['controlador']= new Controlador();
	$_SESSION['controlador']->ponerConexionMysql($db);
	$_SESSION['controlador']->llenarCatalogosModelo();
}else{
	$_SESSION['controlador']->ponerConexionMysql($db);
}


if (isset($_POST['accion'])) $_SESSION["controlador"]->evaluarPost($_POST);



?>

<!DOCTYPE html>
<html>
<head>
	<title>Buenas Prácticas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="includes/estilos.css" rel="stylesheet" type="text/css">

	<!-- Iconos -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

	<!-- tomado de tema de wordPress-->
	<link rel='stylesheet' id='tc-gfonts-css'  href='//fonts.googleapis.com/css?family=Alegreya:700|Roboto' type='text/css' media='all' />

	<script type="text/javascript" src="js/jquery.js" ></script>
</head>

<body link='White' vlink='White' alink='White' bgcolor='#FFFFFF'>
	<div id="Contenido">
		<form action ="index.php" method="post" name ="<?php echo (NOMBRE_FORMULARIO);?>" target="_self" enctype="multipart/form-data">
			<input type="hidden" name ="accion" value ="">
			<input type="hidden" name ="subaccion" value ="">
			<input type="hidden" name ="registroActivo" value ="">
			<input type="hidden" name ="item" value ="">
			<input type="hidden" name ="subItem" value ="">
			<input type="hidden" name ="permisos" value ="">
			<?php $_SESSION["controlador"]->mostrarPantalla();?>
		</form>
	</div>
	<!-- Contenido -->
</body>
</html>

