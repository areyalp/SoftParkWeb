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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmuseradd")) {
  $insertSQL = sprintf("INSERT INTO users (UserTypeId, Passport, FirstName, LastName, Email, MobilePhone, Login, Password, CreatedDate, Status) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, NOW(), %s)",
                       GetSQLValueString($mysqli, $_POST['UserTypeId'], "int"),
                       GetSQLValueString($mysqli, $_POST['Passport'], "text"),
                       GetSQLValueString($mysqli, $_POST['FirstName'], "text"),
                       GetSQLValueString($mysqli, $_POST['LastName'], "text"),
                       GetSQLValueString($mysqli, $_POST['Email'], "text"),
                       GetSQLValueString($mysqli, $_POST['MobilePhone'], "text"),
                       GetSQLValueString($mysqli, $_POST['Login'], "text"),
                       GetSQLValueString($mysqli, md5($_POST['Password']), "text"),
                       #GetSQLValueString($mysqli, $_POST['CreatedDate'], "date"),
                       GetSQLValueString($mysqli, isset($_POST['Status']) ? "true" : "", "defined","1","0"));

  # mysql_select_db($database_softPark, $softPark);
  $Result1 = $mysqli->query($insertSQL) or die(mysqli_error());

  $insertGoTo = "userList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

# mysql_select_db($database_softPark, $softPark);
$query_useraddquery = "SELECT * FROM users";
$useraddquery = $mysqli->query($query_useraddquery) or die(mysqli_error());
$row_useraddquery = $useraddquery->fetch_assoc();
$totalRows_useraddquery = $useraddquery->num_rows;

# mysql_select_db($database_softPark, $softPark);
$query_userTypeQuery = "SELECT * FROM usertype";
$userTypeQuery = $mysqli->query($query_userTypeQuery) or die(mysql_error());
$row_userTypeQuery = $userTypeQuery->fetch_assoc();
$totalRows_userTypeQuery = $userTypeQuery->num_rows;
?>
<?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
                	<h2>Agregar Usuario</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
				<form method="post" name="frmuseradd" action="<?php echo $editFormAction; ?>">
					<input type="hidden" name="CreatedDate" value="date">
                    <input type="hidden" name="MM_insert" value="frmuseradd">
					<div class="form-group row">
						<label for="Login" class="col-sm-3 col-form-label">Usuario:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="Login" name="Login" value="" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="UserTypeId" class="col-sm-3 col-form-label">Tipo Usuario:</label>
						<div class="col-sm-4">
							<select class="form-control" id="UserTypeId" name="UserTypeId">
								<?php do { ?>
									<option value="<?php echo $row_userTypeQuery['Id']?>" ><?php echo $row_userTypeQuery['Name']?></option>
								<?php } while ($row_userTypeQuery = $userTypeQuery->fetch_assoc()); ?>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<label for="Passport" class="col-sm-3 col-form-label">Cedula:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="Passport" name="Passport" value="" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="FirstName" class="col-sm-3 col-form-label">Nombre:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="FirstName" name="FirstName" value="" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="LastName" class="col-sm-3 col-form-label">Apellido:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="LastName" name="LastName" value="" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="Email" class="col-sm-3 col-form-label">Email:</label>
						<div class="col-sm-4">
							<input type="email" class="form-control" id="Email" name="Email" value="" size="32">
						</div>
					</div>
					<div class="form-group row">
						<label for="MobilePhone" class="col-sm-3 col-form-label">Celular:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="MobilePhone" name="MobilePhone" value="" size="32">
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
									<input type="checkbox" class="form-check-input" name="Status" value="">
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
mysqli_free_result($useraddquery);

mysqli_free_result($userTypeQuery);
?>
