<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  7/22/99 - Keith Schoenefeld:	Cleaned up code, converted all IF(): to if(){. #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");


AuthCheck("tech");

commonHeader("Daedalus Knowledge Base Setup - Category Updated");

$query = "REPLACE kbcategories VALUES ('$id', '$categorylist', '$categoryname')";
$count =  $adb->dbh->exec($query);

PRINT "Updated ($id) $categoryname <a href=\"$USERPREFIX/setup-knowledgebase.php\">Go back</a>";

commonFooter();
?>
