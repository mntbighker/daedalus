<?php
#    IRM - The Information Resource Manager
#    Copyright (C) 2000 Yann Ramin
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
#    $Id: snmp.inc.php,v 1.3 2001/07/13 21:05:56 racer Exp $
#
################################################################################
#                                  CHANGELOG                                   #
################################################################################
# 1/1/00 - Yann Ramin: Started work on SNMP functions			       #
################################################################################

function SNMPgetComputerObject($computer, $object) {
	global $cfg_snmp_rcommunity, $adb;
	$query = "SELECT ip FROM computer WHERE computer_id = $computer";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		$result = $sth->fetchrow_hash();
		$ip = $result["ip"];
	}
	{
		PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	
	if ($ip == "" OR $ip == "dhcp" OR $ip == "DHCP") {
		return FALSE;
	}
	$mib = snmpget($ip, $cfg_snmp_rcommunity, $object);
	
	return $mib;
}

function SNMPwalkComputer($computer, $object) {
	global $cfg_snmp_rcommunity, $adb;
	$query = "SELECT ip FROM computer WHERE computer_id = $computer";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		$result = $sth->fetchrow_hash();
		$ip = $result["ip"];
	} else
	{
		PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	
	if ($ip == "" OR $ip == "dhcp" OR $ip == "DHCP") {
		return "Cannot talk to computer.";
	}
	$mib = snmpwalkoid($ip, $cfg_snmp_rcommunity, $object);
	
	return $mib;
}

function SNMPwalkComputerData($computer, $object) {
	global $cfg_snmp_rcommunity, $adb;
	$query = "SELECT ip FROM computer WHERE computer_id = $computer";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		$result = $sth->fetchrow_hash();
		$ip = $result["ip"];
	} else
	{
		PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	
	if ($ip == "" OR $ip == "dhcp" OR $ip == "DHCP") {
		return "Cannot talk to computer.";
	}
	$mib = snmpwalk($ip, $cfg_snmp_rcommunity, $object);
	
	return $mib;
}

function SNMPHTMLping($computer) {
	global $cfg_snmp_rcommunity, $adb;
	$query = "SELECT ip FROM computer WHERE computer_id = $computer";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		$result = $sth->fetchrow_hash();
		$ip = $result["ip"];
	} else
	{
		PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	
	if ($ip != "" OR $ip != "DHCP" OR $ip != "dhcp") {
	  	$out = exec(EscapeShellCmd("ping -c 1 -n -i 1 $ip"),$dummy_array, $ping_return);
	}
  	if ($ping_return == 2) {
  		$hstatus = "<font color=red>DOWN</font>";
	} else if ($ping_return == 0) {
		$hstatus = "<font color=green>UP</font>";
	} else {
		$hstatus = "UNKNOWN ERROR";
	}
	return $hstatus;
}

?>
