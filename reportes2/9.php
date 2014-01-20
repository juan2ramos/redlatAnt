<?
$strQuery = "
	SELECT * FROM (
	SELECT '' as 'D', '' as 'T', 'X' as 'M',gr.nombre as 'Agrupación',CONCAT(p.pais,' / ',gr.ciudad) as 'Ciudad Origen',m.nombre as 'Mercado',m.fecha_inicio as 'Inicio', m.fecha_final as 'Fin', 'musica' as tipo,m.id as id_mercado,gr.id 
	FROM mercado_artistas ma
	LEFT JOIN grupos_musica gr ON gr.id=ma.id_grupo_musica
	LEFT JOIN paises p ON gr.id_pais=p.id
	LEFT JOIN mercados m ON m.id=ma.id_mercado
	WHERE gr.nombre IS NOT NULL AND m.nombre IS NOT NULL
	UNION
	SELECT 'X' as 'D', '' as 'T', '' as 'M',gr.nombre as 'Agrupación',CONCAT(p.pais,' / ',gr.ciudad) as 'Ciudad Origen',m.nombre as 'Mercado',m.fecha_inicio as 'Inicio', m.fecha_final as 'Fin', 'danza' as tipo,m.id as id_mercado,gr.id
	FROM mercado_artistas ma
	LEFT JOIN grupos_danza gr ON gr.id=ma.id_grupo_danza
	LEFT JOIN paises p ON gr.id_pais=p.id
	LEFT JOIN mercados m ON m.id=ma.id_mercado
	WHERE gr.nombre IS NOT NULL AND m.nombre IS NOT NULL
	UNION
	SELECT '' as 'D', 'X' as 'T', '' as 'M',gr.nombre as 'Agrupación',CONCAT(p.pais,' / ',gr.ciudad) as 'Ciudad Origen',m.nombre as 'Mercado',m.fecha_inicio as 'Inicio', m.fecha_final as 'Fin', 'teatro' as tipo,m.id as id_mercado,gr.id
	FROM mercado_artistas ma
	LEFT JOIN grupos_teatro gr ON gr.id=ma.id_grupo_teatro
	LEFT JOIN paises p ON gr.id_pais=p.id
	LEFT JOIN mercados m ON m.id=ma.id_mercado
	WHERE gr.nombre IS NOT NULL AND m.nombre IS NOT NULL
	) AS foo
	ORDER BY 4
	";
$qid=$db->sql_query($strQuery);
$mercados = $artistas = $counts = $danza=$teatro=$musica=array();
while($result=$db->sql_fetchrow($qid)){
	$string = "<tr>";
	for($i=0;$i<8;$i++) 
	{
		$dato = "&nbsp;";
		if($result[$i] != "")
				$dato = $result[$i];
		$string.= "<td>" . $dato . "</td>";
	}
	$string.= "</tr>\n";
	$counts[$result["id_mercado"]][] = $string;
	$mercado[$result["id_mercado"]] = $result["Mercado"];

	$artistas[]=$string;
	if($result["tipo"]=="musica")
		$musica[$result["id"]] = $string;
	elseif($result["tipo"]=="danza")
		$danza[$result["id"]] = $string;
	else
		$teatro[$result["id"]] = $string;
}

?>
<table width="100%" border="1">
<?
	$tot = count($danza)+count($teatro)+count($musica);
	echo "<tr><td colspan=8><b>Total Artistas Participantes : </b>".$tot."</td></tr>";
	echo "<tr><td colspan=8><b>Total Danza : </b>".count($danza)."</td></tr>";
	echo "<tr><td colspan=8><b>Total Teatro : </b>".count($teatro)."</td></tr>";
	echo "<tr><td colspan=8><b>Total Música : </b>".count($musica)."</td></tr>";
	echo "<tr><td colspan=8><b>MERCADOS:</b></td></tr>";
	$i=0;
	foreach($counts as $key => $num)
	{
		if($i==0)
			echo "<tr>";
		echo "<td><b>".$mercado[$key]." : </b>".count($num)."</td>";
	
		$i++;$j++;	
		if($i==8 || $j==count($counts))
		{
			$i=0;
			echo "</tr>";
		}
	}
?>
	<tr>
		<?
		for($i=0;$i<$db->sql_numfields($qid)-3;$i++) echo "<th>" . $db->sql_fieldname($i,$qid) . "</th>";
		?>
	</tr>
	<?
	foreach($artistas as $list)
	{
		echo $list;
	}	
	?>
</table>
