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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmusertype")) {
  $updateSQL = sprintf("UPDATE usertype SET Name=%s, `Description`=%s WHERE Id=%s",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Description'], "text"),
                       GetSQLValueString($_POST['Id'], "int"));

  mysql_select_db($database_softPark, $softPark);
  $Result1 = mysql_query($updateSQL, $softPark) or die(mysql_error());

  $updateGoTo = "usertypeList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$idusertype_usertypeEdit = "0";
if (isset($_GET['recordID'])) {
  $idusertype_usertypeEdit = $_GET['recordID'];
}
mysql_select_db($database_softPark, $softPark);
$query_usertypeEdit = sprintf("SELECT * FROM usertype WHERE usertype.Id=%s", GetSQLValueString($idusertype_usertypeEdit, "int"));
$usertypeEdit = mysql_query($query_usertypeEdit, $softPark) or die(mysql_error());
$row_usertypeEdit = mysql_fetch_assoc($usertypeEdit);
$totalRows_usertypeEdit = mysql_num_rows($usertypeEdit);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Principal</title>
<link rel="stylesheet" type="text/css" href="styles/base.css"/>
</head>

<body>
	<div id="container">
  		
        <header>
        	<h1>SoftPark</h1>
            <div id="user">
            	<p> Bienvenido </p>
            </div>
    	</header><!-- end header -->
        
        <section>
  			<div id="content">
            
            	<div class="title">
                	<h2>Editar Niveles de Usuario</h2>
                </div>
                
                <div> 
              </div>
                                
                <div class="userlist">
                  <form method="post" name="frmusertype" action="<?php echo $editFormAction; ?>">
                    <table align="center">
                      <tr valign="baseline">
                        <td nowrap align="right">Nombre:</td>
                        <td><input type="text" name="Name" value="<?php echo htmlentities($row_usertypeEdit['Name'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Descripción:</td>
                        <td><input type="text" name="Description" value="<?php echo htmlentities($row_usertypeEdit['Description'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">&nbsp;</td>
                        <td><input name="button" type="image" id="button" src="images/check_blue.png" alt="Aceptar"></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_update" value="frmusertype">
                    <input type="hidden" name="Id" value="<?php echo $row_usertypeEdit['Id']; ?>">
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
mysql_free_result($usertypeEdit);
?>
