<?
require_once(dirname(__FILE__) . "/../application.php");
include("templates/header.php");
if(isset($_GET["cancel"]) && $_GET["cancel"]==1){
	$qid=$db->sql_query("SELECT * FROM boletin_envio_actual");
	$envio=$db->sql_fetchrow($qid);
	$command="/usr/bin/kill " . $envio["pid"];
	exec($command,$results,$status);
	$qUpdate=$db->sql_query("UPDATE boletin_envios SET fecha_fin=now() WHERE id='$envio[id_envio]'");
	$qDelete=$db->sql_query("DELETE FROM boletin_envio_actual");
}
?>
<script type="text/javascript">
	var req;
	var kaTimer;
	function initPage() {
		kaTimer=setInterval("keepAlive()", 10000);
	}

	function keepAlive() {
		var url = "<?=$CFG->admin_dir?>/ajax.php";
		if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
			req.onreadystatechange = processReqChange;
			req.open("GET", url, true);
			req.send(null);
		} else if (window.ActiveXObject) {
			req = new ActiveXObject("Microsoft.XMLHTTP");
			if(req){
				req.onreadystatechange = processReqChange;
				var aleatorio=Math.random();
				url=url + "?nocache="+aleatorio;
				req.open("GET", url, true);
				req.send();
			}
		}
	}

	function processReqChange() {
		if(req.readyState==4){
			if(req.status==200){
					document.getElementById('ajax').innerHTML=req.responseText;
					clearInterval(kaTimer);
					if(req.responseText.indexOf('Envío terminado.') !=-1 ) kaTimer=setInterval(keepAlive, 100000);
					else kaTimer=setInterval(keepAlive, 10000);
			}else{
				alert('Problem: [' + req.status + '] ' + req.statusText);
				clearInterval(kaTimer);
			}
			req.onreadystatechange = new function(){};
		}
	}

//	window.onload=initPage();
</script>
<div id="ajax">
	<?include(dirname(__FILE__) . "/ajax.php");?>
</div>
<script type="text/javascript">
	initPage();
</script>
