<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	class sesion extends entity{
		function insert(){
			$atributo=$this->getAttributeByName("fecha_inicial");
			$fecha_inicial=$atributo->value;
			$atributo=$this->getAttributeByName("fecha_final");
			$fecha_final=$atributo->value;
			$atributo=$this->getAttributeByName("id_rueda");
			$id_rueda=$atributo->value;
			$qid=$this->db->sql_query("SELECT m.* FROM ruedas r LEFT JOIN mercados m ON r.id_mercado=m.id WHERE r.id='$id_rueda'");
			$mercado=$this->db->sql_fetchrow($qid);
			$fecha_inicial=strtotime($fecha_inicial);
			$fecha_final=strtotime($fecha_final);
			$fecha_inicial_mercado=strtotime($mercado["fecha_inicio"]);
			$fecha_final_mercado=strtotime($mercado["fecha_final"] . " 23:59:59");
			if($fecha_inicial < $fecha_inicial_mercado || $fecha_final > $fecha_final_mercado){
				echo "<b>Error</b>:<br>\nLas fechas de la sesión están por fuera del rango de fechas del mercado.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}
			return(parent::insert());
		}
		function update(){
			$atributo=$this->getAttributeByName("fecha_inicial");
			$fecha_inicial=$atributo->value;
			$atributo=$this->getAttributeByName("fecha_final");
			$fecha_final=$atributo->value;
			$atributo=$this->getAttributeByName("id_rueda");
			$id_rueda=$atributo->value;
			$qid=$this->db->sql_query("SELECT m.* FROM ruedas r LEFT JOIN mercados m ON r.id_mercado=m.id WHERE r.id='$id_rueda'");
			$mercado=$this->db->sql_fetchrow($qid);
			$fecha_inicial=strtotime($fecha_inicial);
			$fecha_final=strtotime($fecha_final);
			$fecha_inicial_mercado=strtotime($mercado["fecha_inicio"]);
			$fecha_final_mercado=strtotime($mercado["fecha_final"] . " 23:59:59");
			if($fecha_inicial < $fecha_inicial_mercado || $fecha_final > $fecha_final_mercado){
				echo "<b>Error</b>:<br>\nLas fechas de la sesión están por fuera del rango de fechas del mercado.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}
			return(parent::update());
		}
	}

	$entidad =& new sesion();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Sesiones");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------
/*
	$link=new link($entidad);
	$link->set("name","sesiones");
	$link->set("url",$ME . "?module=rondas_sesiones");
	$link->set("iconoLetra","S");
	$link->set("description","Sesiones");
	$link->set("field","id_ronda");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$entidad->addLink($link);
*/
// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_rueda");
	$atributo->set("label","Mercado / Rueda de negocios");
	$atributo->set("inputType","querySelect");
	$atributo->set("qsQuery","SELECT r.id, CONCAT(m.nombre,' / ',r.nombre) as nombre FROM ruedas r LEFT JOIN mercados m ON r.id_mercado=m.id");
//	$atributo->set("foreignTable","ruedas");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_inicial");
	$atributo->set("label","Fecha y hora inicial");
	$atributo->set("sqlType","timestamp");
	$atributo->set("inputType","timestamp");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_final");
	$atributo->set("label","Fecha y hora final");
	$atributo->set("sqlType","timestamp");
	$atributo->set("inputType","timestamp");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","lugar");
	$atributo->set("label","Lugar de la sesión");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>
