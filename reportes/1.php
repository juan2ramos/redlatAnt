<?
/*	Reporte 1: Mercados resumen	*/
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado");
$strSQL="
SELECT 
COUNT(8) AS 'Número de citas programadas',
SUM(CASE WHEN c.aceptada_promotor='1' AND c.aceptada_grupo='1' THEN '1' ELSE '0' END) AS 'Número de citas exitosas',
SUM(CASE WHEN c.aceptada_promotor='0' OR c.aceptada_grupo='0' THEN '1' ELSE '0' END) AS 'Número de citas incumplidas'
FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
 LEFT JOIN ruedas r ON s.id_rueda=r.id
WHERE r.id_mercado='$frm[id_mercado]'
";
?>
