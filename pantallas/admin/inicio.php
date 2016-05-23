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
 *
 */

/**
 *
 * Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * @author  Javier Oñate Mendía (Dédalo)
 *
 */

$jom2='';
// TODO: Función que represente el desempeño de cada práctica en una gráfica
// TODO: Función que represente el desempeño sustentable de todas las prácticas en una gráfica
// TODO: Función que represente estadísticas básicas de todas las prácticas en una gráfica
// TODO: Función que represente en un mapa las localizaciones de las empresas
?>


<div id="empresas">
	<div class="titulo">
		Bienvenido <?php echo ($this->admon->datos['nombre']);   ?>
	</div>
	<div class="subtitulo">
		La adopción de buenas prácticas del ecoturismo
	</div>
	<div class="espacioArriba"></div>
	<div id="adminColIzquierda" >
		<div class="tituloDesempeno">
			El desempeño sustentable de las empresas participantes es:
		</div>

		<div class="texto">
			Aqui va una gráfica de desempeño
		</div>
		<div class="espacioArriba"></div>
		<div class="tituloDesempeno">
			Estadísticas básicas:
		</div>

		<div class="texto">
			Aqui va una sumatoria de empresas participantes, practicas promedio aprobadas mínimo y máximo de practicas
		</div>
		<div class="espacioArriba"></div>
		<div class="tituloDesempeno">
			Donde y quienes:
		</div>

		<div id="map">


		</div>
	</div>
	<!--<div id="EmpresaColCentroArriba">-->
	<!--	centro-->
	<!--</div>-->
	<div id="adminColDerecha" >
		<div class="tituloDesempeno">
			El estado de las prácticas es::<br>
		</div>
		<div class="texto">
			Aqui va una lista que muestra el número de aprobaciones por cada práctica
		</div>
	</div>
	<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
</div>

<?php $this->fx->ponerBoton('admin','irA','manejoMentor','Mentores',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('admin','llenarDatos','','Llenar datos',NULL,NULL,NULL,'btn btn-primary',0);?>

