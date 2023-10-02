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
$logFileName = "install";
require_once "includes/common.inc";
$log->logThis("checking passwords");
unset($_SESSION["errormessage"]);
$password1 = $_POST["newpwd1"];
$password2 = $_POST["newpwd2"];
if ($password1 <> $password2) {
     put_errormsg("The Passwords do not match");
     redirect("newpassword.php");
}
require_once "pwdreq.php";
$errormsg = pwdreq($password1);
if (strlen($errormsg) > 0) {
     put_errormsg($errormsg);
     redirect("newpassword.php");
	exit();
}
$log->logThis("password passes requirements");
$newpassword = mc_encrypt($password1, ENCRYPTION_KEY);
$emplid = $_SESSION['employeenumber'];
$mysqlic = new mysqli('localhost', $_SESSION["user"], mc_decrypt($_SESSION["up"], ps_key), '');
$sql = "UPDATE `vetcliniccorp`.`employee` SET upassword=\"$newpassword\", changepwd=\"N\", changeid=\"".$emplid."\" WHERE emplnumber = \"$emplid\"";
if ($mysqlic->query($sql) === TRUE) {

} else {
    echo "Employee update failed" . $mysqlic->error;
	exit(1);
}
$mysqlic->close();
$log->logThis("new password saved");
delete_errormsg();
redirect("mainmenu.php");
?>