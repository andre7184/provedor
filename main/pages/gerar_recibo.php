<?php
include("../_conf.php");
$id_recibo = isset($_REQUEST["id_recibo"]) ? $_REQUEST["id_recibo"] : false;
$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
$referente= isset($_REQUEST["referente"]) ? $_REQUEST["referente"] : false;
$valor = isset($_REQUEST["valor"]) ? $_REQUEST["valor"] : false;
$select = new PDO_instruction();
$select->con_pdo();
$recibo = $select->select_pdo('SELECT * FROM fcv_recibos WHERE md5recibo_recibofc = ?', array($id_recibo))[0];
if($recibo['id_provedor']>0){
	if(!$tipo)
		$tipo='html';
	//
	if(!$valor && !$referente){
		$valor=$recibo['valor_recibofc'];
		$referente=$recibo['referente_recibofc'];
	}
	$texto_documentos=$recibo['provedorlayout_recibofc'];
	$data = array(
			'grupo' => $recibo['grupo_recibofc']
			,'numero' => $recibo['numero_recibofc']
			,'provedornome' => $recibo['provedornome_recibofc']
			,'provedorend1' => $recibo['provedorend_recibofc']
			,'provedorcnpj' => $recibo['provedorcnpj_recibofc']
			,'provedortel1' => $recibo['provedortel1_recibofc']
			,'provedoremail' => $recibo['provedoremail_recibofc']
			,'provedorsite' => $recibo['provedorsite_recibofc']
			,'nome' => 'RECIBO '.$recibo['numero_recibofc']
			,'valor' => $valor
			,'nomecliente' => $recibo['nomecliente_recibofc']
			,'cpfcnpjcliente' => $recibo['cpfcnpjcliente_recibofc']
			,'valorextenso' => valorPorExtenso($valor)
			,'descricao' => $referente
			,'data' => $recibo['data_recibofc']
			,'tiporecebimento' => $recibo['tiporecebimento_recibofc']
			,'md5recibo' => $recibo['md5recibo_recibofc']
			,'nomerecebedor' => $recibo['localrecebimento_recibofc']
	);
	while ( list( $key, $value ) = each( $data )){
		if ( preg_match( '/\%' . $key . '\%/i', $texto_documentos )){
			$texto_documentos = preg_replace( '/\%' . $key . '\%/', $value, $texto_documentos );
		}
	}
	if($tipo=='html'){
		echo $texto_documentos;
	}else if($tipo=='pdf'){
		include_once( "../_MPDF57/mpdf.php");
		$mpdf=new mPDF();
		//$mpdf->WriteHTML(utf8_encode($texto_documentos));
		$mpdf->WriteHTML($texto_documentos);
		$mpdf->Output();
	}
}