<?
//total artistas
$qidD = $db->sql_row("SELECT count(distinct(id_grupo_danza)) as num FROM mercado_artistas WHERE id_grupo_danza IS NOT NULL ");
$qidT = $db->sql_row("SELECT count(distinct(id_grupo_teatro)) as num FROM mercado_artistas WHERE id_grupo_teatro IS NOT NULL ");
$qidM = $db->sql_row("SELECT count(distinct(id_grupo_musica)) as num FROM mercado_artistas WHERE id_grupo_musica IS NOT NULL ");

//total programadores
$tp = $db->sql_row("SELECT count(distinct(id_promotor)) as num FROM mercado_promotores");
$tpD = $db->sql_row("SELECT count(distinct(m.id_promotor)) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE pr.id_area=1");
$tpM = $db->sql_row("SELECT count(distinct(m.id_promotor)) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE pr.id_area=2");
$tpT = $db->sql_row("SELECT count(distinct(m.id_promotor)) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE pr.id_area=3");
$tpDM = $db->sql_row("SELECT count(distinct(m.id_promotor)) as num FROM mercado_promotores m WHERE m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=2 and b.id_area=1)");
$tpTM = $db->sql_row("SELECT count(distinct(m.id_promotor)) as num FROM mercado_promotores m WHERE m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=2 and b.id_area=3)");
$tpDT = $db->sql_row("SELECT count(distinct(m.id_promotor)) as num FROM mercado_promotores m WHERE m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=1 and b.id_area=3)");
$tpDTM = $db->sql_row("SELECT count(distinct(m.id_promotor)) as num FROM mercado_promotores m WHERE m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor LEFT JOIN pr_promotores_areas c ON c.id_promotor=a.id_promotor WHERE a.id_area=1 and b.id_area=3 AND c.id_area=2)");

echo "<table width=\"100%\" border=\"1\">";
echo "<tr><th colspan=3 align='left'>Cifras Totales</th></tr>";
$tot = $qidD["num"]+$qidT["num"]+$qidM["num"];
echo "<tr><td valign='top'>
	<b>Total Artistas Participantes : </b>".$tot."<br />
	Total Danza: ".$qidD["num"]."<br />
	Total Teatro: ".$qidT["num"]."<br />
	Total Música: ".$qidM["num"]."</td>";
echo "<td>
	<b>Total Programadores Participantes : </b>".$tp["num"]."<br />
	Total Danza: ".$tpD["num"]."<br />
	Total Teatro: ".$tpT["num"]."<br />
	Total Música: ".$tpM["num"]."<br />
	Total Danza y Música: ".$tpDM["num"]."<br />
	Total Teatro y Música: ".$tpTM["num"]."<br />
	Total Danza y Teatro: ".$tpDT["num"]."<br />
	Total Danza, Teatro y Música: ".$tpDTM["num"]."</td>";

//citas
$ci = $db->sql_row("SELECT COUNT(*) AS num FROM citas");
echo "<td valign='top'><b>Total Citas Programadas : </b>".$ci["num"]."</td></tr>";
echo "<tr><th colspan=3 align='left'>Cifras por Mercados</th></tr>";

