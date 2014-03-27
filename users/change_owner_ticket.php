<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/func.header_footer");
include_once("../include/class.user");

AuthCheck("post-only");

$ID = $_REQUEST['ID'];
$customer = $_REQUEST['customer'];
$ID = $_REQUEST['ID'];
$NEMS = $_REQUEST['NEMS'];

commonHeader("Daedalus Change Ticket Owner");

echo "<p>Original Ticket Owner: <b>$customer</b> NEMS:<b>$NEMS</b></p>";

echo "<p>";
echo "<form method=get action=\"../users/changeticket-search.php\"> ";
echo "Enter new owner of the ticket: (Wild Card Lookup)<br>";
echo "Name: <input type=text name=name size=15>";
echo "<input type=submit value=\"Continue with Name\">";
echo "<input type=hidden name=ID value=$ID>";
echo "<input type=hidden name=customer value=$customer>";
echo "<input type=hidden name=NEMS value=$NEMS>";
echo "</form>";
echo "</p>";

commonFooter();

?>
