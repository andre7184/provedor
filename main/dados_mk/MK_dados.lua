:local DOMA "mkfacil.cf";
:local PROV "TECNET";
:local IDPR "2";
:local SFTP "mk1425";
:local convertDate do={
    :if ($1="") do={ :error "data invalida."; }
    :local uptimehms;
    :local uptime $1;
    :local days;
    :local weeks;
    :local hours;
    :local daypos;
    :set daypos (0);

    :for pos from=0 to=([:len $uptime] - 8) do={
        # Find "w" and the weeks
        :if ([:pick $uptime $pos] = "w") do={
            :set weeks ( [:pick $uptime 0 ($pos)] );
            :set daypos ($pos+1);
        }
        # Find "d" and days
        :if ([:pick $uptime $pos] = "d") do={
            :set days ( [:pick $uptime ($daypos) ($pos)] );
        }
    }
    # Recalculate hours and add :min:sec
    :set hours ([:pick $uptime ([:len $uptime]-8) ([:len $uptime]-6)]);
    :set uptimehms ([:tostr (($weeks * 24 * 7) + ($days * 24) + $hours)].([:pick $uptime ([:len $uptime]-6) [:len $uptime]]));
    :return $uptimehms;
};
:local sumDate do={
    :if ($1="") do={ :error "data1 invalida."; }
    :if ($2="") do={ :error "data2 invalida."; }
    :local uptime [:toarray "$1,$2"];
    :local hour 0;
    :local seco 0;
    :local minu 0;
    :foreach data in=$uptime do={ 
        :local tam [:len $data];
        :local pos1 [:find [:tostr $data] ":"];
        :local pos2 ([:find [:tostr [:pick $data ($pos1+1) $tam]] ":"]+($pos1+1));
        :set seco ($seco + ([:pick $data ($pos2+1) $tam]));
        :if ($seco > 59) do={
            :set minu ($minu + 1);
            :set seco ($seco - 60);
        }
        :set minu ($minu + ([:pick $data ($pos1+1) $pos2]));
        :if ($minu > 59) do={
            :set hour ($hour + 1);
            :set minu ($minu - 60);
        }
        :set hour ($hour + ([:pick $data 0 $pos1]));
    }
    :if ($hour < 10) do={ :set hour "0$hour";}
    :if ($minu < 10) do={ :set minu "0$minu";}
    :if ($seco < 10) do={ :set seco "0$seco";}
    :local newdata "$hour:$minu:$seco";
    :return $newdata;
};
:local returnOctet do={
    :if ($1="") do={ :error "You did not specify an IP Address."; }
    :if ($2="") do={ :error "You did not specify an octet to return."; }
    :if (($2>"5") || ($2<"0")) do={ :error "Octet argument out of range."; }
    :local decimalPos "0";
    :local octet1;
    :local octet2;
    :local octet3;
    :local octet4;
    :local octetArray; 
    :set decimalPos [:find $1 "."];
    :set octet1 [:pick $1 0 $decimalPos];
    :set decimalPos ($decimalPos+1);
    :set octet2  [:pick $1 $decimalPos [:find $1 "." $decimalPos]];
    :set decimalPos ([:find $1 "." $decimalPos]+1);
    :set octet3  [:pick $1 $decimalPos [:find $1 "." $decimalPos]];
    :set decimalPos ([:find $1 "." $decimalPos]+1);
    :set octet4 [:pick $1 $decimalPos [:len $1]];
    :set octetArray [:toarray "$octet1,$octet2,$octet3,$octet4"];
    :if (($octet1<"0" || $octet1>"255") || ($octet2<"0" || $octet2>"255") || ($octet3<"0" || $octet3>"255") || ($octet4<"0" || $octet4>"255")) do={ :error "Octet out of range."; }
    :if ($2="0") do={ :return $octet1; }
    :if ($2="1") do={ :return $octet2; }
    :if ($2="2") do={ :return $octet3; }
    :if ($2="3") do={ :return $octet4; }
    :if ($2="4") do={ :return $octetArray; }
    :if ($2="5") do={ :return "$octet1$octet2$octet3$octet4"; }
};
:local arrayPush do={
    :local arrX value=[:toarray $1];
    :if ([:len $arrX] = 0) do={ :set $arrX value=[:toarray ""]; };
    :local arrXlen value=[:len $arrX];
    :local valX value=[:tostr $2];
    :if ($valX = "") do={ :return value=$arrX; };
    :local posX value=([:tostr $3]);
    :if ($posX = "") do={ :set $posX value=($arrXlen + 1); };
    :set $posX value=([:tonum $posX] + 0);
    :if ($posX < 0) do={ :set $posX value=0; };
    :if ($posX > $arrXlen) do={ :set $posX value=$arrXlen; };
    :if ($posX = 0) do={ :return value=($valX,$arrX); };
    :if ($posX = $arrXlen) do={ :return value=($arrX,$valX); };
    :return value=([:pick $arrX 0 ($posX - 1)],$valX,[:pick $arrX ($posX - 1) $arrXlen]);
};
:local saveFile do={
    # USE [$saveFile {nome do arquivo} {dados a salvar no arquivo(Array)} {1° linha do arquivo(OPCIONAL)}]
    :if ($1="") do={ :error "Nome file not specify."; }
    :if ($2="") do={ :error "Dados (ARRAY) to file not specify."; }
    :log info ("CRIANDO FILE $1");
    :local newFile do={
        # USE [$newFile {nome do arquivo} {dados a salvar no arquivo}]
        :if ($1="") do={ :error "Nome file not specify."; }
        :if ($2="") do={ :error "Dados to file not specify."; }
        :if ([:len [/file find name="$1.txt"]] != 1) do={
            /file print file=$1;
            :delay 200ms;
        }       
        :log info ("SALVANDO FILE $1 (".[:len $2].")");
        /file set [find name="$1.txt"] contents="$2";
        :delay 200ms;
        :log info ("ENVIANDO FILE $1 FTP");
        /tool fetch address=[:resolve "mkfacil.cf"] src-path="$1.txt" user="mk@mkfacil.cf" port="21" password="mk1425" upload="yes" mode="ftp" dst-path="TECNET/$1.txt";
        :delay 200ms;
        :log info ("FILE $1 FTP OK");
        /file set [find name="$1.txt"] contents="";
        :return "ok";
    };
    :local dados "$3";
    :local retorno;
    :local n 0;
    :foreach line in=$2 do={
        :if ([:len "$dados\n$line"] < "4000") do={
                :set dados "$dados\n$line";
        } else={
                :set retorno [$newFile ($1."-".$n) $dados];
                :set n ($n+1); 
                :set dados "";
        }
    }
    :if ([:len $dados] > "0") do={:set retorno [$newFile ($1."-".$n) $dados];}
    :return "ok";
};
######################
# #:log info ("QUEUES");
# # == QUEUES == # #
# # :local queue {""->""};
# # :local logqueue "";
# # :local timeinicio ([/system clock get date]." ".[/system clock get time]);
# # :for j from=0 to=10 do={
# #  	:foreach line in=[/queue simple print rate as-value] do={
# #  	 	:local target "";
# #  	 	:if ([:pick $line 4] != [:pick $line 2]) do={
# #  	 		:set target [:pick $line 4];
# #  	 	}
# #  	 	:set ($queue->([:pick $line 2]."|".$target)) (($queue->([:pick $line 2]."|".$target)).",".[:pick $line 3]);
# #  	}
# #  	:delay 30;
# # }
# # :foreach k,v in=$queue do={
# #  	 :set logqueue [$arrayPush $logqueue ($k.$v)];
# # }
# # :if ([:len $logqueue] > 0) do={:local queueLog [$saveFile ([/system routerboard get serial-number]."_logqueue") $logqueue ("#,".$timeinicio."|".[/system clock get date]." ".# # [/system clock get time].",name,target,tx/rx")];}
######################
# #:log info ("ACESSOS");
# # == ACESSOS == # #
# #:local dad "";
# #:local sta {""->""};
# #:foreach line in=[/ip firewall address-list print as-value] do={
# # 	:if ([:pick $line 3]~"(bloqueados|vencidos)") do={
# # 	 	:set ($sta->("ip".[:pick $line 1])) [:pick $line 3];
# # 	} 
# #}
# #:local rxA {""->""};
# #:local txA {""->""};
# #:foreach int in=[/interface pppoe-server find] do={
# # 	 :set ($rxA->[/interface get $int name]) [/interface get $int rx-byte];
# #	 :set ($txA->[/interface get $int name]) [/interface get $int tx-byte];
# #}
# #:foreach int in=[/ppp active print as-value ] do={
# #	:local user [:pick $int 4];
# #	:local rx ($rxA->("<pppoe-".$user.">"));
# #	:local tx ($txA->("<pppoe-".$user.">"));
# #	:local st "at";
# #	:if ( ($sta->("ip".[:pick $int 1])) = "bloqueados" ) do={
# #	 	:set st "bl";
# #	}
# #	:if ( ($sta->("ip".[:pick $int 1])) = "vencidos" ) do={
# #	 	:set st "vc";
# #	}
# # 	:set dad [$arrayPush $dad ([:pick $int 1].",".[:pick $int 2].",$user,".[$convertDate [:pick $int 6]].",$rx,$tx,pp,on,$st,")];
# #   	:delay 10ms;
# #}
# #:local userA {""->""};
# #:local upA {""->""};
# #:foreach int in=[/ip hotspot active print as-value ] do={
# #	:set ($userA->[$returnOctet [:pick $int 1] "5"]) [:pick $int 3];
# #	:set ($upA->[$returnOctet [:pick $int 1] "5"]) [:pick $int 2];
# #}
# #:foreach id in=[/ip hotspot host find] do={
# #	:local ip [/ip hotspot host get $id address];
# #                :local up [$convertDate [/ip hotspot host get $id uptime]];
# #	:local user "";
# #	:local status "";
# #  	:if ([/ip hotspot host get $id authorized]) do={
# # 		:set user ($userA->[$returnOctet $ip "5"]);
# #  		:set up [$convertDate ($upA->[$returnOctet $ip "5"])];
# # 		:set status "on";
# # 	} else={
# # 		:if ([/ip hotspot host get $id bypassed]) do={
# # 			:set user [$returnOctet $ip "5"];
# # 			:set status "ib";
# # 		} else={
# # 			:set user "";
# # 			:set status "of";
# # 		}
# # 	}
# #	:local st "at";
# #	:if ( ($sta->("ip".$ip)) = "bloqueados" ) do={
# #	 	:set st "bl";
# #	}
# #	:if ( ($sta->("ip".$ip)) = "vencidos" ) do={
# #	 	:set st "vc";
# #	}
# # 	:set dad [$arrayPush $dad ("$ip,".[/ip hotspot host get $id mac-address].",$user,$up,".[/ip hotspot host get $id bytes-in].",".[/ip hotspot host get $id bytes-out].",hp,$status,$st,")];
# # 	:delay 10ms;
# #}
# #:if ([:len $dad] > 0) do={:local logAcessos [$saveFile ([/system routerboard get serial-number]."_acessos") $dad ("#,".[/system clock get date]." ".[/system clock get time].",ip,mac,login,uptime,rx-bytes,tx-bytes,tipo,status,situacao,ultimo-acesso")];}
######################
:log info ("SECRETS PPPOE");
# # == SECRETS PPPOE == # #
:local secretpp "";
:foreach int in=[/ppp secret find where !disabled] do={
	:local com [/ppp secret get $int comment];
	:local comment $com;
	# #:if ( [:pick $comment 0 [:find $comment "#"]] = "0" ) do={
	# #	:set comment $com;
	# #} else={
	# #	:set comment "";
	# #}
  	:set secretpp [$arrayPush $secretpp ([/ppp secret get $int name].",".[/ppp secret get $int password].",".[/ppp secret get $int caller-id].",".[/ppp secret get $int profile].",".[/ppp secret get $int local-address].",".[/ppp secret get $int remote-address].",".[/ppp secret get $int last-logged-out].",".$comment.",")];
  	:delay 10ms;
}
:if ([:len $secretpp] > 0) do={:local pppoeSecret [$saveFile ([/system routerboard get serial-number]."_secretpp") $secretpp ("#,".[/system clock get date]." ".[/system clock get time].",name,password,caller-id,profile,local-address,remote-address,last-logged-out,comment")];}
######################
:log info ("PROFILES PPPOE");
# # == PROFILES PPPOE == # #
:local profilepp "";
:foreach int in=[/ppp profile find where !default] do={
  	:set profilepp [$arrayPush $profilepp ([/ppp profile get $int name].",".[/ppp profile get $int local-address].",".[/ppp profile get $int remote-address].",".[/ppp profile get $int address-list].",".[/ppp profile get $int change-tcp-mss].",".[/ppp profile get $int use-compression].",,".[/ppp profile get $int use-encryption].",".[/ppp profile get $int session-timeout].",".[/ppp profile get $int idle-timeout].",".[/ppp profile get $int rate-limit].",".[/ppp profile get $int insert-queue-before].",".[/ppp profile get $int parent-queue].",".[/ppp profile get $int queue-type])];
  	:delay 10ms;
}
:if ([:len $profilepp] > 0) do={:local pppoeProfiles [$saveFile ([/system routerboard get serial-number]."_profilepp") $profilepp ("#,".[/system clock get date]." ".[/system clock get time].",name,local-address,remote-address,address-list,change-tcp-mss,use-compression,use-vj-compression,use-encryption,session-timeout,idle-timeout,rate-limit,insert-queue-before,parent-queue,queue-type")];}
# 
# # == NETWATCH == # #
:local netwatch "";
:foreach int in=[/tool netwatch print as-value ] do={
 	:set netwatch [$arrayPush $netwatch ([:pick $int 1].",".[:pick $int 2].",".[:pick $int 4].",".[:pick $int 5])];
	:delay 10ms;
}
:if ([:len $netwatch] > 0) do={:local netwatchSit [$saveFile ([/system routerboard get serial-number]."_lognetwatch") $netwatch ("#,".[/system clock get date]." ".[/system clock get time].",name,host,since,status")];}
# # 
:local IDMK [/system identity get name];
:local SNMK [/system routerboard get serial-number];
#:local CLMK [/system resource get cpu-load];
:local BNMK [/system resource get board-name];
:local UPMK [/system resource get uptime];
#:local FMMK [/system resource get free-memory];
/tool fetch address=[:resolve "$DOMA"] host="$DOMA" src-path=("/main/dados_mk/start_save_log.php?id=".$IDPR."&pv=".$PROV."&mk=".$IDMK."&rb=true&name_rb=".$BNMK."&sn=".$SNMK."&uptime=".$UPMK) mode="http" dst-path="MK_dados.txt";
:delay 200ms;
:log info ("FIM SCRIPT");