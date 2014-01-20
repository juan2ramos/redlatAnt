<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");
	
class usuarios extends entity
{
	function insert()
	{
		$valor = $this->getAttributeByName("login");
		$valor = $valor->get("value");
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM usuarios WHERE upper(login)='".strtoupper($valor)."'");
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"]==0)
		{
			$this->id = parent::insert();
			$valorP = $this->getAttributeByName("password");
			$valorP = $valorP->get("value");

			if($valorP != "")
				$this->db->sql_query("UPDATE usuarios SET resolv='".$valorP."' WHERE id=".$this->id );
			return($this->id);
		}
		else
		{
			if(isset($_POST["registro_desde_el_usuario"]))
				return ("error");
			
			$this->avisoError("Ya existe un registro con el mismo usuario.<br>NO se puede insertar.");
		}	
	
	}

	function update()
	{
		$valorL = $this->getAttributeByName("login");
		$valorL = $valorL->get("value");
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM usuarios WHERE upper(login)='".strtoupper($valorL)."' AND id != ".$this->id);
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"]==0)
		{
			parent::update();
			$valorP = $this->getAttributeByName("password");
			$valorP = $valorP->get("value");
			if($valorP != "")
				$this->db->sql_query("UPDATE usuarios SET resolv = '".$valorP."' WHERE id=".$this->id);
		}
		else
		{
			$this->avisoError("Ya existe un registro con el mismo usuario.<br>NO se puede actualizar.");
		}	
	}

	function delete()
	{
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM usuarios_grupos_danza WHERE id_usuario=".$this->id);
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"] != 0)
			$this->avisoError("El usuario esta relacionado con artistas de danza.  No se puede eliminar.");
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM usuarios_grupos_musica WHERE id_usuario=".$this->id);
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"] != 0)
			$this->avisoError("El usuario esta relacionado con artistas de música.  No se puede eliminar.");
		$qid = $this->db->sql_query("SELECT count(*) as numero FROM usuarios_grupos_teatro WHERE id_usuario=".$this->id);
		$query = $this->db->sql_fetchrow($qid);
		if($query["numero"] != 0)
			$this->avisoError("El usuario esta relacionado con artistas de teatro.  No se puede eliminar.");

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

	$entidad =& new usuarios();
	$entidad->set("db",$db);

	$entidad->set("name","usuarios");
	$entidad->set("labelModule","Usuarios del sistema");
	$entidad->set("table","usuarios");
	//$entidad->set("orderBy","apellido,nombre");
	$entidad->set("orderBy","id DESC");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","Vinculación_a_Artistas");
	$link->set("url","index.php?mode=usuarios_artistas&e=mc2");
	$link->set("icon","state2.gif");
	$link->set("description","Vinculación a Artistas");
	$link->set("field","id_usuario");
	$link->set("popup","yes");
	$entidad->addLink($link);


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","id_nivel");
	$atributo->set("label","Nivel de acceso");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("arrayValues",array("1"=>"Administrador","2"=>"Admin Géneros","3"=>"Admin Artistas","4"=>"Básico Grupo Danza","5"=>"Básico Grupo Música","6"=>"Básico Grupo Teatro","7"=>"Total Grupo Danza","8"=>"Total Grupo Música","9"=>"Total Grupo Teatro"));
	$atributo->set("mandatory",TRUE);
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
	$atributo->set("encrypted",TRUE);
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
	$atributo->set("sqlType","character varying(60)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","resolv");
	$atributo->set("label","resolv");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("visible",FALSE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure();

?>
