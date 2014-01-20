<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

class tracklist extends entity
{

	function insert()
	{
		global $CFG;

		if($_FILES["archivo"]["size"] != 0)
		{
			//comprobar tipos
			if(!in_array($_FILES["archivo"]["type"],$CFG->tiposAdmitidosAudio))
				$this->avisoError("El tipo del archivo de música no está en un formato permitido.  El registro no se insertó.");

			$carpeta = "/musica/audio/";
			$idOM = $this->getAttributeByName("id_obras_musica");
			$idOM = $idOM->get("value");
			$qidG = $this->db->sql_query("SELECT id_grupos_musica FROM obras_musica WHERE id =".$idOM);
			$id_grupo = $this->db->sql_fetchrow($qidG);
			$carpeta .= $id_grupo["id_grupos_musica"]."/obras/";
			if(!file_exists($CFG->dirroot.$carpeta))
			{
				$comando = "/bin/mkdir -p ".$CFG->dirroot.$carpeta;
				echo system($comando);
				$comando = "/bin/chmod -R 777 ".$CFG->dirroot.$carpeta;
				echo system($comando);
			}
			//$this->getAttributeByName("archivo")->set("value",NULL);
			$arch = $this->getAttributeByName("archivo");
			$arch = $arch->set("value",NULL);

			$this->id = parent::insert();
			$dir = $CFG->dirroot.$carpeta.$this->id;
			mkdir($dir);
			chmod($dir,0777);
			move_uploaded_file($_FILES["archivo"]["tmp_name"],$dir."/".$_FILES["archivo"]["name"]);
		}

	}

	function delete()
	{
		global $CFG;

		$carpeta = "/musica/audio/";
		$idOM = $this->getAttributeByName("id_obras_musica");
		$idOM = $idOM->get("value");
		$qidG = $this->db->sql_query("SELECT id_grupos_musica FROM obras_musica WHERE id =".$idOM);
		$id_grupo = $this->db->sql_fetchrow($qidG);
		$carpeta .= $id_grupo["id_grupos_musica"]."/obras/";
		$comando = "/bin/rm -fr ".$CFG->dirroot.$carpeta.$this->id;
		echo system($comando);
		parent::delete();	
	}

	function avisoError($aviso)
	{
		global $CFG;

		echo "<center>".$aviso."<br><br></center>";
		echo "<center><input type='button' value='Cerrar' OnClick='javascript=window.close()'></center>";
		include($CFG->templatedir."/resize_window.php");
		die();
	}

}

	$entidad =& new tracklist();
	$entidad->set("db",$db);

	$entidad->set("name","tracklist");
	$entidad->set("labelModule","Archivos de Música - Tracklist");
	$entidad->set("table","tracklist");
	$entidad->set("orderBy","orden");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_obras_musica");
	$atributo->set("label","Obra");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
	{
		$atributo->set("inputType","arraySelect");
		$qid=$db->sql_query("SELECT o.id,o.produccion
				FROM obras_musica o
				LEFT JOIN usuarios_grupos_musica ug ON ug.id_grupo_musica = o.id_grupos_musica
				WHERE ug.id_usuario=".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
		$grupos=array();
		while($queryG=$db->sql_fetchrow($qid)){
			$grupos[$queryG["id"]]=$queryG["produccion"];
		}
		$atributo->set("arrayValues",$grupos);
	}
	else
	{
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","obras_musica");
		$atributo->set("foreignLabelFields","produccion");
	}
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

?>
