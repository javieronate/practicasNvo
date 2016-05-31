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

//ponerMenu($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null)

$_SESSION['fx']->ponerMenu('practica','SeleccionePractica',$_SESSION['arrPracticas'],'',$_SESSION['arrPracticaActiva']['id'],'buscarPractica',null,null,null,1);
echo "<br><br>";

//	[id] => 7
//       [categoriaId] => 3
//       [titulo] => Crear y expandir una cadena de impacto social
//	[tituloCorto] => Crear y expandir una cadena de impacto social
//	[descripcion] =>
//       [experiencia] =>
//       [sustentabilidad] =>
//       [competitividad] =>
//       [variaciones] =>
//       [imprimir] =>
//       [recursos] =>
//       [aprenderMas] =>
//       [criterios] =>
//       [propietarioId] =>
//       [fechaCreacion] =>
//       [fechaActualizacion] => 2016-05-15 05:00:00
//       [publico] => 1
//       [imagen1] =>
//       [imagen2] =>
//       [imagen3] =>
//       [valorDeCertificacion] =>
//       [orden] =>
//       [puntosMaximos] => 10.00
//       [periodoDeVigencia] =>
//       [ANPAplicacion] =>
//       [ejemplosCumplimiento] =>

?>
	<h3>titulo</h3>
	<?php $_SESSION['fx']->ponerInput('input','titulo','100','255',$_SESSION['arrPracticaActiva']['titulo'],'campoTextoLlenarPracticas');?>

	<h3>tituloCorto</h3>
	<?php $_SESSION['fx']->ponerInput('input','tituloCorto','100','255',$_SESSION['arrPracticaActiva']['tituloCorto'],'campoTextoLlenarPracticas');?>

	<h3>imagen1</h3>
	<?php $_SESSION['fx']->ponerInput('input','imagen1','100','255',$_SESSION['arrPracticaActiva']['imagen1'],'campoTextoLlenarPracticas');?>

	<h3>imagen2</h3>
	<?php $_SESSION['fx']->ponerInput('input','imagen2','100','255',$_SESSION['arrPracticaActiva']['imagen2'],'campoTextoLlenarPracticas');?>

	<h3>imagen3</h3>
	<?php $_SESSION['fx']->ponerInput('input','imagen3','100','255',$_SESSION['arrPracticaActiva']['imagen3'],'campoTextoLlenarPracticas');?>

	<h3>Puntos máximos</h3>
	<?php $_SESSION['fx']->ponerInput('input','puntosMaximos','100','255',$_SESSION['arrPracticaActiva']['puntosMaximos'],'campoTextoLlenarPracticas');?>


	<br><br>
	<h3>Descripción</h3>
	<textarea name="descripcion" class="textarea"><?php echo ($_SESSION['arrPracticaActiva']['descripcion']);?></textarea>

	<br><br>
	<h3>Experiencia</h3>
	<textarea name="experiencia" class="textarea"><?php echo ($_SESSION['arrPracticaActiva']['experiencia']);?></textarea>

	<br><br>
	<h3>Sustentabilidad</h3>
	<textarea name="sustentabilidad" class="textarea"><?php echo ($_SESSION['arrPracticaActiva']['sustentabilidad']);?></textarea>

	<br><br>
	<h3>Competitividad</h3>
	<textarea name="competitividad" class="textarea"><?php echo ($_SESSION['arrPracticaActiva']['competitividad']);?></textarea>

	<br><br>
	<h3>Variaciones</h3>
	<textarea name="variaciones" class="textarea"><?php echo ($_SESSION['arrPracticaActiva']['variaciones']);?></textarea>

	<br><br>
	<h3>Aprender mas</h3>
	<textarea name="aprenderMas" class="textarea"><?php echo ($_SESSION['arrPracticaActiva']['aprenderMas']);?></textarea>

	<br><br>
	<h3>Ejemplos cumplimiento</h3>
	<textarea name="ejemplosCumplimiento" class="textarea"><?php echo ($_SESSION['arrPracticaActiva']['ejemplosCumplimiento']);?></textarea>



<br><br>
<?php $_SESSION['fx']->ponerBoton('grabar','','','Grabar',null,null,null,'btn btn-primary',null,null);