<?php

# $root_path: The root path of the installation.

$root_path = __DIR__ . '/..';

global $DName, $DPass, $cfg_dbdb;

#This really needs to be changed to something like:
#$bgcd = #BBBBBB"; so that we can put it in the configuration page.

$bgcd = "BGCOLOR=#BBBBBB";
$bgcl = "BGCOLOR=#DDDDDD";

# There is NOTHING else to configure here.  EVERYTHING is in config.inc.php
#

$include_path = "$root_path/include";
include("$include_path/config.inc.php");
include_once("$include_path/func.initvar");
ini_set("include_path", $include_path."/DBI");
#
# Start and register session variables
session_start();
//print_r($_SESSION);
#session_register("DName", "DPass", "cfg_dbdb");

if ( !isset($_SESSION['cfg_dbdb']) || $_SESSION['cfg_dbdb'] == '' ) {
  $_SESSION['cfg_dbdb'] = isset($_REQUEST['dbuse']) ? $_REQUEST['dbuse'] : null;
}
$cfg_dbdb = $_SESSION['cfg_dbdb'];

if ( !isset($_SESSION['DName']) || $_SESSION['DName'] == '' ) {
  $_SESSION['DName'] = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
}
$DName = $_SESSION['DName'];

if ( !isset($_SESSION['DPass']) || $_SESSION['DPass'] == '' ) {
  $_SESSION['DPass'] = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
}
$DPass = $_SESSION['DPass'];

// if db name missing Goto Login
if ( $cfg_dbdb == '' ) {
   //return;
   //die('***5 missing cfg_dbdb');
   exit(header("Location: $PREFIX"));
}
$dbstr = "dbi:" . $cfg_dbtype . ":" . $cfg_dbdb . ";" . $cfg_dbname;
require("$root_path/include/DBI/class.DBI");
$adb = new DBI($cfg_dbtype, $cfg_dbname, $cfg_dbdb, $cfg_dbuser, $cfg_dbpasswd);
if( !$adb->dbh ){
  echo "Could not connect to the database [$cfg_dbdb].<BR>\n";
  exit();
}

function AuthCheck($authtype)
{
  global $DName, $DPass, $USERPREFIX, $adb, $bgcl, $bgcd, $cfg_dbdb;

  $user = new User($DName);
  $type = $user->getAccess();
  if (IsSet($DName) == FALSE)
    {
      commonHeader("Not Logged In");
      PRINT "  You were not logged in. (Check your browsers cookies)  ";
      PRINT "<A HREF=\"$PREFIX/index.php\">Go Back to the login screen</A>.";
      commonFooter();
      exit();
    } else
      {
    if ($authtype == "normal")
      {
        if ($type != "normal" && $type != "tech" && $type != "admin")
          {
        commonHeader("Permission Denied");
        PRINT "You are not a Normal User!";
        commonFooter();
        exit();
          }
      } else if ($authtype == "tech")
        {
          if ($type != "tech" && $type != "admin")
        {
          commonHeader("Permission Denied");
          PRINT "You are not an Technician!";
          commonFooter();
          exit();
        }
        } else if ($authtype == "admin")
          {
        if($type != "admin")
          {
            commonHeader("Permission Denied");
            PRINT "You are not an Administrator!";
            commonFooter();
            exit();
          }
          }
    {
      return 0;
    }
      }
}

function logevent($item, $itemtype, $level, $service, $event) {
  global $adb;
  if ($level <= 4)
        {
          $sql = "INSERT INTO event_log VALUES (NULL, '$item', '$itemtype', NOW(), '$service', '$level', '$event')";
		  $adb->dbh->exec($sql);
  }
}

?>
