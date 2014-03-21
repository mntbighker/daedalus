<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.irm");
include_once("../include/func.listcolumn");

// Required Inputs: 
//   $tablename - name of table in batabase

// Declare Global variables for database handle and login name
global $adb, $IRMName;

$tablename = $_REQUEST['tablename'];

// Create labels from table column names
$labels = listtablecolumns($tablename);

// Throwaway Last Column: mod_date
array_pop($labels);

// Create List of "column = value" for UPDATE/INSERT
$var = '';
foreach ($labels as $label) {
   $var .=  "$label = " . '"' . ${$label} . '"' . ",";
}

// delete last ','
$var = rtrim($var, ",");

$tn_id = "${tablename}_id";

// Setup SQL UPDATE/INSERT statement 
$sql =  ( $$tn_id != '') ? "UPDATE" : "INSERT";
$sql .= " $tablename SET ";

// Asmebly SQL 
$sql .= $var;

$sql .= ( $$tn_id != '') ? " WHERE $tn_id = {$$tn_id} " : '';

// Execute SQL 
$count =  $adb->dbh->exec($query);
if ( mysql_errno() ) { print( mysql_error().': '.$sql ); }
   
// Mark Update Succesfully or not
$add = ($count) ? 1 : 0;

// Log activity
logevent($cID, "$tablename", 4, "database", "$IRMName added record");

// fix URL separators
$sept = ( strrpos ($HTTP_REFERER, '?') ) ? '&' : '?';

// Do Redirect Back to Referer
header("Location: ${HTTP_REFERER}${sept}submit=$submit&add=$add");

?>
