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

$maxRows_userType = 10;
$pageNum_userType = 0;
if (isset($_GET['pageNum_userType'])) {
  $pageNum_userType = $_GET['pageNum_userType'];
}
$startRow_userType = $pageNum_userType * $maxRows_userType;

mysql_select_db($database_softPark, $softPark);
$query_userType = "SELECT * FROM usertype ORDER BY usertype.Name ASC";
$query_limit_userType = sprintf("%s LIMIT %d, %d", $query_userType, $startRow_userType, $maxRows_userType);
$userType = mysql_query($query_limit_userType, $softPark) or die(mysql_error());
$row_userType = mysql_fetch_assoc($userType);

if (isset($_GET['totalRows_userType'])) {
  $totalRows_userType = $_GET['totalRows_userType'];
} else {
  $all_userType = mysql_query($query_userType);
  $totalRows_userType = mysql_num_rows($all_userType);
}
$totalPages_userType = ceil($totalRows_userType/$maxRows_userType)-1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Lista Nivel Usuario</title>
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
                	<h2> Niveles de Usuarios</h2>
                </div>
                
                <div> <a href="userAdd.php"><img src="images/user-new.png" width="64px" height="64px"></a>
                </div>
                                
                <div class="userlist">
                	
				  <table width="100%">
					<tr>
    						<td>Nivel</td>
    						<td>Descripción</td>
    						<td>Acciones</td>
					  </tr>
					  <?php do { ?>
					  <tr>
  						    <td><?php echo $row_userType['Name']; ?></td>
  						    <td><?php echo $row_userType['Description']; ?></td>
  						    <td><a href="usertypeEdit.php?recordID=<?php echo $row_userType['Id']; ?>">Modificar - <a href="usertypeDelete.php?recordID=<?php echo $row_userType['Id']; ?>">Eliminar</td>
					      </tr>
  						  <?php } while ($row_userType = mysql_fetch_assoc($userType)); ?>
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
mysql_free_result($userType);
?>
