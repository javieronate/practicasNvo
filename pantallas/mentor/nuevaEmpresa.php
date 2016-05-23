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
			Nueva empresa
		</div>


		<table border="0">
			<tr>
				<td colspan="3" class="formularioEtiqueta">
					Nombre de la empresa
				</td>
			</tr>
			<tr>
				<td colspan="3" class="formularioCampo">
					<?php $this->fx->ponerInput('input','nombreEmpresa',70,255,'','formularioCampo','nombreEmpresa');?>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="espacioArriba">
					&nbsp;
				</td>
			</tr>

			<tr>
				<td colspan="3" class="formularioEtiqueta">
					Nombre de contacto
				</td>
			</tr>

			<tr>
				<td colspan="3" class="formularioCampo">
					<?php $this->fx->ponerInput('input','contactoNombre',70,255,'','formularioCampo','nombreEmpresa');?>
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
				<td colspan="2" class="formularioEtiqueta">
					Clave
				</td>

			</tr>
			<tr>
				<td colspan="1" class="formularioCampo">
					<?php $this->fx->ponerInput('input','usuario',30,255,'','formularioCampo','nombreEmpresa');?>
				</td>
				<td colspan="2" class="formularioCampo">
					<?php $this->fx->ponerInput('input','clave',30,255,'','formularioCampo','nombreEmpresa');?>
				</td>
			</tr>
			<tr>
				<td colspan="3" class="espacioArriba">
					&nbsp;
				</td>
			</tr>
			<tr>
				<td colspan="2" class="formularioCampo">
					<?php $this->fx->ponerBoton('mentor','grabarNuevaEmpresa','','Grabar',NULL,NULL,NULL,'btn btn-primary',0);?>
				</td>

			</tr>
		</table>
	</div>





		<div id="saltoDeRenglon"></div>
	<div class="espacioArriba"></div>
	<div class="espacioArriba"></div>
</div>
<?php $this->fx->ponerBoton('mentor','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0);?>
<?php $this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);?>
