<?php 
include("_conf.php");
//
if($_REQUEST["token"]==$token_acesso_boleto_facil){
	$paymentToken=isset($_REQUEST["paymentToken"]) ? $_REQUEST["paymentToken"] : false;//F10335E9DBCEEF95E953D3C3F981E538
	$chargeReference=isset($_REQUEST["chargeReference"]) ? $_REQUEST["chargeReference"] : false;
	$chargeCode=isset($_REQUEST["chargeCode"]) ? $_REQUEST["chargeCode"] : false;
	//
	//$var=array();
	// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
	//$var['datatime_logbdfc']=date("Y-m-d H:i:s");
	//$var['texto_logbdfc']='notificar|paymentToken:'.$paymentToken.'|chargeReference:'.$chargeReference.'|chargeCode:'.$chargeCode;
	//
	//$save = new PDO_instruction();
	//$save->con_pdo();
	//$result_save = $save->sql_pdo('fc_logbd','id_logbdfc','',$var);
	//
	if($paymentToken && $chargeCode){
	    //
	    $select = new PDO_instruction();
	    $select->con_pdo();
	    $var=array();
	    $var['id_boletosfc']= $select->select_pdo('SELECT id_boletosfc FROM fc_boletos WHERE numero_boletosfc = ?', array($chargeCode))[0]['id_boletosfc'];
	    $var['token_pag_boletosfc']=$paymentToken;
	    //
	    $save = new PDO_instruction();
	    $save->con_pdo();
		//
		$result_save = $save->sql_pdo('fc_boletos','id_boletosfc',$var['id_boletosfc'],$var);
		if($result_save[0]){
			$contentsBol = file_get_contents('http://mkfacil.top/main/boleto_facil.php?cmd=verificar', null, stream_context_create(array('http'=>array('method'=>'POST','content'=>http_build_query(array('paymentToken' => $paymentToken,'token' => $token_acesso_boleto_facil,'id_boleto' => $var['id_boletosfc']))))));
			$dados['success']=true;$dados['msg']=$result_save[1];$dados['data']=json_decode($contentsBol, true);;
			echo json_encode($dados,JSON_UNESCAPED_UNICODE);
		}else{
			$dados['success']=false;$dados['error']=true;$dados['msg']=$result_save[1];$dados['errorMessage']='Update mal sucedido!';
			echo json_encode($dados,JSON_UNESCAPED_UNICODE);
		}
		//
	}else{
		$dados['success']=false;$dados['errorMessage']='Arguntos (paymentToken or chargeCode) inválidos';
		echo json_encode($dados,JSON_UNESCAPED_UNICODE);
	}

}else{
    $dados['success']=false;$dados['token']=$_REQUEST["token"];$dados['msg']='token invalido!';
	echo json_encode($dados,JSON_UNESCAPED_UNICODE);
}
?>