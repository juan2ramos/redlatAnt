<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	
	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name","generos_grupo_danza");
	$entidad->set("labelModule","Géneros del Grupo");
	$entidad->set("table","generos_grupo_danza");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	
	
// ---------- ATRIBUTOS          ----------------
	
	
	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupos_danza");
	$atributo->set("label","Grupo");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 7)
	{
		$atributo->set("inputType","arraySelect");
		$qid=$db->sql_query("SELECT g.id,g.nombre
				FROM grupos_danza g 
				LEFT JOIN usuarios_grupos_danza ug ON ug.id_grupo_danza = g.id
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
		$atributo->set("foreignTable","grupos_danza");
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
	$atributo->set("field","id_generos_danza");
	$atributo->set("label","Género");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","generos_danza");
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
