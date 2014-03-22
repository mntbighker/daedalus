<?php

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
