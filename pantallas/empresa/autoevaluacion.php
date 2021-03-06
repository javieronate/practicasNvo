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

	<?php for($x=0;$x<count($this->arrPreguntasAutoevaluacion);$x++){
		$nombre="respuesta".$x;
		$numeroDisplay=$x+1;
		$claseTexto=($this->arrPreguntasAutoevaluacion[$x]['correcta']==1) ? 'preguntaTexto' : 'preguntaTextoFaltante';
	?>

	<div class="<?php echo "$claseTexto";?>">
		<?php echo ($numeroDisplay." - ".$this->arrPreguntasAutoevaluacion[$x]['pregunta']);?>
	</div>
	<div class="textoPequeno">
		<?php $this->fx->ponerRadioButtons($nombre,$arreglo,$this->arrPreguntasAutoevaluacion[$x]['valor']); ?>
	</div>

	<?php }?>

</div>

<?php $this->fx->ponerBoton('empresa','autoevaluacionGrabar','','Grabar',NULL,NULL,NULL,'btn btn-primary',0); ?>
