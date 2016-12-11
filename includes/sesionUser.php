<?php 
if((isset($_SESSION['MM_Username'])) && ($_SESSION['MM_Username'] !="")){
	echo Obtenernameuser($_SESSION['MM_Idusuario']);
}
?>