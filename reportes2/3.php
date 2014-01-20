<?
$strQuery="
SELECT 
	emp.id, emp.empresa as 'Organización',
	(
	 SELECT GROUP_CONCAT(CONCAT(pr.nombre,' ',pr.apellido) SEPARATOR ' /<br> ') 
	 FROM empresas_promotores ep LEFT JOIN promotores pr ON ep.id_promotor=pr.id 
	 WHERE ep.id_empresa=emp.id GROUP BY ep.id_empresa
	) AS 'Promotor',
	(
	 SELECT GROUP_CONCAT(ers.nombre SEPARATOR ' /<br> ') 
	 FROM empresas_razones er LEFT JOIN emp_razon_social ers ON er.id_emp_razon_social=ers.id 
	 WHERE er.id_empresa=emp.id GROUP BY er.id_empresa
	) AS 'Actividad',
	CONCAT(emp.pais,' / ',emp.ciudad) as 'País / Ciudad',
	emp.email as 'Email', emp.telefono as 'Teléfono 1', emp.telefono2 as 'Teléfono 2', emp.web as 'Web'
FROM empresas emp
ORDER BY emp.empresa
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

