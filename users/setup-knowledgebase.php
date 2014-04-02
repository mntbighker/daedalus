<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.knowledgebase");

AuthCheck("tech");

commonHeader("Daedalus Knowledge Base Setup");

?>

Welcome to the Daedalus Knowledge Base Setup utility.  Here you can add, modify,
or delete a category from the Daedalus Knowledge Base.
<hr noshade>
<?php
$query = "SELECT * FROM kbcategories";
$sth = $adb->prepare($query);
if($sth)
{
	$res = $sth->execute();
	$numRows = $sth->rowCount();
	for($i = 0; $i < $numRows; $i++)
	{
		$result = $sth->fetchrow_hash();
  	$id = $result["ID"];
  	$categoryname = $result["name"];
  	$parentID = $result["parentID"];
	$fullcategoryname  = kbcategoryname($id);
  	PRINT "<form method=post action=\"$USERPREFIX/setup-knowledgebase-update.php\">
			<table width=100% border=1 noshade bordercolor=#000000>
			<tr bgcolor=#CCCCCC><td colspan=2><strong>$fullcategoryname
			</strong></td></tr>";
  	PRINT "<tr bgcolor=#DDDDDD>";
  	PRINT "<td><font face=\"arial, helvetica\">Category Name:
			<br><input type=text size=\"65%\" 
			name=categoryname value=\"$categoryname\">";
  	PRINT "</font></td>";
		PRINT "<td><font face=\"arial, helvetica\">As a subcategory of: ";
		$query2 = "select * from kbcategories where (ID = $parentID)";
		$sth2 = $adb->prepare($query2);
		if($sth2)
		{
			$res2 = $sth2->execute();
			$result2 = $sth2->fetchrow_hash();
			$current = $result2["ID"];
			kbcategoryList($current);
		} else
		{
			PRINT "Could not prepare query: ".$sth2->errstr."<br>\n";
		}
		PRINT "</font></td>\n";
		PRINT "\n</tr>\n";
  	PRINT "<tr bgcolor=#CCCCCC><td valign=center><input type=hidden 
			name=id value=\"$id\"><input type=submit 
			value=Update></form></td><td valign=center><form method=get 
			action=\"$USERPREFIX/setup-knowledgebase-del.php\"><input type=hidden 
			name=id value=\"$id\"><input type=hidden name=categoryname 
			value=\"$categoryname\"><input type=submit 
			value=Delete></form></td></tr></table>";
  	PRINT "<br>";
	}
} else
{
	PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
}
PRINT "<a name=\"add\"></a><hr noshade><h4>Add a Category</h4>";
PRINT "<form method=post action=\"$USERPREFIX/setup-knowledgebase-add.php\"><table width=100% 
		border=1 noshade bordercolor=#000000><tr bgcolor=#CCCCCC>
		<td colspan=2><strong>New Category</strong></td></tr>";
PRINT "<tr bgcolor=#DDDDDD> <td><font face=\"arial, helvetica\">Name:<br> 
		<input type=text size=\"65%\" name=categoryname></td>";
		PRINT "<td><font face=\"arial, helvetica\">As a subcategory of: ";
		kbcategoryList(0);
		PRINT "</td>";
PRINT "</tr>";
PRINT "<tr bgcolor=#CCCCCC><td colspan=2><input type=submit value=Add>
		</td></tr></table></form>";



commonFooter();

?>
