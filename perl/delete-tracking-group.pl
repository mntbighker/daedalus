#!/usr/bin/perl
#

use warnings;
use strict;
use DBI;

my ($sql, $sth, $rv);
my ($ans, @oldgroups);

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

# Fix tracking

foreach my $grp qw(TSF YAA DT) {

   $sql = qq{ SELECT id, groupname
               FROM  tracking 
              WHERE groupname LIKE "$grp"};

   $sth = $dbh->prepare( $sql );

   $sth->execute();

   my ($id, $groupname);
   $rv = $sth->bind_columns(\$id, \$groupname);

   # Tracking Fetch
   while ($sth->fetch) {
     
        my $sql1 = qq( SELECT id, tracking
                      FROM  followups
                     WHERE tracking LIKE "$id");
        my $sth1 = $dbh->prepare( $sql1 );
        $sth1->execute();

        my ($id1, $tracking);
        my $rv1 = $sth1->bind_columns(\$id1, \$tracking);

        # Followups Fetch
        while ($sth1->fetch) {
           print "X: deleting $groupname, $tracking , $id1\n";
           my $row = $dbh->do ( qq(DELETE FROM followups
                                    WHERE id = $id1) );
        }

        print "Y: Delete Tracking ID: $id\n"
   #     my $row = $dbh->do ( qq(DELETE FROM tracking
   #                              WHERE id = $id) );
   }

   $sth->finish();

} # End Tables foreach

$dbh->disconnect;


