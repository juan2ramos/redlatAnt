
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#cccccc" class="tabla_externa">
  <tr>
    <td bgcolor="#dae599">
		<table width="100%" border="0" cellpadding="0" cellspacing="5" class="textobco10">
      <tr>
        <td>
			<table width="100%"  border="0" cellpadding="4" cellspacing="1" bgcolor="#dae599" class="textobco10">
	         	<tr bgcolor="#bfbfac">
            	<td width="50%" align="left" bgcolor="#f27228"><span class="style2">Compilados</span></td>
          	</tr>
        	</table>
            
            <?php while($query =$db->sql_fetchrow($qReportes))
				{
					
				?>
          <table width="700"  style="margin-left:5px; margin-top:5px;" border="0" cellpadding="0" cellspacing="0" bgcolor="#999999" class="textobco10">
						<tr bgcolor="#dae599">
							<td width="39%" align="left" valign="top"><?php 
							$qReportes2=$db->sql_query("SELECT * FROM compiladostracklist where id_compilado=".$query['id']." ORDER BY orden");
							
									
							$carpeta= $query['id'];
						
							 ?>
                             
                             <img src="http://circulart.org/musica/compilados/<?php echo $carpeta?>/caratula/caratula<?php echo $carpeta?>.jpg" />
                             <br />
                             <?php 
							 echo $query['resena'];
							 
							 ?>
                             <br />
                             <br />
                             <a href="http://circulart.org/musica/compilados/<?php echo $carpeta?>/caratula/circulart<?php echo $query['anio']; ?>.zip" style="color:#f27228"><strong>Descarga Total</strong> </a></td>
							<td width="61%" colspan="2" valign="top">
                                    <table width="100%">
                                    <?php while($query2 =$db->sql_fetchrow($qReportes2))
									{
										$archivo= $query2["mmdd_archivo_filename"];
									?>
                                    
                                      <tr>
                                        <td>
                                        <div style="width:100%;">
                                        <div style="float:left;"><b><?php echo $query2["orden"].".</b> ".$query2["etiqueta"]; ?>&nbsp;-&nbsp;<a  style="color:#f27228"href="http://circulart.org/musica/compilados/<?php echo $carpeta; ?>/<?php echo $archivo?>"><b>Descargar</b></a></div>
                                        <div style="float:left;"><script language="JavaScript" src="http://circulart.org/audio_base/audio-player.js"></script>
                                        <object type="application/x-shockwave-flash" data="http://circulart.org/audio_base/player.swf" id="audioplayer2452" height="24" width="290">
                                        <param name="movie" value="http://circulart.org/audio_base/player.swf">
                                        <param name="FlashVars" value="playerID=2452&amp;soundFile=http://circulart.org/musica/compilados/<?php echo $carpeta; ?>/<?php echo $archivo?>">
                                        <param name="quality" value="high">
                                        <param name="menu" value="false">
                                        <param name="wmode" value="transparent">
                                        </object></div>
                                        </div>
                                       <br />
                                        </td>
                                      </tr>
                                    <?php }?>
                                    </table>
							</td>
						</tr>
			</table>
            <br />
            <br />
            <br />
            <br />
			<?php }?>
            
            
            	</td>
      </tr>
    </table>
		</td>
  </tr>
	<tr>
		<td>
			
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
