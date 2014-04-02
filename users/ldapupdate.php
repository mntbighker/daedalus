<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

AuthCheck("Admin");

commonHeader("Daedalus - update LDAP info");

$language = "american_english";

$lang_array[american_english] = array ('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');


$dsCon = ldap_connect($cfg_ldapserver);
if(!(dsCon))
{
	PRINT "Sorry, cannot contact LDAP server\n";
	exit;
}

$bind = ldap_bind($dsCon);
if(!($bind))
{
	PRINT "Sorry, could not do an anonymous bind to your ldap server.<BR>\n";
	exit;
}

$pieces[0] = $cfg_ldapemail;
$pieces[1] = $cfg_ldapfullname;
$pieces[2] = $cfg_ldapphone;
$pieces[3] = $cfg_ldaplocation;

$sizeOfAlphabet = sizeof($lang_array[$language]);
PRINT "<UL>\n";
for ($i = 0; $i < $sizeOfAlphabet; $i++)
{
	$query = "select * from users where name LIKE '{$lang_array[$language][$i]}%'";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		while ($result = $sth->fetchrow_hash())
		{
			$name = $result["name"];
			$user = new User($name);
			$searchResult = ldap_search($dsCon, $cfg_serverroot, "uid=".$name, $pieces);
			$info = ldap_get_entries($dsCon, $searchResult);
			if($info != false)
			{
      	$fullname = $info[0][$cfg_ldapfullname][0];
      	$email = $info[0][$cfg_ldapemail][0];
      	$officephone = $info[0][$cfg_ldapphone][0];
      	$officelocation = $info[0][$cfg_ldaplocation][0];
      	$user->setEmail($email);
      	$user->setFullname($fullname);
      	$user->setLocation($officelocation);
      	$user->setPhone($officephone);
				PRINT "<LI>Updating user: ".$user->getName().", (".$user->getFullname().")</LI>\n";
				$user->commit();
			} else
			{
				PRINT "<LI>Deleting user: ".$user->getName().", (".$user->getFullname().")</LI>\n";
				$user->delete();
			}
		}
	}
}

PRINT "</UL>\n";

commonFooter();

?>
