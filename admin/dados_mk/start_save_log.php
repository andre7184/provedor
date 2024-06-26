<?php 
	//importa funçoes
	include_once("../_funcoes.php");
	$provedor=isset($_REQUEST["pv"]) ? $_REQUEST["pv"] : false;
	$id_provedor=isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
	$sn_mk=isset($_REQUEST["sn"]) ? $_REQUEST["sn"] : false;
	if($provedor && $id_provedor && $sn_mk){
		//IMPORTA DADOS DO BANCO MYSQL
		require_once("../_conf.php");
		conecta_mysql();	//concecta no banco myslq
		//
		$tipo_mk=$_GET['tipo_mk'];
		$identy_mk=$_GET['mk'];
		$name_rb=$_GET['name_rb'];
		$uptime_mk=$_GET['uptime'];
		$ap=$_GET['ap'];
		$rb=$_GET['rb'];
		//
		if($ap){
			$result = mysql_query("UPDATE fc_aps SET
			datatime_apsfc=NOW(),
			nome_apsfc='$identy_mk',
			tipo_apsfc='$tipo_mk',
			modelo_apsfc='$name_rb'
			where nome_apsfc='$identy_mk' AND id_provedor='$id_provedor';
			");
			if (mysql_affected_rows()==0) {
				$result = mysql_query("INSERT INTO fc_aps (datatime_apsfc, nome_apsfc, tipo_apsfc, modelo_apsfc, id_provedor)
				values (
				NOW(),
				'$identy_mk',
				'$tipo_mk',
				'$name_rb',
				'$id_provedor'
				)");
			}
		}
		if($rb){
			$result = mysql_query("UPDATE mk_mikrotiks SET
			datatime_mikrotiks=NOW(),
			sn_mikrotiks='$sn_mk',
			name_rb_mikrotiks='$name_rb',
			uptime_mikrotiks='$uptime_mk',
			cpu_mikrotiks='$cpu_mk',
			memoria_mikrotiks='$memoria_mk'
			where identy_mikrotiks='$identy_mk' AND id_provedor='$id_provedor';
			");
			if (mysql_affected_rows()==0) {
				$result = mysql_query("INSERT INTO mk_mikrotiks (datatime_mikrotiks, sn_mikrotiks, tipo_mikrotiks, identy_mikrotiks, name_rb_mikrotiks, uptime_mikrotiks, cpu_mikrotiks, memoria_mikrotiks, datatime_backup_mikrotiks, id_provedor)
				values (
				NOW(),
				'$sn_mk',
				'$tipo_mk',
				'$identy_mk',
				'$name_rb',
				'$uptime_mk',
				'$cpu_mk',
				'$memoria_mk',
				NOW(),
				'$id_provedor'
				)");
				$backup=true;
			}else{
				if(mysql_num_rows(mysql_query("SELECT id_mikrotiks FROM mk_mikrotiks WHERE sn_mikrotiks='$sn_mk' AND id_provedor='$id_provedor' AND DATE_ADD(datatime_backup_mikrotiks, INTERVAL 24 HOUR) < NOW()"))>0){
					$backup=true;
				}
			}
			if($backup){
				//$COMANDOS_MK=":local backupfile (\"".$nome."_\" . [:pick [/system clock get date] 4 6] . \"-\" . [:pick [/system clock get date] 0 3] . \"-\" . [:pick [/system clock get date] 7 11] );/system backup save name=backup;/export file=backup;:delay 10s;/tool fetch address=[:resolve \"provedor.uvsat.com\"] src-path=\"backup.backup\" user=provedor port=21 password=amb8484 upload=yes mode=ftp dst-path=\"www/_pvs/$provedor/mk_backup/\$backupfile.backup\";/tool fetch address=[:resolve \"provedor.uvsat.com\"] src-path=\"backup.rsc\" user=provedor port=21 password=amb8484 upload=yes mode=ftp dst-path=\"www/_pvs/$provedor/mk_backup/\$backupfile.rsc\"";
				//$resultadoCALL = mysql_query("CALL mkComands('".$provedor."','".$nome."','".$COMANDOS_MK."','REALIZA BACKUP')") or die ("error|20");
				//$result = mysql_query("UPDATE sis_servidor_mikrotiks SET datatime_backup_mk=NOW() where nome_mk='$nome' AND codigo_provedor='$provedor'");
			}
		}
		//
	   	$path = "$provedor";
	   	$diretorio = dir($path);
	   	while($arquivo = $diretorio -> read()){
	   		if($arquivo{0}!="."){
	   			$nomeArray=explode("_",$arquivo);
	   			if($nomeArray[0]==$sn_mk){
	   				$listaFile[$arquivo] = file_get_contents($path."/".$arquivo);
	   				//remove file
	   				if(file_exists($path."/".$arquivo)){
	   					unlink($path."/".$arquivo); // aqui apaga
	   				}
	   			}
	   		}
	   	}
	   	$diretorio -> close();
	   	//
	   	//echo count($listaFile);
	   	if(count($listaFile)>0){
	   		ksort($listaFile);
		   	foreach($listaFile as $id => $value) {
			   	$nomeArray=explode("-",$id);
			   	$nome_file=$nomeArray[0];
			   	$files[$nome_file].=$value;
		   	}
		   	foreach($files as $id => $linhas) {
		   		$nomeArray = explode("_",$id);
		   		$nome=$nomeArray[1];
		   		//echo "$name<br>";
		   		$chars = array("<", ">");
		   		$linhasArray = explode("\n",$linhas);
		   		$cabecalho="";
		   		if($nome=='acessos')
		   			$arrayLogins=array();
		   		//
		   		for($i = 0; $i < count($linhasArray); $i++) {
		   			$linhaArray=explode(",",str_replace($chars, "", $linhasArray[$i]));
		   			if($linhaArray[0]=="#"){
		   				//cabeçalho
		   				$cabecalho=$linhaArray[1];
		   			}else{
		   			   	switch($nome) {
						   	case "acessos": //ip,mac,login,uptime,rx-bytes,tx-bytes,tipo,status,ultimo-acesso
						   		//echo "-cadastrar acessos<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		$uptimeS=converteUptimeMk($linhaArray[3]);
						   		$datatimeAtual_acessos=SomarDataTime($data_atual, -$uptimeS);
						   		$sql_acessos=mysql_query("SELECT id_logacessos FROM mk_logacessos WHERE id_provedor='$id_provedor' AND login_logacessos='".$linhaArray[2]."' AND datatime_logacessos > '$datatimeAtual_acessos' ORDER BY id_logacessos DESC LIMIT 1");
			   			   		$id_acessos=mysql_fetch_object($sql_acessos)->id_logacessos;
								if(mysql_num_rows($sql_acessos)==0){
									$update_acessos = mysql_query("UPDATE `mk_logacessos` SET `status_logacessos`='off',`datatime_fim_logacessos`=datatime_logacessos WHERE id_provedor='$id_provedor' AND login_logacessos='".$linhaArray[2]."'") or die ("Nao foi possivel ATUALIZA linha 124");
									//
									$insert_acessos = mysql_query("INSERT INTO `mk_logacessos` (`datatime_logacessos`,`ip_logacessos`,`mac_logacessos`,`login_logacessos`,`uptime_logacessos`,`datatime_inicio_logacessos`,`rx-bytes_logacessos`,`tx-bytes_logacessos`,`tipo_logacessos`,`status_logacessos`,`situacao_logacessos`,`sn-mk_logacessos`,`mk_logacessos`,`id_provedor`) VALUES 
											('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."','$datatimeAtual_acessos','".$linhaArray[4]."', '".$linhaArray[5]."', '".$linhaArray[6]."', '".$linhaArray[7]."', '".$linhaArray[8]."', '$sn_mk', '$identy_mk', '$id_provedor')") or die ("Nao foi possivel INSERIR linha 127");
									//echo $data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".$linhaArray[6]."', '".$linhaArray[7]."', '".$linhaArray[8]."', '$sn_mk', '$identy_mk', '$provedor')<br>";
								}else{
									$update_acessos = mysql_query("UPDATE `mk_logacessos` SET `datatime_logacessos`='$data_atual',`uptime_logacessos`='".$linhaArray[3]."',`rx-bytes_logacessos`='".$linhaArray[4]."',`tx-bytes_logacessos`='".$linhaArray[5]."',`status_logacessos`='".$linhaArray[7]."',`situacao_logacessos`='".$linhaArray[8]."',`sn-mk_logacessos`='$sn_mk',`mk_logacessos`='$identy_mk' WHERE `id_logacessos`='$id_acessos'") or die ("Nao foi possivel ATUALIZA linha 130");
									//echo $id_acessos."','".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".$linhaArray[6]."', '".$linhaArray[7]."', '".$linhaArray[8]."', '$sn_mk', '$identy_mk', '$provedor')<br>";
								}	
								$arrayLogins[]=$linhaArray[2];
						   	break;
						   	case "secretpp": //name,password,caller-id,profile,local-address,remote-address,last-logged-out,comment
						   		//echo "-cadastrar secretpp<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		if(mysql_num_rows(mysql_query("SELECT id_secretpp FROM mk_secretpp WHERE id_provedor='$id_provedor' AND name_secretpp='".$linhaArray[0]."' AND mk_secretpp='$identy_mk'"))==0){
						   			$insert_secretpp = mysql_query("INSERT INTO `mk_secretpp` (`datatime_secretpp`, `name_secretpp`, `password_secretpp`, `caller-id_secretpp`, `profile_secretpp`, `local-address_secretpp`, `remote-address_secretpp`, `last-logged-out_secretpp`, `comment_secretpp`, `mk_secretpp`, `salvo_secretpp`, `id_provedor`) VALUES
											('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".converteDateMk($linhaArray[6])."', '".$linhaArray[7]."', '$identy_mk', 'on', '$id_provedor')") or die ("Nao foi possivel INSERIR linha 108");
						   		}else{
						   			$update_secretpp = mysql_query("UPDATE `mk_secretpp` SET `datatime_secretpp`='$data_atual', `password_secretpp`='".$linhaArray[1]."', `caller-id_secretpp`='".$linhaArray[2]."', `profile_secretpp`='".$linhaArray[3]."',`local-address_secretpp`='".$linhaArray[4]."',`remote-address_secretpp`='".$linhaArray[5]."',`last-logged-out_secretpp`='".converteDateMk($linhaArray[6])."',`salvo_secretpp`='on',`tipo_secretpp`='' WHERE id_provedor='$id_provedor' AND name_secretpp='".$linhaArray[0]."' AND mk_secretpp='$identy_mk'") or die ("Nao foi possivel ATUALIZA linha 111");
						   		}
						   	break;
						   	case "profilepp": //name,local-address,remote-address,address-list,change-tcp-mss,use-compression,use-vj-compression,use-encryption,session-timeout,idle-timeout,rate-limit,insert-queue-before,parent-queue,queue-type
						   		//echo "-cadastrar profilepp<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		if(mysql_num_rows(mysql_query("SELECT id_profilepp FROM mk_profilepp WHERE name_profilepp='".$linhaArray[0]."' AND mk_profilepp='$identy_mk'"))==0){
						   			$insert_profilepp = mysql_query("INSERT INTO `mk_profilepp` (`datatime_profilepp`, `name_profilepp`, `local-address_profilepp`, `remote-address_profilepp`, `address-list_profilepp`, `change-tcp-mss_profilepp`, `use-compression_profilepp`, `use-vj-compression_profilepp`, `use-encryption_profilepp`, `session-timeout_profilepp`, `idle-timeout_profilepp`, `rate-limit_profilepp`, `insert-queue-before_profilepp`, `parent-queue_profilepp`, `queue-type_profilepp`, `mk_profilepp`, `id_provedor`) VALUES
											('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '".$linhaArray[5]."', '".$linhaArray[6]."', '".$linhaArray[7]."', '".$linhaArray[8]."', '".$linhaArray[9]."', '".$linhaArray[10]."', '".$linhaArray[11]."', '".$linhaArray[12]."', '".$linhaArray[13]."', '$identy_mk', '$provedor')") or die ("Nao foi possivel INSERIR linha 140");
						   		}else{
						   			$update_profilepp = mysql_query("UPDATE `mk_profilepp` SET `datatime_profilepp`='$data_atual', `local-address_profilepp`='".$linhaArray[1]."', `remote-address_profilepp`='".$linhaArray[2]."', `address-list_profilepp`='".$linhaArray[3]."',`change-tcp-mss_profilepp`='".$linhaArray[4]."',`use-compression_profilepp`='".$linhaArray[5]."',`use-vj-compression_profilepp`='".$linhaArray[6]."',`use-encryption_profilepp`='".$linhaArray[7]."',`session-timeout_profilepp`='".$linhaArray[8]."',`idle-timeout_profilepp`='".$linhaArray[9]."',`rate-limit_profilepp`='".$linhaArray[10]."',`insert-queue-before_profilepp`='".$linhaArray[11]."',`parent-queue_profilepp`='".$linhaArray[12]."',`queue-type_profilepp`='".$linhaArray[13]."', `id_provedor`='".$id_provedor."' WHERE tipo_profilepp='' AND name_profilepp='".$linhaArray[0]."' AND mk_profilepp='$identy_mk'") or die ("Nao foi possivel ATUALIZA linha 142");
						   		}
						   	break;				   
							case "logqueue": //name|tx/rx
								//echo "-cadastrar queue<br>";
								$data_atual=converteDateMk($cabecalho);
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
										//echo "SELECT id_queue FROM mk_queue WHERE codigo_provedor='$provedor' AND name_queue='$q_nome' AND mk_queue='$identy_mk' AND datatime_queue='$time_inicio'";
										if(mysql_num_rows(mysql_query("SELECT id_logqueue FROM mk_logqueue WHERE codigo_provedor='$provedor' AND name_logqueue='$q_nome' AND mk_logqueue='$identy_mk' AND datatime_logqueue='$time_inicio'"))==0){
											$insert_queue = mysql_query("INSERT INTO `mk_logqueue` (`datatime_logqueue`, `name_logqueue`, `target_logqueue`, `tx_logqueue`, `rx_logqueue`, `mk_logqueue`, `id_provedor`) VALUES
											('$time_inicio','$q_nome','$q_target','$up','$down', '$identy_mk', '$id_provedor')") or die ("Nao foi possivel INSERIR linha 164");
										}
										$time_inicio=SomarDataTime($time_inicio,$periodo);
									}
								}
							break;
						   	case "logwireless": //mac,signal-dbm,signal-snr,uptime,ssid
						   		//echo "-cadastrar logwireless - uptime:".$linhaArray[3]."<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		if(mysql_num_rows(mysql_query("SELECT id_wirelessfc FROM fc_wireless WHERE id_provedor='$id_provedor' AND mac_wirelessfc='".$linhaArray[0]."'"))==0){
						   			$insert_logwireless = mysql_query("INSERT INTO `fc_wireless` (`datatime_wirelessfc`, `mac_wirelessfc`, `dbm_wirelessfc`, `snr_wirelessfc`, `uptime_wirelessfc`, `ssid_wirelessfc`, `ap_wirelessfc`, `id_provedor`) VALUES
									('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','".$linhaArray[2]."','".$linhaArray[3]."', '".$linhaArray[4]."', '$identy_mk', '$id_provedor')") or die ("Nao foi possivel INSERIR linha 185");
						   		}else{
						   			$update_logwireless = mysql_query("UPDATE `fc_wireless` SET `datatime_wirelessfc`='$data_atual', `mac_wirelessfc`='".$linhaArray[0]."', `dbm_wirelessfc`='".$linhaArray[1]."', `snr_wirelessfc`='".$linhaArray[2]."',`uptime_wirelessfc`='".$linhaArray[3]."',`ssid_wirelessfc`='".$linhaArray[4]."',`ap_wirelessfc`='$identy_mk' WHERE mac_wirelessfc='".$linhaArray[0]."'") or die ("Nao foi possivel ATUALIZA linha 187");
						   		}
						   	break;
						   	case "lognetwatch": //name,host,since,status 
						   		//echo "-cadastrar secretpp<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		$sql_netwatch=mysql_query("SELECT status_lognetwatch FROM mk_lognetwatch WHERE id_provedor='$provedor' AND host_lognetwatch='".$linhaArray[1]."' AND mk_lognetwatch='$identy_mk' ORDER BY id_lognetwatch DESC LIMIT 1");
						   		$status_netwatch=mysql_fetch_object($sql_netwatch)->status_lognetwatch;
						   		$since_netwatch=mysql_fetch_object($sql_netwatch)->since_lognetwatch;
						   		$data_since=converteDateMk($linhaArray[2]);
						   		if($status_netwatch != $linhaArray[3]){
						   			$insert_netwatch = mysql_query("INSERT INTO `mk_lognetwatch` (`datatime_lognetwatch`, `name_lognetwatch`, `host_lognetwatch`, `since_lognetwatch`, `status_lognetwatch`, `mk_lognetwatch`, `id_provedor`) VALUES
										('".$data_atual."','".$linhaArray[0]."','".$linhaArray[1]."','$data_since','".$linhaArray[3]."', '$identy_mk', '$id_provedor')") or die ("Nao foi possivel INSERIR linha 199");
						   		}
						   	break;
					   	}
		   			}
		   		}
		   		if($nome=='acessos' && count($arrayLogins)>0)
		   			$update_acessos = mysql_query("UPDATE `mk_logacessos` SET `status_logacessos`='off',`datatime_fim_logacessos`=datatime_logacessos WHERE `status_logacessos`='on' AND `mk_logacessos`='$identy_mk' AND `login_logacessos` NOT IN (".sprintf("'%s'", implode("','",$arrayLogins)).")") or die ("Nao foi possivel ATUALIZA linha 206");
		   		//
		   	}
	   	}
	   	echo "ok";
	}else{
		echo "No command";
	}
	//
?>