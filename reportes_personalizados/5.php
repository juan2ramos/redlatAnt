<?
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado.");
$id_mercado=$frm["id_mercado"];

$qid=$db->sql_query("
SELECT 
 CASE WHEN grd.nombre IS NOT NULL THEN grd.nombre
 WHEN grm.nombre IS NOT NULL THEN grm.nombre
 WHEN grt.nombre IS NOT NULL THEN grt.nombre
 ELSE 'ERROR' END as 'Artista',

 CASE WHEN grd.nombre IS NOT NULL THEN grd.nit
 WHEN grm.nombre IS NOT NULL THEN grm.nit
 WHEN grt.nombre IS NOT NULL THEN grt.nit
 ELSE 'ERROR' END as 'NIT',

 CASE WHEN grd.nombre IS NOT NULL THEN grd.rut
 WHEN grm.nombre IS NOT NULL THEN grm.rut
 WHEN grt.nombre IS NOT NULL THEN grt.rut
 ELSE 'ERROR' END as 'RUT',
 
 v.nombre as 'Nombre',
 v.documento as 'Documento'
 

FROM vinculados v
 LEFT JOIN grupos_danza grd ON v.id_grupo_danza=grd.id
 LEFT JOIN grupos_musica grm ON v.id_grupo_musica=grm.id
 LEFT JOIN grupos_teatro grt ON v.id_grupo_teatro=grt.id
WHERE 
 v.id_grupo_danza IN (SELECT id_grupo_danza FROM mercado_artistas WHERE id_mercado='$id_mercado') OR
 v.id_grupo_musica IN (SELECT id_grupo_musica FROM mercado_artistas WHERE id_mercado='$id_mercado') OR
 v.id_grupo_teatro IN (SELECT id_grupo_teatro FROM mercado_artistas WHERE id_mercado='$id_mercado');
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

