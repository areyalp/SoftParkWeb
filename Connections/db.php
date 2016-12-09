<?php if (!isset($_SESSION)) {
  session_start();
}?>
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_softPark = "127.0.0.1";
$database_softPark = "softpark";
$username_softPark = "web";
$password_softPark = "w3bus3r";
$mysqli = new mysqli($hostname_softPark, $username_softPark, $password_softPark, $database_softPark);

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>