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

commonHeader("Daedalus Knowledge Base Setup - Category Deleted");

$query = "DELETE FROM kbcategories WHERE (ID = \"$id\")";
$count =  $adb->dbh->exec($query);
$query = "DELETE FROM kbarticles WHERE ($parentID = \"$id\")";
$count =  $adb->dbh->exec($query);

?>

Category <?php echo "($id) $categoryname"; ?> Deleted!  Note: All articles under this 
<?php

PRINT "category has been deleted. <a href=\"$USERPREFIX/setup-knowledgebase.php\">Go Back</a>";

commonFooter();
?>
