<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Excepciones Horarios");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","desde");
	$atributo->set("label","Fecha y hora inicial");
	$atributo->set("sqlType","datetime");
	$atributo->set("inputType","timestamp");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_promotor");
	$atributo->set("label","Promotor");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","promotores");
	$atributo->set("foreignLabelFields","CONCAT(promotores.apellido, ', ', promotores.nombre)");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_musica");
	$atributo->set("label","Grupo musical");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_musica");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_danza");
	$atributo->set("label","Grupo de danza");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_danza");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_teatro");
	$atributo->set("label","Grupo de teatro");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_teatro");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>
