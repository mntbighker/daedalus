<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

$type = $_REQUEST['type'];

$date = date('M-d-Y');

$filename = "software-inv-$type-$date.xls";

$command = "/var/www/html/daedalus/perl/software-inv-${type}-dl.pl";

header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-type: application/x-msexcel");
header ("Content-Disposition: attachment; filename=\"" . $filename . "\"" );

passthru($command,$err);

?>
