<?
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado.");
$id_mercado=$frm["id_mercado"];
$qMercado=$db->sql_query("SELECT * FROM mercados WHERE id='$id_mercado'");
$mercado=$db->sql_fetchrow($qMercado);

$qCitasDetalle=$db->sql_query("
	SELECT c.*, CASE WHEN c.id_grupo_musica IS NOT NULL THEN gm.nombre WHEN c.id_grupo_danza IS NOT NULL THEN gd.nombre ELSE gt.nombre END as grupo,
		CONCAT(prom.nombre, ' ', prom.apellido) as promotor
	FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
		LEFT JOIN ruedas r ON s.id_rueda=r.id
		LEFT JOIN grupos_musica gm ON c.id_grupo_musica=gm.id
		LEFT JOIN grupos_danza gd ON c.id_grupo_danza=gd.id
		LEFT JOIN grupos_teatro gt ON c.id_grupo_teatro=gt.id
		LEFT JOIN promotores prom ON c.id_promotor=prom.id
	WHERE r.id_mercado='$id_mercado' AND c.aceptada_grupo='1' AND c.aceptada_promotor='1'
	ORDER BY c.id_sesion, c.fecha_inicial
");



?>
<h1><?=$mercado["nombre"]?></h1>

<b>Listado de citas por sesión </b>:<br />
<?
$sesion_anterior=0;
$numSesion=0;
while($cita=$db->sql_fetchrow($qCitasDetalle)){
	if($sesion_anterior!=$cita["id_sesion"]){
		$numSesion++;
		echo "<b> - Sesión # $numSesion</b> <br />\n" ;
	}
	echo " - - " . date("H:i",strtotime($cita["fecha_inicial"])) . " " . $cita["promotor"] . " :: " . $cita["grupo"] . "<br />\n";
	$sesion_anterior=$cita["id_sesion"];
}
?>

