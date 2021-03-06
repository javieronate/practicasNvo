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

$arreglo=array();
$arreglo[]=array('id'=>"1",'nombre'=>" Si");
$arreglo[]=array('id'=>"0",'nombre'=>" No");
$valor="";
?>


<div id="empresas">
	<div class="titulo">
		Bienvenido <?php echo ($this->admon->datos['nombre']);   ?>
	</div>
	<div class="subtitulo">
		Manejo de mentores
	</div>

	<div id="ColIzquierda30">
		<div id="textoLateralIzq">
			<?php
				for($x=0;$x<count($this->admon->arrPersonal);$x++) {
					echo "<div id='itemIzquierda'>";
					$this->fx->ponerBoton('admin', 'seleccionarPersona', $this->admon->arrPersonal[$x]['id'], $this->admon->arrPersonal[$x]['nombre'], NULL, NULL, NULL, 'botonAzul', 1);
					echo "</div>";
				}
			?>
		</div>
	</div>

	<div id="ColDerecha70">


		<?php if(isset($this->arrDatosPersonaTmp['id']) && $this->arrDatosPersonaTmp['id']!=''){ ?>
			<table border="0" width="100%">
				<tr>
					<td colspan="3" class="formularioEtiqueta">
						Nombre
					</td>
				</tr>
				<tr>
					<td colspan="3" class="formularioCampo">
						<?php $this->fx->ponerInput('input','nombrePersona',70,100,$this->arrDatosPersonaTmp['nombre'],'formularioCampo');?>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="espacioArriba">
						&nbsp;
					</td>
				</tr>

				<tr>
					<td colspan="3" class="formularioEtiqueta">
						Usuario
					</td>
				</tr>
				<tr>
					<td colspan="3" class="formularioCampo">
						<?php $this->fx->ponerInput('input','usuarioPersona',70,50,$this->arrDatosPersonaTmp['usuario'],'formularioCampo');?>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="espacioArriba">
						&nbsp;
					</td>
				</tr>

				<tr>
					<td colspan="3" class="formularioEtiqueta">
						Clave
					</td>
				</tr>
				<tr>
					<td colspan="3" class="formularioCampo">
						<?php $this->fx->ponerInput('password','clavePersona',70,255,$this->arrDatosPersonaTmp['clave'],'formularioCampo');?>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="espacioArriba">
						&nbsp;
					</td>
				</tr>

				<tr>
					<td colspan="3" class="formularioEtiqueta">
						Correo
					</td>
				</tr>
				<tr>
					<td colspan="3" class="formularioCampo">
						<?php $this->fx->ponerInput('input','correoPersona',70,255,$this->arrDatosPersonaTmp['email'],'formularioCampo');?>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="espacioArriba">
						&nbsp;
					</td>
				</tr>

				<tr>
					<td colspan="3" class="formularioEtiqueta">
						Nota
					</td>
				</tr>
				<tr>
					<td colspan="3" class="formularioCampo">
						<?php $this->fx->ponerAreaTexto("Nota",50,8,'formularioCampo',$this->arrDatosPersonaTmp['nota']);?>
					</td>
				</tr>

				<tr>
					<td colspan="3" class="espacioArriba">
						&nbsp;
					</td>
				</tr>

				<tr>
					<td colspan="3" class="formularioEtiqueta">
						Notificar por correo cada
					</td>
				</tr>
				<tr>
					<td colspan="3" class="formularioCampo">
						<?php $this->fx->ponerInput('input','notificarPorCorreoCadaHorasPersona',5,2,$this->arrDatosPersonaTmp['correoNotificacionCadaXHoras'],'formularioCampo');?>
					</td>
				</tr>
				<tr>
					<td colspan="3" class="espacioArriba">
						&nbsp;
					</td>
				</tr>
			</table>

		<?php

			if($this->arrDatosPersonaTmp['id']=='nuevo'){
				$this->fx->ponerBoton('admin','grabarNuevo','','Agregar',NULL,NULL,NULL,'btn btn-primary',0);
			}else{
				$this->fx->ponerBoton('admin','editarPersona','','Actualizar',NULL,NULL,NULL,'btn btn-primary',0);
			}


		}
		?>
	</div>


</div>

