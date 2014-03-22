<?php

session_start();
$_SESSION = array();
session_destroy();
?>
<HTML><HEAD><TITLE>Daedalus - Information Resource Manager and Trouble Desk</TITLE>
</HEAD>
<BODY BGCOLOR=#FFFFFF>
<FONT FACE="Arial, Helvetica">
<img src=irm-jr1.jpg>
<br>
  
<a href="login.php">Login</a>
<table border="0">
<tr>
<td valign='top'><h3>Login</h3>
<form method=post action=login.php>
Username: <input type=text name=name>
<br>Password: <input type=password name=password>
<!-- <br>Database: -->
<!-- Database selection disabled and static set -->
<input type='hidden' name='dbuse' value='irm'>
<!-- <select name=dbuse size=1> -->

<!-- Multiple database selection options.  The default is to use a database called 'irm'. -->
<!-- To add more, simply add more option value=dbname lines here. -->

<!-- <option value=irm>irm</option> -->

<!-- End Multi-Database -->

<!-- </select> -->
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

<!-- <form method=post action=login.php><select name=dbuse size=1> -->

<!-- Multiple database selection options.  The default is to use a database called 'irm'. -->
<!-- To add more, simply add more option value=dbname lines here. -->

<!-- <option value=irm>irm</option> -->

<!-- End Multi-Database -->

<!-- </select><input type='hidden' name='password' value='irmconnect'><input type='hidden' name='name' value='IRMConnect'> -->
<!-- <input type='hidden' name='f_req' value='yes'> -->
<!-- <input type=submit value=Read FAQ></form> -->

<!-- <h4>Request help</h4> -->
<!-- You can request help without loging in to Daedalus. To do this you need to select the appropriate department, click the <b>Help</b> button below and then follow the -->
<!-- instructions. Your request will be filed under the user name of <b>guest</b> so you will need to ensure that the contact information is correct if you wish to recieve updates and keep in touch with the helpdesk. -->
<!-- <form method=post action=login.php><select name=dbuse size=1> -->

<!-- Multiple database selection options.  The default is to use a database called 'irm'. -->
<!-- To add more, simply add more option value=dbname lines here. -->

<!-- <option value=irm>irm</option> -->

<!-- End Multi-Database -->

<!-- </select><input type='hidden' name='password' value='irmconnect'><input type='hidden' name='name' value='IRMConnect'><input type=submit value=Help Request></form> -->
</td>
</tr>
</table></form>
<br>   
</BODY>
</HTML>

