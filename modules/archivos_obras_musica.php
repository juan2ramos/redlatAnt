<?
//	require($CFG->common_libdir . "/entidades_v_1.3/object.php");
	require($CFG->objectPath . "/object.php");

class archivos_obras_musica extends entity
{

	function insert()
	{
		global $CFG;

		//$tipo = $this->getAttributeByName("tipo")->get("value");
		$tipo = $this->getAttributeByName("tipo");
		$tipo = $tipo->get("value");

		if($_FILES["archivo"]["size"] != 0 && $tipo==1)
		{
			//comprobar tipos
			if(!in_array($_FILES["archivo"]["type"],$CFG->tiposAdmitidosImagen))
				$this->avisoError("El tipo de la imagen está en un formato no permitido.  El registro no se insertó.");

			//dejar el campo de url vacío
			//$this->getAttributeByName("url")->set("value",NULL);
			$url = $this->getAttributeByName("url");
			$url = $url->set("value",NULL);
			$this->id = parent::insert();
		}
		elseif($tipo==3)
		{
			$url = $this->getAttributeByName("url");
			$url = $url->get("value");
			//if(preg_match("/youtube/",$url,$matches))
			//{
				//$this->getAttributeByName("archivo")->set("value",NULL);
				$arch = $this->getAttributeByName("archivo");
				$arch = $arch->set("value",NULL);
				//$this->getAttributeByName("mmdd_archivo_filename")->set("value",NULL);
				$valorDN = $this->getAttributeByName("mmdd_archivo_filename");
				$valorDN = $valorDN->set("value",NULL);
				//$this->getAttributeByName("mmdd_archivo_filetype")->set("value",NULL);
				$valorFY = $this->getAttributeByName("mmdd_archivo_filetype");
				$valorFY = $valorFY->set("value",NULL);
				//$this->getAttributeByName("mmdd_archivo_filename")->set("value",NULL);
				$valorFN = $this->getAttributeByName("mmdd_archivo_filename");
				$valorFN = $valorFN->set("value",NULL);
				parent::insert();
			//}
			//else
				//$this->avisoError("El Embed no es de YouTube. No se ha insertado el registro.");
		}
	}

	function delete()
	{
		global $CFG;

		//$tipo = $this->getAttributeByName("tipo")->get("value");
		$tipo = $this->getAttributeByName("tipo");
		$tipo = $tipo->get("value");
		if($tipo == 2)
		{
			$idOM = $this->getAttributeByName("id_obras_musica");
			$idOM = $idOM->get("value");
			$qidG = $this->db->sql_query("SELECT id_grupos_musica FROM obras_musica WHERE id =".$idOM);
			$id_grupo = $this->db->sql_fetchrow($qidG);
			$carpeta = "/musica/audio/".$id_grupo["id_grupos_musica"]."/obras/";
			$comando = "/bin/rm -fr ".$CFG->dirroot.$carpeta.$this->id;
			echo system($comando);
		}
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

	$entidad =& new archivos_obras_musica();
	$entidad->set("db",$db);

	$entidad->set("name","archivos_obras_musica");
	$entidad->set("labelModule","Archivos de Imagen y Video de la Producción");
	$entidad->set("table","archivos_obras_musica");

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
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","tipo");
	$atributo->set("label","Tipo Archivo");
	$atributo->set("sqlType","smallint(6)");
	if(isset($_GET["mode"]) && ($_GET["mode"]=="editar" || $_GET["mode"]=="agregar"))
	{
		$tipos = array();
		$existe = array("1"=>false,"2"=>false,"3"=>false);
		$qidNT = $entidad->db->sql_query("SELECT count(*) as num,tipo FROM archivos_obras_musica WHERE id_obras_musica=".$_GET["id_obras_musica"] ." GROUP BY orden");
		while($numeroT = $entidad->db->sql_fetchrow($qidNT))
		{
			$existe[$numeroT["tipo"]]=true;
			if($numeroT["tipo"]==1  && $numeroT["num"]<5)
				$tipos[1] = "Imagen";
			elseif($numeroT["tipo"]==3 && $numeroT["num"]<5)
				$tipos[3] = "Video (Embed YouTube)";
		}

		if(!$existe[1])
			$tipos[1] = "Imagen";
		if(!$existe[3])
			$tipos[3] = "Video (Embed YouTube)";

		if($_GET["mode"]=="editar")
		{
			$qidNT = $entidad->db->sql_query("SELECT tipo FROM archivos_obras_musica WHERE id = ".$_GET["id"]);
			$queryNT = $entidad->db->sql_fetchrow($qidNT);
			if(!isset($tipos[$queryNT["tipo"]]))
			{
				if($queryNT["tipo"] == 1)
					$tipos[1] = "Imagen";
				else
					$tipos[3] = "Video (Embed YouTube)";
			}
		}
	}
	else
		$tipos = array("1"=>"Imagen","3"=>"Video (.flv)");


	$atributo->set("arrayValues",$tipos);
	$atributo->set("mandatory",TRUE);
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
	$atributo->set("label","Archivo (tipo Imagen o Audio)");
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

	$atributo=new attribute($entidad);
	$atributo->set("field","descripcion");
	$atributo->set("label","Descripci&#243;n (tipo Video)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",3);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_descripcion");
	$atributo->set("label","Descripci&#243;n (tipo Video) (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",3);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","url");
	$atributo->set("label","Url YouTube (tipo Video)");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	if(isset($_GET["mode"]) && $_GET["mode"] == "consultar")
	$atributo->set("visible",FALSE);
	if(isset($_GET["mode"]) && $_GET["mode"]=="editar")
		$atributo->set("editable",FALSE);
	if(isset($_POST["mode"]) && $_POST["mode"]=="update")
	  $atributo->set("editable",FALSE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure(FALSE);

?>
