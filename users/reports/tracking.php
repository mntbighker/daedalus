<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
################################################################################

include("../../include/daedalus.inc");
include("../../include/reports.inc.php");
AuthCheck("normal");
PRINT "<html><body bgcolor=#ffffff>";

function getTracking($startdate, $enddate)
{
	global $adb;
	$query = "SELECT ID FROM tracking where (closedate > \"$startdate\") and (closedate < \"$enddate\")";
	$sth = $adb->prepare($query);
	return($sth);
}

function getTrackingByUser($startdate, $enddate, $username)
{
	global $adb;
	$query = "SELECT ID FROM tracking WHERE (assign = '$username') and (closedate > \"$startdate\") and (closedate < \"$enddate\")";
	$sth = $adb->prepare($query);
	return($sth);
}
if ($go == "yes") 
{

	commonHeader("Daedalus Tracking Report Results");
	# 1. Get some number data
	$startdate = $startyear . "-" . $startmonth . "-" . $startday;
	$enddate = $endyear . "-" . $endmonth . "-" . $endday;

	$sth = getTracking($startdate, $enddate);
	if($sth)
	{
		$res = $sth->execute();
		$result = $sth->fetchrow_hash();
		$number_of_tracking = $sth->rowCount();
		$sth->finish();
	} else
	{
  	PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	
	# 2. Spew out the data in a table
	
	PRINT "<table border=0 width=100%>";
	PRINT "<tr><td>Number of Tracking:</td><td>$number_of_tracking</td></tr>";	

	PRINT "<tr><td colspan=2><b>Tracking by user:</b></td></tr>";

	# 3. Get some more number data (operating systems per computer)

	$query = "SELECT * FROM users ORDER BY name";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		$numRows = $sth->rowCount();
		for($i = 0; $i < $numRows; $i++) 
		{
			$result = $sth->fetchrow_hash();
			$username = $result["name"];
			$sth2 = getTrackingByUser($startdate, $enddate, $username);
			if($sth2)
			{
				$sth2->execute();
				$numRows2 = $sth2->rowCount();
				PRINT "<tr><td>$username</td><td>$numRows2</td></tr>";
			} else
			{
  			PRINT "Could not prepare query: ".$sth2->errstr."<br>\n";
			}
		}
	} else
	{
  	PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	PRINT "</table>";
} else 
{
	commonHeader("Daedalus Tracking Report");
	?>
	Welcome to the Default Tracking Report! This report is designed to inform
	you of the tracking requests that have been completed or marked old during
	the time you specify.
	<p>To generate the report: select a start date, an end date, and click on the go button: 
<?php
	PRINT "<form action=\"$USERPREFIX/reports/tracking.php\">";
	PRINT "Select a Start Date:\n";
	PRINT "<select name=startyear>";
	PRINT "<OPTION VALUE=\"2003\">2003</OPTION>\n";
	PRINT "<OPTION VALUE=\"2002\" selected>2002</OPTION>\n";
	PRINT "<OPTION VALUE=\"2001\">2001</OPTION>\n";
	PRINT "<OPTION VALUE=\"2000\">2000</OPTION>\n";
	PRINT "<OPTION VALUE=\"1999\">1999</OPTION>\n";
	PRINT "</select>\n";
	PRINT "-\n";
	PRINT "<select name=startmonth>\n";
	PRINT "<OPTION VALUE=\"01\">January</OPTION>\n";
	PRINT "<OPTION VALUE=\"02\">February</OPTION>\n";
	PRINT "<OPTION VALUE=\"03\">March</OPTION>\n";
	PRINT "<OPTION VALUE=\"04\">April</OPTION>\n";
	PRINT "<OPTION VALUE=\"05\">May</OPTION>\n";
	PRINT "<OPTION VALUE=\"06\">June</OPTION>\n";
	PRINT "<OPTION VALUE=\"07\">July</OPTION>\n";
	PRINT "<OPTION VALUE=\"08\">August</OPTION>\n";
	PRINT "<OPTION VALUE=\"09\">September</OPTION>\n";
	PRINT "<OPTION VALUE=\"10\">October</OPTION>\n";
	PRINT "<OPTION VALUE=\"11\">November</OPTION>\n";
	PRINT "<OPTION VALUE=\"12\">December</OPTION>\n";
	PRINT "</select>\n";
	PRINT "-\n";
	PRINT "<select name=startday>\n";
	PRINT "<OPTION VALUE=\"01\">01</OPTION>\n";
	PRINT "<OPTION VALUE=\"02\">02</OPTION>\n";
	PRINT "<OPTION VALUE=\"03\">03</OPTION>\n";
	PRINT "<OPTION VALUE=\"04\">04</OPTION>\n";
	PRINT "<OPTION VALUE=\"05\">05</OPTION>\n";
	PRINT "<OPTION VALUE=\"06\">06</OPTION>\n";
	PRINT "<OPTION VALUE=\"07\">07</OPTION>\n";
	PRINT "<OPTION VALUE=\"08\">08</OPTION>\n";
	PRINT "<OPTION VALUE=\"09\">09</OPTION>\n";
	PRINT "<OPTION VALUE=\"10\">10</OPTION>\n";
	PRINT "<OPTION VALUE=\"11\">11</OPTION>\n";
	PRINT "<OPTION VALUE=\"12\">12</OPTION>\n";
	PRINT "<OPTION VALUE=\"13\">13</OPTION>\n";
	PRINT "<OPTION VALUE=\"14\">14</OPTION>\n";
	PRINT "<OPTION VALUE=\"15\">15</OPTION>\n";
	PRINT "<OPTION VALUE=\"16\">16</OPTION>\n";
	PRINT "<OPTION VALUE=\"17\">17</OPTION>\n";
	PRINT "<OPTION VALUE=\"18\">18</OPTION>\n";
	PRINT "<OPTION VALUE=\"19\">19</OPTION>\n";
	PRINT "<OPTION VALUE=\"20\">20</OPTION>\n";
	PRINT "<OPTION VALUE=\"21\">21</OPTION>\n";
	PRINT "<OPTION VALUE=\"22\">22</OPTION>\n";
	PRINT "<OPTION VALUE=\"23\">23</OPTION>\n";
	PRINT "<OPTION VALUE=\"24\">24</OPTION>\n";
	PRINT "<OPTION VALUE=\"25\">25</OPTION>\n";
	PRINT "<OPTION VALUE=\"26\">26</OPTION>\n";
	PRINT "<OPTION VALUE=\"27\">27</OPTION>\n";
	PRINT "<OPTION VALUE=\"28\">28</OPTION>\n";
	PRINT "<OPTION VALUE=\"29\">29</OPTION>\n";
	PRINT "<OPTION VALUE=\"30\">30</OPTION>\n";
	PRINT "<OPTION VALUE=\"31\">31</OPTION>\n";
	PRINT "</select>\n";
	PRINT "<BR>\n";
	PRINT "Select and end date:\n";
	PRINT "<select name=endyear>";
	PRINT "<OPTION VALUE=\"2003\">2003</OPTION>\n";
	PRINT "<OPTION VALUE=\"2002\" selected>2002</OPTION>\n";
	PRINT "<OPTION VALUE=\"2001\">2001</OPTION>\n";
	PRINT "<OPTION VALUE=\"2000\">2000</OPTION>\n";
	PRINT "<OPTION VALUE=\"1999\">1999</OPTION>\n";
	PRINT "</select>\n";
	PRINT "-\n";
	PRINT "<select name=endmonth>\n";
	PRINT "<OPTION VALUE=\"01\">January</OPTION>\n";
	PRINT "<OPTION VALUE=\"02\">February</OPTION>\n";
	PRINT "<OPTION VALUE=\"03\">March</OPTION>\n";
	PRINT "<OPTION VALUE=\"04\">April</OPTION>\n";
	PRINT "<OPTION VALUE=\"05\">May</OPTION>\n";
	PRINT "<OPTION VALUE=\"06\">June</OPTION>\n";
	PRINT "<OPTION VALUE=\"07\">July</OPTION>\n";
	PRINT "<OPTION VALUE=\"08\">August</OPTION>\n";
	PRINT "<OPTION VALUE=\"09\">September</OPTION>\n";
	PRINT "<OPTION VALUE=\"10\">October</OPTION>\n";
	PRINT "<OPTION VALUE=\"11\">November</OPTION>\n";
	PRINT "<OPTION VALUE=\"12\">December</OPTION>\n";
	PRINT "</select>\n";
	PRINT "-\n";
	PRINT "<select name=endday>\n";
	PRINT "<OPTION VALUE=\"01\">01</OPTION>\n";
	PRINT "<OPTION VALUE=\"02\">02</OPTION>\n";
	PRINT "<OPTION VALUE=\"03\">03</OPTION>\n";
	PRINT "<OPTION VALUE=\"04\">04</OPTION>\n";
	PRINT "<OPTION VALUE=\"05\">05</OPTION>\n";
	PRINT "<OPTION VALUE=\"06\">06</OPTION>\n";
	PRINT "<OPTION VALUE=\"07\">07</OPTION>\n";
	PRINT "<OPTION VALUE=\"08\">08</OPTION>\n";
	PRINT "<OPTION VALUE=\"09\">09</OPTION>\n";
	PRINT "<OPTION VALUE=\"10\">10</OPTION>\n";
	PRINT "<OPTION VALUE=\"11\">11</OPTION>\n";
	PRINT "<OPTION VALUE=\"12\">12</OPTION>\n";
	PRINT "<OPTION VALUE=\"13\">13</OPTION>\n";
	PRINT "<OPTION VALUE=\"14\">14</OPTION>\n";
	PRINT "<OPTION VALUE=\"15\">15</OPTION>\n";
	PRINT "<OPTION VALUE=\"16\">16</OPTION>\n";
	PRINT "<OPTION VALUE=\"17\">17</OPTION>\n";
	PRINT "<OPTION VALUE=\"18\">18</OPTION>\n";
	PRINT "<OPTION VALUE=\"19\">19</OPTION>\n";
	PRINT "<OPTION VALUE=\"20\">20</OPTION>\n";
	PRINT "<OPTION VALUE=\"21\">21</OPTION>\n";
	PRINT "<OPTION VALUE=\"22\">22</OPTION>\n";
	PRINT "<OPTION VALUE=\"23\">23</OPTION>\n";
	PRINT "<OPTION VALUE=\"24\">24</OPTION>\n";
	PRINT "<OPTION VALUE=\"25\">25</OPTION>\n";
	PRINT "<OPTION VALUE=\"26\">26</OPTION>\n";
	PRINT "<OPTION VALUE=\"27\">27</OPTION>\n";
	PRINT "<OPTION VALUE=\"28\">28</OPTION>\n";
	PRINT "<OPTION VALUE=\"29\">29</OPTION>\n";
	PRINT "<OPTION VALUE=\"30\">30</OPTION>\n";
	PRINT "<OPTION VALUE=\"31\">31</OPTION>\n";
	PRINT "</select>\n";
	PRINT "<input type=submit value=Go><input type=hidden name=go value=yes>";
	PRINT "</form>";
?>

<?php
}
PRINT "</body></html>";
?>
