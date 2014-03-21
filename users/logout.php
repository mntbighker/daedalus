<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  7/22/99 - Keith Schoenefeld:	Cleaned up code, converted all IF(): to if(){. #
#  7/25/99 - Yann Ramin: Blanked cookies correctly.
#  8/03/99 - Yann Ramin: Closed SQL connection
################################################################################
error_reporting(E_ALL);
include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

session_destroy();

header("Location: $PREFIX");

//header("Location: $UPREFIX");

?>    
