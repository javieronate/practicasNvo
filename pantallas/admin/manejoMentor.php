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
		Bienvenido Administrador
	</div>
	<div class="subtitulo">
		Manejo de mentores
	</div>
	<div class="texto">
		Esta página no esta incluida en los terminos de referencia ni en el documento Micrositio buenas practicas,
		pero se requiere dado que el administador es el que habilita a los mentores.<br>
		En esta se administran altas y bajas de mentores,
	</div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>

</div>

<?php $this->fx->ponerBoton('admin','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);?>
