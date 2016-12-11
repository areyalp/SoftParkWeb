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

$maxRows_UserTypeQuery = 10;
$pageNum_UserTypeQuery = 0;
if (isset($_GET['pageNum_UserTypeQuery'])) {
  $pageNum_UserTypeQuery = $_GET['pageNum_UserTypeQuery'];
}
$startRow_UserTypeQuery = $pageNum_UserTypeQuery * $maxRows_UserTypeQuery;

#mysql_select_db($database_softPark, $softPark);
$query_UserTypeQuery = "SELECT * FROM usertype ORDER BY usertype.Name";
$query_limit_UserTypeQuery = sprintf("%s LIMIT %d, %d", $query_UserTypeQuery, $startRow_UserTypeQuery, $maxRows_UserTypeQuery);
$UserTypeQuery = $mysqli->query($query_limit_UserTypeQuery) or die(mysql_error());
$row_UserTypeQuery =$UserTypeQuery->fetch_assoc();

if (isset($_GET['totalRows_UserTypeQuery'])) {
  $totalRows_UserTypeQuery = $_GET['totalRows_UserTypeQuery'];
} else {
  $all_UserTypeQuery = $mysqli->query($query_UserTypeQuery);
  $totalRows_UserTypeQuery = $all_UserTypeQuery->num_rows;
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
            	<?php include("includes/sesionUser.php"); ?>
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
  						  <?php } while ($row_UserTypeQuery = $UserTypeQuery->fetch_assoc()); ?>
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
mysqli_free_result($UserTypeQuery);
?>
