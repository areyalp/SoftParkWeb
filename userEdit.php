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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE users SET UserTypeId=%s, Passport=%s, FirstName=%s, LastName=%s, Email=%s, MobilePhone=%s, Login=%s, Password=%s, Status=%s WHERE Id=%s",
                       GetSQLValueString($_POST['UserTypeId'], "int"),
                       GetSQLValueString($_POST['Passport'], "text"),
                       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['MobilePhone'], "text"),
                       GetSQLValueString($_POST['Login'], "text"),
                       GetSQLValueString(md5($_POST['Password']), "text"),
                       GetSQLValueString(isset($_POST['Status']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Id'], "int"));

  #mysql_select_db($database_softPark, $softPark);
  $Result1 = mysql_query($updateSQL, $softPark) or die(mysql_error());

  $updateGoTo = "userList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varuserID_UserEditQuery = "0";
if (isset($_GET["recordID"])) {
  $varuserID_UserEditQuery = $_GET["recordID"];
}
#mysql_select_db($database_softPark, $softPark);
$query_UserEditQuery = sprintf("SELECT * FROM users WHERE users.Id= %s", GetSQLValueString($mysqli, $varuserID_UserEditQuery, "int"));
$UserEditQuery = $mysqli->query($query_UserEditQuery) or die(mysqli_error());
$row_UserEditQuery = $UserEditQuery->fetch_assoc();
$totalRows_UserEditQuery = $UserEditQuery->num_rows;

#mysql_select_db($database_softPark, $softPark);
$query_UserTypeQuery = "SELECT * FROM usertype ORDER BY usertype.Name";
$UserTypeQuery = $mysqli->query($query_UserTypeQuery) or die(mysqli_error());
$row_UserTypeQuery = $UserTypeQuery->fetch_assoc();
$totalRows_UserTypeQuery = $UserTypeQuery->num_rows;
?>

		<?php include('header.php'); ?>
        <div class="row">
			<div id="user" class="col-xs-12 col-md-9"> 
				<?php include("includes/sesionUser.php"); ?>
			</div>
        </div><!-- end row -->
        
        <div class="row">
			<div class="col-xs-12 col-md-9 title">
                	<h2> Editar usuario</h2>
			</div>
		</div><!-- end row -->
		
        <div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
				<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
					<input type="hidden" name="MM_update" value="form1">
                    <input type="hidden" name="Id" value="<?php echo $row_UserEditQuery['Id']; ?>">
					<div class="form-group row">
						<label for="Login" class="col-sm-3 col-form-label">Usuario:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="Login" name="Login" value="<?php echo htmlentities($row_UserEditQuery['Login'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="UserTypeId" class="col-sm-3 col-form-label">Tipo Usuario:</label>
						<div class="col-sm-4">
							<select class="form-control" id="UserTypeId" name="UserTypeId">
							 <?php do { ?>
							 <option value="<?php echo $row_UserTypeQuery['Id']?>" <?php if (!(strcmp($row_UserTypeQuery['Id'], htmlentities($row_UserEditQuery['UserTypeId'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_UserTypeQuery['Name']?></option>
							 <?php } while ($row_UserTypeQuery = $UserTypeQuery->fetch_assoc()); ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="Passport" class="col-sm-3 col-form-label">Cedula:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="Passport" name="Passport" value="<?php echo htmlentities($row_UserEditQuery['Passport'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="FirstName" class="col-sm-3 col-form-label">Nombre:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="FirstName" name="FirstName" value="<?php echo htmlentities($row_UserEditQuery['FirstName'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="LastName" class="col-sm-3 col-form-label">Apellido:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="LastName" name="LastName" value="<?php echo htmlentities($row_UserEditQuery['LastName'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="Email" class="col-sm-3 col-form-label">Email:</label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="Email" name="Email" value="<?php echo htmlentities($row_UserEditQuery['Email'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="MobilePhone" class="col-sm-3 col-form-label">Celular:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="MobilePhone" name="MobilePhone" value="<?php echo htmlentities($row_UserEditQuery['MobilePhone'], ENT_COMPAT, 'utf-8'); ?>" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="Password" class="col-sm-3 col-form-label">Contraseña:</label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="Password" name="Password" value="" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Status:</label>
						<div class="col-sm-4">
							<div class="form-check row">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="Status" value=""  <?php if (!(strcmp($row_UserEditQuery['Status'],""))) {echo "checked=\"checked\"";} ?>>
								</label>
							</div>
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
mysqli_free_result($UserEditQuery);

mysqli_free_result($UserTypeQuery);
?>
