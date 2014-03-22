<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("normal");

$user = new User($IRMName);
        $currentpass  = $user->getPassword();

if($currentpass != $oldpassword)
{
     $error = "You have incorrectly entered your old password!";
     exit(header("Location: ../users/passwd.php?error=$error"));

} elseif (strlen($newpassword) < 6)
{
     $error = "Your new password must be at least 6 characters long!";
     exit(header("Location: ../users/passwd.php?error=$error"));
} elseif ($newpassword == $oldpassword)
{
     $error = "Your new and old password must be different!";
     exit(header("Location: ../users/passwd.php?error=$error"));
} elseif ($newpassword != $confirm)
{
     $error = "Your new password does not match the confirmation password. <br \>
               They must be the same!";
     exit(header("Location: ../users/passwd.php?error=$error"));
} else
{
	$user = new User($IRMName);
	$user->setPassword($newpassword);
	$user->commit();

        exit(header("Location: ../users/logout.php"));
}

?>
