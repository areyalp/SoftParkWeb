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

$maxRows_UserTypeQuery = 10;
$pageNum_UserTypeQuery = 0;
if (isset($_GET['pageNum_UserTypeQuery'])) {
  $pageNum_UserTypeQuery = $_GET['pageNum_UserTypeQuery'];
}
$startRow_UserTypeQuery = $pageNum_UserTypeQuery * $maxRows_UserTypeQuery;

mysql_select_db($database_softPark, $softPark);
$query_UserTypeQuery = "SELECT * FROM usertype ORDER BY usertype.Name";
$query_limit_UserTypeQuery = sprintf("%s LIMIT %d, %d", $query_UserTypeQuery, $startRow_UserTypeQuery, $maxRows_UserTypeQuery);
$UserTypeQuery = mysql_query($query_limit_UserTypeQuery, $softPark) or die(mysql_error());
$row_UserTypeQuery = mysql_fetch_assoc($UserTypeQuery);

if (isset($_GET['totalRows_UserTypeQuery'])) {
  $totalRows_UserTypeQuery = $_GET['totalRows_UserTypeQuery'];
} else {
  $all_UserTypeQuery = mysql_query($query_UserTypeQuery);
  $totalRows_UserTypeQuery = mysql_num_rows($all_UserTypeQuery);
}
$totalPages_UserTypeQuery = ceil($totalRows_UserTypeQuery/$maxRows_UserTypeQuery)-1;
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Nivel usuario</title>
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
                	<h2> Nivel de usuarios</h2>
                </div>
                
                <div> 
                	<a href="usertypepermissionAdd.php"><img src="images/user-new.png" width="64px" height="64px"></a>
                </div>
                                
                <div class="userlist">
               	  <table width="100%">
					<tr>
    						<td>Tipos de Usuario</td>
    						<td>Acciones</td>
					  </tr>
					  <?php do { ?>
					  <tr>
  						    <td><?php echo $row_UserTypeQuery['Name']; ?></td>
  						    <td><a href="usertypepermissionEdit.php?recordID=<?php echo $row_UserTypeQuery['Id']; ?>">Modifica - <a href="usertypepermissionDelete.php?recordID=<?php echo $row_UserTypeQuery['Id']; ?>">Eliminar</td>
					      </tr>
  						  <?php } while ($row_UserTypeQuery = mysql_fetch_assoc($UserTypeQuery)); ?>
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
mysql_free_result($UserTypeQuery);
?>
