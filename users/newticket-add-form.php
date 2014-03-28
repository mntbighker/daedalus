<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/func.header_footer");
include_once("../include/class.user");
include_once("../include/func.dropdown_date");
include_once("../include/func.dropdown_enum");
include_once("../include/func.drop_filter_list");

// Required inputs: 
//    $ID - computer_id

// Do Authorization
AuthCheck("post-only");

$ID = $_REQUEST['ID'];
$NEMS = $_REQUEST['NEMS'];

if (!isset($error)) $error = '';
if (!isset($category)) $category = 'application';
if (!isset($assign)) $assign = '';
if (!isset($status)) $status = '';
if (!isset($priority)) $priority = '';
if (!isset($summary)) $summary = '';
if (!isset($contents)) $contents = '';
if (!isset($newfollowup)) $newfollowup = '';

global $adb, $IRMName;

// Get/Check 'user' or 'owner' Based On 'ID' From 'computer' Table
$tablename = 'computer';
$field     = 'computer_id';
$col1      = 'computer_id';
$col2      = 'hostname';
                                                                                
$query = "SELECT owner, user, groupname, NEMS
            FROM computer 
           WHERE computer_id = $ID";
$sth = $adb->prepare($query) or print( mysql_error().': '.$query);
$res = $sth->execute();
list($owner,$user,$groupname,$nems1) = $sth->fetchrow_array($res);

$user || $user = $owner;

$NEMS || $NEMS = $nems1;

// Setup anchor for computer ID
$form = "../users/general-info.php";
$vars = "tablename=$tablename&field=$field&col1=$col1&col2=$col2";
$anchor = " <a href=\"$form?$vars&ID=$ID\">$NEMS</a> ";

// Get user email Based On 'lastname' From 'customer' Table
$query = "SELECT email,phone 
            FROM customer 
           WHERE lastname LIKE '$user' ";
$sth = $adb->prepare($query) or print( mysql_error().': '.$query);
$res = $sth->execute();
list($email,$phone) = $sth->fetchrow_array($res);

commonHeader("Daedalus Tracking - Add Job");

$error && print "<h3><font color=\"red\">$error</font><h3>";

print "<form method=post action=\"../users/newticket-add.php\">";

print "<table border=1 width = %100>";

print "<tr><th colspan = 3>New Trouble Call</th></tr>";

echo "<tr>";
echo "<td><b>Computer</b><br>$anchor</td>";
echo "<td><b>Mailto: Customer (Phone)</b><br><a href=\"mailto:$email\">$user</a>($phone)</td>";
echo "<td><b>Category</b><br>";
$category || $category = 'application';
dropFilterList('dropdown_category',category,category,0,$category);            
echo "</tr>";

echo "<tr>";
echo "<td><b>Assigned To</b><br>";
$assign || $assign = $IRMName;
dropFilterList('users','name','assign',$blank=0,$assign);
echo "</td>";
echo "<td><b>Status</b><br>";
$status || $status = 'assign';
dropFilterList('dropdown_status',status,status,0,$status);
echo "</td>";
echo "<td><b>Priority</b><br>";
$priority || $priority = 'normal';
dropFilterList('dropdown_priority',priority,priority,0,$priority); 
echo "</td>";
echo "</tr>";
  

echo "</table>";

print "<table border=1 width = %100>";

print "<tr><th>Terse Summary</th></tr>";
echo "<td valign=top>
      <textarea cols=60 Rows=1 name=summary>$summary</textarea></td>";

print "</table>";

print "<table border=1 width = %100>";

print "<tr><th>Describe the problem:</th></tr>";

print "<tr><td>";
print "<textarea cols=60 rows=10 wrap=soft name=contents>$contents</textarea>"; 
print "</td></tr>";

echo "<tr><td>";
echo "<strong>Date: </strong>";
dropdownDate('month', 1, 12, date(m));
echo " / ";
dropdownDate('day', 1, 31, date(d));
echo " / ";
dropdownDate('year', 2012, 2016, date(Y));

echo "&nbsp;&nbsp;<strong>Time: </strong>";
dropdownDate('hour', 1, 24, date(H));
echo " : ";
dropdownDate('minute', 1, 60, date(i));

echo "</td></tr>";

print "<tr><td>&nbsp;</td></tr>";

print "</table>";

print "<table border=1 width = %100>";

print "<tr><th>Add Followup</th></tr>";
echo "<td valign=top>
      <textarea cols=60 Rows=7 name=newfollowup WRAP=soft>$newfollowup</textarea></td>";

print "</table>";

print "<table border=1 width = %100>";

print "<tr><td>";
print "<input type=submit value=\"Add Job\"> ";
print "<input type=reset value=\"Reset\">";
print "</td></tr>";

print "</table>";

print "<input type=hidden name=computer_id  value=$ID>";
print "<input type=hidden name=customer  value=$user>";
print "<input type=hidden name=groupname value=$groupname>";
print "<input type=hidden name=author    value=$IRMName>";

print "</form>";

commonFooter();

?>
