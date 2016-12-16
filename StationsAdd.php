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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO stations (TypeId, LevelId, Name, `Description`, LastTicket, Active, Configuration, MacAddress) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($mysqli, $_POST['TypeId'], "int"),
                       GetSQLValueString($mysqli, $_POST['LevelId'], "int"),
                       GetSQLValueString($mysqli, $_POST['Name'], "text"),
                       GetSQLValueString($mysqli, $_POST['Description'], "text"),
                       GetSQLValueString($mysqli, $_POST['LastTicket'], "int"),
                       GetSQLValueString($mysqli, isset($_POST['Active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, $_POST['Configuration'], "text"),
                       GetSQLValueString($mysqli, $_POST['MacAddress'], "text"));

  #mysql_select_db($database_softPark, $softPark);
  $Result1 = $mysqli->query($insertSQL) or die(mysqli_error());

  $insertGoTo = "StationsList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

#mysql_select_db($database_softPark, $softPark);
$query_stationsAdd = "SELECT * FROM stations";
$stationsAdd = $mysqli->query($query_stationsAdd) or die(mysqli_error());
$row_stationsAdd = $stationsAdd->fetch_assoc();
$totalRows_stationsAdd = $stationsAdd->num_rows;

#mysql_select_db($database_softPark, $softPark);
$query_stationsTypeQuery = "SELECT * FROM stationstype ORDER BY stationstype.Name";
$stationsTypeQuery = $mysqli->query($query_stationsTypeQuery) or die(mysqli_error());
$row_stationsTypeQuery = $stationsTypeQuery->fetch_assoc();
$totalRows_stationsTypeQuery = $stationsTypeQuery->num_rows;

#mysql_select_db($database_softPark, $softPark);
$query_stationsLevelsQuery = "SELECT * FROM levels ORDER BY levels.Name ASC";
$stationsLevelsQuery = $mysqli->query($query_stationsLevelsQuery) or die(mysqli_error());
$row_stationsLevelsQuery = $stationsLevelsQuery->fetch_assoc();
$totalRows_stationsLevelsQuery = $stationsLevelsQuery->num_rows;
?>
<?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
                	<h2>Tipo de Estacion:</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
				<form method="post" name="frmusertypeadd" action="<?php echo $editFormAction; ?>">
				<input type="hidden" name="MM_insert" value="form1">
				<div class="form-group row">
					<label for="TypeId" class="col-sm-2 col-form-label">Tipo de Estacion:</label>
					<div class="col-sm-4">
						<select name="TypeId">
						<?php do {  ?>
							<option value="<?php echo $row_stationsTypeQuery['Id']?>" <?php if (!(strcmp($row_stationsTypeQuery['Id'], $row_stationsTypeQuery['Id']))) {echo "SELECTED";} ?>><?php echo $row_stationsTypeQuery['Name']?></option>
						<?php } while ($row_stationsTypeQuery = $stationsTypeQuery->fetch_assoc()); ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="LevelId" class="col-sm-2 col-form-label">LevelId:</label>
					<div class="col-sm-4">
						<select name="LevelId">
						<?php do {  ?>
							<option value="<?php echo $row_stationsLevelsQuery['Id']?>" <?php if (!(strcmp($row_stationsLevelsQuery['Id'], $row_stationsLevelsQuery['Id']))) {echo "SELECTED";} ?>><?php echo $row_stationsLevelsQuery['Name']?></option>
						<?php } while ($row_stationsLevelsQuery = $stationsLevelsQuery->fetch_assoc()); ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="Name" class="col-sm-2 col-form-label">Nombre:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Name" name="Name" value="" size="32">
					</div>
				</div>
				<div class="form-group row">
					<label for="Description" class="col-sm-2 col-form-label">Descripción:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Description" name="Description" value="" size="32">
					</div>
				</div>
				<div class="form-group row">
					<label for="LastTicket" class="col-sm-2 col-form-label">Ultimo Ticket:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="LastTicket" name="LastTicket" value="" size="32">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Active:</label>
					<div class="col-sm-4">
						<div class="form-check row">
							<label class="form-check-label">
								<input type="checkbox" class="form-check-input" name="Active" value="">
							</label>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="Configuration" class="col-sm-2 col-form-label">Configuración:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Configuration" name="Configuration" value="" size="32">
					</div>
				</div>
				<div class="form-group row">
					<label for="MacAddress" class="col-sm-2 col-form-label">MacAddress:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="MacAddress" name="MacAddress" value="" size="32">
					</div>
				</div>
				<div class="form-group row">
						<div class="offset-sm-3 col-sm-4">
							<button type="submit" class="btn btn-primary">Aceptar</button>
						</div>
					</div>
				</form>
			</div><!-- end #user -->
        </div><!-- end row -->

<?php include("footer.php"); ?>
<?php
mysqli_free_result($stationsAdd);

mysqli_free_result($stationsTypeQuery);

mysqli_free_result($stationsLevelsQuery);
?>
