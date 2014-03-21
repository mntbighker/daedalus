<?php

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.irm");

header("Location: $HTTP_REFERER");

AuthCheck("tech");

$query = "DELETE FROM $tablename WHERE (name = \"$name\")";
$count =  $adb->dbh->exec($query);

logevent(-1, "IRM", 5, "setup", "$IRMName removed entry $name from $tablename."); 
?>
