<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.movesurplus");
include_once("../include/func.showitem");

AuthCheck("tech");

$ID = $_POST['ID'];
$tablename = $_POST['tablename'];
$col1 = $_POST['col1'];
$col2 = $_POST['col2'];
$submit = $_POST['submit'];

if ( $submit == 'Verify' ) {
   $error = moveSurplus($tablename, $ID);

   if ( ! $error ) {
     logevent(-1, "Daedalus", 5, "surplus", "$DName surplussed $tablename $ID");
     exit(header("Location: ../users/general-index.php?tablename=$tablename"));
   }
}

$message = "<font color=\"red\"> - Surplus Failed</font>";

commonHeader("Daedalus Surplus $message");

if ( $error == 1 ) {
   echo "<p><font color=\"red\">Data move from Table: $tablename with ID failed</font></p>";
} else {
   echo "<p><font color=\"red\">Data delete from Table: $tablename with ID failed</font></p>";
}

showItem($ID, $tablename, $col1, $col2);  

commonFooter();

?>
