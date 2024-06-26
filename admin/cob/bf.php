<?php 
$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
//
$token_boletofacil='CCA0BCEA656E91A7C9D5A531CCF7635AFA5F26180F44C4AC';
switch($cmd) {
	case "gerar": //
		
		$url_boletofacil='https://sandbox.boletobancario.com/boletofacil/integration/api/v1/issue-charge';
		$descricao_cobranca=isset($_REQUEST["descricao_cob"]) ? $_REQUEST["descricao_cob"] : false;
		$codigo_boleto='';
		$valor_cobranca=isset($_REQUEST["valor_cob"]) ? $_REQUEST["valor_cob"] : false;
		$data_vencimento_cobranca='';
		$dias_boleto='';
		$valor_multa=''; 
		$valor_juros='';
		$valor_desconto='';
		$dias_desconto='';
		$nome_cliente='ANDRÉ MARTINS BRAND�O';
		$cpfcnpj_cliente='00508795109';
		$email_cliente='amb7184@gmail.com';
		//
		if(!$endereco_cliente OR !$numero_cliente OR !$cidade_cliente OR !$uf_cliente OR !$cep_cliente){
			$endereco_cliente='';
			$numero_cliente='';
			$cidade_cliente='';
			$uf_cliente='';
			$cep_cliente='';
			$complemento_cliente='';
		}
		//
		if($url_boletofacil && $token_boletofacil && $descricao_cobranca && $valor_cobranca && $valor_cobranca > 3 && $nome_cliente && $cpfcnpj_cliente){
			//
			$valuesCob = http_build_query(array(
					'token' => $token_boletofacil, //s -
					'description'   => utf8_encode($descricao_cobranca), //s - 115 -  DESCRICAO -
					'reference'   => $codigo_boleto, //n - 255 - CODIGO -
					'amount' => $valor_cobranca, //s - decimal - VALOR >=2,30 -
					'dueDate' => $data_vencimento_cobranca, //n - data dd/mm/aaaa - VENCIMENTO - padrao=+3dias
					//'installments' => '', //n - numero - PARCELAS - >1 & <12
					'maxOverdueDays'=>$dias_boleto, //n - numero - DIAS APOS O VENCIMENTO >=0 & <=90 - padrao=0
					'fine' => $valor_multa, //n - decimal - MULTA >=0 & <=2 - padrao=0.00
					'interest' => $valor_juros, //n - decimal - JUROS >=0 & <=1 - padrao=0.00
					'discountAmount' => $valor_desconto, //n - decimal - DESCONTO >=0 & <=VALOR - padrao=0.00
					'discountDays' => $dias_desconto, //n - numero - DIAS PAGAMENTO ANTECIPADO >=0 - padrao=0
					'payerName' => utf8_encode($nome_cliente), //s - 60 - NOME DO CLIENTE
					'payerCpfCnpj' => $cpfcnpj_cliente, //s - - CPF DO CLIENTE
					'payerEmail' => utf8_encode($email_cliente), //n - 80 - EMAIL DO CLIENTE
					//'payerSecondaryEmail'=> $id_carne_cobrancas, //n - 80 - EMAIL DO CLIENTE
					//'payerPhone' => $qtd_linha_carrinho, //n - 25 - TELEFONE DO CLIENTE
					//'payerBirthDate'=>0, //n - data dd/mm/aaaa - NASCIMENTO DO CLIENTE
					'billingAddressStreet'=> utf8_encode($endereco_cliente), //ns - 80 - ENDERE�O DO CLIENTE
					'billingAddressNumber' => $numero_cliente, //ns - 30 - NUMERO DA RUA DO CLIENTE
					'billingAddressComplement' => utf8_encode($complemento_cliente), //n - 30 - COMPLEMENTO DO CLIENTE
					'billingAddressCity' => utf8_encode($cidade_cliente), //ns - 60 - CIDADE DO CLIENTE
					'billingAddressState' => utf8_encode($uf_cliente), //ns - - UF DO CLIETNE
					'billingAddressPostcode' => $cep_cliente, //ns - - CEP DO CLIENTE
					//'notifyPayer' => 0, //n - boolean - ENVIAR NOTIFICA�AO PRA O CLIENTE - padrao=true
					//'notificationUrl' => '', //n - 255 - URL DE NOTIFICA��O DESTA COBRAN�A
					//'responseType'=>'', //n - - TIPO DE RESPOSTA JSON ou XML - padrao=JSON
			));
			//
			$contentsCob = file_get_contents($url_boletofacil, null, stream_context_create(array('http'=>array('method'=>'POST','content'=>$valuesCob,))));
			$contentsCobArray = json_decode($contentsCob, true);
			if($contentsCobArray['success']){
				//
				include_once("../_funcoes.php");
				require_once("../_conf.php");
				conecta_mysql();	//concecta no banco myslq
				//
				$dados=$contentsCobArray['data']['charges'];
				foreach($dados as $value){
					echo $value['code'];
				}
			}else{
				$error_msg=$contentsCobArray['errorMessage'];
			}
		}else{
			$error_msg="argumentos inv�lidos";
		}
	break;
	case "notificar":
		$paymentToken=isset($_REQUEST["paymentToken"]) ? $_REQUEST["paymentToken"] : false;//F10335E9DBCEEF95E953D3C3F981E538
		$chargeReference=isset($_REQUEST["chargeReference"]) ? $_REQUEST["chargeReference"] : false;
		$chargeCode=isset($_REQUEST["chargeCode"]) ? $_REQUEST["chargeCode"] : false;
		//
		if($paymentToken && $chargeCode){
			include_once("../_funcoes.php");
			require_once("../_conf.php");
			conecta_mysql();	//concecta no banco myslq
			//
			$resultado = mysql_query("UPDATE fc_boletos SET token_pag_boletosfc='$paymentToken' WHERE gateway_boletosfc='boletofacil' AND numero_boletosfc='".$chargeCode."'") or die ('{"success":false,"errorMessage":"Error ao salvar dados!"}');
			if(mysql_affected_rows() > 0){
				$contentsBol = file_get_contents('http://mkfacil.cf/admin/cob/bf.php?cmd=verificar', null, stream_context_create(array('http'=>array('method'=>'POST','content'=>http_build_query(array('paymentToken' => $paymentToken))))));
				echo '{"success":true,"data":"'.$contentsBol.'"}';
			}else{
				echo '{"success":false,"errorMessage":"Update mal sucedido!"}';
			}
			//
		}else{
			echo '{
    			"success":false,
   				 "errorMessage":"Arguntos (paymentToken or chargeCode) invalidos"
			}';
		}
	break;
	case "verificar":
		$paymentToken=isset($_REQUEST["paymentToken"]) ? $_REQUEST["paymentToken"] : false;
		if($paymentToken){
			$url_boletofacil='https://sandbox.boletobancario.com/boletofacil/integration/api/v1/fetch-payment-details';
			$valuesBol = http_build_query(array(
				'paymentToken' => $paymentToken, //s -
				//'responseType'=>'', //n - - TIPO DE RESPOSTA JSON ou XML - padrao=JSON
			));
			$contentsBol = file_get_contents($url_boletofacil, null, stream_context_create(array('http'=>array('method'=>'POST','content'=>$valuesBol,))));
			$contentsBolArray = json_decode($contentsBol, true);
			if($contentsBolArray['success']){
				include_once("../_funcoes.php");
				require_once("../_conf.php");
				conecta_mysql();	//concecta no banco myslq
				//
				$dadosPg=$contentsBolArray['data']['payment'];
				$id_pg=$dadosPg['id'];
				$valor_pg=$dadosPg['amount'];
				$data_pg=converterDataSimples($dadosPg['date']);
				$taxa_pg=$dadosPg['fee'];
				$dadosBol=$dadosPg['charge'];
				$cod_bol=$dadosBol['code'];
				//
				$resultado = mysql_query("UPDATE fc_boletos SET data_pag_boletosfc='$data_pg',valor_pag_boletosfc='$valor_pg',valor_taxa_boletosfc='".$taxa_pg."', tipo_pagamento_boletosfc='boleto', id_pagamento_boletosfc='".$id_pg."', situacao_boletosfc='pago' WHERE gateway_boletosfc='boletofacil' AND numero_boletosfc='".$cod_bol."'") or die ("error");
				//	
			}else{
				$error_msg=$contentsBolArray['errorMessage'];
			}
		}else{
			$error_msg="argumentos inv�lidos";
		}
	break;
	case "saldo":
	
	break;
	case "transferencia":
	
	break;
	case "cancelar":
	
	break;
	default:
		$error_msg="cmd(ação) inválido";
	break;
}
$error_msg = isset($error_msg) ? $error_msg : false;
if($error_msg)
	echo $error_msg;
?>