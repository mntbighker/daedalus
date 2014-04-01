<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.listcolumn");

// Required Inputs: 
//   $status
//   $author
//   $assign
//   $computer
//   $priority
//   $customer
//   $category
//   $groupname
//   $summary
//   $contents
//   $newfollowup
//   $year
//   $month
//   $day
//   $hour
//   $minute
//   $date      - Created from "$year-$month-$day $hour:$minute:00"

$HTTP_REFERER = $_SERVER['HTTP_REFERER'];

// Declare Local Variables: 
$tablename = 'tracking';

$status = $_REQUEST['status'];
$author = $_REQUEST['author'];
$assign = $_REQUEST['assign'];
$computer_id = $_REQUEST['computer_id'];
$priority = $_REQUEST['priority'];
$category = $_REQUEST['category'];
$customer = $_REQUEST['customer'];
$groupname = $_REQUEST['groupname'];
$summary = $_REQUEST['summary'];
$contents = $_REQUEST['contents'];
$newfollowup = $_REQUEST['newfollowup'];
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$hour = $_REQUEST['hour'];
$minute = $_REQUEST['minute'];
$date = "$year-$month-$day $hour:$minute:00";
$now = date("Y-m-d H:i");

// Trim $contents, $newfollowup
$contents    = trim($contents);
$newfollowup = trim($newfollowup);

// $vars = "assign=$assign&status=$status&priority=$priority&contents=$contents&newfollowup=$newfollowup";

// Setup Error Messages
$error1 = 'A Problem Description is Required';
$error2 = 'All Tickets Must Have a Followup';
$error3 = 'Tracking Table Entry Failed';
$error4 = 'Followups Table Entry Failed';

// Declare Global Variables: "Database Handle "
global $adb;

// Check for Discription
if ( empty($contents) ) {

   // fix URL separators
   $sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

   // Do Redirect Back to Referer
   exit(header("Location: ${HTTP_REFERER}${sept}error=$error1&${vars}"));
}

// All Tickets Must Have Followup
if ( empty($newfollowup) ) {

   // fix URL separators
   $sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

   // Do Redirect Back to Referer     
   exit(header("Location: ${HTTP_REFERER}${sept}error=$error2&${vars}"));
}

// Escape $contents, newfollowup
// $contents    = mysql_real_escape_string($contents);
// $newfollowup = mysql_real_escape_string($newfollowup);

// Set Closdate to NOW if Ticket is Complete
if ( $status == 'complete' ) {
   $closedate = $now;
}

// Get column Names
$labels = listtablecolumns($tablename);

// Throwaway Last Column: mod_date
array_pop($labels);

// Create List of "column = value" for INSERT
$var = '';
foreach ($labels as $label) {
   $var .=  "$label = " . '"' . ${$label} . '"' . ",";
}

// delete last ','
$var = rtrim($var, ",");

// Setup SQL INSERT statement 
$sql =  "INSERT ";
$sql .= " tracking SET ";

// Asmebly SQL 
$sql .= $var;

// Execute SQL
   $count = $adb->dbh->exec($sql) or print( mysql_error().': '.$sql);

// Check for Error: Tracking
if ( ! $count ) {
   // Do Redirect Back to Referer
   exit(header("Location: ${HTTP_REFERER}&error=$error3&${vars}"));
}

// Get the Tracking ID of New Call
$tID = $adb->insert_id();

// Log activity
logevent($tID, "tracking", 4, "database", "$IRMName added record");

if ( $newfollowup ) {
   $sql = "INSERT followups
             SET tracking = '$tID', date = '$now', 
                 author='$author', contents='$newfollowup'";
   $count = $adb->dbh->exec($sql) or print( mysql_error().': '.$sql);
}

// Check for Error: Followups
if ( ! $count ) {
   // Do Redirect Back to Referer
   exit(header("Location: ${HTTP_REFERER}&error=$error4&${vars}"));
}

// Get the Followup ID 
$fID = $adb->insert_id();

// Log activity
logevent($fID, "followups", 4, "database", "$IRMName added record");

exit(header("Location: ../users/index.php"));

?>
