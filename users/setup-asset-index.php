<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

// Do Authorization
AuthCheck("normal");

$tablename = 'asset_info';
$col1      = 'asset_info_id';
commonHeader("Daedalus -  Asset Information");

echo "Select New or Existing Template";

PRINT "<hr noshade>";

$form = "setup-general-add-form.php";

$vars = "tablename=$tablename&col1=$col1";

echo "<p><a href=\"$form?${vars}\"><font color='red'>New Template</font></a></p>";

// Get Old Status for Tracking ID
$query = "SELECT  asset_info_id, table_name FROM $tablename";
$sth = $adb->prepare($query);
$res = $sth->execute() or print( mysql_error().': '.$query);

while ( list($ID, $tablename)  = $sth->fetchrow_array($res) ) {
  echo "<p><a href=\"$form?${vars}&ID=$ID\">$tablename</a></p>";
}

commonFooter();

?>
