<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.knowledgebase");

AuthCheck("post-only");

commonHeader("Daedalus Frequently Asked Question - Detailed View");
?>
<?php
$ID = $_REQUEST['ID'];
kbdisplayfullarticle($ID);
commonFooter();
?>
