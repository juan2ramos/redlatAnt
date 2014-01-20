<?
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#ffffff" class="tabla_externa">
  <tr>
    <td bgcolor="#ffffff">
		<table width="100%" border="0" cellpadding="0" cellspacing="5" class="textobco10">
      <tr>
        <td>
					<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#ffffff" class="textobco10">
<?if(isset($reporte) && isset($_SERVER["HTTP_REFERER"])){?>
         	<tr bgcolor="#bfbfac">
            	<td width="50%" align="left"><span class="style2"><?=$reporte["titulo"]?></span></td>
            	<td align="right"><a href="<?=$_SERVER["HTTP_REFERER"]?>">Volver</a></td>
          	</tr>
<?}?>


         	<tr bgcolor="#bfbfac">
            	<td width="50%" align="left"><span class="style2"><?=$db->sql_numRows($qid)?> resultado(s)</span></td>
            	<td align="right">
								<table width="200" class="textobco10">
									<tr>
										<td align="right" width="45%"></td>
										<td width="10%" align="center">//</td>
										<td width="45%"></td>
									</tr>
								</table>
							</td>
          	</tr>
        	</table>
          <table width="100%"  border="0" cellpadding="2" cellspacing="1" bgcolor="#999999" class="textobco10">
						<tr bgcolor='#bfbfac' class='title'>
							<?
								for($i=0;$i<$db->sql_numfields($qid);$i++){
									echo "<td class='title' nowrap align='center'><b>" . $db->sql_fieldname($i,$qid) . "</b></td>\n";
								}
							?>
						</tr>
						<?
							while($result=$db->sql_fetchrow($qid)){
								echo "<tr bgcolor=\"#ffffff\">";
								for($i=0;$i<$db->sql_numfields($qid);$i++){
									echo "<td class='label'>" . $result[$i] . "</td>\n";
								}
								echo "</tr>\n";
							}
						?>
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
				</td>
      </tr>
</table>
				</td>
      </tr>
</table>
</body>
</html>
