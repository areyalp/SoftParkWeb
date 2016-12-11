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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO stations (TypeId, LevelId, Name, `Description`, LastTicket, Active, Configuration, MacAddress) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['TypeId'], "int"),
                       GetSQLValueString($_POST['LevelId'], "int"),
                       GetSQLValueString($_POST['Name'], "text"),
                       GetSQLValueString($_POST['Description'], "text"),
                       GetSQLValueString($_POST['LastTicket'], "int"),
                       GetSQLValueString(isset($_POST['Active']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['Configuration'], "text"),
                       GetSQLValueString($_POST['MacAddress'], "text"));

  #mysql_select_db($database_softPark, $softPark);
  $Result1 = mysql_query($insertSQL, $softPark) or die(mysql_error());

  $insertGoTo = "stationList.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

#mysql_select_db($database_softPark, $softPark);
$query_stationsAdd = "SELECT * FROM stations";
$stationsAdd = $mysqli->query($query_stationsAdd) or die(mysql_error());
$row_stationsAdd = $stationsAdd->fetch_assoc();
$totalRows_stationsAdd = $stationsAdd->num_rows;

#mysql_select_db($database_softPark, $softPark);
$query_stationsTypeQuery = "SELECT * FROM stationstype ORDER BY stationstype.Name";
$stationsTypeQuery = $mysqli->query($query_stationsTypeQuery) or die(mysql_error());
$row_stationsTypeQuery = $stationsTypeQuery->fetch_assoc();
$totalRows_stationsTypeQuery = $stationsTypeQuery->num_rows;

#mysql_select_db($database_softPark, $softPark);
$query_stationsLevelsQuery = "SELECT * FROM levels ORDER BY levels.Name ASC";
$stationsLevelsQuery = $mysqli->query($query_stationsLevelsQuery) or die(mysql_error());
$row_stationsLevelsQuery = $stationsLevelsQuery->fetch_assoc();
$totalRows_stationsLevelsQuery = $stationsLevelsQuery->num_rows;
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
            	<p> Bienvenido </p>
            </div>
    	</header><!-- end header -->
        
        <section>
  			<div id="content">
              <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap align="right">Tipo de Estacion:</td>
                    <td><select name="TypeId">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_stationsTypeQuery['Id']?>" <?php if (!(strcmp($row_stationsTypeQuery['Id'], $row_stationsTypeQuery['Id']))) {echo "SELECTED";} ?>><?php echo $row_stationsTypeQuery['Name']?></option>
                      <?php
} while ($row_stationsTypeQuery = mysql_fetch_assoc($stationsTypeQuery));
?>
                    </select></td>
                  <tr>
                  <tr valign="baseline">
                    <td nowrap align="right">LevelId:</td>
                    <td><select name="LevelId">
                      <?php 
do {  
?>
                      <option value="<?php echo $row_stationsLevelsQuery['Id']?>" <?php if (!(strcmp($row_stationsLevelsQuery['Id'], $row_stationsLevelsQuery['Id']))) {echo "SELECTED";} ?>><?php echo $row_stationsLevelsQuery['Name']?></option>
                      <?php
} while ($row_stationsLevelsQuery = mysql_fetch_assoc($stationsLevelsQuery));
?>
                    </select></td>
                  <tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Nombre:</td>
                    <td><input type="text" name="Name" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Descripción:</td>
                    <td><input type="text" name="Description" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Ultimo Ticket:</td>
                    <td><input type="text" name="LastTicket" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Active:</td>
                    <td><input type="checkbox" name="Active" value="" checked></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">Configuración:</td>
                    <td><input type="text" name="Configuration" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">MacAddress:</td>
                    <td><input type="text" name="MacAddress" value="" size="32"></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap align="right">&nbsp;</td>
                    <td><input name="button" type="image" id="button" src="images/check_blue.png" alt="Aceptar"></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="form1">
              </form>
              <p>&nbsp;</p>
            </div>
  			<!-- end content -->
        </section><!-- end section -->
        
  		<footer>
    		<p>Desarrollado para </p>
    	</footer><!-- end footer -->
        
  </div><!-- end .container -->
  
</body>
</html>
<?php
mysqli_free_result($stationsAdd);

mysqli_free_result($stationsTypeQuery);

mysqli_free_result($stationsLevelsQuery);
?>
