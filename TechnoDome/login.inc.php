<?php

	/* $Id: login.inc.php,v 1.3 2001/01/26 20:59:21 dwilson Exp $ */

	// 	File:		login.inc.php
	//	Purpose:	Displays the login screen
	//	Author:		Dan Wilson
	// 	Date:		08 Oct 2000
	
	
	// $cfgProgName $cfgVersion

	reset($cfgServers);
	while(list($key, $val) = each($cfgServers)) {
		// echo "$key => $val[host]<br>";
		if ($val['local'] || !empty($val['host'])) {
			unset($host_display);
			if ($val['local']) {
				$host_display .= "local:" . $val['port'];
			} else {
				if (!empty($val['host'])) {
					$host_display .= $val['host'];
				}
				if (!empty($val['port'])) {
					$host_display .= ":" . $val['port'];
				}
			}
			$aryServers[$host_display] = $key;
		}
	}
	
	if (count($aryServers) > 1) {
		$strServers = select_box(array("values"=>$aryServers, "name"=>"server", "selected"=>$server));
		$strServersTxt = "
						<tr>
							<td align=\"right\" colspan=\"2\">$strServers</td>
						</tr>
		";
	}
	
	echo "<h1>", $strWelcome, " ", $cfgProgName, " ", $cfgVersion, "</h1>";
?>
		<table border="0" cellpadding="0" cellspacing="0" width="350">
			<tr height="18">
				<th align="left" valign="middle" height="18" >&nbsp;&nbsp;<?php echo "$ver_realm"; ?></th>
			</tr>
			<tr height="115">
				<td height="115" align="center" valign="middle">
					<?php echo "<span style=\"color=red\">$strMsg</span>"; ?>
					<table border="0" cellpadding="2" cellspacing="0">
						<form action="index.php" method="POST" name="login_form">
						<?php // echo $strServersTxt; ?>
						<tr>
							<td class="form"><?php echo "$strUserName"; ?>:</td>
							<td><input type="text" name="set_username" value="<?php echo "$PHP_PGADMIN_USER"; ?>" size="24"></td>
						</tr>
						<tr>
							<td class="form"><?php echo "$strPassword"; ?>:</td>
							<td><input type="password" name="set_password" size="24"></td>
						</tr>
						<tr>
							<td colspan="2" align="right" valign="middle">
								<?php echo $strServers; ?>
								<input type="submit" name="login_submit" value="<?php echo "$strLogin"; ?>">
								<!--input type="hidden" name="server" value="<?php echo "$server"; ?>"-->
							</td>
						</tr>
						</form>
					</table>
				</td>
			</tr>
			<tr height="18">
				<th align="right" height="18"><?php echo "$short_realm"; ?>&nbsp;&nbsp;</th>
			</tr>
		<script language=javascript>
			var uname = document.login_form.set_username;
			var pword = document.login_form.set_password;
			if (uname.value == "") { 
				uname.focus();
			} else {
				pword.focus();
			}
		</script>
		</table>	
