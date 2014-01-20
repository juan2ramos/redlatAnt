<?echo $javascript_entidad?>
<script type="text/javascript">
	function abrirVentanaNueva(url,name,width,height){
		izq=(screen.width-width)/2;
		arriba=(screen.height-height)/2;
		return window.open(url,name,'scrollbars=yes,width=' + width +',height=' + height +',resizable=yes,left='+izq+',top='+arriba);
	}
	
	function agregar(module) {
		document.entryform.mode.value='agregar';
		string='ventana_' + module;
		eval(string + "=abrirVentanaNueva('<?=$ME?>?module=" + module + "&mode=agregar','ventana_" + module + "',700,500)");
		eval(string + ".focus()");
		return;
	}

	function newWindow(url,name,width,height) {
		string='ventana_' + name;
		eval(string + "=abrirVentanaNueva(url,'ventana_" + name + "'," + width + "," + height + ")");
		eval(string + ".focus()");
		return;
	}

	function evaluar_accion(mode,id,field){
		verify=window.confirm("Para Georreferenciar la dirección haga click en Aceptar.\n Si desea mantener los datos actuales haga click en Cancelar.");
		eval("var valor=document.entryform."+field+".value");
		if(verify){
			newWindow('modules/map.phtml?type='+mode+'&map_type=georref&id='+id+'&again=&direccion=' + escape(valor),'georref','600','400');	
		}
		else{
			newWindow('modules/map.phtml?type='+mode+'&map_type=georref&id='+id+'&direccion=' + escape(valor),'georref','600','400');
		}
	}

	function preview()
	{
		document.entryform.mode.value='preview';
		string='ventana_pdf';
		<?
			$campo = $entidad->get("primaryKey");
			$temp = $entidad->getAttributeByName($campo);
			$temp = $temp->get("value");
		?>
		eval(string + "=abrirVentanaNueva('<?=$CFG->wwwroot?>/admin/facturas.php?mode=preview&id=<?=$temp?>','ventana_pdf',700,500)");
		eval(string + ".focus()");
		return;
	}


</script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" class="textobco10">
  <tr>
    <td bgcolor="<?=$entidad->get("lightBgColor")?>"><table width="100%"  border="0" cellpadding="0" cellspacing="5" class="textobco10">
      <tr>
        <td>
					<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="textobco10">
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
          <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="textobco10">
          <tr bgcolor="#bfbfac">
                <td align="left">
									<span class="style2">DATOS <?=strtoupper($entidad->get("labelModule"))?> : </span>
								</td>
            </tr>
<?if(isset($frm["mensajeDeError"]) && $frm["mensajeDeError"]!=""){?>
          <tr bgcolor="#bfbfac">
	          <td align="left">
							<span class="style2"><?=$frm["mensajeDeError"]?></span>
						</td>
          </tr>
<?}?>
        </table>
					<form name="entryform" action="<?=$ME?>" method="POST" enctype="multipart/form-data" onSubmit="return revisar()">
					<?
						$pk=$entidad->getAttributeByName($entidad->get("primaryKey"));
					?>
						<input type="hidden" name="module" value="<?=$entidad->get("name");?>">
						<input type="hidden" name="mode" value="<?=$entidad->get("newMode");?>">
						<input type="hidden" name="<?=$entidad->get("primaryKey")?>" value="<?=$pk->get("value");?>">
						<br>        
            <table width="100%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" class="textobco10">
