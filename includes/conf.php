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



// error_reporting(E_ERROR);
error_reporting(E_ALL);

// constantes de programa
define('DEBUG','0');

//$mysqlServidor =   "dedalocommx1.ipagemysql.com";
//$mysqlUser =  "javier";
//$mysqlClave =    "orate";
//$mysqlDb="dedalo_practicas";
//$mysqlPort="3306";


 //Configuracion MySQL
$mysqlServidor =   "localhost";
$mysqlUser =  "jom";
$mysqlClave =    "lehendakari";
$mysqlDb="buenasPracticas";
$mysqlPort="3306";

// ideas en https://api.wordpress.org/secret-key/1.1/salt/
// Guarda una copia del SALT en un lugar seguro para recuperarlo en caso de perdida!
$salt = "7?4E`]/j|Ocq]H6XMh,w(=]Xn >-pO6J8s,WTYb+C{ip!hIf|jdwM|67z!Z#*2d?C;|,8~lZM7^-Z!T7i/+}YVVtIKGU?HAFtM[j/:Wd:V[";
// Carpeta de Archivos guardados (de preferencia fuera del public_html, wwww)
$uploadfolder = "";

include_once ('constantes.php');
//define('NOMBRE_FORMULARIO','reporteador');
//define('FOLDER_IMAGENES_CATEGORIAS','imagenes/categorias/');
//define('FOLDER_IMAGENES_PRACTICAS','imagenes/practicas/');
