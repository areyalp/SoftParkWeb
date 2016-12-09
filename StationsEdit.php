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

$idstation_StationEditQuery = "0";
if (isset($_[GET])) {
  $idstation_StationEditQuery = $_[GET];
}
mysql_select_db($database_softPark, $softPark);
$query_StationEditQuery = sprintf("SELECT * FROM stations WHERE stations.Id=%s", GetSQLValueString($idstation_StationEditQuery, "int"));
$StationEditQuery = mysql_query($query_StationEditQuery, $softPark) or die(mysql_error());
$row_StationEditQuery = mysql_fetch_assoc($StationEditQuery);
$totalRows_StationEditQuery = mysql_num_rows($StationEditQuery);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SoftPark - Editar Estaciones</title>
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
                	<h2> Edicion de Estaciones</h2>
                </div>
                
                <div> 
                </div>
                                
                <div class="userlist">
                	

                        
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
mysql_free_result($StationEditQuery);
?>
