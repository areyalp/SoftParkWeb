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
$userlist_query = $mysqli->query($query_limit_userlist_query) or die(mysql_error());
$row_userlist_query = $userlist_query->fetch_assoc();

if (isset($_GET['totalRows_userlist_query'])) {
  $totalRows_userlist_query = $_GET['totalRows_userlist_query'];
} else {
  $all_userlist_query = $mysqli->query($query_userlist_query);
  $totalRows_userlist_query = $all_userlist_query->num_rows;
}
$totalPages_userlist_query = ceil($totalRows_userlist_query/$maxRows_userlist_query)-1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Principal</title>
<link rel="stylesheet" type="text/css" href="styles/base.css"/>
</head>

<body>
	<div id="container">
  		
        <header>
        
        	<h1>SoftPark</h1>
            <div id="user">
            	<?php include("includes/sesionUser.php"); ?>
            </div>
    	</header><!-- end header -->
        
      <section>
        
  			<div id="content">
            
            	<div class="title">
                	<h2> Lista de usuarios</h2>
                </div>
                
                <div>
                <img src="images/user-new.png" width="64px" height="64px">
                </div>
                                
                <div class="userlist">
                	<table width="100%">
  						<tr>
    						<td width="131">Nombre</td>
    						<td width="137">Apellido</td>
    						<td width="117">Cedula</td>
                            <td width="223">Nivel Usuario</td>
                            <td width="322">Acciones</td>
  						</tr>
  						<?php do { ?>
					    <tr>
  						    <td><?php echo $row_userlist_query['FirstName']; ?></td>
  						    <td><?php echo $row_userlist_query['LastName']; ?></td>
  						    <td><?php echo $row_userlist_query['Passport']; ?></td>
                            <?php $nameusertype= obtenerNameUserType($row_userlist_query['UserTypeId']); ?>
  						    <td><?php echo $nameusertype?></td>
  						    <td><a href="userEdit.php?recordID=<?php echo $row_userlist_query['Id']; ?>">Modificar</a>- <a href="userdelete.php?recordID=<?php echo $row_userlist_query['Id']; ?>">Eliminar</a></td>
					      </tr>
  						  <?php } while ($row_userlist_query = $userlist_query->fetch_assoc()); ?>
					</table>

                        
              </div><!-- end .userlist -->
                
    		</div><!-- end content -->
        </section><!-- end section -->
        
  		<footer>
    		<?php include("includes/footer.php"); ?>
    	</footer><!-- end footer -->
        
  </div><!-- end .container -->
  
</body>
</html>
<?php
mysqli_free_result($userlist_query);
?>
