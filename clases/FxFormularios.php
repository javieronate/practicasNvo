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

/**
 *
 * Helper para inserción y funcionamiento de elementos de formularios
 *
 * Clase FxFormularios
 *
 * @package BuenasPracticas
 * @author  Javier Oñate Mendía (Dédalo)
 *
 */
class FxFormularios
{
	/**
	 * Getter del nombre de formulario
     *
	 * @return string
	 */
	function getFormulario()
	{
		return(NOMBRE_FORMULARIO);
	}

	/**
	 *
	 * Función para insertar un campo de texto
	 *
	 * @param $tipo
	 * @param $nombre
	 * @param $tamano
	 * @param $max
	 * @param $valor
	 * @param null $clase
	 * @param null $id
	 * @param null $enviarFormulario
	 * @param null $foco
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 */
	function ponerInput($tipo,$nombre,$tamano,$max,$valor,$clase=null,$id=null,$enviarFormulario=null,$foco=null,$accion=null,$subaccion=null,$item=null)
	{
		$valorId=($id!=null) ? "id='".$id."' " : "";
		$accionTxt = ($accion!='') ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!='') ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!='') ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$valorEnviar=($enviarFormulario!=null) ? " onblur=\"javascript:".$accionTxt.$subAccionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";
		$valorFoco=($foco!=null) ? " autofocus='".$foco."' " : "";
		$valorClase=($clase!=null) ? " class='".$clase."' " : "";
		echo "<input type='".$tipo."' name='".$nombre."' $valorId size='".$tamano."' maxlength='".$max."' value='".$valor."'$valorClase $valorFoco $valorEnviar>";
	}

	/**
	 *
	 * Función para insertar un campo de texto
	 *
	 * @param $accion
	 * @param $subaccion
	 * @param $item
	 * @param $etiqueta
	 * @param $imagen
	 * @param $anchoImagen
	 * @param $altoImagen
	 * @param $clase
	 * @param $borde
	 */
	function ponerBoton($accion,$subaccion,$item,$etiqueta,$imagen,$anchoImagen,$altoImagen,$clase,$borde,$subitem=null)
	{
		$accionTxt = ($accion!='') ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!='') ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!='') ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$subItemTxt=($subitem!=null) ? "document.".NOMBRE_FORMULARIO.".subItem.value='".$subitem."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		if($imagen!=''){
			$anchoTxt=($anchoImagen!='') ? " width='".$anchoImagen."' " : "";
			$altoTxt=($altoImagen!='') ? " height='".$altoImagen."' " : "";
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			$bordeTxt=($borde!='') ? " border='".$borde."' " : "";
			$etiquetaTxt=($etiqueta!='') ? " alt='".$etiqueta."' " : "";
			$etiquetaDef="<img src='"."$imagen' $anchoTxt$altoTxt$claseTxt$bordeTxt$etiquetaTxt>";
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$submitTxt>";
			echo("$etiquetaDef");
			echo "</a>";
		}else{
			$claseTxt=($clase!='') ? " class='".$clase."' " : "";
			echo "<a href=\"javascript:$accionTxt$subAccionTxt$itemTxt$subItemTxt$submitTxt$claseTxt>";
			echo "$etiqueta";
			echo("</a>");
		}
	}

	/**
 	 *
	 * Función para insertar un menú desplegable de una sola selección
	 *
	 * @param $nombre
	 * @param $titulo
	 * @param $arreglo
	 * @param $valorCategoria
	 * @param $valor
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 */
	function ponerMenu($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null)
	{
		$accionTxt = ($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		$onChangeTxt=($enviarFormulario!=null) ? "onChange=\"javascript:$accionTxt$subAccionTxt$itemTxt$submitTxt" : '';
		$tituloTxt=($titulo !=null) ? "<option value=\"$titulo\" >$titulo</option>" : '';

		echo "<select name='".$nombre."' id='".$nombre."' ";
		echo " $onChangeTxt";
		echo " $claseTxt>";
		echo "$tituloTxt";

		for($x=0;$x<count($arreglo);$x++){
			if ($valorCategoria==null) {
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
//				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".utf8_encode($arreglo[$x]['nombre'])."</option>";
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}else if ($valorCategoria!=null and $valorCategoria==$arreglo[$x]['categoria']){
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}
		}
		echo "</select>";
	}

	/**
 	 *
	 * Función para insertar un menú desplegable de opción múltiple
	 *
	 * @param $nombre
	 * @param $titulo
	 * @param $arreglo
	 * @param $valorCategoria
	 * @param $valor
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 * @param $multiple
	 * @param int $renglones
	 */
	function ponerMenuMultiple($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$multiple,$renglones=8)
	{
		$valoresSeleccionados=array();
		for ($z=0;$z<count($valor);$z++){
			$valoresSeleccionados[]=$valor[$z]['centroId'];
		}

		$accionTxt = ($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		$esMultiple=($multiple!=null) ? "multiple='multiple'" : "";
		$onChangeTxt=($enviarFormulario!=null) ? "onChange=\"javascript:$accionTxt$subAccionTxt$itemTxt$submitTxt" : '';
		$cuantosRenglones=($multiple!=null) ? "size='".$renglones."'" : '';
		$tituloTxt=($titulo !=null) ? "<option value=\"0\" >$titulo</option>" : '';


		echo "<select name='".$nombre."[]' id='".$nombre."' $cuantosRenglones $esMultiple $onChangeTxt $claseTxt>";

		echo "$tituloTxt";

		for($x=0;$x<count($arreglo);$x++){
			if ($valorCategoria==null) {
				$seleccionTxt = (in_array($arreglo[$x]['id'], $valoresSeleccionados)) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".utf8_encode($arreglo[$x]['nombre'])."</option>";
			}else if ($valorCategoria!=null and $valorCategoria==$arreglo[$x]['categoria']){
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}
		}
		echo "</select>";
	}

	/**
	 *
	 * Función para insertar un menú de varios renglones y una sola opción
	 *
	 * @param $nombre
	 * @param $titulo
	 * @param $arreglo
	 * @param $valorCategoria
	 * @param $valor
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 * @param $multiple
	 * @param int $renglones
	 */
	function ponerMenuRenglones($nombre,$titulo,$arreglo,$valorCategoria,$valor,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null,$multiple,$renglones=8)
	{
		//$valoresSeleccionados=array();
		//for ($z=0;$z<count($valor);$z++){
		//	$valoresSeleccionados[]=$valor[$z]['centroId'];
		//}

		$accionTxt = ($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : "";
		$subAccionTxt = ($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : "";
		$itemTxt = ($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : "";
		$submitTxt="document.".NOMBRE_FORMULARIO.".submit();\"";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		$esMultiple=($multiple!=null) ? "multiple='multiple'" : "";
		$onChangeTxt=($enviarFormulario!=null) ? "onChange=\"javascript:$accionTxt$subAccionTxt$itemTxt$submitTxt" : '';
		$cuantosRenglones=($multiple!=null) ? "size='".$renglones."'" : '';
		$tituloTxt=($titulo !=null) ? "<option value=\"0\" >$titulo</option>" : '';


		echo "<select name='".$nombre."[]' id='".$nombre."' $cuantosRenglones $esMultiple $onChangeTxt $claseTxt>";

		echo "$tituloTxt";

		for($x=0;$x<count($arreglo);$x++){
			if ($valorCategoria==null) {
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".utf8_encode($arreglo[$x]['nombre'])."</option>";
			}else if ($valorCategoria!=null and $valorCategoria==$arreglo[$x]['categoria']){
				$seleccionTxt = ($arreglo[$x]['id']==$valor) ? " selected " : '';
				echo "<option value=\"".$arreglo[$x]['id']."\" $seleccionTxt>".$arreglo[$x]['nombre']."</option>";
			}
		}
		echo "</select>";
	}

	/**
 	 *
	 * Función para insertar un área de texto
	 *
	 * @param $nombre
	 * @param $columnas
	 * @param $filas
	 * @param null $clase
	 * @param null $valor
	 */
	function ponerAreaTexto($nombre,$columnas,$filas,$clase=null,$valor=null)
	{
		$claseTxt=($clase!=null) ? " class='".$clase."' " : '';
		$valorTxt=($valor!=null) ? " $valor " : '';

		echo "<textarea name='".$nombre."' cols='".$columnas."' rows='".$filas."' $claseTxt >".$valorTxt."</textarea>";
	}

	/**
  	 *
	 * Función para insertar un checkBox
	 *
	 * @param $nombre
	 * @param $leyenda
	 * @param $valor
	 * @param $seleccionado
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $clase
	 * @param null $enviarFormulario
	 */
	function ponerCheckBox($nombre,$leyenda,$valor,$seleccionado,$accion=null,$subaccion=null,$item=null,$clase=null,$enviarFormulario=null)
	{
		$leyendaTxt=(strlen($leyenda)>0) ? $leyenda : '';
		$claseTxt=($clase!=null) ? "class='".$clase."'" : '' ;
		$marcado=($seleccionado==1) ? ' checked ' : '';
		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$onChangeTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";
		echo "<input name='".$nombre."' type='checkbox' value='".$valor."' $marcado $onChangeTxt $claseTxt> $leyendaTxt </input>";
	}

	/**
  	 *
	 * Función para insertar un Radio Button
	 *
	 * @param $nombre
	 * @param $arreglo
	 * @param $valor
	 * @param null $clase
	 * @param null $accion
	 * @param null $subaccion
	 * @param null $item
	 * @param null $enviarFormulario
	 */
	function ponerRadioButtons($nombre,$arreglo,$valor,$clase=null,$accion=null,$subaccion=null,$item=null,$enviarFormulario=null)
	{
		$claseTxt=($clase!=null) ? "<div class='".$clase."'>" : '' ;
		$claseTxtFin=($clase!=null) ? "</div>" : '' ;

		$accionTxt=($accion!=null) ? "document.".NOMBRE_FORMULARIO.".accion.value='".$accion."';" : '';
		$subacionTxt=($subaccion!=null) ? "document.".NOMBRE_FORMULARIO.".subaccion.value='".$subaccion."';" : '';
		$itemTxt=($item!=null) ? "document.".NOMBRE_FORMULARIO.".item.value='".$item."';" : '';
		$cambioTxt=($enviarFormulario!=null) ? " onchange=\"javascript:".$accionTxt.$subacionTxt.$itemTxt."document.".NOMBRE_FORMULARIO.".submit();\" " : "";

		for ($x=0;$x<count($arreglo);$x++){
			$marcado=($arreglo[$x]['id']==$valor)? " checked " : '';
			echo "$claseTxt &nbsp;&nbsp;&nbsp;<input name='".$nombre."' type='radio' value='".$arreglo[$x]['id']."' $marcado $cambioTxt>".$arreglo[$x]['nombre'].$claseTxtFin;
		}
	}

	/**
	 *
	 * Genera un string pseudoaleatorio del largo especificado
	 *
	 * @param $largo
	 *
	 * @return string
	 */
	function hacerAlfanumericoAleatorio($largo)
	{
		$caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$texto = '';
		for ($x = 0; $x < $largo; $x++) {
			$texto .= $caracteres[rand(0, strlen($caracteres) - 1)];
		}
		return($texto);
	}


	function convertirAASCII( $texto )
	{
        return strtr(utf8_decode($texto),
        utf8_decode(
        'ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ& '),
        'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy__');
	}

	/**
  	 *
	 * Función para cambiar formato de fecha de (año-mes-dia) a (dia-mes-año)
	 *
	 * @param $fecha
	 * @return string
	 */
	function transformarFechaDMY($fecha)
	{
		$ano=substr($fecha,0,4);
		$mes=substr($fecha,5,2);
		$dia=substr($fecha,8,2);
		$nuevaFecha="$dia-$mes-$ano";
		return ($nuevaFecha);
	}

	/**
  	 *
	 * Función para calcular los dias transcurridos entre dos fechas
	 *
	 * @param $inicio
	 * @param $fin
	 * @return float
	 */
	function diasTranscurridos($inicio,$fin)
	{
		$start = strtotime($inicio);
		$end = strtotime($fin);
		$days_between = ceil(abs($end - $start) / 86400);
		return($days_between);
	}

	/**
  	 *
	 * Función para enseñar un arreglo para debugueo
	 *
	 * @param $arreglo
	 * @param $nombre
	 */
	function ensenarArreglo($arreglo,$nombre)
	{
		print "<pre>";
		echo "<br>$nombre  <BR>";
		print_r($arreglo);
		print "</pre>";
	}

	/**
	 *
	 * Función para insertar un menú desplegable con categorias de agrupación
	 * de práctica y criterios
	 *
	 * @param      $arreglo
	 * @param null $clase
	 */
	function ponerMenuJerarquico($arreglo, $clase=null)
	{
		$titulo="Elija criterio";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		echo "<select name='menuPracticaCriterio' id='menuPracticaCriterio'  >";
		echo "<option value='".$titulo."' >$titulo</option>";
		for($x=0;$x<count($arreglo);$x++){
			echo "<option value='".$arreglo[$x]['id']."' ><div class='tituloSeccion'>".$arreglo[$x]['nombrePractica']."</div></option>";
			for($y=0;$y<count($arreglo[$x]['criterios']);$y++){
				echo "<option value='".$arreglo[$x]['criterios'][$y]['criterioId']."'><div class='tituloSeccion'>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$arreglo[$x]['criterios'][$y]['nombre']."</div></option>";
			}
		}
		echo "</select>";
	}

	/**
	 *
	 * Función para insertar un menú desplegable con categorias de agrupación
	 * de categoría y prácticas
	 *
	 * @param      $arreglo
	 * @param null $clase
	 */
	function ponerMenuPracticasPendientes($arreglo, $clase=null)
	{
		$titulo="Elija practica";
		$claseTxt=($clase!=null) ? " class='".$clase."' " :'' ;
		echo "<select name='menuPracticaPendiente' id='menuPracticaPendiente'  >";
		echo "<option value='".$titulo."' >$titulo</option>";
		for($x=0;$x<count($arreglo);$x++){
			echo "<option value='noSeleccionable' ><div class='tituloSeccion'>".$arreglo[$x]['nombreCategoria']."</div></option>";
			for($y=0;$y<count($arreglo[$x]['practicas']);$y++){
				if($arreglo[$x]['practicas'][$y]['idEstatus'] == '') {
					echo "<option value='".$arreglo[$x]['practicas'][$y]['idPractica']."'><div class='tituloSeccion'>"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$arreglo[$x]['practicas'][$y]['nombrePractica']."</div></option>";
				}
			}
		}
		echo "</select>";
	}

}
