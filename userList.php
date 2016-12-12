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

$maxRows_userlist_query = 10;
$pageNum_userlist_query = 0;
if (isset($_GET['pageNum_userlist_query'])) {
  $pageNum_userlist_query = $_GET['pageNum_userlist_query'];
}
$startRow_userlist_query = $pageNum_userlist_query * $maxRows_userlist_query;

#mysql_select_db($database_softPark, $softPark);
$query_userlist_query = "SELECT * FROM users ORDER BY users.FirstName ASC";
$query_limit_userlist_query = sprintf("%s LIMIT %d, %d", $query_userlist_query, $startRow_userlist_query, $maxRows_userlist_query);
$userlist_query = $mysqli->query($query_limit_userlist_query) or die(mysqli_error());
$userlist_query2 = $mysqli->query($query_limit_userlist_query) or die(mysqli_error());
$row_userlist_query = $userlist_query->fetch_assoc();
$row_userlist_query2 = $userlist_query2->fetch_assoc();

if (isset($_GET['totalRows_userlist_query'])) {
  $totalRows_userlist_query = $_GET['totalRows_userlist_query'];
} else {
  $all_userlist_query = $mysqli->query($query_userlist_query);
  $totalRows_userlist_query = $all_userlist_query->num_rows;
}
$totalPages_userlist_query = ceil($totalRows_userlist_query/$maxRows_userlist_query)-1;
?>
        <?php include('header.php'); ?>
        <div class="row">
			<div id="user" class="col-xs-12 col-md-9"> 
				<?php include("includes/sesionUser.php"); ?>
			</div>
        </div><!-- end row -->
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
				<h2> Lista de usuarios</h2>
			</div>
		</div><!-- end row -->
		<div class="row">
			<div class="col-xs-12 col-md-9">
			<a class="btn btn-secondary" href="userAdd.php" role="button"><img src="images/user-new.png" width="64px" height="64px"></a>
			</div>
		</div><!-- end row -->
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<?php do { ?>
					<!-- Modal -->
					<div class="modal fade" id="myModal<?php echo $row_userlist_query2['Id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row_userlist_query2['Id'];?>" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel<?php echo $row_userlist_query2['Id'];?>">Eliminar Usuario</h4>
						  </div>
						  <div class="modal-body">
							Desea eliminar el usuario <h4 class="d-inline"><?php echo $row_userlist_query2['Login']; ?></h4>?
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a type="button" class="btn btn-danger" href="userdelete.php?recordID=<?php echo $row_userlist_query2['Id']; ?>" role="button">Eliminar</a>
						  </div>
						</div>
					  </div>
					</div>
				<?php } while ($row_userlist_query2 = $userlist_query2->fetch_assoc()); ?>
				
				<table class="table">
					<thead class="thead-default">
						<tr>
							<th>Usuario</th>
							<th>Nombre</th>
							<th>Apellido</th>
							<th>Cedula</th>
							<th>Nivel Usuario</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php do { ?>
						<tr>
							<td><?php echo $row_userlist_query['Login']; ?></td>
							<td><?php echo $row_userlist_query['FirstName']; ?></td>
							<td><?php echo $row_userlist_query['LastName']; ?></td>
							<td><?php echo $row_userlist_query['Passport']; ?></td>
							<?php $nameusertype= obtenerNameUserType($row_userlist_query['UserTypeId']); ?>
							<td><?php echo $nameusertype?></td>
							<td><a class="btn btn-warning" href="userEdit.php?recordID=<?php echo $row_userlist_query['Id']; ?>" role="button">Modificar</a>- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row_userlist_query['Id'];?>">Eliminar</button></td>
						</tr>
						  <?php } while ($row_userlist_query = $userlist_query->fetch_assoc()); ?>
					</tbody>
				</table>
			</div>
		</div><!-- end row -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($userlist_query);
?>
