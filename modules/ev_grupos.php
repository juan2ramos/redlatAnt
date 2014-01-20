<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");

	$entidad =& new entity();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Grupos asociados al evento");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","inicio,fin");

	include("style.php");
	$entidad->set("formColumns",1);

	$entidad->set("JSComplementaryRevision","
var artistasSeleccionados=0;
if(document.entryform.id_grupo_musica.options[document.entryform.id_grupo_musica.selectedIndex].value!='%') artistasSeleccionados++;
if(document.entryform.id_grupo_danza.options[document.entryform.id_grupo_danza.selectedIndex].value!='%') artistasSeleccionados++;
if(document.entryform.id_grupo_teatro.options[document.entryform.id_grupo_teatro.selectedIndex].value!='%') artistasSeleccionados++;
if(artistasSeleccionados==0){
	window.alert('Por favor seleccione algún artista');
	return(false);
}
if(artistasSeleccionados>1){
	window.alert('Por favor seleccione sólamente un artista');
	return(false);
}
	");

// ---------- Vinculos a muchos  ----------------

// ---------- ATRIBUTOS          ----------------

	$atributo=new attribute($entidad);
	$atributo->set("field","id_evento");
	$atributo->set("label","Evento");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","eventos");
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


	$entidad->checkSqlStructure();

?>