$mer=array();
$strQuery = $db->sql_query("SELECT *, extract(year from fecha_inicio) as anio FROM mercados ORDER BY fecha_inicio");
while($qmer = $db->sql_fetchrow($strQuery))
{
	$mer[$qmer["anio"]][$qmer["id"]]["nombre"]=$qmer["nombre"];
	$mer[$qmer["anio"]][$qmer["id"]]["fecha"]=$qmer["fecha_inicio"]." / ".$qmer["fecha_final"];

	//total promotores
	$tp = $db->sql_row("SELECT count(*) as num FROM mercado_promotores WHERE id_mercado=".$qmer["id"]);
	$mer[$qmer["anio"]][$qmer["id"]]["numProm"] = $tp["num"];
	$tpD = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE m.id_mercado=".$qmer["id"]." AND pr.id_area=1");
	$mer[$qmer["anio"]][$qmer["id"]]["numProDz"] = $tpD["num"];
	$tpM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE m.id_mercado=".$qmer["id"]." AND pr.id_area=2");
	$mer[$qmer["anio"]][$qmer["id"]]["numProMus"] = $tpM["num"];
	$tpT = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m LEFT JOIN pr_promotores_areas pr ON pr.id_promotor=m.id_promotor WHERE m.id_mercado=".$qmer["id"]." AND pr.id_area=3");
	$mer[$qmer["anio"]][$qmer["id"]]["numProTea"] = $tpT["num"];
	$tpDM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=2 and b.id_area=1)");
	$mer[$qmer["anio"]][$qmer["id"]]["numProDzMs"] = $tpDM["num"];
	$tpTM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=2 and b.id_area=3)");
	$mer[$qmer["anio"]][$qmer["id"]]["numProTeaMs"] = $tpTM["num"];
	$tpDT = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor WHERE a.id_area=1 and b.id_area=3)");
	$mer[$qmer["anio"]][$qmer["id"]]["numProDzTea"] = $tpDT["num"];
	$tpDTM = $db->sql_row("SELECT count(m.id) as num FROM mercado_promotores m WHERE m.id_mercado=".$qmer["id"]." AND m.id_promotor IN (SELECT distinct(a.id_promotor) FROM pr_promotores_areas a LEFT JOIN pr_promotores_areas b on b.id_promotor=a.id_promotor LEFT JOIN pr_promotores_areas c ON c.id_promotor=a.id_promotor WHERE a.id_area=1 and b.id_area=3 AND c.id_area=2)");
	$mer[$qmer["anio"]][$qmer["id"]]["numProDzTeaMus"] = $tpDTM["num"];

	//total artistas
	$qidD = $db->sql_row("SELECT count(id) as num FROM mercado_artistas WHERE id_mercado=".$qmer["id"]." AND id_grupo_danza IS NOT NULL ");
	$mer[$qmer["anio"]][$qmer["id"]]["numArDz"] = $qidD["num"];
	$qidT = $db->sql_row("SELECT count(id) as num FROM mercado_artistas WHERE id_mercado=".$qmer["id"]." AND id_grupo_teatro IS NOT NULL ");
	$mer[$qmer["anio"]][$qmer["id"]]["numArTea"] = $qidT["num"];
	$qidM = $db->sql_row("SELECT count(id) as num FROM mercado_artistas WHERE id_mercado=".$qmer["id"]." AND id_grupo_musica IS NOT NULL ");
	$mer[$qmer["anio"]][$qmer["id"]]["numArMus"] = $qidM["num"];

	$qNumCitasxSs= $db->sql_row("SELECT COUNT(*) AS num 
		FROM citas c 
		LEFT JOIN sesiones s ON c.id_sesion=s.id
		LEFT JOIN ruedas r ON s.id_rueda=r.id
		WHERE r.id_mercado='".$qmer["id"]."'");
	$mer[$qmer["anio"]][$qmer["id"]]["citas"]=$qNumCitasxSs["num"];
}

foreach($mer as $anio => $listXAnio)
{
	echo "<tr><th colspan=3 align='left'>".$anio."</th></tr>";
	$i=$j=0;
	foreach($listXAnio as $me)
	{
		if($i==0)
			echo "<tr>";

		$totArt = $me["numArDz"]+$me["numArTea"]+$me["numArMus"];
		echo "<td><b>".$me["nombre"]."</b><br />
			Fecha: ".$me["fecha"]."</b><br /><br />
			<b>Total Artistas: </b>".$totArt."<br />
			Total Danza: ".$me["numArDz"]."<br />
			Total Teatro: ".$me["numArTea"]."<br />
			Total Música: ".$me["numArMus"]."<br /><br />
			<b>Total Programadores : </b>".$me["numProm"]."<br />
			Total Danza: ".$me["numProDz"]."<br />
			Total Teatro: ".$me["numProTea"]."<br />
			Total Música: ".$me["numProMus"]."<br />
			Total Danza y Música: ".$me["numProDzMs"]."<br />
			Total Teatro y Música: ".$me["numProTeaMs"]."<br />
			Total Danza y Teatro: ".$me["numProDzTea"]."<br />
			Total Danza, Teatro y Música: ".$me["numProDzTeaMus"]."<br /><br />
			<b>No. Citas: </b>".$me["citas"]."</td>";
	
		$i++;$j++;
		if($i==3 || $j==count($me))
		{
			echo "</tr>";
			$i=0;
		}
	}
}
echo "</table>";
?>
