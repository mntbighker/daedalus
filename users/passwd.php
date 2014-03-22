<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

initvar('error');

AuthCheck("normal");

commonHeader("IRM - Change Password");

?>
To change your password, please fill in the form below.<br />
<b>You will be logged out if change succeeds!</b<br />

<?php
    if ($error) print "<p><b><font color='red'>Error: $error</font></b></p>";
?>

<p>

<?php
PRINT "<form method=post action=\"$USERPREFIX/passwd-change.php\">";
?>

<table border=0>
<tr>
  <td>Old Password</td>
  <td><input type=password cols=10 name=oldpassword></td>
</tr>
<tr>
  <td>New Password</td>
  <td><input type=password cols=10 name=newpassword></td>
</tr>
<tr>
  <td>Confirm New Password</td>
  <td><input type=password cols=10 name=confirm></td>
</tr>
</table>
<input type=submit value="Change Password">
</form>

<?php

commonFooter();

?>
