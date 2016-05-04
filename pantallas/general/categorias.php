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
<div class="categorias">
	<div class="titulo">
		<?php echo ($this->arrDatosPaginaCategoria['nombre']); ?>
	</div>


	<div id="ColIzquierdaCategoria">
		<img src="<?php echo (FOLDER_IMAGENES_CATEGORIAS.$this->arrDatosPaginaCategoria['imagen1']);?>" border="0" align="left" width="150px" class=" pull-left"/>
	</div>

	<div id="ColCentroArribaCategoria">
		<div class="subtitulo">
			Descripción
		</div>
		<div class="texto">
			<?php echo ($this->arrDatosPaginaCategoria['descripcion']); ?>
		</div>
	</div>

	<div id="ColDerecha">
		<img src="<?php echo (FOLDER_IMAGENES_CATEGORIAS.$this->arrDatosPaginaCategoria['imagen2']);?>" border="0" align="left" width="150px" class=" pull-left"/>
	</div>

<!--	<div id="ColCentroCentro">-->
<!--			<img src="--><?php //echo (FOLDER_IMAGENES_CATEGORIAS.$this->arrDatosPaginaCategoria['imagen3']);?><!--" border="0" align="center" height="200px" />-->
<!--	</div>-->

	<div id="ColCentroCentro">
		<div class="espacioArriba">  </div>
		<div class="subtitulo">
			Buenas practicas de esta categoría
		</div>
		<div id="listaBotones">
		<?php
		for($x=0;$x<count($this->arrPracticasDeCategoria);$x++){
			$this->fx->ponerBoton('general','irAPractica',$this->arrPracticasDeCategoria[$x]['id'],$this->arrPracticasDeCategoria[$x]['nombre'],NULL,NULL,NULL,'btn',0);
			echo "<br>";
		}
		?>
		</div>

	</div>

	    <div id="ColCentroAbajo">
		    <div class="espacioArriba">
		        <?php $this->fx->ponerBoton('general','irA','innovacion','Innovación',NULL,NULL,NULL,'',0);?>
		    </div>
	    </div>

</div>
<!--categoria-->

