<?php

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("normal");

$resetpw = 'daedalus-ts';

$user = new User($username);

$user->setPassword($resetpw);
$user->commit();

exit(header("Location: ../users/setup-users.php"));

?>