<!--	********************************************	-->
<? echo $string_entidad;?>
<!--	********************************************	-->
<?
if($entidad->get("newMode") == "consultar" || $entidad->get("mode") == "editar")
{
	if($entidad->get("name")=="archivos_grupos_danza" || $entidad->get("name")=="archivos_grupos_musica" || $entidad->get("name")=="archivos_grupos_teatro" || $entidad->get("name")=="archivos_obras_musica" || $entidad->get("name")=="archivos_obras_teatro" || $entidad->get("name")=="archivos_obras_danza" || $entidad->get("name")=="tracklist")
	{
		if($entidad->get("name")=="archivos_obras_danza" || $entidad->get("name")=="archivos_grupos_danza")
			$carpeta = "danza";
		elseif($entidad->get("name")=="archivos_obras_musica" || $entidad->get("name")=="archivos_grupos_musica" || $entidad->get("name")=="tracklist")
			$carpeta = "musica";
		else
			$carpeta = "teatro";

		$campo = "id_obras_".$carpeta;
		$campo_grupo = "id_grupos_".$carpeta;
		$tabla_grupo = "obras_".$carpeta;
		$carpeta = "/".$carpeta;

//		echo "SELECT id,tipo,mmdd_archivo_filename FROM ".$entidad->get("name")." WHERE id=".$entidad->id;
		if($entidad->get("name") == "tracklist")
			$qidBase = $entidad->db->sql_query("SELECT id,mmdd_archivo_filename FROM ".$entidad->get("name")." WHERE id=".$entidad->id);
		else $qidBase = $entidad->db->sql_query("SELECT id,tipo,mmdd_archivo_filename FROM ".$entidad->get("name")." WHERE id=".$entidad->id);
		$base = $entidad->db->sql_fetchrow($qidBase);
//		print_r($base);

		if($entidad->get("name") == "tracklist")
			$base["tipo"]=2;

		if($base["tipo"] == 2)
		{
			if($entidad->get("name")=="archivos_grupos_danza" || $entidad->get("name")=="archivos_grupos_musica" || $entidad->get("name")=="archivos_grupos_teatro")
				$carpeta .= "/audio/".$entidad->$campo_grupo."/grupo/".$entidad->id."/".urlencode($entidad->mmdd_archivo_filename);
			else
			{
				$qidGr = $entidad->db->sql_query("SELECT ".$campo_grupo." as id_grupo FROM ".$tabla_grupo." WHERE id=".$entidad->$campo);
				$idGrupo = $entidad->db->sql_fetchrow($qidGr);
				$idGrupo = $idGrupo["id_grupo"] ;
				$carpeta .= "/audio/".$idGrupo."/obras/".$entidad->id."/".urlencode($entidad->mmdd_archivo_filename);
			}
		}

		if($base["tipo"] == 2 || $base["tipo"] ==1)
		 $titulo = "Archivo"	;
		else
			$titulo = "Video YouTube";
		echo "<tr bgcolor='#ffffff'><td align='right' bgcolor='#ffffff' nowrap>ddd".$titulo." : </td>
			<td bgcolor='#ffffff' nowrap>";
		if($base["tipo"] == 3)
			echo $entidad->url;
		elseif($base["tipo"] == 2)
		{
			?>
			<script language="JavaScript" src="<?=$CFG->dirwww?>/audio_base/audio-player.js"></script>
			<object type="application/x-shockwave-flash" data="<?=$CFG->dirwww?>/audio_base/player.swf" id="audioplayer<?=$entidad->id?>" height="24" width="290">
			<param name="movie" value="<?=$CFG->dirwww?>/audio_base/player.swf">
			<param name="FlashVars" value="playerID=<?=$entidad->id?>&amp;soundFile=<?=$CFG->dirwww.$carpeta?>">
			<param name="quality" value="high">
			<param name="menu" value="false">
			<param name="wmode" value="transparent">
			</object>
<?
		}
		elseif($base["tipo"] == 1)
		{
			//$imagen = $CFG->tmpdir."/".$base["id"]."_redlat_".$base["mmdd_archivo_filename"];
			$carpeta=preg_replace("/^\//","",$carpeta);
			$imagen = $CFG->tmpdir."/".$base["id"]."_".$carpeta."_a_".$base["mmdd_archivo_filename"];
			if(!file_exists($imagen))
			  moverImagenToArchivo ($imagen,$entidad->get("name"),"archivo",$base["id"]);
			$tamanio = getimagesize($imagen);
			if($tamanio[0] > 250)
				$w = "&w=250";
			else
				$w = "";

			echo "<img src=\"".$CFG->wwwroot."/phpThumb/phpThumb.php?src=".$imagen.$w."\" border=0>";
		}

		echo "</td></tr>";
	}

}


?>



						</table>
<!--	********************************************	-->
<?
if($entidad->get("newMode")!="insert"){
for($i=0;$i<sizeof($entidad->relationships);$i++){
	$relation=$entidad->getRelationshipByIndex($i);
?>
<!--	********************************************	-->
        <br>
        <table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#FFFFFF" class="textobco10">
          <tr bgcolor="#728A8C">
                <td align="left" bgcolor="#728A8C"><span class="style2"><?=$relation->get("label");?>:</span></td>
          </tr>
        </table>
        <br>
        <table width="100%"  border="0" cellpadding="0" cellspacing="1" bgcolor="#999999" class="textobco10">
              <tr bgcolor="#728A8C"> 
                <td bgcolor="#728A8C">
									<iframe src="relation.php?name=<?=$relation->get("name")?>&masterTable=<?=$entidad->get("name")?>&masterFieldValue=<?=$relation->get("masterFieldValue")?>" frameborder="1" width="100%" height="200" scrolling="auto" name="postit_iframe"></iframe>
								</td>
              </tr>
				</table>
<!--	********************************************	-->
<?
}
}
?>
<!--	********************************************	-->

            <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="textobco10">
              <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td colspan="2">
									<table width="100%" border="0" cellspacing="0" cellpadding="3">
                    <tr>
                      <td>
											<?if($entidad->get("newMode")!="consultar"){
													if($iframe==0){?>
														<input type="Submit" style="font-size:8pt" value="Aceptar" id="Aceptar">
											 <?}else{
												 		if($entidad->get("newMode")=="insert"){?>
													 		<input type="hidden" name="iframes" value="yes">
															<input type="Submit" style="font-size:8pt" value="Siguiente">
													 <?}else{?>
														 <input type="Submit" style="font-size:8pt" value="Aceptar" id="Aceptar">
													 <?}?>
											 <?}?>
											<?}?>	
												<input type="button" style="font-size:8pt" value="Cancelar" onClick="window.opener.focus();window.close();">
											<?if($entidad->get("name") == "facturas"){?>
												<input type="button" style="font-size:8pt" value="Preview" onClick="preview();">
											<?}?>
											</td>
                    </tr>
                  </table>
								</td>
              </tr>
            </table>
					</form>
				</td>
      </tr>
    </table></td>
  </tr>
</table>
<?
include($CFG->templatedir . "/resize_window.php");
?>
</body>
</html>

