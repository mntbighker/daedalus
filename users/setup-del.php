<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

header("Location: $HTTP_REFERER");

AuthCheck("tech");

$query = "DELETE FROM $tablename WHERE (name = \"$name\")";
$count =  $adb->dbh->exec($query);

logevent(-1, "Daedalus", 5, "setup", "$DName removed entry $name from $tablename."); 
?>
