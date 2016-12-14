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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "frmrateadd")) {
  $insertSQL = sprintf("INSERT INTO rates (TransactionTypeId, Name, Description, MaxAmount, Accumulative, Tax, Template) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($mysqli, $_POST['TransactionTypeId'], "int"),
                       GetSQLValueString($mysqli, $_POST['Name'], "text"),
                       GetSQLValueString($mysqli, $_POST['Description'], "text"),
                       GetSQLValueString($mysqli, $_POST['MaxAmount'], "double"),
					   GetSQLValueString($mysqli, isset($_POST['Accumulative']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, $_POST['Tax'], "double"),
                       GetSQLValueString($mysqli, isset($_POST['Template']) ? "true" : "", "defined","1","0"));

  # mysql_select_db($database_softPark, $softPark);
  $Result1 = $mysqli->query($insertSQL) or die(mysqli_error());

  $insertGoTo = "rateList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$query_Rateaddquery = "SELECT * FROM rates";
$Rateaddquery = $mysqli->query($query_Rateaddquery) or die(mysqli_error());
$row_Rateaddquery = $Rateaddquery->fetch_assoc();
$totalRows_Rateaddquery = $Rateaddquery->num_rows;

$query_TransactionTypeQuery = "SELECT * FROM transacctiontypes";
$TransactionTypeQuery = $mysqli->query($query_TransactionTypeQuery) or die(mysql_error());
$row_TransactionTypeQuery = $TransactionTypeQuery->fetch_assoc();
$totalRows_TransactionTypeQuery = $TransactionTypeQuery->num_rows;
?>
<?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
                	<h2>Agregar Tarifa</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
				<form method="post" name="frmrateadd" action="<?php echo $editFormAction; ?>">
					<input type="hidden" name="CreatedDate" value="date">
                    <input type="hidden" name="MM_insert" value="frmrateadd">
					
					<div class="form-group row">
						<label for="TransactionTypeId" class="col-sm-3 col-form-label">Tipo Transaccion:</label>
						<div class="col-sm-4">
							<select class="form-control" id="UserTypeId" name="TransactionTypeId">
								<?php do { ?>
									<option value="<?php echo $row_TransactionTypeQuery['Id']?>" ><?php echo $row_TransactionTypeQuery['Name']?></option>
								<?php } while ($row_TransactionTypeQuery = $TransactionTypeQuery->fetch_assoc()); ?>
							</select>
						</div>
					</div>
                    
                    <div class="form-group row">
						<label for="FirstName" class="col-sm-3 col-form-label">Nombre:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="Name" name="Name" value="" size="32">
						</div>
					</div>
                    
                    <div class="form-group row">
						<label for="LastName" class="col-sm-3 col-form-label">Descripcion:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="Description" name="Description" value="" size="32">
						</div>
					</div>
                    
                    <div class="form-group row">
						<label for="Login" class="col-sm-3 col-form-label">Precio:</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="MaxAmount" name="MaxAmount" value="" size="32">
						</div>
					</div>
                    
                    <div class="form-group row">
						<label class="col-sm-3 col-form-label">Acumulativo:</label>
						<div class="col-sm-4">
							<div class="form-check row">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="Accumulative" value="">
								</label>
							</div>
						</div>
					</div>
                    
					<div class="form-group row">
						<label for="Passport" class="col-sm-3 col-form-label">Iva</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="Tax" name="Tax" value="" size="32">
						</div>
					</div>
					
                    <div class="form-group row">
						<label class="col-sm-3 col-form-label">Template:</label>
						<div class="col-sm-4">
							<div class="form-check row">
								<label class="form-check-label">
									<input type="checkbox" class="form-check-input" name="Template" value="">
								</label>
							</div>
						</div>
					</div>
				</form>
			</div><!-- end #user -->
        </div><!-- end row -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($Rateaddquery);

mysqli_free_result($TransactionTypeQuery);
?>
