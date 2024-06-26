BEGIN
	declare done INT DEFAULT 0;
	declare qtd_bl INT DEFAULT 0;
    declare qtd_db INT DEFAULT 0;
  	declare ID INT;
  	declare PROVEDOR INT;
  	declare ACAO VARCHAR(50);
	DECLARE curs CURSOR FOR (
		SELECT id_bloqueiosfc,IF(data_agenda_bloqueiosfc=curdate(),'bloquear','desbloquear') AS acao,id_provedor FROM fc_bloqueios WHERE (exe_bloqueiosfc!='on' AND data_bloqueiosfc <= curdate()) OR (exe_fim_bloqueiosfc!='on' AND data_fim_bloqueiosfc <= curdate())
	);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
 	OPEN curs;
	REPEAT FETCH curs INTO ID, ACAO, PROVEDOR;
		IF NOT done THEN 
			CASE ACAO
				WHEN 'bloquear' THEN 
				    UPDATE fc_bloqueios SET exe_bloqueiosfc='on' WHERE id_bloqueiosfc=ID;
					SET qtd_bl=qtd_bl+1;
				ELSE
                   BEGIN
						UPDATE fc_bloqueios SET exe_fim_bloqueiosfc='on' WHERE id_bloqueiosfc=ID;
						SET qtd_db=qtd_db+1;
					END;
            END CASE;
		END IF;
	UNTIL done END REPEAT;
	CLOSE curs;
	INSERT INTO fc_logbd SET datatime_logbdfc=NOW(),tabela_logbdfc='procedure:agenda_bloqueio()',texto_logbdfc=CONCAT('Bloqueados:',qtd_bl,'Desbloqueados:',qtd_db); 
END