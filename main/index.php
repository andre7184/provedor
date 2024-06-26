<?php
include("_conf.php");
//
if(!isset($_SESSION['id_userfc'])){
	header('Location: pages/login.php');
}else{
	header('Location: pages/index.php');
}
?>