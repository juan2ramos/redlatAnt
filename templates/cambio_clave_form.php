<form name="entryform" method="POST" action="<?=$ME?>">
<input type="hidden" name="mode" value="cambioClave">

<table class="tabla_externa" align="center" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="4" width="100%">
	<tr>
		<td bgcolor="#ffffff">
			<table class="textobco10" border="0" cellpadding="0" cellspacing="5" width="50%">
				<tr>
					<td>
						<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#ffffff" class="textobco10">
							<tr bgcolor="#bfbfac">
								<td align="left">
									<span class="style2">Cambio de Clave</span><br>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height=140 align="bottom">
						<table>
							<?
								if(isset($error)){?>
								<tr>
									<td colspan=2><font color="red"><?=$error?></font></td>
								</tr>
							<?}?>
							<tr>
								<td>Nombre:</td>
								<td><?=$_SESSION[$CFG->sesion_admin]["user"]["nombre"]." ".$_SESSION[$CFG->sesion_admin]["user"]["apellido"]?></td>
							</tr>
							<tr>
								<td>E-mail:</td>
								<td><input type='text' size='20'  name='email' value='<?=$_SESSION[$CFG->sesion_admin]["user"]["email"]?>'></td>
							</tr>
							<tr>
								<td>Clave Anterior:</td>
								<td>
									<input type='password' size='20'  name='anterior'>
								</td>
							</tr>
							<tr>
								<td>Clave Nueva:</td>
								<td>
									<input type='password' size='20'  name='nueva'>
								</td>
							</tr>
							<tr>
								<td>Confirmar Clave Nueva:</td>
								<td>
									<input type='password' size='20'  name='nueva2'>
								</td>
							</tr>
							<tr>
								<td height=50 align="bottom"><input type="button"   style="font-size:8pt" value="Cambiar" onClick="enviar()"></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>


<script>

function enviar()
{
	if(revisar())
		document.entryform.submit();
}


function revisar()
{
	if(document.entryform.email.value.replace(/ /g, '') =='')
	{
		window.alert('Por favor escriba: E-mail');
		document.entryform.email.focus();
		return(false);
	}

	if(document.entryform.anterior.value.replace(/ /g, '') =='')
	{
		window.alert('Por favor escriba: Clave Anterior');
		document.entryform.anterior.focus();
		return(false);
	}

	if(document.entryform.nueva.value.replace(/ /g, '') =='')
	{
		window.alert('Por favor escriba: Clave Nueva');
		document.entryform.nueva.focus();
		return(false);
	}
	
	if(document.entryform.nueva2.value.replace(/ /g, '') =='')
	{
		window.alert('Por favor escriba: Confirmación Clave Nueva');
		document.entryform.nueva2.focus();
		return(false);
	}

	if(document.entryform.nueva.value != document.entryform.nueva2.value)
	{
		window.alert('La confirmación de la clave no coincide!');
		document.entryform.nueva2.focus();
		return(false);
	}
	
	return true;
}


</script>


