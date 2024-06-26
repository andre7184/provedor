<?php 
//importa funÁoes
$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
$query = isset($_REQUEST["query"]) ? $_REQUEST["query"] : false;
$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
//IMPORTA SITE SEGURO
header("Content-Type: text/html; charset=ISO-8859-1",true) ;
$page='_dados.php';
require_once("_validar.php");
if($authSession){
	// get command 
	//
	$chars = array('(', ')', '-');
	//
	switch($cmd) {
		case "load": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "servmensal": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fc_sevmensal WHERE id_mensalfc='$id' AND id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 21"}');
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
		case "select": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "clientes": //ATUALIZA DADOS NA PAGINA
					if($grupo!=''){
						$busca=" AND grupot_dadosfc like '".$grupo."'";
					}
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fcv_dados WHERE id_provedor='$id_provedor_usuario' $busca ORDER BY nome_dadosfc ASC") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 57"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="0">Nenhum Encontrado/option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione cliente</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){ 
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_dadosfc.'">'.$linha_dados->nome_dadosfc.' - '.$linha_dados->secretpp_dadosfc.'</option>';
						}
					}
				break;
				case "servmensal": //ATUALIZA DADOS NA PAGINA
					$id_cliente_mensalfc = isset($_REQUEST["id_cliente_mensalfc"]) ? $_REQUEST["id_cliente_mensalfc"] : false;
					if($id_cliente_mensalfc!=''){
						$busca="id_cliente_mensalfc='".$id_cliente_mensalfc."' AND";
					}
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM fc_sevmensal WHERE $busca id_provedor='$id_provedor_usuario'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 77"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '<option value="">Selecione o ServiÁo Mensal</option>';
						echo '<option value="new">Cadastrar Novo</option>';
						//
					}else{
						$i=0;
						echo '<option value="">Selecione o ServiÁo Mensal</option>';
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							echo '<option value="'.$linha_dados->id_mensalfc.'">'.$linha_dados->descricao_mensalfc.' - '.$linha_dados->valor_sevmensalfc.'</option>';
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
					//
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
				case "endcliente":
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$resultadoDados = mysql_query("SELECT * FROM fcv_dados WHERE id_dadosfc='$id'") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
						$qtdResult=mysql_num_rows($resultadoDados);
						if ($qtdResult == 0){
							
						}else{
							$linha_dados=mysql_fetch_object($resultadoDados);
							array_walk($linha_dados, 'toUtf8');
							echo '{"auth":"'.$authSession.'","qtd":"1","objeto":"","cols":"5","data":{"cep_sevmensalfc":"'.$linha_dados->cep_dadosfc.'","end_sevmensalfc":"'.$linha_dados->end_dadosfc.', '.$linha_dados->num_dadosfc.' - '.$linha_dados->bairro_dadosfc.' - '.$linha_dados->cidade_dadosfc.'-'.$linha_dados->uf_dadosfc.'","comp_sevmensalfc":"'.$linha_dados->complementos_dadosfc.'","lat_sevmensalfc":"'.$linha_dados->lat_dadosfc.'","lon_sevmensalfc":"'.$linha_dados->lon_dadosfc.'"}}';
						}
					}
					break;
				case "cep":
					$end = isset($_REQUEST["end"]) ? $_REQUEST["end"] : false;
					$contents = file_get_contents('https://viacep.com.br/ws/'.$end.'/json/');
					echo $contents;
				break;
				case "userppp": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$userppp=mysql_result(mysql_query("SELECT name_secretpp FROM mk_secretpp WHERE id_secretpp='".$id."'"),0,"name_secretpp");
					echo $userppp;
					break;
				case "secrets": //ATUALIZA DADOS NA PAGINA
					$grupo = isset($_REQUEST["grupo"]) ? $_REQUEST["grupo"] : false;
					if($grupo && $grupo!='admin'){
						if(strlen($query)>=3)
							$busca="((`name_secretpp` NOT REGEXP '-' AND `mk_secretpp` LIKE '".$grupo."-VN1') OR `name_secretpp` like '%".$grupo."-%') AND `name_secretpp` like '%".$query."%' AND ";
						else
							$busca="((`name_secretpp` NOT REGEXP '-' AND `mk_secretpp` LIKE '".$grupo."-VN1') OR `name_secretpp` like '%".$grupo."-%') AND `name_secretpp` like '".$query."' AND ";
						//
					}else
						$busca="`name_secretpp` like '%".$query."%' AND ";
					//
					$select="SELECT id_secretpp AS id, name_secretpp AS login, CONCAT(name_secretpp,' - ',mk_secretpp) AS name FROM mk_secretpp WHERE $busca id_provedor='$id_provedor_usuario'";
					//echo $select;
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 38"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult == 0){
						echo '{"auth":"'.$authSession.'","qtd":"1","query":"'.$query.'","suggestion":[{"id":"new","name":"'.$query.'"}]}';
						//
					}else{
						echo '{"auth":"'.$authSession.'","qtd":"'.($qtdResult+1).'","query":"'.$query.'",';
						echo '"suggestion":[';
						$i=0;
						$new=true;
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							//array_walk($linha_dados, 'toUtf8');
							$i++;
							echo '{
								"id":"'.$linha_dados->id.'"
								,"name":"'.$linha_dados->name.'"
							}';
							if($query==$linha_dados->login)
								$new=false;
							//
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						if($new)
							echo ',{"id":"new","name":"'.$query.'"}';
						//
						echo ']}';
					}
				break;
				case "pagamentos": //ATUALIZA DADOS NA PAGINA
					$id_caixafc = isset($_REQUEST["id_caixafc"]) ? $_REQUEST["id_caixafc"] : false;
					$id_cliente_caixafc = isset($_REQUEST["id_cliente_caixafc"]) ? $_REQUEST["id_cliente_caixafc"] : false;
					$data_caixafc = isset($_REQUEST["data_caixafc"]) ? $_REQUEST["data_caixafc"] : false;
					$busca='';
					if($id_caixafc)
						$busca.=" id_caixafc='$id_caixafc' AND ";
					else if($id_cliente_caixafc)
						$busca.=" id_cliente_caixafc='$id_cliente_caixafc' AND ";
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
			}
		break;
		case "list": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "clientes": //ATUALIZA DADOS NA PAGINA
					$id_clientesfc = isset($_REQUEST["id_clientesfc"]) ? $_REQUEST["id_clientesfc"] : false;
					$sit_clientesfc = isset($_REQUEST["sit_clientesfc"]) ? $_REQUEST["sit_clientesfc"] : false;
					$busca='';
					if($id_clientesfc)
						$busca=" id_clientesfc='$id_clientesfc' AND ";
					else{
						if($sit_clientesfc)
							$busca=" sit_clientesfc='$sit_clientesfc' AND ";
						//
					}
					//fetch table rows from mysql db
					$sql = "SELECT * FROM fc_clientes WHERE $busca id_provedor='$id_provedor_usuario'";
					//echo $sql;
					$result = mysql_query($sql) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 637"}');
					
					//create an array
					$emparray = array();
					while($row =mysql_fetch_assoc($result)){
						$emparray[] = array_map('htmlentities',$row);
					}
					//$emparray = array_map('utf8_encode', $rows);
					echo json_encode($emparray);
					//
				break;
			}
		case "save": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "caixa":   //TIPO -> caixa
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
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
						if($id_provedor_usuario!='')
							$var['id_provedor']=$id_provedor_usuario;
						//
						if($login_usuario!='')
							$var['user_login']=$login_usuario;
						//
						if($id_usuario!='')
							$var['id_user_login']=$id_usuario;
						//
						if($grupo && $grupo!='')
							$var['grupo_parceria']=$grupo;
						else
							$var['grupo_parceria']=mysql_result(mysql_query("SELECT grupo_idadosfc FROM fcv_idados WHERE id_idadosfc='".$var['id_cliente_caixafc']."'"),0,"grupo_idadosfc");
						//
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
						$msg='Realizado com sucesso';
					}
					echo '{"msg":"'.$msg.'","id_caixafc":"'.$var['id_caixafc'].'"}';
				break;
				case "secretpp":    //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
					//
					//exit;
					class Facil_item01 extends simpleCRUD{
						protected $__table = "mk_secretpp";
						protected $__id = "id_secretpp";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_cliente_secretpp']>0){
						$resultadoDados = mysql_query("SELECT * FROM fcv_dados WHERE id_dadosfc='".$var['id_cliente_secretpp']."'");
						$linha_dados=mysql_fetch_object($resultadoDados);
						$var['comment_secretpp']=$linha_dados->nome_dadosfc." - ".$linha_dados->tel1_dadosfc." - ".$linha_dados->venc_dadosfc." - ".$linha_dados->sit_dadosfc." - vl:".$linha_dados->valor_dadosfc."";
					}
					//echo $var['comment_secretpp'];
					//exit;
					if($var['id_secretpp']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$facil_item = Facil_item01::find_by_id($var['id_secretpp']);
						if ($facil_item !== false){
							foreach ($facil_item->toArray() as $id=>$value){
								if(isset($var[$id]) && $var[$id]!=$value){
									echo $facil_item->$id.'-'.$var[$id];
									$facil_item->$id = utf8_decode($var[$id]);
								}
							}
							$facil_item->update();
							//
							$msg="atualizado secretpp:".$var['id_secretpp']."<Br>";
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
							$var['id_secretpp'] = $new_itens->id;
							//
							$msg='Cadastrado secretpp:'.$var['id_secretpp']."<Br>";
					}
					echo '{"msg":"'.$msg.'","id_secretpp":"'.$var['id_secretpp'].'"}';
				break;
				case "cliente":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
					//
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item01 extends simpleCRUD{
						protected $__table = "fc_clientes";
						protected $__id = "id_clientesfc";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					if($var['id_clientesfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
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
						//$var=$_GET;
						if($id_provedor_usuario!='')
							$var['id_provedor']=$id_provedor_usuario;
						//
						if($grupo!='')
							$var['grupo_parceria']=$grupo;
						//
						$var['sit_clientesfc']='ativo';
						//
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
						$msg='Realizado com Sucesso!<Br>';
					}
					echo '{"msg":"'.$msg.'","id_clientesfc":"'.$var['id_clientesfc'].'"}';
				break;
				case "servmensal":    //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once("_crud.class.php");
					//
					class Facil_item01 extends simpleCRUD{
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
					if($grupo!='')
						$var['grupo_parceria']=$grupo;
					//
					if($var['id_mensalfc']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						$facil_item = Facil_item01::find_by_id($var['id_mensalfc']); 
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
							$msg.='Atualizado ServiÁo Mensal!<Br>';
						}else{
							$inserir=true;
						}
					}else{
						$inserir=true;
					}
					if($inserir){// INSERE SERVICO MENSAL
						if($var['descricao_mensalfc']=='')
							$var['descricao_mensalfc']='MENSALIDADE INTERNET';
						//
						$var['sit_mensalfc']='ativo';
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
						$var['id_mensalfc'] = $new_itens->id;
						//
						$msg.='Cadastrado ServiÁo Mensal<Br>';
					}
					echo '{"msg":"'.$msg.'","id_mensalfc":"'.$var['id_mensalfc'].'"}';
				break;
			}
		break;
	}
}else{
	echo '{"JSON":true,"auth":false,"msg":"N„o Autenticado"}';
}			
?>