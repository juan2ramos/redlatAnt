<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");
	if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
	else $frm=$_GET;

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Mercado - Promotores");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------

	$link=new link($entidad);
	$link->set("name","promotores_mercados_acuerdos");
	$link->set("description","Acuerdos buscados durante el evento");
	$link->set("field","id_promotor_mercado");
	$link->set("type","checkbox");
	$link->set("visible",FALSE);
	$link->set("relatedTable","promotores_mercados_acuerdos");
	$link->set("relatedICTable","tipos_acuerdo");
	$link->set("relatedICField","nombre");
	$link->set("relatedICIdFieldUno","id_promotor_mercado");
	$link->set("relatedICIdFieldDos","id_tipo_acuerdo");
	$entidad->addLink($link);

	if(isset($frm["mode"]) && (in_array($frm["mode"],array("editar","update","detalles","consultar")))){
		$id_promotor=$db->sql_field("SELECT id_promotor FROM mercado_promotores WHERE id='$frm[id]'");
		$id_mercado=$db->sql_field("SELECT id_mercado FROM mercado_promotores WHERE id='$frm[id]'");
		$qAreas=$db->sql_query("
			SELECT ar.id, ar.nombre, ar.codigo
			FROM pr_promotores_areas pa LEFT JOIN pr_areas ar ON pa.id_area=ar.id
			WHERE pa.id_promotor='$id_promotor'
		");

		while($area=$db->sql_fetchrow($qAreas)){
			$link=new link($entidad);
			$link->set("numCols",3);
			$link->set("name","A qué artistas de $area[nombre] le gustaría contratar");
			$link->set("description","A qué artistas de $area[nombre] le gustaría contratar");
			$link->set("field","id_promotor_mercado");
			$link->set("type","checkbox");
			$link->set("visible",FALSE);
			$link->set("relatedTable","promotores_mercados_intereses_" . $area["codigo"]);
			$link->set("relatedICTable","grupos_" . $area["codigo"]);
			$link->set("relatedICField","nombre");
			$link->set("relatedICIdFieldUno","id_promotor_mercado");
			$link->set("relatedICIdFieldDos","id_grupo");
			$link->set("relatedICTableFilter","id IN (SELECT DISTINCT c.id_grupo_$area[codigo] FROM citas c LEFT JOIN sesiones ses ON c.id_sesion=ses.id LEFT JOIN ruedas r ON ses.id_rueda=r.id WHERE c.id_grupo_$area[codigo]!='0' AND c.id_promotor='$id_promotor' AND r.id_mercado='$id_mercado')");
			$entidad->addLink($link);
		}
	}

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_mercado");
	$atributo->set("label","Mercado");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","mercados");
	$atributo->set("sqlType","int");
	$atributo->set("readonly",TRUE);
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

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
	$atributo->set("subQuery","
		SELECT COUNT(*) 
		FROM citas c 
		WHERE c.id_promotor=(SELECT id_promotor FROM mercado_promotores WHERE id='__id__') 
			AND c.id_sesion IN (SELECT s.id FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=(SELECT id_mercado FROM mercado_promotores WHERE id='__id__'))
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
	$atributo->set("field","num_grupos_contratar");
	$atributo->set("label","¿Cuántos grupos consideraría contratar?");
	$atributo->set("sqlType","smallint(6)");
	$atributo->set("inputSize","6");
	$atributo->set("mandatory",FALSE);
	if(nvl($_GET["mode"])=="agregar") $atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","calidad_productos");
	$atributo->set("label","¿Cómo juzga, en general, la calidad de los productos presentados?");
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

	$entidad->checkSqlStructure(TRUE);

?>
