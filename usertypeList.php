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

$maxRows_userType = 10;
$pageNum_userType = 0;
if (isset($_GET['pageNum_userType'])) {
  $pageNum_userType = $_GET['pageNum_userType'];
}
$startRow_userType = $pageNum_userType * $maxRows_userType;

# mysql_select_db($database_softPark, $softPark);
$query_userType = "SELECT * FROM usertype ORDER BY usertype.Name ASC";
$query_limit_userType = sprintf("%s LIMIT %d, %d", $query_userType, $startRow_userType, $maxRows_userType);
$userTypeResult = $mysqli->query($query_limit_userType) or die(mysqli_error());
$userTypeResult2 = $mysqli->query($query_limit_userType) or die(mysqli_error());
$row_userType = $userTypeResult->fetch_assoc();
$row_userType2 = $userTypeResult2->fetch_assoc();

if (isset($_GET['totalRows_userType'])) {
  $totalRows_userType = $_GET['totalRows_userType'];
} else {
  $all_userType = $mysqli->query($query_userType);
  $totalRows_userType = $all_userType->num_rows;
}
$totalPages_userType = ceil($totalRows_userType/$maxRows_userType)-1;
?>
        <?php include('header.php'); ?>
        <div id="user"> 
			<?php include("includes/sesionUser.php"); ?>
		</div>
        
		<div class="row">
			<div class="col-xs-12 col-md-9 title">
				<h2>Niveles de Usuarios</h2>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9">
			<a class="btn btn-secondary" href="usertypeAdd.php" role="button"><img src="images/user-new.png" width="64px" height="64px"></a>
			</div>
		</div><!-- end row -->
		
		<div class="row">
			<div class="col-xs-12 col-md-9">
				<?php do { ?>
					<!-- Modal -->
					<div class="modal fade" id="myModal<?php echo $row_userType2['Id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row_userType2['Id'];?>" aria-hidden="true" style="display: none;">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
							<h4 class="modal-title" id="myModalLabel<?php echo $row_userType2['Id'];?>">Eliminar Perfil de Usuario</h4>
						  </div>
						  <div class="modal-body">
							Desea eliminar el perfil de usuario <h4 class="d-inline"><?php echo $row_userType2['Name']; ?></h4>?
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a type="button" class="btn btn-danger" href="usertypeDelete.php?recordID=<?php echo $row_userType2['Id']; ?>" role="button">Eliminar</a>
						  </div>
						</div>
					  </div>
					</div>
				<?php } while ($row_userType2 = $userTypeResult2->fetch_assoc()); ?>
				
				<table class="table">
					<thead class="thead-default">
						<tr>
							<th>Nivel</th>
    						<th>Descripción</th>
    						<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php do { ?>
						<tr>
  						    <td><?php echo $row_userType['Name']; ?></td>
  						    <td><?php echo $row_userType['Description']; ?></td>
  						    <td><a class="btn btn-warning" href="usertypeEdit.php?recordID=<?php echo $row_userType['Id']; ?>" role="button">Modificar</a> - <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?php echo $row_userType['Id'];?>">Eliminar</button></td>
						</tr>
  						<?php } while ($row_userType = $userTypeResult->fetch_assoc()); ?>
					</tbody>
				</table>
			</div>
		</div><!-- end row -->
        
<?php include("footer.php"); ?>
<?php
mysqli_free_result($userTypeResult);
?>
