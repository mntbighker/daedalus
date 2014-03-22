<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.asset_info");

// Required inputs: 
//   $tablename - name of table in batabase

// Do Authorization
AuthCheck("tech");

// Create Page title
$name = ucfirst($tablename);

// Config: Database lookup using 'tablename'
$info_hash = getAssetInfo($tablename);

// Auto Set Variable Names Based on Column Names
extract($info_hash);

// Change Input Arrays to String
if ( is_string($required) ) $required = explode(",", $required);

commonHeader("$name Templates");

PRINT "<p>Select from one of the templates below to ease in adding a computer.  
       <br />If you wish to create/modify templates, please go to 
       the setup area.</p>";

// Get template list from DataBase and display
$query = "SELECT * FROM  ${tablename}_template ";

$sth = $adb->prepare($query);

$results = $sth->execute() or print( mysql_error().': '.$query);

while ($template = $sth->fetchrow_array($results)) {
  $tid = array_shift($template);
  $tname = array_shift($template);

   $vars = "?tablename=$tablename&template_id=$tid&col1=$col1&required=$required";

   PRINT "<a href=\"general-add-form.php${vars}\">$tname</a><br>";
}

commonFooter();

?>
