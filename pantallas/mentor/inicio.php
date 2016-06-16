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
	<?php include ('inicioGral.php');?>



	<div id="ColDerecha70">
		<div class="tituloDesempeno">
			Lista de eventos nuevos desde el ultimo login del mentor
		</div>


		<?php for($x=0;$x<count($this->mentor->arrEventosNuevos);$x++) {
			$fecha=$this->fx->transformarFechaDMY($this->mentor->arrEventosNuevos[$x]['fecha'])
		?>
			<div id="saltoDeRenglon"></div>
			<div class="itemListaNuevosEventos">
				<span class="itemListaNuevosEventosFecha">
					<?php echo ("$fecha: &nbsp;") ;?>
				</span>
				<?php echo ($this->mentor->arrEventosNuevos[$x]['mensaje']) ?>
			</div>
		<?php } ?>


	</div>
	<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
</div>








