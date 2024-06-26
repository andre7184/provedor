-- `altera_inforpg`(IN `id_cliente` INT)
BEGIN
	declare valorpago float;
	set valorpago=(SELECT IFNULL(SUM(`valor_caixafc`),0)+IFNULL(SUM(`valor_desconto_caixafc`),0) FROM `fc_caixa` WHERE `tipo_caixafc`='in' AND `id_cliente_caixafc`=id_cliente AND `data_pagamento_caixafc` > IFNULL((SELECT DATE_FORMAT(datatime_inforpgfc,"%Y-%m-%d") FROM `fc_inforpg` WHERE (`sit_inforpgfc`='aberto' OR `sit_inforpgfc`='agendado') AND `id_cliente_inforpgfc`=id_cliente ORDER BY `id_inforpgfc` DESC LIMIT 1),CURDATE()));
	IF(valorpago>0) THEN
		UPDATE `fc_inforpg` SET `sit_inforpgfc`='fechado',`data_fechamento_inforpgfc`=CURDATE(),`obs_inforpgfc`=CONCAT('PAGAMENTO + DESCONTO EFETUADO DE R$ ',valorpago) WHERE `sit_inforpgfc`='aberto' AND `id_cliente_inforpgfc`=id_cliente AND `valor_inforpgfc` <= valorpago; 
		UPDATE `fc_inforpg` SET `sit_inforpgfc`='aberto',`datatime_inforpgfc`=NOW(),`obs_inforpgfc`=CONCAT('PAGAMENTO + DESCONTO EFETUADO DE R$ ',valorpago) WHERE `sit_inforpgfc`='agendado' AND `id_cliente_inforpgfc`=id_cliente AND `valor_agendamento_inforpgfc` <= valorpago;
	END IF;
END