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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmuseradd")) {
  $insertSQL = sprintf("INSERT INTO users (UserTypeId, Passport, FirstName, LastName, Email, MobilePhone, Login, Password, CreatedDate, Status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s)",
                       GetSQLValueString($_POST['UserTypeId'], "int"),
                       GetSQLValueString($_POST['Passport'], "text"),
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['MobilePhone'], "text"),
                       GetSQLValueString($_POST['Login'], "text"),
                       GetSQLValueString(md5($_POST['Password']), "text"),
                       GetSQLValueString($_POST['CreatedDate'], "date"),
                       GetSQLValueString(isset($_POST['Status']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_softPark, $softPark);
  $Result1 = mysql_query($insertSQL, $softPark) or die(mysql_error());

  $insertGoTo = "userList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_softPark, $softPark);
$query_useraddquery = "SELECT * FROM users";
$useraddquery = mysql_query($query_useraddquery, $softPark) or die(mysql_error());
$row_useraddquery = mysql_fetch_assoc($useraddquery);
$totalRows_useraddquery = mysql_num_rows($useraddquery);

mysql_select_db($database_softPark, $softPark);
$query_userTypeQuery = "SELECT * FROM usertype";
$userTypeQuery = mysql_query($query_userTypeQuery, $softPark) or die(mysql_error());
$row_userTypeQuery = mysql_fetch_assoc($userTypeQuery);
$totalRows_userTypeQuery = mysql_num_rows($userTypeQuery);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Agregar Usuario</title>
<link rel="stylesheet" type="text/css" href="styles/base.css"/>
</head>

<body>
	<div id="container">
  		
        <header>
        	<h1>SoftPark</h1>
    	</header><!-- end header -->
        
        <section>
  			<div id="content">
            	<div class="content">
            		<div class="title">
                		<h2>Agregar Usuario</h2>
                	</div><!-- end title -->
                    
                    <div class="form">
                      <form method="post" name="frmuseradd" action="<?php echo $editFormAction; ?>">
                        <table align="center">
                          <tr valign="baseline">
                            <td nowrap align="right">Tipo Usuario:</td>
                            <td><select name="UserTypeId">
                              <?php 
do {  
?>
                              <option value="<?php echo $row_userTypeQuery['Id']?>" ><?php echo $row_userTypeQuery['Name']?></option>
                              <?php
} while ($row_userTypeQuery = mysql_fetch_assoc($userTypeQuery));
?>
                            </select></td>
                          <tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Cedula:</td>
                            <td><input type="text" name="Passport" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Nombre:</td>
                            <td><input type="text" name="FirstName" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Apellido:</td>
                            <td><input type="text" name="LastName" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Email:</td>
                            <td><input type="text" name="Email" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Celular:</td>
                            <td><input type="text" name="MobilePhone" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Usuario:</td>
                            <td><input type="text" name="Login" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Contraseña:</td>
                            <td><input type="password" name="Password" value="" size="32"></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="left">Status:</td>
                            <td><input type="checkbox" name="Status" value="" ></td>
                          </tr>
                          <tr valign="baseline">
                            <td nowrap align="right">&nbsp;</td>
                            <td><input name="button" type="image" id="button" src="images/check_blue.png" alt="Aceptar"></td>
                          </tr>
                        </table>
                        <input type="hidden" name="CreatedDate" value="date">
                        <input type="hidden" name="MM_insert" value="frmuseradd">
                      </form>
                      <p>&nbsp;</p>
<!---------------------------------------------------------------------------->
   	           		  </div><!-- end .form -->
            	</div><!-- end .content -->       
    		</div><!-- end content -->
        </section><!-- end section -->
        
  		<footer>
    		<p>Desarrollado para </p>
    	</footer><!-- end footer -->
        
  </div><!-- end .container -->
  
</body>
</html>
<?php
mysql_free_result($useraddquery);

mysql_free_result($userTypeQuery);
?>
