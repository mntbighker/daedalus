<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.surplus_header");
include_once("../include/func.asset_info");
include_once("../include/func.csv");

// Required Inputs: 
// $tablename - name of table in batabase

// $logical[] - Logical Test (AND/OR)
// $value[]   - Search Value
// $test[]    - Test type (LIKE/NOT LIKE)
// $match[]   - Exact or Wild Card Search
// $field[]   - Table Field to Search On
// $sort      - table field to sort on

// Optional Inputs: 
// $display - list of columns to dispay
// $page    - Page number for pager
// $limit   - Number of records to display per page

// Do Authorization
AuthCheck("normal");

$QUERY_STRING = $_SERVER['QUERY_STRING'];

$tablename = $_REQUEST['tablename'];
$logical = (isset($_REQUEST['logical'])) ? $_REQUEST['logical'] : $logical = array('','','','');
$value = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : $value = array('','','','');
$test = (isset($_REQUEST['test'])) ? $_REQUEST['test'] : $test = array('','','','');
$match = (isset($_REQUEST['match'])) ? $_REQUEST['match'] : $match = array('','','','');
$field = (isset($_REQUEST['field'])) ? $_REQUEST['field'] : $field = array('','','','');
$sort = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : "";
$page = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : "";
$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : "";
if(isset($_REQUEST['display'])){
    $display = $_REQUEST['display'];
    if ( is_string($display) ) $display = explode("|", $display);
} else $display = "";

// Config: Database lookup using 'tablename'
$info_hash = getAssetInfo($tablename);

// Auto Set Variable Names Based on Column Names
extract($info_hash);

// Create Page title
$name = ucfirst($tablename);
$normal = strpos($tablename, 'surplus');

if ( ! isset( $_GET["dump"] ) ) {
   commonHeader("Daedalus $name - Search Results");
   echo "<p><a href=\"general-index.php?$QUERY_STRING\">Restart Search</a></p>";
}         

// Call Function to Display CSV
SearchCVS($tablename, $logical, $value, $test, $match, $field,
           $sort, $col1, $col2, $display, $page, $limit);

if ( ! isset( $_GET["dump"] ) ) {
  commonFooter();
}

?>
