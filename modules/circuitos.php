<?
//	require($CFG->common_libdir . "/entidades_v_1.4/object.php");
	require($CFG->objectPath . "/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Eventos");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);
	
	$entidad->set("JSComplementaryRevision","");

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","Áreas relacionadas");
	$link->set("description","Áreas relacionadas");
	$link->set("field","id_circuito");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","circ_circuitos_areas");
	$link->set("relatedICTable","pr_areas");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_circuito");
	$link->set("relatedICIdFieldDos","id_area");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","archivos");
	$link->set("url",$ME . "?module=circ_archivos");
	$link->set("icon","doc.gif");
	$link->set("description","Archivos adjuntos");
	$link->set("field","id_circuito");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_tipo");
	$atributo->set("label","Tipo");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","circ_tipos");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre del circuito");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","inicio");
	$atributo->set("label","Fecha inicio");
	$atributo->set("sqlType","date");
	$atributo->set("inputType","date");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fin");
	$atributo->set("label","Fecha de cierre");
	$atributo->set("sqlType","date");
	$atributo->set("inputType","date");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","descripcion");
	$atributo->set("label","Descripción");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
//	$atributo->set("inputRows",2);
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_descripcion");
	$atributo->set("label","Descripción (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
//	$atributo->set("inputRows",2);
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","link");
	$atributo->set("label","Link");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","pais");
	$atributo->set("label","País");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ciudad");
	$atributo->set("label","Ciudad");
	$atributo->set("sqlType","varchar(254)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","imagen");
	$atributo->set("label","Imagen");
	$atributo->set("sqlType","longtext");
	$atributo->set("inputType","image");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","circulart");
	$atributo->set("label","¿Circulart?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","0");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","bandera");
	$atributo->set("label","¿Va en la bandera?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","1");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure(FALSE);

?>
