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
include_once("../include/func.showitem");
include_once("../include/func.showsoftware");
include_once("../include/func.showcomputer");
include_once("../include/func.showcomputer_software");
include_once("../include/func.show_ext_device");
include_once("../include/func.asset_info");

// Required inputs: 
//    $tablename - name of table in batabase
//    $ID        - item unique ID

// Do Authorization
AuthCheck("normal");

$tablename = $_REQUEST['tablename'];
$ID = $_REQUEST['ID'];

// Create Page title
$name = ucfirst($tablename);
$normal = strpos($tablename, 'surplus');

// Config Values: Database lookup using 'tablename'
$info_hash = getAssetInfo($tablename);

// Auto Set Variable Names Based on Column Names
extract($info_hash);

// Init Surplus Variable
$surplus = ( $normal === false ) ? 0 : 1;

if ( $normal === false ) { 
   commonHeader("Daedalus $name - Info");
} else {
   commonSurplusHeader("Daedalus $name - Info");
}         


// Show "New Tcket"
if ( $tablename == 'computer' ) {

// Setup Add item URL
PRINT <<<HTML1
   <table border=0 width=100%><tr>
   <td class="white">
   <h4><a href="../users/newticket-add-form.php?ID=$ID"> New Ticket</a></h4>
   </td></tr>
   </table>
HTML1;
}

// Call Function to Create 1 Item Information HTML Table
showItem($ID, $tablename, $col1, $col2);

// Show info for computers includes software info.
if ( $tablename == 'computer' ) {
   $surplus += ShowSoftware($ID);
}

// Show info for software includes computer info.
if ( $tablename == 'software' ) {
   $surplus += ShowComputer($ID);
}

// Show info for customer includes computer info, ext_devices
//   Software list for each computer is in function ShowComputer_Software
if ( $tablename == 'customer' ) {

   $surplus += ShowComputer_Software($ID);
   $surplus += ShowExtDevice($ID);
} 

if ( ! $surplus ) {
   echo "<form method=POST action=\"general-surplus.php\">";
   echo "<input type=hidden name=ID value=$ID>";
   echo "<input type=hidden name=tablename value=$tablename>";
   echo "<input type=hidden name=col1 value=$col1>";
   echo "<input type=hidden name=col2 value=$col2>";
   echo "<input type=submit name='submit' value=Surplus>";
   echo "</form>";
}

commonFooter();

?>
