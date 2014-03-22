<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("tech");

commonHeader("Daedalus Knowledge Base Setup - Category Added");

$query = "INSERT INTO kbcategories VALUES (null, '$categorylist', '$categoryname')";
$count =  $adb->dbh->exec($query);

PRINT "Added $categoryname  <a href=\"$USERPREFIX/setup-knowledgebase.php\">Go Back</a>";

commonFooter();
?>
