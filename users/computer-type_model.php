<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.drop_filter_list");

// Start of Generic code

// Do Authorization
AuthCheck("normal");

$name  = ucfirst($tablename);

  // Get Distinct List of field
  $query = "SELECT DISTINCT type FROM computer_model ORDER BY type";
  $sth   = $adb->prepare($query);
  $res   = $sth->execute()  or print( mysql_error().': '.$query );

  while ( list($type) = $sth->fetchrow_array($res) ) {
    $types[] = $type;
  }
  $sth->finish();                                                               

commonHeader("Daedalus $name Select");

$error && print"<p>ERROR: $error</p>";

echo "<form method=POST action=\"general-add-form.php\">";
echo "<p><table border=1 noshade>";
   echo "<tr>";
     foreach ($types as $type) {
        echo "<th>" . ucfirst($type) . "</th>";
     }
   echo "</tr>";

   echo "<tr>";
     foreach ($types as $type) {
        echo "<td>";
        dropFilterList('computer_model','model',"selected[]",1,"","type",$type);
        echo "</td>";
     }
   echo "</tr>";
echo "</table></p>";

echo "<p><input type=submit name='submit' value=\"Submit\"></p>";

// Create Hidden Fields
echo "<input type=hidden name=\"tablename\" value=\"$tablename\">";

echo "</form>";                                                   

commonFooter();

?>
