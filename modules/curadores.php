<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");
	
class curador extends entity{
	function insert()
	{
		$valor = $this->getAttributeByName("login");
		$valor = $valor->get("value");
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM " . $this->table . " WHERE upper(login)='".strtoupper($valor)."'");
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"]==0)
		{
			$this->id = parent::insert();
			return($this->id);
		}
		else
		{
			$this->avisoError("Ya existe un registro con el mismo usuario.<br>NO se puede insertar.");
		}	
	}

	function update()
	{
		$valorL = $this->getAttributeByName("login");
		$valorL = $valorL->get("value");
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM " . $this->table . " WHERE upper(login)='".strtoupper($valorL)."' AND id != ".$this->id);
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"]==0)
		{
			parent::update();
		}
		else
		{
			$this->avisoError("Ya existe un registro con el mismo usuario.<br>NO se puede actualizar.");
		}	
	}

	function delete()
	{
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM curadores_grupos WHERE id_curador='" . $this->id . "'");
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"] != 0)	$this->avisoError("El curador está relacionado con algún artista.  No se puede eliminar.");

		parent::delete();
	}

	function avisoError($aviso)
	{
		global $CFG;

		echo "<center>".$aviso."<br><br></center>";
		echo "<center>";
		if(isset($_SERVER["HTTP_REFERER"])) echo "<input type='button' value='Volver' OnClick=\"window.location.href='" . $_SERVER["HTTP_REFERER"] . "';\">&nbsp;";
		echo "<input type='button' value='Cerrar' OnClick='javascript=window.close()'>";
		echo "</center>";
		include($CFG->templatedir."/resize_window.php");
		die();
	}
}

	$entidad =& new curador();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Curadores");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","apellido,nombre");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","Áreas");
	$link->set("description","Áreas");
	$link->set("field","id_curador");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","curadores_areas");
	$link->set("relatedICTable","pr_areas");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_curador");
	$link->set("relatedICIdFieldDos","id_area");
	$link->set("numCols",3);
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","Vinculación_a_Grupos");
	$link->set("url","index.php?module=curadores_grupos");
	$link->set("icon","state2.gif");
	$link->set("description","Vinculación a grupos");
	$link->set("field","id_curador");
	$link->set("popup","yes");
	$entidad->addLink($link);


// ---------- ATRIBUTOS          ----------------

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
	$atributo->set("label","Apellido");
	$atributo->set("sqlType","character varying(60)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","login");
	$atributo->set("label","Login");
	$atributo->set("sqlType","character varying(16)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","password");
	$atributo->set("label","Password");
	$atributo->set("inputType","password");
	$atributo->set("encrypted",FALSE);
	$atributo->set("sqlType","character varying(32)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","email");
	$atributo->set("label","e-mail");
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();
?>
