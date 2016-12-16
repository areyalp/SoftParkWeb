<?php require_once('Connections/db.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "frmRateEdit")) {
  $updateSQL = sprintf("UPDATE rates SET TransactionTypeId=%s, Name=%s, `Description`=%s, MaxAmount=%s, Accumulative=%s, Tax=%s, Template=%s WHERE Id=%s",
                       GetSQLValueString($mysqli, $_POST['TransactionTypeId'], "int"),
                       GetSQLValueString($mysqli, $_POST['Name'], "text"),
                       GetSQLValueString($mysqli, $_POST['Description'], "text"),
                       GetSQLValueString($mysqli, $_POST['MaxAmount'], "double"),
                       GetSQLValueString($mysqli, isset($_POST['Accumulative']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, $_POST['Tax'], "double"),
                       GetSQLValueString($mysqli, isset($_POST['Template']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($mysqli, $_POST['Id'], "int"));

    $Result1 = $mysqli->query($updateSQL) or die(mysql_error());

  $updateGoTo = "rateList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$VarIdRate_rateEditQuery = "0";
if (isset($_GET["recordID"])) {
  $VarIdRate_rateEditQuery = $_GET["recordID"];
}

$query_rateEditQuery = sprintf("SELECT * FROM rates WHERE rates.Id=%s", GetSQLValueString($mysqli, $VarIdRate_rateEditQuery, "int"));
$rateEditQuery = $mysqli->query($query_rateEditQuery) or die(mysql_error());
$row_rateEditQuery = $rateEditQuery->fetch_assoc();
$totalRows_rateEditQuery = $rateEditQuery->num_rows;


$query_rateTransactiontypes = "SELECT * FROM transactiontypes";
$rateTransactiontypes = $mysqli->query($query_rateTransactiontypes) or die(mysql_error());
$row_rateTransactiontypes = $rateTransactiontypes->fetch_assoc();
$totalRows_rateTransactiontypes = $rateTransactiontypes->num_rows;
?>
	<?php include('header.php'); ?>
        <div class="row">
			<div id="user" class="col-xs-12 col-md-9"> 
				<?php include("includes/sesionUser.php"); ?>
			</div>
        </div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
                	<h2> Editar Tarifa</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div id="user" class="offset-sm-3 col-xs-12 col-md-9">
                <form method="post" name="frmRateEdit" action="<?php echo $editFormAction; ?>">
				<div class="form-group row">
					<label for="TransactionTypeId" class="col-sm-2 col-form-label">Tipo de Transaccion:</label>
					<div class="col-sm-4">
						<select name="TransactionTypeId">
                         	<?php do {  ?>
                          		<option value="<?php echo $row_rateTransactiontypes['Id']?>" <?php if (!(strcmp($row_rateTransactiontypes['Id'], htmlentities($row_rateEditQuery['TransactionTypeId'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>><?php echo $row_rateTransactiontypes['Name']?></option>
                          	<?php } while ($row_rateTransactiontypes = $rateTransactiontypes->fetch_assoc());?>
                        </select>
					</div>
				</div>
                
				<div class="form-group row">
					<label for="Name" class="col-sm-2 col-form-label">Nombre:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Name" name="Name" value="<?php echo htmlentities($row_rateEditQuery['Name'], ENT_COMPAT, 'utf-8'); ?>" size="32"></td>					
					</div>
				</div>
                
				<div class="form-group row">
					<label for="Description" class="col-sm-2 col-form-label">Descripción:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Description" name="Description" value="<?php echo htmlentities($row_rateEditQuery['Description'], ENT_COMPAT, 'utf-8'); ?>" size="32">					
					</div>
				</div>
                
                <div class="form-group row">
					<label for="MaxAmount" class="col-sm-2 col-form-label">Monto:</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="MaxAmount" name="MaxAmount" value="<?php echo htmlentities($row_rateEditQuery['MaxAmount'], ENT_COMPAT, 'utf-8'); ?>" size="32">
					</div>
				</div>
                
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Acumulativo:</label>
					<div class="col-sm-4">
						<div class="form-check row">
							<label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="Accumulative" value="" <?php if (!(strcmp($row_rateEditQuery['Accumulative'],""))) {echo "checked=\"checked\"";} ?>>
                            </label>
						</div>
					</div>
				</div>
                
				<div class="form-group row">
					<label for="Tax" class="col-sm-2 col-form-label">Iva</label>
					<div class="col-sm-4">
                    	<input type="text" class="form-control" id="Tax" name="Tax" name="Tax" value=" <?php echo htmlentities($row_rateEditQuery['Tax'], ENT_COMPAT, 'utf-8'); ?>" size="32">
					</div>
				</div>
                
				<div class="form-group row">
					<label class="col-sm-3 col-form-label">Template:</label>
					<div class="col-sm-4">
						<div class="form-check row">
							<label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="Template" value=""  <?php if (!(strcmp($row_rateEditQuery['Template'],""))) {echo "checked=\"checked\"";} ?>>
                            </label>
						</div>
					</div>
				</div>
				<div class="form-group row">
						<div class="offset-sm-3 col-sm-4">
							<button type="submit" class="btn btn-primary">Aceptar</button>
						</div>
					</div>
                    <input type="hidden" name="MM_update" value="frmRateEdit">
                    <input type="hidden" name="Id" value="<?php echo $row_rateEditQuery['Id']; ?>">
				</form>
			</div><!-- end #user -->
        </div><!-- end row -->

<?php include("footer.php"); ?>
<?php
mysqli_free_result($rateEditQuery);

mysqli_free_result($rateTransactiontypes);
?>
