<?php

session_start();
$_SESSION = array();
session_destroy();
?>
<HTML><HEAD><TITLE>Daedalus - Asset Manager and Trouble Desk</TITLE>
</HEAD>
<BODY BGCOLOR=#FFFFFF>
<FONT FACE="Arial, Helvetica">
<img src=daedalus.jpg>
<br>
  
<a href="login.php">Login</a>
<table border="0">
<tr>
<td valign='top'><h3>Login</h3>
<form method=post action=login.php>
Username: <input type=text name=name>
<br>Password: <input type=password name=password>
<input type='hidden' name='dbuse' value='daedalus'>
<br>
<input type=submit value=Login>
</form>
<br><br>
</td>
<td>
<h3>Introduction to Daedalus</h3>
<p>Daedalus is a multi-user computer, software, peripheral and problem tracking system.
You can use Daedalus, depending on your user-level, to view, edit, and add
computer systems to a database with an extensive list of fields.  You can
also view and post jobs if you have a problem with a computing resource.</p>

<h4>Frequently Asked Questions</h4>
<p>Helpdesk personel get many questions - many of which are repeated many times. A FAQ, which is a list of frequently asked questions -
and their answers, intends to provide a quick and easy way to help you get an answer to a questions. If your query isn't in this list, feel
free to post a request for help.

<h4>What is Dactyl?</h4>
<p>Dactyl is the first natural satellite of an asteroid ever discovered and photographed.
<a href=http://solarviews.com/eng/asteroid.htm>Asteroid Intro</a>

</td>
</tr>
</table></form>
<br>   
</BODY>
</HTML>

