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
                       GetSQLValueString($mysqli, $_POST['Name'], "text"),
                       GetSQLValueString($mysqli, $_POST['Description'], "text"));

  	$Result1 = $mysqli->query($insertSQL) or die(mysql_error());
	$insertSQL = sprintf("INSERT INTO usertypepermissions (LogToWeb, LogToProgram, ViewUserTypes, CreateUserTypes, ViewUsers, CreateUsers, ViewStations, CreateStations, ViewLoginLog, ViewSummary, ViewTransactions, ViewStats, ViewVehicleTypes, CreateVehicleTypes, CanCheckOut, CanPrintReportZ, CanPrintReportX) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					   GetSQLValueString($mysqli, isset($_POST['LogToWeb']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['LogToProgram']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewUserTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['CreateUserTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewUsers']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['CreateUsers']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewStations']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['CreateStations']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewLoginLog']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewSummary']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewTransactions']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewStats']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['ViewVehicleTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['CreateVehicleTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['CanCheckOut']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['CanPrintReportZ']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, isset($_POST['CanPrintReportX']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, $_POST['UserTypeId'], "int"));	
	
	$Result1 = $mysqli->query($insertSQL) or die(mysql_error());
	
  $insertGoTo = "usertypeList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$query_usertypeAdd = "SELECT * FROM usertype";
$usertypeAdd = $mysqli->query($query_usertypeAdd) or die(mysql_error());
$row_usertypeAdd = $usertypeAdd->fetch_assoc();
$totalRows_usertypeAdd = $usertypeAdd->num_rows;

$query_UserTypePermissionQuery = "SELECT * FROM usertypepermissions";
$UserTypePermissionQuery = $mysqli->query($query_UserTypePermissionQuery) or die(mysql_error());
$row_UserTypePermissionQuery = $UserTypePermissionQuery->fetch_assoc();
$totalRows_UserTypePermissionQuery = $UserTypePermissionQuery->num_rows;
?>
<?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
                	<h2>Agregar Perfil de Usuario</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
				<form method="post" name="frmusertypeadd" action="<?php echo $editFormAction; ?>">
				<input type="hidden" name="MM_insert" value="frmusertypeadd">
				<div class="form-group row">
					<label for="Name" class="col-sm-2 col-form-label">Nombre:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Name" name="Name" value="" size="32">
					</div>
				</div>
				<div class="form-group row">
					<label for="Description" class="col-sm-2 col-form-label">Descripcion:</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Description" name="Description" value="" size="32">
					</div>
				</div>
                <p>&nbsp;</p>
                  <div class="title">
                	<h2>Permisología</h2>
                </div>
                <p>&nbsp;</p>
                    <table width="100%">
  							<tr>
    							<td colspan="2">Iniciar Sesion</td>
    							<td colspan="2">Usuarios</td>
    							<td colspan="2">Estaciones</td>
    							<td colspan="2">Registros</td>
    							<td colspan="2">Vehículos</td>
    							<td colspan="2">Reportes</td>
  							</tr>
                            
  							<tr>
    							<td>Web </td>
    							<td><input type="checkbox" name="LogToWeb" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['LogToWeb'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Tipo Usuarios</td>
    							<td><input type="checkbox" name="ViewUserTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewUserTypes'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Estaciones</td>
    							<td><input type="checkbox" name="ViewStations" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewStations'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Inicio de Sesion</td>
    							<td><input type="checkbox" name="ViewLoginLog2" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewLoginLog'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Tipos de Vehículos</td>
    							<td><input type="checkbox" name="ViewVehicleTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewVehicleTypes'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Reporte Z</td>
    							<td><input type="checkbox" name="CanPrintReportZ" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CanPrintReportZ'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
  							</tr>
                            
  							<tr>
    							<td>Programa</td>
    							<td><input type="checkbox" name="LogToProgram" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['LogToProgram'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Crear Tipos Usuarios</td>
    							<td><input type="checkbox" name="CreateUserTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateUserTypes'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Crear Estaciones</td>
    							<td><input type="checkbox" name="CreateStations" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateStations'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Sumario:</td>
    							<td><input type="checkbox" name="ViewSummary" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewSummary'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Crear Tipos de Vehículo</td>
    							<td><input type="checkbox" name="CreateVehicleTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateVehicleTypes'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Reporte X</td>
    							<td><input type="checkbox" name="CanPrintReportX" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CanPrintReportX'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
  							</tr>
                            
  							<tr>
    							<td colspan="2">&nbsp;</td>
    							<td>Ver Usuarios</td>
    							<td><input type="checkbox" name="ViewUsers" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewUsers'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td colspan="2">&nbsp;</td>
    							<td>Ver Transacciones</td>
    							<td><input type="checkbox" name="ViewTransactions" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewTransactions'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>CanCheckOut</td>
    							<td><input type="checkbox" name="CanCheckOut" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CanCheckOut'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?>></td>
    							<td colspan="2">&nbsp;</td>
  							</tr>
  							
                            <tr>
    							<td colspan="2">&nbsp;</td>
    							<td>Crear Usuarios</td>
    							<td><input type="checkbox" name="CreateUsers" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateUsers'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td colspan="2">&nbsp;</td>
    							<td>ViewStats:</td>
    							<td><input type="checkbox" name="ViewStats" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewStats'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    							<td colspan="2">&nbsp;</td>
    							<td colspan="2">&nbsp;</td>
  							</tr>
                      </table>
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
mysqli_free_result($usertypeAdd);

mysqli_free_result($UserTypePermissionQuery);
?>
