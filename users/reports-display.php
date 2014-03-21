<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

// Do Authorization
AuthCheck("normal");


virtual("../perl/${report}_report.pl?month=$month&year=$year");

?>
