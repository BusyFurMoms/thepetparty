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
$logFileName = "user";
$headerTitle="USER LOG";
require_once "includes/common.inc";

$coname=$_POST["coname"];
$address1=$_POST["address1"];
$address2=$_POST["address2"];
$city=$_POST["city"];
$state=$_POST["state"];
$zipcode=$_POST["zipcode"];
$telephone=$_POST["telephone"];
$fax=$_POST["fax"];
$logo=$_POST["logo"];
$license=$_POST["license"];
$statetax=$_POST["statetax"];
$mysqlic = new mysqli('localhost', $_SESSION["user"], mc_decrypt($_SESSION["up"], ps_key), '');
$address1 = mc_encrypt($address1, ENCRYPTION_KEY);
if (strlen($address2) > 0)
{
	$address2 = mc_encrypt($address2, ENCRYPTION_KEY);
} else {
	$address2 = "";
}
$city = mc_encrypt($city, ENCRYPTION_KEY);
$emplnumber = $_SESSION['employeenumber'];
$sql = "UPDATE `vetcliniccorp`.`company` SET `name` = \"".$coname."\", `address` = \"".$address1."\", `address2` = \"".$address2."\", `city` = \"".$city."\", `state` = \"".$state."\", `zipcode` = \"".$zipcode;
$sql = $sql."\", `telephone` = \"".$telephone."\", `fax` = \"".$fax."\", `logo` = \"".$logo."\", `businesslic` = \"".$license."\", `statetax` = \"".$statetax."\", ";
$sql = $sql."changeid=$emplnumber;";
if ($mysqlic->query($sql) === TRUE) {

} else {
     put_errormsg("Company update failed" . $mysqlic->error);
	redirect("criticalerror.php?m=corpinfo1.php&ec=0");
}
$mysqlic->close();
delete_errormsg();
redirect("corpinfo.php");
?>