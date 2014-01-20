<?php
/* login.php (c) 2012 C�sar Augusto Valencia */

/******************************************************************************
 * MAIN
 *****************************************************************************/

include("application.php");
$DOC_TITLE = "Login";

/* form has been submitted, check if it the user login information is correct */
if (isset($_POST["username"])) {
	if($_GET['userGrupo']==1){
		if( $_POST["email"]!='' && $_POST["username"]!='' && $_POST["password"]!='' && $_POST["nombre_grupo"]!=''){
		 $user= create_account($_POST["email"],$_POST["username"],$_POST["password"],$_POST["nombre_grupo"]);
			 if (!$user) {
			   $errormsgDos = "Ya existe una cuenta con estos datos.";
			 }
		 }
		
	}else{
		
		$user = verify_login($_POST["username"], $_POST["password"]); 
			if (!$user) {	
			   $errormsg = "Login inv�lido, por favor intente de nuevo.";
			   $frm["username"] = $_POST["username"];
			 }
		
	}
	if ($user) {
		$_SESSION[$CFG->sesion_admin]["user"] = $user;
		$_SESSION[$CFG->sesion_admin]["ip"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$CFG->sesion_admin]["nivel"] = "admin";
		$_SESSION[$CFG->sesion_admin]["path"] = NULL;
		if(nvl($_POST["goto"])=="") $goto="index.php?mercado=0;";
		else $goto=$_POST["goto"];
//		$goto = nvl($_SESSION[$CFG->sesion_admin]["goto"],"index.php");
		if(isset($_SESSION[$CFG->sesion_admin]["goto"])) unset($_SESSION[$CFG->sesion_admin]["goto"]);
	
		if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 4 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 7)
			//$goto = "index.php?module=grupos_danza&mercado=0";
			$goto = "http://circulart.org/admin/login.php";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 5 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 8)
			//$goto = "index.php?module=grupos_musica&mercado=0";
			$goto = "http://circulart.org/admin/login.php";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 6 || $_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 9)
			//$goto = "index.php?module=grupos_teatro&mercado=0";
			$goto = "http://circulart.org/admin/login.php";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] ==2)
			//$goto = "index.php?module=generos_danza&mercado=0";
			$goto = "http://circulart.org/admin/login.php";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 3)
			//$goto = "index.php?module=artistas&mercado=0";
			$goto = "http://circulart.org/admin/login.php";
		elseif($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"] == 10)
			//$goto = "index.php?module=empresas&mercado=0";
			$goto = "http://circulart.org/admin/login.php";

		header("Location: $goto");
		die;
	} 
}

//include("../templates/header.php");
if(!isset($_POST["goto"])) $frm["goto"]=nvl($_SESSION[$CFG->sesion_admin]["goto"],"index.php?mercado=0&module=usuarios");
else $frm["goto"]=$_POST["goto"];
if(isset($_SESSION[$CFG->sesion_admin])) unset($_SESSION[$CFG->sesion_admin]);

  include("templates/login_form.php");	

/******************************************************************************
 * FUNCTIONS
 *****************************************************************************/

function verify_login($username, $password) {
	GLOBAL $db;
	$pass = md5($password);
    //Verificar si es usuario de sucursal:
	$username = $db->sql_escape($username);
    $qid = $db->sql_query("SELECT * FROM usuarios WHERE login = '$username' AND password = '" . $pass . "'");
	if($user=$db->sql_fetchrow($qid))	return($user);		
	return(FALSE);
}

function verify_existente($username) {
	GLOBAL $db;
    //Verificar si es usuario de sucursal:
	$username = $db->sql_escape($username);
	$qid = $db->sql_query("SELECT * FROM usuarios WHERE login = '$username'");
	if($user=$db->sql_fetchrow($qid))	return($user);
	//return($user);
	//return(FALSE);
}

function verify_existente2($email) {
	GLOBAL $db;
    //Verificar si es usuario de sucursal:
	$username = $db->sql_escape($username);
	$qid = $db->sql_query("SELECT * FROM usuarios WHERE email = '" . $email . "'");
	if($user=$db->sql_fetchrow($qid))	return($user);
	//return($user);
	//return(FALSE);
}


function create_account($email,$username,$password,$nombre_grupo){
	GLOBAL $db;
	$pass = md5($password);
	
	$user_existente = verify_existente($_POST["username"]); 

	if($user_existente['id']==''){
	
	$user_existente2 = verify_existente2($_POST["email"]); 
	
			if($user_existente2['id']==''){
				
			$user = verify_login($_POST["username"], $_POST["password"]); 
			
					if(!$user){
					// codig para crear cuenta 
					/* $db->sql_query("INSERT INTO usuarios (id_nivel
					 ,nombre
					 ,apellido
					 ,login
					 ,password
					 ,email
					 ,resolv) VALUES('8','Circulart2012','".$nombre_grupo."','".$username."','".$pass."','".$email."','Circulart2012')");
					
					 $frm["nombre"]=$nombre_grupo;
					 $frm["email"]=$email;
					 $frm["id_pais"]=4;
					 $frm["resolv"]='Circulart2012';
					 
                     $id_grupo=$db->sql_insert("grupos_musica", $frm);
					
					 $user = verify_login($_POST["username"], $_POST["password"]); 

						 
					 $db->sql_query("INSERT INTO usuarios_grupos_musica (id_usuario,id_grupo_musica) VALUES('".$user['id']."','$id_grupo')");	 
						 

						$strMail="NOTIFICACI�N\n\n";
						$strMail.="Usted ha creado una cuenta para participar en la Convocatoria CIRCULART 2012.\n\n";
						$strMail.="Login: ".$_POST["username"]."\n\n";
						$strMail.="password: ".$_POST["password"]."\n\n";
						$strMail.="correo: ".$_POST["email"]."\n\n";
						$strMail.="Atentamente,\n\n";
						$strMail.="CIRCULART - REDLAT\n";
						$strMail.="info@circulart.org\n";;
						$strMail.="http://circulart.org/circulart2012/\n";
						$strMail.="\n".date("Y-m-d H:i:s");
						$strMail.="\n";
						mail($_POST["email"],"Notificaci�n - Creaci�n Cuenta CIRCULART 2012",$strMail,"From: info@circulart.org");
				
				
				        $strMail2="NOTIFICACI�N\n\n";
						$strMail2.="Se ha creado una cuenta para participar en la Convocatoria CIRCULART 2012.\n\n";
						$strMail2.="Login: ".$_POST["username"]."\n\n";
						$strMail2.="password: ".$_POST["password"]."\n\n";
						$strMail2.="correo: ".$_POST["email"]."\n\n";
						$strMail2.="Atentamente,\n\n";
						$strMail2.="CIRCULART - REDLAT\n";
						$strMail.="info@circulart.org\n";
						$strMail2.="http://circulart.org/circulart2012/\n";
						$strMail2.="\n".date("Y-m-d H:i:s");
						$strMail2.="\n";

						mail('notificacionescirculart@gmail.com',"Notificaci�n - Creaci�n Cuenta CIRCULART 2012",$strMail2,"From: info@circulart.org"); 
						mail('ncirculart@gmail.com',"Notificaci�n - Creaci�n Cuenta CIRCULART 2012",$strMail2,"From: info@redlat.com"); 
						*/
						 
						 return($user);
					 }else{
						 return(FALSE);
						 }
			}else{
				 return(FALSE);
				 }
				
	}else{
		 return(FALSE);
		 }
	}
?>
