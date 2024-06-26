CREATE VIEW `fcv_descontos` AS SELECT 
	`i`.`id_cliente_itensfc` AS id_descontosfc,
	DATE_FORMAT(`i`.`data_itensfc`,"%Y-%m") AS mes_descontosfc,
	GROUP_CONCAT(`i`.`nome_itensfc` SEPARATOR ';') AS nome_descontosfc,
	GROUP_CONCAT(`i`.`inicio_periodo_itensfc`,'|',`i`.`fim_periodo_itensfc` SEPARATOR ';') AS periodo_descontosfc,
 	GROUP_CONCAT(`i`.`descricao_itensfc`,': - R$ ',REPLACE(`i`.`valor_total_itensfc`,'.',',') SEPARATOR ';') AS descricao_descontosfc,
  	ROUND(SUM(`i`.`valor_total_itensfc`),2) AS total_descontosfc,
  	`c`.`grupo_parceria`,
  	`i`.`id_provedor` AS id_provedor 
  	FROM `fc_itens` AS `i`
  	INNER JOIN `fc_clientes` AS `c` ON `c`.`id_clientesfc`=`i`.`id_cliente_itensfc`
  	WHERE `i`.`tipo_itensfc`='-' AND DATE_FORMAT(`i`.`data_itensfc`,"%Y-%m") <= DATE_FORMAT(CURDATE(),"%Y-%m") AND `i`.`id_vendas_itensfc`=0 AND `i`.`cancelado_itensfc`!='on' AND `i`.`dif_itensfc`!='on'
	GROUP BY `i`.`id_cliente_itensfc`,DATE_FORMAT(`i`.`data_itensfc`,"%Y-%m") 