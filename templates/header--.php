<html>
<head>
<title><?=$CFG->siteTitle?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?=$CFG->admin_dir?>/style.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#ffffff" text="#000000">

<table border="0" cellpadding="0" cellspacing="0" width="100%" style="height:100%">
	<tr>
		<td width="180" valign="top" height="100%">
			<table border="0"  cellpadding="0" cellspacing="0" width="100%" style="height:100%">
				<tr bgcolor="#ffffff">
					<td height="80" align="left" valign="middle" colspan=2>
						<img alt="<?=$CFG->siteTitle?>" src="<?=$CFG->siteLogo?>">
					</td>
				</tr>
				<tr valign="top" bgcolor="#d9d9c3">
					<td width="20" height="24"></td>
					<td></td>
				</tr>
				<tr valign="top" bgcolor="#d9d9c3">
					<td width="20">&nbsp;</td>
					<td height="100%">
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td class="nav">
								</td>
								<td>
									<?
										include("menu_.php");
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td width="20">&nbsp;</td>
					<td><img alt="" src="<?=$CFG->imagedir?>/break.gif" height="1" width="160" vspace="4"></td>
				</tr>
				<tr valign="top">
					<td width="20">&nbsp;</td>
					<td align="left" class="pipe">Usuario: <?echo $_SESSION[$CFG->sesion_admin]["user"]["nombre"] . " " . $_SESSION[$CFG->sesion_admin]["user"]["apellido"];?></td>
				</tr>
				<tr valign="bottom">
					<td align="right" colspan="2">
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td class="titulo" valign="bottom" colspan=2 height=53 >
					</td>
				</tr>
				<tr>
					<td class="titulo" valign="bottom">&nbsp;&nbsp;<?=$CFG->siteTitle?> [<?if(isset($entidad)) echo $entidad->get("labelModule")?>]</td>
				<td align="right">
						<table border="0" cellpadding="2" cellspacing="0">
								<tr>
									<td width="10" align="center">&nbsp;
									</td>
									<td valign="bottom"> <a title="Home" HREF="<?=$CFG->wwwroot?>" target="_blank">
										<IMG BORDER="0" ALT="Home" SRC="<?=$CFG->imagedir?>/gohome.png"></a>
									</td>
									<td width="10" align="center">&nbsp;
									</td>
									<td valign="bottom"> <a title="Salir" HREF="<?=$CFG->admin_dir?>/login.php">
										<IMG BORDER="0" ALT="Home" SRC="<?=$CFG->imagedir?>/exit.png"></a>
									</td>
									<td width="10" align="center">&nbsp;&nbsp;&nbsp;&nbsp;
									</td>
								</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top" colspan=2 bgcolor="#ffffff">
						<table width="100%" cellpadding="1" cellspacing="0" border="0">
							<tr>
								<td>
									<!-- empiezan las páginas -->














<!--

								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>

-->			






















