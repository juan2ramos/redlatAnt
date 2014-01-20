<?
$strQuery="
SELECT 
	CONCAT(TRIM(pr.pais),' / ',TRIM(pr.ciudad)) as 'País / Ciudad',
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='1' LIMIT 1) AS 'D',
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='2' LIMIT 1) AS 'M',
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='3' LIMIT 1) AS 'T',
	CONCAT(pr.nombre, ' ', pr.apellido) as 'Nombre',
	(
	 SELECT GROUP_CONCAT(emp.empresa SEPARATOR ' / ') 
	 FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id 
	 WHERE ep.id_promotor=pr.id GROUP BY ep.id_promotor
	) AS 'Organización',
	pr.cargo as 'Cargo', 
	(
	 SELECT GROUP_CONCAT(t.nombre SEPARATOR ' / ') 
	 FROM pr_promotores_tareas pt LEFT JOIN pr_tareas t ON pt.id_tarea=t.id 
	 WHERE pt.id_promotor=pr.id GROUP BY pt.id_promotor
	) AS 'Actividad',
	pr.email1 as 'Email', pr.telefono1 as 'Teléfono', pr.web
FROM promotores pr
ORDER BY 1,5
";
$qid=$db->sql_query($strQuery);
?>
<table width="100%" border="1">
	<tr>
		<?
		for($i=1;$i<$db->sql_numfields($qid);$i++) echo "<th>" . $db->sql_fieldname($i,$qid) . "</th>";
		?>
	</tr>
	<?
	$cont=0;
	$string="";
	$ciudad_anterior="";
	$str1="áéíóú";
	$str2="aeiou";
	while($result=$db->sql_fetchrow($qid)){
		$result[0]=trim($result[0]);
		if($cont!=0 && strtr(strtolower($ciudad_anterior),$str1,$str2)!=strtr(strtolower($result[0]),$str1,$str2)){
			echo "<tr><td colspan=\"5\"><table width=\"100%\"><tr><td>" . $ciudad_anterior . "</td><td align=\"right\">Programadores: " . $cont . "</td></tr></table></td></tr>\n" . $string;
			$string="";
			$cont=0;
		}
		$string.="<tr>";
		for($i=1;$i<$db->sql_numfields($qid);$i++)
		{
			$dato = "&nbsp;";
			if($result[$i] != "")
			  $dato = $result[$i];
			$string.= "<td>" . $dato . "</td>";
		}
		$string.="</tr>\n";
		$ciudad_anterior=$result[0];
		$cont++;
	}
	?>
</table>

