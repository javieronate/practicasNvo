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

			<div class="contactoEmpresa">
				<?php echo ("Contacto: ".$this->arrEmpresaSeleccionada['contactoNombre']); ?>
			</div>
			<div class="datosEmpresa">
				<?php echo ("Teléfono: ".$this->arrEmpresaSeleccionada['telefono']); ?>
				<?php echo ("<br>Correos: ".$this->arrEmpresaSeleccionada['correos']); ?>
			</div>
			<div class="tituloDesempeno">
				Lista de practicas autorizadas para la empresa:
			</div>
			<?php for($x=0;$x<count($this->arrEmpresaSeleccionada['practicas']);$x++) {
				if($this->arrEmpresaSeleccionada['practicas'][$x]['estatusId']==4) {
					$fechaInicio=$this->fx->transformarFechaDMY($this->arrEmpresaSeleccionada['practicas'][$x]['fechaIncio']);
					$fechaAprobacion=$this->fx->transformarFechaDMY($this->arrEmpresaSeleccionada['practicas'][$x]['fechaAprobacion']);?>
					<div id='textoPractica'>
						<?php echo ($this->arrEmpresaSeleccionada['practicas'][$x]['buenapracticaId']." - ".$this->arrEmpresaSeleccionada['practicas'][$x]['nombrePractica']."<span id='textoFecha'>   (Puntos:".$this->arrEmpresaSeleccionada['practicas'][$x]['puntos'].")</span>");?>
					</div>
					<div id='textoDatos'>
						Inicio: <?php echo "$fechaInicio - Aprobación: $fechaAprobacion";?>
					</div>
				<?php }
			}?>





			<div class="espacioArriba"></div>
			<div class="tituloDesempeno">
				Lista de practicas en proceso para la empresa:
			</div>

			<?php for($x=0;$x<count($this->arrEmpresaSeleccionada['practicas']);$x++) {
				if($this->arrEmpresaSeleccionada['practicas'][$x]['estatusId']==2) {
					// Nombre de practica
					echo("<div id='textoPractica'>".$this->arrEmpresaSeleccionada['practicas'][$x]['buenapracticaId']." - ".$this->arrEmpresaSeleccionada['practicas'][$x]['nombrePractica']."<span id='textoFecha'>   (Puntos:".$this->arrEmpresaSeleccionada['practicas'][$x]['puntos'].")</span></div>");

					for($y = 0; $y < count($this->arrEmpresaSeleccionada['practicas'][$x]['criterios']); $y++) {
						$estatusDeCriterio=$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['estatusCriterio'];
						$todasVistas=1;
						$evidenciaPorEvaluar=0;
						// si no hay ninguna evidencia no poner
						if(count($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'])==0) $todasVistas=0;
						// si falta ver una evidencia no poner
						for($z=0;$z<count($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias']);$z++){
							if($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['evidenciaStatus']<3) $todasVistas=0;
						}
						for($z=0;$z<count($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias']);$z++){
							if($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['evidenciaStatus']==3) $evidenciaPorEvaluar=1;
						}
						$itemBoton = "$x;$y";
						$nombreComentarios="comentariosMentor".$itemBoton;
						// nombre de criterio
						echo("<div id='textoCriterio'><span id='textoNombreCriterioAngosto'>".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['criterioNombre']);
						echo "<span id='textoListaMentorStauts'>";
						echo ("   ".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['nombreStatus']);
						echo "</span></span>";


						// botones de aprobar/rechazar
						if($todasVistas==1 && $evidenciaPorEvaluar==1 && $estatusDeCriterio!=4) {
							echo "<span id='textoALaDerecha'>";
							$this->fx->ponerBoton('mentor', 'aprobarEvidencia', $itemBoton, 'Aprobar', NULL, NULL, NULL, 'textoDatos', 0);
							echo "&nbsp;&nbsp;&nbsp;";
							$this->fx->ponerBoton('mentor', 'rechazarEvidencia', $itemBoton, 'Rechazar', NULL, NULL, NULL, 'textoDatos', 0);
							echo "</span>";
						}
						echo "</div>";
						echo "<div id='textoOrientacionMentor'>".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['orientacionMentor']."</div>";
						for ($z = 0; $z < count($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias']); $z++) {
							$fecha = $this->fx->transformarFechaDMY($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['fechaAltaEvidencia']);
							$subItemBoton = "$x;$y;$z";
							echo "<div id='textoDatos'>";
								$this->fx->ponerBoton('mentor','abrirEvidencia',$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreEvidencia'],$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreOriginal'],NULL,NULL,NULL,'botonAzul',0,$subItemBoton);
								echo("  <span id='mentorListaFecha'>".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreTipoEvento']."(".$fecha.")</span> - ");
								echo "<span id='mentorListaEstatus'>Estatus: ".$this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['nombreEstatus']."</span>";
							echo "</div>";
							echo "<div id='textoComentarioEmpresa'>";
								echo ($this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['evidencias'][$z]['comentariosEmpresa']);
							echo "</div>";
						}
						if($todasVistas==1 && $evidenciaPorEvaluar==1 && $this->arrEmpresaSeleccionada['practicas'][$x]['criterios'][$y]['estatusCriterio']!=4) {
							echo "<div id='textoDatos'>";
							$this->fx->ponerAreaTexto($nombreComentarios, "90", "5", "textoOrientacionMentor", null);
							echo "</div>";
						}
					}
				}
			 } ?>


			<div id="saltoDeRenglon"></div>
			<div class="espacioArriba"></div>
			<div class="espacioArriba"></div>
		</div>
