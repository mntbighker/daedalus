<?php

include_once("./include/irm_conf.php");
include_once("./include/class.user");
include_once("./include/func.header_footer");

$cfg_dbdb = isset($dbuse) ? $dbuse : null;

$user = new User($_SESSION['IRMName']);

if($user->authenticate($_SESSION['IRMName'], ($_SESSION['IRMPass'])))
{
  header("Location: index.php");
  print "Bad username or password.";
  logevent(-1, "IRM", 1, "login", "Failed login: $IRMName");
}
else 
{
  $password = $user->getPassword();

  if ($IRMPass == 'daedalus-ts') {
    exit(header("Location: users/passwd.php"));
  }

  header("Location: users/");

}
?>
