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
$nombreVentanaModal1="#openModalJom";
$nombreVentanaModal="openModalJom";
?>

<div id="empresas">
	<div class="titulo">
		Bienvenido "<?php echo ($this->empresa->datos['nombreEmpresa']); ?>"
	</div>

	<div class="subtitulo">
		Administración de Practicas y Evidencias<br>
		<span class="textoPequeno">Para aprobar una práctica se requiere cumplir con todos los criterios de la misma</span>
	</div>
	<div id="ColIzquierda50">
		<div class="tituloSeccion">
			Practicas en proceso
		</div>
		<?php for($x=0;$x<count($this->empresa->arrPracticasEnProceso);$x++) { ?>
			<div class="nombrePracticaAdmon">
				<?php echo ($this->empresa->arrPracticasEnProceso[$x]['nombrePractica'] ); ?>
			</div>
			<?php for($y=0;$y<count($this->empresa->arrPracticasEnProceso[$x]['criterios']);$y++) {
			$nombrePopup1="#comentario$x$y";
			$nombrePopup="comentario$x$y";
			?>
				<div class="nombreCriterioAdmon">
					<?php $this->fx->ponerBoton('empresa','seleccionarCriterio',"$x:$y",
												$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['nombre'],
												NULL,NULL,NULL,'botonAzul',1);
					?>
					<span class="botonAzulChico">
						<a href="<?php echo "$nombrePopup1"; ?>">
						<img src="imagenes/generales/botonAyuda.png" width="18px"></a>
					</span>

					<div id="<?php echo "$nombrePopup"; ?>" class="modalDialog">
						<div>
							<a href="#close" title="Close" class="close">X</a>
							<h3>Ayuda </h3>
							<?php echo ($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['orientacionMentor']); ?>
						</div>
					</div>









					</div>
				<?php if(strlen($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['comentariosMentor'])>0){?>
					<div class="comentariosDelMentor">
						<?php echo ("Comentarios del mentor: ".$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['comentariosMentor']);?>
					</div>
				<?php }?>
				<?php for($z=0;$z<count($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias']);$z++) { ?>
					<div class="nombreEventosAdmon">
						<?php
							$fecha=$this->fx->transformarFechaDMY($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias'][$z]['fechaAltaEvidencia']);
							echo ("<span id='nombreStatus'>".$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias'][$z]['nombreEstatus']."</span> - <span id='tipoEvento'>".
							$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias'][$z]['nombreTipoEvento']."</span> - <span id='nombreFecha'>".$fecha."</span>");
						?>
					</div>
				<?php } ?>
				<div class="rayaDelgada">&nbsp;</div>
			<?php } ?>
		<?php } ?>
	</div>



	<div id="ColDerecha50">

		<div class="tituloSeccion">
			Agregar Práctica
		</div>
		<div class="upload">
			<?php $this->fx->ponerMenuPracticasPendientes($this->arrListaPracticas,'formularioCampo');?>
		</div>

		<div class="upload">
			<?php $this->fx->ponerBoton('empresa','agregarPractica','','Agregar practica',NULL,NULL,NULL,'btn btn-primary',0);?>
		</div>

		<div class="espacioArriba">
			&nbsp;
		</div>

		<div class="tituloSeccion">
			Agregar evidencia
		</div>

		<div class="upload">
			<?php if(strlen($this->empresa->criterioIdSeleccionado)>0) {
				$cachos=explode(":",$this->empresa->criterioIdSeleccionado)	; ?>

			<div class="tituloSeccion">
				<?php echo ($this->empresa->arrPracticasEnProceso[$cachos['0']]['criterios'][$cachos['1']]['nombre']);
				echo "&nbsp;";
				$this->fx->ponerBoton('empresa','quitarCriterio','','','imagenes/generales/tacheRojo.gif',NULL,NULL,'',0);
				?>
			</div>
			<?php $this->fx->ponerInput('file','nombresArchivos',100,255,'','upload'); ?>
			<div class="upload">
				Comentarios
			</div>
			<div class="texto">
				<?php $this->fx->ponerAreaTexto('comentarios',50,8,"texto");?>
			</div>
			<div class="upload">
				<?php $this->fx->ponerBoton('empresa','agregarEvidencia','','Agregar evidencia',NULL,NULL,NULL,'btn btn-primary',0);?>
			</div>
			<div class="espacioArriba">
				&nbsp;
			</div>
		<?php } ?>
		</div>
	</div>
</div>




<?php $texto ="a ver si asi sale"; ?>
<script type="text/javascript">

	function informacion(texto) {

		alert(texto);
	}
</script>

