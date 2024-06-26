CREATE VIEW `fcv_dados` AS SELECT 
`c`.`id_clientesfc` AS id_dadosfc, 
`p`.`porcentagem_cobrar_bloqueio_provedorfc` AS porcentagem_cobrar_bloqueio_dadosfc,
`c`.`nome_clientesfc` AS nome_dadosfc, 
`c`.`cpf_cnpj_clientesfc` AS cpf_cnpj_dadosfc, 
`c`.`end1_clientesfc` AS end_dadosfc, 
`c`.`num1_clientesfc` AS num_dadosfc,
`c`.`bar1_clientesfc` AS bairro_dadosfc,
`c`.`cep1_clientesfc` AS cep_dadosfc, 
`c`.`cid1_clientesfc` AS cidade_dadosfc, 
`c`.`uf1_clientesfc` AS uf_dadosfc, 
`c`.`comp1_clientesfc` AS complementos_dadosfc,
`c`.`lat1_clientesfc` AS lat_dadosfc, 
`c`.`long1_clientesfc` AS lon_dadosfc, 
`c`.`tel1_clientesfc` AS tel1_dadosfc, 
`c`.`tel2_clientesfc` AS tel2_dadosfc, 
`c`.`email_clientesfc` AS email_dadosfc, 
`c`.`venc_clientesfc` AS venc_dadosfc, 
'' AS venc_ant_dadosfc,
`c`.`sit_clientesfc` AS sit_dadosfc,
`c`.`grupo_parceria` AS grupo_dadosfc,
sum(IF(`s`.`ponto_sevmensalfc`='on','1','0')) AS pontos_dadosfc,
ROUND(sum(`s`.`valor_sevmensalfc`)) - sum(`s`.`valor_desconto_mensalfc`) + sum(`s`.`valor_acrescimo_mensalfc`),2) AS valor_dadosfc,
GROUP_CONCAT(`s`.`id_mensalfc`) AS id_serv_dadosfc,
GROUP_CONCAT(`u`.`mk_secretpp`) AS mk_dadosfc,
GROUP_CONCAT(`u`.`name_secretpp`) AS secretpp_dadosfc,
GROUP_CONCAT(`u`.`profile_secretpp`) AS profile_dadosfc,
GROUP_CONCAT(`s`.`data_ativado_mensalfc`) AS data_serv_dadosfc,
GROUP_CONCAT(`s`.`valor_desconto_mensalfc`) AS valor_desconto_serv_dadosfc,
GROUP_CONCAT(`s`.`valor_acrescimo_mensalfc`) AS valor_acrescimo_serv_dadosfc,
GROUP_CONCAT(`s`.`id_produto_mensalfc`) AS id_prod_dadosfc,
GROUP_CONCAT(`s`.`descricao_mensalfc`) AS nome_prod_dadosfc,
'' AS valor_prod_dadosfc,
`c`.`id_provedor` AS id_provedor
FROM `fc_clientes` AS `c` 
inner join `fc_provedor` AS `p` on `p`.`id_provedorfc`=`c`.`id_provedor`
left join `fc_sevmensal` AS `s` on `s`.`id_cliente_mensalfc`=`c`.`id_clientesfc` and `s`.`sit_mensalfc`='ativo'
left join `mk_secretpp` AS `u` on `u`.`id_secretpp`=`s`.`id_user_sevmensalfc` and  `u`.`id_cliente_secretpp`!=0
GROUP BY `c`.`id_clientesfc`