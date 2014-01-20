<?
$strQuery = "SELECT concat(p.nombre,' ',p.apellido) as 'Programador', concat(p.pais,'/',p.ciudad) as 'País / Ciudad', m.nombre as 'Mercado',m.fecha_inicio as 'Inicio', m.fecha_final as 'Fin',m.id as id_mercado,p.id 
	FROM mercado_promotores mp
	LEFT JOIN mercados m ON m.id=mp.id_mercado
	LEFT JOIN promotores p ON p.id=mp.id_promotor
	WHERE p.nombre IS NOT NULL AND m.nombre IS NOT NULL
	ORDER BY 2";

$qid=$db->sql_query($strQuery);
$mercados = $artistas = $counts = $total =array();
while($result=$db->sql_fetchrow($qid)){
	$string = "<tr>";
	for($i=0;$i<5;$i++) 
	{
		$dato = "&nbsp;";
		if($result[$i] != "")
				$dato = $result[$i];
		$string.= "<td>" . $dato . "</td>";
	}
	$string.= "</tr>\n";
	$counts[$result["id_mercado"]][] = $string;
	$mercados[$result["id_mercado"]] = $result["Mercado"];
	$total[$result["id"]][] = $string;
	$artistas[]=$string;
}

?>
<table width="100%" border="1">
<?
	echo "<tr><td colspan=8><b>Total Promotores Participantes : </b>".count($total)."</td></tr>";
	echo "<tr><td colspan=8><b>MERCADOS</b></td></tr>";
	$i=0;
	foreach($counts as $key => $num)
	{
		if($i==0)
			echo "<tr>";
		echo "<td><b>".$mercados[$key]." : </b>".count($num)."</td>";
	
		$i++;$j++;	
		if($i==5 || $j==count($counts))
		{
			$i=0;
			echo "</tr>";
		}
	}
?>
	<tr>
		<?
		for($i=0;$i<$db->sql_numfields($qid)-2;$i++) echo "<th>" . $db->sql_fieldname($i,$qid) . "</th>";
		?>
	</tr>
	<?
	foreach($artistas as $list)
	{
		echo $list;
	}	
	?>
</table>
