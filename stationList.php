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

mysql_select_db($database_softPark, $softPark);
$query_stationsList = "SELECT * FROM stations ORDER BY stations.Name ASC";
$stationsList = mysql_query($query_stationsList, $softPark) or die(mysql_error());
$row_stationsList = mysql_fetch_assoc($stationsList);
$totalRows_stationsList = mysql_num_rows($stationsList);

mysql_select_db($database_softPark, $softPark);
$query_stationsType = "SELECT * FROM stationstype ORDER BY stationstype.Name ASC";
$stationsType = mysql_query($query_stationsType, $softPark) or die(mysql_error());
$row_stationsType = mysql_fetch_assoc($stationsType);
$totalRows_stationsType = mysql_num_rows($stationsType);

mysql_select_db($database_softPark, $softPark);
$query_stationslevel = "SELECT * FROM levels ORDER BY levels.Name ASC";
$stationslevel = mysql_query($query_stationslevel, $softPark) or die(mysql_error());
$row_stationslevel = mysql_fetch_assoc($stationslevel);
$totalRows_stationslevel = mysql_num_rows($stationslevel);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Lista de estaciones</title>
<link rel="stylesheet" type="text/css" href="styles/base.css"/>
</head>

<body>
	<div id="container">
  		
        <header>
        	<h1>SoftPark</h1>
            <div id="user">
            	<?php 
				if((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] !=""))
                {
                	echo Obtenernameuser($_SESSION['MM_Idusuario']);
                }?>
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
                	
				  <table width="100%" border="0">
					  <tr>
					    <td>Nombre</td>
					    <td>Descripción</td>
					    <td>Tipo</td>
					    <td>Acciones</td>
				    </tr>
					  <tr>
					    <td><?php echo $row_stationsList['Name']; ?></td>
					    <td><?php echo $row_stationsList['Description']; ?></td>
					    <td><?php echo obtenerStationType($row_stationsList['Id'])?></td>
					    <td><a href="StationsEdit.php?recordID=<?php echo $row_stationsList['Id']; ?>"><img src="images/SearchUser.png" width="64" height="64"></a>  <a href="StationsDelete.php?recordID=<?php echo $row_stationsList['Id']; ?>"><img src="images/delete-user.png" width="64" height="64"></a></td>
				    </tr>
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
mysql_free_result($stationsList);

mysql_free_result($stationsType);

mysql_free_result($stationslevel);
?>
