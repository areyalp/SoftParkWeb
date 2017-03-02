<?php require_once('Connections/db.php'); ?>
<?php require_once('Connections/softPark.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($mysqli, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($mysqli, $theValue) : mysqli_escape_string($mysqli, $theValue);

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

# mysql_select_db($database_softPark, $softPark);
$query_userQuery = "SELECT * FROM users";
$userQuery = $mysqli->query($query_userQuery) or die(mysqli_error());
$row_userQuery = $userQuery->fetch_assoc();
$totalRows_userQuery = $userQuery->num_rows;
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

# $loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=md5($_POST['password']);
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "principal.php";
  $MM_redirectLoginFailed = "Index.php";
  $MM_redirecttoReferrer = false;
  # mysql_select_db($database_softPark, $softPark);
  
  $LoginRS__query=sprintf("SELECT Id, Login, Password FROM users WHERE Login=%s AND Password=%s",
    GetSQLValueString($mysqli, $loginUsername, "text"), GetSQLValueString($mysqli, $password, "text")); 
   
  $LoginRS = $mysqli->query($LoginRS__query) or die(mysql_error());
  $row_LoginRS = $LoginRS->fetch_assoc();
  $loginFoundUser = $LoginRS->num_rows;
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare four session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
    $_SESSION['MM_Idusuario'] = $row_LoginRS["Id"];
    $_SESSION['MM_IdTypeUser'] = $row_LoginRS["UserTypeId"];
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
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>SoftPark - Inicio de Sesion</title>
	<link rel="stylesheet" type="text/css" href="styles/Style.css"/>
	<link rel="stylesheet" type="text/css" href="styles/base.css"/>
	<link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
</head>

<body>
	<header>
        <div id="image">
        </div>
    </header>
	
	<div class="container">
    
    <section>
    	<div id="content">
        
        	<div id="logo">
            	<h1> SoftPark</h1>
        	</div>
            
        	<div id="options">
           	  <form ACTION="" id="frmlogin" name="frmlogin" method="POST">
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
	
<?php include("footer.php"); ?>
<?php
mysqli_free_result($userQuery);

?>
