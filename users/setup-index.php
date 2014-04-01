<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

commonHeader("Daedalus Setup");

PRINT <<<TITLE
<p>Welcome to Daedalus Setup.  
Here we will administer new users and configure Daedalus. </p>
TITLE;

echo "<table border=0 width=100%>";

echo "<tr align=center>";

print "<td><h4><a href=\"../users/setup-users.php\">Setup Users</a></h4></td>";
print "<td><h4><a href=\"../users/setup-asset-index.php\">Asset Search Defaults</a></h4></td>";
print "<td><h4><a href=\"../users/setup-dropdowns-index.php\">Manage DropDowns</a></h4></td>";
print "<td><h4><a href=\"../users/setup-knowledgebase.php\">Setup the Knowledge Base</a></h4></td>";

echo "</tr>";

echo "</table>";

commonFooter();

?>
