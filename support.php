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
require_once "includes/header1.inc";
require_once "includes/header2.inc";
require_once "includes/common.inc";
?>
*VetClinic Support</u></b></font></center><br><br>
*VetClinic Management Software provides support in the form of email and tickets on the Source Forge website. Because of the wide variety of platforms that
*VetClinic runs on, we are not able to provide support for the operating system or other applications.
<br>
For support other than bugs, use email address vetclinic.email@gmail.com.
<br><br>
*VetClinic.
In addition, registration is required for Special Features. See the Post Implementation Guide for information about Special Features. To register,
<a href="registration.php">click here</a>.
<br><br>
When you receive your reg.php file, move it to the vetclinic/temp directory and <a href="temp/reg.php">click here</a>.
<br><br>
*VetClinic Software, go to our tickets site at https://sourceforge.net/p/vetclinicmgmt/tickets/
<br><br>
<?php
include "includes/returnmainmenu.inc";
?>