<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  7/22/99 - Keith Schoenefeld:	Cleaned up code, converted all IF(): to if(){. #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.irm");

AuthCheck("admin");

$user = new User();
$user->setName($username);
$user->setPassword($password);
$user->setFullname($fullname);
$user->setEmail($email);
$user->setLocation($building);
$user->setPhone($phone);
$user->setAccess($type);
$user->setComments($comments);
$user->add();

logevent(-1, "IRM", 5, "setup", "$IRMName add user $username.");

header("Location: $HTTP_REFERER");

?>
