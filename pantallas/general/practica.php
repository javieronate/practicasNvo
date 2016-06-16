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

<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<div class="categorias">

	<div class="titulo">
		<?php echo ($this->arrDatosPaginaPractica['titulo']); ?>
	</div>


	<div id="ColIzquierda" >
		<img src="<?php echo (FOLDER_IMAGENES_PRACTICAS.$this->arrDatosPaginaPractica['imagen1']);?>" border="1" align="left" width="150px"/>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<div class="tituloLateralIzq">
			<img src="imagenes/generales/registro.png " width='160px'>
		</div>
		<div class="textoLateralIzq">

			<?php $this->fx->ponerBoton('general', 'irA', 'login','Muestra tu desempeño sustentable al registrar esta práctica en las operaciones de tu empresa', NULL, NULL, NULL, 'textoLateralIzq', 0); ?>
		</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<img src="<?php echo (FOLDER_IMAGENES_PRACTICAS.$this->arrDatosPaginaPractica['imagen2']);?>" border="1" align="left" width="150px"/>
	</div>

	<div id="ColCentroArriba">
		<div class="textoDelgado">
			<?php echo ($this->arrDatosPaginaPractica['descripcion']);?>
		</div>

		<div id="ColCentroCentro">

			<div class="subtitulo">
				De que manera, esta práctica contribuye a:
			</div>


			<div class="tab-panels">
				<ul class="tabs">
					<li rel="experiencia" class="active">Elevar la experiencia de visitantes</li>
					<li rel="sustentabilidad">La sustentabilidad</li>
					<li rel="competitividad">La competitividad</li>
				</ul>

				<div id="experiencia" class="panel active textoDelgado">
					<?php echo ($this->arrDatosPaginaPractica['experiencia']);?>
				</div>
				<div id="sustentabilidad" class="panel textoDelgado">
					<?php echo ($this->arrDatosPaginaPractica['sustentabilidad']);?>
				</div>
				<div id="competitividad" class="panel textoDelgado">
					<?php echo ($this->arrDatosPaginaPractica['competitividad']);?>
				</div>
			</div>

			<div class="subtitulo">
				Ejemplos del cumplimiento de esta práctica
			</div>
			<div class="textoDelgado">
				<?php echo ($this->arrDatosPaginaPractica['ejemplosCumplimiento']);?>
			</div>
		</div>

		<div id="ColCentroAbajo" >
			<div class="subtitulo">
				Requisitos de cumplimiento para esta práctica
			</div>
			<div class="textoDelgado">
				<ul>
				<?php
					for($x=0;$x<count($this->arrDatosPaginaPractica['criterios']);$x++){
						echo "<li>";
							echo ($this->arrDatosPaginaPractica['criterios'][$x]['nombre']."<br>");
						echo "</li>";
					}
				?>
				</ul>
			</div>



		</div>

	</div>

	<div id="ColDerecha" >
		<div class="imagenLateralDer">
			<img src="imagenes/generales/donde.png " width='160px'>
		</div>
		<div class="textoLateralDer">
			<?php echo ($this->arrDatosPaginaPractica['ANPAplicacion']);?>
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>
		<div class="imagenLateralDer">
			<img src="imagenes/generales/aprender.png " width='160px'>
		</div>
		<div class="textoLateralDer">
			<?php echo ($this->arrDatosPaginaPractica['aprenderMas']);?>
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>
		<div class="imagenLateralDer">
			<img src="imagenes/generales/variaciones.png " width='160px'>
		</div>
		<div class="textoLateralDer">
			<?php echo ($this->arrDatosPaginaPractica['variaciones']);?>
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>
		<div class="imagenLateralDer">
			<img src="imagenes/generales/imprimir.png " width='160px'>
		</div>
		<div class="textoLateralDer">
			<?php
			for($x=0;$x<count($this->arrDatosPaginaPractica['impresos']);$x++){
				echo "<a href='".FOLDER_IMPRESOS_PRACTICAS.$this->arrDatosPaginaPractica['impresos'][$x]['archivo']."' target='_blank'>";
				echo ($this->arrDatosPaginaPractica['impresos'][$x]['nombre']);
				echo "</a>";
				echo "<br>";
			}
			?>
		</div>
		<div class="espacioArriba">
			&nbsp;
		</div>
	</div>



</div>



<!--funcion para cambiar las pestañas-->
<script>
	$(function() {

		$('.tab-panels .tabs li').on('click', function() {

			var $panel = $(this).closest('.tab-panels');

			$panel.find('.tabs li.active').removeClass('active');
			$(this).addClass('active');

			//figure out which panel to show
			var panelToShow = $(this).attr('rel');

			//hide current panel
			$panel.find('.panel.active').slideUp(300, showNextPanel);

			//show next panel
			function showNextPanel() {
				$(this).removeClass('active');

				$('#'+panelToShow).slideDown(300, function() {
					$(this).addClass('active');
				});
			}
		});
	});
</script>