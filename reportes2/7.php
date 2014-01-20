<?
$strQuery="
SELECT * FROM (
SELECT 
	gr.nombre as 'Agrupación', gr.contacto as 'Representante', 'X' as 'D', '' as 'T', '' as 'M',
	CONCAT(p.pais,' / ',gr.ciudad) as 'País / Ciudad', gr.telefono as 'Teléfono 1', gr.telefono2 as 'Teléfono 2',
	gr.website as 'web', 'danza' as tipo
FROM grupos_danza gr LEFT JOIN paises p ON gr.id_pais=p.id
UNION
SELECT 
	gr.nombre as 'Agrupación', gr.contacto as 'Representante', '' as 'D', 'X' as 'T', '' as 'M',
	CONCAT(p.pais,' / ',gr.ciudad) as 'País / Ciudad', gr.telefono as 'Teléfono 1', gr.telefono2 as 'Teléfono 2',
	gr.website as 'web', 'teatro' as tipo
FROM grupos_teatro gr LEFT JOIN paises p ON gr.id_pais=p.id
UNION
SELECT 
	gr.nombre as 'Agrupación', gr.contacto as 'Representante', '' as 'D', '' as 'T', 'X' as 'M',
	CONCAT(p.pais,' / ',gr.ciudad) as 'País / Ciudad', gr.telefono as 'Teléfono 1', gr.telefono2 as 'Teléfono 2',
	gr.website as 'web', 'musica' as tipo
FROM grupos_musica gr LEFT JOIN paises p ON gr.id_pais=p.id
) AS foo
ORDER BY tipo,1";
$qid=$db->sql_query($strQuery);
?>
<table width="100%" border="1">
	<tr>
		<?
		for($i=0;$i<$db->sql_numfields($qid)-1;$i++) echo "<th>" . $db->sql_fieldname($i,$qid) . "</th>";
		?>
	</tr>
	<?
	$artistas = array();
	while($result=$db->sql_fetchrow($qid)){
		$string = "<tr>";
		for($i=0;$i<9;$i++) 
		{
			$dato = "&nbsp;";
			if($result[$i] != "")
				  $dato = $result[$i];
			$string.= "<td>" . $dato . "</td>";
		}
		$string.= "</tr>\n";
		$artistas[$result[5]][] = $string; 
	}
	ksort($artistas);

	foreach($artistas as $key => $listado)
	{
		echo "<tr><td colspan=9><b>".$key." : ".count($listado)."</b></td></tr>";
		foreach($listado as $ar)
		{
			echo $ar;
		}
	}	
	?>
</table>

