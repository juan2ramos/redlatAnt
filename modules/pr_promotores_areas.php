<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Promotores - Áreas");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------


	$atributo=new attribute($entidad);
	$atributo->set("field","id_promotor");
	$atributo->set("label","Promotor");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","promotores");
	$atributo->set("foreignLabelFields","CONCAT(promotores.apellido, ', ', promotores.nombre)");
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
