<?
if(!isset($_SERVER["argv"][1])) die("Error, no viene el número del envío.\n");
$id_envio=$_SERVER["argv"][1];
include("../application.php");
echo $id_envio . "/0/0/0/Inicializando...\n";
require_once($CFG->common_libdir . "/htmlMimeMail5/htmlMimeMail5.php");

class htmlMimeMail5APLK extends htmlMimeMail5{
  function addURLImage($url,$id){
    $a = file_get_contents($url);
    $imageInfo = getimagesize($url);
    $imageType = $imageInfo['mime'];
		$imageName = "imagen_" . $id;
    $this->addEmbeddedImage(new stringEmbeddedImage($a,$imageName,$imageType, new Base64Encoding()));
  }
}

$qid=$db->sql_query("SELECT * FROM boletin_envios WHERE id='$id_envio' AND fecha_fin IS NULL");
$envio=$db->sql_fetchrow($qid);
if(nvl($envio["id"])==0 || nvl($envio["id"])==""){
  echo $id_envio . "/0/0/0/Error.  No se seleccionó ningún boletín.\n";
  die();
}

echo $id_envio . "/0/0/0/Ensamblando el correo...\n";

$email=file_get_contents($envio["url"]);

$basedir=dirname($envio["url"]) . "/";
//echo $basedir . "\n";
$email=preg_replace("/ href=\"http/i"," href=\"@http",$email);
$email=preg_replace("/ href=\"([^@])([^\"]*)/i"," href=\"" . $basedir . "\$1\$2",$email);
$email=preg_replace("/ href=\"@http/i"," href=\"http",$email);

$email=preg_replace("/ src=\"http/i"," src=\"@http",$email);
$email=preg_replace("/ src=\"([^@])([^\"]*)/i"," src=\"" . $basedir . "\$1\$2",$email);
$email=preg_replace("/ src=\"@http/i"," src=\"http",$email);

if(preg_match_all("/ src=\"([^\"]*)/i",$email,$matches)){
	$arrayImages=array();
	for($i=0;$i<sizeof($matches[1]);$i++){
		if(!in_array($matches[1][$i], $arrayImages)) array_push($arrayImages,$matches[1][$i]);
	}

}

$mail2 = new htmlMimeMail5APLK();
//$mail2->setReturnPath($envio["bounce_mail"]);
$mail2->setFrom($envio["remitente_nombre"] . " <" . $envio["remitente_mail"] . ">");

$mail2->setSubject($envio["subject"]);

echo $id_envio . "/0/0/0/Insertando imágenes...\n";
for($i=0;$i<sizeof($arrayImages);$i++){
	$mail2->addURLImage($arrayImages[$i],$i);
	$email=str_replace(" src=\"" . $arrayImages[$i] . "\""," src=\"imagen_" . $i . "\"",$email);
}

$mail2->setHeader("Content-Disposition","inline");
$mail2->setHTML($email);
if($envio["areas"]=="") $envio["areas"]="0";
$strSQL="SELECT NULL as email\n";
$arrayDestinatarios=array();
if($envio["id_mercado"]!=""){//El envío es para un mercado en particular...
	// ************************************************************************************************
	if($envio["enviar_a"]==2 || $envio["enviar_a"]==3){//"Sólo promotores","Artistas y promotores"
		$strSQL.="
			UNION
			SELECT prom.email1
			FROM mercado_promotores mp LEFT JOIN promotores prom ON mp.id_promotor=prom.id
			WHERE mp.id_mercado='$envio[id_mercado]' AND mp.id_promotor IN(SELECT id_promotor FROM pr_promotores_areas WHERE id_area IN ($envio[areas]))
		";
	}
	if($envio["enviar_a"]==1 || $envio["enviar_a"]==3){//"Sólo artistas","Artistas y promotores"
		if(preg_match("/1/",$envio["areas"])){//Danza
			$strSQL.="
				UNION
				SELECT gr.email
				FROM mercado_artistas ma LEFT JOIN grupos_danza gr ON ma.id_grupo_danza=gr.id
				WHERE ma.id_mercado='$envio[id_mercado]'
			";
		}
		elseif(preg_match("/2/",$envio["areas"])){//Música
			$strSQL.="
				UNION
				SELECT gr.email
				FROM mercado_artistas ma LEFT JOIN grupos_musica gr ON ma.id_grupo_musica=gr.id
				WHERE ma.id_mercado='$envio[id_mercado]'
			";
		}
		elseif(preg_match("/3/",$envio["areas"])){//Teatro
			$strSQL.="
				UNION
				SELECT gr.email
				FROM mercado_artistas ma LEFT JOIN grupos_teatro gr ON ma.id_grupo_teatro=gr.id
				WHERE ma.id_mercado='$envio[id_mercado]'
			";
		}
	}
}
else{//Es para todos los mercados
	if($envio["enviar_a"]==2 || $envio["enviar_a"]==3){//"Sólo promotores","Artistas y promotores"
		$strSQL.="UNION	SELECT email1 FROM promotores WHERE id IN(SELECT id_promotor FROM pr_promotores_areas WHERE id_area IN ($envio[areas]))\n";
	}
	if($envio["enviar_a"]==1 || $envio["enviar_a"]==3){//"Sólo artistas","Artistas y promotores"
		if(preg_match("/1/",$envio["areas"])){//Danza
			$strSQL.="UNION	SELECT gr.email	FROM grupos_danza gr\n";
		}
		elseif(preg_match("/2/",$envio["areas"])){//Música
			$strSQL.="UNION SELECT gr.email	FROM grupos_musica gr\n";
		}
		elseif(preg_match("/3/",$envio["areas"])){//Teatro
			$strSQL.="UNION	SELECT gr.email FROM grupos_teatro gr\n";
		}
	}
}
$strSQL="\nSELECT * FROM ($strSQL) as foo WHERE email IS NOT NULL ORDER BY email\n";
//$strSQL="SELECT 'camiloandres@gmail.com' as email\n";

error_log($strSQL);
$qid=$db->sql_query($strSQL);
$total=$db->sql_numrows($qid);
$errores=0;
$enviados=0;
//$mail2->send(array($envio["remitente_mail"]));
while($destinatario=$db->sql_fetchrow($qid)){
	$mail2->send(array($destinatario["email"]));
	$correo=$destinatario["email"];
	echo $id_envio . "/" . $total . "/" . $enviados . "/" . $errores . "/" . $correo . "\n";
//	sleep(1);
	$enviados++;
}
$query="UPDATE boletin_envios SET fecha_fin=now() WHERE id='$id_envio'";
$db->sql_query($query);
$query="DELETE FROM boletin_envio_actual WHERE id_envio='$id_envio'";
$db->sql_query($query);

/*
print_r($email);
print_r($matches);
print_r($arrayImages);
print_r($envio);
*/

?>
