<?php
	//importa funçoes
	include_once("../_funcoes.php");
	$DOMAIN_SERVIDOR='mkfacil.cf';
	//
	$id_provedor = isset($_REQUEST["pv"]) ? $_REQUEST["pv"] : false; 
	if($id_provedor){
		$versao_at='1';
		$tipo=$_GET['tp'];
		$nome=$_GET['mk'];
		$resultado=$_GET['res'];
		//IMPORTA DADOS DO BANCO MYSQL
		require_once("../_conf.php");
		conecta_mysql();	//concecta no banco myslq
		//
		if($tipo=="exe"){
			$versao=$_GET['v'];
			//
			if($versao < $versao_at){
				$comandos='
					/system script set [ find name=\"MK_comandos\" ] source=\"## EXECUTADOR DE COMANDOS REMOTOS V.'.$versao_at.'\n
					:local MK [/system identity get name];:local PV \"'.$id_provedor.'\";:local V \"'.$versao_at.'\";
					/tool fetch address=[:resolve \"'.$DOMAIN_SERVIDOR.'\"] host=\"'.$DOMAIN_SERVIDOR.'\" src-path=\"/comands/mk/vc.php?v=\$V&pv=\$PV&mk=mk_\$MK&tp=exe\" mode=\"http\" dst-path=\"MK_comandos.rsc\";
					:delay 5s;
					:if (  [/file get MK_comandos.rsc contents] !=\"#\" ) do={
						:log info (\"EXECUTA COMANDOS\");
						/import file-name=\"MK_comandos.rsc\";
						/tool fetch address=[:resolve \"'.$DOMAIN_SERVIDOR.'\"] host=\"'.$DOMAIN_SERVIDOR.'\" src-path=\"/comands/mk/vc.php\?pv=\$PV&mk=mk_\$MK&tp=ver&res=ok\" mode=\"http\" keep-result=\"no\";
					};\";
				';
			} 
			//
			$sqlComando = "SELECT * FROM mk_comandos WHERE router_comandos_mk='".$nome."' AND sit_comandos_mk='pronto' AND id_provedor='".$id_provedor."'";
			$resultadoComando = mysql_query($sqlComando) or die ("#");
			if(mysql_num_rows($resultadoComando)>0){
				while($linhaComando=mysql_fetch_object($resultadoComando)){
				     $comandos.=$linhaComando->linha_comandos_mk."";
				}
				//altera a situação do comandos_mk
				$sql = "UPDATE mk_comandos SET sit_comandos_mk='executando' WHERE router_comandos_mk='".$nome."' AND sit_comandos_mk='pronto' AND id_provedor='".$id_provedor."'";
				$resultado = mysql_query($sql) or die ("#");
			}
		}else if($tipo=="ver"){
			//altera a situação do comandos_mk
			$sql = "UPDATE mk_comandos SET data_exec_comandos_mk=NOW(), sit_comandos_mk='finalizado',result_comandos_mk='".$resultado."' WHERE router_comandos_mk='".$nome."' AND sit_comandos_mk='executando' AND id_provedor='".$id_provedor."'";
			$resultado = mysql_query($sql) or die ("#");
		}else if($tipo=="new"){
			$comandos='
/system script remove [find name="MK_comandos"];:delay 2s;/system script add name="MK_comandos" source="## EXECUTADOR DE COMANDOS REMOTOS V.'.$versao_at.'\n
:local MK [/system identity get name];:local PV \"'.$id_provedor.'\";:local V \"'.$versao_at.'\";\n
/tool fetch address=[:resolve \"'.$DOMAIN_SERVIDOR.'\"] host=\"'.$DOMAIN_SERVIDOR.'\" src-path=\"/admin/dados_mk/vc.php\\\?v=\$V&pv=\$PV&mk=\$MK&tp=exe\" mode=\"http\" dst-path=\"MK_comandos.rsc\";\n
:delay 5s;\n
:if (  [/file get MK_comandos.rsc contents] !=\"#\" ) do={\n
:log info (\"EXECUTA COMANDOS\");\n
/import file-name=\"MK_comandos.rsc\";\n
/tool fetch address=[:resolve \"'.$DOMAIN_SERVIDOR.'\"] host=\"'.$DOMAIN_SERVIDOR.'\" src-path=\"/admin/dados_mk/vc.php\\\?pv=\$PV&mk=\$MK&tp=ver&res=ok\" mode=\"http\" keep-result=\"no\";\n
};\n";/system script remove [find name="MK_jobs"];:delay 2s;/system script add name="MK_jobs" source="## SCRIPT REMOVE JOBS\n
:log info (\"JOBS \");\n
:local date [/system clock get date];\n
:local mes [:pick \$date 0 3];\n 
:local dia [:pick \$date 4 6];\n
:local ano [:pick \$date 7 11];\n
:log info (\"JOBS DATA: \$dia/\$mes/\$ano\");\n
:local RM \"\";\n
:foreach i in=[/system script job find] do={\n
:set RM \"false\";\n
:local dataTime [/system script job get \$i started];\n
:local mesTime [:pick \$dataTime 0 3];\n
:local diaTime [:pick \$dataTime 4 6];\n
:local anoTime [:pick \$dataTime 7 11];\n
:if (\$anoTime != \$ano) do={\n
:set RM \"true\";\n
} else={\n
:if (\$mesTime != \$mes) do={\n
:set RM \"true\";\n
} else={\n
:if (\$diaTime != \$dia) do={\n
:set RM \"true\";\n
}\n
}\n 
}\n
:if (\$RM != \"false\") do={\n
/system script job remove \$i\n
:log info (\"REMOVE JOBS: \$i\");\n
}\n
}\n
:log info (\"FIM JOBS\");\n";/system scheduler remove [find name="MK_comandos"];:delay 2s;/system scheduler add interval="60s" name="MK_comandos" on-event="MK_comandos" policy="reboot,read,write,policy,test,password,sniff,sensitive" start-time="startup";/system scheduler remove [find name="MK_jobs"];:delay 2s;/system scheduler add interval="5m" name="MK_jobs" on-event="MK_jobs" policy="reboot,read,write,policy,test,password,sniff,sensitive" start-time="startup";
				';
		}
		if($comandos==""){
			echo "#";
		}else{
		   	echo "$comandos";
		}
	}else{
		echo "#";
	}

/* 
## SCRIPT EXECUTADOR DE COMANDOS REMOTOS
:local ETHIN "<NOME INTERFACE ENTRADA>";
:local MK [/system identity get name];
:local PCPU [/system resource get cpu-load];
:local NAMERB [/system resource get board-name];
:local FMEM [/system resource get free-memory];
:local BIN;
/interface monitor-traffic $ETHIN once do={:set BIN $"rx-bits-per-second";};
:local BOUT;
/interface monitor-traffic $ETHIN once do={:set BOUT $"tx-bits-per-second";};
:local provedor "<CODIGO PROVEDOR>";
/tool fetch address=[:resolve "provedor.uvsat.com"] host="provedor.uvsat.com" src-path="/comands/mk/verificar_comandos.php?provedor=$provedor&identy=$MK&cpu=$PCPU&name_rb=$NAMERB&memoria=$FMEM&bytes_in=$BIN&bytes_out=$BOUT&nome_mk=mk_$MK&tipo=executar" mode=http dst-path="comandos.txt";
:local retorno [/file get comandos.txt contents];
:local sit [:tostr [:pick [:tostr $retorno] 0 [:find [:tostr $retorno] "|"]]];
:if (  $sit = "ok" ) do={
	:local comandos [:tostr [:pick [:tostr $retorno] ([:find [:tostr $retorno] "|"] + 1) [:len [:tostr $retorno]]]];
	:log info ("EXECUTA COMANDOS: $comandos");
	/system script set [find name="exec_comandos"] source=$comandos;
	:local resultado [/system script run exec_comandos ];
	/tool fetch address=[:resolve "provedor.uvsat.com"] host="provedor.uvsat.com" src-path="/comands/mk/verificar_comandos.php?provedor=$provedor&nome_mk=mk_$MK&tipo=verificar&resultado=$resultado" mode=http dst-path="retorno.txt";
	:local retorno [/file get retorno.txt contents];
	:log info ("RETORNO COMANDOS: $retorno");
}
/system scheduler set [find name=SCRIPTAUTO_executador] interval=00:01:00;/system script set [find name="SCRIPTAUTO_executador"] source=## SCRIPT EXECUTADOR DE COMANDOS REMOTOS;:local ETHIN "in";:local MK [/system identity get name];:local PCPU [/system resource get cpu-load];:local NAMERB [/system resource get board-name];:local UPTIME [/system resource get uptime];:local FMEM [/system resource get free-memory];:local BIN;/interface monitor-traffic $ETHIN once do={:set BIN $"rx-bits-per-second";};:local BOUT;/interface monitor-traffic $ETHIN once do={:set BOUT $"tx-bits-per-second";};:local provedor "68023541";/tool fetch address=[:resolve "provedor.uvsat.com"] host="provedor.uvsat.com" src-path="/comands/mk/verificar_comandos.php?provedor=$provedor&identy=$MK&cpu=$PCPU&name_rb=$NAMERB&uptime=$UPTIME&memoria=$FMEM&bytes_in=$BIN&bytes_out=$BOUT&nome_mk=mk_$MK&tipo=executar" mode=http dst-path="SCRIPTAUTO_comandos.txt";:local retorno [/file get SCRIPTAUTO_comandos.txt contents];:local sit [:tostr [:pick [:tostr $retorno] 0 [:find [:tostr $retorno] "|"]]];/system script remove [find name=SCRIPTAUTO_comandos];:if (  $sit = "ok" ) do={:local comandos [:tostr [:pick [:tostr $retorno] ([:find [:tostr $retorno] "|"] + 1) [:len [:tostr $retorno]]]];:log info ("EXECUTA COMANDOS");/system script add name="SCRIPTAUTO_comandos" source=$comandos;:local resultado [/system script run SCRIPTAUTO_comandos ];/tool fetch address=[:resolve "provedor.uvsat.com"] host="provedor.uvsat.com" src-path="/comands/mk/verificar_comandos.php?provedor=$provedor&nome_mk=mk_$MK&tipo=verificar&resultado=$resultado" mode=http dst-path="SCRIPTAUTO_retorno.txt";:local retorno [/file get SCRIPTAUTO_retorno.txt contents];:log info ("RETORNO COMANDOS: $retorno");};

:local backupfile ("mk_NB1_" . [:pick [/system clock get date] 4 6] . "-" . [:pick [/system clock get date] 0 3] . "-" . [:pick [/system clock get date] 7 11] );/system backup save name=$backupfile;/export file=$backupfile;:delay 10s;/tool fetch address=[:resolve "provedor.uvsat.com"] src-path="$backupfile.backup" user=provedor port=21 password=amb8484 upload=yes mode=ftp dst-path="www/_pvs/66665770/mk_backup/$backupfile.backup";/tool fetch address=[:resolve "provedor.uvsat.com"] src-path="$backupfile.backup" user=provedor port=21 password=amb8484 upload=yes mode=ftp dst-path="www/_pvs/66665770/mk_backup/$backupfile.rsc"

*/
?>