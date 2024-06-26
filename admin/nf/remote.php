<?php 
//importa funÁoes
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
		case "load": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "dados_empresa": //ATUALIZA DADOS NA PAGINA
					$resultadoDados = mysql_query("SELECT * FROM nf_empresa WHERE id_provedor='$id_provedor_usuario'
					") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 21"}');
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
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
					}
				break;
				case "dados_clientes": //ATUALIZA DADOS NA PAGINA
					$id_clientesnf = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$busca="id_provedor='$id_provedor_usuario'";
					if($id_clientesnf)
						$busca="id_clientesnf='$id_clientesnf'";
					else{
						$col = isset($_REQUEST["col"]) ? $_REQUEST["col"] : false;
						$val = isset($_REQUEST["val"]) ? $_REQUEST["val"] : false;
						if($col && $val){
							$busca=$col."='".$val."'";
						}
					}
					$select="SELECT * FROM nf_clientes WHERE $busca";
					//echo $select;
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 91"}');
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
							if($id_clientesnf=='' && $id=='id_clientesnf')
								$id_clientesnf=$value;
							//
							if($linha)
								$dados_linhas.='"'.$id.'":"'.$value.'",';
							//
						}
						$dados_linhas=substr($dados_linhas,0,-1);
						echo '{"auth":"'.$authSession.'","objeto":"","qtd":"'.$qtdLinhas.'","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
					}else{
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							array_walk($linha_dados, 'toUtf8');
							$dados_linhas.="<option value='".$linha_dados->id_clientesnf."'>".$linha_dados->nome_clientesnf."</option>";
						}
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","id_select":"select_banco",data":"'.$dados_linhas.'"}';
					}
				break;
				case "dados_notas": //ATUALIZA DADOS NA PAGINA
					$id_notasnf = isset($_REQUEST["id_notasnf"]) ? $_REQUEST["id_notasnf"] : false;
					$id_clientesnf = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id_notasnf)
						$busca="id_notasnf='$id_notasnf'";
					else{
						$col = isset($_REQUEST["col"]) ? $_REQUEST["col"] : false;
						$val = isset($_REQUEST["val"]) ? $_REQUEST["val"] : false;
						if($col && $val)
							$busca=$col."='".$val."'";
						else
							$busca="id_provedor='$id_provedor_usuario'";
						//
					}
					$select="SELECT * FROM nf_notas WHERE $busca $order";
					//echo $select;
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 91"}');
					$qtdLinhas=mysql_num_rows($resultadoDados);
					if ($qtdLinhas == 1){
						$colunas=mysql_fetch_assoc($resultadoDados);
						foreach ($colunas as $id=>$value){
							$value=toVarUtf8($value);
							$linha=false;
							if (strpos($id, "dados_empr_") !== false) {
								$id='id_empresanf';
								$arrayValue=explode("|",$value);
								$dados_linhas.='"id_empresanf":"'.$arrayValue[0].'",';
								$dados_linhas.='"nome_empresanf":"'.$arrayValue[1].'",';
							}
							if (strpos($id, "dados_clien_") !== false) {
								$arrayClientes=explode(";",$value);
								if(count($arrayClientes)>0)
									foreach ($arrayClientes as $value1){
										$arrayLinha=explode("|",$value1);
										if($arrayLinha[0]==$id_clientesnf){
											$dados_linhas.='"id_clientesnf":"'.$arrayLinha[0].'",';
											$dados_linhas.='"nome_clientesnf":"'.$arrayLinha[2].'",';
										}
									}
								//	
							}
							if (strpos($id, "dados_fatp_") !== false) {
								$arrayFat=explode(";",$value);
								if(count($arrayFat)>0){
									$dados_fat='';
									foreach ($arrayFat as $value1){
										$arrayLinha=explode("|",$value1);
										if($arrayLinha[0]==$id_clientesnf){
											$dados_fat.='{"id_cliente_servico":"'.$arrayLinha[0].'",';
											$dados_fat.='"tipo_servico":"'.$arrayLinha[10].'",';
											$dados_fat.='"valor_servico":"'.number_format($arrayLinha[3], 2, ',', '').'",';
											$dados_fat.='"unidade_servico":"'.$arrayLinha[6].'",';
											$dados_fat.='"descricao_servico":"'.$arrayLinha[2].'",';
											$dados_fat.='"qtd_contratada_servico":"'.$arrayLinha[7].'",';
											$dados_fat.='"qtd_fornecida_servico":"'.$arrayLinha[8].'",';
											$dados_fat.='"icms_servico":"'.$arrayLinha[4].'",';
											$dados_fat.='"reducao_servico":"'.$arrayLinha[5].'",';
											$dados_fat.='"alicota_servico":"'.$arrayLinha[9].'"},';
										}
									}
									$dados_fat=substr($dados_fat,0,-1);
									$dados_linhas.='"fat":['.$dados_fat.'],';
								}
							}
						}
						$dados_linhas=substr($dados_linhas,0,-1);
						echo '{"auth":"'.$authSession.'","objeto":"","qtd":"'.$qtdLinhas.'","cols":"'.count($colunas).'","data":{'.$dados_linhas.'}}';
					}else{
						while($linha_dados=mysql_fetch_object($resultadoDados)){
							array_walk($linha_dados, 'toUtf8');
							$dados_linhas.="<option value='".$linha_dados->id_clientesnf."'>".$linha_dados->nome_clientesnf."</option>";
						}
						echo '{"auth":"'.$authSession.'","qtd":"'.$qtdLinhas.'","id_select":"select_banco",data":"'.$dados_linhas.'"}';
					}
				break;
			}			
		break;
		case "busca": //ATUALIZA DADOS NA PAGINA
			$retorno = isset($_REQUEST["retorno"]) ? $_REQUEST["retorno"] : false;
			switch($tipo) {
				case "empresas": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca="(nome_empresanf like '%".$query."%' OR razao_empresanf like '%".$query."%' OR cnpj_empresanf like '".$query."')";
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM nf_empresa WHERE $busca") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
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
								"id":"'.$linha_dados->id_empresanf.'"
								,"name":"'.strtr($linha_dados->nome_empresanf, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«", "aaaaeeiooouucAAAAEEIOOOUUC").'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "clientes": //ATUALIZA DADOS NA PAGINA
					if($query!='*all')
						$busca="(nome_clientesnf like '%".$query."%' OR razao_clientesnf like '%".$query."%' OR cpf_cnpj_clientesnf like '".$query."')";
					//$resultadoDados = mysql_query("SELECT id_pessoais AS id_clientesfc, nome_pessoais AS nome_clientesfc FROM sis_dados_pessoais WHERE (nome_pessoais like '%".$query."%' OR cpf_cnpj_pessoais like '".$query."')") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
					$resultadoDados = mysql_query("SELECT * FROM nf_clientes WHERE $busca") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 24"}');
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
								"id":"'.$linha_dados->id_clientesnf.'"
								,"name":"'.strtr($linha_dados->nome_clientesnf, "·‡„‚ÈÍÌÛÙı˙¸Á¡¿√¬… Õ”‘’⁄‹«", "aaaaeeiooouucAAAAEEIOOOUUC").'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "notas": //ATUALIZA DADOS NA PAGINA
					$id_notasnf = isset($_REQUEST["id_notasnf"]) ? $_REQUEST["id_notasnf"] : false;
					$data_notasnf = isset($_REQUEST["data_notasnf"]) ? $_REQUEST["data_notasnf"] : false;
					$status_notasnf = isset($_REQUEST["status_notasnf"]) ? $_REQUEST["status_notasnf"] : false;
					$busca='';
					if($id_notasnf)
						$busca.=" id_notasnf='$id_notasnf' AND ";
					else{
						if($data_notasnf)
							$busca.=" data_caixafc='".converterDataSimples($data_notasnf)."' AND ";
						//
						if($status_notasnf)
							$busca.=" status_notasnf='$status_notasnf' AND ";
					}
					if($admin_usuario!='on') 
						$busca.=" id_user_notasnf='$id_usuario' AND ";
					//
					$select="SELECT * FROM nf_notas WHERE $busca id_notasnf!='0'";
					$resultadoDados = mysql_query($select) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 245"}');
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
							$arrayClientes=explode(";",$linha_dados->dados_clien_notasnf);
							$i++;
							echo '{
								"id":"'.$linha_dados->id_notasnf.'"
								,"name":"Notas Qtd:'.(count($arrayClientes)-1).' ('.$linha_dados->status_notasnf.') de R$ '.number_format($linha_dados->valor_total_notasnf, 2, ',', '').' - cadastrada em '.mostrarData($linha_dados->datatime_notasnf,false).'"
							}';
							if($i<mysql_num_rows($resultadoDados))
								echo ",";
						}
						echo ']}';
					}
				break;
				case "dados_nota": //ATUALIZA DADOS NA PAGINA
					$id_notasnf = isset($_REQUEST["id_notasnf"]) ? $_REQUEST["id_notasnf"] : false;
					$busca='';
					if($id_notasnf)
						$busca.=" id_notasnf='$id_notasnf' AND ";
					//
					if($admin_usuario!='on') 
						$busca.=" id_user_notasnf='$id_usuario' AND ";
					//
					$resultadoDados = mysql_query("SELECT * FROM nf_notas WHERE $busca id_notasnf!=0") or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 280"}');
					$qtdResult=mysql_num_rows($resultadoDados);
					if ($qtdResult != 1){
						if($retorno)
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{"'.$query.'":"'.$query.'"}}';
						else 
							echo '{"auth":"'.$authSession.'","qtd":"0","query":"'.$query.'","suggestion":{}}';
						//
						//
					}else{
						$linha_dados=mysql_fetch_object($resultadoDados);
						$clientesArray=explode(";",$linha_dados->dados_clien_notasnf);
						$faturasArray=explode(";",$linha_dados->dados_fatp_notasnf);
						echo '{"auth":"'.$authSession.'","qtd":"'.(count($clientesArray)-1).'","query":"'.$query.'",';
						echo '"suggestion":[';
						//
						if(count($faturasArray)>0){
							foreach ($faturasArray as $value){
								if($value!=''){
									$linhaArray=explode("|",$value);
									$valor_servicos[$linhaArray[0]]+=(int)$linhaArray[3];
								}
							}
						}
						$i=0;
						if(count($clientesArray)-1>0){
							foreach ($clientesArray as $value){
								if($value!=''){
									$linhaArray=explode("|",$value);
									$i++;
									echo '{
										"id":"'.$linhaArray[0].'"
										,"name":"Cliente:'.$linhaArray[2].' - Emissao:'.$linhaArray[22].' - Valor: R$ '.number_format($valor_servicos[$linhaArray[0]], 2, ',', '').'"
									}';
									if($i<count($clientesArray)-1)
										echo ",";
								}
							}
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
									$referencia="M S $mesA/$anoA";
									$codT=$mesA."".$anoA;
									$texto_filtro=' em mÍs '.$mesA.'/'.$anoA;
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
										$referencia="M S $mesA/$anoA";
										$codT=$anoA."".$mesA;
										$texto_filtro=' em mÍs '.$mesA.'/'.$anoA;
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
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 124"}');
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
						$resultadoDados = mysql_query($select." ".$order) or die ('{"success":false,errors":"N„o foi possÌvel realizar a consulta ao banco de dados linha 247"}');
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
				case "empresa":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( "../../../classes/crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "nf_empresa";
						protected $__id = "id_empresanf";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($var['id_empresanf']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_empresanf']);
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
							$msg="atualizado id:".$var['id_empresanf'];
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
						$var['id_empresanf'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_empresanf'];
					}
					echo '{"msg":"'.$msg.'","id_empresanf":"'.$var['id_empresanf'].'"}';
				break;
				case "cliente":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( "../../../classes/crud.class.php");
					//
					//exit;
					// GERA CLASSE DA(S) TABELA(S) USADA(S)
					class Facil_item extends simpleCRUD{
						protected $__table = "nf_clientes";
						protected $__id = "id_clientesnf";
					}
					$errors=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//$var=$_GET;
					if($id_provedor_usuario!='')
						$var['id_provedor']=$id_provedor_usuario;
					//
					if($id_usuario!='')
						$var['cod_user_clientesnf']=$id_usuario;
					//
					if($var['id_clientesnf']!=""){ //VERIFICA SE ATUALIZA DADOS OU INSERE DADOS
						//ATUALIZA DADOS COM O ID VINDO DA PAGINA
						//INSERE NOVOS DADOS NAS TABELAS
						$Facil_item = Facil_item::find_by_id($var['id_clientesnf']);
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
							$msg="atualizado id:".$var['id_clientesnf'];
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
						$var['id_clientesnf'] = $new_itens->id;
						//
						$msg='Cadastrado id:'.$var['id_clientesnf'];
					}
					echo '{"msg":"'.$msg.'","id_clientesnf":"'.$var['id_clientesnf'].'"}';
				break;
				case "nota":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					include_once( "../../../classes/crud.class.php");
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
								$var[$id][$i] = str_replace($chars, "", $var[$id][$i]);
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
								$profile=mysql_result(mysql_query("SELECT name_profilepp FROM mk_profilepp WHERE id_profilepp='".$var['id_profile_pp'][$i]."'"),0,"name_profilepp");
								$resultado = mysql_query("UPDATE mk_secretpp SET profile_secretpp='$profile',profile_save_secretpp='$profile',id_cliente_secretpp='".$var['id_clientesfc']."',tipo_secretpp='atz',comment_secretpp='".$var['nome_clientesfc']."' WHERE id_secretpp='".$var['id_secretpp'][$i]."'") or die ("error");
								$msg.='User pppoe atualizado:'.$var['id_secretpp'][$i]."<Br>";
							break;
							case "hotspot":
								$profile=mysql_result(mysql_query("SELECT name_profilehp FROM mk_profilehp WHERE id_profilehp='".$var['id_profile_hp'][$i]."'"),0,"name_profilehp");
								$resultado = mysql_query("UPDATE mk_secrethp SET profile_secrethp='$profile',profile_save_secrethp='$profile',id_cliente_secrethp='".$var['id_clientesfc']."',tipo_secrethp='atz',comment_secrethp='".$var['nome_clientesfc']."' WHERE id_secrethp='".$var['id_secrethp'][$i]."'") or die ("error");
								$msg.='User hotspot atualizado:'.$var['id_secrethp'][$i]."<Br>";
							break;
							case "binding":
								$profile=mysql_result(mysql_query("SELECT name_profilebi FROM mk_profilebi WHERE id_profilebi='".$var['id_profile_bi'][$i]."'"),0,"name_profilebi");
								$resultado = mysql_query("UPDATE mk_secretbi SET profile_secretbi='$profile',profile_save_secretbi='$profile',id_cliente_secretbi='".$var['id_clientesfc']."',tipo_secretbi='atz',comment_secretbi='".$var['nome_clientesfc']."' WHERE id_secretbi='".$var['id_secretbi'][$i]."'") or die ("error");
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
	echo '{"auth":false,"msg":"N„o Autenticado"}';
}			
?>