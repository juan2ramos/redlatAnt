<form name="entryform" action="<?=$ME?>" method="GET" >
<input type="hidden" name="mode" value="generar_reporte">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#ffffff" class="tabla_externa">
  <tr>
    <td bgcolor="#ffffff">
		<table width="100%" border="0" cellpadding="0" cellspacing="5" class="textobco10">
      <tr>
        <td>
					<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#ffffff" class="textobco10">
	         	<tr bgcolor="#bfbfac">
            	<td width="50%" align="left"><span class="style2">REPORTES</span></td>
          	</tr>
        	</table>
          <table width="100%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" class="textobco10">
						<tr bgcolor="#ffffff">
							<td rowspan=2>Reportes Disponibles</td>
							<td>
						<?
							$i=0;
							while($result=$db->sql_fetchrow($qReportes)){
								if($i==0) $selected=" CHECKED";
								else $selected="";
								echo "<input type='radio' id='radio_" . $result["id"] . "' name='id' value='p_" . $result["id"] . "'$selected>";
								echo "<label for='radio_" . $result["id"] . "'>";
								if(isset($result["numero"])) echo "<b>" . $result["numero"] . ")</b>&nbsp;";
							 	echo $result["titulo"];
								echo "</label><br>";
								$i++;
							}
						?>
							</td>
							<td>Formato:&nbsp;
								<select name='format'>
									<option value='html'>html</option>
									<?if(nvl($pdf,1)==1){?><option value='pdf'>pdf</option><?}?>
									<?if(nvl($excel,1)==1){?><option value='excel'>excel</option><?}?>
								</select>
							</td>
						</tr>
						<tr bgcolor="#ffffff">
							<td>
							<?
							$i=0;
							while($result=$db->sql_fetchrow($qReportes2)){
								echo "<input type='radio' id='radio_" . $result["id"] . "' name='id' value='s_" . $result["id"] . "'>";
								echo "<label for='radio_" . $result["id"] . "'>";
								if(isset($result["numero"])) echo "<b>" . $result["numero"] . ")</b>&nbsp;";
							 	echo $result["titulo"];
								echo "</label><br>";
								$i++;
							}
						?>
							</td>
							<td>Formato:&nbsp;
								<select name='format'>
									<option value='html'>html</option>
								</select>
							</td>
						</tr>
	


          </table>
				</td>
      </tr>
    </table>
		</td>
  </tr>
	<tr>
		<td>
			<input type="submit" value="Aceptar">
		</td>
	</tr>
</form>
</table>
				</td>
      </tr>
</table>
				</td>
      </tr>
</table>
				</td>
      </tr>
</table>
</body>
</html>
