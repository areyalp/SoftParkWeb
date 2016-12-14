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

$maxRows_StationQuery = 15;
$pageNum_StationQuery = 0;
if (isset($_GET['pageNum_StationQuery'])) {
  $pageNum_StationQuery = $_GET['pageNum_StationQuery'];
}
$startRow_StationQuery = $pageNum_StationQuery * $maxRows_StationQuery;

#mysql_select_db($database_softPark, $softPark);
$query_StationQuery = "SELECT * FROM stations ORDER BY Name";
$query_limit_StationQuery = sprintf("%s LIMIT %d, %d", $query_StationQuery, $startRow_StationQuery, $maxRows_StationQuery);
$StationQuery = $mysqli->query($query_limit_StationQuery) or die(mysqli_error());
$StationQuery2 = $mysqli->query($query_limit_StationQuery) or die(mysqli_error());
$row_StationQuery = $StationQuery->fetch_assoc();
$row_StationQuery2 = $StationQuery2->fetch_assoc();

if (isset($_GET['totalRows_StationQuery'])) {
  $totalRows_StationQuery = $_GET['totalRows_StationQuery'];
} else {
  $all_StationQuery = $mysqli->query($query_StationQuery);
  $totalRows_StationQuery = $all_StationQuery->num_rows;
}
$totalPages_StationQuery = ceil($totalRows_StationQuery/$maxRows_StationQuery)-1;

#mysql_select_db($database_softPark, $softPark);
$query_StationTypeQuery = "SELECT * FROM stationstype";
$StationTypeQuery = $mysqli->query($query_StationTypeQuery) or die(mysqli_error());
$row_StationTypeQuery = $StationTypeQuery->fetch_assoc();
$totalRows_StationTypeQuery = $StationTypeQuery->num_rows;
?>
        <?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
				<h2>Lista de Estaciones</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9">
			<a class="btn btn-secondary" href="StationsAdd.php" role="button"><img src="images/user-new.png" width="64px" height="64px"></a>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<?php do { ?>
					<!-- Modal -->
					<div class="modal fade" id="myModal<?php echo $row_StationQuery2['Id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row_StationQuery2['Id'];?>" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel<?php echo $row_StationQuery2['Id'];?>">Eliminar Estacion</h4>
						  </div>
						  <div class="modal-body">
							Desea eliminar la estacion <h4 class="d-inline"><?php echo $row_StationQuery2['Name']; ?></h4>?
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a type="button" class="btn btn-danger" href="StationsDelete.php?recordID=<?php echo $row_StationQuery2['Id']; ?>" role="button">Eliminar</a>
						  </div>
						</div>
					  </div>
					</div>
				<?php } while ($row_StationQuery2 = $StationQuery2->fetch_assoc()); ?>
			<table class="table">
					<thead class="thead-default">
						<tr>
							<th>Nombre</th>
    						<th>Descripcion</th>
    						<th>MacAddress</th>
                            <th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php do { ?>
					    <tr>
  						    <td><?php echo $row_StationQuery['Name']; ?></td>
  						    <td><?php echo $row_StationQuery['Description']; ?></td>
  						    <td><?php echo $row_StationQuery['MacAddress']; ?></td>
  						    <td><a class="btn btn-warning" href="StationsEdit.php?recordID=<?php echo $row_StationQuery['Id']; ?>" role="button">Modificar</a> - <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row_StationQuery['Id'];?>">Eliminar</button></td>
						</tr>
						<?php } while ($row_StationQuery = $StationQuery->fetch_assoc()); ?>
					</tbody>
				</table>
			</div>
		</div><!-- end row -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($StationQuery);

mysqli_free_result($StationTypeQuery);
?>
