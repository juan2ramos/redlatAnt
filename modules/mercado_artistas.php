<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	class mercado_artistas extends entity{

		function insert(){
			$atributo=$this->getAttributeByName("id_grupo_musica");
			$id_grupo_musica=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_danza");
			$id_grupo_danza=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_teatro");
			$id_grupo_teatro=$atributo->value;
			$seleccionados=0;
			if($id_grupo_musica!="%") $seleccionados++;
			if($id_grupo_danza!="%") $seleccionados++;
			if($id_grupo_teatro!="%") $seleccionados++;
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
			return($this->id = parent::insert());
		}
		
		function update(){
			$atributo=$this->getAttributeByName("id_grupo_musica");
			$id_grupo_musica=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_danza");
			$id_grupo_danza=$atributo->value;
			$atributo=$this->getAttributeByName("id_grupo_teatro");
			$id_grupo_teatro=$atributo->value;
			$seleccionados=0;
			if($id_grupo_musica!="%") $seleccionados++;
			if($id_grupo_danza!="%") $seleccionados++;
			if($id_grupo_teatro!="%") $seleccionados++;

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

			parent::update();
		}
	}

	$entidad =& new mercado_artistas();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Artistas");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------
/*
	$link=new link($entidad);
	$link->set("name","eval_artista");
	$link->set("url",$ME . "?module=eval_rueda_artista");
	$link->set("iconoLetra","EA");
	$link->set("description","Evaluación Rueda - Artista");
	$link->set("field","id_mercado_artistas");
	$link->set("type","iframe");
	$link->set("popup",TRUE);
	$link->set("relatedTable","eval_rueda_artista");
	$entidad->addLink($link);
*/


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_mercado");
	$atributo->set("label","Mercado");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","mercados");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
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
	$atributo->set("field","mesa");
	$atributo->set("label","# de mesa");
	$atributo->set("inputSize","3");
	$atributo->set("sqlType","tinyint(3)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ubicacion");
	$atributo->set("label","Ubicación de la mesa");
	$atributo->set("inputSize","30");
	$atributo->set("sqlType","varchar(128)");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","citas");
	$atributo->set("label","Citas");
	$atributo->set("sqlType","subquery");
	$atributo->set("inputType","subQuery");
//	$atributo->set("subQuery","SELECT COUNT(*) FROM citas c WHERE c.id_grupo_musica=(SELECT id_grupo_musica FROM mercado_artistas WHERE id='__id__') OR c.id_grupo_danza=(SELECT id_grupo_danza FROM mercado_artistas WHERE id='__id__') OR c.id_grupo_teatro=(SELECT id_grupo_teatro FROM mercado_artistas WHERE id='__id__')");

	$atributo->set("subQuery","
		SELECT COUNT(*) 
		FROM citas c 
		WHERE (c.id_grupo_musica=(SELECT id_grupo_musica FROM mercado_artistas WHERE id='__id__') OR c.id_grupo_danza=(SELECT id_grupo_danza FROM mercado_artistas WHERE id='__id__') OR c.id_grupo_teatro=(SELECT id_grupo_teatro FROM mercado_artistas WHERE id='__id__'))
			AND c.id_sesion IN (SELECT s.id FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=(SELECT id_mercado FROM mercado_artistas WHERE id='__id__'))
	");


	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

//	======	EVALUACIÓN	======
	$atributo=new attribute($entidad);
	$atributo->set("field","num_citas_exitosas");
	$atributo->set("label","¿Cuántas citas exitosas tuvo?");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("inputSize","6");
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","num_citas_incumplidas");
	$atributo->set("label","¿Cuántas citas le fueron canceladas o incumplidas?");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("inputSize","6");
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","razones_incumplimiento");
	$atributo->set("label","¿Por qué razones le fueron canceladas o incumplidas sus citas?");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","calidad_productos");
	$atributo->set("label","¿Cómo juzga, en general, la calidad de los promotores asistentes?");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","eventos_similares");
	$atributo->set("label","¿Participaría en otros eventos similares a este?");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("defaultValue","1");
	$atributo->set("inputType","option");
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","es_por_que");
	$atributo->set("label","¿Por qué?");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","comentarios");
	$atributo->set("label","Comentarios");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","recomendaciones");
	$atributo->set("label","Recomendaciones o sugerencias");
	$atributo->set("sqlType","text");
	$atributo->set("inputType","textarea");
	$atributo->set("inputSize",40);
	$atributo->set("inputRows",2);
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>
