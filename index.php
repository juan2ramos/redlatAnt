<?php
	include("application.php");
        
                
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 4)
		$module = "grupos_danza";
	elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5)
		$module = "grupos_musica";
	elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6)
		$module = "grupos_teatro";

	$module=nvl($module,$CFG->defaultModule);
	if(file_exists($CFG->modulesdir . "/" . $module . ".php"))
		include($CFG->modulesdir . "/" . $module . ".php");
	elseif(file_exists($CFG->modulesdir . "/" . $module . ".phtml"))
		include($CFG->modulesdir . "/" . $module . ".phtml");
	else{
		include($CFG->templatedir . "/header.php");
		die("[" . $module . "]:<br>M?dulo no implementado.");
	}

	if($module == "citas")
		hacer_tabla();

	switch(nvl($mode)){
		case "download":
			download($_GET);
			break;

		case "agregar" :
				agregar($_GET);
			break;

		case "insert" :
			insert($_POST);
			break;

		case "editar" :
			editar($_GET);
			break;

		case "consultar" :
			consultar($_GET);
			break;

		case "update" :
			update($_POST);
			break;

		case "update_event_input" :
			update_event_input($_POST);
			break;

		case "eliminar" :
			eliminar($_GET);
			break;

		case "buscar" :
			print_busqueda_form($_GET);
			break;

		case "aprobar":
			aprobar($_POST);
			break;

		case "actualizar":
			update_list($_GET);
			break;	
		
		case "find":
			find($_GET);
			break;

		case "listado_obras_artista":
			listado_obras_artista($_GET);
		break;

		case "usuarios_artistas":
			usuarios_artistas($_GET);
		break;

		case "agregar_rel_usuarios_artistas":
			agregar_rel_usuarios_artistas($_POST);
		break;

		case "borrar_rel_usuarios_artistas":
			borrar_rel_usuarios_artistas($_GET);
		break;

		case "eliminarImagen":
			eliminarImagen($_GET);
		break;

		case "eliminarFS":
			eliminarFS($_GET);
		break;

		case "envio_boletin":
			envio_boletin($_GET);
		break;

		case "enviar_boletin":
			enviar_boletin($_POST);
		break;

		default:
			encontrar($_GET);
			break;
	}


/*	********************************************	*/
/*	                 FUNCIONES:                 	*/
/*	********************************************	*/

function download($frm){
	GLOBAL $CFG, $ME, $entidad;

	$entidad->loadValues($frm);
	$entidad->maxRows=NULL;//Para que no les ponga l?mite a los listados.
	$entidad->find();
	$filename=$entidad->name;
	$ext="csv";
	include("templates/csv.php");
}

function enviar_boletin($frm){
GLOBAL $CFG, $ME, $entidad, $db;

  include("templates/header.php");
  $urlMonitoreo=$CFG->admin_dir . "/monitoreo.php";
  $qid=$db->sql_query("SELECT * FROM boletin_envio_actual");
  if($result=$db->sql_fetchrow($qid)){
    echo "<br>\n<br>\nNo se puede volver a enviar en este momento.<br>\nHay un env?o en ejecuci?n.<br>\n";
    echo "Si desea monitorear el env?o, por favor haga clic <a href=\"" . $urlMonitoreo ."\" TARGET=\"_parent\">aqu?</a>.<br>\n";
    return;
  }
  preguntar($frm);
  $entidad->loadValues($frm);
  $entidad->set("mode","insert");
  $id_envio=$entidad->insert();
  $commandLine=dirname(__FILE__) . "/envio_boletin_cli.php " . $id_envio;
  echo "Lanzando el proceso de fondo...<br>\n";
  flush();
  $pid= exec("/usr/bin/php $commandLine &>/tmp/" . $CFG->sesion . " & echo \$!",$results,$status);
  $query="insert into boletin_envio_actual (id_envio,pid) VALUES ('$id_envio','$pid')";
  $db->sql_query($query);
  echo "Listo.<br>\nSi desea monitorear el env?o, por favor haga clic <a href=\"" . $urlMonitoreo ."\" TARGET=\"_parent\">aqu?</a>.<br>\n";

}

