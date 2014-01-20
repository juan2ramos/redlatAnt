<?
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado.");
$id_mercado=$frm["id_mercado"];
$qMercado=$db->sql_query("SELECT * FROM mercados WHERE id='$id_mercado'");
$mercado=$db->sql_fetchrow($qMercado);
$qCitas=$db->sql_query("
	SELECT COUNT(*) as total_citas,
		COUNT((SELECT id FROM eval_cita_promotor ecp WHERE ecp.id_cita=c.id AND ecp.asistencia='1' LIMIT 1)) as cumplidas
	FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
		LEFT JOIN ruedas r ON s.id_rueda=r.id
	WHERE r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1'
");
$result=$db->sql_fetchrow($qCitas);
$citas_programadas=$result["total_citas"];
$citas_exitosas=$result["cumplidas"];
$citas_incumplidas=$citas_programadas-$citas_exitosas;

$qCitasPromotor=$db->sql_query("
	SELECT prom.id, prom.nombre, prom.apellido, (SELECT COUNT(*) FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE c.id_promotor=mp.id_promotor AND r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1') as citas
	FROM mercado_promotores mp 
		LEFT JOIN promotores prom ON mp.id_promotor=prom.id
	WHERE mp.id_mercado='$id_mercado'
");



$qCitasArtista=$db->sql_query("
	SELECT
		CASE WHEN ma.id_grupo_musica IS NOT NULL THEN ma.id_grupo_musica
			WHEN ma.id_grupo_danza IS NOT NULL THEN ma.id_grupo_danza
			ELSE ma.id_grupo_teatro END AS id_grupo, 
		CASE WHEN ma.id_grupo_musica IS NOT NULL THEN gm.nombre
			WHEN ma.id_grupo_danza IS NOT NULL THEN gd.nombre
			ELSE gt.nombre END AS nombre, 
		CASE WHEN ma.id_grupo_musica IS NOT NULL THEN (SELECT COUNT(*) FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE c.id_grupo_musica=ma.id_grupo_musica AND r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1')
			WHEN ma.id_grupo_danza IS NOT NULL THEN (SELECT COUNT(*) FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE c.id_grupo_danza=ma.id_grupo_danza AND r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1')
			ELSE (SELECT COUNT(*) FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE c.id_grupo_teatro=ma.id_grupo_teatro AND r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1') END AS citas
	FROM mercado_artistas ma 
		LEFT JOIN grupos_musica gm ON ma.id_grupo_musica=gm.id
		LEFT JOIN grupos_danza gd ON ma.id_grupo_danza=gd.id
		LEFT JOIN grupos_teatro gt ON ma.id_grupo_teatro=gt.id
	WHERE ma.id_mercado='$id_mercado'
");




$qCitasPromotorDetalle=$db->sql_query("
	SELECT c.*, CASE WHEN c.id_grupo_musica IS NOT NULL THEN gm.nombre WHEN c.id_grupo_danza IS NOT NULL THEN gd.nombre ELSE gt.nombre END as grupo,
		CONCAT(prom.nombre, ' ', prom.apellido) as promotor
	FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
		LEFT JOIN ruedas r ON s.id_rueda=r.id
		LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
		LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
		LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
		LEFT JOIN promotores prom ON c.id_promotor=prom.id
	WHERE r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1'
");



?>
<h1><?=$mercado["nombre"]?></h1>

<b>Número de citas programadas</b>: <?=$citas_programadas?><br />
<b>Número de citas exitosas</b>: <?=$citas_exitosas?><br />
<b>Número de citas incumplidas</b>: <?=$citas_incumplidas?><br />
<b>Número de citas por promotor</b>:<br />
<?
while($promotor=$db->sql_fetchrow($qCitasPromotor)){
	echo " - " . $promotor["nombre"] . " " . $promotor["apellido"] . ": " . $promotor["citas"] . "<br />\n";
}
?>
<br /><b>Número de citas por artista</b>:<br />
<?
while($artista=$db->sql_fetchrow($qCitasArtista)){
	echo " - " . $artista["nombre"] . ": " . $artista["citas"] . "<br />\n";
}
?>

