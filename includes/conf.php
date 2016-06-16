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

// extender el maximo de tiempo de ejecución
//ini_set('max_execution_time', 300);
set_time_limit(0);
// error_reporting(E_ERROR);
error_reporting(E_ALL);

// constantes de programa
define('DEBUG','1');

 //Configuracion MySQL
$mysqlServidor =   "localhost";
$mysqlUser =  "jom";
$mysqlClave =    "lehendakari";
$mysqlDb="buenasPracticas";
$mysqlPort="3306";

// Carpeta de Archivos guardados (de preferencia fuera del public_html, wwww)
$uploadfolder = "";

include_once ('constantes.php');
