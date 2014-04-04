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
$query = "INSERT INTO $tablename VALUES ('$name')";
$count =  $adb->dbh->exec($query);
logevent(-1, "Daedalus", 5, "setup", "$DName added entry $name to $tablename.");
header("Location: $HTTP_REFERER");
?>
