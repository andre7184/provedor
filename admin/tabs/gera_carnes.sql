BEGIN
	declare done INT DEFAULT 0;
    declare ID INT;
	declare QTD INT;
	declare CIDADE VARCHAR(255);
	declare UF VARCHAR(2);
    -- 
	DECLARE curs CURSOR FOR (
		SELECT `id_clientesfc`,`carne_clientesfc`,`cid1_clientesfc`,`uf1_clientesfc` FROM `fc_clientes` WHERE `carne_clientesfc`>0 AND `id_clientesfc` IN (SELECT `id_cliente_faturatemp` FROM `fcv_faturastemp`)
	);
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
 	OPEN curs;
		REPEAT FETCH curs INTO ID, QTD, CIDADE, UF;
		IF NOT done THEN
        	CREATE TEMPORARY TABLE fcv_carneTemp SELECT * FROM fcv_faturastemp WHERE `id_cliente_faturatemp`=ID;
            WHILE (QTD > 0) DO
            	INSERT INTO `fc_itens` SELECT * FROM `fcv_carneTemp`;
            	--
                UPDATE fcv_carneTemp SET `inicio_periodo_faturatemp`=IF(inicio_periodo_faturatemp != '0000-00-00', DATE_ADD(inicio_periodo_faturatemp,INTERVAL 1 MONTH), inicio_periodo_faturatemp), `fim_periodo_faturatemp`=IF(fim_periodo_faturatemp != '0000-00-00', DATE_ADD(fim_periodo_faturatemp,INTERVAL 1 MONTH), fim_periodo_faturatemp), `data_faturatemp`=ADD_DATA_UTIL(DATE_ADD(data_faturatemp,INTERVAL 1 MONTH),CIDADE,UF),`descricao_faturatemp`=IF(`nome_faturatemp`='MENSALIDADE',REPLACE(`descricao_faturatemp`,SPLIT_STRING(`descricao_faturatemp`,'#',2),DATE_FORMAT(DATE_ADD(str_to_date(CONCAT(SPLIT_STRING(`descricao_faturatemp`,'#',2),'/01'), '%m/%Y/%d'),INTERVAL 1 MONTH),"%m/%Y")),`descricao_faturatemp`);
                SET QTD=(QTD-1);
            END WHILE;
		END IF;
	UNTIL done END REPEAT;
	CLOSE curs; 
END