<?
	require_once($CFG->common_libdir . "/entidades_v_1.5/object.php");

	class publico extends entity{
		function find(){
			global $CFG;
			$condicionAnterior="";
			if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 10){//Publico---
				$condicionAnterior .= "publico.id='" . $_SESSION[$CFG->sesion_admin]["user"]["id"] . "'";
			}
			parent::find($condicionAnterior);
		}
		function insert($dummy=FALSE){
			
			$objidentificacion=$this->getAttributeByName("email1");
			$identificacion=$objidentificacion->value;
			if($existente=$this->db->sql_row("SELECT id, nombre, apellido FROM publico WHERE email1='$email1'")){
				echo "" . $existente["nombre"] . " " . $existente["apellido"] . " ya se encuentra registrado.<br>\n";
				echo "<a href=\"javascript:history.go(-1)\">Volver</a>";
				die();
			}
			return(parent::insert($dummy));
		}
		function update($dummy=FALSE){
			$objidentificacion=$this->getAttributeByName("email1");
			$identificacion=$objidentificacion->value;
			$id=$this->id;
			if($existente=$this->db->sql_row("SELECT id, nombre, apellido FROM publico WHERE email1='$email1' AND id!='$id'")){
				echo "" . $existente["nombre"] . " " . $existente["apellido"] . " ya se encuentra registrado.<br>\n";
				echo "<a href=\"javascript:history.go(-1)\">Volver</a>";
				die();
			}
			return(parent::update($dummy));
		}
		function cargaPaises(){
		    $cont=0;
			$result = mysql_query("SELECT pais FROM paises");
			$array=mysql_fetch_array($result);
			$existente[$cont]=$array[$cont];
		     while($array=mysql_fetch_array($result)){
				$cont++;
				$existente[$cont]=$array[0];
				}
	      return $existente;
	    }
		function cargaCiudades(){
		    $cont=0;
			$result = mysql_query("SELECT nombre FROM ciudad");
			$array=mysql_fetch_array($result);
			$existente[$cont]=$array[$cont];
		     while($array=mysql_fetch_array($result)){
				$cont++;
				$existente[$cont]=$array[0];
				}
	     return $existente;
		}		
	}
    
	$entidad =& new publico();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Publico");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","id desc,apellido,nombre");

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
/*	$link=new link($entidad);
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
*/

	$link=new link($entidad);
	$link->set("name","Áreas");
	$link->set("description","Áreas");
	$link->set("field","id_publico");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","pub_publico_areas");
	$link->set("relatedICTable","pub_areas");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_publico");
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
	$link->set("field","id_publico");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","pub_publico_idiomas"); //nombre del campo
	$link->set("relatedICTable","pub_idiomas");//tabla
	$link->set("relatedICField","idioma");//campo
	$link->set("relatedICIdFieldUno","id_publico");
	$link->set("relatedICIdFieldDos","id_idioma");
	$link->set("numCols",3);
	$entidad->addLink($link);
	

	/*$link=new link($entidad);
	$link->set("name","empresas_promotores");
	$link->set("url",$ME . "?module=empresas_promotores");
	$link->set("iconoLetra","ORG");
	$link->set("description","Organizaciones");
	$link->set("field","id_promotor");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);*/


// ---------- ATRIBUTOS          ----------------


	$atributo=new attribute($entidad);
	$atributo->set("field","fecha");
	$atributo->set("label","Fecha");
	$atributo->set("sqlType","timestamp");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

    $atributo=new attribute($entidad);
	$atributo->set("field","ingreso");
	$atributo->set("label","ingreso");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
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
	$atributo->set("field","beca");
	$atributo->set("label","¿becado?");
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
	$atributo->set("field","pago");
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
	$atributo->set("field","identificacion");
	$atributo->set("label","Identificación");
	$atributo->set("sqlType","character varying(60)");
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
	$atributo->set("mandatory",FALSE);
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
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

    $atributo=new attribute($entidad);
	$atributo->set("field","entidad");
	$atributo->set("label","Entidad a la que pertenece:");
	$atributo->set("sqlType","varchar(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","cargo");
	$atributo->set("label","Cargo o profesión");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);
	
	
	$atributo=new attribute($entidad);
	$atributo->set("field","clase_entidad");
	$atributo->set("label","clase de entidad");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","telefono1");
	$atributo->set("label","Teléfono 1");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
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
	$atributo->set("field","email2");
	$atributo->set("label","e-mail 2");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);
	
	//array("Administrador","Admin Géneros","Admin Artistas");
	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","pais");
	$atributo->set("label","País");
	$atributo->set("arrayValues", $entidad->cargaPaises());
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
	
	$atributo=new attribute($entidad);
	$atributo->set("field","paisOtro");
	$atributo->set("label","Otro País");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","ciudad");
	$atributo->set("label","Ciudad");
	$atributo->set("arrayValues", $entidad->cargaCiudades());
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
	
	$atributo=new attribute($entidad);
	$atributo->set("field","ciudadOtra");
	$atributo->set("label","Otra Ciudad");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
	

	$atributo=new attribute($entidad);
	$atributo->set("field","direccion");
	$atributo->set("label","Dirección");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",FALSE);
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
	$atributo->set("field","otrasAreas");
	$atributo->set("label","Otras Áreas");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",false);
	$atributo->set("browseable",false);
	$atributo->set("shortList",false);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","otrosIdiomas");
	$atributo->set("label","Otros Idiomas");
	$atributo->set("sqlType","text");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",false);
	$atributo->set("browseable",false);
	$atributo->set("shortList",false);
	$entidad->addAttribute($atributo);
	
	$atributo=new attribute($entidad);
	$atributo->set("field","boletin");
	$atributo->set("label","boletín");
	$atributo->set("sqlType","varchar(2)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	/*$atributo=new attribute($entidad);
	$atributo->set("field","vigente");
	$atributo->set("label","¿Vigente?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","1");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);*/

	/*$atributo=new attribute($entidad);
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
	$entidad->addAttribute($atributo);*/
    

	$entidad->checkSqlStructure(FALSE);

?>
