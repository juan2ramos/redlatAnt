<?
/*	Reporte 3: Citas por sesi�n	*/
if(!isset($frm["id_mercado"])) die("No viene el identificador del mercado");
$strSQL="
SELECT 
r.nombre AS 'Sesi�n',
COUNT(*) AS 'N�mero de citas programadas'
FROM citas c LEFT JOIN sesiones s ON c.id_sesion=s.id
 LEFT JOIN ruedas r ON s.id_rueda=r.id
WHERE r.id_mercado='$frm[id_mercado]'
GROUP BY c.id_sesion
";
?>
