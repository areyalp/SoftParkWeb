<?php require_once('Connections/db.php'); ?>
<?php require_once('Connections/softPark.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($mysqli, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmconfigEdit")) {
  $updateSQL = sprintf("UPDATE configs SET `Value`=%s WHERE Name=%s",
                       GetSQLValueString($mysqli, $_POST['Value'], "int"),
                       GetSQLValueString($mysqli, $_POST['Name'], "text"));

    $Result1 = $mysqli->query($updateSQL) or die(mysql_error());

  $updateGoTo = "configsList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$VarIdlevels = "0";
if (isset($_GET["recordID"])) {
  $VarNameconfigs = $_GET["recordID"];
}

$query_configEditQuery = sprintf("SELECT * FROM configs WHERE configs.Name=%s", GetSQLValueString($mysqli, $VarNameconfigs, "text"));
$configEditQuery = $mysqli->query($query_configEditQuery) or die(mysql_error());
$row_configEditQuery = $configEditQuery->fetch_assoc();
$totalRows_configEditQuery = $configEditQuery->num_rows;

?>
	<?php include('header.php'); ?>
            <div id="user">
            	<?php include("includes/sesionUser.php"); ?>
            </div>
         
      		<div class="row">
				<div class="col-xs-12 col-md-9 title">
					<h2>Editar Configuracion</h2>
				</div>
			                                
               <div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
                <form method="post" name="frmconfigEdit" action="<?php echo $editFormAction; ?>">              
				<div class="form-group row">
					<label for="Value" class="col-sm-2 col-form-label">Nombre:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Value" name="Value" value="<?php echo htmlentities($row_configEditQuery['Value'], ENT_COMPAT, 'utf-8'); ?>" size="32">					
					</div>
				</div>
            
				<div class="form-group row">
						<div class="offset-sm-3 col-sm-4">
							<button type="submit" class="btn btn-primary">Aceptar</button>
						</div>
					</div>
                    <input type="hidden" name="MM_update" value="frmconfigEdit">
                    <input type="hidden" name="Name" value="<?php echo $row_configEditQuery['Name']; ?>">
				</form>
			</div><!-- end #user -->
        </div><!-- end row -->

<?php include("footer.php"); ?>
<?php
mysqli_free_result($configEditQuery);
?>
