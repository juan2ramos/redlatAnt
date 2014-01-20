<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	class tarea extends entity
	{
		function delete()
		{
			$qid = $this->db->sql_query("SELECT count(*) as num FROM pr_promotores_tareas WHERE id_tarea=".$this->id);
			$query = $this->db->sql_fetchrow($qid);
			if($query["num"] != 0)
				$this->avisoError("El promotor está relacionado con esta tarea.<br>NO SE PUEDE BORRAR.");

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

	$entidad =& new tarea();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Tareas");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","nombre");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre de la tarea");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>
