<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.add_edit");

// Required inputs: 
//   $tablename - name of table in batabase
//   $ID        - ID of Template
//   $col1      - Column to check ID against
//   $required  - Can be Blank

// Do Authorization
AuthCheck("tech");

$tablename = $_REQUEST['tablename'];
$ID = $_REQUEST['ID'];
$col1 = $_REQUEST['col1'];
if (!isset($add)) $add = '';
if (!isset($submit)) $submit = '0';
if (!isset($template_id)) $template_id = '0';
$required = (isset($_REQUEST['required'])) ? $_REQUEST['required'] : $required = '';

// Create Page title
$name = ucfirst($tablename);

commonHeader("Daedalus $name  - Add/Edit Form");

// Test is UPDATE/INSERT was done: Success or Fail
if ($add == 1) 
{
  PRINT "<hr4><font color=\"blue\">Database Changed Successfully</font></h4>";
  PRINT "<hr noshade>";
} elseif ( isset($add) && $add != 1 ) {
  PRINT "<hr4><font color=\"darkgreen\">All Fields Matched Existing Data!</font>
</h4>";
  PRINT "<hr noshade>";
}

// Print Sub Header
if ( $submit == 'Add' || ! isset($ID) ) {
    unset($ID);
    PRINT "<p>Use this form to Add $name (Red/* Indicates Required Field)</p>";
} else {
    PRINT "<p>Use this form to Edit $name (Red/* Indicates Required Field)</p>";
}

// Start From
PRINT "<form method=post action=\"setup-general-add.php\">";

// Call Function to Create Editiable  HTML Table

AddEdit($tablename, $ID, $col1, $required, $template_id);

// Show and Lable Submit Button
PRINT "<table border=1 noshade>";
   PRINT "<tr>";

   if ( $ID ) {
      PRINT "<td><input type=submit name=submit value=Update></td>";
   } else {
      PRINT "<td><input type=submit name=submit value=Add></td>";
   }

   PRINT "</tr>";
PRINT "</table>";

// Ceate Hidden Fields
PRINT "<input type=hidden name=\"tablename\" value=\"$tablename\">";
PRINT "<input type=hidden name=\"${tablename}_id\" value=\"$ID\">";

PRINT "</form>";

commonFooter();

?>
