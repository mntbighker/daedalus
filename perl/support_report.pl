#!/usr/bin/perl -w
#
use strict;

# use lib qw(/sw/lib/perl5 /sw/lib/perl5/darwin);

use CGI qw(:standard *table);
use CGI::Pretty;
use DBI;

use Getopt::Std;

my %Options;
getopts('S', \%Options);

my $dbuser   = 'admin';
my $lpasswd = 'el0ret_kts';

my $db     = 'irm';


my $newStyle=<<END;
<!-- 
   Th {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10pt;
      font-weight: bold;
      background-color: #D3DCE3;
   }

  Td {
     background-color: #EEEEEE;
     }
-->
END

# List Groups
my @groups = qw(TS TSA TSM TSN TSS TSSN);

my $dbh = DBI->connect("DBI:mysql:$db", $dbuser, $lpasswd,
            { PrintError => 1, RaiseError => 1})
    or die "connecting: $DBI::errstr";

my $query = qq( 
   SELECT FORMAT( SUM(weight), 2)
   FROM computer 
);

my($total1) = $dbh->selectrow_array($query);

$query = qq( 
   SELECT FORMAT( SUM(weight), 2)
   FROM ext_device 
);

my($total2) = $dbh->selectrow_array($query);

my $grandtotal = $total1 + $total2;


print header() unless $Options{S};

print start_html( -title=>'TS Trouble Tracking Report',
                  -style=>{-code=>$newStyle, -media=>"screen, print"}
                 );

print "<p><h2>Monthly Support For TS Divsion - Total: $grandtotal</h2></p>";

#---------------------------------------------

my $query1 = qq(
   SELECT owner, user, type, weight, building, room
   FROM computer
   WHERE weight > 0 AND ( groupname = ? )
   ORDER BY type
);

my $sth1 = $dbh->prepare( $query1 );

my $query3 = qq(
   SELECT owner, user, ext_type,  ext_model, weight, building, room
   FROM ext_device
   WHERE weight > 0 AND ( groupname = ? )
   ORDER BY ext_model
);

my $sth3 = $dbh->prepare( $query3 );

foreach my $group ( @groups ) {

  my($owner, $user, $type, $model, $weight, $building, $room);

  $query = qq( 
     SELECT FORMAT( SUM(weight), 2)
     FROM computer 
     WHERE groupname = '$group' );

  my ($gtotal1) = $dbh->selectrow_array($query);

  $gtotal1 ||= 0;

  $query = qq( 
     SELECT FORMAT( SUM(weight), 2)
     FROM ext_device 
     WHERE groupname = '$group'  );

  my ($gtotal2) = $dbh->selectrow_array($query);

  $gtotal2 ||= 0;

  my $gtotal = $gtotal1 + $gtotal2;

  $sth1->execute($group );

  $sth1->bind_columns(\($owner, $user, $type, $weight, $building, $room) );

  print "<p>";
  print start_table({-border=>1, -cellpadding=>'2', -cellspacing=>'2'});

  print "<tr><td class=white colspan = 5 align = 'center'>$group Total: $gtotal</td></tr>";
  print "<tr><th colspan = 5>Supported Machines</th></tr>";
  print "<tr>
         <th>user</th>
         <th>type </th>
         <th>weight</th>
         <th>building</th>
         <th>room</th>
         </tr>";

  while ( $sth1->fetch) {
     $user ||= $owner;
     print "<tr>
            <td>$user</td>
            <td>$type</td>
            <td>$weight</td>
            <td>$building</td>
            <td>$room</td>
            </tr>";
  }


  print "<tr><th colspan = 5>Printers</th></tr>";

  $sth3->execute($group );

  $sth3->bind_columns(\($owner, $user, $type, $model, $weight, $building, $room) );

  print "<tr>
         <th>User</th>
         <th>Model</th>
         <th>Weight</th>
         <th>Building</th>
         <th>Room</th>
       </tr>";

  while ( $sth3->fetch) {
     $user ||= $owner;
     print "<tr>
            <td>$user</td>
            <td>$model</td>
            <td>$weight</td>
            <td>$building</td>
            <td>$room</td>
          </tr>";
  }

  print end_table();
  print "</p>";

  print q(<div style="page-break-after:always"></div>);


} # End Foreach

print end_html();


