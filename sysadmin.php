<?php
/*****************************************************************
*        DO NOT REMOVE                                           *
*        =============                                           *
*VetClinic Management Software                                   *
*Copyrighted 2015-2016 by Michael Avila                          *
*Distributed under the terms of the GNU General Public License   *
*This program is distributed in the hope that it will be useful, *
* but WITHOUT ANY WARRANTY; without even the implied warranty of *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.           *
*****************************************************************/
session_start();
$background = "3";
$logFileName = "user";
$headerTitle="USER LOG";
if ( !empty($_SESSION['employeenumber']) ) {
	$emplnumber = $_SESSION['employeenumber'];
}
$display ="sysadmin: " . $emplnumber;
include 'includes/header1.inc';
include 'includes/header2.inc';
require_once "includes/common.inc";
$emplnumber = '';
$mysqli = new mysqli('localhost', $_SESSION["user"], mc_decrypt($_SESSION["up"], ps_key), '');
$sql = "SELECT `status` FROM `vetclinicsys`.`logonallowed`";
$status = 'unknown: failed to retrieve data.';
if ( $result = $mysqli->query($sql) ) {
	if ( 1 == $result->num_rows ) {
		$row = $result->fetch_row();
        $status = $row[0];
	}
}
else {
   echo '<div>Error getting data from logonallowed: ' . $mysqli->error . '</div>';
}
$mysqli->close();
echo '<div class="center">';
echo '<div><h2 class="royalBlue">Pet Clinic Software System Administration</h2></div>';
echo '<form method="post" action="sysendis.php">';
echo '<br><input type="submit" value="Disable/Enable Logins">';
echo '<br>Logins are: ';
		if ($status == 'Y') {
			echo '<span id="loginsY">Enabled</span>';
		}
		else if ($status == 'N') {
			echo '<span id="loginsN">Disabled</span>';
		}
		else {
			echo $status;
		}
echo '</form>';
echo '<form method="post" action="sysloggedin.php">';
echo '<br><br><input type="submit" value="Who is Logged In">';
echo '</form>';
echo '<form name="reg" method="post" action="support.php">';
echo '<br><br><input type="submit" value="Support"></form>';
include "includes/returnmainmenu.inc";
echo '</form>';
echo '</div><br>';
include "includes/display_errormsg.inc";
include "includes/phonemsgs.inc";
include 'includes/footer.inc';
?>