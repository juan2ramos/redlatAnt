<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	class archivos_grupos_danza extends entity
	{
		function insert()
		{
			global $CFG;

			//$tipo = $this->getAttributeByName("tipo")->get("value");
			$tipo = $this->getAttributeByName("tipo");
			$tipo = $tipo->get("value");

			if($_FILES["archivo"]["size"] != 0 && ($tipo==1 || $tipo==2))
			{
				//comprobar tipos
				if($tipo == 1)
				{
					if(!in_array($_FILES["archivo"]["type"],$CFG->tiposAdmitidosImagen))
						$this->avisoError("El tipo de la imagen est� en un formato no permitido.  El registro no se insert�.");
				}
				else
				{
					if(!in_array($_FILES["archivo"]["type"],$CFG->tiposAdmitidosAudio))
						$this->avisoError("El tipo del archivo de m�sica no est� en un formato permitido.  El registro no se insert�.");	
				}
					
				if($tipo == 2)
				{
					//$carpeta = "/danza/audio/".$this->getAttributeByName("id_grupos_danza")->get("value")."/grupo/";
					$idGD = $this->getAttributeByName("id_grupos_danza");
					$idGD = $idGD->get("value");
					$carpeta = "/danza/audio/".$idGD."/grupo/";
					if(!file_exists($CFG->dirroot.$carpeta))
					{
						$comando = "/bin/mkdir -p ".$CFG->dirroot.$carpeta;
						echo system($comando);
						$comando = "/bin/chmod -R 777 ".$CFG->dirroot.$carpeta;
						echo system($comando);
					}
					
					//$this->getAttributeByName("archivo")->set("value",NULL);
					$archivo = $this->getAttributeByName("archivo");
					$archivo = $archivo->set("value",NULL);
				}

				$this->id = parent::insert();
				if($tipo == 2)
				{
					$dir = $CFG->dirroot.$carpeta.$this->id;
					mkdir($dir);
					chmod($dir,0777);
					move_uploaded_file($_FILES["archivo"]["tmp_name"],$dir."/".$_FILES["archivo"]["name"]);
				}
			}
			elseif($tipo==3)
			{
				$url = $this->getAttributeByName("url");
				$url = $url->get("value");
				if(preg_match("/youtube/",$url,$matches))
				{
					parent::insert();
				}
				else
					$this->avisoError("El Embed no es de YouTube. No se ha insertado el registro.");
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
				$idGD = $this->getAttributeByName("id_grupos_danza");
				$idGD = $idGD->get("value");
				$carpeta = "/danza/audio/".$idGD."/grupo/";
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


	$entidad =& new archivos_grupos_danza();
	$entidad->set("db",$db);

	$entidad->set("name","archivos_grupos_danza");
	$entidad->set("labelModule","Archivos");
	$entidad->set("table","archivos_grupos_danza");
	$entidad->set("orderBy","orden");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	
	
// ---------- ATRIBUTOS          ----------------
	
	
	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupos_danza");
	$atributo->set("label","Grupo");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 7)
	{
		$atributo->set("inputType","arraySelect");
		$qid=$db->sql_query("SELECT g.id,g.nombre
				FROM grupos_danza g 
				LEFT JOIN usuarios_grupos_danza ug ON ug.id_grupo_danza = g.id
				WHERE ug.id_usuario=".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
		$grupos=array();
		while($queryG=$db->sql_fetchrow($qid)){
			$grupos[$queryG["id"]]=$queryG["nombre"];
		}
		$atributo->set("arrayValues",$grupos);
	}
	else
	{
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","grupos_danza");
		$atributo->set("foreignLabelFields","nombre");
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
		$qidNT = $entidad->db->sql_query("SELECT count(*) as num,tipo FROM archivos_grupos_danza WHERE id_grupos_danza=".$_GET["id_grupos_danza"] ." GROUP BY orden");
		while($numeroT = $entidad->db->sql_fetchrow($qidNT))
		{
			$existe[$numeroT["tipo"]]=true;
			if($numeroT["tipo"]==1  && $numeroT["num"]<5)
				$tipos[1] = "Imagen";
			elseif($numeroT["tipo"]==2  && $numeroT["num"]<5)
				$tipos[2] = "Audio (.mp3)";
			elseif($numeroT["tipo"]==3 && $numeroT["num"]<5)
				$tipos[3] = "Video (Embed YouTube)";
		}

		if(!$existe[1])
			$tipos[1] = "Imagen";
		if(!$existe[2])
			$tipos[2] = "Audio (.mp3)";
		if(!$existe[3])
			$tipos[3] = "Video (Embed YouTube)";

		if($_GET["mode"]=="editar")
		{
			$qidNT = $entidad->db->sql_query("SELECT tipo FROM archivos_grupos_danza WHERE id = ".$_GET["id"]);
			$queryNT = $entidad->db->sql_fetchrow($qidNT);
			if(!isset($tipos[$queryNT["tipo"]]))
			{	
				if($queryNT["tipo"] == 1)
					$tipos[1] = "Imagen";
				elseif($queryNT["tipo"] == 2)
					$tipos[2] = "Audio (.mp3)";
				else
					$tipos[3] = "Video (Embed YouTube)";
			}
		}	
	}
	else
		$tipos = array("1"=>"Imagen","2"=>"Audio (.mp3)","3"=>"Video (Embed YouTube)");

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
	$atributo->set("inputType","image");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
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
	$atributo->set("field","url");
	$atributo->set("label","Embed YouTube (tipo Video)");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
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
