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
$query_userQuery = "SELECT * FROM users";
$userQuery = mysql_query($query_userQuery, $softPark) or die(mysql_error());
$row_userQuery = mysql_fetch_assoc($userQuery);
$totalRows_userQuery = mysql_num_rows($userQuery);
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
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "principal.php";
  $MM_redirectLoginFailed = "Index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_softPark, $softPark);
  
  $LoginRS__query=sprintf("SELECT Id, Login, Password FROM users WHERE Login=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $softPark) or die(mysql_error());
  $row_LoginRS = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
	$_SESSION['MM_Idusuario'] = $row_LoginRS["Id"];
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
    	<?php include("includes/footer.php"); ?>
    </footer>
    
</body>
</html>
<?php
mysql_free_result($userQuery);

mysql_free_result($AccessUserQuery);

mysql_free_result($AccesUserType);

mysql_free_result($userTypePermission);
?>
