<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

$report = $_REQUEST['report'];

// Do Authorization
AuthCheck("admin");

virtual("../perl/software-inv-${report}.pl");

?>