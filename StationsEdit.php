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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmstationedit")) {
  $updateSQL = sprintf("UPDATE stations SET TypeId=%s, LevelId=%s, Name=%s, `Description`=%s, LastTicket=%s, Active=%s, Configuration=%s, MacAddress=%s WHERE Id=%s",
                       GetSQLValueString($mysqli, $_POST['TypeId'], "int"),
                       GetSQLValueString($mysqli, $_POST['LevelId'], "int"),
                       GetSQLValueString($mysqli, $_POST['Name'], "text"),
                       GetSQLValueString($mysqli, $_POST['Description'], "text"),
                       GetSQLValueString($mysqli, $_POST['LastTicket'], "int"),
                       GetSQLValueString($mysqli, isset($_POST['Active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, $_POST['Configuration'], "text"),
                       GetSQLValueString($mysqli, $_POST['MacAddress'], "text"),
                       GetSQLValueString($mysqli, $_POST['Id'], "int"));

  $Result1 = $mysqli->query($updateSQL) or die(mysql_error());

  $updateGoTo = "StationsList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$idstation_StationEditQuery = "0";
if (isset($_GET["recordID"])) {
  $varStationID_StationEditQuery = $_GET["recordID"];
}

$query_StationEditQuery = sprintf("SELECT * FROM stations WHERE stations.Id=%s", GetSQLValueString($mysqli, $varStationID_StationEditQuery , "int"));
$StationEditQuery = $mysqli->query($query_StationEditQuery) or die(mysql_error());
$row_StationEditQuery = $StationEditQuery->fetch_assoc();
$totalRows_StationEditQuery = $StationEditQuery->num_rows;


$query_stationsTypeQuery = "SELECT * FROM stationstype ORDER BY stationstype.Name";
$stationsTypeQuery = $mysqli->query($query_stationsTypeQuery) or die(mysql_error());
$row_stationsTypeQuery = $stationsTypeQuery->fetch_assoc();
$totalRows_stationsTypeQuery = $stationsTypeQuery->num_rows;


$query_SationsLevelsQuery = "SELECT * FROM levels ORDER BY levels.Name";
$SationsLevelsQuery = $mysqli->query($query_SationsLevelsQuery) or die(mysql_error());
$row_SationsLevelsQuery = $SationsLevelsQuery->fetch_assoc();
$totalRows_SationsLevelsQuery = $SationsLevelsQuery->num_rows;
?>
	<?php include('header.php'); ?>
        <div class="row">
			<div id="user" class="col-xs-12 col-md-9"> 
				<?php include("includes/sesionUser.php"); ?>
			</div>
        </div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
                	<h2> Editar Estacion</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
				<form method="post" name="frmstationedit" action="<?php echo $editFormAction; ?>">
					<div class="form-group row">
						<label for="TypeId" class="col-sm-2 col-form-label">Tipo de Estacion:</label>
						<div class="col-sm-4">
							<select name="TypeId">
                         	 <?php do {  ?>
                         		 <option value="<?php echo $row_stationsTypeQuery['Id']?>" <?php if (!(strcmp($row_stationsTypeQuery['Id'], htmlentities($row_StationEditQuery['TypeId'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_stationsTypeQuery['Name']?></option>
                          	<?php } while ($row_stationsTypeQuery = $stationsTypeQuery->fetch_assoc());?>
                        	</select>
						</div>
					</div>
                    
				<div class="form-group row">
					<label for="LevelId" class="col-sm-2 col-form-label">Level:</label>
					<div class="col-sm-4">
						<select name="LevelId">
                        	<?php do {  ?>
                          		<option value="<?php echo $row_SationsLevelsQuery['Id']?>" <?php if (!(strcmp($row_SationsLevelsQuery['Id'], htmlentities($row_StationEditQuery['LevelId'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_SationsLevelsQuery['Name']?></option>
                          	<?php } while ($row_SationsLevelsQuery = $SationsLevelsQuery->fetch_assoc());?>
                        </select>
					</div>
				</div>
                
				<div class="form-group row">
					<label for="Name" class="col-sm-2 col-form-label">Nombre:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Name" name="Name" value="<?php echo htmlentities($row_StationEditQuery['Name'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						
					</div>
				</div>
				<div class="form-group row">
					<label for="Description" class="col-sm-2 col-form-label">Descripción:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Description" name="Description" value="<?php echo htmlentities($row_StationEditQuery['Description'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						
					</div>
				</div>
                
				<div class="form-group row">
					<label for="LastTicket" class="col-sm-2 col-form-label">Ultimo Ticket:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="LastTicket" name="LastTicket" value="<?php echo htmlentities($row_StationEditQuery['LastTicket'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						
					</div>
				</div>
                
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Active:</label>
					<div class="col-sm-4">
						<div class="form-check row">
							<label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="Active" value=""  <?php if (!(strcmp($row_StationEditQuery['Active'],""))) {echo "checked=\"checked\"";} ?>>
							</label>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="Configuration" class="col-sm-2 col-form-label">Configuración:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Configuration" name="Configuration" value="<?php echo htmlentities($row_StationEditQuery['Configuration'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						
					</div>
				</div>
                
				<div class="form-group row">
					<label for="MacAddress" class="col-sm-2 col-form-label">MacAddress:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="MacAddress" name="MacAddress" value="<?php echo htmlentities($row_StationEditQuery['MacAddress'], ENT_COMPAT, 'utf-8'); ?>" size="32">
					
					</div>
				</div>
				<div class="form-group row">
						<div class="offset-sm-3 col-sm-4">
							<button type="submit" class="btn btn-primary">Aceptar</button>
						</div>
					</div>
                    <input type="hidden" name="MM_update" value="frmstationedit">
                    <input type="hidden" name="Id" value="<?php echo $row_StationEditQuery['Id']; ?>">
				</form>
			</div><!-- end #user -->
        </div><!-- end row -->

<?php include("footer.php"); ?>
<?php
mysqli_free_result($StationEditQuery);

mysqli_free_result($stationsTypeQuery);

mysqli_free_result($SationsLevelsQuery);
?>
