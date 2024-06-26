CREATE VIEW `fcv_encargos` AS SELECT 
`e`.`id_cliente_encargosfc` AS id_encargosfcv,
`e`.`mes_encargosfc` AS mes_encargosfcv,
GROUP_CONCAT(`e`.`valor_divida_encargosfc`,'|',`e`.`data_inicio_encargosfc`,'|',`e`.`data_fim_encargosfc`,'|',`e`.`dias_encargosfc`,'|',ROUND(`e`.`valor_multa_encargosfc`+`e`.`valor_juros_encargosfc`,2)) AS encargos_encargosfcv,
ROUND(SUM(`e`.`valor_multa_encargosfc`)+SUM(`e`.`valor_juros_encargosfc`),2) AS valor_encargosfcv,
`c`.`grupo_parceria`,
`c`.`id_provedor` AS id_provedor
FROM `fc_encargos` AS e
INNER JOIN `fc_clientes` AS `c` ON `c`.`id_clientesfc`=`e`.`id_cliente_encargosfc`
GROUP BY `mes_encargosfc`,`id_encargosfc`