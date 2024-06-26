<?php
include_once("../_validar.php");
if($authSession){
	$id_cliente = isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
	$cpf_cnpj= "SELECT cpf_cnpj_clientesfc FROM fc_clientes WHERE id_clientesfc='".$id_cliente."'";
	$nome_cliente="SELECT nome_clientesfc FROM fc_clientes WHERE id_clientesfc='".$id_cliente."'";
	$nome_provedor=$provedor_usuario;
	$auth=true;
}else{
	$nomeSession='authAdminPG';
	session_name($nomeSession);
	session_start($nomeSession);
	$cpf_cnpj=$_SESSION["cpf_cnpj"];
	$id_cliente=$_SESSION["id_cliente"];
	$auth=$_SESSION["auth"];
	//
	include_once("../_funcoes.php");
}
//
$error = $_REQUEST["error"];
$title = 'BOLETO DE COBRANÇA';
//
if($auth){
	//
	include_once("../_conf.php");
	conecta_mysql();	//concecta no banco myslq
	//
	$data_cobranca = isset($_REQUEST["data"]) ? $_REQUEST["data"] : false;
	$valor_cobranca = isset($_REQUEST["valor"]) ? $_REQUEST["valor"] : false;
	//
	$select="SELECT url_boletosfc FROM fc_boletos WHERE id_clientes_boletosfc='".$id_cliente."' AND valor_boletosfc like '".$valor_cobranca."' AND data_cobranca_boletosfc='".$data_cobranca."' AND (vencido_boletosfc!='on' OR data_vencimento_boletosfc>=CURDATE())";
	$consulta = mysql_query($select); 
	if(mysql_num_rows($consulta)==1) {
		// se o usuario existi verifica a senha dele
		$url_boleto=mysql_fetch_object($consulta)->url_boletosfc;
	}else{
		//require_once($LOCAL_HOME."classes/conf_boletos_facil.php");
		//
		$selectDb="SELECT * FROM `fc_clientes` AS `c`
		INNER JOIN `fc_provedor` AS `p` ON `p`.`id_provedorfc`=`c`.`id_provedor`
		LEFT JOIN `fc_gatewaypg` AS `g` ON `g`.`id_provedor`=`p`.`id_provedorfc` AND `g`.`padrao_gatewaypgfc`='on'
		WHERE `c`.`id_clientesfc`=$id_cliente";
		echo $selectDb;
		$resultadoDados = mysql_query($selectDb) or die ("Não foi possível realizar a consulta ao banco de dados linha 34");
		$linha_dados=mysql_fetch_object($resultadoDados);
		if(mysql_num_rows($resultadoDados)==1){
			$dados_boleto=salvarBoletos($linha_dados,$data_cobranca,$valor_cobranca,'',1);
			//print_r($dados_boleto);
			$url_boleto=$dados_boleto[0]['url_boletosfc'];
		}else 
			$url_boleto='';
		//print_r($dados_boleto);
		if($url_boleto!=''){
			// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
			include_once($LOCAL_HOME."classes/crud.class.php");
			include_once($LOCAL_HOME."classes/barcode.class.php");
			//
			// GERA CLASSE DA(S) TABELA(S) USADA(S)
			class Boletos_conf extends simpleCRUD{
				protected $__table = "fc_boletos";
				protected $__id = "id_boletosfc";
			}
			//
			foreach ($dados_boleto as $key => $value){
				$field_boletos = Boletos_conf::find_by_field();
				$new_linha_boletos = new Boletos_conf();
				foreach ($field_boletos as $id){
					if (strpos($id, "datatime_") !== false) {
						$dados_boleto[$key][$id]=date('Y-m-d H:i:s');
					}
					$new_linha_boletos->$id=utf8_decode($dados_boleto[$key][$id]);
				}
				$new_linha_boletos->insert();
				$id_boletos.=$new_linha_boletos->id."|";
			}
			//
		}
	}
	if($url_boleto!='')
		print("<script language='javascript'>window.location = '".$url_boleto."'</script>");
	else 
		echo '<center><font color=red>ERROR AO GERAR BOELETO:URL INVÁLIDA<br>'.$dados_boleto[0]['error_boletosfc'].'</font></center>';
}else{
	echo '<center><font color=red>ERROR AO GERAR BOELETO:CPF OU CONTA INVÁLIDA</font></center>';
}