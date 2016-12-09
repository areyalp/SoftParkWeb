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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmusertypeadd")) {
  $insertSQL = sprintf("INSERT INTO usertype (Name, `Description`) VALUES (%s, %s)",
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Description'], "text"));

  mysql_select_db($database_softPark, $softPark);
  $Result1 = mysql_query($insertSQL, $softPark) or die(mysql_error());

  $insertGoTo = "usertypeList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_softPark, $softPark);
$query_usertypeAdd = "SELECT * FROM usertype";
$usertypeAdd = mysql_query($query_usertypeAdd, $softPark) or die(mysql_error());
$row_usertypeAdd = mysql_fetch_assoc($usertypeAdd);
$totalRows_usertypeAdd = mysql_num_rows($usertypeAdd);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Agregar Tipo Usuario</title>
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
                	<h2> Lista de usuarios</h2>
                </div>
                
                <div> 
              </div>
                                
                <div class="userlist">
                  <form method="post" name="frmusertypeadd" action="<?php echo $editFormAction; ?>">
                    <table align="center">
                      <tr valign="baseline">
                        <td nowrap align="right">Nombre:</td>
                        <td><input type="text" name="Name" value="" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">Descripción:</td>
                        <td><input type="text" name="Description" value="" size="32"></td>
                      </tr>
                      <tr valign="baseline">
                        <td nowrap align="right">&nbsp;</td>
                        <td><input name="button" type="image" id="button" src="images/check_blue.png" alt="Aceptar"></td>
                      </tr>
                    </table>
                    <input type="hidden" name="MM_insert" value="frmusertypeadd">
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
mysql_free_result($usertypeAdd);
?>
