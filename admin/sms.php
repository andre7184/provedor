<?php 
//importa funçoes
include_once( "../../classes/funcoes_novas.php");
require_once( "../../classes/conf_sms.php");
//IMPORTA SITE SEGURO
$linha_CSMS=array('user_contasms'=>'1608','senha_contasms'=>'amb8484','gatewaysms_varArgsSend'=>'app,ta,to,msg,u,p','gatewaysms_valArgsSend'=>'webservices,pv,55$ddd$celular,$mensagem,$username,$password','gatewaysms_url'=>'http://torpedus.com.br/sms/index.php',);
$linha_CSMS = (object) $linha_CSMS;
//print_r($linha_CSMS);
$retornoSms=enviarSMS('torpedus','67','92020992','Ola mundo!',$linha_CSMS);
echo $retornoSms;
?>