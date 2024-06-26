BEGIN
	declare COMANDOS_MK LONGTEXT;
	CASE acao
		WHEN 'add-secrets-pppoe' THEN 			
			SET COMANDOS_MK=(SELECT CONCAT('/ppp secret add',IF(`caller_id_secretpp`!='',CONCAT(' caller-id="',`caller_id_secretpp`,'"'),''),IF(`comment_secretpp`!='',CONCAT(' comment="',`comment_secretpp`,'"'),''),IF(`local_address_secretpp`!='',CONCAT(' local-address="',`local_address_secretpp`,'"'),''),IF(`name_secretpp`!='',CONCAT(' name="',`name_secretpp`,'"'),''),IF(`password_secretpp`!='',CONCAT(' password="',`password_secretpp`,'"'),''),IF(`profile_secretpp`!='',CONCAT(' profile="',`profile_secretpp`,'"'),''),IF(`remote_address_secretpp`!='',CONCAT(' remote-address="',`remote_address_secretpp`,'"'),''),';') FROM `mk_secretpp` WHERE `id_secretpp`=id_table);
		WHEN 'set-secrets-pppoe' THEN 			
		 	SET COMANDOS_MK=(SELECT CONCAT('/ppp secret set [find name="',`name_secretpp`,'"]',IF(`caller_id_secretpp`!='',CONCAT(' caller-id="',`caller_id_secretpp`,'"'),''),IF(`comment_secretpp`!='',CONCAT(' comment="',`comment_secretpp`,'"'),''),IF(`local_address_secretpp`!='',CONCAT(' local_address="',`local_address_secretpp`,'"'),''),IF(`name_secretpp`!='',CONCAT(' name="',`name_secretpp`,'"'),''),IF(`password_secretpp`!='',CONCAT(' password="',`password_secretpp`,'"'),''),IF(`profile_secretpp`!='',CONCAT(' profile="',`profile_secretpp`,'"'),''),IF(`remote_address_secretpp`!='',CONCAT(' remote-address="',`remote_address_secretpp`,'"'),''),';') FROM `mk_secretpp` WHERE `id_secretpp`=id_table);
		WHEN 'remove-secrets-pppoe' THEN 			
			SET COMANDOS_MK=(SELECT CONCAT('/ppp secret remove [find name="',`name_secretpp`,'"];') FROM `mk_secretpp` WHERE `id_secretpp`=id_table);
		WHEN 'add-profile-pppoe' THEN 			
			SET COMANDOS_MK=(SELECT CONCAT('/ppp profile add',IF(`name_profilepp`!='',CONCAT(' name="',`name_profilepp`,'"'),''),IF(`local_address_profilepp`!='',CONCAT(' local-address="',`local_address_profilepp`,'"'),''),IF(`remote_address_profilepp`!='',CONCAT(' remote-address="',`remote_address_profilepp`,'"'),''),IF(`address_list_profilepp`!='',CONCAT(' address-list="',`address_list_profilepp`,'"'),''),IF(`change_tcp_mss_profilepp`!='',CONCAT(' change-tcp-mss="',`change_tcp_mss_profilepp`,'"'),''),IF(`use_compression_profilepp`!='',CONCAT(' use-compression="',`use_compression_profilepp`,'"'),''),IF(`use_vj_compression_profilepp`!='',CONCAT(' use-vj-compression="',`use_vj_compression_profilepp`,'"'),''),IF(`use_encryption_profilepp`!='',CONCAT(' use-encryption="',`use_encryption_profilepp`,'"'),''),IF(`session_timeout_profilepp`!='',CONCAT(' session-timeout="',`session_timeout_profilepp`,'"'),''),IF(`idle_timeout_profilepp`!='',CONCAT(' idle-timeout="',`idle_timeout_profilepp`,'"'),''),IF(`rate_limit_profilepp`!='',CONCAT(' rate-limit="',`rate_limit_profilepp`,'"'),''),IF(`insert_queue-before_profilepp`!='',CONCAT(' insert-queue-before="',`insert_queue-before_profilepp`,'"'),''),IF(`parent_queue_profilepp`!='',CONCAT(' parent-queue="',`parent_queue_profilepp`,'"'),''),IF(`queue_type_profilepp`!='',CONCAT(' queue-type="',`queue_type_profilepp`,'"'),''),';') FROM `mk_profilepp` WHERE `id_profilepp`=id_table);
		WHEN 'set-profile-pppoe' THEN 			
			SET COMANDOS_MK=(SELECT CONCAT('/ppp profile set [find name="',`name_profilepp`,'"]',IF(`name_profilepp`!='',CONCAT(' name="',`name_profilepp`,'"'),''),IF(`local_address_profilepp`!='',CONCAT(' local-address="',`local_address_profilepp`,'"'),''),IF(`remote_address_profilepp`!='',CONCAT(' remote-address="',`remote_address_profilepp`,'"'),''),IF(`address_list_profilepp`!='',CONCAT(' address-list="',`address_list_profilepp`,'"'),''),IF(`change_tcp_mss_profilepp`!='',CONCAT(' change-tcp-mss="',`change_tcp_mss_profilepp`,'"'),''),IF(`use_compression_profilepp`!='',CONCAT(' use-compression="',`use_compression_profilepp`,'"'),''),IF(`use_vj_compression_profilepp`!='',CONCAT(' use-vj-compression="',`use_vj_compression_profilepp`,'"'),''),IF(`use_encryption_profilepp`!='',CONCAT(' use-encryption="',`use_encryption_profilepp`,'"'),''),IF(`session_timeout_profilepp`!='',CONCAT(' session-timeout="',`session_timeout_profilepp`,'"'),''),IF(`idle_timeout_profilepp`!='',CONCAT(' idle-timeout="',`idle_timeout_profilepp`,'"'),''),IF(`rate_limit_profilepp`!='',CONCAT(' rate-limit="',`rate_limit_profilepp`,'"'),''),IF(`insert_queue_before_profilepp`!='',CONCAT(' insert-queue-before="',`insert_queue_before_profilepp`,'"'),''),IF(`parent_queue_profilepp`!='',CONCAT(' parent-queue="',`parent_queue_profilepp`,'"'),''),IF(`queue_type_profilepp`!='',CONCAT(' queue-type="',`queue_type_profilepp`,'"'),''),';') FROM `mk_profilepp` WHERE `id_profilepp`=id_table);
		WHEN 'remove-profile-pppoe' THEN 			
			SET COMANDOS_MK=(SELECT CONCAT('/ppp profile remove [find name="',`name_profilepp`,'"];') FROM `mk_profilepp` WHERE `id_profilepp`=id_table);
		WHEN 'reboot-mk' THEN 			
			SET COMANDOS_MK='/system reboot;';
		WHEN 'remove-active-pppoe' THEN 			
			SET COMANDOS_MK=(SELECT CONCAT('/ppp active remove [find name="',`name_secretpp`,'"];') FROM `mk_secretpp` WHERE `id_secretpp`=id_table);
		WHEN 'set-comment-secrets-pppoe' THEN
			IF(coment!='') THEN
				SET COMANDOS_MK=CONCAT('/ppp secret set [find name="',(SELECT `name_secretpp` FROM `mk_secretpp` WHERE `id_secretpp`=id_table),'"] comment="',coment,'"');
		ELSE
			BEGIN 
				SET COMANDOS_MK='';
			END;
	END CASE;
	RETURN COMANDOS_MK;
END