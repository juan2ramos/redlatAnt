<?
$strQuery="
SELECT 
	gr.nombre as 'Agrupación', gr.contacto as 'Representante', 'X' as 'D', '' as 'T', '' as 'M',
	CONCAT(p.pais,' / ',gr.ciudad) as 'País / Ciudad', gr.telefono as 'Teléfono 1', gr.telefono2 as 'Teléfono 2',
	gr.website as 'web'
FROM grupos_danza gr LEFT JOIN paises p ON gr.id_pais=p.id
UNION
SELECT 
	gr.nombre as 'Agrupación', gr.contacto as 'Representante', '' as 'D', 'X' as 'T', '' as 'M',
	CONCAT(p.pais,' / ',gr.ciudad) as 'País / Ciudad', gr.telefono as 'Teléfono 1', gr.telefono2 as 'Teléfono 2',
	gr.website as 'web'
FROM grupos_teatro gr LEFT JOIN paises p ON gr.id_pais=p.id
UNION
SELECT 
	gr.nombre as 'Agrupación', gr.contacto as 'Representante', '' as 'D', '' as 'T', 'X' as 'M',
	CONCAT(p.pais,' / ',gr.ciudad) as 'País / Ciudad', gr.telefono as 'Teléfono 1', gr.telefono2 as 'Teléfono 2',
	gr.website as 'web'
FROM grupos_musica gr LEFT JOIN paises p ON gr.id_pais=p.id
ORDER BY 1
";
$qid=$db->sql_query($strQuery);
?>
<table width="100%" border="1">
	<tr>
		<?
		for($i=0;$i<$db->sql_numfields($qid);$i++) echo "<th>" . $db->sql_fieldname($i,$qid) . "</th>";
		?>
	</tr>
	<?
	while($result=$db->sql_fetchrow($qid)){
		echo "<tr>";
		for($i=0;$i<$db->sql_numfields($qid);$i++) 
		{
			$dato = "&nbsp;";
			if($result[$i] != "")
				  $dato = $result[$i];
			echo "<td>" . $dato . "</td>";
		}
		echo "</tr>\n";
	}
	?>
</table>