function envio_boletin($frm){
GLOBAL $CFG, $ME, $entidad;

  $frm["mode"]="agregar";
  $entidad->set("mode","$frm[mode]");
  $entidad->set("newMode","enviar_boletin");
  $entidad->loadValues($frm);
  include($CFG->templatedir . "/header.php");

  $att=$entidad->getAttributeByName("fecha");
  $att->set("visible",FALSE);
  $att->set("editable",FALSE);
  $att=$entidad->getAttributeByName("fecha_fin");
  $att->set("visible",FALSE);
  $att->set("editable",FALSE);
  $att=$entidad->getAttributeByName("areas");
  $att->set("editable",FALSE);

  $string_entidad=$entidad->getForm($frm);
  $javascript_entidad=$entidad->getJavaScript();
  $iframe=$entidad->getLinkIframe();
  include("templates/entidad_form.php");
  echo "</table></table></table>";
}

function find($frm){
GLOBAL $CFG, $ME, $entidad;

	$queryArray=array();
	foreach($frm AS $key=>$val){
//		if($key!="mode" && $key!="mode_ant" && $val!="" && $val!="%") array_push($queryArray,$key . "=" . $val);
		if($key!="mode" && $key!="mode_ant" && $val!="" && $val!="%"){
			if(is_array($val)) $val=implode(",",$val);
			array_push($queryArray,$key . "=" . $val);
		}

	}
	$queryString=$ME . "?";
	$queryString.=implode("&",$queryArray);
	
	echo "<script>\n";
	echo "var url='" . $queryString . "';\n";
	echo "var openerUrl=window.opener.location.href;\n";
	echo "if(openerUrl.indexOf('iframe')!=-1) url=url + '&iframe';\n";
	echo "window.opener.location.href=url;\nwindow.close();\n</script>\n";
	echo "</script>\n";

}

function aprobar($frm){
}

function agregar($frm){
GLOBAL $CFG, $ME, $entidad;

	$entidad->set("mode","$frm[mode]");
	$entidad->set("newMode","insert");
	$entidad->loadValues($frm);
	include($CFG->templatedir . "/headerpopup.php");
	$string_entidad=$entidad->getForm($frm);
	$javascript_entidad=$entidad->getJavaScript('agregar');
	$iframe=$entidad->getLinkIframe();
	include("templates/entidad_form.php");

}

function insert($frm){
GLOBAL $CFG, $ME, $entidad,$db;

	$entidad->loadValues($frm);
	$entidad->set("mode","$frm[mode]");
	$frm["id"]=$entidad->insert();
	$iframe=$entidad->getLinkIframe();
	if($iframe==0){
		$url=parse_url($_SERVER["HTTP_REFERER"]);
		$queryString=$url["query"];
		$queryArray=explode("&",$queryString);
		$frmReferer=array();
		foreach($queryArray AS $val){
			if(preg_match("/^([^=]*)=(.*)$/",$val,$matches)){
				if($matches[1]=="foreignLabelFields"){
					if(base64_decode($matches[2])) $matches[2]=base64_decode($matches[2]);
				}
				$frmReferer[$matches[1]]=$matches[2];
			}
		}
		echo "<script language=\"JavaScript\" type=\"text/javascript\">\n";
		if(isset($frmReferer["inputName"]) && $frmReferer["inputName"]!=""){
			$strQuery="
				SELECT " . $frmReferer["foreignLabelFields"] . " AS nombre
				FROM " . $frmReferer["foreignTable"] . "
				WHERE " . $frmReferer["foreignField"] . "='" . $frm["id"] . "'
			";
			$qid=$db->sql_query($strQuery);
			if($result=$db->sql_fetchrow($qid)){
				$comboId=$frm["id"];
				$comboNombre=$result[0];
				echo "
					if(window.opener.document.entryform!=undefined && window.opener.document.entryform." . $frmReferer["inputName"] . "!=undefined && window.opener.document.entryform." . $frmReferer["inputName"] . ".selectedIndex!=undefined){
						elementos=window.opener.document.entryform." . $frmReferer["inputName"] . ".length;
						var nuevaOpcion=new Option('" . $comboNombre . "','" . $comboId . "');
						window.opener.document.entryform." . $frmReferer["inputName"] . "[elementos]=nuevaOpcion;
						window.opener.document.entryform." . $frmReferer["inputName"] . ".selectedIndex=elementos;
						window.opener.focus();
						window.close();
					}
					else{
						window.opener.location.reload();
						window.opener.focus();
						window.close();
					}
				";
			}
			else{
				echo "window.opener.location.reload();\nwindow.opener.focus();\nwindow.close();\n";
			}
		}
		else{
			echo "window.opener.location.reload();\nwindow.opener.focus();\nwindow.close();\n";
		}
		echo "</script>";
	}
	else{
		$frm['mode']="editar";
		editar($frm);
	}
		
}

