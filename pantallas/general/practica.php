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
			Registra esta practica
		</div>
		<div class="textoLateralIzq">
			Muestra tu desempeño sustentable al registrar esta práctica en las operaciones de tu empresa
		</div>
	</div>

	<div id="ColCentroArriba">
		<div class="texto">
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

				<div id="experiencia" class="panel active">
					<?php echo ($this->arrDatosPaginaPractica['experiencia']);?>
				</div>
				<div id="sustentabilidad" class="panel">
					<?php echo ($this->arrDatosPaginaPractica['sustentabilidad']);?>
				</div>
				<div id="competitividad" class="panel">
					<?php echo ($this->arrDatosPaginaPractica['competitividad']);?>
				</div>
			</div>

			<div class="subtitulo">
				Ejemplos del cumplimiento de esta práctica
			</div>
			<div class="texto">
				Falta ligar a lista de items
			</div>
		</div>

		<div id="ColCentroAbajo" >
			<div class="subtitulo">
				Criterios de cumplimiento de esta práctica
			</div>
			<div class="texto">
				<?php
					for($x=0;$x<count($this->arrDatosPaginaPractica['criterios']);$x++){
						echo ($this->arrDatosPaginaPractica['criterios'][$x]['nombre']."<br>");
					}
				?>
			</div>



		</div>

	</div>

	<div id="ColDerecha" >
		<div class="tituloLateralDer">
			Registra esta practica
		</div>
		<div class="textoLateralDer">
			aqui va mapa de lugares
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>
		<div class="tituloLateralDer">
			Aprender más
		</div>
		<div class="textoLateralDer">
			aqui va lista de aprender mas
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>
		<div class="tituloLateralDer">
			Variaciones
		</div>
		<div class="textoLateralDer">
			<?php echo ($this->arrDatosPaginaPractica['variaciones']);?>
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>
		<div class="tituloLateralDer">
			Imprimir
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>

		<div class="empresaTitulo">
			<?php $this->fx->ponerBoton('general','irACategoria',$this->arrDatosPaginaPractica['categoriaId'],'Regresar',NULL,NULL,NULL,'btn btn-primary',0); ?>
			<?php $this->fx->ponerBoton('empresa','irA','inicio','Regresar',NULL,NULL,NULL,'btn btn-primary',0); ?>
		</div>
	</div>



</div>
<div class="">

</div>

<?php //$this->fx->ensenarArreglo($this->arrDatosPaginaCategoria,"arrDatosPaginaCategoria");?>

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