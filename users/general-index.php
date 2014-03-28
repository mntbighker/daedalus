<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.surplus_header");
include_once("../include/func.dropdown_column");
include_once("../include/func.checkbox");
include_once("../include/func.asset_info");

// Required Input
//    $tablename - This Page Table name 

// Configuation Stored in DataBase Table 'asset_info' 
//    $col1      - Field to show in 1st column as anchor
//    $col2      - Field to show in 2nd column as plain text
//    $template  - Templates exist this Item Type: No, Yes
//    $required  - List of Fields that must be fillin to add a record
//    $defaults  - Array of Default Values for Checked Boxes
//    $log_max   - Number of addtional logical tests
//    $dropfield - Array of default Fields (Should match log_max in length)

// Start of Generic code

// initvar('test','logical','value','match','field','sort','fail','count','display');
initvar('count');

// Do Authorization
AuthCheck("normal");

$tablename = $_REQUEST['tablename'];
$logical = (isset($_REQUEST['logical'])) ? $_REQUEST['logical'] : $logical = array('','','','');
$value = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : $value = array('','','','');
$test = (isset($_REQUEST['test'])) ? $_REQUEST['test'] : $test = array('','','','');
$match = (isset($_REQUEST['match'])) ? $_REQUEST['match'] : $match = array('','','','');
$field = (isset($_REQUEST['field'])) ? $_REQUEST['field'] : $field = array('','','','');
$sort = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : "";
$fail = (isset($_REQUEST['fail'])) ? $_REQUEST['fail'] : "no";
if(isset($_REQUEST['display'])){
    $display = $_REQUEST['display'];
    if ( is_string($display) ) $display = explode("|", $display);
} else $display = "";

$name  = ucfirst($tablename);
$normal = strpos($tablename, 'surplus');

// Config: Database lookup using 'tablename'
$info_hash = getAssetInfo($tablename);

// Auto Set Variable Names Based on Column Names
extract($info_hash);

// DEFAULTS: Change Strings to Arrays 
// if ( is_string($required) )  $required  = explode(",", $required);
if ( is_string($defaults) )  $defaults  = explode(",", $defaults);
if ( is_string($dropfield) ) $dropfield = explode(",", $dropfield);

// STICKY: Change Strings to Arrays
if ( is_string($logical) ) $logical = explode("|", $logical);
if ( is_string($value) )   $value   = explode("|", $value);
if ( is_string($test) )    $test    = explode("|", $test);
if ( is_string($match) )   $match   = explode("|", $match);
if ( is_string($field) )   $field   = explode("|", $field);
if ( is_string($display) ) $display = explode("|", $display);

if ( $display[0] != '' ) $defaults = $display;

if ( $normal === false ) {
   commonHeader("$name");
} else {
   commonSurplusHeader("Daedalus $name"); 
}

PRINT "Welcome to the Daedalus Customer Tracking utility!  This is where you store
information about customers in your organization. 
Below are tools in which you can view your customers, as well as edit and add
entries. ";

PRINT "<hr noshade>";

if ( $fail == 'yes' ) {
   echo"<font color='red'><h3 align=center>No results found matching your query!</h3></font>";
};


// Check if Templates exist
if ( $tablename == 'computer' ) {
   $form = "computer-type_model.php";
} else {
   $form = 'general-add-form.php';
}

$vars = "?tablename=$tablename&required=$required";

// Setup Add item URL for NON Surplus Tables
if ( $normal === false ) {
PRINT <<<HTML1
   <table border=0 width=100%><tr>
   <td class="white" align="center">
   <h4><a href="${form}${vars}"> Add $name</a></h4>
   </td></tr>
   </table>
HTML1;

}

PRINT "<table border=1 width=100%><th>$name Search</th>";

   PRINT "<tr><td>";

   // Start Form
   PRINT "<form method=GET action=\"general-search.php\">";

    // Function to Display Checkbox for Each Field in Table
    CheckBox($tablename, 'display', $defaults);

    echo "<table width=\"100%\" border=\"0\">";

    echo "<tr>
            <th>&nbsp;</th>
            <th>Values</th><th>Test</th><th>Matches</th><th>In Field</th>
            <th> Sort By </th>
            <th>&nbsp;</th>
            </tr>";

    echo "<tr align = 'center'>";
    echo "<td>&nbsp;</td>";
    echo "<td><input type=text size=30 name=\"value[]\" value=$value[0]></td>";

    $like = ($test[0] == 'LIKE') ? 'selected' : NULL;
    $notlike = ($test[0] == 'NOT LIKE') ? 'selected' : NULL;
    echo "<td><select name=test[]>";
    echo "<option value=LIKE $like >Does</option>";
    echo "<option value='NOT LIKE' $notlike>Does Not</option>";
    echo "</select></td>";

    $contains = ($match[0] == 'contains') ? 'selected' : NULL;
    $exact    = ($match[0] == 'exact') ? 'selected' : NULL;
    echo "<td><select name=match[]>";
    echo "<option value=contains $contains >Contain</option>";
    echo "<option value=exact $exact >Match</option>";
    echo "</select></td>";

    // Function to Display Dropdown 
    $selected = $field[0] ? $field[0] : $dropfield[0];
    echo "<td>";
    DropColumn($tablename, "field[]", $selected);
    echo "</td>";

    echo "<td>";
    // Function to Display Dropdown 
    DropColumn($tablename, "sort", $sort);
    echo "</td>";

    PRINT "<td><input type=submit value=\"Search\"></td>";
      echo "</tr>";

      // Loop Over 2- 4 Search Input

      while ( $count++ < $log_max ) {

        // Logical Dropdown
        $and = ($logical[$count - 1] == 'AND') ? 'selected' : NULL;
        $or  = ($logical[$count - 1] == 'OR') ? 'selected' : NULL;
        echo "<tr align = 'center'>";
        echo "<td><select name=logical[]>";
        echo "<option value=AND $and>AND</option>";
        echo "<option value='OR' $or>OR</option>";
        echo "</select></td>";

        // Value Input field
echo "<td><input type=text size=30 name=\"value[]\" value=$value[$count]></td>";

        // Test Dropdown
        $like    = ($test[$count] == 'LIKE') ? 'selected' : NULL;
        $notlike = ($test[$count] == 'NOT LIKE') ? 'selected' : NULL;
        echo "<td><select name=test[]>";
        echo "<option value=LIKE $like>Does</option>";
        echo "<option value='NOT LIKE' $notlike>Does Not</option>";
        echo "</select></td>";

        // contains Dropdown
        $contains = ($match[$count] == 'contains') ? 'selected' : NULL;
        $exact    = ($match[$count] == 'exact') ? 'selected' : NULL;
        echo "<td><select name=match[]>";
        echo "<option value=contains $contains>Contain</option>";
        echo "<option value=exact $exact>Match</option>";
        echo "</select></td>";

        // Function to Display Dropdown 
        $selected = $field[$count] ? $field[$count] : $dropfield[$count];
        echo "<td>";
        DropColumn($tablename, "field[]", $selected);
        echo "</td>";
        echo "</tr>";

     } // End While Loop

      echo " </table>";

      // Push following values to next Page (Variables Set at TOP of Page)
      PRINT "<input type=hidden name=tablename value=$tablename>";

   PRINT "</form>";

   PRINT "</td></tr>";

PRINT "</table>";

commonFooter();

?>
