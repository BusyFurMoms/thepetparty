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

if (!empty($_POST["desc"])) {
	$desc = $_POST["desc"];
} else {
     put_errormsg("The Description cannot be blank");
	header("Location:invmedbase.php");
	exit();
}
if (!empty($_POST["desc"])) {
	$desc = $_POST["desc"];
} else {
	$desc = "";
}
if (!empty($_POST["purchdate"])) {
	$purchdate = $_POST["purchdate"];
} else {
	$purchdate = "";
}
if (!empty($_POST["cartoncost"])) {
	$cartoncost = $_POST["cartoncost"];
} else {
	$cartoncost = "";
}
if (!empty($_POST["contcost"])) {
	$contcost = $_POST["contcost"];
} else {
	$contcost = "";
}
if (!empty($_POST["cartonspurch"])) {
	$cartonspurch = $_POST["cartonspurch"];
} else {
	$cartonspurch = "";
}
if (!empty($_POST["contcarton"])) {
	$contcarton = $_POST["contcarton"];
} else {
     put_errormsg("The Containers Per Carton cannot be blank");
     redirect("invmedbase.php");
	exit();
}
if (!empty($_POST["itemcont"])) {
	$itemcont= $_POST["itemcont"];
} else {
     put_errormsg("The Items Per Container cannot be blank");
     redirect("invmedbase.php");
	exit();
}
if (!empty($_POST["itemcost"])) {
	$itemcost = $_POST["itemcost"];
} else {
	$itemcost = "";
}
if (!empty($_POST["itemreorder"])) {
	$itemreorder = $_POST["itemreorder"];
} else {
     put_errormsg("The Item Reorder Level cannot be blank");
     redirect("invmedbase.php");
	exit();
}
if (!empty($_POST["itemmarkup"])) {
	$itemmarkup = $_POST["itemmarkup"];
} else {
     put_errormsg("The Item Markup cannot be blank");
     redirect("invmedbase.php");
	exit();
}
if (!empty($_POST["contmarkup"])) {
	$contmarkup = $_POST["contmarkup"];
} else {
     put_errormsg("The Container Markup cannot be blank");
     redirect("invmedbase.php");
	exit();
}
if (!empty($_POST["itemsales"])) {
	$itemsales = $_POST["itemsales"];
} else {
	$itemsales = "";
}
if (!empty($_POST["contsales"])) {
	$contsales = $_POST["contsales"];
} else {
	$contsales = "";
}
if (!empty($_POST["taxable"])) {
	$taxable = $_POST["taxable"];
} else {
     put_errormsg("If the Item is Taxable cannot be blank");
     redirect("invmedbase.php");
	exit();
}
if(isset($_POST['wherebought']))
{
     $wherebought = $_POST['wherebought'];
} else {
     put_errormsg("A Vendor must be selected for where bought");
     redirect("invmedbase.php");
	exit();
}
if(isset($_POST['status']))
{
	$status = $_POST['status'];
} else {
	$status = "A";
}
/*
 UPDATE table_name
SET column1=value, column2=value2,...
WHERE some_column=some_value
 */
$mysqli = new mysqli('localhost', $_SESSION["user"], mc_decrypt($_SESSION["up"], ps_key), '');
$emplnumber = $_SESSION["employeenumber"];
echo $wherebought;
$quesmark = strpos($wherebought, "?");
$vendorid = substr($wherebought, 0, $quesmark);
$wherebought = substr($wherebought, $quesmark + 1);
$sql = 'UPDATE `vetclinicinv`.`invmedicine` SET `meddesc` = "'.$desc.'", `vendorid` = '.$vendorid.', `wherebought` = "'.$wherebought.'", `purdate` = '.$purchdate.', ";
$sql = $sql.`cartoncost` = '.$cartoncost.',  `cartonspurch` = '.$cartonspurch.', `containercarton` = '.$contcarton.', ';
$sql = $sql.'`itemscontainer` = '.$itemcont.', `itemcost` = '.$itemcost.', `containercost` = '.$contcost.', `itemreorderlevel`= '.$itemreorder.', `itemmarkup` = '.$itemmarkup.', ';
$sql = $sql.'`containermarkup` = '.$contmarkup.', `itemsalesprice` = '.$itemsales.', ';
$sql = $sql.'`containersalesprice` = '.$contsales.', `taxable` = "'.$taxable.'", `status` = "'.$status.'" , `changeid` = '.$emplnumber.';';
if ($mysqli->query($sql) === TRUE) {

} else {
     put_errormsg("Table invmedicine data insertion failed" . $mysqli->error);
     redirect("invmedbase.php");
	 exit(1);
}
$mysqli->close();
delete_errormsg();
redirect("invmedbase.php");
?>