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

<div class="textoIncio">
	<p>&nbsp;</p>
	<p>El ecoturismo en Áreas Naturales Protegidas es tanto una oportunidad como una amenaza para la conservación de la naturaleza, el bienestar de las personas y la prosperidad económica de las comunidades, todo depende de la forma en que las empresas fomenten la sustentabilidad en sus operaciones. Es decir, las empresas pueden favorecer una mayor integración económica de las comunidades, reducir el impacto ambiental de sus actividades, generar mayor valor a los productos y servicios que ofrecen a los visitantes. Estas acciones se pueden lograr aplicando los criterios y especificaciones establecidos en la <a href="http://legismex.mty.itesm.mx/normas/aa/nmx-aa-133-scfi-2013.pdf" target="_blank"> Norma Mexicana NMX AA-SCFI 2013 Requisitos y Especificaciones de Sustentabilidad del Ecoturismo</a>.</p>
	<p>Las empresas que han cumplido con los requisitos de la norma han mostrado que a través de prácticas específicas aplicadas cotidianamente en la empresa se fomenta la sustentabilidad, ésta contribuye a mejorar la experiencia de los visitantes y hacer más competitiva a la empresa.</p>
	<p>Las empresas turísticas regidas bajo los criterios y especificaciones de esta norma reducen significativamente sus impactos ambientales, usan eficientemente la energía y el agua, manejan adecuadamente los residuos sólidos, benefician económica y socialmente a la población local y a los visitantes mediante actividades de educación e interpretación ambiental.</p>
	<p>Las empresas que cumplen con todos los requisitos establecidos en la norma reciben el sello de Ecoturismo Certificado, un listado de las empresas certificadas se encuentra   <a href="http://www.ecoturismocertificado.mx/" target="_blank"> aquí</a>.<p>
	<p>Para ayudar a las empresas a integrar prácticas de sustentabilidad en sus actividades cotidianas, que eventualmente les permitiría obtener el sello de Ecoturismo Certificado, hemos seleccionado 35 prácticas agrupadas en las siguientes categorías:<p>
</div>
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


