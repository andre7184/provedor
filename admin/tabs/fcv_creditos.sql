CREATE VIEW `fcv_creditos` AS SELECT 
	`i`.`id_cliente_itensfc` AS id_creditosfc,
	DATE_FORMAT(`i`.`data_itensfc`,"%Y-%m") AS mes_creditosfc,
	GROUP_CONCAT(`i`.`nome_itensfc` SEPARATOR ';') AS nome_creditosfc,
	GROUP_CONCAT(`i`.`data_origem_itensfc` SEPARATOR ';') AS datas_creditosfc,
	GROUP_CONCAT(`i`.`inicio_periodo_itensfc`,'|',`i`.`fim_periodo_itensfc` SEPARATOR ';') AS periodo_creditosfc,
 	GROUP_CONCAT(`i`.`descricao_itensfc`,': - R$ ',REPLACE(`i`.`valor_total_itensfc`,'.',',') SEPARATOR ';') AS descricao_creditosfc,
  	ROUND(SUM(`i`.`valor_total_itensfc`),2) AS total_creditosfc,
  	`i`.`id_pagamento_itensfc` AS id_pagamento_creditosfc, 
  	`c`.`grupo_parceria`,
  	`i`.`id_provedor` AS id_provedor 
  	FROM `fc_itens` AS `i`
  	INNER JOIN `fc_clientes` AS `c` ON `c`.`id_clientesfc`=`i`.`id_cliente_itensfc`
  	WHERE `i`.`tipo_itensfc`='-' AND `i`.`id_vendas_itensfc`=0 AND `i`.`cancelado_itensfc`!='on' AND `i`.`dif_itensfc`='on'
	GROUP BY `i`.`id_cliente_itensfc`,DATE_FORMAT(`i`.`data_itensfc`,"%Y-%m")