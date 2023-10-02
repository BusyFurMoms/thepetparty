<?php
/*****************************************************************
*        DO NOT REMOVE                                           *
*        =============                                           *
*vetclinic Management Software                                   *
*Copyrighted 2015-2016 by Michael Avila                          *
*Distributed under the terms of the GNU General Public License   *
*This program is distributed in the hope that it will be useful, *
* but WITHOUT ANY WARRANTY; without even the implied warranty of *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.           *
*****************************************************************/
session_start();
$_SESSION["debug"] = "no";
include "includes/ft.inc";
$logFileName = "user";
$headerTitle="USER LOG";
require_once "includes/common.inc";
$log->logThis($logdatetimeecc."user logging in");
delete_errormsg();
if (!empty($_POST["emplnumber"]))
{
	$emplnumber = $_POST["emplnumber"];
} else {
     put_errormsg("You must enter your Employee Number");
     redirect("index1.php");
	 exit();
}
if (!empty($_POST["userid"]))
{
	$uuserid = $_POST["userid"];
} else {
     put_errormsg("You must enter your User ID");
     redirect("index1.php");
	exit();
}
if (!empty($_POST["password"]))
{
	$userpassword = $_POST["password"];
} else {
     put_errormsg("You must enter your Password");
     redirect("index1.php");
	exit();
}
$mysqli = new mysqli('localhost', $_SESSION["user"], mc_decrypt($_SESSION["up"], ps_key), '');
$sql = "SELECT * FROM `vetclinicsys`.`logonallowed`;";
if ($mysqli->query($sql) == TRUE) {

} else {
    echo "Error selecting logon status information. " . $mysqli->error;
	exit(1);
}
$result = $mysqli->query($sql);
$row_cnt = $result->num_rows;
$row = $result->fetch_row();
if ($row[0] == "N") {
     put_errormsg("Logons have been disabled");
     redirect("index1.php");
}
$sql = "SELECT uuserid, upassword, status, changepwd FROM vetcliniccorp.employee WHERE emplnumber = ".$emplnumber;
$result = $mysqli->query($sql);
$row_cnt = $result->num_rows;
if ($row_cnt == 0) {
     put_errormsg("You have entered an incorrect Employee Number");
     redirect("index1.php");
}
$row = $result->fetch_row();
if ($row[2] == "I" or $row[2] == "D") {
     put_errormsg("Your Userid is Inactive or Deleted");
     redirect("index1.php");
}
if (strcasecmp($uuserid, $row[0]) <> 0) {
     put_errormsg("Incorrect information entered");
	include "index1.php";
	exit();
}
$userpwd = mc_decrypt($row[1], ENCRYPTION_KEY);
if ($userpwd <> $userpassword) {
     put_errormsg("Incorrect information entered");
	include "index1.php";
	exit();
}
$ecc = $uuserid.$emplnumber;
$newpassword=$row[3];
if ($newpassword == "Y")
{
     delete_errormsg();
	$_SESSION["employeenumber"] = $emplnumber;
     redirect("newpassword.php");
	exit();
}
$sql = "SELECT * FROM `vetcliniccorp`.`preferences` ORDER BY `sequence`";
$result = $mysqli->query($sql);
$row_cnt = $result->num_rows;
$row = $result->fetch_row();
$row = $result->fetch_row();
$bg0 = $row[1];
$bg1 = $row[2];
$bg2 = $row[3];
$bg3 = $row[4];
$bg4 = $row[5];
$row = $result->fetch_row();
$preload = $row[1];
if ($preload == "Y") {
	$state = $row[2];
	require_once "preloadarraykeys.php";
	$prearray = array_fill(0, 25, "");
	$prearray[$preak_bg0] = $bg0;
	$prearray[$preak_bg1] = $bg1;
	$prearray[$preak_bg2] = $bg2;
	$prearray[$preak_bg3] = $bg3;
	$prearray[$preak_bg4] = $bg4;
	$prearray[$preak_state] = $state;
	setcookie( "preload", serialize($prearray));
}
require_once "includes/userlog.inc";
$log->logThis($logdatetimeecc." user log in successful");
$datetime = date('Ymd H:i:s');
$os = $_SESSION["OS"];
$log->logThis($logdatetimeecc."    empnum: ".$emplnumber."; user: ".$uuserid."; @ ".$datetime."; OS: ".$os);
date_default_timezone_set('America/Detroit');
$datetime = date('Ymd H:i:s');
delete_errormsg();
$sql = "INSERT INTO `vetclinicsys`.`usersol` (`user`, `datetime`, `os`) VALUES ('$uuserid', '$datetime', '$os');";
if ($mysqli->query($sql) == TRUE) {

} else {
     echo "Error inserting into vetclinicsys" . $mysqli->error;
	exit(1);
}
$mysqli->close();
$_SESSION["su"] = $suser;
$_SESSION["sp"] = $spassword;
$_SESSION["employeenumber"] = $emplnumber;
$_SESSION["ecc"] = $ecc;
$_SESSION["SF"] = "rg";
$_SESSION["verify"] = __LINE__;
ft();
/*
 $_SESSION["SF"] = "in";
 //$_SESSION["verify"] = __LINE__._FILE_;

 if($_SESSION["SF"] != "in") {
 echo "<center>";
 include "includes/display_errormsg.inc";
 include "includes/returnmainmenu.inc";
 echo "</center>";
 exit();
 }
 */
delete_errormsg();
redirect("mainmenu.php");
?>