<?
	include("../application.php");

	$frm=$_GET;
	generar_reporte($frm);

//FUNCIONES

function generar_reporte($frm){
GLOBAL $CFG, $ME, $db;

	if(!isset($frm["header"]) || $frm["header"]=="1") include($CFG->templatedir . "/headerpopup.php");

	if(!isset($frm["reporte"])) die("No viene el número del reporte.");
	if(!file_exists("reportes_personalizados/" . $frm["reporte"] . ".php")) die("El reporte $frm[reporte] no existe.");
	include("reportes_personalizados/" . $frm["reporte"] . ".php");

}


?>
