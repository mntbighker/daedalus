<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("tech");

commonHeader("Daedalus Knowledge Base Setup - Category Updated");

$query = "REPLACE kbcategories VALUES ('$id', '$categorylist', '$categoryname')";
$count =  $adb->dbh->exec($query);

PRINT "Updated ($id) $categoryname <a href=\"$USERPREFIX/setup-knowledgebase.php\">Go back</a>";

commonFooter();
?>
