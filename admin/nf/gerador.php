<?php
$gerar=true; 
//
$num_error=0;
require_once("validar.php");
if(!$authSession){
	$num_error++;
	$error.=$num_error.'-Não Autenticado!<br>';
	$gerar=false;
}else{
	$test_files=$_FILES ? $_FILES : false;
	$test_mes=isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
	$test_ano=isset($_REQUEST["ano"]) ? $_REQUEST["ano"] : false;
	$test_num=isset($_REQUEST["num"]) ? $_REQUEST["num"] : false;
	//
	if(!$test_files){
		$num_error++;
		$error.=$num_error.'-Arquivos inválidos!<br>';
		$gerar=false;
	}
	if(! $test_mes || ! $test_ano){
		$num_error++;
		$error.=$num_error.'-Ano ou Mês inválido!<br>';
		$gerar=false;
	}
}
if($gerar){
	//importa funçoes
	include_once( "../../classes/funcoes_novas.php");
	$chars = array('\\', '\/', "|", '*',"!", "#", "$", "^", "&", "*","~", "+", "=", "?", "'", ".", "<", "\'", "-", ":", ",", "(", ")"," ");
	$acentosIn = array('á','é','í','ó','ú','ã','õ','â','ê','î','ô','û','ç','Á','É','Í','Ó','Ú','Ã','Õ','Â','Ê','Î','Ô','Û','Ç','à','À');
	$acentosOut = array('a','e','i','o','u','a','o','a','e','i','o','u','c','A','E','I','O','U','A','O','A','E','I','O','U','C','a','A');
	//
	$numNF = isset($_REQUEST["num"]) ? $_REQUEST["num"] : false;
	if($numNF){
		$num_nf=$numNF;
		$num_inicial_nf=$num_nf;
	}else{
		$num_inicial_nf=1;
	}
	//
	$REF=date('dmy-Hmi');
	$uploaddir="files_in/";
	//$data = str_replace($chars, "", $_REQUEST["data"]);
	foreach($_FILES as $key=>$value){
		if(file_exists($_FILES[$key]['tmp_name'])){
			//abre o arquivo e somente lê (modo "r")
			$uploadfile = $uploaddir . $REF . '_' . $_FILES[$key]['name'];
			if($key=='arquivo_1'){
				$file_clien=$uploadfile;
			}else if($key=='arquivo_2'){
				$file_fatp=$uploadfile;
			}
			//
			if (move_uploaded_file($_FILES[$key]['tmp_name'], $uploadfile)){
				//
				$fp = fopen($uploadfile, "r");
				// lê o arquivo enquanto não chegar ao seu final (eof - end of file)
				//echo $_FILES[$key]['name']."<BR><Br>";
				$linha=array();
				$i=0;
				while(!feof($fp)){
					// armazena o conteudo do arquivo na variavel $conteudo
					$conteudo = fgets($fp);
					//echo $i."-(".$conteudo.")<Br>";
					/* aqui que está o segredo. Explodimos as linhas a cada ' ponto e vírgula '
					 com a função 'explode' e armazenamos na variavel $linha  */
					if($conteudo!='' && $conteudo!=' '){
						$linha[$i] = $conteudo;
						// imprimimos o resultado na tela
						$i++;
					}
				}
				$dadosfile[$key]=$linha;
			}
		}
	}
	foreach($dadosfile['arquivo_1'] as $key=>$value){
		$l=explode('|',$value);
		$dadosfile['arquivo_unico'][$key]=$l[0].'|'.$l[1].'|'.$l[2].'|'.$l[3].'|'.$l[4].'|'.$l[5].'|'.$l[6].'|'.$l[7].'|'.$l[8].'|'.$l[9].'|'.$l[10].'|'.$l[11].'|'.$l[12].'|'.$l[13].'|'.$l[14].'|'.$l[15].'|'.$l[16].'|'.$l[17].'|'.$l[18].'|'.$l[19].'|'.$l[20].'|'.$l[21].'|'.$l[22].'|'.$l[23];
	}
	//
	
	$dadosfile['arquivo_1'] = array_unique($dadosfile['arquivo_unico']);
	//
	sort($dadosfile['arquivo_1']);
	sort($dadosfile['arquivo_2']);
	//exit;
	foreach($dadosfile['arquivo_1'] as $key=>$value){
		//echo $value.'<Br>';
		$linha=explode('|',$value);
		$data[$linha[0]]['soma_item']=0;
		$data[$linha[0]]['referencia_item']='';
		$data[$linha[0]]['codigo']=substr(str_pad($linha[0], 12), 0, 12);
		$data[$linha[0]]['nome']=strtoupper(substr(str_pad($linha[2], 35), 0, 35));
		$data[$linha[0]]['logradouro']=strtoupper(substr(str_pad($linha[3], 45), 0, 45));
		if(is_numeric($linha[4])){
			$num=$linha[4];
		}else{
			$num=0;
		}
		$data[$linha[0]]['numero']=strtoupper(substr(str_pad($num, 5, "0", STR_PAD_LEFT), 0, 5));
		$data[$linha[0]]['complementos']=strtoupper(substr(str_pad($linha[5], 15), 0, 15));
		$data[$linha[0]]['bairro']=strtoupper(substr(str_pad($linha[6], 15), 0, 15));
		$data[$linha[0]]['cidade']=strtoupper(substr(str_pad($linha[7], 30), 0, 30));
		$data[$linha[0]]['uf']=strtoupper(substr(str_pad($linha[8], 2), 0, 2));
		$data[$linha[0]]['cep']=str_replace($chars, "", $linha[9]);
		if($linha[10]!=''){
			$cpf_cnpj=str_replace($chars, "", $linha[10]);
		}else if($linha[12]!=''){
			$cpf_cnpj=str_replace($chars, "", $linha[12]);
		}
		if($linha[10]!=''){
			$ie_rg=str_replace($chars, "", $linha[11]);
		}else if($linha[13]!=''){
			$ie_rg=str_replace($chars, "", $linha[13]);
		}
		$data[$linha[0]]['cpf_cnpj']=substr(str_pad($cpf_cnpj, 14, "0", STR_PAD_LEFT), 0, 14);
		$data[$linha[0]]['ie_rg']=substr(str_pad($ie_rg, 14), 0, 14);
		$data[$linha[0]]['vencimento']=substr($linha[14], 0, 14);
		$data[$linha[0]]['modelo']=$linha[15];
		$data[$linha[0]]['cfop']=$linha[16];
		$data[$linha[0]]['telefone']=substr(str_pad(str_replace($chars, "", $linha[17]), 12, "0", STR_PAD_LEFT), 0, 12);
		$data[$linha[0]]['email']=$linha[18];
		$data[$linha[0]]['tipo_assinante']=$linha[20];
		$data[$linha[0]]['tipo_utilizacao']=$linha[21];
		$data[$linha[0]]['data_emissao']=str_replace($chars, "", converterDataSimples($linha[22]));
		$data[$linha[0]]['data_prestacao']=str_replace($chars, "", converterDataSimples($linha[23]));
		if($numNF){
			$nnf=$num_nf;
		}else{
			$nnf=$key+1;
		}
		$num_final_nf=$nnf;
		//echo $key.'-'.$linha[0].'-'.$nnf.'<br>';
		$data[$linha[0]]['numero_nf']=substr(str_pad($nnf, 9, "0", STR_PAD_LEFT), 0, 9);
		//
		if($numNF)
			$num_nf++;
	}
	//
	$valorTotalNf=0;
	foreach($dadosfile['arquivo_2'] as $key=>$value){
		$linha=explode('|',$value);
		//$totalData[$linha[0]]+=
		$dataItem[$key]['codigo']=$linha[0];
		$dataItem[$key]['classificacao']=substr(str_pad($linha[1], 4, "0", STR_PAD_LEFT), 0, 4);
		$dataItem[$key]['codigo_item']=substr(str_pad($linha[1], 10), 0, 10);
		$dataItem[$key]['descricao']=strtoupper(substr(str_pad($linha[2], 40), 0, 40));
		$dataItem[$key]['valor']=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $linha[3]), 2, '', '')), 11, "0", STR_PAD_LEFT), 0, 11);
		$dataItem[$key]['icms']=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $linha[4]), 2, '', '')), 11, "0", STR_PAD_LEFT), 0, 11);
		$dataItem[$key]['deducao']=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $linha[5]), 2, '', '')), 11, "0", STR_PAD_LEFT), 0, 11);
		$dataItem[$key]['unidade']=strtoupper(substr(str_pad($linha[6], 6), 0, 6));
		$dataItem[$key]['qtd_contratada']=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $linha[7]), 3, '', '')), 11, "0", STR_PAD_LEFT), 0, 11);
		$dataItem[$key]['qtd_prestada']=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $linha[8]), 3, '', '')), 11, "0", STR_PAD_LEFT), 0, 11);
		$dataItem[$key]['alicota_icms']=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $linha[9]), 2, '', '')), 4, "0", STR_PAD_LEFT), 0, 4);
		$data[$linha[0]]['total']+=str_replace(",", ".", $linha[3]);
		$valorTotalNf+=str_replace(",", ".", $linha[3]);
		$data[$linha[0]]['icms_destacado']+=str_replace(",", ".", $linha[4]);
		$data[$linha[0]]['item']=substr(str_pad(str_replace($chars, "", $linha[9]), 3, "0", STR_PAD_LEFT), 0, 3);
		if($data[$linha[0]]['referencia_item']==''){
			$data[$linha[0]]['referencia_item']=substr(str_pad(str_replace($chars, "", ($key+1)), 9, "0", STR_PAD_LEFT), 0, 9);
		}
		$dataItem[$key]['item']=substr(str_pad(str_replace($chars, "", ($data[$linha[0]]['soma_item']+1)), 3, "0", STR_PAD_LEFT), 0, 3);
		$data[$linha[0]]['soma_item']++;
		//echo 'L7:'.$dataItem[$key]['qtd_contratada'].' -L8:'.$dataItem[$key]['qtd_prestada'].'<br>';
	}
	//exit;
