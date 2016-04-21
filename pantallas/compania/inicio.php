<?php
/**
 * Created by PhpStorm.
 * User: jom
 * Date: 3/28/16
 * Time: 5:15 PM
 */





?>

<table width="1100" align=""center" border="0">
	<tr>
		<td colspan="3"  >
			<div class="empresaTitulo">Bienvenido "<?php echo ($this->modelo->compania->datosCompania['nombre']);?>"</div>
			<div class="empresaSubtitulo">Segun la NMX 133 El desempeño sustentable es:</div>
		</td>




	</tr>
	<tr>
		<td colspan="1"   >
			<div class="empresaTituloSeccion"> De tu empresa</div>
			<?php include 'pantallas/compania/graficaEmpresa.php';?>
		</td>
		<td colspan="1"  class="empresaTituloSeccion">
			<div class="empresaTituloSeccion"> De otras empresas</div>
			<?php include 'pantallas/compania/graficaOtrasEmpresas.php';?>
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
