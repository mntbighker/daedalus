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
$query = "INSERT INTO $tablename VALUES ('$name')";
$count =  $adb->dbh->exec($query);
logevent(-1, "IRM", 5, "setup", "$IRMName added entry $name to $tablename.");
header("Location: $HTTP_REFERER");
?>
