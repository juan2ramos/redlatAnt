<?
	include("../application.php");

	include($CFG->templatedir . "/headerpopup.php");

	$frm=$_GET;
	generar_reporte($frm);

//FUNCIONES

function generar_reporte($frm){
GLOBAL $CFG, $ME, $db;

	if(!isset($frm["reporte"])) die("No viene el número del reporte.");
	if(!file_exists("reportes/" . $frm["reporte"] . ".php")) die("El reporte $frm[reporte] no existe.");
	include("reportes/" . $frm["reporte"] . ".php");
	$qid=$db->sql_query($strSQL);
	include("templates/listado_reportes.php");

}


?>
