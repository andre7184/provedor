BEGIN
	declare QTD INT default 0;
	-- ATUALIZA FATURA
	IF(idcliente>0 AND mesitem!='') THEN
		DELETE FROM `fc_itens` WHERE `id_cliente_itensfc`=idcliente AND `user_registro_item`='sistema' AND DATE_FORMAT(`data_itensfc`,"%Y-%m")=mesitem;
		-- LOG
		IF(ROW_COUNT()>0) THEN
			INSERT INTO `fc_logbd` SET `datatime_logbdfc`=NOW(),`tabela_logbdfc`='procedure:gera_faturas()',`id_cliente_logbdfc`=idcliente,`texto_logbdfc`=CONCAT('DELETA fc_itens WHERE:(id_cliente_itensfc=',idcliente,' AND user_registro_item=sistema AND data_itensfc=',mesitem,')');
		END IF;
	END IF;
	-- GERA FATURAS
	IF(idcliente>0) THEN
		INSERT INTO `fc_itens` SELECT * FROM `fcv_faturastemp` WHERE `id_cliente_faturatemp`=idcliente;
		SET QTD=ROW_COUNT();
	ELSE
		INSERT INTO `fc_itens` SELECT * FROM `fcv_faturastemp`;
		SET QTD=ROW_COUNT();
	END IF;
	IF(QTD>0) THEN
		-- LOG
		INSERT INTO `fc_logbd` SET `datatime_logbdfc`=NOW(),`tabela_logbdfc`='procedure:gera_faturas()',`id_cliente_logbdfc`=idcliente,`texto_logbdfc`=CONCAT('QTD FATURAS GERADAS:',QTD);
	END IF;
END