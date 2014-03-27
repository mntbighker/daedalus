<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.checked");

AuthCheck("admin");

commonHeader("Daedalus System Setup");

if($submit == "update")
{
	$query = "REPLACE config VALUES (0, '$notifyassignedbyemail', '$notifynewtrackingbyemail', '$newtrackingemail', '$groups', '$usenamesearch', '$userupdates', '$sendexpire', '$showjobsonlogin', '$minloglevel', '$newlogo', '$snmp', '$snmp_rcommunity', '$snmp_ping', '$irm_version', '$irm_build', '$knowledgebase', '$anonymous', '$anon_faq', '$anon_req')";
	$adb->dbh->exec($query);
	PRINT "Daedalus System Setup updated, click <A HREF=\"$USERPREFIX/setup-irm.php\">here</A> to view or modify the new settings.\n";
} else
{
?>
Welcome to Daedalus' System Setup.  Here is where we will set up Daedalus'
system configuration.  On this page you will be able to set system wide
settings such as whether Daedalus should support computer groups, whether someone
should be emailed when a new work request is entered etc.
<br><br>


<?php
$notifyassignedbyemail = Checked($cfg_notifyassignedbyemail);
$notifynewtrackingbyemail = Checked($cfg_notifynewtrackingbyemail);
$groups = Checked($cfg_groups);
$usenamesearch = Checked($cfg_usenamesearch);
$userupdates = Checked($cfg_userupdates);
$sendexpire = Checked($cfg_sendexpire);
$showjobsonlogin = Checked($cfg_showjobsonlogin);
$snmp = Checked($cfg_snmp);
$snmp_ping = Checked($cfg_snmp_ping);
$knowledgebase = Checked($cfg_knowledgebase);
$anonymous = Checked($cfg_anonymous);
$anon_faq = Checked($cfg_anon_faq);
$anon_req = Checked($cfg_anon_req);

PRINT "<form method=get action=\"$USERPREFIX/setup-irm.php\">";
?>
<table border=0 width=100%>
<?php
	PRINT "<TR><TH><B>Functional Options</B></TH></TR>\n";
	PRINT "<tr><td><input type=checkbox name=notifyassignedbyemail value=\"1\" $notifyassignedbyemail>Notify a person who has been assigned a work request via email.</td></tr>\n";
	PRINT "<tr><td><input type=checkbox name=notifynewtrackingbyemail value=\"1\" $notifynewtrackingbyemail>Notify someone via email when a user has entered a new work request.</td></tr>\n";
	PRINT "<tr><td><input type=text size=20 name=newtrackingemail value=\"$cfg_newtrackingemail\"> The email address that should receive notification when a user has entered a work request (seperate multiple email addresses with a comma).</td></tr>\n";
	PRINT "<tr><td><input type=checkbox name=groups value=\"1\" $groups>Select this option if you would like to be able to group computers together.  This is valuable if you would like people to be able to submit work requests against large numbers of computers, such as a computer lab.</td></tr>\n";
	PRINT "<tr><td><input type=checkbox name=usenamesearch value=\"1\" $usenamesearch>If this option is selected, users will be able to search for their computer by name instead of being forced to type in an Daedalus ID to enter a work request.</td></tr>\n";
	PRINT "<tr><td><input type=checkbox name=userupdates value=\"1\" $userupdates>This option allows users to request updates via email when a tracking job they entered is update in any way (e.g. someone adds a followup, it is marked complete, etc.).</td></tr>\n";
	PRINT "<tr><td><input type=checkbox name=sendexpire value=\"1\" $sendexpire>Send expires and pragma: nocache headers.</td></tr>\n";
	PRINT "<tr><td><input type=checkbox name=showjobsonlogin value=\"1\" $showjobsonlogin>Show a user the jobs assigned to him or her immediately after logging on.  If this is not selected, only the number of jobs the user has assigned is displayed.</td></tr>\n";
	PRINT "<tr><td><select name=minloglevel size=1>\n";
	PRINT "<option ";
	if($cfg_minloglevel == 1)
	{
		PRINT "selected ";
	}
	PRINT "value=\"1\">Critical</option>\n";
	PRINT "<option ";
	if($cfg_minloglevel == 2)
	{
		PRINT "selected ";
	}
	PRINT "value=\"2\">Severe</option>\n";
	PRINT "<option ";
	if($cfg_minloglevel == 3)
	{
		PRINT "selected ";
	}
	PRINT "value=\"3\">Important</option>\n";
	PRINT "<option ";
	if($cfg_minloglevel == 4)
	{
		PRINT "selected ";
	}
	PRINT "value=\"4\">Notice</option>\n";
	PRINT "<option ";
	if($cfg_minloglevel == 5)
	{
		PRINT "selected ";
	}
	PRINT "value=\"5\">Junk</option>\n";
	PRINT "</SELECT> Select the Minimum Log Level.</td></tr>\n";
	PRINT "<tr><td><input type=text size=20 name=newlogo value=\"$LOGO\"> The name of the image file you would like used for the Daedalus logo. Note: $PREFIX is prepended to any value you enter here.</td></tr>\n";
	PRINT "<tr><td><input type=checkbox name=knowledgebase value=\"1\" $knowledgebase>Would you like to use the Knowledge Base system that is now built in to Daedalus?</td></tr>\n";
	?>
	</table>
	<table border=0 width=100%>
	<?php
	PRINT "<TR><TH>Simple Network Management Protocol (SNMP)</TH></TR>";
	PRINT "<tr><td><input type=checkbox name=snmp value=\"1\" $snmp>Do you wish to enable snmp monitoring (ignore the rest of the questions in this section if you don't check this option).</td></tr>";
	PRINT "<tr><td><input type=text size=20 name=snmp_rcommunity value=\"$cfg_snmp_rcommunity\"> The name of the \"read\" or \"public\" snmp community.</td></tr>";
	PRINT "<tr><td><input type=checkbox name=snmp_ping value=\"1\" $snmp_ping>Ping this host when it is loaded into the computer editer.  This option can cause big delays if the host is down - use with caution.</td></tr>";
 ?>
	</TABLE>
        <table border=0 width=100%>
	<?php
	PRINT "<TR><TH>Interface options</TH></TR>";
        PRINT "<tr><td><input type=checkbox name=anonymous value=\"1\" $anonymous>Do you wish to enable anonymous actions? (Submit ticket, read FAQ, etc).</td></tr>";
	PRINT "<tr><td><input type=checkbox name=anon_req value=\"1\" $anon_req>Do you wish to enable users to submit trouble ticket anonymously?.</td></tr>";
	PRINT "<tr><td><input type=checkbox name=anon_faq value=\"1\" $anon_faq>Do you wish to enable users to read the FAQ anonymously? .</td></tr>";
        ?>
	</TABLE>
		<INPUT TYPE=HIDDEN NAME="submit" VALUE="update">
	<TABLE BORDER=0 WIDTH=100%>
	<TR>
		<TD><INPUT TYPE=SUBMIT VALUE="Update"></TD>
	</TR>
	</TABLE>
	</FORM>
<?php
}
commonFooter();
?>
