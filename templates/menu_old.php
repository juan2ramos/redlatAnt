<?
//permisos, el array corresponde a los niveles de acceso

/*
"1"=>"Administrador"
"2"=>"Admin Géneros"
"3"=>"Admin Artistas"
"4"=>"Básico Grupo Danza"
"5"=>"Básico Grupo Música"
"6"=>"Básico Grupo Teatro"
"7"=>"Total Grupo Danza"
"8"=>"Total Grupo Música"
"9"=>"Total Grupo Teatro"
 */

$promotores = array(1,10);	
$empresas = array(1);	
$mercados= array(1);	
$generos = array(1,2);	
$grupos_danza =  array(1,4,7);
$grupos_musica = array(1,5,8);
$grupos_teatro = array(1,6,9);
$artistas = array(1,3,7,8,9);
$usuarios = array(1);
$img_home = array(1);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="1">
													<tr valign="top">
														<td height="1" align="center" colspan="2"></td>
													</tr>
													<?if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$generos)){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="imagen_home") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=imagen_home" class="<?if (nvl($_GET["module"])=="imagen_home") echo "active"; ?>">Imagen home</a>
														</td>
													</tr>
													<tr>
														<td colspan=2><b>ÁREAS</b></td>
													</tr>
<?/*
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="pr_areas") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=pr_areas" class="<?if (nvl($_GET["module"])=="pr_areas") echo "active"; ?>">Im&aacute;genes</a>
														</td>
													</tr>
*/?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="generos_danza") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=generos_danza" class="<?if (nvl($_GET["module"])=="generos_danza") echo "active"; ?>">Danza</a>
														</td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="generos_musica") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=generos_musica" class="<?if (nvl($_GET["module"])=="generos_musica") echo "active"; ?>">Música</a>
														</td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="generos_teatro") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=generos_teatro" class="<?if (nvl($_GET["module"])=="generos_teatro") echo "active"; ?>">Teatro</a>
														</td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="generos_plastica") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=generos_plastica" class="<?if (nvl($_GET["module"])=="generos_plastica") echo "active"; ?>">A. Plásticas y Visuales</a>
														</td>
													</tr>
													<tr>
														<td colspan=2><hr></td>
													</tr>
													<?}
													if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$grupos_danza) || in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$grupos_musica) || in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$grupos_teatro)){?>
													<tr>
														<td colspan=2><b>ARTISTAS</b></td>
													</tr>
													<?}if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$grupos_danza)){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="grupos_danza") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=grupos_danza" class="<?if (nvl($_GET["module"])=="grupos_danza") echo "active"; ?>">Danza</a>
														</td>
													</tr>
													<?}if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$grupos_musica)){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="grupos_musica") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=grupos_musica" class="<?if (nvl($_GET["module"])=="grupos_musica") echo "active"; ?>">Música</a>
														</td>
													</tr>
													<?}if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$grupos_teatro)){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="grupos_teatro") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=grupos_teatro" class="<?if (nvl($_GET["module"])=="grupos_teatro") echo "active"; ?>">Teatro</a>
														</td>
													</tr>
													<?}if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$artistas)){?>
													<tr>
														<td colspan=2><hr></td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="artistas") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=artistas" class="<?if (nvl($_GET["module"])=="artistas") echo "active"; ?>">Integrantes</a>
														</td>
													</tr>

													<?}?>
													<?if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"]==1){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if(simple_me($ME)=="reporte.php") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/reporte.php" class="<?if(simple_me($ME)=="reporte.php") echo "active"; ?>">Reportes</a>
														</td>
													</tr>
													<?}?>


													<tr><td colspan=2><hr></td></tr>
													<tr><td colspan=2><b>PROMOTORES</b></td></tr>
													
													<?if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$empresas)){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="empresas") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=empresas" class="<?if (nvl($_GET["module"])=="empresas") echo "active"; ?>">Organizaciones</a>
														</td>
													</tr>
													<?}?>
													<?if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$promotores)){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="promotores") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=promotores" class="<?if (nvl($_GET["module"])=="promotores") echo "active"; ?>">Promotores</a>
														</td>
													</tr>
													<?}?>

													<?if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$mercados)){?>
													<tr><td colspan=2><hr></td></tr>
													<tr><td colspan=2><b>MERCADOS</b></td></tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="mercados") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=mercados" class="<?if (nvl($_GET["module"])=="mercados") echo "active"; ?>">Mercados</a>
														</td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="citas") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=citas" class="<?if (nvl($_GET["module"])=="citas") echo "active"; ?>">Citas</a>
														</td>
													</tr>
													<?}?>

													<?if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$usuarios)){?>

													<?if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"]==1){?>
													<tr><td colspan=2><hr></td></tr>
													<tr><td colspan=2><b>EVENTOS</b></td></tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="ev_tipos") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=ev_tipos" class="<?if (nvl($_GET["module"])=="ev_tipos") echo "active"; ?>">Tipos</a>
														</td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="eventos") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=eventos" class="<?if (nvl($_GET["module"])=="eventos") echo "active"; ?>">Eventos</a>
														</td>
													</tr>


													<tr><td colspan=2><hr></td></tr>
													<tr><td colspan=2><b>CIRCUITOS</b></td></tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="circ_tipos") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=circ_tipos" class="<?if (nvl($_GET["module"])=="circ_tipos") echo "active"; ?>">Tipos</a>
														</td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="circuitos") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=circuitos" class="<?if (nvl($_GET["module"])=="circuitos") echo "active"; ?>">Circuitos</a>
														</td>
													</tr>

													<?}?>

													<?
													if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"]==1){?>
													<tr><td colspan=2><hr></td></tr>
													<tr><td colspan=2><b>NOTICIAS</b></td></tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="noticias") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=noticias" class="<?if (nvl($_GET["module"])=="noticias") echo "active"; ?>">Noticias</a>
														</td>
													</tr>
													<?}?>

													<tr>
														<td colspan=2><hr></td>
													</tr>
													<tr>
														<td colspan=2><b>ADMINISTRADORES</b></td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="usuarios") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=usuarios" class="<?if (nvl($_GET["module"])=="usuarios") echo "active"; ?>">Usuarios</a>
														</td>
													</tr>
													<?}?>
													<?if($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"]==1){?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="curadores") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=curadores" class="<?if (nvl($_GET["module"])=="curadores") echo "active"; ?>">Curadores</a>
														</td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="boletin_envios") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=boletin_envios&mode=envio_boletin" class="<?if (nvl($_GET["module"])=="boletin_envios") echo "active"; ?>">Env&iacute;o de bolet&iacute;n</a>
														</td>
													</tr>
													<?}?>

													<?if(in_array($_SESSION[$CFG->sesion_admin]["user"]["id_nivel"],$img_home)){/*?>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (nvl($_GET["module"])=="imagen_home") echo "selected"; ?>">
															<a href="<?=$CFG->admin_dir?>/index.php?module=imagen_home" class="<?if (nvl($_GET["module"])=="imagen_home") echo "active"; ?>">Imagen Home</a>
														</td>
													</tr>
													<?*/}?>
													<tr>
														<td colspan=2><hr></td>
													</tr>
													<tr>
														<td><img alt="" src="<?=$CFG->imagedir?>/vineta-cg.gif" height="7" width="11">&nbsp;</td>
														<td class="<?if (simple_me($ME)=="cambio_clave.php") echo "selected"; ?>">
														<a href="<?=$CFG->wwwroot?>/admin/cambio_clave.php" class="<?if (simple_me($ME)=="cambio_clave.php") echo "active"; ?>">Cambio de Clave</a>
														</td>
													</tr>
												</table>
