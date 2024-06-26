<?php
include("_conf.php");
//
if(isset($_SESSION['id_userfc'])){
	$cmd = isset($_REQUEST["cmd"]) ? $_REQUEST["cmd"] : false;
	$query = isset($_REQUEST["query"]) ? $_REQUEST["query"] : false;
	$tipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
	switch($cmd) {
		case "recibo": //ATUALIZA DADOS NA PAGINA
			$id = isset($_REQUEST["id_caixafc"]) ? $_REQUEST["id_caixafc"] : false;
			$select = new PDO_instruction();
			$select->con_pdo();
			$recibo = $select->select_pdo('SELECT * FROM fcv_recibos WHERE numero_recibofc = ?', array($id))[0];
			if($tipo=='email' OR $tipo=='sms'){
				$dados=array();
				$email_tel= isset($_REQUEST["email_tel"]) ? $_REQUEST["email_tel"] : false;
				$provedor = $select->select_pdo('SELECT * FROM fc_provedor WHERE id_provedorfc = ?', array($_SESSION['id_provedor']))[0];
				if($tipo=='email' && $email_tel){
					$texto_documentos=$provedor['email_recibo_provedorfc'];
					$data = array(
						'nome_cliente' => $recibo['nomecliente_recibofc']
						,'valor_recibo' => $recibo['valor_recibofc']
						,'data_pagamento' => $recibo['data_recibofc']
						,'id_recibo' => $recibo['md5recibo_recibofc']
					);
					while ( list( $key, $value ) = each( $data )){
						if ( preg_match( '/\%' . $key . '\%/i', $texto_documentos )){
							$texto_documentos = preg_replace( '/\%' . $key . '\%/', $value, $texto_documentos );
						}
					}
					$retorno=sendMail('','','','','','','',$email_tel,$texto_documentos,'RECIBO DE PAGAMENTO - '.$provedor['nome_provedorfc']);
					if($retorno[0]){
						$dados['error']=false;$dados['msg']=$retorno[1];
					}else{
						$dados['error']=true;$dados['msg']=$retorno[1];
					}
					echo json_encode($dados,JSON_UNESCAPED_UNICODE);
					//
				}else if($tipo=='sms' && $email_tel){
					
				}
			}else{
				//echo 'pages/gerar_recibo.php?tipo='.$tipo.'&id_recibo='.$recibo['md5recibo_recibofc'];
				header('Location: pages/gerar_recibo.php?tipo='.$tipo.'&id_recibo='.$recibo['md5recibo_recibofc']);
			}
			switch($tipo) {
				case "html": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$select = new PDO_instruction();
						$select->con_pdo();
						$result = $select->select_pdo('SELECT * FROM fc_clientes WHERE id_clientesfc = ?', array($id));
						if(count($result)==1){
							$forms=array();
							foreach ($result[0] as $id=>$value){
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
									$forms[$id]=$value;
								}
							}
							echo json_encode($forms,JSON_UNESCAPED_UNICODE);
						}else{
							echo json_encode(array(false));
						}
					}
					break;
				case "pdf": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$select = new PDO_instruction();
						$select->con_pdo();
						$result = $select->select_pdo('SELECT * FROM fc_sevmensal WHERE id_mensalfc = ?', array($id));
						if(count($result)==1){
							$forms=array();
							foreach ($result[0] as $id=>$value){
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
									$forms[$id]=$value;
								}
							}
							if($forms['id_user_sevmensalfc']>0)
								$forms['nome_secret']=$select->select_pdo('SELECT CONCAT(name_secretpp,":",id_secretpp," MK:",mk_secretpp) AS nome_secret FROM mk_secretpp WHERE id_secretpp = ?', array($forms['id_user_sevmensalfc']))[0]['nome_secret'];
								//
								echo json_encode($forms,JSON_UNESCAPED_UNICODE);
						}else{
							echo json_encode(array(false));
						}
					}
					break;
			}
		break;
		case "load": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "cliente": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$select = new PDO_instruction();
						$select->con_pdo();
						$result = $select->select_pdo('SELECT * FROM fc_clientes WHERE id_clientesfc = ?', array($id));
						if(count($result)==1){
							$forms=array();
							foreach ($result[0] as $id=>$value){
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
									$forms[$id]=$value;
								}
							}
							echo json_encode($forms,JSON_UNESCAPED_UNICODE);
						}else{
							echo json_encode(array(false));
						}
					}
				break;
				case "mensal": //ATUALIZA DADOS NA PAGINA
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$select = new PDO_instruction();
						$select->con_pdo();
						$result = $select->select_pdo('SELECT * FROM fc_sevmensal WHERE id_mensalfc = ?', array($id));
						if(count($result)==1){
							$forms=array();
							foreach ($result[0] as $id=>$value){
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
									$forms[$id]=$value;
								}
							}
							if($forms['id_user_sevmensalfc']>0)
								$forms['nome_secret']=$select->select_pdo('SELECT CONCAT(name_secretpp,":",id_secretpp," MK:",mk_secretpp) AS nome_secret FROM mk_secretpp WHERE id_secretpp = ?', array($forms['id_user_sevmensalfc']))[0]['nome_secret'];
							//
							echo json_encode($forms,JSON_UNESCAPED_UNICODE);
						}else{
							echo json_encode(array(false));
						}
					}
				break;
			}
		break;
		case "list":
			switch($tipo) {
				case "cliente": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					//
					$sit= isset($_REQUEST["sit"]) ? $_REQUEST["sit"] : false;
					if($sit && $sit!='all'){
						$busca.="`Sit` LIKE ? AND ";
						$arraybusca[]=$sit;
					}
					$vc= isset($_REQUEST["vc"]) ? $_REQUEST["vc"] : false;
					if($vc && $vc!='all'){
						if($vc=='on'){
							$busca.="`Vc` = ? AND ";
							$arraybusca[]='on';
						}else{
							$busca.="`Vc` != ? AND ";
							$arraybusca[]='on';
						}
					}
					$sel= isset($_REQUEST["sel"]) ? $_REQUEST["sel"] : false;
					$text= isset($_REQUEST["text"]) ? $_REQUEST["text"] : false;
					if($sel && $text){
						switch($sel) {
							case "Tel":
								$busca.="(replace(replace(replace(`Tel1`,'-',''),'(',''),')','') LIKE ? OR replace(replace(replace(`Tel1`,'-',''),'(',''),')','') LIKE ? OR replace(replace(replace(`Tel1`,'-',''),'(',''),')','') LIKE ?)AND ";
								$arraybusca[]='%'.str_replace($textAtua, $textNew, $text).'%';$arraybusca[]='%'.str_replace($textAtua, $textNew, $text).'%';$arraybusca[]='%'.str_replace($textAtua, $textNew, $text).'%';
							break;
							case "Doc":
								$busca.="replace(replace(replace(`Doc`,'-',''),'.',''),'/','') LIKE ?  AND ";
								$arraybusca[]='%'.str_replace($textAtua, $textNew, $text).'%';
								break;
							default:
								$busca.="`$sel` LIKE ? AND ";
								$arraybusca[]='%'.$text.'%';
							break;
						}
					}
					//
					if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
						$grupo=$_SESSION['grupo'];
						$busca.="`Grupo` LIKE ? AND ";
						$arraybusca[]=$grupo;
					}
					$busca.="`Provedor`= ?";
					$arraybusca[]=$_SESSION['id_provedor'];
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fca_clientes WHERE $busca", $arraybusca);
					$retorno=array();
					$retorno["qtd"]=count($result);
					if(count($result)>0){
						$dados=array();
						foreach ($result as $value){
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "pagamentos": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					//
					$id=isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$busca.="`id_pagamentosfc` = ?";
						$arraybusca[]=$id;
					}else{
						$mes= isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
						if($mes && $mes!='all'){
							$tipo= isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
							switch($tipo) {
								case "pagamento":
									$busca.="`mes_pagamentosfc` LIKE ? AND ";
									$arraybusca[]=$mes;
								break;
								case "divida":
									$busca.="`mes_dividasfc` LIKE ? AND ";
									$arraybusca[]=$mes;
								break;
								case "credito":
									$busca.="`mes_creditosfc` LIKE ? AND ";
									$arraybusca[]=$mes;
								break;
								default:
									$busca.="`mes_pagamentosfc` LIKE ? AND ";
									$arraybusca[]=$mes;
								break;
							}
						}
						//
						$user= isset($_REQUEST["user"]) ? $_REQUEST["user"] : false;
						if($user && $user!='all'){
							$busca.="`user_pagamentosfc` LIKE ? AND ";
							$arraybusca[]=$user;
						}
						//
						$nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
						if($nome){
							$busca.="`nome_pagamentosfc` LIKE ? AND ";
							$arraybusca[]='%'.$nome.'%';
						}
						//
						if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
							$grupo=$_SESSION['grupo'];
							$busca.="`grupo_parceria` LIKE ? AND ";
							$arraybusca[]=$grupo;
						}
						$busca.="`id_provedor`= ?";
						$arraybusca[]=$_SESSION['id_provedor'];
					}
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fcv_pagamentos WHERE $busca", $arraybusca);
					$retorno=array();
					$retorno["qtd"]=count($result);
					$retorno["total"]=0;
					$retorno["total_user"]=array();
					if(count($result)>0){
						$dados=array();
						foreach ($result as $value){
							$retorno["total"]+=$value['saldo_pagamentosfc'];
							$retorno["total_user"][$value['user_pagamentosfc']]+=$value['saldo_pagamentosfc'];
							$value['mes_pagamentosfc']=mostrarMes($value['mes_pagamentosfc']);
							if (strpos($value['datas_pagamentosfc'], ",") !== false) {
								$arrayDatas=explode(",",$value['datas_pagamentosfc']);
								$value['datas_pagamentosfc']='';
								foreach ($arrayDatas as $datas){
									$value['datas_pagamentosfc'].=mostrarDataSimples($datas).',';
								}
								$value['datas_pagamentosfc']=substr($value['datas_pagamentosfc'],0,-1);
							}else{
								$value['datas_pagamentosfc']=mostrarDataSimples($value['datas_pagamentosfc']);
							}
							if (strpos($value['datas_creditosfc'], ",") !== false) {
								$arrayDatas=explode(",",$value['datas_creditosfc']);
								$value['datas_creditosfc']='';
								foreach ($arrayDatas as $datas){
									$value['datas_creditosfc'].=mostrarDataSimples($datas).',';
								}
								$value['datas_creditosfc']=substr($value['datas_creditosfc'],0,-1);
							}else{
								$value['datas_creditosfc']=mostrarDataSimples($value['datas_creditosfc']);
							}
							if (strpos($value['datas_dividasfc'], ",") !== false) {
								$arrayDatas=explode(",",$value['datas_dividasfc']);
								$value['datas_dividasfc']='';
								foreach ($arrayDatas as $datas){
									$value['datas_dividasfc'].=mostrarDataSimples($datas).',';
								}
								$value['datas_dividasfc']=substr($value['datas_dividasfc'],0,-1);
							}else{
								$value['datas_dividasfc']=mostrarDataSimples($value['datas_dividasfc']);
							}
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "recebiveis": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					//
					$id=isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$busca.="`id_pagamentosfc` = ?";
						$arraybusca[]=$id;
					}else{
						$mes= isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
						if($mes && $mes!='all'){
							$busca.="`mes_pagamentosfc` LIKE ? AND ";
							$arraybusca[]=$mes;
						}
						//
						$user= isset($_REQUEST["user"]) ? $_REQUEST["user"] : false;
						if($user && $user!='all'){
							$busca.="`user_pagamentosfc` LIKE ? AND ";
							$arraybusca[]=$user;
						}
						//
						$nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
						if($nome){
							$busca.="`nome_pagamentosfc` LIKE ? AND ";
							$arraybusca[]='%'.$nome.'%';
						}
						//
						if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
							$grupo=$_SESSION['grupo'];
							$busca.="`grupo_parceria` LIKE ? AND ";
							$arraybusca[]=$grupo;
						}
						$busca.="`id_provedor`= ?";
						$arraybusca[]=$_SESSION['id_provedor'];
					}
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fcv_pagamentos WHERE $busca", $arraybusca);
					$retorno=array();
					$retorno["qtd"]=count($result);
					$retorno["total"]=0;
					$retorno["total_user"]=array();
					if(count($result)>0){
						$dados=array();
						foreach ($result as $value){
							$retorno["total"]+=$value['saldo_pagamentosfc'];
							$retorno["total_user"][$value['user_pagamentosfc']]+=$value['saldo_pagamentosfc'];
							$value['mes_pagamentosfc']=mostrarMes($value['mes_pagamentosfc']);
							if (strpos($value['datas_pagamentosfc'], ",") !== false) {
								$arrayDatas=explode(",",$value['datas_pagamentosfc']);
								$value['datas_pagamentosfc']='';
								foreach ($arrayDatas as $datas){
									$value['datas_pagamentosfc'].=mostrarDataSimples($datas).',';
								}
								$value['datas_pagamentosfc']=substr($value['datas_pagamentosfc'],0,-1);
							}else{
								$value['datas_pagamentosfc']=mostrarDataSimples($value['datas_pagamentosfc']);
							}
							if (strpos($value['datas_creditosfc'], ",") !== false) {
								$arrayDatas=explode(",",$value['datas_creditosfc']);
								$value['datas_creditosfc']='';
								foreach ($arrayDatas as $datas){
									$value['datas_creditosfc'].=mostrarDataSimples($datas).',';
								}
								$value['datas_creditosfc']=substr($value['datas_creditosfc'],0,-1);
							}else{
								$value['datas_creditosfc']=mostrarDataSimples($value['datas_creditosfc']);
							}
							if (strpos($value['datas_dividasfc'], ",") !== false) {
								$arrayDatas=explode(",",$value['datas_dividasfc']);
								$value['datas_dividasfc']='';
								foreach ($arrayDatas as $datas){
									$value['datas_dividasfc'].=mostrarDataSimples($datas).',';
								}
								$value['datas_dividasfc']=substr($value['datas_dividasfc'],0,-1);
							}else{
								$value['datas_dividasfc']=mostrarDataSimples($value['datas_dividasfc']);
							}
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "cobrancas": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					//
					$id= isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$busca.="`id_cobrancasfc` = ?";
						$arraybusca[]=$id;
					}else{
						$mes= isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
						if($mes && $mes!='all'){
							$busca.="`mes_cobrancasfc` LIKE ? AND ";
							$arraybusca[]=$mes;
						}
						//
						$pg= isset($_REQUEST["pg"]) ? $_REQUEST["pg"] : false;
						if($pg && $pg!='all'){
							if($pg!='on'){
								$busca.="`pago_cobrancasfc` LIKE ? AND `tipo_pago_cobrancasfc` LIKE ? AND ";
								$arraybusca[]='on';$arraybusca[]=$pg;
							}else{
								$busca.="`pago_cobrancasfc` LIKE ? AND ";
								$arraybusca[]='on';
							}
						}
						//
						$nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
						if($nome){
							$busca.="`nome_cliente_cobrancasfc` LIKE ? AND ";
							$arraybusca[]='%'.$nome.'%';
						}
						//
						if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
							$grupo=$_SESSION['grupo'];
							$busca.="`grupo_parceria` LIKE ? AND ";
							$arraybusca[]=$grupo;
						}
						$busca.="`id_provedor`= ?";
						$arraybusca[]=$_SESSION['id_provedor'];
					}
					$select = new PDO_instruction(); 
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fcv_cobrancas WHERE $busca", $arraybusca);
					$retorno=array();
					$retorno["qtd"]=count($result);
					if(count($result)>0){
						$dados=array();
						foreach ($result as $value){
							$value['mes_cobrancasfc']=mostrarMes($value['mes_cobrancasfc']);
							$value['periodo_cobrancasfc']=substr($value['periodo_cobrancasfc'],0,-1);
							if (strpos($value['periodo_cobrancasfc'], ";") !== false) {
								$arrayDatas=explode(";",$value['periodo_cobrancasfc']);
								$value['periodo_cobrancasfc']='';
								foreach ($arrayDatas as $datas){
									$arrayData=explode("|",$datas);
									$value['periodo_cobrancasfc'].=mostrarDataSimples($arrayData[0]).'|'.mostrarDataSimples($arrayData[1]).'<br>';
								}
								$value['periodo_cobrancasfc']=substr($value['periodo_cobrancasfc'],0,-1);
							}else{
								$arrayData=explode("|",$value['periodo_cobrancasfc']);
								$value['periodo_cobrancasfc']=mostrarDataSimples($arrayData[0]).'|'.mostrarDataSimples($arrayData[1]);
							}
							$value['descricao_cobrancasfc']=str_replace(";", "<br>", substr($value['descricao_cobrancasfc'],0,-1));
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
					break;
				case "faturas": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					//
					$id= isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$busca.="`id_faturafc` = ?";
						$arraybusca[]=$id;
					}else{
						$mes= isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
						if($mes && $mes!='all'){
							$busca.="`mes_faturafc` LIKE ? AND ";
							$arraybusca[]=$mes;
						}
						//
						$pg= isset($_REQUEST["pg"]) ? $_REQUEST["pg"] : false;
						if($pg && $pg!='all'){
							if($pg!='on'){
								$busca.="`pago_faturafc` LIKE ? AND `tipo_pg_faturafc` LIKE ? AND ";
								$arraybusca[]='on';$arraybusca[]=$pg;
							}else{
								$busca.="`pago_faturafc` LIKE ? AND ";
								$arraybusca[]='on';
							}
						}
						//
						$nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
						if($nome){
							$busca.="`cliente_faturafc` LIKE ? AND ";
							$arraybusca[]='%'.$nome.'%';
						}
						//
						if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
							$grupo=$_SESSION['grupo'];
							$busca.="`grupo_parceria` LIKE ? AND ";
							$arraybusca[]=$grupo;
						}
						$busca.="`id_provedor`= ?";
						$arraybusca[]=$_SESSION['id_provedor'];
					}
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fcv_faturas WHERE $busca", $arraybusca);
					$retorno=array();
					$retorno["qtd"]=count($result);
					if(count($result)>0){
						$dados=array();
						foreach ($result as $value){
							$value['mes_faturafc']=mostrarMes($value['mes_faturafc']);
							$value['periodo_faturafc']=substr($value['periodo_faturafc'],0,-1);
							if (strpos($value['periodo_faturafc'], ";") !== false) {
								$arrayDatas=explode(";",$value['periodo_faturafc']);
								$value['periodo_faturafc']='';
								foreach ($arrayDatas as $datas){
									$arrayData=explode("|",$datas);
									$value['periodo_faturafc'].=mostrarDataSimples($arrayData[0]).'|'.mostrarDataSimples($arrayData[1]).'<br>';
								}
								$value['periodo_faturafc']=substr($value['periodo_faturafc'],0,-1);
							}else{
								$arrayData=explode("|",$value['periodo_faturafc']);
								$value['periodo_faturafc']=mostrarDataSimples($arrayData[0]).'|'.mostrarDataSimples($arrayData[1]);
							}
							$value['descricao_faturafc']=str_replace(";", "<br>", substr($value['descricao_faturafc'],0,-1));
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "inadimplentes": //ATUALIZA DADOS NA PAGINA
				    $arraybusca=array();
				    $busca='';
				    //
				    $id= isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
				    if($id){
				        $busca.="`id_mensalfc` = ?";
				        $arraybusca[]=$id;
				    }else{
				        //
				        $nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
				        if($nome){
				            $busca.="`cliente_mensalfc` LIKE ? AND ";
				            $arraybusca[]='%'.$nome.'%';
				        }
				        //
				        $grupo= isset($_REQUEST["grupo"]) ? $_REQUEST["grupo"] : false;
				        if($grupo && $grupo!='all'){
				            $busca.='`grupo_parceria` LIKE ? AND ';
				            $arraybusca[]=$grupo;
				        }else if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
				            $grupo=$_SESSION['grupo'];
				            $busca.="`grupo_parceria` LIKE ? AND ";
				            $arraybusca[]=$grupo;
				        }
				        $matual= isset($_REQUEST["matual"]) ? $_REQUEST["matual"] : false;
				        if($matual && $matual=='on'){
				            $busca.='`mes_atual_mensalfc` LIKE ? AND ';
				            $arraybusca[]='on';
				        }else if($matual && $matual!='all'){
				            $busca.='`mes_atual_mensalfc`!= ? AND ';
				            $arraybusca[]='on';
				        }
				        $busca.="`id_provedor`= ?";
				        $arraybusca[]=$_SESSION['id_provedor'];
				    }
				    $select = new PDO_instruction();
				    $select->con_pdo();
				    $result = $select->select_pdo("SELECT id_mensalfc as Id,cliente_mensalfc as Nome,end_mensalfc as End,telefones_mensalfc as Tels,sit_mensalfc as Sit,qtd_mensalfc as Qtd,valor_mensalfc as Valor,total_encargos_mensalfc as Encargos,(valor_mensalfc+total_encargos_mensalfc) as Total,data_mensalfc as Vencimentos,grupo_parceria as Grupo,id_provedor as Provedor FROM `fca_mensalidades` WHERE $busca", $arraybusca);
				    $retorno=array();
				    $retorno["qtd"]=count($result);
				    $retorno["total"]=0;
				    $retorno["total_grupo"]=array();
				    if(count($result)>0){
				        $dados=array();
				        foreach ($result as $id=>$value){
				            if($value["Sit"]=='bloqueado')
				                $value["id_bloqueio"]=$select->select_pdo("SELECT id_bloqueiosfc FROM fc_bloqueios WHERE `id_cliente_bloqueiosfc`= ? ORDER BY `id_bloqueiosfc` DESC LIMIT 1", array($value["Id"]))[0]['id_bloqueiosfc'];
				            else
				                $value["id_bloqueio"]='0';
				            //
				            $retorno["total"]+=($value['Valor']+$value['Encargos']);
				            $retorno["total_grupo"][$value['grupo_parceria']]+=($value['Valor']+$value['Encargos']);
				            $dados[]=$value;
				        }
				        //print_r($dados);
				        $retorno["data"]=$dados;
				    }
				    echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
			    break;
				case "dividas": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					//
					$id= isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$busca.="`id_dividasfc` = ?";
						$arraybusca[]=$id;
					}else{
						$mes= isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
						if($mes && $mes!='all'){
							$busca.="`mes_dividasfc` LIKE ? AND ";
							$arraybusca[]=$mes;
						}
						//
						$nome= isset($_REQUEST["nome"]) ? $_REQUEST["nome"] : false;
						if($nome){
							$busca.="`cliente_dividasfc` LIKE ? AND ";
							$arraybusca[]='%'.$nome.'%';
						}
						//
						if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
							$grupo=$_SESSION['grupo'];
							$busca.="`grupo_parceria` LIKE ? AND ";
							$arraybusca[]=$grupo;
						}
						$busca.="`id_provedor`= ?";
						$arraybusca[]=$_SESSION['id_provedor'];
					}
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fcv_dividas WHERE $busca", $arraybusca);
					$retorno=array();
					$retorno["qtd"]=count($result);
					$retorno["total"]=0;
					$retorno["total_grupo"]=array();
					if(count($result)>0){
						$dados=array();
						foreach ($result as $id=>$value){
							$retorno["total"]+=($value['valor_dividasfc']+$value['encargos_dividasfc']);
							$retorno["total_grupo"][$value['grupo_parceria']]+=($value['valor_dividasfc']+$value['encargos_dividasfc']);
							$value['mes_dividasfc']=mostrarMes($value['mes_dividasfc']);
							$value['data_dividasfc']=mostrarDataSimples($value['data_dividasfc']);
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "bloqueios": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					//
					$id= isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$busca.="`id_cliente_bloqueiosfc` = ?";
						$arraybusca[]=$id;
					}else{
						if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
							$grupo=$_SESSION['grupo'];
							$busca.="`grupo_parceria` LIKE ? AND ";
							$arraybusca[]=$grupo;
						}
						$busca.="`id_provedor`= ?";
						$arraybusca[]=$_SESSION['id_provedor'];
					}
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fc_bloqueios WHERE $busca", $arraybusca);
					$retorno=array();
					$retorno["qtd"]=count($result);
					if(count($result)>0){
						$dados=array();
						foreach ($result as $id=>$value){
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "recebimentos": //ATUALIZA DADOS NA PAGINA
				    $arraybusca=array();
				    $arraybusca2=array();
				    $busca='';
				    //
				    $user= isset($_REQUEST["user"]) ? $_REQUEST["user"] : false;
				    if($user && $user!='all'){
				        if($_SESSION['login_userfc']=='cyberuv'){
				            $busca.="`cx`.`user_login` LIKE ? AND ";
				            $arraybusca[]='cyberuv';
				        }else{
   				            $busca.="`cx`.`user_login` LIKE ? AND ";
    				        $arraybusca[]=$user;
				        }
				    }else{
				        if($_SESSION['login_userfc']=='cyberuv'){
				            $busca.="`cx`.`user_login` LIKE ? AND ";
				            $arraybusca[]='cyberuv';
				        }
				    }
				    //
				    $ano= isset($_REQUEST["ano"]) ? $_REQUEST["ano"] : false;
				    if($ano && $ano!='all'){
				        $busca.='DATE_FORMAT(`cx`.`data_credito_caixafc`,"%Y") LIKE ? AND ';
				        $arraybusca[]=$ano;
				    }
				    //
				    $mes= isset($_REQUEST["mes"]) ? $_REQUEST["mes"] : false;
				    if($mes && $mes!='all'){
				        $busca.='DATE_FORMAT(`cx`.`data_credito_caixafc`,"%m") LIKE ? AND ';
				        $arraybusca[]=$mes;
				    }
				    //
				    $grupo= isset($_REQUEST["grupo"]) ? $_REQUEST["grupo"] : false;
				    if($grupo && $grupo!='all'){
				        $busca.='`cl`.`grupo_parceria` LIKE ? AND ';
				        $arraybusca[]=$grupo;
				    }else if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
				        $grupo=$_SESSION['grupo'];
				        $busca.="`cl`.`grupo_parceria` LIKE ? AND ";
				        $arraybusca[]=$grupo;
				    }
				    $busca.="`cx`.`id_provedor`= ?";
				    $arraybusca[]=$_SESSION['id_provedor'];
                    //
				    $select = new PDO_instruction();
				    $select->con_pdo();
				    $group= isset($_REQUEST["group"]) ? $_REQUEST["group"] : false;
				    if($group=='admin'){
				        $selectDados="SELECT DATE_FORMAT(`cx`.`data_credito_caixafc`,\"%m/%Y\") AS Mes, `cx`.`grupo_user_caixafc` AS Login, COUNT(*) AS Qtd, SUM(`cx`.`valor_caixafc`) AS Valor, SUM(`cx`.`valor_taxa_caixafc`) AS Descontos, SUM(`cx`.`valor_caixafc`)-SUM(`cx`.`valor_taxa_caixafc`) AS Liquido, `cl`.`grupo_parceria` AS Grupo, GROUP_CONCAT(`cx`.`id_caixafc` separator '|') AS Id, GROUP_CONCAT(`cl`.`nome_clientesfc` separator '|') AS Clientes, GROUP_CONCAT(`cx`.`valor_caixafc` separator '|') AS Valores, GROUP_CONCAT(`cx`.`data_credito_caixafc` separator '|') AS Datas FROM `fc_caixa` AS cx INNER JOIN `fc_clientes` AS cl ON `cl`.`id_clientesfc`=`cx`.`id_cliente_caixafc`
                        WHERE $busca
        				group by DATE_FORMAT(`cx`.`data_credito_caixafc`,\"%m/%Y\"),`cx`.`grupo_user_caixafc`,`cl`.`grupo_parceria` ORDER BY `cx`.`datatime_caixafc` DESC";
				    }else{
				        $selectDados="SELECT DATE_FORMAT(`cx`.`data_credito_caixafc`,\"%m/%Y\") AS Mes, `cx`.`user_login` AS Login, COUNT(*) AS Qtd, SUM(`cx`.`valor_caixafc`) AS Valor, SUM(`cx`.`valor_taxa_caixafc`) AS Descontos, SUM(`cx`.`valor_caixafc`)-SUM(`cx`.`valor_taxa_caixafc`) AS Liquido, `cl`.`grupo_parceria` AS Grupo, GROUP_CONCAT(`cx`.`id_caixafc` separator '|') AS Id, GROUP_CONCAT(`cl`.`nome_clientesfc` separator '|') AS Clientes, GROUP_CONCAT(`cx`.`valor_caixafc` separator '|') AS Valores, GROUP_CONCAT(`cx`.`data_credito_caixafc` separator '|') AS Datas FROM `fc_caixa` AS cx INNER JOIN `fc_clientes` AS cl ON `cl`.`id_clientesfc`=`cx`.`id_cliente_caixafc` 
                        WHERE $busca
        				group by DATE_FORMAT(`cx`.`data_credito_caixafc`,\"%m/%Y\"),`cx`.`user_login`,`cl`.`grupo_parceria` ORDER BY `cx`.`datatime_caixafc` DESC";
				    }
				    
				    $result = $select->select_pdo($selectDados, $arraybusca);
				    $retorno=array();
				    $retorno["qtd"]=count($result);
				    $retorno["total"]=0;
				    $retorno["total_grupo"]=array();
				    if(count($result)>0){
				        $dados=array();
				        foreach ($result as $id=>$value){
				            $dados[]=$value;
				        }
				        //print_r($dados);
				        $retorno["data"]=$dados;
				    }
				    echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
                break;
				case "recebimentos_previstos": //ATUALIZA DADOS NA PAGINA
				    $arraybusca=array();
				    $busca='';
				    //
				    $grupo= isset($_REQUEST["grupo"]) ? $_REQUEST["grupo"] : false;
				    if($grupo && $grupo!='all'){
				        $busca.='`cb`.`grupo_parceria` LIKE ? AND ';
				        $arraybusca[]=$grupo;
				    }else if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
				        $grupo=$_SESSION['grupo'];
				        $busca.="`cb`.`grupo_parceria` LIKE ? AND ";
				        $arraybusca[]=$grupo;
				    }
				    $busca.="`cb`.`id_provedor`= ?";
				    $arraybusca[]=$_SESSION['id_provedor'];
				    //
				    $select = new PDO_instruction();
				    $select->con_pdo();
				    $group= isset($_REQUEST["group"]) ? $_REQUEST["group"] : false;
				    if($group=='admin' OR $_SESSION['grupo_userfc']=='admin' && $grupo=='all'){
				        $selectDados="SELECT DATE_FORMAT(`cb`.`vencimento_cobrancasfc`,\"%m/%Y\") AS Mes, COUNT(*) AS Qtd, SUM(`cb`.`valor_atual_cobrancasfc`) AS Valor, `cb`.`grupo_parceria` AS Grupo, GROUP_CONCAT(`cb`.`id_cobrancasfc` separator '|') AS Id, GROUP_CONCAT(`cb`.`mes_cobrancasfc` separator '|') AS Meses, GROUP_CONCAT(`cb`.`nome_cliente_cobrancasfc` separator '|') AS Clientes, GROUP_CONCAT(`cb`.`valor_atual_cobrancasfc` separator '|') AS Valores, GROUP_CONCAT(DATE_FORMAT(`cb`.`vencimento_cobrancasfc`,\"%d/%m/%Y\") separator '|') AS Datas, GROUP_CONCAT(`cb`.`md5_cobrancasfc` separator '|') AS Md5, GROUP_CONCAT(`cb`.`email_cobrancasfc` separator '|') AS Email, GROUP_CONCAT(REPLACE(`cb`.`telefones_cobrancasfc`,'|', ',') separator '|') AS Tels, GROUP_CONCAT(`cb`.`text_sit_cobrancasfc` separator '|') AS Status, GROUP_CONCAT(`cb`.`sit_cliente_cobrancasfc` separator '|') AS Sit FROM `fcv_cobrancas` AS `cb` WHERE `cb`.`sit_cliente_cobrancasfc`!='inativo' AND DATE_FORMAT(`cb`.`vencimento_cobrancasfc`,\"%Y-%m\") LIKE DATE_FORMAT(CURDATE(),\"%Y-%m\") AND `cb`.`pago_cobrancasfc`!='on' AND 
                        $busca
        				group by `cb`.`grupo_parceria`";
				    }else{
				        $selectDados="SELECT DATE_FORMAT(`cb`.`vencimento_cobrancasfc`,\"%m/%Y\") AS Mes, COUNT(*) AS Qtd, SUM(`cb`.`valor_atual_cobrancasfc`) AS Valor, `cb`.`grupo_parceria` AS Grupo, GROUP_CONCAT(`cb`.`id_cobrancasfc` separator '|') AS Id, GROUP_CONCAT(`cb`.`mes_cobrancasfc` separator '|') AS Meses, GROUP_CONCAT(`cb`.`nome_cliente_cobrancasfc` separator '|') AS Clientes, GROUP_CONCAT(`cb`.`valor_atual_cobrancasfc` separator '|') AS Valores, GROUP_CONCAT(DATE_FORMAT(`cb`.`vencimento_cobrancasfc`,\"%d/%m/%Y\") separator '|') AS Datas, GROUP_CONCAT(`cb`.`md5_cobrancasfc` separator '|') AS Md5, GROUP_CONCAT(`cb`.`email_cobrancasfc` separator '|') AS Email, GROUP_CONCAT(REPLACE(`cb`.`telefones_cobrancasfc`,'|',',') separator '|') AS Tels, GROUP_CONCAT(`cb`.`text_sit_cobrancasfc` separator '|') AS Status, GROUP_CONCAT(`cb`.`sit_cliente_cobrancasfc` separator '|') AS Sit FROM `fcv_cobrancas` AS `cb` WHERE `cb`.`sit_cliente_cobrancasfc`!='inativo' AND DATE_FORMAT(`cb`.`vencimento_cobrancasfc`,\"%Y-%m\") LIKE DATE_FORMAT(CURDATE(),\"%Y-%m\") AND `cb`.`pago_cobrancasfc`!='on' AND $busca";
				    }
				    $result = $select->select_pdo($selectDados, $arraybusca);
				    $retorno=array();
				    $retorno["qtd"]=count($result);
				    $retorno["total"]=0;
				    $retorno["total_grupo"]=array();
				    if(count($result)>0){
				        $dados=array();
				        foreach ($result as $id=>$value){
				            $dados[]=$value;
				        }
				        //print_r($dados);
				        $retorno["data"]=$dados;
				    }
				    echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
                break;
			}
		break;
		case "select":
			switch($tipo) {
				case "ufs": //ATUALIZA DADOS NA PAGINA
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo('SELECT Uf FROM fca_cidades GROUP BY Uf');
					$retorno=array();
					foreach ($result as $id=>$value){
						$retorno[]=$value['Uf'];
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "cidades": //ATUALIZA DADOS NA PAGINA
					$uf = isset($_REQUEST["uf"]) ? $_REQUEST["uf"] : false;
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo('SELECT Cidade FROM fca_cidades WHERE Uf = ?', array($uf));
					$retorno=array();
					foreach ($result as $id=>$value){
						$retorno[]=$value['Cidade'];
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
				case "servicos": //ATUALIZA DADOS NA PAGINA
					$id_cliente= isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo('SELECT id_mensalfc,descricao_mensalfc,valor_sevmensalfc,sit_mensalfc FROM fc_sevmensal WHERE id_cliente_mensalfc = ?', array($id_cliente));
					$retorno=array();
					$retorno[]='sel|Selecione o Serviço';
					foreach ($result as $id=>$value){
						$retorno[]=$value['id_mensalfc'].'|'.$value['descricao_mensalfc'].' R$'.number_format($value['valor_sevmensalfc'], 2, ',', '.').'-'.$value['sit_mensalfc'];
					}
					$retorno[]='new|Cadastrar Novo';
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
			}
		break;
		case "list-group":
			switch($tipo) {
				case "faturas": //ATUALIZA DADOS NA PAGINA
					$arraybusca=array();
					$busca='';
					$id_cliente= isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					$sit= isset($_REQUEST["sit"]) ? $_REQUEST["sit"] : false;
					if($id_cliente){
						$busca.="`id_cobrancasfc` = ?";
						$arraybusca[]=$id_cliente;
					}
					if($sit && $sit!='all'){
						if($sit=='pg'){
							$busca.=" AND (`tipo_pago_cobrancasfc`=? OR `tipo_pago_cobrancasfc`=?)";
							$arraybusca[]='TOTAL';$arraybusca[]='MAIOR';
							$textBusca=' paga';
						}else if($sit=='ab'){
							$busca.=" AND `valor_atual_cobrancasfc` > ?";
							$arraybusca[]=0;
							$textBusca=' em aberto';
						}
					}
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo("SELECT * FROM fcv_cobrancas WHERE $busca ORDER BY vencimento_cobrancasfc DESC", $arraybusca);
					$retorno=array();
					//
					$retorno= $select->select_pdo("SELECT id_clientesfc AS Id,nome_clientesfc AS Nome,CONCAT(end1_clientesfc,', ',num1_clientesfc,' - ',bar1_clientesfc,' - ',cid1_clientesfc,'-',uf1_clientesfc) AS End,sit_clientesfc AS Sit,'' AS Mensalidade,grupo_parceria AS Grupo,email_clientesfc AS Email,tel1_clientesfc AS Tel1 FROM fc_clientes WHERE id_clientesfc= ?", array($id_cliente))[0];
					if($retorno["Sit"]=='bloqueado'){
					    $retorno["id_bloqueio"]=$select->select_pdo("SELECT id_bloqueiosfc FROM fc_bloqueios WHERE `id_cliente_bloqueiosfc`= ? ORDER BY `id_bloqueiosfc` DESC LIMIT 1", array($retorno["Id"]))[0]['id_bloqueiosfc'];
					} 
					//
					if(count($result[0])>0){
						$retorno["qtd"]=count($result);
						$dados=array();
						if($retorno["qtd"]>1 && $sit!='pg'){
							$total = $select->select_pdo("SELECT md5_cobrancasfc,id_cobrancasfc,GROUP_CONCAT(mes_cobrancasfc ORDER BY mes_cobrancasfc ASC) AS  mes_cobrancasfc,GROUP_CONCAT(DATE_FORMAT(vencimento_cobrancasfc,'%d/%m/%Y') ORDER BY vencimento_cobrancasfc ASC) AS vencimento_cobrancasfc,SUM(valor_atual_cobrancasfc) AS valor_atual_cobrancasfc,grupo_parceria FROM fcv_cobrancas WHERE $busca GROUP BY id_cobrancasfc", $arraybusca)[0];
							$total['tipo_item']='total';
							$dados[]=$total;
						}
						foreach ($result as $id=>$value){
							$value['text_mes_cobrancasfc']=mostrarMes($value['mes_cobrancasfc']);
							$value['vencimento_cobrancasfc']=mostrarDataSimples($value['vencimento_cobrancasfc']);
							$dataPgArray=explode(",",$value['datas_pg_cobrancasfc']);
							$value['datas_pg_cobrancasfc']='';
							for ($i=0;$i<count($dataPgArray);$i++){
								$value['datas_pg_cobrancasfc'].=mostrarDataSimples($dataPgArray[$i]).',';
							}
							$value['datas_pg_cobrancasfc']=substr($value['datas_pg_cobrancasfc'],0,-1);
							if(count($dataPgArray)==0){
								$value['datas_pg_cobrancasfc']=$value['datas_pg_cobrancasfc'];
							}
							if($sit!='pg')
								$value['tipo_item']='cob';
							else 
								$value['tipo_item']='pag';
							//
							$dados[]=$value;
						}
						//print_r($dados);
						$retorno["data"]=$dados;
					}else{
						$retorno["qtd"]=0;
						$retorno["data"]='';
					}
					echo json_encode($retorno,JSON_UNESCAPED_UNICODE);
				break;
			}
		break;
		case "busca":
			switch($tipo) {
				case "end":
					$cep = isset($_REQUEST["cep"]) ? $_REQUEST["cep"] : false;
					$formato = isset($_REQUEST["formato"]) ? $_REQUEST["formato"] : false;
					$contents = file_get_contents('http://cep.republicavirtual.com.br/web_cep.php?formato='.$formato.'&cep='.$cep);
					echo $contents;
				break;
				case "endcliente":
					$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id){
						$select = new PDO_instruction();
						$select->con_pdo();
						$result = $select->select_pdo("SELECT cep1_clientesfc AS cep_sevmensalfc, CONCAT(end1_clientesfc,', ',num1_clientesfc,' - ',bar1_clientesfc,' - ',cid1_clientesfc,'-',uf1_clientesfc) AS end_sevmensalfc,comp1_clientesfc AS comp_sevmensalfc,lat1_clientesfc AS lat_sevmensalfc,long1_clientesfc AS lon_dadosfc FROM fc_clientes WHERE id_clientesfc = ?", array($id));
						//print_r($result);
						echo json_encode($result[0],JSON_UNESCAPED_UNICODE);
					}
				break;
				case "busca_pagamento":
					$arraybusca=array();
					$busca='';
					//
					if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
						$grupo=$_SESSION['grupo'];
						$busca.="`grupo_parceria` LIKE ? AND ";
						$arraybusca[]=$grupo;
					}
					$busca.="`id_provedor`= ?";
					$arraybusca[]=$_SESSION['id_provedor'];
					$select = new PDO_instruction();
					$select->con_pdo();
					$result['mes'] = $select->select_pdo("SELECT mes_pagamentosfc AS mesn, DATE_FORMAT(CONCAT(mes_pagamentosfc,'-01'),'%m/%Y') AS mesc FROM fcv_pagamentos WHERE $busca group by `mes_pagamentosfc`", $arraybusca);
					$result['user'] = $select->select_pdo("SELECT user_pagamentosfc FROM fcv_pagamentos WHERE $busca group by `user_pagamentosfc`", $arraybusca);
					//print_r($result);
					echo json_encode($result,JSON_UNESCAPED_UNICODE);
				break;
				case "busca_recebimentos":
				    $arraybusca=array();
				    $busca='';
				    //
				    if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
				        $grupo=$_SESSION['grupo'];
				        $busca.="`cl`.`grupo_parceria` LIKE ? AND ";
				        $arraybusca[]=$grupo;
				    }
				    if($_SESSION['login_userfc']=='cyberuv'){
				        $busca.="`cx`.`user_login` LIKE ? AND ";
				        $arraybusca[]='cyberuv';
				    }
				    $busca.="`cx`.`id_provedor`= ?";
				    $arraybusca[]=$_SESSION['id_provedor'];
				    $select = new PDO_instruction();
				    $select->con_pdo();
				    $result['ano'] = $select->select_pdo("SELECT DATE_FORMAT(cx.data_credito_caixafc,'%Y') AS ano FROM `fc_caixa` AS cx
                        INNER JOIN `fc_clientes` AS cl ON cl.id_clientesfc=cx.id_cliente_caixafc
                        WHERE $busca group by DATE_FORMAT(`cx`.`data_credito_caixafc`,'%Y') ORDER BY `cx`.`datatime_caixafc` DESC", $arraybusca);
				    $result['mes'] = $select->select_pdo("SELECT DATE_FORMAT(cx.data_credito_caixafc,'%m') AS mes FROM `fc_caixa` AS cx 
                        INNER JOIN `fc_clientes` AS cl ON cl.id_clientesfc=cx.id_cliente_caixafc
                        WHERE $busca group by DATE_FORMAT(`cx`.`data_credito_caixafc`,'%m') ORDER BY `cx`.`datatime_caixafc` DESC", $arraybusca);
				    $result['user'] = $select->select_pdo("SELECT `cx`.`user_login` AS user_login FROM `fc_caixa` AS cx 
                        INNER JOIN `fc_clientes` AS cl ON cl.id_clientesfc=cx.id_cliente_caixafc
                        WHERE $busca group by `cx`.`user_login` ORDER BY `cx`.`datatime_caixafc` DESC", $arraybusca);
				    $result['grupo'] = $select->select_pdo("SELECT `cl`.`grupo_parceria` AS  grupo FROM `fc_caixa` AS cx 
                        INNER JOIN `fc_clientes` AS cl ON cl.id_clientesfc=cx.id_cliente_caixafc
                        WHERE $busca group by `cl`.`grupo_parceria` ORDER BY `cx`.`datatime_caixafc` DESC", $arraybusca);          //print_r($result);
				    echo json_encode($result,JSON_UNESCAPED_UNICODE);
				    break;
				case "busca_cobrancas":
					$arraybusca=array();
					$busca='';
					//
					if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
						$grupo=$_SESSION['grupo'];
						$busca.="`grupo_parceria` LIKE ? AND ";
						$arraybusca[]=$grupo;
					}
					$busca.="`id_provedor`= ?";
					$arraybusca[]=$_SESSION['id_provedor'];
					$select = new PDO_instruction();
					$select->con_pdo();
					$result['mes'] = $select->select_pdo("SELECT mes_cobrancasfc AS mesn, DATE_FORMAT(CONCAT(mes_cobrancasfc,'-01'),'%m/%Y') AS mesc FROM fcv_cobrancas WHERE $busca group by `mes_cobrancasfc`", $arraybusca);
					//print_r($result);
					echo json_encode($result,JSON_UNESCAPED_UNICODE);
				break;
				case "busca_inadimplentes":
				    $arraybusca=array();
				    $busca='';
				    //
				    if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
				        $grupo=$_SESSION['grupo'];
				        $busca.="`grupo_parceria` LIKE ? AND ";
				        $arraybusca[]=$grupo;
				    }
				    $busca.="`id_provedor`= ?";
				    $arraybusca[]=$_SESSION['id_provedor'];
				    $select = new PDO_instruction();
				    $select->con_pdo();
				    $result['grupo'] = $select->select_pdo("SELECT `grupo_parceria` AS  grupo FROM `fca_mensalidades` WHERE $busca group by `grupo_parceria`", $arraybusca);          //print_r($result);
				    echo json_encode($result,JSON_UNESCAPED_UNICODE);
		        break;
				case "busca_dividas":
					$arraybusca=array();
					$busca='';
					//
					if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
						$grupo=$_SESSION['grupo'];
						$busca.="`grupo_parceria` LIKE ? AND ";
						$arraybusca[]=$grupo;
					}
					$busca.="`id_provedor`= ?";
					$arraybusca[]=$_SESSION['id_provedor'];
					$select = new PDO_instruction();
					$select->con_pdo();
					$result['mes'] = $select->select_pdo("SELECT mes_dividasfc AS mesn, DATE_FORMAT(CONCAT(mes_dividasfc,'-01'),'%m/%Y') AS mesc FROM fcv_dividas WHERE $busca group by `mes_dividasfc`", $arraybusca);
					//print_r($result);
					echo json_encode($result,JSON_UNESCAPED_UNICODE);
				break;
				case "secrets":
					$secret= isset($_REQUEST["secret"]) ? $_REQUEST["secret"] : false;
					if($secret=='pppoe'){
						$arraybusca=array();
						if($_SESSION['grupo_userfc']!='admin'){
							$grupo=$_SESSION['grupo'];
							$busca="`name_secretpp` LIKE ? AND";
							$arraybusca[0]='%'.$grupo.'-'.$query.'%';
						}else{
							$busca="`name_secretpp` like ? AND ";
							$arraybusca[0]='%'.$query.'%';
						}
						$arraybusca[]=$_SESSION['id_provedor'];
						//
						$selectQuery="SELECT id_secretpp AS id,CONCAT(name_secretpp,'-',mk_secretpp) AS label FROM mk_secretpp WHERE $busca id_provedor = ?";
						$select = new PDO_instruction();
						$select->con_pdo();
						$result = $select->select_pdo($selectQuery, $arraybusca);
						$dados['id']='0';
						$dados['label']='Nenhum';
						$result[count($result)]=$dados;  
						//print_r($result);
						echo json_encode($result,JSON_UNESCAPED_UNICODE);
					}
				break;
				case "clientes":
					$arraybusca=array();
					if($_SESSION['grupo_userfc']!='admin' OR $_SESSION['grupo']!='admin'){
						$grupo=$_SESSION['grupo'];
						$busca="`grupo_parceria` like ? AND ";
						$arraybusca[]=$grupo;
					}
					$busca.="`nome_clientesfc` like ? AND ";
					$arraybusca[]='%'.$query.'%';
					//
					$arraybusca[]=$_SESSION['id_provedor'];
					//
					$selectQuery="SELECT id_clientesfc AS id,nome_clientesfc AS label FROM fc_clientes WHERE $busca id_provedor = ?";
					//echo $select;
					//print_r($arraybusca);
					$select = new PDO_instruction();
					$select->con_pdo();
					$result = $select->select_pdo($selectQuery, $arraybusca);
					echo json_encode($result,JSON_UNESCAPED_UNICODE);
				break;
			}
		break;
		case "alterar": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "grupo": //ATUALIZA DADOS NA PAGINA
					$grupo = isset($_REQUEST["grupo"]) ? $_REQUEST["grupo"] : false;
					if($grupo && ($_SESSION['grupo_userfc']=='admin' OR $_SESSION['admin_userfc']!='') && $grupo!=$_SESSION['grupo']){
						$select = new PDO_instruction();
						$select->con_pdo();
						$result = $select->select_pdo('SELECT grupo_userfc FROM fc_user WHERE grupo_userfc = ? AND id_provedor = ?', array($grupo,$_SESSION['id_provedor']))[0];
						if($result['grupo_userfc']==$grupo){
							$_SESSION['grupo']=$result['grupo_userfc'];
							echo '{"auth":"true","result":"Grupo Alterado com Sucesso"}';
						}else{
							echo '{"auth":"true","result":"Grupo inválido"}';
						}
					}
				break;
				case "cancelar_cliente": //ATUALIZA DADOS NA PAGINA
					$id_cliente= isset($_REQUEST["id_cliente"]) ? $_REQUEST["id_cliente"] : false;
					if($id_cliente && $id_cliente>0){
						$msgs='';
						$ids='';
						$error='';
						$delete = new PDO_instruction();
						$delete->con_pdo();
						$result = $delete->del_pdo('DELETE FROM fc_sevmensal WHERE id_cliente_mensalfc = ?', array($id_cliente));
						if($result_save[0]){
							$msgs.=$result_save[1];
							$ids.=$result_save[2];
						}else{
							$error.=$result_save[1];
						}
						//
						$result = $delete->del_pdo('DELETE FROM mk_secretpp WHERE id_cliente_secretpp = ?', array($id_cliente));
						if($result_save[0]){
							$msgs.=$result_save[1].'-';
							$ids.=$result_save[2].'-';
						}else{
							$error.=$result_save[1];
						}
						//
						if($error==''){
							echo '{"error":false,"msg":"'.$msgs.'","id":"'.$ids.'"}';
						}else{
							echo '{"error":true,"msg":"'.$error.'","id":""}';
						}
					}
				break;
				case "remover_pagamento": //ATUALIZA DADOS NA PAGINA
					$id= isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
					if($id && $id>0){
						$delete = new PDO_instruction();
						$delete->con_pdo();
						$result_delete = $delete->del_pdo('DELETE FROM fc_caixa WHERE id_caixafc = ?', array($id));
						if($result_delete[0]){
							$msgs=$result_delete[1];
							$ids=$result_delete[2];
						}else{
							$error=$result_delete[1];
						}
						if($error==''){ 
							echo '{"error":false,"msg":"'.$msgs.'","id":"'.$ids.'"}';
						}else{
							echo '{"error":true,"msg":"'.$error.'","id":""}';
						}
					}
				break;
			}
		break;
		case "save": //ATUALIZA DADOS NA PAGINA
			switch($tipo) {
				case "cliente":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					$dados=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//
					$save = new PDO_instruction();
					$save->con_pdo();
					$result_save = $save->sql_pdo('fc_clientes','id_clientesfc',$var['id_clientesfc'],$var);
					if($result_save[0]){
					    $dados['error']=false;$dados['msg']=$result_save[1];$dados['id']=$result_save[2];$dados['nome']=$var['nome_clientesfc'];$dados['dados_pessoais']=true;$dados['new']=$result_save[3];
					}else{
						$dados['error']=true;$dados['msg']=$result_save[1];$dados['id']='';$dados['send']='';$dados['new']=false;
					}
					echo json_encode($dados,JSON_UNESCAPED_UNICODE);
 				break;
				case "mensal":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					$dados=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//
					$save = new PDO_instruction();
					$save->con_pdo();
					$result_save = $save->sql_pdo('fc_sevmensal','id_mensalfc',$var['id_mensalfc'],$var);
					if($result_save[0]){
						$dados['error']=false;$dados['msg']=$result_save[1];$dados['id']=$result_save[2];$dados['cobranca']=$var['cobranca_instalacao'];$dados['nome']=$var['nome_cliente'];$dados['new']=$result_save[3];
					}else{
						$dados['error']=true;$dados['msg']=$result_save[1];$dados['id']='';$dados['send']='';$dados['new']=false;
					}
					echo json_encode($dados,JSON_UNESCAPED_UNICODE);
				break;
				case "boleto":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					$dados=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//
					$save = new PDO_instruction();
					$save->con_pdo();
					$result_save = $save->sql_pdo('fc_boletos','id_boletosfc',$var['id_boletosfc'],$var);
					if($result_save[0]){
						$dados['error']=false;$dados['msg']=$result_save[1];$dados['id']=$result_save[2];$dados['cobranca']=$var['cobranca_instalacao'];$dados['nome']=$var['nome_cliente'];$dados['new']=$result_save[3];
					}else{
						$dados['error']=true;$dados['msg']=$result_save[1];$dados['id']='';$dados['send']='';$dados['new']=false;
					}
					echo json_encode($dados,JSON_UNESCAPED_UNICODE);
					break;
				case "caixa":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					$dados=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//
					if($var['mes_caixafc']!=''){
						$text_mcArray=explode(",",$var['mes_caixafc']);
						foreach ($text_mcArray as $value){
							$var['text_mes_caixafc'].=' '.mostrarMes($value).',';
						}
						$var['text_mes_caixafc']=substr_replace($var['text_mes_caixafc'], '', -1);
					}
					$result_save[1]='';
					$var['user_login']=$_SESSION['login_userfc'];
					if($var['user_login']=='andre' or $var['user_login']=='cyberuv' or $var['user_login']=='sistema'){
					    $var['grupo_user_caixafc']='admin';
					}else{
					    $var['grupo_user_caixafc']=$_SESSION['login_userfc'];
					}
					$var['id_user_login']=$_SESSION['id_userfc'];
					$save = new PDO_instruction();
					$save->con_pdo();
					$result_save = $save->sql_pdo('fc_caixa','id_caixafc',$var['id_caixafc'],$var);
					if($result_save[0]){
						$recibo=$save->select_pdo("SELECT md5recibo_recibofc FROM fcv_recibos WHERE numero_recibofc = ?", array($result_save[2]))[0]['md5recibo_recibofc'];
						$dados['error']=false;$dados['msg']=$result_save[1];$dados['id']=$result_save[2];$dados['recibo']=$recibo;$dados['send']=$var;
					}else{
						$dados['error']=true;$dados['msg']=$result_save[1];$dados['id']='';$dados['recibo']='';$dados['send']='';
					}
					echo json_encode($dados,JSON_UNESCAPED_UNICODE);
				break;
				case "bloqueios":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					$dados=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					//
					$timeZone = new DateTimeZone('UTC');
					if($var['data_bloqueiosfc']!=''){
						if(DateTime::createFromFormat ('d/m/Y', $var['data_bloqueiosfc'], $timeZone)<=DateTime::createFromFormat ('d/m/Y', date('d/m/Y'), $timeZone))
							$var['exe_bloqueiosfc']='on';
					}
					if($var['data_fim_bloqueiosfc']!=''){
						if(DateTime::createFromFormat ('d/m/Y', $var['data_fim_bloqueiosfc'], $timeZone)<=DateTime::createFromFormat ('d/m/Y', date('d/m/Y'), $timeZone))
							$var['exe_fim_bloqueiosfc']='on';
					}
					$save = new PDO_instruction();
					$save->con_pdo();
					$result_save = $save->sql_pdo('fc_bloqueios','id_bloqueiosfc',$var['id_bloqueiosfc'],$var);
					if($result_save[0]){
						$dados['error']=false;$dados['msg']=$result_save[1];$dados['id']=$result_save[2];$dados['send']='';
					}else{
						$dados['error']=true;$dados['msg']=$result_save[1];$dados['id']='';$dados['send']='';
					}
					echo json_encode($dados,JSON_UNESCAPED_UNICODE);
				break;
				case "itens":   //TIPO -> provedor
					// IMPORTA CLASSE PARA MANIPULAR DADOS MYSQL
					$dados=array();
					// PEGA DADOS VINDO DA PAGINA VIA POST OU GET
					$var=$_POST;
					$save = new PDO_instruction();
					$save->con_pdo();
					foreach ($var['valor_itensfc'] as $key=>$value){
						$campos=array();
						$campos['valor_itensfc']=$value;
						$campos['data_itensfc']=$var['data_itensfc'][$key];
						$campos['qtd_itensfc']=$var['qtd_itensfc'][$key];
						$campos['valor_total_itensfc']=$var['valor_total_itensfc'][$key];
						$campos['descricao_itensfc']=$var['descricao_itensfc'][$key];
						$campos['tipo_itensfc']=$var['tipo_itensfc'];
						$campos['nome_itensfc']=$var['nome_itensfc'];
						$campos['grupo_parceria']=$var['grupo_parceria'];
						$campos['id_cliente_itensfc']=$var['id_cliente_itensfc'];
						$campos['data_origem_itensfc']=$var['data_origem_itensfc'];
						//
						$result_save = $save->sql_pdo('fc_itens','id_itensfc',$var['id_itensfc'],$campos);
						if($result_save[0]){
							$dados['error']=false;$dados['msg'].=$result_save[1].'<br>';$dados['id'].=$result_save[2].'<br>';$dados['send'].='';
						}else{
							$dados['error']=true;$dados['msg'].=$result_save[1].'<br>';$dados['id'].='';$dados['send'].='';
						}
					}
					echo json_encode($dados,JSON_UNESCAPED_UNICODE);
				break;
			}
		break;
	}
}else{
	echo '{"auth":"false","result":"Não Autenticado"}';
}
?>