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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE users SET UserTypeId=%s, Passport=%s, FirstName=%s, LastName=%s, Email=%s, MobilePhone=%s, Login=%s, Password=%s, Status=%s WHERE Id=%s",
                       GetSQLValueString($_POST['UserTypeId'], "int"),
                       GetSQLValueString($_POST['Passport'], "text"),
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['MobilePhone'], "text"),
                       GetSQLValueString($_POST['Login'], "text"),
                       GetSQLValueString(md5($_POST['Password']), "text"),
                       GetSQLValueString(isset($_POST['Status']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Id'], "int"));

  #mysql_select_db($database_softPark, $softPark);
  $Result1 = mysql_query($updateSQL, $softPark) or die(mysql_error());

  $updateGoTo = "userList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varuserID_UserEditQuery = "0";
if (isset($_GET["recordID"])) {
  $varuserID_UserEditQuery = $_GET["recordID"];
}
#mysql_select_db($database_softPark, $softPark);
$query_UserEditQuery = sprintf("SELECT * FROM users WHERE users.Id= %s", GetSQLValueString($mysqli, $varuserID_UserEditQuery, "int"));
$UserEditQuery = $mysqli->query($query_UserEditQuery) or die(mysqli_error());
$row_UserEditQuery = $UserEditQuery->fetch_assoc();
$totalRows_UserEditQuery = mysqli_num_rows($UserEditQuery);

#mysql_select_db($database_softPark, $softPark);
$query_UserTypeQuery = "SELECT * FROM usertype ORDER BY usertype.Name";
$UserTypeQuery = $mysqli->query($query_UserTypeQuery) or die(mysqli_error());
$row_UserTypeQuery = $UserTypeQuery->fetch_assoc();
$totalRows_UserTypeQuery = mysqli_num_rows($UserTypeQuery);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Editar Usuario</title>
<link rel="stylesheet" type="text/css" href="styles/base.css"/>
</head>

<body>
	<div id="container">
  		
        <header>
        	<h1>SoftPark</h1>
    	</header><!-- end header -->
        
        <section>
  			<div id="content">
    			<div class="title">
                	<h2> Editar usuario</h2>
                </div>
                
                <div>
                </div>
                                
               <div class="userlist">
                 <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                   <table align="center">
                     <tr valign="baseline">
                       <td nowrap align="right">Tipo Usuario:</td>
                       <td><select name="UserTypeId">
                         <?php 
do {  
?>
                         <option value="<?php echo $row_UserTypeQuery['Id']?>" <?php if (!(strcmp($row_UserTypeQuery['Id'], htmlentities($row_UserEditQuery['UserTypeId'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_UserTypeQuery['Name']?></option>
                         <?php
} while ($row_UserTypeQuery = mysql_fetch_assoc($UserTypeQuery));
?>
                       </select></td>
                     <tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Cedula:</td>
                       <td><input type="text" name="Passport" value="<?php echo htmlentities($row_UserEditQuery['Passport'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Nombre:</td>
                       <td><input type="text" name="FirstName" value="<?php echo htmlentities($row_UserEditQuery['FirstName'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Apellido:</td>
                       <td><input type="text" name="LastName" value="<?php echo htmlentities($row_UserEditQuery['LastName'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Email:</td>
                       <td><input type="text" name="Email" value="<?php echo htmlentities($row_UserEditQuery['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Celular:</td>
                       <td><input type="text" name="MobilePhone" value="<?php echo htmlentities($row_UserEditQuery['MobilePhone'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Usuario:</td>
                       <td><input type="text" name="Login" value="<?php echo htmlentities($row_UserEditQuery['Login'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Contraseña:</td>
                       <td><input type="password" name="Password" value="" size="32"></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">Status:</td>
                       <td><input type="checkbox" name="Status" value=""  <?php if (!(strcmp($row_UserEditQuery['Status'],""))) {echo "checked=\"checked\"";} ?>></td>
                     </tr>
                     <tr valign="baseline">
                       <td nowrap align="right">&nbsp;</td>
                       <td><input name="button" type="image" id="button" src="images/check_blue.png" alt="Aceptar"></td>
                     </tr>
                   </table>
                   <input type="hidden" name="MM_update" value="form1">
                   <input type="hidden" name="Id" value="<?php echo $row_UserEditQuery['Id']; ?>">
                 </form>
                 <p>&nbsp;</p>
               </div>
               <!-- end .userlist -->
                
   		  </div><!-- end content -->
        </section><!-- end section -->
        
  		<footer>
    		<p>Desarrollado para </p>
    	</footer><!-- end footer -->
        
  </div><!-- end .container -->
  
</body>
</html>
<?php
mysqli_free_result($UserEditQuery);

mysqli_free_result($UserTypeQuery);
?>
