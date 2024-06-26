CREATE VIEW `fcv_contas` AS SELECT 
`u`.`id_secretpp` AS id_contasfc, 
`u`.`name_secretpp` AS user_contasfc, 
`u`.`profile_secretpp` AS profile_contasfc, 
`u`.`mk_secretpp` AS mk_contasfc, 
`c`.`nome_clientesfc` AS cliente_contasfc, 
CONCAT(`c`.`cpf_cnpj_clientesfc`,' ',`c`.`tel1_clientesfc`,' / ',`c`.`tel2_clientesfc`,' End:',IF(`c`.`cob1_clientesfc`='on',`c`.`end1_clientesfc`,`c`.`end2_clientesfc`),', ',IF(`c`.`cob1_clientesfc`='on',`c`.`num1_clientesfc`,`c`.`num2_clientesfc`),'(',IF(`c`.`cob1_clientesfc`='on',`c`.`comp1_clientesfc`,`c`.`comp2_clientesfc`),') - ',IF(`c`.`cob1_clientesfc`='on',`c`.`bar1_clientesfc`,`c`.`bar2_clientesfc`),' - ',IF(`c`.`cob1_clientesfc`='on',`c`.`cep1_clientesfc`,`c`.`cep2_clientesfc`),' - ',IF(`c`.`cob1_clientesfc`='on',`c`.`cid1_clientesfc`,`c`.`cid2_clientesfc`),'-',IF(`c`.`cob1_clientesfc`='on',`c`.`uf1_clientesfc`,`c`.`uf2_clientesfc`)) AS uf_dadosfc, 
`c`.`tel1_clientesfc` AS tel1_dadosfc, 
`c`.`tel2_clientesfc` AS tel2_dadosfc, 
`c`.`email_clientesfc` AS email_dadosfc, 
`c`.`venc_clientesfc` AS venc_dadosfc, 
`c`.`sit_clientesfc` AS sit_dadosfc,
`u`.`codigo_provedor` AS id_provedor
FROM `mk_secretpp` AS `u`
left join `fc_clientes` AS `c` on `c`.`id_clientesfc`=`u`.`id_cliente_secretpp`  