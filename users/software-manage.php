<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.software_list");

// Required  inputs: 
// $ID  computer_id 

// Declare Global variables for database handle and login name
global $adb, $IRMName;

// Do Authorization
AuthCheck("Tech");

commonHeader("Daedalus Software Manager");

// Display Error
if ( ! $success and $submit ) {
   print "<hr4><font color=\"red\">$submit: Failed</font></h4>";
}

// Function to display, move or delete software titles
manageDisplaySoftware($ID);

PRINT "<hr noshade>";

// Function to display and add software titles to computer ID
addDisplaySoftware($ID);

commonFooter();

?>
