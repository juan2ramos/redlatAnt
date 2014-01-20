<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	class imagen_home extends entity
	{
		function insert()
		{

			if($_FILES["imagen"]["size"] != 0)
			{
				$this->id = parent::insert();
			}
		}
	}


	$entidad =& new imagen_home();
	$entidad->set("db",$db);

	$entidad->set("name","imagen_home");
	$entidad->set("labelModule","Imagen Home");
	$entidad->set("table","imagen_home");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

// ---------- ATRIBUTOS          ----------------
	
	$atributo=new attribute($entidad);
	$atributo->set("field","link");
	$atributo->set("label","Link");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","imagen");
	$atributo->set("label","Imagen");
	$atributo->set("sqlType","longtext");
	$atributo->set("inputType","image");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure();

?>
