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
echo "geoJson<br>";
echo ($this->admon->geoJSON);
echo "<br>";
$this->fx->ensenarArreglo($this->arrDatosEmpresaTmp,'arrDatosEmpresaTmp');
$this->fx->ensenarArreglo($this->empresa,'empresa');
$this->fx->ensenarArreglo($_POST,'post');


//$this->fx->ensenarArreglo($this->arrDatosEmpresaTmp,'arrDatosEmpresaTmp');
//$this->fx->ensenarArreglo($this->arrDatosEmpresaTmp,'arrDatosEmpresaTmp');
//$this->fx->ensenarArreglo($this->empresa,'empresa');
//$this->fx->ensenarArreglo($this->arrPreguntasAutoevaluacion,'arrPreguntasAutoevaluacion');