function editar($frm){
GLOBAL $CFG, $ME, $entidad;

	$entidad->load($frm["id"]);
	$entidad->set("newMode","update");
	if(isset($frm["update_event_input"]))
	 $entidad->set("newMode","update_event_input");
	$entidad->set("mode","$frm[mode]");
	include($CFG->templatedir . "/headerpopup.php");
	
	$string_entidad=$entidad->getForm($frm);
	$javascript_entidad=$entidad->getJavaScript('editar');
	$iframe=$entidad->getLinkIframe();
	include("templates/entidad_form.php");

}

function consultar($frm){
GLOBAL $CFG, $ME, $entidad;

	$entidad->load($frm["id"]);
	$entidad->set("newMode","consultar");
	$entidad->set("mode","$frm[mode]");
	include($CFG->templatedir . "/headerpopup.php");
	$string_entidad=$entidad->getForm($frm);
	$javascript_entidad=$entidad->getJavaScript('consultar');
	include("templates/entidad_form.php");

}

function update($frm){
	GLOBAL $CFG, $ME, $entidad;

	$entidad->loadValues($frm);
//	$entidad->load($frm["id"]);
	$entidad->set("mode","$frm[mode]");
	$entidad->update();
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\nwindow.opener.location.reload();\nwindow.opener.focus();\nwindow.close();\n</script>";
	
}

function update_event_input($frm){
	GLOBAL $CFG, $ME, $entidad,$db;

	if($frm["mode"]=="update_event_input"){
		$fecha=explode(" ",$frm["fecha"]);
		$id_gps_vehi=$frm["id_gps_vehi"];
		
		$strq="SELECT x(the_geom) AS longitude, y(the_geom) AS latitude FROM gps_vehi WHERE id=$id_gps_vehi";
		$qid=$db->sql_query($strq);
		if($gps_vehi=$db->sql_fetchrow($qid)){
			$arreglo["longitude"]=$gps_vehi["longitude"];
			$arreglo["latitude"]=$gps_vehi["latitude"];
		}
			
		$arreglo["date"]=$fecha[0];
		$arreglo["time"]=$fecha[1];
		$arreglo["phone"]=$frm["phone"];
		$arreglo["event"]=$frm["event"];
		$arreglo["eventInput"]=$frm["event_input"];

		include($CFG->libdir . "/funciones_gps_solo_hll.php");
		
		$array_err=alimentar_tablas($arreglo,$id_gps_vehi);
		if(is_array($array_err)){
			$array_err["descripcion"]="CORREGIDO : " . $frm["descripcion"];
		}
		else{
			$array_err=array();
			$array_err["id_tipo"]=11;
		}
			$db->sql_update("errores",$array_err,$frm["id"]);
	}
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\nwindow.opener.location.reload();\nwindow.opener.focus();\nwindow.close();\n</script>";
	
}

function update_list($frm){
GLOBAL $CFG, $ME, $entidad;
	
	$entidad->set("mode","$frm[mode]");
	$entidad->update_list($frm);
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\nwindow.location.href='$ME?module=$frm[module]'</script>";

}

function eliminar($frm){
GLOBAL $CFG, $ME, $entidad;

//	for($i=0;$i<sizeof($frm["id"]);$i++){
//		$entidad->load($frm["id"][$i]);
		$entidad->load($frm["id"]);
		$entidad->set("mode","$frm[mode]");
		if($entidad->hasRelatedEntities()){
			echo "<script language=\"JavaScript\" type=\"text/javascript\">\nwindow.outerHeight=200;\nwindow.outerWidth=300;\n</script>\n";
			echo "No se puede borrar, porque tiene elementos relacionados.<br><br>\n";
			echo "<input type=\"button\" onClick=\"window.close();\" value=\"Cerrar\">";
			die();
		}
		$entidad->set("id",$frm['id']);
		$entidad->delete();
//	}
	echo "<script language=\"JavaScript\" type=\"text/javascript\">\nwindow.opener.location.reload();\nwindow.opener.focus();\nwindow.close();\n</script>";
	
}

function print_busqueda_form($frm){
GLOBAL $CFG, $ME, $entidad;

	include($CFG->templatedir . "/headerpopup.php");

	$entidad->set("mode","$frm[mode]");
	$javascript_entidad=$entidad->getJavaScript('buscar');
	$string=$entidad->printBusqueda();
	include("templates/busqueda_form.php");

}

