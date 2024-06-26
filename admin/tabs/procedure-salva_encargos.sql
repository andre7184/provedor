BEGIN
	declare done INT DEFAULT 0;
	declare ACAO CHAR(1);
	declare ID_ITEM INT;
	declare ID INT;
	declare MES VARCHAR(7);
	declare DATA date;
	declare VALOR float;
	declare DIAS INT;
	declare MULTA float;
	declare JUROS float;
	declare PROVEDOR INT;
	DECLARE curs CURSOR FOR (
		SELECT  `acao_encargosnewfc`, `id_itens_encargosnewfc`, `id_cliente_encargosnewfc`, `mes_encargosnewfc`, `data_encargosnewfc`, `valor_encargosnewfc`, `dias_encargosnewfc`, `valor_multa_encargosnewfc`, `valor_juros_encargosnewfc`, `id_provedor`  FROM `fcv_encargosnew`
	);		
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
 	OPEN curs;
		REPEAT FETCH curs INTO ACAO, ID_ITEM, ID, MES, DATA, VALOR, DIAS, MULTA, JUROS, PROVEDOR;
		IF NOT done THEN
        	IF (idcliente=0) THEN
            	SET idcliente=ID;
            END IF;
        	IF (idcliente=ID) THEN
                CASE ACAO
                WHEN 'D' THEN 
                    IF(ID_ITEM IS NOT NULL) THEN
                        DELETE FROM `fc_encargos` WHERE `id_encargosfc`=ID_ITEM;		
                    END IF;
                WHEN 'F' THEN 
                    IF(ID_ITEM IS NOT NULL AND DATA IS NOT NULL) THEN
                        UPDATE `fc_encargos` SET `data_fim_encargosfc`=DATA WHERE `id_encargosfc`=ID_ITEM;
                    END IF;
                ELSE
                    BEGIN
                        IF(ID_ITEM IS NOT NULL) THEN
                            UPDATE `fc_encargos` SET `dias_encargosfc`=DIAS,`data_atz_encargosfc`=CURDATE(),`valor_divida_encargosfc`=VALOR,`valor_multa_encargosfc`=MULTA,`valor_juros_encargosfc`=(valor_juros_encargosfc+JUROS) WHERE `id_encargosfc`=ID_ITEM;
                        ELSE
                            INSERT INTO `fc_encargos` SET `mes_encargosfc`=MES,`data_inicio_encargosfc`=DATA,`data_atz_encargosfc`=CURDATE(),`dias_encargosfc`=DIAS,`valor_divida_encargosfc`=VALOR,`valor_multa_encargosfc`=MULTA,`valor_juros_encargosfc`=JUROS,`id_cliente_encargosfc`=ID,`id_provedor`=PROVEDOR;
                        END IF;
                    END;
                END CASE;
           	END IF;
		END IF;
	  	UNTIL done END REPEAT;
	CLOSE curs;
END