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

commonHeader("Daedalus Knowledge Base - Modify Article");

$ID = $_REQUEST['ID'];

$query = "SELECT * FROM kbarticles WHERE (ID = $ID)";

$sth = $adb->prepare($query);
if($sth)
{
	$res = $sth->execute();
	$result = $sth->fetchrow_hash();
	$answer = $result["answer"];
	$question = $result["question"];
	$faq = $result["faq"];
	$categorylist = $result["categoryID"];
} else
{
	PRINT "Could not prepare query: ".$sth->errstr."<BR>\n";
}

PRINT "Here is where you can modify an article that is in the knowledge base.\n";
PRINT "<hr noshade>\n<BR>\n";
PRINT "<form method=post action=\"$USERPREFIX/knowledgebase-article-preview.php\">";
PRINT "Select the category in which this article should be placed: ";
kbcategoryList($categorylist);
PRINT "<br>\n<br>\nModify the question here.  Please be as detailed as possible with the question, but don't repeat information that can be inferred by the category.\n<br>\n";
PRINT "<textarea cols=50 rows=14 wrap=soft name=question>$question</textarea>"; 
PRINT "<br>\nModify the answer here.  Please be as detailed as possible with the answer, including a step by step process.\n<br>";
PRINT "<textarea cols=50 rows=14 wrap=soft name=answer>$answer</textarea>\n"; 
PRINT "<br>\n";
	PRINT "<input type=checkbox name=faq value=\"yes\" ";
	if($faq == "yes")
	{
		PRINT "checked";
	}
	PRINT ">Place this Knowledge Base Article into the publicly viewable FAQ as well.<BR>\n";
PRINT "<input type=hidden name=modify value=1>\n";
PRINT "<input type=hidden name=ID value=$ID>\n";
PRINT "<input type=submit value=\"Preview Article\"> <input type=reset value=\"Reset\"></form>\n";


commonFooter();


?>
