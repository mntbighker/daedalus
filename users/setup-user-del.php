<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("admin");

commonHeader("Daedalus User Setup - User Deleted");

$username = $_REQUEST['username'];

$user = new User($username);

$user->delete();

logevent(-1, "IRM", 5, "setup", "$IRMName removed user $username");

?>

User <?php echo $username; ?> Deleted!  Note: All jobs assigned to/posted by this user are <STRONG>not</STRONG> deleted. 

<?php

PRINT "<a href=\"$USERPREFIX/setup-users.php\">Go Back</a>";

commonFooter();
?>
