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

$maxRows_RateQuery = 15;
$pageNum_RateQuery = 0;
if (isset($_GET['pageNum_RateQuery'])) {
  $pageNum_StationQuery = $_GET['pageNum_RateQuery'];
}
$startRow_RateQuery = $pageNum_RateQuery * $maxRows_RateQuery;

$query_RateQuery = "SELECT * FROM rates ORDER BY Name";
$query_limit_RateQuery = sprintf("%s LIMIT %d, %d", $query_RateQuery, $startRow_RateQuery, $maxRows_RateQuery);
$RateQuery = $mysqli->query($query_limit_RateQuery) or die(mysqli_error());
$RateQuery2 = $mysqli->query($query_limit_RateQuery) or die(mysqli_error());
$row_RateQuery = $RateQuery->fetch_assoc();
$row_RateQuery2 = $RateQuery2->fetch_assoc();

if (isset($_GET['totalRows_RateQuery'])) {
  $totalRows_StationQuery = $_GET['totalRows_RateQuery'];
} else {
  $all_RateQuery = $mysqli->query($query_RateQuery);
  $totalRows_RateQuery = $all_RateQuery->num_rows;
}
$totalPages_RateQuery = ceil($totalRows_RateQuery/$maxRows_RateQuery)-1;

$query_TransactionTypeQuery = "SELECT * FROM transactiontypes";
$TransactionTypeQuery = $mysqli->query($query_TransactionTypeQuery) or die(mysqli_error());
$row_TransactionTypeQuery = $TransactionTypeQuery->fetch_assoc();
$totalRows_TransactionTypeQuery = $TransactionTypeQuery->num_rows;
?>
        <?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
				<h2>Tarifas</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9">
			<a class="btn btn-secondary" href="rateAdd.php" role="button"><img src="images/coins.png" width="64px" height="64px"></a>
			</div>
		</div><!-- end row -->
        
        <div class="row">
			<div class="col-xs-12 col-md-9">
				<?php do { ?>
					<!-- Modal -->
					<div class="modal fade" id="myModal<?php echo $row_RateQuery2['Id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row_StationQuery2['Id'];?>" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel<?php echo $row_RateQuery2['Id'];?>">Eliminar Estacion</h4>
						  </div>
						  <div class="modal-body">
							Desea eliminar la estacion <h4 class="d-inline"><?php echo $row_RateQuery2['Name']; ?></h4>?
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a type="button" class="btn btn-danger" href="RateDelete.php?recordID=<?php echo $row_RateQuery2['Id']; ?>" role="button">Eliminar</a>
						  </div>
						</div>
					  </div>
					</div>
				<?php } while ($row_RateQuery2 = $RateQuery2->fetch_assoc()); ?>
			<table class="table">
					<thead class="thead-default">
						<tr>
							<th>Nombre</th>
    						<th>Descripcion</th>
    						<th>Monto</th>
                            <th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php do { ?>
					    <tr>
  						    <td><?php echo $row_RateQuery['Name']; ?></td>
  						    <td><?php echo $row_RateQuery['Description']; ?></td>
  						    <td><?php echo $row_RateQuery['MaxAmount']; ?></td>
  						    <td><a class="btn btn-warning" href="RateEdit.php?recordID=<?php echo $row_RateQuery['Id']; ?>" role="button">Modificar</a> - <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row_RateQuery['Id'];?>">Eliminar</button></td>
						</tr>
						<?php } while ($row_RateQuery = $RateQuery->fetch_assoc()); ?>
					</tbody>
				</table>
			</div>
		</div><!-- end row -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($RateQuery);

mysqli_free_result($TransactionTypeQuery);
?>