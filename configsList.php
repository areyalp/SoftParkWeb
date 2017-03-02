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

$maxRows_configList_query = 10;
$pageNum_configList_query = 0;
if (isset($_GET['pageNum_configlist_query'])) {
  $pageNum_configList_query = $_GET['pageNum_configlist_query'];
}
$startRow_configList_query = $pageNum_configList_query * $maxRows_configList_query;

$query_configList_query = "SELECT * FROM configs ORDER BY configs.Name ASC";
$query_limit_configList_query = sprintf("%s LIMIT %d, %d", $query_configList_query, $startRow_configList_query, $maxRows_configList_query);
$configList_query = $mysqli->query($query_limit_configList_query) or die(mysqli_error());
$configList_query2 = $mysqli->query($query_limit_configList_query) or die(mysqli_error());
$row_configList_query = $configList_query->fetch_assoc();
$row_configList_query2 = $configList_query2->fetch_assoc();

if (isset($_GET['totalRows_configlist_query'])) {
  $totalRows_levelsList_query = $_GET['totalRows_configlist_query'];
} else {
  $all_configList_query = $mysqli->query($query_configList_query);
  $totalRows_configList_query = $all_configList_query->num_rows;
}
$totalPages_configList_query = ceil($totalRows_configList_query/$maxRows_configList_query)-1;
?>
        <?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
				<h2>Otras Configuraciones</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9">
			<a class="btn btn-secondary" href="levelsAdd.php" role="button"><img src="images/tools.png" width="64px" height="64px"></a>
			</div>
		</div><!-- end row -->
        
        <div class="row">
			<div class="col-xs-12 col-md-9">
				<?php do { ?>
					<!-- Modal -->
					<div class="modal fade" id="myModal<?php echo $row_configList_query2['Id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row_configList_query2['Id'];?>" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel<?php echo $row_configList_query2['Id'];?>">Eliminar Estacion</h4>
						  </div>
						  <div class="modal-body">
							Desea eliminar la estacion <h4 class="d-inline"><?php echo $row_configList_query2['Name']; ?></h4>?
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a type="button" class="btn btn-danger" href="levelsDelete.php?recordID=<?php echo $row_configList_query2['Id']; ?>" role="button">Eliminar</a>
						  </div>
						</div>
					  </div>
					</div>
				<?php } while ($row_configList_query2 = $configList_query2->fetch_assoc()); ?>
			<table class="table">
					<thead class="thead-default">
						<tr>
							<th>Nombre</th>
    						<th>Tiempo</th>
    						<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php do { ?>
					    <tr>
  						    <td><?php echo $row_configList_query['Name']; ?></td>
  						    <td><?php echo $row_configList_query['Value']; ?></td>
  						    <td><a class="btn btn-warning" href="configsEdit.php?recordID=<?php echo $row_configList_query['Name']; ?>" role="button">Modificar</a> - <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row_configList_query['Name'];?>">Eliminar</button></td>
						</tr>
						<?php } while ($row_configList_query = $configList_query->fetch_assoc()); ?>
					</tbody>
				</table>
			</div>
		</div><!-- end row -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($configList_query);

?>