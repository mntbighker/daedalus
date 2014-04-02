<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#                                                                              #
################################################################################

include_once("../include/daedalus_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.tracking_info");
include_once("../include/func.knowledgebase");

if (!isset($commit)) $commit = '';
if (!isset($categorylist)) $categorylist = '';
if (!isset($question)) $question = '';
if (!isset($answer)) $answer = '';

AuthCheck("tech");
if($commit != 1)
{
	commonHeader("Daedalus Knowledge Base - Add Article");
	if(isset($from_tracking))
	{
		$question = trackDescription($from_tracking);
		$answer   = trackfollowups($from_tracking);
		if($answer == "")
		{
			$answer = "No followups were added, please put something here in the answer!\n";
		} 
	}
	?>
	Here is where you can add an article to the knowledge base.
	<hr noshade>
	<BR>
	<?php
	PRINT "<form method=post action=\"$USERPREFIX/knowledgebase-article-preview.php\">";
	PRINT "Select the category in which this article should be placed: ";
	kbcategoryList($categorylist);
	?>
	<br>
	<br>
	Enter the question here.  Please be as detailed as possible with the question, but don't repeat information that can be inferred by the category.
	<br>
	<?php
	PRINT "<textarea cols=50 rows=14 wrap=soft name=question>$question</textarea>"; 
	?>
	<br>
	Enter the answer here.  Please be as detailed as possible with the answer, including a step by step process.
	<br>
	<?
	PRINT "<textarea cols=50 rows=14 wrap=soft name=answer>$answer</textarea>"; 
	PRINT "<br>\n";
	PRINT "<input type=checkbox name=faq value=\"yes\"> Place this Knowledge Base Article into the publicly viewable FAQ as well. <BR>\n";
	PRINT "<input type=submit value=\"Preview Article\"> <input type=reset value=\"Reset\"></form>";
} else
{
	$question = addslashes($question);
	$answer = addslashes($answer);
	if($modify == 1)
	{
		commonHeader("Daedalus Knowledge Base - Article Modified");
		$query = "REPLACE kbarticles VALUES('$ID', '$categorylist', '$question', '$answer', '$faq')";
		$adb->dbh->exec($query);
		PRINT "Article has been modified, <A HREF=\"$USERPREFIX/knowledgebase-detail.php?ID=$ID\">Go Back</A>\n";
	} else
	{
		commonHeader("Daedalus Knowledge Base - Article Added");
		$query = "INSERT INTO kbarticles VALUES (NULL, '$categorylist', '$question', '$answer', '$faq')";
		$adb->dbh->exec($query);
		PRINT "Article has been added, <A HREF=\"$USERPREFIX/knowledgebase-index.php\">Go Back</A>\n";
	}
}
commonFooter();
?>
