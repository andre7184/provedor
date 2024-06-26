CREATE VIEW `fcv_faturastemp` AS SELECT 
null AS id_faturatemp,
NOW() AS datatime_faturatemp,
'MENSALIDADE' AS nome_faturatemp,
'+' AS tipo_faturatemp,
IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`) AS inicio_periodo_faturatemp,
DATE_FORMAT(curdate(),"%Y-%m-01") AS fim_periodo_faturatemp,
CONCAT(`s`.`descricao_mensalfc`,' MES #',DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%m/%Y")) AS descricao_faturatemp,
ADD_DATA_UTIL(CONCAT(DATE_FORMAT(curdate(),"%Y-%m-"),`c`.`venc_clientesfc`),`c`.`cid1_clientesfc`,`c`.`uf1_clientesfc`) AS data_faturatemp,
'0000-00-00' AS data_origem_faturatemp,
'0' AS id_pagamento_faturatemp,
'' AS dif_faturatemp,
`s`.`valor_sevmensalfc` AS valor_servico_faturatemp,
IF(DATE_FORMAT(IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),"%d") != '02',IF(`s`.`valor_desconto_mensalfc`>0,(ROUND(`s`.`valor_desconto_mensalfc`/30, 2) * TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))),0),`s`.`valor_desconto_mensalfc`) AS desconto_faturatemp,
IF(DATE_FORMAT(IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),"%d") != '02',IF(`s`.`valor_acrescimo_mensalfc`>0,(ROUND(`s`.`valor_acrescimo_mensalfc`/30, 2) * TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))),0),`s`.`valor_acrescimo_mensalfc`) AS acrescimo_faturatemp,
IF(DATE_FORMAT(IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),"%d") != '02',(ROUND((`s`.`valor_sevmensalfc` / 30), 2) * (TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))))-IF(`s`.`valor_desconto_mensalfc`>0,(ROUND(`s`.`valor_desconto_mensalfc`/30, 2) * TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))),0)+IF(`s`.`valor_acrescimo_mensalfc`>0,(ROUND(`s`.`valor_acrescimo_mensalfc`/30, 2) * TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))),0),(`s`.`valor_sevmensalfc`-`s`.`valor_desconto_mensalfc`+`s`.`valor_acrescimo_mensalfc`)) AS valor_faturatemp,
'1' AS qtd_faturatemp,
IF(DATE_FORMAT(IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),"%d") != '02',(ROUND((`s`.`valor_sevmensalfc` / 30), 2) * (TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))))-IF(`s`.`valor_desconto_mensalfc`>0,(ROUND(`s`.`valor_desconto_mensalfc`/30, 2) * TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))),0)+IF(`s`.`valor_acrescimo_mensalfc`>0,(ROUND(`s`.`valor_acrescimo_mensalfc`/30, 2) * TIMESTAMPDIFF(DAY,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`),DATE_FORMAT(curdate(),"%Y-%m-01"))),0),(`s`.`valor_sevmensalfc`-`s`.`valor_desconto_mensalfc`+`s`.`valor_acrescimo_mensalfc`)) AS valor_total_faturatemp,
'' AS cancelado_faturatemp,
`c`.`id_clientesfc` AS id_cliente_faturatemp,
'0' AS id_vendas_faturatemp,
'sistema' AS user_registro_faturatemp,
`c`.`grupo_parceria` AS grupo_faturatemp,
`c`.`id_provedor` AS id_provedor
FROM `fc_clientes` AS `c` 
left join `fc_sevmensal` AS `s` on `s`.`id_cliente_mensalfc`=`c`.`id_clientesfc` and `s`.`sit_mensalfc`='ativo'
WHERE `c`.`id_clientesfc` NOT IN (SELECT `id_cliente_itensfc` FROM `fc_itens` WHERE `nome_itensfc`='MENSALIDADE' AND DATE_FORMAT(`fim_periodo_itensfc`,"%Y-%m")=DATE_FORMAT(curdate(),"%Y-%m")) AND
IF(`s`.`data_ativado_mensalfc` IS NULL,false,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") < DATE_FORMAT(curdate(),"%Y-%m-01"),true,false),IF(`s`.`data_ativado_mensalfc` < DATE_FORMAT(curdate(),"%Y-%m-01"),true,false)))=true 
UNION ALL SELECT 
null AS id_faturatemp,
NOW() AS datatime_faturatemp,
'DESCONTO BLOQUEIO' AS nome_faturatemp,
'-' AS tipo_faturatemp,
'0000-00-00' AS inicio_periodo_faturatemp,
'0000-00-00' AS fim_periodo_faturatemp,
CONCAT('DESCONTO DE ',`p`.`porcentagem_cobrar_bloqueio_provedorfc`,'% DOS ',IFNULL((SELECT SUM(TIMESTAMPDIFF(DAY,`data_bloqueiosfc`,IF(`data_fim_bloqueiosfc` = '0000-00-00' OR `data_fim_bloqueiosfc` > DATE_FORMAT(curdate(),"%Y-%m-01"), DATE_FORMAT(curdate(),"%Y-%m-01"),`data_fim_bloqueiosfc`))) AS `dias_bloqueios` FROM `fc_bloqueios` WHERE `id_cliente_bloqueiosfc`=`c`.`id_clientesfc` AND `data_bloqueiosfc` > IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`) AND `data_bloqueiosfc` < DATE_FORMAT(curdate(),"%Y-%m-01") AND `data_bloqueiosfc` != `data_fim_bloqueiosfc`),0),' DIA(S) DE BLOQUEIO') AS descricao_faturatemp,
ADD_DATA_UTIL(CONCAT(DATE_FORMAT(curdate(),"%Y-%m-"),`c`.`venc_clientesfc`),`c`.`cid1_clientesfc`,`c`.`uf1_clientesfc`) AS data_faturatemp,
'0000-00-00' AS data_origem_faturatemp,
'0' AS id_pagamento_faturatemp,
'' AS dif_faturatemp,
(`s`.`valor_sevmensalfc`-`s`.`valor_desconto_mensalfc`+`s`.`valor_acrescimo_mensalfc`) AS valor_servico_faturatemp,
'0' AS desconto_faturatemp,
'0' AS acrescimo_faturatemp,
ROUND((SELECT SUM(TIMESTAMPDIFF(DAY,`data_bloqueiosfc`,IF(`data_fim_bloqueiosfc` = '0000-00-00' OR `data_fim_bloqueiosfc` > DATE_FORMAT(curdate(),"%Y-%m-01"), DATE_FORMAT(curdate(),"%Y-%m-01"),`data_fim_bloqueiosfc`))) AS `dias_bloqueios` FROM `fc_bloqueios` WHERE `id_cliente_bloqueiosfc`=`c`.`id_clientesfc` AND `data_bloqueiosfc` > IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`) AND `data_bloqueiosfc` < DATE_FORMAT(curdate(),"%Y-%m-01") AND `data_bloqueiosfc` != `data_fim_bloqueiosfc`)*(ROUND((`s`.`valor_sevmensalfc` / 30), 2)*(`p`.`porcentagem_cobrar_bloqueio_provedorfc`/100)), 2) AS valor_faturatemp,
'1' AS qtd_faturatemp,
ROUND((SELECT SUM(TIMESTAMPDIFF(DAY,`data_bloqueiosfc`,IF(`data_fim_bloqueiosfc` = '0000-00-00' OR `data_fim_bloqueiosfc` > DATE_FORMAT(curdate(),"%Y-%m-01"), DATE_FORMAT(curdate(),"%Y-%m-01"),`data_fim_bloqueiosfc`))) AS `dias_bloqueios` FROM `fc_bloqueios` WHERE `id_cliente_bloqueiosfc`=`c`.`id_clientesfc` AND `data_bloqueiosfc` > IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`) AND `data_bloqueiosfc` < DATE_FORMAT(curdate(),"%Y-%m-01") AND `data_bloqueiosfc` != `data_fim_bloqueiosfc`)*(ROUND((`s`.`valor_sevmensalfc` / 30), 2)*(`p`.`porcentagem_cobrar_bloqueio_provedorfc`/100)), 2) AS valor_total_faturatemp,
'' AS cancelado_faturatemp,
`c`.`id_clientesfc` AS id_cliente_faturatemp,
'0' AS id_vendas_faturatemp,
'sistema' AS user_registro_faturatemp,
`c`.`grupo_parceria` AS grupo_faturatemp,
`c`.`id_provedor` AS id_provedor
FROM `fc_clientes` AS `c` 
inner join `fc_provedor` AS `p` on `p`.`id_provedorfc`=`c`.`id_provedor`
left join `fc_sevmensal` AS `s` on `s`.`id_cliente_mensalfc`=`c`.`id_clientesfc` and `s`.`sit_mensalfc`='ativo'
WHERE `c`.`id_clientesfc` NOT IN (SELECT `id_cliente_itensfc` FROM `fc_itens` WHERE `nome_itensfc`='DESCONTO BLOQUEIO' AND DATE_FORMAT(`fim_periodo_itensfc`,"%Y-%m")=DATE_FORMAT(curdate(),"%Y-%m")) AND
IF(`s`.`data_ativado_mensalfc` IS NULL,false,IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") < DATE_FORMAT(curdate(),"%Y-%m-01"),true,false),IF(`s`.`data_ativado_mensalfc` < DATE_FORMAT(curdate(),"%Y-%m-01"),true,false)))=true AND
IF(`p`.`porcentagem_cobrar_bloqueio_provedorfc`>0 AND IFNULL((SELECT SUM(TIMESTAMPDIFF(DAY,`data_bloqueiosfc`,IF(`data_fim_bloqueiosfc` = '0000-00-00' OR `data_fim_bloqueiosfc` > DATE_FORMAT(curdate(),"%Y-%m-01"), DATE_FORMAT(curdate(),"%Y-%m-01"),`data_fim_bloqueiosfc`))) AS `dias_bloqueios` FROM `fc_bloqueios` WHERE `id_cliente_bloqueiosfc`=`c`.`id_clientesfc` AND `data_bloqueiosfc` > IF(DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02") > DATE_FORMAT(`s`.`data_ativado_mensalfc`,"%Y-%m-%d"),DATE_FORMAT(DATE_SUB(curdate(),INTERVAL 1 MONTH),"%Y-%m-02"),`s`.`data_ativado_mensalfc`) AND `data_bloqueiosfc` < DATE_FORMAT(curdate(),"%Y-%m-01") AND `data_bloqueiosfc` != `data_fim_bloqueiosfc`),0)>0,true,false)=true
