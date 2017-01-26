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
					   
	$Result1 = $mysqli->query($updateSQL) or die(mysqli_error());
					   
	$updateSQL = sprintf("UPDATE usertypepermissions SET LogToWeb=%s, LogToProgram=%s, ViewUserTypes=%s, CreateUserTypes=%s, ViewUsers=%s, CreateUsers=%s, ViewStations=%s, CreateStations=%s, ViewLoginLog=%s, ViewSummary=%s, ViewTransactions=%s, ViewStats=%s, ViewVehicleTypes=%s, CreateVehicleTypes=%s, CanCheckOut=%s, CanPrintReportZ=%s, CanPrintReportX=%s WHERE UserTypeId=%s",
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

  $Result1 = $mysqli->query($updateSQL) or die(mysqli_error());
  
  $updateGoTo = "usertypeList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$idusertype_usertypeEdit = "0";
$userType_UserTypePermissionQuery = "0";

if (isset($_GET["recordID"])) {
  $idusertype_usertypeEdit = $_GET["recordID"];
  $userType_UserTypePermissionQuery = $_GET["recordID"];
}


$query_usertypeEdit = sprintf("SELECT * FROM usertype WHERE usertype.Id=%s", GetSQLValueString($mysqli, $idusertype_usertypeEdit, "int"));
$usertypeEdit = $mysqli->query($query_usertypeEdit) or die(mysql_error());
$row_usertypeEdit = $usertypeEdit->fetch_assoc();
$totalRows_usertypeEdit = $usertypeEdit->num_rows;

$query_UserTypePermissionQuery = sprintf("SELECT * FROM usertypepermissions WHERE usertypepermissions.UserTypeId=%s", GetSQLValueString($mysqli, $userType_UserTypePermissionQuery, "int"));
$UserTypePermissionQuery = $mysqli->query($query_UserTypePermissionQuery) or die(mysql_error());
$row_UserTypePermissionQuery = $UserTypePermissionQuery->fetch_assoc();
$totalRows_UserTypePermissionQuery = $UserTypePermissionQuery->num_rows;
?>
        <?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
        
        <section>
  			<div id="content">
            
            	<div class="title">
                	<h2>Editar Perfil de Usuario</h2>
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
                     </table>
                    
                  
                  <p>&nbsp;</p>
                  <div class="title">
                	<h2>Permisología</h2>
                </div>
                  	
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
    							<td><input type="checkbox" name="LogToWeb" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['LogToWeb'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Tipo Usuarios</td>
    							<td><input type="checkbox" name="ViewUserTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewUserTypes'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Estaciones</td>
    							<td><input type="checkbox" name="ViewStations" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewStations'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Inicio de Sesion</td>
    							<td><input type="checkbox" name="ViewLoginLog" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewLoginLog'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Tipos de Vehículos</td>
    							<td><input type="checkbox" name="ViewVehicleTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewVehicleTypes'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Reporte Z</td>
    							<td><input type="checkbox" name="CanPrintReportZ" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CanPrintReportZ'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
  							</tr>
                            
  							<tr>
    							<td>Programa</td>
    							<td><input type="checkbox" name="LogToProgram" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['LogToProgram'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Crear Tipos Usuarios</td>
    							<td><input type="checkbox" name="CreateUserTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateUserTypes'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Crear Estaciones</td>
    							<td><input type="checkbox" name="CreateStations" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateStations'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Ver Sumario:</td>
    							<td><input type="checkbox" name="ViewSummary" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewSummary'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Crear Tipos de Vehículo</td>
    							<td><input type="checkbox" name="CreateVehicleTypes" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateVehicleTypes'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>Reporte X</td>
    							<td><input type="checkbox" name="CanPrintReportX" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CanPrintReportX'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
  							</tr>
                            
  							<tr>
    							<td colspan="2">&nbsp;</td>
    							<td>Ver Usuarios</td>
    							<td><input type="checkbox" name="ViewUsers" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewUsers'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td colspan="2">&nbsp;</td>
    							<td>Ver Transacciones</td>
    							<td><input type="checkbox" name="ViewTransactions" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewTransactions'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td>CanCheckOut</td>
    							<td><input type="checkbox" name="CanCheckOut" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CanCheckOut'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?>></td>
    							<td colspan="2">&nbsp;</td>
  							</tr>
  							
                            <tr>
    							<td colspan="2">&nbsp;</td>
    							<td>Crear Usuarios</td>
    							<td><input type="checkbox" name="CreateUsers" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['CreateUsers'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td colspan="2">&nbsp;</td>
    							<td>ViewStats:</td>
    							<td><input type="checkbox" name="ViewStats" value=""  <?php if (!(strcmp(htmlentities($row_UserTypePermissionQuery['ViewStats'], ENT_COMPAT, 'utf-8'),"1"))) {echo "checked=\"checked\"";} ?> /></td>
    							<td colspan="2">&nbsp;</td>
    							<td colspan="2">&nbsp;</td>
  							</tr>
   							<p>&nbsp;</p>
                            <tr>
     							<td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
     							<td><button type="submit" class="btn btn-primary">Aceptar</button></td>
     						</tr>
					</table>
                     <input type="hidden" name="MM_update" value="frmusertype">
                    <input type="hidden" name="Id" value="<?php echo $row_usertypeEdit['Id']; ?>">
                    <input type="hidden" name="UserTypeId" value="<?php echo $row_UserTypePermissionQuery['UserTypeId']; ?>">
                  </form>
                </div>
                <!-- end .userlist -->
                
    		</div><!-- end content -->
        </section><!-- end section -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($usertypeEdit);
mysqli_free_result($UserTypePermissionQuery);
?>
