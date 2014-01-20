<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");
	if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
	else $frm=$_GET;

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Personas vinculadas al grupo");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_danza");
	$atributo->set("label","Grupo danza");
	$atributo->set("mandatory",FALSE);
	$atributo->set("sqlType","int");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_danza");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
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
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","inscripcion_confirmada");
	$atributo->set("label","¿Inscripción confirmada?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","0");
	$atributo->set("defaultValueSQL","0");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fecha");
	$atributo->set("label","Fecha");
	$atributo->set("inputType","timestamp");
	$atributo->set("sqlType","datetime");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>

