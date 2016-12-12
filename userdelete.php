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

if ((isset($_GET['recordID'])) && ($_GET['recordID'] != "")) {
  $deleteSQL = sprintf("DELETE FROM users WHERE Id=%s",
                       GetSQLValueString($mysqli, $_GET['recordID'], "int"));

  # mysql_select_db($database_softPark, $softPark);
  $Result1 = $mysqli->query($deleteSQL) or die(mysqli_error());

  $deleteGoTo = "userList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}
?>
<?php include('header.php'); ?>
        <div class="row">
			<div id="user" class="col-xs-12 col-md-9"> 
				<?php include("includes/sesionUser.php"); ?>
			</div>
        </div><!-- end row -->
        
        <section>
  			<div id="content">
            
            	<div class="title">
                	<h2> Eliminar usuario</h2>
                </div>
                <p>Usuario eliminado con exito</p>
    		</div><!-- end content -->
        </section><!-- end section -->
        
<?php include("footer.php"); ?>