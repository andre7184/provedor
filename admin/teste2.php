<?php 
$arrayLogins=array();
$arrayLogins[]="carro";
$arrayLogins[]="moto";
$arrayLogins[]="aviao";
$select="UPDATE `mk_logacessos` SET `status_logacessos`='off',`datatime_fim_logacessos`=datatime_logacessos WHERE `status_logacessos`='on' AND `mk_logacessos`='$identy_mk' AND `login_logacessos` NOT IN (".sprintf("'%s'", implode("','",$arrayLogins)).")";
echo $select;
?>