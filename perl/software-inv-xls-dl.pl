#!/usr/bin/perl -w
#

use strict;
use DBI;

use CGI qw(:standard *table);
use Spreadsheet::WriteExcel;

use IO::Scalar;

my $user   = 'admin';
my $lpasswd = 'el0ret_kts';
my $db     = 'irm';

my $dbh = DBI->connect("DBI:mysql:$db", $user, $lpasswd,
            { PrintError => 1, RaiseError => 1})
    or die "connecting: $DBI::errstr";


my ($sql, @rows);

my $title = [ qw(
              S.software_id S.title S.description S.version S.serial_number
              S.os S.software_class S.license_num S.license_used S.software_type
              S.purchase_date S.groupname S.owner_history S.comments 
              C.computer_id C.NEMS C.building C.room C.user C.owner
              C.Ethernet_MAC 
) ];

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

      } # End Trouble While

$sth->finish;

$dbh->disconnect;

my %groups;

# Break out license groups
foreach my $row ( @rows) {
#   print "X:", $row->[0], "\n";
   push( @{$groups{$row->[0]}}, $row); 
}

my ($wkday,$month,$day,$time,$year) = split(/\s+/, localtime);


my $xls_str; 
tie *XLS, 'IO::Scalar', \$xls_str;
my $workbook = Spreadsheet::WriteExcel->new(\*XLS);

my $worksheet1 = $workbook->add_worksheet('Single'); 

my $format1 = $workbook->add_format(bold => 1, color => 'red', border => 1);
my $format2 = $workbook->add_format( color => 'blue');
my $format3 = $workbook->add_format( align => 'left', num_format => 0x01);

$worksheet1->write('A1', $title, $format1);
$worksheet1->set_column('A:A', undef, $format2);

my $i = 0;
foreach my $group ( sort keys %groups ) {
     foreach my $member ( $groups{$group} ) {
        next if ( @$member > 1 );
        next if ( $member->[0][7] > 1 );
        $i++;
        $worksheet1->write_col($i, 0, $member, $format3);
     } # End Member array
} # End Hash


# Multi-Licenses

my $worksheet2 = $workbook->add_worksheet('Multi License'); 

$worksheet2->write('A1', $title, $format1);
$worksheet2->set_column('A:A', undef, $format2);

my $j = 1;
foreach my $group ( sort keys %groups ) {
     foreach my $member ( $groups{$group} ) {
        next if ( (@$member == 1) && ($member->[0][7] == 1) );
        $worksheet2->write_col($j, 0, $member, $format3);
        $j += (@$member + 1);
     } # End Member array
} # End Hash


my $format4 = $workbook->add_format(num_format => '@');
$worksheet1->set_column('D:E', undef, $format4);

foreach my $worksheet ($workbook->sheets()) {
       $worksheet->set_landscape();
       $worksheet->set_header('&CCreated on &D');
    }

$workbook->close(); # This is required


print $xls_str;
