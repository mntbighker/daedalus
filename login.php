<?php

include_once("./include/daedalus_conf.php");
include_once("./include/class.user");
include_once("./include/func.header_footer");

$cfg_dbdb = isset($dbuse) ? $dbuse : null;

$user = new User($_SESSION['DName']);

if($user->authenticate($_SESSION['DName'], ($_SESSION['DPass'])))
{
  header("Location: index.php");
  print "Bad username or password.";
  logevent(-1, "Daedalus", 1, "login", "Failed login: $DName");
}
else 
{
  $password = $user->getPassword();

  if ($DPass == 'daedalus-ts') {
    exit(header("Location: users/passwd.php"));
  }

  header("Location: users/");

}
?>
