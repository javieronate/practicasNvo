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


//$datosTotales='['.$this->admon->estadisticasEmpresas['totales']['menosDe25'].','.
//	$this->admon->estadisticasEmpresas['totales']['menosDe50'].','.
//	$this->admon->estadisticasEmpresas['totales']['menosDe75'].','.
//	$this->admon->estadisticasEmpresas['totales']['menosDe100'].']';
//
//$datosAprobadas='['.$this->admon->estadisticasEmpresas['terminadas']['menosDe25'].','.
//	$this->admon->estadisticasEmpresas['terminadas']['menosDe50'].','.
//	$this->admon->estadisticasEmpresas['terminadas']['menosDe75'].','.
//	$this->admon->estadisticasEmpresas['terminadas']['menosDe100'].']';
//
//$datosEnProceso='['.$this->admon->estadisticasEmpresas['enProceso']['menosDe25'].','.
//	$this->admon->estadisticasEmpresas['enProceso']['menosDe50'].','.
//	$this->admon->estadisticasEmpresas['enProceso']['menosDe75'].','.
//	$this->admon->estadisticasEmpresas['enProceso']['menosDe100'].']';
//
//
$porcentaje=230/$this->admon->estadisticasPracticas['tamanoMaximo'];


$anchoTotalGrafica=300;
$porcentajeAdmonGenerales=
	($this->admon->estadisticasEmpresas['arrAdmin']['promedioUno']/
		$this->admon->estadisticasEmpresas['arrTotalesPosibles']['uno'])*100;
//$porcentajeAdmonGenerales=100;
$porcentajeAdmonInstalaciones=
	($this->admon->estadisticasEmpresas['arrAdmin']['promedioDos']/
		$this->admon->estadisticasEmpresas['arrTotalesPosibles']['dos'])*100;
$porcentajeAdmonActividades=
	($this->admon->estadisticasEmpresas['arrAdmin']['promedioTres']/
		$this->admon->estadisticasEmpresas['arrTotalesPosibles']['tres'])*100;

$porcentajeTodasGenerales=
	($this->admon->estadisticasEmpresas['arrTodas']['promedioUno']/
		$this->admon->estadisticasEmpresas['arrTotalesPosibles']['uno'])*100;
$porcentajeTodasInstalaciones=
	($this->admon->estadisticasEmpresas['arrTodas']['promedioDos']/
		$this->admon->estadisticasEmpresas['arrTotalesPosibles']['dos'])*100;
