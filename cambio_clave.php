<?
include("../application.php");

$mode = nvl($_POST["mode"],nvl($_GET["mode"]));

switch(nvl($mode))
{
	case "cambioClave":
		cambioClave($_POST);
	break;

	default:
		print_form();
	break;
}

function print_form()
{
	global $db,$CFG,$ME;

	include($CFG->templatedir."/header.php");
	include($CFG->templatedir."/cambio_clave_form.php");
}


function cambioClave($frm)
{
	global $db,$CFG,$ME;

	include($CFG->templatedir."/header.php");

	if(md5($frm["anterior"]) != $_SESSION[$CFG->sesion_admin]["user"]["password"])
	{
		$error = "La clave anterior no coincide!";
		include($CFG->templatedir."/cambio_clave_form.php");
		die;		
	}
	
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"]==10) $db->sql_query("UPDATE promotores SET password = '".md5($frm["nueva"])."' WHERE id=".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
	else $db->sql_query("UPDATE usuarios SET password = '".md5($frm["nueva"])."',email='".$frm["email"]."' WHERE id=".$_SESSION[$CFG->sesion_admin]["user"]["id"]);

	echo "<br><br><br><b>EL CAMBIO SE HA REALIZADO CON EXITO!.</b>";
}


?>
