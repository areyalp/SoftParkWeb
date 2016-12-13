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

//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener nombre de Usuario****************************************************************************************//
//***************************************************************************************************************************************//
function Obtenernameuser($identificador){

	global $database_softPark, $softPark, $mysqli;
	#mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT users.FirstName FROM users WHERE Id= %s",$identificador);
	$consultafuncion = $mysqli->query($query_consultafuncion) or die(mysqli_error());
	$row_consultafuncion = $consultafuncion->fetch_assoc();
	#$totalRows_consultafuncion = $row_consultafuncion->num_rows;
	return $row_consultafuncion['FirstName']; 
	mysqli_free_result($consultafuncion);
}
//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener nombre de tipo usuario***********************************************************************************//
//***************************************************************************************************************************************//

function obtenerNameUserType($identificador)
{
	global $database_softPark, $softPark, $mysqli;
	#mysql_select_db($database_softPark, $softPark)
	$query_consultafuncion = sprintf("SELECT usertype.Name FROM usertype WHERE id= %s",$identificador);
	$consultafuncion = $mysqli->query($query_consultafuncion) or die(mysqli_error());
	$row_consultafuncion = $consultafuncion->fetch_assoc();
	#$totalRows_consultafuncion = $row_consultafuncion->num_rows;
	return $row_consultafuncion['Name']; 
	mysqli_free_result($consultafuncion);
}

//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener nombre de tipo usuario***********************************************************************************//
//***************************************************************************************************************************************//

function obteneruserpermission($identificador)
{
	global $database_softPark, $softPark, $mysqli;
	#mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT * FROM usertypepermissions WHERE UserTypeId= %s",$identificador);
	$consultafuncion = $mysqli->query($query_consultafuncion) or die(mysqli_error());
	$row_consultafuncion = $consultafuncion->fetch_assoc();
	#$totalRows_consultafuncion = $row_consultafuncion->num_rows;
	return $row_consultafuncion['Name']; 
	mysqli_free_result($consultafuncion);
}

//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener nombre de tipo usuario***********************************************************************************//
//***************************************************************************************************************************************//

function obtenerUserPermissionId($identificador)
{
	global $database_softPark, $softPark, $mysqli;
	#mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT * FROM usertypepermissions WHERE UserTypeId= %s",$identificador);
	$consultafuncion = $mysqli->query($query_consultafuncion) or die(mysqli_error());
	$row_consultafuncion = $consultafuncion->fetch_assoc();
	$totalRows_consultafuncion = $row_consultafuncion->num_rows;
	return $row_consultafuncion['UserTypeId']; 
	mysqli_free_result($consultafuncion);
}

//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener Tipo de Estacion ****************************************************************************************//
//***************************************************************************************************************************************//

function obtenerStationType($identificador)
{
	global $database_softPark, $softPark, $mysqli;
	#mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT stationstype.Name FROM stationstype WHERE id= %s",$identificador);
	$consultafuncion = $mysqli->query($query_consultafuncion) or die(mysqli_error());
	$row_consultafuncion = $consultafuncion->fetch_assoc();
	#$totalRows_consultafuncion = $row_consultafuncion->num_rows;
	return $row_consultafuncion['Name']; 
	mysqli_free_result($consultafuncion);
}