function encontrar($frm){
GLOBAL $CFG, $ME, $entidad;

	$entidad->loadValues($frm);
	$entidad->find();
	if(isset($frm['popup']) || isset($frm['iframe'])){
		include($CFG->templatedir . "/headerpopup.php");	
		include("templates/listado_simple.php");
	}
	else{
		include($CFG->templatedir . "/header.php");
		$entidad->findPath();
		include("templates/listado.php");
	}

}

function listado_obras_artista($frm)
{
	GLOBAL $CFG, $ME,$db,$entidad;

	include($CFG->templatedir . "/headerpopup.php");

	$qidNombreA = $db->sql_query("SELECT * FROM artistas WHERE id =".$frm["id_artista"]);
	$queryNombreA = $db->sql_fetchrow($qidNombreA);
	$nombreArtista = $queryNombreA["nombres"]." ".$queryNombreA["apellidos"];

	$consulta = "
		SELECT * FROM (
				SELECT 'Danza' as tipo,gd.nombre as grupo,od.obra, (CASE WHEN ad.actividad=1 THEN 'Director' WHEN ad.actividad=2 THEN 'Bailar?n' WHEN ad.actividad=3 THEN 'T?cnico' END) as actividad
				FROM artistas_danza ad
				LEFT JOIN obras_danza od ON od.id = ad.id_obras_danza
				LEFT JOIN grupos_danza gd ON gd.id = od.id_grupos_danza
				WHERE ad.id_artista = ".$frm["id_artista"]."
				UNION
				SELECT 'Danza' as tipo,gd.nombre as grupo,od.obra, 'Productor' as actividad
				FROM directores_danza dd
				LEFT JOIN obras_danza od ON od.id = dd.id_obras_danza
				LEFT JOIN grupos_danza gd ON gd.id = od.id_grupos_danza
				WHERE dd.id_artista = ".$frm["id_artista"]."
				UNION
				SELECT 'M?sica' as tipo,gm.nombre as grupo,om.produccion as obra, (CASE WHEN am.actividad=1 THEN 'M?sico' WHEN am.actividad=2 THEN 'Ingeniero de sonido' WHEN am.actividad=3 THEN 'Roadie' END) as actividad
				FROM artistas_musicos am
				LEFT JOIN obras_musica om ON om.id = am.id_obras_musica
				LEFT JOIN grupos_musica gm ON gm.id = om.id_grupos_musica
				WHERE am.id_artista = ".$frm["id_artista"]."
				UNION
				SELECT 'M?sica' as tipo,gm.nombre as grupo,om.produccion as obra, 'Productor' as actividad
				FROM productores_musica pm
				LEFT JOIN obras_musica om ON om.id = pm.id_obras_musica
				LEFT JOIN grupos_musica gm ON gm.id = om.id_grupos_musica
				WHERE pm.id_artista = ".$frm["id_artista"]."
				UNION
				SELECT 'Teatro' as tipo,gt.nombre as grupo,ot.obra, (CASE WHEN at.actividad=1 THEN 'Director' WHEN at.actividad=2 THEN 'Actor/Actriz' WHEN at.actividad=3 THEN 'T?cnico' WHEN at.actividad=4 THEN 'Productor' END) as actividad
				FROM artistas_teatro at
				LEFT JOIN obras_teatro ot ON ot.id = at.id_obras_teatro
				LEFT JOIN grupos_teatro gt ON gt.id = ot.id_grupos_teatro
				WHERE at.id_artista = ".$frm["id_artista"]."
				UNION
				SELECT 'Teatro' as tipo,gt.nombre as grupo,ot.obra, 'Director/a' as actividad
				FROM directores_teatro dt
				LEFT JOIN obras_teatro ot ON ot.id = dt.id_obras_teatro
				LEFT JOIN grupos_teatro gt ON gt.id = ot.id_grupos_teatro
				WHERE dt.id_artista = ".$frm["id_artista"]."
		)as todo
		";

	$qid = $db->sql_query($consulta);
	$obras = array();
	while($result = $db->sql_fetchrow($qid))
	{
		$obras[$result["tipo"]][]=$result;
	}

	echo "<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"4\" bgcolor=\"#ffffff\">";
	echo "<tr><td align=\"center\"><br><b>".$nombreArtista."</b></td></tr>";

	if(count($obras) == 0)
	{
		echo "<tr><td align=\"center\"><br><b>La persona no est? relacionada con ninguna obra y/o producci?n.</b></td></tr>";
	}



	foreach($obras as $key => $tipo)
	{
		echo "<tr><td><br><b>".$key."</b></td></tr>
			<tr>
				<td>	
					<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#999999\" class=\"textobco10\">
						<tr bgcolor='#bfbfac' class='title'>
							<td align=\"center\"><b>Artista</b></td>
							<td align=\"center\"><b>Obra / Producci?n</b></td>
							<td align=\"center\"><b>Actividad</b></td>
						</tr>";

		foreach($tipo as $datos)
		{
			echo "<tr bgcolor='#ffffff'><td>".$datos["grupo"]."</td>
				<td>".$datos["obra"]."</td>
				<td>".$datos["actividad"]."</td>
			</tr>";
		}
		echo "
					</table>
				</td>
			</tr>";
	}

	echo "<tr>
		<td height=40 valign=\"bottom\">
			<input type=\"button\" style=\"font-size:8pt\" value=\"Cerrar\" onClick=\"window.opener.focus();window.close();\">
		</td>
	</tr>
	</table>";
}


