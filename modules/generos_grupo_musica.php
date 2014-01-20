<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	
	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name","generos_grupo_musica");
	$entidad->set("labelModule","Géneros del Grupo");
	$entidad->set("table","generos_grupo_musica");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	
	
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


	$entidad->checkSqlStructure();

?>
