<?php
/**
 * Created by PhpStorm.
 * User: jom
 * Date: 3/29/16
 * Time: 3:05 PM
 */
print "<pre>";
echo "<br>modelo <BR>";
print_r($this->modelo->arrPracticaDescripcion);
print "</pre>";

?>


<table width="1100" align=""center" border="0">
<tr>
	<td colspan="3"  >
		<div class="empresaSubtitulo">Bienvenido "<?php echo ($this->modelo->compania->datosCompania['nombre']);?>"</div>
	</td>
</tr>

<tr>
	<td colspan="3"  >
		<div class="empresaTitulo"><?php echo ($this->modelo->arrPracticaDescripcion['titulo']);?></div>
	</td>
</tr>

<tr>
	<td colspan="1"   >
		<img src="<?php echo ("tmp/".$this->modelo->arrPracticaDescripcion['imagen1']); ?>" width="200" height="400">

	</td>
	<td colspan="1"  class="empresaTituloSeccion">
		<div class="empresaTituloSeccion"><?php echo ($this->modelo->arrPracticaDescripcion['descripcion']); ?></div>
	</td>
	<td colspan="1"  rowspan="3"   width="350" >
		<?php include 'pantallas/compania/listaPracticas.php';?>
	</td>
</tr>

<tr>
	<td bgcolor="#bdb76b" class='morado' >
		Practicas completadas
	</td>
	<td bgcolor="#f0f8ff" class='rosa' >
		Practicas pendientes
	</td>
</tr>
<tr>
	<td colspan = "2" bgcolor="#add8e6" class='naranja' >
		botones de accion
	</td>
</tr>
</table>
