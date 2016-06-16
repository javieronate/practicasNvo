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
		$this->fx->ponerBoton('general', 'irA', 'inicio', 'Inicio', NULL, NULL, NULL, 'TextoMenu', 0);
		$this->fx->ponerBoton('general', 'irA', 'login', 'Iniciar sesion', NULL, NULL, NULL, 'TextoMenu', 0);
		if ($this->pantalla == 'pantallas/general/practica.php') $this->fx->ponerBoton('general', 'irACategoria', $this->arrDatosPaginaPractica['categoriaId'], $this->arrDatosPaginaCategoria['nombre'], NULL, NULL, NULL, 'TextoMenu', 0);
	}else if($this->logueado=='empresa'){
		// biomar
		//echo "<span class=\"textomenu\">";
		//echo "<a href=\"http://www.biomar.org/site/areas-naturales-protegidas-y-turismo-susentable\">BioMar</a>";
		//echo "</span>";
		// inicio
		$this->fx->ponerBoton('empresa','irA','inicio','Inicio',NULL,NULL,NULL,'TextoMenu',0);
		// editar perfil
		$this->fx->ponerBoton('empresa','irA','perfil','Editar perfil',NULL,NULL,NULL,'TextoMenu',0);
		// si no ha hecho la autoevaluación
		if($this->empresa->datos['autoevaluacionHecha']==0) $this->fx->ponerBoton('empresa','irA','autoevaluacion','Realizar autoevaluación',NULL,NULL,NULL,'TextoMenu',0);
		// si hizo autoevaluación y lleno perfil
		if($this->empresa->datos['infoCapturada']==1 && $this->empresa->datos['autoevaluacionHecha']==1) $this->fx->ponerBoton('empresa','irA','admonPracticasEvidencias','Administración de prácticas y evidencias',NULL,NULL,NULL,'TextoMenu',0);
		// logout
		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'TextoMenu',0);
	}else if($this->logueado=='mentor'){
		// inicio
		$this->fx->ponerBoton('mentor','irA','inicio','Inicio',NULL,NULL,NULL,'TextoMenu',0);
		//Agregar empresa
		$this->fx->ponerBoton('mentor','agregarEmpresa','nueva', 'Agregar empresa', NULL, NULL, NULL, 'TextoMenu', 0);
		// logout
		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'TextoMenu',0);
	}else if($this->logueado=='superAdmin'){
		// inicio
		$this->fx->ponerBoton('admin','irA','inicio','Inicio',NULL,NULL,NULL,'TextoMenu',0);
		// administradores regionales
		$this->fx->ponerBoton('admin','irA','manejoAdminRegional','Directores de ANP',NULL,NULL,NULL,'TextoMenu',0);
		// nuevo admin gegional
		$this->fx->ponerBoton('admin', 'agregarAdminRegional', 'nuevo', 'Nuevo Director de ANP', NULL, NULL, NULL, 'TextoMenu', 1);
		// logout
		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'TextoMenu',0);
	}else if($this->logueado=='adminRegional'){
// inicio
		// inicio
		$this->fx->ponerBoton('admin','irA','inicio','Inicio',NULL,NULL,NULL,'TextoMenu',0);
		// administradores regionales
		$this->fx->ponerBoton('admin','irA','manejoMentor','Mentores',NULL,NULL,NULL,'TextoMenu',0);
		// nuevo admin gegional
		$this->fx->ponerBoton('admin', 'agregarPersona', 'nuevo', 'Nuevo mentor', NULL, NULL, NULL, 'TextoMenu', 1);

		// reasignación  de empresas
		$this->fx->ponerBoton('admin', 'reasignarEmpresas', 'nuevo', 'Reasignar empresas', NULL, NULL, NULL, 'TextoMenu', 1);
		// logout
		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'TextoMenu',0);
	}

	?>


	</div>
</div>
