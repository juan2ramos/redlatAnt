<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");
	if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
	else $frm=$_GET;

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Personas vinculadas al grupo");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_danza");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9){
		$atributo->set("foreignTableFilter","id IN(SELECT id_grupo_danza FROM usuarios_grupos_danza WHERE id_usuario='" . $_SESSION[$CFG->sesion_admin]["user"]["id"] . "')");
	}
	$atributo->set("label","Grupo");
	$atributo->set("mandatory",FALSE);
	$atributo->set("sqlType","int");
	if(isset($frm["id_grupo_danza"])){
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","grupos_danza");
		$atributo->set("editable",TRUE);
		$atributo->set("searchable",TRUE);
		$atributo->set("browseable",TRUE);
		$atributo->set("shortList",TRUE);
	}
	else{
		$atributo->set("inputType","hidden");
		$atributo->set("editable",FALSE);
		$atributo->set("searchable",FALSE);
		$atributo->set("browseable",FALSE);
		$atributo->set("shortList",FALSE);
	}
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_musica");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9){
		$atributo->set("foreignTableFilter","id IN(SELECT id_grupo_musica FROM usuarios_grupos_musica WHERE id_usuario='" . $_SESSION[$CFG->sesion_admin]["user"]["id"] . "')");
	}
	$atributo->set("label","Grupo");
	$atributo->set("mandatory",FALSE);
	$atributo->set("sqlType","int");
	if(isset($frm["id_grupo_musica"])){
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","grupos_musica");
		$atributo->set("editable",TRUE);
		$atributo->set("searchable",TRUE);
		$atributo->set("browseable",TRUE);
		$atributo->set("shortList",TRUE);
	}
	else{
		$atributo->set("inputType","hidden");
		$atributo->set("editable",FALSE);
		$atributo->set("searchable",FALSE);
		$atributo->set("browseable",FALSE);
		$atributo->set("shortList",FALSE);
	}
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_grupo_teatro");
	if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9){
		$atributo->set("foreignTableFilter","id IN(SELECT id_grupo_teatro FROM usuarios_grupos_teatro WHERE id_usuario='" . $_SESSION[$CFG->sesion_admin]["user"]["id"] . "')");
	}
	$atributo->set("label","Grupo");
	$atributo->set("mandatory",FALSE);
	$atributo->set("sqlType","int");
	if(isset($frm["id_grupo_teatro"])){
		$atributo->set("inputType","select");
		$atributo->set("foreignTable","grupos_teatro");
		$atributo->set("editable",TRUE);
		$atributo->set("searchable",TRUE);
		$atributo->set("browseable",TRUE);
		$atributo->set("shortList",TRUE);
	}
	else{
		$atributo->set("inputType","hidden");
		$atributo->set("editable",FALSE);
		$atributo->set("searchable",FALSE);
		$atributo->set("browseable",FALSE);
		$atributo->set("shortList",FALSE);
	}
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","nombre");
	$atributo->set("label","Nombre");
	$atributo->set("sqlType","varchar(64)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","documento");
	$atributo->set("label","Documento");
	$atributo->set("sqlType","varchar(32)");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","foto");
	$atributo->set("label","Foto<br> (Subir JPG)");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("inputType","fileFS");
	$atributo->set("previewInForm",TRUE);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",FALSE);
	$atributo->set("browseable",FALSE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>

