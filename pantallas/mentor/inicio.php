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
		Bienvenido <?php echo ($this->mentor->datos['nombre']); ?>
	</div>
	<div class="tituloDesempeno">
		Pagina principal de cada mentor
	</div>
	<div class="espacioArriba"></div>


	<div id="ColIzquierda30">

		<div class="tituloDesempeno">
			Empresas supervisadas:
		</div>

		<?php for($x=0;$x<count($this->mentor->arrEmpresasSupervisadas);$x++) {?>
			<div id="textoLateralIzq">
				<?php $this->fx->ponerBoton('mentor', 'irAEmpresa', $this->mentor->arrEmpresasSupervisadas[$x]['id'], $this->mentor->arrEmpresasSupervisadas[$x]['nombreEmpresa'], NULL, NULL, NULL, 'btn', 0);?>
			</div>
		<?php } ?>
	</div>

	<div id="ColDerecha70">
		Lista de eventos nuevos desde el uptimo login del mentor
	</div>


	<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
</div>
<?php $this->fx->ponerBoton('mentor','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);?>







