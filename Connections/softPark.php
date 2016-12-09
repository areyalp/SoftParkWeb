<?php if (!isset($_SESSION)) {
  session_start();
}?>
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_softPark = "localhost";
$database_softPark = "softpark";
$username_softPark = "root";
$password_softPark = "";
$softPark = mysql_pconnect($hostname_softPark, $username_softPark, $password_softPark) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
<?php
if(is_file("includes/Funtions.php")){
include("includes/Funtions.php");
}else
{
	include("../includes/Funtions.php");
	
	}
?>