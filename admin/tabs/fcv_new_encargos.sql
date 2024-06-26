CREATE VIEW `fcv_encargosnew` AS SELECT 
'S' AS acao_encargosnewfc,
`e`.`id_encargosfc` AS id_itens_encargosnewfc,
`f`.`id_faturafc` AS id_cliente_encargosnewfc,
DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") AS mes_encargosnewfc, 
SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1) AS data_encargosnewfc, 
(`f`.`valor_faturafc`-(IFNULL(`pg`.`valor_pagamentosfc`,0)+IFNULL(`cr`.`total_creditosfc`,0))) AS valor_encargosnewfc, 
IFNULL(`e`.`dias_encargosfc`,0)+DATEDIFF(CURDATE(),IFNULL(`e`.`data_atz_encargosfc`,SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1))) AS dias_encargosnewfc, 
IF(`p`.`porcentagem_multa_provedorfc`='0',0,round((`p`.`porcentagem_multa_provedorfc`/100)*(`f`.`valor_faturafc`-(IFNULL(`pg`.`valor_pagamentosfc`,0)+IFNULL(`cr`.`total_creditosfc`,0))),2)) AS valor_multa_encargosnewfc, 
IF(`p`.`porcentagem_juros_provedorfc`='0',0,round((DATEDIFF(CURDATE(),IFNULL(`e`.`data_atz_encargosfc`,SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1)))*(`p`.`porcentagem_juros_provedorfc`/100) * + (`f`.`valor_faturafc`-(IFNULL(`pg`.`valor_pagamentosfc`,0)+IFNULL(`cr`.`total_creditosfc`,0)))),2)) AS valor_juros_encargosnewfc, 
`f`.`id_provedor` AS id_provedor 
FROM `fcv_faturas` AS `f` 
INNER JOIN `fc_clientes` AS `c` ON `c`.`id_clientesfc`=`f`.`id_faturafc` 
INNER JOIN `fc_provedor` AS `p` ON `p`.`id_provedorfc`=`f`.`id_provedor` 
LEFT JOIN `fcv_pagamentos` AS `pg` ON `pg`.`id_pagamentosfc`=`f`.`id_faturafc` AND `pg`.`mes_pagamentosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fcv_creditos` AS `cr` ON `cr`.`id_creditosfc`=`f`.`id_faturafc` AND `cr`.`mes_creditosfc`=DATE_FORMAT(`f`.`vencimento_faturafc`,"%Y-%m") 
LEFT JOIN `fc_encargos` AS `e` ON `e`.`id_cliente_encargosfc`=`f`.`id_faturafc` AND `e`.`data_inicio_encargosfc`=SPLIT_STRING(IFNULL(`pg`.`datas_pagamentosfc`,IFNULL(`cr`.`datas_creditosfc`,`f`.`vencimento_faturafc`)),',',1) 
WHERE ADD_DIAS_UTEIS(`f`.`vencimento_faturafc`,`p`.`dias_multa_juros_provedorfc`,`c`.`cid1_clientesfc`,`c`.`uf1_clientesfc`) < CURDATE() AND (`e`.`data_atz_encargosfc` IS NULL OR `e`.`data_atz_encargosfc` < CURDATE()) AND (`f`.`pago_faturafc`!='on' OR `f`.`tipo_pg_faturafc`='MENOR')
UNION ALL SELECT 
'F' AS acao_encargosnewfc, 
`e`.`id_encargosfc` AS id_itens_encargosnewfc,
`e`.`id_cliente_encargosfc` AS id_cliente_encargosnewfc,
NULL AS mes_encargosnewfc, 
(select  `data_pagamento_caixafc`  from `fc_caixa` where `tipo_caixafc`='in' and `id_cliente_caixafc`=`e`.`id_cliente_encargosfc` and DATE_FORMAT(`data_caixafc`,"%Y-%m")=`e`.`mes_encargosfc` and `data_pagamento_caixafc` > `e`.`data_inicio_encargosfc` ORDER BY `data_pagamento_caixafc` ASC LIMIT 1) AS data_encargosnewfc, 
NULL AS valor_encargosnewfc, 
NULL AS dias_encargosnewfc, 
NULL AS valor_multa_encargosnewfc, 
NULL AS valor_juros_encargosnewfc, 
`e`.`id_provedor` AS id_provedor 
FROM `fc_encargos` AS `e` 
WHERE `e`.`data_fim_encargosfc`='0000-00-00' AND (select COUNT(*) from `fc_caixa` where `tipo_caixafc`='in' and `id_cliente_caixafc`=`e`.`id_cliente_encargosfc` and DATE_FORMAT(`data_caixafc`,"%Y-%m")=`e`.`mes_encargosfc` and `data_pagamento_caixafc` > `e`.`data_inicio_encargosfc`)>0 
UNION ALL SELECT 
'D' AS acao, 
`e`.`id_encargosfc` AS id_itens_encargosnewfc,
`e`.`id_cliente_encargosfc` AS id_cliente_encargosnewfc,
NULL AS mes_encargosnewfc,
NULL AS data_encargosnewfc,
NULL AS valor_encargosnewfc, 
NULL AS dias_encargosnewfc, 
NULL AS valor_multa_encargosnewfc, 
NULL AS valor_juros_encargosnewfc, 
`e`.`id_provedor` AS id_provedor  
FROM `fc_encargos` AS `e` 
WHERE `e`.`data_fim_encargosfc`!='0000-00-00' AND (select COUNT(*) from `fc_caixa` where `tipo_caixafc`='in' and `id_cliente_caixafc`=`e`.`id_cliente_encargosfc` and DATE_FORMAT(`data_caixafc`,"%Y-%m")=`e`.`mes_encargosfc` and `data_pagamento_caixafc`= `e`.`data_fim_encargosfc`)=0
