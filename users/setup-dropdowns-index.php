<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.drop_edit");

initvar('submit', 'SCRIPT_NAME');

// Do Authorization
AuthCheck("normal");

$tablename = $_REQUEST['tablename'];

if (isset($_REQUEST['type'])) {
  $type = $_REQUEST['type'];
}
if (isset($_REQUEST['new'])) {
  $new = $_REQUEST['new'];
}
if (isset($_REQUEST['selected'])) {
  $selected = $_REQUEST['selected'];
}
if (isset($_REQUEST['submit'])) {
  $submit = $_REQUEST['submit'];
}

$tablename && $field1 = array_pop(explode("_", $tablename, 2));

if ( $submit == 'Add' ) {

   if ($tablename == 'computer_model') {
      if ( $type && $new ) {
         dropInsert($tablename,$field1,$new,'type',$type);
      } else {
        $error = "Required: Type and New.<br />";
      }
   } else {
      if ( $new ) {
         $error = dropInsert($tablename,$field1,$new);
      } else {
        $error = "Required: New.<br />";
      }
   }
}

if ( $submit == 'Delete' ) {

   $select = array_diff($selected, array(''));

   if (count($select) == 1) {  
      $item = array_pop($select);
      $error = dropDelete($tablename,$field1,$item);
   } else {
      if (count($select) > 1) $less = 'ONLY'; 
      $error = "Please choose $less 1. <br />";
   }
}

$tables = dropTableList();

commonHeader("Daedalus - Computer Templates");

echo "Select Table Type";
echo "<p>";
foreach ($tables as $table) {   
   echo "<a href=\"$SCRIPT_NAME?tablename=$table\">$table</a><br />"; 
}
echo "</p>";
   
echo "<hr>";

if ( !$tablename ) return;

echo "Add or Delete Item from Table: $tablename";

if ($tablename == 'computer_model') { 
    dropShowModel($tablename,$field1); 
} else {
    dropShowTable($tablename,$field1); 
}

$submit && $error && print "<hr><font color='red'>$error</font>"; 

commonFooter();

?>
