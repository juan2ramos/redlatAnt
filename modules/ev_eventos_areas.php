<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Eventos - Áreas");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------


	$atributo=new attribute($entidad);
	$atributo->set("field","id_evento");
	$atributo->set("label","Evento");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","eventos");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_area");
	$atributo->set("label","Área");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","pr_areas");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>
