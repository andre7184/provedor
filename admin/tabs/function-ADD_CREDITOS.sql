-- `ADD_CREDITOS`(IN `id_pagamento` INT, IN `id_cliente` INT, IN `data_fatura` DATE, IN `provedor` INT)
BEGIN
	declare done INT DEFAULT 0;
	declare VALOR float;
	declare DATA_ORIGEM date;
	declare DATA_NEW date;
	declare NOME VARCHAR(10);
	declare TIPO CHAR(1);
	declare DESCRICAO LONGTEXT;
	-- 
	SET DATA_ORIGEM=data_fatura;
	SET DATA_NEW=data_fatura;
	SET VALOR=(SELECT diferenca_faturafc FROM `fcv_faturas` WHERE `id_faturafc`=id_cliente AND `tipo_pg_faturafc` LIKE 'MAIOR' AND `diferenca_faturafc` > 0 AND DATE_FORMAT(`vencimento_faturafc`,"%m-%Y")=DATE_FORMAT(DATA_NEW,"%m-%Y"));
	IF(VALOR IS NULL) THEN
		SET VALOR=0;
	END IF;
	WHILE (VALOR > 0) 
	DO 
		SET NOME='CREDITO';
		SET TIPO='-';
		SET DESCRICAO=CONCAT('CREDITO POR PAGAMENTO MAIOR NO MÊS ',DATE_FORMAT(DATA_NEW,"%m-%Y"));
		SET DATA_NEW=DATE_ADD(DATA_NEW, INTERVAL 1 MONTH);
		INSERT INTO `fc_itens` SET `datatime_itensfc`=NOW(),`nome_itensfc`=NOME,`tipo_itensfc`=TIPO,`descricao_itensfc`=DESCRICAO,`data_origem_itensfc`=DATA_ORIGEM,`data_itensfc`=DATA_NEW,`dif_itensfc`='on',`id_pagamento_itensfc`=id_pagamento,`valor_itensfc`=VALOR,`qtd_itensfc`='1',`valor_total_itensfc`=VALOR,`id_cliente_itensfc`=id_cliente,`user_registro_item`='sistema',`id_provedor`=provedor;
        DO SLEEP(1);
        SET VALOR=(SELECT diferenca_faturafc FROM `fcv_faturas` WHERE `id_faturafc`=id_cliente AND `tipo_pg_faturafc` LIKE 'MAIOR' AND `diferenca_faturafc` > 0 AND DATE_FORMAT(`vencimento_faturafc`,"%m-%Y")=DATE_FORMAT(DATA_NEW,"%m-%Y"));
        IF(VALOR IS NULL) THEN
            SET VALOR=0;
        END IF;
    END WHILE;
    RETURN true;
END