CREATE VIEW `fcv_dividas` AS SELECT 
`f`.`id_faturafc` AS id_dividasfc, 
`f`.`cliente_faturafc` AS cliente_dividasfc, 
DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") AS mes_dividasfc, 
SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1) AS data_dividasfc, 
DATEDIFF(CURDATE(),SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1)) AS dias_dividasfc, 
DIAS_UTEIS(SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1),CURDATE(),`f`.`cidade_faturafc`,`f`.`uf_faturafc`) AS dias_uteis_dividasfc, 
`f`.`diferenca_faturafc` AS valor_dividasfc,
ROUND(IFNULL(`e`.`valor_multa_encargosfc`,0)+IFNULL(`e`.`valor_juros_encargosfc`,0),2) AS encargos_dividasfc, 
`f`.`grupo_parceria`,
SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1) AS date_dividasfc, 
`f`.`id_provedor` AS id_provedor 
FROM `fcv_faturas` AS `f` 
INNER JOIN `fc_provedor` AS `p` ON `p`.`id_provedorfc`=`f`.`id_provedor` 
LEFT JOIN `fcv_pagamentos` AS `pg` ON `pg`.`id_pagamentosfc`=`f`.`id_faturafc` AND `pg`.`mes_pagamentosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fcv_creditos` AS `cr` ON `cr`.`id_creditosfc`=`f`.`id_faturafc` AND `cr`.`mes_creditosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fc_encargos` AS `e` ON `e`.`id_cliente_encargosfc`=`f`.`id_faturafc` AND `e`.`data_inicio_encargosfc`=SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1)
WHERE `f`.`vencimento_faturafc` < DATE_SUB(CURDATE(),INTERVAL 1 DAY) AND (`f`.`pago_faturafc`!='on' OR `f`.`tipo_pg_faturafc`='MENOR')    