$porcentajeTodasActividades=
	($this->admon->estadisticasEmpresas['arrTodas']['promedioTres']/
		$this->admon->estadisticasEmpresas['arrTotalesPosibles']['tres'])*100;



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



		<table border="0" width="430" id="graficaEmpresa2" >
			<tr>
				<td class="altoGraficaEmpresa">
					&nbsp;
				</td>
			</tr>


			<tr>
				<td width="90px" class="textoGraficaEmpresa">
					Requisitos generales
				</td>
				<td width="340px" class="altoGraficaEmpresa">
					<?php
					$anchoEmpresasAdmon=$porcentajeAdmonGenerales*$anchoTotalGrafica/100;
					$anchoTodas=$porcentajeTodasGenerales*$anchoTotalGrafica/100;
					if($this->admon->datos['nivelId']==2) {
						echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresasAdmon px\"/>&nbsp;&nbsp;".number_format($porcentajeAdmonGenerales, 2);
						echo "<br>";
					}
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
					$anchoEmpresasAdmon=$porcentajeAdmonInstalaciones*$anchoTotalGrafica/100;
					$anchoTodas=$porcentajeTodasInstalaciones*$anchoTotalGrafica/100;
					if($this->admon->datos['nivelId']==2) {
						echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresasAdmon px\"/>&nbsp;&nbsp;".number_format($porcentajeAdmonInstalaciones, 2);
						echo "<br>";
					}
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
					$anchoEmpresasAdmon=$porcentajeAdmonActividades*$anchoTotalGrafica/100;
					$anchoTodas=$porcentajeTodasActividades*$anchoTotalGrafica/100;
					if($this->admon->datos['nivelId']==2) {
						echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresasAdmon px\"/>&nbsp;&nbsp;".number_format($porcentajeAdmonActividades, 2);
						echo "<br>";
					}
					echo "<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"$anchoTodas px\"/>&nbsp;&nbsp;".number_format($porcentajeTodasActividades,2);
					?>
				</td>
			</tr>
		</table>
		<?php if($this->admon->datos['nivelId']==2) {?>
			<div class="textoGraficaEmpresa"><br>
				<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"15 px\"/>&nbsp;&nbsp; Tus empresas
				<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"15 px\"/>&nbsp;&nbsp;Empresas similares
			</div>
		<?php } ?>





























		<!--<table width="100%" border="0">-->
		<!--	<tr>-->
		<!--		<td align="center" width="33%">-->
		<!--			<div id="canvas-holder" style="width: 70px;">-->
		<!--				<canvas id="myChart" width="50px" height="50px"></canvas>-->
		<!--			</div>-->
		<!--		</td>-->
		<!--		<td align="center" width="33%">-->
		<!--			<div id="canvas-holder" style="width: 70px;">-->
		<!--				<canvas id="myChart2" width="50px" height="50px"></canvas>-->
		<!--			</div>-->
		<!--		</td>-->
		<!--		<td align="center" width="33%">-->
		<!--			<div id="canvas-holder" style="width: 70px;">-->
		<!--				<canvas id="myChart3" width="50px" height="50px"></canvas>-->
		<!--			</div>-->
		<!--		</td>-->
		<!--	</tr>-->
		<!--	<tr>-->
		<!--		<td class="seccionPractica" align="center">-->
		<!--			Totales por empresa-->
		<!--		</td>-->
		<!--		<td class="seccionPractica" align="center">-->
		<!--			Aprobadas por empresa-->
		<!--		</td>-->
		<!--		<td class="seccionPractica" align="center">-->
		<!--			En proceso por empresa-->
		<!--		</td>-->
		<!--	</tr>-->
		<!--	<tr>-->
		<!--		<td class="seccionPractica" align="center">-->
		<!--			&nbsp;-->
		<!--		</td>-->
		<!--	</tr>-->
		<!--	<tr>-->
		<!--		<td colspan="3">-->
		<!--			<table border="0" width="100%">-->
		<!--				<tr>-->
		<!--					<td class="seccionPractica" align="center">-->
		<!--						<img src='imagenes/generales/simbologiaVerde.png' height='20px' />-->
		<!--						75%-100%-->
		<!--					</td>-->
		<!--					<td class="seccionPractica" align="center">-->
		<!--						<img src='imagenes/generales/simbologiaAzul.png' height='20px' />-->
		<!--						50%-75%-->
		<!--					</td>-->
		<!--					<td class="seccionPractica" align="center">-->
		<!--						<img src='imagenes/generales/simbologiaAmarillo.png' height='20px' />-->
		<!--						25%-50%-->
		<!--					</td>-->
		<!--					<td class="seccionPractica" align="center">-->
		<!--						<img src='imagenes/generales/simbologiaRojo.png' height='20px' />-->
		<!--						0%-25%-->
		<!--					</td>-->
		<!--				</tr>-->
		<!--			</table>-->
		<!--		</td>-->
		<!--	</tr>-->
		<!--</table>-->

		<div class="espacioArriba"></div>
		<div class="tituloDesempeno">
			Donde y quienes:
		</div>

		<div id="map"></div>
	</div>

	<div id="adminColDerecha" >


		<div class="tituloLateralDer">
			El estado de las prácticas es:
		</div>
		<!--<div class="espacioArriba"></div>-->
		<div class="textoLateralDer">

			<table border="0">
				<tr>
					<td>
						<table border="0" width="400">

						<?php for($x=0;$x<count($this->admon->estadisticasPracticas)-1;$x++){?>
							<tr>
								<td colspan="2">
									<div id="seccionCategoria">
										<?php echo ($this->admon->estadisticasPracticas[$x]['nombreCategoria']);?>
									</div>
								</td>
							</tr>

							<?php
							for($y=0;$y<count($this->admon->estadisticasPracticas[$x]['practicas']);$y++) {
							echo "<tr >";
								echo "<td width=\"150\">";
									echo "<div class='seccionPractica'>";
										echo ($this->admon->estadisticasPracticas[$x]['practicas'][$y]['nombrePractica']);
									echo "</div>";
								echo "</td>";
								echo "<td>";
									$anchoTerminadas=$porcentaje*$this->admon->estadisticasPracticas[$x]['practicas'][$y]['completadasTotal'];
									$anchoEnProceso=$porcentaje*$this->admon->estadisticasPracticas[$x]['practicas'][$y]['enProcesoTotal'];
									echo "<img src='imagenes/generales/barraAzul.jpg' height='10px' width=\"$anchoTerminadas px\"/>";
									echo "<span class='seccionPractica'>";
										echo "&nbsp;&nbsp;".$this->admon->estadisticasPracticas[$x]['practicas'][$y]['completadasTotal']."<br>";
									echo "</span>";
									echo "<img src='imagenes/generales/barraCafe.jpg' height='10px' width=\"$anchoEnProceso px\"/>";
									echo "<span class='seccionPractica'>";
										echo "&nbsp;&nbsp;".$this->admon->estadisticasPracticas[$x]['practicas'][$y]['enProcesoTotal']."<br>";
									echo "</span>";
									if($this->admon->nivel==2){
										$anchoTerminadasRegion=$porcentaje*$this->admon->estadisticasPracticas[$x]['practicas'][$y]['completadasRegional'];
										$anchoEnProcesoRegion=$porcentaje*$this->admon->estadisticasPracticas[$x]['practicas'][$y]['enProcesoRegional'];
										echo "<img src='imagenes/generales/barraVerde.jpg' height='10px' width=\"$anchoTerminadasRegion px\"/>";
										echo "<span class='seccionPractica'>";
											echo "&nbsp;&nbsp;".$this->admon->estadisticasPracticas[$x]['practicas'][$y]['completadasRegional']."<br>";
										echo "</span>";
										echo "<img src='imagenes/generales/barraMorada.jpg' height='10px' width=\"$anchoEnProcesoRegion px\"/>";
										echo "<span class='seccionPractica'>";
											echo "&nbsp;&nbsp;".$this->admon->estadisticasPracticas[$x]['practicas'][$y]['enProcesoRegional']."<br>";
										echo "</span>";
									}
								echo "</td>";
							echo "</tr>";
							echo "<tr>";
								echo "<td>";
								echo "&nbsp;";
								echo "</td>";
							echo "</tr>";
							}
						} ?>

						</table>
					</td>
				</tr>
			</table>
		</div>&nbsp;
	</div>
	<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
