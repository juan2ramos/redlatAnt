<?
$mer=array();
$strQuery = $db->sql_query("SELECT id, nombre FROM mercados ORDER BY fecha_inicio");
while($qmer = $db->sql_fetchrow($strQuery))
{
	$mer[$qmer["id"]]["nombre"]=$qmer["nombre"];
	$rd = $db->sql_query("SELECT * FROM ruedas WHERE id_mercado=".$qmer["id"]);
	while($qrd = $db->sql_fetchrow($rd))
	{
		$ss = $db->sql_query("SELECT * FROM sesiones WHERE id_rueda=".$qrd["id"]);
		while($qss = $db->sql_fetchrow($ss))
		{
			$mer[$qmer["id"]]["ruedas"][$qrd["nombre"]][] = array("ini"=>$qss["fecha_inicial"],"fin"=>$qss["fecha_final"],"lug"=>$qss["lugar"]);
		}
	}

	//total promotores
	$tp = $db->sql_row("SELECT count(*) as num FROM mercado_promotores WHERE id_mercado=".$qmer["id"]);
	$mer[$qmer["id"]]["numProm"] = $tp["num"];
	$tpD = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE m.id_mercado=".$qmer["id"]." AND pr.id_area=1");
	$mer[$qmer["id"]]["numProDz"] = $tpD["num"];
	$tpM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE m.id_mercado=".$qmer["id"]." AND pr.id_area=2");
	$mer[$qmer["id"]]["numProMus"] = $tpM["num"];
	$tpT = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE m.id_mercado=".$qmer["id"]." AND pr.id_area=3");
	$mer[$qmer["id"]]["numProTea"] = $tpT["num"];
	$tpDM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE m.id_mercado=".$qmer["id"]." AND pr.id_area=1 AND pr.id_area=2");
	$tpDM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=2 and b.id_area=1)");
	$mer[$qmer["id"]]["numProDzMs"] = $tpDM["num"];
	$tpTM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=2 and b.id_area=3)");
	$mer[$qmer["id"]]["numProTeaMs"] = $tpTM["num"];
	$tpDT = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=1 and b.id_area=3)");
	$mer[$qmer["id"]]["numProDzTea"] = $tpDT["num"];
	$tpDTM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor LEFT JOIN pr_promotores_areas c ON c.id_promotor=a.id_promotor WHERE a.id_area=1 and b.id_area=3 AND c.id_area=2)");
	$mer[$qmer["id"]]["numProDzTeaMus"] = $tpDTM["num"];

	//total artistas
	$qidD = $db->sql_row("SELECT count(id) as num FROM mercado_artistas WHERE id_mercado=".$qmer["id"]." AND id_grupo_danza IS NOT NULL ");
	$mer[$qmer["id"]]["numArDz"] = $qidD["num"];
	$qidT = $db->sql_row("SELECT count(id) as num FROM mercado_artistas WHERE id_mercado=".$qmer["id"]." AND id_grupo_teatro IS NOT NULL ");
	$mer[$qmer["id"]]["numArTea"] = $qidT["num"];
	$qidM = $db->sql_row("SELECT count(id) as num FROM mercado_artistas WHERE id_mercado=".$qmer["id"]." AND id_grupo_musica IS NOT NULL ");
	$mer[$qmer["id"]]["numArMus"] = $qidM["num"];

	$qNumCitasxSs= $db->sql_query("SELECT r.nombre , COUNT(*) AS num 
		FROM citas c 
		LEFT JOIN sesiones s ON c.id_sesion=s.id
		LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='".$qmer["id"]."'
		GROUP BY c.id_sesion");
	$total = 0;
	while($nxss = $db->sql_fetchrow($qNumCitasxSs))
	{
		$mer[$qmer["id"]]["citas"][]=$nxss["nombre"].":".$nxss["num"];
		$total+=$nxss["num"];
	}
	$mer[$qmer["id"]]["totalCitas"]=$total;
	$prom = array();

	$cons="
		SELECT 
		(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='1' LIMIT 1) AS 'D',
		(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='3' LIMIT 1) AS 'T',
		(SELECT 'X' FROM pr_promotores_areas WHERE id_promotor=pr.id AND id_area='2' LIMIT 1) AS 'M',
		CONCAT(pr.nombre, ' ', pr.apellido) as 'Nombre',
			(SELECT GROUP_CONCAT(emp.empresa SEPARATOR ' / ') 
		 	FROM empresas_promotores ep LEFT JOIN empresas emp ON ep.id_empresa=emp.id 
			WHERE ep.id_promotor=pr.id GROUP BY ep.id_promotor
			) AS 'Organización', m.mesa,
 			(
				SELECT COUNT(*) 
				FROM citas c 
				WHERE c.id_promotor=pr.id AND c.id_sesion IN (SELECT s.id FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=".$qmer["id"].")
			) as citas,
		CONCAT(CASE WHEN pr.pais IS NULL THEN '' ELSE pr.pais END,' / ',pr.ciudad) as pais
		FROM mercado_promotores m
		LEFT JOIN promotores pr ON pr.id=m.id_promotor
		WHERE m.id_mercado=".$qmer["id"]." AND pr.nombre IS NOT NULL
		ORDER BY pais";
	$qidPrm = $db->sql_query($cons);
	while($result = $db->sql_fetchrow($qidPrm))
	{
		$string = "<tr>";
		for($i=0;$i<7;$i++) 
		{
			$dato = "&nbsp;";
			if($result[$i] != "")
					$dato = $result[$i];
			$string.= "<td>" . $dato . "</td>";
		}
		$string.= "</tr>\n";
		$prom[$result["pais"]][] = $string;
	}
	$mer[$qmer["id"]]["prom"]=$prom;


	$artistas=array();
	$cons = "SELECT * FROM (
			SELECT 'X' as 'D', '' as 'T', '' as 'M',gr.nombre, m.mesa, (SELECT COUNT(*) FROM citas c WHERE c.id_grupo_danza=gr.id AND c.id_sesion IN (SELECT s.id FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=".$qmer["id"].")) as citas, 'danza' as tipo,CONCAT(p.pais,' / ',gr.ciudad) as pais
			FROM mercado_artistas m 
			LEFT JOIN grupos_danza gr ON gr.id=m.id_grupo_danza
			LEFT JOIN paises p ON gr.id_pais=p.id
			WHERE m.id_mercado=".$qmer["id"]." AND gr.nombre IS NOT NULL
			UNION
			SELECT '' as 'D', 'X' as 'T', '' as 'M', gr.nombre, m.mesa, (SELECT COUNT(*) FROM citas c WHERE c.id_grupo_teatro=gr.id AND c.id_sesion IN (SELECT s.id FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=".$qmer["id"].")) as citas,'teatro' as tipo, CONCAT(p.pais,' / ',gr.ciudad) as pais
			FROM mercado_artistas m
			LEFT JOIN grupos_teatro gr ON gr.id=m.id_grupo_teatro
			LEFT JOIN paises p ON gr.id_pais=p.id
			WHERE m.id_mercado=".$qmer["id"]." AND gr.nombre IS NOT NULL
			UNION
			SELECT '' as 'D', '' as 'T', 'X' as 'M', gr.nombre, m.mesa, (SELECT COUNT(*) FROM citas c WHERE c.id_grupo_musica=gr.id AND c.id_sesion IN (SELECT s.id FROM sesiones s LEFT JOIN ruedas r ON s.id_rueda=r.id WHERE r.id_mercado=".$qmer["id"].")) as citas, 'musica' as tipo, CONCAT(p.pais,' / ',gr.ciudad) as pais
			FROM mercado_artistas m 
			LEFT JOIN grupos_musica gr ON gr.id=m.id_grupo_musica
			LEFT JOIN paises p ON gr.id_pais=p.id
			WHERE m.id_mercado=".$qmer["id"]." AND gr.nombre IS NOT NULL
			) AS foo
		ORDER BY pais,tipo";
	$qart = $db->sql_query($cons);
	while($result = $db->sql_fetchrow($qart))
	{
		$string = "<tr>";
		for($i=0;$i<6;$i++) 
		{
			$dato = "&nbsp;";
			if($result[$i] != "")
					$dato = $result[$i];
			$string.= "<td>" . $dato . "</td>";
		}
		$string.= "</tr>\n";
		$artistas[$result["pais"]][] = $string;
	}
	$mer[$qmer["id"]]["artistas"] = $artistas;
}

