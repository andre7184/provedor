<?php 
include("_conf.php");
//
if(isset($_SESSION['id_userfc']) OR $_REQUEST["token"]==$token_acesso_boleto_facil){
    //if(!$cmd)
	$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
	//
	//$var=array();
	// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
	//$var['datatime_logbdfc']=date("Y-m-d H:i:s");
	//$var['texto_logbdfc']=$cmd;
	//
	//$save = new PDO_instruction();
	//$save->con_pdo();
	//$result_save = $save->sql_pdo('fc_logbd','id_logbdfc','',$var);
	//
	switch($cmd) {
		case "gerar": //
			$id_cobranca=isset($_REQUEST["id_cobranca"]) ? $_REQUEST["id_cobranca"] : false;
			//
			if($id_cobranca){
				$data_vencimento=isset($_REQUEST["data_vencimento"]) ? $_REQUEST["data_vencimento"] : false;
				$valor=isset($_REQUEST["valor"])*1 ? $_REQUEST["valor"]*1 : false; 
				//
				$bol=array();
				$select = new PDO_instruction();
				$select->con_pdo();
				$result = $select->select_pdo('SELECT * FROM fcv_boletostemp WHERE id_boltempfc = ?', array($id_cobranca))[0];
				//
				$bol['valor_cobranca']=isset($result["valor_boltempfc"]) ? $result["valor_boltempfc"] : false;
				if($valor && $valor > $bol['valor_cobranca']){
					$qtd=$valor/$bol['valor_cobranca'];
					$bol['descricao_cobranca']='Boleto Avulso, '.$qtd.' mensalidade(s)';
					$bol['md5']='';
					$bol['data_vencimento_cobranca']=isset($result["vencimento_boltempfc"]) ? $result["vencimento_boltempfc"] : false;
					$bol['valor_cobranca']=$valor;
				}else{
					$bol['descricao_cobranca']=isset($result["descricao_boltempfc"]) ? $result["descricao_boltempfc"] : false;
					$bol['md5']=isset($result["id_boltempfc"]) ? $result["id_boltempfc"] : false;
					$bol['data_vencimento_cobranca']=isset($result["vencimento_boltempfc"]) ? $result["vencimento_boltempfc"] : false;
				}
				//echo converterDataSimples($data_vencimento).'!='.$bol['data_vencimento_cobranca'];
				if($data_vencimento && converterDataSimples($data_vencimento) > $bol['data_vencimento_cobranca'])
					$bol['data_vencimento_cobranca']=converterDataSimples($data_vencimento);
				//
				$bol['dias_boleto']='28';
				$bol['valor_multa']='5.00'; 
				$bol['valor_juros']='1.00';
				$bol['valor_desconto']='';
				$bol['dias_desconto']='';
				$bol['data_cobranca']=isset($result["data_cobranca_boltempfc"]) ? $result["data_cobranca_boltempfc"] : false;
				$bol['id_cliente_boltempfc']=isset($result["id_cliente_boltempfc"]) ? $result["id_cliente_boltempfc"] : false;
				$bol['nome_cliente']=isset($result["nome_boltempfc"]) ? $result["nome_boltempfc"] : false;
				$bol['cpfcnpj_cliente']=isset($result["doc_boltempfc"]) ? $result["doc_boltempfc"] : false;
				$bol['email_cliente']=isset($result["email_boltempfc"]) ? $result["email_boltempfc"] : false;
				$bol['telefones_cliente']=isset($result["telefones_boltempfc"]) ? $result["telefones_boltempfc"] : false;
				//
				$bol['endereco_cliente']=isset($result["end_boltempfc"]) ? $result["end_boltempfc"] : false;
				$bol['numero_cliente']=isset($result["end_num_boltempfc"]) ? $result["end_num_boltempfc"] : false;
				$bol['cidade_cliente']=isset($result["end_cidade_boltempfc"]) ? $result["end_cidade_boltempfc"] : false;
				$bol['uf_cliente']=isset($result["end_uf_boltempfc"]) ? $result["end_uf_boltempfc"] : false;
				$bol['cep_cliente']=isset($result["end_cep_boltempfc"]) ? $result["end_cep_boltempfc"] : false;
				$bol['complemento_cliente']=isset($result["end_comp_boltempfc"]) ? $result["end_comp_boltempfc"] : false;
			}
			// 
			if(!$bol['endereco_cliente'] OR !$bol['numero_cliente'] OR !$bol['cidade_cliente'] OR !$bol['uf_cliente'] OR !$bol['cep_cliente']){
				$bol['endereco_cliente']='';
				$bol['numero_cliente']='';
				$bol['cidade_cliente']='';
				$bol['uf_cliente']='';
				$bol['cep_cliente']='';
				$bol['complemento_cliente']='';
			}
			//
			if($url_boletofacil_gerar && $token_boletofacil && $bol['descricao_cobranca'] && $bol['valor_cobranca'] && $bol['valor_cobranca'] > 3 && $bol['nome_cliente'] && $bol['cpfcnpj_cliente']){
				//
				$valuesCob = http_build_query(array(
						'token' => $token_boletofacil, //s -
						'description'   => $bol['descricao_cobranca'], //s - 115 -  DESCRICAO -
						'reference'   => $bol['codigo_boleto'], //n - 255 - CODIGO -
						'amount' => $bol['valor_cobranca'], //s - decimal - VALOR >=2,30 -
						'dueDate' => mostrarDataSimples($bol['data_vencimento_cobranca']), //n - data dd/mm/aaaa - VENCIMENTO - padrao=+3dias
						//'installments' => '', //n - numero - PARCELAS - >1 & <12
						'maxOverdueDays'=>$bol['dias_boleto'], //n - numero - DIAS APOS O VENCIMENTO >=0 & <=29 - padrao=0
						'fine' => $bol['valor_multa'], //n - decimal - MULTA >=0 & <=2 - padrao=0.00
						'interest' => $bol['valor_juros'], //n - decimal - JUROS >=0 & <=1 - padrao=0.00
						'discountAmount' => $bol['valor_desconto'], //n - decimal - DESCONTO >=0 & <=VALOR - padrao=0.00
						'discountDays' => $bol['dias_desconto'], //n - numero - DIAS PAGAMENTO ANTECIPADO >=0 - padrao=0
						'payerName' => $bol['nome_cliente'], //s - 60 - NOME DO CLIENTE
						'payerCpfCnpj' => $bol['cpfcnpj_cliente'], //s - - CPF DO CLIENTE
						'payerEmail' => $bol['email_cliente'], //n - 80 - EMAIL DO CLIENTE
						//'payerSecondaryEmail'=> $id_carne_cobrancas, //n - 80 - EMAIL DO CLIENTE
						//'payerPhone' => $qtd_linha_carrinho, //n - 25 - TELEFONE DO CLIENTE
						//'payerBirthDate'=>0, //n - data dd/mm/aaaa - NASCIMENTO DO CLIENTE
						'billingAddressStreet'=> $bol['endereco_cliente'], //ns - 80 - ENDERE�O DO CLIENTE
						'billingAddressNumber' => $bol['numero_cliente'], //ns - 30 - NUMERO DA RUA DO CLIENTE
						'billingAddressComplement' => $bol['complemento_cliente'], //n - 30 - COMPLEMENTO DO CLIENTE
						'billingAddressCity' => $bol['cidade_cliente'], //ns - 60 - CIDADE DO CLIENTE
						'billingAddressState' => $bol['uf_cliente'], //ns - - UF DO CLIETNE
						'billingAddressPostcode' => $bol['cep_cliente'], //ns - - CEP DO CLIENTE
						//'notifyPayer' => 0, //n - boolean - ENVIAR NOTIFICAÇÃO PRA O CLIENTE - padrao=true
						//'notificationUrl' => '', //n - 255 - URL DE NOTIFICAÇÃO DESTA COBRANÇA
						//'responseType'=>'', //n - - TIPO DE RESPOSTA JSON ou XML - padrao=JSON
				));
				//
				$contentsCob = file_get_contents($url_boletofacil_gerar, null, stream_context_create(array('http'=>array('method'=>'POST','content'=>$valuesCob,))));
				//echo $contentsCob;
				$contentsCobArray = json_decode($contentsCob, true);
				if($contentsCobArray['success']){
					//
					$dados=$contentsCobArray['data']['charges'];
					foreach($dados as $value){
						$var=array();
						$dados=array();
						// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
						$var['md5_boletosfc']=$bol['md5'];
						$var['numero_boletosfc']=$value['code'];
						$var['data_cobranca_boletosfc']=mostrarDataSimples($bol['data_cobranca']);
						$var['data_vencimento_boletosfc']=$value['dueDate'];
						$var['url_boletosfc']=$value['link'];
						$var['linha_dig_boletosfc']=$value['payNumber'];
						$var['valor_boletosfc']=$bol['valor_cobranca'];
						$var['id_clientes_boletosfc']=$bol['id_cliente_boltempfc'];
						$var['gateway_boletosfc']='boletofacil';
						//
						$save = new PDO_instruction();
						$save->con_pdo();
						$result_save = $save->sql_pdo('fc_boletos','id_boletosfc','',$var);
						if($result_save[0]){
							$dados['error']=false;$dados['msg']=$result_save[1];$dados['id']=$result_save[2];$dados['valor']=$var['valor_boletosfc'];$dados['vencimento']=$var['data_vencimento_boletosfc'];$dados['url']=$var['url_boletosfc'];$dados['linha_digitavel']=$var['linha_dig_boletosfc'];$dados['nome']=$bol['nome_cliente'];$dados['email']=$bol['email_cliente'];$dados['telefones']=$bol['telefones_cliente'];
						}else{
							$dados['error']=true;$dados['msg']=$result_save[1];$dados['id']='';$dados['send']='';$dados['new']=false;
						}
						echo json_encode($dados,JSON_UNESCAPED_UNICODE);
					}
				}else{
					$error_msg=$contentsCobArray['errorMessage'];
				}
			}else{
				$error_msg="argumentos inválidos";
			}
		break;
		case "notificar":
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
		break;
		case "verificar":
			$paymentToken=isset($_REQUEST["paymentToken"]) ? $_REQUEST["paymentToken"] : false;
			$id_boleto=isset($_REQUEST["id_boleto"]) ? $_REQUEST["id_boleto"] : false;
			//
			if($url_boletofacil_verificar && $paymentToken && $id_boleto){
				$valuesBol = http_build_query(array(
					'paymentToken' => $paymentToken
				));
				$contentsBol = file_get_contents($url_boletofacil_verificar, null, stream_context_create(array('http'=>array('method'=>'POST','content'=>$valuesBol,))));
				//echo $contentsBol;
				$contentsBolArray = json_decode($contentsBol, true);
				if($contentsBolArray['success']){
					$var=array();
					$dados=array();
					//
					$dadosPg=$contentsBolArray['data']['payment'];
					//
					$var['data_pag_boletosfc']=$dadosPg['date'];
					$var['data_credito_boletosfc']=$dadosPg['date'];
					$var['valor_pag_boletosfc']=$dadosPg['amount'];
					$var['valor_taxa_boletosfc']=$dadosPg['fee'];
					$var['tipo_pagamento_boletosfc']="boleto";
					$var['id_pagamento_boletosfc']=$dadosPg['id'];
					$var['pago_boletosfc']="on"; 
					$var['id_boletosfc']=$id_boleto;
					//
					$save = new PDO_instruction();
					$save->con_pdo();
					//
					$result_save = $save->sql_pdo('fc_boletos','id_boletosfc',$var['id_boletosfc'],$var);
					if($result_save[0]){
						$dados['success']=true;$dados['msg']='Boleto atualizado';
						echo json_encode($dados,JSON_UNESCAPED_UNICODE);
					}else{
						$dados['success']=false;$dados['errorSql']=$result_save[1];$dados['errorMessage']='Update mal sucedido!';
						echo json_encode($dados,JSON_UNESCAPED_UNICODE);
					}
				}else{
					$error_msg=$contentsBolArray['errorMessage'];
				}
				//*/
			}else{
				$error_msg="argumentos inválidos";
			}
		break;
		case "consultar":
			$dataPgIn=isset($_REQUEST["data_pg_in"]) ? $_REQUEST["data_pg_in"] : false;
			$dataPgOut=isset($_REQUEST["data_pg_out"]) ? $_REQUEST["data_pg_out"] : false;
			$dataVcIn=isset($_REQUEST["data_vc_in"]) ? $_REQUEST["data_vc_in"] : false;
			$dataVcOut=isset($_REQUEST["data_vc_out"]) ? $_REQUEST["data_vc_out"] : false;
			//
			if($url_boletofacil_consultar && ( $dataPgIn OR $dataVcIn )){
				if($dataPgIn && $dataPgOut)
					$valuesBol = http_build_query(array(
						'token' => $token_boletofacil,
						'beginPaymentDate' => $dataPgIn,
						'endPaymentDate' => $dataPgOut,
					));
				else if($dataVcIn && $dataVcOut)
					$valuesBol = http_build_query(array(
						'token' => $token_boletofacil,
						'beginDueDate' => $dataVcIn,
						'endDueDate' => $dataVcOut,
					));
				else if($dataPgIn)
					$valuesBol = http_build_query(array(
							'token' => $token_boletofacil,
							'beginPaymentDate' => $dataPgIn
					));
				else 
					$valuesBol = http_build_query(array(
							'token' => $token_boletofacil,
							'beginDueDate' => $dataVcIn,
					));
				//
				$contentsBol = file_get_contents($url_boletofacil_consultar, null, stream_context_create(array('http'=>array('method'=>'POST','content'=>$valuesBol,))));
				echo $contentsBol;
				$contentsBolArray = json_decode($contentsBol, true);
				if($contentsBolArray['success']){
					$var=array();
					$dados=array();
					$dadosx=array();
					$success=false;
					//
					$charges=$contentsBolArray['data']['charges'];
					foreach($charges as $value){
						$payment=$value['payments'][0];
						//
						$var['data_pag_boletosfc']=$payment['date'];
						$var['data_credito_boletosfc']=$payment['date'];
						$var['valor_pag_boletosfc']=$payment['amount'];
						$var['valor_taxa_boletosfc']=$payment['fee'];
						$var['tipo_pagamento_boletosfc']=$payment['type'];
						$var['id_pagamento_boletosfc']=$payment['id'];
						$var['pago_boletosfc']='on';
						//
						$select = new PDO_instruction();
						$select->con_pdo();
						$var['id_boletosfc']=$select->select_pdo('SELECT id_boletosfc FROM fc_boletos WHERE numero_boletosfc = ?', array($value['code']))[0]['id_boletosfc'];
						$select->end_con_pdo();
						//
						if($var['id_boletosfc']>0){
							$save = new PDO_instruction();
							$save->con_pdo();
							//
							$result_save = $save->sql_pdo('fc_boletos','id_boletosfc',$var['id_boletosfc'],$var);
							$save->end_con_pdo();
							if($result_save[0]){
								$dados['success']=true;$dados['msg']='Boleto atualizado';
								$success=true;
							}else{
								$dados['success']=false;$dados['errorSql']=$result_save[1];$dados['errorMessage']='Update mal sucedido!';
							}
						}else{
							$dados['success']=false;$dados['msg']='Não existe boleto para atualizar';
						}
						$dadosx[]=$dados;
					}
					if(count($dadosx)>0)
						$dadosx['success']=$success;
						echo json_encode($dadosx,JSON_UNESCAPED_UNICODE);
				}else{
					$error_msg=$contentsBolArray['errorMessage'];
				}
			}else{
				$error_msg="argumentos inválidos";
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
	if($error_msg){
		$dados['success']=false;$dados['errorMessage']=$error_msg;
		echo json_encode($dados,JSON_UNESCAPED_UNICODE);
	}
}else{
	$dados['success']=false;$dados['auth']=false;$dados['msg']='Não Autenticado';
	echo json_encode($dados,JSON_UNESCAPED_UNICODE);
}
?>