//	print_r($data);
//	echo "<Br>";
//	print_r($dataItem);
//	exit;
	$id_nfempresa=isset($_REQUEST["id_nfempresa"]) ? $_REQUEST["id_nfempresa"] : false;
	$mes = isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
	$ano = isset($_REQUEST["ano"]) ? $_REQUEST["ano"] : false;
	$UF='MS';
	$SERIE='001';
	if($mes)
		$MES=$mes;
	else
		$MES=date('m');
	//
	if($ano)
		$ANO=substr($ano,-2);
	else
		$ANO=date('y');
	//
	$STATUS='N';
	$VOLUME='001';
	$pasta='files_out/';
	$qtd_notas_canceladas=0;
	
	//ARQUIVO MESTRE
	$dadosM='';
	$qtd_itens_mestre=0;
	$valor_total=0;
	$valor_total_bc=0;
	//
	foreach($data as $value){
		$campo=array();
		$campo[1]=$value['cpf_cnpj']; // CPF OU CNPJ - 14
		$campo[2]=$value['ie_rg']; // IE OU RG - 14
		$campo[3]=$value['nome']; // RAZÃO SOCIAL OU NOME - 35
		$campo[4]=$value['uf']; // UF - 2
		$campo[5]=$value['tipo_assinante']; // TIPO ASSINANTE (1-comercial,2-governo,3-residencial) - 1
		$campo[6]=$value['tipo_utilizacao']; // TIPO UTILIZAÇÃO (1-telefonia,2-comunicação de dados,3-tv por assinatura,4-provimento de acesso a internet,5-multimidia,6-outros) - 1
		$campo[7]='00'; // grupo de tensão - 2
		$campo[8]=$value['codigo']; // codigo do assinante - 12
		$campo[9]=$ano.$mes.substr($value['data_emissao'],-2); // data de emissão ano/mes/dia - 8
		$campo[10]=$value['modelo']; // MODELO - 2
		$campo[11]=$SERIE; // SERIE - 3
		$campo[12]=$value['numero_nf']; // NÚMERO - 9
		$campo[14]=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $value['total']), 2, '', '')), 12, "0", STR_PAD_LEFT), 0, 12); // VALOR TOTAL - 12
		$campo[15]=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $value['total']), 2, '', '')), 12, "0", STR_PAD_LEFT), 0, 12); // BC ICMS - 12
		$campo[16]=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $value['icms_destacado']), 2, '', '')), 12, "0", STR_PAD_LEFT), 0, 12); // ICMS DESTACADO - 12
		$campo[17]='000000000000'; // ISENTAS OU NAO TRIBUTADAS - 12
		$campo[18]='000000000000'; // OUTROS VALORES - 12
		$campo[19]='N'; // SITUAÇÃO - 1
		$campo[20]=$ANO.$MES; // REFERENCIA mes/ano - 4
		$campo[21]=$value['referencia_item']; // referencia ao item da nota - 9
		$campo[22]='            '; // numero da conta de consumo - 12
		$campo[23]='     '; // brancos - 5
		$campo[13]=strtoupper(md5($campo['1'].$campo['12'].$campo['14'].$campo['15'].$campo['16'])); // CODIGO AUTENTICAÇÃO MD5(1,12,14,15,16) - 32
		$campo[24]=strtoupper(md5($campo['1'].$campo['2'].$campo['3'].$campo['4'].$campo['5'].$campo['6'].$campo['7'].$campo['8'].$campo['9'].$campo['10'].$campo['11'].$campo['12'].$campo['13'].$campo['14'].$campo['15'].$campo['16'].$campo['17'].$campo['18'].$campo['19'].$campo['20'].$campo['21'].$campo['22'].$campo['23'])); // CODIGO AUTENTICAÇÃO MD5(todos) - 32
		if($qtd_itens_mestre==0){
			$data_primeiro_doc=$campo[9];
			$num_primeiro_doc=$campo[12];
		}else{
			$data_ultimo_doc=$campo[9];
			$num_ultimo_doc=$campo[12];
		}
		//
		$valor_total+=$value['total'];
		$valor_total_bc+=$value['total'];
		ksort($campo);
		foreach ($campo as $value) {
			$dadosM.=$value;
		}
		$dadosM.="\r\n";
		$qtd_itens_mestre++;
	}
	//echo $dadosM;
	//exit;
	$nomeFileM=$pasta.$REF.'_'.$UF.$SERIE.$ANO.$MES.$STATUS.'M.'.$VOLUME;
	$nomeFinalM=$UF.$SERIE.$ANO.$MES.$STATUS.'M.'.$VOLUME;
	// Abre ou cria o arquivo bloco1.txt
	if(file_exists($nomeFileM)){
		unlink($nomeFileM); // aqui apaga
	}
	// "a" representa que o arquivo é aberto para ser escrito
	$fp1 = fopen($nomeFileM, "a");
	// Escreve "exemplo de escrita" no bloco1.txt
	$escreve = fwrite($fp1, $dadosM);
	// Fecha o arquivo
	fclose($fp1);
	//
	// ARQUIVO ITEM
	$valor_icms=0;
	$dadosI='';
	foreach($dataItem as $value){
		$campo=array();
		$campo[1]=$data[$value['codigo']]['cpf_cnpj']; // CPF OU CNPJ - 14
		$campo[2]=$data[$value['codigo']]['uf']; // UF - 2
		$campo[3]=$data[$value['codigo']]['tipo_assinante']; // TIPO ASSINANTE (1-comercial,2-governo,3-residencial) - 1
		$campo[4]=$data[$value['codigo']]['tipo_utilizacao']; // TIPO UTILIZAÇÃO (1-telefonia,2-comunicação de dados,3-tv por assinatura,4-provimento de acesso a internet,5-multimidia,6-outros) - 1
		$campo[5]='00'; // grupo de tensão - 2
		$campo[6]=$ano.$mes.substr($data[$value['codigo']]['data_emissao'],-2); // data de emissão ano/mes/dia - 8
		$campo[7]=$data[$value['codigo']]['modelo']; // MODELO - 2
		$campo[8]=$SERIE; // SERIE - 3
		$campo[9]=$data[$value['codigo']]['numero_nf']; // NÚMERO - 9
		$campo[10]=$data[$value['codigo']]['cfop']; // CFOP(5307=PF/5303=PJ) - 4
		$campo[11]=$value['item']; // ITEM - 3
		$campo[12]=$value['codigo_item']; // codigo do serviço - 10
		$campo[13]=$value['descricao']; // DESCRIÇÃO - 40
		$campo[14]=$value['classificacao']; // CODIGO DE CLASSIFICAÇÃO DO ITEM - 4
		$campo[15]=$value['unidade']; // UNIDADE - 6
		$campo[16]=$value['qtd_contratada']; // QUANTIDADE CONTRATADA - 11
		$campo[17]=$value['qtd_prestada']; // QUANTIDADE PRESTADA - 11
		$campo[18]=$value['valor']; // TOTAL - 11
		$campo[19]='00000000000'; // DESCONTO - 11
		$campo[20]='00000000000'; // ACRESCIMOS - 11
		$campo[21]=$value['valor']; // BC ICMS - 11
		$campo[22]=$value['icms']; // ICMS - 11
		$campo[23]='00000000000'; // ISENTAS OU NAO TRIBUTADAS - 11
		$campo[24]='00000000000'; // OUTROS VALORES - 11
		$campo[25]=$value['alicota_icms']; // ALICOTA ICMS - 4
		$campo[26]='N'; // SITUAÇÃO - 1
		$campo[27]=$ANO.$MES; // REFERENCIA mes/ano - 4
		$campo[28]='     '; // brancos - 5
		$campo[29]=strtoupper(md5($campo[1].$campo[2].$campo[3].$campo[4].$campo[5].$campo[6].$campo[7].$campo[8].$campo[9].$campo[10].$campo[11].$campo[12].$campo[13].$campo[14].$campo[15].$campo[16].$campo[17].$campo[18].$campo[19].$campo[20].$campo[21].$campo[22].$campo[23].$campo[24].$campo[25].$campo[26].$campo[27].$campo[28])); // CODIGO AUTENTICAÇÃO MD5(todos) - 32
		if($valor_icms=0){
			$valor_icms=$value['icms'];
		}
		ksort($campo);
		foreach ($campo as $value) {
			$dadosI.=$value;
		}
		$dadosI.="\r\n";
	}
	//echo $dadosI;
	//exit;
	$nomeFileI=$pasta.$REF.'_'.$UF.$SERIE.$ANO.$MES.$STATUS.'I.'.$VOLUME;
	$nomeFinalI=$UF.$SERIE.$ANO.$MES.$STATUS.'I.'.$VOLUME;
	// Abre ou cria o arquivo bloco1.txt
	if(file_exists($nomeFileI)){
		unlink($nomeFileI); // aqui apaga
	}
	// "a" representa que o arquivo é aberto para ser escrito
	$fp2 = fopen($nomeFileI, "a");
	// Escreve "exemplo de escrita" no bloco1.txt
	$escreve = fwrite($fp2, $dadosI);
	// Fecha o arquivo
	fclose($fp2);
	//
	// ARQUIVO DADOS
	$dadosD='';
	foreach($data as $value){
		$campo=array();
		$campo[1]=$value['cpf_cnpj']; // CPF OU CNPJ - 14
		$campo[2]=$value['ie_rg']; // IE OU RG - 14
		$campo[3]=$value['nome']; // RAZÃO SOCIAL OU NOME - 35
		$campo[4]=$value['logradouro']; // LOGRADOURO - 45
		$campo[5]=$value['numero']; // NUMERO - 5
		$campo[6]=$value['complementos']; // COMPLEMENTOS - 15
		$campo[7]=$value['cep']; // CEP - 8
		$campo[8]=$value['bairro']; // BAIRRO - 15
		$campo[9]=$value['cidade']; // CIDADE - 30
		$campo[10]=$value['uf']; // UF - 2
		$campo[11]=$value['telefone']; // TELEFONE - 12
		$campo[12]=$value['codigo']; // CODIGO DO ASSINANTE - 12
		$campo[13]='            '; // numero da conta de consumo - 12
		$campo[14]=$value['uf']; // UF - 2
		$campo[15]='     '; // brancos - 5
		$campo[16]=strtoupper(md5($campo[1].$campo[2].$campo[3].$campo[4].$campo[5].$campo[6].$campo[7].$campo[8].$campo[9].$campo[10].$campo[11].$campo[12].$campo[13].$campo[14].$campo[15])); // CODIGO AUTENTICAÇÃO MD5(todos) - 32
		foreach ($campo as $value) {
			$dadosD.=$value;
		}
		$dadosD.="\r\n";
	}
	
	$nomeFileD=$pasta.$REF.'_'.$UF.$SERIE.$ANO.$MES.$STATUS.'D.'.$VOLUME;
	$nomeFinalD=$UF.$SERIE.$ANO.$MES.$STATUS.'D.'.$VOLUME;
	// Abre ou cria o arquivo bloco1.txt
	if(file_exists($nomeFileD)){
		unlink($nomeFileD); // aqui apaga
	}
	// "a" representa que o arquivo é aberto para ser escrito
	$fp3 = fopen($nomeFileD, "a");
	// Escreve "exemplo de escrita" no bloco1.txt
	$escreve = fwrite($fp3, $dadosD);
	// Fecha o arquivo
	fclose($fp3);
	//echo "<br>";
	//
	if($id_nfempresa){
		// ARQUIVO CONTROLE
		$dadosC='';
		$resultadoDados = mysql_query("SELECT * FROM nf_empresa WHERE id_nfempresa='".$id_nfempresa."' 
		") or die ("Não foi possível realizar a consulta ao banco de dados Empresa");
		if (mysql_num_rows($resultadoDados) == 1){
			$linha_dados=mysql_fetch_object($resultadoDados);
			$campo=array();
			$campo[1]=substr(str_pad($linha_dados->cnpj_nfempresa, 18, "0", STR_PAD_LEFT), 0, 18); // CNPJ - 18
			$campo[2]=substr(str_pad($linha_dados->ie_nfempresa, 15, "0", STR_PAD_LEFT), 0, 15); // IE - 2
			$campo[3]=strtoupper(substr(str_pad($linha_dados->razao_nfempresa, 50), 0, 50)); // RAZAO SOCIAL
			$campo[4]=strtoupper(substr(str_pad($linha_dados->endereco_nfempresa, 50), 0, 50)); // ENDEREÇO
			$campo[5]=strtoupper(substr(str_pad($linha_dados->cep_nfempresa, 9), 0, 9)); // CEP
			$campo[6]=strtoupper(substr(str_pad($linha_dados->bairro_nfempresa, 30), 0, 30)); // BAIRRO
			$campo[7]=strtoupper(substr(str_pad($linha_dados->cidade_nfempresa, 30), 0, 30)); // CIDADE
			$campo[8]=strtoupper(substr(str_pad($linha_dados->uf_nfempresa, 2), 0, 2)); // ESTADO/UF
			$campo[9]=strtoupper(substr(str_pad($linha_dados->responsavel_nfempresa, 30), 0, 30)); // RESPONSAVEL
			$campo[10]=strtoupper(substr(str_pad($linha_dados->cargo_nfempresa, 20), 0, 20)); // CARGO
			$campo[11]=strtoupper(substr(str_pad($linha_dados->telefone_nfempresa, 12), 0, 12)); // TELEFONE
			$campo[12]=strtoupper(substr(str_pad($linha_dados->email_nfempresa, 40), 0, 40)); // EMAIL
			$campo[13]=strtoupper(substr(str_pad($qtd_itens_mestre, 7), 0, 7)); // QUANTIDADE DE REGISTRO DO ARQUIVO MESTRE
			$campo[14]=strtoupper(substr(str_pad($qtd_notas_canceladas, 7), 0, 7)); // QUANTIDADE DE NOTAS CANCELADAS
			$campo[15]=strtoupper(substr(str_pad($data_primeiro_doc, 8), 0, 8)); // DATA EMISSAO PRIMEIRO DODUMENTO FISCAL
			$campo[16]=strtoupper(substr(str_pad($data_ultimo_doc, 8), 0, 8)); // DATA EMISSAO ULTIMO DODUMENTO FISCAL
			$campo[17]=strtoupper(substr(str_pad($num_primeiro_doc, 9), 0, 9)); // NUMERO PRIMEIRO DODUMENTO FISCAL
			$campo[18]=strtoupper(substr(str_pad($num_ultimo_doc, 9), 0, 9)); // NUMERO ULTIMO DODUMENTO FISCAL
			$campo[19]=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $valor_total), 2, '', '')), 14, "0", STR_PAD_LEFT), 0, 14); // VALOR TOTAL
			$campo[20]=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $valor_total_bc), 2, '', '')), 14, "0", STR_PAD_LEFT), 0, 14); // VALOR TOTAL BC ICMS
			$campo[21]=substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $valor_icms), 2, '', '')), 14, "0", STR_PAD_LEFT), 0, 14); // VALOR ICMS
			$campo[22]=$value['icms']; // ICMS - 11
			$campo[23]='00000000000'; // ISENTAS OU NAO TRIBUTADAS - 11
			$campo[24]='00000000000'; // OUTROS VALORES - 11
			$campo[25]=$value['alicota_icms']; // ALICOTA ICMS - 4
			$campo[26]='N'; // SITUAÇÃO - 1
			$campo[27]=$ANO.$MES; // REFERENCIA mes/ano - 4
			$campo[28]='     '; // brancos - 5
			$campo[29]=strtoupper(md5($campo[1].$campo[2].$campo[3].$campo[4].$campo[5].$campo[6].$campo[7].$campo[8].$campo[9].$campo[10].$campo[11].$campo[12].$campo[13].$campo[14].$campo[15].$campo[16].$campo[17].$campo[18].$campo[19].$campo[20].$campo[21].$campo[22].$campo[23].$campo[24].$campo[25].$campo[26].$campo[27].$campo[28])); // CODIGO AUTENTICAÇÃO MD5(todos) - 32
			ksort($campo);
			foreach ($campo as $value) {
				$dadosI.=$value;
			}
			$dadosI.="\r\n";
		}		
	}
	//
