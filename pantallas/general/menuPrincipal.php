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

<div id="MenuPrincipal">
	<div class="TextoMenu">

	<?php if($this->logueado=='no') {
		$this->fx->ponerBoton('general', 'irA', 'inicio', 'Inicio', NULL, NULL, NULL, 'btn', 0);
		$this->fx->ponerBoton('general', 'irA', 'login', 'Iniciar sesion', NULL, NULL, NULL, 'btn', 0);
		if ($this->pantalla == 'pantallas/general/practica.php') $this->fx->ponerBoton('general', 'irACategoria', $this->arrDatosPaginaPractica['categoriaId'], $this->arrDatosPaginaCategoria['nombre'], NULL, NULL, NULL, 'btn', 0);
	}else if($this->logueado=='empresa'){
		// inicio
		$this->fx->ponerBoton('empresa','irA','inicio','Inicio',NULL,NULL,NULL,'btn',0);
		// editar perfil
		$this->fx->ponerBoton('empresa','irA','perfil','Editar perfil',NULL,NULL,NULL,'btn',0);
		// si no ha hecho la autoevaluación
		if($this->empresa->datos['autoevaluacionHecha']==0) $this->fx->ponerBoton('empresa','irA','autoevaluacion','Realizar autoevaluación',NULL,NULL,NULL,'btn',0);
		// si hizo autoevaluación y lleno perfil
		if($this->empresa->datos['infoCapturada']==1 && $this->empresa->datos['autoevaluacionHecha']==1) $this->fx->ponerBoton('empresa','irA','admonPracticasEvidencias','Administración de prácticas y evidencias',NULL,NULL,NULL,'btn',0);
		// logout
		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn',0);
	}else if($this->logueado=='mentor'){
		// inicio
		$this->fx->ponerBoton('mentor','irA','inicio','Inicio',NULL,NULL,NULL,'btn',0);
		//Agregar empresa
		$this->fx->ponerBoton('mentor','agregarEmpresa','nueva', 'Agregar empresa', NULL, NULL, NULL, 'btn', 0);
		// logout
		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn',0);
	}








	?>


	</div>
</div>
