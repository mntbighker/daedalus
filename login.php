<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

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
} else
{
        $password = $user->getPassword();

        if ($IRMPass == 'daedalus-ts') {
           exit(header("Location: users/passwd.php"));
         }

    // if ($f_req=='yes')
    // {
    //     header("Location: users/faq-index.php");
        // Can we pull this out yet?!?!  I guess we need to modify the update
        // script to search through all users and set up these prefs before we
        // do.
    //     $user->initPrefs();
    // } else 
    // {
        header("Location: users/");
        // Can we pull this out yet?!?!  I guess we need to modify the update
        // script to search through all users and set up these prefs before we
        // do.
        $user->initPrefs();
    // }
}
?>
