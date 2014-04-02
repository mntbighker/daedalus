<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/func.header_footer");
include_once("../include/class.user");
include_once("../include/func.dropdown_groups");

AuthCheck("post-only");

commonHeader("Daedalus Help Desk");

print "Welcome to the Daedalus Help Desk.<br />
This is where you can request help with a computing resource problem. ";

print "<hr noshade>\n";

print "<form method=get action=\"../users/newticket-search.php\">
       <p>Enter the name of the computer:<br>
       Name: <input type=text name=name size=15> 
       <input type=submit value=\"Continue with Name\">
       </p>
       </form>";

commonFooter();

?>
