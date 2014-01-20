<?
//	require($CFG->common_libdir . "/entidades_v_1.3/object.php");
	require($CFG->objectPath . "/object.php");

class obras_danza extends entity
{
	function insert()
	{
		if($_FILES["documento"]["size"] != "")
		{
			if(!in_array($_FILES["documento"]["type"],$this->CFG->tiposAdmitidosDocumentos))
			{
				//$this->getAttributeByName("documento")->set("value","");
				$valorD = $this->getAttributeByName("documento");
				$valorD = $valorD->set("value","");
				//$this->getAttributeByName("mmdd_documento_filename")->set("value",NULL);
				$valorDN = $this->getAttributeByName("mmdd_documento_filename");
				$valorDN = $valorDN->set("value",NULL);
				//$this->getAttributeByName("mmdd_documento_filetype")->set("value",NULL);
				$valorDF = $this->getAttributeByName("mmdd_documento_filetype");
				$valorDF = $valorDF->set("value",NULL);
				//$this->getAttributeByName("mmdd_documento_filesize")->set("value",NULL);
				$valorDS = $this->getAttributeByName("mmdd_documento_filesize");
				$valorDS = $valorDS->set("value",NULL);
				unset($_FILES["documento"]);
	echo "<script>window.alert('El documento no está en un formato permitido. Se aceptan formatos .pdf y .doc. No se ha insertado el documento')</script>";
			}
		}
//		preguntar($this->getAttributeByName("documento")->get("value"));
//		die;
		$this->id = parent::insert();
		return($this->id);
	}

	function update()
	{
		if($_FILES["documento"]["size"] != "")
		{
			if(!in_array($_FILES["documento"]["type"],$this->CFG->tiposAdmitidosDocumentos))
			{
				echo "<script>window.alert('El documento no está en un formato permitido. Se aceptan formatos .pdf y .doc. Se han actualizado todos los datos, menos el de documento')</script>";
				//$this->getAttributeByName("documento")->set("value",NULL);
				$valorD = $this->getAttributeByName("documento");
				$valorD = $valorD->set("value","NULL");
				//$this->getAttributeByName("mmdd_documento_filename")->set("value",NULL);
				$valorDN = $this->getAttributeByName("mmdd_documento_filename");
				$valorDN = $valorDN->set("value",NULL);
				//$this->getAttributeByName("mmdd_documento_filetype")->set("value",NULL);
				$valorDF = $this->getAttributeByName("mmdd_documento_filetype");
				$valorDF = $valorDF->set("value",NULL);
				//$this->getAttributeByName("mmdd_documento_filesize")->set("value",NULL);
				$valorDS = $this->getAttributeByName("mmdd_documento_filesize");
				$valorDS = $valorDS->set("value",NULL);
				unset($_FILES["documento"]);
			}
		}
		parent::update();
	}
	
	
}

	$entidad =& new obras_danza();
	$entidad->set("db",$db);

	$entidad->set("name","obras_danza");
	$entidad->set("labelModule","Obras");
	$entidad->set("table","obras_danza");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","artistas_danza");
	$link->set("url",$ME . "?module=artistas_danza");
	$link->set("icon","boy.gif");
	$link->set("description","Actores");
	$link->set("field","id_obras_danza");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","artistas_danza");
	$entidad->addLink($link);


	$link=new link($entidad);
	$link->set("name","directores_danza");
	$link->set("url",$ME . "?module=directores_danza");
	$link->set("icon","kgpg_identity.png");
	$link->set("description","Director");
	$link->set("field","id_obras_danza");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","directores_danza");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","archivos_obras_danza");
	$link->set("url",$ME . "?module=archivos_obras_danza");
	$link->set("icon","foto.jpeg");
	$link->set("description","Archivos");
	$link->set("field","id_obras_danza");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","archivos_obras_danza");
	$entidad->addLink($link);


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
	$atributo->set("field","id_generos_danza");
	$atributo->set("label","Género");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","generos_danza");
	$atributo->set("foreignLabelFields","genero");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","obra");
	$atributo->set("label","Obra");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","anio");
	$atributo->set("label","Año");
	$atributo->set("sqlType","varchar(16)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	
	$atributo=new attribute($entidad);
	$atributo->set("field","resena");
	$atributo->set("label","Reseña");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",10);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_resena");
	$atributo->set("label","Reseña (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",10);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","autor");
	$atributo->set("label","Autor");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","musica");
	$atributo->set("label","Música");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","duracion");
	$atributo->set("label","Duración total");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);
		
	$atributo=new attribute($entidad);
	$atributo->set("field","num_actos");
	$atributo->set("label","No. de actos");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","num_intermedios");
	$atributo->set("label","No. de intermedios");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","tipo_publico");
	$atributo->set("label","Tipo de público");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("arrayValues",array("1"=>"Adultos","2"=>"Infantil","3"=>"Familiar"));
	$atributo->set("mandatory",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","num_viajantes");
	$atributo->set("label","¿Cuántas personas viajan con la producción?");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("inputSize",10);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);



	$atributo=new attribute($entidad);
	$atributo->set("field","horas_montaje");
	$atributo->set("label","No. de horas de montaje");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","horas_desmontaje");
	$atributo->set("label","No. de horas de desmontaje");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ensayos");
	$atributo->set("label","No. de ensayos necesarios");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","responsable_carga");
	$atributo->set("label","Responsable de la carga");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_responsable_carga");
	$atributo->set("label","Responsable de la carga (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","piezas");
	$atributo->set("label","No. de piezas");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","volumen");
	$atributo->set("label","Volumen total (en m<sup>3</sup>)");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","peso");
	$atributo->set("label","Peso total (en kilos)");
	$atributo->set("sqlType","varchar(125)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","direccion_recogida");
	$atributo->set("label","Dirección de recogida");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","direccion_regreso");
	$atributo->set("label","Dirección de regreso");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","espacio");
	$atributo->set("label","Espacio escénico requerido");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_espacio");
	$atributo->set("label","Espacio escénico requerido (Inglés)");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","iluminacion");
	$atributo->set("label","Iluminación");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_iluminacion");
	$atributo->set("label","Iluminación (Inglés)");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","sonido");
	$atributo->set("label","Sonido");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_sonido");
	$atributo->set("label","Sonido (Inglés)");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","utileria");
	$atributo->set("label","Elementos de utilería<br>y/o escenográficos");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_utileria");
	$atributo->set("label","Elementos de utilería<br>y/o escenográficos (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","equipos_adicionales");
	$atributo->set("label","Equipos adicionales<br>y/o efectos especiales");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_equipos_adicionales");
	$atributo->set("label","Equipos adicionales<br>y/o efectos especiales (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios");
	$atributo->set("label","Comentarios adicionales");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_comentarios");
	$atributo->set("label","Comentarios adicionales (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",5);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","documento");
	$atributo->set("label","Documento (subir PDF)");
	$atributo->set("sqlType","longtext");
	$atributo->set("inputType","file");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure(FALSE);

?>
