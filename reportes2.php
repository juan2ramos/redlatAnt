<?
	include("../application.php");
	if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
	else $frm=$_GET;
	
	switch(nvl($frm["mode"])){
		case "generar_reporte":
			generar_reporte($frm);
			break;
		default:
			listar_reportes();
			break;
	}
 
//	FUNCIONES:

function generar_reporte($frm){
GLOBAL $CFG, $db, $ME;

	$qReporte=$db->sql_query("SELECT * FROM reportes2 WHERE id='$frm[id]'");
	$reporte=$db->sql_fetchrow($qReporte);
	include($CFG->templatedir . "/header_reportes2.php");
	include("reportes2/" . $reporte["id"] . ".php");
}

function listar_reportes(){
GLOBAL $CFG, $db, $ME;

	include($CFG->templatedir . "/header.php");
	$pdf=0;
	$excel=0;
	$qReportes=$db->sql_query("SELECT * FROM reportes2 ORDER BY numero");
	include($CFG->templatedir . "/listado_de_reportes.php");
}

?>
