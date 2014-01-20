<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name","productores_musica");
	$entidad->set("labelModule","Productor");
	$entidad->set("table","productores_musica");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_obras_musica");
	$atributo->set("label","Nombre Producción");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
	{
		$atributo->set("inputType","arraySelect");
		$qid=$db->sql_query("SELECT o.id,o.produccion
				FROM obras_musica o
				LEFT JOIN usuarios_grupos_musica ug ON ug.id_grupo_musica = o.id_grupos_musica
				WHERE ug.id_usuario=".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
		$grupos=array();
		while($queryG=$db->sql_fetchrow($qid)){
			$grupos[$queryG["id"]]=$queryG["produccion"];
		}
		$atributo->set("arrayValues",$grupos);
	}
	else
	{
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","obras_musica");
		$atributo->set("foreignLabelFields","produccion");
	}
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","id_artista");
	$atributo->set("label","Productor");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("inputSize","50");
	$atributo->set("ACIdField","artistas.id");
	$atributo->set("ACLabel","concat(artistas.nombres, ' ', artistas.apellidos) ");
	$atributo->set("ACFields","artistas.nombres,artistas.apellidos");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
	{
		$atributo->set("ACFrom","usuarios_artistas LEFT JOIN artistas ON artistas.id = usuarios_artistas.id_artista");
		$atributo->set("qsQuery","SELECT artistas.id,concat_ws(' ',artistas.nombres,artistas.apellidos) as nombre
					FROM usuarios_artistas
					LEFT JOIN artistas ON artistas.id = usuarios_artistas.id_artista
					WHERE usuarios_artistas.id_usuario=".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
	}
	else
	{
		$atributo->set("ACFrom","artistas");
		$atributo->set("qsQuery","SELECT artistas.id,concat(artistas.nombres, ' ', artistas.apellidos) as nombre FROM artistas");
	}
	$atributo->set("inputType","autocomplete");
	$atributo->set("mandatory",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("visible",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure();

?>

