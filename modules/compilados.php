<?
	//require($CFG->common_libdir . "/entidades_v_1.3/object.php");
	require($CFG->objectPath . "/object.php");
	
	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name","compilados");
	$entidad->set("labelModule","Compilados");
	$entidad->set("table","compilados");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","tracklist");
	$link->set("url",$ME . "?module=compiladostracklist");
	$link->set("icon","picture.gif");
	$link->set("description","Archivos de Música");
	$link->set("field","id_compilado");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","tracklist");
	$entidad->addLink($link);

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","compilado");
	$atributo->set("label","Nombre del compilado");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","anio");
	$atributo->set("label","Año");
	$atributo->set("sqlType","varchar(16)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","resena");
	$atributo->set("label","Reseña");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",10);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_resena");
	$atributo->set("label","Reseña (Inglés)");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",50);
	$atributo->set("inputRows",10);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure(FALSE);

?>
