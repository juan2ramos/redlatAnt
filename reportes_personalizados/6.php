<?
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado.");
$id_mercado=$frm["id_mercado"];

$qid=$db->sql_query("
	SELECT 
	(
	 SELECT GROUP_CONCAT(emp.empresa SEPARATOR ' ; ') 
	 FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id
	 WHERE ep.id_promotor=p.id GROUP BY ep.id_promotor
	) as 'Empresa',
	p.nombre as 'Nombre',
	p.apellido as 'Apellido',
	mp.mesa AS 'No de mesa'

	FROM mercado_promotores mp LEFT JOIN promotores p ON mp.id_promotor=p.id
	WHERE mp.id_mercado='$id_mercado'
");

$mime_type = 'text/x-csv';
header('Content-Type: ' . $mime_type);
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="citas.csv"');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
$separador=",";
for ($i=0; $i<mysql_num_fields($qid); $i++){
	$texto=mysql_field_name($qid,$i);
	if($i!=0) echo $separador;
	echo '"' . $texto . '"';
}
echo "\r\n";
while($result=$db->sql_fetchrow($qid)){
	for ($i=0; $i<mysql_num_fields($qid); $i++){
		if($i!=0) echo $separador;
		$txt=trim($result[$i]);
		$txt=preg_replace("/\"/","\"\"",$txt);
		$txt=preg_replace("/\r/","",$txt);
		$txt=preg_replace("/\n/"," / ",$txt);
		echo '"' . $txt . '"';
	}
	echo "\r\n";
}
?>

