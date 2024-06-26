-- `auto_desbloqueio`(IN `valorpago` FLOAT, IN `idcliente` INT)
BEGIN
	declare BL VARCHAR(50);
	declare PORCENTAGEM FLOAT;
	declare ID INT;
	declare DIVIDA FLOAT;
	declare EXE boolean default true;
	SET BL=(SELECT CONCAT(id_bloqueiosfc,'|',IF(porcentagem_fim_bloqueiosfc>0,(porcentagem_fim_bloqueiosfc/100),0)) AS porcentagem FROM `fc_bloqueios` WHERE id_cliente_bloqueiosfc=idcliente AND data_fim_bloqueiosfc='0000-00-00' AND motivo_bloqueiosfc='atraso');
	IF(BL IS NOT NULL) THEN
		SET PORCENTAGEM=SUBSTRING(BL, LOCATE('|',BL) + 1);
		SET ID=LEFT(BL, LOCATE('|',BL) - 1);
        IF (valorpago > 0) THEN
            IF (PORCENTAGEM != 0) THEN
                SET DIVIDA=(SELECT SUM(valor_dividasfc)+SUM(encargos_dividasfc) AS valor FROM `fcv_dividas` WHERE `id_dividasfc`=idcliente GROUP BY `id_dividasfc`);
                -- INSERT INTO fc_logbd SET datatime_logbdfc=NOW(),tabela_logbdfc='procedure:auto_desbloqueio()',texto_logbdfc=CONCAT('PAGO:',valorpago,' < DIVIDA:',(DIVIDA*PORCENTAGEM)); 
                IF (valorpago < (DIVIDA*PORCENTAGEM)) THEN
                    SET EXE=false;
                END IF;
            END IF;
            IF (EXE) THEN
                -- INSERT INTO fc_logbd SET datatime_logbdfc=NOW(),tabela_logbdfc='procedure:auto_desbloqueio()',texto_logbdfc='EXE DESBLOQUEIO'; 
                UPDATE fc_bloqueios SET datatime_fim_bloqueiosfc=NOW(),data_fim_bloqueiosfc=CURDATE(),exe_fim_bloqueiosfc='on',motivo_fim_bloqueiosfc='pagamento realizado' WHERE id_bloqueiosfc=ID;
                INSERT INTO fc_logbd SET datatime_logbdfc=NOW(),tabela_logbdfc='procedure:auto_desbloqueio()',texto_logbdfc=CONCAT('CLIENTE Desbloqueado:',idcliente); 
            END IF;
		END IF;
	END IF;
END