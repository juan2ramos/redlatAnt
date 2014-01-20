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
	$arrTotal["Danza"]=0;
	$arrTotal["Música"]=0;
	$arrTotal["Teatro"]=0;
	while($result=$db->sql_fetchrow($qid)){
		$arrayPos=array();
		if($result[0]=="X") array_push($arrayPos,'Danza');
		if($result[1]=="X") array_push($arrayPos,'Música');
		if($result[2]=="X") array_push($arrayPos,'Teatro');
		if(!isset($arrTotal[implode(" / ",$arrayPos)])) $arrTotal[implode(" / ",$arrayPos)]=1;
		else $arrTotal[implode(" / ",$arrayPos)]++;
		$string.="<tr>";
		for($i=0;$i<$db->sql_numfields($qid);$i++) 
		{
			$dato="&nbsp;";
			if($result[$i] != "")
				$dato=$result[$i];
			$string.="<td>" . $dato . "</td>";

		}
		$string.="</tr>\n";
	}
	?>
	<tr>
		<td colspan="10">
			<table border="1">
				<tr>
					<?
					$i=0;
					foreach($arrTotal AS $key=>$val){
						if($i%3==0) echo "<td valign=\"top\">";
						echo $key . ": <b>" . $val . "</b><br>";
						$i++;
						if($i%3==0) echo "</td>\n";
					}
					if($i%3!=0) echo "</td>\n";
					?>
				</tr>
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
