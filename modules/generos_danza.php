<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");

	class generos_danza extends entity
	{
		function delete()
		{
			$qid = $this->db->sql_query("SELECT count(*) as num FROM generos_grupo_danza WHERE id_generos_danza=".$this->id);
			$query = $this->db->sql_fetchrow($qid);
			if($query["num"] != 0)
				$this->avisoError("El género está relacionado con artistas de danza.<br>NO SE PUEDE BORRAR.");

			parent::delete();
		}
	
		function avisoError($aviso)
		{
			global $CFG;

			echo "<center>".$aviso."<br><br></center>";
			echo "<center><input type='button' value='Cerrar' OnClick='javascript=window.close()'></center>";
			include($CFG->templatedir."/resize_window.php");
			die();
		}

	
	}



	$entidad =& new generos_danza();
	$entidad->set("db",$db);

	$entidad->set("name","generos_danza");
	$entidad->set("labelModule","Géneros - Danza");
	$entidad->set("table","generos_danza");
	$entidad->set("orderBy","genero");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","genero");
	$atributo->set("label","Área");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_genero");
	$atributo->set("label","Área (inglés)");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure(FALSE);

?>

