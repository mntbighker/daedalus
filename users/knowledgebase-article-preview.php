<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.knowledgebase");

AuthCheck("tech");
commonHeader("Daedalus Knowledge Base Article - Preview");

/* Start error checking */

if ($question == "") 
{
	$error = 1;
	PRINT "The following error occured with your request for help:  You did not enter any question.<br>";
}

if ($answer == "") 
{
	$error = 1;
	PRINT "The following error occured with your request for help:  You did not enter any answer.<br>";
}

$categoryname = kbcategoryname($categorylist);

if ($categoryname == "") 
{
	$error = 1;
	PRINT "The following error occured with your request for help:  You did not enter any category (You may not post Knowledge Base Articles in Main).<br>";
}

if ($error != 1) 
{
	PRINT "Please check that the article you are about to submit is correct.  If it is not, use the provided links to re-edit it.";
} else {
	PRINT "<br><b>Errors occured with your request for help.  Your only option is to re-edit the article.</b><br>";
}
$question = htmlspecialchars($question);
$answer = htmlspecialchars($answer);
?>
<hr noshade>

<?php
PRINT "<form method=post action=\"$USERPREFIX/knowledgebase-article-add.php\">";
PRINT "<input type=hidden name=categorylist value=\"$categorylist\">";
PRINT "<input type=hidden name=question value=\"$question\">";
PRINT "<input type=hidden name=answer value=\"$answer\">";
PRINT "<input type=hidden name=faq value=\"$faq\">";
?>
<input type=submit value="Re-edit Article"></form> 

<br>
<?php
$htmlquestion = nl2br($question);
$htmlanswer = nl2br($answer);
$categoryname = kbcategoryname($categorylist);
PRINT "Category Selected was: $categoryname\n<BR><HR>";
PRINT "<br><strong>Question:</strong><br>$htmlquestion<br><hr>";
PRINT "<br><strong>Answer:</strong><br>$htmlanswer<br>";

if ($error != 1) 
{
	PRINT "<form method=post action=\"$USERPREFIX/knowledgebase-article-add.php\">";
  PRINT "<input type=hidden name=categorylist value=\"$categorylist\">";
  PRINT "<input type=hidden name=modify value=\"$modify\">";
  PRINT "<input type=hidden name=commit value=\"1\">";
  PRINT "<input type=hidden name=ID value=\"$ID\">";
  PRINT "<input type=hidden name=question value=\"$question\">";
	PRINT "<input type=hidden name=answer value=\"$answer\">";
	PRINT "<input type=hidden name=faq value=\"$faq\">";
	PRINT "<input type=submit value=\"Add Article\"></form>";
}

 
PRINT "<br>";
commonFooter();
?>
