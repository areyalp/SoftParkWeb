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
function Obtenernameuser($identificador)
{
	global $database_softPark, $softPark;
	mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT users.FirstName FROM users WHERE Id= %s",$identificador);
	$consultafuncion = mysql_query($query_consultafuncion, $softPark) or die(mysql_error());
	$row_consultafuncion = mysql_fetch_assoc($consultafuncion);
	$totalRows_consultafuncion = mysql_num_rows($consultafuncion);
	return $row_consultafuncion['FirstName']; 
	mysql_free_result($consultafuncion);
}

//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener nombre de tipo usuario***********************************************************************************//
//***************************************************************************************************************************************//

function obtenerNameUserType($identificador)
{
	global $database_softPark, $softPark;
	mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT usertype.Name FROM usertype WHERE id= %s",$identificador);
	$consultafuncion = mysql_query($query_consultafuncion, $softPark) or die(mysql_error());
	$row_consultafuncion = mysql_fetch_assoc($consultafuncion);
	$totalRows_consultafuncion = mysql_num_rows($consultafuncion);
	return $row_consultafuncion['Name']; 
	mysql_free_result($consultafuncion);
}

//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener nombre de tipo usuario***********************************************************************************//
//***************************************************************************************************************************************//

function obteneruserpermission($identificador)
{
	global $database_softPark, $softPark;
	mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT * FROM usertypepermissions WHERE UserTypeId= %s",$identificador);
	$consultafuncion = mysql_query($query_consultafuncion, $softPark) or die(mysql_error());
	$row_consultafuncion = mysql_fetch_assoc($consultafuncion);
	$totalRows_consultafuncion = mysql_num_rows($consultafuncion);
	return $row_consultafuncion['Name']; 
	mysql_free_result($consultafuncion);
}

//***************************************************************************************************************************************//
//***************************************************************************************************************************************//
//*********Funcion para obtener Tipo de Estacion ****************************************************************************************//
//***************************************************************************************************************************************//

function obtenerStationType($identificador)
{
	global $database_softPark, $softPark;
	mysql_select_db($database_softPark, $softPark);
	$query_consultafuncion = sprintf("SELECT stationstype.Name FROM stationstype WHERE id= %s",$identificador);
	$consultafuncion = mysql_query($query_consultafuncion, $softPark) or die(mysql_error());
	$row_consultafuncion = mysql_fetch_assoc($consultafuncion);
	$totalRows_consultafuncion = mysql_num_rows($consultafuncion);
	return $row_consultafuncion['Name']; 
	mysql_free_result($consultafuncion);
}