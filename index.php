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

if(isset($_POST['accion']) && $_POST['accion']=='mentor' && $_POST['subaccion']=='abrirEvidencia' ){
	$bodyEtiqueta="<body link=\"#FFFFFF\" vlink=\"#FFFFFF\" alink=\"#FFFFFF\" onload=\"javascript: window.open('".$_POST['item']."','_blank','AtentaNota','width=300,height=200')\">";
}else{
	$bodyEtiqueta="<body link='White' vlink='White' alink='White' bgcolor='#FFFFFF'>";
}



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

	<!--mapas admon-->
	<?php  if(isset($_SESSION['controlador']->admon->id)){?>
		<script
			src="https://maps.googleapis.com/maps/api/js?libraries=visualization">
		</script>
		<script>
			var map;

			function initialize() {
				map = new google.maps.Map(document.getElementById('map'), {
					zoom: 5,
					center: new google.maps.LatLng(28.245182,-110.223418),
					mapTypeId: google.maps.MapTypeId.TERRAIN
				});

				// Create a <script> tag and set the USGS URL as the source.
				var script = document.createElement('script');
				// (In this example we use a locally stored copy instead.)
				// script.src = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp';
				script.src = './json/geoJson.php';
				document.getElementsByTagName('head')[0].appendChild(script);

			}

			// Loop through the results array and place a marker for each
			// set of coordinates.
			window.eqfeed_callback = function(results) {
				var infowindow = new google.maps.InfoWindow();
				for (var i = 0; i < results.features.length; i++) {
					var coords = results.features[i].geometry.coordinates;
					var latLng = new google.maps.LatLng(coords[0],coords[1]);
					var nombre = results.features[i].properties.nombreEmpresa;
					var marker = new google.maps.Marker({
						position: latLng,
						icon: './imagenes/generales/pin7R.png',
						title: results.features[i].properties.nombreEmpresa,
						map: map
					});
					google.maps.event.addListener(marker, 'click', (function(marker, i) {
						return function() {
							var contenido="<div class='empresaMapa'>" + results.features[i].properties.nombreEmpresa + "</div>";
							contenido = contenido +"<div class='contactoMapa'>" + results.features[i].properties.contactoNombre + "</div>";
							contenido = contenido +"<div class='textoMapa'>" + results.features[i].properties.telefono + "</div>";
							contenido = contenido +"<div class='textoMapa'>" + results.features[i].properties.correos + "</div>";
							contenido = contenido +"<div class='textoMapa'>" + results.features[i].properties.sitioWeb + "</div>";
							contenido = contenido +"<div class='textoMapa'> Fecha de creación: " + results.features[i].properties.fechaCreacion + "</div>";
							contenido = contenido +"<div class='textoMapa'> Ultima vez que entro al sitio: " + results.features[i].properties.ultimoLogin + "</div>";

							infowindow.setContent(contenido);
							infowindow.open(map, marker);
						}
					})(marker, i));
				}

			}
			google.maps.event.addDomListener(window, 'load', initialize)
		</script>
	<?php } ?>
</head>


<?php echo "$bodyEtiqueta";  ?>
<!--<body link='White' vlink='White' alink='White' bgcolor='#FFFFFF'>-->
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

