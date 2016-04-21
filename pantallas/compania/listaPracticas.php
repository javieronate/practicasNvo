<?php
/**
 * Created by PhpStorm.
 * User: jom
 * Date: 3/29/16
 * Time: 12:05 PM
 */

?>
<table>
	<tr>
		<td class="empresaSubtitulo">
			Otras prácticas que se pueden considerar
		</td>
	</tr>




	<?php for($x=0;$x<count($this->modelo->arrBuenasPracticas);$x++){?>
		<tr>
			<td class="empresaCategoriaLista">
				<?php echo ($this->modelo->arrBuenasPracticas[$x]['nombreCategoria']) ?>
			</td>
		</tr>
		<?php for($y=0;$y<count($this->modelo->arrBuenasPracticas[$x]['practicas']);$y++){?>

			<tr>
				<td class="empresaActividadLista">

					<?php
					$etiqueta="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$this->modelo->arrBuenasPracticas[$x]['practicas'][$y]['idPractica']."-".$this->modelo->arrBuenasPracticas[$x]['practicas'][$y]['nombrePractica'];
					$this->fx->ponerBoton("compania","idrADescripcionPractica",$this->modelo->arrBuenasPracticas[$x]['practicas'][$y]['idPractica'],$etiqueta,"","","","empresaActividadLista",0); ?>
				</td>
			</tr>
		<?php } ?>
	<?php } ?>

</table>
