<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  7/22/99 - Keith Schoenefeld:	Cleaned up code, converted all IF(): to if(){. #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.irm");
include_once("../include/func.header_footer");

include_once("../include/func.showitem");

AuthCheck("tech");

$message = '';
if ( $submit == 'Surplus' ) {
   $message = "<font color=\"red\"> - Please Verify to Surplus Item </font>";
}

commonHeader("Daedalus Surplus $message");

//logevent(-1, "IRM", 5, "surplus", "$IRMName surplussed $tablename $ID");

if ( $submit == 'Surplus' ) {
showItem($ID, $tablename, $col1, $col2);  

   echo "<form method=POST action=\"general-surplus-move.php\">";
   echo "<input type=hidden name=ID value=$ID>";
   echo "<input type=hidden name=tablename value=$tablename>";
   echo "<input type=hidden name=col1 value=$col1>";
   echo "<input type=hidden name=col2 value=$col2>";
   echo "<input type=submit name='submit' value=Verify>";
   echo "</form>";
}                                  

commonFooter();
?>
