<?
	$command="/usr/bin/tail -n 1 /tmp/redlat";
	$result=trim(exec($command));
//	$result="30000/5000/8000/vguzman@apli-k.com";
//	print_r($result);
	if(preg_match("/^([0-9]*)\/([0-9]*)\/([0-9]*)\/([0-9]*)\/(.*)$/",$result,$myMatches)){
		require_once(dirname(__FILE__) . "/../application.php");
		$urlMonitoreo=$CFG->admin_dir . "/monitoreo.php";
		$id_envio=$myMatches[1];
		$total=$myMatches[2];
		$enviados=$myMatches[3] + 1;
		$errores=$myMatches[4];
		$estado=$myMatches[5];

		$qid=$db->sql_query("SELECT * FROM boletin_envios WHERE id='$id_envio'");
		$envio=$db->sql_fetchrow($qid);
/*
		echo "<pre>";
		print_r($envio);
		echo "</pre>";
*/
		$avance=$errores + $enviados;
		@$enviadosPC=round($enviados*100/$total) + 1;
		@$erroresPC=round($errores*100/$total) + 1;
		@$avancePC=round($avance*100/$total) + 1;

		$tiempo_inicial=strtotime($envio["fecha"]);
		if($envio["fecha_fin"]!=""){
			$enviado="Envío terminado.";
			$tiempo_final=strtotime($envio["fecha_fin"]);
//			echo "<script>\nkaTimer=setInterval(keepAlive,100000);\nwindow.alert('VGH');\n</script>";
		}
		else{
			$enviado="Envío activo.";
			$tiempo_final=time();
		}
		$tiempo=$tiempo_final-$tiempo_inicial;
		$horas=floor($tiempo/3600);
		$minutos=floor(($tiempo-($horas*3600))/60);
		$segundos=$tiempo-($horas*3600)-($minutos*60);
		$tiempo_ejecucion=str_pad($horas, 2, "0", STR_PAD_LEFT) . ":" . str_pad($minutos, 2, "0", STR_PAD_LEFT) . ":" . str_pad($segundos, 2, "0", STR_PAD_LEFT);

?>
<table border="1">
	<tr><td colspan="4">Envío: <?=$envio["subject"]?></td></tr>
	<tr><td colspan="4"><?=$enviado?></td></tr>
	<tr><td colspan="4">Tiempo de ejecución: <?=$tiempo_ejecucion?></td></tr>
	<tr>
		<td style="height:100" valign="bottom" align="center" width="100">
			<div style="background-color:yellow; width:50; height:100; overflow: hidden;"></div>
		</td>
		<td style="height:100" valign="bottom" align="center" width="100">
			<div style="background-color:0000ff; width:50; height:<?=$avancePC?>; overflow: hidden;"></div>
		</td>
		<td style="height:100" valign="bottom" align="center" width="100">
			<div style="background-color:00ff00; width:50; height:<?=$enviadosPC?>; overflow: hidden;"></div>
		</td>
		<td style="height:100" valign="bottom" align="center" width="100">
			<div style="background-color:ff0000; width:50; height:<?=$erroresPC?>; overflow: hidden;"></div>
		</td>
	</tr>
	<tr>
		<td align="center">Total</td>
		<td align="center">Procesados</td>
		<td align="center">Enviados</td>
		<td align="center">Errores</td>
	</tr>
	<tr>
		<td align="center"><?=$total?></td>
		<td align="center"><?=$avance?></td>
		<td align="center"><?=$enviados?></td>
		<td align="center"><?=$errores?></td>
	</tr>
	<tr><td colspan="4">Estado actual:<br><?=$estado?></td></tr>
<?if($envio["fecha_fin"]==""){?>
	<tr><td colspan="4"><input type="button" value="Cancelar Envío" onClick="window.location.href='<?=$urlMonitoreo?>?cancel=1'"></td></tr>
<?}?>
</table>
<?
	}
	else echo "Error";
?>

