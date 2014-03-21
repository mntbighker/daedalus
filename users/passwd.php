<?php
#    IRM - The Information Resource Manager
#    Copyright (C) 1999 Yann Ramin
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License (in file COPYING) for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#
#    $Id: passwd.php,v 1.2 2001/06/29 04:07:13 theatrus Exp $
#
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  7/22/99 - Keith Schoenefeld:	Cleaned up code, converted all IF(): to if(){. #
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
