<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  7/22/99 - Keith Schoenefeld:	Cleaned up code, converted all IF(): to if(){. #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.irm");

AuthCheck("admin");

commonHeader("Daedalus User Setup - User Deleted");

$user = new User($username);

$user->delete();

logevent(-1, "IRM", 5, "setup", "$IRMName removed user $username");

?>

User <?php echo $username; ?> Deleted!  Note: All jobs assigned to/posted by this user are <STRONG>not</STRONG> deleted. 

<?php

PRINT "<a href=\"$USERPREFIX/setup-users.php\">Go Back</a>";

commonFooter();
?>
