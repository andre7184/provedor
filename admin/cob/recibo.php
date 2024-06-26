<?php 
//IMPORTA SITE SEGURO
require("../_validar.php");
//
$auth=false;
if($authSession){
	$auth=true;
	$id_cliente = isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
}else{
	$nomeSession='authAdminPG';
	session_name($nomeSession);
	session_start($nomeSession);
	//
	if($_SESSION["auth"]){
		$auth=true;
		$id_cliente=$_SESSION["id_cliente"];
	}
}
if($auth){
	//
	include_once( "../_funcoes.php");
	$error = $_REQUEST["error"];
	//
	include_once( "../_conf.php");
	conecta_mysql();	//concecta no banco myslq
	//
	$title = 'RECIBO DE PAGAMENTO';
	//
	$id_caixafc = isset($_REQUEST["id_caixafc"]) ? $_REQUEST["id_caixafc"] : false;
	$md5_recibo = isset($_REQUEST["md5_recibo"]) ? $_REQUEST["md5_recibo"] : false;
	$nome_recibo = isset($_REQUEST["nome_recibo"]) ? $_REQUEST["nome_recibo"] : false;
	$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : 'html';
	//
	if($id_caixafc){
		$busca="`ca`.`id_caixafc`='$id_caixafc' AND";
		$nome_recibo=$id_caixafc;
	}else if($md5_recibo){
		$busca="MD5(CONCAT(`ca`.`id_caixafc`,`ca`.`valor_caixafc`,`ca`.`data_pagamento_caixafc`,`cl`.`id_clientesfc`,`ca`.`id_provedor`))='$md5_recibo' AND";
		$nome_recibo=$md5_recibo;
	}else{
		$busca="`ca`.`id_cliente_caixafc`='$id_cliente' AND";
		$nome_recibo=$id_cliente;
	}
	
	$select="SELECT 
	`ca`.`id_caixafc` AS numero_recibofc,
	`pr`.`nome_provedorfc` AS provedornome_recibofc,
	CONCAT(`pr`.`endereco1_provedorfc`,',',`pr`.`numero1_provedorfc`,' ',`pr`.`complemento1_provedorfc`,' - ',`pr`.`bairro1_provedorfc`) AS provedorend1_recibofc,
	CONCAT(`pr`.`cep1_provedorfc`,' - ',`pr`.`cidade1_provedorfc`,'-',`pr`.`uf1_provedorfc`) AS provedorend2_recibofc,
	`pr`.`cpf_cnpj_provedorfc` AS provedorcnpj_recibofc,
	`pr`.`telefone_provedorfc` AS provedortel1_recibofc,
	`pr`.`telefone2_provedorfc` AS provedortel2_recibofc,
	`pr`.`email_provedorfc` AS provedoremail_recibofc,
	`pr`.`site_provedorfc` AS provedorsite_recibofc,
	`ca`.`valor_caixafc` AS valor_recibofc,
	`cl`.`nome_clientesfc` AS nomecliente_recibofc,
	`cl`.`cpf_cnpj_clientesfc` AS cpfcnpjcliente_recibofc,
	`ca`.`data_pagamento_caixafc` AS data_recibofc,
	`ca`.`data_credito_caixafc` AS data_credito_recibofc,
IF(`ca`.`data_pagamento_caixafc`!=`ca`.`data_credito_caixafc`,CONCAT(IFNULL(`ca`.`especie_caixafc`,`ca`.`origem_caixafc`),' para ',`ca`.`data_credito_caixafc`),IFNULL(`ca`.`especie_caixafc`,`ca`.`origem_caixafc`)) AS tiporecebimento_recibofc,
	`ca`.`origem_caixafc` AS localrecebimento_recibofc,
	`ca`.`user_login` AS nomerecebedor_recibofc,
	`pr`.`texto_recibo_provedorfc` AS modelo_recibofc,
	`ca`.`id_provedor` AS id_provedor,
	MD5(CONCAT(`ca`.`id_caixafc`,`ca`.`valor_caixafc`,`ca`.`data_pagamento_caixafc`,`cl`.`id_clientesfc`,`ca`.`id_provedor`)) AS md5recibo_recibofc
  	FROM `fc_caixa` AS `ca`
  	INNER JOIN `fc_clientes` AS `cl` ON `cl`.`id_clientesfc`=`ca`.`id_cliente_caixafc`
   	INNER JOIN `fc_provedor` AS `pr` ON `pr`.`id_provedorfc`=`ca`.`id_provedor`
  	WHERE $busca `ca`.`valor_caixafc` > 0
	ORDER BY `ca`.`id_caixafc` DESC";
	//echo $select;
	$resultadoDados = mysql_query($select) or die ("N�o foi poss�vel realizar a consulta ao banco de dados linha 34");
	$linha_dados=mysql_fetch_object($resultadoDados);
	if(mysql_num_rows($resultadoDados)==1){
		$descricao='Pagamento de cobrança(s) ou título(s).';
		$texto_documentos=$linha_dados->modelo_recibofc;
		//numero,provedornome,provedorend,provedorcnpj,provedortel1,provedortel2,provedoremail,provedorsite,nome,
		//valor,nomecliente,cpfcnpjcliente,valorextenso,descricao,data,tiporecebimento,md5recibo,nomerecebedor;
		$data = array(
			'grupo' => 'http://provedor.uvsat.com/_pvs/66665770/imgs/logo_provedor.png'
			,'numero' => $linha_dados->numero_recibofc
			,'provedornome' => $linha_dados->provedornome_recibofc
			,'provedorendl1' => $linha_dados->provedorend1_recibofc
			,'provedorendl2' => $linha_dados->provedorend2_recibofc
			,'provedorcnpj' => $linha_dados->provedorcnpj_recibofc
			,'provedortel1' => $linha_dados->provedortel1_recibofc
			,'provedortel2' => $linha_dados->provedortel2_recibofc
			,'provedoremail' => $linha_dados->provedoremail_recibofc
			,'provedorsite' => $linha_dados->provedorsite_recibofc
			,'nome' => 'RECIBO '.$nome_recibo
			,'valor' => number_format($linha_dados->valor_recibofc, 2, ',', '.')
			,'nomecliente' => $linha_dados->nomecliente_recibofc
			,'cpfcnpjcliente' => $linha_dados->cpfcnpjcliente_recibofc
			,'valorextenso' => valorPorExtenso($linha_dados->valor_recibofc)
			,'descricao' => $descricao
			,'data' => mostrarDataSimples($linha_dados->data_recibofc)
			,'tiporecebimento' => $linha_dados->tiporecebimento_recibofc
			,'md5recibo' => $linha_dados->md5recibo_recibofc
			,'nomerecebedor' => $linha_dados->nomerecebedor_recibofc
			,'EMPRESA' => ''
		);
		while ( list( $key, $value ) = each( $data )){
			if ( preg_match( '/\%' . $key . '\%/i', $texto_documentos )){
				$texto_documentos = preg_replace( '/\%' . $key . '\%/', $value, $texto_documentos );
			}
		}
		if($tipo=="email"){
			$email = isset($_REQUEST["email"]) ? $_REQUEST["email"] : false;
			if($email){
				$fileName="../recibos/pdf_".$nome_recibo.".pdf";
				include_once( "../_MPDF57/mpdf.php");
				$mpdf=new mPDF();
				//$mpdf->WriteHTML(utf8_encode($texto_documentos));
				$mpdf->WriteHTML(utf8_encode($texto_documentos));
				$mpdf->Output($fileName,'F');
				$retorno=sendMail('','','','','','','',$email,'Segue recibo em anexo.','RECIBO DE PAGAMENTO - UVSAT INFORMATICA',$fileName.';');
				if($retorno)
					echo '<center><h2>Email enviado com sucesso!</h2></center>';
				else 
					echo "<center><h2>$retorno</h2></center>";
				//
			}
		}else if($tipo=="pdf"){
			include_once( "../_MPDF57/mpdf.php");
			$mpdf=new mPDF();
			//$mpdf->WriteHTML(utf8_encode($texto_documentos));
			$mpdf->WriteHTML(utf8_encode($texto_documentos));
			$mpdf->Output();
		}else if($tipo=="html"){
			echo $texto_documentos;
		}
	}else 
		echo '<center><font color=red>ERROR AO GERAR BOELETO:PAGAMENTO INV�LIDO OU INEXISTENTE</font></center>';
}else{
	echo '<center><font color=red>ERROR AO GERAR BOELETO:CPF OU CONTA INV�LIDA</font></center>';
}