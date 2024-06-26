-- `exe_bloqueio_desbloqueio`(IN `tipo` VARCHAR(10), IN `id` INT, IN `id_cliente` INT, IN `provedor` INT)
BEGIN
	declare sit VARCHAR(20);
	CASE tipo
		WHEN 'bloquear' THEN 
			SET sit='bloqueado';
			UPDATE `mk_secretpp` SET `profile_save_secretpp`=`profile_secretpp`,`profile_secretpp`='bloqueados',`tipo_secretpp`='atz' WHERE `id_cliente_secretpp`=id_cliente;
		ELSE
            BEGIN
                SET sit='ativo';
				UPDATE `mk_secretpp` SET `profile_secretpp`=`profile_save_secretpp`,`tipo_secretpp`='atz' WHERE `id_cliente_secretpp`=id_cliente;
            END;
	END CASE;
	UPDATE `fc_clientes` SET `sit_clientesfc`=sit WHERE `id_clientesfc`=id_cliente;
	INSERT INTO `fc_logbd` SET `datatime_logbdfc`=NOW(),`tabela_logbdfc`='procedure:exe_bloqueio_desbloqueio()',`texto_logbdfc`=CONCAT('ACAO:',tipo),`id_provedor`=provedor; 
END