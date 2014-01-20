<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Mercados");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","fecha_inicio");
	$entidad->set("orderByMode","DESC");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","ruedas");
	$link->set("url",$ME . "?module=ruedas");
	$link->set("iconoLetra","R");
	$link->set("description","Ruedas de negocio");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("relatedTable",$link->get("name"));
	
//	$link->set("popup",TRUE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","mercado_promotores");
	$link->set("url",$ME . "?module=mercado_promotores");
	$link->set("iconoLetra","MP");
	$link->set("description","Promotores");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable",$link->get("name"));
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","mercado_artistas");
	$link->set("url",$ME . "?module=mercado_artistas");
	$link->set("iconoLetra","MA");
	$link->set("description","Artistas");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable",$link->get("name"));
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","citas_mesa");
	$link->set("url","reportes.php?reporte=2");
	$link->set("iconoLetra","CM");
	$link->set("description","Citas X Mesa");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","citas_sesion");
	$link->set("url","reportes.php?reporte=3");
	$link->set("iconoLetra","CS");
	$link->set("description","Citas X Sesión");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","reporte1");
	$link->set("url","reportes_personalizados.php?reporte=1");
	$link->set("iconoLetra","R1");
	$link->set("description","Reporte #1");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("showInEdit",FALSE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","reporte2");
	$link->set("url","reportes_personalizados.php?reporte=2");
	$link->set("iconoLetra","R2");
	$link->set("description","Reporte #2");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("showInEdit",FALSE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","reporte3");
	$link->set("url","reportes_personalizados.php?reporte=3");
	$link->set("iconoLetra","R3");
	$link->set("description","Reporte #3");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("showInEdit",FALSE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","reporte4");
	$link->set("url","reportes_personalizados.php?reporte=4&header=0");
	$link->set("iconoLetra","R4");
	$link->set("description","Reporte Citas CSV");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",FALSE);
	$link->set("showInEdit",FALSE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","reporte5");
	$link->set("url","reportes_personalizados.php?reporte=5&header=0");
	$link->set("iconoLetra","R5");
	$link->set("description","Reporte Vinculados");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",FALSE);
	$link->set("showInEdit",FALSE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","reporte6");
	$link->set("url","reportes_personalizados.php?reporte=6&header=0");
	$link->set("iconoLetra","R6");
	$link->set("description","Reporte Promotores / Mesas");
	$link->set("field","id_mercado");
	$link->set("type","iframe");
	$link->set("popup",FALSE);
	$link->set("showInEdit",FALSE);
	$entidad->addLink($link);

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre");
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("inputSize",50);
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_inicio");
	$atributo->set("label","Fecha de Inicio");
	$atributo->set("sqlType","date");
	$atributo->set("inputType","date");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_final");
	$atributo->set("label","Fecha Final");
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
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",4);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","citas");
	$atributo->set("label","Citas programadas");
	$atributo->set("sqlType","subquery");
	$atributo->set("inputType","subQuery");
	$atributo->set("subQuery","SELECT COUNT(*) FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=__id__");
	$atributo->set("browseable",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","citas_exitosas");
	$atributo->set("label","Citas exitosas");
	$atributo->set("sqlType","subquery");
	$atributo->set("inputType","subQuery");
	$atributo->set("subQuery","SELECT SUM(CASE WHEN c.aceptada_promotor='1' AND c.aceptada_grupo='1' THEN '1' ELSE '0' END) FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=__id__");
	$atributo->set("browseable",TRUE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure();

?>
