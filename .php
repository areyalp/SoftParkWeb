<?php require_once('Connections/softPark.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_softPark, $softPark);
$query_AccessUserQuery = "SELECT * FROM users";
$AccessUserQuery = mysql_query($query_AccessUserQuery, $softPark) or die(mysql_error());
$row_AccessUserQuery = mysql_fetch_assoc($AccessUserQuery);
$totalRows_AccessUserQuery = mysql_num_rows($AccessUserQuery);

mysql_select_db($database_softPark, $softPark);
$query_AccesUserType = "SELECT * FROM usertype";
$AccesUserType = mysql_query($query_AccesUserType, $softPark) or die(mysql_error());
$row_AccesUserType = mysql_fetch_assoc($AccesUserType);
$totalRows_AccesUserType = mysql_num_rows($AccesUserType);

mysql_select_db($database_softPark, $softPark);
$query_userTypePermission = "SELECT * FROM usertypepermissions";
$userTypePermission = mysql_query($query_userTypePermission, $softPark) or die(mysql_error());
$row_userTypePermission = mysql_fetch_assoc($userTypePermission);
$totalRows_userTypePermission = mysql_num_rows($userTypePermission);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "UserTypeId";
  $MM_redirectLoginSuccess = "principal.php";
  $MM_redirectLoginFailed = "Index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_softPark, $softPark);
  	
  $LoginRS__query=sprintf("SELECT Login, Password, UserTypeId FROM users WHERE Login=%s AND Password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $softPark) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'UserTypeId');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=md5($_POST['password']);
  $MM_fldUserAuthorization = "UserTypeId";
  $MM_redirectLoginSuccess = "principal.php";
  $MM_redirectLoginFailed = "access_error.ph";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_softPark, $softPark);
  	
  $LoginRS__query=sprintf("SELECT Login, Password, UserTypeId FROM users WHERE Login=%s AND Password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $softPark) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'UserTypeId');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Inicio de Sesion</title>
<link rel="stylesheet" type="text/css" href="styles/Style.css"/>
</head>

<body>
	<header>
        <div id="image">
        </div>
    </header>
    
    <section>
    	<div id="content">
        
        	<div id="logo">
            	<h1> SoftPark</h1>
        	</div>
            
        	<div id="options">
           	  <form ACTION="<?php echo $loginFormAction; ?>" id="frmlogin" name="frmlogin" method="POST">
               		  <p>Usuario
               		     <label for="Usuario"></label>
                        <input type="text" name="user" id="user">
                      <p>Contraseña
               		    <input type="password" name="password" id="password">
               		  <p>
           		    <input name="button" type="image" id="button" src="images/check_blue.png" alt="Login">
               		    <input name="button" type="image" id="button" src="images/cross_red.png" alt="Salir">
           		    </p>
                </form>
            </div>
            
        </div>
    </section>
    <footer>
    	
    </footer>
    
</body>
</html>
<?php
mysql_free_result($AccessUserQuery);

mysql_free_result($AccesUserType);

mysql_free_result($userTypePermission);
?>
