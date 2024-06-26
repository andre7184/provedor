CREATE VIEW `fca_mensalidades` AS SELECT 
`f`.`id_faturafc` AS id_mensalfc, 
'' AS mes_atual_mensalfc,
`f`.`sit_cliente_faturafc` AS sit_mensalfc, 
MD5(CONCAT(`f`.`id_faturafc`,`f`.`valor_faturafc`,`f`.`mes_faturafc`)) AS md5_mensalfc,
`f`.`cliente_faturafc` AS cliente_mensalfc,
`f`.`telefones_faturafc` AS telefones_mensalfc, 
CONCAT(`f`.`end_faturafc`,', ',`f`.`end_num_faturafc`,' - ',`f`.`end_bar_faturafc`) AS end_mensalfc,
count(`f`.`diferenca_faturafc`) AS qtd_mensalfc,
SUM(`f`.`diferenca_faturafc`) AS valor_mensalfc,
SUM(ROUND(IFNULL(`e`.`valor_multa_encargosfc`,0)+IFNULL(`e`.`valor_juros_encargosfc`,0),2)) AS total_encargos_mensalfc,
GROUP_CONCAT(DATE_FORMAT(`f`.`vencimento_faturafc`,"%m/%Y") ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS mes_mensalfc, 
GROUP_CONCAT(DATE_FORMAT(SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1),"%d/%m/%Y") ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS data_mensalfc, 
MAX(DATEDIFF(CURDATE(),SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1))) AS `tempo_mensalfc`,
GROUP_CONCAT(DATEDIFF(CURDATE(),SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1)) ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS dias_mensalfc, 
GROUP_CONCAT(DIAS_UTEIS(SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1),CURDATE(),`f`.`cidade_faturafc`,`f`.`uf_faturafc`) ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS dias_uteis_mensalfc, 
GROUP_CONCAT(`f`.`diferenca_faturafc` ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS valores_mensalfc,
GROUP_CONCAT(ROUND(IFNULL(`e`.`valor_multa_encargosfc`,0)+IFNULL(`e`.`valor_juros_encargosfc`,0),2) ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS encargos_mensalfc, 
`f`.`grupo_parceria`,
`f`.`id_provedor` AS id_provedor 
FROM `fcv_faturas` AS `f`
LEFT JOIN `fcv_pagamentos` AS `pg` ON `pg`.`id_pagamentosfc`=`f`.`id_faturafc` AND `pg`.`mes_pagamentosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fcv_creditos` AS `cr` ON `cr`.`id_creditosfc`=`f`.`id_faturafc` AND `cr`.`mes_creditosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fc_encargos` AS `e` ON `e`.`id_cliente_encargosfc`=`f`.`id_faturafc` AND `e`.`data_inicio_encargosfc`=SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1)
WHERE DATE_FORMAT(`f`.`vencimento_faturafc`,"%m/%Y") < DATE_FORMAT(curdate(),"%m/%Y") AND (`f`.`pago_faturafc`!='on' OR `f`.`tipo_pg_faturafc`='MENOR')
GROUP BY `f`.`id_faturafc`
UNION ALL
SELECT 
`f`.`id_faturafc` AS id_mensalfc, 
'on' AS mes_atual_mensalfc,
`f`.`sit_cliente_faturafc` AS sit_mensalfc, 
MD5(CONCAT(`f`.`id_faturafc`,`f`.`valor_faturafc`,`f`.`mes_faturafc`)) AS md5_mensalfc,
`f`.`cliente_faturafc` AS cliente_mensalfc,
`f`.`telefones_faturafc` AS telefones_mensalfc, 
CONCAT(`f`.`end_faturafc`,', ',`f`.`end_num_faturafc`,' - ',`f`.`end_bar_faturafc`) AS end_mensalfc,
count(`f`.`diferenca_faturafc`) AS qtd_mensalfc,
SUM(`f`.`diferenca_faturafc`) AS valor_mensalfc,
SUM(ROUND(IFNULL(`e`.`valor_multa_encargosfc`,0)+IFNULL(`e`.`valor_juros_encargosfc`,0),2)) AS total_encargos_mensalfc,
GROUP_CONCAT(DATE_FORMAT(`f`.`vencimento_faturafc`,"%m/%Y") ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS mes_mensalfc, 
GROUP_CONCAT(DATE_FORMAT(SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1),"%d/%m/%Y") ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS data_mensalfc, 
MAX(DATEDIFF(CURDATE(),SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1))) AS `tempo_mensalfc`,
GROUP_CONCAT(DATEDIFF(CURDATE(),SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1)) ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS dias_mensalfc, 
GROUP_CONCAT(DIAS_UTEIS(SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1),CURDATE(),`f`.`cidade_faturafc`,`f`.`uf_faturafc`) ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS dias_uteis_mensalfc, 
GROUP_CONCAT(`f`.`diferenca_faturafc` ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS valores_mensalfc,
GROUP_CONCAT(ROUND(IFNULL(`e`.`valor_multa_encargosfc`,0)+IFNULL(`e`.`valor_juros_encargosfc`,0),2) ORDER BY `f`.`vencimento_faturafc` DESC  separator ';') AS encargos_mensalfc, 
`f`.`grupo_parceria`,
`f`.`id_provedor` AS id_provedor 
FROM `fcv_faturas` AS `f`
LEFT JOIN `fcv_pagamentos` AS `pg` ON `pg`.`id_pagamentosfc`=`f`.`id_faturafc` AND `pg`.`mes_pagamentosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fcv_creditos` AS `cr` ON `cr`.`id_creditosfc`=`f`.`id_faturafc` AND `cr`.`mes_creditosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fc_encargos` AS `e` ON `e`.`id_cliente_encargosfc`=`f`.`id_faturafc` AND `e`.`data_inicio_encargosfc`=SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1)
WHERE DATE_FORMAT(`f`.`vencimento_faturafc`,"%m/%Y") = DATE_FORMAT(curdate(),"%m/%Y") AND (`f`.`pago_faturafc`!='on' OR `f`.`tipo_pg_faturafc`='MENOR')
GROUP BY `f`.`id_faturafc`