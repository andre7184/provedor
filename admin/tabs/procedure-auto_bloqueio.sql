BEGIN
	declare done INT DEFAULT 0;
	declare qtd_bl INT DEFAULT 0;
    declare EXE boolean;
  	declare ID INT;
  	declare PROVEDOR INT;
  	declare PFB VARCHAR(50);
  	declare NOME VARCHAR(255);
	DECLARE curs CURSOR FOR (
		SELECT IF(SUM(`d`.`valor_dividasfc`)>`p`.`valor_min_bloqueio_provedorfc`,true,false),`d`.`id_dividasfc`,`p`.`porcentagem_desbloqueio_provedorfc`,`c`.`nome_clientesfc`,`d`.`id_provedor` FROM `fcv_dividas` AS `d` INNER JOIN `fc_clientes` AS `c` ON `c`.`id_clientesfc`=`d`.`id_dividasfc` INNER JOIN `fc_provedor` AS `p` ON `p`.`id_provedorfc`=`d`.`id_provedor` WHERE `c`.`sit_clientesfc`='ativo' AND `c`.`destivar_bloqueio_clientesfc`!='on' AND ADD_DIAS_UTEIS(`d`.`data_dividasfc`,`p`.`dias_bloqueio_auto_provedorfc`,`c`.`cid1_clientesfc`,`c`.`uf1_clientesfc`) <= CURDATE() AND (SELECT COUNT(*) FROM `fc_inforpg` WHERE `id_cliente_inforpgfc`=`d`.`id_dividasfc` AND `sit_inforpgfc`='aberto' AND `data_inforpgfc` > CURDATE())=0 GROUP BY `d`.`id_dividasfc`
	);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
 	OPEN curs;
		REPEAT FETCH curs INTO EXE, ID, PFB, NOME, PROVEDOR;
		IF NOT done THEN 
			IF (EXE) THEN
	        	INSERT INTO fc_bloqueios SET datatime_bloqueiosfc=NOW(),data_bloqueiosfc=CURDATE(),exe_bloqueiosfc='on',motivo_bloqueiosfc='atraso',porcentagem_fim_bloqueiosfc=PFB,id_cliente_bloqueiosfc=ID,id_provedor=PROVEDOR;
	           	SET qtd_bl=qtd_bl+1;
			END IF;
		END IF;
	UNTIL done END REPEAT;
	CLOSE curs; 
	INSERT INTO fc_logbd SET datatime_logbdfc=NOW(),tabela_logbdfc='procedure:auto_bloqueio()',texto_logbdfc=CONCAT('Qnt:',qtd_bl); 
END