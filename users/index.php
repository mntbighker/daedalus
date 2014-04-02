<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.getjobs");
include_once("../include/func.displaytickets");

// Declare Global variables for database handle and login name
global $adb, $DName;

$year = date("Y");

$form = "../users/tracking-search.php";

$tablename   = 'tracking';
$logical_str = '';
$test_str    = 'LIKE';
$match_str   = 'contains';
$field_str   = 'status';
$display_str = 'status|date|assign|priority|category|customer|summary';
$sort        = 'date';
$col1        = 'ID';
$col2        = 'status';
$page        = '';
$limit       = '';

// Vars1 Used by; New, Assigned, Hold, Unresolved
// Change value=XXX

$vars1 = "tablename=$tablename&logical=$logical_str&test=$test_str&match=$match_str&field=$field_str&display=$display_str&sort=$sort&col1=$col1&col2=$col2&page=$page&limit=$limit";

// Vars2 Used by; High

$logical_str = 'AND';
$value_str   = 'complete|high';
$test_str    = 'NOT LIKE|LIKE';
$match_str   = 'exact|contains';
$field_str   = 'status|priority';

$vars2 = "tablename=$tablename&logical=$logical_str&value=$value_str&test=$test_str&match=$match_str&field=$field_str&display=$display_str&sort=$sort&col1=$col1&col2=$col2&page=$page&limit=$limit";

// Vars3 Used by; New, Assigned, Hold, Unresolved
// Change value=XXX

$logical_str = 'AND';
$test_str    = 'LIKE|LIKE';
$match_str   = 'exact|contains';
$field_str   = 'status|assign';

$vars3 = "tablename=$tablename&logical=$logical_str&test=$test_str&match=$match_str&field=$field_str&display=$display_str&sort=$sort&col1=$col1&col2=$col2&page=$page&limit=$limit";

// Vars4 Used by; Completed

$logical_str = 'AND';
$value_str = "complete|$year";
$test_str    = 'LIKE|LIKE';
$match_str   = 'exact|contains';
$field_str   = 'status|date';

$vars4 = "tablename=$tablename&logical=$logical_str&value=$value_str&test=$test_str&match=$match_str&field=$field_str&display=$display_str&sort=$sort&col1=$col1&col2=$col2&page=$page&limit=$limit";


$new         = getJobs('status', 'new');
$high        = getJobs('priority', 'high', 'status', 'complete', 'NOT');
$assign      = getJobs('status', 'assigned');
$user_assign = getJobs('status', 'assigned', 'assign', $DName);
$hold        = getJobs('status', 'hold');
$unresolved  = getJobs('status', 'unresolved');
$completed   = getJobs('status', 'complete', 'date', $year);

$new && 
     $new = "<a href=\"$form?$vars1&value=new\">$new</a>";

$high && 
      $high = "<a href=\"$form?$vars2\">$high</a>";

$assign && 
       $assign = "<a href=\"$form?$vars1&value=assign\">$assign</a>";

$user_assign && 
  $user_assign = "<a href=\"$form?$vars3&value=assigned|$DName\">$user_assign</a>";

$hold && $hold = "<a href=\"$form?$vars1&value=hold\">$hold</a>";

$unresolved && 
  $unresolved  = "<a href=\"$form?$vars1&value=unresolved\">$unresolved</a>";

$completed && 
      $completed = "<a href=\"$form?$vars4\">$completed</a>";


commonHeader("Daedalus Command Center");

print "<p><div align = 'center'><table border=1>";

print "<h3>Ticket Status</h3>";

print "<tr>";
print "<th>&nbsp;New&nbsp;</th>";
print "<th>&nbsp;High Priority&nbsp;</th>";
print "<th>&nbsp;Assigned to $DName&nbsp;</th>";
print "<th>&nbsp;Assigned&nbsp;</th>";
print "<th>&nbsp;Held&nbsp;</th>";
print "<th>&nbsp;Unresolved&nbsp;</th>";
print "<th>&nbsp;Completed $year&nbsp;</th>";
print "</tr>";

print "<tr align = 'center'>";
print "<td>$new</td>";
print "<td>$high</td>";
print "<td>$user_assign</td>";
print "<td>$assign</td>";
print "<td>$hold</td>";
print "<td>$unresolved</td>";
print "<td>$completed</td>";
print "</tr>";

print "</table></div></p>";

$new  && displayTickets('status','new');

$high && displayTickets('priority', 'high', 'status', 'complete', 'NOT');

$assign && displayTickets('status','assigned');

commonFooter();

?>
