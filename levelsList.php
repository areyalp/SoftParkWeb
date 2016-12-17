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

$maxRows_levelsList_query = 10;
$pageNum_levelsList_query = 0;
if (isset($_GET['pageNum_userlist_query'])) {
  $pageNum_levelList_query = $_GET['pageNum_userlist_query'];
}
$startRow_levelsList_query = $pageNum_levelsList_query * $maxRows_levelsList_query;

$query_levelsList_query = "SELECT * FROM levels ORDER BY levels.Name ASC";
$query_limit_levelsList_query = sprintf("%s LIMIT %d, %d", $query_levelsList_query, $startRow_levelsList_query, $maxRows_levelsList_query);
$levelsList_query = $mysqli->query($query_limit_levelsList_query) or die(mysqli_error());
$levelsList_query2 = $mysqli->query($query_limit_levelsList_query) or die(mysqli_error());
$row_levelsList_query = $levelsList_query->fetch_assoc();
$row_levelsList_query2 = $levelsList_query2->fetch_assoc();

if (isset($_GET['totalRows_userlist_query'])) {
  $totalRows_levelsList_query = $_GET['totalRows_userlist_query'];
} else {
  $all_levelsList_query = $mysqli->query($query_levelsList_query);
  $totalRows_levelsList_query = $all_levelsList_query->num_rows;
}
$totalPages_levelsList_query = ceil($totalRows_levelsList_query/$maxRows_levelsList_query)-1;
?>
        <?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
				<h2>Levels</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9">
			<a class="btn btn-secondary" href="levelsAdd.php" role="button"><img src="images/garage_multilevel.png" width="64px" height="64px"></a>
			</div>
		</div><!-- end row -->
        
        <div class="row">
			<div class="col-xs-12 col-md-9">
				<?php do { ?>
					<!-- Modal -->
					<div class="modal fade" id="myModal<?php echo $row_levelsList_query2['Id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row_levelsList_query2['Id'];?>" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel<?php echo $row_levelsList_query2['Id'];?>">Eliminar Estacion</h4>
						  </div>
						  <div class="modal-body">
							Desea eliminar la estacion <h4 class="d-inline"><?php echo $row_levelsList_query2['Name']; ?></h4>?
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a type="button" class="btn btn-danger" href="levelsDelete.php?recordID=<?php echo $row_levelsList_query2['Id']; ?>" role="button">Eliminar</a>
						  </div>
						</div>
					  </div>
					</div>
				<?php } while ($row_levelsList_query2 = $levelsList_query2->fetch_assoc()); ?>
			<table class="table">
					<thead class="thead-default">
						<tr>
							<th>Nombre</th>
    						<th>Descripción</th>
    						<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php do { ?>
					    <tr>
  						    <td><?php echo $row_levelsList_query['Name']; ?></td>
  						    <td><?php echo $row_levelsList_query['Description']; ?></td>
  						    <td><a class="btn btn-warning" href="levelsAdd.php?recordID=<?php echo $row_levelsList_query['Id']; ?>" role="button">Modificar</a> - <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row_levelsList_query['Id'];?>">Eliminar</button></td>
						</tr>
						<?php } while ($row_levelsList_query = $levelsList_query->fetch_assoc()); ?>
					</tbody>
				</table>
			</div>
		</div><!-- end row -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($levelsList_query);

?>