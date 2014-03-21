<?php
#    IRM - The Information Resource Manager
#    Copyright (C) 1999 Yann Ramin
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License (in file COPYING) for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
#
#    $Id: default.php,v 1.2 2001/06/29 04:07:13 theatrus Exp $
#
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/06/99 - Yann Ramin: 	Added reports feature. #
################################################################################

include("../../include/irm.inc");
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
	of a real IRM Report.  It provides some simple data, but could really be extended with graphics, percentages, graphs, and user settable options.
	But it serves as a good jumping point for making your own report. (NOTE: The IRM
	header is not nessecary, I just put it in.  You must do a 'connectDB();' though.)
	<p>To generate the report, click on this button: 
<?php
	PRINT "<form action=\"$USERPREFIX/reports/default.php\"><input type=submit value=Go><input type=hidden name=go value=yes></form>";
?>

<?php
}
PRINT "</body></html>";
?>
