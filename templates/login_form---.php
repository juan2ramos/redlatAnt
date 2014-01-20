<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en" style="height: 100%">
<head>
<title><?=$CFG->siteTitle?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="style.css" rel="stylesheet" type="text/css" />
    
</head>

<body bgcolor="#00aba9" style="margin: 0; height: 100%">
<script>
function revisar(frm){
	
	if(frm.username.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: Login');
		frm.login.focus();
		return(false);
	}
	else{
		var regexpression=/./;
		if(!regexpression.test(frm.username.value)){
			window.alert('[Login] no contiene un dato válido.');
			frm.login.focus();
			return(false);
		}
	}
	
	
	if(frm.password.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: password');
		frm.password.focus();
		return(false);
	}
	else{
		var regexpression=/./;
		if(!regexpression.test(frm.password.value)){
			window.alert('[Password] no contiene un dato válido.');
			frm.password.focus();
			return(false);
		}
	}
	
	if(frm.password.value != frm.__CONFIRM_password.value){
		window.alert('La confirmación de Password no corresponde.');
		frm.password.focus();
		return(false);
	}
	
	if(frm.email.value.replace(/ /g, '') ==''){
		window.alert('Por favor escriba: e-mail');
		frm.email.focus();
		return(false);
	}
	else{
		var regexpression=/@.*\./;
		if(!regexpression.test(frm.email.value)){
			window.alert('[e-mail] no contiene un dato válido.');
			frm.email.focus();
			return(false);
		}
	}
	
		if(!document.getElementById('terminos').checked){
		window.alert('Para continuar con la inscripción debe aceptar los términos y condiciones.');
		return(false);
	}
	 
	return(true);
}
</script>
<table align="center" border="0" cellspacing="1" cellpadding="5" width="910" >
	<tr>
		<td height="120" align="left" valign="top"><img src="images/header.jpg" width="916" height="120"></td>
  </tr>
	<tr>
		<td width="100%" height="60" valign="top">
			<table align="center" border="0" cellspacing="5" cellpadding="5" width="910" >
				<tr>
					<td height="30" width="50%" align=center valign=middle >
                    <form name="entryform" method="post" action="login.php?userGrupo=1" onSubmit="return revisar(this)">
			<input type="hidden" name="goto" value="<?=nvl($frm["goto"])?>" />
						<table width="396" border="0" align="center" >
							<tr>
								<td width="352"><p><strong style="color:#bfd630;"><br>
							    Paso 1: </strong>Leer los términos de la Convocatoria.</p>
								  <blockquote>
								    <p>
								     &nbsp;&nbsp;&nbsp; <a href="http://circulart.org/circulart2012/images/stories/descargas/ConvocatoriaCirculart2012.pdf" target="_blank" style="color:#bfd630;"><strong>Ver términos de la convocatoria</strong></a> </p>
							      </blockquote>
						      <p><strong style="color:#bfd630;">Paso 2: </strong>Si no tiene un portafolio creado anteriormente en Circulart cree una cuenta con el diligenciamiento de los siguientes campos</p></td>
							</tr>
							<tr>
							  <td align="center"><? if (! empty($errormsgDos)) { ?>
                                <div align=center><b>
                                  <?=nvl($errormsgDos) ?>
                                </b></div>
                                <?}?>
                                <table width="364"  border="0" align="center" cellpadding="0" cellspacing="1" style="height: 50">
                                  <tr>
                                    <th width="170" align="right">&nbsp;</th>
                                    <th width="49" align="right">login :&nbsp;</th>
                                    <td width="141" align="center" valign="middle"><input type="text" name="username" size="16" /></td>
                                  </tr>
                                  <tr>
                                    <th colspan="2" align="right" >password :&nbsp;</th>
                                    <td width="141" align="center" valign="middle"><input type=password name="password" size="16" /></td>
                                  </tr>
                                  <tr>
                                    <th colspan="2" align="right">check password : </th>
                                    <td align="center" valign="middle"><input type=password name="__CONFIRM_password" size="16" id="password_check" /></td>
                                  </tr>
                                  <tr>
                                    <th colspan="2" align="right">Nombre del grupo de musica o del artista :</th>
                                    <td align="center" valign="middle"><input type=text name="nombre_grupo" size="16" id="nombre_grupo" /></td>
                                  </tr>
                                  <tr>
                                    <th colspan="2" align="right">E-mail :</th>
                                    <td align="center" valign="middle"><input type="text" name="email" size="16" id="email" /></td>
                                  </tr>
                                  <tr>
                                    <th colspan="2" align="right"><strong>(*) He le&iacute;do y acepto <br>
                                      los t&eacute;rminos y condiciones:</strong></th>
                                    <td><label>
                                      <input type="checkbox" id="terminos" >
                                    </label></td>
                                  </tr>
                                  <tr>
                                    <td align="center" valign="middle" colspan="3"><br/>
                                      <input type="submit" name="Submit2" value="Crear" /></td>
                                  </tr>
                              </table></td>
						  </tr>
						</table>
                    </form>
					</td>
					<td width="50%" align=center valign=top bgcolor="#d31e47">
                    
                    <table width="400">
  <tr>
    <td><p><br>
        <strong style="color:#ffffff;">Ingreso de agrupaciones musicales o de artistas ya registrados en Circulart 2012 o que hayan participado en Circulart 2010, 2011 y en las Ruedas de Negocios de la Cámara de Comercio de Bogotá.</strong><br>
        <br>
    </p></td>
  </tr>
  <tr>
    <td><form name="entryform" method="post" action="login.php">
			<input type="hidden" name="goto" value="<?=nvl($frm["goto"])?>" />
									<? if (! empty($errormsg)) { ?>
										<div align=center><b><?=nvl($errormsg) ?></b></div>
									<?}?>
									<table width="215" border="0" align="center" cellpadding="0" cellspacing="1" style="height: 50">
											<tr>
												<th width="102" align="right" style="color:#ffffff;">Login :&nbsp;</th>
												<td width="110" align="right" valign="middle"><input value="<?=nvl($frm["username"]) ?>" type="text" name="username" size="16" /></td>
											</tr>
											<tr>
												<th align="right" style="color:#ffffff;">password :&nbsp;</th>
												<td align="right" valign="middle"><input type=password name="password" size="16" /></td>
											</tr>
											<tr> 
												<td align="center" valign="middle" colspan="2"><br/><input type="submit" name="Submit" value="Entrar" /></td>
											</tr>
									</table>
                                    </form></td>
  </tr>
</table>

                                    </td>
				</tr>
			</table>
			</td>
	</tr>
	<tr>
	  <td height="60" valign="bottom" >&nbsp;</td>
  </tr>
</table>
<!--ACA VA EL PIE DEL DISEÑO-->
<script type="text/javascript">
	document.entryform.username.focus();
</script>

<script>
function abrir()
{
	ruta='<?=$CFG->wwwroot?>/registro_grupo.php';
	ventana = 'registro';
	window.open(ruta,ventana,'scrollbars=yes,width=600,height=350,screenX=100,screenY=100,scrollbar=yes');
}
</script>

</body>
</html>

