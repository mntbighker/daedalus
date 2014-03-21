<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/func.header_footer");
include_once("../include/class.user");

AuthCheck("post-only");

commonHeader("Daedalus - Select New Ticket Owner");

echo "<p>Original Ticket Owner: <b>$customer</b> NEMS:<b>$NEMS</b></p>"; 
 
echo "Click on the computer's ID to select.";

print "<hr noshade>";

// Check Table 'computer'
$query = "SELECT COUNT(*) FROM computer 
          WHERE weight > 0 AND 
                (owner LIKE '%$name%' OR user LIKE '%$name%')";
$sth = $adb->prepare($query);
$res = $sth->execute() or print( mysql_error().': '.$query );

// Number of rows returned from above query.
list($numrows) = $sth->fetchrow_array();

if ( $numrows < 1 ) {
   print "Bad Daedalus ID or search terms";

} elseif ($numRows > 10) {
print "Your search terms were to vague, and yeilded more than 10 results.  
       Please try again.";

} else {

   // Get Info from Table 'computers'
   $query = "SELECT computer_id,NEMS,owner,user,type,building
               FROM computer
              WHERE weight > 0 AND
                    (owner LIKE '%$name%' OR user LIKE '%$name%')";
   $sth = $adb->prepare($query);
   $res = $sth->execute() or print( mysql_error().': '.$query );

   echo "<table>";
   echo "<th>Computer ID</th><th>Owner<th>User</th></th><th>Type</th><th>Location</th>";
   while ( $row = $sth->fetchrow_hash() ) {
      extract($row);

      echo "<tr>";
      echo "<td>";
      $user || $user = $owner; 
  echo "<a href=\"../users/tracking-info.php?ID=$ID&changed=yes&customer=$user&computer_id=$computer_id\">$NEMS</a>";   
      echo "</td>";
      echo "<td>$owner</td>";
      echo "<td>$user</td>";
      echo "<td>$type</td>";
      echo "<td>$building</td>";
      echo "</tr>";

   } // End While
   echo "</table>";

} // End If

commonFooter();

?>
