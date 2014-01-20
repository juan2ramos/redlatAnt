<?
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado.");
$id_mercado=$frm["id_mercado"];
$qMercado=$db->sql_query("SELECT * FROM mercados WHERE id='$id_mercado'");
$mercado=$db->sql_fetchrow($qMercado);
$qPromotores=$db->sql_query("
	SELECT prom.id, prom.nombre, prom.apellido
	FROM mercado_promotores mp 
		LEFT JOIN promotores prom ON mp.id_promotor=prom.id
	WHERE mp.id_mercado='$id_mercado'
");






?>
<h1><?=$mercado["nombre"]?></h1>

<b>Listado de grupos que consideraría contratar el promotor</b>: <br />
<?
while($promotor=$db->sql_fetchrow($qPromotores)){
	echo "<b> - " . $promotor["nombre"] . " " . $promotor["apellido"] . ": </b><br />\n";
	$qGrupos=$db->sql_query("
		SELECT CASE WHEN c.id_grupo_musica IS NOT NULL THEN gm.nombre WHEN c.id_grupo_danza IS NOT NULL THEN gd.nombre ELSE gt.nombre END as nombre
		FROM eval_cita_promotor ecp LEFT JOIN citas c ON ecp.id_cita=c.id
			LEFT JOIN sesiones s ON c.id_sesion=s.id
			LEFT JOIN ruedas r ON s.id_rueda=r.id
			LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
			LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
			LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
		WHERE c.id_promotor='$promotor[id]' AND r.id_mercado='$id_mercado' AND ecp.consideracion_contrato='1' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1'
	");
	while($grupo=$db->sql_fetchrow($qGrupos)){
		if($grupo["nombre"]!="") echo " - - " . $grupo["nombre"] . "<br />\n";
	}
}
?>
