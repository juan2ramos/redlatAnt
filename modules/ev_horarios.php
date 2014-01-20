<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Horarios del evento");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","inicio,fin");

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
	$atributo->set("inputSize",5);
	$atributo->set("field","desde");
	$atributo->set("label","Desde las");
	$atributo->set("sqlType","character varying(5)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$atributo->set("JSRegExp","/^([01][0-9]|2[0-3]):[0-5][0-9]$/");
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputSize",5);
	$atributo->set("field","hasta");
	$atributo->set("label","Hasta las");
	$atributo->set("sqlType","character varying(5)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$atributo->set("JSRegExp","/^([01][0-9]|2[0-3]):[0-5][0-9]$/");
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","checkbox");
	$atributo->set("field","lunes");
	$atributo->set("label","Lunes");
	$atributo->set("sqlType","boolean");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","checkbox");
	$atributo->set("field","martes");
	$atributo->set("label","Martes");
	$atributo->set("sqlType","boolean");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","checkbox");
	$atributo->set("field","miercoles");
	$atributo->set("label","Miércoles");
	$atributo->set("sqlType","boolean");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","checkbox");
	$atributo->set("field","jueves");
	$atributo->set("label","Jueves");
	$atributo->set("sqlType","boolean");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","checkbox");
	$atributo->set("field","viernes");
	$atributo->set("label","Viernes");
	$atributo->set("sqlType","boolean");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","checkbox");
	$atributo->set("field","sabado");
	$atributo->set("label","Sábado");
	$atributo->set("sqlType","boolean");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","checkbox");
	$atributo->set("field","domingo");
	$atributo->set("label","Domingo");
	$atributo->set("sqlType","boolean");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>
