<?
	//require($CFG->common_libdir . "/entidades_v_1.4/object.php");
	require($CFG->objectPath . "/object.php");

	class area extends entity
	{
		function delete()
		{
			$qid = $this->db->sql_query("SELECT count(*) as num FROM pr_promotores_areas WHERE id_area=".$this->id);
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

	$entidad =& new area();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Áreas");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","nombre");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre del área");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","en_nombre");
	$atributo->set("label","Nombre del área (Inglés)");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","codigo");
	$atributo->set("label","Código");
	$atributo->set("sqlType","character varying(16)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
/*
	$atributo=new attribute($entidad);
	$atributo->set("field","ubicacion");
	$atributo->set("label","Ubicación");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","0");
	$atributo->set("arrayOptions",array("Circulart","Mercado"));
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
*/
	$atributo=new attribute($entidad);
	$atributo->set("field","imagen");
	$atributo->set("label","Imagen home");
	$atributo->set("sqlType","longtext");
	$atributo->set("inputType","image");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","link");
	$atributo->set("label","Link home");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","imagen_mercado");
	$atributo->set("label","Imagen mercado");
	$atributo->set("sqlType","longtext");
	$atributo->set("inputType","image");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","link_mercado");
	$atributo->set("label","Link mercado");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure(FALSE);

?>
