<?php
	$chars = array("<", ">");
	$data = str_replace($chars, "", $_REQUEST["data"]);
	$nome_file=$_REQUEST["file"];
	$nfArray=explode("_",$nome_file);
	$nome_mk=$nfArray[0];
	$file_mkArray=explode("-",$nfArray[1]);
	$file_mk=$file_mkArray[0];
	$arquivo = file($nome_file);
	for($i = 0; $i < count($arquivo); $i++) {
		$linhaArray=explode(",",str_replace($chars, "", $arquivo[$i]));
		if($linhaArray[0]=="#"){
			//cabeçalho
			$time=$linhaArray[1];
			if($file_mk=="queue"){
				$timeArray=explode("-",$time);
				$time_inicio=$timeArray[0];
				$time_fim=$timeArray[1];
			}
		}else{
			switch($file_mk) {
				case "acessos": //ip,mac,login,uptime,rx-bytes,tx-bytes,ultimo-acesso,tipo,status
				break;
				case "profilehp": //name,address-pool,shared-users,rate-limit,add-mac-cookie,mac-cookie-timeout,insert-queue-before,parent-queue,queue-type
				break;
				case "profilepp": //name,local-address,remote-address,address-list,change-tcp-mss,use-compression,use-vj-compression,use-encryption,session-timeout,idle-timeout,rate-limit,insert-queue-before,parent-queue,queue-type
				break;
				case "queue": //name|tx/rx
				break;
				case "secrethp": //name,password,address,mac-address,profile,comment
				break;
				case "secretpp": //name,password,caller-id,profile,local-address,remote-address,last-logged-out,comment
				break;
			}
		}
	}
?>