<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

class artistas extends entity
{
	function find()
	{
		global $CFG;

		$condicionAnterior="";
		$nivel = $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"];
		if($nivel == 7 || $nivel == 8 || $nivel == 9)
		{
			$artistas = array(0);
			$qid = $this->db->sql_query("SELECT id_artista
					FROM usuarios_artistas
					WHERE id_usuario = ".$_SESSION[$CFG->sesion_admin]["user"]["id"]);
			while($query = $this->db->sql_fetchrow($qid))
			{
				$artistas[] = $query["id_artista"];
			}
			$condicionAnterior .= " artistas.id IN (".implode(",",$artistas).")";
		}
		parent::find($condicionAnterior);
	}


	function insert()
	{
		global $CFG;

		//$this->getAttributeByName("nombres")->set("value",trim($this->getAttributeByName("nombres")->get("value")));
		$nomgA = $this->getAttributeByName("nombres");
		$nomO = $nomgA->get("value");
		$nomO = trim($nomO);		
		$nomV = $nomgA->set("value",$nomO);
		//$nombres = strtolower($this->getAttributeByName("nombres")->get("value"));
		$nombres = strtolower($nomgA->get("value"));

		//$this->getAttributeByName("apellidos")->set("value",trim($this->getAttributeByName("apellidos")->get("value")));
		$apeA = $this->getAttributeByName("apellidos");
		$apeT = $apeA->get("value");
		$apeT = trim($apeT);
		$apeS = $apeA->set("value",$apeT);
		//$apellidos = strtolower($this->getAttributeByName("apellidos")->get("value"));
		$apellidos = strtolower($apeA->get("value"));

		$passport = $this->getAttributeByName("pasaporte");
		$passport = $passport->get("value");
		$consulta = "SELECT count(*) as numero FROM artistas WHERE lower(nombres) like '%".$nombres."%' AND lower(apellidos) like '%".$apellidos."%' AND pasaporte='".$passport."'" ;
		$query = $this->db->sql_query($consulta);
		$numero = $this->db->sql_fetchrow($query);
		if($numero["numero"] == 0)
		{
			$this->id = parent::insert();
			$nivel = $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"];
			if($nivel == 7 || $nivel == 8 || $nivel == 9)
			{
				$this->db->sql_query("INSERT INTO usuarios_artistas (id_usuario,id_artista) VALUES ('".$_SESSION[$CFG->sesion_admin]["user"]["id"]."','".$this->id."')");
			}
		}
		else
			$this->avisoError("Ya existe una persona con el mismo nombre y apellido.<br><font color='red'>NO se puede insertar.</font>");
	}


	function delete()
	{
		$error = array();
		$tablas = array("artistas_danza","artistas_musicos","artistas_teatro","directores_danza","directores_teatro","productores_musica");
		foreach($tablas as $table)
		{
			$qid = $this->db->sql_query("SELECT count(*) as numero FROM ".$table." WHERE id_artista = ".$this->id);
			$query = $this->db->sql_fetchrow($qid);
			if($query["numero"] != 0)
				$error[] = "- esta relacionada en ".$table;
		}

		if(count($error) != 0)
			$this->avisoError("La persona NO se puede eliminar.  Causa(s):<br> ".implode(",<br>",$error));

		$qid = $this->db->sql_query("DELETE FROM usuarios_artistas WHERE id_artista='" . $this->id . "'");
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

	$entidad =& new artistas();
	$entidad->set("db",$db);

	$entidad->set("name","artistas");
	$entidad->set("labelModule","Artistas");
	$entidad->set("table","artistas");
	$entidad->set("orderBy","nombres, apellidos");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------
	
	$link=new link($entidad);
	$link->set("name","Obras__Producciones");
	$link->set("url","index.php?mode=listado_obras_artista&e=mc2");
	$link->set("icon","estrella.gif");
	$link->set("description","Ver Obras / Producciones relacionados");
	$link->set("field","id_artista");
	$link->set("popup","yes");
	$entidad->addLink($link);

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","nombres");
	$atributo->set("label","Nombres");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","apellidos");
	$atributo->set("label","Apellidos");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","pasaporte");
	$atributo->set("label","Pasaporte");
	$atributo->set("sqlType","character varying(100)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","genero");
	$atributo->set("label","Género");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("arrayValues",array("1"=>"Masculino","2"=>"Femenino"));
	$atributo->set("mandatory",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$entidad->checkSqlStructure();

?>

