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
$month = $_REQUEST['month'];
$year = $_REQUEST['year'];

// Do Authorization
AuthCheck("normal");

virtual("../perl/${report}_report.pl?month=$month&year=$year");

?>