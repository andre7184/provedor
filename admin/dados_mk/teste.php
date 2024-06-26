<?php
	//importa funçoes
	include_once( "../../../classes/funcoes_novas.php");
	$provedor=isset($_REQUEST["pv"]) ? $_REQUEST["pv"] : false;
	$mk=isset($_REQUEST["mk"]) ? $_REQUEST["mk"] : false;
	if($provedor && $mk){
	   	$path = "$provedor";
	   	$diretorio = dir($path);
	   	while($arquivo = $diretorio -> read()){
	   		if($arquivo{0}!="."){
	   			$nomeArray=explode("_",$arquivo);
	   			if($nomeArray[0]==$mk){
	   				$listaFile[$arquivo] = file_get_contents($path."/".$arquivo);
	   				//remove file
	   				if(file_exists($path."/".$arquivo)){
	   					//unlink($path."/".$arquivo); // aqui apaga
	   				}
	   			}
	   		}
	   	}
	   	$diretorio -> close();
	   	//
	   	ksort($listaFile);
	   	foreach($listaFile as $id => $value) {
		   	$nomeArray=explode("-",$id);
		   	$nome_file=$nomeArray[0];
		   	$files[$nome_file].=$value;
	   	}
	   	//IMPORTA DADOS DO BANCO MYSQL
	   	require_once( "../../../classes/conf_facil.php");
	   	conecta_mysql();	//concecta no banco myslq
	   	foreach($files as $id => $linhas) {
	   		$nomeArray = explode("_",$id);
	   		$nome=$nomeArray[1];
	   		echo "$name<br>";
	   		$chars = array("<", ">");
	   		$linhasArray = explode("\n",$linhas);
	   		$cabecalho="";
	   		for($i = 0; $i < count($linhasArray); $i++) {
	   			$linhaArray=explode(",",str_replace($chars, "", $linhasArray[$i]));
	   			if($linhaArray[0]=="#"){
	   				//cabeçalho
	   				$cabecalho=$linhaArray[1];
	   			}else{
	   			   switch($nome) {
				   	case "acessos": //ip,mac,login,uptime,rx-bytes,tx-bytes,tipo,status,ultimo-acesso
				   		echo "-cadastrar acessos<br>";
				   		$data_atual=converteDateMk($cabecalho);
				   		$uptimeS=converteUptimeMk($linhaArray[3]);
				   		$datatimeAtual_acessos=SomarDataTime($data_atual, -$uptimeS);
				   		$sql_acessos=mysql_query("SELECT id_acessos FROM mk_acessos WHERE codigo_provedor='$provedor' AND login_acessos='".$linhaArray[2]."' AND datatime_acessos > '$datatimeAtual_acessos' ORDER BY id_acessos DESC LIMIT 1");
	   			   		$id_acessos=mysql_fetch_object($sql_acessos)->id_acessos;
						if(mysql_num_rows($sql_acessos)==0){
							$insert_acessos = mysql_query("INSERT INTO `mk_acessos` (`datatime_acessos`,`ip_acessos`,`mac_acessos`,`login_acessos`,`uptime_acessos`,`rx-bytes_acessos`,`tx-bytes_acessos`,`tipo_acessos`,`status_acessos`,`ultimo-acesso_acessos`,`mk_acessos`,`codigo_provedor`) VALUES 
									('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".$linhaArray[6]."', '".$linhaArray[7]."', '".$linhaArray[8]."', '$mk', '$provedor')") or die ("Nao foi possivel INSERIR linha 47");
						}else{
							$update_acessos = mysql_query("UPDATE `mk_acessos` SET `datatime_acessos`='$data_atual',`uptime_acessos`='".$linhaArray[3]."',`rx-bytes_acessos`='".$linhaArray[4]."',`tx-bytes_acessos`='".$linhaArray[5]."',`status_acessos`='".$linhaArray[7]."',`ultimo-acesso_acessos`='".$linhaArray[8]."',`mk_acessos`='$mk' WHERE `id_acessos`='$id_acessos'") or die ("Nao foi possivel ATUALIZA linha 50");
						}			   
				   		break;
				   	case "profilehp": //name,address-pool,shared-users,rate-limit,add-mac-cookie,mac-cookie-timeout,insert-queue-before,parent-queue,queue-type
				   		echo "-cadastrar profilehp<br>";
				   		if(mysql_num_rows(mysql_query("SELECT id_profilehp FROM mk_profilehp WHERE codigo_provedor='$provedor' AND name_profilehp='".$linhaArray[0]."' AND mk_profilehp='$mk'"))==0){
				   			$insert_profilehp = mysql_query("INSERT INTO `mk_profilehp` (`datatime_profilehp`,`name_profilehp`,`address-pool_profilehp`,`shared-users_profilehp`,`rate-limit_profilehp`,`add-mac-cookie_profilehp`,`mac-cookie-timeout_profilehp`,`insert-queue-before_profilehp`,`parent-queue_profilehp`,`queue-type_profilehp`,`mk_profilehp`,`codigo_provedor`) VALUES
									('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".$linhaArray[6]."', '".$linhaArray[7]."', '".$linhaArray[8]."', '$mk', '$provedor')") or die ("Nao foi possivel INSERIR linha 55");
				   		}else{
				   			$update_profilehp = mysql_query("UPDATE `mk_profilehp` SET `datatime_profilehp`='$data_atual', `address-pool_profilehp`='".$linhaArray[1]."', `shared-users_profilehp`='".$linhaArray[2]."', `rate-limit_profilehp`='".$linhaArray[3]."',`add-mac-cookie_profilehp`='".$linhaArray[4]."',`mac-cookie-timeout_profilehp`='".$linhaArray[5]."',`insert-queue-before_profilehp`='".$linhaArray[6]."',`parent-queue_profilehp`='".$linhaArray[7]."',`queue-type_profilehp`='".$linhaArray[8]."' WHERE codigo_provedor='$provedor' AND name_profilehp='".$linhaArray[0]."' AND mk_profilehp='$mk'") or die ("Nao foi possivel ATUALIZA linha 58");
				   		}				   
				   		break;
				   	case "profilepp": //name,local-address,remote-address,address-list,change-tcp-mss,use-compression,use-vj-compression,use-encryption,session-timeout,idle-timeout,rate-limit,insert-queue-before,parent-queue,queue-type
				   		echo "-cadastrar profilepp<br>";
				   		if(mysql_num_rows(mysql_query("SELECT id_profilepp FROM mk_profilepp WHERE codigo_provedor='$provedor' AND name_profilepp='".$linhaArray[0]."' AND mk_profilepp='$mk'"))==0){
				   			$insert_profilepp = mysql_query("INSERT INTO `mk_profilepp` (`datatime_profilepp`, `name_profilepp`, `local-address_profilepp`, `remote-address_profilepp`, `address-list_profilepp`, `change-tcp-mss_profilepp`, `use-compression_profilepp`, `use-vj-compression_profilepp`, `use-encryption_profilepp`, `session-timeout_profilepp`, `idle-timeout_profilepp`, `rate-limit_profilepp`, `insert-queue-before_profilepp`, `parent-queue_profilepp`, `queue-type_profilepp`, `mk_profilepp`, `codigo_provedor`) VALUES
									('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".$linhaArray[6]."', '".$linhaArray[7]."', '".$linhaArray[8]."', '".$linhaArray[9]."', '".$linhaArray[10]."', '".$linhaArray[11]."', '".$linhaArray[12]."', '".$linhaArray[13]."', '$mk', '$provedor')") or die ("Nao foi possivel INSERIR linha 63");
				   		}else{
				   			$update_profilepp = mysql_query("UPDATE `mk_profilepp` SET `datatime_profilepp`='$data_atual', `local-address_profilepp`='".$linhaArray[1]."', `remote-address_profilepp`='".$linhaArray[2]."', `address-list_profilepp`='".$linhaArray[3]."',`change-tcp-mss_profilepp`='".$linhaArray[4]."',`use-compression_profilepp`='".$linhaArray[5]."',`use-vj-compression_profilepp`='".$linhaArray[6]."',`use-encryption_profilepp`='".$linhaArray[7]."',`session-timeout_profilepp`='".$linhaArray[8]."',`idle-timeout_profilepp`='".$linhaArray[9]."',`rate-limit_profilepp`='".$linhaArray[10]."',`insert-queue-before_profilepp`='".$linhaArray[11]."',`parent-queue_profilepp`='".$linhaArray[12]."',`queue-type_profilepp`='".$linhaArray[13]."' WHERE codigo_provedor='$provedor' AND name_profilepp='".$linhaArray[0]."' AND mk_profilepp='$mk'") or die ("Nao foi possivel ATUALIZA linha 66");
				   		}
				   		break;				   
					case "queue": //name|tx/rx
						echo "-cadastrar queue<br>";
						$q_nomeArray=explode("|",$linhaArray[0]);
						$q_nome=$q_nomeArray[0];
						$q_target=$q_nomeArray[1];
						if($q_nome!='0' AND $q_nome!=''){
							$dataArray=explode("|",$cabecalho);
							$data_inicio=converteDateMk($dataArray[0]);
							$data_fim=converteDateMk($dataArray[1]);
							$periodo=intval(Diferenca($data_inicio, $data_fim,"s")/(count($linhaArray)-1));
							$time_inicio=$data_inicio;
							for($j = 1; $j < count($linhaArray); $j++) {
								$velArray=explode("/",$linhaArray[$j]);
								$up=converteVelMk($velArray[0]);
								$down=converteVelMk($velArray[1]);
								//echo $time_inicio."=".$up."/".$down."<br>";
								if(mysql_num_rows(mysql_query("SELECT id_queue FROM mk_queue WHERE codigo_provedor='$provedor' AND name_queue='$q_nome' AND mk_queue='$mk' AND datatime_queue='$time_inicio'"))==0){
									$insert_queue = mysql_query("INSERT INTO `mk_queue` (`datatime_queue`, `name_queue`, `target_queue`, `tx_queue`, `rx_queue`, `mk_queue`, `codigo_provedor`) VALUES
									('$time_inicio','$q_nome','$q_target','$up','$down', '$mk', '$provedor')") or die ("Nao foi possivel INSERIR linha 91");
								}
								$time_inicio=SomarDataTime($time_inicio,$periodo);
							}
						}
					break;
				   	case "secrethp": //name,password,address,mac-address,profile,comment
				   		echo "-cadastrar secrethp<br>";
				   		if(mysql_num_rows(mysql_query("SELECT id_secrethp FROM mk_secrethp WHERE codigo_provedor='$provedor' AND name_secrethp='".$linhaArray[0]."' AND mk_secrethp='$mk'"))==0){
				   			$insert_secrethp = mysql_query("INSERT INTO `mk_secrethp` (`datatime_secrethp`, `name_secrethp`, `password_secrethp`, `address_secrethp`, `mac-address_secrethp`, `profile_secrethp`, `comment_secrethp`, `mk_secrethp`, `codigo_provedor`) VALUES
									('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '$mk', '$provedor')") or die ("Nao foi possivel INSERIR linha 100");
				   		}else{
				   			$update_secrethp = mysql_query("UPDATE `mk_secrethp` SET `datatime_secrethp`='$data_atual', `password_secrethp`='".$linhaArray[1]."', `address_secrethp`='".$linhaArray[2]."', `mac-address_secrethp`='".$linhaArray[3]."',`profile_secrethp`='".$linhaArray[4]."',`comment_secrethp`='".$linhaArray[5]."' WHERE codigo_provedor='$provedor' AND name_secrethp='".$linhaArray[0]."' AND mk_secrethp='$mk'") or die ("Nao foi possivel ATUALIZA linha 103");
				   		}
				   		break;				   
				   	case "secretpp": //name,password,caller-id,profile,local-address,remote-address,last-logged-out,comment
				   		echo "-cadastrar secretpp<br>";
				   		if(mysql_num_rows(mysql_query("SELECT id_secretpp FROM mk_secretpp WHERE codigo_provedor='$provedor' AND name_secretpp='".$linhaArray[0]."' AND mk_secretpp='$mk'"))==0){
				   			$insert_secretpp = mysql_query("INSERT INTO `mk_secretpp` (`datatime_secretpp`, `name_secretpp`, `password_secretpp`, `caller-id_secretpp`, `profile_secretpp`, `local-address_secretpp`, `remote-address_secretpp`, `last-logged-out_secretpp`, `comment_secretpp`, `mk_secretpp`, `codigo_provedor`) VALUES
									('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".converteDateMk($linhaArray[6])."', '".$linhaArray[7]."', '$mk', '$provedor')") or die ("Nao foi possivel INSERIR linha 108");
				   		}else{
				   			$update_secretpp = mysql_query("UPDATE `mk_secretpp` SET `datatime_secretpp`='$data_atual', `password_secretpp`='".$linhaArray[1]."', `caller-id_secretpp`='".$linhaArray[2]."', `profile_secretpp`='".$linhaArray[3]."',`local-address_secretpp`='".$linhaArray[4]."',`remote-address_secretpp`='".$linhaArray[5]."',`last-logged-out_secretpp`='".converteDateMk($linhaArray[6])."',`comment_secretpp`='".$linhaArray[7]."' WHERE codigo_provedor='$provedor' AND name_secretpp='".$linhaArray[0]."' AND mk_secretpp='$mk'") or die ("Nao foi possivel ATUALIZA linha 111");
				   		}
				   		break;
				   }
	   			}
	   		}
	   	}
	}else{
		echo "No command";
	}
	//
?>