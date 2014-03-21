<?php
################################################################################
#                                  CHANGELOG                                   #
################################################################################
#  11/2002 - G. hartlieb: Created                                              #
################################################################################

include_once("../include/irm_conf.php");
include_once("../include/class.user");
include_once("../include/func.header_footer");

include_once("../include/func.dropdown_date");


// Do Authorization
AuthCheck("admin");

commonHeader("Daedalus Reports"); 

// echo "<p>IRM Home: /var/www/html/irm</p>";

echo "<form method=POST action=\"reports-display.php\">";

echo "<p>Create Tracking Report For: ";

print "<select name=\"report\" size=1>";
echo "<option value=\"tstracking\" >","TS Tracking Report" , "</option>";
print "</select>\n";

dropdownDate('month', 1, 12, date("m"));
echo " / ";   
$year = date("Y");
dropdownDate('year', $year-3, $year, $year);   

echo "&nbsp;<input type=submit value=\"Display\"></p>";

echo "</form>";

echo "<p><a href=software-reports.php?report=web>Software Inventory: Web</a></p>";

echo "<p><a href=software-inv-download.php?type=xls>Software Inventory: Excel</a></p>";

echo "<p><a href=software-inv-download.php?type=ssp>Software Inventory: SSP</a></p>";

echo "<p><a href=reports-display.php?report=support>Current Support Report</a></p>";

echo "<b>Support Reports By Month</b><br>
      (These Reports were Auto-Generated on the 16th of each Month prior to ERC cutover.)";
echo "<br />";

$reports = Array();

$handle = opendir("$root_path/perl/Support_Reports");

while ( false !== ($file = readdir($handle)) ) {
   if ($file != "." && $file != "..") {   
       $reports[] = $file;
  }
}
closedir($handle);

foreach ($reports as $report) {
   $label = current(explode('.', $report));
   echo "<a href=../perl/Support_Reports/$report>$label</a><br />";
}

commonFooter();

?>
