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
		Bienvenido "<?php echo ($this->empresa->datos['nombreEmpresa']); ?>"
	</div>

	<div class="subtitulo">
		Administración de Practicas y Evidencias
	</div>

	<div id="ColIzquierda50">
		<div class="tituloSeccion">
			Practicas en proceso
		</div>
		<?php for($x=0;$x<count($this->empresa->arrPracticasEnProceso);$x++) { ?>
			<div class="nombrePracticaAdmon">
				<?php echo ($this->empresa->arrPracticasEnProceso[$x]['nombrePractica'] ); ?>
			</div>
			<?php for($y=0;$y<count($this->empresa->arrPracticasEnProceso[$x]['criterios']);$y++) { ?>
				<div class="nombreCriterioAdmon">
					<?php $this->fx->ponerBoton('empresa','seleccionarCriterio',"$x:$y",
												$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['nombre'],
												NULL,NULL,NULL,'botonAzul',1);
					?>
				</div>

				<?php for($z=0;$z<count($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias']);$z++) { ?>
					<div class="nombreEventosAdmon">
						<?php
							$fecha=$this->fx->transformarFechaDMY($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias'][$z]['fechaAltaEvidencia']);
							echo ("<span id='nombreStatus'>".$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias'][$z]['nombreEstatus']."</span> - <span id='tipoEvento'>".
							$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['evidencias'][$z]['nombreTipoEvento']."</span> - <span id='nombreFecha'>".$fecha."</span>");
						?>
					</div>
				<?php } ?>
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