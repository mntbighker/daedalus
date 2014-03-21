#!/usr/bin/perl -w
#
use strict;

# use lib qw(/sw/lib/perl5 /sw/lib/perl5/darwin);

use CGI qw(:standard *table);
use CGI::Pretty;
use DBI;

# use POSIX;

my $month = strftime( "%B",localtime(time) );

my $dbuser   = 'admin';
my $lpasswd = 'el0ret_kts';

my $db     = 'irm';

# Group List 
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

my $mail_msg = "Monthly Computer Support For TS Division (TS-02)\n\n";
$mail_msg   .= "$month Total: $grandtotal\n\n";

#---------------------------------------------

foreach my $group ( @groups ) {

 $query = qq( 
     SELECT FORMAT( SUM(weight), 2)
     FROM computer 
     WHERE  groupname = '$group' OR groupname = '$group' );

  my($gtotal1) = $dbh->selectrow_array($query);

  $gtotal1 ||= 0;

  $query = qq( 
     SELECT FORMAT( SUM(weight), 2)
     FROM ext_device 
     WHERE  groupname = '$group' OR groupname = '$group' );

  my($gtotal2) = $dbh->selectrow_array($query);

  $gtotal2 ||= 0;

  my $gtotal = $gtotal1 + $gtotal2;

  $mail_msg .= "$group \tTotal: $gtotal \tComputers: $gtotal1 \tPrinters: $gtotal2\n";

} # End Foreach


my $first = 'Shannon';
my $last = 'Buffum';
my $email = 'sbuffum@eloret.com';

open(SENDMAIL, "|/usr/sbin/sendmail -oi -t")
                    or die "Can't fork for sendmail: $!\n";

   print SENDMAIL <<"EOF";
From: TS-Support < assupport\@asm.arc.nasa.gov >
To:  $first $last < $email >
Subject: TS Computer Support Information for $month

EOF

   print SENDMAIL $mail_msg;

close(SENDMAIL) or warn "sendmail didn't close nicely";

