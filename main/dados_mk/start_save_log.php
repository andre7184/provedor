<?php 
	//importa funções
	require_once("../_conf.php");
	$provedor=isset($_REQUEST["pv"]) ? $_REQUEST["pv"] : false;
	$id_provedor=isset($_REQUEST["id"]) ? $_REQUEST["id"] : false;
	$sn_mk=isset($_REQUEST["sn"]) ? $_REQUEST["sn"] : false;
	if($provedor && $id_provedor && $sn_mk){
		//
		$tipo_mk=$_GET['tipo_mk'];
		$identy_mk=$_GET['mk'];
		$name_rb=$_GET['name_rb'];
		$uptime_mk=$_GET['uptime'];
		$ap=$_GET['ap'];
		$rb=$_GET['rb'];
		$dados['args']=$_REQUEST;
		$save = new PDO_instruction();
		$save->con_pdo();
		//
		if($ap){
			$var=array();
			$var['id_apsfc']=$save->select_pdo("SELECT id_apsfc FROM fc_aps WHERE nome_apsfc = ? AND id_provedor = ?", array($identy_mk,$id_provedor))[0]['id_apsfc'];
			$var['nome_apsfc']=$identy_mk;
			$var['tipo_apsfc']=$tipo_mk;
			$var['modelo_apsfc']=$name_rb;
			$var['id_provedor']=$id_provedor;
			//
			$result_save = $save->sql_pdo('fc_aps','id_apsfc',$var['id_apsfc'],$var);
			if($result_save[0]){
				$dados['apMsg']=$result_save[1];$dados['apId']=$result_save[2];
			}else{
				$dados['apMsg']=$result_save[1];
			}
		}
		if($rb){
			$var=array();
			$var['id_mikrotiks']=$save->select_pdo("SELECT id_mikrotiks FROM mk_mikrotiks WHERE sn_mikrotiks = ?", array($sn_mk))[0]['id_mikrotiks'];
			$var['sn_mikrotiks']=$sn_mk;
			$var['tipo_mikrotiks']=$tipo_mk;
			$var['identy_mikrotiks']=$identy_mk;
			$var['name_rb_mikrotiks']=$name_rb;
			$var['uptime_mikrotiks']=$uptime_mk;
			$var['cpu_mikrotiks']=$cpu_mk;
			$var['memoria_mikrotiks']=$memoria_mk;
			$var['id_provedor']=$id_provedor;
			//
			$result_save = $save->sql_pdo('mk_mikrotiks','id_mikrotiks',$var['id_mikrotiks'],$var);
			if($result_save[0]){
				$dados['mkMsg']=$result_save[1];$dados['mkId']=$result_save[2];
			}else{
				$dados['mkMsg']=$result_save[1];
			}
			//
			if($save->select_pdo("SELECT count(*) AS qtd FROM mk_mikrotiks WHERE sn_mikrotiks = ? AND id_provedor = ? AND DATE_ADD(datatime_backup_mikrotiks, INTERVAL 24 HOUR) < NOW()", array($sn_mk,$id_provedor))[0]['qtd'] > 0){
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
		   				//cabe�alho
		   				$cabecalho=$linhaArray[1];
		   			}else{
		   			   	switch($nome) {
						   	case "acessos": //ip,mac,login,uptime,rx-bytes,tx-bytes,tipo,status,ultimo-acesso
						   		//echo "-cadastrar acessos<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		$uptimeS=converteUptimeMk($linhaArray[3]);
						   		$datatimeAtual_acessos=SomarDataTime($data_atual, -$uptimeS);
						   		
						   		$var=array();
						   		$var['id_logacessos']=$save->select_pdo("SELECT id_logacessos FROM mk_logacessos WHERE login_logacessos = ? AND datatime_logacessos > ? ORDER BY id_logacessos DESC LIMIT 1", array($linhaArray[2],$datatimeAtual_acessos))[0]['id_logacessos'];
						   		if($var['id_logacessos']==''){
						   			$var2=array();
						   			$var2['id_logacessos']=$save->select_pdo("SELECT id_logacessos FROM mk_logacessos WHERE login_logacessos = ? ORDER BY id_logacessos DESC LIMIT 1", array($linhaArray[2]))[0]['id_logacessos'];
						   			if($var2['id_logacessos']!=''){
							   			$var2['status_logacessos']='off';
							   			$var2['datatime_fim_logacessos']=datatime_logacessos;
							   			//
							   			// $result_save1 = $save->sql_pdo('mk_logacessos','id_logacessos',$id_logacessos,$var2);
							   			// if($result_save1[0]){
							   			// $dados[$i]['la1Msg']=$result_save1[1];$dados[$i]['la1Id']=$result_save1[2];
							   			// }else{
							   			// $dados[$i]['la1Msg']=$result_save1[1];
							   			// }
						   			}
						   			//
						   			$var['datatime_logacessos']=$data_atual;
						   			$var['ip_logacessos']=$linhaArray[0];
						   			$var['mac_logacessos']=$linhaArray[1];
						   			$var['login_logacessos']=$linhaArray[2];
						   			$var['uptime_logacessos']=$linhaArray[3];
						   			$var['datatime_inicio_logacessos']=$datatimeAtual_acessos;
						   			$var['rx_bytes_logacessos']=$linhaArray[4];
						   			$var['tx_bytes_logacessos']=$linhaArray[5];
						   			$var['tipo_logacessos']=$linhaArray[6];
						   			$var['status_logacessos']=$linhaArray[7];
						   			$var['situacao_logacessos']=$linhaArray[8];
						   			$var['sn_mk_logacessos']=$sn_mk;
						   			$var['mk_logacessos']=$identy_mk;
						   			$var['id_provedor']=$id_provedor;
						   			// $result_save2 = $save->sql_pdo('mk_logacessos','id_logacessos',false,$var);
						   			// if($result_save2[0]){
						   			// $dados[$i]['la2Msg']=$result_save1[1];$dados[$i]['la2Id']=$result_save1[2];
						   			// }else{
						   			// $dados[$i]['la2Msg']=$result_save1[1];
						   			// }
						   		}else{
						   			$var['datatime_logacessos']=$data_atual;
						   			$var['uptime_logacessos']=$linhaArray[3];
						   			$var['rx_bytes_logacessos']=$linhaArray[4];
						   			$var['tx_bytes_logacessos']=$linhaArray[5];
						   			$var['status_logacessos']=$linhaArray[7];
						   			$var['situacao_logacessos']=$linhaArray[8];
						   			$var['sn_mk_logacessos']=$sn_mk;
						   			$var['mk_logacessos']=$identy_mk;
						   			//
						   			// $result_save = $save->sql_pdo('mk_logacessos','id_logacessos',$var['id_logacessos'],$var);
						   			// if($result_save[0]){
						   			// $dados[$i]['la1Msg']=$result_save1[1];$dados[$i]['la1Id']=$result_save1[2];
						   			// }else{
						   				// $dados[$i]['la1Msg']=$result_save1[1];
						   			// }
						   		}
								$arrayLogins[]=$linhaArray[2];
						   	break;
						   	case "secretpp": //name,password,caller-id,profile,local-address,remote-address,last-logged-out,comment
						   		//echo "-cadastrar secretpp<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		$var=array();
						   		$commentArray=explode("#",$linhaArray[7]);
						   		$dadosSecrets=$save->select_pdo("SELECT id_secretpp,tipo_secretpp FROM mk_secretpp WHERE name_secretpp = ?", array($linhaArray[0]))[0];
						   		if($commentArray[0]>0 && $dadosSecrets['id_secretpp']!=$commentArray[0]){
						   		    $dadosSecrets=$save->select_pdo("SELECT id_secretpp,tipo_secretpp FROM mk_secretpp WHERE id_secretpp = ?", array($commentArray[0]))[0];
						   		}
						   		$var['id_secretpp']=$dadosSecrets['id_secretpp'];
						   		$tipo_secretpp=$dadosSecrets['tipo_secretpp'];
						   		//
						   		if($tipo_secretpp==''){
						   			$var['data_atz_secretpp']=date('d/m/Y');
							   		$var['name_secretpp']=$linhaArray[0];
							   		$var['password_secretpp']=$linhaArray[1];
							   		$var['caller_id_secretpp']=$linhaArray[2];
							   		$var['profile_secretpp']=$linhaArray[3];
							   		$var['local_address_secretpp']=$linhaArray[4];
							   		$var['remote_address_secretpp']=$linhaArray[5];
							   		$var['last_logged_out_secretpp']=converteDateMk($linhaArray[6]);
							   		$var['atz_comment_secretpp']=$linhaArray[7];
							   		$var['mk_secretpp']=$identy_mk;
							   		$var['sn_mk_secretpp']=$sn_mk;
							   		$var['salvo_secretpp']='on';
							   		$var['no_save_secretpp']='';
							   		$var['id_provedor']=$id_provedor;
						   		}else{
						   			$var['no_save_secretpp']='on';
						   			$var['tipo_secretpp']='';
						   		}
							   	//
							   	$result_save = $save->sql_pdo('mk_secretpp','id_secretpp',$var['id_secretpp'],$var);
							   	if($result_save[0]){
							   		$dados[$i]['secMsg']=$result_save[1];$dados[$i]['secIdIn']=$var['id_secretpp'];$dados[$i]['secId']=$result_save[2];
							   	}else{
							   		$dados[$i]['secMsg']=$result_save[1];
							   	}
						   	break;
						   	case "profilepp": //name,local-address,remote-address,address-list,change-tcp-mss,use-compression,use-vj-compression,use-encryption,session-timeout,idle-timeout,rate-limit,insert-queue-before,parent-queue,queue-type
						   		//echo "-cadastrar profilepp<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		$var=array();
						   		$var['id_profilepp']=$save->select_pdo("SELECT id_profilepp FROM mk_profilepp WHERE name_profilepp = ?", array($linhaArray[0]))[0]['id_profilepp'];
						   		$var['name_profilepp']=$linhaArray[0];
						   		$var['local_address_profilepp']=$linhaArray[1];
						   		$var['remote_address_profilepp']=$linhaArray[2];
						   		$var['address_list_profilepp']=$linhaArray[3];
						   		$var['change_tcp_mss_profilepp']=$linhaArray[4];
						   		$var['use_compression_profilepp']=$linhaArray[5];
						   		$var['use_vj_compression_profilepp']=$linhaArray[6];
						   		$var['use_encryption_profilepp']=$linhaArray[7];
						   		$var['session_timeout_profilepp']=$linhaArray[8];
						   		$var['idle_timeout_profilepp']=$linhaArray[9];
						   		$var['rate_limit_profilepp']=$linhaArray[10];
						   		$var['insert_queue_before_profilepp']=$linhaArray[11];
						   		$var['parent_queue_profilepp']=$linhaArray[12];
						   		$var['queue_type_profilepp']=$linhaArray[13];
						   		$var['mk_profilepp']=$identy_mk;
						   		$var['id_provedor']=$id_provedor;
						   		//
						   		$result_save = $save->sql_pdo('mk_profilepp','id_profilepp',$var['id_profilepp'],$var);
						   		if($result_save[0]){
						   			$dados[$i]['pflMsg']=$result_save[1];$dados[$i]['pflId']=$result_save[2];
						   		}else{
						   			$dados[$i]['pflMsg']=$result_save[1];
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
										//
										if($save->select_pdo("SELECT count(*) as qtd FROM mk_logqueue WHERE name_logqueue = ? AND id_provedor = ? AND mk_logqueue = ? AND datatime_logqueue = ?", array($q_nome,$id_provedor,$identy_mk,$time_inicio))[0]['qtd']==0){
											$var=array();
											$var['datatime_logqueue']=$time_inicio;
											$var['name_logqueue']=$q_nome;
											$var['target_logqueue']=$q_target;
											$var['tx_logqueue']=$up;
											$var['rx_logqueue']=$down;
											$var['mk_logqueue']=$identy_mk;
											$var['id_provedor']=$id_provedor;
											//
											$result_save = $save->sql_pdo('mk_logqueue','id_logqueue',false,$var);
											if($result_save[0]){
												$dados[$i]['lqu'.$j.'Msg']=$result_save[1];$dados[$i]['lqu'.$j.'Id']=$result_save[2];
											}else{
												$dados[$i]['lqu'.$j.'Msg']=$result_save[1];
											}
										}
										$time_inicio=SomarDataTime($time_inicio,$periodo);
									}
								}
							break;
						   	case "logwireless": //mac,signal-dbm,signal-snr,uptime,ssid
						   		//echo "-cadastrar logwireless - uptime:".$linhaArray[3]."<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		$var=array();
						   		$var['id_wirelessfc']=$save->select_pdo("SELECT id_wirelessfc FROM fc_wireless WHERE mac_wirelessfc = ?", array($linhaArray[0]))[0]['id_wirelessfc'];
						   		$var['datatime_wirelessfc']=$data_atual;
						   		$var['mac_wirelessfc']=$linhaArray[0];
						   		$var['dbm_wirelessfc']=$linhaArray[1];
						   		$var['snr_wirelessfc']=$linhaArray[2];
						   		$var['uptime_wirelessfc']=$linhaArray[3];
						   		$var['ssid_wirelessfc']=$linhaArray[4];
						   		$var['ap_wirelessfc']=$identy_mk;
						   		$var['id_provedor']=$id_provedor;
						   		//
						   		$result_save = $save->sql_pdo('fc_wireless','id_wirelessfc',$var['id_wirelessfc'],$var);
						   		if($result_save[0]){
						   			$dados[$i]['wssMsg']=$result_save[1];$dados[$i]['wssId']=$result_save[2];
						   		}else{
						   			$dados[$i]['wssMsg']=$result_save[1];
						   		}
						   	break;
						   	case "lognetwatch": //name,host,since,status 
						   		//echo "-cadastrar secretpp<br>";
						   		$data_atual=converteDateMk($cabecalho);
						   		$var=array();
						   		$sql_netwatch=$save->select_pdo("SELECT status_lognetwatch,since_lognetwatch FROM mk_lognetwatch WHERE id_provedor = ? AND host_lognetwatch = ? AND mk_lognetwatch = ? ORDER BY id_lognetwatch DESC LIMIT 1", array($id_provedor,$linhaArray[1],$identy_mk))[0];
						   		$status_netwatch=$sql_netwatch['status_lognetwatch'];
						   		$since_netwatch=$sql_netwatch['since_lognetwatch'];
						   		$data_since=converteDateMk($linhaArray[2]);
						   		if($status_netwatch != $linhaArray[3]){
							   		$var['datatime_lognetwatch']=$data_atual;
							   		$var['name_lognetwatch']=$linhaArray[0];
							   		$var['host_lognetwatch']=$linhaArray[1];
							   		$var['since_lognetwatch']=$data_since;
							   		$var['status_lognetwatch']=$linhaArray[3];
							   		$var['ssid_wirelessfc']=$linhaArray[4];
							   		$var['mk_lognetwatch']=$identy_mk;
							   		$var['id_provedor']=$id_provedor;
							   		//
							   		$result_save = $save->sql_pdo('fc_wireless','id_wirelessfc',$var['id_wirelessfc'],$var);
							   		if($result_save[0]){
							   			$dados[$i]['nwaMsg']=$result_save[1];$dados[$i]['nwaId']=$result_save[2];
							   		}else{
							   			$dados[$i]['nwaMsg']=$result_save[1];
							   		}
						   		}
						   	break;
					   	}
		   			}
		   		}
		   		if($nome=='acessos' && count($arrayLogins)>0){
		   			$var['id_logacessos']=$save->select_pdo("SELECT id_logacessos FROM mk_logacessos WHERE status_logacessos = ? AND mk_logacessos = ? AND login_logacessos NOT IN (".sprintf("'%s'", implode("','",$arrayLogins)).")", array('on',$linhaArray[0],$identy_mk))[0]['id_logacessos'];
		   			$var['status_logacessos']='off';
		   			$var['datatime_fim_logacessos']=datatime_logacessos;
		   			//
		   			//$result_save = $save->sql_pdo('mk_logacessos','id_logacessos',$var['id_logacessos'],$var);
		   			//if($result_save1[0]){
		   			//	$dados['la1Msg']=$result_save1[1];$dados['la1Id']=$result_save1[2];
		   			//}else{
		   			//	$dados['la1Msg']=$result_save1[1];
		   			//}
		   		}
		   	}
	   	}
	   	echo json_encode($dados,JSON_UNESCAPED_UNICODE);
	}else{
		echo "No command";
	}
	//
?>