//	$result = mysql_query("INSERT INTO nf_notas (datatime_nfnotas, id_user_nfnotas, id_dados_nfnotas, mes_nfnotas, ano_nfnotas, uf_nfnotas, serie_nfnotas, volume_nfnotas, status_nfnotas, num_inicial_nfnotas, num_final_nfnotas, valor_total_nfnotas, file_clien_nfnotas, file_fatp_nfnotas, file_M_nfnotas, file_I_nfnotas, file_D_nfnotas, file_C_nfnotas, file_N_nfnotas)
//		values (NOW(), '$id_usuario', '$id_dados', '$mes', '$ano', '$UF', '$SERIE', '$VOLUME', '$STATUS', '$num_inicial_nf', '$num_final_nf', '$valorTotalNf', '$file_clien', '$file_fatp', '$nomeFileM', '$nomeFileI', '$nomeFileD', '$nomeFileC', '$nomeFileN')
//	");
	//
	$fileMArr=explode("/",$nomeFileM);$fileMArr1=explode("_",$fileMArr[1]);
	$fileFinalM='files_down/'.$fileMArr1[1];
	copy($nomeFileM,$fileFinalM);
	//
	$fileIArr=explode("/",$nomeFileI);$fileIArr1=explode("_",$fileIArr[1]);
	$fileFinalI='files_down/'.$fileIArr1[1];
	copy($nomeFileI,$fileFinalI);
	//
	$fileDArr=explode("/",$nomeFileD);$fileDArr1=explode("_",$fileDArr[1]);
	$fileFinalD='files_down/'.$fileDArr1[1];
	copy($nomeFileD,$fileFinalD);
	//echo $dadosM;
//	require('zip_lib.php');
	//
//	$zipfile = new zipfile(date("d-m-Y").".zip");
	//
//	$zipfile->addFileAndRead($fileFinalM);
//	$zipfile->addFileAndRead($fileFinalI);
//	$zipfile->addFileAndRead($fileFinalD);
	//
//	echo $zipfile->file();
	//echo "valor total: ".substr(str_pad(str_replace($chars, "", number_format(str_replace(",", ".", $valor_total), 2, '', '')), 14, "0", STR_PAD_LEFT), 0, 14);
	//*/
	//
}else{
	print("<script language='javascript'>window.location = 'index.php?error=$error'</script>");
}
?>