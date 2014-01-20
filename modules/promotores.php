<?
	require_once($CFG->common_libdir . "/entidades_v_1.4/object.php");

	class promotor extends entity{
		function find(){
			global $CFG;
			$condicionAnterior="";
			if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 10){//Promotor---
				$condicionAnterior .= "promotores.id='" . $_SESSION[$CFG->sesion_admin]["user"]["id"] . "'";
			}
			parent::find($condicionAnterior);
		}
		function insert($dummy=FALSE){
			$objLogin=$this->getAttributeByName("login");
			$login=$objLogin->value;
			if($existente=$this->db->sql_row("SELECT id, nombre, apellido FROM " . $this->table . " WHERE login='$login'")){
				echo "El promotor " . $existente["nombre"] . " " . $existente["apellido"] . " ya tiene asignado ese login.<br>\n";
				echo "<a href=\"javascript:history.go(-1)\">Volver</a>";
				die();
			}
			/*if($existente=$this->db->sql_row("SELECT id, nombre, apellido FROM usuarios WHERE login='$login'")){
				echo "El usuario " . $existente["nombre"] . " " . $existente["apellido"] . " ya tiene asignado ese login.<br>\n";
				echo "<a href=\"javascript:history.go(-1)\">Volver</a>";
				die();
			}*/
			return(parent::insert($dummy));
		}
		function update($dummy=FALSE){
			$objLogin=$this->getAttributeByName("login");
			$login=$objLogin->value;
			$id=$this->id;
			
			if($existente=$this->db->sql_row("SELECT id, nombre, apellido FROM " . $this->table . " WHERE login='$login' AND id!='$id'")){
				echo "El promotor " . $existente["nombre"] . " " . $existente["apellido"] . " ya tiene asignado ese login.<br>\n";
				echo "<a href=\"javascript:history.go(-1)\">Volver</a>";
				die();
			}
			
			/*if($existente=$this->db->sql_row("SELECT id, nombre, apellido FROM usuarios WHERE login='$login'")){
				echo "El usuario " . $existente["nombre"] . " " . $existente["apellido"] . " ya tiene asignado ese login.<br>\n";
				echo "<a href=\"javascript:history.go(-1)\">Volver</a>";
				die();
			}*/
			return(parent::update($dummy));
			//$this->db->sql_query("UPDATE promotores SET fecha_actualizacion = ".date("Y-m-d H:i:s")." WHERE id='$id')");
		}
	}

	$entidad =& new promotor();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Promotores");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","preinscripto DESC");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------
/*
	$link=new link($entidad);
	$link->set("name","tareas");
	$link->set("url",$ME . "?module=pr_promotores_tareas");
	$link->set("iconoLetra","T");
	$link->set("description","Tareas");
	$link->set("field","id_promotor");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);
*/
	$link=new link($entidad);
	$link->set("name","Tareas");
	$link->set("description","Tareas");
	$link->set("field","id_promotor");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","pr_promotores_tareas");
	$link->set("relatedICTable","pr_tareas");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_promotor");
	$link->set("relatedICIdFieldDos","id_tarea");
	$link->set("numCols",4);
	$entidad->addLink($link);

/*
	$link=new link($entidad);
	$link->set("name","areas");
	$link->set("url",$ME . "?module=pr_promotores_areas");
	$link->set("iconoLetra","A");
	$link->set("description","Áreas");
	$link->set("field","id_promotor");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);
*/

	$link=new link($entidad);
	$link->set("name","Áreas");
	$link->set("description","Áreas");
	$link->set("field","id_promotor");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","pr_promotores_areas");
	$link->set("relatedICTable","pr_areas");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_promotor");
	$link->set("relatedICIdFieldDos","id_area");
	$link->set("numCols",3);
	$entidad->addLink($link);
/*
	$link=new link($entidad);
	$link->set("name","idiomas");
	$link->set("url",$ME . "?module=pr_promotores_idiomas");
	$link->set("iconoLetra","I");
	$link->set("description","Idiomas");
	$link->set("field","id_promotor");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);
*/
	$link=new link($entidad);
	$link->set("name","Idiomas");
	$link->set("description","Idiomas");
	$link->set("field","id_promotor");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","pr_promotores_idiomas");
	$link->set("relatedICTable","pr_idiomas");
	$link->set("relatedICField","idioma");
	$link->set("relatedICIdFieldUno","id_promotor");
	$link->set("relatedICIdFieldDos","id_idioma");
	$link->set("numCols",3);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","empresas_promotores");
	$link->set("url",$ME . "?module=empresas_promotores");
	$link->set("iconoLetra","ORG");
	$link->set("description","Organizaciones");
	$link->set("field","id_promotor");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);


// ---------- ATRIBUTOS          ----------------

    $atributo=new attribute($entidad);
	$atributo->set("field","el_id");
	$atributo->set("label","id");
	$atributo->set("inputType","subQuery");
	$atributo->set("sqlType","subQuery");
	$atributo->set("subQuery","SELECT __id__");
//	$atributo->set("subQuery","id");
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

    $atributo=new attribute($entidad);
	$atributo->set("field","fecha_actualizacion");
	$atributo->set("label","Fecha Actualización");
	$atributo->set("sqlType","timestamp");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


    $atributo=new attribute($entidad);
	$atributo->set("field","terminos");
	$atributo->set("label","terminos");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","0");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

    $atributo=new attribute($entidad);
	$atributo->set("field","preinscripto");
	$atributo->set("label","¿preinscrito?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","0");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

    $atributo=new attribute($entidad);
	$atributo->set("field","convenio");
	$atributo->set("label","Mercado,Convenio,Acuerdo");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);



    $atributo=new attribute($entidad);
	$atributo->set("field","compra");
	$atributo->set("label","¿Pagó?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","1");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre");
	$atributo->set("sqlType","character varying(60)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","apellido");
	$atributo->set("label","Apellidos");
	$atributo->set("sqlType","character varying(60)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","resena");
	$atributo->set("label","Reseña");
	$atributo->set("inputType","textarea");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","independiente");
	$atributo->set("label","¿Independiente?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","1");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","cargo");
	$atributo->set("label","Cargo");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","telefono1");
	$atributo->set("label","Teléfono 1");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","telefono2");
	$atributo->set("label","Teléfono 2");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","email1");
	$atributo->set("label","e-mail 1");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","login");
	$atributo->set("label","Login");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","password");
	$atributo->set("label","Password");
	$atributo->set("inputType","password");
	$atributo->set("encrypted",TRUE);
	$atributo->set("sqlType","character varying(32)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","email2");
	$atributo->set("label","e-mail 2");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","pais");
	$atributo->set("label","País");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ciudad");
	$atributo->set("label","Ciudad");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","direccion");
	$atributo->set("label","Dirección");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","web");
	$atributo->set("label","Website");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","vigente");
	$atributo->set("label","¿Vigente?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","1");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","imagen");
	$atributo->set("label","Imagen<br> (Subir JPG)");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","fileFS");
	$atributo->set("previewInForm",TRUE);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","expectativas");
	$atributo->set("label","De acuerdo a su actividad...");
	$atributo->set("inputType","textarea");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);
	
	$atributo=new attribute($entidad);
	$atributo->set("field","bandas");
	$atributo->set("label","3-Mencione mínimo cinco bandas...");
	$atributo->set("inputType","textarea");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);
	
	$atributo=new attribute($entidad);
	$atributo->set("field","perfiles");
	$atributo->set("label","4-Que perfiles (géneros)...");
	$atributo->set("inputType","textarea");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);	

	$entidad->checkSqlStructure(FALSE);

?>
