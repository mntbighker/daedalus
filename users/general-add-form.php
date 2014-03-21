<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.surplus_header");

include_once("../include/func.asset_info");
include_once("../include/func.add_edit");
include_once("../include/func.add_db");

// Required inputs: 
//   $tablename - name of table in batabase
//   $required -  List of Fields that must be fillin to add a record

// Do Authorization
AuthCheck("tech");

$tablename = $_REQUEST['tablename'];
$required = $_REQUEST['required'];
$col1 = $_REQUEST['col1'];
$ID = $_REQUEST['ID'];

if (!isset($submit)) $submit = '';
if (!isset($model)) $model = '';

// Setup for Computer Type Model
if ( isset($selected) ) {
  $select = array_diff($selected, array(''));

  if (count($select) == 1) {  
    $model = array_pop($select);
  } else {
    if (count($select) > 1) $less = 'ONLY'; 
    $error = "Please choose $less 1. <br />";
    exit(header("Location: computer-type_model.php?tablename=$tablename&error=$error"));
  }                                                                            
}

// Config: Database lookup using 'tablename'
$info_hash = getAssetInfo($tablename);

// Auto Set Variable Names Based on Column Names
extract($info_hash);

// Change Input Arrays to String
if ( is_string($required) ) $required = explode(",", $required);

// Do DB Add/Update if Submit
if ( strtoupper($submit) == 'ADD' ) {
   list($dbmsg, $ID) = addDB($tablename, $required); 
}

if ( strtoupper($submit) == 'UPDATE' ) {
   list($dbmsg, $ID) = addDB($tablename, $required); 
}


// Create Page title
$name = ucfirst($tablename);
$normal = strpos($tablename, 'surplus');

if ( $normal === false ) { 
   commonHeader("Daedalus $name  - Add/Edit Form");
} else {
   commonSurplusHeader("Daedalus $name  - Add/Edit Form");
}


// Test is UPDATE/INSERT was done: Success or Fail
if ( isset($dbmsg) ) {
   echo "$dbmsg";
}

// Display HREF For New Item
if ( strtoupper($submit) == 'ADD' && isset($ID) && $ID ) { 
   $form = 'general-info.php';
   $anchor = "<a href=\"$form?tablename=$tablename&col1='computer'&col2='NEMS'&ID=$ID\">$ID</a>";

   echo "Added ID: $anchor <br />";
}

// Print Sub Header
if ( $submit == 'Add' || ! isset($ID) ) {
    unset($ID);
    PRINT "<p>Use this form to Add $name (Red/* Indicates Required Field)</p>";
} else {
    PRINT "<p>Use this form to Edit $name (Red/* Indicates Required Field)</p>";
}

// Start From
PRINT "<form method=post action=\"$PHP_SELF\">";

// Call Function to Create Editiable  HTML Table
AddEdit($tablename, $ID, $col1, $required, $model);

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

// Create Hidden Fields

$name_id = $tablename.'_id';

PRINT "<input type=hidden name=\"tablename\" value=\"$tablename\">";
PRINT "<input type=hidden name=\"$name_id\" value=\"$ID\">";

PRINT "</form>";

commonFooter();

?>
