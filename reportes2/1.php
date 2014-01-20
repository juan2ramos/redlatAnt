<?
$strQuery="
SELECT 
	pr.id, CONCAT(pr.nombre, ' ', pr.apellido) as 'Nombre',
	(
	 SELECT GROUP_CONCAT(emp.empresa SEPARATOR ' / ') 
	 FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id 
	 WHERE ep.id_promotor=pr.id GROUP BY ep.id_promotor
	) AS 'Organización',
	pr.cargo as 'Cargo', 
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='1' LIMIT 1) AS 'Danza',
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='2' LIMIT 1) AS 'Música',
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='3' LIMIT 1) AS 'Teatro',
	CONCAT(CASE WHEN pr.pais IS NULL THEN '' ELSE pr.pais END,' / ',pr.ciudad) as 'País / Ciudad',
	pr.email1 as 'Email', pr.telefono1 as 'Teléfono', pr.web
FROM promotores pr
ORDER BY pr.nombre,pr.apellido
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
