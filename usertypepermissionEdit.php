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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmPermiEdit")) {
  $updateSQL = sprintf("UPDATE usertypepermissions SET LogToWeb=%s, LogToProgram=%s, ViewUserTypes=%s, CreateUserTypes=%s, ViewUsers=%s, CreateUsers=%s, ViewStations=%s, CreateStations=%s, ViewLoginLog=%s, ViewSummary=%s, ViewTransactions=%s, ViewStats=%s, ViewVehicleTypes=%s, CreateVehicleTypes=%s, CanCheckOut=%s, CanPrintReportZ=%s, CanPrintReportX=%s WHERE UserTypeId=%s",
                       GetSQLValueString(isset($_POST['LogToWeb']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['LogToProgram']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewUserTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CreateUserTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewUsers']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CreateUsers']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewStations']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CreateStations']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewLoginLog']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewSummary']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewTransactions']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewStats']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['ViewVehicleTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CreateVehicleTypes']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CanCheckOut']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CanPrintReportZ']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString(isset($_POST['CanPrintReportX']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['UserTypeId'], "int"));

  #mysql_select_db($database_softPark, $softPark);
  $Result1 = mysql_query($updateSQL, $softPark) or die(mysql_error());

  $updateGoTo = "usertypepermissionList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$userType_UserTypePermissionQuery = "0";
if (isset($_GET["recordID"])) {
  $userType_UserTypePermissionQuery = $_GET["recordID"];
}
#mysql_select_db($database_softPark, $softPark);
$query_UserTypePermissionQuery = sprintf("SELECT * FROM usertypepermissions WHERE usertypepermissions.UserTypeId=%s", GetSQLValueString($mysqli, $userType_UserTypePermissionQuery, "int"));
$UserTypePermissionQuery = $mysqli->query($query_UserTypePermissionQuery) or die(mysql_error());
$row_UserTypePermissionQuery = $UserTypePermissionQuery->fetch_assoc();
$totalRows_UserTypePermissionQuery = $UserTypePermissionQuery->num_rows;
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
                	<h2>Permisos</h2>
                </div>
                
                <div> 
                </div>
                                
                <div class="userlist">
                	<form method="post" name="frmPermiEdit" action="<?php echo $editFormAction; ?>">
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
   							
                            <tr>
     							<td>&nbsp;</td>
     							<td><input name="button" type="image" id="button" src="images/check_blue.png" alt="Aceptar"></td>
     						</tr>
</table>
                    <input type="hidden" name="MM_update" value="frmPermiEdit">
                    <input type="hidden" name="UserTypeId" value="<?php echo $row_UserTypePermissionQuery['UserTypeId']; ?>">
                  </form>
                  <p>&nbsp;</p>
                </div>
                <!-- end .userlist -->
                
   		  </div><!-- end content -->
        </section><!-- end section -->
        
  		<footer>
    		<?php include("includes/footer.php"); ?>
    	</footer><!-- end footer -->
        
  </div><!-- end .container -->
  
</body>
</html>
<?php
mysqli_free_result($UserTypePermissionQuery);
?>
