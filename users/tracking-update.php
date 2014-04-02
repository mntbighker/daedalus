<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/func.header_footer");
include_once("../include/class.user");
include_once("../include/func.listcolumn");

// Required inputs: 
   // tID       - Tracking ID
   // assign   - Person Assign to Trouble Call
   // status   - Status of Trouble Call
   // priority - priority of Trouble Call

// Optional inputs: 
   // newfollowup        - Text of New Followup
   // year, month, day   - Date followup submitted
   // hour, minute       - Time followup submitted
   // addtoknowledgebase - Add something to knowledgebase 
   // summary            - Add or modify summary
   //                      for a Complete Trouble Call.

$HTTP_REFERER = $_SERVER['HTTP_REFERER'];

$tID = $_REQUEST['tID'];
$assign = $_REQUEST['assign'];
$status = $_REQUEST['status'];
$priority = $_REQUEST['priority'];
$newfollowup = $_REQUEST['newfollowup'];
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$hour = $_REQUEST['hour'];
$minute = $_REQUEST['minute'];
$fcount = $_REQUEST['fcount'];
$summary = $_REQUEST['summary'];
$category = $_REQUEST['category'];
$close = '';

if(isset($_REQUEST['addtoknowledgebase'])){
    $display = $_REQUEST['addtoknowledgebase'];
}

// Declare Global variables for database handle and login name
global $adb, $DName, $tID;

// Set current Date Time in Mysql Format
$now = date("Y-m-d H:i");

// Default Info Message
$dmsg = "<br>Error Caused {Assigned To} and 'Status' To Be Reset";

// Status of 'new' is Illegal 
if ( $status == 'new' ) {
   $message = 
      "<hr4><font color=\"red\">Status Can Not Be 'New'</font></h4>".$dmsg;  

   // fix URL separators
   $sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

   // Do Redirect Back to Referer
   exit(header("Location: ${HTTP_REFERER}${sept}message=$message"));
}

// Ticket Must Be Assigned
if (empty($assign)) {
   $message = 
     "<hr4><font color=\"red\">Ticket Must Be Assigned</font></h4>".$dmsg;  

   // fix URL separators
   $sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

   // Do Redirect Back to Referer
   exit(header("Location: ${HTTP_REFERER}${sept}message=$message"));
}

// Trim Pre and Post White Spaces
$trimmedFollowup = trim($newfollowup);

// Ticket Must at Least 1 Followup
if ( ! $fcount && ! $trimmedFollowup ) {
   $message = "
    <hr4><font color=\"red\">Ticket Must at Least 1 Followup</font></h4>".$dmsg;

   // fix URL separators
   $sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

   // Do Redirect Back to Referer
   exit(header("Location: ${HTTP_REFERER}${sept}message=$message"));
}

// Get Old Status for Tracking ID
// ***5 Replace all these built up sql statements with prepared statements
//     query = "SELECT status FROM tracking WHERE ID = $tID";
$statusQuery = "SELECT status FROM tracking WHERE ID = $tID";
$statusStmt  = $adb->prepare($statusQuery);

// ^^^5 No need to check for errors, exception will be tossed
// res = $sth->execute() or print( mysql_error().': '.$query);
$statusStmt->execute(array('tID' => $tID));

// ***5 use fetchOne when we expect one and only one row
//        this helps to avoid the unbuffered query nonsense
// list($oldstatus) = $sth->fetchrow_array($res);
$statusRow = $statusStmt->fetchOne();
$oldstatus = $statusRow['status'];

// If Call is Not Closed and status Equals 'complete' Set 'closedate'
if ($oldstatus != 'complete' and $status == 'complete' ) {
  $close = ",closedate = '$now:00' ";
}

# No Negative Dates
// Build datetime For Mysql
$dateFollowup = "$year-$month-$day $hour:$minute:00";

$timediff = "SEC_TO_TIME( (TO_DAYS('$dateFollowup')*24*3600+TIME_TO_SEC('$dateFollowup')) - (TO_DAYS(date)*24*3600+TIME_TO_SEC(date)) )";

$diffQuery = "SELECT $timediff as diff FROM tracking WHERE ID = $tID";
$diffStmt = $adb->prepare($diffQuery);
$diffStmt->execute(array('tID' => $tID));
$diffRow = $diffStmt->fetchOne();
$diff = $diffRow['diff'];

$pos1 = strpos($diff, '-');
if ( $pos1 !== false ) {
   $message = "
    <hr4><font color=\"red\">Date entered is before call created: $dateFollowup</font></h4>";
   // fix URL separators
   $sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

   // Do Redirect Back to Referer
   exit(header("Location: ${HTTP_REFERER}${sept}message=$message"));
}                                                                               

// Setup SQL Tracking Table UPDATE statement 
// ***5 TODO: This should use prepared statements
$sql = "UPDATE tracking ";
$sql .= " SET ";
$sql .= " status = '$status' ";

// Only update if Call is Not complete
if ($oldstatus != 'complete' ) {
   $sql .= " ,summary = '$summary' , assign = '$assign' , priority = '$priority' , category = '$category' ";
}

//Add 'closedate if required
$close && $sql .= $close;

$sql .= " WHERE ID = $tID";

// Execute SQL 
//   Mysql: Value Matches Current Value 0 Rows Returned
$count1 = $adb->dbh->exec($sql);
if ( mysql_errno() )  {
   print(mysql_error().': '.$sql);
}

// Trim Pre and Post White Spaces
$trimmedFollowup = trim($newfollowup);

// Insert followup only if contents exist and status not Complete
if ( $trimmedFollowup and $oldstatus != 'complete' ) {
/*
   // Protect for Bad User Input
   $escapeFollowups = mysql_escape_string($trimmedFollowup);

   // Setup SQL 'followups' Table UPDATE statement 
   $sql = " INSERT INTO followups 
            SET tracking = '$tID', date = '$dateFollowup', 
                author ='$DName', contents = '$escapeFollowups' ";

   // Execute SQL 
   $count2 = $adb->dbh_do($sql) or print( mysql_error().': '.$sql);
*/
    // **5 Use prepared statements for inserts

    $followupsSql = <<<EOT
INSERT INTO followups 
SET tracking = :tID, 
    date     = :dateFollowup,
    author   = :DName,
    contents = :trimmedFollowup
EOT;
   $followupsStmt = $adb->prepare($followupsSql);
   $count2 = $followupsStmt->execute(array(
       'tID'             => $tID, 
       'dateFollowup'    => $dateFollowup, 
       'DName'         => $DName, 
       'trimmedFollowup' => $trimmedFollowup
   ));
   
} // End If

// Test for Adding Information to Knowledge Base
if ($status == 'complete' and $addtoknowledgebase == 'yes' ) {
 exit(header("Location: knowledgebase-article-add.php?from_tracking=$tID"));
}

// Mark Update Succesfully or Not
$msg = "<hr4><font color=\"darkgreen\">Database Change Succeeded</font></h4>";

($count1 + $count2) || $error ="Ticket Change Failed"; 
$count2 || $error ="No Followup to Add"; 

if ($oldstatus == 'complete' and ! $count2 ) {
   $error ="Completed Tickets can Only Have Their Status Changed";
}

$error && $msg = "<hr4><font color=\"red\">$error</font></h4>";


// Log activity
$count1 && logevent($tID,"tracking", 4, "database", "$DName modified record");
$count2 && logevent($tID,"followups", 4, "database", "$DName added record");

// fix URL separators
$sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

// Do Redirect Back to Referer
exit(header("Location: ${HTTP_REFERER}${sept}message=$msg"));

?>