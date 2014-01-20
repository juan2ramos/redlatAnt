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
	
// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","Áreas relacionadas");
	$link->set("description","Áreas relacionadas");
	$link->set("field","id_evento");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","ev_eventos_areas");
	$link->set("relatedICTable","pr_areas");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_evento");
	$link->set("relatedICIdFieldDos","id_area");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","ev_grupos");
	$link->set("url",$ME . "?module=ev_grupos");
	$link->set("iconoLetra","G");
	$link->set("description","Grupos para este evento");
	$link->set("field","id_evento");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable","ev_grupos");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","ev_horarios");
	$link->set("url",$ME . "?module=ev_horarios");
	$link->set("iconoLetra","H");
	$link->set("description","Horarios para este evento");
	$link->set("field","id_evento");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable","ev_horarios");
	$entidad->addLink($link);

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_tipo");
	$atributo->set("label","Tipo");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","ev_tipos");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre del evento");
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
	$atributo->set("field","fin");
	$atributo->set("label","Fecha y hora final");
	$atributo->set("sqlType","datetime");
	$atributo->set("inputType","timestamp");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_mercado");
	$atributo->set("label","Mercado");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","mercados");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ubicacion");
	$atributo->set("label","Ubicación");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","direccion");
	$atributo->set("label","Dirección");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ciudad");
	$atributo->set("label","Ciudad");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",TRUE);
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
	$atributo->set("field","telefonos");
	$atributo->set("label","Teléfonos");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
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
	$atributo->set("field","precios");
	$atributo->set("label","Precios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("mandatory",FALSE);
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

	$entidad->checkSqlStructure(FALSE);

?>
