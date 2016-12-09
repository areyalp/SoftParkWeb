<?php require_once('Connections/softPark.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

mysql_select_db($database_softPark, $softPark);
$query_StationQuery = "SELECT * FROM stations";
$query_limit_StationQuery = sprintf("%s LIMIT %d, %d", $query_StationQuery, $startRow_StationQuery, $maxRows_StationQuery);
$StationQuery = mysql_query($query_limit_StationQuery, $softPark) or die(mysql_error());
$row_StationQuery = mysql_fetch_assoc($StationQuery);

if (isset($_GET['totalRows_StationQuery'])) {
  $totalRows_StationQuery = $_GET['totalRows_StationQuery'];
} else {
  $all_StationQuery = mysql_query($query_StationQuery);
  $totalRows_StationQuery = mysql_num_rows($all_StationQuery);
}
$totalPages_StationQuery = ceil($totalRows_StationQuery/$maxRows_StationQuery)-1;

mysql_select_db($database_softPark, $softPark);
$query_StationTypeQuery = "SELECT * FROM stationstype";
$StationTypeQuery = mysql_query($query_StationTypeQuery, $softPark) or die(mysql_error());
$row_StationTypeQuery = mysql_fetch_assoc($StationTypeQuery);
$totalRows_StationTypeQuery = mysql_num_rows($StationTypeQuery);
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
            	<p> Bienvenido </p>
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
  						  <?php } while ($row_StationQuery = mysql_fetch_assoc($StationQuery)); ?>
  					</table>

                        
              </div><!-- end .userlist -->
                
   		  </div><!-- end content -->
        </section><!-- end section -->
        
  		<footer>
    		<p>Desarrollado para </p>
    	</footer><!-- end footer -->
        
  </div><!-- end .container -->
  
</body>
</html>
<?php
mysql_free_result($StationQuery);

mysql_free_result($StationTypeQuery);
?>
