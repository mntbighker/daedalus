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

// Declare Global variables for database handle and login name
global $adb, $DName;



commonSurplusHeader("Daedalus Surplus System"); 

echo "<p>
<a href=\"$USERPREFIX/general-index.php?tablename=surplus_computer\">Surplus Computers</a>
</p>";

echo "<p>
<a href=\"$USERPREFIX/general-index.php?tablename=surplus_ext_device\">Surplus Ext Devices</a>
</p>";

echo "<p>
<a href=\"$USERPREFIX/general-index.php?tablename=surplus_software\">Surplus Software</a>
</p>";


echo "<p>
<a href=\"$USERPREFIX/general-index.php?tablename=surplus_customer\">Surplus Customer</a>
</p>";


commonFooter();

?>
