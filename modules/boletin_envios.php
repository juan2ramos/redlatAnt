<?
	require($CFG->common_libdir . "/entidades_v_1.4/object.php");

	class boletin	extends entity{
		function getForm($frm){
			$qid=$this->db->sql_query("SELECT id,nombre,codigo FROM pr_areas ORDER BY id");
			$string=parent::getForm($frm);
			$string.="<tr bgcolor='" . $this->rowColor . "'>\n";
			($this->fieldLabelStyle=="") ? $class="" : $class=" class=\"" . $this->fieldLabelStyle . "\"";
			$att=$this->getAttributeByName("areas");
			$string.="<td" . $class . " align='right' bgcolor='#ffffff' nowrap>" . $att->label . " : </td><td bgcolor='".$this->bgColorFieldValue."'>";
			$string.="<input type='checkbox' onClick=\"changeAll(this.checked,'".$att->field."[]')\">Todas<br>\n";
			while($cat=$this->db->sql_fetchrow($qid)){
				$string.="<input type='checkbox' name='".$att->field."[]' value='" . $cat["id"] . "'>";
				$string.=$cat["nombre"] . "<br>\n";
			}
			$string.="</td></tr>\n";
			return($string);
		}
		function getJavaScript(){
			$string='
<script type="text/javascript">
<!--
function changeAll(state,inputName){
	for (var i = 0; i < document.entryform.elements.length; i++) {
		if (document.entryform.elements[i].name==inputName) document.entryform.elements[i].checked=state;
	}
}
-->
</script>
			';
			return(parent::getJavaScript() . $string);
		}
	}

	$entidad =& new boletin();
	$entidad->JSComplementaryRevision="
inputName='areas[]';
chequeadas=0;
for (var i = 0; i < document.entryform.elements.length; i++) {
	if (document.entryform.elements[i].name==inputName && document.entryform.elements[i].checked)  chequeadas++;
}
if(chequeadas==0){
	window.alert('Por favor seleccione por lo menos un área ');
	return(false);
}
	";

	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Boletín &gt; Envíos");
	$entidad->set("table",$entidad->get("name"));
	$entidad->set("orderBy","fecha");
	$entidad->set("orderByMode","DESC");

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------


	$atributo=new attribute($entidad);
	$atributo->set("field","url");
	$atributo->set("label","Dirección del boletín");
	$atributo->set("sqlType","character varying(255)");
	$atributo->set("inputSize","50");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","subject");
	$atributo->set("label","Asunto");
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("inputSize","50");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","remitente_nombre");
	$atributo->set("label","Nombre del remitente");
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("inputSize","40");
	$atributo->set("mandatory",TRUE);
	$atributo->set("defaultValue","Circulart");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","remitente_mail");
	$atributo->set("label","Correo del remitente");
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("inputSize","40");
	$atributo->set("mandatory",TRUE);
	$atributo->set("defaultValue","info@circulart.org");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","bounce_mail");
	$atributo->set("label","Correo de devolución del mail");
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("inputSize","40");
	$atributo->set("mandatory",TRUE);
	$atributo->set("defaultValue","devueltos@circulart.org");
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","areas");
	$atributo->set("label","Áreas");
	$atributo->set("sqlType","character varying(128)");
	$atributo->set("inputSize","40");
	$atributo->set("visible",FALSE);
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","id_mercado");
	$atributo->set("label","Mercado");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","mercados");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","enviar_a");
	$atributo->set("label","Enviar a");
	$atributo->set("sqlType","tinyint(3)");
	$atributo->set("arrayValues",array("1"=>"Sólo artistas","2"=>"Sólo promotores","3"=>"Artistas y promotores"));
	$atributo->set("mandatory",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","fecha");
	$atributo->set("label","Fecha de inicio");
	$atributo->set("sqlType","datetime");
	$atributo->set("defaultValue",date("Y-m-d H:i:s"));
	$atributo->set("inputType","timestamp");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
	
	$atributo=new attribute($entidad);
	$atributo->set("field","fecha_fin");
	$atributo->set("label","Fecha de finalización");
	$atributo->set("sqlType","datetime");
	$atributo->set("inputType","timestamp");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);
	
	$entidad->checkSqlStructure();

?>
