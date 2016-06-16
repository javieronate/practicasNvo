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

$anchoTotalGrafica=250;
$porcentajeMentorGenerales=
	($this->mentor->arrGraficaMentor['arrMentor']['promedioUno']/
		$this->mentor->arrGraficaMentor['arrTotalesPosibles']['uno'])*100;
$porcentajeMentorInstalaciones=
	($this->mentor->arrGraficaMentor['arrMentor']['promedioDos']/
		$this->mentor->arrGraficaMentor['arrTotalesPosibles']['dos'])*100;
$porcentajeMentorActividades=
	($this->mentor->arrGraficaMentor['arrMentor']['promedioTres']/
		$this->mentor->arrGraficaMentor['arrTotalesPosibles']['tres'])*100;

$porcentajeTodasGenerales=
	($this->mentor->arrGraficaMentor['arrTodas']['promedioUno']/
		$this->mentor->arrGraficaMentor['arrTotalesPosibles']['uno'])*100;
$porcentajeTodasInstalaciones=
	($this->mentor->arrGraficaMentor['arrTodas']['promedioDos']/
		$this->mentor->arrGraficaMentor['arrTotalesPosibles']['dos'])*100;
$porcentajeTodasActividades=
	($this->mentor->arrGraficaMentor['arrTodas']['promedioTres']/
		$this->mentor->arrGraficaMentor['arrTotalesPosibles']['tres'])*100;
?>
<div class="titulo">
	Bienvenido <?php echo ($this->mentor->datos['nombre']); ?>
</div>
<div class="tituloDesempeno">
	Desempeño de las empresas del mentor
</div>
<div class="espacioArriba"></div>
<table border="0" width="355" id="graficaEmpresa" >
	<tr>
		<td class="altoGraficaEmpresa">
			&nbsp;
		</td>
	</tr>


	<tr>
		<td width="90px" class="textoGraficaEmpresa">
			Requisitos generales
		</td>
		<td width="260px" class="altoGraficaEmpresa">
			<?php
			$anchoEmpresasMentor=$porcentajeMentorGenerales*$anchoTotalGrafica/100;
			$anchoTodas=$porcentajeTodasGenerales*$anchoTotalGrafica/100;
			echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresasMentor px\"/>&nbsp;&nbsp;".number_format($porcentajeMentorGenerales,2);
			echo "<br>";
			echo "<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"$anchoTodas px\"/>&nbsp;&nbsp;".number_format($porcentajeTodasGenerales,2);
			?>
		</td>
	</tr>
	<tr>
		<td class="textoGraficaEmpresa">
			Requisitos de las instalaciones
		</td>
		<td class="altoGraficaEmpresa">
			<?php
			$anchoEmpresasMentor=$porcentajeMentorInstalaciones*$anchoTotalGrafica/100;
			$anchoTodas=$porcentajeTodasInstalaciones*$anchoTotalGrafica/100;
			echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresasMentor px\"/>&nbsp;&nbsp;".number_format($porcentajeMentorInstalaciones,2);
			echo "<br>";
			echo "<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"$anchoTodas px\"/>&nbsp;&nbsp;".number_format($porcentajeTodasInstalaciones,2);
			?>
		</td>
	</tr>
	<tr>
		<td class="textoGraficaEmpresa">
			Requisitos de las actividades
		</td>
		<td class="altoGraficaEmpresa">
			<?php
			$anchoEmpresasMentor=$porcentajeMentorActividades*$anchoTotalGrafica/100;
			$anchoTodas=$porcentajeTodasActividades*$anchoTotalGrafica/100;
			echo "<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"$anchoEmpresasMentor px\"/>&nbsp;&nbsp;".number_format($porcentajeMentorActividades,2);
			echo "<br>";
			echo "<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"$anchoTodas px\"/>&nbsp;&nbsp;".number_format($porcentajeTodasActividades,2);
			?>
		</td>
	</tr>
</table>
<div class="textoGraficaEmpresa"><br>
	<img src='imagenes/generales/barraVerde.jpg' height='15px' width=\"15 px\"/>&nbsp;&nbsp; Tus empresas
	<img src='imagenes/generales/barraMorada.jpg' height='15px' width=\"15 px\"/>&nbsp;&nbsp;Empresas similares
</div>
<div class="espacioArriba"></div>
<div id="saltoDeRenglon"></div>
<div id="ColIzquierda30">


	<div class="tituloDesempeno">
		Empresas supervisadas:
	</div>
	<div id="saltoDeRenglon"></div>

	<?php for($x=0;$x<count($this->mentor->arrEmpresasSupervisadas);$x++) {?>
		<div id="itemIzquierda">
			<?php $this->fx->ponerBoton('mentor', 'irAEmpresa', $this->mentor->arrEmpresasSupervisadas[$x]['id'], $this->mentor->arrEmpresasSupervisadas[$x]['nombreEmpresa'], NULL, NULL, NULL, 'botonAzul', 0);
			?>
			<span class="botonAzulChico">
			<?php
				$this->fx->ponerBoton('mentor', 'editarEmpresa',"$x", 'Editar', NULL, NULL, NULL, 'botonAzulChico', 0);
			?>
			</span>
		</div>
	<?php } ?>
</div>