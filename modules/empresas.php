<?
	require_once($CFG->common_libdir . "/entidades_v_1.4/object.php");
	

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Organización");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","empresa DESC");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------
	$link=new link($entidad);
	$link->set("name","Actividad");
	$link->set("description","Actividad");
	$link->set("field","id_empresa");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","empresas_razones");
	$link->set("relatedICTable","emp_razon_social");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_empresa");
	$link->set("relatedICIdFieldDos","id_emp_razon_social");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","empresas_ventas");
	$link->set("url",$ME . "?module=empresas_ventas");
	$link->set("iconoLetra","V");
	$link->set("description","Ventas");
	$link->set("field","id_empresa");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","empresas_promotores");
	$link->set("url",$ME . "?module=empresas_promotores");
	$link->set("iconoLetra","P");
	$link->set("description","Promotores");
	$link->set("field","id_empresa");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","empresa");
	$atributo->set("label","Organización");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	
	$atributo=new attribute($entidad);
	$atributo->set("field","id_naturaleza");
	$atributo->set("label","Naturaleza");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","emp_naturalezas");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","nit");
	$atributo->set("label","NIT");
	$atributo->set("sqlType","character varying(50)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","direccion");
	$atributo->set("label","Dirección");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","telefono");
	$atributo->set("label","Teléfono");
	$atributo->set("sqlType","character varying(30)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","telefono2");
	$atributo->set("label","Otro Teléfono");
	$atributo->set("sqlType","character varying(30)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","email");
	$atributo->set("label","E-mail");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","web");
	$atributo->set("label","Website");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","pais");
	$atributo->set("label","País");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ciudad");
	$atributo->set("label","Ciudad");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);



	$atributo=new attribute($entidad);
	$atributo->set("field","observaciones");
	$atributo->set("label","Observaciones");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>

