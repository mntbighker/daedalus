<?php

# NOTE: This is NOT used anymore. Time to develop it was not available for the 1.4.0 release. 

class UserDriver 
{
	var $user_values;

	function UserDriver() 
	{
	}

	function authenticate($u, $p) 
	{
		global $adb;

		# TODO: MD5 Password hashes, encryption

		$q = $adb->prepare("SELECT name FROM users WHERE name = '$u' AND password = '$p'");
		$q->execute();
		$r = $q->fetchrow_hash();
		if ($r[name] == $u) 
		{
			return(0);
		} else 
		{
			return(1); # error!
		}
	}

	function services() 
	{
		$service[add] = 1;
		$service[delete] = 1;
		$service[typemap] = 0; 
		return $service;
	}

	function retrieve($name) 
	{
		global $adb;
		$data[Name] = $name;

		$query = "SELECT fullname,email,location,phone,type,comments FROM users WHERE (name = '".$data[Name]."')";
		$sth = $adb->prepare($query);
		$res = $sth->execute();
		$result = $sth->fetchrow_hash();
			# password removed
		$data[Fullname] = $result["fullname"];
		$data[Email] = $result["email"];


		$data[Location] = $result["location"];
		$data[Phone] = $result["phone"];
		$data["Type"] = $result["type"];

		$data[Comments] = $result["comments"];
		

		return $data; # get returned data	
	}
}
?>