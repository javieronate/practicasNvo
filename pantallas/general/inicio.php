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
<div class="tituloPagina">
	Prácticas de sustentabilidad de ecoturismo
</div>
<img src="imagenes/generales/inicio.jpg" width="900"/>

	<?php
		echo "<br><br>";
		$columna=0;

		for($x=0;$x<count($this->modelo->arrCategorias);$x++){
			$y=$x+1;
			$columna++;
			if($columna>4)$columna=1;
			$nombreFoto="imagenes/categorias/".$this->modelo->arrCategorias[$x]['imagenLiga'];
	?>
		<div class="floatleft210 border" style="padding:5px;">
			<?php
			$this->fx->ponerBoton('general','irACategoria',$this->modelo->arrCategorias[$x]['id'],$this->modelo->arrCategorias[$x]['nombre'],$nombreFoto,'150','101',null,0);
			echo "<br>";
			$this->fx->ponerBoton('general','irACategoria',$this->modelo->arrCategorias[$x]['id'],$this->modelo->arrCategorias[$x]['nombre'],null,null,null,'texto' ,0);
			?>
		</div>

	<?php } ?>



