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
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Description'], "text"));

  #mysql_select_db($database_softPark, $softPark);
  $Result1 = $mysql->query($insertSQL, $softPark) or die(mysql_error());

  $insertGoTo = "usertypeList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

#mysql_select_db($database_softPark, $softPark);
$query_usertypeAdd = "SELECT * FROM usertype";
$usertypeAdd = $mysqli->query($query_usertypeAdd) or die(mysql_error());
$row_usertypeAdd = $usertypeAdd->fetch_assoc();
$totalRows_usertypeAdd = $usertypeAdd->num_rows;
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
?>
