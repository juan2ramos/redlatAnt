<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");

	class cita extends entity{

		function insert(){
			$atributo=$this->getAttributeByName("fecha_inicial");
			$fecha_inicial=$fecha_cita=$atributo->value;
			$atributo=$this->getAttributeByName("id_sesion");
			$id_sesion=$atributo->value;
			$qid=$this->db->sql_query("
				SELECT r.duracion_cita, s.fecha_inicial, s.fecha_final
				FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE s.id='$id_sesion'
			");
			$sesion=$this->db->sql_fetchrow($qid);
			$fecha_inicial=strtotime($fecha_inicial);
			$fecha_final=$fecha_inicial + $sesion["duracion_cita"]*60;
			$fecha_inicial_sesion=strtotime($sesion["fecha_inicial"]);
			$fecha_final_sesion=strtotime($sesion["fecha_final"]);
			if($fecha_inicial < $fecha_inicial_sesion || $fecha_final > $fecha_final_sesion){
				echo "<b>Error</b>:<br>\nLa fecha de la cita está por fuera del rango de fechas de la sesión.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}
			$atributo=$this->getAttributeByName("id_grupo_musica");
			$id_grupo_musica=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_danza");
			$id_grupo_danza=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_teatro");
			$id_grupo_teatro=$atributo->value;
			$seleccionados=0;
			
			if($id_grupo_musica!="%")
			{
				$seleccionados++;
				$condicion = " id_grupo_musica=".$id_grupo_musica;
			}
			if($id_grupo_danza!="%")
			{
				$seleccionados++;
				$condicion = " id_grupo_danza=".$id_grupo_danza;
			}
			if($id_grupo_teatro!="%")
			{
				$seleccionados++;
				$condicion = " id_grupo_teatro =".$id_grupo_teatro;
			}

			if($seleccionados==0){
				echo "<b>Error</b>:<br>\nDebe escoger un grupo de teatro o de danza o de música.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}
			if($seleccionados>1){
				echo "<b>Error</b>:<br>\nDebe escoger un grupo de teatro o de danza o de música, pero sólo uno.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}

			//verificar que la fecha escogida los dos la tengan libre
			$id_promotor = $this->getAttributeByName("id_promotor");
			$id_promotor = $id_promotor->value;
			$qid = $this->db->sql_query("
				SELECT fecha_inicial
				FROM citas
				WHERE id_sesion IN (SELECT id FROM sesiones WHERE id_rueda IN(SELECT id FROM ruedas WHERE id_mercado=(SELECT r.id_mercado FROM sesiones ses LEFT JOIN ruedas r ON ses.id_rueda=r.id WHERE ses.id='$id_sesion')))
					AND fecha_inicial = '".$fecha_cita."'
					AND (id_promotor=".$id_promotor." OR ".$condicion.")
			");
			$numero = $this->db->sql_numrows($qid);
			if($numero != 0)
			{
				echo "<b>Error</b>:<br>\nEl horario escogido no está disponible. Los horarios que tienen espacio libre son:\n<br>";
				$qiHL = $this->db->sql_query("SELECT * FROM fechas_sesiones WHERE id_sesion = ".$id_sesion." AND fecha NOT IN (SELECT fecha_inicial FROM citas WHERE id_sesion = ".$id_sesion." AND fecha_inicial = '".$fecha_cita."' AND (id_promotor=".$id_promotor." OR ".$condicion."))");
				while($fecha_libre = $this->db->sql_fetchrow($qiHL))
				{
					echo $fecha_libre["fecha"]."<br>";
				}
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}

			return(parent::insert());
		}

		function update(){
			$atributo=$this->getAttributeByName("fecha_inicial");
			$fecha_inicial=$fecha_cita=$atributo->value;
			$atributo=$this->getAttributeByName("id_sesion");
			$id_sesion=$atributo->value;
			$qid=$this->db->sql_query("
				SELECT r.duracion_cita, s.fecha_inicial, s.fecha_final
				FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE s.id='$id_sesion'
			");
			$sesion=$this->db->sql_fetchrow($qid);
			$fecha_inicial=strtotime($fecha_inicial);
			$fecha_final=$fecha_inicial + $sesion["duracion_cita"]*60;
			$fecha_inicial_sesion=strtotime($sesion["fecha_inicial"]);
			$fecha_final_sesion=strtotime($sesion["fecha_final"]);
			if($fecha_inicial < $fecha_inicial_sesion || $fecha_final > $fecha_final_sesion){
				echo "<b>Error</b>:<br>\nLa fecha de la cita está por fuera del rango de fechas de la sesión.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}
			$atributo=$this->getAttributeByName("id_grupo_musica");
			$id_grupo_musica=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_danza");
			$id_grupo_danza=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_teatro");
			$id_grupo_teatro=$atributo->value;
			$seleccionados=0;
			if($id_grupo_musica!="%")
			{
				$seleccionados++;
				$condicion = " c.id_grupo_musica=".$id_grupo_musica;
			}
			if($id_grupo_danza!="%")
			{
				$seleccionados++;
				$condicion = " c.id_grupo_danza=".$id_grupo_danza;
			}
			if($id_grupo_teatro!="%")
			{
				$seleccionados++;
				$condicion = " c.id_grupo_teatro =".$id_grupo_teatro;
			}
//			if($id_grupo_musica!="%") $seleccionados++;
//			if($id_grupo_danza!="%") $seleccionados++;
//			if($id_grupo_teatro!="%") $seleccionados++;
			if($seleccionados==0){
				echo "<b>Error</b>:<br>\nDebe escoger un grupo de teatro o de danza o de música.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}
			if($seleccionados>1){
				echo "<b>Error</b>:<br>\nDebe escoger un grupo de teatro o de danza o de música, pero sólo uno.<br>\n";
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}

			//verificar que la fecha escogida los dos la tengan libre
			$id_promotor = $this->getAttributeByName("id_promotor");
			$id_promotor = $id_promotor->value;
			$qid = $this->db->sql_query("
				SELECT c.fecha_inicial
				FROM citas c
				WHERE c.id_sesion IN (SELECT id FROM sesiones WHERE id_rueda IN(SELECT id FROM ruedas WHERE id_mercado=(SELECT r.id_mercado FROM sesiones ses LEFT JOIN ruedas r ON ses.id_rueda=r.id WHERE ses.id='$id_sesion'))) AND
					c.fecha_inicial = '".$fecha_cita."' AND
					(c.id_promotor=".$id_promotor." OR ".$condicion.")
					AND c.id!='" . $this->id . "'
			");
			$numero = $this->db->sql_numrows($qid);
			if($numero != 0)
			{
				echo "<b>Error</b>:<br>\nEl horario escogido no está disponible. Los horarios que tienen espacio libre son:\n<br>";
				$qiHL = $this->db->sql_query("SELECT * FROM fechas_sesiones WHERE id_sesion = ".$id_sesion." AND fecha NOT IN (SELECT fecha_inicial FROM citas WHERE id_sesion = ".$id_sesion." AND fecha_inicial = '".$fecha_cita."' AND (id_promotor=".$id_promotor." OR ".$condicion."))");
				while($fecha_libre = $this->db->sql_fetchrow($qiHL))
				{
					echo $fecha_libre["fecha"]."<br>";
				}
				echo "<form><input type=\"button\" value=\"Volver\" onClick=\"history.back(1);\"></form>";
				die();
			}
			return(parent::update());
		}
	}

	$entidad =& new cita();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Citas");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------
	$link=new link($entidad);
	$link->set("name","eval_cita");
	$link->set("url",$ME . "?module=eval_cita");
	$link->set("iconoLetra","EC");
	$link->set("description","Evaluación de la Cita");
	$link->set("field","id_cita");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable","eval_cita");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","eval_promotor");
	$link->set("url",$ME . "?module=eval_cita_promotor");
	$link->set("iconoLetra","EP");
	$link->set("description","Evaluación Promotor");
	$link->set("field","id_cita");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable","eval_cita_promotor");
	$entidad->addLink($link);

	$link=new link($entidad);
	$link->set("name","eval_artista");
	$link->set("url",$ME . "?module=eval_cita_artista");
	$link->set("iconoLetra","EA");
	$link->set("description","Evaluación Artista");
	$link->set("field","id_cita");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable","eval_cita_artista");
	$entidad->addLink($link);

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_sesion");
	$atributo->set("label","Sesión");
	$atributo->set("inputType","querySelect");
	$atributo->set("qsQuery","
		SELECT s.id, CONCAT(m.nombre,' / ',r.nombre,' / ', s.lugar) as nombre
		FROM sesiones s 
		LEFT JOIN ruedas r ON s.id_rueda=r.id
		LEFT JOIN mercados m ON r.id_mercado=m.id
	");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);

//atributos necesarios para el select_dependiente
/*
	$nameidARecargar="fecha_inicial";
	$CFG->namediv = "div_select_dependiente";
	$queryACargar = "SELECT fecha FROM fechas_sesiones WHERE id_sesion=__%idARemp%__ ORDER BY fecha";
	$atributo->set("onChange","updateRecursive(this,'".$nameidARecargar."','".$queryACargar."')");
*/
	$entidad->addAttribute($atributo);



	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_inicial");
	$atributo->set("label","Fecha y hora inicial");
	$atributo->set("sqlType","datetime");

	$atributo->set("inputType","select_dependiente");
	$atributo->set("fieldIdParent","id_sesion");
	$atributo->set("namediv","div_fecha");

	$atributo->set("foreignFieldId","fecha");
	$atributo->set("foreignTable","fechas_sesiones");
	$atributo->set("foreignField","fecha");
	$atributo->set("foreignLabelFields","fecha");

	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

/*
	$atributo=new attribute($entidad);
	$atributo->set("field","mesa");
	$atributo->set("label","Mesa");
	$atributo->set("sqlType","smallint(4)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
*/

	$atributo=new attribute($entidad);
	$atributo->set("field","id_promotor");
	$atributo->set("label","Promotor");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","promotores");
	$atributo->set("foreignLabelFields","CONCAT(promotores.apellido, ', ', promotores.nombre)");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_promotor2");
	$atributo->set("label","Promotor 2");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","promotores");
	$atributo->set("foreignTableAlias","prom2");
	$atributo->set("foreignLabelFields","CONCAT(prom2.apellido, ', ', prom2.nombre)");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_idioma_traduccion");
	$atributo->set("label","Servicio de Traducción");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","pr_idiomas");
	$atributo->set("foreignLabelFields","idioma");
	$atributo->set("sqlType","smallint(4)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_musica");
	$atributo->set("label","Grupo musical");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_musica");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_danza");
	$atributo->set("label","Grupo de danza");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_danza");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_teatro");
	$atributo->set("label","Grupo de teatro");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","grupos_teatro");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);


	$atributo=new attribute($entidad);
	$atributo->set("field","aceptada_promotor");
	$atributo->set("label","¿Aceptada por el promotor?");
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
	$atributo->set("field","aceptada_promotor2");
	$atributo->set("label","¿Aceptada por el promotor 2?");
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
	$atributo->set("field","aceptada_grupo");
	$atributo->set("label","¿Aceptada por el grupo?");
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
	$atributo->set("field","comentarios");
	$atributo->set("label","Comentarios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);



	$entidad->checkSqlStructure(FALSE);

?>
