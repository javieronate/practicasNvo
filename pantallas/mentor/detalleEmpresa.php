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
				Situación de <?php echo ($this->arrEmpresaSeleccionada['nombreEmpresa']); ?>
			</div>


			<div class="tituloDesempeno">
				Lista de practicas autorizadas para la empresa:
			</div>
			<?php for($x=0;$x<count($this->arrEmpresaSeleccionada['practicas']);$x++) {
				if($this->arrEmpresaSeleccionada['practicas'][$x]['estatusId']==3) {
					$fechaInicio=$this->fx->transformarFechaDMY($this->arrEmpresaSeleccionada['practicas'][$x]['fechaIncio']);
					$fechaAprobacion=$this->fx->transformarFechaDMY($this->arrEmpresaSeleccionada['practicas'][$x]['fechaAprobacion']);
					echo("<div id='textoPractica'>".$this->arrEmpresaSeleccionada['practicas'][$x]['buenapracticaId']." - ".$this->arrEmpresaSeleccionada['practicas'][$x]['nombrePractica']."</div>");
					echo "<div id='textoDatos'>Inicio: ".$fechaInicio." - Aprovación: ".$fechaAprobacion."</div>";
				}
			}?>





			<div class="espacioArriba"></div>
			<div class="tituloDesempeno">
				Lista de practicas en proceso para la empresa:
			</div>

			<?php for($x=0;$x<count($this->arrEmpresaSeleccionada['practicas']);$x++) {
				if($this->arrEmpresaSeleccionada['practicas'][$x]['estatusId']==2) {
					// Nombre de practica
					echo("<div id='textoPractica'>".$this->arrEmpresaSeleccionada['practicas'][$x]['buenapracticaId']." - ".$this->arrEmpresaSeleccionada['practicas'][$x]['nombrePractica']."</div>");

					for ($y = 0; $y < count($this->arrEmpresaSeleccionada['practicas'][$x]['criterios']); $y++) {

						// nombre de criterio
						echo("<div id='textoCriterio'>".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['nombre']." <span id='textoFecha'> (Puntos: ".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['puntos'].")</span></div>");
						for ($z = 0; $z < count($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias']); $z++) {
							$fecha = $this->fx->transformarFechaDMY($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['fecha']);
							$itemBoton = "$x;$y;$z";
							// tipo de evento (fecha) - liga a evidencia
							echo "<div id='textoDatos'>";

							echo "<a href='".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreEvidencia']."'  target='_blank' class='textoDatos'>";
							echo(basename($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreEvidencia']));
							echo "</a>";
							echo(" ".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreTipoEvento']."(".$fecha.") - ");
							echo "Estatus: ".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreEstatusCriterio'];
							if ($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['rechazada'] == 0 &&
								$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['aprovada'] == 0
							) {
								echo "<span id='textoALaDerecha'>";
								$this->fx->ponerBoton('mentor', 'aprobarEvidencia', $itemBoton, 'Aprobar', NULL, NULL, NULL, 'textoDatos', 0);
								echo "&nbsp;&nbsp;&nbsp;";
								$this->fx->ponerBoton('mentor', 'rechazarEvidencia', $itemBoton, 'Rechazar', NULL, NULL, NULL, 'textoDatos', 0);
								echo "</span>";
							} else {
								$fechaAprovRechazo = $this->fx->transformarFechaDMY($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['fechaAprovacionRechazo']);
								echo(" (".$fechaAprovRechazo.")");
							}
							echo "</div>";
						}
					}
				}
			 } ?>


			<div id="saltoDeRenglon"></div>
			<div class="espacioArriba"></div>
			<div class="espacioArriba"></div>
		</div>

<?php $this->fx->ponerBoton('mentor','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);?>