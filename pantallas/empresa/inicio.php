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

//$this->fx->ensenarArreglo($this->empresa,'empresa');
//$this->fx->ensenarArreglo($this->arrListaPracticas,'arrListaPracticas');
?>

<div id="empresas">
	<div class="titulo">
		Bienvenido "<?php echo ($this->empresa->datos['nombreEmpresa']); ?>"
	</div>

	<?php
	$leyendaFaltantes='';
	if($this->empresa->datos['infoCapturada']==0){
		$leyendaFaltantes.="Recuerde que debe capturar la información de su empresa para poder continuar";
	}
	if($this->empresa->datos['autoevaluacionHecha']==0){
		if(strlen($leyendaFaltantes)>0) $leyendaFaltantes.="<br>";
		$leyendaFaltantes.="Recuerde que debe realizar la autoevaluación de su empresa para poder continuar";
	}
	if(strlen($leyendaFaltantes)>0){?>
	<div class="leyendaFaltantes">
		<?php echo "$leyendaFaltantes";?>
	</div>


	<?php
	}
	?>


	<div class="subtitulo">
		Según la NMX 133 El desempeño sustentable
	</div>


<!--	// columna izquierda-->

	<div id="EmpresaColIzquierda" >
		<div class="tituloDesempeno">
			de tu empresa es
		</div>
		<div class="">
			<img src="imagenes/temp/grafEmpresa.png" width="270px" align="center"/>
		</div>

		<div class="espacioArriba"></div>

		<div class="tituloDesempeno">
			Practicas completadas en tiempo
		</div>
		<div class="espacioArriba"></div>
		<?php
		for($x=0;$x,$x<count($this->empresa->arrPracticasTerminadas);$x++){
			echo "<div class='practicaDesempeno textoTerminada'>";
				echo ($this->empresa->arrPracticasTerminadas[$x]['nombrePractica']);
			echo "</div>";
			echo "<div class='fechaDesempeno'>";
				echo ("Fecha inicio: ".$this->empresa->arrPracticasTerminadas[$x]['fechaIncio']." / Fecha aprovación: ".$this->empresa->arrPracticasTerminadas[$x]['fechaAprobacion']);
			echo "</div>";
			echo "<div class='lineaDelgada'></div>";
		}
		?>


	</div>




	<!--// columna centro-->


	<div id="EmpresaColCentroArriba">
		<div class="tituloDesempeno">
			de otras empresas similares
		</div>
		<div class="">
			<img src="imagenes/temp/grafOtrasEmpresas.png" width="270px" align="center"/>
		</div>

		<div class="espacioArriba"></div>

		<div class="tituloDesempeno">
			Practicas en proceso de aprobación
		</div>
		<div class="espacioArriba"></div>
		<?php
		for($x=0;$x,$x<count($this->empresa->arrPracticasEnProceso);$x++){
			echo "<div class='practicaDesempeno textoEnProceso'>";
			echo ($this->empresa->arrPracticasEnProceso[$x]['nombrePractica']);
			echo "</div>";
			echo "<div class='fechaDesempeno'>";
			echo ("Fecha inicio: ".$this->empresa->arrPracticasEnProceso[$x]['fechaIncio']);
			echo "</div>";
			echo "<div class='lineaDelgada'></div>";
		}
		?>
	</div>


	<!--// columna derecha-->


	<div id="EmpresaColDerecha" >
		<div class="tituloLateralDer">
			Otras prácticas que pueden considerar:<br>
		</div>
		<div class="espacioArriba"></div>
			<div class="textoLateralDer">
				<?php for($x=0;$x<count($this->arrListaPracticas);$x++){?>
					<div id="seccionCategoria">
						<?php echo ($this->arrListaPracticas[$x]['nombreCategoria']);?>
					</div>
					<?php
					for($y=0;$y<count($this->arrListaPracticas[$x]['practicas']);$y++) {
						if ($this->arrListaPracticas[$x]['practicas'][$y]['idEmpresaBuenaPractica'] >0) {
							$claseAUsar=($this->arrListaPracticas[$x]['practicas'][$y]['idEstatus']==3)? "seccionPracticaAprobada" : "seccionPracticaEnProceso";
							echo "<div class='".$claseAUsar."'>";
							echo ($this->arrListaPracticas[$x]['practicas'][$y]['nombrePractica']);
							echo "</div>";
						}
						else {
							echo "<div class='seccionPractica'>";
							$this->fx->ponerBoton('general', 'irAPractica', $this->arrListaPracticas[$x]['practicas'][$y]['idPractica'], $this->arrListaPracticas[$x]['practicas'][$y]['nombrePractica'], NULL, NULL, NULL, 'seccionPractica', 0);
							echo "</div>";
						}
					}?>
				<?php } ?>
				<?php //$this->fx->ponerBoton('empresa','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>

			</div>
	</div>
	<div id="saltoDeRenglon"></div>
	<div class="">
		<?php
		//if($this->empresa->datos['infoCapturada']==0){
			$this->fx->ponerBoton('empresa','irA','perfil','Editar perfil',NULL,NULL,NULL,'btn btn-primary',0);
		//}
		//if($this->empresa->datos['autoevaluacionHecha']==0){
			$this->fx->ponerBoton('empresa','irA','autoevaluacion','Realizar autoevaluación',NULL,NULL,NULL,'btn btn-primary',0);
		//}
		//if($this->empresa->datos['infoCapturada']==1 && $this->empresa->datos['autoevaluacionHecha']==1){
			$this->fx->ponerBoton('empresa','irA','agregarPractica','Registrar una nueva práctica',NULL,NULL,NULL,'btn btn-primary',0);
			$this->fx->ponerBoton('empresa','irA','evidencias','Agregar evidencia',NULL,NULL,NULL,'btn btn-primary',0);
		//}


		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);
		?>
	</div>
</div>

