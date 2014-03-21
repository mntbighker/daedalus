<?php
#    IRM - The Information Resource Manager
#    Copyright (C) 1999-2002 Yann Ramin & Keith Schoenefeld
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License (in file COPYING) for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#
#    $Id: irm.inc,v 1.50 2002/09/16 03:47:17 racer Exp $
#
################################################################################
# $root_path: The root path of the IRM installation.
# Set this to the actual path of where IRM is installed: this information
# is needed to find the configuration files. 
# Default: $root_path = "/full/path/to/irm";

$root_path = __DIR__ . '/..';

global $IRMName, $IRMPass, $cfg_dbdb;

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
#session_register("IRMName", "IRMPass", "cfg_dbdb");

if ( !isset($_SESSION['cfg_dbdb']) || $_SESSION['cfg_dbdb'] == '' ) {
  $_SESSION['cfg_dbdb'] = isset($_REQUEST['dbuse']) ? $_REQUEST['dbuse'] : null;
}
$cfg_dbdb = $_SESSION['cfg_dbdb'];

if ( !isset($_SESSION['IRMName']) || $_SESSION['IRMName'] == '' ) {
  $_SESSION['IRMName'] = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
}
$IRMName = $_SESSION['IRMName'];

if ( !isset($_SESSION['IRMPass']) || $_SESSION['IRMPass'] == '' ) {
  $_SESSION['IRMPass'] = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
}
$IRMPass = $_SESSION['IRMPass'];

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

# Setup config values.
$query = "select * from config";
$sth = $adb->prepare($query);
if($sth)
{
    $res = $sth->execute();
    $result = $sth->fetchrow_hash();
    $cfg_notifyassignedbyemail = $result["notifyassignedbyemail"];
    $cfg_notifynewtrackingbyemail = $result["notifynewtrackingbyemail"];
    $cfg_newtrackingemail = $result["newtrackingemail"];
    $cfg_groups = $result["groups"];
    $cfg_usenamesearch = $result["usenamesearch"];
    $cfg_userupdates = $result["userupdates"];
    $cfg_sendexpire = $result["sendexpire"];
    $cfg_showjobsonlogin = $result["showjobsonlogin"];
    $cfg_minloglevel = $result["minloglevel"];
    $LOGO = $result["logo"];
    $cfg_snmp = $result["snmp"];
    $cfg_snmp_rcommunity = $result["snmp_rcommunity"];
    $cfg_snmp_ping = $result["snmp_ping"];
    $cfg_knowledgebase = $result["knowledgebase"];
    $cfg_fasttrack = $result["fasttrack"];
        $cfg_anonymous = $result["anonymous"];
        $cfg_anon_faq = $result["anon_faq"];
         $cfg_anon_req = $result["anon_req"];
    $irm_version = $result["version"];
    #$irm_build = $result["build"];
    $sth->finish();
} else {
  PRINT "Could not prepare query: ".$sth->errstr."<BR>\n";
}

if ($cfg_snmp == 1) {
  include("$include_path/snmp.inc.php");
}


function AuthCheck($authtype) 
{
  global $IRMName, $IRMPass, $USERPREFIX, $adb, $bgcl, $bgcd, $cfg_dbdb;
  
  $user = new User($IRMName);
  $type = $user->getAccess();
  if (IsSet($IRMName) == FALSE) 
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
  global $cfg_minloglevel, $adb;
  if ($level <= $cfg_minloglevel)
        {
          $query = "INSERT INTO event_log VALUES (NULL, $item, '$itemtype', NOW(), '$service', $level, '$event')";
		  $adb->dbh->exec($query);
  }
}
                                                                                
?>
