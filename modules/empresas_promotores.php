<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Promotores");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_empresa");
	$atributo->set("label","Organización");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","empresas");
	$atributo->set("foreignLabelFields","empresas.empresa");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_promotor");
	$atributo->set("label","Promotor");
	$atributo->set("inputType","querySelect");
	$atributo->set("qsQuery"," SELECT id, CONCAT( nombre,' ',apellido,' ',convert(case when vigente then '<strong>(Vigente)</strong>' else '(No Vigente)' END USING latin1)) as nombre
		FROM promotores
		ORDER BY vigente DESC, nombre,apellido");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure();

?>
