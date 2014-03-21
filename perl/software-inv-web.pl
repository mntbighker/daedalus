#!/usr/bin/perl
#

use strict;
use DBI;

use CGI qw(:standard *table);

my $user   = 'admin';
my $lpasswd = 'el0ret_kts';
my $db     = 'irm';

my $dbh = DBI->connect("DBI:mysql:$db", $user, $lpasswd,
            { PrintError => 1, RaiseError => 1})
    or die "connecting: $DBI::errstr";

my ($sql, @rows);

my @title =qw(
              S.software_id S.title S.description S.version S.serial_number
              S.os S.software_class S.license_num S.license_used S.software_type
              S.purchase_date S.groupname S.owner_history S.comments 
              C.computer_id C.NEMS C.building C.room C.user C.owner
              C.Ethernet_MAC 
);

# Start Trouble Tracking 

$sql =  qq[ SELECT S.software_id, S.title, S.description, S.version, S.serial_number,
                   S.os, S.software_class, S.license_num, S.license_used, S.software_type,
                   S. purchase_date, S.groupname, S.owner_history, S.comments, 
                   C.computer_id, C.NEMS, C.building, C.room, C.user, C.owner, 
                   C.Ethernet_MAC
                 FROM computer_software CS,  software S, computer C
                WHERE S.software_id = CS.software_id AND C.computer_id = CS.computer_id 
             ORDER BY S.software_id ];

    my $sth = $dbh->prepare( $sql );

     $sth->execute();

     while ( my @list = $sth->fetchrow_array() ) {

        push(@rows, [@list] ); 
#        push(@rows, td(\@list)); 

      } # End Trouble While

$sth->finish;

$dbh->disconnect;

my %groups;

# Break out license groups
foreach my $row ( @rows) {
#   print "X:", $row->[0], "\n";
   push( @{$groups{$row->[0]}}, $row); 
}

my @outrows1 = th(\@title);

# Single License

foreach my $group ( sort keys %groups ) {
     foreach my $member ( $groups{$group} ) {
        next if ( @$member > 1 );
        next if ( $member->[0][7] > 1 );
        foreach my $line ( @$member ) {
             push(@outrows1, td(\@$line));
        } # End Line
     } # End Member array
} # End Hash


my ($wkday,$month,$day,$time,$year) = split(/\s+/, localtime);

# Setup StyleSheet
my $newStyle=<<END;
<!-- 
   Th {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 10pt;
      font-weight: bold;
      background-color: #D3DCE3;
   }

  Td.Break {
     background-color: #EEEEEE;
     }
-->
END

print header;

print start_html( -title=>"Software Inventory for $month-$day-$year",
                  -style=>{-code=>$newStyle}
	         );

print h1("Software Inventory for $month-$day-$year");

# Single License
print table({-border=>1,-cellpadding=>'2',-cellspacing=>'2'},
            caption(b('Software Inventory: Single licsense')), 
            Tr(\@outrows1)
           );

# Milti-License
foreach my $group ( sort keys %groups ) {
     foreach my $member ( $groups{$group} ) {
        next if ( (@$member == 1) && ($member->[0][7] == 1) );
        my @multiout;
        push(@multiout, th(\@title));
        foreach my $line ( @$member ) {
             push(@multiout, td(\@$line));
        } # End Line

        
        print "<p>";
        print table({-border=>1,-cellpadding=>'2',-cellspacing=>'2'},
            caption(b("Software Inventory: Multi-license")), 
            Tr(\@multiout)
        );
        print "</p>";

     } # End Member array
} # End Hash

print end_html;