function usuarios_artistas($frm)
{
	global $db,$ME,$CFG;

	include($CFG->templatedir . "/headerpopup.php");

	$agregarRelacion = true;
	$qid = $db->sql_query("SELECT * FROM usuarios WHERE id=".$frm["id_usuario"]);
	$usuario = $db->sql_fetchrow($qid);

	$nivelesNoAceptados = array("1"=>"Administrador","2"=>"Admin G?neros","3"=>"Admin Artistas");
	$nivelesAceptados = array("4"=>"B?sico Grupo Danza","5"=>"B?sico Grupo M?sica","6"=>"B?sico Grupo Teatro","7"=>"Total Grupo Danza","8"=>"Total Grupo M?sica","9"=>"Total Grupo Teatro");
	
	echo "<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"4\" bgcolor=\"#ffffff\">";
	echo "<tr><td align=\"center\"><br><b>".$usuario["nombre"]." ".$usuario["apellido"]."</b></td></tr>";

	if($usuario["password"]=="" || $usuario["login"]=="")
	{
		echo "<tr><td align=\"center\"><br><b><font color='red'>El usuario no tiene login o password.  No se pueden agregar relaciones.</font></b></td></tr>";
		$agregarRelacion =false;
	}

	if(array_key_exists($usuario["id_nivel"],$nivelesNoAceptados))
	{
		echo "<tr><td><br>El Nivel de Acceso del Usuario (".$nivelesNoAceptados[$usuario["id_nivel"]].") no permite la relaci?n con Artistas.<br><br>Para relacionarlo con Artistas debe estar en alguno de los siguientes niveles: ".implode(", ",$nivelesAceptados).".</td></tr>";
		echo "<tr>
			<td height=40 valign=\"bottom\" align=\"center\">
				<input type=\"button\" style=\"font-size:8pt\" value=\"Cerrar\" onClick=\"window.opener.focus();window.close();\">
			</td>
		</tr>
		</table>";
		die;
	}

	//listado de las relaciones que tiene el usuario
	if($usuario["id_nivel"] == 4 || $usuario["id_nivel"] == 7)
	{
		$tabla = "grupos_danza";
		$campo = "id_grupo_danza";
	}
	elseif($usuario["id_nivel"] == 5 || $usuario["id_nivel"] == 8)
	{
		$tabla = "grupos_musica";
		$campo = "id_grupo_musica";
	}
	else
	{
		$tabla = "grupos_teatro";
		$campo = "id_grupo_teatro";
	}

	echo"<tr>
				<td>	
					<table width=\"100%\" border=\"0\" cellspacing=\"1\" cellpadding=\"2\" bgcolor=\"#999999\" class=\"textobco10\">
						<tr bgcolor='#bfbfac' class='title'>
							<td align=\"center\"><b>Artista</b></td>
							<td align=\"center\"><b>Opci?n</b></td>
						</tr>";
	$qidR = $db->sql_query("SELECT g.id,g.nombre
			FROM usuarios_".$tabla." u 
			LEFT JOIN ".$tabla." g ON g.id=u.".$campo."
			WHERE u.id_usuario=".$usuario["id"]."
			ORDER BY g.nombre");
	if($db->sql_numrows($qidR) == 0)
		echo "<tr bgcolor='#ffffff'><td colspan=2>No hay Relaciones.</td></tr>";

	$grupos = array(0);
	while($query = $db->sql_fetchrow($qidR))
	{
		echo "<tr bgcolor='#ffffff'><td>".$query["nombre"]."</td>
			<td widht='20%' align='center'><a href=\"".$CFG->admin_dir."/index.php?mode=borrar_rel_usuarios_artistas&id_usuario=".$usuario["id"]."&campo=".$campo."&tabla=".$tabla."&id_grupo=".$query["id"]."\"><img alt=\"Borrar Relaci?n\" border='0' src='".$CFG->icondir."/borrador.gif'></a></td>
			</tr>";
		$grupos[] = $query["id"];
	}

	if($agregarRelacion)
	{
	
		$qidGR = $db->sql_query("SELECT id,nombre FROM ".$tabla." WHERE id NOT IN (".implode(",",$grupos).") ORDER BY nombre");
		$selectArtistas.= "<select name=\"".$campo."\">";
		//$selectArtistas=">";
		//echo "<select>";
		while($queryGR = $db->sql_fetchrow($qidGR))
		{
			$selectArtistas.= "<option value='".$queryGR["id"]."'>".$queryGR["nombre"]."</option>\n";
		}
		$selectArtistas.= "</select>";

		//agregar relaci?n
		echo "
					</table>
				</td>
			</tr>
			<tr>
				<td height=40 valign=\"bottom\">
					<input type=\"button\" style=\"font-size:8pt\" value=\"Cerrar\" onClick=\"window.opener.focus();window.close();\">
				</td>
			</tr>
			<tr><td><hr></td></tr>
			<form name=\"entryform\" method=\"POST\" action=".$ME.">
			<input type=\"hidden\" name=\"mode\" value=\"agregar_rel_usuarios_artistas\">
			<input type=\"hidden\" name=\"tabla\" value=\"".$tabla."\">
			<input type=\"hidden\" name=\"id_usuario\" value=\"".$usuario["id"]."\">
			<tr><td><br><b>Agregar Relaci?n con Artista</b></td></tr>
			<tr>
				<td>
					<table class=\"textobco10\" cellspacing=\"5\" width=\"50%\">
						<tr>
							<td align=\"bottom\">
								<table>
									<tr>
										<td>Artista:</td>
										<td>".$selectArtistas."</td>
									</tr>
									<tr>
										<td height=50 align=\"bottom\" colspan=2>
											<input type=\"submit\" style=\"font-size:8pt\" value=\"Agregar\">&nbsp;&nbsp;
											<input type=\"button\" style=\"font-size:8pt\" value=\"Cerrar\" onClick=\"window.opener.focus();window.close();\">
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			</form>";
	}
	echo "</table>";
}

function agregar_rel_usuarios_artistas($frm)
{
	global $db,$ME,$CFG;

	if($frm["tabla"] == "grupos_danza")
	{
		$campo = "id_grupo_danza";
	}
	elseif($frm["tabla"] == "grupos_musica")
	{
		$campo = "id_grupo_musica";
	}
	else
	{
		$campo = "id_grupo_teatro";
	}

	$db->sql_query("INSERT INTO usuarios_".$frm["tabla"]." (id_usuario,".$campo.") VALUES('".$frm["id_usuario"]."','".$frm[$campo]."')" );
	//enviar_mail($frm["id_usuario"],$frm["tabla"],$frm[$campo]);
	usuarios_artistas($frm);
}

function enviar_mail($id_usuario,$tabla,$id_grupo)
{
	global $db,$CFG;
// se oculto el codigo
	/*$qid = $db->sql_query("SELECT * FROM usuarios WHERE id=".$id_usuario);
	$usuario = $db->sql_fetchrow($qid);
	$qid = $db->sql_query("SELECT nombre FROM ".$tabla." WHERE id=".$id_grupo);
	$grupo = $db->sql_fetchrow($qid);

	$mensaje = "
Buen D?a.

Se ha creado una cuenta para que administre el artista ".$grupo["nombre"].".

Usted puede entrar al portal de redlat (".$CFG->dirwww."/admin/login.php) con los siguientes datos de ingreso:

Usuario : ".$usuario["login"]."
Contrase?a : ".$usuario["resolv"]."

Si tiene alguna duda, no dude en escribirnos : ".$CFG->mail_envio."\n

Atentamente,

".$CFG->nombreSitioCompleto;

	$asunto = "Bienvenido al portal de Redlat";
	$cabeceraAd = 'From: '.$CFG->mail_envio. "\r\n" . 'Reply-To: '.$CFG->mail_envio;

	mail($usuario["email"],$asunto, $mensaje,$cabeceraAd);
	$mensaje.="\n\n\nNOTA: Copia del mail enviado a ".$usuario["email"];
	mail($CFG->mail_envio,$asunto, $mensaje,$cabeceraAd);*/
}




function borrar_rel_usuarios_artistas($frm)
{
	global $db,$ME,$CFG;

	$db->sql_query("DELETE FROM usuarios_".$frm["tabla"]." WHERE id_usuario='".$frm["id_usuario"]."' AND ".$frm["campo"]."='".$frm["id_grupo"] ."'");
	usuarios_artistas($frm);
	
}

function eliminarFS($frm)
{
	global $db,$entidad,$ME,$CFG;

	$dir=preg_replace("/\/+/","/",$CFG->dirroot . "/" . $CFG->filesdir);
	$archivo=$dir . "/" . $entidad->table . "/" . $frm["field"] . "/" . $frm["id"];
	if(file_exists($archivo)){
		if(!unlink($archivo)) die("Error:<br>\nNo se pudo eliminar el archivo <b>$archivo</b>.<br>\n<a href=\"" . $_SERVER["HTTP_REFERER"] . "\">Volver</a>");
	}

	$entidad->db->sql_query("UPDATE ".$entidad->table."
			SET
			mmdd_".$frm["field"]."_filename = NULL,
			mmdd_".$frm["field"]."_filetype = NULL,
			mmdd_".$frm["field"]."_filesize = NULL,
			".$frm["field"]."= NULL
			WHERE id = ".$frm["id"]);

	$frm['mode']="editar";
	editar($frm);
}

function eliminarImagen($frm)
{
	global $db,$entidad,$ME,$CFG;

	$entidad->db->sql_query("UPDATE ".$entidad->table."
			SET
			mmdd_".$frm["field"]."_filename = NULL,
			mmdd_".$frm["field"]."_filetype = NULL,
			mmdd_".$frm["field"]."_filesize = NULL,
			".$frm["field"]."= NULL
			WHERE id = ".$frm["id"]);
	$frm['mode']="editar";
	editar($frm);
}


function hacer_tabla()
{
	global $db;

	$db->sql_query("DROP TABLE IF EXISTS fechas_sesiones");

	$db->sql_query("CREATE TABLE fechas_sesiones (id_sesion integer, fecha timestamp)");
	$qid = $db->sql_query("
		SELECT s.id,r.duracion_cita,s.fecha_inicial,s.fecha_final 
		FROM sesiones s 
			LEFT JOIN ruedas r ON r.id = s.id_rueda
		WHERE r.id IS NOT NULL
		ORDER BY fecha_inicial
	");
	while($query = $db->sql_fetchrow($qid))
	{
		listado_citas($query["id"],$query["fecha_inicial"],$query["fecha_final"],$query["duracion_cita"]);
	}

	/*
	$qidf = $db->sql_query("SELECT * FROM fechas_sesiones");
	while($fecha = $db->sql_fetchrow($qidf))
	{
		preguntar($fecha);
	}
	*/
}

function listado_citas($id_sesion,$fecha_inicial,$fecha_final,$duracion)
{
	global $db;

	$db->sql_query("INSERT INTO fechas_sesiones (id_sesion,fecha) VALUES('".$id_sesion."','".$fecha_inicial."')");
	$qfecha = $db->sql_query("SELECT SUBDATE('".$fecha_final."', INTERVAL ".$duracion." minute) as fecha");
	$quryF = $db->sql_fetchrow($qfecha);
	$fecha_final = $quryF["fecha"];

	while($fecha_inicial < $fecha_final )
	{
		$qidS = $db->sql_query("SELECT DATE_ADD('".$fecha_inicial."', INTERVAL ".$duracion." minute) as fecha");
		$queryF =  $db->sql_fetchrow($qidS);
		$fecha_inicial = $queryF["fecha"];
		$db->sql_query("INSERT INTO fechas_sesiones (id_sesion,fecha) VALUES('".$id_sesion."','".$fecha_inicial."')");			
	}
}


?>
