<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

class tracklist extends entity
{
	
	


	function muestra(){
	        echo '<script language="JavaScript" src="http://circulart.org/audio_base/audio-player.js"></script>';
			echo '<object type="application/x-shockwave-flash" data="http://circulart.org/audio_base/player.swf" id="audioplayer2452" height="24" width="290">';
			echo '<param name="movie" value="http://circulart.org/audio_base/player.swf">';
			echo '<param name="FlashVars" value="playerID=2452&amp;soundFile=http://circulart.org/musica/audio/12/obras/2452/08+La+Ni%F1a.mp3">';
			echo '<param name="quality" value="high">';
			echo '<param name="menu" value="false">';
			echo '<param name="wmode" value="transparent">';
			echo '</object>';
		}

}

	$entidad =& new tracklist();
	$entidad->set("db",$db);

	$entidad->set("name","compiladostracklist");
	$entidad->set("labelModule","Archivos de Música - MP3");
	$entidad->set("table","compiladostracklist");
	$entidad->set("orderBy","orden");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_compilado");
	$atributo->set("label","Compilado");
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","compilados");
		$atributo->set("foreignLabelFields","compilado");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","etiqueta");
	$atributo->set("label","Etiqueta");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","orden");
	$atributo->set("label","Orden");
	$atributo->set("sqlType","integer");
	$atributo->set("defaultValue",1);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","archivo");
	$atributo->set("label","Archivo de Audio (.mp3)");
	$atributo->set("sqlType","longtext");
	$atributo->set("inputType","file");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	if(isset($_GET["mode"]) && $_GET["mode"] == "consultar")
		$atributo->set("visible",FALSE);
	if(isset($_GET["mode"]) && $_GET["mode"]=="editar")
	  $atributo->set("editable",FALSE);
	if(isset($_POST["mode"]) && $_POST["mode"]=="update")
	  $atributo->set("editable",FALSE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure();
	if(isset($_GET["mode"]) && $_GET["mode"]=="editar"){
    $entidad->muestra();}
?>
