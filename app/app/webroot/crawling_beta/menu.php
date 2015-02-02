<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="15%" align="right" valign="middle"><a href="home.php"><img src="img/home.png" width="16" height="16" border="0" /></a></td>
                <td height="25" colspan="2" align="left" valign="middle" class="bigtext1">&nbsp;<a href="home.php">Home</a></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td width="9%" align="center" valign="middle">&nbsp;</td>
                <td width="76%" align="left" valign="middle">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td colspan="2" align="left" valign="middle" class="menutext1">Merchants Website</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
                <td align="left" valign="middle">&nbsp;</td>
            </tr>
            <?php
			$qry_site = mysql_query("select * from mc_merchants_new");
			while($res_site = mysql_fetch_array($qry_site)){
			?>
            <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><img src="img/arrow-right.png" width="16" height="16" border="0" /></td>
                <td height="22" align="left" valign="middle" class="menutext1"><a href="product_list.php?siteid=<?php echo base64_encode($res_site['id']);?>"><?php echo $res_site['website_name'];?></a></td>
            </tr>
            <?php }?>
            <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
                <td height="22" align="left" valign="middle" class="menutext1">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
                <td height="22" align="left" valign="middle" class="menutext1">&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle"><a href="logout.php"><img src="img/logout.png" width="16" height="16" border="0" /></a></td>
                <td height="22" align="left" valign="middle" class="menutext1"><a href="logout.php">Logout</a></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" valign="middle">&nbsp;</td>
                <td height="200" align="left" valign="middle">&nbsp;</td>
            </tr>
        </table>