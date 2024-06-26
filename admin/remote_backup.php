<?php 
//importa funçoes
$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
$query = isset($_REQUEST["query"]) ? $_REQUEST["query"] : false;
$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
$LOCAL_HOME='/home/provedor/';
include_once($LOCAL_HOME."classes/funcoes_novas.php");
//IMPORTA SITE SEGURO
require_once("validar.php");
if($authSession){
	// get command 
	//
	include_once($LOCAL_HOME."classes/conf_facil.php");
	conecta_mysql();	//concecta no banco myslq
	//
	$chars = array('(', ')', '-');
	//
	switch($cmd) {
		case "dados_html": //
			$page = isset($_REQUEST["page"]) ? $_REQUEST["page"] : false;
			$link = isset($_REQUEST["link"]) ? $_REQUEST["link"] : false;
			$activ;
			switch($page) {
				case "home":
					$listaMenu='<li data-role="list-divider">Opções</li>
						<li><a href="#ConfigurarProvedor" onclick="openPg(\'dados_provedor\')">Provedor</a></li>
						<li><a href="#ConfigurarBanco" onclick="openPg(\'dados_banco\')">Bancos/Boletos</a></li>
						<li><a href="#">Usuário/Acessos</a></li>
						<li><a href="#">Site/HomePage</a></li>';
					//
					$activ[home]=true;
					$title='Pagina Inicial';
				break;
				case "contas":
					$listaMenu='<li data-role="list-divider">Opções</li>
						<li><a href="#ConfigurarCliente" >Cadastrar Cliente</a></li>
						<li><a href="#ListarCliente" onclick="onLoadLista()">Listar Clientes</a></li>
						<li><a href="#">Bloqueios</a></li>
						<li><a href="#">Serviços Mensais</a></li>
						<li><a href="#">Usuários Mk</a></li>
						<li><a href="#">Usuários Mk</a></li>';
					//
					$activ[contas]=true;
					$title='Contas/Clientes';
				break;
				case "vendas":
					$listaMenu='<li data-role="list-divider">Opções</li>
						<li><a href="#">Provedor</a></li>
						<li><a href="#">Bancos/Boletos</a></li>
						<li><a href="#">Usuário/Acessos</a></li>
						<li><a href="#">Site/HomePage</a></li>';
					//
					$activ[vendas]=true;
					$title='Serviços/Vendas';
				break;
				case "caixa":
					$listaMenu='<li data-role="list-divider">Opções</li>
						<li><a href="#">Provedor</a></li>
						<li><a href="#">Bancos/Boletos</a></li>
						<li><a href="#">Usuário/Acessos</a></li>
						<li><a href="#">Site/HomePage</a></li>';
					//
					$activ[caixa]=true;
					$title='Financeiro/Caixa';
				break;
				case "logmk":
					$listaMenu='<li data-role="list-divider">Opções</li>
						<li><a href="#">Provedor</a></li>
						<li><a href="#">Bancos/Boletos</a></li>
						<li><a href="#">Usuário/Acessos</a></li>
						<li><a href="#">Site/HomePage</a></li>';
					//
					$activ[logmk]=true;
					$title='Logs Acessos/MK';
				break;
			}
			$htmlnavbar='<div data-role="navbar">
				<ul>
					<li><a href="#" onclick="location.href=\'index.php?page=home\'" '.($activ[home] ? 'class="ui-btn-active"':'').' data-icon="info">Home</a></li>
					<li><a href="#" onclick="location.href=\'index.php?page=contas\'" '.($activ[contas] ? 'class="ui-btn-active"':'').' data-icon="bullets">Contas</a></li>
					<li><a href="#" onclick="location.href=\'index.php?page=vendas\'" '.($activ[vendas] ? 'class="ui-btn-active"':'').' data-icon="shop">Vendas</a></li>
					<li><a href="#" onclick="location.href=\'index.php?page=caixa\'" '.($activ[caixa] ? 'class="ui-btn-active"':'').' data-icon="calendar">Caixa</a></li>
					<li><a href="#" onclick="location.href=\'index.php?page=logmk\'" '.($activ[logmk] ? 'class="ui-btn-active"':'').' data-icon="info">Mk</a></li>
				</ul>
			</div>';
			//
			if(!$link)
				$texto_rodape='<font  size="4"><b>MKFácil</b><br>Gerenciador de Mk</font>';
			else
				$texto_rodape='<center><font  size="4"><b>'.$title.'</b><br>'.$link.'<br></font></center>';
			//
			echo $authSession.'|'.toVarUtf8(preg_replace('/\s/',' ',$htmlnavbar)).'|'.toVarUtf8(preg_replace('/\s/',' ',$texto_rodape)).'|'.toVarUtf8(preg_replace('/\s/',' ',$listaMenu));
		break;
		case "load": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "dados_provedor": //ATUALIZA DADOS NA PAGINA
					$resultadoDados = mysql_query("SELECT * FROM fc_provedor WHERE id_provedorfc='$id_provedor_usuario'
					") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 21"}');
					$qtdLinhas=mysql_num_rows($resultadoDados);
					if ($qtdLinhas == 0){
						echo '{"auth":"'.$authSession.'","data":""}';
					}else{
						$colunas=mysql_fetch_assoc($resultadoDados);
						foreach ($colunas as $id=>$value){
							$value=toVarUtf8($value);
							$linha=true;
							if (strpos($id, "data_") !== false) {
								$value=mostrarDataSimples($value);
							}
							if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false) {
								$linha=false;
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$value=number_format($value, 2, ',', '.');
							}
							if($linha){
								$dados_linhas.='"'.$id.'":"'.$value.'",';
							}
						}
						$dados_linhas=substr($dados_linhas,0,-1);
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
					}
				break;
				case "dados_banco": //ATUALIZA DADOS NA PAGINA
					$id_gatewaypgfc = isset($_REQUEST["id_gatewaypgfc"]) ? $_REQUEST["id_gatewaypgfc"] : false;
					$busca="id_provedor='$id_provedor_usuario'";
					if($id_gatewaypgfc)
						$busca="id_gatewaypgfc='$id_gatewaypgfc'";
					else{
						$col = isset($_REQUEST["col"]) ? $_REQUEST["col"] : false;
						$val = isset($_REQUEST["val"]) ? $_REQUEST["val"] : false;
						if($col && $val){
							$busca=$col."='".$val."'";
						}
					}
					$resultadoDados = mysql_query("SELECT * FROM fc_gatewaypg WHERE $busca
					") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 21"}');
					$qtdLinhas=mysql_num_rows($resultadoDados);
					if ($qtdLinhas == 1){
						$colunas=mysql_fetch_assoc($resultadoDados);
						foreach ($colunas as $id=>$value){
							$value=toVarUtf8($value);
							$linha=true;
							if (strpos($id, "data_") !== false) {
								$value=mostrarDataSimples($value);
							}
							if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false) {
								$linha=false;
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$value=number_format($value, 2, ',', '.');
							}
							if($linha){
								$dados_linhas.='"'.$id.'":"'.$value.'",';
							}
						}
						$dados_linhas=substr($dados_linhas,0,-1);
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
					}else{
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							array_walk($linha_dados, 'toUtf8');
							$dados_linhas.="<option value='".$linha_dados->id_gatewaypgfc."'>".$linha_dados->nome_gatewaypgfc."</option>";
						}
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","id_select":"select_banco",data":"'.$dados_linhas.'"}';
					}
				break;
				case "dados_cliente": //ATUALIZA DADOS NA PAGINA
					$id_clientesfc = isset($_REQUEST["id_clientesfc"]) ? $_REQUEST["id_clientesfc"] : false;
					$busca="id_provedor='$id_provedor_usuario'";
					if($id_clientesfc)
						$busca="id_clientesfc='$id_clientesfc'";
					else{
						$col = isset($_REQUEST["col"]) ? $_REQUEST["col"] : false;
						$val = isset($_REQUEST["val"]) ? $_REQUEST["val"] : false;
						if($col && $val){
							$busca=$col."='".$val."'";
						}
					}
					$select="SELECT * FROM fc_clientes WHERE $busca";
					//echo $select;
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 91"}');
					$qtdLinhas=mysql_num_rows($resultadoDados);
					if ($qtdLinhas == 1){
						$colunas=mysql_fetch_assoc($resultadoDados);
						foreach ($colunas as $id=>$value){
							$value=toVarUtf8($value);
							$linha=true;
							if (strpos($id, "data_") !== false)
								$value=mostrarDataSimples($value);
							//
							if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false)
								$linha=false;
							//
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false)
								$value=number_format($value, 2, ',', '.');
							//
							if($id_clientesfc=='' && $id=='id_clientesfc')
								$id_clientesfc=$value;
							//
							if($linha)
								$dados_linhas.='"'.$id.'":"'.$value.'",';
							//
						}
						$dados_linhas.='"qtd_pontos_clientesfc":"'.mysql_num_rows(mysql_query("SELECT id_pontosfc FROM fc_pontos WHERE id_cliente_pontosfc='$id_clientesfc'")).'"';
						echo '{"auth":"'.$authSession.'","objeto":"","qtd":"'.$qtdLinhas.'","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
					}else{
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							array_walk($linha_dados, 'toUtf8');
							$dados_linhas.="<option value='".$linha_dados->id_gatewaypgfc."'>".$linha_dados->nome_gatewaypgfc."</option>";
						}
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","id_select":"select_banco",data":"'.$dados_linhas.'"}';
					}
				break;
				case "clientes_pontos": //ATUALIZA DADOS NA PAGINA
					$col = isset($_REQUEST["col"]) ? $_REQUEST["col"] : false;
					$val = isset($_REQUEST["val"]) ? $_REQUEST["val"] : false;
					if($col && $val)
						$busca=$col."='".$val."'";
					else
						$busca="id_provedor='$id_provedor_usuario'";
					//
					$n = isset($_REQUEST["n"]) ? $_REQUEST["n"] : false;
					if($n){
						$inicio=(1 * $n) - 1;
    					$order = "ORDER BY id_pontosfc DESC LIMIT $inicio, 1";
					}
					$select="SELECT * FROM fc_pontos AS pt 
					INNER JOIN fc_sevmensal AS sm ON sm.id_cliente_mensalfc=pt.id_cliente_pontosfc
					WHERE $busca $order";
					//echo $select;
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 91"}');
					$qtdLinhas=mysql_num_rows($resultadoDados);
					if ($qtdLinhas == 1){
						$colunas=mysql_fetch_assoc($resultadoDados);
						foreach ($colunas as $id=>$value){
							$value=toVarUtf8($value);
							$linha=true;
							if (strpos($id, "data_") !== false) {
								$value=mostrarDataSimples($value);
							}
							if (strpos($id, "datatime_") !== false OR strpos($id, "texto_") !== false) {
								$linha=false;
							}
							if ($value=='') {
								$linha=false;
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$value=number_format($value, 2, ',', '.');
							}
							if($linha){
								$dados_linhas.='"'.$id.'":"'.$value.'",';
							}
						}
						$dados_linhas=substr($dados_linhas,0,-1);
						if($n<10)
							$n='0'.$n;
						echo '{"auth":"'.$authSession.'","objeto":"ponto_'.$n.'","qtd":"'.$qtdLinhas.'","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
					}else{
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							array_walk($linha_dados, 'toUtf8');
							$dados_linhas.="<option value='".$linha_dados->id_gatewaypgfc."'>".$linha_dados->nome_gatewaypgfc."</option>";
						}
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","id_select":"select_banco",data":"'.$dados_linhas.'"}';
					}
				break;
			}			
		break;
		case "busca": //ATUALIZA DADOS NA PAGINA
			$retorno = isset($_REQUEST["retorno"]) ? $_REQUEST["retorno"] : false;
			switch($tipo) {
				case "cliente": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca="(nome_clientesfc like '%".$query."%' OR cpf_cnpj_clientesfc like '".$query."') AND";
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fc_clientes WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_clientesfc.'"
								,"name":"'.strtr($linha_dados->nome_clientesfc, "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ", "aaaaeeiooouucAAAAEEIOOOUUC").'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "end":
					$cep = isset($_REQUEST["cep"]) ? $_REQUEST["cep"] : false;
					$formato = isset($_REQUEST["formato"]) ? $_REQUEST["formato"] : false;
					$contents = file_get_contents('http://cep.republicavirtual.com.br/web_cep.php?formato='.$formato.'&cep='.$cep);
					echo $contents;
				break;
				case "cep":
					$end = isset($_REQUEST["end"]) ? $_REQUEST["end"] : false;
					$contents = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.str_replace(" ", "+", $end).'&sensor=false');
					echo $contents;
				break;
				case "torre": //ATUALIZA DADOS NA PAGINA
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fc_torre WHERE id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="0">All Torres</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione a torre</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_torrefc.'">'.$linha_dados->nome_torrefc.' (|'.$linha_dados->latitude_torrefc.'|'.$linha_dados->longitude_torrefc.'|)</option>';
						}
					}
				break;
				case "mk": //ATUALIZA DADOS NA PAGINA
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM mk_mikrotiks WHERE codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="">Nenhum Mikrotik</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione o mikrotik</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_mikrotiks.'">'.$linha_dados->identy_mikrotiks." - ".$linha_dados->name_rb_mikrotiks."</option>";
						}
					}
				break;
				case "produto": //ATUALIZA DADOS NA PAGINA
					$int = isset($_REQUEST["int"]) ? $_REQUEST["int"] : false;
					$mensal = isset($_REQUEST["mensal"]) ? $_REQUEST["mensal"] : false;
					$busca='';
					if($mensal)
						$busca.=" mensal_produtosfc='on' AND ";
					//
					if($int)
						$busca.=" internet_produtosfc='on' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="">Nenhum Produt</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione o Produto</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_produtosfc.'">'.$linha_dados->descricao_produtosfc." - R$ ".number_format($linha_dados->valor_produtosfc, 2, ',', '')." (|".$linha_dados->valor_produtosfc."|".$linha_dados->id_profilepp_produtosfc."|".$linha_dados->id_profilehp_produtosfc."|".$linha_dados->id_profilebi_produtosfc."|)</option>";
						}
					}
				break;
				case "pagamentos": //ATUALIZA DADOS NA PAGINA
					$id_caixafc = isset($_REQUEST["id_caixafc"]) ? $_REQUEST["id_caixafc"] : false;
					$data_caixafc = isset($_REQUEST["data_caixafc"]) ? $_REQUEST["data_caixafc"] : false;
					$busca='';
					if($id_caixafc)
						$busca.=" id_caixafc='$id_caixafc' AND ";
					//
					if($data_caixafc)
						$busca.=" data_caixafc='".converterDataSimples($data_caixafc)."' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_caixa WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_caixafc.'"
								,"name":"Pagamento em:'.mostrarDataSimples($linha_dados->data_pagamento_caixafc).' de R$ '.number_format($linha_dados->valor_caixafc, 2, ',', '').'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "secret": //ATUALIZA DADOS NA PAGINA
					$auth = isset($_REQUEST["auth"]) ? $_REQUEST["auth"] : false;
					$mk = isset($_REQUEST["mk"]) ? $_REQUEST["mk"] : false;
					switch($auth) {
						case "pp":
							if($mk)
								$busca=" (mk_secretpp='$mk' OR mk_secretpp='') AND ";
							//
							if($query!='*all')
								$busca.=" name_secretpp like '%".$query."%' AND ";
							//
							$resultadoDados = mysql_query("SELECT id_secretpp AS id, CONCAT(name_secretpp,' - ',mk_secretpp) AS name FROM mk_secretpp WHERE $busca codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
						break;
						case "hp":
							if($mk)
								$busca=" (mk_secrethp='$mk' OR mk_secrethp='') AND ";
							//
							if($query!='*all')
								$busca.=" name_secrethp like '%".$query."%' AND ";
							//
							$resultadoDados = mysql_query("SELECT id_secrethp AS id, CONCAT(name_secrethp,' - ',mk_secrethp) AS name FROM mk_secrethp WHERE $busca codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
						break;
						case "bi":
							if($mk)
								$busca=" (mk_secretbi='$mk' OR mk_secretbi='') AND ";
							//
							if($query!='*all')
								$busca.=" name_secretbi like '%".$query."%' AND ";
							//
							$resultadoDados = mysql_query("SELECT id_secretbi AS id, CONCAT(name_secretbi,' - Mk:',mk_secretbi) AS name FROM mk_secretbi WHERE $busca codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 24"}');
						break;
					}
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id.'"
								,"name":"'.$linha_dados->name.'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
			}
		break;
		case "list": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "facil_vendas": //ATUALIZA DADOS NA PAGINA
					$start = $_REQUEST["start"];
					$limit = $_REQUEST["limit"];
					$id_vendasfc = isset($_REQUEST["id_vendasfc"]) ? $_REQUEST["id_vendasfc"] : false;
					if($id_vendasfc){
						$busca="WHERE id_vendasfc='".$id_vendasfc."' AND id_conta='$conta_usuario'";
					}else{
						$busca_conta="id_conta='$conta_usuario'";
						$all = isset($_REQUEST["all"]) ? $_REQUEST["all"] : false;
						if(!$all){
							$dataHoje = date('Y-m-d H:i:s');
							$diaHoje = date('d');
							$mesHoje = date('m');
							$anoHoje = date('Y');
							$dh=strtotime($anoHoje."-".$mesHoje."-".$diaHoje);
							$dataHhArray=explode(" ",$dataHoje);
							$dataArray=explode("-",$dataHhArray[0]);
							$mes_ano = isset($_REQUEST["mes_ano"]) ? $_REQUEST["mes_ano"] : false;
							$periodo = $_REQUEST['periodo'];
							if($mes_ano){
								$mesAnoArray=explode("/",$mes_ano);
								$mesAtual=$mesAnoArray[0];
								$anoAtual=$mesAnoArray[1];
								$codT=$anoAtual."".$mesAtual;
							}else{
								$diaAtual=$_REQUEST['dia'];
								$mesAtual=$_REQUEST['mes'];
								$anoAtual=$_REQUEST['ano'];
							}
							$data_hoje=$diaHoje.'/'.$mesHoje.'/'.$anoHoje;
							//data anterior
							$diaAntArray=explode("/",SomarData(mostrarDataSimples($data_atual), -1, 0, 0));
							$dia_anterior=$diaAntArray[0].";".$diaAntArray[1].";".$diaAntArray[2].";";
							$diaAnt=$dia_anterior[0];
							$mesAnt=$dia_anterior[1];
							$anoAnt=$dia_anterior[2];
							//data posterior
							$diaPostArray=explode("/",SomarData(mostrarDataSimples($data_atual), +1, 0, 0));
							$dia_posterior=$diaPostArray[0].";".$diaPostArray[1].";".$diaPostArray[2].";";
							$diaPost=$dia_posterior[0];
							$mesPost=$dia_posterior[1];
							$anoPost=$dia_posterior[2];
							//
							if($diaAtual!=''){
								$dataAtual="$diaAtual/$mesAtual/$anoAtual";
								if($periodo=='p'){
									$dataAtual=SomarData($dataAtual, +1, 0, 0);
								}else if($periodo=='a'){
									$dataAtual=SomarData($dataAtual, -1, 0, 0);
								}
								//data atual
								$dataAtualArray=explode("/",$dataAtual);
								$diaA=$dataAtualArray[0];
								$mesA=$dataAtualArray[1];
								$anoA=$dataAtualArray[2];
								//
								$data_atual=$diaA.";".$mesA.";".$anoA.";";
								$busca="WHERE $busca_conta AND datatime_vendasfc = '".converterDataSimples($dataAtual)."'";
								$referencia="DIA ".$dataAtual;
								$texto_filtro=' em dia '.$dataAtual;
							}else{
								if($mesAtual!=''){
									$dataAtual="$diaHoje/$mesAtual/$anoAtual";
									if($periodo=='p'){
										$dataAtual=SomarData($dataAtual, 0, +1, 0);
									}else if($periodo=='a'){
										$dataAtual=SomarData($dataAtual, 0, -1, 0);
									}
									//data atual
									$dataAtualArray=explode("/",$dataAtual);
									$mesA=$dataAtualArray[1];
									$anoA=$dataAtualArray[2];
									//
									$dataPosterior=explode("/",SomarData($dataAtual, 0, +1, 0));
									$data_posterior=";".$dataPosterior[1].";".$dataPosterior[2].";";
									$mesPosterior=$dataPosterior[1];
									$anoPosterior=$dataPosterior[2];
									$data_atual=";".$mesAtual.";".$anoAtual.";";
									//
									$busca="WHERE $busca_conta AND datatime_vendasfc >= '$anoA-$mesA-01' AND datatime_vendasfc < '$anoPosterior-$mesPosterior-01'";
									$referencia="MÊS $mesA/$anoA";
									$codT=$mesA."".$anoA;
									$texto_filtro=' em mês '.$mesA.'/'.$anoA;
								}else{
									if($anoAtual!=''){
										$dataAtual="$diaHoje/$mesHoje/$anoAtual";
										if($periodo=='p'){
											$dataAtual=SomarData($dataAtual, 0, 0, +1);
										}else if($periodo=='a'){
											$dataAtual=SomarData($dataAtual, 0, 0, -1);
										}
										//data atual
										$dataAtualArray=explode("/",$dataAtual);
										$anoA=$dataAtualArray[2];
										//
										$dataPosterior=explode("/",SomarData($dataAtual, 0, 0, +1));
										$data_posterior=";".$dataPosterior[1].";".$dataPosterior[2].";";
										$anoPosterior=$dataPosterior[2];
										$data_atual=";;".$anoAtual.";";
										//
										$busca="WHERE $busca_conta AND datatime_vendasfc >= '$anoA-01-01' AND datatime_vendasfc < '$anoPosterior-01-01'";
										$referencia="ANO $anoA";
										$texto_filtro=' em ano '.$anoA;
									}else{
										$dataAtual="$diaHoje/$mesHoje/$anoHoje";
										//
										if($periodo=='p'){
												$dataAtual=SomarData($dataAtual, 0, +1, 0);
										}else if($periodo=='a'){
											$dataAtual=SomarData($dataAtual, 0, -1, 0);
										}
										//data atual
										$dataAtualArray=explode("/",$dataAtual);
										$mesA=$dataAtualArray[1];
										$anoA=$dataAtualArray[2];
										//
										$anoPArray=explode("/",SomarData($dataAtual, 0, +1, 0));
										$mesPosterior=$anoPArray[1];
										$anoPosterior=$anoPArray[2];
										$data_atual=";".$mesA.";".$anoA.";";
										//
										$busca="WHERE $busca_conta AND datatime_vendasfc >= '$anoA-$mesA-01' AND datatime_vendasfc < '$anoPosterior-$mesPosterior-01'";
										$referencia="MÊS $mesA/$anoA";
										$codT=$anoA."".$mesA;
										$texto_filtro=' em mês '.$mesA.'/'.$anoA;
									}
								}
							}
						}else{
							$busca="WHERE $busca_conta";
							$referencia="Todas";
							$texto_filtro=' em qualquer data';
						}
					}
					$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : false;
					if($sort){
						$chars = array('\\', '//', "|", '*',"!", "#", "$", "^", "&", "*","~", "+", "=", "?", "'", ".", "<", "\'");
						$data = str_replace($chars, "", $sort);
						$data_array = json_decode(utf8_encode($data), true);
						$order=" ORDER BY ".$data_array[0][property]." ".$data_array[0][direction];
					}else{
						$order=" ORDER BY id_vendasfc ASC";
					}
					$select = "SELECT * FROM facil_vendas $busca";
					//echo $select;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						echo '{"auth":"'.$authSession.'","total":"'.$qtdResult.'","texto_filtro":"'.$texto_filtro.'","data":[]}';
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 124"}');
						echo '{"auth":"'.$authSession.'","total":"'.$qtdResult.'","texto_filtro":"'.$texto_filtro.'",
						"data":[';
							$i=0;
							while($linha_dados=mysql_fetch_object($resultadoDados)){
								array_walk($linha_dados, 'toUtf8');
								$i++;
								echo '{
									"id_vendasfc":"'.$linha_dados->id_vendasfc.'"
									,"identificacao_vendasfc":"'.$linha_dados->identificacao_vendasfc.'"
									,"valor_vendasfc":"R$ '. number_format($linha_dados->valor_vendasfc, 2).'"
									,"desconto_vendasfc":"R$ '. number_format($linha_dados->desconto_vendasfc, 2).'"
									,"pago_vendasfc":"R$ '. number_format($linha_dados->pago_vendasfc, 2).'"
									,"data_pg_vendasfc":"'.mostrarDataSimples($linha_dados->data_pg_vendasfc).'"
									,"sit_vendasfc":"'.$linha_dados->sit_vendasfc.'"
								}';
								if($i<mysql_num_rows($resultadoDados))
									echo ",";
							}
						echo ']}';
					}	
				break;
				case "facil_clientes": //ATUALIZA DADOS NA PAGINA
					$start = $_REQUEST["start"];
					$limit = $_REQUEST["limit"];
					$id_vendasfc = isset($_REQUEST["id_vendasfc"]) ? $_REQUEST["id_vendasfc"] : false;
					if($id_vendasfc){
						$busca="WHERE id_clientesfc='".$id_vendasfc."' AND id_conta='$conta_usuario'";
					}else{
						$busca_conta="id_conta='$conta_usuario'";
					}
					$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : false;
					if($sort){
						$chars = array('\\', '//', "|", '*',"!", "#", "$", "^", "&", "*","~", "+", "=", "?", "'", ".", "<", "\'");
						$data = str_replace($chars, "", $sort);
						$data_array = json_decode(utf8_encode($data), true);
						$order=" ORDER BY ".$data_array[0][property]." ".$data_array[0][direction];
					}else{
						$order=" ORDER BY nome_clientesfc ASC";
					}
					$select = "SELECT * FROM facil_clientes $busca";
					//echo $select;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						echo '{"auth":"'.$authSession.'","total":"'.$qtdResult.'","texto_filtro":"'.$texto_filtro.'","data":[]}';
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 247"}');
						echo '{"auth":"'.$authSession.'","total":"'.$qtdResult.'","texto_filtro":"'.$texto_filtro.'",
						"data":[';
							$i=0;
							while($linha_dados=mysql_fetch_object($resultadoDados)){
								array_walk($linha_dados, 'toUtf8');
								$i++;
								echo '{
									"id_clientesfc":"'.$linha_dados->id_clientesfc.'"
									,"datatime_clientesfc":"'.mostrarData($linha_dados->datatime_clientesfc,true).'"
									,"nome_clientesfc":"'.$linha_dados->nome_clientesfc.'"
									,"endereco_clientesfc":"'.$linha_dados->endereco_clientesfc.'"
									,"telefone_clientesfc":"'.$linha_dados->telefone_clientesfc.'"
									,"email_clientesfc":"'.$linha_dados->email_clientesfc.'"
									,"visitas_clientesfc":"'.$linha_dados->visitas_clientesfc.'"
									,"consumo_clientesfc":"'.$linha_dados->consumo_clientesfc.'"
								}';
								if($i<mysql_num_rows($resultadoDados))
									echo ",";
							}
						echo ']}';
					}
				break;
				case "clientes": //ATUALIZA DADOS NA PAGINA
					$start = $_REQUEST["start"];
					$limit = $_REQUEST["limit"];
					$id_clientesfc = isset($_REQUEST["id_clientesfc"]) ? $_REQUEST["id_clientesfc"] : false;
					if($id_vendasfc){
						$busca="WHERE id_clientesfc='".$id_clientesfc."'";
					}else{
						$busca="WHERE id_provedor='$id_provedor_usuario'";
					}
					$sort = isset($_REQUEST["sort"]) ? $_REQUEST["sort"] : false;
					if($sort){
						$chars = array('\\', '//', "|", '*',"!", "#", "$", "^", "&", "*","~", "+", "=", "?", "'", ".", "<", "\'");
						$data = str_replace($chars, "", $sort);
						$data_array = json_decode(utf8_encode($data), true);
						$order=" ORDER BY ".$data_array[0][property]." ".$data_array[0][direction];
					}else{
						$order=" ORDER BY nome_clientesfc ASC";
					}
					$select = "SELECT * FROM fc_clientes $busca";
					//echo $select;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						echo '{"auth":"'.$authSession.'","qtd_total":"0","qtd_atual":"0","texto_filtro":"'.$texto_filtro.'","data":[]}';
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"Não foi possível realizar a consulta ao banco de dados linha 627"}');
						$qtdAtual=mysql_num_rows($resultadoDados);
						echo '{"auth":"'.$authSession.'","qtd_total":"'.$qtdResult.'","qtd_atual":"'.$qtdAtual.'","texto_filtro":"'.$texto_filtro.'",';
						echo '"data":[';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							array_walk($linha_dados, 'toUtf8');
							$i++;
							if($linha_dados->tel1_clientesfc!=''){
								if($linha_dados->wsap1_clientesfc=='on')
									$w1='<img align=\"Absmiddle\" src=\"img/whatsapp.png\">';
								//
								$tel1=$linha_dados->tel1_clientesfc.'(<img align=\"Absmiddle\" src=\"img/oper_'.$linha_dados->op1_clientesfc.'.png\">)'.$w1.' / ';
							}
							if($linha_dados->tel2_clientesfc!=''){
								if($linha_dados->wsap2_clientesfc=='on')
									$w2='<img align=\"Absmiddle\" src=\"img/whatsapp.png\">';
								$tel2=$linha_dados->tel2_clientesfc.'(<img align=\"Absmiddle\" src=\"img/oper_'.$linha_dados->op2_clientesfc.'.png\">)'.$w2.' / ';
							}
							if($linha_dados->tel3_clientesfc!=''){
								if($linha_dados->wsap3_clientesfc=='on')
									$w3='<img align=\"Absmiddle\" src=\"img/whatsapp.png\">';
								$tel3=$linha_dados->tel3_clientesfc.'(<img align=\"Absmiddle\" src=\"img/oper_'.$linha_dados->op3_clientesfc.'.png\">)'.$w3.' / ';
							}
							echo '{
								"id":"'.$linha_dados->id_clientesfc.'"
								,"nome":"'.$linha_dados->nome_clientesfc.'"
								,"telefone1":"'.$tel1.'"
								,"telefone2":"'.$tel2.'"
								,"telefone3":"'.$tel3.'"
								,"email":"'.$linha_dados->email_clientesfc.'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
			}
		break;
		case "save": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "caixa":   //TIPO -> caixa
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( "../../classes/crud.class.php");
					//
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "fc_caixa";
						protected $__id = "id_caixafc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_caixafc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_caixafc']);
						if ($Facil_item !== false){
							foreach ($Facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										if($var[$id] != '')
											$var[$id]=converterDataSimples($var[$id]);
										//
										if ($id=="data_pagamento_caixafc" && $var[$id] == '')
											$var[$id]=date('Y-m-d');
										//
									}else
										$var[$id] = str_replace($chars, "", $var[$id]);
									//
									$var[$id] = str_replace($chars, "", $var[$id]);
									$Facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$Facil_item->update();
							//
							$msg="atualizado";
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item::find_by_field();
						$new_itens = new Facil_item();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}else if (strpos($id, "data_") !== false) {
								if($var[$id] != '')
									$var[$id]=converterDataSimples($var[$id]);
								//
								if ($id=="data_pagamento_caixafc" && $var[$id] == '')
									$var[$id]=date('Y-m-d');
								//
							}else
								$var[$id] = str_replace($chars, "", $var[$id]);
							//
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_caixafc'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_caixafc'];
					}
					echo '{"msg":"'.$msg.'","id_caixafc":"'.$var['id_caixafc'].'"}';
				break;
				case "provedor":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( "../../classes/crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "fc_provedor";
						protected $__id = "id_provedorfc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedorfc']=$id_provedor_usuario;
					//
					if($var['id_provedorfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_provedorfc']);
						if ($Facil_item !== false){
							foreach ($Facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										$var[$id]=converterDataSimples($var[$id]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id]=str_replace(',', '.',$var[$id]);
									}
									$var[$id] = str_replace($chars, "", $var[$id]);
									$Facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$Facil_item->update();
							//
							$msg="atualizado id:".$var['id_provedorfc'];
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item::find_by_field();
						$new_itens = new Facil_item();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}
							if (strpos($id, "data_") !== false) {
								$var[$id]=converterDataSimples($var[$id]);
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$var[$id]=str_replace(',', '.',$var[$id]);
							}
							$var[$id] = str_replace($chars, "", $var[$id]);
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_provedorfc'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_provedorfc'];
					}
					echo '{"msg":"'.$msg.'","id_provedorfc":"'.$var['id_provedorfc'].'"}';
				break;
				case "banco":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( "../../classes/crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "fc_gatewaypg";
						protected $__id = "id_gatewaypgfc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_gatewaypgfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_gatewaypgfc']);
						if ($Facil_item !== false){
							foreach ($Facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										$var[$id]=converterDataSimples($var[$id]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id]=str_replace(',', '.',$var[$id]);
									}
									$var[$id] = str_replace($chars, "", $var[$id]);
									$Facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$Facil_item->update();
							//
							$msg="atualizado id:".$var['id_gatewaypgfc'];
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item::find_by_field();
						$new_itens = new Facil_item();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}
							if (strpos($id, "data_") !== false) {
								$var[$id]=converterDataSimples($var[$id]);
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$var[$id]=str_replace(',', '.',$var[$id]);
							}
							$var[$id] = str_replace($chars, "", $var[$id]);
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_gatewaypgfc'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_gatewaypgfc'];
					}
					echo '{"msg":"'.$msg.'","id_gatewaypgfc":"'.$var['id_gatewaypgfc'].'"}';
				break;
				case "cliente":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( "../../classes/crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item01 extends simpleCRUD{
						protected $__table = "fc_clientes";
						protected $__id = "id_clientesfc";
					}
					//
					class Facil_item02 extends simpleCRUD{
						protected $__table = "fc_pontos";
						protected $__id = "id_pontosfc";
					}
					//
					class Facil_item03 extends simpleCRUD{
						protected $__table = "fc_sevmensal";
						protected $__id = "id_mensalfc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_clientesfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$facil_item = Facil_item01::find_by_id($var['id_clientesfc']);
						if ($facil_item !== false){
							foreach ($facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									if (strpos($id, "data_") !== false) {
										$var[$id]=converterDataSimples($var[$id]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id]=str_replace(',', '.',$var[$id]);
									}
									$var[$id] = str_replace($chars, "", $var[$id]);
									$facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$facil_item->update();
							//
							$msg="atualizado cliente:".$var['id_clientesfc']."<Br>";
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){
						//INSERE NOVOS DADOS NAS TABELAS
						$field_itens = Facil_item01::find_by_field();
						$new_itens = new Facil_item01();
						foreach ($field_itens as $id){
							if (strpos($id, "datatime_") !== false) {
								if($var[$id]==""){
									$var[$id]=date('Y-m-d H:i:s');
								}
							}
							if (strpos($id, "data_") !== false) {
								$var[$id]=converterDataSimples($var[$id]);
							}
							if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
								$var[$id]=str_replace(',', '.',$var[$id]);
							}
							$var[$id] = str_replace($chars, "", $var[$id]);
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_clientesfc'] = $new_itens->id;
						//
						$msg='Cadastrado cliente:'.$var['id_clientesfc']."<Br>";
					}
					if(count($var['id_pontosfc'])>1){
						for ($i=0;$i<count($var['id_pontosfc']);$i++){
							if($var['id_pontosfc'][$i]!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
								//ATUALIZA DADOS COM O ID VINDO DA PAGINA
								//INSERE NOVOS DADOS NAS TABELAS
								$facil_item = Facil_item02::find_by_id($var['id_pontosfc'][$i]);
								if ($facil_item !== false){
									foreach ($facil_item->toArray() as $id=>$value){
										if(isset($var[$id][$i]) && $var[$id][$i]!=$value){
											if (strpos($id, "data_") !== false) {
												$var[$id][$i]=converterDataSimples($var[$id][$i]);
											}
											if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
												$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
											}
											$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
											$facil_item->$id = utf8_decode($var[$id][$i]);
										}
									}
									$facil_item->update();
									//
									$msg.="atualizado Ponto:".$var['id_pontosfc'][$i]."<Br>";
								}else{
									$inserir=true;
								}
							}else{
								$inserir=true;
							}
							if($inserir){// INSERE PONTOS
								if($var['id_cliente_pontosfc'][$i]=='')
									$var['id_cliente_pontosfc'][$i]=$var['id_clientesfc'];
								//
								//INSERE NOVOS DADOS NAS TABELAS
								$field_itens = Facil_item02::find_by_field();
								$new_itens = new Facil_item02();
								foreach ($field_itens as $id){
									if (strpos($id, "datatime_") !== false) {
										if($var[$id][$i]==""){
											$var[$id][$i]=date('Y-m-d H:i:s');
										}
									}
									if (strpos($id, "data_") !== false) {
										$var[$id][$i]=converterDataSimples($var[$id][$i]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
									}
									$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
									$new_itens->$id=utf8_decode($var[$id][$i]);
									//echo $var[$id]."\n";
								}
								$new_itens->insert();
								$var['id_pontosfc'] = $new_itens->id;
								//
								$msg.='Cadastrado Ponto:'.$var['id_pontosfc']."<Br>";
							}	
							if($var['id_mensalfc'][$i]!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
								//ATUALIZA DADOS COM O ID VINDO DA PAGINA
								//INSERE NOVOS DADOS NAS TABELAS
								$facil_item = Facil_item03::find_by_id($var['id_mensalfc'][$i]);
								if ($facil_item !== false){
									foreach ($facil_item->toArray() as $id=>$value){
										if(isset($var[$id][$i]) && $var[$id][$i]!=$value){
											if (strpos($id, "data_") !== false) {
												$var[$id][$i]=converterDataSimples($var[$id][$i]);
											}
											if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
												$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
											}
											$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
											$facil_item->$id = utf8_decode($var[$id][$i]);
										}
									}
									$facil_item->update();
									//
									$msg.="atualizado Serviço Mensal:".$var['id_mensalfc'][$i]."<Br>";
								}else{
									$inserir=true;
								}
							}else{
								$inserir=true;
							}
							if($inserir){// INSERE SERVICO MENSAL
								if($var['id_cliente_mensalfc'][$i]=='')
									$var['id_cliente_mensalfc'][$i]=$var['id_clientesfc'];
								//
								//INSERE NOVOS DADOS NAS TABELAS
								$field_itens = Facil_item03::find_by_field();
								$new_itens = new Facil_item03();
								foreach ($field_itens as $id){
									if (strpos($id, "datatime_") !== false) {
										if($var[$id][$i]==""){
											$var[$id][$i]=date('Y-m-d H:i:s');
										}
									}
									if (strpos($id, "data_") !== false) {
										$var[$id][$i]=converterDataSimples($var[$id][$i]);
									}
									if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
										$var[$id][$i]=str_replace(',', '.',$var[$id][$i]);
									}
									$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
									$new_itens->$id=utf8_decode($var[$id][$i]);
									//echo $var[$id]."\n";
								}
								$new_itens->insert();
								$var['id_mensalfc'] = $new_itens->id;
								//
								$msg.='Cadastrado Serviço Mensal:'.$var['id_mensalfc']."<Br>";
							}
							switch($var['tipo_auth_pontosfc'][$i]) {
								case "pppoe":
									$profile=mysql_result(mysql_query("SELECT name_profilepp FROM mk_profilepp WHERE id_profilepp='".$var['id_profile'][$i]."'"),0,"name_profilepp");
									$resultado = mysql_query("UPDATE mk_secretpp SET profile_secretpp='$profile',profile_save_secretpp='$profile',id_cliente_secretpp='".$var['id_clientesfc']."',tipo_secretpp='atz',comment_secretpp='".$var['nome_clientesfc']."' WHERE id_secretpp='".$var['id_secret'][$i]."'") or die ("error");
									$msg.='User pppoe atualizado:'.$var['id_secretpp'][$i]."<Br>";
								break;
								case "hotspot":
									$profile=mysql_result(mysql_query("SELECT name_profilehp FROM mk_profilehp WHERE id_profilehp='".$var['id_profile'][$i]."'"),0,"name_profilehp");
									$resultado = mysql_query("UPDATE mk_secrethp SET profile_secrethp='$profile',profile_save_secrethp='$profile',id_cliente_secrethp='".$var['id_clientesfc']."',tipo_secrethp='atz',comment_secrethp='".$var['nome_clientesfc']."' WHERE id_secrethp='".$var['id_secret'][$i]."'") or die ("error");
									$msg.='User hotspot atualizado:'.$var['id_secrethp'][$i]."<Br>";
								break;
								case "binding":
									$profile=mysql_result(mysql_query("SELECT name_profilebi FROM mk_profilebi WHERE id_profilebi='".$var['id_profile'][$i]."'"),0,"name_profilebi");
									$resultado = mysql_query("UPDATE mk_secretbi SET profile_secretbi='$profile',profile_save_secretbi='$profile',id_cliente_secretbi='".$var['id_clientesfc']."',tipo_secretbi='atz',comment_secretbi='".$var['nome_clientesfc']."' WHERE id_secretbi='".$var['id_secret'][$i]."'") or die ("error");
									$msg.='User ipbinding atualizado:'.$var['id_secretbi'][$i]."<Br>";
								break;
							}
						}
					}else{
						if($var['id_pontosfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
							//ATUALIZA DADOS COM O ID VINDO DA PAGINA
							//INSERE NOVOS DADOS NAS TABELAS
							$facil_item = Facil_item02::find_by_id($var['id_pontosfc']);
							if ($facil_item !== false){
								foreach ($facil_item->toArray() as $id=>$value){
									if(isset($var[$id]) && $var[$id]!=$value){
										if (strpos($id, "data_") !== false) {
											$var[$id]=converterDataSimples($var[$id]);
										}
										if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
											$var[$id]=str_replace(',', '.',$var[$id]);
										}
										$var[$id] = str_replace($chars, "", $var[$id]);
										$facil_item->$id = utf8_decode($var[$id]);
									}
								}
								$facil_item->update();
								//
								$msg.="atualizado Ponto:".$var['id_pontosfc']."<Br>";
							}else{
								$inserir=true;
							}
						}else{
							$inserir=true;
						}
						if($inserir){// INSERE PONTOS
							if($var['id_cliente_pontosfc']=='')
								$var['id_cliente_pontosfc']=$var['id_clientesfc'];
							//
							//INSERE NOVOS DADOS NAS TABELAS
							$field_itens = Facil_item02::find_by_field();
							$new_itens = new Facil_item02();
							foreach ($field_itens as $id){
								if (strpos($id, "datatime_") !== false) {
									if($var[$id]==""){
										$var[$id]=date('Y-m-d H:i:s');
									}
								}
								if (strpos($id, "data_") !== false) {
									$var[$id]=converterDataSimples($var[$id]);
								}
								if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
									$var[$id]=str_replace(',', '.',$var[$id]);
								}
								$var[$id] = str_replace($chars, "", $var[$id]);
								$new_itens->$id=utf8_decode($var[$id]);
								//echo $var[$id]."\n";
							}
							$new_itens->insert();
							$var['id_pontosfc'] = $new_itens->id;
							//
							$msg.='Cadastrado Ponto:'.$var['id_pontosfc']."<Br>";
						}
						if($var['id_mensalfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
							//ATUALIZA DADOS COM O ID VINDO DA PAGINA
							//INSERE NOVOS DADOS NAS TABELAS
							$facil_item = Facil_item03::find_by_id($var['id_mensalfc']);
							if ($facil_item !== false){
								foreach ($facil_item->toArray() as $id=>$value){
									if(isset($var[$id]) && $var[$id]!=$value){
										if (strpos($id, "data_") !== false) {
											$var[$id]=converterDataSimples($var[$id]);
										}
										if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
											$var[$id]=str_replace(',', '.',$var[$id]);
										}
										$var[$id] = str_replace($chars, "", $var[$id]);
										$facil_item->$id = utf8_decode($var[$id]);
									}
								}
								$facil_item->update();
								//
								$msg.="atualizado Serviço Mensal:".$var['id_mensalfc']."<Br>";
							}else{
								$inserir=true;
							}
						}else{
							$inserir=true;
						}
						if($inserir){// INSERE SERVICO MENSAL
							if($var['id_cliente_mensalfc']=='')
								$var['id_cliente_mensalfc']=$var['id_clientesfc'];
							//
							//INSERE NOVOS DADOS NAS TABELAS
							$field_itens = Facil_item03::find_by_field();
							$new_itens = new Facil_item03();
							foreach ($field_itens as $id){
								if (strpos($id, "datatime_") !== false) {
									if($var[$id]==""){
										$var[$id]=date('Y-m-d H:i:s');
									}
								}
								if (strpos($id, "data_") !== false) {
									$var[$id]=converterDataSimples($var[$id]);
								}
								if (strpos($id, "valor_") !== false OR strpos($id, "porcentagem_") !== false) {
									$var[$id]=str_replace(',', '.',$var[$id]);
								}
								$var[$id] = str_replace($chars, "", $var[$id]);
								$new_itens->$id=utf8_decode($var[$id]);
								//echo $var[$id]."\n";
							}
							$new_itens->insert();
							$var['id_mensalfc'] = $new_itens->id;
							//
							$msg.='Cadastrado Serviço Mensal:'.$var['id_mensalfc']."<Br>";
						}
						switch($var['tipo_auth_pontosfc']) {
							case "pppoe":
								$profile=mysql_result(mysql_query("SELECT name_profilepp FROM mk_profilepp WHERE id_profilepp='".$var['id_profile']."'"),0,"name_profilepp");
								$resultado = mysql_query("UPDATE mk_secretpp SET profile_secretpp='$profile',profile_save_secretpp='$profile',id_cliente_secretpp='".$var['id_clientesfc']."',tipo_secretpp='atz',comment_secretpp='".$var['nome_clientesfc']."' WHERE id_secretpp='".$var['id_secret']."'") or die ("error");
								$msg.='User pppoe atualizado:'.$var['id_secretpp']."<Br>";
								break;
							case "hotspot":
								$profile=mysql_result(mysql_query("SELECT name_profilehp FROM mk_profilehp WHERE id_profilehp='".$var['id_profile']."'"),0,"name_profilehp");
								$resultado = mysql_query("UPDATE mk_secrethp SET profile_secrethp='$profile',profile_save_secrethp='$profile',id_cliente_secrethp='".$var['id_clientesfc']."',tipo_secrethp='atz',comment_secrethp='".$var['nome_clientesfc']."' WHERE id_secrethp='".$var['id_secret']."'") or die ("error");
								$msg.='User hotspot atualizado:'.$var['id_secrethp']."<Br>";
								break;
							case "binding":
								$profile=mysql_result(mysql_query("SELECT name_profilebi FROM mk_profilebi WHERE id_profilebi='".$var['id_profile']."'"),0,"name_profilebi");
								$resultado = mysql_query("UPDATE mk_secretbi SET profile_secretbi='$profile',profile_save_secretbi='$profile',id_cliente_secretbi='".$var['id_clientesfc']."',tipo_secretbi='atz',comment_secretbi='".$var['nome_clientesfc']."' WHERE id_secretbi='".$var['id_secret']."'") or die ("error");
								$msg.='User ipbinding atualizado:'.$var['id_secretbi']."<Br>";
								break;
						}
					}				
					echo '{"msg":"'.$msg.'","id_clientesfc":"'.$var['id_clientesfc'].'"}';
				break;
			}
		break;
	}
}else{
	echo '{"auth":false,"msg":"Não Autenticado"}';
}			
?>