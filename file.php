<?
	include("../application.php");
	
	$campo=$_GET["field"];
	$strQuery="
		SELECT
			$campo,
			mmdd_" . $campo . "_filetype,
			mmdd_" . $campo . "_filesize,
			mmdd_" . $campo . "_filename
		FROM $_GET[table]
		WHERE id = '$_GET[id]'
	";
	$qid=$db->sql_query($strQuery);
	if($result=$db->sql_fetchrow($qid)){
		$fileName=$result["mmdd_" . $campo . "_filename"];
		$fileType=$result["mmdd_" . $campo . "_filetype"];
		$fileSize=$result["mmdd_" . $campo . "_filesize"];
		$fileFile=base64_decode($result[$campo]);
		header("Content-type: " . $fileType);
		header('Content-Disposition: attachment; filename="' . $fileName . '"');
		echo $fileFile;
	}

?>
