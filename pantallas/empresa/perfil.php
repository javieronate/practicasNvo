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

?>
<div id="empresas">
	<div class="titulo">
		Bienvenido "<?php echo ($this->empresa->datos['nombreEmpresa']); ?>"
	</div>


	<div class="subtitulo">
		Actualice su información
	</div>

	<table border="0">
		<tr>
			<td colspan="3" class="formularioEtiqueta">
				Nombre de la empresa
			</td>
		</tr>
		<tr>
			<td colspan="3" class="formularioCampo">
				<?php $this->fx->ponerInput('input','nombreEmpresa',100,255,'','formularioCampo','nombreEmpresa');?>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="espacioArriba">
				&nbsp;
			</td>
		</tr>

		<tr>
			<td colspan="1" class="formularioEtiqueta">
				Calle
			</td>
			<td colspan="1" class="formularioEtiqueta">
				No. exterior
			</td>
			<td colspan="1" class="formularioEtiqueta">
				No. interior
			</td>
		</tr>
		<tr>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','calle',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','noExt',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','noInt',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
		</tr>

		<tr>
			<td colspan="3" class="espacioArriba">
				&nbsp;
			</td>
		</tr>

		<tr>
			<td colspan="1" class="formularioEtiqueta">
				Colonia
			</td>
			<td colspan="1" class="formularioEtiqueta">
				C.P.
			</td>
			<td colspan="1" class="formularioEtiqueta">
				Ciudad
			</td>
		</tr>
		<tr>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','colonia',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','cp',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','ciudad',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
		</tr>

		<tr>
			<td colspan="3" class="espacioArriba">
				&nbsp;
			</td>
		</tr>

		<tr>
			<td colspan="1" class="formularioEtiqueta">
				Estado
			</td>
			<td colspan="1" class="formularioEtiqueta">
				Municipio
			</td>
			<td colspan="1" class="formularioEtiqueta">
				Ubicación
			</td>
		</tr>
		<tr>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','estado',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','municipio',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','ubicacion',30,255,'','formularioCampo','nombreEmpresa');?>
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
				<?php $this->fx->ponerInput('input','nombreContacto',100,255,'','formularioCampo','nombreEmpresa');?>
			</td>
		</tr>

		<tr>
			<td colspan="3" class="espacioArriba">
				&nbsp;
			</td>
		</tr>

		<tr>
			<td colspan="1" class="formularioEtiqueta">
				Teléfono
			</td>
			<td colspan="1" class="formularioEtiqueta">
				Correos
			</td>
			<td colspan="1" class="formularioEtiqueta">
				Página web
			</td>
		</tr>
		<tr>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','telefono',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','correos',30,255,'','formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','pagWeb',30,255,'','formularioCampo','nombreEmpresa');?>
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
	</table>

	<div class="espacioArriba"/>
	<div class="espacioArriba"/>




</div>

	<div class="espacioArriba"></div>
<?php $this->fx->ponerBoton('empresa','perfilGrabar','','Grabar',NULL,NULL,NULL,'btn btn-primary',0); ?>
<?php $this->fx->ponerBoton('empresa','irA','inicio','Inicio',NULL,NULL,NULL,'btn btn-primary',0); ?>
