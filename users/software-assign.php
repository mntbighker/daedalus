<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.software_assign");

// Required inputs: $tablename - name of table in batabase
//                  $required  - required table fields (field1,field2 ...)


// Declare Global variables for database handle and login name
global $adb, $IRMName;

// Test "$submit and do action

#commonHeader("Daedalus $name - Search Results");

// Add selected software and change owner if needed
($submit == 'Add') && $success = addSoftware($ID);

// Unassign selected software
($submit == 'Unassign') && $success = freeSoftware($ID);

// Moved selected software to a different resource
($submit == 'Move') && $success = moveSoftware($ID);

#print "Success: $success";

#commonFooter();

// Log activity
#logevent($cID, "$tablename", 4, "database", "$IRMName added record");

// fix URL separators
$sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

// Do Redirect Back to Referer
header("Location: ${HTTP_REFERER}${sept}submit=$submit&success=$success");


?>
