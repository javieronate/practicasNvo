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
					<?php echo ($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['nombre'] ); ?>
				</div>

				<?php for($z=0;$z<count($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['datos']);$z++) { ?>
					<div class="nombreEventosAdmon">
						<?php echo ($this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['datos'][$z]['nombreEstatus']." - ".
							$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['datos'][$z]['nombreTipoEvento']." - ".
							$this->empresa->arrPracticasEnProceso[$x]['criterios'][$y]['datos'][$z]['fecha']);
						?>
					</div>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</div>



	<div id="ColDerecha50">
		<div class="tituloSeccion">
			Agregar evidencia
		</div>

		<div class="upload">
			<?php $this->fx->ponerMenuJerarquico($this->empresa->arrPracticasEnProceso,'formularioCampo');?>
			<?php $this->fx->ponerInput('file','nombresArchivos',100,255,'','upload'); ?>
		</div>
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
		<div class="tituloSeccion">
			Agregar Práctica
		</div>
		<div class="upload">
			<!--ponerMenu($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null)-->
			<?php $this->fx->ponerMenuPracticasPendientes($this->arrListaPracticas,'formularioCampo');?>
		</div>
		<div class="upload">
			<?php $this->fx->ponerBoton('empresa','agregarPractica','','Agregar practica',NULL,NULL,NULL,'btn btn-primary',0);?>
		</div>



	</div>
<div id="saltoDeRenglon">
	<?php $this->fx->ponerBoton('empresa','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>
</div>