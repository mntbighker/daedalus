<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("admin");

$update = $_REQUEST['update'];
$username = $_REQUEST['username'];
$comments = ''; // TO_DO - re-add comments back into user forms

if(isset($_REQUEST['fullname'])){
    $fullname = $_REQUEST['fullname'];
}
if(isset($_REQUEST['email'])){
    $email = $_REQUEST['email'];
}
if(isset($_REQUEST['building'])){
    $building = $_REQUEST['building'];
}
if(isset($_REQUEST['phone'])){
    $phone = $_REQUEST['phone'];
}
if(isset($_REQUEST['type'])){
    $type = $_REQUEST['type'];
}

commonHeader("Daedalus User Setup - User Update");

if($update == "act")
{
	$query = "UPDATE users SET fullname = '$fullname', email = '$email', building = '$building', phone = '$phone', access = '$type', comments = '$comments' WHERE name = '$username'";
	$adb->dbh->exec($query);
	logevent(-1, "Daedalus", 5, "setup", "$DName updated user $username");
	PRINT "Updated $username <a href=\"$USERPREFIX/setup-users.php\">Go back</a>";
} else if($update == "edit")
{
	$user = new User($username);
	$fullname = $user->getFullname();
	$email = $user->getEmail();
	$building = $user->getLocation();
	$phone = $user->getPhone();
	$type = $user->getAccess();
	PRINT "<form method=get action=\"$USERPREFIX/setup-user-update.php\">
		<table width=100% border=1 noshade bordercolor=#000000>
		<tr bgcolor=#CCCCCC><td colspan=2><strong>$fullname</strong>
		</td></tr>";

	PRINT "<tr bgcolor=#DDDDDD><td><font face=\"arial, helvetica\">
		<table width=100% border=0 noshade><tr bgcolor=#CCCCCC\">
		<td width=\"50%\">Username: $username</td><td width=\"50%\">
                Full Name:<input type=text width=40 name=fullname 
                value=\"$fullname\"></td></tr>
		</table><input type=hidden width=20 name=username 
		value=\"$username\"></font></td><td><font face=\"arial, 
		helvetica\">Password:<br>Now Set On Separate Page</td></tr>";
	PRINT "<tr bgcolor=#DDDDDD><td><font face=\"arial, helvetica\">E-mail: 
		<br><input type=text width=20 name=email value=\"$email\">
		</font></td><td><font face=\"arial, helvetica\">Phone:<br> 
		<input type=text width=20 name=phone value=\"$phone\">
		</td></tr>";
	PRINT "<tr bgcolor=#DDDDDD><td><font face=\"arial, helvetica\">Location: 
		<br><input type=text width=20 name=building 
		value=\"$building\"></font></td><td><font face=\"arial, 
		helvetica\">User Type:<br>";
	PRINT "<select name=type>\n";
	PRINT "<option value=admin";
	if($type == "admin")
	{
		PRINT " selected";
	}
	PRINT ">Administrator</option>\n";
	PRINT "<option value=normal";
	if($type == "normal")
	{
		PRINT " selected";
	}
	PRINT ">Normal</option>\n";
	PRINT "<option value=post-only";
	if($type == "post-only")
	{
		PRINT " selected";
	}
	PRINT ">Post Only</option>\n";
	PRINT "<option value=tech";
	if($type == "tech")
	{
		PRINT " selected";
	}
	PRINT ">Technician</option>\n";
	PRINT "</select>\n";
	PRINT "<input type=hidden name=update value=\"act\">";
	PRINT "<tr bgcolor=#CCCCCC><td colspan=2 valign=center><input type=submit 
		value=Update></form></td></tr></table>";
	PRINT "<br>";
} else if($update == "delete")
{
 	PRINT "<form method=post action=\"$USERPREFIX/setup-user-del.php\">";
	PRINT "The user $username is about to be deleted from the database, to cancel this action click <A HREF=\"$USERPREFIX/setup-users.php\">here</A>.";
	PRINT "<br>\n";
 	PRINT "<input type=hidden name=username value=\"$username\">";
 	PRINT "<input type=submit value=Delete></form>";
} else
{
	PRINT "Invalid action request for user update <A HREF=\"$USERPREFIX/setup-users.php\">Go Back</A>\n";
}

commonFooter();

?>
