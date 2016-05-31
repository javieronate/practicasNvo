<?php
/**
 *
 * Buenas Prácticas
 *
 * PHP Version 5.6.16
 *
 * @copyright 2016 Hasselbit,S.C. / Dédalo (http://www.hasselbit.com)
 *
 * @author  Javier Oñate Mendía (Dédalo)
 */

$jom2='';
?>
<div class="tituloPagina">
	Prácticas de sustentabilidad de ecoturismo
</div>
<div id="login">
	<div id="#login-bg">
		<div id="caja">
			<div id="usuario">Usuario: <?php $this->fx->ponerInput('input','usuario','30','30','','inputNormal');?></div>
			<div id="usuario">Clave:&nbsp;&nbsp;&nbsp; <?php $this->fx->ponerInput('input','clave','30','30','','inputNormal');?></div>
			<div id="boton"><?php $this->fx->ponerBoton('login','','','Entrar',NULL,NULL,NULL,'btn btn-primary',0);?>&nbsp;&nbsp;&nbsp;
				<?php $this->fx->ponerBoton('general','irA','inicio','Regresar',NULL,NULL,NULL,'btn btn-primary',0);?></div>

			<?php if(strlen($this->mensaje)>0){?>
				<div class="textoError">
					<?php
					echo ($this->mensaje);
					$this->mensaje='';
					?>
				</div>
			<?php } ?>

		</div>
	</div>
</div>










