<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Reportes");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","numero");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","numero");
	$atributo->set("label","Número del reporte");
	$atributo->set("inputSize",10);
	$atributo->set("sqlType","character varying(16)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);	

	$atributo=new attribute($entidad);
	$atributo->set("field","titulo");
	$atributo->set("label","Título del reporte");
	$atributo->set("inputSize",50);
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);	

	$entidad->checkSqlStructure();

?>
