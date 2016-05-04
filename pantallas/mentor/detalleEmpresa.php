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

$jom2='';
?>
	<div id="empresas">
		<div class="titulo">
			Bienvenido Mentor
		</div>
		<div class="subtitulo">
			Pagina de detalle de evaluacion de una empresa
		</div>
		<div class="espacioArriba"></div>

		<div class="tituloDesempeno">
			Lista de practicas autorizadas para la empresa:
		</div>
		<div class="espacioArriba"></div>
		<div class="tituloDesempeno">
			Lista de practicas en proceso para la empresa:
		</div>
		<div class="texto">
			En esta página se muestran las evidencias presentadas por la empresa, detallando las autorizadas y las pendientes de autorizar. <br>
			Es una presentación completa de la historia de los procesos de la empresa y sus buenas practicas.<br>
			Aqui se puede revisar nuevas evidencias, autorizarlas o rechazarlas y aprobar o rechazar una buena practica.
		</div>

		<div id="saltoDeRenglon"></div>
		<div class="espacioArriba"></div>
		<div class="espacioArriba"></div>
	</div>


<?php $this->fx->ponerBoton('mentor','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);?>