</div>




<script>


	var confTotales = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: <?php echo $datosTotales; ?>,
				backgroundColor: [
					"#c92127",
					"#f7e675",
					"#3092d7",
					"#20af82",
				],
			}],
			labels: [
				"Red",
				"Green",
				"Yellow",
				"Grey",
			]
		},
		options: {
			responsive: true,
			legend: {
				display: false
			},
			tooltips: {
				enabled: false,
			}
		}
	};
	var confAprobadas = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: <?php echo $datosAprobadas; ?>,
				backgroundColor: [
					"#c92127",
					"#f7e675",
					"#3092d7",
					"#20af82",
				],
			}],
			labels: [
				"Red",
				"Green",
				"Yellow",
				"Grey",
			]
		},
		options: {
			responsive: true,
			legend: {
				display: false
			},
			tooltips: {
				enabled: false,
			}
		}
	};

	var confEnProceso = {
		type: 'doughnut',
		data: {
			datasets: [{
				data: <?php echo $datosEnProceso; ?>,
				backgroundColor: [
					"#c92127",
					"#f7e675",
					"#3092d7",
					"#20af82",
				],
			}],
			labels: [
				"Red",
				"Green",
				"Yellow",
				"Grey",
			]
		},
		options: {
			responsive: true,
			legend: {
				display: false
			},
			tooltips: {
				enabled: false,
			}
		}
	};


	var ctx = document.getElementById("myChart").getContext("2d");
	var myChart = new Chart(ctx,confTotales);
	var ctx = document.getElementById("myChart2").getContext("2d");
	var myChart2 = new Chart(ctx,confAprobadas);
	var ctx = document.getElementById("myChart3").getContext("2d");
	var myChart2 = new Chart(ctx,confEnProceso);
</script>