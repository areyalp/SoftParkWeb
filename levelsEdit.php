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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmlevelEdit")) {
  $updateSQL = sprintf("UPDATE levels SET Name=%s, `Description`=%s, ExitOption=%s, Minutes=%s, Places=%s WHERE Id=%s",
                       GetSQLValueString($mysqli, $_POST['Name'], "text"),
                       GetSQLValueString($mysqli, $_POST['Description'], "text"),
                       GetSQLValueString($mysqli, $_POST['ExitOption'], "int"),
                       GetSQLValueString($mysqli, $_POST['Minutes'], "int"),
					   GetSQLValueString($mysqli, $_POST['Places'], "int"),
                       GetSQLValueString($mysqli, $_POST['Id'], "int"));

    $Result1 = $mysqli->query($updateSQL) or die(mysql_error());

  $updateGoTo = "levelsList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$VarIdlevels = "0";
if (isset($_GET["recordID"])) {
  $VarIdlevels = $_GET["recordID"];
}

$query_levelsEditQuery = sprintf("SELECT * FROM levels WHERE levels.Id=%s", GetSQLValueString($mysqli, $VarIdlevels, "int"));
$levelsEditQuery = $mysqli->query($query_levelsEditQuery) or die(mysql_error());
$row_levelsEditQuery = $levelsEditQuery->fetch_assoc();
$totalRows_levelsEditQuery = $levelsEditQuery->num_rows;

?>
	<?php include('header.php'); ?>
            <div id="user">
            	<?php include("includes/sesionUser.php"); ?>
            </div>
         
      		<div class="row">
				<div class="col-xs-12 col-md-9 title">
					<h2>Editar Niveles</h2>
				</div>
			                                
               <div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
                <form method="post" name="frmlevelEdit" action="<?php echo $editFormAction; ?>">              
				<div class="form-group row">
					<label for="Name" class="col-sm-2 col-form-label">Nombre:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Name" name="Name" value="<?php echo htmlentities($row_levelsEditQuery['Name'], ENT_COMPAT, 'utf-8'); ?>" size="32">					
					</div>
				</div>
                
				<div class="form-group row">
					<label for="Description" class="col-sm-2 col-form-label">Descripción:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Description" name="Description" value="<?php echo htmlentities($row_levelsEditQuery['Description'], ENT_COMPAT, 'utf-8'); ?>" size="32">					
					</div>
				</div>
                
                <div class="form-group row">
					<label for="ExitOption" class="col-sm-2 col-form-label">Opción Salida:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="ExitOption" name="ExitOption" value="<?php echo htmlentities($row_levelsEditQuery['ExitOption'], ENT_COMPAT, 'utf-8'); ?>" size="32">
					</div>
				</div>
                
                <div class="form-group row">
					<label for="Minutes" class="col-sm-2 col-form-label">Minutos:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Minutes" name="Minutes" value="<?php echo htmlentities($row_levelsEditQuery['Minutes'], ENT_COMPAT, 'utf-8'); ?>" size="32">
					</div>
				</div>
				
                <div class="form-group row">
					<label for="Places" class="col-sm-2 col-form-label">N° de Puestos:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Places" name="Places" value="<?php echo htmlentities($row_levelsEditQuery['Places'], ENT_COMPAT, 'utf-8'); ?>" size="32">
					</div>
				</div>
                
				<div class="form-group row">
						<div class="offset-sm-3 col-sm-4">
							<button type="submit" class="btn btn-primary">Aceptar</button>
						</div>
					</div>
                    <input type="hidden" name="MM_update" value="frmlevelEdit">
                    <input type="hidden" name="Id" value="<?php echo $row_levelsEditQuery['Id']; ?>">
				</form>
			</div><!-- end #user -->
        </div><!-- end row -->

<?php include("footer.php"); ?>
<?php
mysqli_free_result($levelsEditQuery);
?>
