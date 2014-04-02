<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

ob_start();

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.surplus_header");
include_once("../include/func.asset_info");
include_once("../include/func.search");

initvar('limit','page');

$PHP_SELF = $_SERVER['QUERY_STRING'];
$SERVER_NAME = $_SERVER['SERVER_NAME'];

$tablename = $_REQUEST['tablename'];
$display = $_REQUEST['display'];
$logical = (isset($_REQUEST['logical'])) ? $_REQUEST['logical'] : $logical = array('','','','');
$value = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : $value = array('','','','');
$test = (isset($_REQUEST['test'])) ? $_REQUEST['test'] : $test = array('','','','');
$match = (isset($_REQUEST['match'])) ? $_REQUEST['match'] : $match = array('','','','');
$field = (isset($_REQUEST['field'])) ? $_REQUEST['field'] : $field = array('','','','');
$page = (isset($_REQUEST['page'])) ? $_REQUEST['page'] : "";
$sort = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : "";
$limit = (isset($_REQUEST['limit'])) ? $_REQUEST['limit'] : "";

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

// Config: Database lookup using 'tablename'
$info_hash = getAssetInfo($tablename);

// Auto Set Variable Names Based on Column Names
extract($info_hash);

// Create Page title
$name = ucfirst($tablename);
$normal = strpos($tablename, 'surplus');

if ( $normal === false ) { 
   commonHeader("Daedalus $name - Search Results");
} else {
   commonSurplusHeader("Daedalus $name - Search Results");
}         

echo "<p><a href=\"general-index.php?$PHP_SELF\">Restart Search</a>";
echo " | <a href=\"general-csv.php?$PHP_SELF\">Display CSV</a>";
echo " | <a href=\"general-csv.php?dump=1&$PHP_SELF\">Download CSV</a></p>";

// Call Function to Create Paged Information HTML Table //
$return = SearchView($tablename, $logical, $value, $test, $match, $field,
           $sort, $col1, $col2, $display, $page, $limit);

commonFooter();

if ( $return ) {
 $query = $_SERVER['QUERY_STRING'] . "&fail=yes";
 header("Location: https://$SERVER_NAME/daedalus/users/general-index.php?$query");
};

ob_flush();

?>
