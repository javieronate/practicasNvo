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

include_once ("FxFormularios.php");

class Pantallas
{

	var $fx;

	/**
	 *
	 *  Constructor del Pantallas que:
	 *  Inicializa una instancia de la clase pantallas en la variable "pantallas" dentro del controlador
	 *  Inicializa la variable fx que es un helper de elementos de formulario
	 *
	 */
	function __construct()
	{
		$this->fx=new FxFormularios();
	}

	/**
	 *
	 *  Llama al archivo encargado de construir la pantalla para el usuario (sección View en le MVC)
	 *
	 */
	function mostrarPantalla()
	{

		$this->cabecera();
		$this->menuPrincipal();


		$this->pie();
		if(DEBUG==1){
			$this->debug();
		}

		//include ('pantallas/general/cabecera.php');
		//include ('pantallas/general/menuPrincipal.php');
		//include ($this->pantalla);
		//include ('pantallas/general/pie.php');
		//if(DEBUG==1){
		//	include ('pantallas/general/debug.php');
		//}
	}

	function cabecera()
	{ ?>
		<div id="Cabecera">
		<a href="http://www.presidencia.gob.mx/" title="Biomar | Gobierno de Mexico">
			<img src="imagenes/generales/1gobmex60.jpg" />
		</a>
		<a href="http://www.semarnat.gob.mx/" title="Biomar | SERMARNAT">
			<img src="imagenes/generales/2sermanat60.jpg"   />
		</a>
		<a href="http://www.conanp.gob.mx/" title="Biomar | CONANP">
			<img src="imagenes/generales/3conanp60.jpg" />
		</a>
		<a href="http://www.giz.de/" title="Biomar | Gobierno de Mexico">
			<img src="imagenes/generales/4giz60.jpg" />
		</a>
		<a href="http://www.bmub.bund.de/" title="Biomar | Bund BMUB">
			<img src="imagenes/generales/5bmub60.jpg"/>
		</a>
		</div>
	<?php
	}

	function menuPrincipal()
	{ ?>
		<div id="MenuPrincipal">
			<div class="TextoMenu">jom</div>
		</div>
		<?php
	}

	function pie()
	{ ?>
		<div id="Pie">
			<div class="textoPie">
				Hasselbit derechos reservados
			</div>
		</div>
		<?php
	}

	function debug()
	{
		$this->fx->ensenarArreglo($this->arrDatosPersonaTmp,'arrDatosPersonaTmp');
		$this->fx->ensenarArreglo($this->admon,'admon');
		//$this->fx->ensenarArreglo($this->arrDatosEmpresaTmp,'arrDatosEmpresaTmp');
		$this->fx->ensenarArreglo($_POST,'post');
		$this->fx->ensenarArreglo($this->arrDatosEmpresaTmp,'arrDatosEmpresaTmp');
		$this->fx->ensenarArreglo($this->empresa,'empresa');
	}







	function admonInicio()
	{ ?>

		<div id="empresas">
			<div class="titulo">
		Bienvenido <?php echo ($this->admon->datos['nombre']);   ?>
		</div>
		<div class="subtitulo">
			La adopción de buenas prácticas del ecoturismo
		</div>
		<div class="espacioArriba"></div>
		<div id="EmpresaColIzquierda" >
			<div class="tituloDesempeno">
				El desempeño sustentable de las empresas participantes es:
			</div>

			<div class="texto">
				Aqui va una gráfica de desempeño
			</div>
			<div class="espacioArriba"></div>
			<div class="tituloDesempeno">
				Estadísticas básicas:
			</div>

			<div class="texto">
				Aqui va una sumatoria de empresas participantes, practicas promedio aprobadas mínimo y máximo de practicas
			</div>
			<div class="espacioArriba"></div>
			<div class="tituloDesempeno">
				Donde y quienes:
			</div>

			<div class="texto">
				Aqui va una imeagen de satelite con marcas de las empresas participantes
			</div>
		</div>
		<!--<div id="EmpresaColCentroArriba">-->
		<!--	centro-->
		<!--</div>-->
		<div id="EmpresaColDerecha" >
			<div class="tituloDesempeno">
				El estado de las prácticas es::<br>
			</div>
			<div class="texto">
				Aqui va una lista que muestra el número de aprobaciones por cada práctica
			</div>
		</div>
		<div id="saltoDeRenglon"></div>
		<div class="espacioArriba"></div>
		<div class="espacioArriba"></div>
		</div>
	<?php
		$this->fx->ponerBoton('admin','irA','manejoMentor','Mentores',NULL,NULL,NULL,'btn btn-primary',0);
		$this->fx->ponerBoton('logout','','','Logout',NULL,NULL,NULL,'btn btn-primary',0);
	}


}