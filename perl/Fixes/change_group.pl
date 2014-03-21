#!/usr/bin/perl
#

use warnings;
use strict;
use DBI;

my ($sql, $sth, $rv);
my ($ans, @oldgroups);

# Fix DB Or Exit
print q(WARNING: Do these items first as there might be a problem with incoming emails 
 or others access Daedalus!!
Update by hand Table: dropdown_groupname
Fix rmt2-bin/gatetest:
    $customer    = 'AS_Unsupp';  change TS_Unsupp
    $groupname   = 'AS';         change TS
copy  rmt2-bin/gatetest  rmt2-bin/rmt2-mailgate
\n\n);

print "Continue?(y/n): ";
($ans = <STDIN>) =~ tr/ //d;
exit if ( $ans !~ /^y/i );

my $user   = 'admin';
my $lpasswd = 'el0ret_kts';
my $db     = 'irm';

my $dbh = DBI->connect("DBI:mysql:$db", $user, $lpasswd,
            { PrintError => 1, RaiseError => 1})
    or die "connecting: $DBI::errstr";

sub in_array {
   my $needle = shift;
   return 1 if (grep $_ eq $needle, @_);
   return 0;
}

# Fix Customer Names
my %customer_name = (
   15184 =>  "TS",
   15182 =>  "TSA",
   15186 =>  "TSA_Inv", 
   15416 =>  "TSA_Surplus",
   15376 =>  "TSF_Inv",
   15183 =>  "TSM",
   15187 =>  "TSM_Inv",
   15428 =>  "TSM_Surplus",
   15188 =>  "TSN",
   15189 =>  "TSN_Inv",
   15429 =>  "TSN_Surplus",
   15185 =>  "TS_Inv",
   15430 =>  "TS_Surplus",
   15471 =>  "TS_Unsupp",
);

print "Fixing Customer Names in Customer Table\n";
foreach my $cid ( sort keys %customer_name ) {

   $rv = $dbh->do (qq{ UPDATE customer
                          SET lastname = "$customer_name{$cid}"
                        WHERE customer_id = "$cid" });
};

my %newgroups = (
   AS  => 'TS',
   ASA => 'TSA',
   ASF => 'TSF',
   ASM => 'TSM',
   ASN => 'TSN',
    AX => 'DT',
    PX => 'DT',
);

foreach my $old (sort keys %newgroups) {
  push @oldgroups, $old;
}

#
# Change Group Name in all required Tables
#  Tables
#     computer
#     customer
#     ext_device
#     odin
#     software
#     surplus_computer
#     surplus_customer
#     surplus_ext_device

# Special Cases
#     tracking
#     unix_hardware

my @tables = qw(computer
     customer
     ext_device
     odin
     software
     surplus_computer
     surplus_customer
     surplus_ext_device);

# Fix Tables

foreach my $table ( @tables ) {

   $sql = qq{ SELECT ${table}_id, groupname
               FROM  $table };

   $sth = $dbh->prepare( $sql );

   $sth->execute();

   my ($id, $groupname, %fix);

   $rv = $sth->bind_columns(\$id, \$groupname);

   while ($sth->fetch) {
     $fix{$id} = $groupname;
   }

   $sth->finish();

   print "TABLE: $table \n";

   foreach ( sort keys %fix ) {
      next unless in_array($fix{$_}, @oldgroups);
      my $newgr = $newgroups{ $fix{$_} };

   $rv = $dbh->do (qq{ UPDATE $table
                          SET groupname = "$newgr"
                        WHERE ${table}_id = "$_" });
   }

} # End Tables foreach

# Fix Special Cases
#     tracking
#     unix_hardware

# tracking unix_hardware 
foreach my $table qw(tracking unix_hardware) {

   $sql = qq{ SELECT id, groupname
               FROM  $table };

   $sth = $dbh->prepare( $sql );

   $sth->execute();

   my ($id, $groupname, %fix);

   $rv = $sth->bind_columns(\$id, \$groupname);

   while ($sth->fetch) {
     $fix{$id} = $groupname;
   }

   $sth->finish();

   print "TABLE: $table \n";

   foreach ( sort keys %fix ) {
      next unless in_array($fix{$_}, @oldgroups);
      my $newgr = $newgroups{ $fix{$_} };

   $rv = $dbh->do (qq{ UPDATE $table
                          SET groupname = "$newgr"
                        WHERE ID = "$_" });
   }

} # End Tables foreach

$dbh->disconnect;


