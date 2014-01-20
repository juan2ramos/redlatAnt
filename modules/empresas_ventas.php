<?
	require($CFG->common_libdir . "/entidades_v_1.3/object.php");

	class ventas extends entity{
		function find($condicionAnterior=""){
			if(isset($_GET["id_empresa"])){
				$id_empresa=$_GET["id_empresa"];
				$qid=$this->db->sql_query("SELECT * FROM " . $this->table . " WHERE id_empresa='$id_empresa'");
				if($this->db->sql_numrows($qid)==0){
					for($i=(date("Y") - 5);$i<(date("Y") - 1);$i++){
						$qInsert=$this->db->sql_query("INSERT INTO " . $this->table . " (id_empresa,ano) VALUES ('$id_empresa','$i')");
//						echo ("INSERT INTO " . $this->table . " (id_empresa,ano) VALUES ('$id_empresa','$i')<br>\n");
					}
				}
			}
			parent::find($condicionAnterior);
		}
	}

	$entidad =& new ventas();
	$entidad->set("db",$db);

	$entidad->set("name",basename(__FILE__, ".php"));
	$entidad->set("labelModule","Organización - Ventas");
	$entidad->set("table",$entidad->get("name"));

	include("style.php");
	$entidad->set("formColumns",1);

// ---------- Vinculos a muchos  ----------------


// ---------- ATRIBUTOS          ----------------


	$atributo=new attribute($entidad);
	$atributo->set("field","id_empresa");
	$atributo->set("label","Organización");
	$atributo->set("inputType","select");
	$atributo->set("foreignTable","empresas");
	$atributo->set("foreignLabelFields","empresas.empresa");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",FALSE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","ano");
	$atributo->set("label","Año");
	$atributo->set("sqlType","int");
	$atributo->set("mandatory",TRUE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("inputType","arraySelect");
	$atributo->set("field","monto");
	$atributo->set("label","Monto USD");
	$atributo->set("sqlType","tinyint(4)");
	$atributo->set("arrayValues",array("1"=>"Menos de US$50.000 ", "2"=>"US$50.000 - US$100.000","3"=>"US$100.000 - US$250.000","4"=>"US$250.000 - US$500.000","5"=>"US$500.000 - US$1.000.000","6"=>"US$1.000.000 - US$5.000.000","7"=>"Más de US$5.000.000"));
	$atributo->set("mandatory",FALSE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","mercado_nal");
	$atributo->set("label","% mercado nacional");
	$atributo->set("sqlType","double");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$atributo=new attribute($entidad);
	$atributo->set("field","mercado_int");
	$atributo->set("label","% mercado internacional");
	$atributo->set("sqlType","double");
	$atributo->set("mandatory",FALSE);
	$atributo->set("editable",TRUE);
	$atributo->set("searchable",TRUE);
	$atributo->set("browseable",TRUE);
	$atributo->set("shortList",TRUE);
	$entidad->addAttribute($atributo);

	$entidad->checkSqlStructure();

?>
