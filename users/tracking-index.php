<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.dropdown_column");
include_once("../include/func.checkbox");
include_once("../include/func.asset_info");

initvar('sort','sort_default','fail','count');

// Do Authorization
AuthCheck("normal");

// Values Required for Later Pages
//    $tablename - This Page Table name 
//    $col1      - Field to show in 1st column as anchor
//    $col2      - Field to show in 2nd column as plain text
//    $template  - Templates exist this Item Type: No, Yes
//    $required  - List of Fields that must be fillin to add a record
//    $defaults  - Array of Default Values for Checked Boxes
//    $log_max   - Number of addtional logical tests
//    $dropfield - Array of default Fields (Should match log_max in length)

$tablename = 'tracking';
$value = (isset($_REQUEST['value'])) ? $_REQUEST['value'] : $value = array('','','','');
$test = (isset($_REQUEST['test'])) ? $_REQUEST['test'] : $test = array('','','','');
$match = (isset($_REQUEST['match'])) ? $_REQUEST['match'] : $match = array('','','','');
$field = (isset($_REQUEST['field'])) ? $_REQUEST['field'] : $field = array('','','','');
$sort = (isset($_REQUEST['sort'])) ? $_REQUEST['sort'] : "";
$logical = (isset($_REQUEST['logical'])) ? $_REQUEST['logical'] : "";
$fail = (isset($_REQUEST['fail'])) ? $_REQUEST['fail'] : "no";
if(isset($_REQUEST['display'])){
    $display = $_REQUEST['display'];
    if ( is_string($display) ) $display = explode("|", $display);
} else $display = "";

// Start of Generic code

// Config: Database lookup using 'tablename'
$info_hash = getAssetInfo($tablename);

$sort || $sort = $sort_default;

// Auto Set Variable Names Based on Column Names
extract($info_hash);

// Change Input Arrays to String
if ( is_string($required) )  $required  = explode(",", $required);
if ( is_string($defaults) )  $defaults  = explode(",", $defaults);
if ( is_string($dropfield) ) $dropfield = explode(",", $dropfield);

$name  = ucfirst($tablename);

commonHeader("Daedalus $name");

PRINT <<<TEXT
Welcome to the Daedalus Trouble Call Tracking utility!<br>
This is where you store information about customers in your organization. 
Below are tools in which you can view your customers, as well as edit and add
entries.
TEXT;

PRINT "<hr noshade>";

if ( $fail == 'yes' ) {
   echo"<font color='red'><h3 align=center>No results found matching your query!</h3></font>";
};


// Setup Add item URL
$form = '../users/newticket.php';

PRINT <<<HTML1
   <table border=0 width=100%><tr>
   <td class="white" align="center">
   <h4><a href="$form"> Add $name</a></h4>
   </td></tr>
   </table>
HTML1;

PRINT "<table border=1 width=100%><th>$name Search</th>";

   PRINT "<tr><td>";

   // Start Form
   PRINT "<form method=GET action=\"tracking-search.php\">";

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
      echo "<td><input type=text size=30 name=\"value[]\"></td>";

      PRINT "<td><select name=test[]>
                <option value=LIKE>Does</option>
                <option value='NOT LIKE'>Does Not</option>
              </select></td>";

      PRINT "<td><select name=match[]>
                <option value=contains>Contain</option>
                <option value=exact>Match</option>
              </select></td>";

      // Function to Display Dropdown 
      echo "<td>";
      DropColumn($tablename, "field[]", $dropfield[0]);
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
        echo "<tr align = 'center'>";
        echo "<td><select name=logical[]>
                  <option value=AND>AND</option>
                  <option value='OR'>OR</option>
                </select></td>";

        // Value Input field
        echo "<td><input type=text size=30 name=\"value[]\"></td>";

        // Test Dropdown
        echo "<td><select name=test[]>
                  <option value=LIKE>Does</option>
                  <option value='NOT LIKE'>Does Not</option>
                </select></td>";

        // contains Dropdown
        echo "<td><select name=match[]>
                  <option value=contains>Contain</option>
                  <option value=exact>Match</option>
                </select></td>";

        // Function to Display Dropdown 
        echo "<td>";
        DropColumn($tablename, "field[]", $dropfield[$count]);
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
