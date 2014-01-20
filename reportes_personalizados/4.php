<?
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado.");
$id_mercado=$frm["id_mercado"];
$qMercado=$db->sql_query("SELECT * FROM mercados WHERE id='$id_mercado'");
$mercado=$db->sql_fetchrow($qMercado);

$qCitasDetalle=$db->sql_query("
	SELECT c.*,mp.mesa,
		CASE WHEN (c.id_grupo_musica IS NOT NULL AND c.id_grupo_musica!='0') THEN gm.nombre
		WHEN (c.id_grupo_danza IS NOT NULL AND c.id_grupo_danza!='0') THEN gd.nombre
		ELSE gt.nombre END as grupo,
		CONCAT(prom.nombre, ' ', prom.apellido) as promotor
	FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
		LEFT JOIN ruedas r ON s.id_rueda=r.id
		LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
		LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
		LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
		LEFT JOIN promotores prom ON c.id_promotor=prom.id
		LEFT JOIN mercado_promotores mp ON c.id_promotor=mp.id_promotor AND mp.id_mercado='$id_mercado'
	WHERE r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1'
	ORDER BY c.id_sesion, c.fecha_inicial
");

$mime_type = 'text/x-csv';
header('Content-Type: ' . $mime_type);
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="citas.csv"');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');

?>
"Fecha","Hora","Nombre promotor","Nombre artista","No. de mesa"
<?
while($cita=$db->sql_fetchrow($qCitasDetalle)){
	echo "\"" . date("Y-m-d",strtotime($cita["fecha_inicial"])) . "\",";
	echo "\"" . date("H:i",strtotime($cita["fecha_inicial"])) . "\",";
	echo "\"" . $cita["promotor"] . "\",";
	echo "\"" . $cita["grupo"] . "\",";
	echo "\"" . $cita["mesa"] . "\"\n";
}
?>

