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
define('NOMBRE_FORMULARIO','llenadoPracticas');
include_once ('../clases/FxFormularios.php');

session_start();

$dbTmp = new mysqli('localhost', 'jom','lehendakari', 'buenasPracticas');
$dbTmp->query("SET NAMES utf8");

if(isset($_POST['accion']) && $_POST['accion']=='grabar'){
	echo "grabar <br>";

	$_SESSION['arrPracticaActiva']['titulo']=$_POST['titulo'];
	$_SESSION['arrPracticaActiva']['tituloCorto']=$_POST['tituloCorto'];
	$_SESSION['arrPracticaActiva']['imagen1']=$_POST['imagen1'];
	$_SESSION['arrPracticaActiva']['imagen2']=$_POST['imagen2'];
	$_SESSION['arrPracticaActiva']['imagen3']=$_POST['imagen3'];
	$_SESSION['arrPracticaActiva']['puntosMaximos']=$_POST['puntosMaximos'];
	$_SESSION['arrPracticaActiva']['descripcion']=$_POST['descripcion'];
	$_SESSION['arrPracticaActiva']['experiencia']=$_POST['experiencia'];
	$_SESSION['arrPracticaActiva']['sustentabilidad']=$_POST['sustentabilidad'];
	$_SESSION['arrPracticaActiva']['competitividad']=$_POST['competitividad'];
	$_SESSION['arrPracticaActiva']['variaciones']=$_POST['variaciones'];
	$_SESSION['arrPracticaActiva']['aprenderMas']=$_POST['aprenderMas'];
	$_SESSION['arrPracticaActiva']['ejemplosCumplimiento']=$_POST['ejemplosCumplimiento'];

	$sql="update bp_buenasPracticas set
			titulo='".$_SESSION['arrPracticaActiva']['titulo']."',
			tituloCorto='".$_SESSION['arrPracticaActiva']['tituloCorto']."',
			imagen1='".$_SESSION['arrPracticaActiva']['imagen1']."',
			imagen2='".$_SESSION['arrPracticaActiva']['imagen2']."',
			imagen3='".$_SESSION['arrPracticaActiva']['imagen3']."',
			puntosMaximos='".$_SESSION['arrPracticaActiva']['puntosMaximos']."',
			descripcion='".$_SESSION['arrPracticaActiva']['descripcion']."',
			experiencia='".$_SESSION['arrPracticaActiva']['experiencia']."',
			sustentabilidad='".$_SESSION['arrPracticaActiva']['sustentabilidad']."',
			competitividad='".$_SESSION['arrPracticaActiva']['competitividad']."',
			variaciones='".$_SESSION['arrPracticaActiva']['variaciones']."',
			aprenderMas='".$_SESSION['arrPracticaActiva']['aprenderMas']."',
			ejemplosCumplimiento='".$_SESSION['arrPracticaActiva']['ejemplosCumplimiento']."'
			where id=".$_SESSION['arrPracticaActiva']['id'];

	$dbTmp->query($sql);
}


if(isset($_POST['accion']) && $_POST['accion']=='buscarPractica'){

	$sql="select * from bp_buenasPracticas where id=".$_POST['practica'];
	$resultado=$dbTmp->query($sql);
	$_SESSION['arrPracticaActiva']=$resultado->fetch_assoc();
}
if(!isset($_SESSION['arrPracticas'])){
	echo "no hay sesion<br>";
}


if(!isset($_SESSION['arrPracticas']) or count($_SESSION['arrPracticas'])==0){

	$sql="select id,tituloCorto from bp_buenasPracticas order by orden";
	$resultado=$dbTmp->query($sql);
	while($linea=$resultado->fetch_assoc()){
		$_SESSION['arrPracticas'][]=array('id'=>$linea['id'],'nombre'=>$linea['id']." - ".$linea['tituloCorto']);
	}
}
if(!isset($_SESSION['arrPracticaActiva'])){
	$_SESSION['arrPracticaActiva']=array();
}
if(!isset($_SESSION['fx'])){
	$_SESSION['fx']=new FxFormularios();
}

//print"<pre>";
//print_r($_POST);
//print"</pre>";

?>




<!DOCTYPE html>
<html>
<head>
	<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
	<title>Llenado Buenas Prácticas</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="../includes/estilos.css" rel="stylesheet" type="text/css">

	<!-- Iconos -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

	<script type="text/javascript" src="http://code.jquery.com/jquery.min.js" charset="utf-8"></script>

</head>


<?php //echo "$bodyEtiqueta";  ?>
<body link='White' vlink='White' alink='White' bgcolor='#FFFFFF'>
<div id="Contenido">
	<form action ="llenadoPracticas.php" method="post" name ="<?php echo (NOMBRE_FORMULARIO);?>" target="_self" enctype="multipart/form-data">
		<input type="hidden" name ="accion" value ="">
		<input type="hidden" name ="subaccion" value ="">
		<input type="hidden" name ="registroActivo" value ="">
		<input type="hidden" name ="item" value ="">
		<input type="hidden" name ="subItem" value ="">
		<input type="hidden" name ="permisos" value ="">
		<?php include ('practicasPantalla.php') ?>

	</form>
	<script>
		CKEDITOR.replace('descripcion');
		CKEDITOR.replace('experiencia');
		CKEDITOR.replace('sustentabilidad');
		CKEDITOR.replace('competitividad');
		CKEDITOR.replace('variaciones');
		CKEDITOR.replace('aprenderMas');
		CKEDITOR.replace('ejemplosCumplimiento');
	</script>

</div>

<?php
//print"<pre>";
//	echo "post";
//		print_r($_POST);
//	print"</pre>";
//
//
//
//print"<pre>";
//echo "sesion";
//	print_r($_SESSION);
//print"</pre>";
?>

</body>
</html>