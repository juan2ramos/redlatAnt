<?
	include("../application.php");
	if(sizeof($_POST)>sizeof($_GET)) $frm=$_POST;
	else $frm=$_GET;
	
	switch(nvl($frm["mode"])){
		case "generar_reporte":
			generar_reporte($frm);
			break;
		default:
			listar_reportes();
			break;
	}
 
//	FUNCIONES:

function generar_reporte($frm){
GLOBAL $CFG, $db, $ME;

	$tipo = substr($frm["id"], 0, 1);
	$id = str_replace($tipo."_","",$frm["id"]);
	if($tipo == "p")
	{
		$qReporte=$db->sql_query("SELECT * FROM reportes WHERE id='$id'");
		$reporte=$db->sql_fetchrow($qReporte);
		$qid=$db->sql_query($reporte["strsql"]);
		if($frm["format"]=="html"){
			include($CFG->templatedir . "/header.php");
			include($CFG->templatedir . "/listado_reportes.php");
		}
		elseif($frm["format"]=="pdf")
			pdf($reporte,$qid);
		else
			excel($reporte,$qid);
	}else
	{
		$qReporte=$db->sql_query("SELECT * FROM reportes2 WHERE id='$id'");
		$reporte=$db->sql_fetchrow($qReporte);
		include($CFG->templatedir . "/header_reportes2.php");
		include("reportes2/" . $reporte["id"] . ".php");
	}

}

function listar_reportes(){
GLOBAL $CFG, $db, $ME;

	include($CFG->templatedir . "/header.php");
	$qReportes=$db->sql_query("SELECT * FROM reportes ORDER BY id");
	$qReportes2=$db->sql_query("SELECT * FROM reportes2 ORDER BY numero");

	include($CFG->templatedir . "/listado_de_reportes.php");
}

function pdf($reporte,$qid)
{
	GLOBAL $CFG, $db, $ME;

	$titulos = titulos($qid);
	$datos = datos($qid);	

	if(!defined("FPDF_FONTPATH")) define("FPDF_FONTPATH",$CFG->common_libdir . "/fpdf/font/");
	include_once($CFG->common_libdir . "/fpdf/fpdf.php");
	include_once($CFG->common_libdir . "/funciones_pdf.php");
	$pdf=new PDF('P','mm','Letter');

	$pdf->SetMargins(10,15,10);

	$pdf->SetAutoPageBreak(1,5);
	$pdf->SetDisplayMode('fullpage','single');
	$pdf->Open();
	$pdf->AliasNbPages();
	$pdf->titulos = $titulos;
	$pdf->reporte = $reporte["titulo"];
	$pdf->AddPage();

	foreach($datos as $linea)
	{
		$pdf->Row($linea);
	}

	$pdf->Output();
}


function excel($reporte,$qid)
{
	GLOBAL $CFG, $db, $ME;

	$titulos = titulos($qid);
	$datos = datos($qid);	

	require_once $CFG->common_libdir."/writeexcel/class.writeexcel_workbook.inc.php";
	require_once $CFG->common_libdir."/writeexcel/class.writeexcel_worksheet.inc.php";

	$nombreArchivo="reporte.xls";
	$fname = tempnam($CFG->tmpdir, $nombreArchivo);
	$workbook = new writeexcel_workbook($fname);
	$workbook->set_tempdir($CFG->tmpdir);
	$worksheet = &$workbook->addworksheet("reporte");

	$style1=& $workbook->addformat(array("size"=>"11","bold"=>1,"align"=>"center","valign"=>"vjustify"));
	$style2=& $workbook->addformat(array("size"=>"9","bold"=>1,"align"=>"center","valign"=>"vjustify","border"=>"1"));
	$style3=& $workbook->addformat(array("size"=>"8","align"=>"left","valign"=>"vjustify","border"=>"1"));

	$fila = $columna = 0;
	$worksheet->write($fila,$columna,$reporte["titulo"],$style1);
	$worksheet->merge_cells($fila,$columna,$fila,count($titulos)-1);
	$fila++;

	foreach($titulos as $titCol)
	{
		$worksheet->write($fila,$columna,$titCol,$style2);
		$columna++;
	}
	$fila++; $columna = 0;

	foreach($datos as $linea)
	{
		foreach($linea as $col)
		{
			$worksheet->write($fila,$columna,$col,$style3);
			$columna++;
		}
		$fila++; $columna = 0;
	}

	$workbook->close();
	header("Content-Type: application/x-msexcel; name=\"".$nombreArchivo."\"");
	header("Content-Disposition: inline; filename=\"".$nombreArchivo."\"");
	$fh=fopen($fname, "rb");
	fpassthru($fh);
	unlink($fname);
}

function titulos($qid)
{
	GLOBAL $CFG, $db, $ME;

	$titulos = array();
	for($i=0;$i<$db->sql_numfields($qid);$i++)
	{
		$titulos[] = $db->sql_fieldname($i,$qid);
	}

	return $titulos;
}

function datos($qid)
{
	GLOBAL $CFG, $db, $ME;

	$datos = array();
	$j=0;
	while($result=$db->sql_fetchrow($qid))
	{
		for($i=0;$i<$db->sql_numfields($qid);$i++){
			$datos[$j][] = $result[$i];
		}
		$j++;
	}

	return $datos;
}




?>
