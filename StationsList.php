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
$query_StationQuery = "SELECT * FROM stations";
$query_limit_StationQuery = sprintf("%s LIMIT %d, %d", $query_StationQuery, $startRow_StationQuery, $maxRows_StationQuery);
$StationQuery = $mysqli->query($query_limit_StationQuery) or die(mysqli_error());
$row_StationQuery = $StationQuery->fetch_assoc();

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
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Estaciones</title>
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
                	<h2> Lista de Estaciones</h2>
                </div>
                
                <div> <a href="userAdd.php"><img src="images/user-new.png" width="64px" height="64px"></a>
                </div>
                                
                <div class="userlist">
               	  <table width="880" border="1">
  						<tr>
    						<td>Nombre</td>
    						<td>Descripcion</td>
    						<td>MacAddress</td>
                            <td>Acciones</td>
  						</tr>
  						<?php do { ?>
					    <tr>
  						    <td><?php echo $row_StationQuery['Name']; ?></td>
  						    <td><?php echo $row_StationQuery['Description']; ?></td>
  						    <td><?php echo $row_StationQuery['MacAddress']; ?></td>
  						    <td>Modificar - Eliminar</td>
						    </tr>
  						  <?php } while ($row_StationQuery = $StationQuery->fetch_assoc()); ?>
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
mysqli_free_result($StationQuery);

mysqli_free_result($StationTypeQuery);
?>
