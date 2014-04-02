<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
################################################################################

include("../../include/daedalus.inc");
include("../../include/reports.inc.php");
AuthCheck("normal");
PRINT "<html><body bgcolor=#ffffff>";
if ($go == "yes") 
{
	commonHeader("Default Report");
	# 1. Get some number data

	$query = "SELECT ID FROM computers";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		$result = $sth->fetchrow_hash();
		$number_of_computers = $sth->rows();
		$sth->finish();
	} else
	{
  	PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	$query = "SELECT ID FROM software";
	$sth = $adb->prepare($query);
	if($sth)
	{
  	$res = $sth->execute();
  	$result = $sth->fetchrow_hash();
  	$number_of_software = $sth->rows();
  	$sth->finish();
	} else
	{
  	PRINT "Could not prepare query: ".$sth->errstr."<br>\n";
	}
	
	# 2. Spew out the data in a table
	
	PRINT "<table border=0 width=100%>";
	PRINT "<tr><td>Number of Computers:</td><td>$number_of_computers</td></tr>";	
	PRINT "<tr><td>Amount of Software:</td><td>$number_of_software</td></tr>";

	PRINT "<tr><td colspan=2><b>Operating Systems:</b></td></tr>";

	# 3. Get some more number data (operating systems per computer)

	$query = "SELECT * FROM dropdown_os ORDER BY name";
	$sth = $adb->prepare($query);
	if($sth)
	{
		$res = $sth->execute();
		$numRows = $sth->rows();
		for($i = 0; $i < $numRows; $i++) 
		{
			$result = $sth->fetchrow_hash();
			$os = $result["name"];
			$query = "SELECT ID,os FROM computers WHERE (os = '$os')";
			$sth2 = $adb->prepare($query);
			if($sth2)
			{
				$sth2->execute();
				$numRows2 = $sth2->rows();
				PRINT "<tr><td>$os</td><td>$numRows2</td></tr>";
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
	commonHeader("Default Report");
	?>
	Welcome to the Default Report!  This report is designed to be a functional model
	of a real Daedalus Report.  It provides some simple data, but could really be extended with graphics, percentages, graphs, and user settable options.
	But it serves as a good jumping point for making your own report. (NOTE: The Daedalus
	header is not nessecary, I just put it in.  You must do a 'connectDB();' though.)
	<p>To generate the report, click on this button: 
<?php
	PRINT "<form action=\"$USERPREFIX/reports/default.php\"><input type=submit value=Go><input type=hidden name=go value=yes></form>";
?>

<?php
}
PRINT "</body></html>";
?>
