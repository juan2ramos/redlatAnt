<?
	require($CFG->common_libdir . "/entidades_v_1.5/object.php");
	if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
	else $frm=$_GET;

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Curadores - Grupos");
	$entidad->set("table",$entidad->get("name"));
    $entidad->set("orderBy","id_grupo_musica ASC");
	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_curador");
	$atributo->set("label","Curador");
	$atributo->set("mandatory",TRUE);
	$atributo->set("sqlType","int");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","curadores");
	$atributo->set("foreignTableAlias","cur");
	$atributo->set("foreignLabelFields","CONCAT(cur.nombre, ' ', cur.apellido)");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_danza");
	$atributo->set("label","Grupo danza");
	$atributo->set("mandatory",FALSE);
	$atributo->set("sqlType","int");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_danza");
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_musica");
	$atributo->set("label","Grupo música");
	$atributo->set("mandatory",FALSE);
	$atributo->set("sqlType","int");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_musica");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_teatro");
	$atributo->set("label","Grupo teatro");
	$atributo->set("mandatory",FALSE);
	$atributo->set("sqlType","int");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_teatro");
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","cumple_requisitos");
	$atributo->set("label","¿Cumple todos los requisitos?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","option");
	$atributo->set("arrayOptions",array("1"=>"Sí","2"=>"No"));
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios");
	$atributo->set("label","Comentarios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

/*	**	*/	
/*	**	*/	
	$atributo=new attribute($entidad);
	$atributo->set("field","trayectoria");
	$atributo->set("label","¿Cómo evalúa la trayectoria de este grupo?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","option");
	$atributo->set("arrayOptions",array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"));
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios_trayectoria");
	$atributo->set("label","Comentarios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","calidad");
	$atributo->set("label","¿Cómo evalúa la calidad de este grupo?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","option");
	$atributo->set("arrayOptions",array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"));
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios_calidad");
	$atributo->set("label","Comentarios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","solidez");
	$atributo->set("label","¿Cómo evalúa la solidez de la propuesta de este grupo?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","option");
	$atributo->set("arrayOptions",array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5"));
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios_solidez");
	$atributo->set("label","Comentarios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
/*	**	*/	
/*	**	*/	


/*	**	*/	
	$atributo=new attribute($entidad);
	$atributo->set("field","permitiria_asistencia");
	$atributo->set("label","¿Cree que esta agrupación debería presentarse en las Muestras Artísticas?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","option");
	$atributo->set("arrayOptions",array("1"=>"Sí","2"=>"No"));
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios_asistencia");
	$atributo->set("label","Comentarios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);
/*	**	*/	


	$atributo=new attribute($entidad);
	$atributo->set("field","fecha");
	$atributo->set("label","Fecha");
	$atributo->set("sqlType","datetime");
	$atributo->set("mandatory",FALSE);
	$atributo->set("readonly",TRUE);
	$atributo->set("defaultValue",date("Y-m-d H:i:s"));
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>

