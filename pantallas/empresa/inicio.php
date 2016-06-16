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

$anchoTotalGrafica=250;

if(isset($this->empresa->datosNuevosGraficas['arrEmpresa']['puntosUnoTerminadas'])){
	$porcentajeEmpresaGenerales=
		($this->empresa->datosNuevosGraficas['arrEmpresa']['puntosUnoTerminadas']/
		$this->empresa->datosNuevosGraficas['arrTotalesPosibles']['uno'])*100;
}else{
	$porcentajeEmpresaGenerales=0;
}
if(isset($this->empresa->datosNuevosGraficas['arrEmpresa']['puntosDosTerminadas'])){
	$porcentajeEmpresaInstalaciones=
		($this->empresa->datosNuevosGraficas['arrEmpresa']['puntosDosTerminadas']/
		$this->empresa->datosNuevosGraficas['arrTotalesPosibles']['dos'])*100;
}else {
	$porcentajeEmpresaInstalaciones = 0;
}
if(isset($this->empresa->datosNuevosGraficas['arrEmpresa']['puntosTresTerminadas'])){
	$porcentajeEmpresaActividades=
		($this->empresa->datosNuevosGraficas['arrEmpresa']['puntosTresTerminadas']/
		$this->empresa->datosNuevosGraficas['arrTotalesPosibles']['tres'])*100;
}else{
	$porcentajeEmpresaActividades=0;
}

$porcentajeTodasGenerales=
	($this->empresa->datosNuevosGraficas['arrTodasEmpresas']['puntosUnoTerminadas']/
		$this->empresa->datosNuevosGraficas['arrTotalesPosibles']['uno'])*100;
$porcentajeTodasInstalaciones=
	($this->empresa->datosNuevosGraficas['arrTodasEmpresas']['puntosDosTerminadas']/
		$this->empresa->datosNuevosGraficas['arrTotalesPosibles']['dos'])*100;
$porcentajeTodasActividades=
	($this->empresa->datosNuevosGraficas['arrTodasEmpresas']['puntosTresTerminadas']/
		$this->empresa->datosNuevosGraficas['arrTotalesPosibles']['tres'])*100;
?>
<script src="https://code.jquery.com/jquery-latest.min.js"></script>


