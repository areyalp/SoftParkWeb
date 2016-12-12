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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmusertype")) {
  $updateSQL = sprintf("UPDATE usertype SET Name=%s, `Description`=%s WHERE Id=%s",
                       GetSQLValueString($mysqli, $_POST['Name'], "text"),
                       GetSQLValueString($mysqli, $_POST['Description'], "text"),
                       GetSQLValueString($mysqli, $_POST['Id'], "int"));

 # mysql_select_db($database_softPark, $softPark);
  $Result1 = $mysqli->query($updateSQL) or die(mysqli_error());

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
# mysql_select_db($database_softPark, $softPark);
$query_usertypeEdit = sprintf("SELECT * FROM usertype WHERE usertype.Id=%s", GetSQLValueString($mysqli, $idusertype_usertypeEdit, "int"));
$usertypeEdit = $mysqli->query($query_usertypeEdit) or die(mysql_error());
$row_usertypeEdit = $usertypeEdit->fetch_assoc();
$totalRows_usertypeEdit = $usertypeEdit->num_rows;
?>
        <?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
        
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
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($usertypeEdit);
?>
