<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("admin");

commonHeader("Daedalus User Setup");

PRINT "Welcome to the Daedalus User Setup utility.  Here you can ";

if($AUTHSOURCE == "DB")
{
	PRINT "change, view, delete, and add users to the Daedalus database. \n";
} else
{
	PRINT "view and update users in the Daedalus database. \n";
	PRINT "<a href=\"./ldapupdate.php\">Click here to update the database information from LDAP.</a>\n";
}

PRINT "<hr noshade>\n";

$user = new User();

$user->displayAllUsers();

$dpass = 'daedalus-ts';

PRINT "<a name=\"add\"></a><hr noshade>";

PRINT "<form method=post action=\"$USERPREFIX/setup-user-add.php\"><table width=100% 
		border=1 noshade bordercolor=#000000><tr bgcolor=#CCCCCC>
		<th colspan=2><strong>Add a New User</strong></th></tr>";
PRINT "<tr bgcolor=#DDDDDD><td><font face=\"arial, helvetica\"><table width=100$ border=0 bgcolor=#DDDDDD><tr><td width=50%>Username: 
		<br><input type=text width=20 name=username></td><td width=50%>Full Name:<BR><INPUT TYPE=TEXT WIDTH=40 NAME=fullname value=\" \"></td></tr></font></table></td>
		<td><font face=\"arial, helvetica\">Default Password: $dpass</td></tr>";
PRINT "<tr bgcolor=#DDDDDD><td><font face=\"arial, helvetica\">E-mail: 
		<br><input type=text width=20 name=email></font></td><td>
		<font face=\"arial, helvetica\">Phone:<br> <input 
		type=text width=20 name=phone></td></tr>";
PRINT "<tr bgcolor=#DDDDDD><td><font face=\"arial, helvetica\">Location: 
		<br><input type=text width=20 name=building></font></td>
		<td><font face=\"arial, helvetica\"> User Type:<br>";
		PRINT "<select name=type>\n";
		PRINT "<option value=admin>Administrator</option>\n";
		PRINT "<option value=normal>Normal</option>\n";
		PRINT "<option value=post-only selected>Post Only</option>\n";
		PRINT "<option value=tech>Technician</option>\n";
		PRINT "</select>\n</td></tr>";
PRINT "<input type=hidden name=password value=$dpass>";
PRINT "<tr bgcolor=#CCCCCC><td colspan=2><input type=submit value=Add>
		</td></tr></table></form>";

commonFooter();
?>
