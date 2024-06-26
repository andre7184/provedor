UPDATE `fc_clientes` AS `c`, (SELECT * FROM `fc_clientes_z`) AS `z`
SET 
`c`.`nome_clientesfc`=`z`.`nome_clientesfc`,
`c`.`data_nascimento_clientesfc`=`z`.`data_nascimento_clientesfc`
WHERE `c`.`cpf_cnpj_clientesfc`=`z`.`cpf_cnpj_clientesfc`
 
UPDATE `mk_secretpp` AS `s`, (SELECT * FROM `fcv_dados`) AS `d`
SET 
`s`.`comment_secretpp`=CONCAT(`s`.`id_secretpp`,'# ',`d`.`nome_dadosfc`,' - ',`d`.`venc_dadosfc`,' - ',`d`.`sit_dadosfc`),
`s`.`profile_at_secretpp`=`s`.`profile_secretpp`
WHERE `s`.`id_cliente_secretpp`=`d`.`id_dadosfc` AND `s`.`id_secretpp='13'