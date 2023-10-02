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
$editempnum = $_POST['editempnum'];
$emplnumber=$_POST["emplnumber"];
$uuserid=$_POST["uuserid"];
$epassword=$_POST["epassword"];
$changepwd=$_POST["changepwd"];
$passwordhint=$_POST["passwordhint"];
$hintanswer=$_POST["hintanswer"];
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
$changeid=$_POST["changeid"];
$telephone = $_POST["telephone"];


if (empty($_POST["uuserid"]))
{
     put_errormsg("User ID cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["epassword"]))
{
     put_errormsg( "The Password cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["changepwd"]))
{
     put_errormsg("Change Password cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if ($changepwd <> "Y" AND $changepwd <> "N")
{
     put_errormsg("Change Password must be Y or N");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["fname"]))
{
     put_errormsg("First Name cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["lname"]))
{
     put_errormsg("Last name cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["address1"]))
{
     put_errormsg("Address 1 cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["city"]))
{
     put_errormsg("City cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["state"]))
{
     put_errormsg("State cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["zipcode"]))
{
     put_errormsg("Zip Code cannot be blank");
     redirect("emplmaint.php");
	exit();
}
if (empty($_POST["telephone"]))
{
     put_errormsg("Telephone cannot be blank");
     redirect("emplmaint.php");
	exit();
}
require_once "pwdreq.php";
$errormsg = pwdreq($epassword);
if (strlen($errormsg) > 0) {
     put_errormsg($errormsg);
     redirect("emplmaint.php");
	exit();
}
$mysqli = new mysqli('localhost', $_SESSION["user"], mc_decrypt($_SESSION["up"], ps_key), '');
if ($editempnum <> "new")
{
	$sql="SELECT upassword FROM vetcliniccorp.employee WHERE emplnumber = ".$editempnum;
	$result = $mysqli->query($sql);
	if ($result == FALSE)
	{
          put_errormsg("Invalid Employee number");
          redirect("emplmaint.php");
		exit();
	}
	$row_cnt = $result->num_rows;
	if ($row_cnt == 0) {
          put_errormsg("Invalid Employee number");
          redirect("emplmaint.php");
		exit();
	}
	$row = $result->fetch_row();
	$oldpassword = $row[0];
	$oldpassword = mc_decrypt($oldpassword, ENCRYPTION_KEY);
	if ($oldpassword <> $epassword)
	{
		$changepwd = "Y";
	} else {
		$changepwd = "N";
	}
}
$epassword = mc_encrypt($epassword, ENCRYPTION_KEY);
$address1 = mc_encrypt($address1, ENCRYPTION_KEY);
if (strlen($address2) > 0)
{
	$address2 = mc_encrypt($address2, ENCRYPTION_KEY);
} else {
	$address2 = "";
}
$city = mc_encrypt($city, ENCRYPTION_KEY);
$passwordhint = mc_encrypt($passwordhint, ENCRYPTION_KEY);
$hintanswer = mc_encrypt($hintanswer, ENCRYPTION_KEY);
if ($editempnum <> "new")
{
	$sql = "UPDATE `vetcliniccorp`.`employee` SET `uuserid` = \"".$uuserid."\", `upassword` = \"".$epassword."\", `changepwd` = \"".$changepwd."\", `pwdhint` = \"".$passwordhint."\", ";
	$sql = $sql."`hintans` = \"".$hintanswer."\", `lname` = \"".$lname."\", `fname` = \"".$fname."\", `prefix` = \"".$prefix."\", `suffix` = \"".$suffix."\", ";
	$sql = $sql."`address` = \"".$address1."\", `address2` = \"".$address2."\", `city` = \"".$city."\", `state` = \"".$state."\", `zipcode` = \"".$zipcode."\", ";
	$sql = $sql."`email` = \"".$email."\", `status` = \"".$status."\", `telephone` = \"".$telephone."\", `changeid` = \"".$emplnumber."\" WHERE emplnumber = \"".$editempnum."\";";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Table employee data update failed" . $mysqli->error;
		exit(1);
	}
} else{
	$sql = "INSERT INTO `vetcliniccorp`.`employee` (`uuserid`, `upassword`, `lname`, `fname`, `address`, `address2`, `city`, `state`, `zipcode`,
       `telephone`, `status`, `changeid`, `changepwd`, `email`, `pwdhint`, `hintans`, `prefix`, `suffix`)
	   VALUES (\"$uuserid\", \"$epassword\", \"$lname\", \"$fname\", \"$address1\", \"$address2\", \"$city\",
	   \"$state\", \"$zipcode\", \"$telephone\", 'A', \"$emplnumber\", 'Y', \"$email\", \"$passwordhint\", \"$hintanswer\", \"$prefix\", \"$suffix\");";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Table employee data insertion failed" . $mysqli->error;
		exit(1);
	}
	$result = $mysqli->insert_id;
	$editempnum  = $result;
	$sql = "INSERT INTO `vetcliniccorp`.`seckeys` (`emplnumber`, `sequence`, `changeid`) VALUES ($result, 1, $emplnumber);";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Table employee security data1 insertion failed" . $mysqli->error;
		exit(1);
	}
	$sql = "INSERT INTO `vetcliniccorp`.`seckeys` (`emplnumber`, `sequence`, `changeid`) VALUES ($result, 2, $emplnumber);";
	if ($mysqli->query($sql) === TRUE) {

	} else {
		echo "Table employee security data2 insertion failed" . $mysqli->error;
		exit(1);
	}
}
$mysqli->close();
delete_errormsg();
$_SESSION['employee_data']=array('uid' => $editempnum, 'user' => $uuserid);
echo "emplmaint.php"; //?editempnum=" . $editempnum;  // return string to the ajax via success.
?>