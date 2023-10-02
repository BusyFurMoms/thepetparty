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
//$_SESSION["SF"] = "in";
//$_SESSION["verify"] = __LINE__._FILE_;



$background = "1";
$logFileName = "user";
$headerTitle="USER LOG";
require_once "includes/header1.inc";
require_once "includes/header2.inc";
require_once "includes/common.inc";
$emplnumber = $_SESSION['employeenumber'];
$display ="Maintmenu:".$emplnumber;
?>
<center><form action="invmednav.php" method="post"><table width="25%">
<tr><td><input type="radio" name="menu[]" value="1">Medicine Inventory Transaction</td></tr>
<tr><td><input type="radio" name="menu[]" value="2">Medicine Inventory Base Record - Modify</td></tr>
<tr><td><input type="radio" name="menu[]" value="3">Medicine Inventory Base Record - Create</td></tr>
<?php include "includes/phonemsgs.inc"; ?>
</table><br><br><center><input type="submit" value="Process Selection"></center></form>
<?php
include "includes/returnmaintmenu.inc";
include "includes/display_errormsg.inc";
echo "</body></html>";
?>