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

commonHeader("Daedalus Knowledge Base - Article Deleted");

$ID = $_REQUEST['ID'];

$query = "DELETE FROM kbarticles WHERE (ID = \"$ID\")";
$count =  $adb->dbh->exec($query);

PRINT "Deleted the knowledge base article. <a href=\"$USERPREFIX/knowledgebase-index.php\">Go Back</a>";

commonFooter();

?>
