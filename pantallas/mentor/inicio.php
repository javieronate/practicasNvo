<?php
/**
 *
 * Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */

$jom2='';
?>

<div id="empresas">
	<div class="titulo">
		Bienvenido Mentor
	</div>
	<div class="subtitulo">
		Pagina principal de cada mentor
	</div>
	<div class="espacioArriba"></div>

	<div class="tituloDesempeno">
		Lista de empresas supervisadas por el mentor:
	</div>

	<div class="texto">
		En esta pagina se muestra el estado general de las empresas supervisadas por el mentor,
		y se indica si hay alguna evidencia nueva que autorizar.<br>
	</div>

	<div id="listaBotones">
		<?php $this->fx->ponerBoton('mentor','irAEmpresa','1','Turismo Del Golfo',NULL,NULL,NULL,'btn',0); ?>
	</div>
	<div id="listaBotones">
		<?php $this->fx->ponerBoton('mentor','irAEmpresa','2','Avistadores de ballenas',NULL,NULL,NULL,'btn',0); ?>
	</div>
	<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
</div>
<?php $this->fx->ponerBoton('mentor','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);?>







