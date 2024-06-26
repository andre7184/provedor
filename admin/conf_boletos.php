<?php 
	function gerarBoletos($var,$linha_dados,$linha_enderecos,$banco,$linha_contaboleto,$rem){
		//
		global $codigo_provedor,$LOCAL_HOME;
		// PEGA DADOS CONFIGURAÇÕES DO PROVEDOR
		$desativar_encargos_clientes=$linha_dados->desativar_encargos_clientes;
		//
		if($banco=='local'){
			//
			$url=$linha_dados->url_cobrancas;
			$vencimento=$linha_dados->data_vencimento_cobrancas;
			//echo $content3."\n\n";
			//
			if($linha_enderecos->complementos_enderecos!=''){
				$complementos='('.$linha_enderecos->complementos_enderecos.')';
			}else{
				$complementos='';
			}
			$endereco1_conta=$linha_enderecos->tipo_logradouro_enderecos." ".$linha_enderecos->logradouro_enderecos." ".$linha_enderecos->numero_enderecos." ".$complementos;
			$endereco2_conta=$linha_enderecos->bairro_enderecos." - ".$linha_enderecos->cep_enderecos." ".$linha_enderecos->cidade_enderecos."-".$linha_enderecos->uf_enderecos;
			//
			$sacado=$linha_dados->nome_pessoais." cpf:".$linha_dados->cpf_cnpj_pessoais."\n".$linha_enderecos->tipo_logradouro_enderecos." ".$linha_enderecos->logradouro_enderecos." ".$linha_enderecos->numero_enderecos." ".$linha_enderecos->bairro_enderecos." ".$linha_enderecos->complementos_enderecos."\n".$linha_enderecos->cep_enderecos." - ".$linha_enderecos->cidade_enderecos." - ".$linha_enderecos->uf_enderecos;
			//
			$instrucoesCb='';
			$dados_boleto[tipo_boleto]='local';
			$dados_boleto[codigo_conta]=$linha_dados->codigo_pessoais_cobrancas;
			$dados_boleto[id_cobranca]=$linha_dados->id_cobrancas;
			$dados_boleto[nome_banco]='local';
			$dados_boleto[endereco1_conta]=$endereco1_conta;
			$dados_boleto[endereco2_conta]=$endereco2_conta;
			$dados_boleto[local_pg_facil]=$linha_contaboleto->local_pg_facil_contaboleto.' - '.$linha_contaboleto->endereco_pg_facil_contaboleto;
			$dados_boleto[codigo_banco]=$linha_contaboleto->codigo_banco_boletos;
			$dados_boleto[codigo_boleto]=$linha_dados->linha_dig_boletos;
			$dados_boleto[tipo_codigo_boleto]='';
			$dados_boleto[local_pag]=$linha_dados->local_pag_boletos;
			$dados_boleto[local_pag_av]=$linha_dados->local_pag_boletos;
			$dados_boleto[vencimento]=mostrarDataSimples($vencimento);
			$dados_boleto[nome_cedente]=$linha_contaboleto->cedente_contaboleto;
			$dados_boleto[conta_cedente]=$linha_dados->num_conta_boletos;
			$dados_boleto[data_documento]=$linha_dados->data_documento_boletos;
			$dados_boleto[numero_documento]=$linha_dados->numero_boletos;
			$dados_boleto[especie_documento]=$linha_dados->especie_documento_boletos;
			$dados_boleto[aceite_documento]=$linha_dados->aceite_documento_boletos;
			$dados_boleto[processamento_documento]=$linha_dados->data_processamento_boletos;
			$dados_boleto[nosso_numero_documento]=$linha_dados->nosso_num_boletos;
			$dados_boleto[uso_banco]=$linha_dados->uso_banco_boletos;
			$dados_boleto[carteira]=$linha_contaboleto->carteira_contaboleto;
			$dados_boleto[moeda]=$linha_dados->moeda_boletos;
			$dados_boleto[qtd]=$linha_dados->qtd_boletos;
			$dados_boleto[x_valor]=$linha_dados->x_valor_boletos;
			$dados_boleto[valor]=number_format($linha_dados->valor_boletos, 2, ',', '.');
			$dados_boleto[instrucoes]=$linha_dados->instrucoes_boletos;
			$dados_boleto[nome_sacado]=$linha_dados->nome_pessoais;
			$dados_boleto[cpf_sacado]=$linha_dados->cpf_cnpj_pessoais;
			$dados_boleto[sacado]=$sacado;
			$dados_boleto[avalista]=$linha_contaboleto->avalista_contaboleto;
			$dados_boleto[codigo_barra]='';
			$dados_boleto[num_codigo_barra]=$linha_dados->codigo_barras_boletos;
			$dados_boleto['ERROR']='';
			//
			return $dados_boleto;
			//
		}else if($banco=='f2b'){
			//
			$dados_boleto[tipo_boleto]='remoto';
			$dados_boleto[codigo_conta]=$linha_dados->codigo_pessoais_cobrancas;
			$dados_boleto[id_cobranca]=$linha_dados->id_cobrancas;
			$dados_boleto[endereco1_conta]=$linha_enderecos->tipo_logradouro_enderecos." ".$linha_enderecos->logradouro_enderecos." ".$linha_enderecos->numero_enderecos." ".$complementos;
			$dados_boleto[endereco2_conta]=$linha_enderecos->bairro_enderecos." - ".$linha_enderecos->cep_enderecos." ".$linha_enderecos->cidade_enderecos."-".$linha_enderecos->uf_enderecos;
			$dados_boleto[local_pg_facil]=$linha_contaboleto->local_pg_facil_contaboleto.' - '.$linha_contaboleto->endereco_pg_facil_contaboleto;
			$dados_boleto[nome_sacado]=$linha_dados->nome_pessoais;
			$dados_boleto[sacado]=$linha_dados->nome_pessoais." cpf:".$linha_dados->cpf_cnpj_pessoais."\n".$linha_enderecos->tipo_logradouro_enderecos." ".$linha_enderecos->logradouro_enderecos." ".$linha_enderecos->numero_enderecos." ".$linha_enderecos->bairro_enderecos." ".$linha_enderecos->complementos_enderecos." - ".$linha_enderecos->cep_enderecos." - ".$linha_enderecos->cidade_enderecos." - ".$linha_enderecos->uf_enderecos;
			$dados_boleto[sacado2]=$linha_dados->nome_pessoais." CPF:".$linha_dados->cpf_cnpj_pessoais;
			//
			if(!$rem){ 
				$dados_boleto['ERROR']='';
			}else{
				$url=$linha_dados->url_boletos;
				$vencimento=$linha_dados->data_vencimento_boletos;
				$urlArr=explode('=',$url);
				$id=$urlArr[1];
				$content3 = http_build_query(array(
						'dt_due' => '04062012',
						'id'   => $id,
						'num_cedente' => '104',
						'num_cedente_default' => '33',
				));
				//echo $content."\n";
				$context3 = stream_context_create(array(
					'http' => array(
						'method'  => 'POST',
						'content' => $content3,
					)
				));
				//echo $content3."\n\n";
				$contents3 = file_get_contents('http://www.f2b.com.br/BillingBoleto', null, $context3);
				if($contents3==''){
					return $dados_boleto['ERROR']='O sistema do F2b está inacessivel, tente Mais tarde';
				}
				if($var[modelo_boleto]=='unico'){
					//$meu_nome=htmlentities("André Martins Brandao");
					$acentosIn = array('á','é','í','ó','ú','ã','õ','â','ê','î','ô','û','ç','Á','É','Í','Ó','Ú','Ã','Õ','Â','Ê','Î','Ô','Û','Ç','à','À');
					$acentosOut = array('&aacute;','&eacute;','&iacute;','&oacute;','&uacute;','&atilde;','&otilde;','&acirc;','&ecirc;','&icirc;','&ocirc;','&ucirc;','&ccedil;','&Aacute;','&Eacute;','&Iacute;','&Oacute;','&Uacute;','&Atilde;','&Otilde;','&Acirc;','&Ecirc;','&Icirc;','&Ocirc;','&Ucirc;','&Ccedil;','&agrave;','&Agrave;');
					//    $texto = preg_replace(array_keys($substituir), array_values($substituir), $texto);
					//              echo nl2br($texto);
					$charIn = array('&nbsp;','=\'/','=/img','<body>','<td class=\'textocomum\' height=\'20\' valign=\'bottom\'>................................................................................................................................................................   Corte Aqui</td>');
					$charOut = array('','=\'http://www.f2b.com.br/','=http://www.f2b.com.br/img','<body cellspacing=\'0\' cellpadding=\'0\'>','');
					//
					$charIn=array_merge($acentosIn,$charIn);
					$charOut=array_merge($acentosOut,$charOut);
					$dadosArray=explode("<form name='formBarra'>",str_replace($charIn, $charOut, $contents3));
					//
					return $dadosArray[0]."</body></html>";//str_replace("='/", "='http://www.f2b.com.br/", $contents3);
				}else{
					$charIn = array('&nbsp;','</',' align=\'right\'',' align=\'center\'','<td height=\'10\'><td>','<big>','>|','|<','valign=\'bottom\'>','<table width=\'489\' border=\'0\' cellspacing=\'0\' cellpadding=\'0\' class=\'textocomumbold10\'>','<tr class=\'textocomumbold10\'>','<td rowspan=\'12\' valign=\'top\' class=\'textocomum\'>','<span><span class=\'textocomumbold10\'>','<span class=\'textocomum8\'>','<span class=\'textocomumbold10\'>','<span><td>','><img src=/img/','<img src=/img/','>    <td>');//, "|", '*',"!", "#", "$", "^", "&", "*","~", "+", "=", "?", "'", ".", "<", "\'");
					$charOut = array('','<','','','|#|','<NB>','><CB>|','|<CB><','><ARGS>','<LPG>','<ARGSX1>','<TEXTX1>','','','<AVAL1>','<AVAL1>','<IMG>','<IMG>','<IMG>');
				}
				$itemCbIn = array('A','B','C','D','E','F','G','H','I','J');
				$itemCbOut = array('0','1','2','3','4','5','6','7','8','9');
				//
				$error1="Esta cobrança já foi paga";
				$error2="Esta cobrança foi cancelada";
				if (strpos($contents3, $error1) !== false) {
					$dados_boleto['ERROR']=$error1;
				}else if(strpos($contents3, $error2) !== false){
					$dados_boleto['ERROR']=$error2;
				}else{
					$dadosArr=explode("<body>",str_replace($charIn, $charOut, $contents3));
					$bodyArr=explode("|#|",$dadosArr[1]);
					$part1=$bodyArr[0];
					$part2=$bodyArr[1];
					$part3=$bodyArr[2];
					//
					$bancoArr=explode("<NB>",$part3);
					$banco=$bancoArr[1];
					//
					$cod_bancoArr=explode("<CB>",$part3);
					$cod_banco=$cod_bancoArr[1];
					//
					$cod_bolArr=explode("<ARGS>",$part3);
					$cod_bolArr1=explode("<td>",$cod_bolArr[1]);
					$cod_bol=$cod_bolArr1[0];
					//
					$local_pagArr=explode("<LPG>",$part3);
					$local_pagArr1=explode("<td>",$local_pagArr[1]);
					$local_pag=$local_pagArr1[1];
					$local_pagAv=$local_pagArr1[3];
					//
					$vencimentoArr=explode("<ARGS>",$part3);
					$vencimentoArr1=explode("<td>",$vencimentoArr[2]);
					$vencimentoCb=$vencimentoArr1[0];
					//
					$cedenteArr=explode("<ARGSX1>",$part3);
					$cedenteArr1=explode("<td>",$cedenteArr[1]);
					$cedente=$cedenteArr1[1];
					$cedente_conta=$cedenteArr1[3];
					//
					$docArr=explode("<ARGSX1>",$part3);
					$docArr1=explode("<td>",$docArr[2]);
					$data_doc=$docArr1[1];
					$numero_doc=$docArr1[3];
					$especie_doc=$docArr1[5];
					$aceite_doc=$docArr1[7];
					$processamento_doc=$docArr1[9];
					$nosso_num_doc=$docArr1[11];
					//
					$bancoArr=explode("<ARGSX1>",$part3);
					$bancoArr1=explode("<td>",$bancoArr[3]);
					$uso_banco=$bancoArr1[1];
					$carteira_banco=$bancoArr1[3];
					$moeda_banco=$bancoArr1[5];
					$quantidade_banco=$bancoArr1[7];
					$x_valor_banco=$bancoArr1[9];
					$valor_banco=$bancoArr1[11];
					//
					$instrucoesArr=explode("<TEXTX1>",$part3);
					$instrucoesArr1=explode("<td>",$instrucoesArr[1]);
					$instrucoesCb=str_replace("<br>","",$instrucoesArr1[0]);
					//
					if($linha_enderecos->complementos_enderecos!=''){
						$complementos='('.$linha_enderecos->complementos_enderecos.')';
					}else{
						$complementos='';
					}
					//
					$avalistaArr=explode("<AVAL1>",$part3);
					$avalistaCbT=str_replace("Cliente desde:"," Cliente desde:",str_replace("CPF:"," CPF:",trim($avalistaArr[1])));
					$avalistaCbArr=explode("<td>",$avalistaCbT);
					if($avalistaCbArr[1]!=''){
						$avalistaCb=$avalistaCbArr[0];
					}else{
						$avalistaCb=$avalistaCbT;
					}
					//
					$cod_barraArr=explode("<IMG>",$part3);
					$cod_barra='';
					for($icb=1;$icb<count($cod_barraArr)-1;$icb++){
						$cod_barra.=$cod_barraArr[$icb]."|";
					}
					//
					$codigo_barArr=explode("<input type='hidden' name='codBarra' value='",$part3);
					$codigo_barArr1=explode("'>",$codigo_barArr[1]);
					$codigo_barra=str_replace($itemCbIn, $itemCbOut, $codigo_barArr1[0]);
					//
					$codigo_bolArr=explode("<input type='hidden' name='criptLin' value='",$part3);
					$codigo_bolArr1=explode("'>",$codigo_bolArr[1]);
					$codigo_boleto=str_replace($itemCbIn, $itemCbOut, $codigo_bolArr1[0]);
					//
					if($codigo_boleto==''){
						$codigo_boleto=str_replace("'>","",str_replace("<img src='","",str_replace("/CarregaImg","http://www.f2b.com.br/CarregaImg",$cod_bol)));
						$tipo_codigo_boleto='img';
					}else{
						$tipo_codigo_boleto='texto';
						$cod_barra='';
					}
					//
					$nome_bancoArr=explode("/",$banco);
					$nome_bancoArr1=explode("_",$nome_bancoArr[count($nome_bancoArr)-1]);
					$nome_banco=$nome_bancoArr1[0];
					//
					$dados_boleto[html_boletos]=$contents3;
					$dados_boleto[nome_banco]=$nome_banco;
					$dados_boleto[codigo_banco]=$cod_banco;
					$dados_boleto[codigo_boleto]=$codigo_boleto;
					$dados_boleto[tipo_codigo_boleto]=$tipo_codigo_boleto;
					$dados_boleto[local_pag]=$local_pag;
					$dados_boleto[local_pag_av]=$local_pagAv;
					$dados_boleto[vencimento]=$vencimentoCb;
					$dados_boleto[nome_cedente]=$cedente;
					$dados_boleto[conta_cedente]=$cedente_conta;
					$dados_boleto[data_documento]=$data_doc;
					$dados_boleto[numero_documento]=$numero_doc;
					$dados_boleto[especie_documento]=$especie_doc;
					$dados_boleto[aceite_documento]=$aceite_doc;
					$dados_boleto[processamento_documento]=$processamento_doc;
					$dados_boleto[nosso_numero_documento]=$nosso_num_doc;
					$dados_boleto[uso_banco]=$uso_banco;
					$dados_boleto[carteira]=$carteira_banco;
					$dados_boleto[moeda]=$moeda_banco;
					$dados_boleto[qtd]=$quantidade_banco;
					$dados_boleto[x_valor]=$x_valor_banco;
					$dados_boleto[valor]=$valor_banco;
					$dados_boleto[instrucoes]=$instrucoesCb;
					$dados_boleto[avalista]=$avalistaCb;
					$dados_boleto[codigo_barra]=$cod_barra;
					$dados_boleto[num_codigo_barra]=$codigo_barra;
					$dados_boleto['ERROR']='';
				}
			}
			//
			return $dados_boleto;			
		}
	}
	//
	function salvarBoletos($var,$linha_dados,$linha_enderecos,$linha_contaboleto,$linha_provedor){
		//
		//echo 'sb1';
		global $codigo_provedor,$LOCAL_HOME;
		//
		// PEGA DADOS CONFIGURAÇÕES DO PROVEDOR
		$desativar_encargos_clientes=$linha_dados->desativar_encargos_clientes;
		//
		$dias_sem_multa_provedor=$linha_contaboleto->dias_sem_multa_contaboleto;
		$gerar_encargos_apos_provedor=$linha_contaboleto->gerar_encargos_apos_contaboleto;
		$tipo_multa_provedor=$linha_contaboleto->tipo_multa_contaboleto;
		$valor_multa_provedor=$linha_contaboleto->valor_multa_contaboleto;
		$tipo_juros_provedor=$linha_contaboleto->tipo_juros_contaboleto;
		$valor_juros_provedor=$linha_contaboleto->valor_juros_contaboleto;
		$pasta_gateway=$linha_contaboleto->valor_juros_contaboleto;
		$banco=$linha_contaboleto->banco_contaboleto;
		if($tipo_multa_provedor=='r'){
			$rMulta='R$ ';
			$pMulta='';
		}else if($tipo_multa_provedor=='p'){
			$rMulta='';
			$pMulta='%';
		}else{ 
			$rMulta='';
			$pMulta='';
		}
		//
		if($valor_multa_provedor>0){
			$textoMulta='multa de '.$rMulta.$valor_multa_provedor.$pMulta.' ';
		}
		if($tipo_juros_provedor=='r'){
			$rJuros='R$ ';
			$pJuros='';
		}else if($tipo_juros_provedor=='p'){
			$rJuros='';
			$pJuros='%';
		}else{
			$rJuros='';
			$pJuros='';
		}
		//
		if($valor_juros_provedor>0){
			if($textoMulta!='')
				$textoMulta.='mais ';
			$textoJuros='juros de '.$rJuros.$valor_juros_provedor.$pJuros.' ';
		}
		if($textoMulta!='' || $textoJuros!=''){
			$textoJurosMulta='Após vencimento, '.$textoMulta.$textoJuros.'<br>';
		}else{
			$textoJurosMulta='Pague preferêncialmente até o vencimento!<br>';
		}
		//
		if($banco=='local'){
			$ncb=1;
			while($ncb!=0){
				$numero_boletos=mt_rand(10000000,99999999);		//verifica se cdc ja existe
				$ncb = mysql_num_rows(mysql_query("SELECT numero_boletos FROM sis_cobrancas_boletos WHERE numero_boletos='".$numero_boletos."' AND codigo_provedor='$codigo_provedor'"));
			}
			//GERA DADOS DO BOLETO LOCAL
			$dados_boleto['codigo_provedor']=$codigo_provedor;
			$dados_boleto['numero_boletos']=$numero_boletos;
			$dados_boleto['codigo_cobranca_boletos']=$linha_dados->codigo_cobrancas;
			$dados_boleto['codigo_conta_boletos']=$linha_dados->codigo_pessoais_cobrancas;
			$dados_boleto['valor_boletos']=$linha_dados->valor_total_cobrancas;
			$dados_boleto['data_vencimento_boletos']=$linha_dados->data_vencimento_cobrancas;
			$dados_boleto['status_boletos']='REGISTRADA';
			$dados_boleto['tipo_boletos']='local';
			$dados_boleto['url_boletos']="http://provedor.uvsat.com/central/cob.php?provedor=$codigo_provedor&numero=".$numero_boletos;
			$dados_boleto['nome_cedente_boletos']=$linha_contaboleto->cedente_contaboleto;
			$dados_boleto['data_documento_boletos']=date("Y-m-d");
			$dados_boleto['num_conta_boletos']='';
			$dados_boleto['local_pag_boletos']=toVarUtf8('Somente em:'.$linha_contaboleto->local_pg_facil_contaboleto.' (Endereço em Instruções abaixo)');
			$dados_boleto['nosso_num_boletos']='';
			$dados_boleto['especie_documento_boletos']='';
			$dados_boleto['aceite_documento_boletos']='';
			$dados_boleto['data_processamento_boletos']=date("Y-m-d");
			$dados_boleto['uso_banco_boletos']='';
			$dados_boleto['carteira_boletos']='';
			$dados_boleto['moeda_boletos']='R$';
			$dados_boleto['qtd_boletos']='';
			$dados_boleto['x_valor_boletos']=$linha_dados->valor_total_cobrancas;
			$instrucoes='';
			if($linha_contaboleto->instr_linha1_contaboleto!=''){
				$instrucoes.=toVarUtf8($linha_contaboleto->instr_linha1_contaboleto).'<br>';
			}else{
				$instrucoes.=$textoJurosMulta;
			}
			if($linha_contaboleto->instr_linha2_contaboleto!=''){
				$instrucoes.=toVarUtf8($linha_contaboleto->instr_linha2_contaboleto).'<br>';
			}else{
				$instrucoes.='<br>';
			}
			if($linha_contaboleto->instr_linha3_contaboleto!=''){
				$instrucoes.=toVarUtf8($linha_contaboleto->instr_linha3_contaboleto).'<br>';
			}else{
				$instrucoes.='<br>';
			}
			if($linha_contaboleto->instr_linha4_contaboleto!=''){
				$instrucoes.=toVarUtf8($linha_contaboleto->instr_linha4_contaboleto).'<br>';
			}else{
				$instrucoes.='Endereço para pagamento:<br>';
			}
			if($linha_contaboleto->instr_linha5_contaboleto!=''){
				$instrucoes.=toVarUtf8($linha_contaboleto->instr_linha5_contaboleto).'<br>';
			}else{
				$instrucoes.=toVarUtf8($linha_contaboleto->endereco_pg_facil_contaboleto);
			}
			$dados_boleto['instrucoes_boletos']=toVarUtf8($instrucoes);
			//
			return $dados_boleto;
			//
		}else if($banco=='f2b'){
			//
			//echo 'sb2';
			$envio='n';
			if(!checkEmail($linha_dados->email_1_pessoais)){
				$email_1=$linha_dados->codigo_pessoais."@uvsat.com.br";
			}else{
				$email_1=$linha_dados->email_1_pessoais;
				if($linha_dados->envio_email_cobrancas=='on'){
					$envio='e';
				}
			}
			//gera a cobrança f2b
			$telefone1Arr=explode(")",$linha_dados->telefone1_numero_pessoais);
			$ddd_telefone1=str_replace("(","",$telefone1Arr[0]);
			$numero_telefone1=str_replace("-","",$telefone1Arr[1]);
			$telefone2Arr=explode(")",$linha_dados->telefone2_numero_pessoais);
			$ddd_telefone2=str_replace("(","",$telefone2Arr[0]);
			$numero_telefone2=str_replace("-","",$telefone2Arr[1]);
			$telefone3Arr=explode(")",$linha_dados->telefone3_numero_pessoais);
			$ddd_telefone3=str_replace("(","",$telefone3Arr[0]);
			$numero_telefone3=str_replace("-","",$telefone3Arr[1]);
			//
			$cep=str_replace("-","",$linha_enderecos->cep_enderecos);
			if($linha_dados->tipo_pessoa_pessoais=="f"){
				if($linha_dados->cpf_cnpj_pessoais!=""){
					$cpf=ereg_replace("[^0-9]", "", $linha_dados->cpf_cnpj_pessoais);
					if(validaCpf($cpf)){
						$CPF=$cpf;
					}
				}
				if($linha_dados->nome_pessoais!=""){
					$NOME=$linha_dados->nome_pessoais;
				}
			}else if($linha_dados->tipo_pessoa_pessoais=="j"){
				if($linha_dados->cpf_cnpj_pessoais!=""){
					$cnpj=ereg_replace("[^0-9]", "", $linha_dados->cpf_cnpj_pessoais);
					if(validaCNPJ($cnpj)){
						$CNPJ=$cnpj;
					}
				}
				if($linha_dados->razao_social_pessoais!=""){
					$NOME=$linha_dados->razao_social_pessoais;
				}
			}
			$cod_grupo="";
			$qgp=1;
			while($qgp!=0){
				$cod_grupo="NET_".mt_rand(10000000,99999999);		//verifica se cdc ja existe
				$qgp = mysql_num_rows(mysql_query("SELECT cod_grupo_boletos FROM sis_cobrancas_boletos WHERE cod_grupo_boletos='".$cod_grupo."' AND codigo_provedor='$codigo_provedor'"));
			}
			require_once("$LOCAL_HOME/classes/WSBilling.php");
			// Inicia a classe WSBilling
			$WSBilling = new WSBilling();
			// Cria o cabeçalho SOAP
			$xmlObj = $WSBilling->add_node("","soap-env:Envelope");
			$WSBilling->add_attributes($xmlObj, array("xmlns:soap-env" => "http://schemas.xmlsoap.org/soap/envelope/") );
			$xmlObj = $WSBilling->add_node($xmlObj,"soap-env:Body");
			// Cria  o elemento m:F2bCobranca
			$xmlObjF2bCobranca = $WSBilling->add_node($xmlObj,"m:F2bCobranca");
			$WSBilling->add_attributes($xmlObjF2bCobranca, array("xmlns:m" => "http://www.f2b.com.br/soap/wsbilling.xsd") );
			// Cria o elemento mensagem
			$xmlObj = $WSBilling->add_node($xmlObjF2bCobranca,"mensagem");
			$WSBilling->add_attributes($xmlObj, array("data" => date("Y-m-d"),"numero" => date("His"),"tipo_ws" => "WebService"));
			// Cria o elemento sacador
			$xmlObj = $WSBilling->add_node($xmlObjF2bCobranca,"sacador");
			$WSBilling->add_attributes($xmlObj, array("conta" => $linha_contaboleto->num_conta_contaboleto,"senha" => $linha_contaboleto->senha_conta_contaboleto));
			$WSBilling->add_content($xmlObj,$linha_contaboleto->cedente_contaboleto);
			// Cria o elemento cobranca
			$xmlObjCobranca = $WSBilling->add_node($xmlObjF2bCobranca,"cobranca");
			$WSBilling->add_attributes($xmlObjCobranca, array("valor" => $linha_dados->valor_total_cobrancas,"tipo_cobranca" => "BT","num_document" => "","cod_banco" => "104"));
			// Cria os elementos demonstrativos (Até 10 linhas com 80 caracteres cada)
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"Cobrança ".$linha_provedor->nome_pessoais);
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"---------------");
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"---------------");
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"---------------");
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"---------------");
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"---------------");
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"*Locais de Pagamento Fácil:");
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,$linha_contaboleto->local_pg_facil_contaboleto);
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,$linha_contaboleto->endereco_pg_facil_contaboleto);
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"demonstrativo");
			$WSBilling->add_content($xmlObj,"---------------");
			// Cria o elemento desconto
			if($linha_contaboleto->valor_desconto_contaboleto!=0){
				$xmlObj = $WSBilling->add_node($xmlObjCobranca,"desconto");
				if($linha_contaboleto->tipo_desconto_contaboleto=='p'){
					$tipo_desconto='1';
				}else {
					$tipo_desconto='0';
				}
				$WSBilling->add_attributes($xmlObj, array("valor" => $linha_contaboleto->valor_desconto_contaboleto, "tipo_desconto" => $tipo_desconto,"antecedencia" => $linha_contaboleto->dias_desconto_contaboleto));
			}
			// Cria o elemento multa
			$xmlObj = $WSBilling->add_node($xmlObjCobranca,"multa");
			//$WSBilling->add_attributes($xmlObj, array("atraso" => "15"));
			if($linha_contaboleto->gerar_encargos_apos_contaboleto!='on' && $linha_dados->desativar_encargos_clientes!='on'){
				if($linha_contaboleto->tipo_multa_contaboleto=='p'){
					$tipo_multa='1';
				}else {
					$tipo_multa='0';
				}
				if($linha_contaboleto->tipo_juros_contaboleto=='p'){
					$tipo_juros='1';
				}else {
					$tipo_juros='0';
				}
				$WSBilling->add_attributes($xmlObj, array("atraso" => "20",  "valor" => $linha_contaboleto->valor_multa_contaboleto,  "tipo_multa" => $tipo_multa,"valor_dia" => $linha_contaboleto->valor_juros_contaboleto, "tipo_multa_dia" => $tipo_juros));
				//$ERROR.="vrmulta:".$linha_contaboleto->valor_multa_contaboleto."-$tipo_multa - vrJuros:".$linha_contaboleto->valor_juros_contaboleto."-$tipo_juros";
			}else{
				$WSBilling->add_attributes($xmlObj, array("atraso" => "20"));
			}
			//echo "tpmulta:".$linha_contaboleto->tipo_multa_contaboleto."-$tipo_multa - tpJuros:".$linha_contaboleto->tipo_juros_contaboleto."-$tipo_juros";
			//Cria o elemento agendamento
			$xmlObj = $WSBilling->add_node($xmlObjF2bCobranca,"agendamento");
			//	echo "vc:".$linha_dados->data_vencimento_cobrancas."\n";
			$data_vencimento=$linha_dados->data_vencimento_cobrancas;
			$dvTM=strtotime($data_vencimento);
			$dhTM=strtotime(date('Y-m-d'));
			if(strtotime($linha_dados->data_vencimento_cobrancas) < strtotime(date('Y-m-d'))){
				$data_vencimento=date('Y-m-d');
			}
			$WSBilling->add_attributes($xmlObj, array("vencimento" => $data_vencimento,
					//  Descomentar os atributos abaixo caso queria realizar cobranças com Agendamento //////
					//                                          "ultimo_dia" => "n","antecedencia" => 10,"periodicidade" => "1","periodos" => "12",
					"sem_vencimento" => "n"));
			$WSBilling->add_content($xmlObj,"Pagamento a vista");
			// Cria o elemento sacado
			$xmlObjSacado = $WSBilling->add_node($xmlObjF2bCobranca,"sacado");
			$WSBilling->add_attributes($xmlObjSacado, array("grupo" => $cod_grupo,"codigo" => $linha_dados->codigo_pessoais_cobrancas,"envio" => $envio));
			// Cria o elemento nome
			$xmlObj = $WSBilling->add_node($xmlObjSacado,"nome");
			$WSBilling->add_content($xmlObj,$NOME);
			// Cria o elemento email
			$xmlObj = $WSBilling->add_node($xmlObjSacado,"email");
			$WSBilling->add_content($xmlObj,$email_1);
			// Cria o elemento endereco
			$xmlObj = $WSBilling->add_node($xmlObjSacado,"endereco");
			$WSBilling->add_attributes($xmlObj, array("logradouro" => $linha_enderecos->tipo_logradouro_enderecos." ".$linha_enderecos->logradouro_enderecos,"numero" => $linha_enderecos->numero_enderecos,"complemento" => $linha_enderecos->complementos_enderecos,"bairro" => $linha_enderecos->bairro_enderecos,"cidade" => $linha_enderecos->cidade_enderecos,"estado" => $linha_enderecos->uf_enderecos,"cep" => $cep));
			// Cria o elemento telefone
			if($ddd_telefone1!=""){
				$xmlObj = $WSBilling->add_node($xmlObjSacado,"telefone");
				$WSBilling->add_attributes($xmlObj, array("ddd" => $ddd_telefone1,"numero" => $numero_telefone1));
			}
			// Cria o elemento telefone comercial
			if($ddd_telefone2!=""){
				$xmlObj = $WSBilling->add_node($xmlObjSacado,"telefone_com");
				$WSBilling->add_attributes($xmlObj, array("ddd_com" => $ddd_telefone2,"numero_com" => $numero_telefone2));
			}
			// Cria o elemento telefone celular
			if($ddd_telefone3!=""){
				$xmlObj = $WSBilling->add_node($xmlObjSacado,"telefone_cel");
				$WSBilling->add_attributes($xmlObj, array("ddd_cel" => $ddd_telefone3,"numero_cel" => $numero_telefone3));
			}
			// Cria o elemento cpf
			if($CPF!=""){
				$xmlObj = $WSBilling->add_node($xmlObjSacado,"cpf");
				$WSBilling->add_content($xmlObj,$CPF);
			}
			// Cria o elemento cnpj
			if($CNPJ!=""){
				$xmlObj = $WSBilling->add_node($xmlObjSacado,"cnpj");
				$WSBilling->add_content($xmlObj,$CNPJ);
			}
			$xmlObj = $WSBilling->add_node($xmlObjSacado,"observacao");
			$WSBilling->add_content($xmlObj,$linha_dados->obs_pessoais);
			//	echo "--------: GERA COBRANÇA NO F2B<Br>\n";
			// envia dados
			$WSBilling->send($WSBilling->getXML());
			$resposta = $WSBilling->resposta;
			//$resposta = implode("",file("WSBillingResposta.xml"));
			if(strlen($resposta) > 0){
				// Reinicia a classe WSBlling, agora com uma string XML
				if(stripos($resposta, 'HTTP Status 500') !== false){
					$log["texto"]="ERROR NO F2B";
				}else{
					$WSBilling = new WSBilling($resposta);
					// LOG
					$log = $WSBilling->pegaLog();
				}
				if($log["texto"] == "OK"){
					// **** Para abrir a cobrança em uma nova janela ****
					$cobranca = $WSBilling->pegaCobranca();
					$numero_boletos=$cobranca[0][numero];
					$url_boletos=$cobranca[0][url];
					$tipo_boletos="f2b";
					//echo "--------: Cobrança Registrada N:".$numero_cobranca."<Br>\n";
				} else {
					foreach($log as $key => $value){
						$ERROR.=$log[$key].' - ';
					}
					//echo "--------: Cobrança nao Gerada ERROR:".$ERROR." - ".$linha_dados->nome_pessoais."<Br>\n";
					$status_boletos='CRIADO';
					$url_boletos='';
					$numero_boletos='';
					$tipo_boletos="local";
				}
			} else {
				//echo "--------: Cobrança nao Gerada ERROR:Sem Resposta<Br>\n";
				$status_boletos='CRIADO';
				$url_boletos='';
				$numero_boletos='';
				$tipo_boletos="local";
			}
			if($numero_boletos==''){
				$ncb=1;
				while($ncb!=0){
					$numero_boletos=mt_rand(10000000,99999999);		//verifica se cdc ja existe
					$ncb = mysql_num_rows(mysql_query("SELECT numero_boletos FROM sis_cobrancas_boletos WHERE numero_boletos='".$numero_boletos."' AND codigo_provedor='$codigo_provedor'"));
				}
			}
			//*/
			//GERA DADOS DO BOLETO LOCAL
			$dados_boleto['codigo_provedor']=$codigo_provedor;
			$dados_boleto['numero_boletos']=$numero_boletos;
			$dados_boleto['codigo_cobranca_boletos']=$linha_dados->codigo_cobrancas;
			$dados_boleto['codigo_conta_boletos']=$linha_dados->codigo_pessoais_cobrancas;
			$dados_boleto['valor_boletos']=$linha_dados->valor_total_cobrancas;
			$dados_boleto['data_vencimento_boletos']=$data_vencimento;
			$dados_boleto['status_boletos']='REGISTRADA';
			$dados_boleto['tipo_boletos']=$tipo_boletos;
			$dados_boleto['url_boletos']=$url_boletos;
			$dados_boleto['cod_grupo_boletos']=$cod_grupo;
			$dados_boleto['error_boletos']=$ERROR;
			//
			//print_r($dados_boleto);
			return $dados_boleto;			
		}
	}
	//
	function verificarBoletos($banco,$linha_contaboleto,$tipo,$valor,$valor_final,$outros){
		//
		global $codigo_provedor;
		global $LOCAL_HOME;
		global $URL_SERVIDOR;
		global $session;
		//
		$dias_sem_multa_provedor=$linha_contaboleto->dias_sem_multa_contaboleto;
		$gerar_encargos_apos_provedor=$linha_contaboleto->gerar_encargos_apos_contaboleto;
		$tipo_multa_provedor=$linha_contaboleto->tipo_multa_contaboleto;
		$valor_multa_provedor=$linha_contaboleto->valor_multa_contaboleto;
		$tipo_juros_provedor=$linha_contaboleto->tipo_juros_contaboleto;
		$valor_juros_provedor=$linha_contaboleto->valor_juros_contaboleto;
		$pasta_gateway=$linha_contaboleto->valor_juros_contaboleto;
		//
		if($banco=='f2b'){
//			global $codigo_pessoais_cobrancas;
//			global $cod_grupo_cobrancas;
			require_once($LOCAL_HOME."classes/WSBillingStatus.php");
			// Inicia a classe WSBillingStatus
			$WSBillingStatus = new WSBillingStatus();
			// Cria o cabeçalho SOAP
			$xmlObj = $WSBillingStatus->add_node("","soap-env:Envelope");
			$WSBillingStatus->add_attributes($xmlObj, array("xmlns:soap-env" => "http://schemas.xmlsoap.org/soap/envelope/") );
			$xmlObj = $WSBillingStatus->add_node($xmlObj,"soap-env:Body");
			// Cria  o elemento m:F2bCobranca
			$xmlObjF2bCobranca = $WSBillingStatus->add_node($xmlObj,"m:F2bSituacaoCobranca");
			$WSBillingStatus->add_attributes($xmlObjF2bCobranca, array("xmlns:m" => "http://www.f2b.com.br/soap/wsbillingstatus.xsd") );
			// Cria o elemento mensagem
			$xmlObj = $WSBillingStatus->add_node($xmlObjF2bCobranca,"mensagem");
			$WSBillingStatus->add_attributes($xmlObj, array("data" => date("Y-m-d"),"numero" => date("His")));
			// Cria o elemento cliente
			$xmlObj = $WSBillingStatus->add_node($xmlObjF2bCobranca,"cliente");
			$WSBillingStatus->add_attributes($xmlObj, array("conta" => $linha_contaboleto->num_conta_contaboleto,"senha" => $linha_contaboleto->senha_conta_contaboleto));
			// Cria o elemento cobranca
			$xmlObjCobranca = $WSBillingStatus->add_node($xmlObjF2bCobranca,"cobranca");
			// Deve ser enviado
			//echo "$NMEC - $NMAC<br>";
			$dados_busca_cb=array();
			if($tipo=="numero"){
				// ********************** Intervalos de cobranças ************************************
				$dados_busca_cb[numero]=$valor; 
				if($valor_final!=''){
					$dados_busca_cb[numero_final]=$valor_final;
				}
			}else if($tipo=="registro"){
				// ********************** Intervalos de registro ************************************
				$dados_busca_cb[registro]=$valor; 
				if($valor_final!=''){
					$dados_busca_cb[registro_final]=$valor_final;
				}
			}else if($tipo=="vencimento"){
				// ********************** Intervalos de vencimento ************************************
				$dados_busca_cb[vencimento]=$valor; 
				if($valor_final!=''){
					$dados_busca_cb[vencimento_final]=$valor_final;
				}
			}else if($tipo=="processamento"){
				// ********************** Intervalos de processamento ************************************
				$dados_busca_cb[processamento]=$valor; 
				if($valor_final!=''){
					$dados_busca_cb[processamento_final]=$valor_final;
				}
			}else if($tipo=="credito"){
				// ********************** Intervalos de credito ************************************
				$dados_busca_cb[credito]=$valor; 
				if($valor_final!=''){
					$dados_busca_cb[credito_final]=$valor_final;
				}
			}
			// e/ou -------------
			if($outros[cod_sacado]!=""){
				$dados_busca_cb[cod_sacado]=$outros[cod_sacado];
			}
			// e/ou -------------
			if($outros[cod_grupo]!=""){
				$dados_busca_cb[cod_grupo]=$outros[cod_grupo];
			}
			// e/ou -------------
			if($outros[tipo_pagamento]!=""){
				$dados_busca_cb[tipo_pagamento]=$outros[tipo_pagamento];
			}
			// e/ou -------------
			if($outros[numero_documento]!=""){
				$dados_busca_cb[numero_documento]=$outros[numero_documento];
			}
			// e/ou -------------
			if($outros[situacao]!=""){
				$dados_busca_cb[situacao]=$outros[situacao];
			}
			echo "busca:";
			print_r($dados_busca_cb);
			echo "\n";
			// e/ou -------------
			$WSBillingStatus->add_attributes($xmlObjCobranca, $dados_busca_cb);
			// envia dados
			$WSBillingStatus->send($WSBillingStatus->getXML());
			$resposta = $WSBillingStatus->resposta;
			if(strlen($resposta) > 0){
				// Reinicia a classe WSBillingStatus, agora com uma string XML
				if(stripos($resposta, 'HTTP Status 500') !== false){
					$log["texto"]="ERROR NO F2B";
				}else{
					$WSBillingStatus = new WSBillingStatus($resposta);
					// LOG
					$log = $WSBillingStatus->pegaLog();
				}
				if($log["texto"] == "OK"){
					// COBRANCAS
					$cobranca = $WSBillingStatus->pegaCobranca();
					// TOTAL
					$total = $WSBillingStatus->pegaTotal();
					if($total[0][numero_cobrancas]!="0"){
						echo "true|".$total[0][numero_cobrancas]."|\n";
						foreach($cobranca as $key => $value){
					//		echo "<br>";
					        $numero=$cobranca[$key][numero]*1;
					        $situacao=$cobranca[$key][situacao];
					        $taxa_pagamento=$cobranca[$key][taxa_pagamento];
					        $data_pagamento=$cobranca[$key][pagamento];
					        $valor_pago=$cobranca[$key][valor_pago];
					        $pagamento_bloqueado=$cobranca[$key][pagamento_bloqueado];
					        $credito_em=$cobranca[$key][credito];
					        $tipo_do_pagamento=$cobranca[$key][tipo_do_pagamento];
					        if($credito_em=='')
					        	$credito_em=$data_pagamento;
					       	//
					        echo "$numero - $situacao - $taxa_pagamento - $data_pagamento - $valor_pago - $pagamento_bloqueado - $credito_em - $tipo_do_pagamento\n";
					//
							switch($situacao) { 
								case "Registrada":
									$situacao_cobranca="REGISTRADA";
								break;
								case "Cancelada":
									$situacao_cobranca="CANCELADA";
								break;
								case "Paga":
									$situacao_cobranca="PAGA";
								break;
							}
							//PEGA DADOS DO BOLETO
							if($situacao_cobranca!="REGISTRADA" && $situacao_cobranca!="CANCELADA"){
								$sqlBoletoAtual = "SELECT * FROM sis_cobrancas_boletos AS bol 
								INNER JOIN sis_dados_cobrancas AS cob ON cob.codigo_cobrancas=bol.codigo_cobranca_boletos
								WHERE bol.numero_boletos like '%$numero%' AND (bol.status_boletos!='".$situacao_cobranca."' OR cob.situacao_cobrancas!=bol.status_boletos) AND cob.situacao_cobrancas!='CANCELADA' AND bol.codigo_provedor='$codigo_provedor'";
								//
								$resultadoBoletoAtual = mysql_query($sqlBoletoAtual);
								if(mysql_num_rows($resultadoBoletoAtual)==1){
									$lCoAtual=mysql_fetch_object($resultadoBoletoAtual);
									if($situacao_cobranca=="PAGA"){
										//REGISTRA O PAGAMENTO
										if($lCoAtual->valor_total_cobrancas < $valor_pago){
											$juros_multa=$valor_pago-$lCoAtual->valor_total_cobrancas;
										}else{
											$juros_multa=0;
										}
										$contentsRecebimento = file_get_contents(''.$URL_SERVIDOR.'/admin/caixa/configurar_recebimentos.php', null, stream_context_create(array('http' => array('method'=>'POST','content'=>http_build_query(array(
											'cmd'=>'save',
											'tipo_pg'=>'auto',
											'n_alterar_boletos'=>true,
											'id_recebimentos'=>'',
											'tipo_recebimento_cobrancas'=>'f2b',
											'especie_recebimentos'=>$tipo_do_pagamento,
											'data_recebimentos'=>$data_pagamento,
											'data_credito_recebimentos'=>$credito_em,
											'valor_taxa_recebimentos'=>$taxa_pagamento,
											'obs_recebimentos'=>'',
											'tipo_recebimentos'=>'f2b',
											'codigo_pessoais_recebimentos'=>$lCoAtual->codigo_conta_boletos,
											'valor_recebimentos'=>$valor_pago,
											'array_tipo_recebimentos'=>'COBR;',
											'array_id_recebimentos' => $lCoAtual->id_cobrancas.";",
											'array_valor_recebimentos' => $lCoAtual->valor_total_cobrancas.";",
											'array_juros_recebimentos' => $juros_multa.";",
											'array_vencimento_recebimentos' => $lCoAtual->data_vencimento_cobrancas.";",
											'session'=>$session,
										)),))));
										$contentsCobrancasArray = json_decode($contentsRecebimento, true);
										//if($contentsCobrancasArray['id_recebimentos']!=''){
											//ALTERA CODIGO RECEBIMENTO DA COBRANÇA
										//	$resultado = mysql_query("UPDATE sis_dados_cobrancas SET cod_recebimento_cobrancas = '".$contentsCobrancasArray['id_recebimentos']."' WHERE id_cobrancas='".$lCoAtual->id_cobrancas."' AND codigo_provedor= '$codigo_provedor'") or die ('{"success":false,errors":"Não foi possível alterar produtos_dados LINHA 426"}');
										//}
										//
										echo $lCoAtual->id_cobrancas.";$numero;$situacao_cobranca;Boleto local Atualizado(Recebimento:".$contentsCobrancasArray['id_recebimentos'].")|\n";
										//
									}
									//ALTERA BOLETOS
									$resultadoBol = mysql_query("UPDATE sis_cobrancas_boletos SET data_pag_boletos='".$data_pagamento."', status_boletos='".$situacao_cobranca."', valor_taxa_boletos='".$taxa_pagamento."', valor_pag_boletos='".$valor_pago."', pagamento_bloqueado_boletos='".$pagamento_bloqueado."', data_credito_boletos='".$credito_em."', tipo_pagamento_boletos='".$tipo_do_pagamento."' WHERE id_boletos='".$lCoAtual->id_boletos."' AND codigo_provedor= '$codigo_provedor'") or die ('{"success":false,errors":"Não foi possível alterar produtos_dados LINHA 426"}');
									//
								}else{
									echo "null;$numero;$situacao_cobranca;Boleto Inexistente ou ja Atualizado|\n";
								}
							}else if($situacao_cobranca=="CANCELADA"){
								echo "null;$numero;$situacao_cobranca;Cobrança remota Cancelada|\n";
							}else{
								$sqlBoletoAtual = "SELECT * FROM sis_cobrancas_boletos WHERE numero_boletos='$numero' AND status_boletos='PG' AND valor_boletos > 0 AND codigo_provedor='$codigo_provedor'";
								$resultadoBoletoAtual = mysql_query($sqlBoletoAtual) or die ("Não foi possível realizar a consulta ao banco de boletos");
								if(mysql_num_rows($resultadoBoletoAtual)==1){
									$lCoAtual=mysql_fetch_object($resultadoBoletoAtual);
									//ATUALIZA PAGAMENTO DE BOLETOS NO BANCO
//									$argv = array("",$provedor,"registrar_pagamento",$lCoAtual->id_cobrancas."|");
//									$comando = trim(shell_exec("/home/uvsatcom/scripts/cobrancas/alterar_boletos.php \"".$argv[1]."\" \"".$argv[2]."\" \"".$argv[3]."\""));
									echo "null;$numero;$situacao_cobranca;Cobrança remota Atualizada ($comando)|\n";	
								}else{						
									echo "null;$numero;$situacao_cobranca;Boleto nao Atualizado|\n";
								}
							}
						}
						echo "\n";
					}else{
						echo "false|Nenhum boleto Encontrado\n";
					}
				} else {
					foreach($log as $key => $value){
						$ERROR.=toVarIso88591($log[$key]).' - ';
					}
					echo "false|Boleto não verificado\n ERROR:".$ERROR."\n";
				}
			} else {
		   		echo "false|Boleto não verificado\n ERROR:Sem Resposta\n";
			}
		}
	}	
?>