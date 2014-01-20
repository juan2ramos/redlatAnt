<?
$strQuery="
SELECT 
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='1' LIMIT 1) AS 'D',
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='2' LIMIT 1) AS 'M',
	(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='3' LIMIT 1) AS 'T',
	CONCAT(pr.pais,' / ',pr.ciudad) as 'País / Ciudad',
	CONCAT(pr.nombre, ' ', pr.apellido) as 'Nombre',
	(
	 SELECT GROUP_CONCAT(emp.empresa SEPARATOR ' / ') 
	 FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id 
	 WHERE ep.id_promotor=pr.id GROUP BY ep.id_promotor
	) AS 'Organización',
	(
	 SELECT GROUP_CONCAT(t.nombre SEPARATOR ' /<br>') 
	 FROM pr_promotores_tareas pt LEFT JOIN pr_tareas t ON pt.id_tarea=t.id 
	 WHERE pt.id_promotor=pr.id GROUP BY pt.id_promotor
	 ORDER BY t.nombre
	) AS 'Actividad',
	pr.cargo as 'Cargo', 
	pr.email1 as 'Email', pr.telefono1 as 'Teléfono', pr.web
FROM promotores pr
ORDER BY 4
";
$qid=$db->sql_query($strQuery);
?>
<table width="100%" border="1">
	<?
	$string="";
	$arrTotal[""]=0;
	while($result=$db->sql_fetchrow($qid)){
		$arrayPos=array();
		if(!isset($arrTotal[$result[6]])) $arrTotal[$result[6]]=1;
		else $arrTotal[$result[6]]++;
		$string.="<tr>";
		for($i=0;$i<$db->sql_numfields($qid);$i++) 
		{
			$dato="&nbsp;";
			if($result[$i]!="")
				$dato=$result[$i];
			$string.="<td>" . $dato . "</td>";

		}
		$string.="</tr>\n";
	}
	?>
	<tr>
		<td colspan="11">
			<table border="1">
					<?
					$i=0;
					foreach($arrTotal AS $key=>$val){
						if($i%11==0) echo "<tr>";
						echo "<td>" . $key . ": <b>" . $val . "</b></td>";
						$i++;
						if($i%11==0) echo "</tr>\n";
					}
					?>
			</table>
		</td>
	</tr>
	<tr>
		<?
		for($i=0;$i<$db->sql_numfields($qid);$i++) echo "<th>" . $db->sql_fieldname($i,$qid) . "</th>";
		?>
	</tr>
	<?echo $string?>
</table>
<?
?>
