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
$editclientnum=$_POST["editclientnum"];
$emplnumber=$_POST["emplnumber"];
$lname=$_POST["lname"];
$fname=$_POST["fname"];
$prefix=$_POST["prefix"];
$suffix=$_POST["suffix"];
$address1=$_POST["address1"];
$address2=$_POST["address2"];
$city=$_POST["city"];
$state=$_POST["state"];
$zipcode=$_POST["zipcode"];
$email=$_POST["email"];
$status=$_POST["status"];
$htele = "";
$ftele = "";
$ctele = "";
if (!empty($_POST["htele"]))
{
	$htele = $_POST["htele"];
}

if (!empty($_POST["ftele"]))
{
	$ftele = $_POST["ftele"];
}

if (!empty($_POST["ctele"]))
{
	$ctele = $_POST["ctele"];
}
$mysqli = new mysqli('localhost', $_SESSION["user"], mc_decrypt($_SESSION["up"], ps_key), '');
$billingaddress = $address1.", ".$address2.", ".$city.", ".$state." ".$zipcode;
$address1 = mc_encrypt($address1, ENCRYPTION_KEY);
if (strlen($address2) > 0)
{
	$address2 = mc_encrypt($address2, ENCRYPTION_KEY);
} else {
	$address2 = "";
}
$city = mc_encrypt($city, ENCRYPTION_KEY);
$soundex = soundex($lname);
if ($editclientnum <> "new")
{
	$sql = "UPDATE `vetclinic`.`client` SET `lname` = \"".$lname."\", `fname` = \"".$fname."\", `prefix` = \"".$prefix."\", `suffix` = \"".$suffix."\", ";
	$sql = $sql."`address` = \"".$address1."\", `address2` = \"".$address2."\", `city` = \"".$city."\", `state` = \"".$state."\", `zipcode` = \"".$zipcode."\", ";
	$sql = $sql."`email` = \"".$email."\", `soundex` = \"".$soundex."\", `changeid` = \"".$emplnumber."\"	WHERE clientnumber = \"".$editclientnum."\";";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Table client data update failed" . $mysqli->error;
		exit(1);
	}
} else{
	$sql = "INSERT INTO `vetclinic`.`client` (`lname`, `fname`, `address`, `address2`, `city`, `state`, `zipcode`, `email`, `prefix`, `suffix`, `soundex`, `status`, `changeid`)
	   VALUES (\"$lname\", \"$fname\", \"$address1\", \"$address2\", \"$city\", \"$state\", \"$zipcode\", \"$email\", \"$prefix\", \"$suffix\", \"$soundex\", \"$status\", \"$emplnumber\");";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Table data data insertion failed" . $mysqli->error;
		exit(1);
	}
     $newcustid = $mysqli->insert_id;
     $editclientnum = $newcustid;
     if(isset($_POST["billable"])) {
          $billable = $_POST["billable"];
     }
}

if (strlen($htele) != 0) {
	$sql = "REPLACE INTO `vetclinic`.`clientphone` VALUES (\"$editclientnum\", \"H\", \"$htele\");";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Home Telephone Number insertion failed" . $mysqli->error;
		exit(1);
	}
}
if (strlen($ftele) != 0) {
	$sql = "REPLACE INTO `vetclinic`.`clientphone` VALUES (\"$editclientnum\", \"F\", \"$ftele\");";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Fax Telephone Number insertion failed" . $mysqli->error;
		exit(1);
	}
}
if (strlen($ctele) != 0) {
	$sql = "REPLACE INTO `vetclinic`.`clientphone` VALUES (\"$editclientnum\", \"C\", \"$ctele\");";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Cell Telephone Number insertion failed" . $mysqli->error;
		exit(1);
	}
}
$mysqli->close();
delete_errormsg();
$_SESSION['client_data']=array('client' => $lname . ', ' . $fname, 'cid' => $editclientnum);
echo 'clientmaint.php';
?>