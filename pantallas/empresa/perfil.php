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

$jom2='';
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
				<?php $this->fx->ponerInput('input','nombreEmpresa',100,255,$this->arrDatosEmpresaTmp['nombreEmpresa'],'formularioCampo','nombreEmpresa');?>
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
				<?php $this->fx->ponerInput('input','calle',30,255,$this->arrDatosEmpresaTmp['calle'],'formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','noExt',30,255,$this->arrDatosEmpresaTmp['noExt'],'formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','noInt',30,255,$this->arrDatosEmpresaTmp['noInt'],'formularioCampo','nombreEmpresa');?>
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
				<?php $this->fx->ponerInput('input','colonia',30,255,$this->arrDatosEmpresaTmp['colonia'],'formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','cp',30,255,$this->arrDatosEmpresaTmp['cp'],'formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','ciudad',30,255,$this->arrDatosEmpresaTmp['ciudad'],'formularioCampo','nombreEmpresa');?>
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
				Latitud / Longitud <br>en DD (grados decimales)
			</td>
		</tr>
		<tr>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerMenu('estado','Estado',$this->arrEstados,null,$this->arrDatosEmpresaTmp['estado'],'empresa','cambiarEstado',null,'formularioCampo',1);?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php
				if($this->arrDatosEmpresaTmp['estado']!='' and $this->arrDatosEmpresaTmp['estado']!='Estado') {
					$this->fx->ponerMenu('municipio', 'Municipio', $this->arrMunicipios, $this->arrDatosEmpresaTmp['estado'], $this->arrDatosEmpresaTmp['municipio'],null,null,null,'formularioCampo',null);
				}
				?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','latitud',15,15,$this->arrDatosEmpresaTmp['latitud'],'formularioCampo','nombreEmpresa');?>
				<?php $this->fx->ponerInput('input','longitud',15,15,$this->arrDatosEmpresaTmp['longitud'],'formularioCampo','nombreEmpresa');?>
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
				<?php $this->fx->ponerInput('input','contactoNombre',100,255,$this->arrDatosEmpresaTmp['contactoNombre'],'formularioCampo','nombreEmpresa');?>
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
				<?php $this->fx->ponerInput('input','telefono',30,255,$this->arrDatosEmpresaTmp['telefono'],'formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','correos',30,255,$this->arrDatosEmpresaTmp['correos'],'formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="1" class="formularioCampo">
				<?php $this->fx->ponerInput('input','sitioWeb',30,255,$this->arrDatosEmpresaTmp['sitioWeb'],'formularioCampo','nombreEmpresa');?>
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
				<?php $this->fx->ponerInput('input','usuario',30,255,$this->arrDatosEmpresaTmp['usuario'],'formularioCampo','nombreEmpresa');?>
			</td>
			<td colspan="2" class="formularioCampo">
				<?php $this->fx->ponerInput('password','clave',30,255,$this->arrDatosEmpresaTmp['clave'],'formularioCampo','nombreEmpresa');?>
			</td>
		</tr>

		<tr>
			<td colspan="3" class="espacioArriba">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" class="formularioEtiqueta">
				<?php $this->fx->ponerBoton('empresa','perfilGrabar','','Grabar',NULL,NULL,NULL,'btn btn-primary',0); ?>
			</td>
		</tr>



		<tr>
			<td colspan="3" class="espacioArriba">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" class="formularioEtiqueta">
				Foto de empresa (tamaño maximo 500 MB)
			</td>
		</tr>
		<tr>
			<td colspan="2" class="formularioCampo">
				<?php $this->fx->ponerInput('file','fotoEmpresa',100,255,'','upload'); ?>
			</td>

		</tr>
		<tr>
			<td colspan="3" class="espacioArriba">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td colspan="2" class="formularioEtiqueta">
				<?php $this->fx->ponerBoton('empresa','fotoGrabar','','Grabar fotografía',NULL,NULL,NULL,'btn btn-primary',0); ?>
			</td>
		</tr>
	</table>

	<div class="espacioArriba"/>
	<div class="espacioArriba"/>




</div>


