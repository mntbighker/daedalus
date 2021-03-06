<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#Need to change REQUESTs to POSTs                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("admin");

$HTTP_REFERER = $_SERVER['HTTP_REFERER'];

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$fullname = $_REQUEST['fullname'];
$email = $_REQUEST['email'];
$building = $_REQUEST['building'];
$phone = $_REQUEST['phone'];
$type = $_REQUEST['type'];

if (!isset($comments)) $comments = '';

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

logevent(-1, "Daedalus", 4, "setup", "$DName add user $username.");

header("Location: $HTTP_REFERER");

?>
