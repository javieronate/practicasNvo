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
<div class="titulo">
	Bienvenido <?php echo ($this->mentor->datos['nombre']); ?>
</div>
<div class="tituloDesempeno">
	Pagina principal de cada mentor
</div>
<div class="espacioArriba"></div>


<div id="ColIzquierda30">
	<div class="tituloDesempeno">
		Empresas supervisadas:
	</div>
	<?php for($x=0;$x<count($this->mentor->arrEmpresasSupervisadas);$x++) {?>
		<div id="itemIzquierda">
			<?php $this->fx->ponerBoton('mentor', 'irAEmpresa', $this->mentor->arrEmpresasSupervisadas[$x]['id'], $this->mentor->arrEmpresasSupervisadas[$x]['nombreEmpresa'], NULL, NULL, NULL, 'botonAzul', 0);?>
		</div>
	<?php } ?>
	<div id="itemIzquierda">
		<?php $this->fx->ponerBoton('mentor','agregarEmpresa','nueva', 'Agregar empresa', NULL, NULL, NULL, 'botonAzul', 0);?>
	</div>
</div>