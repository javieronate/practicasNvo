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

$arreglo=array();
$arreglo[]=array('id'=>"1",'nombre'=>" Si");
$arreglo[]=array('id'=>"0",'nombre'=>" No");
$arreglo[]=array('id'=>"-1",'nombre'=>" No se");
$valor="";

?>
<div id="empresas">
	<div class="titulo">
Autoevaluación "<?php echo ($this->empresa->datos['nombreEmpresa']); ?>"
</div>
	<div class="subtitulo">
		Por favor conteste el siguente cuestionario para poder evaluar la situación actual de su empresa
	</div>


	<table border="1" width="100%">



		<?php for($x=0;$x<count($this->arrPreguntasAutoevaluacion);$x++){
			$nombre="respuesta".$x;
			$numeroDisplay=$x+1;
			$claseTexto=($this->arrPreguntasAutoevaluacion[$x]['correcta']==1) ? 'preguntaTexto' : 'preguntaTextoFaltante';
		?>
			<tr>
				<td class="<?php echo "$claseTexto";?>">
					<?php echo ($numeroDisplay);?>
				</td>
				<td class="$claseTexto">
					<?php echo ($this->arrPreguntasAutoevaluacion[$x]['pregunta']);?>
				</td>
				<td> <?php $this->fx->ponerRadioButtons($nombre,$arreglo,$this->arrPreguntasAutoevaluacion[$x]['valor']); ?></td>
			</tr>
		<?php }?>
	</table>
</div>


<?php $this->fx->ponerBoton('empresa','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0); ?>
<?php $this->fx->ponerBoton('empresa','autoevaluacionGrabar','','Grabar',NULL,NULL,NULL,'btn btn-primary',0); ?>
