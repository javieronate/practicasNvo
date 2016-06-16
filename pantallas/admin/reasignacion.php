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
for($x=0;$x<count($this->admon->arrPersonal);$x++){
	$arrPersonalCorto[]=array('id'=>$this->admon->arrPersonal[$x]['id'],'nombre'=>$this->admon->arrPersonal[$x]['nombre']);
}
?>
<div id="empresas">
	<div class="titulo">
		Bienvenido <?php echo ($this->admon->datos['nombre']);   ?>
	</div>

	<div id="ColIzquierda30">

		<div class="subtitulo">
			Reasignación de empresas
		</div>
		<div class="espacioArriba"></div>
		<div class="texto">
			Asignar las empresas del mentor:
		</div>
		<div class="texto">
			<?php $this->fx->ponerMenu('donador','Seleccione',$arrPersonalCorto,null,$this->admon->mentorDonador,'admin','buscarEmpresasDeDonador',null,null,1);?>
			<!--ponerMenu($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null)-->
		</div>
		<div class="espacioArriba"></div>
		<div class="texto">
			Al mentor:
		</div>
		<div class="texto">
			<?php $this->fx->ponerMenu('receptor','Seleccione',$arrPersonalCorto,null,$this->admon->mentorReceptor);?>
		</div>
		<div class="espacioArriba"></div>
		<div class="texto">
			<?php $this->fx->ponerBoton('admin','grabarReasignacionDeEmpresas','','Reasignar',NULL,NULL,NULL,'btn btn-primary',0); ?>
		</div>
	</div>

	<div id="ColDerecha70">
		<div class="subtitulo">
			Empresas asignadas al mentor
		</div>

		<?php for($x=0;$x<count($this->admon->arrEmpresasDeMentorDonador);$x++){
			$nombreChBox="chBox_".$this->admon->arrEmpresasDeMentorDonador[$x]['id'];
		?>
			<div class="texto">
				<?php $this->fx->ponerCheckBox($nombreChBox,'',1,0); ?>
				<?php echo ($this->admon->arrEmpresasDeMentorDonador[$x]['nombreEmpresa']); ?>
			</div>




		<?php } ?>
	</div>

</div>