foreach($mer as $idMer => $mercado)
{
	echo "<table width=\"100%\" border=\"1\">";
	echo "<tr><th colspan=2>".$mercado["nombre"]."</th></tr>";
	echo "<tr><td valign=\"top\"><table width=\"100%\" border=\"1\">\n
	<tr><td><b>Rueda</b></td><td><b>Fecha Inicio</b></td><td><b>Fecha Fin</b></td><td><b>Lugar</b></td></tr>\n";
	if(isset($mercado["ruedas"]))
	{
		foreach($mercado["ruedas"] as $nm => $rd)
		{
			foreach($rd as $dia => $ss)
			{
					echo "<tr><td>".$nm."</td>";
					echo "<td>".$ss["ini"]."</td>";
					echo "<td>".$ss["fin"]."</td>";
					echo "<td>".$ss["lug"]."</td></tr>\n";
			}
		}
	}
	echo "</table></td>";
	echo "<td valign=\"top\"><table width=\"100%\" border=\"1\">\n
	<tr><td><b>Total Programadores</b></td><td><b>Total Artistas</b></td><td><b>Citas Programadas</b></td></tr>\n";
	echo "<tr>";
	echo "<td valign=\"top\">Total : ".$mercado["numProm"]."<br />
	Danza : ".$mercado["numProDz"]."<br />
	Teatro : ".$mercado["numProTea"]."<br />
	Música : ".$mercado["numProMus"]."<br />
	Danza/Teatro : ".$mercado["numProDzTea"]."<br />
	Danza/Música : ".$mercado["numProDzMs"]."<br />
	Teatro/Música : ".$mercado["numProTeaMs"]."<br />
	Danza/Teatro/Música : ".$mercado["numProDzTeaMus"]."</td>";
	$tot = $mercado["numArDz"]+$mercado["numArTea"]+$mercado["numArMus"];
	echo "<td valign=\"top\">Total : ".$tot."<br />
	Danza : ".$mercado["numArDz"]."<br />
	Teatro : ".$mercado["numArTea"]."<br />
	Música : ".$mercado["numArMus"]."</td>";
	echo "<td valign=\"top\">Total : ".$mercado["totalCitas"]."<br />";
	if(isset($mercado["citas"]))
		echo implode("<br />",$mercado["citas"]);
	echo "</td></tr>";
	echo "</table></td></tr>";

	//promotores
	echo "<tr><td colspan=2><b>Programadores : ".$mercado["numProm"]."</b></td></tr>";
	echo "<tr><td colspan=2><table border=\"1\">\n";
	echo "<tr><td><b>D</b></td><td><b>T</b></td><td><b>M</b></td><td><b>Nombre</b></td><td><b>Organizacion</b></td><td><b>No. Mesa</b></td><td><b>Citas Programadas</b></td></tr>";
	foreach($mercado["prom"] as $ciudad => $ar )
	{
		echo "<tr><td colspan=7><b>".$ciudad." , Programadores : </b>".count($ar)."</td></tr>";
		echo implode("\n",$ar);
	
	}
	echo "</table></td></tr>";



	//artistas
	echo "<tr><td colspan=2><b>Artistas : ".$tot."</b></td></tr>";
	echo "<tr><td colspan=2><table border=\"1\">\n";
	echo "<tr><td><b>D</b></td><td><b>T</b></td><td><b>M</b></td><td><b>Agrupación</b></td><td><b>No. Mesa</b></td><td><b>Citas Programadas</b></td></tr>";
	foreach($mercado["artistas"] as $ciudad => $ar )
	{
		echo "<tr><td colspan=6><b>".$ciudad." , Artistas : </b>".count($ar)."</td></tr>";
		echo implode("\n",$ar);
	
	}
	echo "</table></td></tr>";
	echo "</table><br /><br /><br /><br />";
}
?>
