<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");
include_once("../include/func.knowledgebase");

AuthCheck("post-only");

commonHeader("Daedalus Knowledge Base");
?>
This is the Daedalus Knowledge Base system. It allows you to view all of the 
knowledge base articles that have been entered.
<br>
<BR>
<table border=0 width=100%>
<tr>
<?php
PRINT "<td align=center><h4><a href=\"$USERPREFIX/knowledgebase-article-add.php\">Add an Article</a>";
?>
		</h4></td></tr>
</TABLE>

<?php

kbdisplaycategories();

commonFooter();

?>