<div id="empresas">
	<div class="titulo">
		Bienvenido "<?php echo ($this->empresa->datos['nombreEmpresa']); ?>"
	</div>

	<div id="ladoIzquierdo70">
		<?php if(strlen($this->empresa->datos['foto'])>0){
			echo"<img src='".FOLDER_IMAGENES_EMPRESAS.$this->empresa->datos['foto']."' width='500px'/>";
		}?>
	</div>
	<div id="ladoDerecho30">
		<div class="tituloGraficaEmpresa">
			El desempeño sustentable en los siguientes requisitos de la NMX 133 es:
		</div>
		<table border="0" width="355" id="graficaEmpresa" >
			<tr>
				<td class="altoGraficaEmpresa">
					&nbsp;
				</td>
			</tr>


			<tr>
				<td width="90px" class="textoGraficaEmpresa">
					Requisitos generales
				</td>
				<td width="260px" class="altoGraficaEmpresa">
					<?php
						$anchoEmpresa=$porcentajeEmpresaGenerales*$anchoTotalGrafica/100;
						$anchoTodas=$porcentajeTodasGenerales*$anchoTotalGrafica/100;
						echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresa px\"/>&nbsp;&nbsp;".number_format($porcentajeEmpresaGenerales,2);
						echo "<br>";
						echo "<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"$anchoTodas px\"/>&nbsp;&nbsp;".number_format($porcentajeTodasGenerales,2);
					?>
				</td>
			</tr>
			<tr>
				<td class="textoGraficaEmpresa">
					Requisitos de las instalaciones
				</td>
				<td class="altoGraficaEmpresa">
					<?php
						$anchoEmpresa=$porcentajeEmpresaInstalaciones*$anchoTotalGrafica/100;
						$anchoTodas=$porcentajeTodasInstalaciones*$anchoTotalGrafica/100;
						echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresa px\"/>&nbsp;&nbsp;".number_format($porcentajeEmpresaInstalaciones,2);
						echo "<br>";
						echo "<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"$anchoTodas px\"/>&nbsp;&nbsp;".number_format($porcentajeTodasInstalaciones,2);
					?>
				</td>
			</tr>
			<tr>
				<td class="textoGraficaEmpresa">
					Requisitos de las actividades
				</td>
				<td class="altoGraficaEmpresa">
					<?php
						$anchoEmpresa=$porcentajeEmpresaActividades*$anchoTotalGrafica/100;
						$anchoTodas=$porcentajeTodasActividades*$anchoTotalGrafica/100;
						echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresa px\"/>&nbsp;&nbsp;".number_format($porcentajeEmpresaActividades,2);
						echo "<br>";
						echo "<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"$anchoTodas px\"/>&nbsp;&nbsp;".number_format($porcentajeTodasActividades,2);
					?>
				</td>
			</tr>
		</table>

		<div class="textoGraficaEmpresa"><br>
			<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"15 px\"/>&nbsp;&nbsp; Tu empresa
			<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"15 px\"/>&nbsp;&nbsp;Empresas similares
		</div>
		<div class="tituloGraficaEmpresa">
			<br>Si deseas incrementar el desempeño de tu empresa, agrega  más prácticas de sustentabilidad
		</div>

	</div>
	<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<?php
		// lineas de informacion faltante

		$leyendaFaltantes='';
		if($this->empresa->datos['infoCapturada']==0){
			$leyendaFaltantes.="Recuerde que debe capturar la información de su empresa para poder continuar";
		}
		if($this->empresa->datos['autoevaluacionHecha']==0){
			if(strlen($leyendaFaltantes)>0) $leyendaFaltantes.="<br>";
			$leyendaFaltantes.="Recuerde que debe realizar la autoevaluación de su empresa para poder continuar";
		}
		if(strlen($leyendaFaltantes)>0){
			echo "<div class=\"leyendaFaltantes\">";
				echo "$leyendaFaltantes";
		echo "</div>";
	} ?>



	<div class="espacioArriba"></div>

	<div class="tab-panels">
		<ul class="tabs">
			<li rel="completadas" class="active">Prácticas completadas</li>
			<li rel="enProceso">Prácticas en proceso</li>
			<li rel="otras">Otras que agregar</li>
		</ul>

		<div id="completadas" class="panel active textoDelgado">
			<?php
				echo "<table>";
					echo "<tr>";
						echo "<td class='tituloTablaEmpresa' width='500px'>";
							echo "Practica";
						echo "</td>";
						echo "<td class='tituloTablaEmpresa' width='200px'>";
							echo "Fecha de inicio";
						echo "</td>";
						echo "<td class='tituloTablaEmpresa' width='200px'>";
							echo "Fecha de aprobación";
						echo "</td>";
					echo "</tr>";
					for($x=0;$x,$x<count($this->empresa->arrPracticasTerminadas);$x++){
						$fechaInicioBien=$this->fx->transformarFechaDMY($this->empresa->arrPracticasTerminadas[$x]['fechaIncio']);
						$fechaAprobacionBien=$this->fx->transformarFechaDMY($this->empresa->arrPracticasTerminadas[$x]['fechaAprobacion']);
						echo "<tr>";
							echo "<td class='practicaDesempeno textoTerminada'>";

								//echo "<div class='practicaDesempeno textoTerminada'>";
								echo ($this->empresa->arrPracticasTerminadas[$x]['nombrePractica']);
								//echo "</div>";
							echo "</td>";

							echo "<td class='fechaDesempeno'>";
								echo ($fechaInicioBien);
							echo "</td>";
							echo "<td class='fechaDesempeno'>";
								echo ($fechaAprobacionBien);
							echo "</td>";
						//echo "<div class='lineaDelgada'></div>";
						echo "</tr>";
					}

				echo "</table>";
			?>
		</div>
		<div id="enProceso" class="panel textoDelgado">
			<?php
			echo "<table>";
				echo "<tr>";
					echo "<td class='tituloTablaEmpresa' width='500px'>";
						echo "Practica";
					echo "</td>";
					echo "<td class='tituloTablaEmpresa' width='200px'>";
						echo "Fecha de inicio";
					echo "</td>";
					echo "<td class='tituloTablaEmpresa' width='200px'>";
						echo "Fecha de vencimiento";
					echo "</td>";
				echo "</tr>";
				for($x=0;$x,$x<count($this->empresa->arrPracticasEnProceso);$x++){
					$fechaBien=$this->fx->transformarFechaDMY($this->empresa->arrPracticasEnProceso[$x]['fechaIncio']);
					$fechaVencimiento=$this->fx->definirFechaVencimiento($this->empresa->arrPracticasEnProceso[$x]['fechaIncio']);
					echo "<tr>";
						echo "<td class='practicaDesempeno textoEnProceso'>";
							echo ($this->empresa->arrPracticasEnProceso[$x]['nombrePractica']);
						echo "</td>";

						echo "<td class='fechaDesempeno'>";
							echo ($fechaBien);
						echo "</td>";

						echo "<td class='fechaVencimiento'>";
							echo ($fechaVencimiento);
						echo "</td>";
				}
			echo "</table>";
			?>
		</div>
		<div id="otras" class="panel textoDelgado">
			<table border="0">
				<?php for($x=0;$x<count($this->arrListaPracticas);$x++){?>
					<tr>
						<td id='seccionCategoria' width='500px' colspan="2">
							<?php echo ($this->arrListaPracticas[$x]['nombreCategoria']);?>
						</td>
					</tr>
					<?php
						for($y=0;$y<count($this->arrListaPracticas[$x]['practicas']);$y++) {
							if ($this->arrListaPracticas[$x]['practicas'][$y]['idEmpresaBuenaPractica'] >0) {
							} else { ?>
								<tr>
									<td id='seccionPractica' width='450px'>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<?php $this->fx->ponerBoton('general', 'irAPractica', $this->arrListaPracticas[$x]['practicas'][$y]['idPractica'], $this->arrListaPracticas[$x]['practicas'][$y]['nombrePractica'], NULL, NULL, NULL, 'seccionPractica', 0); ?>
									</td>
									<td id='seccionPractica' width='50px'>
										<?php $this->fx->ponerBoton('empresa', 'agregarPracticaDePaginaPrincipal', $this->arrListaPracticas[$x]['practicas'][$y]['idPractica'],null, 'imagenes/generales/agregar.png', '12', '12', 'seccionPractica', 0); ?>
									</td>
								</tr>
							<?php } ?>
					<?php } ?>
				<?php } ?>
			</table>
		</div>
	</div>

	<div id="saltoDeRenglon"></div>


&nbsp;
























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