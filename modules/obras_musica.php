<?
	//require($CFG->common_libdir . "/entidades_v_1.3/object.php");
	require($CFG->objectPath . "/object.php");
	
	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name","obras_musica");
	$entidad->set("labelModule","Producciones");
	$entidad->set("table","obras_musica");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","artistas_musicos");
	$link->set("url",$ME . "?module=artistas_musicos");
	$link->set("icon","boy.gif");
	$link->set("description","Músicos");
	$link->set("field","id_obras_musica");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","artistas_musicos");
	$entidad->addLink($link);
	
	$link=new link($entidad);
	$link->set("name","productores_musica");
	$link->set("url",$ME . "?module=productores_musica");
	$link->set("icon","kgpg_identity.png");
	$link->set("description","Productor");
	$link->set("field","id_obras_musica");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","productores_musica");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","archivos_obras_musica");
	$link->set("url",$ME . "?module=archivos_obras_musica");
	$link->set("icon","foto.jpeg");
	$link->set("description","Archivos");
	$link->set("field","id_obras_musica");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","archivos_obras_musica");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","tracklist");
	$link->set("url",$ME . "?module=tracklist");
	$link->set("icon","spaceball.gif");
	$link->set("description","Archivos de Música");
	$link->set("field","id_obras_musica");
	$link->set("type","iframe");
	$link->set("popup","TRUE");
	$link->set("relatedTable","tracklist");
	$entidad->addLink($link);

// ---------- ATRIBUTOS          ----------------
	
	
	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupos_musica");
	$atributo->set("label","Grupo");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
	{
		$atributo->set("inputType","arraySelect");
		$qid=$db->sql_query("SELECT g.id,g.nombre
				FROM grupos_musica g
				LEFT JOIN usuarios_grupos_musica ug ON ug.id_grupo_musica = g.id
				WHERE ug.id_usuario=".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
		$grupos=array();
		while($queryG=$db->sql_fetchrow($qid)){
			$grupos[$queryG["id"]]=$queryG["nombre"];
		}
		$atributo->set("arrayValues",$grupos);
	}
	else
	{
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","grupos_musica");
		$atributo->set("foreignLabelFields","nombre");
	}
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","id_generos_musica");
	$atributo->set("label","Género");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","generos_musica");
	$atributo->set("foreignLabelFields","genero");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","produccion");
	$atributo->set("label","Nombre Producción");
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
	$atributo->set("field","num_viajantes");
	$atributo->set("label","¿Cuántas personas viajan con la producción?");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("inputSize",10);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
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
	$atributo->set("browseable",FALSE);
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
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","sello_disquero");
	$atributo->set("label","Sello disquero");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure(FALSE);

?>
