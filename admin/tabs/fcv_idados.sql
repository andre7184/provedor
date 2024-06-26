CREATE VIEW `fcv_idados` AS SELECT 
`c`.`id_clientesfc` AS id_idadosfc,
`c`.`nome_clientesfc` AS nome_idadosfc,
`c`.`cpf_cnpj_clientesfc` AS cpf_cnpj_idadosfc,
`c`.`end1_clientesfc` AS end_idadosfc, 
`c`.`num1_clientesfc` AS num_idadosfc,
`c`.`bar1_clientesfc` AS bairro_idadosfc,
`c`.`cep1_clientesfc` AS cep_idadosfc, 
`c`.`cid1_clientesfc` AS cidade_idadosfc, 
`c`.`uf1_clientesfc` AS uf_idadosfc, 
`c`.`comp1_clientesfc` AS complementos_idadosfc,
`c`.`lat1_clientesfc` AS lat_idadosfc, 
`c`.`long1_clientesfc` AS lon_idadosfc, 
`c`.`tel1_clientesfc` AS tel1_idadosfc, 
`c`.`tel2_clientesfc` AS tel2_idadosfc, 
`c`.`email_clientesfc` AS email_idadosfc, 
`c`.`venc_clientesfc` AS venc_idadosfc,
`c`.`sit_clientesfc` AS sit_idadosfc,
`c`.`grupo_parceria` AS grupo_idadosfc,
sum(IF(`s`.`ponto_sevmensalfc`='on','1','0')) AS qtd_pontos_idadosfc,
count(`s`.`id_mensalfc`) AS qtd_servicos_idadosfc,
ROUND(sum(`s`.`valor_sevmensalfc`) - sum(`s`.`valor_desconto_mensalfc`) + sum(`s`.`valor_acrescimo_mensalfc`),2) AS valor_idadosfc,
GROUP_CONCAT(`s`.`id_mensalfc`) AS id_serv_idadosfc,
GROUP_CONCAT(`u`.`mk_secretpp`) AS mk_idadosfc,
GROUP_CONCAT(`u`.`name_secretpp`) AS secretpp_idadosfc,
GROUP_CONCAT(`u`.`profile_secretpp`) AS profile_idadosfc,
GROUP_CONCAT(`s`.`data_ativado_mensalfc`) AS data_serv_idadosfc,
GROUP_CONCAT(`s`.`valor_desconto_mensalfc`) AS valor_desconto_serv_idadosfc,
GROUP_CONCAT(`s`.`valor_acrescimo_mensalfc`) AS valor_acrescimo_serv_idadosfc,
GROUP_CONCAT(`s`.`id_produto_mensalfc`) AS id_prod_idadosfc,
GROUP_CONCAT(`s`.`descricao_mensalfc`) AS nome_prod_idadosfc,
'0' AS valor_prod_idadosfc,
`f`.`id_faturafc` AS id_fat_idadosfc,
IF(`f`.`id_faturafc` IS NULL,IF((SELECT COUNT(*) FROM `fc_sevmensal` AS `sm` WHERE `sm`.`id_cliente_mensalfc`=`c`.`id_clientesfc` AND DATE_FORMAT(`sm`.`data_ativado_mensalfc`,"%Y-%m-02")<=DATE_SUB(DATE_FORMAT(CURDATE(),"%Y-%m-02"),INTERVAL 1 MONTH))>0,'ERROR','OK'),'OK') AS status_idadosfc,
IF(`v`.`valor_dividasfc` IS NULL,'0,00',(`v`.`valor_dividasfc`+encargos_dividasfc)) AS dividas_idadosfc,
IFNULL(`v`.`dias_dividasfc`,'0') AS dias_dividas_idadosfc,
IF(`v`.`valor_dividasfc` IS NOT NULL OR `v`.`valor_dividasfc`>0,'on',IF(diferenca_faturafc)) AS vencido_idadosfc,
`c`.`id_provedor` AS id_provedor
FROM `fc_clientes` AS `c` 
inner JOIN `fc_provedor` AS `p` on `p`.`id_provedorfc`=`c`.`id_provedor`
LEFT JOIN `fc_sevmensal` AS `s` on `s`.`id_cliente_mensalfc`=`c`.`id_clientesfc` and `s`.`sit_mensalfc`='ativo'
LEFT JOIN `mk_secretpp` AS `u` on `u`.`id_secretpp`=`s`.`id_user_sevmensalfc` and  `u`.`id_cliente_secretpp`=`c`.`id_clientesfc`
LEFT JOIN `fcv_faturas` AS `f` ON `f`.`id_faturafc`=`c`.`id_clientesfc` AND `f`.`mes_faturafc`=DATE_FORMAT(DATE_SUB(CURDATE(),INTERVAL 1 MONTH),"%Y-%m") 
LEFT JOIN `fcv_dividas` AS `v` ON `v`.`id_dividasfc`=`c`.`id_clientesfc` AND `v`.`mes_dividasfc`<DATE_FORMAT(CURDATE(),"%Y-%m")
GROUP BY `c`.`id_clientesfc`

