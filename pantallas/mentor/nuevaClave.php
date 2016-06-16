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


$jom2="";
?>

<div id="empresas">
	<?php include ('inicioGral.php');?>
	<div id="ColDerecha70">
		<div class="subtitulo">
			Nueva clave de empresa
		</div>


		<table border="0">

			<tr>
				<td colspan="3" class="formularioCampo">
					<?php echo ($this->mentor->arrEmpesaSeleccionada['nombreEmpresa']);  ?>
				</td>
			</tr>

			<tr>
				<td colspan="3" class="espacioArriba">
					&nbsp;
				</td>
			</tr>

			<tr>
				<td colspan="3" class="formularioCampo">
					<?php echo ($this->mentor->arrEmpesaSeleccionada['contactoNombre']);  ?>
				</td>
			</tr>

			<tr>
				<td colspan="3" class="espacioArriba">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="1" class="formularioEtiqueta">
					Usuario
				</td>
			</tr>
			<tr>
				<td colspan="1" class="formularioCampo">
					<?php $this->fx->ponerInput('input','usuario',30,255,$this->mentor->arrEmpesaSeleccionada['usuario'],'formularioCampo');?>
				</td>
				<td colspan="2" class="formularioCampo">
			</tr>
			<tr>
				<td colspan="3" class="espacioArriba">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="1" class="formularioCampo">
					Clave
				</td>
			</tr>
			<tr>
				<td colspan="1" class="formularioCampo">
					<?php $this->fx->ponerInput('password','clave',30,255,$this->mentor->arrEmpesaSeleccionada['clave'],'formularioCampo');?>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="espacioArriba">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2" class="formularioCampo">
					<?php $this->fx->ponerBoton('mentor','grabarNuevaClave','','Grabar',NULL,NULL,NULL,'btn btn-primary',0);?>
				</td>

			</tr>
		</table>
	</div>





		<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
</div>

