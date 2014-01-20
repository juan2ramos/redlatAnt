<?
/*	Reporte 1: Mercados resumen	*/
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado");
$strSQL="
SELECT 
mp.mesa AS 'N�mero de mesa',
COUNT(*) AS 'N�mero de citas programadas'
FROM citas c
	LEFT JOIN mercado_promotores mp ON c.id_promotor=mp.id_promotor AND mp.id_mercado='$frm[id_mercado]'
	LEFT JOIN sesiones s ON c.id_sesion=s.id
	LEFT JOIN ruedas r ON s.id_rueda=r.id
WHERE r.id_mercado='$frm[id_mercado]'
GROUP BY mp.mesa
";
?>
