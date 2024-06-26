<?php 
//importa funÁoes
$LOCAL_HOME='/home/provedor/';
$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
$query = isset($_REQUEST["query"]) ? $_REQUEST["query"] : false;
$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
//IMPORTA SITE SEGURO
header("Content-Type: text/html; charset=ISO-8859-1",true) ;
$authSession=true;
include_once($LOCAL_HOME."classes/funcoes_novas.php");
require_once($LOCAL_HOME."classes/conf.php");
conecta_mysql();	//concecta no banco myslq
if($authSession){
	// get command 
	//
	$chars = array('(', ')', '-');
	//
	switch($cmd) {
		case "load": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "vendas": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_vendas WHERE id_vendasfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 637"}');
						//
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
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
					}
				break;
				case "clientes": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_clientes WHERE id_clientesfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 637"}');
						//
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
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
					}
				break;
				case "itens": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_produtos_itens WHERE id_itensfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 637"}');
						//
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
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
					}
				break;
				case "saidas": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_saidas WHERE id_saidasfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 637"}');
						//
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
								if (strpos($id, "valor_") !== false) {
									$value=number_format($value, 2, ',', '.');
								}
								if($linha){
									$dados_linhas.='"'.$id.'":"'.$value.'",';
								}
							}
							$dados_linhas=substr($dados_linhas,0,-1);
							echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","objeto":"","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
						}
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
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fc_clientes WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
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
								,"name":"'.strtr($linha_dados->nome_clientesfc, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«", "aaaaeeiooouucAAAAEEIOOOUUC").'"
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
					$contents = file_get_contents('https://viacep.com.br/ws/'.$end.'/json/');
					echo $contents;
				break;
				case "select_torre": //ATUALIZA DADOS NA PAGINA
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fc_torre WHERE id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="0">All Torres</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione a torre</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_torrefc.'|'.$linha_dados->latitude_torrefc.'|'.$linha_dados->longitude_torrefc.'|'.$linha_dados->nome_torrefc.'">'.$linha_dados->nome_torrefc.'</option>';
						}
					}
				break;
				case "select_mk": //ATUALIZA DADOS NA PAGINA
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM mk_mikrotiks WHERE codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
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
				case "select_produto": //ATUALIZA DADOS NA PAGINA
					$int = isset($_REQUEST["int"]) ? $_REQUEST["int"] : false;
					$mensal = isset($_REQUEST["mensal"]) ? $_REQUEST["mensal"] : false;
					$busca='';
					if($mensal)
						$busca.=" mensal_produtosfc='on' AND ";
					//
					if($int)
						$busca.=" internet_produtosfc='on' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="">Nenhum Produt</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione o Produto</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_produtosfc.'|'.$linha_dados->valor_produtosfc.'|'.$linha_dados->id_profilepp_produtosfc.'|'.$linha_dados->id_profilehp_produtosfc.'|'.$linha_dados->id_profilebi_produtosfc.'|'.$linha_dados->descricao_produtosfc.'">'.$linha_dados->descricao_produtosfc.' - R$ '.number_format($linha_dados->valor_produtosfc, 2, ',', '').'</option>';
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
					$resultadoDados = mysql_query("SELECT * FROM fc_caixa WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
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
						case "pppoe":
							if($mk)
								$busca=" (mk_secretpp='$mk' OR mk_secretpp='') AND ";
								//
								if($query!='*all')
									$busca.=" name_secretpp like '%".$query."%' AND ";
									//
									$resultadoDados = mysql_query("SELECT id_secretpp AS id, CONCAT(name_secretpp,' - ',mk_secretpp) AS name FROM mk_secretpp WHERE $busca codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
									break;
						case "hotspot":
							if($mk)
								$busca=" (mk_secrethp='$mk' OR mk_secrethp='') AND ";
								//
								if($query!='*all')
									$busca.=" name_secrethp like '%".$query."%' AND ";
									//
									$resultadoDados = mysql_query("SELECT id_secrethp AS id, CONCAT(name_secrethp,' - ',mk_secrethp) AS name FROM mk_secrethp WHERE $busca codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
									break;
						case "binding":
							if($mk)
								$busca=" (mk_secretbi='$mk' OR mk_secretbi='') AND ";
								//
								if($query!='*all')
									$busca.=" name_secretbi like '%".$query."%' AND ";
									//
									$resultadoDados = mysql_query("SELECT id_secretbi AS id, CONCAT(name_secretbi,' - Mk:',mk_secretbi) AS name FROM mk_secretbi WHERE $busca codigo_provedor='$cod_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
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
				case "produto": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca.=" descricao_produtosfc like '%".$query."%' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
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
								"id":"'.$linha_dados->id_produtosfc.'|'.$linha_dados->valor_produtosfc.'|'.$linha_dados->valor_custo_produtosfc.'"
								,"name":"'.$linha_dados->descricao_produtosfc.': R$ '.number_format($linha_dados->valor_produtosfc, 2, ',', '').'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "itens": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca.=" descricao_itensfc like '%".$query."%' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM fc_produtos_itens WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
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
								"id":"'.$linha_dados->id_itensfc.'|'.$linha_dados->embalagem_itensfc.'|'.$linha_dados->valor_unitario_itensfc.'"
								,"name":"'.$linha_dados->descricao_itensfc.': R$ '.number_format($linha_dados->valor_unitario_itensfc, 5, ',', '').' p/ '.$linha_dados->embalagem_itensfc.'"
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
				case "contas": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$user = isset($_REQUEST["user"]) ? $_REQUEST["user"] : false;
					$nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
					$ordem = isset($_REQUEST["ordem"]) ? $_REQUEST["ordem"] : false;
					$busca='';
					if($id){
						$busca=" id_contasfc='$id' AND ";
						$busc="Id $id+ ";
					}else{
						if($nome){
							$busca=" cliente_contasfc like '%".$nome."%' AND ";
							$busc="Cliente $nome+ ";
						}
						//
					}
					if($cod_provedor_usuario){
						$busc="provedor $cod_provedor_usuario+ ";
						$select="SELECT 
						`u`.`id_secretpp` AS id_contasfc, 
						`u`.`name_secretpp` AS user_contasfc, 
						`u`.`profile_secretpp` AS profile_contasfc, 
						`u`.`mk_secretpp` AS mk_contasfc, 
						`u`.`last-logged-out_secretpp` AS acesso_contasfc,
						`c`.`nome_clientesfc` AS cliente_contasfc,  
						CONCAT('<b>Documento:</b> ',`c`.`cpf_cnpj_clientesfc`,' <b>Tels:</b> ',`c`.`tel1_clientesfc`,' / ',`c`.`tel2_clientesfc`,' <b>Email:</b> ',`c`.`email_clientesfc`,' <b>End: </b>',IF(`c`.`cob1_clientesfc`='on',`c`.`end1_clientesfc`,`c`.`end2_clientesfc`),', ',IF(`c`.`cob1_clientesfc`='on',`c`.`num1_clientesfc`,`c`.`num2_clientesfc`),'(',IF(`c`.`cob1_clientesfc`='on',`c`.`comp1_clientesfc`,`c`.`comp2_clientesfc`),') - ',IF(`c`.`cob1_clientesfc`='on',`c`.`bar1_clientesfc`,`c`.`bar2_clientesfc`),' - ',IF(`c`.`cob1_clientesfc`='on',`c`.`cep1_clientesfc`,`c`.`cep2_clientesfc`),' - ',IF(`c`.`cob1_clientesfc`='on',`c`.`cid1_clientesfc`,`c`.`cid2_clientesfc`),'-',IF(`c`.`cob1_clientesfc`='on',`c`.`uf1_clientesfc`,`c`.`uf2_clientesfc`),' <b>Vencimento:</b> ',`c`.`venc_clientesfc`,' <b>Sit:</b> ',`c`.`sit_clientesfc`) AS dados_dadosfc, 
						`u`.`codigo_provedor` AS id_provedor
						FROM `mk_secretpp` AS `u`
						left join `fc_clientes` AS `c` on `c`.`id_clientesfc`=`u`.`id_cliente_secretpp`
						WHERE $busca `u`.`codigo_provedor`='$cod_provedor_usuario'";
					}else
						$select="SELECT 
						`u`.`id_secretpp` AS id_contasfc, 
						`u`.`name_secretpp` AS user_contasfc, 
						`u`.`profile_secretpp` AS profile_contasfc, 
						`u`.`mk_secretpp` AS mk_contasfc, 
						`u`.`last-logged-out_secretpp` AS acesso_contasfc,
						`c`.`nome_clientesfc` AS cliente_contasfc, 
						CONCAT('<b>Documento:</b> ',`c`.`cpf_cnpj_clientesfc`,' <b>Tels:</b> ',`c`.`tel1_clientesfc`,' / ',`c`.`tel2_clientesfc`,' <b>Email:</b> ',`c`.`email_clientesfc`,' <b>End: </b>',IF(`c`.`cob1_clientesfc`='on',`c`.`end1_clientesfc`,`c`.`end2_clientesfc`),', ',IF(`c`.`cob1_clientesfc`='on',`c`.`num1_clientesfc`,`c`.`num2_clientesfc`),'(',IF(`c`.`cob1_clientesfc`='on',`c`.`comp1_clientesfc`,`c`.`comp2_clientesfc`),') - ',IF(`c`.`cob1_clientesfc`='on',`c`.`bar1_clientesfc`,`c`.`bar2_clientesfc`),' - ',IF(`c`.`cob1_clientesfc`='on',`c`.`cep1_clientesfc`,`c`.`cep2_clientesfc`),' - ',IF(`c`.`cob1_clientesfc`='on',`c`.`cid1_clientesfc`,`c`.`cid2_clientesfc`),'-',IF(`c`.`cob1_clientesfc`='on',`c`.`uf1_clientesfc`,`c`.`uf2_clientesfc`),' <b>Vencimento:</b> ',`c`.`venc_clientesfc`,' <b>Sit:</b> ',`c`.`sit_clientesfc`) AS dados_dadosfc, 
						`u`.`codigo_provedor` AS id_provedor
						FROM `mk_secretpp` AS `u`
						left join `fc_clientes` AS `c` on `c`.`id_clientesfc`=`u`.`id_cliente_secretpp`
						WHERE $busca `u`.`codigo_provedor`!=0";
					//
					if($ordem){ 
						$ordemArray=explode("|",$ordem);
						$idOrdem=$ordemArray[0];
						$vlOrdem=$ordemArray[1];
						if($idOrdem!='' && $vlOrdem!='')
							$order=" ORDER BY ".$idOrdem." ".$vlOrdem;
						//
					}
					//echo $select;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Secrets Contas","busca":"'.$busc.'",suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Secrets Contas","busca":"'.$busc.'","suggestion":{}}';
						//
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 430"}');
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Secrets Contas","busca":"'.$busc.'",';
						echo '"suggestion":[';
						echo '{
							"id":"0"
							,"name":"<font style=\"white-space:normal; font-size: small\">Ordenar por: <b><a href=\"#\" onclick=\"Ol(\'cliente_contasfc\');\"><b>Cliente</b></a> | <a href=\"#\" onclick=\"Ol(\'user_contasfc\');\"><b>User</b></a> | <a href=\"#\" onclick=\"Ol(\'mk_contasfc\');\"><b>Mk</b></a> | <a href=\"#\" onclick=\"Ol(\'acesso_contasfc\');\"><b>Ultimo Acesso</b></a></font>"
						},';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							if($linha_dados->cliente_contasfc!='')
								echo '{
									"id":"'.$linha_dados->id_contasfc.'"
									,"name":"<font style=\"white-space:normal; font-size: small\"><b>User: </b> '.$linha_dados->user_contasfc.' <b>Cliente: </b> '.$linha_dados->cliente_contasfc.' <b>Profile: </b> '.$linha_dados->profile_contasfc.' <b>Mk: </b> '.$linha_dados->mk_contasfc.' <b>Ultimo Acesso: </b> '.$linha_dados->acesso_contasfc.'<br>'.$linha_dados->dados_dadosfc.'</font>"
								}';
							else 
								echo '{
									"id":"'.$linha_dados->id_contasfc.'"
									,"name":"<font style=\"white-space:normal; font-size: small\"><b>User: </b> '.$linha_dados->user_contasfc.' <b>Profile: </b> '.$linha_dados->profile_contasfc.' <b>Mk: </b> '.$linha_dados->mk_contasfc.' <b>Ultimo Acesso: </b> '.$linha_dados->acesso_contasfc.'</font>"
								}';								
							//
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "clientes": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$nome = isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
					$ordem = isset($_REQUEST["ordem"]) ? $_REQUEST["ordem"] : false;
					$busca='';
					if($id){
						$busca=" id_clientesfc='$id' AND ";
						$busc="Id $id+ ";
					}else{
						if($nome){
							$busca=" nome_clientesfc like '%".$nome."%' AND ";
							$busc="Cliente $parceiro+ ";
						}
						//
					}
					if($cod_provedor_usuario){
						$busc="provedor $cod_provedor_usuario+ ";
						$select="SELECT * FROM fc_clientes WHERE $busca id_provedor='$cod_provedor_usuario'";
					}else
						$select="SELECT * FROM fc_clientes WHERE $busca id_provedor!=0";
						//
					if($ordem){
						$ordemArray=explode("|",$ordem);
						$idOrdem=$ordemArray[0];
						$vlOrdem=$ordemArray[1];
						if($idOrdem!='' && $vlOrdem!='')
							$order=" ORDER BY ".$idOrdem." ".$vlOrdem;
					}
					//echo $busc;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Clientes","busca":"'.$busc.'",suggestion":{"'.$query.'":"'.$query.'"}}';
						else
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Clientes","busca":"'.$busc.'","suggestion":{}}';
						//
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 430"}');
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Secrets PPPoe","busca":"'.$busc.'",';
						echo '"suggestion":[';
						echo '{
							"id":"0"
							,"name":"<font style=\"white-space:normal; font-size: small\">Ordenar por: <b><a href=\"#\" onclick=\"Ol(\'nome_clientesfc\');\"><b>Nome</b></a> | <a href=\"#\" onclick=\"Ol(\'datatime_clientesfc\');\"><b>Cadastro</b></a></font>"
						},';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							if($linha_dados->pessoa_juridica_clientesfc=='on')
								echo '{
									"id":"'.$linha_dados->id_clientesfc.'"
									,"name":"<font style=\"white-space:normal; font-size: small\"><b>Empresa:</b> '.$linha_dados->nome_clientesfc.'  <b>Raz„o Social:</b> '.$linha_dados->razao_social_clientesfc.' <b>Respons·vel:</b>'.$linha_dados->responsavel_clientesfc.' <b>Tels:</b> '.$linha_dados->tel1_clientesfc.' ('.$linha_dados->op1_clientesfc.',wapp:'.$linha_dados->wsap1_clientesfc.') / '.$linha_dados->tel2_clientesfc.' ('.$linha_dados->op2_clientesfc.',wz:'.$linha_dados->wsap2_clientesfc.') <b>Cadastro:</b> '.mostrarData($linha_dados->datatime_clientesfc,false).'</font>"
								}';
							else 
								echo '{
									"id":"'.$linha_dados->id_clientesfc.'"
									,"name":"<font style=\"white-space:normal; font-size: small\"><b>Nome:</b> '.$linha_dados->nome_clientesfc.' <b>Tels:</b> '.$linha_dados->tel1_clientesfc.' ('.$linha_dados->op1_clientesfc.',wapp:'.$linha_dados->wsap1_clientesfc.') / '.$linha_dados->tel2_clientesfc.'('.$linha_dados->op2_clientesfc.',wapp:'.$linha_dados->wsap2_clientesfc.') <b>Cadastro: </b>'.mostrarData($linha_dados->datatime_clientesfc,false).'</font>"
								}';
							//
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "secrets": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$id_cliente = isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
					$login = isset($_REQUEST["login"]) ? $_REQUEST["login"] : false;
					$parceiro = isset($_REQUEST["parceiro"]) ? $_REQUEST["parceiro"] : false;
					$ordem = isset($_REQUEST["ordem"]) ? $_REQUEST["ordem"] : false;
					$busca='';
					if($id){
						$busca=" id_secretpp='$id' AND ";
						$busc="id $id+ ";
					}else if($id_cliente){
						$busca=" id_cliente_secretpp='$id_cliente' AND ";
						$busc="id do cliente $id+ ";
					}else{
						if($login){
							$busca=" name_secretpp='$login' AND ";
							$busc="login $id+ ";
						}else if($parceiro){
							if($cod_provedor_usuario)
								$busca=" name_secretpp like '%".$parceiro."-%' OR ";
							else
								$busca=" name_secretpp like '%".$parceiro."-%' AND ";
							//
							$busc="parceiro $parceiro+ ";
						}
						//
					}
					if($cod_provedor_usuario){
						$busc="provedor $cod_provedor_usuario+ ";
						$select="SELECT id_secretpp,name_secretpp,profile_secretpp,`last-logged-out_secretpp` AS ultimo_acesso,mk_secretpp,id_cliente_secretpp,codigo_provedor FROM mk_secretpp WHERE $busca codigo_provedor='$cod_provedor_usuario'";
					}else 
						$select="SELECT id_secretpp,name_secretpp,profile_secretpp,`last-logged-out_secretpp` AS ultimo_acesso,mk_secretpp,id_cliente_secretpp,codigo_provedor FROM mk_secretpp WHERE $busca codigo_provedor!=0";
					//
					if($ordem){
						$ordemArray=explode("|",$ordem);
						$idOrdem=$ordemArray[0];
						$vlOrdem=$ordemArray[1];
						if($idOrdem!='' && $vlOrdem!='')
							$order=" ORDER BY ".$idOrdem." ".$vlOrdem;
					}
					//echo $busc;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Secrets PPPoe","busca":"'.$busc.'",suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Secrets PPPoe","busca":"'.$busc.'","suggestion":{}}';
						//
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 442"}');
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Secrets PPPoe","busca":"'.$busc.'",';
						echo '"suggestion":[';
						echo '{
							"id":"0"
							,"name":"<font style=\"white-space:normal; font-size: small\">Ordenar por: <b><a href=\"#\" onclick=\"Ol(\'name_secretpp\');\"><b>User</b></a> | <a href=\"#\" onclick=\"Ol(\'profile_secretpp\');\"><b>Profile</b></a> | <a href=\"#\" onclick=\"Ol(\'ultimo_acesso\');\"><b>Ultimo acesso</b></a> | <a href=\"#\" onclick=\"Ol(\'mk_secretpp\');\"><b>Mikrotik</b></a></font>"
						},';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_secretpp.'"
								,"name":"<font style=\"white-space:normal; font-size: small\"><b>User:</b><a href=\"#\" onclick=\"$(\'#dados_clientes\').simpledialog2();$(\'#id_clientesfc\').val(\''.$linha_dados->id_cliente_secretpp.'\');\">'.$linha_dados->name_secretpp.'</a> <b>Profile:</b><a href=\"#\" onclick=\"$(\'#alterar_profile\').simpledialog2();$(\'#id_secretpp\').val(\''.$linha_dados->id_secretpp.'\');\">'.$linha_dados->profile_secretpp.'</a> <b>Ultimo acesso:</b><a href=\"acessos.html\" onclick=\"$(\'#ver_acessos\').simpledialog2();$(\'#name_secretpp\').val(\''.$linha_dados->name_secretpp.'\');\">'.mostrarData($linha_dados->ultimo_acesso,false).'</a> <b>Mikrotik:</b>'.$linha_dados->mk_secretpp.'</font>"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}'; 
					}
				break;
				case "acessos": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$status = isset($_REQUEST["status"]) ? $_REQUEST["status"] : false;
					$login = isset($_REQUEST["login"]) ? $_REQUEST["login"] : false;
					$parceiro = isset($_REQUEST["parceiro"]) ? $_REQUEST["parceiro"] : false;
					$ordem = isset($_REQUEST["ordem"]) ? $_REQUEST["ordem"] : false;
					$busca='';
					if($id){
						$busca=" id_logacessos='$id' AND ";
						$busc="id $id+ "; 
					}else if($login){
						$busca=" login_logacessos='$login' AND ";
						$busc="login $login+ ";
					}else{
						$busca=" status_logacessos='on' AND ";
						$busc="Online(s)+ ";
						if($parceiro){
							if($cod_provedor_usuario)
								$busca.=" name_secretpp like '%".$parceiro."-%' OR";
							else
								$busca.=" name_secretpp like '%".$parceiro."-%' AND ";
							//
							$busc="provedor $parceiro+ ";
						}
						
						//
					}
					if($cod_provedor_usuario){
						$busc.="do provedor $cod_provedor_usuario";
						$select="SELECT id_logacessos,login_logacessos,status_logacessos,ip_logacessos,mac_logacessos,datatime_inicio_logacessos,datatime_fim_logacessos,uptime_logacessos,situacao_logacessos,`tx-bytes_logacessos` AS down,`rx-bytes_logacessos` AS up FROM mk_logacessos WHERE $busca codigo_provedor='$id_provedor_usuario'";
					}else 
						$select="SELECT id_logacessos,login_logacessos,status_logacessos,ip_logacessos,mac_logacessos,datatime_inicio_logacessos,datatime_fim_logacessos,uptime_logacessos,situacao_logacessos,`tx-bytes_logacessos` AS down,`rx-bytes_logacessos` AS up FROM mk_logacessos WHERE $busca codigo_provedor!=0";
					//
					if($ordem){
						$ordemArray=explode("|",$ordem);
						$idOrdem=$ordemArray[0];
						$vlOrdem=$ordemArray[1];
						if($idOrdem!='' && $vlOrdem!='')
							$order=" ORDER BY ".$idOrdem." ".$vlOrdem;
					}
					//echo $busc;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Acessos PPPoe","busca":"'.$busc.'",suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Acessos PPPoe","busca":"'.$busc.'","suggestion":{}}';
						//
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 124"}');
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Acessos PPPoe","busca":"'.$busc.'",';
						echo '"suggestion":[';
						echo '{
							"id":"0"
							,"name":"<font style=\"white-space:normal; font-size: small\">Ordenar por: <b><a href=\"#\" onclick=\"Ol(\'login_logacessos\');\"><b>User</b></a> | <a href=\"#\" onclick=\"Ol(\'status_logacessos\');\"><b>Status</b></a> | <a href=\"#\" onclick=\"Ol(\'ip_logacessos\');\"><b>IP</b></a> | <a href=\"#\" onclick=\"Ol(\'mac_logacessos\');\"><b>Mac</b></a> | <a href=\"#\" onclick=\"Ol(\'datatime_inicio_logacessos\');\"><b>Inicio</b></a> | <a href=\"#\" onclick=\"Ol(\'datatime_fim_logacessos\');\"><b>Fim</b></a> | <a href=\"#\" onclick=\"Ol(\'uptime_logacessos\');\"><b>uptime</b></a> | <a href=\"#\" onclick=\"Ol(\'situacao_logacessos\');\"><b>Sit</b></a> | <a href=\"#\" onclick=\"Ol(\'down\');\"><b>Down</b></a> | <a href=\"#\" onclick=\"Ol(\'up\');\"><b>Up</b></a></font>"
						},';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id_logacessos.'"
								,"name":"<font style=\"white-space:normal; font-size: small\"><b>User:</b><a href=\"secrets.html\" >'.$linha_dados->login_logacessos.' </a> <b>Status:</b>'.$linha_dados->status_logacessos.' <b>IP:</b><a href=\"http://'.$linha_dados->ip_logacessos.'\" target=\"_blank\">'.$linha_dados->ip_logacessos.'</a> <b>Mac:</b>'.$linha_dados->mac_logacessos.' <b>Inicio:</b>'.mostrarData($linha_dados->datatime_inicio_logacessos,false).' <b>Fim:</b>'.mostrarData($linha_dados->datatime_fim_logacessos,false).' <b>uptime:</b>'.$linha_dados->uptime_logacessos.' <b>Sit:</b>'.$linha_dados->situacao_logacessos.' <b>Down:</b>'.$linha_dados->down.' <b>Up:</b>'.$linha_dados->up.'</font>"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}'; 
					}
				break;
				case "wireless": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$ssid = isset($_REQUEST["ssid"]) ? $_REQUEST["ssid"] : false;
					$mac = isset($_REQUEST["mac"]) ? $_REQUEST["mac"] : false;
					$ap = isset($_REQUEST["ap"]) ? $_REQUEST["ap"] : false;
					$ordem = isset($_REQUEST["ordem"]) ? $_REQUEST["ordem"] : false;
					$busca='';
					if($id){
						$busca=" id_wirelessfc='$id' AND ";
						$busc="id $id+ ";
					}else if($mac){
						$busca=" mac_wirelessfc='$mac' AND ";
						$busc="login $login+ ";
					}else{
						if($ssid){
							$busca.=" ssid_wirelessfc='".$ssid."' AND";
							$busc="Ssid $ssid+ ";
						}
						if($ap){
							$busca.=" ap_wirelessfc='".$ap."' AND";
							$busc="Ap $ap+ ";
						}
					}
					if($cod_provedor_usuario){
						$busc.="do provedor $cod_provedor_usuario";
						$select="SELECT * FROM fc_wireless WHERE $busca id_provedor='$id_provedor_usuario'";
					}else{
						$busc.="all provedor";
						$select="SELECT * FROM fc_wireless WHERE $busca id_provedor!=0";
					}
					//
					if($ordem){
						$ordemArray=explode("|",$ordem);
						$idOrdem=$ordemArray[0];
						$vlOrdem=$ordemArray[1];
						if($idOrdem!='' && $vlOrdem!='')
							$order=" ORDER BY ".$idOrdem." ".$vlOrdem;
					}
					//echo $busc;
					$qtdResult=mysql_num_rows(mysql_query($select));
					if ($qtdResult == 0){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Sinal Wireless","busca":"'.$busc.'",suggestion":{"'.$query.'":"'.$query.'"}}';
							else
								echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","title":"Sinal Wireless","busca":"'.$busc.'","suggestion":{}}';
								//
					}else{
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 124"}');
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdResult.'","query":"'.$query.'","title":"Sinal Wireless","busca":"'.$busc.'",';
						echo '"suggestion":[';
						echo '{
							"id":"0"
							,"name":"<font style=\"white-space:normal; font-size: small\">Ordenar por: <b><a href=\"#\" onclick=\"Ol(\'mac_wirelessfc\');\"><b>Mac</b></a> | <a href=\"#\" onclick=\"Ol(\'ssid_wirelessfc\');\"><b>Ssid</b></a> | <a href=\"#\" onclick=\"Ol(\'ap_wirelessfc\');\"><b>Ap</b></a> | <a href=\"#\" onclick=\"Ol(\'datatime_wirelessfc\');\"><b>Time</b></a> | <a href=\"#\" onclick=\"Ol(\'dbm_wirelessfc\');\"><b>Dbm</b></a> | <a href=\"#\" onclick=\"Ol(\'snr_wirelessfc\');\"><b>Snr</b></a> | <a href=\"#\" onclick=\"Ol(\'uptime_wirelessfc\');\"><b>uptime</b></a></font>"
						},';
						$i=0;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
							"id":"'.$linha_dados->id_wirelessfc.'"
							,"name":"<font style=\"white-space:normal; font-size: small\"><b>Mac:</b><a href=\"_acessos.html?mac='.$linha_dados->mac_wirelessfc.'\" >'.$linha_dados->mac_wirelessfc.' </a> <b>Ssid:</b>'.$linha_dados->ssid_wirelessfc.' <b>Ap:</b><a href=\"_aps.html?ap='.$linha_dados->ap_wirelessfc.'\" >'.$linha_dados->ap_wirelessfc.'</a> <b>Time:</b>'.mostrarData($linha_dados->datatime_wirelessfc,false).' <b>Dbm:</b>'.$linha_dados->dbm_wirelessfc.' <b>Snr:</b>'.$linha_dados->snr_wirelessfc.' <b>uptime:</b>'.$linha_dados->uptime_wirelessfc.'</font>"
						}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
			}
		break; 
		case "remove": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "vendas":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if ($id){
						//REMOVE
						$sql = "DELETE FROM fc_vendas WHERE id_vendasfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Venda Com id:'.$id.' Removido com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Remover Venda Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id da Venda invalido!"}';
					}	
				break;
				case "saidas":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if ($id){
						//REMOVE
						$sql = "DELETE FROM fc_saidas WHERE id_saidasfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Saida Com id:'.$id.' Removido com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Remover Saida Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id da Saida invalido!"}';
					}
				break;
				case "produtos":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if ($id){
						//REMOVE
						$sql = "DELETE FROM fc_produtos WHERE id_produtosfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Produto Com id:'.$id.' Removido com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Remover Produto Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id do Produto invalido!"}';
					}
				break;
				case "itens_produtos":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$valor = isset($_REQUEST["valor"]) ? $_REQUEST["valor"] : false;
					if ($id){
						$new_itens='';
						$itensArray=explode(",",mysql_fetch_object(mysql_query("SELECT itens_produtosfc FROM fc_produtos WHERE id_produtosfc='$id' AND id_provedor='$id_provedor_usuario' AND itens_produtosfc!=''"))->itens_produtosfc);
						for($i=0;$i<count($itensArray);$i++){
							if($itensArray[$i]!=$valor)
								$new_itens.=$itensArray[$i].',';
							//
						}
						$new_itens=substr($new_itens,0,-1);
						//echo $new_itens;
						//REMOVE
						$sql = "UPDATE fc_produtos SET itens_produtosfc='$new_itens' WHERE id_produtosfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Itens do produto Com id:'.$id.' Alterado com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Alterar Itens do Produto Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id do Produto invalido!"}';
					}
				break;
				case "itens_itens":   //TIPO -> caixa
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$valor = isset($_REQUEST["valor"]) ? $_REQUEST["valor"] : false;
					if ($id){
						$new_itens='';
						$itensArray=explode(",",mysql_fetch_object(mysql_query("SELECT itens_itensfc FROM fc_produtos_itens WHERE id_itensfc='$id' AND id_provedor='$id_provedor_usuario' AND itens_produtosfc!=''"))->itens_itensfc);
						for($i=0;$i<count($itensArray);$i++){
							if($itensArray[$i]!=$valor)
								$new_itens.=$itensArray[$i].',';
							//
						}
						$new_itens=substr($new_itens,0,-1);
						//echo $new_itens;
						//REMOVE
						$sql = "UPDATE fc_produtos_itens SET itens_itensfc='$new_itens' WHERE id_itensfc='".$id."'";
						if ($resultado = mysql_query($sql)){
							echo '{"success":true,"dados":"Itens do Item Com id:'.$id.' Alterado com sucesso!"}';
						}else{
							echo '{"success":false,"errors":"Erro ao Alterar Itens do Item Com id:'.$id.'!"}';
						}
					}else{
						echo '{"success":false,"errors":"id do Produto invalido!"}';
					}
				break;
			}		
		break;
		case "save": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "caixa":   //TIPO -> caixa
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( $LOCAL_HOME."classes/crud.class.php");
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
					include_once( $LOCAL_HOME."classes/crud.class.php");
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
					include_once( $LOCAL_HOME."classes/crud.class.php");
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
					include_once( $LOCAL_HOME."classes/crud.class.php");
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
									if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
										$var[$id] = str_replace($chars, "", $var[$id]);
									}
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
							if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
								$var[$id] = str_replace($chars, "", $var[$id]);
							}
							$new_itens->$id=utf8_decode($var[$id]);
							//echo $var[$id]."\n";
						}
						$new_itens->insert();
						$var['id_clientesfc'] = $new_itens->id;
						//
						$msg='Cadastrado cliente:'.$var['id_clientesfc']."<Br>";
					}
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
											if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
												$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
											}
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
									if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
										$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
									}
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
											if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
												$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
											}
											$facil_item->$id = utf8_decode($var[$id][$i]);
										}
									}
									$facil_item->update();
									//
									$msg.="atualizado ServiÁo Mensal:".$var['id_mensalfc'][$i]."<Br>";
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
									if (!(strpos($id, "datatime_") !== false) && !(strpos($id, "data_") !== false)) {
										$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
									}
									$new_itens->$id=utf8_decode($var[$id][$i]);
									//echo $var[$id]."\n";
								}
								$new_itens->insert();
								$var['id_mensalfc'] = $new_itens->id;
								//
								$msg.='Cadastrado ServiÁo Mensal:'.$var['id_mensalfc']."<Br>";
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
					echo '{"msg":"'.$msg.'","id_clientesfc":"'.$var['id_clientesfc'].'"}';
				break;
			}
		break;
	}
}else{
	echo '{"JSON":true,"auth":false,"msg":"N„o Autenticado"}';
}			
?>